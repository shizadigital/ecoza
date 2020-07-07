<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_rule extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 22) );

		// load model
		$this->load->model('tax_rule_model');
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
												'access' => admin_url('tax_rule/addnew'),
												'permission' => 'add'
											)
										),
					);
			
			$this->load->view( admin_root('tax_rule_view'), $data );
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
													'access' => admin_url('tax_rule'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('tax_rule_add'), $data );
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
													'access' => admin_url('tax_rule/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('tax_rule'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('tax_rule_edit'), $data );
		}
	}

	public function delete($id){
		if( is_delete() ){

		}
	}

}
