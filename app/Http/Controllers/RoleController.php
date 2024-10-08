<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Daftar Peran";

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            $title => ''
        ];

        $theads = ['No', 'Nama Peran', 'Tipe', 'Aplikasi', ''];

        $roles = Role::with('application')->get();
        $applications = Application::all();
        $permissions = Permission::all()->groupBy('application_id');

        return view('manage-user.role.index', compact('title', 'breadcrumbs', 'theads', 'roles', 'applications', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'application_id' => $request->application_id
        ]);

        $message = 'Berhasil membuat peran!';
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
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'application_id' => $request->application_id
        ]);

        $message = 'Berhasil mengubah peran!';
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
        $role = Role::findOrFail($id);

        $role->delete();

        $message = 'Berhasil menghapus peran!';
        return redirect()->back()->with('toast_success', $message);
    }
}
