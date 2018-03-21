<header class="main-header">
  <!-- Logo -->
  <a class="logo"><b>Administrateur</b></a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="hidden-xs">{{ Session::get('nom') }} {{ Session::get('prenom') }} </span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="public/img/admin.png" class="img-circle" alt="User Image" />
              <p>
                {{ Session::get('nom') }} {{ Session::get('prenom') }}
                <small>Administrateur</small>
              </p>
            </li>
            <!-- Menu Body -->
            <!--li class="user-body">
              <div class="col-xs-12 text-center">
                <a href="">Profile</a>
              </div>
            </li-->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a data-toggle="modal" data-target="#modalUpdateProfile" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Deconnexion</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
