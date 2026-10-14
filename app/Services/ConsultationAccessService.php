<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Carbon;

/** Controls patient-visible meeting access independently from admin forms. */
class ConsultationAccessService
{
    /** @return array{allowed: bool, message: string} */
    public function forPatient(Appointment $appointment): array
    {
        if ($appointment->consultation_type !== 'online') {
            return ['allowed' => false, 'message' => 'This is an in-person appointment.'];
        }

        if (!$appointment->meeting_url) {
            return ['allowed' => false, 'message' => 'The doctor has not added a consultation link yet.'];
        }

        // Never grant access to a consultation that has been ended or invalidated.
        if (in_array($appointment->status, ['completed', 'cancelled', 'rejected', 'no_show'], true)) {
            return ['allowed' => false, 'message' => 'This consultation is no longer available.'];
        }

        // An explicit doctor/Super Admin override bypasses only the normal meeting,
        // time-window, payment and queue gates. The appointment itself must still
        // be confirmed/active, and the link must exist.
        if ($appointment->meeting_manual_override) {
            if (!in_array($appointment->status, ['confirmed', 'waiting', 'in_progress'], true)) {
                return ['allowed' => false, 'message' => 'Your appointment must be confirmed before the doctor can open the link.'];
            }

            return ['allowed' => true, 'message' => 'Your doctor has manually opened the consultation link.'];
        }

        if (!$appointment->meeting_enabled) {
            return ['allowed' => false, 'message' => 'The doctor has not opened the consultation link yet.'];
        }

        if (!in_array($appointment->status, ['waiting', 'in_progress'], true)) {
            return ['allowed' => false, 'message' => 'Your join link will activate when the doctor calls your serial.'];
        }

        if ((float) $appointment->fee > 0 && !$appointment->fee_waived && $appointment->payment_status !== 'paid') {
            return ['allowed' => false, 'message' => 'Payment must be verified before joining the online consultation.'];
        }

        if (!$appointment->scheduled_at) {
            return ['allowed' => false, 'message' => 'The appointment time is not available. Please contact the clinic.'];
        }

        $start = $appointment->scheduled_at->copy()->subMinutes(15);
        $end = $appointment->scheduled_at->copy()->addMinutes(max(5, (int) $appointment->duration_minutes) + 30);
        $now = Carbon::now();
        if ($now->lt($start) || $now->gt($end)) {
            return ['allowed' => false, 'message' => 'The Join button will be available 15 minutes before your appointment and until 30 minutes after it ends.'];
        }

        // Queue gating: an earlier active serial in the same chamber/day must finish first.
        if ($appointment->chamber_id) {
            $earlierPatientStillActive = Appointment::query()
                ->where('chamber_id', $appointment->chamber_id)
                ->whereDate('scheduled_at', $appointment->scheduled_at->toDateString())
                ->where('scheduled_at', '<', $appointment->scheduled_at)
                ->whereIn('status', ['confirmed', 'waiting', 'in_progress'])
                ->exists();

            if ($earlierPatientStillActive) {
                return ['allowed' => false, 'message' => 'An earlier patient is still in the queue. Your Join button will activate when your serial is called.'];
            }
        }

        return ['allowed' => true, 'message' => 'Your doctor has opened the consultation.'];
    }
}
