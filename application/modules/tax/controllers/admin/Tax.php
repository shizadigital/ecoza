<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 21) );

		// load model
		$this->load->model('tax_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'tax';
			$where = "taxDeleted='0'";

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "taxName LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";
				
				// check multilanguage
				$lang = get_cookie('admin_lang');
				if( $lang != $this->config->item('language') ){
					// check the keyword here
					$dataidresult = $this->Env_model->view_where("dtRelatedId","dynamic_translations","dtRelatedTable='{$table}' AND dtLang='{$lang}' AND ( dtRelatedId IN (SELECT taxId FROM ".$this->db->dbprefix($table)." WHERE taxId=dtRelatedId) AND (dtRelatedField='taxName' AND dtTranslation LIKE '%{$kw}%') ) ");

					$standardlangcount = countdata($table, $where . $excClause);

					if( count($dataidresult)>0 ){
						$resultlangsearch = array();
						foreach($dataidresult AS $key => $val){
							$resultlangsearch[] = $val['dtRelatedId'];
						}

						$querysearchlang = ($standardlangcount > 0) ? '(':'';
						$querysearchlang .= '( taxId=\'' .implode('\' OR taxId=\'', $resultlangsearch). '\' )';

						if( $standardlangcount > 0 ){
							$querysearchlang .= " OR (".$queryserach.")";
						}

						$querysearchlang .= ($standardlangcount > 0) ? ')':'';

						$excClause = " AND $querysearchlang";
						
					} else {
						if($standardlangcount < 1){
							$excClause = " AND taxName=''";
						}
					}
				}
            }

			$perPage = 30;

			$where = $where.$excClause;
			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'taxId', 'DESC', $perPage, $datapage);
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
			
			$this->load->view( admin_root('tax_view'), $data );
		}
	}

	public function addingprocess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('name') ) OR empty( $this->input->post('rate') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$name = esc_sql( filter_txt( $this->input->post('name') ) );
				$rate = esc_sql( singleComma( filter_txt( $this->input->post('rate') ) ) );				
				
				$nextId = getNextId('taxId', 'tax');

				$datatax = array(
					'taxId' => $nextId,
					'taxName' => $name,
					'taxRate'=> $rate,
					'taxType' => $this->input->post('type'),
					'taxActive' => 'y',
					'taxAdded' => time2timestamp(),
					'taxModified' => time2timestamp(),
					'taxDeleted' => 0,
				);
				
				// insert data
				$query = $this->Env_model->insert('tax', $datatax);
				
			    if($query){
					// insert or update data translation
					translate_pushdata('name', 'tax', 'taxName', $nextId );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('tax/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('tax') );
		}
	}

	public function edit($id){
		if( is_edit() ){

			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","tax", "taxId='{$id}'");

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
													'access' => admin_url('tax'),
													'permission' => 'view'
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('tax_edit'), $data );
		}
	}

	public function editprocess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('name') ) OR empty( $this->input->post('rate') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$name = esc_sql( filter_txt( $this->input->post('name') ) );
				$rate = esc_sql( singleComma( filter_txt( $this->input->post('rate') ) ) );
				$ID = esc_sql( filter_int( $this->input->post('ID') ) );
				
				$active = 'n';
				if( $this->input->post('active') == 'y' ){
					$active = 'y';
				}

				$datatax = array(
					'taxName' => $name,
					'taxRate'=> $rate,
					'taxType' => $this->input->post('type'),
					'taxActive' => $active,
					'taxModified' => time2timestamp(),
				);
				
				// insert data
				$query = $this->Env_model->update('tax', $datatax, array('taxId' => $ID));
				
			    if($query){
					// insert or update data translation
					translate_pushdata('name', 'tax', 'taxName', $ID );

					$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('tax/edit/'.$ID) );
		}
	}


	protected function deleteAction($id){
		if( is_delete() ){
			$id = esc_sql( filter_int( $id ) );

			$where = array('taxId' => $id);
			return $this->Env_model->update('tax', array('taxDeleted'=>time2timestamp()), $where);
		}
	}
	public function delete($id){
		if( is_delete() ){
			$query = Self::deleteAction($id);
			if($query){

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}

			redirect( admin_url('tax') );
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

							$query = Self::deleteAction($id);

							if($query){

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

					redirect( admin_url('tax') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('tax') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
