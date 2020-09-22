<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permalink {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}
	
	public function get($param, $id=null){

		if(empty($id)){
			
			if(is_array($param)){
				
				$count = count($param);
				$x = 1;
				$permalink = '';
				foreach($param as $value){

					if($count!=$x AND $x!=1){ $permalink .='/'; }

					if( is_array($value) ){

						if($x!=1){ $permalink .='/'; }

						$x2 = 1;
						foreach($value as $vl){

							if($x2!=1){ $permalink .='-'; }

							$permalink .= esc_sql( filter_int($vl) );

							$x2++;
						}

					} else {

						$permalink .= esc_sql( filter_int($value) );

					}

					$x++;
				}

			} else {

				$permalink = $param;

			}

		} else {
			$id = esc_sql(filter_int($id));

			if( $param == 'post' ){

				$getdata = getval('contentId,contentTitle,contentSlug','contents', array('contentId'=>$id));
				$permalink = 'post/'.$getdata['contentId'].'-'. $getdata['contentSlug'];

			}
			elseif( $param == 'post-category' ){

				$getdata = getval('catId,catName,catSlug','categories', array('catId'=>$id));
				$permalink = 'post/category/'.$getdata['catId'].'-'.$getdata['catSlug'];

			}
			elseif( $param == 'page' ){

				$getdata = getval('contentId,contentTitle,contentSlug','contents', array('contentId'=>$id));
				$permalink = 'page/'.$getdata['contentId'].'-'. $getdata['contentSlug'];

			}
			elseif( $param == 'product' OR $param == 'catalog'){

				$getdata = getval('prodId,prodName','product', array('prodId'=>$id));
				$permalink = 'catalog/'.$getdata['prodId'].'-'.slugURL( $getdata['prodName'] );

			}
			elseif( $param == 'product-category' ){

				$getdata = getval('catId,catName','categories', array('catId'=>$id));
				$permalink = 'catalog/category/'.$getdata['catId'].'-'.slugURL( $getdata['catName'] );

			}
			elseif( $param == 'gallery' ){

				$getdata = getval('contentId,contentTitle','contents', array('catId'=>$id));
				$permalink = 'gallery/'.$getdata['contentId'].'-'. slugURL( $getdata['contentTitle'] );

			}
			elseif( $param == 'gallery-category' ){

				$getdata = getval('catId,catName','categories', array('catId'=>$id));
				$permalink = 'gallery/category/'.$getdata['catId'].'-'.slugURL( $getdata['catName'] );

			} else {

				$permalink = $param . ( ($id!=null) ? '/'.$id:'' );

			}

		}

		return base_url($permalink);
	}
}
