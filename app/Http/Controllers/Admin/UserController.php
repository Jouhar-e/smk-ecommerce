<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::first();

        $query = User::orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('telp', 'like', "%{$q}%");
            });
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', [
            'profile' => $profile,
            'users'   => $users,
            'search'  => $request->q,
        ]);
    }

    public function edit(User $user)
    {
        $profile = Profile::first();

        return view('admin.users.edit', compact('profile', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'level'    => ['required', 'in:admin,seller,customer'],
            'status'   => ['required', 'boolean'],
            // password tidak wajib, tapi kalau diisi harus valid dan confirmed
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->level  = $validated['level'];
        $user->status = $validated['status'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }
}
