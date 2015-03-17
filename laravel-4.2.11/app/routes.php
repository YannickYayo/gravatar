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

//HOMEPAGE
Route::get('/',array('uses'=>'GravatarController@index','as'=>'home'));

//LOGIN
Route::get('/login',array('uses'=>'GravatarController@viewLogin','as'=>'login'));
Route::post('/user/me',array('uses'=>'GravatarController@login','as'=>'logMe'));

//ADD USER
Route::get('/register',array('uses'=>'GravatarController@newUser','as'=>'newUser'));
Route::post('/registerOK',array('uses'=>'GravatarController@createUser','as'=>'createUser'));