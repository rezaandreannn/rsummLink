<?php

namespace App\Models\Simrs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $connection = 'db_rsumm';
    protected $table = 'DB_RSMM.dbo.DOKTER';

    public function scopeFilteredDokters($query)
    {
        return $query->whereRaw('LOWER(Jenis_Profesi) LIKE ?', ['%dokter%'])
            ->whereNotNull('No_KTP')
            ->where('No_KTP', '!=', '')
            ->where('Kode_Dokter', 'NOT LIKE', '%[a-zA-Z]%');
    }
}
