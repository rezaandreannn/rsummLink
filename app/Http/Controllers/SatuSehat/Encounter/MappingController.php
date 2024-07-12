<?php

namespace App\Http\Controllers\SatuSehat\Encounter;

use Illuminate\Http\Request;
use App\Models\SatuSehat\Location;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Organization;
use App\Models\SatuSehat\Practitioner;
use Satusehat\Integration\OAuth2Client;
use App\Models\SatuSehat\Encounter\Mapping;

class MappingController extends Controller
{
    public function index()
    {
        $mappings = Mapping::with(['location', 'organization', 'practitioner'])->get();

        return view('satusehat.encounter.mapping.index', compact('mappings'));
    }

    public function create()
    {

        $practitioners = Practitioner::pluck('nama_dokter', 'id_dokter');

        $pelayanans = [
            1 => 'rawat jalan',
            2 => 'rawat inap',
            3 => 'igd',
        ];

        $organizations = Organization::pluck('organization_id', 'name');

        $locations = Location::pluck('location_id', 'name');

        return view('satusehat.encounter.mapping.create', compact('practitioners', 'pelayanans', 'organizations', 'locations'));
    }

    public function store(Request $request)
    {

        // cari organization by location
        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_id('Location', $request->location_id);
        if ($statusCode == 200) {
            $managingOrganization = $response->managingOrganization->reference;
            $parts = explode('/', $managingOrganization);
            $uuid_organization = end($parts);
        }

        Mapping::create([
            'dokter_id' => $request->practitioner_id,
            'location_id' => $request->location_id,
            'organization_id' => $uuid_organization ?? '',
            'cara_masuk' => $request->cara_masuk
        ]);

        return redirect()->route('encounter.mapping')->with('toast_success', 'Berhasil mapping data.');
    }

    public function edit($id)
    {
        $practitioners = Practitioner::pluck('nama_dokter', 'id_dokter');

        $pelayanans = [
            1 => 'rawat jalan',
            2 => 'rawat inap',
            3 => 'igd',
        ];

        $organizations = Organization::pluck('organization_id', 'name');

        $locations = Location::pluck('location_id', 'name');

        $mapping = Mapping::where('id', $id)->first();

        return view('satusehat.encounter.mapping.edit', compact('practitioners', 'pelayanans', 'organizations', 'locations', 'mapping'));
    }

    public function update(Request $request, $id)
    {
        // cari organization by location
        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_id('Location', $request->location_id);
        if ($statusCode == 200) {
            $managingOrganization = $response->managingOrganization->reference;
            $parts = explode('/', $managingOrganization);
            $uuid_organization = end($parts);
        }

        $mapping = Mapping::where('id', $id)->first();
        $mapping->update([
            'dokter_id' => $request->practitioner_id,
            'location_id' => $request->location_id,
            'organization_id' => $uuid_organization ?? '',
            'cara_masuk' => $request->cara_masuk
        ]);

        return redirect()->route('encounter.mapping')->with('toast_success', 'Berhasil memperbarui data.');
    }
}
