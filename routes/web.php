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

    Route::resource('post', 'PostController');


    Route::get('category', 'CategoryController@index')->name('category.index');
    Route::post('category', 'CategoryController@store')->name('category.store');
    Route::get('category/{id}/edit', 'CategoryController@edit')->name('category.edit');
    Route::post('category/{id}', 'CategoryController@update')->name('category.update');
    Route::put('category/{id}', 'CategoryController@disable')->name('category.disable');
    Route::get('category/lists', 'CategoryController@getLists')->name('category.lists');

    Route::resource('tag', 'TagController');
    Route::resource('comment', 'CommentController');
//    Route::resource('user', 'UserController');
//    Route::resource('role', 'RoleController');
//    Route::resource('permission', 'PermissionController');

});
