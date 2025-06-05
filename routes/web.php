<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['guest'])->group(function () {
Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/dashboard/peta-interaktif', [DashboardController::class, 'map']);

    Route::get('/dashboard/ndvi-map', [DashboardController::class, 'ndvimap']);

    Route::get('/dashboard/ndvi-data', [DashboardController::class, 'getNdviData'])->name('dashboard.ndvi.data');

    Route::get('/dashboard/settings', [DashboardController::class, 'editProfile'])->name('dashboard.settings');
    Route::post('/dashboard/settings', [DashboardController::class, 'updateProfile'])->name('dashboard.settings.update');

});



Route::prefix('dashboard')->middleware(['auth', 'role:Administrator'])->group(function () {
    Route::resource('users-management', UserController::class);

    Route::get('/ndvi-update', [DashboardController::class, 'showNdvi'])->name('dashboard.ndvi.show');
    Route::post('/ndvi-update', [DashboardController::class, 'updateNdvi'])->name('dashboard.ndvi.update');

    Route::post('/ndvi-upload', [DashboardController::class, 'updateNdviCsv'])->name('dashboard.ndvi.upload');

});


