<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_categories extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('product_categories_model');
	}

	public function index(){
		if( is_view() ){

			$data = array( 
						'title' => 'Kategori Produk - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => 'Kategori Produk',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
					);
			
			$this->load->view( admin_root('product_categories_view'), $data );
		}
	}

	public function prosestambah(){
		if( is_add() ){

		}
	}

	public function edit($id){
		if( is_edit() ){
			$data = array( 
							'title' => 'Kategori Produk - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => 'Edit Kategori Produk',
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => 'Tambah',
													'icon'	=> 'fe fe-plus',
													'access' => admin_url('product_categories/tambah'),
													'permission' => 'add'
												),
												array(
													'title' => 'Kembali',
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('product_categories')
												)
											),
						);

			$this->load->view( admin_root('product_categories_edit'), $data );
		}
	}

	public function delete($id){
		if( is_delete() ){

		}
	}

}
?>