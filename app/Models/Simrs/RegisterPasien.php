<?php

namespace App\Models\Simrs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterPasien extends Model
{
    use HasFactory;
    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.REGISTER_PASIEN';
}
