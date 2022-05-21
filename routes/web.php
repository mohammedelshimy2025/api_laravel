<?php

use App\Http\Controllers\PostController;
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
    return view('auth.login');
});

  Route::group(['prefix' => 'posts' , 'middleware' => 'auth'] , function(){
  Route::get('/' , 'App\Http\Controllers\PostController@index')->name('posts.index');
  Route::get('create' , 'App\Http\Controllers\PostController@create')->name('posts.create');
  Route::post('store' , 'App\Http\Controllers\PostController@store')->name('posts.store');
  Route::get('edit/{id}' , 'App\Http\Controllers\PostController@edit')->name('posts.edit');
  Route::put('update/{id}' , 'App\Http\Controllers\PostController@update')->name('posts.update');
  Route::get('delete/{id}' , 'App\Http\Controllers\PostController@destroy')->name('posts.destroy');


  });





require __DIR__.'/auth.php';
