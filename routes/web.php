<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\TahunAjarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleMenusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

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
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified', 'cekRole'])->name('dashboard');

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/getRole', [ProfileController::class, 'getRole'])->name('profile.getRole');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

Route::middleware(['auth', 'cekRole'])->group(function () {

    Route::prefix('blog')->group(function () {
        foreach (['index', 'table'] as $key => $value) {
            Route::get($value == 'index' ? '/' : $value, [BlogController::class, $value])->name('blog.' . $value);
        }
        foreach (['store', 'show', 'destroy'] as $key => $value) {
            Route::post($value == 'store' ? '/' : $value, [BlogController::class, $value])->name('blog.' . $value);
        }
    });

    Route::prefix('role-menu')->group(function () {
        foreach (['index', 'table'] as $key => $value) {
            Route::get($value == 'index' ? '/' : $value, [RoleMenusController::class, $value])->name('role.' . $value);
        }
        foreach (['store', 'show', 'destroy', 'saveRoleMenu', 'showRole'] as $key => $value) {
            Route::post($value == 'store' ? '/' : $value, [RoleMenusController::class, $value])->name('role.' . $value);
        }
    });

    Route::prefix('configuration')->group(function () {
        foreach (['index', 'getConfig'] as $key => $value) {
            Route::get($value == 'index' ? '/' : $value, [ConfigurationController::class, $value])->name('configuration.' . $value);
        }
        foreach (['store', 'show', 'destroy', 'uploadLogo'] as $key => $value) {
            Route::post($value == 'store' ? '/' : $value, [ConfigurationController::class, $value])->name('configuration.' . $value);
        }
    });

    Route::prefix('user')->group(function () {
        foreach (['index', 'table', 'getRoles'] as $key => $value) {
            Route::get($value == 'index' ? '/' : $value, [UserController::class, $value])->name('user.' . $value);
        }
        foreach (['store', 'show', 'destroy'] as $key => $value) {
            Route::post($value == 'store' ? '/' : $value, [UserController::class, $value])->name('user.' . $value);
        }
    });
});

require __DIR__ . '/auth.php';
