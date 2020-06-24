<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
    }
    
    protected function drawMenu($groupId, $data=array(), $listParentMenu = null, $submenulevel = 1, $lastulkeylevel = 1, $lastlikeylevel = 1){
        $result = '';

		// check sub menu
		if($submenulevel <= WEBMENUDEEPLIMIT){

			$tablemenu = array('website_menu a', 'category_relationship b');

			$where = '';
			if($listParentMenu == null){
				$where .= "a.menuParentId = '0' AND ";
			} else {
				$where .= "a.menuParentId = '{$listParentMenu}' AND a.menuParentId != '0' AND ";
			}

			$where .= "a.menuActive='y' AND b.relatedId = a.menuId AND b.crelRelatedType = 'webmenu' AND b.catId = '{$groupId}' AND a.storeId='".storeId()."'";

			$countmenuavailabel = countdata($tablemenu, $where);

            
			if($countmenuavailabel > 0){

                $menudata = $this->CI->Env_model->view_where_order("a.*", $tablemenu, $where,'a.menuSort','ASC');

                // identify ul array
                if( isset($data['openingtag'][$submenulevel]) ){
                    $ulkeylevel = $submenulevel;
                } else {
                    $ulkeylevel = $lastulkeylevel;
                }

                // identify li array
                if( isset($data['listingtag'][$submenulevel]) ){
                    $likeylevel = $submenulevel;
                } else {
                    $likeylevel = $lastlikeylevel;
                }
                
                $result .= '<'. $data['openingtag'][$ulkeylevel]['tag'];

                if(isset($data['openingtag'][$ulkeylevel]['attr'])){
                        
                    if(!empty($data['openingtag'][$ulkeylevel]['attr']['class'])){
                        $result .= ' class="'.$data['openingtag'][$ulkeylevel]['attr']['class'].'"';
                    }

                    foreach(array_filter($data['openingtag'][$ulkeylevel]['attr']) as $ftag => $fval){
                        if( $ftag == 'class'){ continue; }

                        $result .= ' '.$ftag.'="'.$fval.'"';
                    }
                }

                $result .= '>'."\n";

                // convert current url
                $httptype = ( (is_https() OR $_SERVER['SERVER_PORT'] == 443 ) ? "https://" : "http://" );
                $currenturl = str_replace( $httptype, '', current_url() );
                $currenturl = ( substr($currenturl, -1) == '/' ) ? substr($currenturl, 0, -1):$currenturl;
                
				foreach ($menudata AS $pm1) {

                    $menurul = '';
                    if(!empty($pm1['menuUrlAccess'])){
                        $menurul = variable_parser($pm1['menuUrlAccess']);
                        $menurul = str_replace( $httptype, '', $menurul );
                        $menurul = ( substr($menurul, -1) == '/' ) ? substr($menurul, 0, -1):$menurul;
                    }

                    $result .= '<'. $data['listingtag'][$likeylevel]['tag'];

                    $litagposition = isset($data['listingtag']['activeclass']['tagposition'])?$data['listingtag']['activeclass']['tagposition']:'';

                    if(isset($data['listingtag'][$likeylevel]['attr']) OR $litagposition==$data['listingtag'][$likeylevel]['tag']){
                        
                        $classvalue = '';
                        if($menurul == $currenturl AND $litagposition==$data['listingtag'][$likeylevel]['tag']){
                            $classvalue .= $data['listingtag']['activeclass']['class'];
                        }
                        
                        if( !empty($data['listingtag'][$likeylevel]['attr']['class']) ){
                            $classvalue .= ($classvalue=='')?'':' ';
                            $classvalue .= empty($data['listingtag'][$likeylevel]['attr']['class'])?'':' '.$data['listingtag'][$likeylevel]['attr']['class'];
                        }

                        if(!empty($classvalue)){
                            $result .= ' class="';
                            $result .= $classvalue;
                            $result .= '"';
                        }

                        if(isset($data['listingtag'][$likeylevel]['attr'])){
                            foreach(array_filter($data['listingtag'][$likeylevel]['attr']) as $ftag => $fval){
                                if( $ftag == 'class'){ continue; }

                                $result .= ' '.$ftag.'="'.$fval.'"';
                            }
                        }
                        
                    }

                    $result .= '>'."\n";
                    
                    $result .= '<a href="'.(empty($pm1['menuUrlAccess']) ? 'javascript:void(0)':variable_parser($pm1['menuUrlAccess'])).'"';
                    
                    if(isset($data['listingtag'][$likeylevel]['anchor_attr']) OR $litagposition == 'a'){
                            
                        $classvalue = '';
                        if($menurul == $currenturl AND $litagposition == 'a'){
                            $classvalue .= $data['listingtag']['activeclass']['class'];
                        }
                        
                        if( !empty($data['listingtag'][$likeylevel]['anchor_attr']['class']) ){
                            $classvalue .= ($classvalue=='')?'':' ';
                            $classvalue .= empty($data['listingtag'][$likeylevel]['anchor_attr']['class'])?'':' '.$data['listingtag'][$likeylevel]['anchor_attr']['class'];
                        }

                        if(!empty($classvalue)){
                            $result .= ' class="';
                            $result .= $classvalue;
                            $result .= '"';
                        }
                        
                        if(isset($data['listingtag'][$likeylevel]['anchor_attr'])){
                            foreach(array_filter($data['listingtag'][$likeylevel]['anchor_attr']) as $ftag => $fval){
                                if( $ftag == 'class'){ continue; }

                                $result .= ' '.$ftag.'="'.$fval.'"';
                            }
                        }
                        
                    }

                    $result .= '>';
                    $result .= t(array('table'=>'website_menu','field'=>'menuName','id'=>$pm1['menuId']));	
                    
                    if( countdata( 'website_menu', array('menuParentId'=>$pm1['menuId'], 'menuActive'=>'y','storeId'=>storeId() ) )  > 0 ){

                        if( $submenulevel > 1 ){
                            $result .= ' '.$data['listingtag']['subindicator']['submenu'];
                        } else {
                            $result .= ' '.$data['listingtag']['subindicator']['topmenu'];
                        }
                    }
                    
					$result .= "</a>"."\n";

					$nextsubmenu = $submenulevel+1;

					// recursive menu
					$result .= $this->drawMenu($groupId, $data, $pm1['menuId'], $nextsubmenu, $ulkeylevel, $likeylevel);

					$result .= '</'. $data['listingtag'][$likeylevel]['tag']. '>'."\n";
					
                }

                $result .= '</'. $data['openingtag'][$ulkeylevel]['tag'] . '>'."\n";
                
			}
		}

		return $result;
    }

    public function hasMenu( $groupmenu=null ){
        $result = false;

        if($groupmenu == null){
            $groupmenu = getval('catId','categories',array('catType'=>'webmenu', 'catActive'=>'1', 'catDesc'=>'primary'));
        }

        $groupmenu = esc_sql( filter_int($groupmenu) );

        $storeid = storeId();
        $tablecat = array('categories a', 'category_relationship b', 'category_store c');
        $checkgroup = countdata($tablecat,"b.crelRelatedType='webmenu' AND a.catType='webmenu' AND a.catId=b.catId AND a.catId='{$groupmenu}' AND a.catId=c.catId AND c.storeId='{$storeid}'");

        if($checkgroup > 0){
            $result = true;
        }

        return $result;
    }

    public function navMenu($group = null, $menudata = array(), $display = false){

        if( is_array($menudata) AND $group!=null AND $this->hasMenu($group) ){
            
            $themenu = $this->drawMenu(
                $group,
                $menudata,
            );

            if( $display ){
                echo $themenu;
            } else {
                return $themenu;
            }

        }

    }
}