<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Title_1</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

  <!-- Bootstrap 3.3.2 -->

  <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

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

            <table class="table table-striped table-bordered" width="100%" >
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Equipement</th>
                  <th>Technicien</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Durée</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $item->nom_ti }}</td>
                    <td>{{ $item->description_e }} ({{ $item->description_f }})</td>
                    <td>{{ $item->nom_u }} {{ $item->prenom_u }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->duree }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </section>

    </div>
    <!-- /.content-wrapper -->



  </div><!-- ./wrapper -->


</body>
</html>
