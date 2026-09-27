<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $primaryKey = 'pelanggan_id';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'nomor_meja',
    ];
    
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id', 'pelanggan_id');
    }
}