@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Overview</div>
            </div>
        </div>

        <div class="section-body">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
                <div>
                    <h2 class="section-title ">Welcome, {{ auth()->user()->name }}</h2>
                    <p class="section-lead mb-0">Your clinic and website overview. Statistics below are calculated from saved records.</p>
                </div>
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-outline-primary mt-3 mt-md-0">
                    <i class="fas fa-external-link-alt mr-1"></i> Open Website
                </a>
            </div>

            @if(!empty($medicalTablesReady) && !$medicalTablesReady)
                <div class="alert alert-warning alert-has-icon">
                    <div class="alert-icon"><i class="fas fa-database"></i></div>
                    <div class="alert-body"><div class="alert-title">Setup required</div>Run the database migrations to enable appointment and prescription statistics.</div>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible show fade"><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>{{ session('success') }}</div></div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger"><strong>Please correct the form fields.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <div class="row">
                @php
                    $statCards = [
                        ['title' => 'Total Appointments', 'value' => $stats['appointments_total'] ?? 0, 'icon' => 'fa-calendar-check', 'color' => 'bg-primary', 'hint' => 'All recorded appointments'],
                        ['title' => "Today's Appointments", 'value' => $stats['appointments_today'] ?? 0, 'icon' => 'fa-calendar-day', 'color' => 'bg-info', 'hint' => 'Scheduled for today'],
                        ['title' => 'Pending Requests', 'value' => $stats['appointments_pending'] ?? 0, 'icon' => 'fa-clock', 'color' => 'bg-warning', 'hint' => 'Need review'],
                        ['title' => 'Registered Patients', 'value' => $stats['patients'] ?? 0, 'icon' => 'fa-user-injured', 'color' => 'bg-success', 'hint' => 'Known patient accounts'],
                        ['title' => 'Published Prescriptions', 'value' => $stats['prescriptions_published'] ?? 0, 'icon' => 'fa-file-medical', 'color' => 'bg-success', 'hint' => 'Available to patients'],
                        ['title' => 'Draft Prescriptions', 'value' => $stats['prescriptions_draft'] ?? 0, 'icon' => 'fa-file-alt', 'color' => 'bg-secondary', 'hint' => 'Not yet published'],
                        ['title' => 'Unpaid Appointments', 'value' => $stats['payments_pending'] ?? 0, 'icon' => 'fa-wallet', 'color' => 'bg-danger', 'hint' => 'Unpaid or awaiting payment'],
                        ['title' => 'Payments Awaiting Review', 'value' => $stats['payment_submissions_pending'] ?? 0, 'icon' => 'fa-receipt', 'color' => 'bg-warning', 'hint' => 'Manual payment submissions to verify'],
                        ['title' => 'Recorded Revenue', 'value' => (($currencyCode ?? 'BDT') === 'BDT' ? '৳' : ($currencyCode ?? 'BDT') . ' ') . number_format((float)($stats['revenue_paid'] ?? 0), 2), 'icon' => 'fa-coins', 'color' => 'bg-dark', 'hint' => 'Appointments marked paid'],
                    ];
                @endphp
                @foreach($statCards as $card)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon {{ $card['color'] }}"><i class="fas {{ $card['icon'] }}"></i></div>
                            <div class="card-wrap">
                                <div class="card-header"><h4>{{ $card['title'] }}</h4></div>
                                <div class="card-body">{{ $card['value'] }}</div>
                                <div class="px-3 pb-3 text-muted small">{{ $card['hint'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-3">
                <div class="col-12"><h2 class="section-title">Quick actions</h2></div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="{{ route('admin.appointments.index') }}" class="card card-link h-100"><div class="card-body d-flex align-items-center"><div class="mr-3 text-primary"><i class="fas fa-calendar-check fa-2x"></i></div><div><h6 class="mb-1">Manage Appointments</h6><small class="text-muted">Review requests and meeting links</small></div></div></a>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="{{ route('admin.chambers.index') }}" class="card card-link h-100"><div class="card-body d-flex align-items-center"><div class="mr-3 text-success"><i class="fas fa-hospital fa-2x"></i></div><div><h6 class="mb-1">Chambers & Schedule</h6><small class="text-muted">Manage locations and time slots</small></div></div></a>
                </div>
                @hasanyrole('Super Admin|Doctor|Admin')
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="card card-link h-100"><div class="card-body d-flex align-items-center"><div class="mr-3 text-danger"><i class="fas fa-receipt fa-2x"></i></div><div><h6 class="mb-1">Payment Management</h6><small class="text-muted">Review patient payment submissions</small></div></div></a>
                </div>
                @endhasanyrole
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="{{ route('admin.doctor-profile.edit') }}" class="card card-link h-100"><div class="card-body d-flex align-items-center"><div class="mr-3 text-info"><i class="fas fa-user-md fa-2x"></i></div><div><h6 class="mb-1">Doctor Profile</h6><small class="text-muted">Update credentials and images</small></div></div></a>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="{{ route('admin.pages.edit', 'home') }}" class="card card-link h-100"><div class="card-body d-flex align-items-center"><div class="mr-3 text-warning"><i class="fas fa-edit fa-2x"></i></div><div><h6 class="mb-1">Edit Website Pages</h6><small class="text-muted">Change text and supported images</small></div></div></a>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h4>Upcoming appointments</h4><div class="card-header-action"><a href="{{ route('admin.appointments.index') }}" class="btn btn-primary btn-sm">View all</a></div></div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-striped mb-0">
                                <thead><tr><th>Patient</th><th>Date & time</th><th>Chamber</th><th>Status</th></tr></thead>
                                <tbody>
                                @forelse($upcomingAppointments as $appointment)
                                    <tr>
                                        <td><strong>{{ $appointment->patient->name ?? 'Patient unavailable' }}</strong><br><small class="text-muted">{{ $appointment->appointment_code }}</small></td>
                                        <td>{{ $appointment->scheduled_at?->format('d M Y') }}<br><small>{{ $appointment->scheduled_at?->format('h:i A') }}</small></td>
                                        <td>{{ $appointment->chamber->name ?? ($appointment->consultation_type === 'online' ? 'Online consultation' : 'Not assigned') }}</td>
                                        <td><span class="badge badge-{{ ['pending'=>'warning','confirmed'=>'primary','waiting'=>'info','in_progress'=>'info','completed'=>'success','cancelled'=>'secondary','rejected'=>'danger','no_show'=>'dark'][$appointment->status] ?? 'secondary' }}">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No upcoming appointments are recorded.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><h4>Recent appointments</h4></div>
                        <div class="card-body">
                            @forelse($recentAppointments as $appointment)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="mr-3 mt-1 text-primary"><i class="fas fa-calendar-alt"></i></div>
                                    <div class="flex-grow-1"><strong>{{ $appointment->patient->name ?? 'Patient unavailable' }}</strong><div class="small text-muted">{{ $appointment->appointment_code }} · {{ $appointment->created_at?->format('d M Y') }}</div><div class="small">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</div></div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">New appointments will appear here.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <div class="card" id="list1">
                        <div class="card-header"><h4>My task list</h4></div>
                        <div class="card-body">
                            <form action="{{ route('todo.store') }}" method="POST" class="mb-4">
                                @csrf
                                <div class="form-row align-items-end">
                                    <div class="form-group col-md-5"><label for="task_name">Task</label><input id="task_name" type="text" name="name" class="form-control" placeholder="e.g. Call patient" maxlength="255" required></div>
                                    <div class="form-group col-md-2"><label for="task_time">Time</label><input id="task_time" type="time" name="time" class="form-control" required></div>
                                    <div class="form-group col-md-3"><label for="task_date">Date</label><input id="task_date" type="date" name="date" class="form-control" required></div>
                                    <div class="form-group col-md-2"><button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus mr-1"></i>Add task</button></div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead><tr><th>Task</th><th>Date</th><th>Time</th><th class="text-right">Actions</th></tr></thead>
                                    <tbody>
                                    @forelse($data as $task)
                                        <tr>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->date ? \Carbon\Carbon::parse($task->date)->format('d M Y') : '—' }}</td>
                                            <td>{{ $task->time ? \Carbon\Carbon::parse($task->time)->format('h:i A') : '—' }}</td>
                                            <td class="text-right text-nowrap">
                                                <a href="{{ route('todo.edit', $task->id) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit task"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('todo.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this task?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Delete task"><i class="fas fa-trash"></i></button></form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted py-3">No tasks yet. Add a task above to get started.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('style')
<style>
    .card-link { color: inherit; transition: box-shadow .15s ease, transform .15s ease; }
    .card-link:hover { color: inherit; text-decoration: none; transform: translateY(-2px); box-shadow: 0 4px 14px rgba(0,0,0,.08); }
</style>
@endpush
