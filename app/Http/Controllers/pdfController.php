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

  public function printStats(Request $request){
    //dd($request->all());

    $where_id_equipement = "";
    $where_type_intervention = "";
    $where_id_user = "";
    $where_id_famille = "";

    //where id_type_intervention = X
    if($request->id_type_intervention != 'null' ) {
      $id_type_intervention = $request->id_type_intervention;
      $where_type_intervention = " and i.id_type_intervention = ".$id_type_intervention." ";
    }

    if($request->id_famille != 'null' ) {
      $id_famille = $request->id_famille;
      $where_id_famille = " and i.id_equipement in (select id_famille from familles where id_famille = ".$id_famille.") ";
    }

    if($request->id_equipement != 'null' ) {
      $id_equipement = $request->id_equipement;
      $where_id_equipement = " and i.id_equipement = ".$id_equipement." ";
    }

    if($request->id_technicien != 'null' ) {
      $id_technicien = $request->id_technicien;
      $where_id_user = " and i.id_user = ".$id_technicien." ";
    }


    $data = collect(DB::select(
      "SELECT
      month(date) as month,YEAR(date) AS year,
      sum(duree) as duree,
      sum(hour(duree)) as h,sum(minute(duree)) as m,sum(second(duree)) as s,
      sum( SECOND(duree)/3600 + MINUTE(duree)/60 + HOUR(duree)) as 'totalH',
      sum( SECOND(duree)/60 + MINUTE(duree) + HOUR(duree)*60 ) as 'totalM',
      sum( SECOND(duree) + MINUTE(duree)*60 + HOUR(duree)*3600) as 'totalS'
      FROM interventions i
      WHERE true ".$where_type_intervention." ".$where_id_famille." ".$where_id_equipement." ".$where_id_user."
      GROUP BY MONTH(date),YEAR(date)
      ORDER BY YEAR(date),MONTH(date) ;"));



      $interventions = collect(DB::select(
        "select i.description, i.date, i.duree, i.created_at,
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

        try{
        $pdf = PDF::loadView('pdf/stats',['data'=> $data, 'interventions'=>$interventions]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
        //return $pdf->download('stats.pdf');

      }catch(Exception $e){
        return redirect()->back()->with('alert_danger',"Erreur d'impression.<br>Message d'erreur: <b>".$e->getMessage()."</b>");
      }
    }


  }
