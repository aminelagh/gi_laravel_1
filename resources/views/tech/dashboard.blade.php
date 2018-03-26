@extends('layouts.master_tech')

@section('content-head')
  <h1>Espace Technicien<small></small></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
@endsection

@section('content')


  <div class="row">

    <section class="col-lg-12 connectedSortable">

      <div class="nav-tabs-custom">
        {{-- *************************   add Intervention   *****************************  --}}
        <div class="box box-primary">
          {{-- form add Intervention --}}
          <form method="POST" action="{{ route('tech.addIntervention') }}">
            @csrf

            <div class="box-header with-border">
              <h3 class="box-title">Nouvelle intervention <span class="badge badge-info badge-pill"></span></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <div class="btn-group">
                  <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a data-toggle="modal" data-target="#modalListFamille"><i class="fa fa-fw fa-bars"></i> Liste complete</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Imprimer la liste</a></li>
                  </ul>
                </div>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">

              <div class="row">
                <div class="col-lg-12">
                  {{-- Type_intervention --}}
                  <div class="form-group" align="center">
                    <label>Type de l'intervention</label>
                    <div class="radio">
                      <table class="table table-bordered">
                        <tr>
                          @foreach($type_interventions as $item)
                            <td title="{{ $item->description }}">
                              <label>
                                <input type="radio" name="id_type_intervention" value="{{ $item->id_type_intervention }}" {{ $loop->first ? 'checked':'' }}>
                                {{ $item->nom }}
                              </label>
                            </td>
                          @endforeach
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-4">
                  {{-- Equipement --}}
                  <div class="form-group has-feedback">
                    <label>Equipement</label>
                    <select id="id_equipement" class="selectpicker" data-live-search="true" name="id_equipement">
                      @foreach($equipements as $item)
                        <option value="{{ $item->id_equipement }}">{{ $item->description_e }} ({{ $item->description_f }})</option>
                      @endForeach
                    </select>
                  </div>
                </div>

                <div class="col-lg-6">
                  {{-- Description --}}
                  <div class="form-group has-feedback">
                    <label>Description</label>
                    <input class="form-control" type="text" name="description" placeholder="Description" value="{{ old('description') }}" required>
                  </div>
                </div>
                <div class="col-lg-1"></div>
              </div>
              <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-2">
                  {{-- Date --}}
                  <div class="form-group has-feedback">
                    <label>Date</label>
                    <input class="form-control" type="date" name="date" value="{{ old('date') }}" required>
                  </div>
                </div>

                <div class="col-lg-3">
                  {{-- Time --}}
                  <div class="form-group has-feedback">
                    <label>Heure</label>
                    <input class="form-control" type="time" name="heure" value="{{ old('heure') }}" required>
                  </div>
                </div>

                <div class="col-lg-3">
                  {{-- Durée --}}
                  <div class="form-group has-feedback">
                    <label>Durée</label>
                    <input class="form-control" type="time" name="duree" placeholder="Duree" value="{{ old('duree') }}" required>
                  </div>
                </div>

                <div class="col-lg-2"></div>
              </div>
            </div>

            <div class="box-footer clearfix no-border">
              <div class="row" align="center">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                  <input type="submit" value="Ajouter" class="btn btn-block btn-primary btn-md">
                </div>
                <div class="col-lg-4"></div>
              </div>
            </div>
          </div>
        </form>
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
                    <li><a onclick="printInterventionsFunction();">Imprimer la liste</a></li>
                    <li><a onclick="exportInterventionsFunction();">Exporter</a></li>
                  </li>
                </ul>
              </div>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <script>
          $(document).ready(function() {
            $('#interventions').DataTable( {
              "order": [[ 0, "asc" ]],
              "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "Nothing found - sorry",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
              }
            } );
          } );
          </script>

          <div class="box-body">

            @if($interventions->count()==0)
              <span class="text"><i>Aucune Intervention</i></span>
            @else
              <table id="interventions" class="table table-hover" width="100%" cellspacing="0">
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Intervention       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Intervention">
    <script>
    function infoInterventionFunction(ti, equipement,tech , description, date, duree){
      document.getElementById("info_ti").value = ti;
      document.getElementById("info_equipement").value = equipement;
      document.getElementById("info_tech").value = tech;
      document.getElementById("info_description").value = description;
      document.getElementById("info_date").value = date;
      document.getElementById("info_duree").value = duree;
    }
    </script>

    {{-- *****************************    Info Intervention    ***************************************************** --}}
    <div class="modal fade" id="modalInfoIntervention" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Details Intervention</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="row">

              <div class="col-md-3">
                {{-- Type_intervention --}}
                <div class="form-group has-feedback">
                  <label>Description</label>
                  <input class="form-control" type="text" id="info_ti" disabled>
                </div>
              </div>

              <div class="col-md-3">
                {{-- Equipement --}}
                <div class="form-group has-feedback">
                  <label>Equipement</label>
                  <input class="form-control" type="text" id="info_equipement" disabled>
                </div>
              </div>

              <div class="col-md-6">
                {{-- Technicien --}}
                <div class="form-group has-feedback">
                  <label>Technicien</label>
                  <input class="form-control" type="text" id="info_tech" disabled>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-12">
                {{-- Description --}}
                <div class="form-group has-feedback">
                  <label>Description</label>
                  <input class="form-control" type="text" id="info_description" disabled>
                </div>
              </div>

            </div>
            <div class="row">

              <div class="col-md-6">
                {{-- Date --}}
                <div class="form-group has-feedback">
                  <label>Date</label>
                  <input class="form-control" type="text" id="info_date" disabled>
                </div>
              </div>

              <div class="col-md-6">
                {{-- Duree --}}
                <div class="form-group has-feedback">
                  <label>Durée</label>
                  <input class="form-control" type="text" id="info_duree" disabled>
                </div>
              </div>

            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
  </div>
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Intervention       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}



  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Profile       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <div class="CRUD Profile">
    {{-- *****************************    update Profile    ************************************************* --}}
    <div class="modal fade" id="modalUpdateProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update Profile --}}
      <form method="POST" action="{{ route('tech.updateProfile') }}">
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Famille       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{-- ****************************************************************************************** --}}
  {{-- ****************************** Print Forms *********************************************** --}}
  <form id="formPrintInterventionsTech" method="POST" action="{{ route('printInterventionsTech') }}" target="_blank">
    @csrf
  </form>

  <script>
  function printInterventionsFunction(){
    document.getElementById("formPrintInterventionsTech").submit();
  }
  </script>
  {{-- ****************************** Print Forms *********************************************** --}}
  {{-- ****************************************************************************************** --}}

  {{-- ****************************************************************************************** --}}
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  <form id="formExportInterventionsTech" method="POST" action="{{ route('exportInterventionsTech') }}" target="_blank">
    @csrf
  </form>
  <script>
  function exportInterventionsFunction(){
    document.getElementById("formExportInterventionsTech").submit();
  }
  </script>
  {{-- ************************** Export To Excel Forms ***************************************** --}}
  {{-- ****************************************************************************************** --}}

@endsection




@section('menu_1')
  @include('tech.menu_1')
@endsection
