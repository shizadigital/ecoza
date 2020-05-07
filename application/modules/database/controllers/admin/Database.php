<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 30) );

		// load model
		$this->load->model('database_model');
	}

	public function index(){
		if( is_view() ){

			// getAllTables
			$data = $this->database_model->showAllTables();

			$totaldata = count($data);

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
												'access' => admin_url('database/addnew'),
												'permission' => 'add'
											)
										),
						'data' => $data,
						'totaldata' => $totaldata
					);
			
			$this->load->view( admin_root('database_view'), $data );
		}
	}

	public function array_migration($data){
		if( is_view() ){
			$data = esc_sql( filter_txt($data) );

			// getAllTables
			$getdata = $this->database_model->getDataAllTables("SELECT * FROM {$data}");

			$totaldata = 0;

			$data = array( 
						'title' => $this->moduleName . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' =>  $this->moduleName,
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'header_button_action' => array(
											array(
												'title' => t('back'),
												'icon'	=> 'fe fe-corner-up-left',
												'access' => admin_url('database'),
												'permission' => 'view'
											)
										),
						'data' => $getdata,
						'totaldata' => $totaldata,
						'tablename' => $data
					);
			
			$this->load->view( admin_root('database_array_migration'), $data );
		}
	}

}
