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

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

//    Route::get('category/lists', 'CategoryController@getLists')->name('category.lists');
//    Route::put('category/{id}', 'CategoryController@disable')->name('category.disable');
//    Route::resource('category', 'CategoryController', ['only' =>
//        ['index', 'store', 'edit', 'show', 'update']
//    ]);


    Route::get('category', 'CategoryController@index')->name('category.index');
    Route::post('category', 'CategoryController@store')->name('category.store');
    Route::get('category/{id}/edit', 'CategoryController@edit')->name('category.edit');
    Route::post('category/{id}', 'CategoryController@update')->name('category.update');
    Route::put('category/{id}', 'CategoryController@disable')->name('category.disable');
    Route::get('category/lists', 'CategoryController@getLists')->name('category.lists');

    Route::get('tag', 'TagController@index')->name('tag.index');
    Route::post('tag', 'TagController@store')->name('tag.store');
    Route::get('tag/{id}/edit', 'TagController@edit')->name('tag.edit');
    Route::post('tag/{id}', 'TagController@update')->name('tag.update');
    Route::put('tag/{id}', 'TagController@disable')->name('tag.disable');
    Route::get('tag/lists', 'TagController@getLists')->name('tag.lists');

    Route::get('post', 'PostController@index')->name('post.index');
    Route::get('post/create', 'PostController@create')->name('post.create');
    Route::post('post', 'PostController@store')->name('post.store');
    Route::get('post/{id}/edit', 'PostController@edit')->name('post.edit');
    Route::post('post/{id}', 'PostController@update')->name('post.update');
    Route::put('post/{id}', 'PostController@disable')->name('post.disable');
    Route::get('post/lists', 'PostController@getLists')->name('post.lists');

    Route::resource('comment', 'CommentController');
//    Route::resource('user', 'UserController');
//    Route::resource('role', 'RoleController');
//    Route::resource('permission', 'PermissionController');

});
