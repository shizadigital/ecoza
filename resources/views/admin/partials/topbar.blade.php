<div class="air__layout">

    <div class="air__layout__header">
        <div class="air__utils__header">
            <div class="air__topbar">
            
                <div class="dropdown mr-auto d-none d-md-block">
                    <a
                    href=""
                    class="dropdown-toggle text-nowrap"
                    data-toggle="dropdown"
                    aria-expanded="false"
                    data-offset="0,15"
                    >
                        <i class="dropdown-toggle-icon fe fe-book-open"></i>
                        <span class="dropdown-toggle-text">Issues History</span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <div class="dropdown-header">Active</div>
                        <a class="dropdown-item" href="javascript:void(0)">Project Management</a>
                        <a class="dropdown-item" href="javascript:void(0)">User Inetrface Development</a>
                        <a class="dropdown-item" href="javascript:void(0)">Documentation</a>

                        <div class="dropdown-header">Inactive</div>
                        <a class="dropdown-item" href="javascript:void(0)">Marketing</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-settings"></i>
                            Settings
                        </a>
                    </div>
                </div>
                <p class="mb-0 mr-4 d-xl-block d-none">
                    Status
                    <span class="ml-1 badge bg-success text-white font-size-12 text-uppercase air__topbar__status"
                    >Online</span>
                </p>
                <div class="dropdown mr-4 d-none d-sm-block">
                    <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" data-offset="5,15">
                    <span class="dropdown-toggle-text">EN</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)"
                        ><span class="text-uppercase font-size-12 mr-1 align-text-bottom">EN</span> English</a
                    >
                    <a class="dropdown-item" href="javascript:void(0)"
                        ><span class="text-uppercase font-size-12 mr-1 align-text-bottom">RU</span> Русский</a
                    >
                    <a class="dropdown-item" href="javascript:void(0)"
                        ><span class="text-uppercase font-size-12 mr-1 align-text-bottom">CN</span> 简体中文</a
                    >
                    </div>
                </div>
                <div class="air__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
                    <a
                    href=""
                    class="dropdown-toggle text-nowrap"
                    data-toggle="dropdown"
                    aria-expanded="false"
                    data-offset="0,15"
                    >
                        <i class="dropdown-toggle-icon fe fe-message-square"></i>
                        <span class="dropdown-toggle-text">Comments</span>
                    </a>
                    <div class="air__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
                    
                    <div class="card-body">
                        <div class="height-300 air__customScroll">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-alert-content" role="tabpanel" aria-labelledby="tab-alert-content">
                                <ul class="width-250 list-unstyled">
                                    <li class="mb-3">
                                        <div class="air__l2__head">
                                            <p class="air__l2__title">
                                            Update Status:
                                            <strong class="text-black">New</strong>
                                            </p>
                                            <time class="air__l2__time">5 min ago</time>
                                        </div>
                                        <p class="air__l2__content">
                                            Mary has approved your quote.
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="air__l2__head">
                                            <p class="air__l2__title">
                                            Update Status:
                                            <strong class="text-danger">Rejected</strong>
                                            </p>
                                            <time class="air__l2__time">15 min ago</time>
                                        </div>
                                        <p class="air__l2__content">
                                            Mary has declined your quote.
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="air__l2__head">
                                            <p class="air__l2__title">
                                            Payment Received:
                                            <strong class="text-black">$5,467.00</strong>
                                            </p>
                                            <time class="air__l2__time">15 min ago</time>
                                        </div>
                                        <p class="air__l2__content">
                                            GOOGLE, LLC AUTOMATED PAYMENTS
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="air__l2__head">
                                            <p class="air__l2__title">
                                            Notification:
                                            <strong class="text-danger">Access Denied</strong>
                                            </p>
                                            <time class="air__l2__time">5 Hours ago</time>
                                        </div>
                                        <p class="air__l2__content">
                                            The system prevent login to your account
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="air__l2__head">
                                            <p class="air__l2__title">
                                            Payment Received:
                                            <strong class="text-black">$55,829.00</strong>
                                            </p>
                                            <time class="air__l2__time">1 day ago</time>
                                        </div>
                                        <p class="air__l2__content">
                                            GOOGLE, LLC AUTOMATED PAYMENTS
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="air__l2__head">
                                            <p class="air__l2__title">
                                            Notification:
                                            <strong class="text-danger">Access Denied</strong>
                                            </p>
                                            <time class="air__l2__time">5 Hours ago</time>
                                        </div>
                                        <p class="air__l2__content">
                                            The system prevent login to your account
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
                        <?php
                            $imgAdmin = 'http://placehold.it/90x90';
                        ?>
                        <img class="dropdown-toggle-avatar" src="{{ asset('admin/components/core/img/avatars/avatar-2.png') }}" alt="User avatar" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item" href="{{ URL::to('/') }}" target="_blank">
                            <i class="dropdown-icon fe fe-globe"></i>
                            Lihat Website
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">
                            Admin
                        </div>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-user"></i>
                            Akun
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-settings"></i>
                            Web Setting
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.auth.signout') }}">
                            <i class="dropdown-icon fe fe-log-out"></i> @lang('button.signout')
                        </a>
                    </div>
                </div>
            </div>

            
                <div class="air__subbar">
                <ul class="air__subbar__breadcrumbs mr-4">
                    <li class="air__subbar__breadcrumb">
                    <a href="#" class="air__subbar__breadcrumbLink">Main</a>
                    </li>
                    <li class="air__subbar__breadcrumb">
                    <a href="#" class="air__subbar__breadcrumbLink air__subbar__breadcrumbLink--current"
                        >Dashboard</a
                    >
                    </li>
                </ul>
                <div class="air__subbar__divider mr-4 d-none d-xl-block"></div>
                <p class="color-gray-4 text-uppercase font-size-18 mb-0 mr-4 d-none d-xl-block">INV-00125</p>
                <button class="btn btn-primary btn-with-addon mr-auto text-nowrap d-none d-md-block">
                    <span class="btn-addon">
                    <i class="btn-addon-icon fe fe-plus-circle"></i>
                    </span>
                    New Request
                </button>
                <div class="air__subbar__amount mr-3 ml-auto d-none d-sm-flex">
                    <p class="air__subbar__amountText">
                    This month
                    <span class="air__subbar__amountValue">$251.12</span>
                    </p>
                    <div class="air__subbar__amountGraph">
                    <i class="air__subbar__amountGraphItem" style="height: 80%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 50%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 70%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 60%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 50%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 65%"></i>
                    </div>
                </div>
                <div class="air__subbar__amount d-none d-sm-flex">
                    <p class="air__subbar__amountText">
                    Last month
                    <span class="air__subbar__amountValue">$12,256.12</span>
                    </p>
                    <div class="air__subbar__amountGraph">
                    <i class="air__subbar__amountGraphItem" style="height: 60%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 65%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 75%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 55%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 100%"></i>
                    <i class="air__subbar__amountGraphItem" style="height: 85%"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start content here -->
    <div class="air__layout__content">
        <div class="air__utils__content">