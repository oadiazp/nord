<?php

use App\Http\Controllers\GetScooters;
use App\Http\Controllers\ReceiveEvent;
use Illuminate\Support\Facades\Route;

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

Route::post('/events', ReceiveEvent::class);
Route::get('/scooters/{x1}/{y1}/{x2}/{y2}/{available}', GetScooters::class);
