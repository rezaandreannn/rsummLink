<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Daftar Perizinan';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            $title => ''
        ];

        $theads = ['No', 'Nama Perizinan', 'Tipe', ''];

        $permissions = Permission::with('application')->orderBy('application_id')->get();
        $applications = Application::all();

        return view('manage-user.permission.index', compact('permissions', 'title', 'breadcrumbs', 'applications', 'theads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'application_id' => $request->application_id
        ]);
        $message = 'Berhasil membuat perizinan!';
        return redirect()->back()->with('toast_success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'application_id' => $request->application_id
        ]);

        $message = 'Berhasil mengubah perizinan!';
        return redirect()->back()->with('toast_success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();

        $message = 'Berhasil menghapus perizinan!';
        return redirect()->back()->with('toast_success', $message);
    }
}
