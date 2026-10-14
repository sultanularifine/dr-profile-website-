<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Services\ConsultationAccessService;
use Tests\TestCase;

class ConsultationAccessManualOverrideTest extends TestCase
{
    public function test_manual_override_allows_confirmed_unpaid_appointment_outside_scheduled_time(): void
    {
        $appointment = new Appointment([
            'consultation_type' => 'online',
            'status' => 'confirmed',
            'fee' => 800,
            'fee_waived' => false,
            'payment_status' => 'unpaid',
            'meeting_enabled' => false,
            'meeting_manual_override' => true,
            'meeting_url' => 'https://meet.google.com/abc-defg-hij',
            'scheduled_at' => now()->addDays(7),
            'duration_minutes' => 15,
        ]);

        $access = (new ConsultationAccessService())->forPatient($appointment);

        $this->assertTrue($access['allowed']);
        $this->assertStringContainsString('manually opened', $access['message']);
    }

    public function test_manual_override_does_not_allow_a_cancelled_or_completed_appointment(): void
    {
        foreach (['completed', 'cancelled', 'rejected', 'no_show'] as $status) {
            $appointment = new Appointment([
                'consultation_type' => 'online',
                'status' => $status,
                'meeting_manual_override' => true,
                'meeting_url' => 'https://meet.google.com/abc-defg-hij',
            ]);

            $access = (new ConsultationAccessService())->forPatient($appointment);
            $this->assertFalse($access['allowed'], "Unexpected access for {$status} appointment.");
        }
    }

    public function test_payment_gate_still_applies_without_manual_override(): void
    {
        $appointment = new Appointment([
            'consultation_type' => 'online',
            'status' => 'waiting',
            'fee' => 800,
            'fee_waived' => false,
            'payment_status' => 'unpaid',
            'meeting_enabled' => true,
            'meeting_manual_override' => false,
            'meeting_url' => 'https://meet.google.com/abc-defg-hij',
            'scheduled_at' => now(),
            'duration_minutes' => 15,
        ]);

        $access = (new ConsultationAccessService())->forPatient($appointment);

        $this->assertFalse($access['allowed']);
        $this->assertStringContainsString('Payment must be verified', $access['message']);
    }
}
