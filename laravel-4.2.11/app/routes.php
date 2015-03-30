<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Toutes les routes sont reno� de mani�re claire avec l'attribut 'as'
| 
|
*/

//HOMEPAGE
Route::get('/',array('uses'=>'GravatarController@index','as'=>'home'));

//LOGIN
Route::get('/login',array('uses'=>'GravatarController@viewLogin','as'=>'login'));
Route::post('/user/me',array('uses'=>'GravatarController@login','as'=>'logMe'));

//LIST AVATAR
Route::get('/user/me',array('before'=>'auth','uses'=>'GravatarController@avatarListView','as'=>'avatarlist'));

//ADD USER
Route::get('/register',array('uses'=>'GravatarController@newUser','as'=>'newUser'));
Route::post('/registerOK',array('uses'=>'GravatarController@createUser','as'=>'createUser'));

//ADD AVATAR
Route::get('/addAvatar',array('before'=>'auth','uses'=>'GravatarController@addAvatar','as'=>'addAvatar'));
Route::post('/uploadAvatar',array('before'=>'auth','uses'=>'GravatarController@uploadAvatar','as'=>'uploadAvatar'));

//DELETE AVATAR
Route::get('/delete/{randomString}',array('before'=>'auth','uses'=>'GravatarController@deleteAvatar','as'=>'deleteAvatar'));

//LOGOUT
Route::get('/logout',array('before'=>'auth','uses'=>'GravatarController@logout','as'=>'logout'));

//Api
Route::controller('/api', 'ApiController');