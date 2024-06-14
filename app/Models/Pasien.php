<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $connection = 'db_rsumm';
    protected $table = 'REGISTER_PASIEN';

    public function scopeLatestRecords($query, $limit = 1000)
    {
        return $query->orderBy('Tgl_Register', 'desc')->take($limit);
    }
}
