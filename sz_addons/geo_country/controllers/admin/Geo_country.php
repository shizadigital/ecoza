<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geo_country extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 27) );

		// load model
		$this->load->model('geo_country_model');
	}

	public function index(){
		if( is_view() ){
			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'geo_country';
			$where = "countryDeleted='0'";

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "countryName LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";
            }

			$perPage = 30;

			$where = $where.$excClause;
			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'countryId', 'DESC', $perPage, $datapage);

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
			
			$this->load->view( admin_root('geo_country_view'), $data );
		}
	}

	public function addprocess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('name') ) OR empty( $this->input->post('countryIsoCode2') ) OR empty( $this->input->post('countryIsoCode3') )){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$nama 		= esc_sql( filter_txt( $this->input->post('name') ) );
				$countryIsoCode2 = esc_sql( filter_txt( $this->input->post('countryIsoCode2') ) );
				$countryIsoCode3 = esc_sql( filter_txt( $this->input->post('countryIsoCode3') ) );
				
				$nextId = getNextId('countryId', 'geo_country');

				$datacat = array(
					'countryId' => $nextId,
					'countryName' => $nama,
					'countryIsoCode2'=> $countryIsoCode2,
					'countryIsoCode3' => $countryIsoCode3,
					'countryStatus' => 1,
					'countryDeleted' => 0,
				);
				
				// insert data
				$query = $this->Env_model->insert('geo_country', $datacat);
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('geo_country/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('geo_country') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","geo_country", "countryId='{$id}'");

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
													'access' => admin_url('geo_country'),
													'permission' => 'view'
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('geo_country_edit'), $data );
		}
	}

	public function editprocess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('name') ) OR empty( $this->input->post('countryIsoCode2') ) OR empty( $this->input->post('countryIsoCode3') )){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$id 		= esc_sql( filter_int( $this->input->post('ID') ) );
				$nama 		= esc_sql( filter_txt( $this->input->post('name') ) );
				$countryIsoCode2 = esc_sql( filter_txt( $this->input->post('countryIsoCode2') ) );
				$countryIsoCode3 = esc_sql( filter_txt( $this->input->post('countryIsoCode3') ) );
				$active		= ($this->input->post('active') !==NULL) ? 1:0;

				$datacat = array(
					'countryName' => $nama,
					'countryIsoCode2'=> $countryIsoCode2,
					'countryIsoCode3' => $countryIsoCode3,
					'countryStatus' => $active,
				);
				
				// update data
				$query = $this->Env_model->update('geo_country', $datacat, "countryId='{$id}'");
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('geo_country/edit/'.$id) );
		}
	}

	protected function deleteAction($id){
		if( is_delete() ){
			$id = esc_sql( filter_int( $id ) );

			$set = array('countryDeleted' => time2timestamp() );
			$query = $this->Env_model->update('geo_country', $set, "countryId='{$id}'");

			if($query){
				return true;
			} else {
				return false;
			}
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

			redirect( admin_url('geo_country') );
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

							$queryact = Self::deleteAction($id);

							if($queryact){

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

					redirect( admin_url('geo_country') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('geo_country') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
