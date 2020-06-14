<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website_menu extends CI_Controller{ 

	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 30) );

		// load model
		$this->load->model('website_menu_model');
	}

	public function index(){
		if( is_view() ){

			// get menu category
			$datamncat = $this->Env_model->view_where_order('catId,catName,catDesc','categories',array('catActive'=>'1','catType'=>'webmenu'),'catId','DESC');
			$groupmenu = $this->input->get('groupmenu');

			$catmenuselected = '';
			$catmenu = array();
			foreach( $datamncat as $v ){
				if( !empty($groupmenu) ){
					if( $groupmenu == $v['catId'] ){
						$catmenuselected = $v['catId'];
					}
				} else {
					if($v['catDesc']=='primary'){
						$catmenuselected = $v['catId'];
					}
				}

				$catmenu[$v['catId']] = $v['catName'] . ( ($v['catDesc']=='primary') ?' ('.t('primary').')':'' );
			}

			$data = array( 
						'title' => $this->moduleName . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' =>  $this->moduleName,
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'menucat' => $catmenu,
						'menuselected' => $catmenuselected,
					);
			
			$this->load->view( admin_root('website_menu_view'), $data );
		}
	}

	public function addgroup(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('titlegroup') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$nama 		= esc_sql( filter_txt( $this->input->post('titlegroup') ) );
				
				$nextId = getNextId('catId', 'categories');

				$array_ins = array(
					'catId' => $nextId,
					'catName' => $nama,
					'catSlug'=> (string) '',
					'catColor' => (string) '',
					'catActive' => '1',
					'catType' => 'webmenu',
				);

				$countgroup = countdata("categories","catType='webmenu'");
				if( $countgroup < 1){
					$dataprimary = array('catDesc' => 'primary');
				} else {
					$dataprimary = array('catDesc' =>  (string) '');
				}
				$array_ins = array_merge($array_ins, $dataprimary);
				
				// insert data
				$query = $this->Env_model->insert('categories', $array_ins);
				
			    if($query){

					// add store
					$datastore = array(
						'catId' => $nextId,
						'storeId' => storeId()
					);
					$query = $this->Env_model->insert('category_store', $datastore);

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('website_menu/?groupmenu='.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('website_menu') );
		}
	}

	public function editgroup(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('titlegroup') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$nama = esc_sql( filter_txt( $this->input->post('titlegroup') ) );
				$id   = esc_sql( filter_int( $this->input->post('idgroup') ) );

				$dataupdate = array(
					'catName' => $nama,
				);

				if( !empty( $this->input->post('primary') ) ){
					if($this->input->post('primary') == 'y'){
						// update primary menu first
						$this->Env_model->update("categories",array('catDesc' => (string) ''),"catType='webmenu'");
		
						$dataprimary = array('catDesc' => 'primary');
						$dataupdate = array_merge($dataupdate, $dataprimary);
					}
				}
				
				// insert data
				$query = $this->Env_model->update('categories', $dataupdate, array('catId'=>$id,'catType'=>'webmenu'));
				
			    if($query){
					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('website_menu/?groupmenu='.$id) );
			
		}
	}

	public function edit($id){
		if( is_edit() ){
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
													'access' => admin_url('website_menu/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('website_menu'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('website_menu_edit'), $data );
		}
	}

	protected function deleteGroupAction($id){
		if( is_delete() ){
			$id = esc_sql( filter_int($id) );
			$result = false;

			// check if category group is primary menu
			if( countdata('categories', "catId='{$id}' AND catDesc!='primary'" ) > 0 ){
				$dcatrel = $this->Env_model->view_where("*", 'category_relationship', "catId='{$id}' AND crelRelatedType='webmenu'" );
				foreach($dcatrel as $datarel){
					// remove menu first
					$this->Env_model->delete('website_menu', array('menuId'=>$datarel['relatedId']));
				}

				// and then remove relastionship data
				$delete = $this->Env_model->delete('category_relationship', array('catId'=>$id, 'crelRelatedType'=> 'webmenu'));

				if($delete){
					// remove category
					$this->Env_model->delete('categories', array('catId'=>$id, 'catType'=> 'webmenu'));

					// remove category store
					$this->Env_model->delete('category_store', array('catId'=>$id));

					$result = true;
				}

			}

			return $result;
			
		}
	}
	public function deletegroup($id){
		if( is_delete() ){
			
			$update = $this->deleteGroupAction($id);

			if( $update ){

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}
			redirect( admin_url('website_menu') );
		}
	}

}
