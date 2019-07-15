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
    return view('agenda_eletronica');
});


Route::resource('contacts', 'ContactController');
Route::resource('companies', 'MessageController');

Route::get('/novo-contato', 'ContactController@index')->name('new-contact');
Route::get('/nova-mensagem', 'MessageController@index')->name('new-message');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
