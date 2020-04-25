<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weight_unit extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 19) );

		// load model
		$this->load->model('weight_unit_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'unit_weight';
			$where = "";

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "weightTitle LIKE '%{$kw}%' OR weightUnit LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";
				
				// check multilanguage
				$lang = get_cookie('admin_lang');
				if( $lang != $this->config->item('language') ){
					// check the keyword here
					$dataidresult = $this->Env_model->view_where("dtRelatedId","dynamic_translations","dtRelatedTable='{$table}' AND dtLang='{$lang}' AND ( dtRelatedId IN (SELECT weightId FROM ".$this->db->dbprefix($table)." WHERE weightId=dtRelatedId) AND (dtRelatedField='weightTitle' AND dtTranslation LIKE '%{$kw}%') OR (dtRelatedField='weightUnit' AND dtTranslation LIKE '%{$kw}%') ) ");

					$standardlangcount = countdata($table, $where . $excClause);

					if( count($dataidresult)>0 ){
						$resultlangsearch = array();
						foreach($dataidresult AS $key => $val){
							$resultlangsearch[] = $val['dtRelatedId'];
						}

						$querysearchlang = ($standardlangcount > 0) ? '(':'';
						$querysearchlang .= '( weightId=\'' .implode('\' OR weightId=\'', $resultlangsearch). '\' )';

						if( $standardlangcount > 0 ){
							$querysearchlang .= " OR (".$queryserach.")";
						}

						$querysearchlang .= ($standardlangcount > 0) ? ')':'';

						$excClause = " AND $querysearchlang";
						
					} else {
						if($standardlangcount < 1){
							$excClause = " AND weightTitle='' AND weightUnit=''";
						}
					}
				}
            }

			$perPage = 30;

			if( empty($where) ){
				$where = $where.$excClause;
				$datauser = $this->Env_model->view_order_limit('*', $table, 'weightId', 'DESC', $perPage, $datapage);
				$rows = countdata($table);
			} else {
				$where = $where.$excClause;
				$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'weightId', 'DESC', $perPage, $datapage);
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
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('weight_unit_view'), $data );
		}
	}

	public function addingprocess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('unitname') ) OR empty( $this->input->post('unitexplanation') ) OR empty( $this->input->post('value') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$unitname = esc_sql( filter_txt( $this->input->post('unitname') ) );
				$unitexplanation = esc_sql( filter_txt( $this->input->post('unitexplanation') ) );
				$value 	= esc_sql( filter_txt( $this->input->post('value') ) );
				
				$nextId = getNextId('weightId', 'unit_weight');

				// if default this data, set old default data to n
				$default = 'n';
				if( countdata('unit_weight') > 0 ){
					if( $this->input->post('default') == 'y' ){
						$this->Env_model->update('unit_weight', array('weightDefault'=>'n'), array('weightDefault'=>'y') );
						$default = 'y';
					}
				} else {
					$default = 'y';
				}

				$dataunit = array(
					'weightId' => $nextId,
					'weightTitle' => $unitexplanation,
					'weightUnit'=> $unitname,
					'weightValue' => singleComma($value),
					'weightDefault' => $default
				);
				
				// insert data
				$query = $this->Env_model->insert('unit_weight', $dataunit);
				
			    if($query){
					// insert or update data translation
					translate_pushdata('unitexplanation', 'unit_weight', 'weightTitle', $nextId );
					translate_pushdata('unitname', 'unit_weight', 'weightUnit', $nextId );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('weight_unit/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('weight_unit') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","unit_weight", "weightId='{$id}'");

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
													'access' => admin_url('weight_unit'),
													'permission' => 'view'
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('weight_unit_edit'), $data );
		}
	}

	public function editprocess(){
		if(is_edit()){
			$error = false;
			$ID = esc_sql( filter_int( $this->input->post('ID') ) );

			if( empty( $this->input->post('unitname') ) OR empty( $this->input->post('unitexplanation') ) OR empty( $this->input->post('value') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			// check if old data default not choose
			if(countdata('unit_weight',"weightDefault='y' AND weightId='{$ID}'") > 0 AND $this->input->post('default') != 'y'){
				$error = "<strong>".t('error')."!!</strong> ".t('defaultnotselected');
			}

			if(!$error){

				$unitname = esc_sql( filter_txt( $this->input->post('unitname') ) );
				$unitexplanation = esc_sql( filter_txt( $this->input->post('unitexplanation') ) );
				$value 	= esc_sql( filter_txt( $this->input->post('value') ) );

				// if default this data, set old default data to n
				$default = 'n';
				if( countdata('unit_weight') > 0 ){
					if( $this->input->post('default') == 'y' ){
						$this->Env_model->update('unit_weight', array('weightDefault'=>'n'), array('weightDefault'=>'y') );
						$default = 'y';
					}
				} else {
					$default = 'y';
				}

				$dataunit = array(
					'weightTitle' => $unitexplanation,
					'weightUnit'=> $unitname,
					'weightValue' => singleComma($value),
					'weightDefault' => $default
				);
				
				// insert data
				$query = $this->Env_model->update('unit_weight', $dataunit, array('weightId' => $ID));
				
			    if($query){
					// insert or update data translation
					translate_pushdata('unitexplanation', 'unit_weight', 'weightTitle', $ID );
					translate_pushdata('unitname', 'unit_weight', 'weightUnit', $ID );

					$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('weight_unit/edit/'.$ID) );
		}
	}


	protected function deleteAction($id){
		if( is_delete() ){
			$id = esc_sql( filter_int( $id ) );

			$where = array('weightId' => $id);
			$query = $this->Env_model->delete('unit_weight', $where);
			if($query){
				// remove translate
				translate_removedata('unit_weight', $id );
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

			redirect( admin_url('weight_unit') );
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

					redirect( admin_url('weight_unit') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('weight_unit') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
