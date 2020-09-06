<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
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

		$idorder = esc_sql( filter_int($this->input->get('order', true)));
		$orderstatus = (empty($idorder)) ? false:true;

		$data = getval('*','orders',array('orderId'=>$idorder));

		//title web
        $webtitle = 'Invoice';

        // set meta web page
        $web_meta = web_head_properties(
            
            array(                
                // FB Open Graph
                'og' => array(
                    'og:title' 		=> $webtitle .' - '. get_option('sitename'),
                    'og:description' => get_option('sitedescription')
                ),

                // Twitter Cards
                'twitter' => array(
                    'twitter:title' 	=> $webtitle .' - '. get_option('sitename'),
                    'twitter:description' => get_option('sitedescription'),
                    'twitter:card' => 'summary'
                ),

                // Google+ / Schema.org
                'g+' => array(
                    'name' => $webtitle .' - '. get_option('sitename'),
                    'headline' => $webtitle .' - '. get_option('sitename'),
                    'description' => get_option('sitedescription')
                ),
            )
        );

        $dataview = array(
                    'title' => $webtitle .' - '. get_option('sitename'),
					'web_meta' => $web_meta,
					'orderdata' => $data,
					'orderstatus' => $orderstatus
                );
        $this->load->view( 'checkout-succeed', $dataview);
	}
	
}
