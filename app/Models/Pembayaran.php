<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $primaryKey = 'pembayaran_id';

    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'metode',
        'jumlah_bayar',
        'kembalian',
        'status',
        'tanggal_bayar',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'qris_url',
        'qris_string',
        'expired_at',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'pesanan_id',
            'pesanan_id'
        );
    }
}