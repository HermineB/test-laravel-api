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
Route::post('/categories/add-categories', 'CategoriesController@store');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/categories/add', 'CategoriesController@store');
Route::post('/categories/update', 'CategoriesController@update');
Route::post('/categories/delete', 'CategoriesController@deleteCategory');
Route::get('/categories/get', 'CategoriesController@getCategories');
Route::post('/products/get', 'ProductsController@getProducts');
Route::get('/products/get', 'ProductsController@getProducts');
Route::post('/products/getByCategory', 'ProductsController@getByCategory');
Route::post('/products/getById', 'ProductsController@getById');
Route::post('/products/add', 'ProductsController@store');
Route::post('/products/delete', 'ProductsController@delete');
Route::post('/products/update', 'ProductsController@update');

