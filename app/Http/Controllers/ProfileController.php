<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile.profil', compact('user'));
    }

    public function editPfp()
    {
        $user = Auth::user();
        return view('profile.edit_pfp', compact('user'));
    }

    public function updatePfp(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $user = Auth::user();

            // Hapus foto lama jika ada
            if ($user->profile_picture && Storage::disk('public')->exists('profile/' . $user->profile_picture)) {
                Storage::disk('public')->delete('profile/' . $user->profile_picture);
            }

            // Upload foto baru
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile', $filename);

            // Simpan ke database
        $user->profile_picture = $filename;
            $user->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah foto. Error: ' . $e->getMessage());
        }
    }
}