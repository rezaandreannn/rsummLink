<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $roleId = $request->input('roleId');
        $permissionId = $request->input('permissionId');
        $checked = $request->input('action');

        $role = Role::findById($roleId);

        $permission = Permission::findById($permissionId);

        if ($role && $permission) {
            if ($checked == 'insert') {
                $role->givePermissionTo($permission);
                $message = 'Berhasil menambahkan perizinan ' . $permission->name;
            } else {
                $role->revokePermissionTo($permission);
                $message = 'Berhasil menghapus perizinan ' . $permission->name;
            }

            return response()->json(['message' => $message]);
        }

        return response()->json(['error' => 'Role or permission not found'], 404);
    }
}
