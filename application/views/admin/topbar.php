<div class="air__layout">

    <div class="air__layout__header">
        <div class="air__utils__header">
            <div class="air__topbar">
            
                <div class="dropdown mr-auto d-none d-md-block">
                    <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15" >
                        <i class="dropdown-toggle-icon fe fe-bookmark"></i>
                        <span class="dropdown-toggle-text"><?php echo t('quickaccess'); ?></span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="<?php echo admin_url('product/addnew'); ?>"><i class="fe fe-plus"></i> <?php echo t('newproduct'); ?></a>
                        <a class="dropdown-item" href="<?php echo admin_url('product_categories'); ?>"><i class="fe fe-plus"></i> <?php echo t('newproductcategory'); ?></a>
                        <?php
                        if( $this->session->userdata('leveluser') =='1' ){
                            echo '
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-header">Super Admin Mode</div>
                            <a class="dropdown-item" href="'.admin_url('menu_admin_master/tambah').'"><i class="fe fe-plus"></i> '.t('addnewmenuadminmaster').'</a>
                            <a class="dropdown-item" href="'.admin_url('menu_admin_privilage').'"><i class="fe fe-user-check"></i> '.t('menuadminprivilege').'</a>
                            <a class="dropdown-item" href="'.admin_url('main/iconscomponent/?theval=feather').'" target="_blank"><i class="fe fe-grid"></i> '.t('looktheicon').'</a>';
                        }
                        ?>
                    </div>
                </div>

                <p class="mb-0 mr-4 d-xl-block d-none">
                    Status <?php echo get_adm_ol_status(); ?> 
                </p>
                
                <?php if(count(langlist())>1): ?>
                <div class="dropdown mr-4 d-none d-sm-block">
                    <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" data-offset="5,15">
                        <span class="dropdown-toggle-text"><?php echo strtoupper(getAdminLocaleCode(false)); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php
                        foreach( langlist() AS $lv ){

                            echo '
                            <a class="dropdown-item';
                            if($lv == getAdminLocaleCode()) { 
                                echo ' bg-primary text-white';
                            } 
                            echo '" href="';

                            if( $lv == getAdminLocaleCode() ) {
                                echo 'javascript:void(0)';
                            } else {
                                echo base_url('setlang/setadminlang/'.$lv);
                            }

                            $shortname = explode("_", $lv)[0];
                            $countryName = locales($lv);

                            echo '">
                                <span class="text-uppercase font-size-12 mr-1 align-text-bottom">'.strtoupper($shortname).'</span>
                                '.$countryName.'
                            </a>
                            ';
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="air__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
                    <?php
                    $totalcomments = countdata("comments","commentApproved='0'");
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
                            <?php echo t('viewtheweb'); ?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">
                            Admin
                        </div>
                        <a class="dropdown-item" href="<?php echo admin_url('manage_users/edit/'.$CI->session->userdata('adminid') ); ?>">
                            <i class="dropdown-icon fe fe-user"></i>
                            <?php echo t('myaccount'); ?>
                        </a>
                        <a class="dropdown-item" href="<?php echo admin_url('atur_web'); ?>">
                            <i class="dropdown-icon fe fe-settings"></i>
                            <?php echo t('websetting'); ?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo admin_url('main/logout'); ?>">
                            <i class="dropdown-icon fe fe-log-out"></i> <?php echo t('signout'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php 
            $page_header_on = empty($page_header_on)? false:$page_header_on;
            $optheader = array(
                'title_page' => empty($title_page) ? '':$title_page,
                'title_page_icon' => empty($title_page_icon) ? '':$title_page_icon,
                'title_page_secondary' => empty($title_page_secondary) ? '':$title_page_secondary,
                'header_button_action' => empty($header_button_action) ? array():$header_button_action
            );
            $CI->adminenv->adminPageHeader( $page_header_on, $optheader );
            ?>
            
        </div>
    </div>
    
    <!-- Start content here -->
    <div class="air__layout__content">
        <div class="air__utils__content">
            <?php 
            $breadcrumb = empty($breadcrumb)? false:$breadcrumb;
            if($breadcrumb){
            ?>
                <nav aria-label="breadcrumb">
                    <?php $CI->adminenv->adminBreadcrumb(); ?>
                </nav>
            <?php
            }
            ?>