<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name'))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

  <link rel="stylesheet"href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('app.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
        body{

        }
        .sidebar, .logoLevo{
            background-color:#06065a !important;
            opacity: 1 !important;
            color: white;
        }
        .main-header{
            /*background-color: #d60213;*/
            background-color:white;

        }


       .card-blue{

    background-color: #2c0289 !important;
    }

        .btn{
        background-color: #2c0289;
        color: white;
        }
        .btn-primary{
        background-color: #2c0289;
        color: white;
        }
        .no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(https://digitalmonkeynl.github.io/FB-Docs/2.0.2/img/form/loading.gif) center no-repeat #fff;
}

    </style>
<script>
    function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('time').innerHTML =
      h + ":" + m + ":" + s + " UTC";
      var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
    }
    </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
</head>

<script>
    $(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
    </script>
<body class="hold-transition sidebar-mini layout-fixed" onload="startTime()">
    <div class="se-pre-con"></div>
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Tech support</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link" >{{Carbon\Carbon::now()->format('d.m.Y')}}</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link" id='time' style="margin-left: -10px;"> </a>
            </li>
        </ul>

        <!-- SEARCH FORM -->


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                @auth
                    <a href="{{route('profile')}}">
                        <i class="fas fa-user mt-1" style="color: #2c0289"></i>
                       <strong style="color: #2c0289">{{ auth()->user()->name}} {{auth()->user()->last_name}}</strong></a> [{{auth()->user()->cid}}]


            </li>
            <li class="nav-item dropdown ml-1">
                <a href="{{route('logout')}}" class="text-danger">Logout</a>
            </li>
            @endauth
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 logoLevo">
        <!-- Brand Logo -->
        <a href="{{route('home')}}" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">ATC Center</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="{{route('profile')}}" class="nav-link">
                            <i class="fas fa-user"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Training
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{route('applicationRequest')}}" class="nav-link">
                                    <i class="fas fa-caret-right"></i>
                                    <p>Training applications</p>
                                </a>
                            </li>

                            @if(in_array("Trainee", explode(', ',auth()->user()->roles)))
                            <li class="nav-item">
                                <a href="{{route('request.training')}}" class="nav-link">
                                    <i class="fas fa-caret-right"></i>
                                    <p>Request a training</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{route('progress')}}" class="nav-link">
                                    <i class="fas fa-caret-right"></i>
                                    <p>Training review</p>
                                </a>
                            </li>
                            @endif

                        </ul>
                    @if(in_array("ATC", explode(', ',auth()->user()->roles)) || in_array("Visiting ATC", explode(', ',auth()->user()->roles)) || in_array("Trainee", explode(', ',auth()->user()->roles)))
                    <li class="nav-item">
                        <a href="events" class="nav-link">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Events
                            </p>
                        </a>
                    </li>
                    @endif
                    @if(in_array("ATC", explode(', ',auth()->user()->roles)) || in_array("Visiting ATC", explode(', ',auth()->user()->roles)))
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fas fa-headphones-alt"></i>
                            <p>
                                ATC
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('bookings')}}" class="nav-link">
                                    <i class="fas fa-caret-right"></i>
                                    <p>Bookings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="fas fa-caret-right"></i>
                                    <p>Roster</p>
                                </a>
                            </li>
                           
                        </ul>
                    @endif
                    @if(in_array("ATC", explode(', ',auth()->user()->roles)) || in_array("Visiting ATC", explode(', ',auth()->user()->roles)))
                <li class="nav-item">
                    <a href="/reviews" class="nav-link">
                        <i class="nav-icon far as fa-edit"></i>
                        <p>
                            Reviews
                        </p>
                    </a>
                </li>
                    @endif
                    @if(in_array("Mentor", explode(', ',auth()->user()->roles)))
                    <li class="nav-header">TD</li>
                    <li class="nav-item">
                        <a href="{{route('training.requests')}}" class="nav-link">
                            <i class="fas fa-caret-right"></i>
                            <p>
                                Training requests
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="/my_mentor_sessions" class="nav-link">
                        <i class="fas fa-caret-right"></i>
                        <p>
                            My mentor sessions
                        </p>
                    </a>
                    </li>
                    <li class="nav-item">
                        <a href="/mentor_reviews" class="nav-link">
                            <i class="fas fa-caret-right"></i>
                            <p>
                                My reviews
                            </p>
                        </a>
                        </li>
                    @if(in_array("TD", explode(', ',auth()->user()->roles)))
                    <li class="nav-item">
                        <a href="{{route('trainees')}}" class="nav-link">
                            <i class="fas fa-caret-right"></i>
                            <p>
                                Trainees managment
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('trainingApplications')}}" class="nav-link">
                            <i class="fas fa-caret-right"></i>
                            <p>
                                Training applications
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/mentor_reviews_all" class="nav-link">
                            <i class="fas fa-caret-right"></i>
                            <p>
                                Mentor reviews
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/atcs" class="nav-link">
                            <i class="fas fa-caret-right"></i>
                            <p>
                                Manage controllers
                            </p>
                        </a>
                    </li>
                    
                    @endif
                    @endif
                  
                    @if(in_array("Admin", explode(', ',auth()->user()->roles)))
                        <li class="nav-header">ADMIN</li>
                        <li class="nav-item">
                            <a href="{{route('roles')}}" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Manage roles
                                </p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-header">CONTACT</li>
                    <li class="nav-item">
                        <a href="{{}}" class="nav-link">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>
                                Contact web department
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->

     

  
@yield('content')

<!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; <?php echo date("Y"); ?>. vACC management system by <a href="https://github.com/aleksae/">Aleksa Erić [1400612]</a>.</strong>
        <strong>Used and maintained by <a href="http://www.vatadria.net">VATAdria</a>.</strong>

        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>



</body>

</html>
