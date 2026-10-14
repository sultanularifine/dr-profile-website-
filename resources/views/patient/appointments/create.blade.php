@extends('patient.layouts.app')
@section('title', 'Request Appointment')
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>Book an Appointment</h1></div>
    <div class="section-body">
        @if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="card"><div class="card-header"><h4>Choose your chamber and serial</h4></div><div class="card-body">
            @if($chambers->isEmpty())
                <div class="alert alert-warning">Online booking is not available yet because no active chamber has been configured.</div>
                <p>Please contact the clinic directly for assistance.</p>
            @else
            @php
                $oldSchedule = old('scheduled_at');
                $oldDate = $oldSchedule ? \Illuminate\Support\Carbon::parse($oldSchedule)->format('Y-m-d') : '';
                $oldTime = $oldSchedule ? \Illuminate\Support\Carbon::parse($oldSchedule)->format('Y-m-d\\TH:i') : '';
            @endphp
            <form method="POST" action="{{ route('patient.appointments.store') }}" id="patient-booking-form">
                @csrf
                <div class="form-group"><label for="chamber_id">Hospital / Chamber</label>
                    <select class="form-control" name="chamber_id" id="chamber_id" required>
                        <option value="">Select a chamber</option>
                        @foreach($chambers as $chamber)
                            <option value="{{ $chamber->id }}" data-consultation="{{ $chamber->consultation_type }}" data-fee="{{ number_format((float)$chamber->consultation_fee,2,'.','') }}" @selected((string)old('chamber_id', request('chamber_id'))===(string)$chamber->id)>{{ $chamber->name }} — {{ $chamber->address }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="consultation_type">Consultation type</label>
                        <select class="form-control" name="consultation_type" id="consultation_type" required>
                            <option value="offline" @selected(old('consultation_type')==='offline')>Offline — chamber visit</option>
                            <option value="online" @selected(old('consultation_type')==='online')>Online — Google Meet / Zoom</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6"><label for="appointment_date">Preferred date</label>
                        <input class="form-control" type="date" name="appointment_date" id="appointment_date" min="{{ now()->format('Y-m-d') }}" value="{{ old('appointment_date', $oldDate) }}" required>
                    </div>
                </div>
                <div class="alert alert-light border" id="fee-display">Choose a chamber to view the consultation fee.</div>
                <div class="form-group"><label for="scheduled_at">Available time / serial</label>
                    <select class="form-control" name="scheduled_at" id="scheduled_at" required disabled>
                        <option value="">First choose a chamber and date</option>
                    </select>
                    <small class="text-muted" id="slot-help">Only available slots from the chamber's active schedule will appear.</small>
                </div>
                <div class="form-group"><label for="reason">Reason for appointment (optional)</label><textarea class="form-control" name="reason" id="reason" rows="3" maxlength="1000">{{ old('reason') }}</textarea></div>
                <div class="alert alert-info">Your request starts as Pending. The clinic must confirm your serial. For online consultation, the Join button becomes available only when your serial is called, the time window is open, the doctor enables the link, and payment is verified if a fee applies.</div>
                <button class="btn btn-primary" id="submit-booking" type="submit" disabled>Submit appointment request</button>
                <a class="btn btn-light" href="{{ route('patient.dashboard') }}">Cancel</a>
            </form>
            @endif
        </div></div>
    </div>
</section></div>
@if($chambers->isNotEmpty())
<script>
(function () {
    const chamber = document.getElementById('chamber_id');
    const date = document.getElementById('appointment_date');
    const type = document.getElementById('consultation_type');
    const time = document.getElementById('scheduled_at');
    const help = document.getElementById('slot-help');
    const fee = document.getElementById('fee-display');
    const submit = document.getElementById('submit-booking');
    const endpoint = @json(route('patient.availability'));
    const oldTime = @json($oldTime);

    function resetSlots(message) {
        time.innerHTML = '';
        const option = document.createElement('option'); option.value = ''; option.textContent = message;
        time.appendChild(option); time.disabled = true; submit.disabled = true;
    }

    function updateConsultationOptions() {
        const option = chamber.options[chamber.selectedIndex];
        if (!option || !option.value) { fee.textContent = 'Choose a chamber to view the consultation fee.'; return; }
        const supported = option.dataset.consultation || 'both';
        Array.from(type.options).forEach(item => {
            item.disabled = supported !== 'both' && item.value !== supported;
        });
        if (type.options[type.selectedIndex]?.disabled) type.value = supported === 'online' ? 'online' : 'offline';
        fee.textContent = 'Consultation fee: ' + option.dataset.fee + ' BDT. Payment instructions will be shown in your patient dashboard.';
    }

    async function loadSlots() {
        resetSlots('Loading available times…');
        updateConsultationOptions();
        if (!chamber.value || !date.value) { resetSlots('First choose a chamber and date'); return; }
        try {
            const url = new URL(endpoint, window.location.origin);
            url.searchParams.set('chamber_id', chamber.value);
            url.searchParams.set('date', date.value);
            const response = await fetch(url.toString(), {headers: {'Accept': 'application/json'}});
            const payload = await response.json();
            if (!response.ok) throw new Error(payload.message || 'Could not load available times.');
            resetSlots(payload.slots.length ? 'Choose an available serial' : 'No free serials for this date');
            time.disabled = !payload.slots.length;
            payload.slots.forEach(slot => {
                const option = document.createElement('option'); option.value = slot.value; option.textContent = slot.label;
                if (slot.value === oldTime) option.selected = true;
                time.appendChild(option);
            });
            help.textContent = payload.slots.length ? payload.slots.length + ' available time(s). Slots are rechecked securely when submitted.' : 'Please choose another date or contact the clinic.';
            submit.disabled = !payload.slots.length;
        } catch (error) {
            resetSlots('Unable to load times; please try again');
            help.textContent = error.message || 'Please try again.';
        }
    }
    chamber.addEventListener('change', loadSlots);
    date.addEventListener('change', loadSlots);
    updateConsultationOptions();
    if (chamber.value && date.value) loadSlots();
    else resetSlots('First choose a chamber and date');
})();
</script>
@endif
@endsection
