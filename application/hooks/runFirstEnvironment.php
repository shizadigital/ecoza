<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class runFirstEnvironment {

	public function runEnv(){
		// load environment of CI
		if(isNotMigration()) {
			$ci_env =& get_instance();
			$segment = trim( strtolower( $ci_env->uri->segment(1) ) );
			// set time zone
			date_default_timezone_set(get_option('timezone'));
	
			if($segment != 'migration') {
				// set token with cookie
				$ci_env->load->helper('cookie');
				// set default currency
				if( empty( get_cookie('currency') ) ){
					$cook_currency = array(
						'name'   => 'currency',
						'value'  => get_option('defaultcurrency'),
						'expire' => '0',
						'path ' => '/'
						);
					$ci_env->input->set_cookie($cook_currency);
				}

				// set shiza token
				if( empty( get_cookie('sz_token') ) ){
					$expiredtoken = 86400; // 1 day
					$createcookiecode = sz_token();
					$cookie = array(
							'name'   => 'sz_token',
							'value'  => $createcookiecode,
							'expire' => $expiredtoken,
							'path ' => '/'
							);
					$ci_env->input->set_cookie($cookie);
				}

				// set default website store as session
				if( !$ci_env->session->has_userdata('visitor_storeid') ){
					// force slash to the last base_url()
					$baseuri = ( substr(base_url(), -1) == '/' ) ? base_url():base_url() .'/';

					// get store ID by uri
					$uri = getval('storeId','store', array('storeUri'=>$baseuri) );
					$newdata = array(
						'visitor_storeid' => $uri
					);
					$ci_env->session->set_userdata($newdata);
				}

				// check only frontend system here
				if( $ci_env->uri->segment(1) != $ci_env->config->item('admin_slug') ){

					if($ci_env->session->has_userdata('cart_timeout')){
						// unset cart if time is expired
						if(time() > $ci_env->session->userdata('cart_timeout')){
							$ci_env->shopping_cart->unsetCart();
						}
					}

				}

				// set the first time using this system
				if( check_option('startupdate') < 1 ){
					add_option('startupdate', date('Y-m-d'));
				}
				
			}
		}

	}
}
