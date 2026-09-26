<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $primaryKey = 'menu_id';

    public $timestamps = false;


    protected $fillable = [
        'kategori_id',
        'nama_menu',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
    ];


    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id',
            'kategori_id'
        );
    }
}