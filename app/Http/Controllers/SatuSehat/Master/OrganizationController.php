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

        $client = new OAuth2Client;
        $body = new FHIROrganization();
        $body->addIdentifier($request->identifier);
        $body->setName($request->name);
        if ($request->part_of) {
            $body->setPartOf($request->part_of);
        }
        $body->json();

        dd($body);
        $resource = 'Organization';

        [$statusCode, $response] = $client->ss_post($resource, $body);
        echo $statusCode, $response;
    }

    public function show($id)
    {
        $client = new OAuth2Client;

        [$statusCode, $response] = $client->get_by_id('Organization', $id);

        dd($response);
    }
}
