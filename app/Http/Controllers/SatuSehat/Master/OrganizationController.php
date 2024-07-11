<?php

namespace App\Http\Controllers\SatuSehat\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Organization;
use Satusehat\Integration\FHIR\Organization as FHIROrganization;
use Satusehat\Integration\OAuth2Client;

class OrganizationController extends Controller
{
    public function index()
    {

        $organizations = Organization::all();

        return view('satusehat.master-data.organization.index', compact('organizations'));
    }

    public function create()
    {
        $organizations = Organization::pluck('organization_id', 'name');
        return view('satusehat.master-data.organization.create', compact('organizations'));
    }

    public function store(Request $request)
    {

        try {
            $client = new OAuth2Client;
            $organization = new FHIROrganization();
            $organization->addIdentifier($request->identifier);
            $organization->setName($request->name);
            if ($request->part_of) {
                $organization->setPartOf($request->part_of);
            }

            $body = $organization->json();

            $resource = 'Organization';

            [$statusCode, $response] = $client->ss_post($resource, $body);

            if ($statusCode == 201) {
                // $responseBody = json_decode($response);

                // Extract the numeric part from the response's partOf reference
                $partOfNumericToken = null;
                if (isset($response->partOf->reference)) {
                    preg_match('/(\d+)/', $response->partOf->reference, $matches);
                    $partOfNumericToken = $matches[0] ?? null;
                }

                // Create the organization record in the database
                Organization::create([
                    'organization_id' => $response->id,
                    'active' => $response->active == true ? 1 : 0,
                    'name' => $response->name,
                    'part_of' => $request->part_of,
                    'created_by' => auth()->user()->id,
                ]);
            }

            $message = 'Berhasil membuat Organization';
            return redirect()->route('organization.index')->with('toast_success', $message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $client = new OAuth2Client;

        [$statusCode, $response] = $client->get_by_id('Organization', $id);

        dd($response);
    }

    public function edit($id)
    {
        $organization = Organization::where('organization_id', $id)
            ->first();

        $organizations = Organization::pluck('organization_id', 'name');

        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_id('Organization', $id);
        $identifierValue = $response->identifier[0]->value;


        return view('satusehat.master-data.organization.edit', compact('organization', 'organizations', 'identifierValue'));
    }

    public function update(Request $request, $id)
    {
        try {
            $organization = new FHIROrganization();
            $organization->put($id);
            $organization->addIdentifier($request->identifier);
            $organization->setName($request->name);
            if ($request->part_of) {
                $organization->setPartOf($request->part_of);
            }

            $body = $organization->json();

            $resource = 'Organization';

            $client = new OAuth2Client;
            [$statusCode, $response] = $client->ss_put($resource, $id, $body);

            if ($statusCode == 200 || $statusCode == 204) {
                // update the organization record in the database

                $localOrganization = Organization::where('organization_id', $id)->first();
                $localOrganization->update([
                    'organization_id' => $response->id,
                    'active' => $response->active == true ? 1 : 0,
                    'name' => $response->name,
                    'part_of' => $request->part_of,
                    'updated_by' => auth()->user()->id,
                ]);
            }

            $message = 'Berhasil mengubah Organization';
            return redirect()->route('organization.index')->with('toast_success', $message);
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }
}
