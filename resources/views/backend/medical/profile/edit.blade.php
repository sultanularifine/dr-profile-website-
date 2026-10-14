@extends('backend.layouts.app')

@section('title', 'Doctor Profile')

@push('style')
<style>
    .profile-editor .form-section-title { margin: 0 0 1rem; font-size: 1rem; font-weight: 700; color: #34395e; }
    .profile-editor .form-hint { color: #98a6ad; font-size: 12px; }
    .profile-editor .profile-preview { max-width: 220px; max-height: 160px; border: 1px solid #e4e6fc; border-radius: 8px; padding: 4px; background: #fff; object-fit: contain; }
</style>
@endpush

@section('main')
<div class="main-content profile-editor">
    <section class="section">
        <div class="section-header">
            <h1>Doctor Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active">Doctor Profile</div>
            </div>
        </div>
        <div class="section-body">
            <p class="section-lead">Manage the doctor information shown across the website. Existing public pages and their design remain unchanged.</p>

            @if(session('success'))<div class="alert alert-success alert-dismissible show fade"><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>{{ session('success') }}</div></div>@endif
            @if($errors->any())<div class="alert alert-danger"><strong>Please correct the following:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <form method="POST" action="{{ route('admin.doctor-profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card">
                    <div class="card-header"><h4>Professional Information</h4></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4"><label for="doctor_id">Doctor ID</label><input id="doctor_id" name="doctor_id" class="form-control" maxlength="100" value="{{ old('doctor_id', $profile->doctor_id) }}"></div>
                            <div class="form-group col-md-5"><label for="full_name">Full name <span class="text-danger">*</span></label><input id="full_name" name="full_name" class="form-control" required maxlength="255" value="{{ old('full_name', $profile->full_name) }}">@error('full_name')<small class="text-danger">{{ $message }}</small>@enderror</div>
                            <div class="form-group col-md-6"><label for="professional_title">Professional title</label><input id="professional_title" name="professional_title" class="form-control" value="{{ old('professional_title', $profile->professional_title) }}" maxlength="255"></div>
                            <div class="form-group col-md-3"><label for="gender">Gender</label><select id="gender" name="gender" class="form-control"><option value="">Select if needed</option>@foreach(['Male','Female','Other'] as $gender)<option value="{{ $gender }}" @selected(old('gender', $profile->gender) === $gender)>{{ $gender }}</option>@endforeach</select></div>
                            <div class="form-group col-md-6"><label for="bmdc_registration">BMDC registration number</label><input id="bmdc_registration" name="bmdc_registration" class="form-control" value="{{ old('bmdc_registration', $profile->bmdc_registration) }}" maxlength="100"><small class="form-hint">Enter only the doctor's actual registration information.</small></div>
                            <div class="form-group col-md-3"><label for="years_experience">Years of experience</label><input id="years_experience" type="number" min="0" max="100" name="years_experience" class="form-control" value="{{ old('years_experience', $profile->years_experience) }}"></div>
                            <div class="form-group col-md-3"><label for="phone">Public phone</label><input id="phone" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" maxlength="50"></div>
                            <div class="form-group col-md-6"><label for="public_email">Public email</label><input id="public_email" type="email" name="public_email" class="form-control" value="{{ old('public_email', $profile->public_email) }}" maxlength="255"></div>
                            <div class="form-group col-12"><label for="biography">Biography</label><textarea id="biography" name="biography" rows="5" maxlength="20000" class="form-control">{{ old('biography', $profile->biography) }}</textarea><small class="form-hint">Use plain text; existing frontend styling handles the display.</small></div>
                            <div class="form-group col-md-6"><label for="qualifications_text">Qualifications (one per line)</label><textarea id="qualifications_text" name="qualifications_text" rows="4" class="form-control">{{ old('qualifications_text', implode("\n", $profile->qualifications ?? [])) }}</textarea></div>
                            <div class="form-group col-md-6"><label for="specializations_text">Specializations (one per line)</label><textarea id="specializations_text" name="specializations_text" rows="4" class="form-control">{{ old('specializations_text', implode("\n", $profile->specializations ?? [])) }}</textarea></div>
                            <div class="form-group col-md-6"><label for="memberships_text">Professional memberships (one per line)</label><textarea id="memberships_text" name="memberships_text" rows="3" class="form-control">{{ old('memberships_text', implode("\n", $profile->professional_memberships ?? [])) }}</textarea></div>
                            <div class="form-group col-md-6"><label for="awards_text">Awards & achievements (one per line)</label><textarea id="awards_text" name="awards_text" rows="3" class="form-control">{{ old('awards_text', implode("\n", $profile->awards ?? [])) }}</textarea></div>
                            <div class="form-group col-md-6"><label for="publications_text">Publications (one per line)</label><textarea id="publications_text" name="publications_text" rows="3" class="form-control">{{ old('publications_text', implode("\n", $profile->publications ?? [])) }}</textarea></div>
                            <div class="form-group col-md-6"><label for="languages_text">Languages spoken (one per line)</label><textarea id="languages_text" name="languages_text" rows="3" class="form-control">{{ old('languages_text', implode("\n", $profile->languages ?? [])) }}</textarea></div>
                            <div class="form-group col-md-6"><label for="services_text">Services offered (one per line)</label><textarea id="services_text" name="services_text" rows="3" class="form-control">{{ old('services_text', implode("\n", $profile->services ?? [])) }}</textarea></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h4>Profile Images</h4></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="profile_photo">Profile photo</label>
                                @if($profile->profile_photo)
                                    <div class="mb-2"><img id="profile-photo-current" class="profile-preview" src="{{ str_starts_with($profile->profile_photo, 'doctor/') ? asset('storage/'.$profile->profile_photo) : asset($profile->profile_photo) }}" alt="Current doctor profile photo"></div>
                                @endif
                                <input id="profile_photo" type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" class="form-control-file">
                                <img id="profile-photo-new-preview" class="profile-preview mt-2" alt="New profile photo preview" style="display:none">
                                <small class="form-hint d-block">JPG, PNG or WebP; maximum 5 MB.</small>
                                @error('profile_photo')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cover_image">Cover image</label>
                                @if($profile->cover_image)
                                    <div class="mb-2"><img id="cover-image-current" class="profile-preview" src="{{ str_starts_with($profile->cover_image, 'doctor/') ? asset('storage/'.$profile->cover_image) : asset($profile->cover_image) }}" alt="Current doctor cover image"></div>
                                @endif
                                <input id="cover_image" type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" class="form-control-file">
                                <img id="cover-image-new-preview" class="profile-preview mt-2" alt="New cover image preview" style="display:none">
                                <small class="form-hint d-block">JPG, PNG or WebP; maximum 8 MB.</small>
                                @error('cover_image')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="custom-control custom-switch mt-2 mb-3">
                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $profile->is_featured))>
                            <label class="custom-control-label" for="is_featured">Mark as featured profile</label>
                        </div>
                        <p class="text-muted small">Verification: {{ ucfirst(str_replace('_', ' ', $profile->verification_status ?? 'unverified')) }}. This status can only be changed through an authorized verification process.</p>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="is_visible" name="is_visible" value="1" @checked(old('is_visible', $profile->exists ? $profile->is_visible : true))>
                            <label class="custom-control-label" for="is_visible">Show doctor profile on the website</label>
                        </div>
                    </div>
                    <div class="card-footer text-right"><button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Profile</button></div>
                </div>
            </form>
        </div>
    </section>
</div>
@push('scripts')
<script>
(function () {
    [['profile_photo', 'profile-photo-new-preview'], ['cover_image', 'cover-image-new-preview']].forEach(function (pair) {
        const input = document.getElementById(pair[0]);
        const preview = document.getElementById(pair[1]);
        if (!input || !preview) return;
        input.addEventListener('change', function () {
            const file = input.files && input.files[0];
            if (!file) { preview.style.display = 'none'; preview.removeAttribute('src'); return; }
            preview.src = URL.createObjectURL(file);
            preview.style.display = '';
        });
    });
})();
</script>
@endpush
@endsection
