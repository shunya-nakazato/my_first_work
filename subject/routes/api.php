<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/v1/article', 'ArticleController@read');
Route::get('/v1/articles/{login_id}', 'ArticleController@all_read');
Route::get('/v1/category_articles', 'ArticleController@category_read');
Route::post('/v1/app_user/register', 'AppUserController@register');
Route::post('/v1/app_user/login', 'AppUserController@login');
Route::delete('/v1/like/delete', 'LikeController@delete');
Route::post('/v1/like', 'LikeController@index');
// Route::put('/v1/app_user', 'AppUserController@update');
// Route::delete('/v1/app_user/{id}', 'AppUserController@delete');
