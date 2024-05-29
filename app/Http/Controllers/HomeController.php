<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $applications = Application::all();
        return view('home', compact('applications'));
    }
}
