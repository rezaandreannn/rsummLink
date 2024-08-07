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

        if ($status !== null) {
            $query->where('status', $status);
        } else {
            // Jika status tidak diberikan, maka filter berdasarkan status 0 dan 1
            $query->whereIn('status', [0, 1]);
        }

        return $query->get();
    }
}
