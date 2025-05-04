<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = UserModel::all();
        return response()->json($users);
    }

    public function store(Request $request): JsonResponse
    {
        // Validasi input user baru
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:m_user,username',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:255',
            'level_id' => 'required|exists:m_level,level_id',
        ]);

        // Enkripsi password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        // Simpan user baru ke database
        $user = UserModel::create($validated);

        // Berikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'user' => $user
        ], 201);
    }

    public function show(UserModel $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(Request $request, UserModel $user): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'sometimes|required|string|max:255|unique:m_user,username,' . $user->user_id . ',user_id',
            'password' => 'nullable|string|min:6',
            'nama' => 'sometimes|required|string|max:255',
            'level_id' => 'sometimes|required|exists:m_level,level_id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diupdate',
            'user' => $user
        ], 200);
    }

    public function destroy(UserModel $user): JsonResponse
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully',
        ]);
    }
}