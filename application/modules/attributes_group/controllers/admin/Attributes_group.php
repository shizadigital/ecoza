<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attributes_group extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 16) );

		// load model
		$this->load->model('attributes_group_model');
	}

	public function index(){
		if( is_view() ){

			// get attr group data start here
			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'attribute_group';

			$excClause = '';
			$where = "attrgroupDeleted='0'";

			$querysearchlang ='';
			// search process
            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				// standard lang
				$queryserach = "attrgroupLabel LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";

				// check multilanguage
				$lang = get_cookie('admin_lang');
				if( $lang !== $this->config->item('language') ){
					// check the keyword here
					$dataidresult = $this->Env_model->view_where("dtRelatedId","dynamic_translations","dtRelatedTable='{$table}' AND dtRelatedField='attrgroupLabel' AND dtLang='{$lang}' AND ( dtTranslation LIKE '%{$kw}%') ");

					if( count($dataidresult) > 0 ){ 
						$resultlangsearch = array();
						foreach($dataidresult AS $key => $val){
							$resultlangsearch[] = $val['dtRelatedId'];
						}

						$standardlangcount = countdata($table, $where . $excClause);

						$querysearchlang = ($standardlangcount > 0) ? '(':'';

						$querysearchlang .= '( attrgroupId=\''.implode('\' OR attrgroupId=\'', $resultlangsearch).'\' )';

						if( $standardlangcount > 0 ){
							$querysearchlang .= " OR (".$queryserach.")";
						}

						$querysearchlang .= ($standardlangcount > 0) ? ')':'';

						$excClause = " AND $querysearchlang";
					} else {
						$excClause = " AND attrgroupLabel=''";
					}
				}
            }

			$perPage = 30;
			
			$where = $where.$excClause;

			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'attrgroupId', 'DESC', $perPage, $datapage);
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
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('attributes_group_view'), $data );
		}
	}

	public function addingprocess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('label') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$label 		= esc_sql( filter_txt( $this->input->post('label') ) );
				$sorting	= esc_sql( filter_int( $this->input->post('sorting') ) );
				
				$nextId = getNextId('attrgroupId', 'attribute_group');

				$datacat = array(
					'attrgroupId' => $nextId,
					'attrgroupLabel' => $label,
					'attrgroupSorting' => (int)$sorting,
					'attrgroupDeleted' => 0
				);
				
				// insert data
				$query = $this->Env_model->insert('attribute_group', $datacat);
				
			    if($query){
					// insert or update data translation
					translate_pushdata('label', 'attribute_group', 'attrgroupLabel', $nextId );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('attributes_group/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('attributes_group') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			// get attr data
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","attribute_group", "attrgroupId='{$id}'");

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
													'access' => admin_url('attributes_group')
												)
											),	
							'data' => $getdata,
						);

			$this->load->view( admin_root('attributes_group_edit'), $data );
		}
	}

	public function editprocess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('label') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$id 		= esc_sql( filter_txt( $this->input->post('ID') ) );
				$label 		= esc_sql( filter_txt( $this->input->post('label') ) );
				$sorting	= esc_sql( filter_int( $this->input->post('sorting') ) );

				$datacat = array(
					'attrgroupLabel' => $label,
					'attrgroupSorting' => (int)$sorting
				);
				
				// insert data
				$query = $this->Env_model->update('attribute_group', $datacat, "attrgroupId='{$id}'");
				
			    if($query){
					// insert or update data translation
					translate_pushdata('label', 'attribute_group', 'attrgroupLabel', $id );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('attributes_group/edit/'.$id) );
		}
	}

	public function delete($id){
		if( is_delete() ){
			// get attr data
			$id = esc_sql( filter_int($id) );

			// update to delete with timestamp
			$data_ = array( 'attrgroupDeleted' => time2timestamp() );
			$update = $this->Env_model->update( 'attribute_group', $data_, array('attrgroupId'=> $id) );

			if( $update ){

				// remove attribute relationship
				$this->Env_model->delete('attribute_relationship', array('attrgroupId'=> $id));

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}
			redirect( admin_url('attributes_group') );
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
							$data_ = array( 'attrgroupDeleted' => time2timestamp() );
							$update = $this->Env_model->update( 'attribute_group', $data_, array('attrgroupId'=> $id) );

							if($update){

								// remove attribute relationship
								$this->Env_model->delete('attribute_relationship', array('attrgroupId'=> $id));
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

					redirect( admin_url('attributes_group') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('attributes_group') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
