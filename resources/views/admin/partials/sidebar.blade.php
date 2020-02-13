<div class="air__menuLeft">
    <div class="air__menuLeft__outer">
        <div class="air__menuLeft__mobileToggleButton air__menuLeft__mobileActionToggle">
            <span></span>
        </div>
        <div class="air__menuLeft__toggleButton air__menuLeft__actionToggle">
            <span></span>
            <span></span>
        </div>
        <a href="javascript: void(0);" class="air__menuLeft__logo">
            <img src="{{ asset('admin/components/core/img/shiza-logo.png') }}" alt="<?php echo env('APP_NAME') ?>" />
            <div class="air__menuLeft__logo__name">Shiza.Id</div>
            <div class="air__menuLeft__logo__descr">Administrator</div>
        </a>
        <a href="javascript: void(0);" class="air__menuLeft__user">
            <div class="air__menuLeft__user__avatar">
            
            <img src="{{ asset('admin/components/core/img/avatars/avatar.png') }}" alt="David Beckham" />
            </div>
            <div class="air__menuLeft__user__name">
            David Beckham
            </div>
            <div class="air__menuLeft__user__role">
            Administrator
            </div>
        </a>

        <!-- Sidebar menu start here -->
        <div class="air__menuLeft__container air__customScroll">

            <ul class="air__menuLeft__list">

                <li class="air__menuLeft__category"><span>Main Menu</span></li>

                <li class="air__menuLeft__item">
                    <a href="javascript: void(0)" class="air__menuLeft__link air__sidebar__actionToggle">
                    <i class="fe fe-home air__menuLeft__icon"></i>
                    <span>Dashboard</span>
                    </a>
                </li>

                <li class="air__menuLeft__item">
                    <a href="{{ route('admin.auth.signout') }}" class="air__menuLeft__link air__sidebar__actionToggle">
                    <i class="fe fe-log-out air__menuLeft__icon"></i>
                    <span>@lang('button.signout')</span>
                    </a>
                </li>
            
            </ul>

        </div>
        <!-- Sidebar menu end here -->
    </div>
</div>





<?php /*
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
    */ ?>