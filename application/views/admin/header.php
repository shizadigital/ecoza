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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="<?php echo "Memo Indo Media"; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="noindex,nofollow" />
    <!-- Icons -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo favicon_img_url(); ?>">
    <link rel="icon" type="image/ico" href="<?php echo favicon_img_url(); ?>">
    <link rel="shortcut icon" href="<?php echo favicon_img_url(); ?>">

    <!-- Global stylesheets -->
    <link href="<?php echo admin_assets(); ?>/css/fonts/roboto/roboto.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/global_assets/css/icons/material/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/global_assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_assets(); ?>/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <?php 
    // LOAD STYLE
    echo $this->assetsloc->get_admin_style('library');

    echo $this->assetsloc->get_admin_style('manually');
    ?>
    
    <link href="<?php echo admin_assets(); ?>/css/custom-style.css" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script src="<?php echo admin_assets(); ?>/global_assets/js/main/jquery.min.js"></script>
    <script src="<?php echo admin_assets(); ?>/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo admin_assets(); ?>/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark">
        <div class="navbar-brand">
            <a href="<?php echo admin_url(); ?>" class="d-inline-block">
                <img src="<?php echo admin_assets(); ?>/global_assets/images/logo_light.png" alt="Memo Indo Media">
            </a>
        </div>

        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                        <i class="icon-paragraph-justify3"></i>
                    </a>
                </li>
            </ul>

            <span class="navbar-text ml-md-3 mr-md-auto">
                <?php echo get_adm_ol_status(); ?>                
            </span>

            <ul class="navbar-nav">
                
                <li class="nav-item dropdown">
                    <?php
                    $totalcomments = countdata("komentar","komenApproved='0'");
                    ?>
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-bubbles4"></i>
                        <span class="d-md-none ml-2">Komentar</span>
                        <?php if($totalcomments > 0){ ?>
                        <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0"><?php echo $totalcomments; ?></span>
                        <?php } ?>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Komentar (<?php echo $totalcomments; ?>)</span>
                        </div>

                        <?php if($totalcomments > 0){ ?>
                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <?php
                                foreach ($CI->adminenv->topBarComments() as $ky => $dc) {

                                    $ava = gravatar($dc['komenEmail'],80,true,'g',false);
                                    if( $ava ){
                                        $imgcommentnotif = '<img class="rounded-circle" width="36" height="36" src="'.$ava.'" alt="'.$dc['komenPenulis'].'">';
                                    } else {
                                        $imgcommentnotif = '<img class="rounded-circle" width="36" height="36" src="'.admin_assets().'/img/no_avatar.jpg" alt="'.$dc['komenPenulis'].'">';
                                    }

                                    // potongcomment
                                    $commentcontentnotif = the_excerpt($dc['komenIsi'], 38, '...' );
                                ?>
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <?php echo $imgcommentnotif; ?>
                                    </div>

                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold"><?php echo $dc['komenPenulis']; ?></span>
                                                <span class="text-muted float-right font-size-sm"><?php echo dateSays($dc['komenTimestamp']); ?> Lalu</span>
                                            </a>
                                        </div>

                                        <span class="text-muted"><?php echo $commentcontentnotif; ?></span>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>

                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Selengkapnya"><i class="icon-menu7 d-block top-0"></i></a>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown dropdown-user">
                    <?php
                    $admindata = $CI->adminenv->adminData();

                    if( !empty($admindata['userDir']) AND !empty($admindata['userPic']) ){
                        $imgadmin = images_url() . '/'.$admindata['userDir'].'/xsmall_'.$admindata['userPic'];
                    } else {
                        $imgadmin = admin_assets().'/img/no_avatar_small.jpg';
                    }
                    ?>
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $imgadmin; ?>" class="rounded-circle" alt="<?php echo $admindata['userDisplayName']; ?>">
                        <span><?php echo $admindata['userDisplayName']; ?></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="<?php echo base_url(); ?>" target="_blank" class="dropdown-item"><i class="icon-sphere"></i> Lihat Website</a>
                        <a href="<?php echo admin_url('manage_users/edit/'.$CI->session->userdata('adminid') ); ?>" class="dropdown-item"><i class="icon-user"></i> Akun</a>
                        <a href="<?php echo admin_url('atur_web'); ?>" class="dropdown-item"><i class="icon-cog5"></i> Web Setting</a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo admin_url('main/logout'); ?>" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->

    <!-- Page content -->
    <div class="page-content">