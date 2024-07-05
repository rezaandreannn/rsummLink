<?php

namespace App\Http\Controllers\SatuSehat\Master;

use Illuminate\Http\Request;
use App\Models\SatuSehat\Pasien;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\SatuSehat\RegisterPasienService;

class PasienController extends Controller
{

    public function index(Request $request)
    {

        $pasiens = Cache::remember('pasiens', 600, function () {
            return Pasien::all();
        });
        return view('satusehat.master-data.pasien.index', compact('pasiens'));
    }
}
