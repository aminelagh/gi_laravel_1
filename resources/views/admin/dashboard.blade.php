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
                  <li>
                    <a onclick="printInterventionsFunction();">Imprimer la liste</a>
                  </li>
                  <li>
                    <a onclick="exportInterventionsFunction();">Exporter</a>
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

  <div class="row">

    <section class="col-lg-3 connectedSortable">

      <div class="nav-tabs-custom">
        {{-- *************************   Familles   *****************************  --}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Familles <span class="badge badge-info badge-pill"> {{ $familles->count() }}</span></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <div class="btn-group">
                <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                <ul class="dropdown-menu" role="menu">
                  <li><a data-toggle="modal" data-target="#modalAddFamille"><i class="fa fa-fw fa-plus"></i> Créer une famille d'équiement</a></li>
                  <li><a data-toggle="modal" data-target="#modalListFamille"><i class="fa fa-fw fa-bars"></i> Liste complete</a></li>
                  <li class="divider"></li>
                  <li><a onclick="printEquipements();">Imprimer la liste</a></li>
                  <li><a onclick="exportFamillesFunction();">Exporter</a></li>
                  <li><a onclick="exportFamilles2Function();">Exporter 2</a></li>
                </ul>
              </div>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">
            <ul class="todo-list">
              @foreach ($familles->take(5) as $item)
                <li>
                  <span class="handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                  </span>
                  <!-- checkbox -->
                  <input type="checkbox" value="" name=""/>
                  <!-- todo text -->
                  <span class="text">{{ $item->description }}</span>
                  <!--small class="label label-info"><i class="fa fa-clock-o"></i> 2 mins</small-->
                  <div class="tools">
                    <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateFamille" onclick='updateFamilleFunction({{ $item->id_famille }}, "{{ $item->description }}" );'></i>
                    <i class="fa fa-trash-o" onclick="deleteFamilleFunction({{ $item->id_famille }},'{{ $item->description }}');" ></i>
                  </div>
                </li>

              @endforeach
            </ul>
          </div>
          <div class="box-footer clearfix no-border"></div>
        </div>
      </div>

      <div class="nav-tabs-custom">
        {{-- *************************   Equipements   *****************************  --}}
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Equipements @isset($equipements)<span class="badge badge-info badge-pill">{{ $equipements->count() }}</span>@endisset</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <div class="btn-group">
                  <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a data-toggle="modal" data-target="#modalAddEquipement"><i class="fa fa-fw fa-plus"></i> Créer un nouveau équipement</a></li>
                    <li><a data-toggle="modal" data-target="#modalListEquipement"><i class="fa fa-fw fa-bars"></i> Liste complete</a></li>
                    <li class="divider"></li>
                    <li><a onclick="printEquipements();">Imprimer la liste</a></li>
                    <li><a onclick="exportEquipementsFunction();">Exporter</a></li>
                    <li><a onclick="exportFamilles2Function();">Exporter 2</a></li>
                  </ul>
                </div>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">
              <ul class="todo-list">
                @isset($equipements)
                  @if($equipements!=null && $equipements->count()==0)
                    <li>
                      <span class="text"><i>Aucun equipement enregistré</i></span>
                    </li>
                  @else
                    @foreach ($equipements->take(5) as $item)
                      <li>
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <!-- checkbox -->
                        <input type="checkbox" value="" name=""/>
                        <!-- todo text -->
                        <span class="text">{{ $item->description_e }}</span>
                        <small class="label label-info"> {{ $item->description_f }}</small>
                        <div class="tools">
                          <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateEquipement" onclick='updateEquipementFunction({{ $item->id_equipement }}, {{ $item->id_famille }}, "{{ $item->description_e }}" );'></i>
                          <i class="fa fa-trash-o" onclick="deleteEquipementFunction({{ $item->id_equipement }},'{{ $item->description_e }}');" ></i>
                        </div>
                      </li>
                    @endforeach
                  @endif
                @endisset
              </ul>
            </div>
            <div class="box-footer clearfix no-border"></div>
          </div>

        </div>

      </section>

      <section class="col-lg-6 connectedSortable">

        <div class="nav-tabs-custom">
          {{-- *************************   Techniciens   *****************************  --}}
          <div class="box box-warning">

            <div class="box-header with-border">
              <h3 class="box-title">Techniciens <span class="badge badge-info badge-pill"> {{ $techs->count() }}</span></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <div class="btn-group">
                  <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a data-toggle="modal" data-target="#modalAddTechnicien"><i class="fa fa-fw fa-plus"></i> Créer un nouveau technicien</a></li>
                    <li><a data-toggle="modal" data-target="#modalListTechnicien"><i class="fa fa-fw fa-bars"></i> Liste complete</a></li>
                    <li class="divider"></li>
                    <li><a onclick="printTechniciensFunction();">Imprimer la liste</a></li>
                    <li><a onclick="exportTechniciensFunction();">Exporter</a></li>
                  </ul>
                </div>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <script>
            $(document).ready(function() {
              $('#techs').DataTable( {
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

              @if($techs->count()==0)
                <span class="text"><i>Aucun technicien</i></span>
              @else
                <table id="techs" class="table table-hover" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Technicien</th>
                      <th>Login</th>
                      <th>Last Login</th>
                      <th>Tools</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($techs->take(5) as $item)
                      <tr>
                        <td>{{ $item->nom }} {{ $item->prenom }}</td>
                        <td>{{ $item->login }}</td>
                        <td>{{ $item->last_login }}</td>
                        <td>
                          <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateTechnicien" onclick='updateTechnicienFunction({{ $item->id }}, "{{ $item->nom }}", "{{ $item->prenom }}","{{ $item->login }}" );'></i>
                          <i class="fa fa-trash-o" onclick="deleteTechnicienFunction({{ $item->id }},'{{ $item->nom }}');" ></i>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif

            </div>
            <!-- /.box-body -->
          </div>
        </div>

      </section>

      <section class="col-lg-3 connectedSortable">

        <div class="nav-tabs-custom">
          {{-- *************************   Type_intervention   *****************************  --}}
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Types d'interventions <span class="badge badge-info badge-pill"> {{ $type_interventions->count() }}</span></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <div class="btn-group">
                  <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a data-toggle="modal" data-target="#modalAddType_intervention"><i class="fa fa-fw fa-plus"></i> Créer un nouveau type</a></li>
                    <li><a data-toggle="modal" data-target="#modalListType_intervention"><i class="fa fa-fw fa-bars"></i> Liste complete</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Imprimer la liste</a></li>
                  </ul>
                </div>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">
              <ul class="todo-list">
                @if($type_interventions->count()==0)
                  <li>
                    <span class="text"><i>Aucun type enregistré</i></span>
                  </li>
                @else
                  @foreach ($type_interventions->take(3) as $item)
                    <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                      <!-- checkbox -->
                      <input type="checkbox" value="" name=""/>
                      <!-- todo text -->
                      <span class="text">{{ $item->nom }}</span>
                      <!--small class="label label-info"><i class="fa fa-clock-o"></i> 2 mins</small-->
                      <div class="tools">
                        <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateType_intervention" onclick='updateType_interventionFunction({{ $item->id_type_intervention }}, "{{ $item->nom }}", "{{ $item->description }}" );'></i>
                        <i class="fa fa-trash-o" onclick="deleteType_interventionFunction({{ $item->id_type_intervention }},'{{ $item->nom }}');" ></i>
                      </div>
                    </li>
                  @endforeach
                @endif
              </ul>
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
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Famille       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    <div class="CRUD Famille">
      <form id="formDeleteFamille" method="POST" action="{{ route('deleteFamille') }}">
        @csrf
        <input type="hidden" id="id_famille" name="id_famille" />
      </form>
      <script>
      function deleteFamilleFunction(id_famille, description){
        var go = confirm('Vos êtes sur les points d\'effacer la Famille: "'+description+'".\n voulez-vous continuer?');
        if(go){
          document.getElementById("id_famille").value = id_famille;
          document.getElementById("formDeleteFamille").submit();
        }
      }
      function updateFamilleFunction(id_famille, description){
        document.getElementById("update_id_famille").value = id_famille;
        document.getElementById("update_description").value = description;
      }
      </script>

      {{-- *****************************    List Famille    ***************************************************** --}}
      <div class="modal fade" id="modalListFamille" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Liste des Familles</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">

                  <ul class="todo-list">
                    @if($familles->count() == 0)
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <i>Aucune Famille</i>
                      </li>
                    @else
                      @foreach ($familles as $item)

                        <li>
                          <span class="text"><p>{{ $item->description }}</p></span>
                          <div class="tools">
                            <div class="tools">
                              <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateFamille" onclick='updateFamilleFunction({{ $item->id_famille }}, "{{ $item->description }}" );'></i>
                              <i class="fa fa-trash-o" onclick="deleteFamilleFunction({{ $item->id_famille }},'{{ $item->description }}');" ></i>
                            </div>
                          </div>
                        </li>

                      @endforeach
                    @endif
                  </ul>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      {{-- *****************************    Add Famille    ***************************************************** --}}
      <div class="modal fade" id="modalAddFamille" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form AddFamille --}}
        <form method="POST" action="{{ route('addFamille') }}">
          @csrf

          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter une famille d'équipement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    {{-- description Famille --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Description" name="description" value="{{ old('description') }}" required >
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </div>

            </div>
          </div>

        </form>
      </div>

      {{-- *****************************    update Famille    ***************************************************** --}}
      <div class="modal fade" id="modalUpdateFamille" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form AddFamille --}}
        <form method="POST" action="{{ route('updateFamille') }}">
          @csrf
          <input type="hidden" name="id_famille" id="update_id_famille">

          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification une famille d'équipement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    {{-- description Famille --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Description" name="description" id="update_description" required >
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


    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Equipement       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    <div class="CRUD Equipement">
      <form id="formDeleteEquipement" method="POST" action="{{ route('deleteEquipement') }}">
        @csrf
        <input type="hidden" id="id_equipement" name="id_equipement" />
      </form>
      <script>
      function deleteEquipementFunction(id_equipement, description){
        var go = confirm('Vos êtes sur les points d\'effacer l\'equipement: "'+description+'".\n voulez-vous continuer?');
        if(go){
          document.getElementById("id_equipement").value = id_equipement;
          document.getElementById("formDeleteEquipement").submit();
        }
      }
      function updateEquipementFunction(id_equipement, id_famille, description){
        document.getElementById("update_id_equipement_equipement").value = id_equipement;
        document.getElementById("update_id_famille_equipement").value = id_famille;
        document.getElementById("update_description_equipement").value = description;
      }
      </script>

      {{-- *****************************    List Equipement    ************************************************ --}}
      <div class="modal fade" id="modalListEquipement" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Liste des Familles</h4>
            </div>
            <div class="box-body">
              <ul class="todo-list">
                @isset($equipements)
                  @if($equipements!=null && $equipements->count()==0)
                    <li>
                      <span class="text"><i>Aucun equipement enregistré</i></span>
                    </li>
                  @else
                    @foreach ($equipements->take(5) as $item)
                      <li>
                        <span class="handle">
                          <i class="fa fa-ellipsis-v"></i>
                          <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <!-- checkbox -->
                        <input type="checkbox" value="" name=""/>
                        <!-- todo text -->
                        <span class="text">{{ $item->description_e }}</span>
                        <small class="label label-info"> {{ $item->description_f }}</small>
                        <div class="tools">
                          <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateEquipement" onclick='updateEquipementFunction({{ $item->id_equipement }}, {{ $item->id_famille }}, "{{ $item->description_e }}" );'></i>
                          <i class="fa fa-trash-o" onclick="deleteEquipementFunction({{ $item->id_equipement }},'{{ $item->description_e }}');" ></i>
                        </div>
                      </li>
                    @endforeach
                  @endif
                @endisset
              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      {{-- *****************************    Add Equipement    ********************************************** --}}
      <div class="modal fade" id="modalAddEquipement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form add Equipement --}}
        <form method="POST" action="{{ route('addEquipement') }}">
          @csrf

          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un équipement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                    {{-- id_famille Equipement --}}
                    <div class="form-group has-feedback">
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
                  <div class="col-md-7">
                    {{-- description Equipement --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Description" name="description" required >
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </div>

            </div>
          </div>

        </form>
      </div>

      {{-- *****************************    update Equipement    ************************************************* --}}
      <div class="modal fade" id="modalUpdateEquipement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form update Equipement --}}
        <form method="POST" action="{{ route('updateEquipement') }}">
          @csrf
          <input type="hidden" name="id_equipement" id="update_id_equipement_equipement">

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
                  <div class="col-md-5">
                    {{-- id_famille Equipement --}}
                    <div class="form-group has-feedback">
                      <select  class="form-control" name="id_famille" id="update_id_famille_equipement">
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
                  <div class="col-md-7">
                    {{-- description Equipement --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Description" name="description" id="update_description_equipement" required>
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


    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@       Type_intervention       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    <div class="CRUD Type_intervention">
      <form id="formDeleteType_intervention" method="POST" action="{{ route('deleteType_intervention') }}">
        @csrf
        <input type="hidden" id="id_type_intervention" name="id_type_intervention" />
      </form>
      <script>
      function deleteType_interventionFunction(id_type_intervention, nom){
        var go = confirm('Vos êtes sur les points d\'effacer le type d\'intervention: "'+nom+'".\n voulez-vous continuer?');
        if(go){
          document.getElementById("id_type_intervention").value = id_type_intervention;
          document.getElementById("formDeleteType_intervention").submit();
        }
      }
      function updateType_interventionFunction(id_type_intervention, nom, description){
        document.getElementById("update_id_type_intervention").value = id_type_intervention;
        document.getElementById("update_nom").value = nom;
        document.getElementById("update_type_intervention_description").value = description;
      }
      </script>

      {{-- *****************************    List Type_intervention    ************************************************ --}}
      <div class="modal fade" id="modalListType_intervention" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Liste des types d'intervention</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">

                  <ul class="todo-list">
                    @if($familles->count() == 0)
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <i>Aucun type d'intervention</i>
                      </li>
                    @else
                      @foreach ($type_interventions as $item)

                        <li>
                          <span class="text"><p>{{ $item->nom }}</p></span>
                          @if( $item->description != null )
                            <small class="label label-primary"> {{ $item->description }}</small>
                          @endif
                          <div class="tools">
                            <div class="tools">
                              <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateType_intervention" onclick='updateType_interventionFunction({{ $item->id_type_intervention }}, "{{ $item->nom }}","{{ $item->description }}" );'></i>
                              <i class="fa fa-trash-o" onclick="deleteType_interventionFunction({{ $item->id_type_intervention }},'{{ $item->nom }}');" ></i>
                            </div>
                          </div>
                        </li>

                      @endforeach
                    @endif
                  </ul>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      {{-- *****************************    Add Type_intervention    ************************************************* --}}
      <div class="modal fade" id="modalAddType_intervention" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form AddFamille --}}
        <form method="POST" action="{{ route('addType_intervention') }}">
          @csrf

          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un type d'intervention</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                    {{-- Nom --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ old('nom') }}" required >
                    </div>
                  </div>

                  <div class="col-md-7">
                    {{-- description --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Description" name="description" value="{{ old('description') }}">
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </div>

            </div>
          </div>

        </form>
      </div>

      {{-- *****************************    update Type_intervention    ********************************************** --}}
      <div class="modal fade" id="modalUpdateType_intervention" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form AddFamille --}}
        <form method="POST" action="{{ route('updateType_intervention') }}">
          @csrf
          <input type="hidden" name="id_type_intervention" id="update_id_type_intervention">

          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification du type d'intervention</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                    {{-- Nom --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Nom" name="nom" id="update_nom" required >
                    </div>
                  </div>

                  <div class="col-md-7">
                    {{-- description --}}
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control" placeholder="Description" name="description" id="update_type_intervention_description">
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
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Type_intervention       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}


    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Technicien       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    <div class="CRUD Technicien">
      <form id="formDeleteTechnicien" method="POST" action="{{ route('deleteTechnicien') }}">
        @csrf
        <input type="hidden" id="id_technicien" name="id" />
      </form>
      <script>
      function deleteTechnicienFunction(id_technicien, nom, prenom){
        var go = confirm('Vos êtes sur les points d\'effacer le technicien: "'+nom+' '+prenom+'".\n voulez-vous continuer?');
        if(go){
          document.getElementById("id_technicien").value = id_technicien;
          document.getElementById("formDeleteTechnicien").submit();
        }
      }
      function updateTechnicienFunction(id_technicien, nom, prenom, login){
        document.getElementById("update_id_technicien_technicien").value = id_technicien;
        document.getElementById("update_nom_technicien").value = nom;
        document.getElementById("update_prenom_technicien").value = prenom;
        document.getElementById("update_login_technicien").value = login;
        //document.getElementById("update_password_equipement").value = password;
      }
      </script>

      {{-- *****************************    List Technicien    ************************************************ --}}
      <div class="modal fade" id="modalListTechnicien" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Liste des Techniciens</h4>
            </div>
            <div class="box-body">

              <script>
              $(document).ready(function() {
                $('#listTechs').DataTable( {
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

              @if($techs->count()==0)
                <span class="text"><i>Aucun technicien</i></span>
              @else
                <table id="listTechs" class="table table-hover" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Technicien</th>
                      <th>Login</th>
                      <th>Last Login</th>
                      <th>Tools</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($techs as $item)
                      <tr>
                        <td>{{ $item->nom }} {{ $item->prenom }}</td>
                        <td>{{ $item->login }}</td>
                        <td>{{ $item->last_login }}</td>
                        <td>
                          <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateTechnicien" onclick='updateTechnicienFunction({{ $item->id }}, "{{ $item->nom }}", "{{ $item->prenom }}" );'></i>
                          <i class="fa fa-trash-o" onclick="deleteTechnicienFunction({{ $item->id }},'{{ $item->nom }}');" ></i>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      {{-- *****************************    Add Technicien    ********************************************** --}}
      <div class="modal fade" id="modalAddTechnicien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form add Technicien --}}
        <form method="POST" action="{{ route('addTechnicien') }}">
          @csrf

          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un Technicien</h5>
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
                      <input type="text" class="form-control" placeholder="Nom" name="nom" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    {{-- Prenom --}}
                    <div class="form-group has-feedback">
                      <label>Prenom</label>
                      <input type="text" class="form-control" placeholder="Prenom" name="prenom">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    {{-- Login --}}
                    <div class="form-group has-feedback">
                      <label>Login</label>
                      <input type="text" class="form-control" placeholder="Login" name="login" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    {{-- Password --}}
                    <div class="form-group has-feedback">
                      <label>Password</label>
                      <input type="text" class="form-control" placeholder="Password" name="password" required>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </div>

            </div>
          </div>

        </form>
      </div>

      {{-- *****************************    update Technicien    ************************************************* --}}
      <div class="modal fade" id="modalUpdateTechnicien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Form update Technicien --}}
        <form method="POST" action="{{ route('updateTechnicien') }}">
          @csrf
          <input type="hidden" name="id" id="update_id_technicien_technicien">

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
                      <input type="text" class="form-control" placeholder="Nom" name="nom" id="update_nom_technicien" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    {{-- Prenom --}}
                    <div class="form-group has-feedback">
                      <label>Prenom</label>
                      <input type="text" class="form-control" placeholder="Prenom" name="prenom" id="update_prenom_technicien">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                    {{-- Login --}}
                    <div class="form-group has-feedback">
                      <label>Login</label>
                      <input type="text" class="form-control" placeholder="Login" name="login" id="update_login_technicien" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    {{-- Password --}}
                    <div class="form-group has-feedback">
                      <label>Password</label>
                      <input type="text" class="form-control" placeholder="Password" name="password">
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
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Technicien       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
    {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}


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
    <form id="formPrintTechniciens" method="POST" action="{{ route('printTechniciens') }}" target="_blank">
      @csrf
    </form>
    <form id="formPrintEquipements" method="POST" action="{{ route('printEquipements') }}" target="_blank">
      @csrf
    </form>

    <script>
    function printInterventionsFunction(){
      document.getElementById("formPrintInterventions").submit();
    }
    function printTechniciensFunction(){
      document.getElementById("formPrintTechniciens").submit();
    }
    function printEquipements(){
      alert('a');
      document.getElementById("formPrintEquipements").submit();
    }
    </script>
    {{-- ****************************** Print Forms *********************************************** --}}
    {{-- ****************************************************************************************** --}}

    {{-- ****************************************************************************************** --}}
    {{-- ************************** Export To Excel Forms ***************************************** --}}
    <form id="formExportInterventions" method="POST" action="{{ route('exportInterventions') }}" target="_blank">
      @csrf
    </form>
    <form id="formExportTechniciens" method="POST" action="{{ route('exportTechniciens') }}" target="_blank">
      @csrf
    </form>
    <form id="formExportEquipements" method="POST" action="{{ route('exportEquipements') }}" target="_blank">
      @csrf
    </form>
    <form id="formExportFamilles" method="POST" action="{{ route('exportFamilles') }}" target="_blank">
      @csrf
    </form>
    <form id="formExportFamilles2" method="POST" action="{{ route('exportFamilles2') }}" target="_blank">
      @csrf
    </form>

    <script>
    function exportInterventionsFunction(){
      document.getElementById("formExportInterventions").submit();
    }
    function exportTechniciensFunction(){
      document.getElementById("formExportTechniciens").submit();
    }
    function exportEquipementsFunction(){
      document.getElementById("formExportEquipements").submit();
    }
    function exportFamillesFunction(){
      document.getElementById("formExportFamilles").submit();
    }
    function exportFamilles2Function(){
      document.getElementById("formExportFamilles2").submit();
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
