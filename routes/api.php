<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
//});

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/profile', [AuthController::class, 'profile']);
});


Route::group(['prefix' => 'posts'] , function(){
  Route::get('/' , 'App\Http\Controllers\Api\PostController@index');
  Route::get('post/{id}' , 'App\Http\Controllers\Api\PostController@show');
  Route::post('save' , 'App\Http\Controllers\Api\PostController@save');
  Route::post('post/{id}' , 'App\Http\Controllers\Api\PostController@update');
  Route::post('delete/{id}' , 'App\Http\Controllers\Api\PostController@delete');



});
