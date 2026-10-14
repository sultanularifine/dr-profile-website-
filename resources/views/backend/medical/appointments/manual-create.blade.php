@extends('backend.layouts.app')
@section('title', 'Manual / Priority Appointment')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manual / Priority Appointment</h1>
            <div class="section-header-button"><a href="{{ route('admin.appointments.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Back to Appointments</a></div>
        </div>
        <div class="section-body">
            <div class="alert alert-info">
                Use this form for known patients, urgent follow-ups, or appointments arranged by phone. You can choose a custom time outside the weekly chamber schedule. The system will still block overlapping active appointments.
            </div>
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            <div class="card">
                <div class="card-header"><h4>Patient and appointment details</h4></div>
                <div class="card-body">
                    @if($patients->isEmpty())
                        <div class="alert alert-warning">No patient accounts were found. Ask the patient to register first, or create a patient account before scheduling manually.</div>
                    @endif
                    <form method="POST" action="{{ route('admin.appointments.manual.store') }}" id="manual-appointment-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="patient_id">Patient <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="patient_id" id="patient_id" required>
                                    <option value="">Select a patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" @selected((string)old('patient_id')===(string)$patient->id)>{{ $patient->name }}{{ $patient->email ? ' — '.$patient->email : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="chamber_id">Chamber / Location</label>
                                <select class="form-control" name="chamber_id" id="chamber_id">
                                    <option value="">Custom / online / unspecified location</option>
                                    @foreach($chambers as $chamber)
                                        <option value="{{ $chamber->id }}" data-fee="{{ number_format((float)$chamber->consultation_fee, 2, '.', '') }}" data-type="{{ $chamber->consultation_type }}" @selected((string)old('chamber_id')===(string)$chamber->id)>{{ $chamber->name }} — Fee {{ number_format((float)$chamber->consultation_fee, 2) }} BDT</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Leave blank when arranging a custom online consultation or a location not listed above.</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="consultation_type">Consultation type <span class="text-danger">*</span></label>
                                <select class="form-control" name="consultation_type" id="consultation_type" required>
                                    <option value="offline" @selected(old('consultation_type','offline')==='offline')>Offline</option>
                                    <option value="online" @selected(old('consultation_type')==='online')>Online — Meet / Zoom</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="scheduled_at">Custom date and time <span class="text-danger">*</span></label>
                                <input class="form-control" type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                                <small class="form-text text-muted">Can be outside the standard weekly schedule, but must be in the future and not overlap another active appointment.</small>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="duration_minutes">Duration (minutes) <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="duration_minutes" id="duration_minutes" min="5" max="240" step="5" value="{{ old('duration_minutes', 15) }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="fee">Consultation fee (BDT)</label>
                                <input class="form-control" type="number" name="fee" id="fee" min="0" max="10000000" step="0.01" value="{{ old('fee') }}" placeholder="Uses chamber fee if blank">
                                <small class="form-text text-muted">Leave blank to use the selected chamber's standard fee.</small>
                            </div>
                            @hasanyrole('Super Admin|Doctor')
                            <div class="form-group col-md-8 pt-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="fee_waived" value="1" id="fee_waived" @checked(old('fee_waived'))>
                                    <label class="custom-control-label" for="fee_waived"><strong>Waive the consultation fee for this patient</strong></label>
                                </div>
                                <small class="form-text text-muted">The standard fee remains recorded for reference, but the patient will not be asked to pay. This appointment will not count as collected revenue.</small>
                            </div>
                            @endhasanyrole
                        </div>
                        @hasanyrole('Super Admin|Doctor')
                        <div class="form-group" id="fee-waiver-reason-wrap" style="display:none">
                            <label for="fee_waiver_reason">Reason for fee waiver <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="fee_waiver_reason" id="fee_waiver_reason" rows="2" maxlength="2000" placeholder="e.g. Known patient — follow-up consultation">{{ old('fee_waiver_reason') }}</textarea>
                            <small class="form-text text-muted">Saved in the appointment record for audit purposes.</small>
                        </div>
                        @endhasanyrole
                        <div class="form-group">
                            <label for="reason">Appointment reason (optional)</label>
                            <textarea class="form-control" name="reason" id="reason" rows="2" maxlength="1000">{{ old('reason') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="admin_notes">Internal notes (not shown to patient)</label>
                            <textarea class="form-control" name="admin_notes" id="admin_notes" rows="2" maxlength="5000">{{ old('admin_notes') }}</textarea>
                        </div>
                        <div class="alert alert-warning">The appointment is created as Confirmed. If you waive the fee, that does not mean money was collected; the waiver is recorded separately and online meeting access will not require payment verification.</div>
                        <button type="submit" class="btn btn-primary" @disabled($patients->isEmpty())><i class="fas fa-calendar-check"></i> Create Manual Appointment</button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
(function () {
    const chamber = document.getElementById('chamber_id');
    const fee = document.getElementById('fee');
    const consultationType = document.getElementById('consultation_type');
    const waiver = document.getElementById('fee_waived');
    const waiverWrap = document.getElementById('fee-waiver-reason-wrap');
    const waiverReason = document.getElementById('fee_waiver_reason');
    let feeManuallyChanged = fee.value !== '';
    fee.addEventListener('input', function () { feeManuallyChanged = true; });
    function syncChamber() {
        const option = chamber.options[chamber.selectedIndex];
        if (!feeManuallyChanged) fee.value = option && option.value ? (option.dataset.fee || '') : '';
        if (!option || !option.value) {
            Array.from(consultationType.options).forEach(item => item.disabled = false);
            return;
        }
        const supported = option.dataset.type || 'both';
        Array.from(consultationType.options).forEach(item => {
            item.disabled = supported !== 'both' && item.value !== supported;
        });
        if (consultationType.options[consultationType.selectedIndex]?.disabled) {
            consultationType.value = supported === 'online' ? 'online' : 'offline';
        }
    }
    function syncWaiver() {
        if (!waiverWrap) return;
        waiverWrap.style.display = waiver.checked ? 'block' : 'none';
        waiverReason.required = waiver.checked;
    }
    chamber.addEventListener('change', syncChamber);
    if (waiver) waiver.addEventListener('change', syncWaiver);
    syncChamber(); syncWaiver();
})();
</script>
@endsection
