<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_badges extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 17) );

		// load model
		$this->load->model('product_badges_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$excClause = '';
			$perPage = 30;
			$table = 'badges';
			$where = "badgeDeleted='0' AND badgeType='product'";

            if(!empty($this->input->get('kw'))){
            	$kw = $this->security->xss_clean( $this->input->get('kw') );
            	$excClause .= " AND ( badgeLabel LIKE '%{$kw}%' )";
            }

			$perPage = 30;
			
			$table = 'badges';

			$where = $where.$excClause;
			
			$datacontent = $this->Env_model->view_where_order_limit('*', $table, $where, 'badgeId', 'DESC', $perPage, $datapage);
			$rows = countdata($table, $where);

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
						'data' => $datacontent,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('product_badges_view'), $data );
		}
	}

	public function addingprocess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('label') ) OR empty($_FILES['picture']['tmp_name']) ){
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
				$label 		= esc_sql( filter_txt( $this->input->post('label') ) );
				$deskripsi 	= esc_sql( filter_txt( $this->input->post('desc') ) );
				
				$nextId = getNextId('badgeId', 'badges');

				$file_img = '';
				$file_dir = '';
				// upload image proccess
				if(!empty($_FILES['picture']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

					if(in_array($ext_file,$extensi_allowed)) {
						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'120',
							'medium' 	=>'360',
							'large' 	=>'680'
						);
						$img = uploadImage('picture', 'badges', $sizeimg, $extensi_allowed);
						$file_img = $img['filename'];
						$file_dir = $img['directory'];
					}
				}

				$datacat = array(
					'badgeId' => $nextId,
					'badgeLabel' => $label,
					'badgeDesc'=> (string) $deskripsi,
					'badgeType' => 'product',
					'badgeDir' => $file_dir,
					'badgePic' => $file_img,
					'badgeActive' => 1,
					'badgeDeleted' => 0
				);
				
				// insert data
				$query = $this->Env_model->insert('badges', $datacat);
				
			    if($query){
					// insert and update multilanguage
					translate_pushdata('desc', 'badges', 'badgeDesc', $nextId );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('product_badges/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('product_badges') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );
			
			$getdata = $this->Env_model->getval("*","badges", "badgeId='{$id}' AND badgeType='product'");

			$data = array( 
							'title' => $this->moduleName . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => $this->moduleName . ' - ' . t('edit'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('product_badges')
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('product_badges_edit'), $data );
		}
	}

	public function editprocess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('label') ) ){
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
				$label 		= esc_sql( filter_txt( $this->input->post('label') ) );
				$deskripsi 	= esc_sql( filter_txt( $this->input->post('desc') ) );
				$ID 		= esc_sql( filter_int( $this->input->post('ID') ) );
				$active 	= ($this->input->post('active')=='y')? 1:0;

				// upload image proccess
				$datapic = array();
				if(!empty($_FILES['picture']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

					if(in_array($ext_file,$extensi_allowed)) {

						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'120',
							'medium' 	=>'360',
							'large' 	=>'680'
						);

						// remove old image first
						$getoldimg = getval("badgeDir,badgePic", "badges", array('badgeId'=> $ID));
						if( !empty($getoldimg['badgeDir']) AND !empty($getoldimg['badgePic']) ){
							foreach($sizeimg AS $kimg => $vimg ){
								@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .$kimg.'_'.$getoldimg['badgeDir'].DIRECTORY_SEPARATOR.$getoldimg['badgePic']);
							}
						}

						$img = uploadImage('picture', 'badges', $sizeimg, $extensi_allowed);

						$datapic = array(
							'badgeDir' => $img['directory'],
							'badgePic' => $img['filename'],
						);
					}
				}

				$databdg = array(
					'badgeLabel' => $label,
					'badgeDesc'=> (string) $deskripsi,
					'badgeActive' => $active,
				);

				$databdg = array_merge($databdg, $datapic);
				
				// insert data
				$query = $this->Env_model->update('badges', $databdg, array('badgeId'=> $ID) );
				
			    if($query){
					// insert and update multilanguage
					translate_pushdata('desc', 'badges', 'badgeDesc', $ID );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('product_badges/edit/'.$ID) );
		}
	}

	public function delete($id){
		if( is_delete() ){
			$id = esc_sql( filter_int($id) );

			// update to delete with timestamp
			$data_ = array( 'badgeDeleted' => time2timestamp() );
			$update = $this->Env_model->update( 'badges', $data_, array('badgeId'=> $id) );

			if( $update ){

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}
			redirect( admin_url('product_badges') );
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
							$data_ = array( 'badgeDeleted' => time2timestamp() );
							$update = $this->Env_model->update( 'badges', $data_, array('badgeId'=> $id) );

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

					redirect( admin_url('product_badges') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('product_badges') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
