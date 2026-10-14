<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Chamber;
use App\Models\ChamberSchedule;
use App\Models\Prescription;
use App\Services\AppointmentBookingService;
use App\Services\ConsultationAccessService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PatientDashboardController extends Controller
{
    public function index(ConsultationAccessService $accessService)
    {
        $userId = auth()->id();
        $appointments = Appointment::with(['chamber', 'payments' => fn ($query) => $query->latest()])
            ->where('patient_id', $userId)
            ->latest('scheduled_at')
            ->paginate(10);
        foreach ($appointments as $appointment) {
            $appointment->meeting_access = $accessService->forPatient($appointment);
        }
        $prescriptions = Prescription::with(['author', 'appointment'])
            ->where('patient_id', $userId)
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(10)
            ->get();

        return view('patient.dashboard', compact('appointments', 'prescriptions'));
    }

    public function createAppointment()
    {
        $chambers = Chamber::where('is_active', true)->orderBy('display_order')->orderBy('name')->get();
        return view('patient.appointments.create', compact('chambers'));
    }

    /** Return the actual free appointment slots from chamber schedules. */
    public function availability(Request $request)
    {
        $data = $request->validate([
            'chamber_id' => ['required', 'integer', 'exists:chambers,id'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $chamber = Chamber::query()->where('is_active', true)->findOrFail($data['chamber_id']);
        $date = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfDay();
        $schedules = ChamberSchedule::query()
            ->where('chamber_id', $chamber->id)
            ->where('weekday', $date->dayOfWeek)
            ->where('is_active', true)
            ->orderBy('starts_at')
            ->get();

        $activeStatuses = ['pending', 'confirmed', 'waiting', 'in_progress'];
        $booked = Appointment::query()
            ->where('chamber_id', $chamber->id)
            ->whereDate('scheduled_at', $date->toDateString())
            ->whereIn('status', $activeStatuses)
            ->orderBy('scheduled_at')
            ->get(['scheduled_at', 'duration_minutes']);
        // A personal practice has one doctor, so a manual booking in another chamber
        // must also make the overlapping time unavailable in the public booking form.
        $allDayAppointments = Appointment::query()
            ->whereDate('scheduled_at', $date->toDateString())
            ->whereIn('status', $activeStatuses)
            ->orderBy('scheduled_at')
            ->get(['scheduled_at', 'duration_minutes']);

        $slots = [];
        foreach ($schedules as $schedule) {
            $slotMinutes = max(1, (int) $schedule->slot_minutes);
            $shiftAppointments = $booked->filter(function ($appointment) use ($schedule) {
                $time = Carbon::parse($appointment->scheduled_at)->format('H:i:s');
                return $time >= (string) $schedule->starts_at && $time < (string) $schedule->ends_at;
            })->count();
            if ($shiftAppointments >= (int) $schedule->max_patients) {
                continue;
            }

            $slot = Carbon::parse($date->toDateString() . ' ' . $schedule->starts_at);
            $shiftEnd = Carbon::parse($date->toDateString() . ' ' . $schedule->ends_at);
            while ($slot->copy()->addMinutes($slotMinutes)->lessThanOrEqualTo($shiftEnd)) {
                $slotEnd = $slot->copy()->addMinutes($slotMinutes);
                if ($slot->greaterThan(now()->addMinutes(30))) {
                    $overlap = $allDayAppointments->contains(function ($appointment) use ($slot, $slotEnd) {
                        $existingStart = Carbon::parse($appointment->scheduled_at);
                        $existingEnd = $existingStart->copy()->addMinutes(max(1, (int) $appointment->duration_minutes));
                        return $existingStart->lt($slotEnd) && $existingEnd->gt($slot);
                    });
                    if (!$overlap) {
                        $slots[] = [
                            'value' => $slot->format('Y-m-d\TH:i'),
                            'label' => $slot->format('h:i A'),
                        ];
                    }
                }
                $slot->addMinutes($slotMinutes);
            }
        }

        return response()->json([
            'slots' => $slots,
            'consultation_type' => $chamber->consultation_type,
            'fee' => (float) $chamber->consultation_fee,
        ]);
    }

    public function storeAppointment(Request $request, AppointmentBookingService $bookingService)
    {
        $data = $request->validate([
            'chamber_id' => ['required', 'integer', 'exists:chambers,id'],
            'consultation_type' => ['required', 'in:offline,online'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $appointment = $bookingService->book($request->user(), $data);

        return redirect()->route('patient.dashboard')->with(
            'success',
            'Appointment request submitted. Reference: ' . $appointment->appointment_code
        );
    }
}
