<?php

namespace App\Listeners;

use App\Models\UserActivityAuth;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class LogUserLogin
{
    protected $agent;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        $deviceName = $this->agent->device();
        $ipAddress = Request::ip();
        $userAgent = Request::userAgent();

        UserActivityAuth::create([
            'user_id' => $user->id,
            'device' => $deviceName,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'login_at' => now()
        ]);
    }
}
