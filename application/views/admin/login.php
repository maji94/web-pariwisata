<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title>LOGIN | ADMIN AREA</title>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="description" content="Phoenixcoded">
	<meta name="keywords"
		  content=", Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
	<meta name="author" content="Phoenixcoded">

	<!-- Favicon icon -->
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/logo-provinsi-bengkulu.png" type="image/x-icon">
	<link rel="icon" href="<?php echo base_url();?>assets/images/logo-provinsi-bengkulu.ico" type="image/x-icon">

	<!-- Google font-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

	<!-- Font Awesome -->
	<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!--ico Fonts-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/icon/icofont/css/icofont.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">

	<!-- Style.css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/main.css">

	<!-- Responsive.css-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/responsive.css">

	<!--color css-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/color/color-1.min.css" id="color"/>

</head>
<body>
<section class="login p-fixed d-flex text-center bg-primary common-img-bg">
	<!-- Container-fluid starts -->
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12">
				<div class="login-card card-block">
					<?php echo form_open('login/getLogin','class="md-float-material" method="POST"'); ?>
					<!-- <form class="md-float-material"> -->
						<div class="text-center">
							<img src="<?php echo base_url();?>assets/images/logo-provinsi-bengkulu.png" alt="logo" width="15%">
						</div>
						<h3 class="text-center txt-primary">
							<strong>
								DINAS PARIWISATA PROVINSI BENGKULU
							</strong>
							<br>Admin Area
						</h3>
						<div class="md-input-wrapper">
							<input type="text" name="user" class="md-form-control" required>
							<label>Username</label>
						</div>
						<div class="md-input-wrapper">
							<input type="password" name="password" class="md-form-control" required>
							<label>Password</label>
						</div>
						<div class="row">
							<div class="col-sm-6 col-xs-12">
								<div class="rkmd-checkbox checkbox-rotate checkbox-ripple m-b-25">
									<label class="input-checkbox checkbox-primary">
										<input type="checkbox" name="checkbox" id="checkbox" required>
										<span class="checkbox"></span>
									</label>
									<div class="captions"><label for="checkbox">Bukan Robot</label></div>

								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 offset-xs-1">
								<button type="sumbit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">LOGIN</button>
							</div>
						</div>
						<!-- <div class="card-footer"> -->
						<!-- <div class="col-sm-12 col-xs-12 text-center">
							<span class="text-muted">Don't have an account?</span>
							<a href="register2.html" class="f-w-600 p-l-5">Sign up Now</a>
						</div> -->

						<!-- </div> -->
					<!-- </form> -->
					<?php echo form_close(); ?>
					<!-- end of form -->
				</div>
				<!-- end of login-card -->
			</div>
			<!-- end of col-sm-12 -->
		</div>
		<!-- end of row -->
	</div>
	<!-- end of container-fluid -->
</section>

<!-- Required Jqurey -->
<script src="<?php echo base_url();?>assets/plugins/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/tether/dist/js/tether.min.js"></script>
<!-- Required Fremwork -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- waves effects.js -->
<script src="<?php echo base_url();?>assets/plugins/Waves/waves.min.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?php echo base_url();?>assets/pages/elements.js"></script>
</body>
</html>