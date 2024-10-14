<?php

use App\Http\Controllers\ActivityUserController;
use App\Models\Simrs\Antrean;
use App\Models\SatuSehat\Pasien;
use App\Models\Simrs\Pendaftaran;
use Illuminate\Support\Facades\DB;
use App\Models\Simrs\RegisterPasien;
use Illuminate\Support\Facades\Route;
use App\Models\Emr\TacRjMasalahPerawat;
use Satusehat\Integration\OAuth2Client;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RolePermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/activity', ActivityUserController::class)->name('activity.index')->middleware('auth');

Route::get('/app', function () {
    return view('layouts.app');
});

Route::get('/register', function () {
    return view('auth.register');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// manajemen user 
Route::prefix('manage-user')->middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::put('user/changestatus/{id}', [UserController::class, 'changeStatus'])->name('user.changeStatus');
    Route::resource('menu', MenuController::class);
    Route::post('submenu', [SubmenuController::class, 'store'])->name('submenu.store');
    Route::put('submenu/{id}', [SubmenuController::class, 'update'])->name('submenu.update');
    Route::delete('submenu/{id}', [SubmenuController::class, 'destroy'])->name('submenu.destroy');
    Route::get('/getPermissionsByApplicationId/{id}', [MenuController::class, 'getPermissionByApplicationId'])->name('permissions.get');
    Route::resource('permission', PermissionController::class)->except(['show', 'edit', 'create']);
    Route::resource('role', RoleController::class)->except(['show', 'edit', 'create']);
    Route::get('/role-permission', RolePermissionController::class)->name('role.permission.manage');
});
// ajax
Route::get('/user-role', [UserController::class, 'assignRole'])->name('user.role');
Route::post('/user/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');


// master data
Route::prefix('master-data')->middleware('auth')->group(function () {
    Route::resource('aplikasi', ApplicationController::class);
});


Route::prefix('v-claimbpjs')->middleware('checkrole:user')->group(function () {
    Route::get('vclaim', [TestController::class, 'index'])->name('v-claimbpjs.dashboard');
});

Route::get('/pasien', function () {
    // $users = Pasien::create([
    //     'no_mr' => '214942',
    //     'nik' => '1807062203970004',
    //     'id_pasien' => 'P00190649673',
    //     'nama_pasien' => 'REZA ANDREAN'
    // ]);
    // dd($users);
    // $registerPasiens = DB::table('bridging.dbo.satusehat_pasien as a')->limit(10)->get();
    // dd($registerPasiens);

    // $client = new OAuth2Client;
    // [$statusCode, $response] = $client->get_by_nik('Patient', '1802111508920002');
    // $data =   $latestNoMR = Pasien::latest('no_mr')->value('no_mr');
    // dd($data);
    // dd($data->entry[0]->resource->name[0]->text);

    // $results =  DB::table('DB_RSMM.dbo.ANTRIAN as a')
    //     ->leftJoin('DB_RSMM.dbo.REGISTER_PASIEN as rp', 'a.No_MR', '=', 'rp.No_MR')
    //     ->leftJoin('DB_RSMM.dbo.PENDAFTARAN as p', 'p.No_MR', '=', 'a.No_MR')
    //     ->leftJoin('PKU.dbo.TAC_RJ_STATUS as trs', 'trs.FS_KD_REG', '=', 'p.No_Reg')
    //     ->where('a.Tanggal', '2022-06-13')
    //     ->where('a.Dokter', '140')
    //     ->where('p.Tanggal', '2022-06-13')
    //     ->where('p.Kode_Dokter', '140')
    //     ->where('trs.FS_STATUS', '!=', 0)
    //     ->whereNotNull('rp.HP2')
    //     ->where('rp.HP2', '!=', '')
    //     ->select(
    //         'a.Nomor as no_antrian',
    //         'p.No_Reg as no_reg',
    //         'a.No_MR as no_mr',
    //         'p.Kode_Dokter as kode_dokter',
    //         'rp.Nama_Pasien as nama_pasien',
    //         'rp.HP2 as nik'
    //     )
    //     ->orderBy('a.Nomor')
    //     ->get();

    // dd($results);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/satusehat.php';
require __DIR__ . '/vclaim.php';
require __DIR__ . '/eclaim.php';
