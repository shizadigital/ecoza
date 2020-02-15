<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_users extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
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
						'title' => 'Kelola Pengguna - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => 'Kelola Pengguna',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(
											array(
												'title' => 'Tambah',
												'icon'	=> 'icon-plus3',
												'access' => admin_url('manage_users/tambah'),
												'permission' => 'add'
											)
										),
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('manage_users/manage_users_view'), $data );
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
							'title' => 'Kelola Pengguna - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => 'Tambah Kelola Pengguna',
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => 'Kembali',
													'icon'	=> 'icon-undo2',
													'access' => admin_url('manage_users')
												)
											),
							'datalevel' => $datalevel
						);

			$this->load->view( admin_root('manage_users/manage_users_add'), $data );
		}
	}
	public function prosestambah(){
		if( is_add() ){

			if(empty($this->input->post('username')) OR empty($this->input->post('email')) OR empty($this->input->post('nama')) OR empty($this->input->post('pass')) OR empty($this->input->post('level')) OR empty($this->input->post('ulang_pass'))){
				$error = "<strong>Error</strong> Bidang wajib tidak boleh kosong";
			}
			
			if(!empty($_FILES['fupload']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['fupload']['name'], PATHINFO_EXTENSION));
				
				$extensi_allowed = array('jpg','jpeg','png');

				if(!in_array($ext_file,$extensi_allowed)) {
					$error = "<strong>Error</strong> Ekstensi file tidak diizinkan. silahkan pilih file dengan ekstensi yang sesuai";
				}
			}

			$username 	= esc_sql(filter_clear(filter_txt(strtolower($this->input->post('username')))));
			$email 		= esc_sql(filter_txt($this->input->post('email')));
			$nama 		= esc_sql(filter_txt($this->input->post('nama')));
			$pass 		= esc_sql(filter_txt($this->input->post('pass')));
			$pass 		= sha1( sha1($pass .'>>>>'. LOGIN_SALT ) . "#" . LOGIN_SALT );
			$level 		= esc_sql(filter_int($this->input->post('level')));

			// username check
			$usernum = $this->Env_model->countdata('users',"userLogin = '{$username}'");
			if($usernum > 0){
				$error = "<strong>Error</strong> Username ini sudah digunakan silahkan gunakan username yang lain";
			}

			// email check
			$emailnum = $this->Env_model->countdata('users',"userEmail = '{$email}'");
			if($emailnum > 0){
				$error = "<strong>Error</strong> Email ini sudah digunakan silahkan gunakan email yang lain";
			}

			// password check
			if(strlen($this->input->post('pass'))<4){
				$error = "<strong>Error</strong> Gunakan minimal 3 huruf untuk password";
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
		                      'userPass'		=> $pass,
		                      'userEmail' 		=> $email,
		                      'userDisplayName'	=> $nama,
		                      'levelId'   		=> $level,
		                      'userBlokir'    	=> 'n',
		                      'userDelete'		=> '0',
		                      'userLastLogin'	=> '0',
		                      'userRegistered'	=> $registered,
							  'userDir'			=> $file_dir,
							  'userPic'			=> $file_img
		                );

				$query = $this->Env_model->insert('users', $insvalue);
				
				if($query){ 
					$this->session->set_flashdata( 'sukses', 'Data berhasil ditambah' );
	    			redirect( admin_url('manage_users/edit/'.$nextID) );
				} else {
					$error = "<strong>Error</strong> Data tidak dapat diproses, silahkan coba lagi";
				}
			}

			if($error){
				$this->session->set_flashdata( 'gagal', $error );
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
                $potoadmin = images_url().'/'.$getdata['userDir'].'/small_'.$getdata['userPic']; 
            }else{
                $potoadmin = admin_assets()."/img/no_avatar.jpg";
            }

			$data = array( 
							'title' => 'Kelola Pengguna - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => 'Edit Kelola Pengguna',
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => 'Tambah',
													'icon'	=> 'icon-plus3',
													'access' => admin_url('manage_users/tambah'),
													'permission' => 'add'
												),
												array(
													'title' => 'Kembali',
													'icon'	=> 'icon-undo2',
													'access' => admin_url('manage_users')
												)
											),
							'data' => $getdata,
							'datalevel' => $datalevel,
							'potoadmin' => $potoadmin
						);

			$this->load->view( admin_root('manage_users/manage_users_edit'), $data );
		}
	}
	public function prosesedit(){
		if( is_edit() ){
			$id = $this->input->post('ID');

			if( empty($this->input->post('email')) OR empty($this->input->post('nama')) OR empty($this->input->post('level')) ){
				$error = "<strong>Error</strong> Bidang wajib tidak boleh kosong";
			}
			
			if(!empty($_FILES['fupload']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['fupload']['name'], PATHINFO_EXTENSION));
				
				$extensi_allowed = array('jpg','jpeg','png');

				if(!in_array($ext_file,$extensi_allowed)) {
					$error = "<strong>Error</strong> Ekstensi file tidak diizinkan. silahkan pilih file dengan ekstensi yang sesuai";
				}
			}

			$old_email 	= esc_sql(filter_txt($this->input->post('old_email')));
			$email 		= esc_sql(filter_txt($this->input->post('email')));
			$nama 		= esc_sql(filter_txt($this->input->post('nama')));
			$level 		= esc_sql(filter_int($this->input->post('level')));

			// username check
			$usernum = $this->Env_model->countdata('users',"userLogin = '{$username}'");
			if($usernum > 0){
				$error = "<strong>Error</strong> Username ini sudah digunakan silahkan gunakan username yang lain";
			}

			// password check
			if( !empty($this->input->post('pass')) ){
				// password check
				if(strlen($this->input->post('pass'))<4){
					$error = "<strong>Error</strong> Gunakan minimal 3 huruf untuk password";
				}

				$pass = esc_sql(filter_txt($this->input->post('pass')));
				$pass = sha1( sha1($pass .'>>>>'. LOGIN_SALT ) . "#" . LOGIN_SALT );

				$arraypass = array('userPass'=> $pass);
			} else {
				$arraypass = array();
			}

			// email check
			$emailnum = $this->Env_model->countdata('users',"userEmail = '{$email}' AND userEmail !='$old_email'");
			if($emailnum > 0){
				$error = "<strong>Error</strong> Email ini sudah digunakan silahkan gunakan email yang lain";
			}			
			
			if(!$error){
				$arrayfile_img = array();
				
				if(!empty($_FILES['fupload']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['fupload']['name'], PATHINFO_EXTENSION));
					$extensi_allowed = array('jpg','jpeg','png');

					if(in_array($ext_file,$extensi_allowed)) {
						//delete favicon old file
						@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .'xsmall_'.$array_logo['directory'].DIRECTORY_SEPARATOR.$array_logo['filename']);
						@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .'small_'.$array_logo['directory'].DIRECTORY_SEPARATOR.$array_logo['filename']);
						@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .'medium_'.$array_logo['directory'].DIRECTORY_SEPARATOR.$array_logo['filename']);
						@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .'large_'.$array_logo['directory'].DIRECTORY_SEPARATOR.$array_logo['filename']);

						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'210',
							'medium' 	=>'530',
							'large' 	=>'1920'
						);
						$img = uploadImage('fupload', 'users', $sizeimg, $extensi_allowed);
						$arrayfile_img = array('userDir'=> $img['filename'], 'userPic' => $img['directory']);
					}
				}
				
				$block = ($this->input->post('block')=='y') ? 'y' : 'n';

				$thevalue = array(
		                      'userEmail' 		=> $email,
		                      'userDisplayName'	=> $nama,
		                      'levelId'   		=> $level,
		                      'userBlokir'    	=> $block
		                );

				$dataupdate = array_merge($thevalue, $arrayfile_img, $arraypass);

				$query = $this->Env_model->update('users', $dataupdate, "userId='{$id}'");
				
				if($query){ 
					$this->session->set_flashdata( 'sukses', 'Data berhasil diperbarui' );
	    			redirect( admin_url('manage_users/edit/'.$id) );
				} else {
					$error = "<strong>Error</strong> Data tidak dapat diproses, silahkan coba lagi";
				}
			}

			if($error){
				$this->session->set_flashdata( 'gagal', $error );
		    	redirect( admin_url('manage_users/tambah') );
			}
		}
	}

	public function delete($id){
		if( is_delete() ){
			$id = filter_int($id);

			// update to delete
			$deleted = time2timestamp();
			$data = array('userDelete'=>$deleted, 'userBlokir'=>'y');

			$queryact = $this->Env_model->update('users', $data, "userId='{$id}'");
			if($queryact){
				$this->session->set_flashdata( 'sukses', 'Data berhasil dihapus' );
			} else {
				$this->session->set_flashdata( 'sukses', 'Data gagal dihapus' );
			}
			redirect( admin_url('manage_users') );
		}
	}

	public function bulk_action(){
		$error = false;
		if(empty($this->input->post('bulktype'))){
			$error = "<strong>Error</strong> Tindakan masal belum dipilih, silahkan pilih jenis tindakan masal terlebih dahulu";
		}

		if(!$error){
			if( $this->input->post('bulktype')=='bulk_delete' AND is_delete() ){
				$theitem = (!empty($this->input->post('item'))) ? array_filter($this->input->post('item')):array();

				if( count($theitem) > 0 ){
					$stat_hapus = FALSE;

					foreach ($theitem as $key => $value) {
						if($value == 'y'){
							$id = filter_int($this->input->post('item_val')[$key]);

							$deleted = time2timestamp();

						    $data = array('userDelete'=>$deleted, 'userBlokir'=>'y');
							$queryact = $this->Env_model->update('users', $data, "userId='{$id}'");
							
							if($queryact){ $stat_hapus = TRUE; } else { $stat_hapus = FALSE; break; }
						}
					}

					if($stat_hapus){
						$this->session->set_flashdata( 'sukses', 'Data berhasil dihapus' );
					} else {
					  	$this->session->set_flashdata( 'sukses', 'Data gagal dihapus' );
					}
					redirect( admin_url('manage_users') );
					exit;

				} else {
					$error = "<strong>Error</strong> Silahkan pilih item pada tindakan masal terlebih dahulu";
				}

			}
			redirect( admin_url('manage_users') );
		}

		if($error){
			show_error($error, 503,'Tindakan masal gagal');
			exit;
		}
	}

}
?>