<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tesajadeh extends CI_Controller {

	public function index(){
		echo 'controller berhasil';
		$this->load->view( 'tesview' );
	}
}
