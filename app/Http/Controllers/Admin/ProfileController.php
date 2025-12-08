<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::first();

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'open_hours' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $profile = Profile::firstOrCreate([]);

        $data = $request->only([
            'store_name',
            'tagline',
            'description',
            'address',
            'phone',
            'email',
            'instagram',
            'facebook',
            'tiktok',
            'open_hours'
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Profil toko diperbarui.');
    }
}
