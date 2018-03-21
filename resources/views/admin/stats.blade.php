@extends('layouts.master_admin')

@section('content-head')
  <h1>Espace Administrateur<small></small></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
@endsection

@section('content')

  <div class="row">
    <section class="col-lg-12 connectedSortable">

      <form id="formFiltreStats" method="POST" action="{{ route('submitStats') }}">
        @csrf

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"> Filtre </h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">

            <div class="col-lg-3">
              {{-- Type_interventions --}}
              <div class="form-group has-feedback">
                <label>Type intervention</label>
                <select name="id_type_intervention" class="form-control" id="id_type_intervention">
                  <option value="null">Tous les types d'intervention</option>
                  @foreach($types as $item)
                    <option value="{{ $item->id_type_intervention }}" {{ isset($selected_id_type_intervention) && $selected_id_type_intervention == $item->id_type_intervention ? 'selected' : ''  }}>{{ $item->nom }}</option>
                  @endForeach
                </select>
              </div>
            </div>

            <div class="col-lg-3">
              {{-- id_famille Equipement --}}
              <div class="form-group has-feedback">
                <label>Famille d'equipement</label>
                <select  class="form-control" name="id_famille" id="id_famille">
                  <option value="null">Toute les familles</option>
                  @foreach ($familles as $item)
                    <option value="{{ $item->id_famille }}" {{ isset($selected_id_famille) && $selected_id_famille == $item->id_famille ? 'selected' : ''  }} >{{ $item->description }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-3">
              {{-- Equipement --}}
              <div class="form-group has-feedback">
                <label>Equipement</label>
                <select name="id_equipement" class="form-control" id="id_equipement">
                  <option value="null">Tous les équipements</option>
                  @foreach($equipements as $item)
                    <option value="{{ $item->id_equipement }}" {{ isset($selected_id_equipement) && $selected_id_equipement == $item->id_equipement ? 'selected' : ''  }}>{{ $item->description_e }} ({{ $item->description_f }})</option>
                  @endForeach
                </select>
              </div>
            </div>

            <div class="col-lg-3">
              {{-- Technicien --}}
              <div class="form-group has-feedback">
                <label>Technicien</label>
                <select name="id_technicien" class="form-control" id="id_technicien">
                  <option value="null">Tous les techniciens</option>
                  @foreach($techs as $item)
                    <option value="{{ $item->id }}" {{ isset($selected_id_technicien) && $selected_id_technicien == $item->id ? 'selected' : ''  }}>{!! $item->nom." ".$item->prenom !!}</option>
                  @endForeach
                </select>
              </div>
            </div>

          </div>
          <div class="box-footer clearfix no-border">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
              <input type="submit" value="Filtrer" class="btn btn-block btn-primary btn-md" name="submitFiltre">
            </div>
            <div class="col-lg-4"></div>
          </div>
        </div>

      </form>

    </section>
  </div>

  <script>
  function submitForm(){
    //alert('aa');
    //document.getElementById("formFiltreStats").submit();
  }
  </script>

  <hr>

  {{-- ****************************************************************************************** --}}
  {{-- ****************************** Print Forms *********************************************** --}}
  <form id="formPrintStats" method="POST" action="{{ route('printStats') }}" target="_blank">
    @csrf
    <input type="hidden" name="id_type_intervention" id="print_id_type_intervention">
    <input type="hidden" name="id_famille" id="print_id_famille">
    <input type="hidden" name="id_equipement" id="print_id_equipement">
    <input type="hidden" name="id_technicien" id="print_id_technicien">
  </form>

  <script>
  function printStatsFunction(){
    let id_type_intervention = document.getElementById("id_type_intervention").value;
    let id_famille = document.getElementById("id_famille").value;
    let id_equipement = document.getElementById("id_equipement").value;
    let id_technicien = document.getElementById("id_technicien").value;

    document.getElementById("print_id_type_intervention").value = id_type_intervention;
    document.getElementById("print_id_famille").value = id_famille;
    document.getElementById("print_id_equipement").value = id_equipement;
    document.getElementById("print_id_technicien").value = id_technicien;
    //alert("id_type_intervention: "+id_type_intervention+"\n id_famille: "+id_famille+"\n id_equipement: "+id_equipement+"\n id_technicien: "+id_technicien);
    document.getElementById("formPrintStats").submit();
  }
  </script>
  {{-- ****************************** Print Forms *********************************************** --}}
  {{-- ****************************************************************************************** --}}
  {{-- ****************************************************************************************** --}}
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  <form id="formExportStats" method="POST" action="{{ route('exportStats') }}" target="_blank">
    @csrf
    <input type="hidden" name="id_type_intervention" id="export_id_type_intervention">
    <input type="hidden" name="id_famille" id="export_id_famille">
    <input type="hidden" name="id_equipement" id="export_id_equipement">
    <input type="hidden" name="id_technicien" id="export_id_technicien">
  </form>

  <script>
  function exportStatsFunction(){
    let id_type_intervention = document.getElementById("id_type_intervention").value;
    let id_famille = document.getElementById("id_famille").value;
    let id_equipement = document.getElementById("id_equipement").value;
    let id_technicien = document.getElementById("id_technicien").value;

    document.getElementById("export_id_type_intervention").value = id_type_intervention;
    document.getElementById("export_id_famille").value = id_famille;
    document.getElementById("export_id_equipement").value = id_equipement;
    document.getElementById("export_id_technicien").value = id_technicien;
    //alert("id_type_intervention: "+id_type_intervention+"\n id_famille: "+id_famille+"\n id_equipement: "+id_equipement+"\n id_technicien: "+id_technicien);
    document.getElementById("formExportStats").submit();
  }
  </script>
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  {{-- ****************************************************************************************** --}}


  <div class="row">
    <section class="col-lg-12 connectedSortable">

      <div class="nav-tabs-custom">
        {{-- *************************   List Stats   *****************************  --}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"> Somme des durée par mois <span class="badge badge-info badge-pill"></span></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <div class="btn-group">
                <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                <ul class="dropdown-menu" role="menu">
                  <li><a onclick="printStatsFunction();">Imprimer la liste</a></li>
                  <li><a onclick="exportStatsFunction();">Exporter</a></li>
                </ul>
              </div>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <script>
          $(document).ready(function() {
            $('#stats').DataTable( {
              "pagingType": "full_numbers",
              "order": [[ 0, "asc" ]],
              "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
              "columnDefs": [
                {targets: 0 , visible: false,},
                {targets: 1 , visible: true,},
                {targets: 2 , visible: true,},
              ],
            } );
          } );
          </script>

          <div class="box-body">

            @if($data->count()==0)
              <span class="text"><i>Aucune Intervention</i></span>
            @else
              <table id="stats" class="table table-hover" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mois</th>
                    <th>en Heurs</th>
                    <th>en Min</th>
                    <th>en Sec</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ getMonthName($item->month) }} {{ $item->year }}</td>
                      <td>{{ number_format($item->totalH, 3) }}</td>
                      <td>{{ number_format($item->totalM, 2) }}</td>
                      <td>{{ number_format($item->totalS, 2) }}</td>
                      <th>{{ getSommeDuree($item->h ,$item->m ,$item->s) }}</th>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif

          </div>
          <div class="box-footer clearfix no-border"></div>
        </div>
      </div>
    </section>
  </div>

  <div class="row">



    <section class="col-lg-12 connectedSortable">

      <div class="nav-tabs-custom">
        {{-- *************************   List Interventions   *****************************  --}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"> Interventions <span class="badge badge-info badge-pill"></span></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <div class="btn-group">
                <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                <ul class="dropdown-menu" role="menu">
                  <li class="divider"></li>
                  <li>
                    <a onclick="printStatsFunction();">Imprimer la liste</a>
                  </li>
                </ul>
              </div>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <script>
          $(document).ready(function() {
            $('#tableDetails').DataTable( {
              "order": [[ 5, "asc" ]]
            } );
          } );
          </script>

          <div class="box-body">

            @if($data->count()==0)
              <span class="text"><i>Aucune Intervention</i></span>
            @else
              <table id="tableDetails" class="table table-hover" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>Technicien</th>
                    <th>Equipement</th>
                    <th>Famille</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Durée</th>
                    <th>Tools</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($interventions as $item)
                    <tr>
                      <td title="{{ $item->description_ti }}">{{ $item->nom_ti }}</td>
                      <td title="{{ $item->login_u }}">{{ $item->nom_u }} {{ $item->prenom_u }}</td>
                      <td>{{ $item->description_e }}</td>
                      <td>{{ $item->description_f }}</td>
                      <td>{{ $item->description }}</td>
                      <td>{{ $item->date }}</td>
                      <td>{{ $item->duree }}</td>
                      <td>
                        <i class="fa fa-fw fa-info-circle" data-toggle="modal" data-target="#modalInfoIntervention"
                        onclick="infoInterventionFunction('{{ $item->nom_ti }}', '{{ $item->description_e }}','{{ $item->nom_u }} {{ $item->prenom_u }}' , '{{ $item->description }}', '{{ $item->date }}', '{{ $item->duree }}');" ></i>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif

          </div>
          <div class="box-footer clearfix no-border"></div>
        </div>
      </div>
    </section>

  </div>



  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Modals       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}


  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Profile       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Profile">
    {{-- *****************************    update Profile    ************************************************* --}}
    <div class="modal fade" id="modalUpdateProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Profile --}}
      <form method="POST" action="{{ route('admin.updateProfile') }}">
        @csrf
        <input type="hidden" name="id" value="{{ Session::get('id_user') }}">

        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modification de l'équipement</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  {{-- Nom --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ Session::get('nom') }}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Prenom --}}
                  <div class="form-group has-feedback">
                    <label>Prenom</label>
                    <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="{{ Session::get('prenom') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  {{-- Login --}}
                  <div class="form-group has-feedback">
                    <label>Login</label>
                    <input type="text" class="form-control" placeholder="Login" name="login" value="{{ Session::get('login') }}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  {{-- Password --}}
                  <div class="form-group has-feedback">
                    <label>Password</label>
                    <input type="text" class="form-control" placeholder="Password" name="password" title='Pour garder votre ancien mot de passe, laissez le champ "Password" vide.'>
                    <span>Pour garder votre ancien mot de passe, laissez le champ "Password" vide.</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Modifier</button>
            </div>

          </div>
        </div>

      </form>
    </div>
  </div>
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Profile       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{-- ****************************************************************************************** --}}
  {{-- ****************************** Print Forms *********************************************** --}}
  <form id="formPrintInterventions" method="POST" action="{{ route('printInterventions') }}" target="_blank">
    @csrf
  </form>

  <script>
  function printInterventionsFunction(){
    document.getElementById("formPrintInterventions").submit();
  }
  </script>
  {{-- ****************************** Print Forms *********************************************** --}}
  {{-- ****************************************************************************************** --}}

  {{-- ****************************************************************************************** --}}
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  <form id="formExportInterventions" method="POST" action="{{ route('exportInterventions') }}" target="_blank">
    @csrf
  </form>
  <script>
  function exportInterventions(){
    document.getElementById("formExportInterventions").submit();
  }


  </script>
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  {{-- ****************************************************************************************** --}}
@endsection




@section('menu_1')
  @include('admin.menu_1')
@endsection
@section('menu_2')
  @include('admin.menu_2')
@endsection
