<?php

namespace App\View\Components;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class NavigationComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $menuItemsByMenuId;
    public $menus;
    public $app;
    public $initialApp;
    public $menuActive;

    public function __construct(Request $request)
    {
        $this->menuItemsByMenuId = MenuItem::orderBy('serial_number', 'asc')
            ->get()
            ->groupBy('menu_id');

        // if (Auth::user()->hasRole('superadmin')) {
        // } else {
        // }
        $segment = $request->attributes->get('application');
        // dd($segment);
        if ($segment) {
            $this->app = $segment->name;
            $this->menus = Menu::with('permission')->where('application_id', $segment->id)->orderBy('serial_number', 'asc')->get();
        } else {
            $this->app = 'Rsumm Link';
            $this->menus = Menu::with('permission')->where('is_superadmin', true)->orderBy('serial_number', 'asc')->get();
        }
        $this->initialApp = implode('', array_map(function ($word) {
            return substr($word, 0, 1);
        }, explode(' ', $this->app)));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.navigation');
    }
}
