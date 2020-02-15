<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <?php
                    $admindata = $CI->adminenv->adminData();
                    if( !empty($admindata['userDir']) AND !empty($admindata['userPic']) ){
                        $imgadmin = images_url() . '/'.$admindata['userDir'].'/xsmall_'.$admindata['userPic'];
                    } else {
                        $imgadmin = admin_assets().'/img/no_avatar.jpg';
                    }
                    ?>
                    <div class="mr-3">
                        <img src="<?php echo $imgadmin; ?>" width="38" height="38" class="rounded-circle" alt="<?php echo $admindata['userDisplayName']; ?>">
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold"><?php echo $admindata['userDisplayName']; ?></div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-mail5 font-size-sm"></i> &nbsp;<?php echo $admindata['userEmail']; ?>
                        </div>
                    </div>

                    <?php if( $CI->session->userdata('leveluser')=='1' ){ ?>
                    <div class="ml-3 align-self-center">
                        <a href="<?php echo admin_url('atur_web'); ?>" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>

                <li class="nav-item">
                    <a href="<?php echo admin_url('dashboard'); ?>" class="nav-link<?php if ($CI->uri->segment(2)=='dashboard'){ echo " active"; } ?>">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                <?php $CI->adminenv->admin_menu_item(); ?>

                <li class="nav-item">
                    <a href="<?php echo admin_url('main/logout'); ?>" class="nav-link">
                        <i class="icon-switch2"></i>
                        <span>
                            Logout
                        </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->
    
</div>
<!-- /main sidebar -->

<!-- Main content -->
<div class="content-wrapper">
    
    <!-- Page header -->
    <div class="page-header page-header-light">
        <?php
        $page_header_on = isset($page_header_on)? true:false;
        $optheader = array(
            'title_page' => isset($title_page) ? $title_page:'',
            'title_page_icon' => isset($title_page_icon) ? $title_page_icon:'',
            'title_page_secondary' => isset($title_page_secondary) ? $title_page_secondary:'',
            'header_button_action' => isset($header_button_action) ? $header_button_action:array()
        );
        $CI->adminenv->adminPageHeader( $page_header_on, $optheader );
        ?>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <?php $CI->adminenv->adminBreadcrumb(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->
    

    <!-- Content area -->
    <div class="content">