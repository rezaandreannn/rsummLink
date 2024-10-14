<?php

namespace App\Models\Simrs;

use App\Models\Simrs\Pendaftaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BpjsRegister extends Model
{
    use HasFactory;

    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.BPJS_REGISTER';

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'No_Reg', 'No_Reg');
    }
}
