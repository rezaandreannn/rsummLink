<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {

        $organizations = Organization::all();

        return view('satusehat.master-data.organization.index', compact('organizations'));
    }
}
