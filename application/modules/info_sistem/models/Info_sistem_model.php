<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_sistem_model extends CI_model{ 
	public function getMysqlVersion(){
		$sql = "SELECT VERSION() AS versi";
		$query = $this->db->query($sql);
		return $query->result_array()[0]['versi'];
	}
}
?>