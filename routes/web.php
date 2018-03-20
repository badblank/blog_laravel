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

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/welcome',function(){
    return view('welcome');
});

Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});

Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'postId: '.$postId.' commentId: '.$commentId;
});*/

Route::get('test', 'IndexController@index');

Route::get('/','Home\IndexController@index');
Route::get('/cate/{cate_id}','Home\IndexController@cate');
Route::get('/article/{art_id}','Home\IndexController@article');
Route::any('admin/login','Admin\LoginController@Login');

Route::get('admin/code','Admin\LoginController@Code');
Route::get('admin/getcode','Admin\LoginController@getcode');


//分组路由
Route::group(['middleware' => ['web','admin.login'],'prefix' => 'admin','namespace' => 'Admin'],function(){
    Route::get('index','AdminController@index');
    Route::get('info','AdminController@info');
    Route::get('quit','AdminController@quit');
    Route::any('pass','AdminController@pass');

    Route::post('cate/changeorder','CategoryController@changeOrder');
    Route::post('links/changeorder','LinksController@changeOrder');
    Route::post('navs/changeorder','NavsController@changeOrder');
    Route::post('config/changeorder','ConfigController@changeOrder');
    Route::post('config/changecontent','ConfigController@changeContent');
    Route::get('config/putfile','ConfigController@putFile');

    Route::any('upload','CommonController@upload');
    //资源路由
    Route::resource('category', 'CategoryController');
    Route::resource('article','ArticleController');
    Route::resource('links','LinksController');
    Route::resource('navs','NavsController');
    Route::resource('config','ConfigController');
});
