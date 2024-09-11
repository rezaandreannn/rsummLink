<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        $loggedInUsers = UserActivity::select('user_id')
            ->where('activity_type', 'login')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('user_activities as ua')
                    ->whereColumn('ua.user_id', 'user_activities.user_id')
                    ->where('ua.activity_type', 'logout')
                    ->whereColumn('ua.created_at', '>', 'user_activities.created_at');
            })
            ->groupBy('user_id')
            ->get();

        // dd($loggedInUsers);

        return view('dashboard', compact('title'));
    }
}
