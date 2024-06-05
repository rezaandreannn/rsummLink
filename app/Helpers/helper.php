<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('checkRolePermission')) {
    function checkRolePermission($roleId, $permissionId)
    {
        $role = Role::findById($roleId);

        try {
            if ($role->hasPermissionTo(Permission::findById($permissionId)->id)) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
