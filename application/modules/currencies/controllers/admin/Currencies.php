<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currencies extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 23) );

		// load model
		$this->load->model('currencies_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'currency';

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "curTitle LIKE '%{$kw}%' OR curCode LIKE '%{$kw}%'";
				$excClause = " ( $queryserach )";				
            }

			$perPage = 30;

			$where = $excClause;
			if( empty($where) ){
				$datauser = $this->Env_model->view_order_limit('*', $table, 'curId', 'DESC', $perPage, $datapage);
				$rows = countdata($table);
			} else {
				$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'curId', 'DESC', $perPage, $datapage);
				$rows = countdata($table, $where);
			}
			
			$pagingURI = admin_url( $this->uri->segment(2) );

			$this->load->library('paging');
			$pagination = $this->paging->PaginationAdmin( $pagingURI, $rows, $perPage );

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
												'access' => admin_url('currencies/addnew'),
												'permission' => 'add'
											)
										),
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('currencies_view'), $data );
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
													'access' => admin_url('currencies')
												)
											),
						);

			$this->load->view( admin_root('currencies_add'), $data );
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
													'access' => admin_url('currencies/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('currencies')
												)
											),
						);

			$this->load->view( admin_root('currencies_edit'), $data );
		}
	}

	public function delete($id){
		if( is_delete() ){

		}
	}

}
