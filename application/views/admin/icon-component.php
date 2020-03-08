<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">

<head>
<title><?php echo $title; ?></title>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="author" content="<?php echo "Shiza.id"; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="robots" content="noindex,nofollow" />

<!-- Icons -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo favicon_img_url(); ?>">
<link rel="icon" type="image/ico" href="<?php echo favicon_img_url(); ?>">
<link rel="shortcut icon" href="<?php echo favicon_img_url(); ?>">

<!-- Font -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i,900" rel="stylesheet">

<!-- VENDORS -->
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/bootstrap/dist/css/bootstrap.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/font-feathericons/dist/feather.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/font-awesome/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/font-linearicons/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/font-icomoon/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('vendors/perfect-scrollbar/css/perfect-scrollbar.css'); ?>">


<!-- AIR UI HTML ADMIN TEMPLATE MODULES-->
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/vendors/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/core/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/widgets/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/system/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/menu-left/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/footer/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/apps/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/extra-apps/style.css'); ?>">

<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('custom.css'); ?>">

<!--  -->
<script src="<?php echo admin_assets('vendors/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?php echo admin_assets('vendors/popper.js/dist/umd/popper.js'); ?>"></script>
<script src="<?php echo admin_assets('vendors/bootstrap/dist/js/bootstrap.js'); ?>"></script>

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

<body class="p-5">
<div class="air__utils__heading">
	<?php 
	echo "<h5>";
	if($this->input->get('theval')=='feather'){ echo 'Feather Icons'; }
	if($this->input->get('theval')=='font-awesome'){ echo 'FontAwesome'; }
	if($this->input->get('theval')=='icomoon'){ echo 'Icomoon Free'; }
	if($this->input->get('theval')=='linearicons'){ echo 'Linearicons Free'; }
	echo "</h5>";
	?>
