<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setlang extends CI_Controller {
	// load model
	public function __construct()
	{
		parent::__construct();
		// load helper random string
		$this->load->helper('cookie');
		$this->load->library('user_agent');
	}

	public function setAdminLang($lang){

		if( in_array($lang, langlist()) ){

			// filter lang data
			$langdata = filter_txt( $this->security->xss_clean( $lang ) );
			
			$lang_cook = array(
				'name'   => 'admin_lang',
				'value'  => $langdata,
				'expire' => $this->config->item('sess_expiration'),
				'path ' => '/'
			);
			$this->input->set_cookie($lang_cook);

			// save lang to user
			if( !empty( $this->session->userdata('username') ) AND !empty( $this->session->userdata('passuser') ) ){

				$adminid = $this->session->userdata('adminid');

				// load model admin auth
				$this->load->model('adminauth_model');
				$this->adminauth_model->update_login( $adminid, array( 'userLang' => $langdata ) );

			}

		}

		// redirect back
		redirect( $this->agent->referrer() );
		
	}

	public function setLang($lang){

		$referrer = $this->agent->referrer();
		
		$httpmodel = ( is_https() OR $_SERVER['SERVER_PORT'] == 443 ) ? "https://" : "http://";

		$cuthttpreferrer = str_replace( $httpmodel,'',substr(base_url(), 0, -1) );

		if( in_array($lang, langlist()) AND strpos($referrer, $cuthttpreferrer) ){

			// filter lang data
			$langdata = filter_txt( $this->security->xss_clean( $lang ) );	

			// get locale code
			$langcode = explode('_',$langdata)[0];
			
			// force slash to the last base_url()
			$baseurislash = ( substr(base_url(), -1) == '/' ) ? base_url():base_url() .'/';
			
			// check uri availability lang
			$lenuri = strlen($baseurislash);
			$getlanguri = substr($referrer, $lenuri, 2);

			$baseurl_lang = $baseurislash . $langcode;

			$referrer = str_replace($baseurislash.$getlanguri, $baseurl_lang, $referrer);

			// set lang cookies
			$lang_cook = array(
				'name'   => 'lang',
				'value'  => $langdata,
				'expire' => 0,
				'path ' => '/'
			);
			$this->input->set_cookie($lang_cook);
		
		}
		
		// redirect
		redirect( $referrer );
		
	}
}
