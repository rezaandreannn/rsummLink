<?php

namespace App\Models\SatuSehat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'satusehat_location';
    protected $guarded = [];

    // fields = 'id', 'location_id', 'name', 'physical_type', 'organization_id', 'description', 'part_of', 'created_by', 'updated_by'


}
