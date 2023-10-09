<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

Route::controller(UserController::class)->group(function () {
    Route::get('registration/', 'getSigUp')->name('registration.getSigUp');
    Route::post('registration/', 'postSigUp')->name('registration.postSigUp');
    Route::get('login/', 'getSigin')->name('getSigin');
    Route::post('login/', 'postSigin')->name('postSigin');
    Route::get('logout/', 'logout')->name('logout');
    
});

Route::controller(AdminController::class)->group(function () {
   
    Route::get('/admin','index')->middleware('сheckAdmin')->name('admin.index');
  
});