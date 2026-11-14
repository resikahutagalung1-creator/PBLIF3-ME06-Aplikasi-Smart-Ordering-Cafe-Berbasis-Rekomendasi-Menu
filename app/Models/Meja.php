<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'meja';

    protected $primaryKey = 'meja_id';

    protected $fillable = [
        'nomor_meja',
        'status',
    ];
}