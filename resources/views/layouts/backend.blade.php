<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Aplikasi Catat Meter PGN">
    <meta name="author" content="Zakian Maulana Syaifulloh">
    <meta name="referrer" content="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Aplikasi Catat Meter PGN</title>
    
    <link rel="icon" type="image/x-icon" href="{{asset('public/assets-global/img/logo.png')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/assets-global/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('public/assets-global/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/assets-global/css/adminlte.min.css')}}">

	<!-- =================================== ADDITIONAL PLUGIN ===================================== -->
	<!-- DataTables -->
	<link rel="stylesheet" href="{{asset('public/assets-global/css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/fixedHeader.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/responsive.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/buttons.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/select.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/rowGroup.bootstrap4.min.css')}}">
	<!-- Additinal script -->
	<link rel="stylesheet" href="{{asset('public/assets-global/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/select2-bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/sweetalert2.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/load-table.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/custom-table.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/flatpickr.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/toastr.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/dropify.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/assets-global/css/css-custom.css')}}">
    
    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                
				<li class="nav-item dropdown user-menu">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
						<img src="{{asset('public/assets-global/img/user-default/male.png')}}" class="user-image img-circle elevation-2" alt="User Image">
						<span class="d-none d-md-inline">{{ Auth::user()->nama }}</span>
					</a>
					<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<!-- User image -->
						<li class="user-header bg-primary">
							<img src="{{asset('public/assets-global/img/user-default/male.png')}}" class="img-circle elevation-2" alt="User Image">
							<p style="font-size: 15px">
								{{ Auth::user()->nama }} - {{ Auth::user()->nip }} <br>
								<span>{{ ucfirst(Auth::user()->role) }}</span>
							</p>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<a href="{{url('logout')}}" class="btn btn-danger btn-flat float-right">Sign out</a>
						</li>
					</ul>
				</li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
			<a href="{{url('/dashboard')}}" class="brand-link brand-link">
				<img src="{{asset('public/assets-global/img/logo.png')}}" class="brand-image img-circle elevation-3" style="opacity: 1.8;background: #fff;padding: 5px;">
				<span class="brand-text font-weight-light"><small><strong>PT Perusahaan Gas Negara</strong></small></span>
			</a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @if (Auth::user()->role == 'operator')
                            <li class="nav-item">
                                <a href="{{url('catat-meter-gas')}}" class="nav-link {{ request()->is('catat-meter-gas') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-edit"></i>
                                    <p>
                                        Catat Meter Gas
                                    </p>
                                </a>
                            </li>
                        @endif
                        
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a href="{{url('dashboard')}}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            
                            <li class="nav-item {{ request()->is('master-data/*') ? 'menu-open' : '' }}">
                                <a href="javascript:void(0);" class="nav-link {{ request()->is('master-data/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Master Data
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('master-data/pelanggan')}}" class="nav-link {{ request()->is('master-data/pelanggan') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pelanggan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('master-data/user')}}" class="nav-link {{ request()->is('master-data/user') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>User</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
			<!-- Main content -->
			<div class="content pt-4">
                @yield('content')
			</div>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            <b>Template By Admin LTE Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2024</strong> Zakian Maulana Syaifulloh
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset('public/assets-global/js/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('public/assets-global/js/bootstrap.bundle.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('public/assets-global/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('public/assets-global/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('public/assets-global/js/demo.js')}}"></script>
    
	<!-- DataTables  & Plugins -->
	<script src="{{asset('public/assets-global/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/buttons.bootstrap4.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTables.select.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTables.fixedHeader.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/buttons.print.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/buttons.colVis.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTables.rowGroup.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/rowGroup.bootstrap4.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTable.rowSpanGroup.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dataTables.fixedColumns.min.js')}}"></script>

    <!-- additional script -->
	<script src="{{asset('public/assets-global/js/moment.min.js')}}"></script>
    <script src="{{asset('public/assets-global/js/jquery.validate.js')}}"></script>
    <script src="{{asset('public/assets-global/js/select2.full.min.js')}}"></script>
    <script src="{{asset('public/assets-global/js/sweetalert2.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/flatpickr.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/toastr.min.js')}}"></script>
	<script src="{{asset('public/assets-global/js/dropify.min.js')}}"></script>
    <!-- Highcharts js -->
    <script src="{{asset('public/assets-global/js/highcharts/highcharts.js')}}"></script>
    <script src="{{asset('public/assets-global/js/highcharts/data.js')}}"></script>
    <script src="{{asset('public/assets-global/js/highcharts/pareto.js')}}"></script>
    <script src="{{asset('public/assets-global/js/highcharts/exporting.js')}}"></script>
    <script src="{{asset('public/assets-global/js/highcharts/export-data.js')}}"></script>
    <script src="{{asset('public/assets-global/js/highcharts/accessibility.js')}}"></script>
	<script src="{{asset('public/assets-global/js/js-custom.js')}}"></script>

	<script>
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		});

		flatpickr();

		function flatpickr() {
			$(".flatpickr-input").flatpickr({
				dateFormat: "Y-m-d",
				allowInput: true,
			});

			$(".flatpickr-time").flatpickr({
				dateFormat: "H:i",
                enableTime: true,
                noCalendar: true,
				time_24hr: true,
			});

			$(".flatpickr").flatpickr({
				dateFormat: "d F Y"
			});

			$(".flatpickr").val(moment().format("DD MMMM YYYY")).removeAttr('readonly');
			$(".flatpickr-time").val(moment().format("HH:mm")).removeAttr('readonly');
		}

        $('.dropify').dropify({
            messages: {
                'default': 'Seret dan jatuhkan file di sini atau klik',
                'replace': 'Seret dan jatuhkan atau klik untuk mengganti',
                'remove':  'Hapus',
                'error':   'Oops, terjadi kesalahan.'
            }
        });

        $('.select2').select2()
    </script>

    @yield('js')
</body>
</html>
