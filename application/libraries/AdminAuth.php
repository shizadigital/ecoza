<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAuth {
	protected $CI;

	public function __construct(){
        $this->CI =& get_instance();
	}

	public function auth_login(){
		$login = false;

		if(
			!empty( $this->CI->session->userdata('username') ) AND 
			!empty( $this->CI->session->userdata('passuser') ) AND 
			!empty( $this->CI->session->userdata('checkpoint') ) 
		){	
			$login = true;

			if( $this->CI->session->userdata('checkpoint') !== loginCP() ){
				$login = false;
			}
		}

		if($login == false){
			unset($login);
			redirect( admin_url('main/logout'),'refresh');
		}
	}

	public function destroy_login(){
		$this->CI->session->sess_destroy();
	}
}