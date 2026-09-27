<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'pesanan_id';

    protected $fillable = [
        'nomor_pesanan',
        'pelanggan_id',
        'kasir_id',
        'tanggal_pesanan',
        'subtotal',
        'pajak',
        'total',
        'status',
        'catatan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(
            Pelanggan::class,
            'pelanggan_id',
            'pelanggan_id'
        );
    }

    public function detailPesanan()
    {
        return $this->hasMany(
            DetailPesanan::class,
            'pesanan_id',
            'pesanan_id'
        );
    }
}