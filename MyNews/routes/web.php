<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
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
Route::controller(NewsController::class)->group(function () {
    Route::get('/', 'test');
    Route::get('/create', 'create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{news}','show')->name('show');

});
