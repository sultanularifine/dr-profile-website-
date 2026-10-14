<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prescription {{ $prescription->reference }}</title>
<style>
@page { size: A4; margin: 24mm 18mm 20mm 18mm; }
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.55; color: #182235; }
.header { border-bottom: 2px solid #1d70a8; padding-bottom: 12px; margin-bottom: 16px; }
.doctor { font-size: 20px; font-weight: bold; color: #145b88; margin: 0; }
.muted { color: #596579; }
.reference { float: right; font-weight: bold; }
.patient { background: #f1f6fa; border: 1px solid #d7e4ed; padding: 10px; margin-bottom: 14px; }
h3 { font-size: 12px; color: #145b88; border-bottom: 1px solid #dbe5ec; padding-bottom: 4px; margin: 15px 0 6px; }
p { margin: 5px 0; }
table { width: 100%; border-collapse: collapse; margin-top: 6px; }
th, td { border: 1px solid #cbd5df; padding: 6px; text-align: left; vertical-align: top; }
th { background: #edf4f8; }
.signature { margin-top: 28px; text-align: right; }
.footer { margin-top: 26px; padding-top: 8px; border-top: 1px solid #dbe5ec; font-size: 9px; color: #687588; }
</style>
</head>
<body>
@php
    $doctorName = $doctorProfile?->full_name ?: ($doctorProfile?->user?->name ?: ($prescription->author->name ?? 'Doctor'));
    $qualifications = is_array($doctorProfile?->qualifications) ? implode(', ', array_filter($doctorProfile->qualifications)) : (string) ($doctorProfile?->qualifications ?? '');
    $chamber = $prescription->appointment?->chamber;
@endphp
<div class="header">
    <span class="reference">RX: {{ $prescription->reference }}</span>
    <p class="doctor">{{ $doctorName }}</p>
    @if($doctorProfile?->professional_title)<p>{{ $doctorProfile->professional_title }}</p>@endif
    @if($qualifications !== '')<p class="muted">{{ $qualifications }}</p>@endif
    @if($doctorProfile?->bmdc_registration)<p class="muted">Registration: {{ $doctorProfile->bmdc_registration }}</p>@endif
    @if($chamber)<p>{{ $chamber->name }}@if($chamber->address) — {{ $chamber->address }}@endif</p>@endif
    @if($doctorProfile?->phone)<p>Phone: {{ $doctorProfile->phone }}</p>@endif
</div>
<div class="patient">
    <strong>Patient:</strong> {{ $patient->name ?? 'Patient' }} &nbsp;&nbsp;
    <strong>Appointment:</strong> {{ $prescription->appointment->appointment_code ?? '—' }}<br>
    <strong>Date:</strong> {{ $prescription->published_at?->format('d M Y') ?? now()->format('d M Y') }}
    @if($prescription->appointment?->scheduled_at) &nbsp;&nbsp;<strong>Consultation:</strong> {{ $prescription->appointment->scheduled_at->format('d M Y, h:i A') }} @endif
</div>
@foreach(['chief_complaints'=>'Chief complaints','examination_findings'=>'Examination findings','diagnosis'=>'Diagnosis','investigation_advice'=>'Investigations / tests'] as $field=>$label)
    @if($prescription->$field)<h3>{{ $label }}</h3><p>{!! nl2br(e($prescription->$field)) !!}</p>@endif
@endforeach
@if($prescription->items->isNotEmpty())
<h3>Medication</h3>
<table><thead><tr><th style="width:30%">Medicine / Strength</th><th>Dosage / Route</th><th>Frequency</th><th>Duration / Qty.</th><th>Instructions</th></tr></thead><tbody>
@foreach($prescription->items as $item)
<tr>
<td>{{ $item->medicine_name }}@if($item->strength)<br>{{ $item->strength }}@endif</td>
<td>{{ $item->dosage }}@if($item->route)<br>{{ $item->route }}@endif</td>
<td>{{ $item->frequency }}</td>
<td>{{ $item->duration }}@if($item->quantity)<br>Qty: {{ $item->quantity }}@endif</td>
<td>{{ $item->instructions }}</td>
</tr>
@endforeach
</tbody></table>
@endif
@if($prescription->general_advice)<h3>Advice</h3><p>{!! nl2br(e($prescription->general_advice)) !!}</p>@endif
@if($prescription->follow_up_date)<h3>Follow-up</h3><p>{{ $prescription->follow_up_date->format('d M Y') }}</p>@endif
<div class="signature"><strong>{{ $doctorName }}</strong><br><span class="muted">Digital prescription generated from the clinic system</span></div>
<div class="footer">Prescription reference: {{ $prescription->reference }}. This document contains private medical information and is intended only for the named patient.</div>
</body>
</html>
