<?php

use App\Http\Controllers\SatuSehat\DashboardController;
use App\Http\Controllers\SatuSehat\EncounterController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

// dashboard 
$roles = Role::where('application_id', 1)->pluck('name')->toArray();
$rolesString = implode(',', $roles);

Route::prefix('satusehat')->middleware(['checkrole:' . $rolesString])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('satusehat.dashboard');
    Route::get('encounter', [EncounterController::class, 'index'])->name('encounter');
});
