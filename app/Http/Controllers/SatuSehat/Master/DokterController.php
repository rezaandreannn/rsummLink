<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Models\Simrs\Dokter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Satusehat\Integration\OAuth2Client;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::filteredDokters()
            ->first();

        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_nik('Practitioner', $dokters->No_KTP);

        dd($response);
    }
}
