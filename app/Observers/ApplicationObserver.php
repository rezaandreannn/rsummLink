<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class ApplicationObserver
{
    /**
     * Handle the Application "created" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function created(Application $application)
    {
        $this->logActivity($application, 'created', $application->getChanges());
    }

    /**
     * Handle the Application "updated" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function updated(Application $application)
    {
        $this->logActivity($application, 'updated', $application->getChanges());
    }

    /**
     * Handle the Application "deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function deleted(Application $application)
    {
        $this->logActivity($application, 'deleted', $application->getChanges());
    }

    /**
     * Handle the Application "restored" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the Application "force deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }

    private function logActivity($model, $activityType, $changes)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => $activityType,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'changes' => json_encode($changes),
        ]);
    }
}
