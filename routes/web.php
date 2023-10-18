<?php

use App\Http\Middleware\CheckAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Jobs\WriteToLog;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dispatch-job', function () {
    WriteToLog::dispatch("This message will be logged.");

    return "Job has been queued!";
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware(CheckAuthenticated::class);
});

Route::resource('posts', 'PostController');
