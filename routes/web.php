<?php

use App\Http\Middleware\CheckAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Jobs\WriteToLog;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

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

Route::get('/weather', function () {
    $city = request('city') ?? 'Kyiv';
    $apiKey = 'ff1ee38d76df76dc57a73eef9d5cc2ec';

    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=ua";

    $client = new Client();
    $response = $client->request('GET', $url);

    $data = $response->getBody();

    return response($data)
        ->header('Content-Type', 'application/json');
});
