<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currencies extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 23) );

		// load model
		$this->load->model('currencies_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'currency';

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "curTitle LIKE '%{$kw}%' OR curCode LIKE '%{$kw}%'";
				$excClause = " ( $queryserach )";				
            }

			$perPage = 30;

			$where = $excClause;
			if( empty($where) ){
				$datauser = $this->Env_model->view_order_limit('*', $table, 'curId', 'DESC', $perPage, $datapage);
				$rows = countdata($table);
			} else {
				$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'curId', 'DESC', $perPage, $datapage);
				$rows = countdata($table, $where);
			}
			
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
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('currencies/addnew'),
												'permission' => 'add'
											)
										),
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('currencies_view'), $data );
		}
	}

	public function addnew(){
		if( is_add() ){

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
													'access' => admin_url('currencies'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('currencies_add'), $data );
		}
	}

	public function addproccess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('judul') ) OR empty( $this->input->post('kode') ) OR empty( $this->input->post('decimal_place') ) OR empty( $this->input->post('rate') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(empty($this->input->post('prefix')) AND empty($this->input->post('suffix'))){
				$error = "<strong>".t('error')."</strong> ".t('prefixsuffixempty');
			}

			if(!$error){
				$judul 			= esc_sql(filter_txt($this->input->post('judul')));
				$kode 			= esc_sql(filter_txt($this->input->post('kode')));
				$prefix 		= esc_sql(filter_txt($this->input->post('prefix')));
				$suffix 		= esc_sql(filter_txt($this->input->post('suffix')));
				$decimal_place 	= esc_sql(filter_int($this->input->post('decimal_place')));
				$rate 			= esc_sql(filter_txt($this->input->post('rate')));
				$rate_foreign   = esc_sql(filter_txt($this->input->post('rate_foreign')));
				$status 		= esc_sql(filter_int($this->input->post('status')));
				
				$nextID = getNextId('curId','currency');

				$now = time2timestamp();
				
				// rate condition
				$rate = singleComma($rate);
				$exp_rate = explode(".", $rate);
		
				if(count($exp_rate) > 1){ $value_rate = $rate; }
				else { $value_rate = $exp_rate[0] .".00000000"; }
		
				// rate foreign condition
				$rate_foreign = singleComma($rate_foreign);
				$exp_rate_foreign = explode(".", $rate_foreign);
		
				if(count($exp_rate_foreign) > 1){ $value_rate_foreign = $rate_foreign; }
				else { $value_rate_foreign = $exp_rate_foreign[0] .".00000000"; }

				$arrayfieldins = array(
					"curId"         	=> $nextID,
					"curTitle"       	=> $judul,
					"curCode"       	=> $kode,
					"curPrefixSymbol" 	=> (string) $prefix,
					"curSuffixSymbol"	=> (string) $suffix,
					"curRate"      		=> strval($value_rate),
					"curForeignCurrencyToDefault" => strval($value_rate_foreign),
					"curDecimalPlace"	=> strval($decimal_place),
					"curModifiedDate"	=> $now,
					'curUpdateMethod' 	=> 'automatic',
					"curStatus"			=> $status
				);
				
				// insert data
				$query = $this->Env_model->insert('currency', $arrayfieldins);
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('currencies/edit/'.$nextID) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('currencies/addnew/') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","currency", "curId='{$id}'");

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
													'access' => admin_url('currencies/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('currencies'),
													'permission' => 'view'
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('currencies_edit'), $data );
		}
	}

	public function editproccess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('judul') ) OR empty( $this->input->post('kode') ) OR empty( $this->input->post('decimal_place') ) OR empty( $this->input->post('rate') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(empty($this->input->post('prefix')) AND empty($this->input->post('suffix'))){
				$error = "<strong>".t('error')."!!</strong> ".t('prefixsuffixempty');
			}

			if(!$error){
				$judul 			= esc_sql(filter_txt($this->input->post('judul')));
				$kode 			= esc_sql(filter_txt($this->input->post('kode')));
				$prefix 		= esc_sql(filter_txt($this->input->post('prefix')));
				$suffix 		= esc_sql(filter_txt($this->input->post('suffix')));
				$decimal_place 	= esc_sql(filter_int($this->input->post('decimal_place')));
				$rate 			= esc_sql(filter_txt($this->input->post('rate')));
				$rate_foreign   = esc_sql(filter_txt($this->input->post('rate_foreign')));
				$status 		= esc_sql(filter_int($this->input->post('status')));
				
				$ID = esc_sql(filter_int($this->input->post('ID')));

				$now = time2timestamp();
				
				// rate condition
				$rate = singleComma($rate);
				$exp_rate = explode(".", $rate);
		
				if(count($exp_rate) > 1){ $value_rate = $rate; }
				else { $value_rate = $exp_rate[0] .".00000000"; }
		
				// rate foreign condition
				$rate_foreign = singleComma($rate_foreign);
				$exp_rate_foreign = explode(".", $rate_foreign);
		
				if(count($exp_rate_foreign) > 1){ $value_rate_foreign = $rate_foreign; }
				else { $value_rate_foreign = $exp_rate_foreign[0] .".00000000"; }

				$arrayfieldins = array(
					"curTitle"       	=> $judul,
					"curCode"       	=> $kode,
					"curPrefixSymbol" 	=> (string) $prefix,
					"curSuffixSymbol"	=> (string) $suffix,
					"curRate"      		=> strval($value_rate),
					"curForeignCurrencyToDefault" => strval($value_rate_foreign),
					"curDecimalPlace"	=> strval($decimal_place),
					"curModifiedDate"	=> $now,
					'curUpdateMethod' 	=> esc_sql(filter_txt($this->input->post('update_method'))),
					"curStatus"			=> $status
				);
				
				// insert data
				$query = $this->Env_model->update('currency', $arrayfieldins, array('curId'=>$ID));
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('currencies/edit/'.$ID) );
		}
	}

	public function delete($id){
		if( is_delete() ){
			$id = filter_int($id);

			// get value currency
			$getval = getval("curCode,curPrefixSymbol,curSuffixSymbol", "currency","curId='{$id}'");

			if($getval['curCode'] == get_option('defaultcurrency') ){
				$error = "<strong>".t('error')."!!</strong> ".sprintf( t('cannotremovedefault'), get_option('defaultcurrency') );
			}

			if(!$error){
				$query = $this->Env_model->delete('currency', array('curId'=>$id) );

				if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
				} else {
					$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			} else {
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('currencies') );
		}
	}

	public function editstatus($id){
		if( is_edit() ){
			$id = filter_int($id);

			$status = 0;
			if($this->input->get('s')=='1'){
				$status = esc_sql(filter_int($this->input->get('s')));
			}

			$actquery = $this->Env_model->update("currency",array('curStatus' => $status), array('curId' => $id) );
		
			if($actquery){
				$this->session->set_flashdata( 'succeed', t('successfullyupdated') );
			} else {
				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
			}

			redirect( admin_url('currencies') );
		}
	}

	public function ajax_changemethodeupdate(){

		if( is_edit() ){

			$data = explode('#', $this->input->post('method') );
			$ID = filter_int($data[0]);
			$method = filter_txt($data[1]);

			$update = $this->Env_model->update("currency",array('curUpdateMethod' => $method), array('curId' => $ID) );
			if($update){
				echo 'ok';
			} 

		}

	}

}
