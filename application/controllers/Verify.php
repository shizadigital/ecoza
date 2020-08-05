<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function _remap ($param1=null, $params = array() ){
		if($param1){
			
			$method = strtolower(trim($param1));
			if(method_exists($this, $method)){
				
				return call_user_func_array (array($this, $method), $params);

			} else {	
				
				$this->index($param1);

			}
		} else {

			$this->index();

		}
	}
	
	public function index($param=null){	
		if($param=='index'){
			show_404();
		} else {
			
		}
	}


	public function memberregister($key=null){
		echo $key;
	}

	
}
