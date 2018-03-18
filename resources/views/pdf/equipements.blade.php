<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Equipements</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

  <!-- Bootstrap 3.3.2 -->
  <style>
  <?php include(public_path().'/bootstrap/css/bootstrap.min.css');?>
</style>

</head>
<body>
  <div class="wrapper">

    <div class="content-wrapper">

      <section class="content-header">
        <div class="row" align="center">
          <h1>Liste des Equipements</h1>
        </div>
      </section>


      <section class="content">
        <div class="row">
          <div class="col-lg-1"></div>
          <div class="col-lg-5">

            <table class="table table-striped table-bordered" width="100%" >
              <thead>
                <tr>
                  <th>Equipement</th>
                  <th>Famille</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $item->description_e }}</td>
                    <td>{{ $item->description_f }}</td>
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
