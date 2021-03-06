<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/getWxToken', 'WxAPIController@get_access_token');

Route::get('/testPage', 'WxAPIController@test');

Route::post('/wx_upload',  'WxUploadController@upload');
Route::get('/wx_download', 'WxUploadController@download');