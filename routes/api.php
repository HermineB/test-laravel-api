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

Route::middleware('api.token:api')->post('/categories/add', 'CategoriesController@store');
Route::middleware('AuthKey:api')->post('/categories/update', 'CategoriesController@update');
Route::middleware('AuthKey:api')->post('/categories/delete', 'CategoriesController@deleteCategory');
Route::middleware('AuthKey:api')->post('/products/add', 'ProductsController@store');
Route::middleware('AuthKey:api')->post('/products/delete', 'ProductsController@delete');
Route::middleware('AuthKey:api')->post('/products/update', 'ProductsController@update');
Route::get('/categories/get', 'CategoriesController@getCategories');
Route::post('/products/get', 'ProductsController@getProducts');
Route::get('/products/get', 'ProductsController@getProducts');
Route::post('/products/getByCategory', 'ProductsController@getByCategory');
Route::post('/products/getById', 'ProductsController@getById');


