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

        $consultations = [
            'RAJAL' => 'AMB',
            'RANAP' => 'IMP',
            'IGD' => 'EMER',
            'HOMECARE' => 'HH',
            'TELEKONSULTASI' => 'TELE'
        ];

        return view('satusehat.encounter.success.index', compact('successEncounters'));
    }
}
