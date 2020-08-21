<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		// load model random string
		$this->load->model('memberauth_model');
	}

	public function _remap ($param1=null, $params = array() ){
		if($param1){
			
			$method = strtolower(trim($param1));
			if(method_exists($this, $method)){
				
				return call_user_func_array (array($this, $method), $params);

			} else {
				
				// redirect to 404 if more parameter arguments in method
				if(count($params)>0) show_404();
				else $this->index($param1);

			}
		} else {

			$this->index();

		}
	}
	
	public function index(){
		if(get_cookie('sz_token') === sz_token()){

			$cookiesName = array(
				'member', 'memberemail', 'checkpoint', 'verifystatus', 'lastlog'
			);

			// get current domain
			$domain = getDomain( current_url() );

			foreach( $cookiesName as $name ){
				// delete cookies
				delete_cookie($name, '.'.$domain, '/');
			}

			redirect( base_url('login') );

		}
	}
	
}
