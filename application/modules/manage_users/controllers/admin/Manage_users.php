<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_users extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('manage_users_model');
	}

	public function index(){
		if( is_view() ){

			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$excClause = '';
            if( $this->session->userdata('leveluser') !='1'){
                $excClause .= " AND a.levelId !='1'";
            }

            if(!empty($this->input->get('kw'))){
            	$kw = $this->input->get('kw');
            	$excClause .= " AND (a.userDisplayName LIKE '%{$kw}%' OR a.userEmail LIKE '%{$kw}%' OR a.userLogin LIKE '%{$kw}%')";
            }

            $perPage = 30;

			$where = "a.levelId=b.levelId AND a.userDelete='0'".$excClause;
			$table = array( 'users a', 'users_level b');
			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'a.userDisplayName', 'ASC', $perPage, $datapage);

			$rows = countdata($table, $where);
			$pagingURI = admin_url( $this->uri->segment(2) );

			$this->load->library('paging');
			$pagination = $this->paging->PaginationAdmin( $pagingURI, $rows, $perPage );

			$data = array( 
						'title' => t('usermanagement') .' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => t('usermanagement'),
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('manage_users/tambah'),
												'permission' => 'add'
											)
										),
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('manage_users_view'), $data );
		}
	}

	public function tambah(){
		if( is_add() ){

			// get data level account
			$whereclause = "levelActive='y'";
			if( $this->session->userdata('leveluser') !='1'){
                $whereclause .= " AND levelId!='1'";
            }
			$datalevel = $this->Env_model->view_where_order('levelId,levelName','users_level', $whereclause, 'levelId', 'ASC');

			$data = array( 
							'title' => t('usermanagement') .' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => t('usermanagement'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('manage_users'),
													'permission' => 'view'
												)
											),
							'datalevel' => $datalevel
						);

			$this->load->view( admin_root('manage_users_add'), $data );
		}
	}
	public function prosestambah(){
		if( is_add() ){
			$error = false;

			if(empty($this->input->post('username')) OR empty($this->input->post('email')) OR empty($this->input->post('nama')) OR empty($this->input->post('pass')) OR empty($this->input->post('level')) OR empty($this->input->post('ulang_pass'))){
				$error = "<strong>".t('error')."</strong> ".t('emptyrequiredfield');
			}
			
			if(!empty($_FILES['fupload']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['fupload']['name'], PATHINFO_EXTENSION));
				
				$extensi_allowed = array('jpg','jpeg','png');

				if(!in_array($ext_file,$extensi_allowed)) {
					$error = "<strong>".t('error')."!!</strong> " . t('wrongextentionfile');
				}
			}

			$username 	= esc_sql(filter_clear(filter_txt(strtolower($this->input->post('username')))));
			$email 		= esc_sql(filter_txt($this->input->post('email')));
			$nama 		= esc_sql(filter_txt($this->input->post('nama')));
			$level 		= esc_sql(filter_int($this->input->post('level')));

			$pass 		= esc_sql(filter_txt($this->input->post('pass')));
			$pass 		= sha1( 
							sha1(
								encoder( $pass .'>>>>'. LOGIN_SALT )
							) . "#" . LOGIN_SALT
						);

			$passwordunik = password_hash( 
								$pass,
								PASSWORD_DEFAULT,
								['cost' => 10]
							); 

			// username check
			$usernum = $this->Env_model->countdata('users',"userLogin = '{$username}'");
			if($usernum > 0){
				$error = "<strong>".t('error')."!!</strong> ". t('usernameavailebleerror');
			}

			// email check
			$emailnum = $this->Env_model->countdata('users',"userEmail = '{$email}'");
			if($emailnum > 0){
				$error = "<strong>".t('error')."!!</strong> ". t('emailavailebleerror');
			}

			// password check
			if(strlen($this->input->post('pass'))<4){
				$error = "<strong>".t('error')."!!</strong> ". sprintf(t('passtotalcharerror'), 3);
			}
			
			if(!$error){
				$file_img = '';
				$file_dir = '';
				
				if(!empty($_FILES['fupload']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['fupload']['name'], PATHINFO_EXTENSION));
					$extensi_allowed = array('jpg','jpeg','png');

					if(in_array($ext_file,$extensi_allowed)) {
						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'210',
							'medium' 	=>'530',
							'large' 	=>'1920'
						);
						$img = uploadImage('fupload', 'users', $sizeimg, $extensi_allowed);
						$file_img = $img['filename'];
						$file_dir = $img['directory'];
					}
				}
				
				$registered = time2timestamp();
				$nextID = $this->Env_model->getNextId('userId','users');

				$insvalue = array(
		                      'userId'      	=> $nextID,
		                      'userLogin'		=> $username,
		                      'userPass'		=> $passwordunik,
		                      'userEmail' 		=> $email,
		                      'userDisplayName'	=> $nama,
		                      'levelId'   		=> $level,
		                      'userBlocked'    	=> 'n',
		                      'userDelete'		=> '0',
		                      'userLastLogin'	=> '0',
		                      'userRegistered'	=> $registered,
							  'userDir'			=> $file_dir,
							  'userPic'			=> $file_img,
							  'userOnlineStatus'=> 'offline'
		                );

				$query = $this->Env_model->insert('users', $insvalue);
				
				if($query){ 
					$this->session->set_flashdata( 'succeed', t('successfullyadd') );
	    			redirect( admin_url('manage_users/edit/'.$nextID) );
				} else {
					$error = "<strong>".t('error')."!!</strong> ".t('cannotprocessdata');
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
		    	redirect( admin_url('manage_users/tambah') );
			}
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = filter_int($id);

			$getdata = $this->Env_model->getval("*","users", "userId='{$id}'");

			// get data level account
			$whereclause = "levelActive='y'";
			if( $this->session->userdata('leveluser') !='1'){
                $whereclause .= " AND levelId!='1'";
            }
			$datalevel = $this->Env_model->view_where_order('levelId,levelName','users_level', $whereclause, 'levelId', 'ASC');

			// admin picture
            if($getdata['userPic']){
                $potoadmin = images_url($getdata['userDir'].'/small_'.$getdata['userPic']); 
            }else{
                $potoadmin = admin_assets('components/core/img/avatars/avatar.png');
            }

			$data = array( 
							'title' => t('usermanagement') . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' =>  t('usermanagement'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => t('addnew'),
													'icon'	=> 'fe fe-plus',
													'access' => admin_url('manage_users/tambah'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('manage_users'),
													'permission' => 'view'
												)
											),
							'data' => $getdata,
							'datalevel' => $datalevel,
							'potoadmin' => $potoadmin
						);

			$this->load->view( admin_root('manage_users_edit'), $data );
		}
	}
	public function prosesedit(){
		if( is_edit() ){
			$error = false;
			$id = esc_sql(filter_int($this->input->post('ID')));

			if( empty($this->input->post('email')) OR empty($this->input->post('nama')) OR empty($this->input->post('level')) ){
				$error = "<strong>".t('error')."</strong> ".t('emptyrequiredfield');
			}
			
			if(!empty($_FILES['fupload']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['fupload']['name'], PATHINFO_EXTENSION));
				
				$extensi_allowed = array('jpg','jpeg','png');

				if(!in_array($ext_file,$extensi_allowed)) {
					$error = "<strong>".t('error')."!!</strong> " . t('wrongextentionfile');
				}
			}

			$old_email 	= esc_sql(filter_txt($this->input->post('old_email')));
			$email 		= esc_sql(filter_txt($this->input->post('email')));
			$nama 		= esc_sql(filter_txt($this->input->post('nama')));
			$level 		= esc_sql(filter_int($this->input->post('level')));

			// password check
			if( !empty($this->input->post('pass')) ){
				// password check
				if(strlen($this->input->post('pass'))<4){
					$error = "<strong>".t('error')."!!</strong> ". sprintf(t('passtotalcharerror'), 3);
				}

				$pass = esc_sql(filter_txt($this->input->post('pass')));
				$pass = sha1( 
							sha1(
								encoder( $pass .'>>>>'. LOGIN_SALT ) 
							) . "#" . LOGIN_SALT
						);
				
				$passwordunik = password_hash( 
									$pass,
									PASSWORD_DEFAULT,
									['cost' => 10]
								);

				$arraypass = array('userPass'=> $passwordunik);
			} else {
				$arraypass = array();
			}

			// email check
			$emailnum = $this->Env_model->countdata('users',"userEmail = '{$email}' AND userEmail !='$old_email'");
			if($emailnum > 0){
				$error = "<strong>".t('error')."!!</strong> ". t('emailavailebleerror');
			}			
			
			if(!$error){
				$arrayfile_img = array();
				
				if(!empty($_FILES['fupload']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['fupload']['name'], PATHINFO_EXTENSION));
					$extensi_allowed = array('jpg','jpeg','png');

					if(in_array($ext_file,$extensi_allowed)) {
						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'210',
							'medium' 	=>'530',
							'large' 	=>'1920'
						);

						$dataimg = getval("*", 'users', "userId='{$id}'" );
						if(!empty($dataimg['userDir']) AND !empty($dataimg['userPic'])){							
							//delete old file
							foreach($sizeimg AS $imgkey => $valimg){
								@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .$dataimg['userDir'].DIRECTORY_SEPARATOR.$imgkey.'_'.$dataimg['userPic']);
							}
						}

						$img = uploadImage('fupload', 'users', $sizeimg, $extensi_allowed);
						$arrayfile_img = array('userDir'=> $img['filename'], 'userPic' => $img['directory']);
					}
				}
				
				$block = ($this->input->post('block')=='y') ? 'y' : 'n';

				$thevalue = array(
		                      'userEmail' 		=> $email,
		                      'userDisplayName'	=> $nama,
		                      'levelId'   		=> $level,
		                      'userBlocked'    	=> $block
		                );

				$dataupdate = array_merge($thevalue, $arrayfile_img, $arraypass);

				$query = $this->Env_model->update('users', $dataupdate, "userId='{$id}'");
				
				if($query){ 
					$this->session->set_flashdata( 'succeed', t('successfullyupdated') );
	    			redirect( admin_url('manage_users/edit/'.$id) );
				} else {
					$error = "<strong>".t('error')."!!</strong> ".t('cannotprocessdata');
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
		    	redirect( admin_url('manage_users/tambah') );
			}
		}
	}

	protected function deleteAction($id){
		if( is_delete() ){
			$id = filter_int($id);

			// update to delete
			$deleted = time2timestamp();
			$data = array('userDelete'=>$deleted, 'userBlocked'=>'y');

			return $this->Env_model->update('users', $data, "userId='{$id}'");
		}
	}
	public function delete($id){
		if( is_delete() ){
			$queryact = Self::deleteAction($id);
			
			if($queryact){
				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );
			} else {
				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
			}
			redirect( admin_url('manage_users') );
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
							
							if($queryact){ $stat_hapus = TRUE; } else { $stat_hapus = FALSE; break; }
						}
					}

					if($stat_hapus){
						$this->session->set_flashdata( 'succeed', t('successfullydeleted') );
					} else {
					  	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
					}
					redirect( admin_url('manage_users') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('manage_users') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

}
?>
