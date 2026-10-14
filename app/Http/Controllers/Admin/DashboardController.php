<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentPayment;
use App\Models\Prescription;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Build the admin overview from persisted records only.
     * No sample statistics are displayed as real business data.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user?->hasRole('Patient')) {
            return redirect()->route('patient.dashboard');
        }

        abort_unless($user && $user->hasAnyRole(['Super Admin', 'Doctor', 'Receptionist', 'Admin']), 403);

        $hasAppointments = Schema::hasTable('appointments');
        $hasPayments = Schema::hasTable('appointment_payments');
        $hasPrescriptions = Schema::hasTable('prescriptions');
        $hasUsers = Schema::hasTable('users');
        $hasRoleTables = Schema::hasTable('roles') && Schema::hasTable('model_has_roles');

        $today = now()->toDateString();

        // Use a fresh query for each statistic so one filter cannot leak into another.
        $stats = [
            'appointments_total' => $hasAppointments ? Appointment::count() : 0,
            'appointments_today' => $hasAppointments ? Appointment::whereDate('scheduled_at', $today)->count() : 0,
            'appointments_pending' => $hasAppointments ? Appointment::where('status', 'pending')->count() : 0,
            'appointments_confirmed' => $hasAppointments ? Appointment::where('status', 'confirmed')->count() : 0,
            'appointments_completed' => $hasAppointments ? Appointment::where('status', 'completed')->count() : 0,
            'patients' => 0,
            'prescriptions_draft' => $hasPrescriptions ? Prescription::where('status', 'draft')->count() : 0,
            'prescriptions_published' => $hasPrescriptions ? Prescription::where('status', 'published')->count() : 0,
            'payments_pending' => $hasAppointments ? Appointment::whereIn('payment_status', ['unpaid', 'pending'])->where('fee_waived', false)->count() : 0,
            'payment_submissions_pending' => $hasPayments ? AppointmentPayment::where('status', 'pending')->count() : 0,
            'revenue_paid' => $hasAppointments ? Appointment::where('payment_status', 'paid')->sum('fee') : 0,
        ];

        if ($hasUsers && $hasRoleTables) {
            $patientIds = collect();
            try {
                $patientIds = $patientIds->merge(User::role('Patient')->pluck('id'));
            } catch (\Throwable $exception) {
                // The Patient role may not have been created yet on an older installation.
            }
            if ($hasAppointments) {
                $patientIds = $patientIds->merge(Appointment::query()->distinct()->pluck('patient_id'));
            }
            $stats['patients'] = $patientIds->filter()->unique()->count();
        } elseif ($hasAppointments) {
            $stats['patients'] = Appointment::query()->distinct()->count('patient_id');
        }

        $upcomingAppointments = $hasAppointments
            ? Appointment::with(['patient', 'chamber'])
                ->whereIn('status', ['pending', 'confirmed', 'waiting', 'in_progress'])
                ->where('scheduled_at', '>=', now())
                ->orderBy('scheduled_at')
                ->limit(8)
                ->get()
            : collect();

        $recentAppointments = $hasAppointments
            ? Appointment::with(['patient', 'chamber'])
                ->latest('created_at')
                ->limit(5)
                ->get()
            : collect();

        $tasks = Schema::hasTable('todos')
            ? Todo::query()->orderBy('date')->orderBy('time')->limit(10)->get()
            : collect();

        $currencyCode = 'BDT';
        if (Schema::hasTable('site_settings')) {
            $currencyCode = (string) (\App\Models\SiteSetting::valueFor('currency', 'BDT') ?: 'BDT');
        }

        return view('backend.dashboard', [
            'stats' => $stats,
            'upcomingAppointments' => $upcomingAppointments,
            'recentAppointments' => $recentAppointments,
            'data' => $tasks, // Keep the existing dashboard To-do list working.
            'medicalTablesReady' => $hasAppointments && $hasPrescriptions,
            'currencyCode' => $currencyCode,
        ]);
    }
}
