<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {
	
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

			$where = array('contentId'=>$id, 'contentType'=>'post', 'contentStatus'=>'1');
			$checkproduct = countdata('contents', $where);

			if( $checkproduct > 0){

				$data = getval('*','contents',$where);
				// if permalink is not same, redirect to 404
				$thepermalink_segment = $data['contentId'] .'-'. $data['contentSlug'];
				if($thepermalink_segment != $this->uri->segment(2)){ show_404(); }

				// count and update product hit
				$hit = $data['contentRead'] + 1;
				$this->Env_model->update('contents', array( 'contentRead' => $hit),  array('contentId'=>$id));

				// get meta category
				$categorypost = $this->meta->post_categories($data['contentId']);
				$categorylimit1 = $this->meta->post_categories($data['contentId'],true);

				// seo page start here
				$seo = getSeoPage($data['contentId'], 'post');
				
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
							'article:section' => $categorylimit1['name'][0]
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
					'categories' => $categorypost
				);
				$this->load->view( 'post-detail', $dataview);

			}else {
				show_404();
			}

		}
	}

	public function category($param=null, $datapage = 0){
		
		if($param != null){
			// get segment
			$segment = explode('-', $param);

			$id = esc_sql( filter_int( $segment[0] ) );

			$where = array('catId'=>$id, 'catType'=>'post', 'catActive'=>'1');
			$checkproduct = countdata('categories', $where);

			if( $checkproduct > 0){

				$datacat = getval('*','categories',$where);
				// if permalink is not same, redirect to 404
				$thepermalink_segment = $datacat['catId'] .'-'. $datacat['catSlug'];
				if($thepermalink_segment != $param ){ show_404(); }

				$tablepost = array('contents a', 'category_relationship b');

				// get segment
				$datapage = esc_sql(filter_int($datapage));
				//$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$perPage = 16;

				$where = "b.relatedId=a.contentId AND b.catId='{$id}' AND a.contentType='post' AND a.contentStatus='1'";
				$postdata = $this->Env_model->view_where_order_limit('*', $tablepost, $where, 'a.contentId', 'DESC', $perPage, $datapage);

				$rows = countdata($tablepost, $where);
				$pagingURI = base_url( $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3) );

				
				// get pagging setting in fronpage libraries
				$this->load->library('Frontpagelib');
				$pagingscheme = $this->frontpagelib->getPaggingScheme();

				$this->load->library('paging');

				$option = array('uri_segment'=>4);
				$pagination = $this->paging->PaginationWeb( $pagingURI, $rows, $perPage, $pagingscheme, $option);

				$web_meta = web_head_properties(
						
					array(
						'meta_keyword' 		=> get_option('sitekeywords'),
						'meta_description' 	=> get_option('sitedescription'),
						'meta_robots' 		=> get_option('robots'),
						
						// FB Open Graph
						'og' => array(
							'og:title' 		=> get_option('sitename'),
							'og:type' 		=> 'article',
							'og:description' => get_option('sitedescription'),
						),
		
						// Twitter Cards
						'twitter' => array(
							'twitter:title' 	=> get_option('sitename'),
							'twitter:description' => get_option('sitedescription'),
						),
		
						// Google+ / Schema.org
						'g+' => array(
							'name' => get_option('sitename'),
							'headline' => get_option('sitename'),
							'description' => get_option('sitedescription'),
						),
					)
				);
				
				$data = array( 
					'title' =>  get_option('sitename'),
					'web_meta' => $web_meta,
					'category' => $datacat,
					'postdata' => $postdata,
					'pagination' => $pagination,
					'totaldata' => $rows
				);
				$this->load->view( 'post-category', $data, false);
			} else {
				show_404();
			}

		} else {
			show_404();
		}

	}

	public function search(){

		$tablepost = array('contents a');

		// get segment
		$datapage = ( $this->input->get('page') ) ? esc_sql(filter_int( $this->input->get('page',true))):0;
		$perPage = 16;

		$keyword = $this->input->get('q',true);

		// split by space and counting the words
		$exp_text   = explode(" ",$keyword);
		$count_text = (integer)count($exp_text);
		$jml_text   = $count_text-1;

		$where = "a.contentType='post' AND a.contentStatus='1' AND (";
		for ($i=0; $i<=$jml_text; $i++){
			$where .= "a.contentTitle LIKE '%".esc_sql($exp_text[$i])."%'";
			if ($i < $jml_text ){
				$where .= " OR ";
			}
		}
		$where .= ")";

		$postdata = $this->Env_model->view_where_order_limit('*', $tablepost, $where, 'a.contentId', 'DESC', $perPage, $datapage);

		$rows = countdata($tablepost, $where);
		$pagingURI = base_url( $this->uri->segment(1).'/'.$this->uri->segment(2) );

		
		// get pagging setting in fronpage libraries
		$this->load->library('Frontpagelib');
		$pagingscheme = $this->frontpagelib->getPaggingScheme();

		$this->load->library('paging');

		$option = array('uri_segment'=>4);
		$pagination = $this->paging->PaginationWeb( $pagingURI, $rows, $perPage, $pagingscheme, $option);

		$web_meta = web_head_properties(
				
			array(
				'meta_keyword' 		=> get_option('sitekeywords'),
				'meta_description' 	=> get_option('sitedescription'),
				'meta_robots' 		=> get_option('robots'),
				
				// FB Open Graph
				'og' => array(
					'og:title' 		=> get_option('sitename'),
					'og:type' 		=> 'article',
					'og:description' => get_option('sitedescription'),
				),

				// Twitter Cards
				'twitter' => array(
					'twitter:title' 	=> get_option('sitename'),
					'twitter:description' => get_option('sitedescription'),
				),

				// Google+ / Schema.org
				'g+' => array(
					'name' => get_option('sitename'),
					'headline' => get_option('sitename'),
					'description' => get_option('sitedescription'),
				),
			)
		);
		
		$data = array( 
			'title' =>  get_option('sitename'),
			'web_meta' => $web_meta,
			'postdata' => $postdata,
			'pagination' => $pagination,
			'totaldata' => $rows
		);
		$this->load->view( 'post-search', $data, false);
	}

	
}
