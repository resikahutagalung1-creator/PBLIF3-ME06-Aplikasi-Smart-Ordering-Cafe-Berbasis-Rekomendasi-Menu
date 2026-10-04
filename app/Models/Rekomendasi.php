<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    protected $table = 'rekomendasi';

    protected $primaryKey = 'rekomendasi_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'menu_id',
        'menu_rekomendasi_id',
        'skor',
        'alasan',
        'status',
    ];

    public function menu()
    {
        return $this->belongsTo(
            Menu::class,
            'menu_id',
            'menu_id'
        );
    }

    public function menuRekomendasi()
    {
        return $this->belongsTo(
            Menu::class,
            'menu_rekomendasi_id',
            'menu_id'
        );
    }
}