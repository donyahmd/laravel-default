<?php

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

include_once('setup.php');

Route::middleware(['installed'])->group( function () {
    Route::get('/', 'HomeController@index');
});
Route::resource('loas', 'LoaController');Route::resource('loaas', 'LoaaController');Route::resource('loaaaas', 'LoaaaaController');Route::resource('fikris', 'FikriController');Route::resource('fikris', 'FikriController');Route::resource('fikrias', 'FikriaController');Route::resource('fikriaaawdwas', 'FikriaAawdwaController');Route::resource('fikriaws', 'FikriAwController');Route::resource('fikriaws', 'FikriAwController');Route::resource('fikriawawds', 'FikriAwawdController');Route::resource('fikrials', 'FikriAlController');Route::resource('fikrialls', 'FikriAllController');