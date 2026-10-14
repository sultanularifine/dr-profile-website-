@extends('backend.layouts.app')
@section('title', 'Prescriptions')
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>Prescriptions</h1></div>
    <div class="section-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="card"><div class="card-body table-responsive">
            <table class="table table-striped"><thead><tr><th>Reference</th><th>Patient</th><th>Appointment</th><th>Type</th><th>Status</th><th>Actions</th></tr></thead><tbody>
            @forelse($prescriptions as $prescription)
                <tr><td>{{ $prescription->reference }}</td><td>{{ $prescription->patient->name ?? 'Deleted patient' }}</td><td>{{ $prescription->appointment->appointment_code ?? '-' }}</td><td>{{ ucfirst($prescription->type) }}</td><td>{{ ucfirst($prescription->status) }}</td><td>
                    @if($prescription->type==='digital' && $prescription->status==='published')<a class="btn btn-sm btn-outline-primary" href="{{ route('admin.prescriptions.pdf',$prescription) }}">Download PDF</a>@endif
                    @if($prescription->private_file_path)<a class="btn btn-sm btn-outline-primary" href="{{ route('admin.prescriptions.file',$prescription) }}">Download original file</a>@endif
                    @if($prescription->status === 'draft')<form method="POST" action="{{ route('admin.prescriptions.publish',$prescription) }}" class="d-inline">@csrf @method('PUT')<button class="btn btn-sm btn-success">Publish</button></form>@endif
                </td></tr>
            @empty<tr><td colspan="6" class="text-center">No prescriptions yet.</td></tr>@endforelse
            </tbody></table>{{ $prescriptions->links() }}
        </div></div>
    </div>
</section></div>
@endsection
