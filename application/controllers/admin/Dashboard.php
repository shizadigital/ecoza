<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	// load model
	public function __construct(){
		parent::__construct();
		// load helper random string
		$this->load->helper('cookie');

		// protect the page
		$this->adminauth->auth_login();
	}

	public function index(){
		// LOGIN PAGE
		$data = array( 
					'title' => 'Dashboard - '.get_option('sitename'),
					'title_page' => 'Dashboard'
				);
		$this->load->view( admin_root('dashboard/dashboard_view'), $data );
	}
}
