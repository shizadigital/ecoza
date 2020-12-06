<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminenv_model extends CI_model{
    public function getadminonline($id){
        $result = false;
    	$this->db->select('userOnlineStatus');
	    $this->db->from( $this->db->dbprefix('users') );
	    $this->db->where('userId', $id);
	    $query = $this->db->get();
        return $query->row();
    }

    public function updateadminonline($id,$status){
        $updt = array('userOnlineStatus' => $status);
        
    	$this->db->where('userId', filter_int($id));
        return $this->db->update( $this->db->dbprefix('users') , $updt);
    }

    // START check Menu admin children here
    public function AdminMenuChild($id){
        $users_menu = $this->db->dbprefix('users_menu');
        $sqllookchild = "SELECT menuId,menuParentId,menuName,menuType,menuAccess 
                         FROM {$users_menu} 
                         WHERE menuParentId='{$id}' AND menuActive='y' AND menuView='y'
                            UNION SELECT menuId,menuParentId,menuName,menuType,menuAccess 
                                  FROM {$users_menu} WHERE menuParentId IN (
                                        SELECT menuId 
                                        FROM {$users_menu} 
                                        WHERE menuParentId = '{$id}' AND menuActive='y' AND menuView='y'
                                    )";
        $querylookchild = $this->db->query( $sqllookchild );
        return $querylookchild->result_array();
    }

    public function rowAdminMenuChild($id){
        $this->db->select("COUNT(menuId) AS totalMenu");
        $this->db->from( $this->db->dbprefix('users_menu') );
        $this->db->where("menuParentId='{$id}' AND menuActive='y' AND menuView='y'");
        $query = $this->db->get();
        return $query->row()->totalMenu;
    }
    // END check Menu admin children here

    // Menu admin
    public function getAdminMenuData($parent=0){
        $users_menu_access = $this->db->dbprefix('users_menu_access');
        $users_menu = $this->db->dbprefix('users_menu');

        $sqlMenu = "SELECT a.levelId, b.* FROM {$users_menu_access} a, {$users_menu} b 
                            WHERE a.levelId = '{$this->session->userdata('leveluser')}'
                            AND a.menuId = b.menuId
                            AND b.menuActive = 'y'
                            AND b.menuView='y'
                            AND a.lmnView='y'
                            AND b.menuParentId = '{$parent}'";

        if($parent > 0){ $sqlMenu .= " AND b.menuParentId != '0'"; }

        $sqlMenu .= " ORDER BY b.menuSort ASC";

        $queryMenu1 = $this->db->query($sqlMenu);

        return $queryMenu1->result_array();
    }

    // count menu admin
    public function rowsAdminMenuData($parent=0){
        $users_menu_access = $this->db->dbprefix('users_menu_access');
        $users_menu = $this->db->dbprefix('users_menu');

        $sqlMenu = "SELECT a.levelId, b.* FROM {$users_menu_access} a, {$users_menu} b 
                            WHERE a.levelId = '{$this->session->userdata('leveluser')}'
                            AND a.menuId = b.menuId
                            AND b.menuActive = 'y'
                            AND b.menuView='y'
                            AND a.lmnView='y'
                            AND b.menuParentId = '{$parent}'";

        if($parent > 0){ $sqlMenu .= " AND b.menuParentId != '0'"; }

        $queryMenu1 = $this->db->query($sqlMenu);
        return $queryMenu1->num_rows();
    }    

    // START permission check for module here
    public function countPermissionAdminMenu($querymodule){
		$querymodule = esc_sql( filter_txt($querymodule) ); 
        $this->db->select("COUNT(menuId) AS totalMenu");
        $this->db->from( $this->db->dbprefix('users_menu') );
        $this->db->where("menuActive","y");
        $this->db->where("menuAccess",$querymodule);
        $query = $this->db->get();
        return $query->row()->totalMenu;
    }
    public function permissionAdminMenu($querymodule, $lvltype = ''){
        $dataAccess = esc_sql( filter_txt($querymodule));

        $permnum = $this->countPermissionAdminMenu($dataAccess);

        if($permnum>0){
            $this->db->select("menuId,menuView,menuAdd,menuEdit,menuDelete");
            $this->db->from( $this->db->dbprefix('users_menu') );
            $this->db->where("menuActive","y");
            $this->db->where("menuAccess",$dataAccess);
            $query = $this->db->get();
            $perm  = $query->result_array()[0];

            if($lvltype=='view'){ $accperm = $perm['menuView']; }
            elseif($lvltype=='add'){ $accperm = $perm['menuAdd']; }
            elseif($lvltype=='edit'){ $accperm = $perm['menuEdit']; }
            elseif($lvltype=='delete'){ $accperm = $perm['menuDelete']; }
            else { $accperm = 'n'; }

            if($accperm=='y'){ $status = true; } else { $status = false; }

            $result = array(
                'id' => $perm['menuId'],
                'status' => $status
            );
        } else {
            $result = array(
                'id' => 0,
                'status' => false
            );
        }

        return $result;
    }

    public function countPermissionMenuAccess($menuid, $leveluser){
        $this->db->select("COUNT(menuId) AS totalAccess");
        $this->db->from( $this->db->dbprefix('users_menu_access') );
        $this->db->where("levelId",$leveluser);
        $this->db->where("menuId",$menuid);
        $query = $this->db->get();
        return $query->row()->totalAccess;
    }
    public function permissionMenuAccess($menuid, $leveluser, $lvltype = ''){
        $result = false;

        if( $this->countPermissionMenuAccess($menuid, $leveluser) > 0){
            $this->db->select("lmnView,lmnAdd,lmnEdit,lmnDelete");
            $this->db->from( $this->db->dbprefix('users_menu_access') );
            $this->db->where("levelId",$leveluser);
            $this->db->where("menuId",$menuid);
            $query = $this->db->get();
            $perm  = $query->result_array()[0];

            if($lvltype=='view'){ $accperm = $perm['lmnView']; }
            elseif($lvltype=='add'){ $accperm = $perm['lmnAdd']; }
            elseif($lvltype=='edit'){ $accperm = $perm['lmnEdit']; }
            elseif($lvltype=='delete'){ $accperm = $perm['lmnDelete']; }
            else { $accperm = 'n'; }

            if($accperm=='y'){ $result = true; }
        }
        return $result;        
    }
    // END permission check for module here
}
