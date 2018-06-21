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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'Admin\FeedController@index')->name('admin.home');

Route::get('/categories', 'Admin\CategoryController@index')->name('categories');
Route::post('category/create', 'Admin\CategoryController@create')->name('categories.create');
Route::post('category/delete', 'Admin\CategoryController@destroy')->name('categories.destroy');

Route::get('feeds', 'Admin\FeedController@index')->name('feeds');
Route::post('feed/create', 'Admin\FeedController@create')->name('feeds.create');
Route::post('feed/delete', 'Admin\FeedController@destroy')->name('feeds.destroy');

Route::get('feeds/{id}/item', 'Admin\FeedController@articles')->name('feeds.articles');
Route::post('feeds/articles', 'Admin\FeedController@addArticles')->name('articles.add');
Route::post('feeds/delete/articles', 'Admin\FeedController@deleteArticles')->name('articles.delete');

Route::get('bookmarks', 'Admin\FeedController@bookmarks')->name('bookmarks');