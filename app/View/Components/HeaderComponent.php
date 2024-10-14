<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;
use Spatie\Activitylog\Models\Activity;

class HeaderComponent extends Component
{
    public $loginTime;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->loginTime = Activity::where('causer_id', auth()->id())
            ->where('description', 'User logged in')
            ->latest()
            ->pluck('created_at')
            ->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $loginTime = Carbon::parse($this->loginTime);
        $timeAgo = $loginTime->diffForHumans();
        return view('layouts.header', compact('timeAgo'));
    }
}
