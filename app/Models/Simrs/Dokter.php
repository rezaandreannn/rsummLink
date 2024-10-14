<?php

namespace App\Models\Simrs;

use App\Models\Simrs\Pendaftaran;
use App\Models\SatuSehat\Practitioner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokter extends Model
{
    use HasFactory;

    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.DOKTER';

    public function practitioner()
    {
        return $this->hasOne(Practitioner::class, 'kode_rs', 'Kode_Dokter');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'Kode_Dokter', 'Kode_Dokter');
    }

    public function scopeFilteredDokters($query)
    {
        return $query->whereRaw('LOWER(Jenis_Profesi) LIKE ?', ['%dokter%'])
            ->whereNotNull('No_KTP')
            ->where('No_KTP', '!=', '')
            ->where('Kode_Dokter', 'NOT LIKE', '%[a-zA-Z]%');
    }

    public function getMaskedNoKtpAttribute()
    {
        if ($this->No_KTP) {
            return substr($this->No_KTP, 0, -4) . '****';
        }
        return null;
    }
}
