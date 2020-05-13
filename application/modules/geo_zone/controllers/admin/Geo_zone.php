<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geo_zone extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 28) );

		// load model
		$this->load->model('geo_zone_model');
	}

	public function index(){
		if( is_view() ){
			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'geo_zone';
			$where = "zoneDeleted='0'";

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "zoneName LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";
            }

			$perPage = 30;

			$where = $where.$excClause;
			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'zoneId', 'DESC', $perPage, $datapage);

			$rows = countdata($table, $where);
			$pagingURI = admin_url( $this->uri->segment(2) );

			$this->load->library('paging');

			$optpaging = array('num_links'=>4);
			$pagination = $this->paging->PaginationAdmin( $pagingURI, $rows, $perPage, $optpaging);

			// get data country
			$datacntry = $this->Env_model->view_where_order('countryId,countryName','geo_country',array('countryDeleted'=>0,),'countryName','ASC');

			$country[''] = '-- '.t('country').' --';
			foreach( $datacntry as $v ){
				$country[$v['countryId']] = $v['countryName'];
			}

			$data = array( 
						'title' => $this->moduleName . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' =>  $this->moduleName,
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows,
						'selectcountry' => $country
					);
			
			$this->load->view( admin_root('geo_zone_view'), $data );
		}
	}

	public function addprocess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('country') ) OR empty( $this->input->post('name') ) OR empty( $this->input->post('code') )){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$nama 		= esc_sql( filter_txt( $this->input->post('name') ) );
				$country 	= esc_sql( filter_int( $this->input->post('country') ) );
				$code 		= esc_sql( filter_txt( $this->input->post('code') ) );
				
				$nextId = getNextId('zoneId', 'geo_zone');

				$datacat = array(
					'zoneId' => $nextId,
					'countryId' => $country,
					'zoneName'=> $nama,
					'zoneCode' => $code,
					'zoneStatus' => 1,
					'zoneDeleted' => 0,
				);
				
				// insert data
				$query = $this->Env_model->insert('geo_zone', $datacat);
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('geo_zone/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('geo_zone') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","geo_zone", "zoneId='{$id}'");

			// get data country
			$datacntry = $this->Env_model->view_where_order('countryId,countryName','geo_country',array('countryDeleted'=>0,),'countryName','ASC');

			$country[''] = '-- '.t('country').' --';
			foreach( $datacntry as $v ){
				$country[$v['countryId']] = $v['countryName'];
			}

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
													'access' => admin_url('geo_zone'),
													'permission' => 'view'
												)
											),
							'data' => $getdata,
							'selectcountry' => $country
						);

			$this->load->view( admin_root('geo_zone_edit'), $data );
		}
	}

	public function editprocess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('country') ) OR empty( $this->input->post('name') ) OR empty( $this->input->post('code') )){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$id 	= esc_sql( filter_int( $this->input->post('ID') ) );
				$nama 		= esc_sql( filter_txt( $this->input->post('name') ) );
				$country 	= esc_sql( filter_int( $this->input->post('country') ) );
				$code 		= esc_sql( filter_txt( $this->input->post('code') ) );
				$active		= ($this->input->post('active') !==NULL) ? 1:0;

				$datacat = array(
					'countryId' => $country,
					'zoneName'=> $nama,
					'zoneCode' => $code,
					'zoneStatus' => $active,
				);
				
				// update data
				$query = $this->Env_model->update('geo_zone', $datacat, "zoneId='{$id}'");
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('geo_zone/edit/'.$id) );
		}
	}

	protected function deleteAction($id){
		if( is_delete() ){
			$id = esc_sql( filter_int( $id ) );

			$set = array('zoneDeleted' => time2timestamp() );
			$query = $this->Env_model->update('geo_zone', $set, "zoneId='{$id}'");

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

			redirect( admin_url('geo_zone') );
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

					redirect( admin_url('geo_zone') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('geo_zone') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
