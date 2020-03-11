<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Length_unit extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 20) );

		// load model
		$this->load->model('length_unit_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'unit_length';
			$where = "";

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "lengthTitle LIKE '%{$kw}%' OR lengthUnit LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";
				
				// check multilanguage
				$lang = get_cookie('admin_lang');
				if( $lang != $this->config->item('language') ){
					// check the keyword here
					$dataidresult = $this->Env_model->view_where("dtRelatedId","dynamic_translations","dtRelatedTable='{$table}' AND dtLang='{$lang}' AND ( dtRelatedId IN (SELECT lengthId FROM ".$this->db->dbprefix($table)." WHERE lengthId=dtRelatedId) AND (dtRelatedField='lengthTitle' AND dtTranslation LIKE '%{$kw}%') OR (dtRelatedField='lengthUnit' AND dtTranslation LIKE '%{$kw}%') ) ");

					$standardlangcount = countdata($table, $where . $excClause);

					if( count($dataidresult)>0 ){
						$resultlangsearch = array();
						foreach($dataidresult AS $key => $val){
							$resultlangsearch[] = $val['dtRelatedId'];
						}

						$querysearchlang = ($standardlangcount > 0) ? '(':'';
						$querysearchlang .= '( lengthId=\'' .implode('\' OR lengthId=\'', $resultlangsearch). '\' )';

						if( $standardlangcount > 0 ){
							$querysearchlang .= " OR (".$queryserach.")";
						}

						$querysearchlang .= ($standardlangcount > 0) ? ')':'';

						$excClause = " AND $querysearchlang";
						
					} else {
						if($standardlangcount < 1){
							$excClause = " AND lengthTitle='' AND lengthUnit=''";
						}
					}
				}
            }

			$perPage = 30;

			if( empty($where) ){
				$where = $where.$excClause;
				$datauser = $this->Env_model->view_order_limit('*', $table, 'lengthId', 'DESC', $perPage, $datapage);
				$rows = countdata($table);
			} else {
				$where = $where.$excClause;
				$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'lengthId', 'DESC', $perPage, $datapage);
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
			
			$this->load->view( admin_root('length_unit_view'), $data );
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
				
				$default = 'n';
				
				$nextId = getNextId('lengthId', 'unit_length');

				// if default this data, set old default data to n
				if( $this->input->post('default') == 'y' ){
					$this->Env_model->update('unit_length', array('lengthDefault'=>'n'), array('lengthDefault'=>'y') );

					$default = 'y';
				}

				$dataunit = array(
					'lengthId' => $nextId,
					'lengthTitle' => $unitexplanation,
					'lengthUnit'=> $unitname,
					'lengthValue' => singleComma($value),
					'lengthDefault' => $default
				);
				
				// insert data
				$query = $this->Env_model->insert('unit_length', $dataunit);
				
			    if($query){
					// insert or update data translation
					translate_pushdata('unitexplanation', 'unit_length', 'lengthTitle', $nextId );
					translate_pushdata('unitname', 'unit_length', 'lengthUnit', $nextId );

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('length_unit/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('length_unit') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","unit_length", "lengthId='{$id}'");
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
													'access' => admin_url('length_unit')
												)
											),
							'data' => $getdata
						);

			$this->load->view( admin_root('length_unit_edit'), $data );
		}
	}

	public function editprocess(){
		if(is_edit()){
			$error = false;

			if( empty( $this->input->post('unitname') ) OR empty( $this->input->post('unitexplanation') ) OR empty( $this->input->post('value') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$ID = esc_sql( filter_int( $this->input->post('ID') ) );

				$unitname = esc_sql( filter_txt( $this->input->post('unitname') ) );
				$unitexplanation = esc_sql( filter_txt( $this->input->post('unitexplanation') ) );
				$value 	= esc_sql( filter_txt( $this->input->post('value') ) );
				
				$default = 'n';

				// if default this data, set old default data to n
				if( $this->input->post('default') == 'y' ){
					$this->Env_model->update('unit_length', array('lengthDefault'=>'n'), array('lengthDefault'=>'y') );

					$default = 'y';
				}

				$dataunit = array(
					'lengthTitle' => $unitexplanation,
					'lengthUnit'=> $unitname,
					'lengthValue' => singleComma($value),
					'lengthDefault' => $default
				);
				
				// insert data
				$query = $this->Env_model->update('unit_length', $dataunit, array('lengthId' => $ID));
				
			    if($query){
					// insert or update data translation
					translate_pushdata('unitexplanation', 'unit_length', 'lengthTitle', $ID );
					translate_pushdata('unitname', 'unit_length', 'lengthUnit', $ID );

					$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('length_unit/edit/'.$ID) );
		}
	}

	public function delete($id){
		if( is_delete() ){
			$id = esc_sql( filter_int( $id ) );

			$where = array('lengthId' => $id);
			$query = $this->Env_model->delete('unit_length', $where);

			if($query){

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}

			redirect( admin_url('length_unit') );
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

							$where = array('lengthId' => $id);
							$query = $this->Env_model->delete('unit_length', $where);

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

					redirect( admin_url('length_unit') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('length_unit') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
