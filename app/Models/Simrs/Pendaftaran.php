<?php

namespace App\Models\Simrs;

use App\Models\Simrs\Dokter;
use App\Models\Emr\TacRjStatus;
use App\Models\Simrs\BpjsRegister;
use App\Models\Simrs\RegisterPasien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    use HasFactory;
    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.PENDAFTARAN';

    public function tacRjStatus()
    {
        return $this->hasOne(TacRjStatus::class, 'FS_KD_REG', 'No_Reg');
    }

    public function bpjsRegister()
    {
        return $this->hasOne(BpjsRegister::class, 'No_Reg', 'No_Reg');
    }

    public function pasien()
    {
        return $this->belongsTo(RegisterPasien::class, 'No_MR', 'No_MR');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'Kode_Dokter', 'Kode_Dokter');
    }
}
