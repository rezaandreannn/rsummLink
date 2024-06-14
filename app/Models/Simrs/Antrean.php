<?php

namespace App\Models\Simrs;

use App\Models\Simrs\Pendaftaran;
use App\Models\Simrs\RegisterPasien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Antrean extends Model
{
    use HasFactory;
    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.ANTRIAN';

    public function registerPasien()
    {
        return $this->belongsTo(RegisterPasien::class, 'No_MR', 'No_MR');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'No_MR', 'No_MR');
    }
}
