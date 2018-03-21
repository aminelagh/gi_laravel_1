<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Authentification</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link href="public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

  <!-- Bootstrap 3.3.2 JS -->
  <script src="public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

</head>
<body class="login-page">

  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Gestion des </b>Interventions</a>

    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Veuillez vous authentifier</p>
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Login" name="login" value="{{ old('login') }}" required/>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password" required />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12" align="center">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Connexion</button>
          </div><!-- /.col -->
        </div>
      </form>

    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->

  <!-- jQuery 2.1.3 -->
  <script src="public/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- iCheck -->
  <script src="public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

  @include('layouts.alerts')

</body>

</html>
