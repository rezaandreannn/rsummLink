<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
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
        $title = 'Daftar Pengguna';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            $title => '',
        ];


        $users = User::all();
        // $applications = Application::all();
        // $roles = Role::all();
        $applications = Application::all();
        $roles = [];

        foreach ($applications as $app) {
            $roles[$app->id] = Role::where('application_id', $app->id)->get();
        }
        return view($this->pathView . '.index', compact('breadcrumbs', 'users', 'title', 'applications', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Pengguna';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            'Pengguna' => route('user.index'),
            $title => '',
        ];

        return view($this->pathView . '.create', compact('title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
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
    public function show(User $user)
    {
        $title = 'Detail Pengguna';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            'Pengguna' => route('user.index'),
            $title => '',
        ];

        $applications = Application::all();
        $roles = [];
        $userRoles = [];

        foreach ($applications as $app) {
            $roles[$app->id] = Role::where('application_id', $app->id)->get();
            foreach ($roles[$app->id] as $role) {
                if ($user->hasRole($role->id)) {
                    $userRoles[$role->id] = true;
                } else {
                    $userRoles[$role->id] = false;
                }
            }
        }

        return view($this->pathView . '.peran', compact('roles', 'applications', 'user', 'userRoles', 'title', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = 'Ubah pengguna';

        $breadcrumbs = [
            'Dashboard' => route('dashboard'),
            'Pengguna' => route('user.index'),
            $title => ''
        ];

        return view($this->pathView . '.edit', compact('breadcrumbs', 'title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {

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
    public function destroy(User $user)
    {

        $user->delete();

        $message = 'Berhasil menghapus pengguna!';

        return redirect()->route($this->routeIndex)->with($this->toastSuccess, $message);
    }

    // public function changeStatus(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $user->update([
    //         'status' => $request->status
    //     ]);

    //     $message = 'Berhasil mengubah status pengguna!';
    //     return redirect()->route($this->routeIndex)->with($this->toastSuccess, $message);
    // }


    public function assignRole(Request $request)
    {
        $userId = $request->input('userId');
        $roleId = $request->input('roleId');
        $checked = $request->input('action');

        $user = User::find($userId);

        $role = Role::findById($roleId);

        if ($user && $role) {
            if ($checked == 'insert') {
                $user->assignRole($role);
                $message = 'Berhasil menambahkan peran ' . $role->name;
            } else {
                $user->removeRole($role);
                $message = 'Berhasil menghapus peran ' . $role->name;
            }

            return response()->json(['message' => $message]);
        }

        return response()->json(['error' => 'Role  not found'], 404);
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => true]);
    }
}
