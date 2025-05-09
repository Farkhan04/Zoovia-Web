<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile; // relasi ke user_profiles

        return view('admin.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);
 
        $user = Auth::user();

        // Update tabel users
        $user->update([
            'name' => $request->name ?? $user->name,
            'no_hp' => $request->no_hp ?? $user->no_hp,
        ]);

        // Update atau buat tabel user_profiles
        $profile = $user->profile ?? new UserProfile();
        $profile->user_id = $user->id;
        $profile->address = $request->address ?? $profile->address;

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::delete($profile->photo); // Hapus foto lama
            }

            $profile->photo = $request->file('photo')->store('profile_photos', 'public');
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}
