<?php

namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:m_user,username',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required|exists:m_level,level_id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan user baru',
            ], 409);
        }
    }
}