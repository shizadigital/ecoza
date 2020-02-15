<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminauth_model extends CI_model{
    public function login_auth($username,$password){
        $result = false;
    	$this->db->select('userId');
	    $this->db->from( $this->db->dbprefix('users') );
	    $this->db->where('userLogin', $username);
        $this->db->where('userPass', $password);
        $this->db->where('userBlokir', 'n');
        $this->db->where('userDelete', '0');
	    $query = $this->db->get();
        $numrows = $query->num_rows();

        if( $numrows > 0 ) $result = $numrows;
        return $result;
    }

    public function get_auth_data($username,$password){
    	$this->db->select('a.userId,a.userLogin,a.userPass,a.userEmail,a.userDisplayName,a.levelId, b.levelActive');
        $this->db->from( $this->db->dbprefix('users') . ' a' );

        $this->db->join($this->db->dbprefix('users_level') . ' b' , 'b.levelId = a.levelId', 'left');

        $this->db->where('a.userLogin', $username);
        $this->db->where('a.userPass', $password);
        $this->db->where('a.userBlokir', 'n');
        $this->db->where('a.userDelete', '0');
        $query = $this->db->get();
        return $query->row();
    }

    public function update_login($id, $data){
        $this->db->where('userId', filter_int($id));
        return $this->db->update( $this->db->dbprefix('users') , $data);
    }
}