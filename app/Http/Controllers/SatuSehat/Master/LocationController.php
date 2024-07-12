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
        try {
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

            if ($statusCode == 201) {

                // Create the location record in the database
                Location::create([
                    'location_id' => $response->id,
                    'name' => $response->name,
                    'status' => $response->status,
                    'physical_type' => $response->physicalType->coding[0]->code,
                    'organization_id' => $request->managing_organization ?? '',
                    'description' => $response->description,
                    'part_of' => $request->part_of ?? '',
                    'created_by' => auth()->user()->id ?? '',
                ]);
            } else {
                $message = $response->issue[0]->diagnostics;
                return redirect()->back()->with('toast_error', $message);
            }

            $message = 'Berhasil membuat Location';
            return redirect()->route('location.index')->with('toast_success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('location.index')->with('toast_error', $th->getMessage());
        }
    }

    public function show()
    {
    }

    public function edit($id)
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

        $location = Location::where('location_id', $id)->first();

        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_id('Location', $id);
        $identifierValue = $response->identifier[0]->value;

        return view('satusehat.master-data.location.edit', compact('physicalTypes', 'organizations', 'locations', 'location', 'identifierValue'));
    }

    public function update(Request $request, $id)
    {
        try {
            $location = new FHIRLocation;
            $location->put($id);
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

            [$statusCode, $response] = $client->ss_put($resource, $id, $body);

            if ($statusCode == 200 || $statusCode == 204) {

                // Create the location record in the database
                $localLocation = Location::where('location_id', $id)
                    ->first();
                $localLocation->update([
                    'location_id' => $response->id,
                    'name' => $response->name,
                    'status' => $response->status,
                    'physical_type' => $response->physicalType->coding[0]->code,
                    'organization_id' => $request->managing_organization ?? '',
                    'description' => $response->description,
                    'part_of' => $request->part_of ?? '',
                    'updated_by' => auth()->user()->id ?? '',
                ]);
            } else {
                $message = $response->issue[0]->diagnostics;
                return redirect()->back()->with('toast_error', $message);
            }

            $message = 'Berhasil memperbarui Location';
            return redirect()->route('location.index')->with('toast_success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('location.index')->with('toast_error', $th->getMessage());
        }
    }
}
