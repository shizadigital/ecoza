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
                    @php
                        $imgadmin = 'http://placehold.it/200x200';
                    @endphp
                    <div class="mr-3">
                        <img src="{{ $imgadmin }}" width="38" height="38" class="rounded-circle" alt="Admin">
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">Admin</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-mail5 font-size-sm"></i> &nbsp;Admin
                        </div>
                    </div>

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
                    <a href="#" class="nav-link active">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.auth.signout') }}" class="nav-link">
                        <i class="icon-switch2"></i>
                        <span>
                            @lang('button.signout')
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

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    @yield('breadcrumb')
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->
    

    <!-- Content area -->
    <div class="content">