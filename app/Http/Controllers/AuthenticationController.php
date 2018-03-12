<?php

namespace App\Http\Controllers;

use \Exception;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\Role_user;

class AuthenticationController extends Controller
{


  //login *****************************************************************************
  public function login(){
    if( Sentinel::check() ){
      //function's body bollow
      return self::redirectToSpace();
    }
    else{
      return view('login');
    }
  }

  //Authentification ******************************************************************
  public function submitLogin(Request $request){

    try {
      if (request()->has('remember'))
      $user = Sentinel::authenticateAndRemember(request()->all());
      else
      $user = Sentinel::authenticate(request()->all());

      if (Sentinel::check()) {
        Session::put('id_user', $user->id);
        Session::put('role', $this->getRole());
        Session::put('login', $user->login);
        Session::put('nom', $user->nom);
        Session::put('prenom', $user->prenom);

        return $this->redirectToSpace();

      } else return redirect()->back()->withInput()->withAlertWarning("<b>login et/ou mot de passe incorrect</b>")->withTimerWarning(2000);

    } catch (ThrottlingException $e) {

      return redirect()->back()->withInput()->with('alert_success', "<b>Une activité suspecte s'est produite sur votre adresse IP, l'accès vous est refusé pour " . $e->getDelay() . " seconde (s)</b>")->withTimerDanger($e->getDelay() * 1000);

    }
  }

  //Deconnexion ***********************************************************************
  public function logout(){
    Sentinel::logout();
    Session::flush();
    return redirect('/');
  }

  //redirect to proper dashboard ******************************************************
  private static function redirectToSpace(){
    if( Sentinel::inRole('admin') ){
      return redirect()->route('admin-dash');
    }elseif( Sentinel::inRole('tech') ){
      return redirect()->route('tech-dash');
    }else{
      return redirect()->route('errorPage')->withAlertDanger("Le rôle de l'utilisateur authentifié n'est pas répertorié, veuillez contacter l'administrateur de l'application.");
    }
  }

  //return role of the current users **************************************************
  public function getRole()
  {
    if (Sentinel::inRole('admin')){
      return "admin";
    }
    elseif(Sentinel::inRole('tech')){
      return "tech";
    }
  }


  /*
  public function submitLogin(Request $request){

  try{
  $user = Sentinel::authenticate($request->all());
}catch(Exception $e){
return redirect()->back()->withAlertDanger("Erreur d'Authentification. Message d'erreur: ".$e->getMessage()." ");
}

if( Sentinel::check() ){
//function's body bollow
return self::redirectToSpace();
}
else {
return redirect()->route('login')->withAlertWarning("Login et/ou Mot de passe incorrect")->withInput();
}
}

public function logout(){
Sentinel::logout();
return redirect('/');
}
*/

}
