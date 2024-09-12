<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;

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
        $title = 'Aktifitas';

        $activities = collect(UserActivity::ByAuthId()->with('user')->get())->sortDesc();

        foreach ($activities as $activity) {
            $activity->description = $activity->getDescription(); // Tambahkan deskripsi

        }


        return view('activity', compact('title', 'activities'));
    }
}
