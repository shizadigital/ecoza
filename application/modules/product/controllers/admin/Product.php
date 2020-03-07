<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller{ 
	
	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 15) );

		// load model
		$this->load->model('product_model');
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
												'access' => admin_url('product/addnew'),
												'permission' => 'add'
											)
										),
					);
			
			$this->load->view( admin_root('product_view'), $data );
		}
	}

	public function addnew(){
		if( is_add() ){
			// get categories
			$categories = $this->Env_model->view_where_order('*','categories', "catActive='1' AND catType='product'",'catId','DESC');
			foreach( $categories as $k => $v ){
				$datacategories[$v['catId']] = $v['catName'];
			}

			// get categories
			$manufacturers = $this->Env_model->view_where_order('*','manufacturers', "manufactActive='y' AND manufactDeleted='0'",'manufactName','ASC');
			$datamanufacturers[''] = '-- '.t('choose').' --';
			foreach( $manufacturers as $k => $v ){
				$datamanufacturers[$v['manufactId']] = $v['manufactName'];
			}

			// get product
			$product = $this->Env_model->view_where_order('prodId,prodName,','product', "prodDisplay='y' AND prodDeleted='0'",'prodId','DESC');
			foreach( $product as $k => $v ){
				$dataproduct[$v['prodId']] = $v['prodName'];
			}

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
													'access' => admin_url('product')
												)
											),
							'categories' => $datacategories,
							'manufacturers' => $datamanufacturers,
							'products' => $dataproduct
						);

			$this->load->view( admin_root('product_add'), $data );
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
													'access' => admin_url('product/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('product')
												)
											),
						);

			$this->load->view( admin_root('product_edit'), $data );
		}
	}

	public function delete($id){
		if( is_delete() ){

		}
	}

}
