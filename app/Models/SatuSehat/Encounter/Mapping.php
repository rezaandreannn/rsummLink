<?php

namespace App\Models\SatuSehat\Encounter;

use App\Models\SatuSehat\Location;
use App\Models\SatuSehat\Organization;
use App\Models\SatuSehat\Practitioner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    use HasFactory;

    protected $table = 'satusehat_encounter_mapping';
    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'organization_id');
    }

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class, 'dokter_id', 'id_dokter');
    }
}
