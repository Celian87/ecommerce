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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
//Home
Route::get('/','StoreController@home');
//Admin
Route::get('/adminConsole','StoreController@adminconsole')->middleware('auth');

//Autenticazione
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//Categories
Route::get('/category/create', 'CategoryController@create')->middleware('auth');
Route::post('/category/create', 'CategoryController@store')->middleware('auth');
Route::get('/category/{category}', 'CategoryController@show')->name('CategoryPage');
Route::get('/category/all/{category}', 'CategoryController@showAll')->middleware('auth');
Route::get('/category/{cetegory}/edit', 'CategoryController@edit')->middleware('auth');
Route::patch('/category/{category}', 'CategoryController@update')->middleware('auth');

//Product
Route::get('/product/create', 'ProductsController@create')->middleware('auth');
Route::post('/product/create', 'ProductsController@store')->middleware('auth');
Route::get('/product/{product}', 'ProductsController@show');
Route::get('/product/NA/{product}', 'ProductsController@showNA')->middleware('auth');
Route::get('/product/{product}/edit', 'ProductsController@edit')->middleware('auth');
Route::patch('/product/{product}', 'ProductsController@update')->middleware('auth');
Route::get('/search','ProductsController@search');

//Cart
Route::get('/cart', 'CartController@index')->middleware('auth');
Route::post('/cart', 'CartController@store')->middleware('auth');
Route::patch('/cart/{cart}', 'CartController@update')->middleware('auth');
Route::delete('/cart/{cart}', 'CartController@destroy')->middleware('auth');

//Orders
Route::get('/orders', 'OrdersController@index')->middleware('auth');
Route::get('/orders/{user}', 'OrdersController@indexAdmin')->middleware('auth');
Route::post('/orders', 'OrdersController@store')->middleware('auth');
