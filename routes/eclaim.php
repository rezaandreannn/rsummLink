<?php

use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Eclaim\DashboardController;



// dashboard 
if (Schema::hasTable('roles')) {
    $roles = Role::where('application_id', 3)->pluck('name')->toArray();
    $rolesString = !empty($roles) ? implode(',', $roles) : '';

    Route::prefix('e-claim')->middleware(['checkrole:' . $rolesString])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('e-claim.dashboard');
    });
}
