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

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$excClause = '';

            if(!empty($this->input->get('kw'))){
            	$kw = $this->input->get('kw');
            	$excClause .= " AND ( catName LIKE '%{$kw}%' OR catDesc LIKE '%{$kw}%' )";
            }

			$perPage = 30;
			
			$table = 'categories';

			$where = "catType='product'".$excClause;
			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'catId', 'DESC', $perPage, $datapage);

			$rows = countdata($table, $where);
			$pagingURI = admin_url( $this->uri->segment(2) );

			$this->load->library('paging');
			$pagination = $this->paging->PaginationAdmin( $pagingURI, $rows, $perPage );

			$data = array( 
						'title' => 'Kategori Produk - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => 'Kategori Produk',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('product_categories_view'), $data );
		}
	}

	public function prosestambah(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('nama') ) ){
				$error = "<strong>Error</strong> Bidang wajib tidak boleh kosong";
			}

			if(!$error){
				$nama 		= esc_sql( filter_txt( $this->input->post('nama') ) );
				$deskripsi 	= (empty($this->input->post('desc'))) ? esc_sql( filter_txt( $this->input->post('desc') ) ):'';
				$warna 		= esc_sql( filter_txt( $this->input->post('warna') ) );
				
				$nextId = getNextId('catId', 'categories');

				$slugcat = slugURL($nama);

				$datacat = array(
					'catId' => $nextId,
					'catName' => $nama,
					'catSlug'=> $slugcat,
					'catDesc' => (string) $deskripsi,
					'catColor' => (string) $warna,
					'catActive' => 1,
					'catType' => 'product'
				);
				
				// insert data menu here
				$query = $this->Env_model->insert('categories', $datacat);
				
			    if($query){
					$this->session->set_flashdata( 'sukses', 'Data berhasil disimpan');
					redirect( admin_url('product_categories/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'gagal', 'Data gagal disimpan' );
				}
			}

			if($error){
				$this->session->set_flashdata( 'gagal', $error );
			}

			redirect( admin_url('product_categories') );
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