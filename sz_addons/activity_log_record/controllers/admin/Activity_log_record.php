<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log_record extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = $this->add_ons->addonName('activity_log_record');

		// load model
		$this->load->model('activity_log_record_model');
	}

	public function index(){
		if( is_view() ){
			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'activity_log';
			$where = "storeId='".storeId()."'";

			$excClause = '';

            if(!empty($this->input->get('username'))){
				$kw = $this->security->xss_clean( $this->input->get('username') );

				$queryserach = "userLogin LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";
            }

			if( !empty($this->input->get('startdate')) OR !empty($this->input->get('enddate'))){
				if( !empty($this->input->get('startdate'))){
					$ex_startDate = explode('-',$this->input->get('startdate'));
					$date1 = $ex_startDate[2].'-'.$ex_startDate[1].'-'.$ex_startDate[0];
				}
				
				if( !empty($this->input->get('enddate'))){
					$ex_endDate = explode('-',$this->input->get('enddate'));
					$date2 = $ex_endDate[2].'-'.$ex_endDate[1].'-'.$ex_endDate[0];
				}


				if( !empty($this->input->get('startdate')) AND !empty($this->input->get('enddate'))){
					$queryserach = "date(logDateTime) BETWEEN '{$date1}' AND '{$date2}'";
				}
				if( !empty($this->input->get('startdate')) AND empty($this->input->get('enddate'))){
					$queryserach = "date(logDateTime) = '{$date1}'";
				}
				if( empty($this->input->get('startdate')) AND !empty($this->input->get('enddate'))){
					$queryserach = "date(logDateTime) = '{$date2}'";
				}

				$excClause = " AND ( $queryserach )";
			}

			$perPage = 30;

			$where = $where.$excClause;

			$param = [
				'where' => $where,
				'order' => ['logId' => 'DESC'],
				'limit' => [$perPage, $datapage]
			];

			$datauser = $this->sm->viewData('*', $table, $param);

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
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('pages/addnew'),
												'permission' => 'add'
											)
										),
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('activity_log_record_view'), $data );
		}
	}

	protected function truncateAction(){
		if( is_delete() ){

			$query = $this->sm->truncate('activity_log');
			if($query){
				return true;
			} else {
				return false;
			}
		}
	}
	public function truncate(){
		if( is_delete() ){

			$query = $this->truncateAction();
			if($query){

				$this->activity_log->set_log(t('log_delete_in').$this->moduleName, 'truncate', 'activity_log');
				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->activity_log->set_log(t('log_delete_failed_in').$this->moduleName, 'truncate');
				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}

			redirect( admin_url( $this->uri->segment(2) ) );
		}
	}

	public function active(){
		if( is_edit() ){

			if(check_option('logactivity')){
				$set = set_option('logactivity', 'y');
			}else{
				$set = add_option('logactivity', 'y');
			}

			if( $set ){

				$id = getval('optionId','options', ['optionName'=>'logactivity']);

				$this->activity_log->set_log(t('log_edit_in').$this->moduleName.' (active)', 'update', 'option', $id);

				$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			} else {
				$this->activity_log->set_log(t('log_edit_failed_in').$this->moduleName.' (active)', 'update');

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
			}

			redirect( admin_url( $this->uri->segment(2) ) );
		}
	}


	public function inactive(){
		if( is_edit() ){

			if(check_option('logactivity')){
				$set = set_option('logactivity', 'n');
			}else{
				$set = add_option('logactivity', 'n');
			}

			$getId = getNextId('logId', 'activity_log');

			if( $set ){

				$id = getval('optionId','options', ['optionName'=>'logactivity']);

				$logData = [
					'logId' => $getId,
					'storeId' => storeId(),
					'userLogin' => (string) filter_txt($this->session->userdata('username')),
					'logTable' => 'options',
					'logIdMaster' => $id,
					'logType' => 'update',
					'logDescription' => t('log_edit_in').$this->moduleName.' (inactive)',
					'logURL' => this_url(),
					'logDateTime' => date('Y-m-d H:i:s'),
					'logIP' => getIP(),
					'logBrowser' => getBrowser(true),
					'logOS' => getOS()
				];

				$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
			} else {

				$logData = [
					'logId' => $getId,
					'storeId' => storeId(),
					'userLogin' => (string) filter_txt($this->session->userdata('username')),
					'logTable' => 'options',
					'logIdMaster' => 0,
					'logType' => 'update',
					'logDescription' => t('log_edit_in').$this->moduleName.' (inactive)',
					'logURL' => this_url(),
					'logDateTime' => date('Y-m-d H:i:s'),
					'logIP' => getIP(),
					'logBrowser' => getBrowser(true),
					'logOS' => getOS()
				];

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
			}


			$this->sm->insert('activity_log', $logData);

			redirect( admin_url( $this->uri->segment(2) ) );
		}
	}

}
