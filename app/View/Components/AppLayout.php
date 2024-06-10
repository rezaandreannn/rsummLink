<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $title;
    public $app;
    public function __construct(Request $request, $title = '', $app = '')
    {
        $this->title = $title;
        $application = $request->attributes->get('application');
        $this->app = $application->name ?? '';
    }


    public function render(): View
    {
        return view('layouts.app');
    }
}
