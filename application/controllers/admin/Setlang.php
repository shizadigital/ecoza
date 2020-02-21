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
		if( !empty( $this->session->userdata('namauser') ) AND !empty( $this->session->userdata('passuser') ) ){

			$adminid = $this->session->userdata('adminid');

			// load model admin auth
			$this->load->model('adminauth_model');
			$this->adminauth_model->update_login( $adminid, array( 'userLang' => $langdata ) );

		}

		// redirect back
		redirect( $this->agent->referrer() );
		
	}

	public function setLang($lang){

		// filter lang data
		$langdata = filter_txt( $this->security->xss_clean( $lang ) );		
		
		// redirect
		redirect( $this->agent->referrer() );
		
	}
}
