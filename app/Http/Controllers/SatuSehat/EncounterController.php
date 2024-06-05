<?php

namespace App\Http\Controllers\SatuSehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function index()
    {
        return view('satusehat.encounter');
    }
}
