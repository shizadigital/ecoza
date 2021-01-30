<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}
	
	public function accountMenu(){
		$ci = $this->CI;
		if(get_cookie('sz_token') == sz_token() AND $ci->member->is_login()){

			$dashboard_active = ($ci->uri->segment(1)=='account' AND empty($ci->uri->segment(2)))? true:false;
			$order_active = ($ci->uri->segment(1)=='account' AND $ci->uri->segment(2)=='orders')? true:false;
			$cpass_active = ($ci->uri->segment(1)=='account' AND $ci->uri->segment(2)=='changepass')? true:false;

			return [
				['keyword' => 'dashboard', 'title' => 'Dashboard', 'url' => base_url('account'), 'active' => $dashboard_active],
				['keyword' => 'myorder', 'title' => 'My Order', 'url' => base_url('account/orders'), 'active' => $order_active],
				['keyword' => 'changepass', 'title' => 'Change Password', 'url' => base_url('account/changepass'), 'active' => $cpass_active],
				['keyword' => 'logout', 'title' => 'Logout', 'url' => base_url('logout'), 'active' => false],
			];
		} else {
			return false;
		}
	}

	
	public function product_categories($prod_id, $single=false){
		$ci = $this->CI;

		$prod_id = esc_sql(filter_int($prod_id));

		$select = 'c.catId,c.catName,c.catDesc,c.catColor';
		$table = array('product a', 'category_relationship b', 'categories c');
		$where = "a.prodId=b.relatedId 
		AND b.catId=c.catId
		AND b.crelRelatedType = 'product'
		AND b.relatedId='{$prod_id}'
		AND c.catActive='1'";

		if($single){
			$data = $ci->Env_model->view_where_order_limit($select,$table, $where, 'b.crelId','DESC', '1');
		} else {
			$data = $ci->Env_model->view_where_order($select,$table, $where, 'b.crelId','DESC');
		}

		$arrayarg = array();
		if(count($data)>0){
			foreach( $data as $categ ) {
				$arrayarg['id'][] 		= $categ['catId'];
				$arrayarg['name'][] 	= $categ['catName'];
				$arrayarg['url'][] 		= $ci->permalink->get('product-category', $categ['catId']);
				$arrayarg['desc'][] 	= $categ['catDesc'];
				$arrayarg['color'][] 	= $categ['catColor'];
			}
		}

		return $arrayarg;
	}

	public function getAllProductCategories(){
		$ci = $this->CI;

		if(countdata('categories',array('catActive'=>1,'catType'=>'product')) > 0){
			return $ci->Env_model->view_where_order('*','categories',array('catActive'=>1,'catType'=>'product'), 'catId','DESC');
		} else {
			return array();
		}
	}

	public function post_categories($post_id, $single=false){
		$ci = $this->CI;

		$post_id = esc_sql(filter_int($post_id));

		$select = 'c.catId,c.catName,c.catDesc,c.catColor';
		$table = array('contents a', 'category_relationship b', 'categories c');
		$where = "a.contentId=b.relatedId 
		AND b.catId=c.catId
		AND b.crelRelatedType = 'post'
		AND b.relatedId='{$post_id}'
		AND c.catActive='1'";

		if($single){
			$data = $ci->Env_model->view_where_order_limit($select,$table, $where, 'b.crelId','DESC', '1');
		} else {
			$data = $ci->Env_model->view_where_order($select,$table, $where, 'b.crelId','DESC');
		}

		$arrayarg = array();
		if(count($data)>0){
			foreach( $data as $categ ) {
				$arrayarg['id'][] 		= $categ['catId'];
				$arrayarg['name'][] 	= $categ['catName'];
				$arrayarg['url'][] 		= $ci->permalink->get('post-category', $categ['catId']);
				$arrayarg['desc'][] 	= $categ['catDesc'];
				$arrayarg['color'][] 	= $categ['catColor'];
			}
		}

		return $arrayarg;
	}

	public function getAllPostCategories(){
		$ci = $this->CI;

		if(countdata('categories',array('catActive'=>1,'catType'=>'post')) > 0){
			return $ci->Env_model->view_where_order('*','categories',array('catActive'=>1,'catType'=>'post'), 'catId','DESC');
		} else {
			return array();
		}
	}

	public function getPopularPost($limittotal = 10, $newestintervalday = null){
		$ci = $this->CI;

		$newest = '';
		if(!empty($newestintervalday)){
			// get latest post
			$maks = $ci->Env_model->view_where_order_limit("contentId,contentTimestamp", "contents", "contentStatus='1' AND contentType='post'",'contentTimestamp', 'DESC', 1)[0];

			$newest = " AND ( FROM_UNIXTIME(kontenTimestamp) >= FROM_UNIXTIME({$maks['contentTimestamp']}) - INTERVAL {$newestintervalday} DAY )";
		}

		$where = "contentStatus='1' AND contentType='post'". $newest;

		if(countdata('contents',$where) > 0){
			return $ci->Env_model->view_where_order_limit('*', 'contents', $where, 'contentRead', 'DESC', $limittotal);
		} else {
			return array();
		}
		
	}

	public function getRecentPost($limittotal = 10){
		$ci = $this->CI;

		$where = "contentStatus='1' AND contentType='post'";

		if(countdata('contents',$where) > 0){
			return $ci->Env_model->view_where_order_limit('*', 'contents', $where, 'contentId', 'DESC', $limittotal);
		} else {
			return array();
		}
	}
}
