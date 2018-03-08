<?php

namespace App\Http\Controllers;

use \Exception;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\User;
use \App\Models\Role_user;
use \App\Models\Famille;


class AdminController extends Controller
{
  public function home(){
    //dump(Session::get('nom'));
    //$user = User::all();
    //dump($user);
    $familles = Famille::all();
    /*foreach ($familles as $famille) {
      dump($famille->id_famille." ".$famille->description);
    }*/
    return view('admin.dashboard')->withFamilles($familles);//->with('alert_info',"Welcome");
  }

  public function submitAddFamille(Request $request){
    return "Admin dashBoard";
  }

  public function submitAddEquipement(Request $request){
    return "Admin dashBoard";
  }

  public function submitAddTypeIntervention(Request $request){
    return "Admin dashBoard";
  }



  //register
  public function register(){
    $roles = Role::all();
    return view('admin.register')->withRoles($roles);
  }

  //valider l'enregistremenet de l'utilisateur
  public function submitAddUser(Request $request){
    //ajouter et activer le compte de l'utilisateur
    try{
      $user = Sentinel::registerAndActivate($request->all());
    }catch(Exception $e){
      return redirect('/register')->withAlertDanger("Erreur de création de l'utilisateur. Message d'erreur: ".$e->getMessage()." ");
    }
    //chercher le role pour l'utilisateur
    $role = Sentinel::findRoleBySlug($request->role_slug);
    //associer le role a l'utilisateur
    $role->users()->attach($user);

    return redirect('/register')->with('alertSuccess',"Création de l'utilisateur réussie");
  }

}
