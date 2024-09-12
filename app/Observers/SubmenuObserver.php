<?php

namespace App\Observers;

use App\Models\MenuItem;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class SubmenuObserver
{
    /**
     * Handle the MenuItem "created" event.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return void
     */
    public function created(MenuItem $menuItem)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'created',
            'model_type' => get_class($menuItem),
            'model_id' => $menuItem->id,
            'changes' => json_encode($menuItem->getAttributes()),
        ]);
    }

    /**
     * Handle the MenuItem "updated" event.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return void
     */
    public function updated(MenuItem $menuItem)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'updated',
            'model_type' => get_class($menuItem),
            'model_id' => $menuItem->id,
            'changes' => json_encode($menuItem->getAttributes()),
        ]);
    }

    /**
     * Handle the MenuItem "deleted" event.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return void
     */
    public function deleted(MenuItem $menuItem)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'deleted',
            'model_type' => get_class($menuItem),
            'model_id' => $menuItem->id,
            'changes' => json_encode($menuItem->getAttributes()),
        ]);
    }

    /**
     * Handle the MenuItem "restored" event.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return void
     */
    public function restored(MenuItem $menuItem)
    {
        //
    }

    /**
     * Handle the MenuItem "force deleted" event.
     *
     * @param  \App\Models\MenuItem  $menuItem
     * @return void
     */
    public function forceDeleted(MenuItem $menuItem)
    {
        //
    }
}
