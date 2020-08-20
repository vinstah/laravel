<?php

use Illuminate\Http\Request;

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

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', 'Auth\RegisterController@register');

Route::group(['middleware' => 'auth:api'], function() {

    Route::put('user/{user}', 'UserController@update');

    Route::get('config', 'ConfigController@index');

    /*Route::get('menus', 'MenusController@index');
    Route::get('categories', 'CategoriesController@index');*/

    Route::get('category/{category}', 'CategoriesController@show');

    Route::get('jobs', 'JobsController@index');
    Route::get('jobs/{job}', 'JobsController@show');
    Route::post('jobs', 'JobsController@store');
    Route::put('jobs/{job}', 'JobsController@update');
    Route::delete('jobs/{job}', 'JobsController@delete');

    Route::get('calculator/{id}', 'CalculatorController@show');
    Route::post('calculator/{id}', 'CalculatorController@calculate');

    Route::post('product/{id}', 'ProductController@addProduct');
    Route::get('product/{id}', 'ProductController@show');

    Route::get('summary/{job}', 'SummaryController@show');
    Route::put('summary/{calculation}', 'SummaryController@update');

    /* test routes */
    Route::get('test/error403', 'TestController@error403');
    Route::get('test/error500', 'TestController@error500');
    Route::get('test/errorValidation', 'TestController@errorValidation');

});