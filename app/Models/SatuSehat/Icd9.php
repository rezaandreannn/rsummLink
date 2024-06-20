<?php

namespace App\Models\SatuSehat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd9 extends Model
{
    use HasFactory;
    protected $table = 'satusehat_icd9cm';
    protected $guarded = [];
}
