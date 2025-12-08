<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::first();
        $user = Auth::user();

        return view('frontend.profile.edit', compact('profile', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:20',
        ]);

        // $user->update($request->only('name', 'alamat', 'telp'));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
