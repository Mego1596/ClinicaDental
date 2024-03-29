<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Clinica @include('layouts.nombreEmpresa') - @yield('titulo')</title>

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>


  @yield('CSS')
  <style type="text/css">
    .sidebar-brand {
      background-color: #212529;
    }

    .navbar {
      background-color: #212529;
    }

    .sidebar-divider {
      background-color: white;
      width: 100%;
    }


    @media (max-width: 768px) {

      .fc-toolbar .fc-left,
      .fc-toolbar .fc-center,
      .fc-toolbar .fc-right {
        display: inline-block;
        float: none !important;
      }
    }

    /*  .loader {
  border: 16px solid #f3f3f3; 
  border-top: 16px solid #3498db; 
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}*/

    /*@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}*/
  </style>
</head>

<body id="page-top" onload="mueveReloj()">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <img src="{{asset('img/yekipaki2.jpg')}}" style="height: 300%">
        <div class="sidebar-brand-text mx-3">@include('layouts.nombreEmpresa')</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="/home">
          <i class="fa  fa-home"></i>
          <span>Inicio</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      @if(Auth::user()->roles[0]['slug'] == 'admin')
      <div class="sidebar-heading">
        Administración de Usuarios
      </div>
      @endif
      <!-- Nav Item - Pages Collapse Menu -->
      @can('usuario.index')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('users.index')}}">
          <i class="fa fa-group"></i>
          <span>Listado de Usuarios</span>
        </a>
      </li>
      @endcan
      @can('role.index')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('roles.index')}}">
          <i class="fa fa-list"></i>
          <span>Listado de Roles</span>
        </a>
      </li>
      @endcan
      @can('expediente.index')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('expedientes.index')}}">
          <i class="fa fa-address-card"></i>
          <span>Listado de Pacientes</span>
        </a>
      </li>
      @endcan
      @can('procedimiento.index')
      <div class="sidebar-heading">
        Procedimientos
      </div>
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('procedimientos.index')}}">
          <i class="fa fa-list"></i>
          <span>Listado de Procedimientos</span>
        </a>
      </li>
      @endcan
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link">
                <span id="time_span"></span>
              </a>
            </li>
            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              @guest
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              @endguest
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  @guest

                  @else
                  {{Auth::user()->persona->primer_nombre.' '.Auth::user()->persona->segundo_nombre.' '.Auth::user()->persona->primer_apellido.' '.Auth::user()->persona->segundo_apellido}}
                  @endguest
                </span>
                <img class="img-profile rounded-circle" src="{{asset('css/account.png')}}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('perfil')}}">
                  <i class="fa  fa-address-card fa-sm mr-2 text-gray-400"></i>
                  Perfil de Usuario
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fa fa-sign-out fa-sm  mr-2 text-gray-400"></i>
                  Cerrar Sesión
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->

        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">Clínica de Atencion Integral y Preventiva @include('layouts.nombreEmpresa')</div>
              <div class="card-body">
                @yield('content')
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>&copy; Sana Dental 2019</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Estás Listo para irte?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Selecciona la opción de "Cerrar Sesión" si estas listo para finalizar tu sesión actual.</div>
          <div class="modal-footer">
            <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
    <!-- Page level plugins -->
    <!-- Page level custom scripts -->
    <script type="text/javascript">
      $(document).ready(function() {
        $("form").submit(function() {
          $("button.btn.btn-success").attr('disabled', true);
          $("button.btn.btn-danger").attr('disabled', true);
        });
      });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/es.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    @yield('JS')
    <script type="text/javascript">
      function mueveReloj(argument) {
        var currentTime = new Date()
        var hours = currentTime.getHours()
        var minutes = currentTime.getMinutes()
        var seconds = currentTime.getSeconds()
        var month = currentTime.getMonth() + 1
        var date = currentTime.getDate()
        if (minutes < 10) {
          minutes = "0" + minutes
        }
        if (seconds < 10) {
          seconds = "0" + seconds
        }
        if (month < 10) {
          month = "0" + month
        }
        if (date < 10) {
          date = "0" + date
        }
        var t_str = date + "/" + month + "/" + currentTime.getFullYear() + " " + hours + ":" + minutes + ":" + seconds;
        if (hours > 11) {
          t_str += " PM";
        } else {
          t_str += " AM";
        }
        document.getElementById('time_span').innerHTML = t_str;
        setTimeout("mueveReloj()", 1000);
      }
    </script>
</body>

</html>