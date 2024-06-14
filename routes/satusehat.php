<?php

use App\Http\Controllers\SatuSehat\AntreanController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\SatuSehat\DashboardController;
use App\Http\Controllers\SatuSehat\EncounterController;
use App\Http\Controllers\SatuSehat\Master\PasienController;

// dashboard 
if (Schema::hasTable('roles')) {
    $roles = Role::where('application_id', 1)->pluck('name')->toArray();
    $rolesString = !empty($roles) ? implode(',', $roles) : '';

    Route::prefix('satu-sehat')->middleware(['checkrole:' . $rolesString])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('satu-sehat.dashboard');
        Route::get('encounter', [EncounterController::class, 'index'])->name('encounter');
        Route::get('antrean', [AntreanController::class, 'index'])->name('antrean.index');

        Route::prefix('master')->group(function () {
            Route::get('pasien', [PasienController::class, 'index'])->name('pasien.index');
        });
    });
}
