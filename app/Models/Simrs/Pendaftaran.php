<?php

namespace App\Models\Simrs;

use App\Models\Emr\TacRjStatus;
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
}
