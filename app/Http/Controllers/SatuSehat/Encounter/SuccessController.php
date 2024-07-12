<?php

namespace App\Http\Controllers\SatuSehat\Encounter;

use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Encounter\Encounter;
use Illuminate\Http\Request;

class SuccessController extends Controller
{
    public function index()
    {
        $successEncounters = Encounter::all();

        return view('satusehat.encounter.success.index', compact('successEncounters'));
    }
}
