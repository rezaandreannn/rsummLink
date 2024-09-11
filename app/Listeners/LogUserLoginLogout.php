<?php

namespace App\Listeners;

use Jenssegers\Agent\Agent;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Models\UserActivityDetail;
use Illuminate\Support\Facades\Auth;


class LogUserLoginLogout
{
    protected $request;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $activityType = $event instanceof Login ? 'login' : 'logout';

        $ipAddress = $this->request->ip();

        $agent = new Agent();
        $device = $agent->device(); // Mendapatkan nama perangkat (jika tersedia)
        $platform = $agent->platform(); // Mendapatkan OS
        $browser = $agent->browser(); // Mendapatkan browser

        $userActivity = UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => $activityType,
            'model_type' => null,  // Tidak ada model terkait untuk login/logout
            'model_id' => null,
            'changes' => null, // Tidak ada perubahan data
        ]);

        // Simpan data detail di tabel user_activity_details
        UserActivityDetail::create([
            'user_activity_id' => $userActivity->id,
            'ip_address' => $ipAddress,
            'device' => $device . ' (' . $platform . ')', // Nama perangkat + OS
            'browser' => $browser, // Nama browser
        ]);
    }
}
