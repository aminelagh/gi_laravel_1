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



    <form id="formFiltreStats" method="POST" action="{{ route('submitStats') }}">
      @csrf
      <div class="row">
        <div class="col-lg-3">
          {{-- id_famille Equipement --}}
          <div class="form-group has-feedback">
            <label>Famille d'equipement</label>
            <select  class="form-control" name="id_famille">
              @isset($familles)
                @if($familles->count()>0)
                  @foreach ($familles as $item)
                    <option value="{{ $item->id_famille }}">{{ $item->description }}</option>
                  @endforeach
                @endif
              @endisset
            </select>
          </div>
        </div>

        <div class="col-lg-3">
          {{-- Equipement --}}
          <div class="form-group has-feedback">
            <label>Equipement</label>
            <select name="id_equipement" class="form-control">
              @foreach($equipements as $item)
                <option value="{{ $item->id_equipement }}" {{ isset($selected_id_equipement) && $selected_id_equipement == $item->id_equipement ? 'selected' : ''  }}>{{ $item->description_e }} ({{ $item->description_f }})</option>
              @endForeach
            </select>
          </div>
        </div>

        <div class="col-lg-3">
          {{-- Type_interventions --}}
          <div class="form-group has-feedback">
            <label>Type intervention</label>
            <select name="id_type_intervention" class="form-control">
              @foreach($types as $item)
                <option value="{{ $item->id_type_intervention }}">{{ $item->nom }}</option>
              @endForeach
            </select>
          </div>
        </div>

        <div class="col-lg-3">
          {{-- Technicien --}}
          <div class="form-group has-feedback">
            <label>Technicien</label>
            <select name="id_type_intervention" class="form-control" oninput="submitForm();">
              @foreach($techs as $item)
                <option value="{{ $item->id }}">{!! $item->nom." ".$item->prenom !!}</option>
              @endForeach
            </select>
          </div>
        </div>
      </div>
      <div class="row" align="center">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
          <input type="submit" value="Ajouter" class="btn btn-block btn-primary btn-md">
        </div>
        <div class="col-lg-4"></div>
      </div>

    </form>

  </div>

  <script>
  function submitForm(){
    //alert('aa');
    //document.getElementById("formFiltreStats").submit();
  }
  </script>

  <hr>

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
                    <a onclick="printInterventionsFunction();">Imprimer la liste</a>
                  </li>
                </ul>
              </div>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <script>
          $(document).ready(function() {
            $('#table').DataTable( {
              //"order": [[ 0, "asc" ]]
            } );
          } );
          </script>

          <div class="box-body">

            @if($data->count()==0)
              <span class="text"><i>Aucune Intervention</i></span>
            @else
              <table id="table1" class="table table-hover" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Mois</th>
                    <th>Duree</th>
                    <th>en Heurs</th>
                    <th>en Min</th>
                    <th>en Sec</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                      <td>{{ getMonthName($item->month) }} {{ $item->year }}</td>
                      <td>{{ $item->duree }}</td>
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
@endsection




@section('menu_1')
  @include('admin.menu_1')
@endsection
@section('menu_2')
  @include('admin.menu_2')
@endsection
