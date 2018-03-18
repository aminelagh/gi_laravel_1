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
use Excel;

class ExcelController extends Controller
{
  public function e11(){
    try{

      Excel::create('Filename', function($excel) {
        $excel->setTitle('ExcelFile');
        //sheet Familles
        $excel->sheet('Familles', function($sheet) {
          $familles = Famille::all();
          foreach ($familles as $item) {
            $sheet->appendRow(array($item->description));
          }
        });

        //sheet Equipements
        $excel->sheet('Equipements', function($sheet) {
          $equipements = Equipement::all();
          foreach ($equipements as $item) {
            $sheet->appendRow(array($item->description));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
    return "Done";
  }

  //Exporter la liste des Familles ---------------------------------------------
  public function exportFamilles(){
    try{
      Excel::create('Filename', function($excel) {

        $excel->sheet('Familles', function($sheet) {
          $familles = Famille::all();
          foreach ($familles as $item) {
            $sheet->appendRow(array($item->description));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  //Exporter la liste des Equipements ------------------------------------------
  public function exportFamilles2(){
    try{
      Excel::create('Filename', function($excel) {
        $excel->sheet('Familles et Equipements', function($sheet) {

          $familles = Famille::all();
          foreach ($familles as $item) {
            $sheet->appendRow( array($item->description));
            $equipements = Equipement::where('id_famille',$item->id_famille)->get();
            foreach ($equipements as $equipement) {
              $sheet->appendRow(array("",$equipement->description));
            }
            $sheet->appendRow(array(null));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  //Exporter la liste des Equipements ------------------------------------------
  public function exportEquipements(){
    try{
      Excel::create('Filename', function($excel) {
        $excel->sheet('Familles et Equipements', function($sheet) {
          $equipements = Equipement::all();
          foreach ($equipements as $equipement) {
            $sheet->appendRow(array($equipement->description));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  //Exporter la liste des Techniciens ------------------------------------------
  public function exportTechniciens(){
    try{
      Excel::create('Filename', function($excel) {
        $excel->sheet('Familles et Equipements', function($sheet) {

          $techs = collect(DB::select("select * from users u where u.id in (select user_id from role_users where role_id in (select id from roles where slug='tech')) order by u.created_at desc;"));
          $sheet->appendRow( array("Nom","Prenom","Login"));
          foreach ($techs as $item) {
            $sheet->appendRow( array($item->nom,$item->prenom,$item->login));
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  //Exporter la liste des Interventions ----------------------------------------
  public function exportInterventions(){
    try{
      Excel::create('interventions', function($excel) {
        $excel->sheet('interventions', function($sheet) {

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

          $sheet->appendRow( array("Type d'intervention","Technicien","Famille","Equipement","Intervention","Date","Duree"));
          foreach ($data as $item) {
            $sheet->appendRow( array($item->nom_ti,$item->nom_u." ".$item->prenom_u,$item->description_f,$item->description_e,$item->description,$item->date,$item->duree) );
          }
        });
      })->export('xls');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
    }
  }

  //Exporter la liste des stats ------------------------------------------------
  public function exportStats(Request $request){
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

    $GLOBALS['where_id_equipement'] = $where_id_equipement;
    $GLOBALS['where_type_intervention'] = $where_type_intervention;
    $GLOBALS['where_id_user'] = $where_id_user;
    $GLOBALS['where_id_famille'] = $where_id_famille;

    try{
      Excel::create('Stats', function($excel) {

        //sheet Stats --------
        $excel->sheet('Stats', function($sheet) {

          $where_id_equipement = $GLOBALS['where_id_equipement'];
          $where_type_intervention = $GLOBALS['where_type_intervention'];
          $where_id_user = $GLOBALS['where_id_user'];
          $where_id_famille = $GLOBALS['where_id_famille'];

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

            $sheet->appendRow( array("Mois","Total en H","Total en M","Total en S","Durée Totale"));
            foreach ($data as $item) {
              $sheet->appendRow( array( getMonthName($item->month)." ".$item->year,number_format($item->totalH, 3),number_format($item->totalM, 3),number_format($item->totalS, 3),getSommeDuree($item->h ,$item->m ,$item->s)) );
            }

          });

          //Sheet Details
          $excel->sheet('Interventions', function($sheet) {

            $where_id_equipement = $GLOBALS['where_id_equipement'];
            $where_type_intervention = $GLOBALS['where_type_intervention'];
            $where_id_user = $GLOBALS['where_id_user'];
            $where_id_famille = $GLOBALS['where_id_famille'];

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

              $sheet->appendRow( array("Type d'intervention","Technicien","Equipement","Famille","Intervention","Date","Durée"));
              foreach ($interventions as $item) {
                $sheet->appendRow( array($item->nom_u,$item->nom_u." ".$item->prenom_u,$item->description_e,$item->description_f,$item->description,$item->date,$item->duree ));
              }
            });

          })->export('xls');

        }catch(Exception $e){
          return redirect()->back()->with('alert_danger',"Erreur !<br>Message d'erreur: ".$e->getMessage());
        }
      }
    }
