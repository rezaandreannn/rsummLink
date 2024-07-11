<?php

namespace App\Http\Controllers\SatuSehat\Master;

use Illuminate\Http\Request;
use App\Models\SatuSehat\Location;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Organization;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Location as FHIRLocation;

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

        $locations = Location::pluck('name', 'location_id');

        return view('satusehat.master-data.location.create', compact('physicalTypes', 'organizations', 'locations'));
    }

    public function store(Request $request)
    {

        $location = new FHIRLocation;
        $location->addIdentifier($request->identifier);
        $location->setName($request->name, $request->description);
        $location->addPhysicalType($request->physical_type);
        $location->setManagingOrganization($request->managing_organization);
        if ($request->part_of != '') {
            $location->setPartOf($request->part_of);
        }

        $location->json();


        $client = new OAuth2Client;
        $body = $location->json(); // JSON Object
        $resource = 'Location';

        [$statusCode, $response] = $client->ss_post($resource, $body);
        dd($response);
        echo $statusCode, $response;
    }
}
