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
use PDF;
use App;

class pdfController extends Controller
{
  public function printInterventions(){
    try{
      $data = collect(DB::select("select
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

      $pdf = PDF::loadView('pdf/interventions',['data'=> $data]);
      $pdf->setPaper('a4', 'landscape');
      return $pdf->download('interventions.pdf');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur d'impression.<br>Message d'erreur: <b>".$e->getMessage()."</b>");
    }
  }

  public function printTechniciens(){
    try{
      $data = collect(DB::select("select * from users u where u.id in (select user_id from role_users where role_id in (select id from roles where slug='tech')) order by u.created_at desc;"));
      $pdf = PDF::loadView('pdf/technicients',['data'=> $data]);
      $pdf->setPaper('a4', 'landscape');
      return $pdf->download('technicients.pdf');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur d'impression.<br>Message d'erreur: <b>".$e->getMessage()."</b>");
    }
  }

  public function printEquipements(){
    try{
      $data = collect(DB::select('SELECT id_equipement, e.id_famille, e.description as description_e, f.description as description_f  FROM equipements e LEFT JOIN familles f ON e.id_famille=f.id_famille ORDER BY e.created_at desc'));
      $pdf = PDF::loadView('pdf/equipements',['data'=> $data]);
      $pdf->setPaper('a4', 'landscape');
      return $pdf->stream();
      return $pdf->download('Equipements.pdf');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur d'impression.<br>Message d'erreur: <b>".$e->getMessage()."</b>");
    }
  }


}
