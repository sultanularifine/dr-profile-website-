<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use App\Models\Chamber;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    private function authorizeAppointmentStaff(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['Super Admin', 'Doctor', 'Receptionist', 'Admin']), 403);
    }

    private function canManageClinicalDetails(): bool
    {
        return auth()->user()?->hasAnyRole(['Super Admin', 'Doctor']) ?? false;
    }

    public function index(Request $request)
    {
        $this->authorizeAppointmentStaff();
        $request->validate([
            'status' => ['nullable', Rule::in(['pending','confirmed','waiting','in_progress','completed','cancelled','rejected','no_show'])],
            'date' => ['nullable', 'date'],
        ]);
        $query = Appointment::with(['patient', 'chamber', 'meetingOverrideBy', 'payments.reviewer'])->orderByDesc('scheduled_at');
        if ($request->filled('status')) $query->where('status', (string) $request->input('status'));
        if ($request->filled('date')) $query->whereDate('scheduled_at', $request->input('date'));
        $appointments = $query->paginate(20)->withQueryString();
        return view('backend.medical.appointments.index', compact('appointments'));
    }


    public function createManual()
    {
        $this->authorizeAppointmentStaff();
        $patients = User::query()
            ->whereHas('roles', fn ($query) => $query->where('name', 'Patient'))
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        $chambers = Chamber::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'consultation_type', 'consultation_fee']);

        return view('backend.medical.appointments.manual-create', compact('patients', 'chambers'));
    }

    public function storeManual(Request $request)
    {
        $this->authorizeAppointmentStaff();
        $canWaiveFee = $this->canManageClinicalDetails();

        $data = $request->validate([
            'patient_id' => ['required', 'integer', 'exists:users,id'],
            'chamber_id' => ['nullable', 'integer', 'exists:chambers,id'],
            'consultation_type' => ['required', Rule::in(['offline', 'online'])],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:240'],
            'fee' => ['nullable', 'numeric', 'min:0', 'max:10000000'],
            'fee_waived' => ['sometimes', 'boolean'],
            'fee_waiver_reason' => ['nullable', 'string', 'max:2000'],
            'reason' => ['nullable', 'string', 'max:1000'],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $patient = User::query()
            ->whereKey($data['patient_id'])
            ->whereHas('roles', fn ($query) => $query->where('name', 'Patient'))
            ->firstOrFail();

        $chamber = null;
        if (!empty($data['chamber_id'])) {
            $chamber = Chamber::query()->where('is_active', true)->findOrFail($data['chamber_id']);
            if (!in_array($chamber->consultation_type, ['both', $data['consultation_type']], true)) {
                throw ValidationException::withMessages(['consultation_type' => 'The selected chamber does not support this consultation type.']);
            }
        }

        $feeWaived = $canWaiveFee && $request->boolean('fee_waived');
        if ($request->boolean('fee_waived') && !$canWaiveFee) {
            abort(403, 'Only a doctor or super admin can waive a consultation fee.');
        }
        if ($feeWaived && trim((string) ($data['fee_waiver_reason'] ?? '')) === '') {
            throw ValidationException::withMessages(['fee_waiver_reason' => 'Enter a short reason for waiving this consultation fee.']);
        }

        $fee = array_key_exists('fee', $data) && $data['fee'] !== null && $data['fee'] !== ''
            ? (float) $data['fee']
            : (float) ($chamber?->consultation_fee ?? 0);
        if ($feeWaived && $fee <= 0) {
            // Keep the normal consultation fee as a reference if available; the waiver is recorded separately.
            $fee = (float) ($chamber?->consultation_fee ?? 0);
        }
        $startsAt = Carbon::parse($data['scheduled_at']);
        $duration = (int) $data['duration_minutes'];
        $endsAt = $startsAt->copy()->addMinutes($duration);

        $appointment = DB::transaction(function () use ($data, $patient, $chamber, $fee, $feeWaived, $startsAt, $endsAt, $duration) {
            // This is a single-doctor site. Prevent overlapping active consultations even when
            // the custom time is outside the weekly chamber schedule or another chamber was selected.
            $activeStatuses = ['pending', 'confirmed', 'waiting', 'in_progress'];
            $sameDayAppointments = Appointment::query()
                ->whereDate('scheduled_at', $startsAt->toDateString())
                ->whereIn('status', $activeStatuses)
                ->orderBy('scheduled_at')
                ->lockForUpdate()
                ->get(['id', 'scheduled_at', 'duration_minutes']);

            $conflict = $sameDayAppointments->contains(function (Appointment $existing) use ($startsAt, $endsAt) {
                $existingStart = Carbon::parse($existing->scheduled_at);
                $existingEnd = $existingStart->copy()->addMinutes(max(1, (int) $existing->duration_minutes));
                return $existingStart->lt($endsAt) && $existingEnd->gt($startsAt);
            });
            if ($conflict) {
                throw ValidationException::withMessages([
                    'scheduled_at' => 'This time overlaps with another active appointment. Choose another time or resolve the existing appointment first.',
                ]);
            }

            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'created_by' => auth()->id(),
                'booking_source' => 'manual_priority',
                'chamber_id' => $chamber?->id,
                'consultation_type' => $data['consultation_type'],
                'scheduled_at' => $startsAt,
                'duration_minutes' => $duration,
                'reason' => $data['reason'] ?? null,
                'status' => 'confirmed',
                'fee' => $fee,
                'fee_waived' => $feeWaived,
                'fee_waiver_reason' => $feeWaived ? trim((string) $data['fee_waiver_reason']) : null,
                'payment_status' => 'unpaid',
                'admin_notes' => $data['admin_notes'] ?? null,
            ]);

            AppointmentStatusHistory::create([
                'appointment_id' => $appointment->id,
                'changed_by' => auth()->id(),
                'old_status' => null,
                'new_status' => 'confirmed',
                'notes' => 'Manually scheduled by staff. Source: manual priority booking.' . ($feeWaived ? ' Fee waived: ' . trim((string) $data['fee_waiver_reason']) : ''),
            ]);

            return $appointment;
        });

        return redirect()->route('admin.appointments.index')->with('success', 'Manual appointment scheduled and confirmed. Reference: ' . $appointment->appointment_code);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointmentStaff();
        $canManageClinicalDetails = $this->canManageClinicalDetails();

        $rules = [
            'status' => ['required', Rule::in(['pending','confirmed','waiting','in_progress','completed','cancelled','rejected','no_show'])],
            'admin_notes' => ['nullable','string','max:5000'],
        ];
        if ($canManageClinicalDetails) {
            $rules += [
                'meeting_provider' => ['nullable', Rule::in(['Google Meet','Zoom'])],
                'meeting_url' => ['nullable','url','max:2000'],
                'meeting_id' => ['nullable','string','max:255'],
                'meeting_passcode' => ['nullable','string','max:255'],
                'meeting_instructions' => ['nullable','string','max:5000'],
                'meeting_enabled' => ['sometimes', 'boolean'],
            ];
        }
        $data = $request->validate($rules);

        if ($canManageClinicalDetails) {
            $data['meeting_enabled'] = $request->boolean('meeting_enabled');
            if ($data['meeting_enabled'] && empty($data['meeting_url'])) {
                throw ValidationException::withMessages(['meeting_url' => 'Save a valid Google Meet or Zoom URL before enabling patient access.']);
            }
        }

        if ($canManageClinicalDetails && !empty($data['meeting_url'])) {
            $host = strtolower((string) parse_url($data['meeting_url'], PHP_URL_HOST));
            $isGoogleMeet = $host === 'meet.google.com';
            $isZoom = $host === 'zoom.us' || $host === 'www.zoom.us' || str_ends_with($host, '.zoom.us');
            abort_unless($isGoogleMeet || $isZoom, 422, 'Use an official Google Meet or Zoom HTTPS URL.');
            abort_unless(parse_url($data['meeting_url'], PHP_URL_SCHEME) === 'https', 422, 'Meeting URL must use HTTPS.');
        }

        DB::transaction(function () use ($appointment, $data, $canManageClinicalDetails) {
            // Lock the row so concurrent staff cannot apply conflicting status transitions.
            $lockedAppointment = Appointment::query()->whereKey($appointment->id)->lockForUpdate()->firstOrFail();
            $currentStatus = $lockedAppointment->status;
            $nextStatus = $data['status'];
            if (!$canManageClinicalDetails && in_array($nextStatus, ['waiting', 'in_progress', 'completed', 'no_show'], true) && $nextStatus !== $currentStatus) {
                throw ValidationException::withMessages(['status' => 'Only the doctor or super admin can call a serial, start or complete a consultation, or mark a no-show.']);
            }
            $allowedTransitions = [
                'pending' => ['confirmed', 'rejected', 'cancelled'],
                'confirmed' => ['waiting', 'in_progress', 'cancelled', 'no_show'],
                'waiting' => ['in_progress', 'cancelled', 'no_show'],
                'in_progress' => ['completed', 'cancelled'],
                'completed' => [],
                'cancelled' => [],
                'rejected' => [],
                'no_show' => [],
            ];
            if ($nextStatus !== $currentStatus && !in_array($nextStatus, $allowedTransitions[$currentStatus] ?? [], true)) {
                throw ValidationException::withMessages(['status' => "The appointment cannot be changed from {$currentStatus} to {$nextStatus}."]);
            }
            $update = [
                'status' => $nextStatus,
                'admin_notes' => $data['admin_notes'] ?? null,
            ];
            // Only a doctor or super admin can view/change private meeting credentials.
            if ($canManageClinicalDetails) {
                $update['meeting_enabled'] = (bool) ($data['meeting_enabled'] ?? false);
                foreach (['meeting_provider', 'meeting_url', 'meeting_id', 'meeting_passcode', 'meeting_instructions'] as $field) {
                    if (array_key_exists($field, $data)) {
                        $update[$field] = $data[$field] ?? null;
                    }
                }
            }
            if ($nextStatus === 'in_progress' && !$lockedAppointment->consultation_started_at) {
                $update['consultation_started_at'] = now();
            }
            if ($nextStatus === 'completed' && !$lockedAppointment->consultation_completed_at) {
                $update['consultation_completed_at'] = now();
            }
            $lockedAppointment->fill($update)->save();

            if ($currentStatus !== $nextStatus) {
                AppointmentStatusHistory::create([
                    'appointment_id' => $lockedAppointment->id,
                    'changed_by' => auth()->id(),
                    'old_status' => $currentStatus,
                    'new_status' => $nextStatus,
                    'notes' => isset($data['admin_notes']) ? mb_substr((string) $data['admin_notes'], 0, 2000) : null,
                ]);
            }
        });

        return back()->with('success', 'Appointment updated.');
    }

    /**
     * Explicitly open a patient's online consultation, bypassing normal time,
     * payment and queue gates. Only Doctor/Super Admin may use this override.
     */
    public function toggleManualJoinOverride(Request $request, Appointment $appointment)
    {
        abort_unless($this->canManageClinicalDetails(), 403, 'Only a doctor or Super Admin can manually open a consultation link.');

        $data = $request->validate([
            'enabled' => ['required', 'boolean'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);
        $enabled = $request->boolean('enabled');
        if ($enabled && trim((string) ($data['reason'] ?? '')) === '') {
            throw ValidationException::withMessages(['reason' => 'Enter a short reason before manually opening the consultation link.']);
        }

        DB::transaction(function () use ($appointment, $enabled, $data) {
            $locked = Appointment::query()->whereKey($appointment->id)->lockForUpdate()->firstOrFail();

            if ($locked->consultation_type !== 'online') {
                throw ValidationException::withMessages(['enabled' => 'Manual Join override is available only for online appointments.']);
            }
            if (!in_array($locked->status, ['confirmed', 'waiting', 'in_progress'], true)) {
                throw ValidationException::withMessages(['enabled' => 'Confirm the appointment before manually opening the Join button.']);
            }

            if ($enabled) {
                if (!$locked->meeting_url) {
                    throw ValidationException::withMessages(['enabled' => 'Add and save a valid Google Meet or Zoom URL first.']);
                }
                $host = strtolower((string) parse_url($locked->meeting_url, PHP_URL_HOST));
                $isGoogleMeet = $host === 'meet.google.com';
                $isZoom = $host === 'zoom.us' || $host === 'www.zoom.us' || str_ends_with($host, '.zoom.us');
                if (parse_url($locked->meeting_url, PHP_URL_SCHEME) !== 'https' || (!$isGoogleMeet && !$isZoom)) {
                    throw ValidationException::withMessages(['enabled' => 'The saved link must be an official Google Meet or Zoom HTTPS URL.']);
                }

                $reason = trim((string) $data['reason']);
                $locked->forceFill([
                    'meeting_manual_override' => true,
                    'meeting_override_by' => auth()->id(),
                    'meeting_override_at' => now(),
                    'meeting_override_reason' => $reason,
                ])->save();
                $auditNote = 'MANUAL JOIN OVERRIDE ENABLED by ' . auth()->user()->name
                    . '. Normal time, payment and queue gates bypassed. Reason: ' . $reason;
            } else {
                $locked->forceFill([
                    'meeting_manual_override' => false,
                    'meeting_override_by' => null,
                    'meeting_override_at' => null,
                    'meeting_override_reason' => null,
                ])->save();
                $auditNote = 'MANUAL JOIN OVERRIDE DISABLED by ' . auth()->user()->name
                    . '. Normal time, payment and queue rules are restored.';
            }

            // Store the action in the existing appointment history so overrides are auditable.
            AppointmentStatusHistory::create([
                'appointment_id' => $locked->id,
                'changed_by' => auth()->id(),
                'old_status' => $locked->status,
                'new_status' => $locked->status,
                'notes' => $auditNote,
            ]);
        });

        return back()->with('success', $enabled
            ? 'Manual Join override enabled. The patient can join now without waiting for the usual time/payment/queue checks.'
            : 'Manual Join override disabled. Normal consultation access rules are restored.');
    }

}
