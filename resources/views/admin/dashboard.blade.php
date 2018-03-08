@extends('layouts.master_2')

@section('content-head')

  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>

@endsection



@section('content')

  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- TO DO List -->
        <div class="box box-primary">
          <div class="box-header">
            <i class="ion ion-clipboard"></i>
            <h3 class="box-title">Liste des Familles</h3>
          </div><!-- /.box-header -->
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
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o">{{ $item->id_famille }}</i>
                  </div>
                </li>

              @endforeach


            </ul>
          </div><!-- /.box-body -->
          <div class="box-footer clearfix no-border">
            <button class="btn btn-default pull-right"><i class="fa fa-plus"></i> Ajouter une famille</button>
          </div>
        </div><!-- /.box -->


        <hr>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
          Launch demo modal
        </button>

      </div>


    </section><!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">




      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Diagnostics <span class="badge badge-info badge-pill"> ${diagnostics.size()}</span></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <div class="btn-group">
              <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><a data-toggle="modal" data-target="#modalAddDiag"><i class="fa fa-fw fa-plus"></i> Créer un diagnostic</a></li>
                <li><a data-toggle="modal" data-target="#modalListDiag"><i class="fa fa-fw fa-bars"></i> Tous les diagnostics</a></li>
                <li class="divider"></li>
                <li><a href="#">Imprimer la liste</a></li>
              </ul>
            </div>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <ul class="todo-list">
                <c:if test="${diagnostics.size() == 0}">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <i>Aucun Diagnostic</i>
                </li>
              </c:if>
              <c:if test="${diagnostics.size() != 0}">
              <c:if test="${diagnostics.size() > 5}">
              <c:set var="diagnostics" value="${diagnostics.subList(0,5)}" />
            </c:if>
            <li>
              <span class="text"><p>description</p></span>
              <div class="tools">
                <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateDiag" onclick='updateDiag(${diag.id_diagnostic},"${diag.description}",${diag.nombre_seances});'></i>
                <i class="fa fa-trash-o" onclick="deleteDiagnosticFunction(${diag.id_diagnostic},'${diag.description}');" ></i>
              </div>
            </li>

        </c:if>
      </ul>
    </div>
  </div><!-- /.row -->
</div><!-- ./box-body -->
<div class="box-footer">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
  </div>
</div>
</div>
{{-- ********************************************************************** --}}


</section><!-- right col -->
</div><!-- /.row (main row) -->


{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Modals       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}


{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       Famille       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
<form id="formDeleteFamille" method="POST" action="{{ route('admin-dash') }}">
  <input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
  <input type="hidden" id="id_diagnostic" name="id_diagnostic" />
  <input type="hidden" id="id_patient" name="id_patient" value="${patient.id_patient}" />
</form>
<script>
function deleteDiagnosticFunction(id_diag, description){
  var go = confirm('Vos êtes sur les points d\'effacer le diagnostic "'+description+'".\n voulez-vous continuer?');
  if(go){
    document.getElementById("id_diagnostic").value = id_diag;
    document.getElementById("formDeleteDiagnostic").submit();
  }
}
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter famille d'équipement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Formulaire
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
{{--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@       /.Famille       @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}


@endsection









@section('menu_1')@include('admin.menu_1')@endsection
  @section('menu_2')@include('admin.menu_2')@endsection
