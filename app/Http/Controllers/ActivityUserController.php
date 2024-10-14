<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;


class ActivityUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $title = 'Aktivitas';

        $activities = Activity::where('causer_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())
            ->whereNotIn('event', ['login', 'logout'])
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($activities);

        return view('activity', compact('title', 'activities'));
    }
}
