<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Techniciens</title>
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
          <h1>Liste des Techniciens</h1>
        </div>
      </section>


      <section class="content">
        <div class="row">
          <div class="col-lg-1"></div>
          <div class="col-lg-5">

            <table class="table table-striped table-bordered" width="100%" >
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Prenom</th>
                  <th>Login</th>
                  <th>Date de création</th>
                  <th>Dernière connexion</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $item->nom }}</td>
                    <td>{{ $item->prenom }}</td>
                    <td>{{ $item->login }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{!! $item->last_login == null ? "<i>Jamais</i>" : $item->last_login !!}</td>
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
