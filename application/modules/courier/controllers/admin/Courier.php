<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 26) );

		// load model
		$this->load->model('courier_model');
	}

	public function index(){
		if( is_view() ){

			$data = array( 
						'title' => $this->moduleName . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' =>  $this->moduleName,
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('courier/addnew'),
												'permission' => 'add'
											)
										),
					);
			
			$this->load->view( admin_root('courier_view'), $data );
		}
	}

	public function addnew(){
		if( is_add() ){

			
			$data = array( 
							'title' => $this->moduleName . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => $this->moduleName . ' - ' . t('addnew'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('courier'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('courier_add'), $data );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$data = array( 
							'title' => $this->moduleName . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => $this->moduleName . ' - ' . t('edit'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('addnew'),
													'icon'	=> 'fe fe-plus',
													'access' => admin_url('courier/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('courier'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('courier_edit'), $data );
		}
	}

	public function delete($id){
		if( is_delete() ){

		}
	}

}
