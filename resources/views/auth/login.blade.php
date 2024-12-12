<!DOCTYPE html>
<html lang="en">
<head>
	<title>Aplikasi Catat Meter</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset('public/assets-global/img/logo.png')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('public/auth/css/main.css')}}">
<!--===============================================================================================-->
<meta name="robots" content="noindex, follow">
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('public/auth/img/img-01.jpg');">
			<div class="wrap-login100 p-t-80 p-b-25">
				<form class="login100-form validate-form" action="{{ url('login_post') }}" method="POST" autocomplete="off">
					{{ csrf_field() }}
	
					<div class="login100-form-avatar">
						<img src="{{asset('public/assets-global/img/Logo-big.png')}}" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						PT Perusahaan Gas Negara
					</span>

                    @if(\Session::has('alert'))
                        <div class="wrap-input100 mb-3">
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle mr-2"></i> {{ Session::get('alert') }}
                            </div>
                        </div>
                    @endif

					<div class="wrap-input100 validate-input m-b-10">
						<input class="input100" type="text" name="nip" placeholder="Masukkan Nomor Induk Pegawai"  autocomplete="off" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10">
						<input class="input100" type="password" name="password" placeholder="Password" autocomplete="off" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn" type="submit">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="{{asset('public/auth/js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('public/auth/js/popper.js')}}"></script>
	<script src="{{asset('public/auth/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/auth/js/select2.min.js')}}"></script>
	<script src="{{asset('public/auth/js/main.js')}}"></script>
</body>
</html>
