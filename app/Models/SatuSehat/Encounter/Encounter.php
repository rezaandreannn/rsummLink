<?php

namespace App\Models\SatuSehat\Encounter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    use HasFactory;

    protected $table = 'satusehat_encounter';
    protected $guarded = [];
}
