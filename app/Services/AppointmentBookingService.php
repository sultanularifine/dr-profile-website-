<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use App\Models\Chamber;
use App\Models\ChamberSchedule;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Business rules for booking an appointment. Keeping these rules outside the
 * controller makes the booking flow easier to maintain and test.
 */
class AppointmentBookingService
{
    public function book(User $patient, array $data): Appointment
    {
        $chamber = Chamber::query()
            ->where('is_active', true)
            ->findOrFail($data['chamber_id']);

        if (!in_array($chamber->consultation_type, ['both', $data['consultation_type']], true)) {
            throw ValidationException::withMessages([
                'consultation_type' => 'This chamber does not support that consultation type.',
            ]);
        }

        $startsAt = Carbon::parse($data['scheduled_at']);
        $weekday = (int) $startsAt->dayOfWeek;
        $time = $startsAt->format('H:i:s');

        $schedule = $chamber->schedules()
            ->where('weekday', $weekday)
            ->where('is_active', true)
            ->where('starts_at', '<=', $time)
            ->where('ends_at', '>', $time)
            ->orderBy('starts_at')
            ->first();

        if (!$schedule) {
            throw ValidationException::withMessages([
                'scheduled_at' => 'The selected time is outside the chamber schedule.',
            ]);
        }

        $openMinutes = ((int) $startsAt->format('H') * 60 + (int) $startsAt->format('i'))
            - ((int) substr((string) $schedule->starts_at, 0, 2) * 60 + (int) substr((string) $schedule->starts_at, 3, 2));
        $slotMinutes = (int) $schedule->slot_minutes;
        if ($slotMinutes < 1) {
            throw ValidationException::withMessages([
                'scheduled_at' => 'This chamber schedule has an invalid slot duration. Ask the administrator to correct it.',
            ]);
        }
        if ($openMinutes < 0 || $openMinutes % $slotMinutes !== 0) {
            throw ValidationException::withMessages([
                'scheduled_at' => 'Choose a time that matches an available appointment slot.',
            ]);
        }

        $endsAt = $startsAt->copy()->addMinutes($slotMinutes);
        if ($endsAt->format('H:i:s') > (string) $schedule->ends_at) {
            throw ValidationException::withMessages([
                'scheduled_at' => 'The selected appointment would extend beyond chamber closing time.',
            ]);
        }

        return DB::transaction(function () use ($patient, $data, $chamber, $startsAt, $schedule) {
            // Serialize requests for a schedule so simultaneous bookings cannot race.
            // Re-check schedule values after locking; an administrator may have edited it
            // after the initial availability lookup above.
            $lockedSchedule = ChamberSchedule::query()->whereKey($schedule->id)->lockForUpdate()->firstOrFail();
            if (!$lockedSchedule->is_active || (int) $lockedSchedule->weekday !== (int) $startsAt->dayOfWeek) {
                throw ValidationException::withMessages(['scheduled_at' => 'This schedule is no longer available.']);
            }

            $startClock = $startsAt->format('H:i:s');
            if ($startClock < (string) $lockedSchedule->starts_at || $startClock >= (string) $lockedSchedule->ends_at) {
                throw ValidationException::withMessages(['scheduled_at' => 'The selected time is outside the current chamber schedule.']);
            }

            $lockedSlotMinutes = (int) $lockedSchedule->slot_minutes;
            $scheduleStart = substr((string) $lockedSchedule->starts_at, 0, 8);
            $openMinutes = ((int) $startsAt->format('H') * 60 + (int) $startsAt->format('i'))
                - ((int) substr($scheduleStart, 0, 2) * 60 + (int) substr($scheduleStart, 3, 2));
            if ($lockedSlotMinutes < 1 || $openMinutes < 0 || $openMinutes % $lockedSlotMinutes !== 0) {
                throw ValidationException::withMessages(['scheduled_at' => 'Choose a time that matches an available appointment slot.']);
            }
            $lockedEndsAt = $startsAt->copy()->addMinutes($lockedSlotMinutes);
            if ($lockedEndsAt->format('H:i:s') > (string) $lockedSchedule->ends_at) {
                throw ValidationException::withMessages(['scheduled_at' => 'The appointment would extend beyond chamber closing time.']);
            }

            $activeStatuses = ['pending', 'confirmed', 'waiting', 'in_progress'];
            $sameDayAppointments = Appointment::query()
                ->whereDate('scheduled_at', $startsAt->toDateString())
                ->whereIn('status', $activeStatuses)
                ->orderBy('scheduled_at')
                ->lockForUpdate()
                ->get(['id', 'scheduled_at', 'duration_minutes']);

            $conflict = $sameDayAppointments->contains(function (Appointment $existing) use ($startsAt, $lockedEndsAt) {
                $existingStarts = Carbon::parse($existing->scheduled_at);
                $existingEnds = $existingStarts->copy()->addMinutes((int) $existing->duration_minutes);
                return $existingStarts->lt($lockedEndsAt) && $existingEnds->gt($startsAt);
            });

            if ($conflict) {
                throw ValidationException::withMessages([
                    'scheduled_at' => 'That time overlaps with an existing appointment. Please choose another time.',
                ]);
            }

            $appointmentsThisShift = Appointment::query()
                ->where('chamber_id', $chamber->id)
                ->whereDate('scheduled_at', $startsAt->toDateString())
                ->whereTime('scheduled_at', '>=', $lockedSchedule->starts_at)
                ->whereTime('scheduled_at', '<', $lockedSchedule->ends_at)
                ->whereIn('status', $activeStatuses)
                ->count();
            if ($appointmentsThisShift >= (int) $lockedSchedule->max_patients) {
                throw ValidationException::withMessages([
                    'scheduled_at' => 'This chamber shift has reached its patient limit.',
                ]);
            }

            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'chamber_id' => $chamber->id,
                'consultation_type' => $data['consultation_type'],
                'scheduled_at' => $startsAt,
                'duration_minutes' => $lockedSlotMinutes,
                'reason' => $data['reason'] ?? null,
                'status' => 'pending',
                'fee' => $chamber->consultation_fee,
                'payment_status' => 'unpaid',
            ]);

            AppointmentStatusHistory::create([
                'appointment_id' => $appointment->id,
                'changed_by' => $patient->id,
                'old_status' => null,
                'new_status' => 'pending',
                'notes' => 'Appointment requested by patient.',
            ]);

            return $appointment;
        });
    }
}
