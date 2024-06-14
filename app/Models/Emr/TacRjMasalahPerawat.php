<?php

namespace App\Models\Emr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TacRjMasalahPerawat extends Model
{
    use HasFactory;
    protected $connection = 'emr';
    protected $table = 'PKU.dbo.TAC_RJ_MASALAH_KEP';
}
