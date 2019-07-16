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



Route::get('/contatos', 'ContactController@viewContacts')->name('new-contact');
Route::get('/nova-mensagem', 'MessageController@viewNewMessage')->name('new-message');
Route::get('/mensagens-contato/{id}', 'MessageController@messagesContact')->name('message-contact');
Route::get('/mensagens/{name}', 'MessageController@viewMessageContact')->name('message-contact');
