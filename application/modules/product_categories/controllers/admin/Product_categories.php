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
            	$kw = $this->security->xss_clean( $this->input->get('kw') );
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
						'title' => t('productcategories').' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => t('productcategories'),
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
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$nama 		= esc_sql( filter_txt( $this->input->post('nama') ) );
				$deskripsi 	= esc_sql( filter_txt( $this->input->post('desc') ) );
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
				
				// insert data
				$query = $this->Env_model->insert('categories', $datacat);
				
			    if($query){
					// insert or update data translation
					translate_pushdata('nama', 'categories', 'catName', $nextId );
					translate_pushdata('desc', 'categories', 'catDesc', $nextId );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('product_categories/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('product_categories') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","categories", "catId='{$id}'");

			$data = array( 
							'title' => t('productcategories') .' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => t('edit_category'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('product_categories')
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('product_categories_edit'), $data );
		}
	}

	public function prosesedit(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('nama') ) OR empty( $this->input->post('slug') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$id 		= esc_sql( filter_int( $this->input->post('ID') ) );

				$nama 		= esc_sql( filter_txt( $this->input->post('nama') ) );
				$slug 		= esc_sql( filter_txt( $this->input->post('slug') ) );
				$deskripsi 	= esc_sql( filter_txt( $this->input->post('desc') ) );
				$warna 		= esc_sql( filter_txt( $this->input->post('warna') ) );
				$active		= ($this->input->post('active') !==NULL) ? esc_sql( filter_txt( $this->input->post('active') ) ):0;
				

				$datacat = array(
					'catName' => $nama,
					'catSlug'=> $slug,
					'catDesc' => (string) $deskripsi,
					'catColor' => (string) $warna,
					'catActive' => $active,
				);
				
				// update data
				$query = $this->Env_model->update('categories', $datacat, "catId='{$id}'");
				
			    if($query){
					// insert or update data translation
					translate_pushdata('nama', 'categories', 'catName', $id );
					translate_pushdata('desc', 'categories', 'catDesc', $id );

					$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('product_categories/edit/'.$id) );
		}
	}

	public function delete($id){
		if( is_delete() ){
			$id = esc_sql( filter_int( $id ) );

			$where = array('catId' => $id, 'catType' => 'product');
			$query = $this->Env_model->delete('categories', $where);

			if($query){
				// remove relationship too
				$where = array('catId' => $id, 'crelRelatedType' => 'product');
				$this->Env_model->delete('category_relationship', $where);

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}

			redirect( admin_url('product_categories') );
		}
	}

	public function bulk_action(){
		$error = false;
		if(empty($this->input->post('bulktype'))){
			$error = "<strong>".t('error')."!!</strong> ". t('bulkactionnotselectedyet');
		}

		if(!$error){
			if( $this->input->post('bulktype')=='bulk_delete' AND is_delete() ){
				$theitem = (!empty($this->input->post('item'))) ? array_filter($this->input->post('item')):array();

				if( count($theitem) > 0 ){
					$stat_hapus = FALSE;

					foreach ($theitem as $key => $value) {
						if($value == 'y'){
							$id = filter_int($this->input->post('item_val')[$key]);

							$where = array('catId' => $id, 'catType' => 'product');
							$queryact = $this->Env_model->delete('categories', $where);

							if($queryact){
								// remove relationship too
								$where = array('catId' => $id, 'crelRelatedType' => 'product');
								$this->Env_model->delete('category_relationship', $where);

								$stat_hapus = TRUE;

							} else {

								$stat_hapus = FALSE; break;

							}
						}
					}

					if($stat_hapus){
						$this->session->set_flashdata( 'succeed', t('successfullydeleted') );
					} else {
					  	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
					}

					redirect( admin_url('product_categories') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('product_categories') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}