<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
    
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'NoTelepon' => 'nullable|string',
            'Alamat'    => 'nullable|string',
            'capital'   => 'nullable|string',
            'city'      => 'nullable|string',
            'uploadFoto' => 'nullable|image|max:2048',
        ]);
    
        // Update user basic data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();
    
        // Update or create profile data
        $profile = $user->profile()->firstOrNew();
    
        $profile->phone = $validated['NoTelepon'] ?? $profile->phone;
        $profile->address = $validated['Alamat'] ?? $profile->address;
        $profile->capital = $validated['capital'] ?? $profile->capital;
        $profile->city = $validated['city'] ?? $profile->city;
    
        // Handle photo
        if ($request->hasFile('uploadFoto')) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }
    
            $path = $request->file('uploadFoto')->store('photos', 'public');
            $profile->photo = $path;
        }
    
        $profile->user_id = $user->id; // Pastikan ada user_id
        $profile->save();
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
    
}
