<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

</head>
<body class="login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/admin"><b>Gestion des </b>Interventions</a>
    </div>

    @if (session('alert_danger'))
    <div class="alert alert-danger">
      {{ session('alert_danger') }}
    </div>
    @elseif(isset($alert_danger))
    <div class="alert alert-danger">
      {{ $alert_danger }}
    </div>
    @endif

    <div class="login-box-body">
      <p class="login-box-msg">Creation des utilisateurs</p>

      <form action="/register" method="POST">
        @csrf
        {{-- csrf_field() --}}

        {{-- Role --}}
        <div class="form-group has-feedback">
          <select name="role_slug" class="form-control">
            @foreach($roles as $role)
            <option value="{{ $role->slug }}">{{ $role->name }}</option>
            @endForeach
          </select>
        </div>

        {{-- Login --}}
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Login" name="login" value="{{ old('login') }}" required/>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        {{-- password --}}
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password" value="" required />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        {{-- password_confirm --}}
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Confirmation Password" name="password_confirmation" value="" required />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        {{-- Nom --}}
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ old('nom') }}" required/>
        </div>

        {{-- Prenom --}}
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="{{ old('prenom') }}" />
        </div>

        <div class="row">
          <div class="col-xs-12" align="center">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Valider</button>
          </div><!-- /.col -->
        </div>
      </form>


    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->

  <!-- jQuery 2.1.3 -->
  <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>

</body>

</html>
