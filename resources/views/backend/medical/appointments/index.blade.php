@extends('backend.layouts.app')
@section('title', 'অ্যাপয়েন্টমেন্ট ব্যবস্থাপনা')
@section('main')
<div class="main-content appointment-admin-page">
    <section class="section">
        <div class="section-header apt-page-header">
            <div><h1>অ্যাপয়েন্টমেন্ট ব্যবস্থাপনা</h1><p class="text-muted mb-0">রোগীর সিরিয়াল, পেমেন্ট, অনলাইন কনসালটেশন ও প্রেসক্রিপশন এক জায়গা থেকে পরিচালনা করুন।</p></div>
            <div class="section-header-button"><a href="{{ route('admin.appointments.manual.create') }}" class="btn btn-primary" title="ফোনে বা সরাসরি চেম্বারে বুক করা রোগীর অ্যাপয়েন্টমেন্ট যোগ করুন"><i class="fas fa-calendar-plus mr-1"></i> নতুন / ম্যানুয়াল অ্যাপয়েন্টমেন্ট</a></div>
        </div>
        <div class="section-body">
            @if(session('success'))<div class="alert alert-success alert-dismissible fade show" role="status">{{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="বন্ধ করুন"><span>&times;</span></button></div>@endif
            @if(session('warning'))<div class="alert alert-warning">{{ session('warning') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger"><strong>তথ্য যাচাই করে আবার চেষ্টা করুন:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <div class="apt-guide card">
                <div class="card-body">
                    <div class="apt-guide-title"><i class="fas fa-info-circle"></i><strong>বাটন ও অপশন কী কাজ করে?</strong></div>
                    <div class="apt-guide-grid">
                        <div><span class="apt-guide-icon"><i class="fas fa-save"></i></span><p><strong>পরিবর্তন সংরক্ষণ</strong><br>অ্যাপয়েন্টমেন্টের অবস্থা, মিটিং তথ্য ও অভ্যন্তরীণ নোট সেভ করে।</p></div>
                        <div><span class="apt-guide-icon"><i class="fas fa-check-circle"></i></span><p><strong>পেমেন্ট Verify</strong><br>রোগীর TrxID/প্রমাণ মিলিয়ে ঠিক থাকলে Payment Status Paid করে।</p></div>
                        <div><span class="apt-guide-icon"><i class="fas fa-video"></i></span><p><strong>Join Access</strong><br>রোগীকে Meet/Zoom লিংকে যোগ দেওয়ার অনুমতি নিয়ন্ত্রণ করে।</p></div>
                        <div><span class="apt-guide-icon"><i class="fas fa-file-prescription"></i></span><p><strong>প্রেসক্রিপশন লিখুন</strong><br>এই রোগীর ভিজিটের সঙ্গে ডিজিটাল বা হাতে-লেখা প্রেসক্রিপশন যুক্ত করে।</p></div>
                    </div>
                </div>
            </div>

            <div class="card apt-filter-card"><div class="card-body">
                <form class="apt-filter-form" method="GET" action="{{ route('admin.appointments.index') }}">
                    <div class="form-group"><label for="status">অ্যাপয়েন্টমেন্টের অবস্থা</label><select name="status" id="status" class="form-control">
                        <option value="">সব অবস্থা</option>
                        @foreach(['pending'=>'অনুমোদনের অপেক্ষায়','confirmed'=>'অনুমোদিত','waiting'=>'সিরিয়ালে অপেক্ষা','in_progress'=>'চিকিৎসা চলছে','completed'=>'সম্পন্ন','cancelled'=>'বাতিল','rejected'=>'প্রত্যাখ্যাত','no_show'=>'রোগী আসেননি'] as $value=>$label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach
                    </select></div>
                    <div class="form-group"><label for="date">তারিখ দিয়ে খুঁজুন</label><input type="date" id="date" name="date" class="form-control" value="{{ request('date') }}"></div>
                    <div class="apt-filter-actions"><button class="btn btn-primary" type="submit" title="নির্বাচিত তারিখ ও অবস্থা অনুযায়ী তালিকা দেখাবে"><i class="fas fa-filter mr-1"></i> ফিল্টার করুন</button><a class="btn btn-light" href="{{ route('admin.appointments.index') }}" title="সব ফিল্টার মুছে সব অ্যাপয়েন্টমেন্ট দেখাবে">ফিল্টার মুছুন</a></div>
                </form>
                <div class="small text-muted mt-2">এই পৃষ্ঠায় মোট {{ $appointments->total() }}টি রেকর্ডের মধ্যে {{ $appointments->count() }}টি দেখানো হচ্ছে।</div>
            </div></div>

            @php
                $canManageClinical = auth()->user()->hasAnyRole(['Super Admin', 'Doctor']);
                $statusLabels = ['pending'=>'অনুমোদনের অপেক্ষায়','confirmed'=>'অনুমোদিত','waiting'=>'সিরিয়ালে অপেক্ষা','in_progress'=>'চিকিৎসা চলছে','completed'=>'সম্পন্ন','cancelled'=>'বাতিল','rejected'=>'প্রত্যাখ্যাত','no_show'=>'রোগী আসেননি'];
                $statusTransitions = ['pending'=>['confirmed','rejected','cancelled'],'confirmed'=>['waiting','in_progress','cancelled','no_show'],'waiting'=>['in_progress','cancelled','no_show'],'in_progress'=>['completed','cancelled'],'completed'=>[],'cancelled'=>[],'rejected'=>[],'no_show'=>[]];
                $statusColors = ['pending'=>'warning','confirmed'=>'success','waiting'=>'info','in_progress'=>'primary','completed'=>'success','cancelled'=>'secondary','rejected'=>'danger','no_show'=>'secondary'];
            @endphp

            <div class="apt-list-heading"><h3>রোগীদের অ্যাপয়েন্টমেন্ট</h3><span class="text-muted small">প্রতি কার্ড খুলে প্রয়োজনীয় পরিবর্তন করুন</span></div>
            @forelse($appointments as $appointment)
                <article class="apt-card">
                    <div class="apt-card-top">
                        <div><span class="apt-ref-label">অ্যাপয়েন্টমেন্ট রেফারেন্স</span><h4>{{ $appointment->appointment_code }}</h4>
                            <div class="apt-badges"><span class="badge badge-{{ $statusColors[$appointment->status] ?? 'secondary' }}">{{ $statusLabels[$appointment->status] ?? ucfirst(str_replace('_',' ',$appointment->status)) }}</span>
                                @if(($appointment->booking_source ?? 'patient') !== 'patient')<span class="badge badge-info">ম্যানুয়াল / অগ্রাধিকার</span>@endif
                                @if($appointment->meeting_manual_override)<span class="badge badge-warning">Manual Join Override চালু</span>@endif
                            </div>
                        </div>
                        <div class="apt-date-chip"><i class="far fa-calendar-alt"></i><span>{{ $appointment->scheduled_at?->format('d M Y') }}<small>{{ $appointment->scheduled_at?->format('h:i A') }} · {{ $appointment->duration_minutes }} মিনিট</small></span></div>
                    </div>
                    <div class="apt-card-body">
                        <div class="apt-summary-panel">
                            <div class="apt-patient-name"><span class="apt-avatar"><i class="fas fa-user"></i></span><div><strong>{{ $appointment->patient->name ?? 'রোগীর অ্যাকাউন্ট পাওয়া যায়নি' }}</strong><small>{{ $appointment->patient->email ?? '' }}</small>@if(!empty($appointment->patient->phone))<small>{{ $appointment->patient->phone }}</small>@endif</div></div>
                            <div class="apt-detail-grid">
                                <div><small>ভিজিটের ধরন</small><strong>{{ $appointment->consultation_type === 'online' ? 'অনলাইন কনসালটেশন' : 'চেম্বারে সরাসরি' }}</strong></div>
                                <div><small>চেম্বার</small><strong>{{ $appointment->chamber->name ?? 'অনলাইন / নির্দিষ্ট নয়' }}</strong></div>
                                <div><small>ভিজিট ফি</small><strong>{{ number_format((float)$appointment->fee, 2) }} {{ config('app.currency','BDT') }}</strong></div>
                                <div><small>পেমেন্ট অবস্থা</small><strong>@if($appointment->fee_waived)<span class="badge badge-success">ফি মওকুফ</span>@else<span class="badge badge-{{ $appointment->payment_status==='paid'?'success':($appointment->payment_status==='pending'?'warning':'secondary') }}">{{ $appointment->payment_status==='paid'?'পরিশোধিত':($appointment->payment_status==='pending'?'যাচাই অপেক্ষায়':($appointment->payment_status==='refunded'?'ফেরত দেওয়া':'পরিশোধ হয়নি')) }}</span>@endif</strong></div>
                            </div>
                            @if($appointment->reason)<div class="apt-reason"><small>রোগীর সমস্যার বিবরণ</small><p>{{ $appointment->reason }}</p></div>@endif
                            @if($appointment->admin_notes)<div class="apt-reason"><small>সর্বশেষ অভ্যন্তরীণ নোট</small><p>{{ $appointment->admin_notes }}</p></div>@endif

                            @php $manualPending = $appointment->payments->first(fn($payment) => $payment->status === 'pending' && $payment->method !== 'sslcommerz'); @endphp
                            @if($manualPending)
                                <div class="apt-payment-review">
                                    <div class="apt-payment-title"><i class="fas fa-receipt"></i><strong>ম্যানুয়াল পেমেন্ট যাচাই বাকি</strong><span class="badge badge-warning">Pending</span></div>
                                    <div class="apt-payment-meta"><span>রেফারেন্স: <strong>{{ $manualPending->reference }}</strong></span><span>মাধ্যম: <strong>{{ $manualPending->method === 'bkash' ? 'bKash' : ($manualPending->method === 'nagad' ? 'Nagad' : str_replace('_',' ',ucfirst($manualPending->method))) }}</strong></span><span>TrxID: <strong class="text-break">{{ $manualPending->transaction_reference ?: 'দেওয়া হয়নি' }}</strong></span><span>পরিমাণ: <strong>{{ number_format((float)$manualPending->amount, 2) }} টাকা</strong></span></div>
                                    @if($manualPending->proof_path)@hasanyrole('Super Admin|Doctor|Admin')<a class="btn btn-outline-primary btn-sm mt-2" href="{{ route('admin.payments.proof',$manualPending) }}" title="রোগীর দেওয়া পেমেন্ট স্ক্রিনশট বা PDF দেখুন/ডাউনলোড করুন"><i class="fas fa-paperclip mr-1"></i> পেমেন্ট প্রমাণ দেখুন</a>@endhasanyrole @endif
                                    @if($manualPending->patient_note)<p class="small mb-2 mt-2">রোগীর নোট: {{ $manualPending->patient_note }}</p>@endif
                                    @if($canManageClinical)
                                        <form method="POST" action="{{ route('admin.payments.update',$manualPending) }}" class="apt-payment-review-form">@csrf @method('PUT')
                                            <input type="text" class="form-control form-control-sm" name="review_note" maxlength="2000" placeholder="যাচাই নোট (ঐচ্ছিক)" aria-label="পেমেন্ট যাচাই নোট">
                                            <button class="btn btn-success btn-sm" type="submit" name="status" value="verified" title="ট্রানজেকশন আপনার bKash/Nagad/Bank-এ মিলিয়ে নিলে Paid করবে" onclick="return confirm('টাকা বাস্তবে পেয়েছেন এবং TrxID মিলেছে নিশ্চিত? তাহলে পেমেন্ট Verify হবে।')"><i class="fas fa-check mr-1"></i> যাচাই করে Paid করুন</button>
                                            <button class="btn btn-outline-danger btn-sm" type="submit" name="status" value="rejected" title="ভুল বা মিল না পাওয়া পেমেন্ট আবেদন বাতিল করবে" onclick="return confirm('এই পেমেন্ট সাবমিশন Reject করবেন?')"><i class="fas fa-times mr-1"></i> Reject</button>
                                        </form>
                                        <small class="text-muted d-block mt-2">TrxID ও বাস্তব লেনদেন যাচাই করার পরেই Paid করুন। এটি ম্যানুয়াল যাচাই; bKash/Nagad API স্বয়ংক্রিয়ভাবে পরীক্ষা করে না।</small>
                                    @else
                                        <small class="text-muted d-block mt-2">পেমেন্ট যাচাই করার অনুমতি শুধু ডাক্তার বা Super Admin-এর আছে।</small>
                                    @endif
                                </div>
                            @elseif($appointment->payments->where('status','verified')->isNotEmpty())
                                <div class="apt-payment-done"><i class="fas fa-check-circle"></i> এই অ্যাপয়েন্টমেন্টের একটি পেমেন্ট যাচাই করা হয়েছে।</div>
                            @endif
                            <a href="{{ route('admin.payments.index', ['status'=>'pending']) }}" class="apt-more-payments"><i class="fas fa-list mr-1"></i> সব পেমেন্ট রেকর্ড দেখুন</a>
                        </div>

                        <div class="apt-management-panel">
                            <div class="apt-panel-heading"><i class="fas fa-sliders-h"></i><div><strong>অ্যাপয়েন্টমেন্ট পরিচালনা</strong><small>পরিবর্তন করলে নিচের Save বাটনে চাপ দিন।</small></div></div>
                            <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}" class="apt-update-form">@csrf @method('PUT')
                                @php
                                    $nextStatuses = $statusTransitions[$appointment->status] ?? [];
                                    if (!$canManageClinical) $nextStatuses = array_values(array_intersect($nextStatuses, ['confirmed','rejected','cancelled']));
                                    $statusOptions = array_unique(array_merge([$appointment->status], $nextStatuses));
                                @endphp
                                <div class="form-group"><label for="apt-status-{{ $appointment->id }}">১. অ্যাপয়েন্টমেন্টের অবস্থা</label><select id="apt-status-{{ $appointment->id }}" name="status" class="form-control" required>@foreach($statusOptions as $status)<option value="{{ $status }}" @selected($appointment->status === $status)>{{ $statusLabels[$status] ?? ucfirst(str_replace('_',' ',$status)) }}</option>@endforeach</select><small class="form-text text-muted">অনুমোদিত = বুকিং নিশ্চিত; Waiting = রোগী সিরিয়ালে; চিকিৎসা চলছে = Doctor এখন রোগী দেখছেন; সম্পন্ন = ভিজিট শেষ। অনুমোদিত status transition-ই দেখানো হয়।</small></div>
                                @if($canManageClinical && $appointment->consultation_type === 'online')
                                    <div class="apt-online-fields"><div class="apt-subheading"><i class="fas fa-video"></i><strong>২. অনলাইন কনসালটেশন সেটিংস</strong></div>
                                        <div class="form-group"><label for="provider-{{ $appointment->id }}">মিটিং প্ল্যাটফর্ম</label><select id="provider-{{ $appointment->id }}" name="meeting_provider" class="form-control"><option value="">প্ল্যাটফর্ম নির্বাচন করুন</option>@foreach(['Google Meet','Zoom'] as $provider)<option value="{{ $provider }}" @selected($appointment->meeting_provider === $provider)>{{ $provider }}</option>@endforeach</select><small class="form-text text-muted">রোগীকে অনলাইনে দেখার জন্য কোন প্ল্যাটফর্ম ব্যবহার করবেন তা বাছুন।</small></div>
                                        <div class="form-group"><label for="meet-url-{{ $appointment->id }}">Meet / Zoom URL</label><input id="meet-url-{{ $appointment->id }}" class="form-control" name="meeting_url" type="url" placeholder="https://meet.google.com/..." value="{{ $appointment->meeting_url }}"><small class="form-text text-muted">সঠিক HTTPS লিংক দিন। রোগীর Join বাটন এই লিংকে নিয়ে যাবে।</small></div>
                                        <div class="row"><div class="form-group col-md-6"><label for="meet-id-{{ $appointment->id }}">Meeting ID (ঐচ্ছিক)</label><input id="meet-id-{{ $appointment->id }}" class="form-control" name="meeting_id" placeholder="Meeting ID" value="{{ $appointment->meeting_id }}"></div><div class="form-group col-md-6"><label for="meet-pass-{{ $appointment->id }}">Passcode (ঐচ্ছিক)</label><input id="meet-pass-{{ $appointment->id }}" class="form-control" name="meeting_passcode" placeholder="Passcode" value="{{ $appointment->meeting_passcode }}"></div></div>
                                        <div class="form-group"><label for="meet-instructions-{{ $appointment->id }}">রোগীর জন্য যোগদানের নির্দেশনা</label><textarea id="meet-instructions-{{ $appointment->id }}" class="form-control" name="meeting_instructions" rows="2" placeholder="যেমন: সময়ের ৫ মিনিট আগে যুক্ত হন">{{ $appointment->meeting_instructions }}</textarea></div>
                                        <div class="custom-control custom-checkbox mb-2"><input type="checkbox" class="custom-control-input" id="meeting_enabled_{{ $appointment->id }}" name="meeting_enabled" value="1" @checked($appointment->meeting_enabled)><label class="custom-control-label" for="meeting_enabled_{{ $appointment->id }}">সিরিয়াল ডাকলে রোগীকে Join করার অনুমতি দিন</label></div>
                                        <div class="apt-inline-help">এই সুইচ চালু করলে শুধু নিজে থেকে পেমেন্ট Paid হবে না। নির্ধারিত সময়, কিউ, অ্যাপয়েন্টমেন্টের অবস্থা ও পেমেন্ট-সংক্রান্ত নিয়মও প্রযোজ্য থাকবে।</div>
                                    </div>
                                @endif
                                <div class="form-group mt-3"><label for="apt-notes-{{ $appointment->id }}">{{ $canManageClinical ? '৩.' : '২.' }} অভ্যন্তরীণ নোট (রোগী দেখবে না)</label><textarea id="apt-notes-{{ $appointment->id }}" class="form-control" name="admin_notes" rows="2" placeholder="ক্লিনিকের staff-এর জন্য নোট">{{ $appointment->admin_notes }}</textarea></div>
                                <button class="btn btn-primary btn-block" type="submit" title="উপরের অবস্থা, মিটিং তথ্য ও নোট সংরক্ষণ করবে"><i class="fas fa-save mr-1"></i> পরিবর্তন সংরক্ষণ করুন</button>
                            </form>

                            @if($canManageClinical && $appointment->consultation_type === 'online' && in_array($appointment->status, ['confirmed','waiting','in_progress'], true))
                                <div class="apt-override-box">
                                    <div class="apt-panel-heading"><i class="fas fa-unlock-alt"></i><div><strong>Manual Join Access</strong><small>জরুরি পরিস্থিতিতে সাধারণ Join নিয়মের ব্যতিক্রম।</small></div></div>
                                    @if($appointment->meeting_manual_override)
                                        <span class="badge badge-warning">চালু</span><small class="d-block mt-2">চালু করেছেন: {{ $appointment->meetingOverrideBy->name ?? 'স্টাফ' }} · {{ $appointment->meeting_override_at?->format('d M Y, h:i A') }}@if($appointment->meeting_override_reason) · কারণ: {{ $appointment->meeting_override_reason }}@endif</small>
                                        <form method="POST" action="{{ route('admin.appointments.join-override', $appointment) }}" class="mt-2">@csrf<input type="hidden" name="enabled" value="0"><button type="submit" class="btn btn-outline-danger btn-sm" title="Manual override বন্ধ করে স্বাভাবিক সময়/পেমেন্ট/কিউ নিয়ম ফিরিয়ে দেবে"><i class="fas fa-lock mr-1"></i> Override বন্ধ করুন</button></form>
                                    @elseif($appointment->meeting_url)
                                        <form method="POST" action="{{ route('admin.appointments.join-override', $appointment) }}" class="mt-2">@csrf<input type="hidden" name="enabled" value="1"><label for="override_reason_{{ $appointment->id }}">কারণ লিখুন (অডিটের জন্য বাধ্যতামূলক)</label><input id="override_reason_{{ $appointment->id }}" type="text" name="reason" class="form-control form-control-sm mb-2" maxlength="1000" required placeholder="যেমন: জরুরি রোগী / পরিচিত রোগী"><button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('এতে সাধারণ সময়, পেমেন্ট ও কিউ চেক এড়িয়ে Join চালু হবে। চালু করবেন?')" title="জরুরি ক্ষেত্রে Join button খুলবে; payment status পরিবর্তন করবে না"><i class="fas fa-unlock mr-1"></i> জরুরিভাবে Join চালু করুন</button></form>
                                    @else
                                        <div class="small text-muted">প্রথমে উপরের ফর্মে Google Meet/Zoom URL দিয়ে সংরক্ষণ করুন, তারপর Override চালু করা যাবে।</div>
                                    @endif
                                    <small class="text-muted d-block mt-2">সতর্কতা: এটি অ্যাপয়েন্টমেন্টের সময়, পেমেন্ট ও queue gate bypass করে; ফি Paid বা waived করে না। শুধু জরুরি প্রয়োজনে ব্যবহার করুন।</small>
                                </div>
                            @endif
                            @if(in_array($appointment->status,['confirmed','waiting','completed','in_progress']))
                                @hasanyrole('Super Admin|Doctor')<a class="btn btn-success btn-block mt-3" href="{{ route('admin.prescriptions.create',$appointment) }}" title="এই অ্যাপয়েন্টমেন্টের রোগীর জন্য প্রেসক্রিপশন তৈরি বা আপলোড করুন"><i class="fas fa-file-prescription mr-1"></i> প্রেসক্রিপশন লিখুন / যোগ করুন</a>@endhasanyrole
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="apt-empty"><i class="far fa-calendar-times"></i><h4>কোনো অ্যাপয়েন্টমেন্ট পাওয়া যায়নি</h4><p>ফিল্টার পরিবর্তন করুন অথবা নতুন অ্যাপয়েন্টমেন্ট যোগ করুন।</p><a href="{{ route('admin.appointments.manual.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> নতুন অ্যাপয়েন্টমেন্ট</a></div>
            @endforelse
            <div class="apt-pagination mt-4">{{ $appointments->links() }}</div>
        </div>
    </section>
</div>
@endsection

@push('style')
<style>
.appointment-admin-page{--apt-primary:#075b8f;--apt-ink:#183447;--apt-muted:#697d8a;--apt-line:#e3ebf1;--apt-soft:#f5f9fc;color:var(--apt-ink)}
.appointment-admin-page .apt-page-header{align-items:flex-start;gap:18px;flex-wrap:wrap}.apt-page-header h1{font-weight:800;letter-spacing:-.4px}.apt-page-header p{font-size:13px;line-height:1.65;max-width:720px}.apt-guide,.apt-filter-card,.apt-card{border:1px solid var(--apt-line);border-radius:16px;box-shadow:0 8px 25px rgba(24,52,71,.045);overflow:hidden}.apt-guide{background:linear-gradient(135deg,#f6fbff,#fff)}.apt-guide-title{display:flex;align-items:center;gap:10px;margin-bottom:14px;font-size:15px}.apt-guide-title i{color:var(--apt-primary);font-size:20px}.apt-guide-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.apt-guide-grid>div{display:flex;align-items:flex-start;gap:9px;padding:12px;border:1px solid #e2edf5;border-radius:12px;background:#fff}.apt-guide-icon{width:32px;height:32px;flex:0 0 32px;display:grid;place-items:center;color:var(--apt-primary);border-radius:9px;background:#e8f4fb}.apt-guide-grid p{font-size:12px;line-height:1.55;margin:0;color:var(--apt-muted)}.apt-guide-grid p strong{font-size:13px;color:var(--apt-ink)}.apt-filter-form{display:grid;grid-template-columns:minmax(180px,1fr) minmax(180px,1fr) auto;gap:14px;align-items:end}.apt-filter-form .form-group{margin:0}.apt-filter-form label{font-size:12px;font-weight:700;color:var(--apt-muted)}.apt-filter-actions{display:flex;flex-wrap:wrap;gap:8px}.apt-filter-actions .btn{margin:0;min-height:38px}.apt-list-heading{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;margin:26px 0 14px}.apt-list-heading h3{font-size:18px;font-weight:800;margin:0}.apt-card{background:#fff;margin-bottom:18px}.apt-card-top{padding:18px 20px;display:flex;justify-content:space-between;align-items:center;gap:18px;background:linear-gradient(100deg,#f5faff,#fff);border-bottom:1px solid var(--apt-line)}.apt-ref-label{font-size:10px;text-transform:uppercase;letter-spacing:.8px;color:var(--apt-muted);font-weight:800}.apt-card-top h4{font-size:17px;font-weight:800;margin:2px 0 7px;overflow-wrap:anywhere}.apt-badges{display:flex;flex-wrap:wrap;gap:6px}.apt-badges .badge{padding:6px 8px;border-radius:30px;font-size:10px}.apt-date-chip{display:flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--apt-line);border-radius:12px;padding:10px 13px;flex-shrink:0}.apt-date-chip>i{font-size:20px;color:var(--apt-primary)}.apt-date-chip span{font-size:12px;font-weight:800}.apt-date-chip small{display:block;font-weight:500;color:var(--apt-muted);margin-top:3px}.apt-card-body{display:grid;grid-template-columns:minmax(0,.92fr) minmax(0,1.08fr);gap:0}.apt-summary-panel{padding:20px;border-right:1px solid var(--apt-line);min-width:0}.apt-management-panel{padding:20px;min-width:0;background:#fcfdfe}.apt-patient-name{display:flex;align-items:center;gap:11px;margin-bottom:18px}.apt-avatar{width:43px;height:43px;border-radius:13px;background:#e5f3fb;color:var(--apt-primary);display:grid;place-items:center;font-size:17px;flex:0 0 43px}.apt-patient-name strong{display:block;font-size:15px;overflow-wrap:anywhere}.apt-patient-name small{display:block;font-size:11px;color:var(--apt-muted);overflow-wrap:anywhere}.apt-detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.apt-detail-grid>div{padding:11px;background:var(--apt-soft);border:1px solid #e9f0f5;border-radius:10px;min-width:0}.apt-detail-grid small{display:block;color:var(--apt-muted);font-size:10px;margin-bottom:5px}.apt-detail-grid strong{display:block;font-size:12px;overflow-wrap:anywhere}.apt-reason{margin-top:12px;font-size:12px;border-left:3px solid #bcd9ea;padding-left:10px}.apt-reason small{font-size:10px;color:var(--apt-muted)}.apt-reason p{margin:4px 0 0;white-space:pre-line;overflow-wrap:anywhere}.apt-payment-review{margin-top:18px;padding:14px;border:1px solid #f3dfac;background:#fffaf0;border-radius:12px}.apt-payment-title{display:flex;align-items:center;flex-wrap:wrap;gap:7px;font-size:13px}.apt-payment-title i{color:#9b6b00}.apt-payment-title .badge{margin-left:auto}.apt-payment-meta{display:flex;flex-direction:column;gap:5px;font-size:11px;margin-top:10px}.apt-payment-review-form{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:12px}.apt-payment-review-form input{grid-column:1/-1}.apt-payment-review-form .btn{font-size:11px}.apt-payment-done{margin-top:15px;padding:10px 12px;background:#eefaf2;border:1px solid #c5e9d0;border-radius:10px;color:#19743b;font-size:12px}.apt-more-payments{display:inline-block;margin-top:12px;font-size:11px;color:var(--apt-primary);font-weight:700}.apt-panel-heading{display:flex;gap:10px;align-items:flex-start;margin-bottom:16px}.apt-panel-heading>i{width:32px;height:32px;display:grid;place-items:center;color:var(--apt-primary);background:#e9f5fc;border-radius:9px;flex-shrink:0}.apt-panel-heading strong{display:block;font-size:14px}.apt-panel-heading small{display:block;color:var(--apt-muted);font-size:11px;margin-top:3px}.apt-management-panel label{font-size:11px;font-weight:800}.apt-management-panel .form-control{font-size:12px;border-color:#dce6ee;border-radius:9px;min-height:38px}.apt-management-panel textarea.form-control{min-height:66px}.apt-management-panel .form-group{margin-bottom:13px}.apt-management-panel .form-text,.apt-inline-help{font-size:10px;line-height:1.5}.apt-online-fields{margin-top:14px;padding:14px;background:#f5faff;border:1px solid #dfedf8;border-radius:12px}.apt-subheading{display:flex;gap:8px;align-items:center;margin-bottom:14px;color:var(--apt-primary);font-size:12px}.apt-inline-help{padding:9px;border-radius:8px;background:#fff;border:1px solid #dfeaf2;color:var(--apt-muted)}.apt-override-box{margin-top:18px;padding:14px;border:1px dashed #e4c66d;background:#fffdf5;border-radius:12px}.apt-override-box .apt-panel-heading{margin-bottom:10px}.apt-override-box label{display:block}.apt-override-box .btn{white-space:normal}.apt-empty{text-align:center;background:#fff;border:1px dashed #cad9e5;border-radius:16px;padding:55px 20px}.apt-empty>i{font-size:38px;color:#9cb2c2}.apt-empty h4{margin-top:14px;font-weight:800}.apt-empty p{color:var(--apt-muted);font-size:13px}.apt-pagination{overflow-x:auto}.apt-pagination nav{display:flex;justify-content:center}
@media(max-width:1199px){.apt-guide-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.apt-card-body{grid-template-columns:minmax(0,.86fr) minmax(0,1.14fr)}}
@media(max-width:767px){.apt-page-header{display:block}.apt-page-header .section-header-button{margin-top:14px}.apt-page-header .btn{width:100%;white-space:normal}.apt-guide-grid{grid-template-columns:1fr 1fr}.apt-filter-form{grid-template-columns:1fr}.apt-filter-actions .btn{flex:1}.apt-card-top{align-items:flex-start;flex-direction:column;padding:15px}.apt-date-chip{width:100%}.apt-card-body{grid-template-columns:1fr}.apt-summary-panel{border-right:0;border-bottom:1px solid var(--apt-line);padding:16px}.apt-management-panel{padding:16px}.apt-payment-review-form{grid-template-columns:1fr}.apt-payment-review-form input{grid-column:auto}.apt-detail-grid{gap:7px}.apt-detail-grid>div{padding:9px}.apt-guide-grid>div{padding:9px;gap:7px}}
@media(max-width:420px){.apt-guide-grid{grid-template-columns:1fr}.apt-payment-review-form .btn{width:100%;white-space:normal}.apt-detail-grid strong{font-size:11px}.apt-list-heading{align-items:flex-start;flex-direction:column}}
</style>
@endpush
