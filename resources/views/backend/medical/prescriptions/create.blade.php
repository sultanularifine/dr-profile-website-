@extends('backend.layouts.app')
@section('title', 'Create Prescription')
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>Prescription for {{ $appointment->patient->name }}</h1></div>
    <div class="section-body">
        <div class="alert alert-info">Appointment: {{ $appointment->appointment_code }} · {{ $appointment->scheduled_at?->format('d M Y, h:i A') }}. Clinical information must be entered and approved by the treating doctor.</div>
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.prescriptions.store',$appointment) }}">
            @csrf
            <div class="card"><div class="card-header"><h4>Prescription details</h4></div><div class="card-body">
                <div class="form-group"><label>Type</label><select name="type" id="prescription-type" class="form-control" required><option value="digital">Online written prescription</option><option value="handwritten">Upload handwritten image / scanned PDF</option></select></div>
                <div class="form-group" id="handwritten-field" style="display:none"><label>Prescription photo or PDF (JPG, PNG, WEBP, PDF; max 10 MB)</label><input type="file" name="handwritten_file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.pdf,image/jpeg,image/png,image/webp,application/pdf"><small class="text-muted">Stored in private storage and delivered only to the assigned patient.</small></div>
                <div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ old('title') }}" placeholder="Prescription title"></div>
                <div class="form-group"><label>Chief complaints</label><textarea class="form-control" name="chief_complaints" rows="2">{{ old('chief_complaints') }}</textarea></div>
                <div class="form-group"><label>Examination findings</label><textarea class="form-control" name="examination_findings" rows="2">{{ old('examination_findings') }}</textarea></div>
                <div class="form-group"><label>Diagnosis</label><textarea class="form-control" name="diagnosis" rows="2">{{ old('diagnosis') }}</textarea></div>
                <div class="form-group"><label>Investigation / tests</label><textarea class="form-control" name="investigation_advice" rows="2">{{ old('investigation_advice') }}</textarea></div>
                <hr><h5>Medicines (digital prescription only)</h5>
                <div id="medicine-rows">
                    <div class="border rounded p-3 mb-3 medicine-row">
                        <div class="form-row">
                            <div class="form-group col-md-6"><label>Medicine name</label><input class="form-control" name="medicines[0][medicine_name]"></div>
                            <div class="form-group col-md-3"><label>Strength</label><input class="form-control" name="medicines[0][strength]"></div>
                            <div class="form-group col-md-3"><label>Dosage</label><input class="form-control" name="medicines[0][dosage]"></div>
                            <div class="form-group col-md-3"><label>Route</label><input class="form-control" name="medicines[0][route]" placeholder="e.g. oral"></div>
                            <div class="form-group col-md-3"><label>Frequency</label><input class="form-control" name="medicines[0][frequency]"></div>
                            <div class="form-group col-md-3"><label>Duration</label><input class="form-control" name="medicines[0][duration]"></div>
                            <div class="form-group col-md-3"><label>Quantity</label><input class="form-control" name="medicines[0][quantity]"></div>
                            <div class="form-group col-12"><label>Instructions</label><input class="form-control" name="medicines[0][instructions]"></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary mb-3" id="add-medicine">Add medicine row</button>
                <div class="form-group"><label>General advice</label><textarea class="form-control" name="general_advice" rows="3">{{ old('general_advice') }}</textarea></div>
                <div class="form-group"><label>Follow-up date</label><input class="form-control" type="date" name="follow_up_date" value="{{ old('follow_up_date') }}"></div>
                <button class="btn btn-secondary" name="action" value="draft">Save Draft</button>
                <button class="btn btn-primary" name="action" value="publish" onclick="return confirm('Publish this prescription to the selected patient?')">Publish to Patient</button>
                <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-light">Cancel</a>
            </div></div>
        </form>
    </div>
</section></div>
<script>
(function(){
 const type=document.getElementById('prescription-type'), upload=document.getElementById('handwritten-field');
 const rows=document.getElementById('medicine-rows');
 function toggle(){ upload.style.display=type.value==='handwritten'?'block':'none'; rows.style.display=type.value==='handwritten'?'none':'block'; document.getElementById('add-medicine').style.display=type.value==='handwritten'?'none':'inline-block'; }
 type.addEventListener('change',toggle); toggle();
 document.getElementById('add-medicine').addEventListener('click',function(){
   const i=rows.querySelectorAll('.medicine-row').length, first=rows.querySelector('.medicine-row'), clone=first.cloneNode(true);
   clone.querySelectorAll('input').forEach(input=>{input.value='';input.name=input.name.replace(/medicines\[\d+\]/,'medicines['+i+']');});
   rows.appendChild(clone);
 });
})();
</script>
@endsection
