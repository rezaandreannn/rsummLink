<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        $title = 'Aplikasi';
        $applications = Application::all();
        return view('master-data.application.index', compact('title', 'applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $statuses = ['active', 'maintenance', 'inactive'];
        return view('master-data.application.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $string = "v-claim bpjs!";
        $slug = Str::slug($string);
        dd($slug);
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
        $application = Application::find($id);
        $statuses = ['active', 'maintenance', 'inactive'];
        return view('master-data.application.edit', compact('statuses', 'application'));
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
