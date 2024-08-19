<?php

namespace App\Models\SatuSehat\Encounter;

use App\Models\SatuSehat\Location;
use App\Models\SatuSehat\Pasien;
use App\Models\SatuSehat\Practitioner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    use HasFactory;

    protected $table = 'satusehat_encounter';
    protected $guarded = [];
    protected $with = ['practitioner', 'location', 'patient'];

    public static function filterByMetodeConsultation($date, $consultation =  null)
    {
        $query = self::whereDate('created_at', $date);

        if ($consultation) {
            $query->where('metode_konsultasi', $consultation);
        }

        return $query
            ->orderBy('practitioner_id')
            ->get();
    }

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class, 'practitioner_id', 'id_dokter');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function patient()
    {
        return $this->belongsTo(Pasien::class, 'patient_id', 'id_pasien');
    }
}
