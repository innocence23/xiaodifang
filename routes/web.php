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

    Route::get('category/lists', 'CategoryController@getLists')->name('category.lists');
    Route::post('category/{category}', 'CategoryController@disable')->name('category.disable');
    Route::resource('category', 'CategoryController', ['only' =>
        ['index', 'store', 'edit', 'update', 'show']
    ]);

    Route::get('tag/lists', 'TagController@getLists')->name('tag.lists');
    Route::post('tag/{tag}', 'TagController@disable')->name('tag.disable');
    Route::resource('tag', 'TagController', ['only' =>
        ['index', 'store', 'edit', 'update', 'show']
    ]);

    Route::get('post/lists', 'TagController@getLists')->name('post.lists');
    Route::post('post/{post}', 'TagController@disable')->name('post.disable');
    Route::resource('post', 'PostController', ['only' =>
        ['index', 'create', 'store', 'edit', 'update', 'show']
    ]);

    Route::resource('comment', 'CommentController');
//    Route::resource('user', 'UserController');
//    Route::resource('role', 'RoleController');
//    Route::resource('permission', 'PermissionController');

});
