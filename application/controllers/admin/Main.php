<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	// load model
	public function __construct()
	{
		parent::__construct();
		// load helper random string
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// load model random string
		$this->load->model('adminauth_model');
	}

	public function index(){
		if( empty( $this->session->userdata('username') ) AND empty( $this->session->userdata('passuser') ) ){
			// LOGIN PAGE
			$data = array( 
						'title' => 'Login Administrator - '.get_option('sitename'),
						'CP' => get_cookie('sz_token')
					);
			$this->load->view( admin_root('login'), $data );
		} else {
			// REDIRECT TO ADMIN PAGE
			redirect( admin_url('dashboard') );
		}
	}

	public function authLogin(){
		$error = false; $msg = '';

		$username = esc_sql(filter_txt( $this->input->post('user') ) );
		$password = esc_sql(filter_txt( $this->input->post('pass') ) );

		$passwordunik = sha1( 
							sha1(
								encoder( $password .'>>>>'. LOGIN_SALT ) 
							) . "#" . LOGIN_SALT
						);

		// validate first data
		if( empty($username) AND !empty($password) ){
			$error = true;
			$msg = 'Silahkan masukkan username Anda';
		} elseif( !empty($username) AND empty($password) ) {
			$error = true;
			$msg = 'Silahkan masukkan password Anda';
		} elseif( empty($username) AND empty($password) ) {
			$error = true;
			$msg = 'Silahkan masukkan username dan password Anda';
		} 

		// validasi token checkpoint
		if( $this->input->post('CP') !== get_cookie('sz_token') ) {
			$error = true;
			$msg = 'Akses Anda bermasalah dengan token';
		}

		if(!$error){
			if (!ctype_alnum($username)){

				$error = true;
				$msg = 'Maaf karakter untuk masuk pada halaman administrator tidak cocok';

			} else {

				$authlogin = $this->adminauth_model->login_auth($username);

				if ( password_verify($passwordunik, $authlogin->userPass) ){

					$logindata = $this->adminauth_model->get_auth_data($username, $authlogin->userPass);

					// make session here
					$newdata = array(
					        'adminid' 		=> $logindata->userId,
					        'username' 		=> $logindata->userLogin,
							'passuser' 		=> $logindata->userPass,
							'leveluser' 	=> $logindata->levelId,
							'levelstatus' 	=> $logindata->levelActive,
							'checkpoint' 	=> loginCP()
						);

					$this->session->set_userdata($newdata);

					// regenerated session ID
					session_regenerate_id();
		          	$sid_baru = session_id();

		          	$updt = array(
		          				'userSession' => $sid_baru,
		          				'userLastLogin' => time2timestamp(),
		          				'userOnlineStatus' => 'online'
		          			);

					$updatedata = $this->adminauth_model->update_login($logindata->userId, $updt);
					
					// update language in cookie
					$lang = array(
								'name'   => 'admin_lang',
								'value'  => $logindata->userLang,
								'expire' => $this->config->item('sess_expiration'),
								'path ' => '/'
							);
					$this->input->set_cookie($lang);

		          	redirect($this->uri->segment(1).'/dashboard/');

	          	} else {
					$error = true;
					$msg = 'Username atau Password salah atau akun Anda sedang diblokir';
				}
			}
		} 

		if($error){
			$this->session->set_flashdata( 'username', $this->input->post('user') );
			$this->session->set_flashdata( 'password', $this->input->post('pass') );
			$this->session->set_flashdata( 'errormsg', $msg );
			redirect( admin_url() );
		}
	}

	public function logout(){
		// update user to offline
		update_adm_ol_status('offline');

		// logout access
		$this->adminauth->destroy_login();

		$this->session->set_flashdata('successmsg', 'Anda berhasil logout');
		redirect( admin_url() );
	}

	public function iconscomponent(){
		$data = array( 
			'title' => 'Komponen Icon - '.get_option('sitename')			
		);
		$this->load->view( admin_root('icon-component'), $data );
	}
}
