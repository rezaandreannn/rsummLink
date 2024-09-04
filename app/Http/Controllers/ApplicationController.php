<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Daftar Aplikasi';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            $title => ''
        ];

        $applications = Application::all();

        return view('master-data.application.index', compact('title', 'applications', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Aplikasi';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            'Aplikasi' => route('aplikasi.index'),
            $title => ''
        ];

        $statuses = ['active', 'maintenance', 'inactive'];
        return view('master-data.application.create', compact('statuses', 'title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $appName = $request->name;
        $slug = Str::slug($appName);

        $data = [
            'name' => $request->name,
            'prefix' => $slug,
            'status' => $request->status,
            'description' => $request->description
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('img/aplikasi', 'public');
        }

        Application::create($data);

        return redirect()->route('aplikasi.index')->with('toast_success', 'Aplikasi berhasil disimpan.');
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
        $title = 'Ubah Aplikasi';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            'Aplikasi' => route('aplikasi.index'),
            $title => ''
        ];

        $application = Application::find($id);

        $statuses = ['active', 'maintenance', 'inactive'];

        return view('master-data.application.edit', compact('statuses', 'application', 'breadcrumbs', 'title'));
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
        $nameApp = $request->name;
        $slug = Str::slug($nameApp);

        $data = [
            'name' => $request->name,
            'prefix' => $slug,
            'status' => $request->status,
            'description' => $request->description
        ];


        if ($request->file('image')) {
            $oldImagePath = $request->oldImage;
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
            $data['image'] = $request->file('image')->store('img/aplikasi', 'public');
        }

        $application = Application::find($id);

        $application->update($data);

        $message = 'Berhasil membuat aplikasi!';

        return redirect()->route('aplikasi.index')->with('toast_success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
