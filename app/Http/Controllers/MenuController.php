<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Permission;
use App\Models\Application;
use App\Models\Icon;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Menu';
        $menus = Menu::with(['application', 'permission'])->orderBy('application_id', 'asc')->get();
        $applications = Application::all();

        $icons = Icon::where('label', 'user')->get();
        return view('manage-user.menu.index', compact('title', 'menus', 'applications', 'icons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $applications = Application::all();

        $icons = Icon::all();
        return view('manage-user.menu.create', compact('icons', 'applications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Menu::create([
            'name' => $request->name,
            'route' => $request->route,
            'icon' => $request->icon,
            'application_id' => $request->application_id == 0 ? null :  $request->application_id,
            'permission_id' => $request->permission_id,
            'is_superadmin' => $request->application_id == 0 ? true : false,
            'serial_number' => $request->serial_number
        ]);

        $message = 'Berhasil membuat menu!';
        return redirect()->route('menu.index')->with('toast_success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::find($id);
        $title = 'Menu : ' . ucwords($menu->name);
        $menuItems = MenuItem::with('permission')->where('menu_id', $id)->get();
        return view('manage-user.menu.detail', compact('menuItems', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $applications = Application::all();
        $permissions = Permission::all();
        $icons = Icon::all();
        $menu = Menu::findOrFail($id);

        return view('manage-user.menu.edit', compact('icons', 'applications', 'menu', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::FindOrFail($id);

        $data = [
            'name' => $request->name,
            'route' => $request->route,
            'icon' => $request->icon,
            'application_id' => $request->application_id == 0 ? null :  $request->application_id,
            'permission_id' => $request->permission_id,
            'is_superadmin' => $request->application_id == 0 ? true : false,
            'serial_number' => $request->serial_number
        ];

        $menu->update($data);

        $message = 'Berhasil mengubah menu!';
        return redirect()->route('menu.index')->with('toast_success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $menu = Menu::FindOrFail($id);

        $menu->delete();

        $message = 'Berhasil menghapus menu!';
        return redirect()->route('menu.index')->with('toast_success', $message);
    }

    public function getPermissionByApplicationId($id)
    {
        $idApp = $id == 0 ? null : $id;
        $permissions = Permission::where('application_id', $idApp)->pluck('name', 'id');
        return response()->json($permissions);
    }
}
