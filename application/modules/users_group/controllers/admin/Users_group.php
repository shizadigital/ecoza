<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_group extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('users_group_model');
	}

	public function index(){
		if( is_view() ){

			$data = array( 
						'title' => t('usergroup') . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => '',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('users_group/tambah'),
												'permission' => 'add'
											)
										),
						'datalevel' => $this->users_group_model->getLevelUsers()
					);
			
			$this->load->view( admin_root('users_group_view'), $data );
		}
	}

	public function tambah(){
		if( is_add() ){
			$data = array( 
							'title' => t('usergroup') . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => t('addnewusergroup'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('users_group')
												)
											),
						);

			$this->load->view( admin_root('users_group_add'), $data );
		}
	}
	public function prosestambah(){
		if( is_add() ){
			$error = false;
			if( empty($this->input->post('access_name')) ){
				$error = "<strong>".t('error')."</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$modulName 	= esc_sql(filter_txt($this->input->post('access_name')));

				$nextID = getNextId('levelId','users_level');

				$insvalue = array(
		                      'levelId'     => $nextID,
		                      'levelName'	=> $modulName,
		                      'levelActive'	=> $this->input->post('mod_active')
		                );

				$query = $this->Env_model->insert('users_level', $insvalue);

				if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd') );
		    		redirect( admin_url('users_group/edit/'.$nextID) );
				} else {
					$error = "<strong>".t('error')."!!</strong> ".t('cannotprocessdata');
				}

			}

			if($error){
		    	$this->session->set_flashdata( 'failed', $error );
		    	redirect( admin_url('users_group/tambah') );
		    }
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );

			$datagroup = $this->Env_model->view_where('*','users_level',"levelId='{$id}'")[0];

			$data = array( 
							'title' => t('usergroup') . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => t('editusergroup'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => t('addnew'),
													'icon'	=> 'fe fe-plus',
													'access' => admin_url('users_group/tambah'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('users_group')
												)
											),
							'data' => $datagroup
						);

			$this->load->view( admin_root('users_group_edit'), $data );
		}
	}
	public function prosesedit(){
		if( is_edit() ){
			$error = false;
			if( empty($this->input->post('access_name')) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$id = esc_sql( filter_int($this->input->post('ID')) );
				$modulName 	= esc_sql(filter_txt($this->input->post('access_name')));

				$mod_active = empty( $this->input->post('mod_active') ) ? "n":"y";

				$datavalue = array(
		                      'levelName'	=> $modulName,
		                      'levelActive'	=> $this->input->post('mod_active')
		                );

				$query = $this->Env_model->update('users_level', $datavalue, "levelId='{$id}'");

				if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyupdated') );
		    		redirect( admin_url('users_group/edit/'.$id) );
				} else {
					$error = "<strong>".t('error')."!!</strong> ". t('cannotprocessdata');
				}

			}

			if($error){
		    	$this->session->set_flashdata( 'failed', $error );
		    	redirect( admin_url('users_group/tambah') );
		    }
		}
	}

	public function updatelist(){
		if( is_edit() ){

			foreach ($this->input->post('idaccess') as $key => $value) {

				$stataccess = (empty($this->input->post('mod_active')[$value])) ? "n" : "y";

				$data = array(
					'levelActive' => $stataccess
				);

				$queryact = $this->Env_model->update('users_level', $data, "levelId='{$value}'");
			}

			$this->session->set_flashdata( 'succeed', t('successfullyupdated') );
		    redirect( admin_url('users_group') );
		}
	}

}