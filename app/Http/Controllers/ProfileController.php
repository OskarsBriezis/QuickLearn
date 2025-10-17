<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('user.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */

public function update(Request $request): RedirectResponse
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'password' => 'nullable|string|min:8|confirmed', // ✅ Add this
    ]);

    // Update basic fields
    $user->name = $request->name;
    $user->email = $request->email;

    // ✅ Update password only if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // ✅ Handle profile picture upload (as before)
    if ($request->hasFile('profile_picture')) {
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $image = $request->file('profile_picture');
        $manager = new ImageManager(new Driver());
        $imageObject = $manager->read($image);
        $resized = $imageObject->scale(width: 300, height: 300)->toJpeg(quality: 90);

        $filename = 'profile_pictures/' . uniqid() . '.jpg';
        Storage::disk('public')->put($filename, $resized);
        $user->profile_picture = $filename;
    }

    $user->save();

    return redirect()->route('user.profile.edit')->with('success', 'Profile updated successfully.');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->profile_picture && Storage::exists($user->profile_picture)) {
            Storage::delete($user->profile_picture);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}