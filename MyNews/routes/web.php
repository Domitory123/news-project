<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TagController;
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
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/show/{news}','show')->name('news.show');
    Route::get('/edit/{news}','edit')->name('news.edit');
    Route::put('/update/{news}', 'update')->name('news.update');
    Route::get('/showdestroy/{news}','showDestroy')->name('news.showDestroy');
    Route::delete('/destroy/{news}','destroy')->name('news.destroy');
    Route::get('/destroyInfo','destroyInfo')->name('news.destroyInfo');
    
});

Route::controller(TagController::class)->group(function () {
    
    Route::get('/delete/{tag}', 'destroy')->name('tag.delete');
  
});