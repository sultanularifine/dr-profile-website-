@extends('backend.layouts.app')
@section('title', 'Profile')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
            </div>

            <div class="card card-primary">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="{{ !$user->avatar ? asset('backend/images/default-avatar.png') : (str_starts_with($user->avatar, 'avatars/') ? asset('storage/'.$user->avatar) : (str_starts_with($user->avatar, 'uploads/') ? asset($user->avatar) : asset('uploads/avatars/'.$user->avatar))) }}"
                                alt="Avatar" class="img-fluid rounded-circle mb-2" style="width:150px;height:150px;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ $user->roles->pluck('name')->join(', ') ?? 'N/A' }}</td>
                                </tr>
                            </table>

                            <a href="{{ route('settings.index') }}" class="btn btn-primary mt-3">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
