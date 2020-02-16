<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
            <img src="<?php echo admin_assets('components/core/img/shiza-logo.png'); ?>" alt="Ecoza" />
            <div class="air__menuLeft__logo__name">Shiza.Id</div>
            <div class="air__menuLeft__logo__descr">Administrator</div>
        </a>
        
        <?php
        $admindata = $CI->adminenv->adminData();
        if( !empty($admindata['userDir']) AND !empty($admindata['userPic']) ){
            $imgadmin = images_url($admindata['userDir'].'/xsmall_'.$admindata['userPic']);
        } else {
            $imgadmin = admin_assets('components/core/img/avatars/avatar.png');
        }
        ?>
        <a href="javascript: void(0);" class="air__menuLeft__user">
            <div class="air__menuLeft__user__avatar">
            
            <img src="<?php echo $imgadmin; ?>" style="width:42px;height:42px;" alt="<?php echo $admindata['userDisplayName']; ?>" />
            </div>
            <div class="air__menuLeft__user__name">
            <?php echo $admindata['userDisplayName']; ?>
            </div>
            <div class="air__menuLeft__user__role">
            <?php echo $admindata['userEmail']; ?>
            </div>
        </a>

        <!-- Sidebar menu start here -->
        <div class="air__menuLeft__container air__customScroll">

            <ul class="air__menuLeft__list">

                <li class="air__menuLeft__category"><span>Main Menu</span></li>

                <li class="air__menuLeft__item<?php if ($CI->uri->segment(2)=='dashboard'){ echo "--active"; } ?>">
                    <a href="<?php echo admin_url('dashboard'); ?>" class="air__menuLeft__link air__sidebar__actionToggle">
                        <i class="fe fe-home air__menuLeft__icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <?php $CI->adminenv->admin_menu_item(); ?>

                <li class="air__menuLeft__item">
                    <a href="<?php echo admin_url('main/logout'); ?>" class="air__menuLeft__link air__sidebar__actionToggle">
                    <i class="fe fe-log-out air__menuLeft__icon"></i>
                    <span>Sign Out</span>
                    </a>
                </li>
            
            </ul>

        </div>
        <!-- Sidebar menu end here -->
    </div>
</div>