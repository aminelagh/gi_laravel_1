<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Stats</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

  <style>
  <?php include(public_path().'/bootstrap/css/bootstrap.min.css');?>
</style>

</head>
<body>
  <div class="wrapper">

    <div class="content-wrapper">

      <section class="content-header">
        <div class="row" align="center">
          <h1>Liste des interventions</h1>
        </div>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-lg-1"></div>
          <div class="col-lg-5">

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
        </div>

        <div class="row">
          <h3>Details</h3>
          @isset($interventions)
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
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          @endisset
        </div>

      </section>


    </div>
    <!-- /.content-wrapper -->



  </div><!-- ./wrapper -->


</body>
</html>
