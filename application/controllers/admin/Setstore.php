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

	public function setAdminLang($idstore){
		$error = false;

		$id = esc_sql(filter_int( $this->security->xss_clean($idstore) ));

		if(countdata('store',"storeId='{$id}' AND storeDeleted='0' storeActive='y'") > 0){
			// make session here
			$newdata = array(
				'storeid'=> $logindata->userId,
			);

			$this->session->set_userdata($newdata);
		}

		// redirect back
		redirect( $this->agent->referrer() );
		
	}
}
