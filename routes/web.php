<?php

use App\Http\Middleware\CheckAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Jobs\WriteToLog;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client; // Не забудьте імпортувати клієнта Guzzle.

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

# Cache
Route::get('/cache-get', function () {
    $key = request('key');

    if (!$key) {
        return 'Key required!';
    }

    // Try to retrieve the value from cache.
    $value = Cache::get($key, 'Value does not exist.');

    return 'Value from cache: ' . $value;
});
Route::get('/cache-set', function () {
    $key = request('key');
    $value = request('value');

    if (!$key || !$value) {
        return 'Key and value required!';
    }

    // Store the value in the cache for 24 hours.
    Cache::put($key, $value, now()->addHours(24));

    return 'Value set in cache!';
});

# API weather
Route::get('/weather', function () {
    // Тут буде логіка обробки запиту
});
