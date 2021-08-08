<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// admin authentication routes
Route::group(['prefix' => 'admin-auth'], function(){
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('register', [RegisterController::class, 'register'])->name('admin.register');

    Route::group(['middleware' => 'auth:api'], function(){
        route::post('logout', [LogoutController::class, 'logout'])->name('admin.logout');
    });
});

// authorization (roles, permission) related routes
Route::middleware('auth:api')->group(function(){
    // Route::prefix('roles')->group(function(){
    //     Route::get('/', [RoleController::class, 'index'])->name('roles.all');
    //     Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
    //     Route::put('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    //     Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    // });
});

// admin profile activity routes
Route::middleware('auth:api')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'profile'])->name('admin.profile');
    Route::put('info', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('password', [ProfileController::class, 'updatePassword'])->name('admin.password');
});


// user & user profile based routes
Route::group(['middleware' => 'auth:api', 'prefix' => 'users'], function(){
    Route::get('/', [UserController::class, 'index'])->name('user.all');
    Route::get('/{id}', [UserController::class, 'show'])->name('user');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});