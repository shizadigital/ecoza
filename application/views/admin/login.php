<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="<?php echo getAdminLocaleCode(false); ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="author" content="Shiza.id" />
    <meta name="robots" content="noindex,follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title><?php echo $title; ?></title>
	
	<!-- Icons -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo favicon_img_url(); ?>">
	<link rel="icon" type="image/ico" href="<?php echo favicon_img_url(); ?>">
	<link rel="shortcut icon" href="<?php echo favicon_img_url(); ?>">

	<!-- Global stylesheets -->	
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i,900" rel="stylesheet">

	<!-- VENDORS -->
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/bootstrap/dist/css/bootstrap.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/font-feathericons/dist/feather.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('admin/vendors/font-awesome/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('admin/vendors/font-linearicons/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('admin/vendors/font-icomoon/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('admin/vendors/perfect-scrollbar/css/perfect-scrollbar.css'); ?>">


	<script src="<?php echo admin_assets('vendors/jquery/dist/jquery.min.js'); ?>"></script>
	<script src="<?php echo admin_assets('vendors/popper.js/dist/umd/popper.js'); ?>"></script>
	<script src="<?php echo admin_assets('vendors/bootstrap/dist/js/bootstrap.js'); ?>"></script>
	<script src="<?php echo admin_assets('vendors/jquery-mousewheel/jquery.mousewheel.min.js'); ?>"></script>
	<script src="<?php echo admin_assets('vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.js'); ?>"></script>
  

	<!-- AIR UI HTML ADMIN TEMPLATE MODULES-->
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/vendors/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/core/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/widgets/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/system/style.css'); ?>">
	<!-- /global stylesheets -->

	<!-- PRELOADER STYLES-->
	<style>
	.air__initialLoading {
		position: fixed;
		z-index: 99999;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-position: center center;
		background-repeat: no-repeat;
		background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDFweCIgIGhlaWdodD0iNDFweCIgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIiBjbGFzcz0ibGRzLXJvbGxpbmciPiAgICA8Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiBmaWxsPSJub25lIiBuZy1hdHRyLXN0cm9rZT0ie3tjb25maWcuY29sb3J9fSIgbmctYXR0ci1zdHJva2Utd2lkdGg9Int7Y29uZmlnLndpZHRofX0iIG5nLWF0dHItcj0ie3tjb25maWcucmFkaXVzfX0iIG5nLWF0dHItc3Ryb2tlLWRhc2hhcnJheT0ie3tjb25maWcuZGFzaGFycmF5fX0iIHN0cm9rZT0iIzAxOTBmZSIgc3Ryb2tlLXdpZHRoPSIxMCIgcj0iMzUiIHN0cm9rZS1kYXNoYXJyYXk9IjE2NC45MzM2MTQzMTM0NjQxNSA1Ni45Nzc4NzE0Mzc4MjEzOCIgdHJhbnNmb3JtPSJyb3RhdGUoODQgNTAgNTApIj4gICAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgY2FsY01vZGU9ImxpbmVhciIgdmFsdWVzPSIwIDUwIDUwOzM2MCA1MCA1MCIga2V5VGltZXM9IjA7MSIgZHVyPSIxcyIgYmVnaW49IjBzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSI+PC9hbmltYXRlVHJhbnNmb3JtPiAgICA8L2NpcmNsZT4gIDwvc3ZnPg==);
		background-color: #fff;
	}
	</style>
	<script>
	$(document).ready(function () {
		$('.air__initialLoading').delay(200).fadeOut(400)
	})
	</script>

</head>

<body>
<div class="air__initialLoading"></div>

	<div class="air__auth">
		<div class="pt-5 pb-5 d-flex align-items-end mt-auto">
			<img src="<?php echo admin_assets('components/core/img/shiza-logo.png'); ?>" alt="Shiza.id" />
			<div class="air__utils__logo__text">
				<div class="air__utils__logo__name text-uppercase text-dark font-size-21"><?php echo t('administrator'); ?></div>
				<div class="air__utils__logo__descr text-uppercase font-size-12 text-gray-6">
				<?php echo t('storemanagement'); ?>
				</div>
			</div>
		</div>
		
		<div class="air__auth__container pl-5 pr-5 pt-5 pb-5 bg-white text-center">
			<div class="text-dark font-size-30 mb-4"><?php echo web_info(); ?></div>			
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

			<?php echo form_open( admin_url('main/authlogin'), array( 'class'=> 'mb-4' ) ); ?>
				<input type="hidden" value="<?php echo $CP; ?>" name="CP">				
				<div class="form-group mb-4">
					<input type="text"<?php if( !empty( $this->session->has_userdata('user_input') ) ){ echo ' value="'.$this->session->flashdata('user_input').'"'; } ?> name="user" class="form-control" placeholder="<?php echo t('username'); ?>">
					<div class="form-control-feedback">
						<i class="icon-user text-muted"></i>
					</div>
				</div>
				<div class="form-group mb-4">
					<input type="password"<?php if( !empty( $this->session->has_userdata('pass_input') ) ){ echo ' value="'.$this->session->flashdata('pass_input').'"'; } ?> name="pass" class="form-control" placeholder="<?php echo t('password'); ?>">
					<div class="form-control-feedback">
						<i class="icon-lock2 text-muted"></i>
					</div>
				</div>
				<button class="text-center btn btn-success w-100 font-weight-bold font-size-18"><?php echo t('logintoadministrator'); ?></button>
			<?php echo form_close();?>
			
			<a href="#" class="text-blue font-weight-bold font-size-18"><?php echo t('forgotpassword'); ?></a>
		</div>

		<div class="mt-auto pb-5 pt-5">
			<ul class="air__auth__footerNav list-unstyled d-flex mb-2 flex-wrap justify-content-center">
				<li>
					<a href="#">Terms of Use</a>
				</li>
				<li>
					<a href="https://github.com/shizadigital/shiza" target="_blank">Github</a>
				</li>
				<li>
					<a href="#">Support</a>
				</li>
				<li>
					<a href="#">Contacts</a>
				</li>
			</ul>

			<div class="text-gray-4 text-center">
				© <?php echo date('Y'); ?> <a href="<?php echo base_url(); ?>"><?php echo web_info(); ?></a>. All rights reserved. Powered by <a href="https://shiza.id/" target="_blank">Shiza</a>. Version <?php echo SHIZA_VERSION; ?>
			</div>
		</div>
	</div>

</body>
</html>