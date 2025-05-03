<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok'; // Nama tabel di database
    protected $primaryKey = 'stok_id'; // Primary key tabel
    protected $fillable = [
        'barang_id',     // ID barang
        'supplier_id',   // ID supplier
        'user_id',       // ID user
        'stok_tanggal',  // Tanggal stok
        'stok_jumlah',   // Jumlah stok
    ];

    /**
     * Relasi ke model Barang (m_barang)
     */
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }

    /**
     * Relasi ke model User (m_user)
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke model Supplier (m_supplier)
     */
    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'supplier_id');
    }
}