</div>
<script>
$( document ).ready(function() {
    $('#pilihanicon').change(function(){
		var val = $(this).val();
		window.location.href = "<?php echo admin_url('main/iconscomponent/?theval='); ?>"+val;
    });
});	
</script>
<div class="card">
	
	<div class="card-header">
		<div class="row">
            <div class="col-md-6">
                <select class="custom-select" id="pilihanicon">
                    <option value="feather"<?php if($this->input->get('theval')=='feather'){ echo ' selected'; } ?>>Feather Icons</option>
                    <option value="font-awesome"<?php if($this->input->get('theval')=='font-awesome'){ echo ' selected'; } ?>>Font Awesome</option>
                    <option value="icomoon"<?php if($this->input->get('theval')=='icomoon'){ echo ' selected'; } ?>>Icomoon Free</option>
                    <option value="linearicons"<?php if($this->input->get('theval')=='linearicons'){ echo ' selected'; } ?>>Linearicons Free</option>
                </select>
            </div>
        </div>
	</div>
	<div class="card-body">

	<?php if($this->input->get('theval')=='feather'){ ?>
		<div class="row">
			<div class="col-lg-12">
				<h5 class="text-black"><strong>Simply beautiful open source icons</strong></h5>
				<p class="text-muted">
					The complete set of 279 icons in Feathericons v4.21.0
					<br />
					License: MIT License. You can use it for commercial projects, open source projects, or
					really just about whatever you want
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<h3 class="text-block mt-5 mb-4 text-center"><strong>General Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fe fe-activity"></i></li>
					<li><i class="fe fe-airplay"></i></li>
					<li><i class="fe fe-alert-circle"></i></li>
					<li><i class="fe fe-alert-octagon"></i></li>
					<li><i class="fe fe-alert-triangle"></i></li>
					<li><i class="fe fe-align-center"></i></li>
					<li><i class="fe fe-align-justify"></i></li>
					<li><i class="fe fe-align-left"></i></li>
					<li><i class="fe fe-align-right"></i></li>
					<li><i class="fe fe-anchor"></i></li>
					<li><i class="fe fe-aperture"></i></li>
					<li><i class="fe fe-archive"></i></li>
					<li><i class="fe fe-arrow-down"></i></li>
					<li><i class="fe fe-arrow-down-circle"></i></li>
					<li><i class="fe fe-arrow-down-left"></i></li>
					<li><i class="fe fe-arrow-down-right"></i></li>
					<li><i class="fe fe-arrow-left"></i></li>
					<li><i class="fe fe-arrow-left-circle"></i></li>
					<li><i class="fe fe-arrow-right"></i></li>
					<li><i class="fe fe-arrow-right-circle"></i></li>
					<li><i class="fe fe-arrow-up"></i></li>
					<li><i class="fe fe-arrow-up-circle"></i></li>
					<li><i class="fe fe-arrow-up-left"></i></li>
					<li><i class="fe fe-arrow-up-right"></i></li>
					<li><i class="fe fe-at-sign"></i></li>
					<li><i class="fe fe-award"></i></li>
					<li><i class="fe fe-bar-chart"></i></li>
					<li><i class="fe fe-bar-chart-2"></i></li>
					<li><i class="fe fe-battery"></i></li>
					<li><i class="fe fe-battery-charging"></i></li>
					<li><i class="fe fe-bell"></i></li>
					<li><i class="fe fe-bell-off"></i></li>
					<li><i class="fe fe-bluetooth"></i></li>
					<li><i class="fe fe-bold"></i></li>
					<li><i class="fe fe-book"></i></li>
					<li><i class="fe fe-book-open"></i></li>
					<li><i class="fe fe-bookmark"></i></li>
					<li><i class="fe fe-box"></i></li>
					<li><i class="fe fe-briefcase"></i></li>
					<li><i class="fe fe-calendar"></i></li>
					<li><i class="fe fe-camera"></i></li>
					<li><i class="fe fe-camera-off"></i></li>
					<li><i class="fe fe-cast"></i></li>
					<li><i class="fe fe-check"></i></li>
					<li><i class="fe fe-check-circle"></i></li>
					<li><i class="fe fe-check-square"></i></li>
					<li><i class="fe fe-chevron-down"></i></li>
					<li><i class="fe fe-chevron-left"></i></li>
					<li><i class="fe fe-chevron-right"></i></li>
					<li><i class="fe fe-chevron-up"></i></li>
					<li><i class="fe fe-chevrons-down"></i></li>
					<li><i class="fe fe-chevrons-left"></i></li>
					<li><i class="fe fe-chevrons-right"></i></li>
					<li><i class="fe fe-chevrons-up"></i></li>
					<li><i class="fe fe-chrome"></i></li>
					<li><i class="fe fe-circle"></i></li>
					<li><i class="fe fe-clipboard"></i></li>
					<li><i class="fe fe-clock"></i></li>
					<li><i class="fe fe-cloud"></i></li>
					<li><i class="fe fe-cloud-drizzle"></i></li>
					<li><i class="fe fe-cloud-lightning"></i></li>
					<li><i class="fe fe-cloud-off"></i></li>
					<li><i class="fe fe-cloud-rain"></i></li>
					<li><i class="fe fe-cloud-snow"></i></li>
					<li><i class="fe fe-code"></i></li>
					<li><i class="fe fe-codepen"></i></li>
					<li><i class="fe fe-command"></i></li>
					<li><i class="fe fe-compass"></i></li>
					<li><i class="fe fe-copy"></i></li>
					<li><i class="fe fe-corner-down-left"></i></li>
					<li><i class="fe fe-corner-down-right"></i></li>
					<li><i class="fe fe-corner-left-down"></i></li>
					<li><i class="fe fe-corner-left-up"></i></li>
					<li><i class="fe fe-corner-right-down"></i></li>
					<li><i class="fe fe-corner-right-up"></i></li>
					<li><i class="fe fe-corner-up-left"></i></li>
					<li><i class="fe fe-corner-up-right"></i></li>
					<li><i class="fe fe-cpu"></i></li>
					<li><i class="fe fe-credit-card"></i></li>
					<li><i class="fe fe-crop"></i></li>
					<li><i class="fe fe-crosshair"></i></li>
					<li><i class="fe fe-database"></i></li>
					<li><i class="fe fe-delete"></i></li>
					<li><i class="fe fe-disc"></i></li>
					<li><i class="fe fe-dollar-sign"></i></li>
					<li><i class="fe fe-download"></i></li>
					<li><i class="fe fe-download-cloud"></i></li>
					<li><i class="fe fe-droplet"></i></li>
					<li><i class="fe fe-edit"></i></li>
					<li><i class="fe fe-edit-2"></i></li>
					<li><i class="fe fe-edit-3"></i></li>
					<li><i class="fe fe-external-link"></i></li>
					<li><i class="fe fe-eye"></i></li>
					<li><i class="fe fe-eye-off"></i></li>
					<li><i class="fe fe-facebook"></i></li>
					<li><i class="fe fe-fast-forward"></i></li>
					<li><i class="fe fe-feather"></i></li>
					<li><i class="fe fe-file"></i></li>
					<li><i class="fe fe-file-minus"></i></li>
					<li><i class="fe fe-file-plus"></i></li>
					<li><i class="fe fe-file-text"></i></li>
					<li><i class="fe fe-film"></i></li>
					<li><i class="fe fe-filter"></i></li>
					<li><i class="fe fe-flag"></i></li>
					<li><i class="fe fe-folder"></i></li>
					<li><i class="fe fe-folder-minus"></i></li>
					<li><i class="fe fe-folder-plus"></i></li>
					<li><i class="fe fe-gift"></i></li>
					<li><i class="fe fe-git-branch"></i></li>
					<li><i class="fe fe-git-commit"></i></li>
					<li><i class="fe fe-git-merge"></i></li>
					<li><i class="fe fe-git-pull-request"></i></li>
					<li><i class="fe fe-github"></i></li>
					<li><i class="fe fe-gitlab"></i></li>
					<li><i class="fe fe-globe"></i></li>
					<li><i class="fe fe-grid"></i></li>
					<li><i class="fe fe-hard-drive"></i></li>
					<li><i class="fe fe-hash"></i></li>
					<li><i class="fe fe-headphones"></i></li>
					<li><i class="fe fe-heart"></i></li>
					<li><i class="fe fe-help-circle"></i></li>
					<li><i class="fe fe-home"></i></li>
					<li><i class="fe fe-image"></i></li>
					<li><i class="fe fe-inbox"></i></li>
					<li><i class="fe fe-info"></i></li>
					<li><i class="fe fe-instagram"></i></li>
					<li><i class="fe fe-italic"></i></li>
					<li><i class="fe fe-layers"></i></li>
					<li><i class="fe fe-layout"></i></li>
					<li><i class="fe fe-life-buoy"></i></li>
					<li><i class="fe fe-link"></i></li>
					<li><i class="fe fe-link-2"></i></li>
					<li><i class="fe fe-linkedin"></i></li>
					<li><i class="fe fe-list"></i></li>
					<li><i class="fe fe-loader"></i></li>
					<li><i class="fe fe-lock"></i></li>
					<li><i class="fe fe-log-in"></i></li>
					<li><i class="fe fe-log-out"></i></li>
					<li><i class="fe fe-mail"></i></li>
					<li><i class="fe fe-map"></i></li>
					<li><i class="fe fe-map-pin"></i></li>
					<li><i class="fe fe-maximize"></i></li>
					<li><i class="fe fe-maximize-2"></i></li>
					<li><i class="fe fe-menu"></i></li>
					<li><i class="fe fe-message-circle"></i></li>
					<li><i class="fe fe-message-square"></i></li>
					<li><i class="fe fe-mic"></i></li>
					<li><i class="fe fe-mic-off"></i></li>
					<li><i class="fe fe-minimize"></i></li>
					<li><i class="fe fe-minimize-2"></i></li>
					<li><i class="fe fe-minus"></i></li>
					<li><i class="fe fe-minus-circle"></i></li>
					<li><i class="fe fe-minus-square"></i></li>
					<li><i class="fe fe-monitor"></i></li>
					<li><i class="fe fe-moon"></i></li>
					<li><i class="fe fe-more-horizontal"></i></li>
					<li><i class="fe fe-more-vertical"></i></li>
					<li><i class="fe fe-move"></i></li>
					<li><i class="fe fe-music"></i></li>
					<li><i class="fe fe-navigation"></i></li>
					<li><i class="fe fe-navigation-2"></i></li>
					<li><i class="fe fe-octagon"></i></li>
					<li><i class="fe fe-package"></i></li>
					<li><i class="fe fe-paperclip"></i></li>
					<li><i class="fe fe-pause"></i></li>
					<li><i class="fe fe-pause-circle"></i></li>
					<li><i class="fe fe-percent"></i></li>
					<li><i class="fe fe-phone"></i></li>
					<li><i class="fe fe-phone-call"></i></li>
					<li><i class="fe fe-phone-forwarded"></i></li>
					<li><i class="fe fe-phone-incoming"></i></li>
					<li><i class="fe fe-phone-missed"></i></li>
					<li><i class="fe fe-phone-off"></i></li>
					<li><i class="fe fe-phone-outgoing"></i></li>
					<li><i class="fe fe-pie-chart"></i></li>
					<li><i class="fe fe-play"></i></li>
					<li><i class="fe fe-play-circle"></i></li>
					<li><i class="fe fe-plus"></i></li>
					<li><i class="fe fe-plus-circle"></i></li>
					<li><i class="fe fe-plus-square"></i></li>
					<li><i class="fe fe-pocket"></i></li>
					<li><i class="fe fe-power"></i></li>
					<li><i class="fe fe-printer"></i></li>
					<li><i class="fe fe-radio"></i></li>
					<li><i class="fe fe-refresh-ccw"></i></li>
					<li><i class="fe fe-refresh-cw"></i></li>
					<li><i class="fe fe-repeat"></i></li>
					<li><i class="fe fe-rewind"></i></li>
					<li><i class="fe fe-rotate-ccw"></i></li>
					<li><i class="fe fe-rotate-cw"></i></li>
					<li><i class="fe fe-rss"></i></li>
					<li><i class="fe fe-save"></i></li>
					<li><i class="fe fe-scissors"></i></li>
					<li><i class="fe fe-search"></i></li>
					<li><i class="fe fe-send"></i></li>
					<li><i class="fe fe-server"></i></li>
					<li><i class="fe fe-settings"></i></li>
					<li><i class="fe fe-share"></i></li>
					<li><i class="fe fe-share-2"></i></li>
					<li><i class="fe fe-shield"></i></li>
					<li><i class="fe fe-shield-off"></i></li>
					<li><i class="fe fe-shopping-bag"></i></li>
					<li><i class="fe fe-shopping-cart"></i></li>
					<li><i class="fe fe-shuffle"></i></li>
					<li><i class="fe fe-sidebar"></i></li>
					<li><i class="fe fe-skip-back"></i></li>
					<li><i class="fe fe-skip-forward"></i></li>
					<li><i class="fe fe-slack"></i></li>
					<li><i class="fe fe-slash"></i></li>
					<li><i class="fe fe-sliders"></i></li>
					<li><i class="fe fe-smartphone"></i></li>
					<li><i class="fe fe-speaker"></i></li>
					<li><i class="fe fe-square"></i></li>
					<li><i class="fe fe-star"></i></li>
					<li><i class="fe fe-stop-circle"></i></li>
					<li><i class="fe fe-sun"></i></li>
					<li><i class="fe fe-sunrise"></i></li>
					<li><i class="fe fe-sunset"></i></li>
					<li><i class="fe fe-tablet"></i></li>
					<li><i class="fe fe-tag"></i></li>
					<li><i class="fe fe-target"></i></li>
					<li><i class="fe fe-terminal"></i></li>
					<li><i class="fe fe-thermometer"></i></li>
					<li><i class="fe fe-thumbs-down"></i></li>
					<li><i class="fe fe-thumbs-up"></i></li>
					<li><i class="fe fe-toggle-left"></i></li>
					<li><i class="fe fe-toggle-right"></i></li>
					<li><i class="fe fe-trash"></i></li>
					<li><i class="fe fe-trash-2"></i></li>
					<li><i class="fe fe-trending-down"></i></li>
					<li><i class="fe fe-trending-up"></i></li>
					<li><i class="fe fe-triangle"></i></li>
					<li><i class="fe fe-truck"></i></li>
					<li><i class="fe fe-tv"></i></li>
					<li><i class="fe fe-twitter"></i></li>
					<li><i class="fe fe-type"></i></li>
					<li><i class="fe fe-umbrella"></i></li>
					<li><i class="fe fe-underline"></i></li>
					<li><i class="fe fe-unlock"></i></li>
					<li><i class="fe fe-upload"></i></li>
					<li><i class="fe fe-upload-cloud"></i></li>
					<li><i class="fe fe-user"></i></li>
					<li><i class="fe fe-user-check"></i></li>
					<li><i class="fe fe-user-minus"></i></li>
					<li><i class="fe fe-user-plus"></i></li>
					<li><i class="fe fe-user-x"></i></li>
					<li><i class="fe fe-users"></i></li>
					<li><i class="fe fe-video"></i></li>
					<li><i class="fe fe-video-off"></i></li>
					<li><i class="fe fe-voicemail"></i></li>
					<li><i class="fe fe-volume"></i></li>
					<li><i class="fe fe-volume-1"></i></li>
					<li><i class="fe fe-volume-2"></i></li>
					<li><i class="fe fe-volume-x"></i></li>
					<li><i class="fe fe-watch"></i></li>
					<li><i class="fe fe-wifi"></i></li>
					<li><i class="fe fe-wifi-off"></i></li>
					<li><i class="fe fe-wind"></i></li>
					<li><i class="fe fe-x"></i></li>
					<li><i class="fe fe-x-circle"></i></li>
					<li><i class="fe fe-x-square"></i></li>
					<li><i class="fe fe-youtube"></i></li>
					<li><i class="fe fe-zap"></i></li>
					<li><i class="fe fe-zap-off"></i></li>
					<li><i class="fe fe-zoom-in"></i></li>
					<li><i class="fe fe-zoom-out"></i></li>
				</ul>
				<script>
				;(function($) {
					'use strict'
					$(function() {
					$('.air__utils__iconPresent li').each(function() {
						$(this).tooltip({
						title: $(this)
							.find('i')
							.attr('class'),
						})
					})
					})
				})(jQuery)
				</script>
			</div>
		</div>
	<?php } ?>

	<?php if($this->input->get('theval')=='font-awesome'){ ?>
		<div class="row">
			<div class="col-lg-12">
				<h5 class="text-black"><strong>The iconic font</strong></h5>
				<p class="text-muted">
				The complete set of 634 icons in Font Awesome 4.6.3
				<br />
				License: MIT License. You can use it for commercial projects, open source projects, or
				really just about whatever you want
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<h3 class="text-block mt-5 mb-4 text-center"><strong>New Icons in 4.6</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-american-sign-language-interpreting"></i></li>
					<li><i class="fa fa-asl-interpreting"></i></li>
					<li><i class="fa fa-assistive-listening-systems"></i></li>
					<li><i class="fa fa-blind"></i></li>
					<li><i class="fa fa-braille"></i></li>
					<li><i class="fa fa-deaf"></i></li>
					<li><i class="fa fa-deafness"></i></li>
					<li><i class="fa fa-envira"></i></li>
					<li><i class="fa fa-fa"></i></li>
					<li><i class="fa fa-first-order"></i></li>
					<li><i class="fa fa-font-awesome"></i></li>
					<li><i class="fa fa-gitlab"></i></li>
					<li><i class="fa fa-glide"></i></li>
					<li><i class="fa fa-glide-g"></i></li>
					<li><i class="fa fa-google-plus-circle"></i></li>
					<li><i class="fa fa-google-plus-official"></i></li>
					<li><i class="fa fa-hard-of-hearing"></i></li>
					<li><i class="fa fa-instagram"></i></li>
					<li><i class="fa fa-low-vision"></i></li>
					<li><i class="fa fa-pied-piper"></i></li>
					<li><i class="fa fa-question-circle-o"></i></li>
					<li><i class="fa fa-sign-language"></i></li>
					<li><i class="fa fa-signing"></i></li>
					<li><i class="fa fa-snapchat"></i></li>
					<li><i class="fa fa-snapchat-ghost"></i></li>
					<li><i class="fa fa-snapchat-square"></i></li>
					<li><i class="fa fa-themeisle"></i></li>
					<li><i class="fa fa-universal-access"></i></li>
					<li><i class="fa fa-viadeo"></i></li>
					<li><i class="fa fa-viadeo-square"></i></li>
					<li><i class="fa fa-volume-control-phone"></i></li>
					<li><i class="fa fa-wheelchair-alt"></i></li>
					<li><i class="fa fa-wpbeginner"></i></li>
					<li><i class="fa fa-wpforms"></i></li>
					<li><i class="fa fa-yoast"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Web Application Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-adjust"></i></li>
					<li><i class="fa fa-american-sign-language-interpreting"></i></li>
					<li><i class="fa fa-anchor"></i></li>
					<li><i class="fa fa-archive"></i></li>
					<li><i class="fa fa-area-chart"></i></li>
					<li><i class="fa fa-arrows"></i></li>
					<li><i class="fa fa-arrows-h"></i></li>
					<li><i class="fa fa-arrows-v"></i></li>
					<li><i class="fa fa-asl-interpreting"></i></li>
					<li><i class="fa fa-assistive-listening-systems"></i></li>
					<li><i class="fa fa-asterisk"></i></li>
					<li><i class="fa fa-at"></i></li>
					<li><i class="fa fa-audio-description"></i></li>
					<li><i class="fa fa-automobile"></i></li>
					<li><i class="fa fa-balance-scale"></i></li>
					<li><i class="fa fa-ban"></i></li>
					<li><i class="fa fa-bank"></i></li>
					<li><i class="fa fa-bar-chart"></i></li>
					<li><i class="fa fa-bar-chart-o"></i></li>
					<li><i class="fa fa-barcode"></i></li>
					<li><i class="fa fa-bars"></i></li>
					<li><i class="fa fa-battery-0"></i></li>
					<li><i class="fa fa-battery-1"></i></li>
					<li><i class="fa fa-battery-2"></i></li>
					<li><i class="fa fa-battery-3"></i></li>
					<li><i class="fa fa-battery-4"></i></li>
					<li><i class="fa fa-battery-empty"></i></li>
					<li><i class="fa fa-battery-full"></i></li>
					<li><i class="fa fa-battery-half"></i></li>
					<li><i class="fa fa-battery-quarter"></i></li>
					<li><i class="fa fa-battery-three-quarters"></i></li>
					<li><i class="fa fa-bed"></i></li>
					<li><i class="fa fa-beer"></i></li>
					<li><i class="fa fa-bell"></i></li>
					<li><i class="fa fa-bell-o"></i></li>
					<li><i class="fa fa-bell-slash"></i></li>
					<li><i class="fa fa-bell-slash-o"></i></li>
					<li><i class="fa fa-bicycle"></i></li>
					<li><i class="fa fa-binoculars"></i></li>
					<li><i class="fa fa-birthday-cake"></i></li>
					<li><i class="fa fa-blind"></i></li>
					<li><i class="fa fa-bluetooth"></i></li>
					<li><i class="fa fa-bluetooth-b"></i></li>
					<li><i class="fa fa-bolt"></i></li>
					<li><i class="fa fa-bomb"></i></li>
					<li><i class="fa fa-book"></i></li>
					<li><i class="fa fa-bookmark"></i></li>
					<li><i class="fa fa-bookmark-o"></i></li>
					<li><i class="fa fa-braille"></i></li>
					<li><i class="fa fa-briefcase"></i></li>
					<li><i class="fa fa-bug"></i></li>
					<li><i class="fa fa-building"></i></li>
					<li><i class="fa fa-building-o"></i></li>
					<li><i class="fa fa-bullhorn"></i></li>
					<li><i class="fa fa-bullseye"></i></li>
					<li><i class="fa fa-bus"></i></li>
					<li><i class="fa fa-cab"></i></li>
					<li><i class="fa fa-calculator"></i></li>
					<li><i class="fa fa-calendar"></i></li>
					<li><i class="fa fa-calendar-check-o"></i></li>
					<li><i class="fa fa-calendar-minus-o"></i></li>
					<li><i class="fa fa-calendar-o"></i></li>
					<li><i class="fa fa-calendar-plus-o"></i></li>
					<li><i class="fa fa-calendar-times-o"></i></li>
					<li><i class="fa fa-camera"></i></li>
					<li><i class="fa fa-camera-retro"></i></li>
					<li><i class="fa fa-car"></i></li>
					<li><i class="fa fa-caret-square-o-down"></i></li>
					<li><i class="fa fa-caret-square-o-left"></i></li>
					<li><i class="fa fa-caret-square-o-right"></i></li>
					<li><i class="fa fa-caret-square-o-up"></i></li>
					<li><i class="fa fa-cart-arrow-down"></i></li>
					<li><i class="fa fa-cart-plus"></i></li>
					<li><i class="fa fa-cc"></i></li>
					<li><i class="fa fa-certificate"></i></li>
					<li><i class="fa fa-check"></i></li>
					<li><i class="fa fa-check-circle"></i></li>
					<li><i class="fa fa-check-circle-o"></i></li>
					<li><i class="fa fa-check-square"></i></li>
					<li><i class="fa fa-check-square-o"></i></li>
					<li><i class="fa fa-child"></i></li>
					<li><i class="fa fa-circle"></i></li>
					<li><i class="fa fa-circle-o"></i></li>
					<li><i class="fa fa-circle-o-notch"></i></li>
					<li><i class="fa fa-circle-thin"></i></li>
					<li><i class="fa fa-clock-o"></i></li>
					<li><i class="fa fa-clone"></i></li>
					<li><i class="fa fa-close"></i></li>
					<li><i class="fa fa-cloud"></i></li>
					<li><i class="fa fa-cloud-download"></i></li>
					<li><i class="fa fa-cloud-upload"></i></li>
					<li><i class="fa fa-code"></i></li>
					<li><i class="fa fa-code-fork"></i></li>
					<li><i class="fa fa-coffee"></i></li>
					<li><i class="fa fa-cog"></i></li>
					<li><i class="fa fa-cogs"></i></li>
					<li><i class="fa fa-comment"></i></li>
					<li><i class="fa fa-comment-o"></i></li>
					<li><i class="fa fa-commenting"></i></li>
					<li><i class="fa fa-commenting-o"></i></li>
					<li><i class="fa fa-comments"></i></li>
					<li><i class="fa fa-comments-o"></i></li>
					<li><i class="fa fa-compass"></i></li>
					<li><i class="fa fa-copyright"></i></li>
					<li><i class="fa fa-creative-commons"></i></li>
					<li><i class="fa fa-credit-card"></i></li>
					<li><i class="fa fa-credit-card-alt"></i></li>
					<li><i class="fa fa-crop"></i></li>
					<li><i class="fa fa-crosshairs"></i></li>
					<li><i class="fa fa-cube"></i></li>
					<li><i class="fa fa-cubes"></i></li>
					<li><i class="fa fa-cutlery"></i></li>
					<li><i class="fa fa-dashboard"></i></li>
					<li><i class="fa fa-database"></i></li>
					<li><i class="fa fa-deaf"></i></li>
					<li><i class="fa fa-deafness"></i></li>
					<li><i class="fa fa-desktop"></i></li>
					<li><i class="fa fa-diamond"></i></li>
					<li><i class="fa fa-dot-circle-o"></i></li>
					<li><i class="fa fa-download"></i></li>
					<li><i class="fa fa-edit"></i></li>
					<li><i class="fa fa-ellipsis-h"></i></li>
					<li><i class="fa fa-ellipsis-v"></i></li>
					<li><i class="fa fa-envelope"></i></li>
					<li><i class="fa fa-envelope-o"></i></li>
					<li><i class="fa fa-envelope-square"></i></li>
					<li><i class="fa fa-eraser"></i></li>
					<li><i class="fa fa-exchange"></i></li>
					<li><i class="fa fa-exclamation"></i></li>
					<li><i class="fa fa-exclamation-circle"></i></li>
					<li><i class="fa fa-exclamation-triangle"></i></li>
					<li><i class="fa fa-external-link"></i></li>
					<li><i class="fa fa-external-link-square"></i></li>
					<li><i class="fa fa-eye"></i></li>
					<li><i class="fa fa-eye-slash"></i></li>
					<li><i class="fa fa-eyedropper"></i></li>
					<li><i class="fa fa-fax"></i></li>
					<li><i class="fa fa-feed"></i></li>
					<li><i class="fa fa-female"></i></li>
					<li><i class="fa fa-fighter-jet"></i></li>
					<li><i class="fa fa-file-archive-o"></i></li>
					<li><i class="fa fa-file-audio-o"></i></li>
					<li><i class="fa fa-file-code-o"></i></li>
					<li><i class="fa fa-file-excel-o"></i></li>
					<li><i class="fa fa-file-image-o"></i></li>
					<li><i class="fa fa-file-movie-o"></i></li>
					<li><i class="fa fa-file-pdf-o"></i></li>
					<li><i class="fa fa-file-photo-o"></i></li>
					<li><i class="fa fa-file-picture-o"></i></li>
					<li><i class="fa fa-file-powerpoint-o"></i></li>
					<li><i class="fa fa-file-sound-o"></i></li>
					<li><i class="fa fa-file-video-o"></i></li>
					<li><i class="fa fa-file-word-o"></i></li>
					<li><i class="fa fa-file-zip-o"></i></li>
					<li><i class="fa fa-film"></i></li>
					<li><i class="fa fa-filter"></i></li>
					<li><i class="fa fa-fire"></i></li>
					<li><i class="fa fa-fire-extinguisher"></i></li>
					<li><i class="fa fa-flag"></i></li>
					<li><i class="fa fa-flag-checkered"></i></li>
					<li><i class="fa fa-flag-o"></i></li>
					<li><i class="fa fa-flash"></i></li>
					<li><i class="fa fa-flask"></i></li>
					<li><i class="fa fa-folder"></i></li>
					<li><i class="fa fa-folder-o"></i></li>
					<li><i class="fa fa-folder-open"></i></li>
					<li><i class="fa fa-folder-open-o"></i></li>
					<li><i class="fa fa-frown-o"></i></li>
					<li><i class="fa fa-futbol-o"></i></li>
					<li><i class="fa fa-gamepad"></i></li>
					<li><i class="fa fa-gavel"></i></li>
					<li><i class="fa fa-gear"></i></li>
					<li><i class="fa fa-gears"></i></li>
					<li><i class="fa fa-gift"></i></li>
					<li><i class="fa fa-glass"></i></li>
					<li><i class="fa fa-globe"></i></li>
					<li><i class="fa fa-graduation-cap"></i></li>
					<li><i class="fa fa-group"></i></li>
					<li><i class="fa fa-hand-grab-o"></i></li>
					<li><i class="fa fa-hand-lizard-o"></i></li>
					<li><i class="fa fa-hand-paper-o"></i></li>
					<li><i class="fa fa-hand-peace-o"></i></li>
					<li><i class="fa fa-hand-pointer-o"></i></li>
					<li><i class="fa fa-hand-rock-o"></i></li>
					<li><i class="fa fa-hand-scissors-o"></i></li>
					<li><i class="fa fa-hand-spock-o"></i></li>
					<li><i class="fa fa-hand-stop-o"></i></li>
					<li><i class="fa fa-hard-of-hearing"></i></li>
					<li><i class="fa fa-hashtag"></i></li>
					<li><i class="fa fa-hdd-o"></i></li>
					<li><i class="fa fa-headphones"></i></li>
					<li><i class="fa fa-heart"></i></li>
					<li><i class="fa fa-heart-o"></i></li>
					<li><i class="fa fa-heartbeat"></i></li>
					<li><i class="fa fa-history"></i></li>
					<li><i class="fa fa-home"></i></li>
					<li><i class="fa fa-hotel"></i></li>
					<li><i class="fa fa-hourglass"></i></li>
					<li><i class="fa fa-hourglass-1"></i></li>
					<li><i class="fa fa-hourglass-2"></i></li>
					<li><i class="fa fa-hourglass-3"></i></li>
					<li><i class="fa fa-hourglass-end"></i></li>
					<li><i class="fa fa-hourglass-half"></i></li>
					<li><i class="fa fa-hourglass-o"></i></li>
					<li><i class="fa fa-hourglass-start"></i></li>
					<li><i class="fa fa-i-cursor"></i></li>
					<li><i class="fa fa-image"></i></li>
					<li><i class="fa fa-inbox"></i></li>
					<li><i class="fa fa-industry"></i></li>
					<li><i class="fa fa-info"></i></li>
					<li><i class="fa fa-info-circle"></i></li>
					<li><i class="fa fa-institution"></i></li>
					<li><i class="fa fa-key"></i></li>
					<li><i class="fa fa-keyboard-o"></i></li>
					<li><i class="fa fa-language"></i></li>
					<li><i class="fa fa-laptop"></i></li>
					<li><i class="fa fa-leaf"></i></li>
					<li><i class="fa fa-legal"></i></li>
					<li><i class="fa fa-lemon-o"></i></li>
					<li><i class="fa fa-level-down"></i></li>
					<li><i class="fa fa-level-up"></i></li>
					<li><i class="fa fa-life-bouy"></i></li>
					<li><i class="fa fa-life-buoy"></i></li>
					<li><i class="fa fa-life-ring"></i></li>
					<li><i class="fa fa-life-saver"></i></li>
					<li><i class="fa fa-lightbulb-o"></i></li>
					<li><i class="fa fa-line-chart"></i></li>
					<li><i class="fa fa-location-arrow"></i></li>
					<li><i class="fa fa-lock"></i></li>
					<li><i class="fa fa-low-vision"></i></li>
					<li><i class="fa fa-magic"></i></li>
					<li><i class="fa fa-magnet"></i></li>
					<li><i class="fa fa-mail-forward"></i></li>
					<li><i class="fa fa-mail-reply"></i></li>
					<li><i class="fa fa-mail-reply-all"></i></li>
					<li><i class="fa fa-male"></i></li>
					<li><i class="fa fa-map"></i></li>
					<li><i class="fa fa-map-marker"></i></li>
					<li><i class="fa fa-map-o"></i></li>
					<li><i class="fa fa-map-pin"></i></li>
					<li><i class="fa fa-map-signs"></i></li>
					<li><i class="fa fa-meh-o"></i></li>
					<li><i class="fa fa-microphone"></i></li>
					<li><i class="fa fa-microphone-slash"></i></li>
					<li><i class="fa fa-minus"></i></li>
					<li><i class="fa fa-minus-circle"></i></li>
					<li><i class="fa fa-minus-square"></i></li>
					<li><i class="fa fa-minus-square-o"></i></li>
					<li><i class="fa fa-mobile"></i></li>
					<li><i class="fa fa-mobile-phone"></i></li>
					<li><i class="fa fa-money"></i></li>
					<li><i class="fa fa-moon-o"></i></li>
					<li><i class="fa fa-mortar-board"></i></li>
					<li><i class="fa fa-motorcycle"></i></li>
					<li><i class="fa fa-mouse-pointer"></i></li>
					<li><i class="fa fa-music"></i></li>
					<li><i class="fa fa-navicon"></i></li>
					<li><i class="fa fa-newspaper-o"></i></li>
					<li><i class="fa fa-object-group"></i></li>
					<li><i class="fa fa-object-ungroup"></i></li>
					<li><i class="fa fa-paint-brush"></i></li>
					<li><i class="fa fa-paper-plane"></i></li>
					<li><i class="fa fa-paper-plane-o"></i></li>
					<li><i class="fa fa-paw"></i></li>
					<li><i class="fa fa-pencil"></i></li>
					<li><i class="fa fa-pencil-square"></i></li>
					<li><i class="fa fa-pencil-square-o"></i></li>
					<li><i class="fa fa-percent"></i></li>
					<li><i class="fa fa-phone"></i></li>
					<li><i class="fa fa-phone-square"></i></li>
					<li><i class="fa fa-photo"></i></li>
					<li><i class="fa fa-picture-o"></i></li>
					<li><i class="fa fa-pie-chart"></i></li>
					<li><i class="fa fa-plane"></i></li>
					<li><i class="fa fa-plug"></i></li>
					<li><i class="fa fa-plus"></i></li>
					<li><i class="fa fa-plus-circle"></i></li>
					<li><i class="fa fa-plus-square"></i></li>
					<li><i class="fa fa-plus-square-o"></i></li>
					<li><i class="fa fa-power-off"></i></li>
					<li><i class="fa fa-print"></i></li>
					<li><i class="fa fa-puzzle-piece"></i></li>
					<li><i class="fa fa-qrcode"></i></li>
					<li><i class="fa fa-question"></i></li>
					<li><i class="fa fa-question-circle"></i></li>
					<li><i class="fa fa-question-circle-o"></i></li>
					<li><i class="fa fa-quote-left"></i></li>
					<li><i class="fa fa-quote-right"></i></li>
					<li><i class="fa fa-random"></i></li>
					<li><i class="fa fa-recycle"></i></li>
					<li><i class="fa fa-refresh"></i></li>
					<li><i class="fa fa-registered"></i></li>
					<li><i class="fa fa-remove"></i></li>
					<li><i class="fa fa-reorder"></i></li>
					<li><i class="fa fa-reply"></i></li>
					<li><i class="fa fa-reply-all"></i></li>
					<li><i class="fa fa-retweet"></i></li>
					<li><i class="fa fa-road"></i></li>
					<li><i class="fa fa-rocket"></i></li>
					<li><i class="fa fa-rss"></i></li>
					<li><i class="fa fa-rss-square"></i></li>
					<li><i class="fa fa-search"></i></li>
					<li><i class="fa fa-search-minus"></i></li>
					<li><i class="fa fa-search-plus"></i></li>
					<li><i class="fa fa-send"></i></li>
					<li><i class="fa fa-send-o"></i></li>
					<li><i class="fa fa-server"></i></li>
					<li><i class="fa fa-share"></i></li>
					<li><i class="fa fa-share-alt"></i></li>
					<li><i class="fa fa-share-alt-square"></i></li>
					<li><i class="fa fa-share-square"></i></li>
					<li><i class="fa fa-share-square-o"></i></li>
					<li><i class="fa fa-shield"></i></li>
					<li><i class="fa fa-ship"></i></li>
					<li><i class="fa fa-shopping-bag"></i></li>
					<li><i class="fa fa-shopping-basket"></i></li>
					<li><i class="fa fa-shopping-cart"></i></li>
					<li><i class="fa fa-sign-in"></i></li>
					<li><i class="fa fa-sign-language"></i></li>
					<li><i class="fa fa-sign-out"></i></li>
					<li><i class="fa fa-signal"></i></li>
					<li><i class="fa fa-signing"></i></li>
					<li><i class="fa fa-sitemap"></i></li>
					<li><i class="fa fa-sliders"></i></li>
					<li><i class="fa fa-smile-o"></i></li>
					<li><i class="fa fa-soccer-ball-o"></i></li>
					<li><i class="fa fa-sort"></i></li>
					<li><i class="fa fa-sort-alpha-asc"></i></li>
					<li><i class="fa fa-sort-alpha-desc"></i></li>
					<li><i class="fa fa-sort-amount-asc"></i></li>
					<li><i class="fa fa-sort-amount-desc"></i></li>
					<li><i class="fa fa-sort-asc"></i></li>
					<li><i class="fa fa-sort-desc"></i></li>
					<li><i class="fa fa-sort-down"></i></li>
					<li><i class="fa fa-sort-numeric-asc"></i></li>
					<li><i class="fa fa-sort-numeric-desc"></i></li>
					<li><i class="fa fa-sort-up"></i></li>
					<li><i class="fa fa-space-shuttle"></i></li>
					<li><i class="fa fa-spinner"></i></li>
					<li><i class="fa fa-spoon"></i></li>
					<li><i class="fa fa-square"></i></li>
					<li><i class="fa fa-square-o"></i></li>
					<li><i class="fa fa-star"></i></li>
					<li><i class="fa fa-star-half"></i></li>
					<li><i class="fa fa-star-half-empty"></i></li>
					<li><i class="fa fa-star-half-full"></i></li>
					<li><i class="fa fa-star-half-o"></i></li>
					<li><i class="fa fa-star-o"></i></li>
					<li><i class="fa fa-sticky-note"></i></li>
					<li><i class="fa fa-sticky-note-o"></i></li>
					<li><i class="fa fa-street-view"></i></li>
					<li><i class="fa fa-suitcase"></i></li>
					<li><i class="fa fa-sun-o"></i></li>
					<li><i class="fa fa-support"></i></li>
					<li><i class="fa fa-tablet"></i></li>
					<li><i class="fa fa-tachometer"></i></li>
					<li><i class="fa fa-tag"></i></li>
					<li><i class="fa fa-tags"></i></li>
					<li><i class="fa fa-tasks"></i></li>
					<li><i class="fa fa-taxi"></i></li>
					<li><i class="fa fa-television"></i></li>
					<li><i class="fa fa-terminal"></i></li>
					<li><i class="fa fa-thumb-tack"></i></li>
					<li><i class="fa fa-thumbs-down"></i></li>
					<li><i class="fa fa-thumbs-o-down"></i></li>
					<li><i class="fa fa-thumbs-o-up"></i></li>
					<li><i class="fa fa-thumbs-up"></i></li>
					<li><i class="fa fa-ticket"></i></li>
					<li><i class="fa fa-times"></i></li>
					<li><i class="fa fa-times-circle"></i></li>
					<li><i class="fa fa-times-circle-o"></i></li>
					<li><i class="fa fa-tint"></i></li>
					<li><i class="fa fa-toggle-down"></i></li>
					<li><i class="fa fa-toggle-left"></i></li>
					<li><i class="fa fa-toggle-off"></i></li>
					<li><i class="fa fa-toggle-on"></i></li>
					<li><i class="fa fa-toggle-right"></i></li>
					<li><i class="fa fa-toggle-up"></i></li>
					<li><i class="fa fa-trademark"></i></li>
					<li><i class="fa fa-trash"></i></li>
					<li><i class="fa fa-trash-o"></i></li>
					<li><i class="fa fa-tree"></i></li>
					<li><i class="fa fa-trophy"></i></li>
					<li><i class="fa fa-truck"></i></li>
					<li><i class="fa fa-tty"></i></li>
					<li><i class="fa fa-tv"></i></li>
					<li><i class="fa fa-umbrella"></i></li>
					<li><i class="fa fa-universal-access"></i></li>
					<li><i class="fa fa-university"></i></li>
					<li><i class="fa fa-unlock"></i></li>
					<li><i class="fa fa-unlock-alt"></i></li>
					<li><i class="fa fa-unsorted"></i></li>
					<li><i class="fa fa-upload"></i></li>
					<li><i class="fa fa-user"></i></li>
					<li><i class="fa fa-user-plus"></i></li>
					<li><i class="fa fa-user-secret"></i></li>
					<li><i class="fa fa-user-times"></i></li>
					<li><i class="fa fa-users"></i></li>
					<li><i class="fa fa-video-camera"></i></li>
					<li><i class="fa fa-volume-control-phone"></i></li>
					<li><i class="fa fa-volume-down"></i></li>
					<li><i class="fa fa-volume-off"></i></li>
					<li><i class="fa fa-volume-up"></i></li>
					<li><i class="fa fa-warning"></i></li>
					<li><i class="fa fa-wheelchair"></i></li>
					<li><i class="fa fa-wheelchair-alt"></i></li>
					<li><i class="fa fa-wifi"></i></li>
					<li><i class="fa fa-wrench"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Accessibility Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-american-sign-language-interpreting"></i></li>
					<li><i class="fa fa-asl-interpreting"></i></li>
					<li><i class="fa fa-assistive-listening-systems"></i></li>
					<li><i class="fa fa-audio-description"></i></li>
					<li><i class="fa fa-blind"></i></li>
					<li><i class="fa fa-braille"></i></li>
					<li><i class="fa fa-cc"></i></li>
					<li><i class="fa fa-deaf"></i></li>
					<li><i class="fa fa-deafness"></i></li>
					<li><i class="fa fa-hard-of-hearing"></i></li>
					<li><i class="fa fa-low-vision"></i></li>
					<li><i class="fa fa-question-circle-o"></i></li>
					<li><i class="fa fa-sign-language"></i></li>
					<li><i class="fa fa-signing"></i></li>
					<li><i class="fa fa-tty"></i></li>
					<li><i class="fa fa-universal-access"></i></li>
					<li><i class="fa fa-volume-control-phone"></i></li>
					<li><i class="fa fa-wheelchair"></i></li>
					<li><i class="fa fa-wheelchair-alt"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Hand Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-hand-grab-o"></i></li>
					<li><i class="fa fa-hand-lizard-o"></i></li>
					<li><i class="fa fa-hand-o-down"></i></li>
					<li><i class="fa fa-hand-o-left"></i></li>
					<li><i class="fa fa-hand-o-right"></i></li>
					<li><i class="fa fa-hand-o-up"></i></li>
					<li><i class="fa fa-hand-paper-o"></i></li>
					<li><i class="fa fa-hand-peace-o"></i></li>
					<li><i class="fa fa-hand-pointer-o"></i></li>
					<li><i class="fa fa-hand-rock-o"></i></li>
					<li><i class="fa fa-hand-scissors-o"></i></li>
					<li><i class="fa fa-hand-spock-o"></i></li>
					<li><i class="fa fa-hand-stop-o"></i></li>
					<li><i class="fa fa-thumbs-down"></i></li>
					<li><i class="fa fa-thumbs-o-down"></i></li>
					<li><i class="fa fa-thumbs-o-up"></i></li>
					<li><i class="fa fa-thumbs-up"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Transportation Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-ambulance"></i></li>
					<li><i class="fa fa-automobile"></i></li>
					<li><i class="fa fa-bicycle"></i></li>
					<li><i class="fa fa-bus"></i></li>
					<li><i class="fa fa-cab"></i></li>
					<li><i class="fa fa-car"></i></li>
					<li><i class="fa fa-fighter-jet"></i></li>
					<li><i class="fa fa-motorcycle"></i></li>
					<li><i class="fa fa-plane"></i></li>
					<li><i class="fa fa-rocket"></i></li>
					<li><i class="fa fa-ship"></i></li>
					<li><i class="fa fa-space-shuttle"></i></li>
					<li><i class="fa fa-subway"></i></li>
					<li><i class="fa fa-taxi"></i></li>
					<li><i class="fa fa-train"></i></li>
					<li><i class="fa fa-truck"></i></li>
					<li><i class="fa fa-wheelchair"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Gender Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-genderless"></i></li>
					<li><i class="fa fa-intersex"></i></li>
					<li><i class="fa fa-mars"></i></li>
					<li><i class="fa fa-mars-double"></i></li>
					<li><i class="fa fa-mars-stroke"></i></li>
					<li><i class="fa fa-mars-stroke-h"></i></li>
					<li><i class="fa fa-mars-stroke-v"></i></li>
					<li><i class="fa fa-mercury"></i></li>
					<li><i class="fa fa-neuter"></i></li>
					<li><i class="fa fa-transgender"></i></li>
					<li><i class="fa fa-transgender-alt"></i></li>
					<li><i class="fa fa-venus"></i></li>
					<li><i class="fa fa-venus-double"></i></li>
					<li><i class="fa fa-venus-mars"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>File Type Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-file"></i></li>
					<li><i class="fa fa-file-archive-o"></i></li>
					<li><i class="fa fa-file-audio-o"></i></li>
					<li><i class="fa fa-file-code-o"></i></li>
					<li><i class="fa fa-file-excel-o"></i></li>
					<li><i class="fa fa-file-image-o"></i></li>
					<li><i class="fa fa-file-movie-o"></i></li>
					<li><i class="fa fa-file-o"></i></li>
					<li><i class="fa fa-file-pdf-o"></i></li>
					<li><i class="fa fa-file-photo-o"></i></li>
					<li><i class="fa fa-file-picture-o"></i></li>
					<li><i class="fa fa-file-powerpoint-o"></i></li>
					<li><i class="fa fa-file-sound-o"></i></li>
					<li><i class="fa fa-file-text"></i></li>
					<li><i class="fa fa-file-text-o"></i></li>
					<li><i class="fa fa-file-video-o"></i></li>
					<li><i class="fa fa-file-word-o"></i></li>
					<li><i class="fa fa-file-zip-o"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Spinner Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-circle-o-notch"></i></li>
					<li><i class="fa fa-cog"></i></li>
					<li><i class="fa fa-gear"></i></li>
					<li><i class="fa fa-refresh"></i></li>
					<li><i class="fa fa-spinner"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Form Control Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-check-square"></i></li>
					<li><i class="fa fa-check-square-o"></i></li>
					<li><i class="fa fa-circle"></i></li>
					<li><i class="fa fa-circle-o"></i></li>
					<li><i class="fa fa-dot-circle-o"></i></li>
					<li><i class="fa fa-minus-square"></i></li>
					<li><i class="fa fa-minus-square-o"></i></li>
					<li><i class="fa fa-plus-square"></i></li>
					<li><i class="fa fa-plus-square-o"></i></li>
					<li><i class="fa fa-square"></i></li>
					<li><i class="fa fa-square-o"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Payment Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-cc-amex"></i></li>
					<li><i class="fa fa-cc-diners-club"></i></li>
					<li><i class="fa fa-cc-discover"></i></li>
					<li><i class="fa fa-cc-jcb"></i></li>
					<li><i class="fa fa-cc-mastercard"></i></li>
					<li><i class="fa fa-cc-paypal"></i></li>
					<li><i class="fa fa-cc-stripe"></i></li>
					<li><i class="fa fa-cc-visa"></i></li>
					<li><i class="fa fa-credit-card"></i></li>
					<li><i class="fa fa-credit-card-alt"></i></li>
					<li><i class="fa fa-google-wallet"></i></li>
					<li><i class="fa fa-paypal"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Chart Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-area-chart"></i></li>
					<li><i class="fa fa-bar-chart"></i></li>
					<li><i class="fa fa-bar-chart-o"></i></li>
					<li><i class="fa fa-line-chart"></i></li>
					<li><i class="fa fa-pie-chart"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Currency Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-bitcoin"></i></li>
					<li><i class="fa fa-btc"></i></li>
					<li><i class="fa fa-cny"></i></li>
					<li><i class="fa fa-dollar"></i></li>
					<li><i class="fa fa-eur"></i></li>
					<li><i class="fa fa-euro"></i></li>
					<li><i class="fa fa-gbp"></i></li>
					<li><i class="fa fa-gg"></i></li>
					<li><i class="fa fa-gg-circle"></i></li>
					<li><i class="fa fa-ils"></i></li>
					<li><i class="fa fa-inr"></i></li>
					<li><i class="fa fa-jpy"></i></li>
					<li><i class="fa fa-krw"></i></li>
					<li><i class="fa fa-money"></i></li>
					<li><i class="fa fa-rmb"></i></li>
					<li><i class="fa fa-rouble"></i></li>
					<li><i class="fa fa-rub"></i></li>
					<li><i class="fa fa-ruble"></i></li>
					<li><i class="fa fa-rupee"></i></li>
					<li><i class="fa fa-shekel"></i></li>
					<li><i class="fa fa-sheqel"></i></li>
					<li><i class="fa fa-try"></i></li>
					<li><i class="fa fa-turkish-lira"></i></li>
					<li><i class="fa fa-usd"></i></li>
					<li><i class="fa fa-won"></i></li>
					<li><i class="fa fa-yen"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Text Editor Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-align-center"></i></li>
					<li><i class="fa fa-align-justify"></i></li>
					<li><i class="fa fa-align-left"></i></li>
					<li><i class="fa fa-align-right"></i></li>
					<li><i class="fa fa-bold"></i></li>
					<li><i class="fa fa-chain"></i></li>
					<li><i class="fa fa-chain-broken"></i></li>
					<li><i class="fa fa-clipboard"></i></li>
					<li><i class="fa fa-columns"></i></li>
					<li><i class="fa fa-copy"></i></li>
					<li><i class="fa fa-cut"></i></li>
					<li><i class="fa fa-dedent"></i></li>
					<li><i class="fa fa-eraser"></i></li>
					<li><i class="fa fa-file"></i></li>
					<li><i class="fa fa-file-o"></i></li>
					<li><i class="fa fa-file-text"></i></li>
					<li><i class="fa fa-file-text-o"></i></li>
					<li><i class="fa fa-files-o"></i></li>
					<li><i class="fa fa-floppy-o"></i></li>
					<li><i class="fa fa-font"></i></li>
					<li><i class="fa fa-header"></i></li>
					<li><i class="fa fa-indent"></i></li>
					<li><i class="fa fa-italic"></i></li>
					<li><i class="fa fa-link"></i></li>
					<li><i class="fa fa-list"></i></li>
					<li><i class="fa fa-list-alt"></i></li>
					<li><i class="fa fa-list-ol"></i></li>
					<li><i class="fa fa-list-ul"></i></li>
					<li><i class="fa fa-outdent"></i></li>
					<li><i class="fa fa-paperclip"></i></li>
					<li><i class="fa fa-paragraph"></i></li>
					<li><i class="fa fa-paste"></i></li>
					<li><i class="fa fa-repeat"></i></li>
					<li><i class="fa fa-rotate-left"></i></li>
					<li><i class="fa fa-rotate-right"></i></li>
					<li><i class="fa fa-save"></i></li>
					<li><i class="fa fa-scissors"></i></li>
					<li><i class="fa fa-strikethrough"></i></li>
					<li><i class="fa fa-subscript"></i></li>
					<li><i class="fa fa-superscript"></i></li>
					<li><i class="fa fa-table"></i></li>
					<li><i class="fa fa-text-height"></i></li>
					<li><i class="fa fa-text-width"></i></li>
					<li><i class="fa fa-th"></i></li>
					<li><i class="fa fa-th-large"></i></li>
					<li><i class="fa fa-th-list"></i></li>
					<li><i class="fa fa-underline"></i></li>
					<li><i class="fa fa-undo"></i></li>
					<li><i class="fa fa-unlink"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Directional Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-angle-double-down"></i></li>
					<li><i class="fa fa-angle-double-left"></i></li>
					<li><i class="fa fa-angle-double-right"></i></li>
					<li><i class="fa fa-angle-double-up"></i></li>
					<li><i class="fa fa-angle-down"></i></li>
					<li><i class="fa fa-angle-left"></i></li>
					<li><i class="fa fa-angle-right"></i></li>
					<li><i class="fa fa-angle-up"></i></li>
					<li><i class="fa fa-arrow-circle-down"></i></li>
					<li><i class="fa fa-arrow-circle-left"></i></li>
					<li><i class="fa fa-arrow-circle-o-down"></i></li>
					<li><i class="fa fa-arrow-circle-o-left"></i></li>
					<li><i class="fa fa-arrow-circle-o-right"></i></li>
					<li><i class="fa fa-arrow-circle-o-up"></i></li>
					<li><i class="fa fa-arrow-circle-right"></i></li>
					<li><i class="fa fa-arrow-circle-up"></i></li>
					<li><i class="fa fa-arrow-down"></i></li>
					<li><i class="fa fa-arrow-left"></i></li>
					<li><i class="fa fa-arrow-right"></i></li>
					<li><i class="fa fa-arrow-up"></i></li>
					<li><i class="fa fa-arrows"></i></li>
					<li><i class="fa fa-arrows-alt"></i></li>
					<li><i class="fa fa-arrows-h"></i></li>
					<li><i class="fa fa-arrows-v"></i></li>
					<li><i class="fa fa-caret-down"></i></li>
					<li><i class="fa fa-caret-left"></i></li>
					<li><i class="fa fa-caret-right"></i></li>
					<li><i class="fa fa-caret-square-o-down"></i></li>
					<li><i class="fa fa-caret-square-o-left"></i></li>
					<li><i class="fa fa-caret-square-o-right"></i></li>
					<li><i class="fa fa-caret-square-o-up"></i></li>
					<li><i class="fa fa-caret-up"></i></li>
					<li><i class="fa fa-chevron-circle-down"></i></li>
					<li><i class="fa fa-chevron-circle-left"></i></li>
					<li><i class="fa fa-chevron-circle-right"></i></li>
					<li><i class="fa fa-chevron-circle-up"></i></li>
					<li><i class="fa fa-chevron-down"></i></li>
					<li><i class="fa fa-chevron-left"></i></li>
					<li><i class="fa fa-chevron-right"></i></li>
					<li><i class="fa fa-chevron-up"></i></li>
					<li><i class="fa fa-exchange"></i></li>
					<li><i class="fa fa-hand-o-down"></i></li>
					<li><i class="fa fa-hand-o-left"></i></li>
					<li><i class="fa fa-hand-o-right"></i></li>
					<li><i class="fa fa-hand-o-up"></i></li>
					<li><i class="fa fa-long-arrow-down"></i></li>
					<li><i class="fa fa-long-arrow-left"></i></li>
					<li><i class="fa fa-long-arrow-right"></i></li>
					<li><i class="fa fa-long-arrow-up"></i></li>
					<li><i class="fa fa-toggle-down"></i></li>
					<li><i class="fa fa-toggle-left"></i></li>
					<li><i class="fa fa-toggle-right"></i></li>
					<li><i class="fa fa-toggle-up"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Video Player Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-arrows-alt"></i></li>
					<li><i class="fa fa-backward"></i></li>
					<li><i class="fa fa-compress"></i></li>
					<li><i class="fa fa-eject"></i></li>
					<li><i class="fa fa-expand"></i></li>
					<li><i class="fa fa-fast-backward"></i></li>
					<li><i class="fa fa-fast-forward"></i></li>
					<li><i class="fa fa-forward"></i></li>
					<li><i class="fa fa-pause"></i></li>
					<li><i class="fa fa-pause-circle"></i></li>
					<li><i class="fa fa-pause-circle-o"></i></li>
					<li><i class="fa fa-play"></i></li>
					<li><i class="fa fa-play-circle"></i></li>
					<li><i class="fa fa-play-circle-o"></i></li>
					<li><i class="fa fa-random"></i></li>
					<li><i class="fa fa-step-backward"></i></li>
					<li><i class="fa fa-step-forward"></i></li>
					<li><i class="fa fa-stop"></i></li>
					<li><i class="fa fa-stop-circle"></i></li>
					<li><i class="fa fa-stop-circle-o"></i></li>
					<li><i class="fa fa-youtube-play"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Brand Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-500px"></i></li>
					<li><i class="fa fa-adn"></i></li>
					<li><i class="fa fa-amazon"></i></li>
					<li><i class="fa fa-android"></i></li>
					<li><i class="fa fa-angellist"></i></li>
					<li><i class="fa fa-apple"></i></li>
					<li><i class="fa fa-behance"></i></li>
					<li><i class="fa fa-behance-square"></i></li>
					<li><i class="fa fa-bitbucket"></i></li>
					<li><i class="fa fa-bitbucket-square"></i></li>
					<li><i class="fa fa-bitcoin"></i></li>
					<li><i class="fa fa-black-tie"></i></li>
					<li><i class="fa fa-bluetooth"></i></li>
					<li><i class="fa fa-bluetooth-b"></i></li>
					<li><i class="fa fa-btc"></i></li>
					<li><i class="fa fa-buysellads"></i></li>
					<li><i class="fa fa-cc-amex"></i></li>
					<li><i class="fa fa-cc-diners-club"></i></li>
					<li><i class="fa fa-cc-discover"></i></li>
					<li><i class="fa fa-cc-jcb"></i></li>
					<li><i class="fa fa-cc-mastercard"></i></li>
					<li><i class="fa fa-cc-paypal"></i></li>
					<li><i class="fa fa-cc-stripe"></i></li>
					<li><i class="fa fa-cc-visa"></i></li>
					<li><i class="fa fa-chrome"></i></li>
					<li><i class="fa fa-codepen"></i></li>
					<li><i class="fa fa-codiepie"></i></li>
					<li><i class="fa fa-connectdevelop"></i></li>
					<li><i class="fa fa-contao"></i></li>
					<li><i class="fa fa-css3"></i></li>
					<li><i class="fa fa-dashcube"></i></li>
					<li><i class="fa fa-delicious"></i></li>
					<li><i class="fa fa-deviantart"></i></li>
					<li><i class="fa fa-digg"></i></li>
					<li><i class="fa fa-dribbble"></i></li>
					<li><i class="fa fa-dropbox"></i></li>
					<li><i class="fa fa-drupal"></i></li>
					<li><i class="fa fa-edge"></i></li>
					<li><i class="fa fa-empire"></i></li>
					<li><i class="fa fa-envira"></i></li>
					<li><i class="fa fa-expeditedssl"></i></li>
					<li><i class="fa fa-fa"></i></li>
					<li><i class="fa fa-facebook"></i></li>
					<li><i class="fa fa-facebook-f"></i></li>
					<li><i class="fa fa-facebook-official"></i></li>
					<li><i class="fa fa-facebook-square"></i></li>
					<li><i class="fa fa-firefox"></i></li>
					<li><i class="fa fa-first-order"></i></li>
					<li><i class="fa fa-flickr"></i></li>
					<li><i class="fa fa-font-awesome"></i></li>
					<li><i class="fa fa-fonticons"></i></li>
					<li><i class="fa fa-fort-awesome"></i></li>
					<li><i class="fa fa-forumbee"></i></li>
					<li><i class="fa fa-foursquare"></i></li>
					<li><i class="fa fa-ge"></i></li>
					<li><i class="fa fa-get-pocket"></i></li>
					<li><i class="fa fa-gg"></i></li>
					<li><i class="fa fa-gg-circle"></i></li>
					<li><i class="fa fa-git"></i></li>
					<li><i class="fa fa-git-square"></i></li>
					<li><i class="fa fa-github"></i></li>
					<li><i class="fa fa-github-alt"></i></li>
					<li><i class="fa fa-github-square"></i></li>
					<li><i class="fa fa-gitlab"></i></li>
					<li><i class="fa fa-gittip"></i></li>
					<li><i class="fa fa-glide"></i></li>
					<li><i class="fa fa-glide-g"></i></li>
					<li><i class="fa fa-google"></i></li>
					<li><i class="fa fa-google-plus"></i></li>
					<li><i class="fa fa-google-plus-circle"></i></li>
					<li><i class="fa fa-google-plus-official"></i></li>
					<li><i class="fa fa-google-plus-square"></i></li>
					<li><i class="fa fa-google-wallet"></i></li>
					<li><i class="fa fa-gratipay"></i></li>
					<li><i class="fa fa-hacker-news"></i></li>
					<li><i class="fa fa-houzz"></i></li>
					<li><i class="fa fa-html5"></i></li>
					<li><i class="fa fa-instagram"></i></li>
					<li><i class="fa fa-internet-explorer"></i></li>
					<li><i class="fa fa-ioxhost"></i></li>
					<li><i class="fa fa-joomla"></i></li>
					<li><i class="fa fa-jsfiddle"></i></li>
					<li><i class="fa fa-lastfm"></i></li>
					<li><i class="fa fa-lastfm-square"></i></li>
					<li><i class="fa fa-leanpub"></i></li>
					<li><i class="fa fa-linkedin"></i></li>
					<li><i class="fa fa-linkedin-square"></i></li>
					<li><i class="fa fa-linux"></i></li>
					<li><i class="fa fa-maxcdn"></i></li>
					<li><i class="fa fa-meanpath"></i></li>
					<li><i class="fa fa-medium"></i></li>
					<li><i class="fa fa-mixcloud"></i></li>
					<li><i class="fa fa-modx"></i></li>
					<li><i class="fa fa-odnoklassniki"></i></li>
					<li><i class="fa fa-odnoklassniki-square"></i></li>
					<li><i class="fa fa-opencart"></i></li>
					<li><i class="fa fa-openid"></i></li>
					<li><i class="fa fa-opera"></i></li>
					<li><i class="fa fa-optin-monster"></i></li>
					<li><i class="fa fa-pagelines"></i></li>
					<li><i class="fa fa-paypal"></i></li>
					<li><i class="fa fa-pied-piper"></i></li>
					<li><i class="fa fa-pied-piper-alt"></i></li>
					<li><i class="fa fa-pied-piper-pp"></i></li>
					<li><i class="fa fa-pinterest"></i></li>
					<li><i class="fa fa-pinterest-p"></i></li>
					<li><i class="fa fa-pinterest-square"></i></li>
					<li><i class="fa fa-product-hunt"></i></li>
					<li><i class="fa fa-qq"></i></li>
					<li><i class="fa fa-ra"></i></li>
					<li><i class="fa fa-rebel"></i></li>
					<li><i class="fa fa-reddit"></i></li>
					<li><i class="fa fa-reddit-alien"></i></li>
					<li><i class="fa fa-reddit-square"></i></li>
					<li><i class="fa fa-renren"></i></li>
					<li><i class="fa fa-resistance"></i></li>
					<li><i class="fa fa-safari"></i></li>
					<li><i class="fa fa-scribd"></i></li>
					<li><i class="fa fa-sellsy"></i></li>
					<li><i class="fa fa-share-alt"></i></li>
					<li><i class="fa fa-share-alt-square"></i></li>
					<li><i class="fa fa-shirtsinbulk"></i></li>
					<li><i class="fa fa-simplybuilt"></i></li>
					<li><i class="fa fa-skyatlas"></i></li>
					<li><i class="fa fa-skype"></i></li>
					<li><i class="fa fa-slack"></i></li>
					<li><i class="fa fa-slideshare"></i></li>
					<li><i class="fa fa-snapchat"></i></li>
					<li><i class="fa fa-snapchat-ghost"></i></li>
					<li><i class="fa fa-snapchat-square"></i></li>
					<li><i class="fa fa-soundcloud"></i></li>
					<li><i class="fa fa-spotify"></i></li>
					<li><i class="fa fa-stack-exchange"></i></li>
					<li><i class="fa fa-stack-overflow"></i></li>
					<li><i class="fa fa-steam"></i></li>
					<li><i class="fa fa-steam-square"></i></li>
					<li><i class="fa fa-stumbleupon"></i></li>
					<li><i class="fa fa-stumbleupon-circle"></i></li>
					<li><i class="fa fa-tencent-weibo"></i></li>
					<li><i class="fa fa-themeisle"></i></li>
					<li><i class="fa fa-trello"></i></li>
					<li><i class="fa fa-tripadvisor"></i></li>
					<li><i class="fa fa-tumblr"></i></li>
					<li><i class="fa fa-tumblr-square"></i></li>
					<li><i class="fa fa-twitch"></i></li>
					<li><i class="fa fa-twitter"></i></li>
					<li><i class="fa fa-twitter-square"></i></li>
					<li><i class="fa fa-usb"></i></li>
					<li><i class="fa fa-viacoin"></i></li>
					<li><i class="fa fa-viadeo"></i></li>
					<li><i class="fa fa-viadeo-square"></i></li>
					<li><i class="fa fa-vimeo"></i></li>
					<li><i class="fa fa-vimeo-square"></i></li>
					<li><i class="fa fa-vine"></i></li>
					<li><i class="fa fa-vk"></i></li>
					<li><i class="fa fa-wechat"></i></li>
					<li><i class="fa fa-weibo"></i></li>
					<li><i class="fa fa-weixin"></i></li>
					<li><i class="fa fa-whatsapp"></i></li>
					<li><i class="fa fa-wikipedia-w"></i></li>
					<li><i class="fa fa-windows"></i></li>
					<li><i class="fa fa-wordpress"></i></li>
					<li><i class="fa fa-wpbeginner"></i></li>
					<li><i class="fa fa-wpforms"></i></li>
					<li><i class="fa fa-xing"></i></li>
					<li><i class="fa fa-xing-square"></i></li>
					<li><i class="fa fa-y-combinator"></i></li>
					<li><i class="fa fa-y-combinator-square"></i></li>
					<li><i class="fa fa-yahoo"></i></li>
					<li><i class="fa fa-yc"></i></li>
					<li><i class="fa fa-yc-square"></i></li>
					<li><i class="fa fa-yelp"></i></li>
					<li><i class="fa fa-yoast"></i></li>
					<li><i class="fa fa-youtube"></i></li>
					<li><i class="fa fa-youtube-play"></i></li>
					<li><i class="fa fa-youtube-square"></i></li>
				</ul>
				<h3 class="text-block  mt-5 mb-4 text-center"><strong>Medical Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="fa fa-ambulance"></i></li>
					<li><i class="fa fa-h-square"></i></li>
					<li><i class="fa fa-heart"></i></li>
					<li><i class="fa fa-heart-o"></i></li>
					<li><i class="fa fa-heartbeat"></i></li>
					<li><i class="fa fa-hospital-o"></i></li>
					<li><i class="fa fa-medkit"></i></li>
					<li><i class="fa fa-plus-square"></i></li>
					<li><i class="fa fa-stethoscope"></i></li>
					<li><i class="fa fa-user-md"></i></li>
					<li><i class="fa fa-wheelchair"></i></li>
				</ul>
				
				<script>
				;(function($) {
					'use strict'
					$(function() {
						$('.air__utils__iconPresent li').each(function() {
						$(this).tooltip({
							title: $(this)
							.find('i')
							.attr('class'),
						})
						})
					})
				})(jQuery)
				</script>
			</div>
		</div>
	<?php } ?>
	<?php if($this->input->get('theval')=='icomoon'){ ?>
		<div class="row">
			<div class="col-lg-12">
				<h5 class="text-black">
				<strong>A package of flat vector icons together with an installable ligature font</strong>
				</h5>
				<p class="text-muted">
					The complete set of 490 icons in Icomoon Free v1.0.0
					<br />
					License: MIT License. You can use it for commercial projects, open source projects, or
					really just about whatever you want
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<h3 class="text-block mt-5 mb-4 text-center"><strong>General Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="icmn-home"></i></li>
					<li><i class="icmn-home2"></i></li>
					<li><i class="icmn-home3"></i></li>
					<li><i class="icmn-office"></i></li>
					<li><i class="icmn-newspaper"></i></li>
					<li><i class="icmn-pencil"></i></li>
					<li><i class="icmn-pencil2"></i></li>
					<li><i class="icmn-quill"></i></li>
					<li><i class="icmn-pen"></i></li>
					<li><i class="icmn-blog"></i></li>
					<li><i class="icmn-eyedropper"></i></li>
					<li><i class="icmn-droplet"></i></li>
					<li><i class="icmn-paint-format"></i></li>
					<li><i class="icmn-image"></i></li>
					<li><i class="icmn-images"></i></li>
					<li><i class="icmn-camera"></i></li>
					<li><i class="icmn-headphones"></i></li>
					<li><i class="icmn-music"></i></li>
					<li><i class="icmn-play"></i></li>
					<li><i class="icmn-film"></i></li>
					<li><i class="icmn-video-camera"></i></li>
					<li><i class="icmn-dice"></i></li>
					<li><i class="icmn-pacman"></i></li>
					<li><i class="icmn-spades"></i></li>
					<li><i class="icmn-clubs"></i></li>
					<li><i class="icmn-diamonds"></i></li>
					<li><i class="icmn-bullhorn"></i></li>
					<li><i class="icmn-connection"></i></li>
					<li><i class="icmn-podcast"></i></li>
					<li><i class="icmn-feed"></i></li>
					<li><i class="icmn-mic"></i></li>
					<li><i class="icmn-book"></i></li>
					<li><i class="icmn-books"></i></li>
					<li><i class="icmn-library"></i></li>
					<li><i class="icmn-file-text"></i></li>
					<li><i class="icmn-profile"></i></li>
					<li><i class="icmn-file-empty"></i></li>
					<li><i class="icmn-files-empty"></i></li>
					<li><i class="icmn-file-text2"></i></li>
					<li><i class="icmn-file-picture"></i></li>
					<li><i class="icmn-file-music"></i></li>
					<li><i class="icmn-file-play"></i></li>
					<li><i class="icmn-file-video"></i></li>
					<li><i class="icmn-file-zip"></i></li>
					<li><i class="icmn-copy"></i></li>
					<li><i class="icmn-paste"></i></li>
					<li><i class="icmn-stack"></i></li>
					<li><i class="icmn-folder"></i></li>
					<li><i class="icmn-folder-open"></i></li>
					<li><i class="icmn-folder-plus"></i></li>
					<li><i class="icmn-folder-minus"></i></li>
					<li><i class="icmn-folder-download"></i></li>
					<li><i class="icmn-folder-upload"></i></li>
					<li><i class="icmn-price-tag"></i></li>
					<li><i class="icmn-price-tags"></i></li>
					<li><i class="icmn-barcode"></i></li>
					<li><i class="icmn-qrcode"></i></li>
					<li><i class="icmn-ticket"></i></li>
					<li><i class="icmn-cart"></i></li>
					<li><i class="icmn-coin-dollar"></i></li>
					<li><i class="icmn-coin-euro"></i></li>
					<li><i class="icmn-coin-pound"></i></li>
					<li><i class="icmn-coin-yen"></i></li>
					<li><i class="icmn-credit-card"></i></li>
					<li><i class="icmn-calculator"></i></li>
					<li><i class="icmn-lifebuoy"></i></li>
					<li><i class="icmn-phone"></i></li>
					<li><i class="icmn-phone-hang-up"></i></li>
					<li><i class="icmn-address-book"></i></li>
					<li><i class="icmn-envelop"></i></li>
					<li><i class="icmn-pushpin"></i></li>
					<li><i class="icmn-location"></i></li>
					<li><i class="icmn-location2"></i></li>
					<li><i class="icmn-compass"></i></li>
					<li><i class="icmn-compass2"></i></li>
					<li><i class="icmn-map"></i></li>
					<li><i class="icmn-map2"></i></li>
					<li><i class="icmn-history"></i></li>
					<li><i class="icmn-clock"></i></li>
					<li><i class="icmn-clock2"></i></li>
					<li><i class="icmn-alarm"></i></li>
					<li><i class="icmn-bell"></i></li>
					<li><i class="icmn-stopwatch"></i></li>
					<li><i class="icmn-calendar"></i></li>
					<li><i class="icmn-printer"></i></li>
					<li><i class="icmn-keyboard"></i></li>
					<li><i class="icmn-display"></i></li>
					<li><i class="icmn-laptop"></i></li>
					<li><i class="icmn-mobile"></i></li>
					<li><i class="icmn-mobile2"></i></li>
					<li><i class="icmn-tablet"></i></li>
					<li><i class="icmn-tv"></i></li>
					<li><i class="icmn-drawer"></i></li>
					<li><i class="icmn-drawer2"></i></li>
					<li><i class="icmn-box-add"></i></li>
					<li><i class="icmn-box-remove"></i></li>
					<li><i class="icmn-download"></i></li>
					<li><i class="icmn-upload"></i></li>
					<li><i class="icmn-floppy-disk"></i></li>
					<li><i class="icmn-drive"></i></li>
					<li><i class="icmn-database"></i></li>
					<li><i class="icmn-undo"></i></li>
					<li><i class="icmn-redo"></i></li>
					<li><i class="icmn-undo2"></i></li>
					<li><i class="icmn-redo2"></i></li>
					<li><i class="icmn-forward"></i></li>
					<li><i class="icmn-reply"></i></li>
					<li><i class="icmn-bubble"></i></li>
					<li><i class="icmn-bubbles"></i></li>
					<li><i class="icmn-bubbles2"></i></li>
					<li><i class="icmn-bubble2"></i></li>
					<li><i class="icmn-bubbles3"></i></li>
					<li><i class="icmn-bubbles4"></i></li>
					<li><i class="icmn-user"></i></li>
					<li><i class="icmn-users"></i></li>
					<li><i class="icmn-user-plus"></i></li>
					<li><i class="icmn-user-minus"></i></li>
					<li><i class="icmn-user-check"></i></li>
					<li><i class="icmn-user-tie"></i></li>
					<li><i class="icmn-quotes-left"></i></li>
					<li><i class="icmn-quotes-right"></i></li>
					<li><i class="icmn-hour-glass"></i></li>
					<li><i class="icmn-spinner"></i></li>
					<li><i class="icmn-spinner2"></i></li>
					<li><i class="icmn-spinner3"></i></li>
					<li><i class="icmn-spinner4"></i></li>
					<li><i class="icmn-spinner5"></i></li>
					<li><i class="icmn-spinner6"></i></li>
					<li><i class="icmn-spinner7"></i></li>
					<li><i class="icmn-spinner8"></i></li>
					<li><i class="icmn-spinner9"></i></li>
					<li><i class="icmn-spinner10"></i></li>
					<li><i class="icmn-spinner11"></i></li>
					<li><i class="icmn-binoculars"></i></li>
					<li><i class="icmn-search"></i></li>
					<li><i class="icmn-zoom-in"></i></li>
					<li><i class="icmn-zoom-out"></i></li>
					<li><i class="icmn-enlarge"></i></li>
					<li><i class="icmn-shrink"></i></li>
					<li><i class="icmn-enlarge2"></i></li>
					<li><i class="icmn-shrink2"></i></li>
					<li><i class="icmn-key"></i></li>
					<li><i class="icmn-key2"></i></li>
					<li><i class="icmn-lock"></i></li>
					<li><i class="icmn-unlocked"></i></li>
					<li><i class="icmn-wrench"></i></li>
					<li><i class="icmn-equalizer"></i></li>
					<li><i class="icmn-equalizer2"></i></li>
					<li><i class="icmn-cog"></i></li>
					<li><i class="icmn-cogs"></i></li>
					<li><i class="icmn-hammer"></i></li>
					<li><i class="icmn-magic-wand"></i></li>
					<li><i class="icmn-aid-kit"></i></li>
					<li><i class="icmn-bug"></i></li>
					<li><i class="icmn-pie-chart"></i></li>
					<li><i class="icmn-stats-dots"></i></li>
					<li><i class="icmn-stats-bars"></i></li>
					<li><i class="icmn-stats-bars2"></i></li>
					<li><i class="icmn-trophy"></i></li>
					<li><i class="icmn-gift"></i></li>
					<li><i class="icmn-glass"></i></li>
					<li><i class="icmn-glass2"></i></li>
					<li><i class="icmn-mug"></i></li>
					<li><i class="icmn-spoon-knife"></i></li>
					<li><i class="icmn-leaf"></i></li>
					<li><i class="icmn-rocket"></i></li>
					<li><i class="icmn-meter"></i></li>
					<li><i class="icmn-meter2"></i></li>
					<li><i class="icmn-hammer2"></i></li>
					<li><i class="icmn-fire"></i></li>
					<li><i class="icmn-lab"></i></li>
					<li><i class="icmn-magnet"></i></li>
					<li><i class="icmn-bin"></i></li>
					<li><i class="icmn-bin2"></i></li>
					<li><i class="icmn-briefcase"></i></li>
					<li><i class="icmn-airplane"></i></li>
					<li><i class="icmn-truck"></i></li>
					<li><i class="icmn-road"></i></li>
					<li><i class="icmn-accessibility"></i></li>
					<li><i class="icmn-target"></i></li>
					<li><i class="icmn-shield"></i></li>
					<li><i class="icmn-power"></i></li>
					<li><i class="icmn-switch"></i></li>
					<li><i class="icmn-power-cord"></i></li>
					<li><i class="icmn-clipboard"></i></li>
					<li><i class="icmn-list-numbered"></i></li>
					<li><i class="icmn-list"></i></li>
					<li><i class="icmn-list2"></i></li>
					<li><i class="icmn-tree"></i></li>
					<li><i class="icmn-menu"></i></li>
					<li><i class="icmn-menu2"></i></li>
					<li><i class="icmn-menu3"></i></li>
					<li><i class="icmn-menu4"></i></li>
					<li><i class="icmn-cloud"></i></li>
					<li><i class="icmn-cloud-download"></i></li>
					<li><i class="icmn-cloud-upload"></i></li>
					<li><i class="icmn-cloud-check"></i></li>
					<li><i class="icmn-download2"></i></li>
					<li><i class="icmn-upload2"></i></li>
					<li><i class="icmn-download3"></i></li>
					<li><i class="icmn-upload3"></i></li>
					<li><i class="icmn-sphere"></i></li>
					<li><i class="icmn-earth"></i></li>
					<li><i class="icmn-link"></i></li>
					<li><i class="icmn-flag"></i></li>
					<li><i class="icmn-attachment"></i></li>
					<li><i class="icmn-eye"></i></li>
					<li><i class="icmn-eye-plus"></i></li>
					<li><i class="icmn-eye-minus"></i></li>
					<li><i class="icmn-eye-blocked"></i></li>
					<li><i class="icmn-bookmark"></i></li>
					<li><i class="icmn-bookmarks"></i></li>
					<li><i class="icmn-sun"></i></li>
					<li><i class="icmn-contrast"></i></li>
					<li><i class="icmn-brightness-contrast"></i></li>
					<li><i class="icmn-star-empty"></i></li>
					<li><i class="icmn-star-half"></i></li>
					<li><i class="icmn-star-full"></i></li>
					<li><i class="icmn-heart"></i></li>
					<li><i class="icmn-heart-broken"></i></li>
					<li><i class="icmn-man"></i></li>
					<li><i class="icmn-woman"></i></li>
					<li><i class="icmn-man-woman"></i></li>
					<li><i class="icmn-happy"></i></li>
					<li><i class="icmn-happy2"></i></li>
					<li><i class="icmn-smile"></i></li>
					<li><i class="icmn-smile2"></i></li>
					<li><i class="icmn-tongue"></i></li>
					<li><i class="icmn-tongue2"></i></li>
					<li><i class="icmn-sad"></i></li>
					<li><i class="icmn-sad2"></i></li>
					<li><i class="icmn-wink"></i></li>
					<li><i class="icmn-wink2"></i></li>
					<li><i class="icmn-grin"></i></li>
					<li><i class="icmn-grin2"></i></li>
					<li><i class="icmn-cool"></i></li>
					<li><i class="icmn-cool2"></i></li>
					<li><i class="icmn-angry"></i></li>
					<li><i class="icmn-angry2"></i></li>
					<li><i class="icmn-evil"></i></li>
					<li><i class="icmn-evil2"></i></li>
					<li><i class="icmn-shocked"></i></li>
					<li><i class="icmn-shocked2"></i></li>
					<li><i class="icmn-baffled"></i></li>
					<li><i class="icmn-baffled2"></i></li>
					<li><i class="icmn-confused"></i></li>
					<li><i class="icmn-confused2"></i></li>
					<li><i class="icmn-neutral"></i></li>
					<li><i class="icmn-neutral2"></i></li>
					<li><i class="icmn-hipster"></i></li>
					<li><i class="icmn-hipster2"></i></li>
					<li><i class="icmn-wondering"></i></li>
					<li><i class="icmn-wondering2"></i></li>
					<li><i class="icmn-sleepy"></i></li>
					<li><i class="icmn-sleepy2"></i></li>
					<li><i class="icmn-frustrated"></i></li>
					<li><i class="icmn-frustrated2"></i></li>
					<li><i class="icmn-crying"></i></li>
					<li><i class="icmn-crying2"></i></li>
					<li><i class="icmn-point-up"></i></li>
					<li><i class="icmn-point-right"></i></li>
					<li><i class="icmn-point-down"></i></li>
					<li><i class="icmn-point-left"></i></li>
					<li><i class="icmn-warning"></i></li>
					<li><i class="icmn-notification"></i></li>
					<li><i class="icmn-question"></i></li>
					<li><i class="icmn-plus"></i></li>
					<li><i class="icmn-minus"></i></li>
					<li><i class="icmn-info"></i></li>
					<li><i class="icmn-cancel-circle"></i></li>
					<li><i class="icmn-blocked"></i></li>
					<li><i class="icmn-cross"></i></li>
					<li><i class="icmn-checkmark"></i></li>
					<li><i class="icmn-checkmark2"></i></li>
					<li><i class="icmn-spell-check"></i></li>
					<li><i class="icmn-enter"></i></li>
					<li><i class="icmn-exit"></i></li>
					<li><i class="icmn-play2"></i></li>
					<li><i class="icmn-pause"></i></li>
					<li><i class="icmn-stop"></i></li>
					<li><i class="icmn-previous"></i></li>
					<li><i class="icmn-next"></i></li>
					<li><i class="icmn-backward"></i></li>
					<li><i class="icmn-forward2"></i></li>
					<li><i class="icmn-play3"></i></li>
					<li><i class="icmn-pause2"></i></li>
					<li><i class="icmn-stop2"></i></li>
					<li><i class="icmn-backward2"></i></li>
					<li><i class="icmn-forward3"></i></li>
					<li><i class="icmn-first"></i></li>
					<li><i class="icmn-last"></i></li>
					<li><i class="icmn-previous2"></i></li>
					<li><i class="icmn-next2"></i></li>
					<li><i class="icmn-eject"></i></li>
					<li><i class="icmn-volume-high"></i></li>
					<li><i class="icmn-volume-medium"></i></li>
					<li><i class="icmn-volume-low"></i></li>
					<li><i class="icmn-volume-mute"></i></li>
					<li><i class="icmn-volume-mute2"></i></li>
					<li><i class="icmn-volume-increase"></i></li>
					<li><i class="icmn-volume-decrease"></i></li>
					<li><i class="icmn-loop"></i></li>
					<li><i class="icmn-loop2"></i></li>
					<li><i class="icmn-infinite"></i></li>
					<li><i class="icmn-shuffle"></i></li>
					<li><i class="icmn-arrow-up-left"></i></li>
					<li><i class="icmn-arrow-up"></i></li>
					<li><i class="icmn-arrow-up-right"></i></li>
					<li><i class="icmn-arrow-right"></i></li>
					<li><i class="icmn-arrow-down-right"></i></li>
					<li><i class="icmn-arrow-down"></i></li>
					<li><i class="icmn-arrow-down-left"></i></li>
					<li><i class="icmn-arrow-left"></i></li>
					<li><i class="icmn-arrow-up-left2"></i></li>
					<li><i class="icmn-arrow-up2"></i></li>
					<li><i class="icmn-arrow-up-right2"></i></li>
					<li><i class="icmn-arrow-right2"></i></li>
					<li><i class="icmn-arrow-down-right2"></i></li>
					<li><i class="icmn-arrow-down2"></i></li>
					<li><i class="icmn-arrow-down-left2"></i></li>
					<li><i class="icmn-arrow-left2"></i></li>
					<li><i class="icmn-circle-up"></i></li>
					<li><i class="icmn-circle-right"></i></li>
					<li><i class="icmn-circle-down"></i></li>
					<li><i class="icmn-circle-left"></i></li>
					<li><i class="icmn-tab"></i></li>
					<li><i class="icmn-move-up"></i></li>
					<li><i class="icmn-move-down"></i></li>
					<li><i class="icmn-sort-alpha-asc"></i></li>
					<li><i class="icmn-sort-alpha-desc"></i></li>
					<li><i class="icmn-sort-numeric-asc"></i></li>
					<li><i class="icmn-sort-numberic-desc"></i></li>
					<li><i class="icmn-sort-amount-asc"></i></li>
					<li><i class="icmn-sort-amount-desc"></i></li>
					<li><i class="icmn-command"></i></li>
					<li><i class="icmn-shift"></i></li>
					<li><i class="icmn-ctrl"></i></li>
					<li><i class="icmn-opt"></i></li>
					<li><i class="icmn-checkbox-checked"></i></li>
					<li><i class="icmn-checkbox-unchecked"></i></li>
					<li><i class="icmn-radio-checked"></i></li>
					<li><i class="icmn-radio-checked2"></i></li>
					<li><i class="icmn-radio-unchecked"></i></li>
					<li><i class="icmn-crop"></i></li>
					<li><i class="icmn-make-group"></i></li>
					<li><i class="icmn-ungroup"></i></li>
					<li><i class="icmn-scissors"></i></li>
					<li><i class="icmn-filter"></i></li>
					<li><i class="icmn-font"></i></li>
					<li><i class="icmn-ligature"></i></li>
					<li><i class="icmn-ligature2"></i></li>
					<li><i class="icmn-text-height"></i></li>
					<li><i class="icmn-text-width"></i></li>
					<li><i class="icmn-font-size"></i></li>
					<li><i class="icmn-bold"></i></li>
					<li><i class="icmn-underline"></i></li>
					<li><i class="icmn-italic"></i></li>
					<li><i class="icmn-strikethrough"></i></li>
					<li><i class="icmn-omega"></i></li>
					<li><i class="icmn-sigma"></i></li>
					<li><i class="icmn-page-break"></i></li>
					<li><i class="icmn-superscript"></i></li>
					<li><i class="icmn-subscript"></i></li>
					<li><i class="icmn-superscript2"></i></li>
					<li><i class="icmn-subscript2"></i></li>
					<li><i class="icmn-text-color"></i></li>
					<li><i class="icmn-pagebreak"></i></li>
					<li><i class="icmn-clear-formatting"></i></li>
					<li><i class="icmn-table"></i></li>
					<li><i class="icmn-table2"></i></li>
					<li><i class="icmn-insert-template"></i></li>
					<li><i class="icmn-pilcrow"></i></li>
					<li><i class="icmn-ltr"></i></li>
					<li><i class="icmn-rtl"></i></li>
					<li><i class="icmn-section"></i></li>
					<li><i class="icmn-paragraph-left"></i></li>
					<li><i class="icmn-paragraph-center"></i></li>
					<li><i class="icmn-paragraph-right"></i></li>
					<li><i class="icmn-paragraph-justify"></i></li>
					<li><i class="icmn-indent-increase"></i></li>
					<li><i class="icmn-indent-decrease"></i></li>
					<li><i class="icmn-share"></i></li>
					<li><i class="icmn-new-tab"></i></li>
					<li><i class="icmn-embed"></i></li>
					<li><i class="icmn-embed2"></i></li>
					<li><i class="icmn-terminal"></i></li>
					<li><i class="icmn-share2"></i></li>
					<li><i class="icmn-mail"></i></li>
					<li><i class="icmn-mail2"></i></li>
					<li><i class="icmn-mail3"></i></li>
					<li><i class="icmn-mail4"></i></li>
					<li><i class="icmn-amazon"></i></li>
					<li><i class="icmn-google"></i></li>
					<li><i class="icmn-google2"></i></li>
					<li><i class="icmn-google3"></i></li>
					<li><i class="icmn-google-plus"></i></li>
					<li><i class="icmn-google-plus2"></i></li>
					<li><i class="icmn-google-plus3"></i></li>
					<li><i class="icmn-hangouts"></i></li>
					<li><i class="icmn-google-drive"></i></li>
					<li><i class="icmn-facebook"></i></li>
					<li><i class="icmn-facebook2"></i></li>
					<li><i class="icmn-instagram"></i></li>
					<li><i class="icmn-whatsapp"></i></li>
					<li><i class="icmn-spotify"></i></li>
					<li><i class="icmn-telegram"></i></li>
					<li><i class="icmn-twitter"></i></li>
					<li><i class="icmn-vine"></i></li>
					<li><i class="icmn-vk"></i></li>
					<li><i class="icmn-renren"></i></li>
					<li><i class="icmn-sina-weibo"></i></li>
					<li><i class="icmn-rss"></i></li>
					<li><i class="icmn-rss2"></i></li>
					<li><i class="icmn-youtube"></i></li>
					<li><i class="icmn-youtube2"></i></li>
					<li><i class="icmn-twitch"></i></li>
					<li><i class="icmn-vimeo"></i></li>
					<li><i class="icmn-vimeo2"></i></li>
					<li><i class="icmn-lanyrd"></i></li>
					<li><i class="icmn-flickr"></i></li>
					<li><i class="icmn-flickr2"></i></li>
					<li><i class="icmn-flickr3"></i></li>
					<li><i class="icmn-flickr4"></i></li>
					<li><i class="icmn-dribbble"></i></li>
					<li><i class="icmn-behance"></i></li>
					<li><i class="icmn-behance2"></i></li>
					<li><i class="icmn-deviantart"></i></li>
					<li><i class="icmn-500px"></i></li>
					<li><i class="icmn-steam"></i></li>
					<li><i class="icmn-steam2"></i></li>
					<li><i class="icmn-dropbox"></i></li>
					<li><i class="icmn-onedrive"></i></li>
					<li><i class="icmn-github"></i></li>
					<li><i class="icmn-npm"></i></li>
					<li><i class="icmn-basecamp"></i></li>
					<li><i class="icmn-trello"></i></li>
					<li><i class="icmn-wordpress"></i></li>
					<li><i class="icmn-joomla"></i></li>
					<li><i class="icmn-ello"></i></li>
					<li><i class="icmn-blogger"></i></li>
					<li><i class="icmn-blogger2"></i></li>
					<li><i class="icmn-tumblr"></i></li>
					<li><i class="icmn-tumblr2"></i></li>
					<li><i class="icmn-yahoo"></i></li>
					<li><i class="icmn-yahoo2"></i></li>
					<li><i class="icmn-tux"></i></li>
					<li><i class="icmn-appleinc"></i></li>
					<li><i class="icmn-finder"></i></li>
					<li><i class="icmn-android"></i></li>
					<li><i class="icmn-windows"></i></li>
					<li><i class="icmn-windows8"></i></li>
					<li><i class="icmn-soundcloud"></i></li>
					<li><i class="icmn-soundcloud2"></i></li>
					<li><i class="icmn-skype"></i></li>
					<li><i class="icmn-reddit"></i></li>
					<li><i class="icmn-hackernews"></i></li>
					<li><i class="icmn-wikipedia"></i></li>
					<li><i class="icmn-linkedin"></i></li>
					<li><i class="icmn-linkedin2"></i></li>
					<li><i class="icmn-lastfm"></i></li>
					<li><i class="icmn-lastfm2"></i></li>
					<li><i class="icmn-delicious"></i></li>
					<li><i class="icmn-stumbleupon"></i></li>
					<li><i class="icmn-stumbleupon2"></i></li>
					<li><i class="icmn-stackoverflow"></i></li>
					<li><i class="icmn-pinterest"></i></li>
					<li><i class="icmn-pinterest2"></i></li>
					<li><i class="icmn-xing"></i></li>
					<li><i class="icmn-xing2"></i></li>
					<li><i class="icmn-flattr"></i></li>
					<li><i class="icmn-foursquare"></i></li>
					<li><i class="icmn-yelp"></i></li>
					<li><i class="icmn-paypal"></i></li>
					<li><i class="icmn-chrome"></i></li>
					<li><i class="icmn-firefox"></i></li>
					<li><i class="icmn-IE"></i></li>
					<li><i class="icmn-edge"></i></li>
					<li><i class="icmn-safari"></i></li>
					<li><i class="icmn-opera"></i></li>
					<li><i class="icmn-file-pdf"></i></li>
					<li><i class="icmn-file-openoffice"></i></li>
					<li><i class="icmn-file-word"></i></li>
					<li><i class="icmn-file-excel"></i></li>
					<li><i class="icmn-libreoffice"></i></li>
					<li><i class="icmn-html-five"></i></li>
					<li><i class="icmn-html-five2"></i></li>
					<li><i class="icmn-css3"></i></li>
					<li><i class="icmn-git"></i></li>
					<li><i class="icmn-codepen"></i></li>
					<li><i class="icmn-svg"></i></li>
				</ul>
				<script>
				;(function($) {
					'use strict'
					$(function() {
					$('.air__utils__iconPresent li').each(function() {
						$(this).tooltip({
						title: $(this)
							.find('i')
							.attr('class'),
						})
					})
					})
				})(jQuery)
				</script>
			</div>
		</div>
	<?php } ?>
	<?php if($this->input->get('theval')=='linearicons'){ ?>
		<div class="row">
			<div class="col-lg-12">
				<h5 class="text-black"><strong>Ultra crisp line icons with integrity</strong></h5>
				<p class="text-muted">
				The complete set of 170 icons in Linearicons Free v1.0.0
				<br />
				License: MIT License. You can use it for commercial projects, open source projects, or
				really just about whatever you want
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<h3 class="text-block mt-5 mb-4 text-center"><strong>General Icons</strong></h3>
				<ul class="air__utils__iconPresent list-unstyled">
					<li><i class="lnr lnr-home"></i></li>
					<li><i class="lnr lnr-apartment"></i></li>
					<li><i class="lnr lnr-pencil"></i></li>
					<li><i class="lnr lnr-magic-wand"></i></li>
					<li><i class="lnr lnr-drop"></i></li>
					<li><i class="lnr lnr-lighter"></i></li>
					<li><i class="lnr lnr-poop"></i></li>
					<li><i class="lnr lnr-sun"></i></li>
					<li><i class="lnr lnr-moon"></i></li>
					<li><i class="lnr lnr-cloud"></i></li>
					<li><i class="lnr lnr-cloud-upload"></i></li>
					<li><i class="lnr lnr-cloud-download"></i></li>
					<li><i class="lnr lnr-cloud-sync"></i></li>
					<li><i class="lnr lnr-cloud-check"></i></li>
					<li><i class="lnr lnr-database"></i></li>
					<li><i class="lnr lnr-lock"></i></li>
					<li><i class="lnr lnr-cog"></i></li>
					<li><i class="lnr lnr-trash"></i></li>
					<li><i class="lnr lnr-dice"></i></li>
					<li><i class="lnr lnr-heart"></i></li>
					<li><i class="lnr lnr-star"></i></li>
					<li><i class="lnr lnr-star-half"></i></li>
					<li><i class="lnr lnr-star-empty"></i></li>
					<li><i class="lnr lnr-flag"></i></li>
					<li><i class="lnr lnr-envelope"></i></li>
					<li><i class="lnr lnr-paperclip"></i></li>
					<li><i class="lnr lnr-inbox"></i></li>
					<li><i class="lnr lnr-eye"></i></li>
					<li><i class="lnr lnr-printer"></i></li>
					<li><i class="lnr lnr-file-empty"></i></li>
					<li><i class="lnr lnr-file-add"></i></li>
					<li><i class="lnr lnr-enter"></i></li>
					<li><i class="lnr lnr-exit"></i></li>
					<li><i class="lnr lnr-graduation-hat"></i></li>
					<li><i class="lnr lnr-license"></i></li>
					<li><i class="lnr lnr-music-note"></i></li>
					<li><i class="lnr lnr-film-play"></i></li>
					<li><i class="lnr lnr-camera-video"></i></li>
					<li><i class="lnr lnr-camera"></i></li>
					<li><i class="lnr lnr-picture"></i></li>
					<li><i class="lnr lnr-book"></i></li>
					<li><i class="lnr lnr-bookmark"></i></li>
					<li><i class="lnr lnr-user"></i></li>
					<li><i class="lnr lnr-users"></i></li>
					<li><i class="lnr lnr-shirt"></i></li>
					<li><i class="lnr lnr-store"></i></li>
					<li><i class="lnr lnr-cart"></i></li>
					<li><i class="lnr lnr-tag"></i></li>
					<li><i class="lnr lnr-phone-handset"></i></li>
					<li><i class="lnr lnr-phone"></i></li>
					<li><i class="lnr lnr-pushpin"></i></li>
					<li><i class="lnr lnr-map-marker"></i></li>
					<li><i class="lnr lnr-map"></i></li>
					<li><i class="lnr lnr-location"></i></li>
					<li><i class="lnr lnr-calendar-full"></i></li>
					<li><i class="lnr lnr-keyboard"></i></li>
					<li><i class="lnr lnr-spell-check"></i></li>
					<li><i class="lnr lnr-screen"></i></li>
					<li><i class="lnr lnr-smartphone"></i></li>
					<li><i class="lnr lnr-tablet"></i></li>
					<li><i class="lnr lnr-laptop"></i></li>
					<li><i class="lnr lnr-laptop-phone"></i></li>
					<li><i class="lnr lnr-power-switch"></i></li>
					<li><i class="lnr lnr-bubble"></i></li>
					<li><i class="lnr lnr-heart-pulse"></i></li>
					<li><i class="lnr lnr-pie-chart"></i></li>
					<li><i class="lnr lnr-chart-bars"></i></li>
					<li><i class="lnr lnr-gift"></i></li>
					<li><i class="lnr lnr-diamond"></i></li>
					<li><i class="lnr lnr-dinner"></i></li>
					<li><i class="lnr lnr-coffee-cup"></i></li>
					<li><i class="lnr lnr-leaf"></i></li>
					<li><i class="lnr lnr-paw"></i></li>
					<li><i class="lnr lnr-rocket"></i></li>
					<li><i class="lnr lnr-briefcase"></i></li>
					<li><i class="lnr lnr-bus"></i></li>
					<li><i class="lnr lnr-car"></i></li>
					<li><i class="lnr lnr-train"></i></li>
					<li><i class="lnr lnr-bicycle"></i></li>
					<li><i class="lnr lnr-wheelchair"></i></li>
					<li><i class="lnr lnr-select"></i></li>
					<li><i class="lnr lnr-earth"></i></li>
					<li><i class="lnr lnr-smile"></i></li>
					<li><i class="lnr lnr-sad"></i></li>
					<li><i class="lnr lnr-neutral"></i></li>
					<li><i class="lnr lnr-mustache"></i></li>
					<li><i class="lnr lnr-alarm"></i></li>
					<li><i class="lnr lnr-bullhorn"></i></li>
					<li><i class="lnr lnr-volume-high"></i></li>
					<li><i class="lnr lnr-volume-medium"></i></li>
					<li><i class="lnr lnr-volume-low"></i></li>
					<li><i class="lnr lnr-volume"></i></li>
					<li><i class="lnr lnr-mic"></i></li>
					<li><i class="lnr lnr-hourglass"></i></li>
					<li><i class="lnr lnr-undo"></i></li>
					<li><i class="lnr lnr-redo"></i></li>
					<li><i class="lnr lnr-sync"></i></li>
					<li><i class="lnr lnr-history"></i></li>
					<li><i class="lnr lnr-clock"></i></li>
					<li><i class="lnr lnr-download"></i></li>
					<li><i class="lnr lnr-upload"></i></li>
					<li><i class="lnr lnr-enter-down"></i></li>
					<li><i class="lnr lnr-exit-up"></i></li>
					<li><i class="lnr lnr-bug"></i></li>
					<li><i class="lnr lnr-code"></i></li>
					<li><i class="lnr lnr-link"></i></li>
					<li><i class="lnr lnr-unlink"></i></li>
					<li><i class="lnr lnr-thumbs-up"></i></li>
					<li><i class="lnr lnr-thumbs-down"></i></li>
					<li><i class="lnr lnr-magnifier"></i></li>
					<li><i class="lnr lnr-cross"></i></li>
					<li><i class="lnr lnr-menu"></i></li>
					<li><i class="lnr lnr-list"></i></li>
					<li><i class="lnr lnr-chevron-up"></i></li>
					<li><i class="lnr lnr-chevron-down"></i></li>
					<li><i class="lnr lnr-chevron-left"></i></li>
					<li><i class="lnr lnr-chevron-right"></i></li>
					<li><i class="lnr lnr-arrow-up"></i></li>
					<li><i class="lnr lnr-arrow-down"></i></li>
					<li><i class="lnr lnr-arrow-left"></i></li>
					<li><i class="lnr lnr-arrow-right"></i></li>
					<li><i class="lnr lnr-move"></i></li>
					<li><i class="lnr lnr-warning"></i></li>
					<li><i class="lnr lnr-question-circle"></i></li>
					<li><i class="lnr lnr-menu-circle"></i></li>
					<li><i class="lnr lnr-checkmark-circle"></i></li>
					<li><i class="lnr lnr-cross-circle"></i></li>
					<li><i class="lnr lnr-plus-circle"></i></li>
					<li><i class="lnr lnr-circle-minus"></i></li>
					<li><i class="lnr lnr-arrow-up-circle"></i></li>
					<li><i class="lnr lnr-arrow-down-circle"></i></li>
					<li><i class="lnr lnr-arrow-left-circle"></i></li>
					<li><i class="lnr lnr-arrow-right-circle"></i></li>
					<li><i class="lnr lnr-chevron-up-circle"></i></li>
					<li><i class="lnr lnr-chevron-down-circle"></i></li>
					<li><i class="lnr lnr-chevron-left-circle"></i></li>
					<li><i class="lnr lnr-chevron-right-circle"></i></li>
					<li><i class="lnr lnr-crop"></i></li>
					<li><i class="lnr lnr-frame-expand"></i></li>
					<li><i class="lnr lnr-layers"></i></li>
					<li><i class="lnr lnr-funnel"></i></li>
					<li><i class="lnr lnr-text-format"></i></li>
					<li><i class="lnr lnr-text-format-remove"></i></li>
					<li><i class="lnr lnr-text-size"></i></li>
					<li><i class="lnr lnr-bold"></i></li>
					<li><i class="lnr lnr-italic"></i></li>
					<li><i class="lnr lnr-underline"></i></li>
					<li><i class="lnr lnr-strikethrough"></i></li>
					<li><i class="lnr lnr-highlight"></i></li>
					<li><i class="lnr lnr-text-align-left"></i></li>
					<li><i class="lnr lnr-text-align-center"></i></li>
					<li><i class="lnr lnr-text-align-right"></i></li>
					<li><i class="lnr lnr-text-align-justify"></i></li>
					<li><i class="lnr lnr-line-spacing"></i></li>
					<li><i class="lnr lnr-indent-increase"></i></li>
					<li><i class="lnr lnr-indent-decrease"></i></li>
					<li><i class="lnr lnr-pilcrow"></i></li>
					<li><i class="lnr lnr-direction-ltr"></i></li>
					<li><i class="lnr lnr-direction-rtl"></i></li>
					<li><i class="lnr lnr-page-break"></i></li>
					<li><i class="lnr lnr-sort-alpha-asc"></i></li>
					<li><i class="lnr lnr-sort-amount-asc"></i></li>
					<li><i class="lnr lnr-hand"></i></li>
					<li><i class="lnr lnr-pointer-up"></i></li>
					<li><i class="lnr lnr-pointer-right"></i></li>
					<li><i class="lnr lnr-pointer-down"></i></li>
					<li><i class="lnr lnr-pointer-left"></i></li>
				</ul>
				<script>
				;(function($) {
					'use strict'
					$(function() {
					$('.air__utils__iconPresent li').each(function() {
						$(this).tooltip({
						title: $(this)
							.find('i')
							.attr('class'),
						})
					})
					})
				})(jQuery)
				</script>
			</div>
		</div>
	<?php } ?>

	</div>
<!-- /.card-body -->
</div>
<!-- /.card -->


<script src="<?php echo admin_assets('vendors/jquery-mousewheel/jquery.mousewheel.min.js'); ?>"></script>
<script src="<?php echo admin_assets('vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.js'); ?>"></script>

<script src="<?php echo admin_assets('components/core/index.js'); ?>"></script>
<script src="<?php echo admin_assets('components/menu-left/index.js'); ?>"></script>
<script src="<?php echo admin_assets('components/sidebar/index.js'); ?>"></script>
<script src="<?php echo admin_assets('components/topbar/index.js'); ?>"></script>

</body>
</html>