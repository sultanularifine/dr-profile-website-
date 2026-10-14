@extends('backend.layouts.app')
@section('title', 'Chambers & Schedules')
@section('main')
<div class="main-content"><section class="section">
    <div class="section-header"><h1>Chambers & Schedules</h1></div>
    <div class="section-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="card"><div class="card-header"><h4>Add chamber / hospital</h4></div><div class="card-body">
            <form method="POST" action="{{ route('admin.chambers.store') }}">@csrf
                <div class="form-row">
                    <div class="form-group col-md-6"><label>Chamber name *</label><input class="form-control" name="name" required></div>
                    <div class="form-group col-md-6"><label>Hospital / clinic</label><input class="form-control" name="hospital_name"></div>
                    <div class="form-group col-md-6"><label>Department</label><input class="form-control" name="department"></div>
                    <div class="form-group col-md-6"><label>Phone</label><input class="form-control" name="phone"></div>
                    <div class="form-group col-12"><label>Address *</label><textarea class="form-control" name="address" required></textarea></div>
                    <div class="form-group col-md-6"><label>Google Maps URL</label><input class="form-control" type="url" name="maps_url"></div>
                    <div class="form-group col-md-3"><label>Consultation type</label><select class="form-control" name="consultation_type"><option value="both">Both</option><option value="offline">Offline</option><option value="online">Online</option></select></div>
                    <div class="form-group col-md-3"><label>Fee</label><input class="form-control" type="number" step="0.01" min="0" name="consultation_fee" value="0" required></div>
                    <div class="form-group col-md-3"><label>Display order</label><input class="form-control" type="number" min="0" name="display_order" value="0"></div>
                    <div class="form-group col-md-3 d-flex align-items-center"><label class="mb-0"><input type="checkbox" name="is_active" value="1" checked> Active</label></div>
                    <div class="form-group col-md-3 d-flex align-items-center"><label class="mb-0"><input type="checkbox" name="is_default" value="1"> Default chamber</label></div>
                </div>
                <button class="btn btn-primary">Add chamber</button>
            </form>
        </div></div>
        @foreach($chambers as $chamber)
        <div class="card"><div class="card-header"><h4>{{ $chamber->name }} @if($chamber->is_default)<span class="badge badge-primary">Default</span>@endif</h4></div><div class="card-body">
            <form method="POST" action="{{ route('admin.chambers.update',$chamber) }}">@csrf @method('PUT')
                <div class="form-row">
                    @foreach(['name'=>'Chamber name','hospital_name'=>'Hospital / clinic','department'=>'Department','phone'=>'Phone','address'=>'Address','maps_url'=>'Google Maps URL'] as $field=>$label)
                    <div class="form-group {{ $field === 'address' ? 'col-12' : 'col-md-6' }}"><label>{{ $label }}</label>@if($field === 'address')<textarea class="form-control" name="{{ $field }}" required>{{ $chamber->$field }}</textarea>@else<input class="form-control" name="{{ $field }}" value="{{ $chamber->$field }}" {{ $field === 'name' ? 'required' : '' }}>@endif</div>
                    @endforeach
                    <div class="form-group col-md-3"><label>Type</label><select class="form-control" name="consultation_type">@foreach(['both','offline','online'] as $type)<option value="{{ $type }}" @selected($chamber->consultation_type===$type)>{{ ucfirst($type) }}</option>@endforeach</select></div>
                    <div class="form-group col-md-3"><label>Fee</label><input class="form-control" type="number" step="0.01" min="0" name="consultation_fee" value="{{ $chamber->consultation_fee }}"></div>
                    <div class="form-group col-md-3"><label>Order</label><input class="form-control" type="number" min="0" name="display_order" value="{{ $chamber->display_order }}"></div>
                    <div class="form-group col-md-3"><label class="d-block">Options</label><label class="mr-3"><input type="checkbox" name="is_active" value="1" @checked($chamber->is_active)> Active</label><label><input type="checkbox" name="is_default" value="1" @checked($chamber->is_default)> Default</label></div>
                </div>
                <button class="btn btn-primary btn-sm">Save chamber</button>
            </form>
            <hr><h5>Weekly schedule</h5>
            @foreach($chamber->schedules as $schedule)
                <div class="border rounded p-3 mb-3">
                    <form method="POST" action="{{ route('admin.chambers.schedules.update',[$chamber,$schedule]) }}">
                        @csrf @method('PUT')
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-2"><label>Weekday</label><select class="form-control" name="weekday">@foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $i=>$day)<option value="{{ $i }}" @selected((int)$schedule->weekday===$i)>{{ $day }}</option>@endforeach</select></div>
                            <div class="form-group col-md-2"><label>Starts</label><input class="form-control" type="time" name="starts_at" value="{{ substr($schedule->starts_at,0,5) }}" required></div>
                            <div class="form-group col-md-2"><label>Ends</label><input class="form-control" type="time" name="ends_at" value="{{ substr($schedule->ends_at,0,5) }}" required></div>
                            <div class="form-group col-md-2"><label>Slot minutes</label><input class="form-control" type="number" name="slot_minutes" value="{{ $schedule->slot_minutes }}" min="5" max="180" required></div>
                            <div class="form-group col-md-2"><label>Max patients</label><input class="form-control" type="number" name="max_patients" value="{{ $schedule->max_patients }}" min="1" max="500" required></div>
                            <div class="form-group col-md-2"><label class="d-block">Availability</label><label><input type="checkbox" name="is_active" value="1" @checked($schedule->is_active)> Active</label></div>
                        </div>
                        <button class="btn btn-primary btn-sm">Save schedule</button>
                    </form>
                    <form class="d-inline-block mt-2" method="POST" action="{{ route('admin.chambers.schedules.destroy',[$chamber,$schedule]) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this schedule?')">Remove</button></form>
                </div>
            @endforeach
            <form class="mt-3" method="POST" action="{{ route('admin.chambers.schedules.store',$chamber) }}">@csrf
                <div class="form-row align-items-end">
                    <div class="form-group col-md-2"><label>Weekday</label><select class="form-control" name="weekday">@foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $i=>$day)<option value="{{ $i }}">{{ $day }}</option>@endforeach</select></div>
                    <div class="form-group col-md-2"><label>Starts</label><input class="form-control" type="time" name="starts_at" required></div>
                    <div class="form-group col-md-2"><label>Ends</label><input class="form-control" type="time" name="ends_at" required></div>
                    <div class="form-group col-md-2"><label>Slot minutes</label><input class="form-control" type="number" name="slot_minutes" value="15" min="5" max="180" required></div>
                    <div class="form-group col-md-2"><label>Max patients</label><input class="form-control" type="number" name="max_patients" value="20" min="1" max="500" required></div>
                    <div class="form-group col-md-2"><label class="d-block">Availability</label><label><input type="checkbox" name="is_active" value="1" checked> Active</label></div>
                    <div class="form-group col-12"><button class="btn btn-outline-primary">Add schedule</button></div>
                </div>
            </form>
        </div></div>
        @endforeach
    </div>
</section></div>
@endsection
