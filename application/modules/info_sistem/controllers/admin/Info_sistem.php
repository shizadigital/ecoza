<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_sistem extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('info_sistem_model');
	}

	public function index(){
		if( is_view() ){
			// REQUIREMENT WEBSITE FEATURE
			$k = 'pdo_driver';
			$arr[$k]['name'] = 'PHP PDO EXTENSION';
			if(extension_loaded('PDO')){
				if(extension_loaded('pdo_mysql') and in_array('mysql', PDO::getAvailableDrivers()) == true){
					$arr[$k]['result'] = array(
						'type' => 'ok'
					);
				} else {
					$arr[$k]['result'] = array(
						'type' => 'error',
						'desc' => 'PDO extension loaded, but MySQL driver not found.'
					);
				}
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'Missing PHP PDO'
				);
			}

			$k = 'exec';
			$arr[$k]['name'] = 'PHP Exec';
			if(function_exists('exec')){
				if(exec('echo EXEC') == 'EXEC'){
					$arr[$k]['result'] = array(
						'type' => 'ok'
					);
				} else {
					$arr[$k]['result'] = array(
						'type' => 'error',
						'desc' => 'Exec loaded, but not working correctly.'
					);
				}
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'PHP Exec not loaded.'
				);
			}

			$k = 'ioncube';
			$arr[$k]['name'] = 'Ioncube Loader';
			if(extension_loaded ('ionCube Loader')){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'Ioncube loader not installed!'
				);
			}

			$k = 'base64';
			$arr[$k]['name'] = 'BASE64';
			if(function_exists('base64_encode') and function_exists('base64_decode')){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'Missing base64 encoder'
				);
			}


			$k = 'gettext';
			$arr[$k]['name'] = 'GETTEXT';
			if(function_exists('gettext') and function_exists('bindtextdomain') and function_exists('textdomain') and function_exists('setlocale')){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'Missing gettext function'
				);
			}

			$k = 'openssl';
			$arr[$k]['name'] = 'OpenSSL Encription';
			if(function_exists('openssl_encrypt') and function_exists('openssl_decrypt')){

				$iv = substr(hash('sha256', AUTH_SALT), 0, 16);
				$str = 'Hello';

				$crypt = openssl_encrypt($str, 'aes-128-cbc', AUTH_SALT, 0, $iv);
				if(trim(openssl_decrypt($crypt, 'aes-128-cbc', AUTH_SALT, 0, $iv))==$str){
					$arr[$k]['result'] = array(
						'type' => 'ok'
					);
				} else {
					$arr[$k]['result'] = array(
						'type' => 'error',
						'desc' => 'OpenSSL loaded, but not working properly.'
					);
				}
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'Missing gettext extension'
				);
			}

			$k = 'DOMDocument';
			$arr[$k]['name'] = 'DOMDocument';
			if(class_exists('DOMDocument')){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'Missing DOMDocument Class.'
				);
			}

			$k = 'ZipArchive';
			$arr[$k]['name'] = 'ZipArchive';
			if(class_exists('ZipArchive')){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'Missing ZipArchive Class.'
				);
			}

			$k = 'ob';
			$arr[$k]['name'] = 'Output Buffering';
			if(function_exists('ob_start') and function_exists('ob_end_flush')){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'missing Output Buffering.'
				);
			}

			$k = 'mail';
			$arr[$k]['name'] = 'Mail Function';
			if( function_exists('mail') ){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'missing Mail Function.'
				);
			}

			$k = 'mbstring';
			$arr[$k]['name'] = 'mbstring';
			if( extension_loaded('mbstring') ){
				$arr[$k]['result'] = array(
					'type' => 'ok'
				);
			} else {
				$arr[$k]['result'] = array(
					'type' => 'error',
					'desc' => 'missing mbstring.'
				);
			}

			$data = array( 
						'title' => 'Info Sistem - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => '',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(
										),
						'data' => $arr,
						'mysqlversion' => $this->info_sistem_model->getMysqlVersion(),
					);
			
			$this->load->view( admin_root('info_sistem_view'), $data );
		}
	}

}
?>
