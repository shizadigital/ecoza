<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_group_model extends CI_model{ 

	public function getLevelUsers(){

		if($this->session->userdata('leveluser')!='1'){
			$this->db->where("levelId !=","1");
		}	
        $this->db->order_by('levelId','ASC');
        $query = $this->db->get( $this->db->dbprefix('users_level') );
        return $query->result_array();
	}

}
?>