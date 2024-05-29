<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $app = $request->attributes->get('application');
        $user = Auth::user();
        $test = $user->roles($app->id)->where('name', 'admin')->exists();
        dd($test);
    }
}
