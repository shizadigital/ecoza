<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAuth {
	protected $CI;

	public function __construct(){
        $this->CI =& get_instance();
	}

	public function validate_login(){
		$login = false;

		if(
			!empty( $this->CI->session->userdata('username') ) AND 
			!empty( $this->CI->session->userdata('passuser') ) AND 
			!empty( $this->CI->session->userdata('adminid') ) AND 
			!empty( $this->CI->session->userdata('leveluser') ) AND 
			!empty( $this->CI->session->userdata('levelstatus') ) 
		){	
			$login = true;

			if( $this->CI->session->userdata('checkpoint') !== loginCP() ){
				$login = false;
			}
		}

		return $login;
	}

	public function auth_login(){
		$login = false;

		if( $this->validate_login() ){	
			$login = true;
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
