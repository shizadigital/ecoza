<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {
	
	private $params = null;
	
	public function __construct(){
		parent::__construct();
	}

	public function _remap ($param1=null, $params = array() ){
		if(count($params) > 0){
			if(strlen($params[0]) > 0){
				$this->params = $params;
			}
		}

		if($this->params){
			$method = strtolower(trim($this->params[0]));
		    if(method_exists($this, $method)){
		        return call_user_func_array (array($this, $method), $this->params);
		    }else{
				$this->index();
		    }
		}else{
			if(empty($param1)){
				$this->index();
			} else {
				$this->index($param1);
			}
		}
	}
	
	public function index($param=null){	
		if($param=='index'){
			show_404();
		} else {
			
		}
	}


	public function category($param=null, $sldls=null){
		
	}

	
}
