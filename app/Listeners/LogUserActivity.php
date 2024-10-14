<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogUserActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */

    public function handleLogin(Login $event)
    {
        // Mencatat aktivitas login
        activity()
            ->causedBy($event->user)
            ->event('login')
            ->log('User logged in');
    }

    public function handleLogout(Logout $event)
    {
        // Mencatat aktivitas logout
        activity()
            ->causedBy($event->user)
            ->event('logout')
            ->log('User logged out');
    }
}
