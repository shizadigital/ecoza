<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog extends CI_Controller {

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
			// get segment
			$segment = explode('-', $this->uri->segment(2));

			$id = esc_sql( filter_int( $segment[0] ) );

			$where = array('prodId'=>$id, 'prodDisplay'=>'y', 'prodDeleted'=>'0');
			$checkproduct = countdata('product', $where);

			if($checkproduct > 0){
				$data = getval('*', 'product', $where);

				// permalink product, if not same redirect to 404
				$thepermalink_segment = $data['prodId'] .'-'. slugURL($data['prodName']);
				if($thepermalink_segment != $this->uri->segment(2)){ show_404(); }

				// count and update product hit
				$hit = $data['prodViewCount'] + 1;
				$this->Env_model->update('product', array( 'prodViewCount' => $hit),  array('prodId'=>$id));

				// get meta category
				$categoryprod = $this->meta->product_categories($data['prodId']);

				// get primary picture
				$primaryimg = getval("pimgId,pimgDir,pimgImg","product_images","prodId='{$data['prodId']}' AND pimgPrimary='y'");

				// get all picture
				$allimages = $this->Env_model->view_where_order("pimgId,pimgDir,pimgImg","product_images","prodId='{$data['prodId']}'", 'pimgPosition', 'ASC');

				// seo page start here
				$seo = getSeoPage($data['prodId'], 'product');

				$seodesc = '';
				if(!empty($seo['seoKeyword'])){

					if(!empty($seo['seoDesc'])){
						$seodesc = $seo['seoDesc'];
					} else {
						if(!empty($data['prodDesc'])){
							$seodesc = the_excerpt($data['prodDesc'], 160, '');
						}
					}

				}

				$metaimg = (!empty($primaryimg['pimgDir']) AND !empty($primaryimg['pimgImg'])) ? images_url($primaryimg['pimgDir']."/medium_".$primaryimg['pimgImg']):'';

				// set meta web page
				$web_meta = web_head_properties(
					
					array(
						'meta_keyword' 		=> $seo['seoKeyword'],
						'meta_description' 	=> $seodesc,
						'meta_robots' 		=> $seo['seoRobots'],
						
						// FB Open Graph
						'og' => array(
							'og:image' 		=> $metaimg,
							'og:image:url' 	=> $metaimg,
							'og:title' 		=> $data['prodName'],
							'og:description' => $seodesc,
							'article:published_time' => date('c', $data['prodAdded']),
							'article:modified_time' => date('c', $data['prodModified']),
							'og:updated_time' => date('c', $data['prodModified']),
							'og:type' 		=> 'product',
							'og:type' 		=> 'og:product',
							'product:price:amount' => $data['prodPrice'],
							'product:price:currency' => get_option('defaultcurrency'),
						),

						// Twitter Cards
						'twitter' => array(
							'twitter:image:src' => $metaimg,
							'twitter:title' 	=> $data['prodName'],
							'twitter:description' => $seodesc,
							'twitter:image' 	=> $metaimg,
							'twitter:card' => 'product',
							'twitter:label1' => 'Harga',
							'twitter:data1' => the_price($data['prodPrice']),
						),

						// Google+ / Schema.org
						'g+' => array(
							'name' => $data['prodName'],
							'headline' => $data['prodName'],
							'description' => $seodesc,
							'image' => $metaimg,
							'datePublished' => date('Y-m-d', $data['prodAdded']),
							'dateModified' => date('c', $data['prodModified'])
						),
					)
				);
		
				$dataview = array( 
							'title' => $data['prodName'] .' - '. get_option('sitename'),
							'web_meta' => $web_meta,
							'data' => $data,
							'metacategories' => $categoryprod,
							'primaryimage' => $primaryimg,
							'allimages' => $allimages
						);
				$this->load->view( 'catalog', $dataview);
				
			} else {
				show_404();
			}

		}
	}

	public function category($param=null, $sldls=null){
		
	}

	
}
