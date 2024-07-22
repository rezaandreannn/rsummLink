<?php

namespace App\Models\SatuSehat\Encounter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    use HasFactory;

    protected $table = 'satusehat_encounter';
    protected $guarded = [];

    public static function filterByMetodeConsultation($date, $consultation =  null)
    {
        $query = self::whereDate('created_at', $date);

        if ($consultation) {
            $query->where('metode_konsultasi', $consultation);
        }

        return $query->get();
    }
}
