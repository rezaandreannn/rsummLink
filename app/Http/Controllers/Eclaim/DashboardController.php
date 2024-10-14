<?php

namespace App\Http\Controllers\Eclaim;

use Illuminate\Http\Request;
use App\Models\Simrs\BpjsRegister;
use App\Http\Controllers\Controller;
use App\Models\Simrs\Pendaftaran;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $app = $request->attributes->get('application');
        $pasien = Pendaftaran::with(['bpjsRegister', 'pasien', 'dokter'])
            ->where('Tanggal', '2024-10-11')
            ->limit(5)
            ->get();
        dd($pasien);
        // $user = Auth::user();
        // $test = $user->roles($app->id)->where('name', 'admin')->exists();
        return view('eclaim.dashboard', compact('app'));
    }
}
