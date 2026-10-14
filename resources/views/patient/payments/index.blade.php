@extends('patient.layouts.app')
@section('title', 'Payment History')
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>My Payment History</h1></div>
    <div class="section-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="card"><div class="card-body table-responsive"><table class="table table-striped">
            <thead><tr><th>Payment reference</th><th>Appointment</th><th>Method</th><th>Amount</th><th>Status</th><th>Proof</th></tr></thead><tbody>
            @forelse($payments as $payment)
            <tr><td>{{ $payment->reference }}<br><small>{{ $payment->created_at?->format('d M Y, h:i A') }}</small></td><td>{{ $payment->appointment->appointment_code ?? '—' }}<br><small>{{ $payment->appointment->scheduled_at?->format('d M Y, h:i A') }}</small></td><td>{{ ucfirst(str_replace('_',' ',$payment->method)) }}</td><td>{{ number_format((float)$payment->amount,2) }} {{ config('app.currency','BDT') }}</td><td><span class="badge badge-{{ $payment->status==='verified'?'success':($payment->status==='pending'?'warning':($payment->status==='rejected'?'danger':'secondary')) }}">{{ ucfirst($payment->status) }}</span>@if($payment->review_note)<small class="d-block mt-1">{{ $payment->review_note }}</small>@endif</td><td>@if($payment->proof_path)<a class="btn btn-sm btn-outline-primary" href="{{ route('patient.payments.proof',$payment) }}">Download proof</a>@else—@endif</td></tr>
            @empty<tr><td colspan="6" class="text-center">No payment submissions yet.</td></tr>@endforelse
            </tbody></table>{{ $payments->links() }}</div></div>
    </div>
</section></div>
@endsection
