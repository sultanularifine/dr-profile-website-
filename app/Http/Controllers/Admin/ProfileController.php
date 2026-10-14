<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('backend.profile.show', compact('user'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('backend.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($request->hasFile('avatar')) {
            $oldAvatar = $user->avatar;
            $user->avatar = $request->file('avatar')->store('avatars', 'public');

            // Only remove avatar files stored by this profile module.
            if ($oldAvatar && str_starts_with($oldAvatar, 'avatars/') && Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
