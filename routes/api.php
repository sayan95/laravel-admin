<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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


Route::group(['prefix' => 'admin-auth'], function(){
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('register', [RegisterController::class, 'register'])->name('admin.register');
});



Route::group(['middleware' => 'auth:api', 'prefix' => 'users'], function(){
    Route::get('/', [UserController::class, 'index'])->name('user.all');
    Route::get('/{id}', [UserController::class, 'show'])->name('user');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});