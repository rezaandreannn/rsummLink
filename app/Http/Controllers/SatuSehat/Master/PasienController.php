<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasienController extends Controller
{
    public function index()
    {
        $registerPasiens = Pasien::latestRecords(1000)->get();
        dd($registerPasiens);
        return view('satusehat.master-data.pasien.index', compact('registerPasiens'));
    }
}
