<?php

namespace App\Http\Controllers\Vclaim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $app = $request->attributes->get('application');
        // $user = Auth::user();
        // $test = $user->roles($app->id)->where('name', 'admin')->exists();
        return view('vclaim.dashboard', compact('app'));
    }
}
