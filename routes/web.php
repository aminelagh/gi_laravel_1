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


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@   Tech-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'tech'], function () {
  Route::get('/tech', 'TechController@home')->name('tech-dash');

  //updateProfile
  Route::post('/updateTechProfile', 'TechController@updateProfile')->name('tech.updateProfile');

  //add Intervention
  Route::post('/addIntervention', 'TechController@addIntervention')->name('tech.addIntervention');
});




//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@   admin-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'admin'], function () {
  Route::get('/admin','AdminController@home')->name('admin-dash');

  //register users
  Route::get('/register', 'AuthenticationController@register' )->name('admin.register');
  Route::post('/register', 'AuthenticationController@submitRegister' )->name('admin.submitRegister');

  //updateProfile
  Route::post('/updateAdminProfile', 'AdminController@updateProfile')->name('admin.updateProfile');

  //Famille --------------------------------------------------------------------
  Route::post('/addFamille', 'AdminController@addFamille')->name('addFamille');
  Route::post('/updateFamille', 'AdminController@updateFamille')->name('updateFamille');
  Route::post('/deleteFamille', 'AdminController@deleteFamille')->name('deleteFamille');

  //Equipement -----------------------------------------------------------------
  Route::post('/addEquipement', 'AdminController@addEquipement')->name('addEquipement');
  Route::post('/updateEquipement', 'AdminController@updateEquipement')->name('updateEquipement');
  Route::post('/deleteEquipement', 'AdminController@deleteEquipement')->name('deleteEquipement');

  //Type_intervention ----------------------------------------------------------
  Route::post('/addType_intervention', 'AdminController@addType_intervention')->name('addType_intervention');
  Route::post('/updateType_intervention', 'AdminController@updateType_intervention')->name('updateType_intervention');
  Route::post('/deleteType_intervention', 'AdminController@deleteType_intervention')->name('deleteType_intervention');

  //Technicien -----------------------------------------------------------------
  Route::post('/addTechnicien', 'AdminController@addTechnicien')->name('addTechnicien');
  Route::post('/updateTechnicien', 'AdminController@updateTechnicien')->name('updateTechnicien');
  Route::post('/deleteTechnicien', 'AdminController@deleteTechnicien')->name('deleteTechnicien');

  //pdf ------------------------------------------------------------------------
  Route::post('/printI','pdfController@printInterventions')->name('printInterventions');
  Route::post('/printT','pdfController@printTechniciens')->name('printTechniciens');
  Route::post('/printE','pdfController@printEquipements')->name('printEquipements');
  Route::post('/printF','pdfController@printFamilles')->name('printFamilles');

});

//Authentification
//login
Route::get('/login', 'AuthenticationController@login')->name('login');
Route::post('/login', 'AuthenticationController@submitLogin')->name('submitLogin');

//logout
Route::get('/logout', 'AuthenticationController@logout')->name('logout');

//error Routes
Route::get('{any}', function () {
  return redirect()->back()->with('alert_warning',"Oups !<br>il paraît que vous avez pris le mauvais chemin");
});
