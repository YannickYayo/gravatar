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

//LIST AVATAR
Route::get('/user/me',array('uses'=>'GravatarController@avatarListView','as'=>'avatarlist'));

//ADD USER
Route::get('/register',array('uses'=>'GravatarController@newUser','as'=>'newUser'));
Route::post('/registerOK',array('uses'=>'GravatarController@createUser','as'=>'createUser'));

//ADD AVATAR
Route::get('/addAvatar',array('uses'=>'GravatarController@addAvatar','as'=>'addAvatar'));
Route::post('/uploadAvatar',array('uses'=>'GravatarController@uploadAvatar','as'=>'uploadAvatar'));

//DELETE AVATAR
Route::get('/delete/{id}',array('uses'=>'GravatarController@deleteAvatar','as'=>'deleteAvatar'));

//LOGOUT
Route::get('/logout',array('uses'=>'GravatarController@logout','as'=>'logout'));