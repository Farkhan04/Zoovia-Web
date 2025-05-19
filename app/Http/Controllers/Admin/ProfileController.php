<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form
     * 
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile; // relasi ke user_profiles

        return view('admin.profile', compact('user', 'profile'));
    }

    /**
     * Update the user's profile
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Debug semua data yang diterima
        Log::info('Received request data:', [
            'all' => $request->all(),
            'files' => $request->allFiles(),
            'has_file' => $request->hasFile('upload'),
        ]);

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

        // Debug upload process
        Log::info('File upload check details: ', [
            'has_file' => $request->hasFile('upload'),
            'file_valid' => $request->hasFile('upload') ? $request->file('upload')->isValid() : 'N/A',
            'files' => $request->allFiles(),
            'content_type' => $request->hasFile('upload') ? $request->file('upload')->getMimeType() : 'N/A',
        ]);

        // Upload foto jika ada
        try {
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                
                // Pastikan file valid
                if ($file->isValid()) {
                    // Hapus foto lama jika ada
                    if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                        Storage::disk('public')->delete($profile->photo);
                    }
                    
                    // Simpan foto baru dengan nama unik
                    $fileName = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('profile_photos', $fileName, 'public');
                    $profile->photo = $path;
                    
                    Log::info('Profile photo uploaded successfully: ' . $path);
                } else {
                    Log::error('Uploaded file is not valid');
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to upload profile photo: ' . $e->getMessage());
        }

        $profile->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui');
    }
}   