<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_admin_master_model extends CI_model{
    // Menu admin in page
    public function getAdminMenuInPage($parent=null){
        if($parent == null){
            $this->db->where("menuParentId","0");
        } else {
            $this->db->where("menuParentId !=","0");
            $this->db->where("menuParentId",$parent);
        }
        $this->db->order_by('menuSort','ASC');
        $query = $this->db->get( $this->db->dbprefix('users_menu') );
        return $query->result_array();
    }

    // count menu admin in page
    public function rowsAdminMenuInPage($parent=null){
        $users_menu = $this->db->dbprefix('users_menu');

        $parent_ = ($parent == null) ? 0 : $parent;

        $sqlMenu = "SELECT * FROM {$users_menu} WHERE menuParentId = '{$parent_}'";
        if($parent != null){ $sqlMenu .= " AND menuParentId != '0'"; }

        $queryMenu1 = $this->db->query($sqlMenu);
        return $queryMenu1->num_rows();
    }
}