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
use \DB;


class AdminController extends Controller{

  public function home(){
    $familles = Famille::orderBy('created_at', 'desc')->get();
    $roles = Role::all();
    $equipements = collect(DB::select('SELECT id_equipement, e.id_famille, e.description as description_e, f.description as description_f  FROM equipements e LEFT JOIN familles f ON e.id_famille=f.id_famille ORDER BY e.created_at desc'));
    //$techs = collect(DB::select("select * from users u where u.id in (select user_id from role_users where role_id in (select id from roles where slug='tech')) order by u.created_at desc;"));
    $users = collect(DB::select("select u.id as id_user,u.nom, u.prenom,r.slug,r.name,u.last_login,u.created_at,u.login from users u LEFT JOIN role_users ru on ru.user_id = u.id LEFT JOIN roles r on r.id = ru.role_id;"));
    /*foreach ($users as $item) {
    dump($item);
  }
  dd($users);*/
  $type_interventions = Type_intervention::orderBy('created_at', 'desc')->get();
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
  return view('admin.dashboard')->withFamilles($familles)->withRoles($roles)->with('type_interventions',$type_interventions)->withEquipements($equipements)->withUsers($users)->withInterventions($interventions);
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
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//Stats **********************************************************************
public function stats(Request $request){

  $where_id_equipement = "";
  $where_type_intervention = "";
  $where_id_user = "";
  $where_id_famille = "";

  if($request->has('submitFiltre')){
    if($request->id_famille != 'null' ) {
      $id_famille = $request->id_famille;
      $where_id_famille = " and i.id_equipement in (select id_famille from familles where id_famille = ".$id_famille.") ";
    }

    if($request->id_equipement != 'null' ) {
      $id_equipement = $request->id_equipement;
      $where_id_equipement = " and i.id_equipement = ".$id_equipement." ";
    }

    //where id_type_intervention = X
    if($request->id_type_intervention != 'null' ) {
      $id_type_intervention = $request->id_type_intervention;
      $where_type_intervention = " and i.id_type_intervention = ".$id_type_intervention." ";
    }

    if($request->id_technicien != 'null' ) {
      $id_technicien = $request->id_technicien;
      $where_id_user = " and i.id_user = ".$id_technicien." ";
    }
  }


  $data = collect(DB::select("
  SELECT
  month(date) as month,YEAR(date) AS year,
  sum(duree) as duree,
  sum(hour(duree)) as h,sum(minute(duree)) as m,sum(second(duree)) as s,
  sum( SECOND(duree)/3600 + MINUTE(duree)/60 + HOUR(duree)) as 'totalH',
  sum( SECOND(duree)/60 + MINUTE(duree) + HOUR(duree)*60 ) as 'totalM',
  sum( SECOND(duree) + MINUTE(duree)*60 + HOUR(duree)*3600) as 'totalS'
  FROM interventions i
  WHERE true " . $where_type_intervention . " ".$where_id_famille." ".$where_id_equipement." ".$where_id_user."
  GROUP BY MONTH(date),YEAR(date)
  ORDER BY YEAR(date),MONTH(date) ;"));

  $interventions = collect(DB::select("
  select i.description, i.date, i.duree, i.created_at,
  ti.nom as nom_ti, ti.description as description_ti,
  e.description as description_e,
  f.description as description_f,
  u.nom as nom_u, u.prenom as prenom_u, u.login as login_u
  from
  interventions i left join type_interventions ti on i.id_type_intervention = ti.id_type_intervention
  left join users u on i.id_user = u.id
  left join equipements e on e.id_equipement = i.id_equipement
  left join familles f on e.id_famille = f.id_famille
  WHERE true ".$where_type_intervention." ".$where_id_famille." ".$where_id_equipement." ".$where_id_user."
  order by i.created_at desc"));

  //foreach ($data as $item)  dump($item);
  $familles = Famille::all();
  $equipements = collect(DB::select('SELECT id_equipement, e.id_famille, e.description as description_e, f.description as description_f  FROM equipements e LEFT JOIN familles f ON e.id_famille=f.id_famille ORDER BY e.created_at desc'));
  $type_interventions = Type_intervention::orderBy('created_at', 'desc')->get();
  $techs = collect(DB::select("select * from users u where u.id in (select user_id from role_users where role_id in (select id from roles where slug='tech')) order by u.created_at desc;"));

  //the returned view
  $view = view('admin.stats')->withData($data)->withFamilles($familles)->withEquipements($equipements)->withTypes($type_interventions)->withTechs($techs)->withInterventions($interventions);


  if($request->has('submitFiltre')){
    if($request->has('id_equipement') && $request->id_equipement != "null"){
      //  dd($request->id_equipement);
      $view->with('selected_id_equipement',$request->id_equipement);
    }
    if($request->has('id_famille') && $request->id_famille != "null" ){
      $view->with('selected_id_famille',$request->id_famille);
    }
    if($request->has('id_type_intervention') && $request->id_type_intervention != "null"){
      $view->with('selected_id_type_intervention',$request->id_type_intervention);
    }
    if($request->has('id_technicien') && $request->id_technicien != "null"){
      $view->with('selected_id_technicien',$request->id_technicien);
    }
  }

  return $view;

}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//Delete Famille *************************************************************
public function deleteFamille(Request $request){
  try{
    $item = Famille::find($request->id_famille);
    $item->delete();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de suppression de la famille.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Suppression de la famille réussie");
}
//add Famille ****************************************************************
public function addFamille(Request $request){
  try{
    $item = new Famille();
    $item->description = $request->description;
    $item->save();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de création de la famille.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Création de la famille réussi");
}
//update Famille *************************************************************
public function updateFamille(Request $request){
  try{
    $item = Famille::find($request->id_famille);
    $item->description = $request->description;
    $item->save();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de modification de la famille.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Modification de la famille réussi");
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//Delete Equipement ****************************************************
public function deleteEquipement(Request $request){
  try{
    $item = Equipement::find($request->id_equipement);
    $item->delete();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de suppression de l'equipement.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Suppression de l'equipement réussi");
}
//add Equipement *******************************************************
public function addEquipement(Request $request){
  try{
    $item = new Equipement();
    $item->id_famille = $request->id_famille;
    $item->description = $request->description;
    $item->save();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de création de l'equipement.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Création de l'equipement réussi");
}
//update Equipement ****************************************************
public function updateEquipement(Request $request){
  try{
    $item = Equipement::find($request->id_equipement);
    $item->id_famille = $request->id_famille;
    $item->description = $request->description;
    $item->save();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de modification de l'equipement.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Modification de l'equipement reussie");
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//Delete Type_intervention ***************************************************
public function deleteType_intervention(Request $request){
  try{
    $item = Type_intervention::find($request->id_type_intervention);
    $item->delete();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de suppression du type de l'intervention.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Suppression du type de l'intervention réussi");
}
//add Type_intervention ******************************************************
public function addType_intervention(Request $request){
  try{
    $item = new Type_intervention();
    $item->nom = $request->nom;
    $item->description = $request->description;
    $item->save();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de création du type de l'intervention.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Création du type de l'intervention réussi");
}
//update Type_intervention ***************************************************
public function updateType_intervention(Request $request){
  try{
    $item = Type_intervention::find($request->id_type_intervention);
    $item->nom = $request->nom;
    $item->description = $request->description;
    $item->save();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de modification du type de l'intervention.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Modification du type de l'intervention reussie");
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//Delete User ****************************************************************
public function deleteUser(Request $request){
  try{
    if($request->id == 1){
      return redirect()->back()->with("alert_warning","Impossible de supprimer l'administrateur principal");
    }
    $item = User::find($request->id);
    $item->delete();
    $role_user = Role_user::where('user_id', $request->id)->get()->first();
    $role_user->delete();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de suppression de l'utilisateur.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Suppression de l'utilisateur réussie");
}
//add User *******************************************************************
public function addUser(Request $request){
  //ajouter et activer le compte de l'utilisateur
  try{
    $user = Sentinel::registerAndActivate($request->all());
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de création de l'utilisateur. Message d'erreur: ".$e->getMessage()." ");
  }
  //chercher le role pour l'utilisateur
  $role = Sentinel::findRoleBySlug($request->slug);
  //associer le role a l'utilisateur
  $role->users()->attach($user);
  return redirect()->back()->with('alert_success',"Création du l'utilisateur réussie");
}
//update User ****************************************************************
public function updateUser(Request $request){
  //dd($request->all());
  try{
    $item = User::find($request->id);
    $item->nom = $request->nom;
    $item->prenom = $request->prenom;
    $item->login = $request->login;
    if( $request->password != "" ){
      $item->password = password_hash($request->password, PASSWORD_DEFAULT);
    }
    $item->save();
  }catch(Exception $e){
    return redirect()->back()->with('alert_danger',"Erreur de modification de l'utilisateur.<br>Message d'erreur: ".$e->getMessage().".");
  }
  return redirect()->back()->with('alert_success',"Modification de l'utilisateur réussi");
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


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

/*
public function register(){
$roles = Role::all();
return view('admin.register')->withRoles($roles);
}*/

//valider l'enregistremenet de l'utilisateur
/*public function submitAddUser(Request $request){
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
}*/


}
