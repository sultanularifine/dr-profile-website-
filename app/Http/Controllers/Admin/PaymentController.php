<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    private function authorizePaymentStaff(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['Super Admin', 'Doctor', 'Admin']), 403);
    }

    private function authorizeReviewer(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['Super Admin', 'Doctor']), 403);
    }

    public function index(Request $request)
    {
        $this->authorizePaymentStaff();
        $request->validate(['status' => ['nullable', Rule::in(['pending', 'verified', 'rejected', 'refunded'])]]);
        $query = AppointmentPayment::with(['appointment.chamber', 'patient', 'reviewer'])->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }
        $payments = $query->paginate(20)->withQueryString();

        return view('backend.medical.payments.index', compact('payments'));
    }

    public function update(Request $request, AppointmentPayment $payment)
    {
        $this->authorizeReviewer();
        $data = $request->validate([
            'status' => ['required', Rule::in(['verified', 'rejected', 'refunded'])],
            'review_note' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($payment, $data) {
            $lockedPayment = AppointmentPayment::query()->whereKey($payment->id)->lockForUpdate()->firstOrFail();
            $appointment = $lockedPayment->appointment()->lockForUpdate()->firstOrFail();
            $newStatus = $data['status'];
            if ($lockedPayment->method === 'sslcommerz' && in_array($newStatus, ['verified', 'rejected'], true)) {
                throw ValidationException::withMessages(['status' => 'SSLCommerz payment status must be verified by the gateway callback/IPN. Manual verification is only for bKash, Nagad, bank transfer, and cash submissions.']);
            }

            if ($newStatus === 'verified') {
                if ($lockedPayment->status !== 'pending') {
                    throw ValidationException::withMessages(['status' => 'Only pending payments can be verified.']);
                }
                $otherVerified = AppointmentPayment::query()
                    ->where('appointment_id', $appointment->id)
                    ->where('status', 'verified')
                    ->where('id', '!=', $lockedPayment->id)
                    ->exists();
                if ($otherVerified) {
                    throw ValidationException::withMessages(['status' => 'Another payment has already been verified for this appointment.']);
                }
                $appointment->update(['payment_status' => 'paid']);
            } elseif ($newStatus === 'rejected') {
                if ($lockedPayment->status !== 'pending') {
                    throw ValidationException::withMessages(['status' => 'Only pending payments can be rejected.']);
                }
                $otherPending = AppointmentPayment::query()
                    ->where('appointment_id', $appointment->id)
                    ->where('status', 'pending')
                    ->where('id', '!=', $lockedPayment->id)
                    ->exists();
                $appointment->update(['payment_status' => $otherPending ? 'pending' : 'unpaid']);
            } else {
                if ($lockedPayment->status !== 'verified') {
                    throw ValidationException::withMessages(['status' => 'Only verified payments can be marked refunded. Record the actual refund through your payment provider first.']);
                }
                $appointment->update(['payment_status' => 'refunded']);
            }

            $lockedPayment->update([
                'status' => $newStatus,
                'review_note' => $data['review_note'] ?? null,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        });

        return back()->with('success', 'Payment review saved. No external gateway charge or refund was performed by this manual review.');
    }

    public function proof(AppointmentPayment $payment)
    {
        $this->authorizePaymentStaff();
        abort_unless($payment->proof_path && Storage::disk('local')->exists($payment->proof_path), 404);

        return Storage::disk('local')->download($payment->proof_path, $payment->proof_original_name ?: 'payment-proof');
    }
}
