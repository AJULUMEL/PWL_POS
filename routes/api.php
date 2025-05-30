<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\LevelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('levels', [LevelController::class, 'index']);
Route::post('levels', [LevelController::class, 'store']);
Route::get('levels/{level}', [LevelController::class, 'show']);
Route::put('levels/{level}', [LevelController::class, 'update']);
Route::delete('levels/{level}', [LevelController::class, 'destroy']);

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);

Route::get('kategori', [\App\Http\Controllers\Api\KategoriController::class, 'index']);
Route::post('kategori', [\App\Http\Controllers\Api\KategoriController::class, 'store']);
Route::get('kategori/{kategori}', [\App\Http\Controllers\Api\KategoriController::class, 'show']);
Route::put('kategori/{kategori}', [\App\Http\Controllers\Api\KategoriController::class, 'update']);
Route::delete('kategori/{kategori}', [\App\Http\Controllers\Api\KategoriController::class, 'destroy']);

Route::get('barang', [\App\Http\Controllers\Api\BarangController::class, 'index']);
Route::post('barang', [\App\Http\Controllers\Api\BarangController::class, 'store']);
Route::get('barang/{barang}', [\App\Http\Controllers\Api\BarangController::class, 'show']);
Route::put('barang/{barang}', [\App\Http\Controllers\Api\BarangController::class, 'update']);
Route::delete('barang/{barang}', [\App\Http\Controllers\Api\BarangController::class, 'destroy']);


