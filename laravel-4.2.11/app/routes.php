<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',array('uses'=>'GravatarController@index','as'=>'home'));
Route::get('/login',array('uses'=>'GravatarController@viewLogin','as'=>'login'));
Route::post('/user/me',array('uses'=>'GravatarController@login','as'=>'logMe'));
