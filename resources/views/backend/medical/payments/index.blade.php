@extends('backend.layouts.app')
@section('title', 'Payment Management')
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>Payment Management</h1></div>
    <div class="section-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="alert alert-info">This module reviews patient-submitted manual payments. It does not charge or refund money through bKash, Nagad, or a bank API.</div>
        <div class="card"><div class="card-body">
            <form method="GET" class="form-inline mb-3">
                <label for="status" class="mr-2">Payment status</label>
                <select class="form-control mr-2" id="status" name="status">
                    <option value="">All</option>
                    @foreach(['pending','verified','rejected','refunded'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>@endforeach
                </select><button class="btn btn-primary">Filter</button>
            </form>
            <div class="table-responsive"><table class="table table-striped table-hover">
                <thead><tr><th>Payment</th><th>Patient / Appointment</th><th>Method</th><th>Amount</th><th>Proof / Reference</th><th>Review</th></tr></thead><tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->reference }}</strong><br><span class="badge badge-{{ $payment->status==='verified'?'success':($payment->status==='pending'?'warning':($payment->status==='rejected'?'danger':'secondary')) }}">{{ ucfirst($payment->status) }}</span><br><small>{{ $payment->created_at?->format('d M Y, h:i A') }}</small></td>
                        <td>{{ $payment->patient->name ?? 'Patient unavailable' }}<br><small>{{ $payment->appointment->appointment_code ?? 'Appointment unavailable' }} · {{ $payment->appointment->scheduled_at?->format('d M Y, h:i A') }}</small></td>
                        <td>{{ ucfirst(str_replace('_',' ',$payment->method)) }}</td>
                        <td>{{ number_format((float)$payment->amount, 2) }} {{ config('app.currency', 'BDT') }}</td>
                        <td>@if($payment->transaction_reference)<div>Txn: {{ $payment->transaction_reference }}</div>@endif @if($payment->proof_path)<a class="btn btn-sm btn-outline-primary mt-1" href="{{ route('admin.payments.proof',$payment) }}">Download proof</a>@endif @if($payment->patient_note)<small class="d-block mt-1">{{ $payment->patient_note }}</small>@endif</td>
                        <td style="min-width:260px">
                            @if($payment->status==='pending' && $payment->method==='sslcommerz')
                                <div class="alert alert-info p-2 mb-0"><strong>Gateway validation pending</strong><br><small>SSLCommerz পেমেন্ট এখানে হাতে Verify/Reject করা যাবে না। Success callback বা IPN transaction যাচাই করবে।</small></div>
                            @elseif($payment->status==='pending')
                                @hasanyrole('Super Admin|Doctor')
                                <form method="POST" action="{{ route('admin.payments.update',$payment) }}">@csrf @method('PUT')
                                    <textarea name="review_note" class="form-control mb-2" rows="2" maxlength="2000" placeholder="Optional review note"></textarea>
                                    <button class="btn btn-success btn-sm" name="status" value="verified" onclick="return confirm('Confirm that the payment was checked and received?')">Verify payment</button>
                                    <button class="btn btn-danger btn-sm" name="status" value="rejected" onclick="return confirm('Reject this payment submission?')">Reject</button>
                                </form>
                                @else <span class="text-muted">Only the doctor or super admin can verify payments.</span> @endhasanyrole
                            @elseif($payment->status==='verified')
                                <small>Reviewed by {{ $payment->reviewer->name ?? 'Admin' }}<br>{{ $payment->reviewed_at?->format('d M Y, h:i A') }}</small>
                                @hasanyrole('Super Admin|Doctor')
                                <form method="POST" action="{{ route('admin.payments.update',$payment) }}" class="mt-2">@csrf @method('PUT')<input type="hidden" name="status" value="refunded"><input class="form-control form-control-sm mb-1" name="review_note" placeholder="Refund note" maxlength="2000"><button class="btn btn-outline-warning btn-sm" onclick="return confirm('Only use this after completing the real refund with the provider. Continue?')">Record refunded</button></form>
                                @endhasanyrole
                            @else
                                <small>{{ $payment->review_note ?: 'No review note.' }}</small>
                            @endif
                        </td>
                    </tr>
                @empty<tr><td colspan="6" class="text-center py-4">No payment submissions found.</td></tr>@endforelse
                </tbody></table></div>{{ $payments->links() }}
        </div></div>
    </div>
</section></div>
@endsection
