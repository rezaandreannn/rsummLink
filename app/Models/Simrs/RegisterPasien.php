<?php

namespace App\Models\Simrs;

use App\Models\SatuSehat\Pasien;
use App\Models\Simrs\Pendaftaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegisterPasien extends Model
{
    use HasFactory;
    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.REGISTER_PASIEN';

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'no_mr', 'No_MR');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'No_MR', 'No_MR');
    }
}
