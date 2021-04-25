<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', '\App\Http\Controllers\UserController@register');
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('login', '\App\Http\Controllers\UserController@authenticate');
    Route::get('userlist', '\App\Http\Controllers\UserController@getAll');
    Route::get('approve', '\App\Http\Controllers\UserController@approve');
    Route::get('useredit', '\App\Http\Controllers\UserController@update');
    Route::get('edit', '\App\Http\Controllers\UserController@edit');
    Route::get('delete', '\App\Http\Controllers\UserController@delete');
    
});
