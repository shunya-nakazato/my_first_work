<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'ArticleController@index')->name('home');
Route::get('/article/create', 'ArticleController@create')->name('article_create');
Route::post('/article/store', 'ArticleController@store')->name('article_store');
Route::post('/article/category/store', 'CategoryController@store')->name('category_store');
// Route::get('/article/image/create', 'ImageController@create')->name('image_create');
// Route::post('/article/image/confirm', 'ImageController@confirm')->name('image_confirm');
Route::get('/article/detail/{id}', 'ArticleController@detail')->name('article_detail');
Route::post('/article/edit', 'ArticleController@edit')->name('article_edit');
Route::post('/article/delete', 'ArticleController@delete')->name('article_delete');
Route::get('/app_user/list', 'AppUserController@index')->name('app_user_index');
Route::get('/app_user/detail/{id}', 'AppUserController@detail')->name('app_user_detail');
Route::get('/category', 'CategoryController@index')->name('category_list');
Route::post('category/edit', 'CategoryController@edit')->name('category_edit');
Route::post('category/delete', 'CategoryController@delete')->name('category_delete');


