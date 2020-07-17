<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
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
}
