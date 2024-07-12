<?php

namespace App\Models\SatuSehat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $table = 'satusehat_transaction_logs';
    protected $guarded = [];
}
