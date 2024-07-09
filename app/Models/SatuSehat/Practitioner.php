<?php

namespace App\Models\SatuSehat;

use App\Models\Simrs\Dokter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Practitioner extends Model
{
    use HasFactory;
    // fields = id, kode_rs, id_dokter, nama_dokter, created_at, updated_at

    protected $connection = 'sqlsrv';
    protected $table = 'dbo.satusehat_dokter';
    protected $guarded = [];


    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kode_rs', 'Kode_Dokter');
    }
}
