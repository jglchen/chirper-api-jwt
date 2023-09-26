<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\UserFollowController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::resource('chirps', ChirpController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->middleware(['auth:api', 'verified']);

Route::get('/myfollowings',  [UserFollowController::class, 'myfollowings'])
            ->middleware(['auth:api', 'verified'])
            ->name('myfollowings');

Route::resource('userfollow', UserFollowController::class)
            ->only(['store', 'destroy'])
            ->middleware(['auth:api', 'verified']);

require __DIR__.'/auth.php';
