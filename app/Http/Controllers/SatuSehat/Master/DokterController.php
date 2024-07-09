<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Models\Simrs\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Cache\RateLimiting\Limit;
use Satusehat\Integration\OAuth2Client;

class DokterController extends Controller
{
    public function index()
    {
        $practitioners = Dokter::FilteredDokters()
            ->with('practitioner')
            ->get();

        return view('satusehat.master-data.practitioner.index', compact('practitioners'));
    }
}
