<div class="air__layout">

    <div class="air__layout__header">
        <div class="air__utils__header">
            <div class="air__topbar">
            
                <div class="dropdown mr-auto d-none d-md-block">
                    <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15" >
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
                    Status <?php echo get_adm_ol_status(); ?> 
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
                    <?php
                    $totalcomments = countdata("komentar","komenApproved='0'");
                    ?>
                    <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
                        <i class="dropdown-toggle-icon fe fe-message-square"></i>
                        <span class="dropdown-toggle-text">Comments (<?php if($totalcomments > 0){ echo $totalcomments; } else { echo 0; } ?>)</span>
                    </a>
                    <?php if($totalcomments > 0){ ?>
                    <div class="air__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
                    
                        <div class="card-body">
                            <div class="height-300 air__customScroll">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-alert-content" role="tabpanel" aria-labelledby="tab-alert-content">
                                    <ul class="width-250 list-unstyled">
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
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="dropdown">
                    <?php
                    $admindata = $CI->adminenv->adminData();

                    if( !empty($admindata['userDir']) AND !empty($admindata['userPic']) ){
                        $imgadmin = images_url($admindata['userDir'].'/xsmall_'.$admindata['userPic']);
                    } else {
                        $imgadmin = admin_assets('components/core/img/avatars/avatar-2.png');
                    }
                    ?>
                    <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
                        <img class="dropdown-toggle-avatar" style="width:40px;height:40px;" src="<?php echo $imgadmin; ?>" alt="<?php echo $admindata['userDisplayName']; ?>" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>" target="_blank">
                            <i class="dropdown-icon fe fe-globe"></i>
                            Lihat Website
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">
                            Admin
                        </div>
                        <a class="dropdown-item" href="<?php echo admin_url('manage_users/edit/'.$CI->session->userdata('adminid') ); ?>">
                            <i class="dropdown-icon fe fe-user"></i>
                            Akun
                        </a>
                        <a class="dropdown-item" href="<?php echo admin_url('atur_web'); ?>">
                            <i class="dropdown-icon fe fe-settings"></i>
                            Web Setting
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo admin_url('main/logout'); ?>">
                            <i class="dropdown-icon fe fe-log-out"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>

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
            
        </div>
    </div>
    
    <!-- Start content here -->
    <div class="air__layout__content">
        <div class="air__utils__content">

            <div class="breadcrumb">
                <?php $CI->adminenv->adminBreadcrumb(); ?>
            </div>