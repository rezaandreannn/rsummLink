<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Location;
use App\Models\SatuSehat\Organization;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('satusehat.master-data.location.index', compact('locations'));
    }

    public function create()
    {
        $physicalTypes = [
            'bu' => 'Building (bangunan)',
            'wi' => 'Wing (sayap gedung)',
            // 'co' => 'Corridor',
            'ro' => 'Room (ruangan)',
            've' => 'Vehicle (kendaraan)',
            'ho' => 'House (rumah)',
            'ca' => 'Cabinet (kabined)',
            'rd' => 'Road (jalan)',
            'area' => 'Area (area)',
        ];

        $organizations = Organization::pluck('name', 'organization_id');
        // dd($organizations);
        $locations = Location::pluck('name', 'location_id');

        return view('satusehat.master-data.location.create', compact('physicalTypes', 'organizations', 'locations'));
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
