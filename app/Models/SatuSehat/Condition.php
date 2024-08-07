<?php

namespace App\Models\SatuSehat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'satusehat_condition';

    public static function filterByDateAndStatus($date, $status =  null)
    {
        $query = self::whereDate('created_at', $date);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }
}
