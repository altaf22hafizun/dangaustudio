<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        return view('landing.user.setting');
    }

    public function updateprofile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|min:4',
            'telp' => 'sometimes|min:11',
            'alamat' => 'sometimes|string|min:8|',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'sometimes|email|unique:users,email,' . Auth::user()->id,
        ], [
            'name.min' => 'Nama lengkap minimal 4 karakter.',
            'alamat.min' => 'Alamat minimal 8 karakter.',
            'telp.min' => 'Nomor telepon minimal 11 karakter.',
            'foto_profile.image' => 'Foto profile harus dalam format gambar.',
            'foto_profile.mimes' => 'Foto profile harus dalam format PNG, JPG, atau JPEG.',
            'foto_profile.max' => 'Ukuran file gambar tidak boleh lebih dari 2MB.',
            'email.email' => 'Email harus berformat valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ]);

        $user = User::find(Auth::user()->id);

        // Handle image upload
        if ($request->hasFile('foto_profile')) {
            $image = $request->file('foto_profile');
            $path = $image->store('foto_profile', 'public');
            // Remove old profile photo if exists
            if ($user->foto_profile && Storage::exists('public/' . $user->foto_profile)) {
                Storage::delete('public/' . $user->foto_profile);
            }
            $validatedData['foto_profile'] = $path;
        }

        // Update user profile
        $user->update($validatedData);

        return redirect('user/account')->with('success', 'Detail Profile berhasil diperbarui!');
    }

    public function updatepassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('user/account')->with('success', 'Password berhasil diperbarui!');
    }
}
