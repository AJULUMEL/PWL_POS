<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Illuminate\Http\JsonResponse;

class KategoriController extends Controller
{
    public function index()
    {
        return KategoriModel::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100',
        ]);
        $kategori = KategoriModel::create($validated);
        return response()->json($kategori, 201);
    }

    public function show(KategoriModel $kategori)
    {
        return $kategori;
    }

    public function update(Request $request, KategoriModel $kategori)
    {
        $data = [
            'kategori_kode' => $request->query('kategori_kode', $request->input('kategori_kode')),
            'kategori_nama' => $request->query('kategori_nama', $request->input('kategori_nama')),
        ];

        $data = array_filter($data, function($value) {
            return !is_null($value);
        });

        $kategori->update($data);
        return response()->json($kategori, 200);
    }

    public function destroy(KategoriModel $kategori): JsonResponse
    {
        $kategori->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully',
        ]);
    }
}
