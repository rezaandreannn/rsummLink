<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class SubmenuController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        MenuItem::create([
            'name' => $request->name,
            'route' => $request->route,
            'menu_id' => $request->menu_id,
            'permission_id' => $request->permission_id,
            'serial_number' => $request->serial_number
        ]);

        $message = 'Berhasil membuat sub menu!';
        return redirect()->back()->with('toast_success', $message);
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::find($id);

        $menuItem->update([
            'name' => $request->name,
            'route' => $request->route,
            'menu_id' => $request->menu_id,
            'permission_id' => $request->permission_id,
            'serial_number' => $request->serial_number
        ]);

        $message = 'Berhasil mengubah sub menu!';
        return redirect()->back()->with('toast_success', $message);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);

        $menuItem->delete();

        $message = 'Berhasil menghapus sub menu!';
        return redirect()->back()->with('toast_success', $message);
    }
}
