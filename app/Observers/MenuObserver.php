<?php

namespace App\Observers;

use App\Models\menu;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class MenuObserver
{
    /**
     * Handle the menu "created" event.
     *
     * @param  \App\Models\menu  $menu
     * @return void
     */
    public function created(menu $menu)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'created',
            'model_type' => get_class($menu),
            'model_id' => $menu->id,
            'changes' => json_encode($menu->getAttributes()),
        ]);
    }

    /**
     * Handle the menu "updated" event.
     *
     * @param  \App\Models\menu  $menu
     * @return void
     */
    public function updated(menu $menu)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'updated',
            'model_type' => get_class($menu),
            'model_id' => $menu->id,
            'changes' => json_encode($menu->getChanges()),
        ]);
    }

    /**
     * Handle the menu "deleted" event.
     *
     * @param  \App\Models\menu  $menu
     * @return void
     */
    public function deleted(menu $menu)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'deleted',
            'model_type' => get_class($menu),
            'model_id' => $menu->id,
            'changes' => json_encode($menu->getAttributes()),
        ]);
    }

    /**
     * Handle the menu "restored" event.
     *
     * @param  \App\Models\menu  $menu
     * @return void
     */
    public function restored(menu $menu)
    {
        //
    }

    /**
     * Handle the menu "force deleted" event.
     *
     * @param  \App\Models\menu  $menu
     * @return void
     */
    public function forceDeleted(menu $menu)
    {
        //
    }
}
