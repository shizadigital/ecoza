<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog extends CI_Controller {
	
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

				$attrcombination = array();
				$productattrdata = array();
				$producdefaulttattrdata = array();
				$is_attr = false;
				if( $data['prodType']=='configurableproduct' OR $data['prodType']=='downloadableproduct'){
					
					$countattravailable = countdata('product_attribute', array('prodId'=>$data['prodId']));						
					if( $countattravailable > 0){
						$is_attr = true;

						$producdefaulttattrdata = getval("*", "product_attribute", "prodId='{$data['prodId']}' AND pattrDefault='y'");

						// get product attribute combination
						$productattrdata = $this->Env_model->view_where_order("*", "product_attribute", "prodId='{$data['prodId']}'",'pattrId','ASC');
						$xattv = 0;
						foreach($productattrdata AS $key => $value){
							$attrval = $this->Env_model->view_where_order("*", "product_attribute_combination", "pattrId='{$value['pattrId']}'",'pattrId','ASC');
							$attrcombination[$xattv] = $value;
							$attrcombination[$xattv]['attrval'] = $attrval;

							$xattv++;
						}
						
					}
				}

				// get meta category
				$categoryprod = $this->meta->product_categories($data['prodId']);

				// get primary picture
				$primaryimg = getval("pimgId,pimgDir,pimgImg","product_images","prodId='{$data['prodId']}' AND pimgPrimary='y'");

				// get all picture
				$allimages = $this->Env_model->view_where_order("pimgId,pimgDir,pimgImg","product_images","prodId='{$data['prodId']}'", 'pimgPosition', 'ASC');

				// seo page start here
				$seo = getSeoPage($data['prodId'], 'product');

				//title web
				$webtitle = (empty($seo['seoTitle'])) ? $data['prodName']:$seo['seoTitle'];

				$seodesc = '';
				if(!empty($seo['seoDesc'])){

					if(!empty($seo['seoDesc'])){
						$seodesc = $seo['seoDesc'];
					} else {
						if(!empty($data['prodDesc'])){
							$seodesc = the_excerpt($data['prodDesc'], 160, '');
						}
					}

				}

				$metaimg = (!empty($primaryimg['pimgDir']) AND !empty($primaryimg['pimgImg'])) ? images_url($primaryimg['pimgDir']."/medium_".$primaryimg['pimgImg']):'';

				$price = $data['prodPrice'];
				if( $data['prodType']=='configurableproduct' OR $data['prodType']=='downloadableproduct'){
					$price = $producdefaulttattrdata['pattrPrice'];
				}

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
							'product:price:amount' => $price,
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
							'twitter:data1' => the_price($price),
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
							'title' => $webtitle .' - '. get_option('sitename'),
							'web_meta' => $web_meta,
							'data' => $data,
							'is_attr' => $is_attr,
							'dataattribute' => $productattrdata,
							'defaultattribute' => $producdefaulttattrdata,
							'attrcombination' => $attrcombination,
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

	public function category($param=null){
		echo $param;
	}

	
}
