<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
	
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
			// get segment
			$segment = explode('-', $this->uri->segment(2));

			$id = esc_sql( filter_int( $segment[0] ) );

			$where = array('contentId'=>$id, 'contentType'=>'page', 'contentStatus'=>'1');
			$checkproduct = countdata('contents', $where);

			if( $checkproduct > 0){

				$data = getval('*','contents',$where);
				// if permalink is not same, redirect to 404
				$thepermalink_segment = $data['contentId'] .'-'. $data['contentSlug'];
				if($thepermalink_segment != $this->uri->segment(2)){ show_404(); }

				// count and update product hit
				$hit = $data['contentRead'] + 1;
				$this->Env_model->update('contents', array( 'contentRead' => $hit),  array('contentId'=>$id));

				// seo page start here
				$seo = getSeoPage($data['contentId'], 'page');
				
				// get author
				$getauthor = getval('userDisplayName,userEmail,userLogin,userDir,userPic', 'users', array('userLogin'=>$data['contentUsername']));

				//title web
				$webtitle = (empty($seo['seoTitle'])) ? $data['contentTitle']:$seo['seoTitle'];

				$seodesc = '';
				if(!empty($seo['seoDesc'])){

					if(!empty($seo['seoDesc'])){
						$seodesc = $seo['seoDesc'];
					} else {
						if(!empty($data['contentPost'])){
							$seodesc = the_excerpt($data['contentPost'], 160, '');
						}
					}

				}

				$metaimg = (!empty($data['contentDirImg']) AND !empty($data['contentImg'])) ? images_url($data['contentDirImg']."/medium_".$data['contentImg']):'';

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
							'og:title' 		=> $webtitle,
							'og:description' => $seodesc,
							'article:published_time' => date('c', $data['contentAddDate']),
							'article:modified_time' => date('c', $data['contentTimestamp']),
							'og:updated_time' => date('c', $data['contentTimestamp']),
							'og:type' 		=> 'article',
							'og:type' 		=> 'og:article',
						),

						// Twitter Cards
						'twitter' => array(
							'twitter:image:src' => $metaimg,
							'twitter:title' 	=> $webtitle,
							'twitter:description' => $seodesc,
							'twitter:image' 	=> $metaimg,
							'twitter:card' => 'summary_large_image',
						),

						// Google+ / Schema.org
						'g+' => array(
							'name' => $webtitle,
							'headline' => $webtitle,
							'description' => $seodesc,
							'image' => $metaimg,
							'datePublished' => date('Y-m-d', $data['contentAddDate']),
							'dateModified' => date('c', $data['contentTimestamp']),
							'author' => $getauthor['userDisplayName'],
						),
					)
				);

				$dataview = array( 
					'title' => $webtitle .' - '. get_option('sitename'),
					'web_meta' => $web_meta,
					'data' => $data,
				);
				$this->load->view( 'page', $dataview);

			}else {
				show_404();
			}

		}
	}


	public function category($param=null, $sldls=null){
		
	}

	
}
