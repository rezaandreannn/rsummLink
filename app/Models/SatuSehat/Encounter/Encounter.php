<?php

namespace App\Models\SatuSehat\Encounter;

use App\Models\SatuSehat\Practitioner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    use HasFactory;

    protected $table = 'satusehat_encounter';
    protected $guarded = [];
    protected $with = ['practitioner'];

    public static function filterByMetodeConsultation($date, $consultation =  null)
    {
        $query = self::whereDate('created_at', $date);

        if ($consultation) {
            $query->where('metode_konsultasi', $consultation);
        }

        return $query->get();
    }

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class, 'practitioner_id', 'id_dokter');
    }
}
