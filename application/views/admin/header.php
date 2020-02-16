<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

global $CI;
$CI =& get_instance();

// load admin libraries here
$CI->load->library('AdminEnv');

// load admin helper here
$CI->load->helper('admin_functions');
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
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/topbar/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/subbar/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/sidebar/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/apps/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/extra-apps/style.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo admin_assets('components/ecommerce/style.css'); ?>">

<?php 
// LOAD STYLE
echo $this->assetsloc->get_admin_style('library');

echo $this->assetsloc->get_admin_style('manually');
?>
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

<body class="air__menu--white air__menu--shadow air__sidebar--toggled air__layout--cardsShadow">
<div class="air__initialLoading"></div>
    <div class="air__layout air__layout--hasSider">
        