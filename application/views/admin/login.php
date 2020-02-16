<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="author" content="Memo Indo Media" />
    <meta name="robots" content="noindex,follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title><?php echo $title; ?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo admin_assets(); ?>/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo admin_assets(); ?>/global_assets/css/icons/material/icons.css" rel="stylesheet" type="text/css">
	<link href="<?php echo admin_assets(); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo admin_assets(); ?>/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo admin_assets(); ?>/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo admin_assets(); ?>/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo admin_assets(); ?>/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?php echo admin_assets(); ?>/global_assets/js/main/jquery.min.js"></script>
	<script src="<?php echo admin_assets(); ?>/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="<?php echo admin_assets(); ?>/global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?php echo admin_assets(); ?>/js/app.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login form -->
				<?php echo form_open( admin_url('main/authlogin'), array( 'class'=> 'login-form' ) ); ?>
					<input type="hidden" value="<?php echo $CP; ?>" name="CP">

					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Login ke Administrator</h5>
								<span class="d-block text-muted">Masukkan informasi akun Anda di bawah ini</span>
							</div>
							<?php 
							if( !empty( $this->session->has_userdata('errormsg') ) ){
					            echo '
								<div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
									' . $this->session->flashdata('errormsg') . '
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="mi-close"></i></button>
								</div>
								';
							}

							if( !empty( $this->session->has_userdata('successmsg') ) ){
					            echo '
								<div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
									' . $this->session->flashdata('successmsg') . '
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="mi-close"></i></button>
								</div>
								';
							}
					        ?>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text"<?php if( !empty( $this->session->has_userdata('username') ) ){ echo ' value="'.$this->session->flashdata('username').'"'; } ?> name="user" class="form-control" placeholder="Username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password"<?php if( !empty( $this->session->has_userdata('password') ) ){ echo ' value="'.$this->session->flashdata('password').'"'; } ?> name="pass" class="form-control" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Masuk ke Administrator <i class="icon-circle-right2 ml-2"></i></button>
							</div>
						</div>
					</div>
				<?php echo form_close();?>
				<!-- /login form -->

			</div>
			<!-- /content area -->


			<!-- Footer -->
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; <?php echo date('Y'); ?>. <a href="<?php echo base_url(); ?>"><?php echo web_info(); ?></a>. Powered by <a href="https://www.memoindomedia.com/" target="_blank">Memo Indo Media</a>
					</span>
					
					<ul class="navbar-nav ml-lg-auto">
						<?php /*
						<li class="nav-item"><a href="#" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
						<li class="nav-item"><a href="#" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
						*/ ?>
						<li class="nav-item">Version <?php echo FRAMEWORK_VERSION; ?></li>
					</ul>
					
				</div>
			</div>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>