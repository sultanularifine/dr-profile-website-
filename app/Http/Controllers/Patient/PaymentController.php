<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentPayment;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = AppointmentPayment::with('appointment')
            ->where('patient_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('patient.payments.index', compact('payments'));
    }

    public function create(Appointment $appointment)
    {
        $this->assertOwnedPayableAppointment($appointment);
        $latestPayment = $appointment->payments()->first();
        $paymentSettings = $this->paymentSettings();
        $paymentMethods = $this->availablePaymentMethods($paymentSettings);

        return view('patient.payments.create', compact('appointment', 'latestPayment', 'paymentSettings', 'paymentMethods'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $this->assertOwnedPayableAppointment($appointment);
        $paymentSettings = $this->paymentSettings();
        abort_unless(($paymentSettings['manual_payment_enabled'] ?? '0') === '1', 403, 'Manual payment submissions are disabled. Please contact the clinic.');
        if ($appointment->fee_waived || (float) $appointment->fee <= 0) {
            throw ValidationException::withMessages(['payment_method' => 'No payment is required for this appointment.']);
        }
        if ($appointment->payment_status === 'paid') {
            throw ValidationException::withMessages(['payment_method' => 'This appointment is already marked as paid.']);
        }
        if ($appointment->payments()->where('status', 'pending')->exists()) {
            throw ValidationException::withMessages(['payment_method' => 'A payment submission is already waiting for admin review.']);
        }

        $data = $request->validate([
            'payment_method' => ['required', Rule::in(array_keys($this->availablePaymentMethods($paymentSettings)))],
            'transaction_reference' => ['required_unless:payment_method,cash_at_chamber', 'nullable', 'string', 'max:255'],
            'payment_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'patient_note' => ['nullable', 'string', 'max:1500'],
        ]);

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('private/payment-proofs', 'local');
        }

        try {
            DB::transaction(function () use ($appointment, $data, $request, $proofPath) {
                $lockedAppointment = Appointment::query()->whereKey($appointment->id)->lockForUpdate()->firstOrFail();
                abort_unless((int) $lockedAppointment->patient_id === (int) auth()->id(), 404);
                if ($lockedAppointment->payment_status === 'paid' || $lockedAppointment->payments()->where('status', 'pending')->exists()) {
                    throw ValidationException::withMessages(['payment_method' => 'Payment state changed. Refresh and check your appointment.']);
                }

                $file = $request->file('payment_proof');
                AppointmentPayment::create([
                    'appointment_id' => $lockedAppointment->id,
                    'patient_id' => auth()->id(),
                    'method' => $data['payment_method'],
                    'amount' => $lockedAppointment->fee,
                    'transaction_reference' => $data['transaction_reference'] ?? null,
                    'proof_path' => $proofPath,
                    'proof_original_name' => $file ? $this->safeFilename($file->getClientOriginalName()) : null,
                    'proof_mime' => $file ? $file->getMimeType() : null,
                    'proof_size' => $file ? $file->getSize() : null,
                    'status' => 'pending',
                    'patient_note' => $data['patient_note'] ?? null,
                ]);

                if (in_array($lockedAppointment->payment_status, ['unpaid', 'refunded'], true)) {
                    $lockedAppointment->update(['payment_status' => 'pending']);
                }
            });
        } catch (\Throwable $exception) {
            if ($proofPath && Storage::disk('local')->exists($proofPath)) {
                Storage::disk('local')->delete($proofPath);
            }
            throw $exception;
        }

        return redirect()->route('patient.payments.index')->with('success', 'Payment information submitted. It will remain pending until the clinic verifies it.');
    }

    public function proof(AppointmentPayment $payment)
    {
        abort_unless((int) $payment->patient_id === (int) auth()->id(), 404);
        abort_unless($payment->proof_path && Storage::disk('local')->exists($payment->proof_path), 404);

        return Storage::disk('local')->download($payment->proof_path, $payment->proof_original_name ?: 'payment-proof');
    }


    private function paymentSettings(): array
    {
        $settings = [];
        foreach (config('site_settings_fields.payments.fields', []) as $field) {
            $key = $field['key'];
            $settings[$key] = (string) SiteSetting::valueFor($key, $field['default'] ?? '');
        }

        // SSLCommerz is managed in the gateway settings section rather than in the
        // manual-payment settings list, so read its flags explicitly for patient UI.
        $settings['sslcommerz_enabled'] = (string) SiteSetting::valueFor('sslcommerz_enabled', '0');
        $settings['sslcommerz_environment'] = (string) SiteSetting::valueFor('sslcommerz_environment', 'sandbox');
        $settings['sslcommerz_configured'] = (
            trim((string) SiteSetting::valueFor('sslcommerz_store_id', '')) !== ''
            && trim((string) SiteSetting::valueFor('sslcommerz_store_passwd', '')) !== ''
        ) ? '1' : '0';

        return $settings;
    }

    private function availablePaymentMethods(array $settings): array
    {
        $methods = ['cash_at_chamber' => 'Cash at chamber (pay in person)'];
        if (trim((string) ($settings['bkash_payment_number'] ?? '')) !== '') $methods['bkash'] = 'bKash (manual transfer)';
        if (trim((string) ($settings['nagad_payment_number'] ?? '')) !== '') $methods['nagad'] = 'Nagad (manual transfer)';
        if (trim((string) ($settings['bank_name'] ?? '')) !== '' && trim((string) ($settings['bank_account_number'] ?? '')) !== '') $methods['bank_transfer'] = 'Bank transfer';
        return $methods;
    }

    private function assertOwnedPayableAppointment(Appointment $appointment): void
    {
        abort_unless((int) $appointment->patient_id === (int) auth()->id(), 404);
        abort_unless(!in_array($appointment->status, ['cancelled', 'rejected'], true), 422, 'Cancelled or rejected appointments cannot receive payment.');
        abort_unless(!$appointment->fee_waived && (float) $appointment->fee > 0, 422, 'No payment is required for this appointment.');
    }

    private function safeFilename(string $name): string
    {
        $extension = preg_replace('/[^A-Za-z0-9]+/', '', pathinfo($name, PATHINFO_EXTENSION)) ?: 'bin';
        $base = preg_replace('/[^A-Za-z0-9._-]+/', '-', pathinfo(str_replace('\\', '/', $name), PATHINFO_FILENAME)) ?: 'payment-proof';
        return substr(trim($base, '.-_'), 0, 100) . '.' . strtolower($extension);
    }
}
