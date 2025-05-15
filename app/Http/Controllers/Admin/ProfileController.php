<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile; // relasi ke user_profiles

        return view('admin.profile', compact('user', 'profile'));
    }

    // Di ProfileController.php, metode update
    public function update(Request $request)
    {
        $request->validate([
            'NamaDepan' => 'nullable|string|max:255',
            'NamaBelakang' => 'nullable|string|max:255',
            'nomortelepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'city' => 'nullable|string',
            'upload' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // Gabungkan NamaDepan dan NamaBelakang untuk field name
        $firstName = $request->NamaDepan ?? '';
        $lastName = $request->NamaBelakang ?? '';
        $fullName = trim($firstName . ' ' . $lastName);

        // Update tabel users
        $user->update([
            'name' => !empty($fullName) ? $fullName : $user->name,
            'no_hp' => $request->nomortelepon ?? $user->no_hp,
        ]);

        // Update atau buat tabel user_profiles
        $profile = $user->profile;
        if (!$profile) {
            $profile = new UserProfile();
            $profile->user_id = $user->id;
        }

        // Gabungkan alamat dan kota menjadi satu field address
        $alamat = $request->alamat ?? '';
        $kota = $request->city ?? '';
        $fullAddress = $alamat;
        if (!empty($kota)) {
            $fullAddress = !empty($fullAddress) ? $fullAddress . ', ' . $kota : $kota;
        }

        // Gunakan alamat gabungan atau tetap gunakan yang lama jika kosong
        $profile->address = !empty($fullAddress) ? $fullAddress : $profile->address;

        // Upload foto jika ada
        if ($request->hasFile('upload')) {
            // Pastikan variabel 'upload' cocok dengan nama input di form
            if ($profile->photo) {
                Storage::delete('public/' . $profile->photo);
            }
            $profile->photo = $request->file('upload')->store('profile_photos', 'public');
        }

        $profile->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui');
    }
}
