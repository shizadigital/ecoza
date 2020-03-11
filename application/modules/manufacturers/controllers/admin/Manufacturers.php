<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturers extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('manufacturers_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$excClause = '';

            if(!empty($this->input->get('kw'))){
            	$kw = $this->security->xss_clean( $this->input->get('kw') );
            	$excClause .= " AND ( manufactName LIKE '%{$kw}%' OR manufactDesc LIKE '%{$kw}%' )";
            }

			$perPage = 30;
			
			$table = 'manufacturers';

			$where = "manufactDeleted='0'".$excClause;
			
			$datacontent = $this->Env_model->view_where_order_limit('*', $table, $where, 'manufactId', 'DESC', $perPage, $datapage);
			$rows = countdata($table, $where);

			$pagingURI = admin_url( $this->uri->segment(2) );

			$this->load->library('paging');
			$pagination = $this->paging->PaginationAdmin( $pagingURI, $rows, $perPage );

			$data = array( 
						'title' => t('manufacturers') . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => t('manufacturers'),
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'data' => $datacontent,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('manufacturers_view'), $data );
		}
	}

	public function addingproccess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('nama') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			// file extention allowed
			$extensi_allowed = array('jpg','jpeg','png','gif');

			// check image upload
			if(!empty($_FILES['picture']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

				if(!in_array($ext_file,$extensi_allowed)) {
					$error = "<strong>".t('error')."!!</strong> " . t('wrongextentionfile');
				}
			}

			if(!$error){
				$nama 		= esc_sql( filter_txt( $this->input->post('nama') ) );
				$deskripsi 	= esc_sql( filter_txt( $this->input->post('desc') ) );
				$sorting	= esc_sql( filter_int( $this->input->post('sorting') ) );
				
				$nextId = getNextId('manufactId', 'manufacturers');

				$slug = slugURL($nama);

				$file_img = '';
				$file_dir = '';
				// upload image proccess
				if(!empty($_FILES['picture']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

					if(in_array($ext_file,$extensi_allowed)) {
						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'210',
							'medium' 	=>'530',
							'large' 	=>'1920'
						);
						$img = uploadImage('picture', 'manufacturers', $sizeimg, $extensi_allowed);
						$file_img = $img['filename'];
						$file_dir = $img['directory'];
					}
				}

				if(empty($sorting)){
					$sorting      = nextSort('manufacturers', 'manufactSort');
				}

				$datacat = array(
					'manufactId' => $nextId,
					'manufactName' => $nama,
					'manufactDesc'=> (string) $deskripsi,
					'manufactSlug' => $slug,
					'manufactDir' => $file_dir,
					'manufactImg' => $file_img,
					'manufactSort' => $sorting,
					'manufactActive' => 'y',
					'manufactDeleted' => (int) 0
				);
				
				// insert data
				$query = $this->Env_model->insert('manufacturers', $datacat);
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('manufacturers/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('manufacturers') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );
			
			$getdata = $this->Env_model->getval("*","manufacturers", "manufactId='{$id}'");

			$data = array( 
							'title' => t('manufacturers') . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => t('editmanufacturer'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('manufacturers')
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('manufacturers_edit'), $data );
		}
	}

	public function editprocess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('nama') ) OR empty( $this->input->post('slug') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			// file extention allowed
			$extensi_allowed = array('jpg','jpeg','png','gif');

			// check image upload
			if(!empty($_FILES['picture']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

				if(!in_array($ext_file,$extensi_allowed)) {
					$error = "<strong>".t('error')."!!</strong> " . t('wrongextentionfile');
				}
			}

			if(!$error){
				$nama 		= esc_sql( filter_txt( $this->input->post('nama') ) );
				$deskripsi 	= esc_sql( filter_txt( $this->input->post('desc') ) );
				$sorting	= esc_sql( filter_int( $this->input->post('sorting') ) );
				$ID			= esc_sql( filter_int( $this->input->post('ID') ) );
				$slug		= esc_sql( filter_txt( $this->input->post('slug') ) );
				$active		= ($this->input->post('active') =='y' ) ? 'y':'n';

				if(empty($slug)){
					$slug = slugURL($nama);
				}

				$file = array();
				// upload image proccess
				if(!empty($_FILES['picture']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

					if(in_array($ext_file,$extensi_allowed)) {
						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'210',
							'medium' 	=>'530',
							'large' 	=>'1920'
						);
						$img = uploadImage('picture', 'manufacturers', $sizeimg, $extensi_allowed);
						$file_img = $img['filename'];
						$file_dir = $img['directory'];
						
						$file = array( 'manufactDir'=> $file_dir, 'manufactImg'=>$file_img );
					}
				}

				//check sorting
				$checksorting = countdata('manufacturers',"manufactSort='{$sorting}' AND manufactId!='{$ID}'");
				if(empty($sorting) OR $checksorting > 0){
					$sorting      = nextSort('manufacturers', 'manufactSort');
				}

				$dataman = array(
					'manufactName' => $nama,
					'manufactDesc'=> (string) $deskripsi,
					'manufactSlug' => $slug,
					'manufactSort' => $sorting,
					'manufactActive' => $active
				);

				$data_ = array_merge($dataman,$file);
				
				// insert data
				$query = $this->Env_model->update('manufacturers', $data_, array('manufactId'=> $ID) );
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('manufacturers/edit/'.$ID) ); exit;
		}
	}

	public function delete($id){
		if( is_delete() ){
			$id = esc_sql( filter_int($id) );

			// update to delete with timestamp
			$data_ = array( 'manufactDeleted' => time2timestamp() );
			$update = $this->Env_model->update( 'manufacturers', $data_, array('manufactId'=> $id) );

			if( $update ){

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}
			redirect( admin_url('manufacturers') );
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

							// update to delete with timestamp
							$data_ = array( 'manufactDeleted' => time2timestamp() );
							$update = $this->Env_model->update( 'manufacturers', $data_, array('manufactId'=> $id) );

							if($update){

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

					redirect( admin_url('manufacturers') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('manufacturers') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
