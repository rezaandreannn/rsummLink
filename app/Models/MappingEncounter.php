<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingEncounter extends Model
{
    use HasFactory;
    protected $table = 'satusehat_mapping_encounter';
    protected $guarded = [];
}
