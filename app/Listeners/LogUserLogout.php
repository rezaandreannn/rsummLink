<?php

namespace App\Listeners;

use App\Models\UserActivityAuth;
use Jenssegers\Agent\Agent;
use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUserLogout
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
    public function handle(Logout $event)
    {
        $user = $event->user;
        $deviceName = $this->agent->device();

        UserActivityAuth::where('user_id', $user->id)
            ->where('device', $deviceName)
            ->whereNull('logout_at')
            ->update(['logout_at' => now()]);
    }
}
