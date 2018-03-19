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
use \App\Models\Type_intervention;
use \App\Models\Equipement;
use \App\Models\Intervention;
use \DB;

class TechController extends Controller
{
  public function home(){
    //$this->updateSession();
    //$familles = Famille::orderBy('created_at', 'desc')->get();
    $equipements = collect(DB::select('SELECT id_equipement, e.id_famille, e.description as description_e, f.description as description_f  FROM equipements e LEFT JOIN familles f ON e.id_famille=f.id_famille ORDER BY f.description desc'));
    //$techs = collect(DB::select("select * from users u where u.id in (select user_id from role_users where role_id in (select id from roles where slug='tech')) order by u.created_at desc;"));
    $type_interventions = Type_intervention::orderBy('created_at', 'asc')->get();
    //$interventions = Intervention::all();

    $interventions = collect(DB::select("select
    i.description, i.date, i.duree, i.created_at,
    ti.nom as nom_ti, ti.description as description_ti,
    e.description as description_e,
    f.description as description_f,
    u.nom as nom_u, u.prenom as prenom_u, u.login as login_u
    from
    interventions i left join type_interventions ti on i.id_type_intervention = ti.id_type_intervention
    left join users u on i.id_user = u.id
    left join equipements e on e.id_equipement = i.id_equipement
    left join familles f on e.id_famille = f.id_famille
    order by i.created_at desc"));
    //foreach($data as $i)
    //dump($i);

    return view('tech.dashboard')->with('type_interventions',$type_interventions)->withEquipements($equipements)->withInterventions($interventions);
  }

  //update Profile *************************************************************
  public function updateProfile(Request $request){
    try{
      $item = User::find($request->id);
      $item->nom = $request->nom;
      $item->prenom = $request->prenom;
      $item->login = $request->login;
      if( $request->password != "" ){
        $item->password = password_hash($request->password, PASSWORD_DEFAULT);
      }
      $item->save();
      $this->updateSession();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de modification de votre profile.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Modification du profile réussi");
  }

  //addIntervention ************************************************************
  public function addIntervention(Request $request){
    try{
      $item = new Intervention();
      $item->id_type_intervention = $request->id_type_intervention;
      $item->id_equipement = $request->id_equipement;
      $item->description = $request->description;
      $item->id_user = Session::get('id_user');
      $item->date = $request->date." ".$request->heure;
      $item->duree = $request->duree;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'intervention.<br> Message d'erreur: ".$e->getMessage());
    }
    return redirect()->back()->with('alert_success',"Création de l'intervention réussie");
  }

  //updating Session variable after updating the current user's Profil
  public static function updateSession(){
    try{
      $user = User::find(Session::get('id_user'));
      Session::put('login', $user->login);
      Session::put('nom', $user->nom);
      Session::put('prenom', $user->prenom);
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de mise a jour de votre session.<br>Message d'erreur: ".$e->getMessage());
    }
  }
}
