<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminEnv {
	protected $CI;

	public function __construct(){
        $this->CI =& get_instance();

        // load helper function
        $this->CI->load->helper('functions');
        $this->CI->load->helper('admin_functions');
	}

	public function topBarComments($limit = 20){
		$field = "commentId,commentAuthor,commentComment,commentEmail,commentTimestamp";
		$table = "comments";
		$where = "commentApproved='0'";
		
		return $this->CI->env_model->view_where_order_limit($field, $table, $where, "commentId", "DESC", $limit);
	}

	public function adminData(){
		$adminID = $this->CI->session->userdata('adminid');

		return $data = getval("*","users","userId='{$adminID}'");
	}

	// menu admin
    public function admin_menu_item(){
		$LevelID = $this->CI->session->userdata('leveluser');

    	$menudata1 = $this->CI->Adminenv_model->getAdminMenuData($LevelID,0);

        foreach ($menudata1 as $dm1) {

            $menu_li_active = '';
            $menu_li_active_expand = '';

            if(empty($dm1['menuAccess'])){ 
                $menu_url = "javascript:void(0)";

                // check menu child
                if( is_adminmenuchild_active($dm1['menuId']) ){
                    $menu_li_active_expand = "--active";
                }
            } else {
                $array_access = unserialize($dm1['menuAccess']);
                if(array_key_exists('admin_link', $array_access)){ 
                    $exp_access = explode('&', $array_access['admin_link']);
                    $url_access = admin_url()."/".$array_access['admin_link']; 
                } else {
                    $exp_access[0] = '';
                    $url_access = $array_access['out_link']."\" target=\"_blank\" rel=\"nofollow";
                }
                $menu_url = $url_access;
                if ( $this->CI->uri->segment(2) == $exp_access[0]){ 
                    $menu_li_active = "--active"; 
                }                    
            }

            $numnumMenu2 = $this->CI->Adminenv_model->rowsAdminMenuData($dm1['levelId'],$dm1['menuId']);
        ?>
        <li class="air__menuLeft__item<?php echo $menu_li_active . (($numnumMenu2 > 0) ? ' air__menuLeft__submenu':'') . $menu_li_active_expand; ?>">
            <a href="<?php echo $menu_url; ?>" class="air__menuLeft__link<?php echo (!empty($dm1['menuAttrClass']) ? ' '.$dm1['menuAttrClass']:''); ?>">
                <i class="air__menuLeft__icon <?php if($dm1['menuIcon']!='') { echo $dm1['menuIcon']; } else { echo "fe fe-more-horizontal"; } ?>"></i>
                <span><?php echo $dm1['menuName']; ?></span>
            </a>
            <?php
                if($numnumMenu2>0){
                    echo "<ul class=\"air__menuLeft__list\">";
                    
                    $menudata2 = $this->CI->Adminenv_model->getAdminMenuData($dm1['levelId'], $dm1['menuId']);
                    foreach ($menudata2 as $dm2) {

                        $menu_a_active2 = '';
            			$menu_a_active_expand2 = '';

                        if(empty($dm2['menuAccess'])){ 
                            $menu_url2 = "javascript:void(0)";
                            // check menu child
                            if( is_adminmenuchild_active($dm2['menuId']) ){
                                $menu_a_active_expand2 = "--active";
                            }
                        } else {
                            $array_access2 = unserialize($dm2['menuAccess']);
                            if(array_key_exists('admin_link', $array_access2)){ 
                                $exp_access2 = explode('&', $array_access2['admin_link']);
                                $url_access2 = admin_url()."/".$array_access2['admin_link']; 
                            } else {
                                $exp_access2[0] = '';
                                $url_access2 = $array_access2['out_link']."\" target=\"_blank\" rel=\"nofollow";
                            }
                            $menu_url2 = $url_access2;
                            if ($this->CI->uri->segment(2)==$exp_access2[0]){ 
                                $menu_a_active2 = "--active";
                            } 
                        }

                        $numnumMenu3 = $this->CI->Adminenv_model->rowsAdminMenuData($dm1['levelId'],$dm2['menuId']);

                        echo "<li class=\"air__menuLeft__item".$menu_a_active2 . (($numnumMenu3 > 0) ? ' air__menuLeft__submenu':'') . $menu_a_active_expand2."\">";
                        echo "<a href=\"{$menu_url2}\" class=\"air__menuLeft__link".(!empty($dm2['menuAttrClass']) ? ' '.$dm2['menuAttrClass']:'') . "\"><span>".$dm2['menuName']."</span></a>";

                        if($numnumMenu3>0){
                        	echo "<ul class=\"air__menuLeft__list\">";

                        	$menudata3 = $this->CI->Adminenv_model->getAdminMenuData($dm1['levelId'], $dm2['menuId']);
                        	foreach ($menudata3 as $dm3) {

                                $menu_a_active3 = '';
            					$menu_a_active_expand3 = '';

                                if(empty($dm3['menuAccess'])){ 
                                    $menu_url3 = "javascript:void(0)";
                                    // check menu child
                                    if( is_adminmenuchild_active($dm3['menuId']) ){
                                        $menu_a_active_expand3 = "--active";
                                    }                                        
                                } else {
                                    $array_access3 = unserialize($dm3['menuAccess']);
                                    if(array_key_exists('admin_link', $array_access3)){ 
                                        $exp_access3 = explode('&', $array_access3['admin_link']);
                                        $url_access3 = admin_url()."/".$array_access3['admin_link']; 
                                    } else {
                                        $exp_access3[0] ='';
                                        $url_access3 = $array_access3['out_link']."\" target=\"_blank\" rel=\"nofollow";
                                    }
                                    $menu_url3 = $url_access3;
                                    if ($this->CI->uri->segment(2)==$exp_access3[0]){  
                                        $menu_a_active3 = "--active";
                                    }
                                }

                                $numnumMenu4 = $this->CI->Adminenv_model->rowsAdminMenuData($dm1['levelId'],$dm3['menuId']);

                                echo "<li class=\"air__menuLeft__item".$menu_a_active3 . (($numnumMenu4 > 0) ? ' air__menuLeft__submenu':'') . $menu_a_active_expand3."\">";
                                echo "<a href=\"{$menu_url3}\" class=\"air__menuLeft__link".(!empty($dm3['menuAttrClass']) ? ' '.$dm3['menuAttrClass']:'')."\"><span>".$dm3['menuName']."</span></a>";

                                if($numnumMenu4>0){
                        			echo "<ul class=\"air__menuLeft__list\">";

                        			$menudata4 = $this->CI->Adminenv_model->getAdminMenuData($dm1['levelId'], $dm3['menuId']);
                        			foreach ($menudata4 as $dm4) {

                                        $menu_a_active4 = '';

                                        if(empty($dm4['menuAccess'])){ 
                                            $menu_url4 = "javascript:void(0)";
                                        } else {
                                            $array_access4 = unserialize($dm4['menuAccess']);
                                            if(array_key_exists('admin_link', $array_access4)){
                                                $exp_access4 = explode('&', $array_access4['admin_link']);
                                                $url_access4 = admin_url()."/".$array_access4['admin_link']; 
                                            } else {
                                                $exp_access4[0] ='';
                                                $url_access4 = $array_access4['out_link']."\" target=\"_blank\" rel=\"nofollow";
                                            }
                                            $menu_url4 = $url_access4;
                                            if ($this->CI->uri->segment(2)==$exp_access4[0]){  
                                                $menu_a_active4 = "--active";
                                            }
                                        }

                                        echo "<li class=\"air__menuLeft__item".$menu_a_active4."\"><a href=\"{$menu_url4}\" class=\"nav-link" . (!empty($dm4['menuAttrClass']) ? ' '.$dm4['menuAttrClass']:'')."\">".$dm4['menuName']."</a></li>";

                                    } // END while $dm4
                                    echo "</ul>";
                                }
                                echo "</li>";
                            } // END while $dm3
                            echo "</ul>";
                        }
                        echo "</li>"; 
                    } // END while $dm2
                echo "</ul>";
                }
            ?>
        </li>
        <?php
        } // END while $dm1
    }

    public function adminPageHeader( $page_header_on = false, $optvar ){
        if( $page_header_on == true ){
            $title_page =  empty($optvar['title_page']) ? '':$optvar['title_page'];
            $title_page_icon = empty($optvar['title_page_icon']) ? '':$optvar['title_page_icon'];
            $title_page_secondary = empty($optvar['title_page_secondary']) ? '':$optvar['title_page_secondary'];
            $header_button_action = (count($optvar['header_button_action'])>0) ? $optvar['header_button_action']:array();

            // get segment
            $querymodule = $this->CI->uri->segment(2);
            $countmod = strlen($querymodule);
            $data = 'a:1:{s:10:"admin_link";s:'.$countmod.':"'.$querymodule.'";}';
            $getmenu = getval("menuId,menuParentId,menuName,menuAccess,menuSort,menuActive,menuIcon","users_menu","menuAccess = '{$data}'");
        ?>
        <div class="air__subbar">
            <ul class="air__subbar__breadcrumbs mr-4">
                <?php if( $this->CI->uri->segment(2) != 'dashboard'): ?>
                <li class="air__subbar__breadcrumb">
                    <a href="<?php echo admin_url(); ?>" class="air__subbar__breadcrumbLink">Dashboard</a>
                </li>
                <?php endif; ?>
                <li class="air__subbar__breadcrumb">
                    <a href="javascript:void(0)" class="air__subbar__breadcrumbLink air__subbar__breadcrumbLink--current">
                    <?php 
                    if( empty($title_page_icon) ){ 
                        if(!empty($getmenu['menuIcon'])){
                            echo '<i class="'.$getmenu['menuIcon'].'"></i> ';
                        }
                    } else { 
                        echo '<i class="'.$title_page_icon.'"></i> ';
                    }
                    
                    echo empty($title_page)? $getmenu['menuName']:$title_page;
                    ?>
                    </a>
                </li>
            </ul>
            <div class="air__subbar__divider mr-4 d-none d-xl-block"></div>
            <?php if(!empty($title_page_secondary)) : ?>
            <p class="color-gray-4 text-uppercase font-size-18 mb-0 mr-4 d-none d-xl-block"><?php echo $title_page_secondary; ?></p>
            <?php endif; ?>            

            <?php
            if( count($header_button_action) > 0){
                echo '<div class="air__subbar__amount mr-3 ml-auto d-none d-sm-flex">';
                foreach ($header_button_action as $btn_v) {
                    if(isset($btn_v['permission'])){

                        $permission = false;
                        if($btn_v['permission'] == 'view' OR $btn_v['permission'] == 'add' OR $btn_v['permission'] == 'edit' OR $btn_v['permission'] == 'delete'){
                            
                            if($btn_v['permission'] == 'view') { if( is_view() ) $permission = true; }
                            if($btn_v['permission'] == 'add') { if( is_add() ) $permission = true; }
                            if($btn_v['permission'] == 'edit') { if( is_edit() ) $permission = true; }
                            if($btn_v['permission'] == 'delete') { if( is_delete() ) $permission = true; }
                        }

                        if($permission == true){
                            echo '<a href="'.$btn_v['access'].'" class="btn btn-secondary btn-with-addon ml-2 mr-auto text-nowrap d-none d-md-block"><span class="btn-addon"><i class="btn-addon-icon ';
                            if(empty($btn_v['icon'])){ echo 'fe fe-menu'; } else { echo $btn_v['icon']; } 
                            echo '"></i></span> '.$btn_v['title'].'</a>';
                        }
                    } else {
                        echo '<a href="'.$btn_v['access'].'" class="btn btn-secondary btn-with-addon ml-2 mr-auto text-nowrap d-none d-md-block"><span class="btn-addon"><i class="btn-addon-icon ';
                        if(empty($btn_v['icon'])){ echo 'fe fe-menu'; } else { echo $btn_v['icon']; } 
                        echo '"></i></span>'.$btn_v['title'].'</a>';
                    }

                }
                echo '</div>';
            }
            ?>
                            
        </div>
        <?php }
    }

    public function adminBreadcrumb(){
        $querymodule = $this->CI->uri->segment(2);

        echo '<a href="'.admin_url().'" class="breadcrumb-item"><i class="fe fe-home"></i> Dashboard</a>';

        if( !empty( $querymodule ) ){
            $countmod = strlen($querymodule);
            $data = 'a:1:{s:10:"admin_link";s:'.$countmod.':"'.$querymodule.'";}';

            //count have parent
            $count1 = countdata( "users_menu","menuAccess = '{$data}'");
            if($count1 > 0){
                $getmenu1 = getval("menuId,menuParentId,menuName,menuAccess,menuSort,menuActive,menuIcon","users_menu","menuAccess = '{$data}'");

                if($getmenu1['menuParentId'] != 0){
                    $array_access1 = unserialize($getmenu1['menuAccess']);
                    $url1 = ( empty($getmenu1['menuAccess']) ) ? '':admin_url($array_access1['admin_link']);

                    $getmenu2 = getval("menuId,menuParentId,menuName,menuAccess,menuSort,menuActive,menuIcon","users_menu","menuId = '{$getmenu1['menuParentId']}'");

                    if($getmenu2['menuParentId'] != 0){
                        $array_access2 = unserialize($getmenu2['menuAccess']);
                        $url2 = ( empty($getmenu2['menuAccess']) ) ? '':admin_url($array_access2['admin_link']);

                        $getmenu3 = getval("menuId,menuParentId,menuName,menuAccess,menuSort,menuActive,menuIcon","users_menu","menuId = '{$getmenu2['menuParentId']}'");

                        if($getmenu3['menuParentId'] != 0){
                            $array_access3 = unserialize($getmenu3['menuAccess']);
                            $url3 = ( empty($getmenu3['menuAccess']) ) ? '':admin_url($array_access3['admin_link']);

                            $getmenu4 = getval("menuId,menuParentId,menuName,menuAccess,menuSort,menuActive,menuIcon","users_menu","menuId = '{$getmenu3['menuParentId']}'");

                            echo '<span class="breadcrumb-item active">'.$getmenu4['menuName'].'</span>';

                        }
                        echo '<span class="breadcrumb-item active">'.$getmenu3['menuName'].'</span>';

                    }
                    echo '<span class="breadcrumb-item active">'.$getmenu2['menuName'].'</span>';

                }                 
                echo '<span class="breadcrumb-item active">'.$getmenu1['menuName'].'</span>';
            }

        }
    }
}