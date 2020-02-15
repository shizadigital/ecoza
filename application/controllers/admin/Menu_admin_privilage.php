<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_admin_privilage extends CI_Controller{

	protected $menu_data = array();

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('menu_admin_privilage_model');

		// load model menu admin master
		$this->load->model('menu_admin_master_model');

		// start load menu data here
		$queryMenu1 = $this->menu_admin_master_model->getAdminMenuInPage();
		$x=0;
        foreach ($queryMenu1 as $dm1) {
        	$this->menu_data[$x] = $dm1;

        	$idlevel = esc_sql( filter_int( $this->input->get('levelaccess') ) );
        		
        	// get menu access
        	if( !empty($this->input->get('levelaccess')) AND $this->Env_model->countdata('users_menu_access',"menuId = '{$dm1['menuId']}' AND levelId='{$idlevel}'") > 0){
        		$getaccmenu1 = $this->Env_model->getval('lmnView,lmnAdd,lmnEdit,lmnDelete','users_menu_access',"menuId = '{$dm1['menuId']}' AND levelId='{$idlevel}'");
        		$this->menu_data[$x]['menuaccess'] = $getaccmenu1;
        	} else {
        		$this->menu_data[$x]['menuaccess'] = array('lmnView'=>'n','lmnAdd'=>'n','lmnEdit'=>'n','lmnDelete'=>'n');
        	}

            $numnumMenu2 = $this->menu_admin_master_model->rowsAdminMenuInPage($dm1['menuId']);
            if($numnumMenu2>0){
            	$queryMenu2 = $this->menu_admin_master_model->getAdminMenuInPage($dm1['menuId']);

            	$xx=0;
            	foreach ($queryMenu2 as $dm2) {
                	$this->menu_data[$x]['level_2'][$xx] = $dm2;

                	// get menu access
		        	if( !empty($this->input->get('levelaccess')) AND $this->Env_model->countdata('users_menu_access',"menuId = '{$dm2['menuId']}' AND levelId='{$idlevel}'") > 0){
		        		$getaccmenu2 = $this->Env_model->getval('lmnView,lmnAdd,lmnEdit,lmnDelete','users_menu_access',"menuId = '{$dm2['menuId']}' AND levelId='{$idlevel}'");
		        		$this->menu_data[$x]['level_2'][$xx]['menuaccess'] = $getaccmenu2;
		        	} else {
		        		$this->menu_data[$x]['level_2'][$xx]['menuaccess'] = array('lmnView'=>'n','lmnAdd'=>'n','lmnEdit'=>'n','lmnDelete'=>'n');
		        	}

                	$numnumMenu3 = $this->menu_admin_master_model->rowsAdminMenuInPage($dm2['menuId']);
	                if($numnumMenu3>0){
	                	$queryMenu3 = $this->menu_admin_master_model->getAdminMenuInPage($dm2['menuId']);

	                	$xxx=0;
	                	foreach ($queryMenu3 as $dm3) {
                			$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx] = $dm3;

                			// get menu access
				        	if( !empty($this->input->get('levelaccess')) AND $this->Env_model->countdata('users_menu_access',"menuId = '{$dm3['menuId']}' AND levelId='{$idlevel}'") > 0){
				        		$getaccmenu3 = $this->Env_model->getval('lmnView,lmnAdd,lmnEdit,lmnDelete','users_menu_access',"menuId = '{$dm3['menuId']}' AND levelId='{$idlevel}'");
				        		$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['menuaccess'] = $getaccmenu3;
				        	} else {
				        		$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['menuaccess'] = array('lmnView'=>'n','lmnAdd'=>'n','lmnEdit'=>'n','lmnDelete'=>'n');
				        	}

                			$numnumMenu4 = $this->menu_admin_master_model->rowsAdminMenuInPage($dm3['menuId']);
			                if($numnumMenu4>0){
			                	$queryMenu4 = $this->menu_admin_master_model->getAdminMenuInPage($dm3['menuId']);

			                	$xxxx=0;
			                	foreach ($queryMenu4 as $dm4) {
			                		$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['level_4'][$xxxx] = $dm4;
			                		// get menu access
						        	if( !empty($this->input->get('levelaccess')) AND $this->Env_model->countdata('users_menu_access',"menuId = '{$dm4['menuId']}' AND levelId='{$idlevel}'") > 0){
						        		$getaccmenu4 = $this->Env_model->getval('lmnView,lmnAdd,lmnEdit,lmnDelete','users_menu_access',"menuId = '{$dm4['menuId']}' AND levelId='{$idlevel}'");
						        		$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['level_4'][$xxxx]['menuaccess'] = $getaccmenu4;
						        	} else {
						        		$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['level_4'][$xxxx]['menuaccess'] = array('lmnView'=>'n','lmnAdd'=>'n','lmnEdit'=>'n','lmnDelete'=>'n');
						        	}

			                		$xxxx++;
			                	}
			                } else {
			                	$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['level_4'] = array();
			                }

	                		$xxx++;
	                	}
	                } else {
	                	$this->menu_data[$x]['level_2'][$xx]['level_3'] = array();
	                }

                	$xx++;
                }

            } else {
            	$this->menu_data[$x]['level_2'] = array();
            }

            $x++;
        }
		// end load menu data here
	}

	public function index(){
		if( is_view() ){
			$datalevel = $this->Env_model->view_where('*','users_level',array('levelActive'=>'y'));

			$levelaccessdata = '';
			$accessname = '';
			$totalmenudata = 0;
			if(!empty($this->input->get('levelaccess'))){
				$idlevel = esc_sql( filter_int($this->input->get('levelaccess') ) );
				$dataleveaccess = $this->Env_model->getval('levelId,levelName','users_level',"levelId='$idlevel' AND levelActive='y'");
				$accessname = $dataleveaccess['levelName'];

				$totalmenudata = $this->Env_model->countdata('users_menu');
			}

			$data = array( 
						'title' => 'Menu Admin Privilage- '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => '',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(),
						'data' => array(
							'datalevel' => $datalevel,
							'levelaccessdata' =>$levelaccessdata,
							'accessname'=>$accessname,
							'menudata'=>$this->menu_data,
							'totalmenudata'=>$totalmenudata
						)
					);
			
			$this->load->view( admin_root('menu_admin_privilage/menu_admin_privilage_view'), $data );
		}
	}

	public function updatecrudacc(){
		if(is_edit()){
			foreach ($this->input->post('idmenu') as $key => $value) {
				$viewv   = (empty($this->input->post('mod_view')[$value])) ? "n" : $this->input->post('mod_view')[$value];
				$addv    = (empty($this->input->post('mod_add')[$value])) ? "n" : $this->input->post('mod_add')[$value];
				$editv   = (empty($this->input->post('mod_edit')[$value])) ? "n" : $this->input->post('mod_edit')[$value];
				$deletev = (empty($this->input->post('mod_delete')[$value])) ? "n" : $this->input->post('mod_delete')[$value];

				$numgetacc = $this->Env_model->countdata('users_menu_access', array('levelId'=>$this->input->post('levelaccess'),'menuId'=>$value));

				if($numgetacc>0){
					$updatedata = array(
						'lmnView' => $viewv,
						'lmnAdd' => $addv,
						'lmnEdit' => $editv,
						'lmnDelete' => $deletev
					);
					$query = $this->Env_model->update('users_menu_access', $updatedata, array('levelId'=>$this->input->post('levelaccess'),'menuId'=>$value) );
					if(!$query){
						$error = "<strong>ERROR</strong> Data tidak dapat diproses";
						break;
					}
				} else {
					$nextID = $this->Env_model->getNextId('lmnId', 'users_menu_access');

					$datains = array(
						'lmnId' => $nextID,
						'levelId' => $this->input->post('levelaccess'),
						'menuId' => $value,
						'lmnView' => $viewv,
						'lmnAdd' => $addv,
						'lmnEdit' => $editv,
						'lmnDelete' => $deletev
					);

					$query = $this->Env_model->insert('users_menu_access', $datains);
					if(!$query){
						$error = "<strong>Error</strong> Data tidak dapat diproses";
						break;
					}
				}		
			}
			
			if(!$error){ 
				$this->session->set_flashdata( 'sukses', 'Data berhasil diperbarui' );
			} else {		
				$this->session->set_flashdata( 'gagal', $error );
			}
			redirect( admin_url('menu_admin_privilage/?act=detail_access&levelaccess='.$this->input->post('levelaccess')) );
		}
	}

}
?>