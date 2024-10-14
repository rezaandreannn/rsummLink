<?php

namespace App\Http\Controllers\Eclaim\Berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RajalController extends Controller
{
    public function index()
    {
        $title = 'Data Pasien';

        $breadcrumbs = [
            'Dashboard' => route('e-claim.dashboard'),
            $title => ''
        ];

        $theads = ['No', 'Nama Pasien', 'No RM', 'Dokter', 'Tanggal', 'opsi'];


        return view('eclaim.berkas.index', compact('title', 'breadcrumbs', 'theads', 'menus'));
    }
}
