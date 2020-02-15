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
		$field = "komenId,komenPenulis,komenIsi,komenEmail,komenTimestamp";
		$table = "komentar";
		$where = "komenApproved='0'";
		
		return $this->CI->env_model->view_where_order_limit($field, $table, $where, "komenId", "DESC", $limit);
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
                    $menu_li_active_expand = " nav-item-expanded nav-item-open";
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
                    $menu_li_active = " active"; 
                }                    
            }

            $numnumMenu2 = $this->CI->Adminenv_model->rowsAdminMenuData($dm1['levelId'],$dm1['menuId']);
        ?>
        <li class="nav-item<?php echo (($numnumMenu2 > 0) ? ' nav-item-submenu':'') . $menu_li_active_expand; ?>">
            <a href="<?php echo $menu_url; ?>" class="nav-link<?php echo $menu_li_active . (!empty($dm1['menuAttrClass']) ? ' '.$dm1['menuAttrClass']:''); ?>">
                <?php if($dm1['menuIcon']!='') { echo "<i class=\"{$dm1['menuIcon']}\"></i>"; } else { echo "<i class=\"icon-cog4\"></i>"; } ?> <span><?php echo $dm1['menuName']; ?></span>
            </a>
            <?php
                if($numnumMenu2>0){
                    echo "<ul class=\"nav nav-group-sub\" data-submenu-title=\"{$dm1['menuName']}\">";
                    
                    $menudata2 = $this->CI->Adminenv_model->getAdminMenuData($dm1['levelId'], $dm1['menuId']);
                    foreach ($menudata2 as $dm2) {

                        $menu_a_active2 = '';
            			$menu_a_active_expand2 = '';

                        if(empty($dm2['menuAccess'])){ 
                            $menu_url2 = "javascript:void(0)";
                            // check menu child
                            if( is_adminmenuchild_active($dm2['menuId']) ){
                                $menu_a_active_expand2 = " nav-item-expanded nav-item-open";
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
                                $menu_a_active2 = " active";
                            } 
                        }

                        $numnumMenu3 = $this->CI->Adminenv_model->rowsAdminMenuData($dm1['levelId'],$dm2['menuId']);

                        echo "<li class=\"nav-item".(($numnumMenu3 > 0) ? ' nav-item-submenu':'') . $menu_a_active_expand2."\">";
                        echo "<a href=\"{$menu_url2}\" class=\"nav-link".$menu_a_active2 . (!empty($dm2['menuAttrClass']) ? ' '.$dm2['menuAttrClass']:'') . "\">".$dm2['menuName']."</a>";

                        if($numnumMenu3>0){
                        	echo "<ul class=\"nav nav-group-sub\" data-submenu-title=\"{$dm2['menuName']}\">";

                        	$menudata3 = $this->CI->Adminenv_model->getAdminMenuData($dm1['levelId'], $dm2['menuId']);
                        	foreach ($menudata3 as $dm3) {

                                $menu_a_active3 = '';
            					$menu_a_active_expand3 = '';

                                if(empty($dm3['menuAccess'])){ 
                                    $menu_url3 = "javascript:void(0)";
                                    // check menu child
                                    if( is_adminmenuchild_active($dm3['menuId']) ){
                                        $menu_a_active_expand3 = " nav-item-expanded nav-item-open";
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
                                        $menu_a_active3 = " active";
                                    }
                                }

                                $numnumMenu4 = $this->CI->Adminenv_model->rowsAdminMenuData($dm1['levelId'],$dm3['menuId']);

                                echo "<li class=\"nav-item".(($numnumMenu4 > 0) ? ' nav-item-submenu':'') . $menu_a_active_expand3."\">";
                                echo "<a href=\"{$menu_url3}\" class=\"nav-link".$menu_a_active3 . (!empty($dm3['menuAttrClass']) ? ' '.$dm3['menuAttrClass']:'')."\">".$dm3['menuName']."</a>";

                                if($numnumMenu4>0){
                        			echo "<ul class=\"nav nav-group-sub\" data-submenu-title=\"{$dm3['menuName']}\">";

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
                                                $menu_a_active4 = " active";
                                            }
                                        }

                                        echo "<li class=\"nav-item><a href=\"{$menu_url4}\" class=\"nav-link" . (!empty($dm4['menuAttrClass']) ? ' '.$dm4['menuAttrClass']:'')."\">".$dm4['menuName']."</a></li>";

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
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>
                <?php 
                if( empty($title_page_icon) ){ 
                    if(!empty($getmenu['menuIcon'])){
                        echo '<i class="'.$getmenu['menuIcon'].' mr-2"></i>';
                    }                   
                } else { 
                    echo '<i class="icon-arrow-left52 mr-2"></i>'; 
                }
                ?>
                <span class="font-weight-semibold"><?php echo empty($title_page)? $getmenu['menuName']:$title_page; ?></span><?php echo empty($title_page_secondary)?'':' - '.$title_page_secondary; ?></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <?php
                    if( count($header_button_action) > 0){
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
                                    echo '<a href="'.$btn_v['access'].'" class="btn btn-link btn-float text-default"><i class="';
                                    if(empty($btn_v['icon'])){ echo 'icon-menu7'; } else { echo $btn_v['icon']; } 
                                    echo ' text-primary"></i><span>'.$btn_v['title'].'</span></a>';
                                }
                            } else {
                                echo '<a href="'.$btn_v['access'].'" class="btn btn-link btn-float text-default"><i class="';
                                if(empty($btn_v['icon'])){ echo 'icon-menu7'; } else { echo $btn_v['icon']; } 
                                echo ' text-primary"></i><span>'.$btn_v['title'].'</span></a>';
                            }

                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php }
    }

    public function adminBreadcrumb(){
        $querymodule = $this->CI->uri->segment(2);

        echo '<a href="'.admin_url().'" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>';

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