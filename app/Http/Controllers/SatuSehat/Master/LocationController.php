<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('satusehat.master-data.location.index', compact('locations'));
    }
}
