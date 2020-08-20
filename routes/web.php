<?php

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
    return view('welcome');
});

Route::get('/api/doc', function () {
    return view('api.documentation');
});

Route::get('/products', 'ProductsController@index');
Route::get('/products/create', 'ProductsController@create');
Route::get('/categories/create', 'CategoriesController@create');
Route::get('/categories/store', 'CategoriesController@store');
Route::get('/categories', 'CategoriesController@index');

