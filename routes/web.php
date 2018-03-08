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





Route::get('/s', function () {
  dump(Session::all());
});

Route::get('/', function () {
  return view('welcome');
})->name('welcome');

//routes protected by Tech-Middleware
Route::group(['middleware' => 'tech'], function () {
  Route::get('/tech', 'TechController@home')->name('tech-dash');

});

//routes protected by Admin-Middleware
Route::group(['middleware' => 'admin'], function () {
  Route::get('/admin','AdminController@home')->name('admin-dash');

  //register users
  Route::get('/register', 'AuthenticationController@register' )->name('admin.register');
  Route::post('/register', 'AuthenticationController@submitRegister' )->name('admin.submitRegister');

  //profile
  Route::get('/profile', function(){ return "Profile"; } )->name('admin.profile');

});


Route::get('/e', function(){
  return view('example');
});

//Authentification


//login
Route::get('/login', 'AuthenticationController@login')->name('login');
Route::post('/login', 'AuthenticationController@submitLogin')->name('submitLogin');

//logout
Route::get('/logout', 'AuthenticationController@logout')->name('logout');
