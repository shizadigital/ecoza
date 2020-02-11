<!DOCTYPE html>
<html lang="id">

<head>
<title>@yield('title') | <?php echo env('APP_NAME') ?></title>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="author" content="Shiza.id" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="robots" content="noindex,nofollow" />
<!-- Icons -->
<?php /* ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo favicon_img_url(); ?>">
<link rel="icon" type="image/ico" href="<?php echo favicon_img_url(); ?>">
<link rel="shortcut icon" href="<?php echo favicon_img_url(); ?>">
<?php */ ?>

<!-- Global stylesheets -->
<link href="{{ asset('admin/css/fonts/roboto/roboto.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/global_assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/global_assets/css/icons/material/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/global_assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/layout.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/components.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/css/colors.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('admin/css/custom-style.css') }}" rel="stylesheet" type="text/css">

@yield('custom-style')

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="{{ route('admin.dashboard.index') }}" class="d-inline-block">
            <img src="{{ asset('admin/global_assets/images/logo_light.png') }}" alt="Memo Indo Media">
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
            Online
            <?php #echo get_adm_ol_status(); ?>                
        </span>

        <ul class="navbar-nav">
            
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                    <i class="icon-bubbles4"></i>
                    <span class="d-md-none ml-2">Komentar</span>
                    <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">0</span>
                </a>
                
                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    <div class="dropdown-content-header">
                        <span class="font-weight-semibold">Komentar (0)</span>
                    </div>

                    <div class="dropdown-content-footer justify-content-center p-0">
                        <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Selengkapnya"><i class="icon-menu7 d-block top-0"></i></a>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown dropdown-user">
                <?php
                    $imgAdmin = 'http://placehold.it/200x200';
                ?>
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ $imgAdmin }}" class="rounded-circle" alt="Admin">
                    <span>Admin</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ URL::to('/') }}" target="_blank" class="dropdown-item"><i class="icon-sphere"></i> Lihat Website</a>
                    <a href="#" class="dropdown-item"><i class="icon-user"></i> Akun</a>
                    <a href="#" class="dropdown-item"><i class="icon-cog5"></i> Web Setting</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.auth.signout') }}" class="dropdown-item"><i class="icon-switch2"></i> 
                        @lang('button.signout')
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->

<!-- Page content -->
<div class="page-content">