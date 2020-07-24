<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}

	/**
	 * Check member is login or not
	 *
	 * @return boolean
	 */
	public function is_login(){
		$return = false;
		if( !empty(get_cookie('member')) AND !empty(get_cookie('checkpoint'))  AND !empty(get_cookie('lastlog')) AND !empty(get_cookie('memberemail')) ){
			$return = true;
		}

		return $return;
	}

	
}
