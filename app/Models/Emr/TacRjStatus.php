<?php

namespace App\Models\Emr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TacRjStatus extends Model
{
    use HasFactory;
    protected $connection = 'emr';
    protected $table = 'PKU.dbo.TAC_RJ_STATUS';
}
