<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		if( !$this->member->is_login() ){

			redirect( base_url('login') );

		}
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
		//title web
        $webtitle = 'Dashboard';

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
                );
        $this->load->view( 'account-dashboard', $dataview);
	}

	public function orders($act = null, $ordercode = null){

		if($act=='detail'){
			if( $ordercode == null ){ exit; }

			$ordercode = esc_sql( filter_txt( $ordercode ) );
			$memberId = $this->member->memberId();

			$data = getval('*', 'orders', array('orderCode'=>$ordercode));

			// get detail order
			$detaildata = $this->Env_model->view_where_order('*', 'order_detail',array('orderId'=>$data['orderId']),'odetId','ASC');
			$usedefaultax = array();
			foreach($detaildata as $det){
				$usedefaultax[] = ($det['odetProdTaxId']==$data['orderTaxDefaultId'])?'y':'n';
			}
			$allusedefaulttax = (in_array('n',$usedefaultax))?false:true;

			//title web
			$webtitle = 'Order Detail';

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
						'data' => $data,
						'detail' => $detaildata,
						'status' => getval('orderstatName','order_status', array('orderId'=>$data['orderId'],'orderstatCurrentStatus'=>1)),
						'allusedefaulttax' => $allusedefaulttax
					);
			$this->load->view( 'account-order-detail', $dataview);
		} else {

			//title web
			$webtitle = 'Orders';

			$memberId = $this->member->memberId();

			// get segment
			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
			$perPage = 5;
			
			$table = 'orders';
			$where = "mId='{$memberId}'";

			// get order data
			$getorder = $this->Env_model->view_where_order_limit('*', $table, $where, 'orderId', 'DESC', $perPage, $datapage);
			$rows = countdata($table, $where);

			$pagingURI = base_url( $this->uri->segment(1).'/'.$this->uri->segment(2) );

			// get pagging setting in fronpage libraries
			$this->load->library('Frontpagelib');
			$pagingscheme = $this->frontpagelib->getPaggingScheme();

			$this->load->library('paging');

			$option = array('uri_segment'=>3);
			$pagination = $this->paging->PaginationWeb( $pagingURI, $rows, $perPage, $pagingscheme, $option);
			
			$dataorder = array();

			foreach($getorder as $key => $data){
				$dataorder[$key] = $data;

				// get status order
				$dataorder[$key]['status'] = getval('orderstatName','order_status', array('orderId'=>$data['orderId'],'orderstatCurrentStatus'=>1));

				// get detail order
				$detaildata = $this->Env_model->view_where_order('*', 'order_detail',array('orderId'=>$data['orderId']),'odetId','ASC');
				$dataorder[$key]['detail'] = $detaildata;
				
				$usedefaultax = array();
				foreach($detaildata as $det){
					$usedefaultax[] = ($det['odetProdTaxId']==$data['orderTaxDefaultId'])?'y':'n';
				}

				$dataorder[$key]['allusedefaulttax'] = (in_array('n',$usedefaultax))?false:true;
			}		

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
						'order' => $dataorder,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			$this->load->view( 'account-orders', $dataview);
		}
	}
	
}
