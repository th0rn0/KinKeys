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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'KeyboardFeatureController@index')->name('feature.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/keyboards/submit', 'KeyboardController@submit')->name('keyboards');

// Route::get('/keyboards/submit', 'KeyboardController@store')->name('submitKeyboard')

// Route::post('/keyboards/submit', 'KeyboardController@store')->name('keyboards.submit');

// Route::resource('keyboards', 'KeyboardController');

Route::get('keyboards', 'KeyboardController@index')->name('keyboard.index');
Route::get('keyboards/create', 'KeyboardController@create')->name('keyboard.create')->middleware('auth');
Route::get('keyboards/{slug}/edit', 'KeyboardController@edit')->name('keyboard.edit')->middleware('auth');
Route::get('keyboards/{slug}', 'KeyboardController@show')->name('keyboard.show');
Route::post('keyboards', 'KeyboardController@store')->name('keyboard.store')->middleware('auth');
Route::post('keyboards/{slug}/update', 'KeyboardController@update')->name('keyboard.update')->middleware('auth');
Route::post('keyboards/{slug}/vote', 'KeyboardController@vote')->name('keyboard.vote')->middleware('auth');

Route::get('me', 'MeController@index');