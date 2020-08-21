<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Memberauth_model extends CI_model{

    public function login_auth($username){
		$result = false;		
    	$this->db->select('mId,mPassword');
	    $this->db->from( $this->db->dbprefix('member') );
	    $this->db->where('mEmail', $username);
        $this->db->where('mStatus', '1');
        $this->db->where('mDeleted', '0');
        $query = $this->db->get();
        
        return $query->row();
    }

    public function get_auth_data($id,$password){
    	$this->db->select('*');
        $this->db->from( $this->db->dbprefix('member') . ' a' );

        $this->db->where('a.mId', $id);
        $this->db->where('a.mPassword', $password);
        $this->db->where('a.mStatus', '1');
        $this->db->where('a.mDeleted', '0');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_login($id, $data){
        $this->db->where('mId', filter_int($id));
        return $this->db->update( $this->db->dbprefix('member') , $data);
	}
	
}
