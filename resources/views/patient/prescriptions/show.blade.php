@extends('patient.layouts.app')
@section('title', 'Prescription '.$prescription->reference)
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>Prescription {{ $prescription->reference }}</h1></div>
    <div class="section-body">
        <div class="card"><div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                <div><p><strong>Doctor:</strong> {{ $prescription->author->name ?? 'Doctor' }}</p><p><strong>Appointment:</strong> {{ $prescription->appointment->appointment_code ?? '-' }}</p><p><strong>Published:</strong> {{ $prescription->published_at?->format('d M Y, h:i A') }}</p></div>
                <div>
                    @if($prescription->type==='digital')<a class="btn btn-primary mb-2" href="{{ route('patient.prescriptions.pdf',$prescription) }}"><i class="fas fa-file-pdf"></i> Download prescription PDF</a>@endif
                    @if($prescription->private_file_path)<a class="btn btn-outline-secondary mb-2" href="{{ route('patient.prescriptions.file',$prescription) }}">Download original file</a>@endif
                </div>
            </div>
            @if($prescription->type==='handwritten')
                <div class="alert alert-info">Your doctor uploaded a handwritten prescription or scan. The original file is stored privately and is shown only to your account.</div>
                @if(str_starts_with((string)$prescription->mime_type, 'image/'))
                    <div class="text-center"><img src="{{ route('patient.prescriptions.preview',$prescription) }}" alt="Handwritten prescription {{ $prescription->reference }}" class="img-fluid border rounded" style="max-height:900px"></div>
                @elseif($prescription->mime_type==='application/pdf')
                    <div style="height:75vh"><iframe title="Handwritten prescription scan" src="{{ route('patient.prescriptions.preview',$prescription) }}" width="100%" height="100%" style="border:1px solid #ddd"></iframe></div>
                @else
                    <p>Preview is not available for this file type. Use Download original file.</p>
                @endif
            @else
                <div id="print-prescription" class="prescription-paper border rounded p-4 p-md-5">
                    <div class="text-center border-bottom pb-3 mb-3"><h2>{{ config('app.name') }}</h2><h4>Medical Prescription</h4><p class="mb-0">Reference: {{ $prescription->reference }}</p></div>
                    <div class="row"><div class="col-md-7"><p><strong>Patient:</strong> {{ auth()->user()->name }}</p><p><strong>Appointment:</strong> {{ $prescription->appointment->appointment_code ?? '-' }}</p></div><div class="col-md-5 text-md-right"><p><strong>Date:</strong> {{ $prescription->published_at?->format('d M Y') }}</p><p><strong>Doctor:</strong> {{ $prescription->author->name ?? 'Doctor' }}</p></div></div>
                    @foreach(['chief_complaints'=>'Chief complaints','examination_findings'=>'Examination findings','diagnosis'=>'Diagnosis','investigation_advice'=>'Investigations / tests'] as $field=>$label)
                        @if($prescription->$field)<h5 class="mt-4">{{ $label }}</h5><p>{!! nl2br(e($prescription->$field)) !!}</p>@endif
                    @endforeach
                    @if($prescription->items->isNotEmpty())
                        <h5 class="mt-4">Medicines</h5><div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Medicine</th><th>Dosage / Route</th><th>Frequency</th><th>Duration / Quantity</th><th>Instructions</th></tr></thead><tbody>
                        @foreach($prescription->items as $item)<tr><td>{{ $item->medicine_name }} {{ $item->strength }}</td><td>{{ $item->dosage }} {{ $item->route }}</td><td>{{ $item->frequency }}</td><td>{{ $item->duration }} @if($item->quantity) / {{ $item->quantity }} @endif</td><td>{{ $item->instructions }}</td></tr>@endforeach
                        </tbody></table></div>
                    @endif
                    @if($prescription->general_advice)<h5 class="mt-4">Advice</h5><p>{!! nl2br(e($prescription->general_advice)) !!}</p>@endif
                    @if($prescription->follow_up_date)<p class="mt-4"><strong>Follow-up:</strong> {{ $prescription->follow_up_date->format('d M Y') }}</p>@endif
                    <div class="text-right mt-5"><strong>{{ $prescription->author->name ?? 'Doctor' }}</strong><br><small>Digitally prepared prescription</small></div>
                </div>
                <button class="btn btn-outline-primary mt-3" onclick="window.print()">Print prescription</button>
                <small class="text-muted d-block mt-2">Use Download prescription PDF for a file you can save and share securely with your care provider.</small>
            @endif
        </div></div>
    </div>
</section></div>
<style>
.prescription-paper{background:#fff;color:#17202b;min-height:600px}.prescription-paper h2{color:#145b88}
@media print { body * { visibility:hidden; } #print-prescription, #print-prescription * { visibility:visible; } #print-prescription { position:absolute; left:0; top:0; width:100%; border:0!important; } .patient-top,.btn,header,footer{display:none!important} }
</style>
@endsection
