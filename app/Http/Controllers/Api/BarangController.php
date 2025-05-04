<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Http\JsonResponse;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'  => 'required|exists:m_kategori,kategori_id',
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama'  => 'required|string|max:100',
            'harga_beli'   => 'required|integer',
            'harga_jual'   => 'required|integer',
        ]);
        $barang = BarangModel::create($validated);
        return response()->json($barang, 201);
    }

    public function show(BarangModel $barang)
    {
        return $barang;
    }

    public function update(Request $request, BarangModel $barang)
    {
        $data = [
            'kategori_id'  => $request->query('kategori_id', $request->input('kategori_id')),
            'barang_kode'  => $request->query('barang_kode', $request->input('barang_kode')),
            'barang_nama'  => $request->query('barang_nama', $request->input('barang_nama')),
            'harga_beli'   => $request->query('harga_beli', $request->input('harga_beli')),
            'harga_jual'   => $request->query('harga_jual', $request->input('harga_jual')),
        ];

        $data = array_filter($data, function($value) {
            return !is_null($value);
        });

        // Validasi unik untuk barang_kode saat update
        $request->validate([
            'barang_kode' => 'sometimes|string|max:10|unique:m_barang,barang_kode,' . $barang->barang_id . ',barang_id',
            'barang_nama' => 'sometimes|string|max:100',
            'kategori_id' => 'sometimes|exists:m_kategori,kategori_id',
            'harga_beli'  => 'sometimes|integer',
            'harga_jual'  => 'sometimes|integer',
        ]);

        $barang->update($data);
        return response()->json($barang, 200);
    }

    public function destroy(BarangModel $barang): JsonResponse
    {
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully',
        ]);
    }
}
