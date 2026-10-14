<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class DoctorProfileController extends Controller
{
    private function authorizeMedicalStaff(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['Super Admin', 'Doctor']), 403);
    }

    public function edit()
    {
        $this->authorizeMedicalStaff();
        $profile = DoctorProfile::query()->first() ?? new DoctorProfile();

        return view('backend.medical.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $this->authorizeMedicalStaff();

        $data = $request->validate([
            'doctor_id' => ['nullable', 'string', 'max:100'],
            'full_name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:50'],
            'professional_title' => ['nullable', 'string', 'max:255'],
            'bmdc_registration' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'public_email' => ['nullable', 'email', 'max:255'],
            'biography' => ['nullable', 'string', 'max:20000'],
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:100'],
            'qualifications_text' => ['nullable', 'string', 'max:10000'],
            'specializations_text' => ['nullable', 'string', 'max:10000'],
            'memberships_text' => ['nullable', 'string', 'max:10000'],
            'awards_text' => ['nullable', 'string', 'max:10000'],
            'publications_text' => ['nullable', 'string', 'max:10000'],
            'languages_text' => ['nullable', 'string', 'max:10000'],
            'services_text' => ['nullable', 'string', 'max:10000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        $profile = DoctorProfile::query()->first() ?? new DoctorProfile();
        $profile->user_id = $profile->user_id ?: auth()->id();
        $profile->doctor_id = $data['doctor_id'] ?? null;
        $profile->full_name = $data['full_name'];
        $profile->gender = $data['gender'] ?? null;
        $profile->professional_title = $data['professional_title'] ?? null;
        $profile->bmdc_registration = $data['bmdc_registration'] ?? null;
        $profile->phone = $data['phone'] ?? null;
        $profile->public_email = $data['public_email'] ?? null;
        $profile->biography = $data['biography'] ?? null;
        $profile->years_experience = $data['years_experience'] ?? null;
        $profile->qualifications = $this->linesToArray($data['qualifications_text'] ?? '');
        $profile->specializations = $this->linesToArray($data['specializations_text'] ?? '');
        $profile->professional_memberships = $this->linesToArray($data['memberships_text'] ?? '');
        $profile->awards = $this->linesToArray($data['awards_text'] ?? '');
        $profile->publications = $this->linesToArray($data['publications_text'] ?? '');
        $profile->languages = $this->linesToArray($data['languages_text'] ?? '');
        $profile->services = $this->linesToArray($data['services_text'] ?? '');
        $profile->is_featured = $request->boolean('is_featured');
        $profile->is_visible = $request->boolean('is_visible');

        foreach (['profile_photo' => 'doctor/profile', 'cover_image' => 'doctor/cover'] as $field => $directory) {
            if (!$request->hasFile($field)) {
                continue;
            }

            $oldPath = $profile->{$field};
            $newPath = $request->file($field)->store($directory, 'public');
            if (!$newPath || !Storage::disk('public')->exists($newPath)) {
                throw ValidationException::withMessages([
                    $field => 'The image could not be saved. Check that storage/app/public is writable and run php artisan storage:link.',
                ]);
            }
            $profile->{$field} = $newPath;

            // Delete only files managed by this module; preserve old paths from the original site.
            if ($oldPath && str_starts_with($oldPath, 'doctor/') && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $profile->save();

        // Sync the primary public profile fields to existing homepage bindings.
        // Null values restore the original Blade fallback instead of rendering blank content.
        $homeOverrides = [
            'home.2' => $profile->full_name ? $profile->full_name . ' — ' : null,
            'home.3' => $profile->professional_title ?: null,
            'home.4' => $profile->biography ?: null,
            'home.doctor_image' => $profile->profile_photo ? 'storage/' . $profile->profile_photo : null,
            'home.doctor_image_alt' => $profile->full_name ?: null,
        ];
        foreach ($homeOverrides as $key => $value) {
            PageContent::updateOrCreate(
                ['content_key' => $key],
                ['page' => 'home', 'value' => $value]
            );
        }
        Cache::forget('page_content_overrides');

        return redirect()->route('admin.doctor-profile.edit')->with('success', 'Doctor profile and the linked homepage fields updated successfully.');
    }

    private function linesToArray(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $value) ?: [])
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
