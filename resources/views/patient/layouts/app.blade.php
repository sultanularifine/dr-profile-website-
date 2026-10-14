<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'রোগী ড্যাশবোর্ড') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('backend/library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/components.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--patient-ink:#183548;--patient-muted:#687f8d;--patient-primary:#0874a8;--patient-primary-dark:#075b8f;--patient-bg:#f3f8fb;--patient-border:#e1ebf1;--patient-white:#fff}
        *{box-sizing:border-box}body{margin:0;background:var(--patient-bg);color:var(--patient-ink);font-family:'Hind Siliguri',system-ui,sans-serif;line-height:1.55}
        .patient-shell{width:min(1320px,100%);margin:0 auto;padding:22px 22px 50px}.patient-top{position:relative;display:flex;justify-content:space-between;align-items:center;gap:16px;background:#fff;border:1px solid var(--patient-border);box-shadow:0 8px 30px rgba(15,65,91,.055);border-radius:18px;padding:14px 18px;margin-bottom:24px;z-index:50}
        .patient-brand{display:flex;align-items:center;gap:11px;min-width:0;text-decoration:none;color:inherit}.patient-brand-icon{display:grid;place-items:center;width:42px;height:42px;border-radius:13px;background:linear-gradient(135deg,#0874a8,#1aa4be);color:#fff;font-size:17px;flex-shrink:0}.patient-brand-name{font-weight:800;font-size:15px;line-height:1.25}.patient-brand-name small{display:block;color:var(--patient-muted);font-size:11px;font-weight:500;margin-top:3px}.patient-nav{display:flex;align-items:center;gap:6px;flex-wrap:wrap}.patient-nav>a{padding:9px 11px;border-radius:10px;text-decoration:none;color:#4c6574;font-size:12px;font-weight:700;white-space:nowrap}.patient-nav>a:hover,.patient-nav>a.active{background:#eaf5fb;color:var(--patient-primary-dark)}.patient-user{display:flex;align-items:center;gap:10px;padding-left:11px;border-left:1px solid var(--patient-border)}.patient-user .user-name{font-size:12px;font-weight:700;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.patient-user form{margin:0}.patient-user .btn{border-radius:9px;font-size:11px;white-space:nowrap}.patient-mobile-toggle{display:none;border:1px solid var(--patient-border);background:#fff;color:var(--patient-primary-dark);border-radius:10px;width:42px;height:42px}
        .patient-shell .main-content{margin-left:0!important;padding:0!important}.patient-shell .section{margin:0;padding:0}.patient-shell .section-header{box-shadow:none;border:0;padding:0;margin-bottom:18px;min-height:auto}.patient-shell .section-header h1{font-size:clamp(23px,3vw,32px);font-weight:800;color:var(--patient-ink);margin:0}.patient-shell .section-body{padding:0}.patient-shell .card{border:1px solid var(--patient-border);border-radius:16px;box-shadow:0 8px 28px rgba(16,65,90,.045);overflow:hidden;margin-bottom:18px}.patient-shell .card-header{background:#fff;border-bottom:1px solid var(--patient-border);padding:17px 20px}.patient-shell .card-header h4,.patient-shell .card-header h5{font-size:16px;font-weight:800;color:var(--patient-ink);margin:0}.patient-shell .card-body{padding:20px}.patient-shell .table{color:var(--patient-ink);margin:0}.patient-shell .table th{font-size:11px;color:var(--patient-muted);text-transform:uppercase;letter-spacing:.25px;border-top:0;border-bottom:1px solid var(--patient-border);white-space:nowrap}.patient-shell .table td{font-size:12px;vertical-align:middle;border-top:1px solid #edf2f6}.patient-shell .btn{border-radius:9px;font-weight:700}.patient-shell .alert{border-radius:12px;font-size:13px}.patient-footer-note{font-size:11px;color:var(--patient-muted);text-align:center;padding-top:10px}
        @media(max-width:1020px){.patient-shell{padding:16px}.patient-top{align-items:flex-start;flex-wrap:wrap}.patient-nav{flex:1 1 100%;order:3;padding-top:10px;border-top:1px solid var(--patient-border);display:none}.patient-top.nav-open .patient-nav{display:flex}.patient-mobile-toggle{display:block;margin-left:auto}.patient-user{border-left:0;padding-left:0;margin-left:auto}.patient-nav>a{flex:1 1 auto;text-align:center;background:#f7fafc}.patient-shell .table-responsive{border-radius:10px}}
        @media(max-width:575px){.patient-shell{padding:10px 10px 32px}.patient-top{padding:12px;border-radius:14px;margin-bottom:17px;gap:9px}.patient-brand-icon{width:38px;height:38px}.patient-brand-name{font-size:13px}.patient-brand-name small{font-size:10px}.patient-user{width:100%;order:4;justify-content:space-between;border-top:1px solid var(--patient-border);padding-top:9px}.patient-top.nav-open .patient-nav{display:grid;grid-template-columns:1fr 1fr;gap:5px}.patient-nav>a{white-space:normal;display:flex;justify-content:center;align-items:center;padding:10px 7px}.patient-shell .section-header{display:block}.patient-shell .card-body{padding:13px}.patient-shell .card-header{padding:14px}.patient-shell .table th,.patient-shell .table td{font-size:11px;padding:9px}.patient-shell .btn-block{white-space:normal}.patient-shell .pagination{flex-wrap:wrap;justify-content:center}.patient-shell .pagination .page-link{padding:.35rem .55rem}}
    </style>
    @stack('styles')
</head>
<body>
<div class="patient-shell">
    <header class="patient-top" id="patientTop">
        <a class="patient-brand" href="{{ route('patient.dashboard') }}"><span class="patient-brand-icon"><i class="fas fa-heartbeat"></i></span><span class="patient-brand-name">{{ config('app.name') }}<small>রোগী সেবা পোর্টাল</small></span></a>
        <button type="button" class="patient-mobile-toggle" id="patientMenuToggle" aria-expanded="false" aria-controls="patientNav" aria-label="মেনু খুলুন"><i class="fas fa-bars"></i></button>
        <nav class="patient-nav" id="patientNav" aria-label="রোগী মেনু">
            <a href="{{ route('patient.dashboard') }}" class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large mr-1"></i> ড্যাশবোর্ড</a>
            <a href="{{ route('patient.appointments.create') }}" class="{{ request()->routeIs('patient.appointments.create') ? 'active' : '' }}"><i class="far fa-calendar-plus mr-1"></i> অ্যাপয়েন্টমেন্ট</a>
            <a href="{{ route('patient.dashboard') }}#my-prescriptions"><i class="fas fa-file-prescription mr-1"></i> প্রেসক্রিপশন</a>
            <a href="{{ route('patient.documents.index') }}" class="{{ request()->routeIs('patient.documents.*') ? 'active' : '' }}"><i class="fas fa-camera mr-1"></i> রিপোর্ট / ছবি</a>
            <a href="{{ route('patient.payments.index') }}" class="{{ request()->routeIs('patient.payments.*') ? 'active' : '' }}"><i class="fas fa-wallet mr-1"></i> পেমেন্ট</a>
        </nav>
        <div class="patient-user"><span class="user-name"><i class="fas fa-user-circle mr-1 text-info"></i>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-secondary" type="submit"><i class="fas fa-sign-out-alt mr-1"></i> লগআউট</button></form></div>
    </header>
    @yield('main')
    <div class="patient-footer-note">আপনার মেডিকেল তথ্য ব্যক্তিগতভাবে সংরক্ষিত রাখুন। জরুরি অবস্থায় নিকটস্থ হাসপাতালের সাহায্য নিন।</div>
</div>
<script src="{{ asset('backend/library/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('backend/library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script>
(function(){var top=document.getElementById('patientTop'),toggle=document.getElementById('patientMenuToggle');if(toggle&&top){toggle.addEventListener('click',function(){var open=top.classList.toggle('nav-open');toggle.setAttribute('aria-expanded',open?'true':'false');toggle.innerHTML=open?'<i class="fas fa-times"></i>':'<i class="fas fa-bars"></i>';});}})();
</script>
@stack('scripts')
</body>
</html>
