<?php

namespace App\Http\Controllers\SatuSehat\Encounter;

use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Encounter\Encounter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuccessController extends Controller
{
    public function index(Request $request)
    {
        $created_at = $request->input('created_at');
        $consultation = $request->input('consultation');

        $date = $created_at ? date('Y-m-d', strtotime($created_at)) : Carbon::today()->toDateString();

        if ($consultation) {
            $consultation = $consultation;
        }

        $successEncounters = Encounter::filterByMetodeConsultation('2023-05-16', $consultation);


        $consultations = [
            'RAJAL' => 'AMB',
            'RANAP' => 'IMP',
            'IGD' => 'EMER',
            'HOMECARE' => 'HH',
            'TELEKONSULTASI' => 'TELE'
        ];

        return view('satusehat.encounter.success.index', compact('successEncounters', 'consultations'));
    }
}
