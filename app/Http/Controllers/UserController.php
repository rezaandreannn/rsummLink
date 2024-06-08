<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $routeIndex;
    public $pathView;
    public $toastSuccess;

    public function __construct()
    {
        $this->routeIndex = 'user.index';
        $this->pathView = 'manage-user.users';
        $this->toastSuccess = 'toast_success';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $title = 'Pengguna';
        return view($this->pathView . '.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->pathView . '.create');
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
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\S*$/u',
                Rule::unique(User::class),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
                'regex:/^\+?[0-9]{7,15}$/',
            ],
        ]);


        $user = User::create([
            'name' => $request->name,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone
        ]);

        $message = 'Berhasil membuat pengguna baru!';
        return redirect()->route($this->routeIndex)->with($this->toastSuccess, $message);
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
        $title = 'Ubah pengguna';
        $user = User::findOrFail($id);
        return view($this->pathView . '.edit', compact('title', 'user'));
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
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\S*$/u',
                Rule::unique(User::class)->ignore($id),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($id),
            ],
            'password' => [
                'nullable',
                'confirmed',
                Rules\Password::defaults()
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
                'regex:/^\+?[0-9]{7,15}$/',
            ],
        ]);

        $user = User::findOrFail($id);

        $data = $request->all();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        $message = 'Berhasil mengubah pengguna!';
        return redirect()->route($this->routeIndex)->with($this->toastSuccess, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        $message = 'Berhasil menghapus pengguna!';
        return redirect()->route($this->routeIndex)->with($this->toastSuccess, $message);
    }

    public function changeStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => $request->status
        ]);

        $message = 'Berhasil mengubah status pengguna!';
        return redirect()->route($this->routeIndex)->with($this->toastSuccess, $message);
    }
}
