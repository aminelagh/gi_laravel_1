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

Route::get('/e','ExcelController@e1' );

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

  //pdf ------------------------------------------------------------------------
  Route::post('/printITech','pdfController@printInterventionsTech')->name('printInterventionsTech');

  //export to Excel ------------------------------------------------------------
  Route::post('/exportITech','ExcelController@exportInterventionsTech')->name('exportInterventionsTech');
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
  Route::post('/addUser', 'AdminController@addUser')->name('addUser');
  Route::post('/updateUser', 'AdminController@updateUser')->name('updateUser');
  Route::post('/deleteUser', 'AdminController@deleteUser')->name('deleteUser');

  //pdf ------------------------------------------------------------------------
  Route::post('/printI','pdfController@printInterventions')->name('printInterventions');
  Route::post('/printU','pdfController@printUsers')->name('printUsers');
  Route::post('/printE','pdfController@printEquipements')->name('printEquipements');
  Route::post('/printF','pdfController@printFamilles')->name('printFamilles');
  Route::post('/printStats','pdfController@printStats')->name('printStats');

  //export to Excel ------------------------------------------------------------
  Route::post('/exportI','ExcelController@exportInterventions')->name('exportInterventions');
  Route::post('/exportU','ExcelController@exportUsers')->name('exportUsers');
  Route::post('/exportE','ExcelController@exportEquipements')->name('exportEquipements');
  Route::post('/exportF','ExcelController@exportFamilles')->name('exportFamilles');
  Route::post('/exportF2','ExcelController@exportFamilles2')->name('exportFamilles2');
  Route::post('/exportStats','ExcelController@exportStats')->name('exportStats');

  //stats ----------------------------------------------------------------------
  Route::get('/stats','AdminController@stats')->name('stats');
  Route::post('/stats','AdminController@stats')->name('submitStats');



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
