<?php

namespace App\Models\Simrs;

use App\Models\SatuSehat\Pasien;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterPasien extends Model
{
    use HasFactory;
    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.REGISTER_PASIEN';

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'no_mr', 'No_MR');
    }
}
