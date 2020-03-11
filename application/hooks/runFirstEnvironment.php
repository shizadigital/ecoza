<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class runFirstEnvironment {

	public function runEnv(){
		// load environment of CI
		if(isNotMigration()) {
			$ci_env =& get_instance();
			$segment = $ci_env->uri->segment(1);
			// set time zone
			date_default_timezone_set(get_option('timezone'));
	
			if($segment != 'migration') {
				// set token with cookie
				$ci_env->load->helper('cookie');
				if( empty( get_cookie('sz_token') ) ){
					$createcode = generate_code(6);
					$createcookiecode = encoder($createcode ."##".base_url() );
					$cookie = array(
							'name'   => 'sz_token',
							'value'  => $createcookiecode,
							'expire' => '0',
							'path ' => '/'
							);
					$ci_env->input->set_cookie($cookie);
				}
			}
		}

	}
}
