<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoppingcart extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		if (
			!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
			strtolower(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) !== 'xmlhttprequest' AND 
			'POST' != $_SERVER['REQUEST_METHOD'] AND 
			get_cookie('sz_token') == sz_token()
		) {
			show_404();
		}

		header("cache-control: private");
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
		show_404();
	}

	public function add(){

		$id = esc_sql( filter_int( $this->input->post('product', true) ) );
		$qty = esc_sql( filter_int( $this->input->post('qty', true) ) );
		$prodattrId = empty($this->input->post('productattr')) ? null: esc_sql( filter_int( $this->input->post('productattr', true) ) );

		if(empty($id) OR !is_numeric($id)){
			$status = 503;
			$response = array(
				'msg' => t('productidisemtpy'),
			);
		} else {
			$error = false;
			
			// rechecking whether the product still exist in database
			$is_product_exist = countdata("product", "prodId='{$id}'");

			if($is_product_exist > 0){

				// get product data
				$product = getval('*', 'product',array('prodId'=>$id));

				// quentity checking
				$qtyerror = false;
				if($qty > $product['prodQty'] AND $product['prodQtyType']!= 'unlimited'){
					$qtyerror = true;
				}
				
				$cartidwithattr = '';
				// get attribute data start here
				if( $prodattrId !=null ){
					$productattr = getval('*', 'product_attribute',array('pattrId'=>$prodattrId, 'prodId'=>$id));
					
					if($qty > $productattr['pattrQty'] AND $productattr['pattrQtyType']!='unlimited' ){

						if( $qtyerror == false ){ $qtyerror = false; }
						else { $qtyerror = true; }
						
					} else {
						$qtyerror = false;
					}

					$cartidwithattr = $prodattrId.'-';
					
				}

				if( $qtyerror ){
					$error = t('qtytoolarge');
				}

				// define data cart
				$datacart = array();
				$hasCart = $this->shopping_cart->hasCart();
				if( $hasCart ){
					// get data cart first 
					$datacart = $this->shopping_cart->dataCart();
				}

				if(!$error){

					// make unique cart ID for shopping cart identifying
					$cartid = sha1( sha1( $id . '-' .$cartidwithattr. $product['prodSku']) );

					// get the product name
					$productname = t( array( 'table'=>'product', 'field'=>'prodName', 'id'=>$product['prodId']) );

					// get currency code
					$currency = get_option('defaultcurrency');
					if( !empty(get_cookie('currency')) ){
						$currency = get_cookie('currency');
					}
					
					// get the product price
					$price = $product['prodPrice'];
					if( $prodattrId !=null ){
						if($productattr['pattrPrice']!='0.00') $price = $productattr['pattrPrice'];
					}
					$price = priceConvertCurrency( $price, $currency);

					//check if the product price have a discount
					$specialprice = '0.00';
					if($product['prodSpecialPrice']!='0.00'){
						$specialprice = priceConvertCurrency( $product['prodSpecialPrice'], $currency);
					}

					// declare final price
					$finalprice = $product['prodPrice'];
					if( $prodattrId !=null ){
						if($productattr['pattrPrice']!='0.00') $finalprice = $productattr['pattrPrice'];
					}

					if($product['prodSpecialPrice']!='0.00'){
						$finalprice = $product['prodSpecialPrice'];
					}

					// declare final price with product tax
					if($product['taxId'] > 0){

						$taxresult = countTax($finalprice, $product['taxId']);
						$finalprice = $finalprice + $taxresult;

					}
					$finalprice = priceConvertCurrency( $finalprice, $currency);

					// get tax data
					$gettaxval['rate'] = 0.0000;
					$gettaxval['type'] = '';
					if(count(getTaxValue($product['taxId'])) > 0) $gettaxval = getTaxValue($product['taxId']);
					
					// check if the product have the attribute
					$attribute = array();
					$attributeid = '';
					if($prodattrId != null){

						$attrval = $this->Env_model->view_where_order("*", "product_attribute_combination", "pattrId='{$prodattrId}'",'attrId','ASC');

						foreach($attrval as $attr ){
							$attrvariant = getval('attrLabel','attribute', array('attrId'=>$attr['attrId']));
							$attrvariantvalue = getval('attrvalLabel','attribute_value', array('attrvalId'=>$attr['attrvalId']));
							$attribute[$attrvariant] = $attrvariantvalue;
						}

						$attributeid = $prodattrId;
						
					}

					// set weight
					$weight = $product['prodWeight'];
					$weightunit = $product['prodWeightUnit'];
					if($prodattrId != null){
						if( $productattr['pattrWeight']!='0.00' ){

							$weight = $productattr['pattrWeight'];
							$weightunit = $productattr['pattrWeightUnit'];

						}
					}								

					$updatecart=false;
					$temp_qty = $qty;
					if( $hasCart AND count($datacart['cart'])>0 ){

						foreach($datacart['cart'] as $key => $cart){
							
							if( $cart['cartId'] == $cartid){ 
								$updatecart = true;

								$datacart['cart'][$key]['qty'] += $qty;

								$temp_qty = $datacart['cart'][$key]['qty'];

								// use minimum order as quantity if order quantity smaller than minimum order
								if($temp_qty < $product['prodMinOrder']){
									$temp_qty = $product['prodMinOrder'];
								}

								// use max order as quantity if order quantity bigger than maximum order
								if($temp_qty > $product['prodMaxOrder'] AND $product['prodMaxOrder'] != 0){
									$temp_qty = $product['prodMaxOrder'];
								}

								// set quantity again
								$datacart['cart'][$key]['qty'] = $temp_qty;
								break;

							}
							
						}

					}
					
					if(!$updatecart){
						$num = 1;
						// count the number of product added
						if( $hasCart ){
							$num = count($datacart['cart']) + 1;
						}
	
						for ($i=1; $i<=$num; $i++){

							if ( !isset($datacart['cart'][$i]['cartId']) ){

								// use minimum order as quantity if order quantity smaller than minimum order
								if($qty < $product['prodMinOrder']){
									$qty = $product['prodMinOrder'];
								}

								// use max order as quantity if order quantity bigger than maximum order
								if($qty > $product['prodMaxOrder'] AND $product['prodMaxOrder'] != 0){
									$qty = $product['prodMaxOrder'];
								}

								// get default image
								$defimgdir = '';
								$defimgfile = '';
								if(countdata('product_images', array('prodId'=>$id,'pimgPrimary'=>'y')) > 0){
									$prodimg = getval('pimgDir,pimgImg','product_images', array('prodId'=>$id,'pimgPrimary'=>'y'));
									$defimgdir = $prodimg['pimgDir'];
									$defimgfile = $prodimg['pimgImg'];
								}

								// define the cart
								$datacart['cart'][$i]['cartId'] = $cartid;
								$datacart['cart'][$i]['productId'] = $id;
								$datacart['cart'][$i]['taxId'] = $product['taxId'];
								$datacart['cart'][$i]['taxRate'] = $gettaxval['rate'];
								$datacart['cart'][$i]['taxType'] = $gettaxval['type'];
								$datacart['cart'][$i]['qty'] = $temp_qty;
								$datacart['cart'][$i]['name'] = $productname;
								$datacart['cart'][$i]['defaultImageDir'] = $defimgdir;
								$datacart['cart'][$i]['defaultImageFile'] = $defimgfile;
								$datacart['cart'][$i]['price'] = $price;
								$datacart['cart'][$i]['specialPrice'] = $specialprice;
								$datacart['cart'][$i]['finalPrice'] = $finalprice;
								$datacart['cart'][$i]['weight'] = $weight;
								$datacart['cart'][$i]['weightUnit'] = $weightunit;
								$datacart['cart'][$i]['length'] = $product['prodLength'];
								$datacart['cart'][$i]['width'] = $product['prodWidth'];
								$datacart['cart'][$i]['height'] = $product['prodHeight'];
								$datacart['cart'][$i]['lengthUnit'] = $product['prodLengthUnit'];
								$datacart['cart'][$i]['prodShipping'] = $product['prodShipping'];
								$datacart['cart'][$i]['freeShipping'] = $product['prodFreeShipping'];
								$datacart['cart'][$i]['attribute'] = $attribute; // array
								$datacart['cart'][$i]['attributeId'] = $attributeid;

							}

						}
	
					}

					// recalculate for total cart
					$totalcart = isset($datacart['totalcart'])?$datacart['totalcart']:'';
					$finaltotalcart = isset($datacart['finaltotalcart'])?$datacart['finaltotalcart']:'';
					$totalsavingcart = isset($datacart['totalsavingcart'])?$datacart['totalsavingcart']:'';
					$usedefaultax = array();
					if(count($datacart['cart'])>0){
						$totalprice = 0.00;
						$totalsaving = 0.00;
						$totalfinal = 0.00;				
						foreach($datacart['cart'] as $key => $cart){
							$usedefaultax[] = ($datacart['cart'][$key]['taxId']==get_option('taxId'))?'y':'n';

							// recalculating . . .
							if( $datacart['cart'][$key]['specialPrice'] != '0.00'){
								$totalprice += $datacart['cart'][$key]['specialPrice'] * $datacart['cart'][$key]['qty'];
								$totalsaving += ($datacart['cart'][$key]['price'] - $datacart['cart'][$key]['specialPrice']) * $datacart['cart'][$key]['qty'];
							} else {
								$totalprice += $datacart['cart'][$key]['price'] * $datacart['cart'][$key]['qty'];
							}

							$totalfinal += $datacart['cart'][$key]['finalPrice'] * $datacart['cart'][$key]['qty'];

						}
						
						$difftotal = $totalfinal - $totalprice;
						if($difftotal > 0){
							$totalsaving = $totalsaving - $difftotal;
						}

						$totalcart = $totalprice;
						$totalsavingcart = $totalsaving;
						$finaltotalcart = $totalfinal;
					}

					$datacart['currency'] = $currency;
					$datacart['totalcart'] = $totalcart;
					$datacart['finaltotalcart'] = $finaltotalcart;
					$datacart['totalsavingcart'] = $totalsavingcart;
					$datacart['defaulttax'] = ( get_option('taxstatus') == 'y' )? get_option('taxId'):0;
					$datacart['taxstatus'] = get_option('taxstatus');
					$datacart['allusedefaulttax'] = (in_array('n',$usedefaultax))?false:true;
					
					$this->shopping_cart->setCart($datacart);

					$status = 200;
					$response = array(
						'msg' => sprintf( t('addtoshoppingcartsuccessfull'), $productname, $temp_qty ),
					);
				}

				if( $error ){
					$status = 503;
					$response = array(
						'msg' => $error,
					);
				}				
				
			} else {
				$this->shopping_cart->setCart(array());

				$status = 503;
				$response = array(
					'msg' => t('shoppingcarthasbeenemptied'),
				);
			}
		}

		$returndata = array(
			'status' => $status,
			'data' => $response
		);

		// make absolute for json file with header
		header('Content-Type: application/json');
		echo json_encode((object) $returndata);

	}

	public function addqty(){
		$cartid = esc_sql( filter_txt( $this->input->post('cartid', true) ) );
		$qty = esc_sql( filter_int( $this->input->post('qty', true) ) );

		if(empty($cartid) OR !is_numeric($qty)){
			$status = 503;
			$response = array(
				'msg' => t('shoppingcartnotfound'),
			);
		} else {
			$error = false;

			// define data cart
			$datacart = array();
			$hasCart = $this->shopping_cart->hasCart();
			if( $hasCart ){
				// get data cart first 
				$datacart = $this->shopping_cart->dataCart();
			} else {
				$error = t('shoppingcartnotfound');
			}

			if($qty < 1){
				$error = t('qtycannotbeempty');
			}

			if(!$error){
				
				$temp_qty = $qty;
				$updateqty = false;

				if(count($datacart['cart'])>0 AND $hasCart){

					$totalcart = $datacart['totalcart'];
					$totalsavingcart = $datacart['totalsavingcart'];
					$totalprice = 0.00;

					foreach($datacart['cart'] as $key => $cart){
						
						if( $cart['cartId'] == $cartid){ 
							$prodid = esc_sql( filter_int($cart['productId']));

							$product = getval('*', 'product',array('prodId'=>$prodid));

							// quentity checking
							$qtyerror = false;
							if($qty > $product['prodQty'] AND $product['prodQtyType']!= 'unlimited'){
								$qtyerror = true;
							}
							
							// get attribute data start here
							if( $cart['attributeId'] !=null ){
								$prodattrId = esc_sql(filter_int($cart['attributeId']));
								$productattr = getval('*', 'product_attribute',array('pattrId'=>$prodattrId, 'prodId'=>$prodid));
								
								if($qty > $productattr['pattrQty'] AND $productattr['pattrQtyType']!='unlimited' ){

									if( $qtyerror == false ){ $qtyerror = false; }
									else { $qtyerror = true; }
									
								} else {
									$qtyerror = false;
								}
								
							}

							if( $qtyerror ){

								$error = t('qtytoolarge');

							} else {
								$updateqty = true;

								// use minimum order as quantity if order quantity smaller than minimum order
								if($temp_qty < $product['prodMinOrder']){
									$temp_qty = $product['prodMinOrder'];
								}

								// use max order as quantity if order quantity bigger than maximum order
								if($temp_qty > $product['prodMaxOrder'] AND $product['prodMaxOrder'] != 0){
									$temp_qty = $product['prodMaxOrder'];
								}

								// set quantity again
								$datacart['cart'][$key]['qty'] = $temp_qty;

								// recalculating total price
								$specialprice = $datacart['cart'][$key]['specialPrice'];
								$price = $datacart['cart'][$key]['price'];

								if( $specialprice != '0.00'){
									$totalprice += $specialprice * $temp_qty;
									$totalsavingcart += ($price - $specialprice) * $temp_qty;
								} else {
									$totalprice += $price * $temp_qty;
								}
							}
							break;

						}
						
					}
				}
				
				if(!$error){

					if( $updateqty ){
						// recalculate for total cart
						$totalcart = $datacart['totalcart'];
						$finaltotalcart = $datacart['finaltotalcart'];
						$totalsavingcart = $datacart['totalsavingcart'];
						if(count($datacart['cart'])>0){
							$totalprice = 0.00;
							$totalsaving = 0.00;
							$totalfinal = 0.00;			
							foreach($datacart['cart'] as $key => $cart){

								// recalculating . . .
								if( $datacart['cart'][$key]['specialPrice'] != '0.00'){
									$totalprice += $datacart['cart'][$key]['specialPrice'] * $datacart['cart'][$key]['qty'];
									$totalsaving += ($datacart['cart'][$key]['price'] - $datacart['cart'][$key]['specialPrice']) * $datacart['cart'][$key]['qty'];
								} else {
									$totalprice += $datacart['cart'][$key]['price'] * $datacart['cart'][$key]['qty'];
								}

								$totalfinal += $datacart['cart'][$key]['finalPrice'] * $datacart['cart'][$key]['qty'];

							}
							$totalcart = $totalprice;
							$totalsavingcart = $totalsaving;
							$finaltotalcart = $totalfinal;
						}

						$datacart['totalcart'] = $totalcart;
						$datacart['finaltotalcart'] = $finaltotalcart;
						$datacart['totalsavingcart'] = $totalsavingcart;
					}

					$this->shopping_cart->setCart($datacart);

					$status = 200;
					$response = array(
						'msg' => t( 'qtysuccessfullyupdated' ),
					);
				}

			}

			if($error){
				$status = 503;
				$response = array(
					'msg' => $error,
				);
			}
		}

		$returndata = array(
			'status' => $status,
			'data' => $response
		);

		// make absolute for json file with header
		header('Content-Type: application/json');
		echo json_encode((object) $returndata);
	}

	public function removecartitem(){

		$cartid = esc_sql( filter_txt( $this->input->post('cartid', true) ) );

		if(empty($cartid)){
			$status = 503;
			$response = array(
				'msg' => t('shoppingcartnotfound'),
			);
		} else {

			$error = false;

			// define data cart
			$datacart = array();
			$hasCart = $this->shopping_cart->hasCart();
			if( $hasCart ){
				// get data cart first 
				$datacart = $this->shopping_cart->dataCart();
			} else {
				$error = t('shoppingcartnotfound');
			}

			if(!$error){

				$delete_all_cart = true;
				foreach ($datacart as $key => $value) {

					if($key == 'cart'){

						foreach($datacart['cart'] as $key_cart => $value_cart){
							if( in_array($cartid, $value_cart) ){

								unset($datacart['cart'][$key_cart]);continue;
		
							} else {
								$delete_all_cart = false;
							}
						}

					}
				}

				if($delete_all_cart){
					$this->shopping_cart->unsetCart();
				} else {

					if( count( $datacart['cart'] ) > 0 ){

						// recalculate for total cart
						$totalcart = $datacart['totalcart'];
						$finaltotalcart = $datacart['finaltotalcart'];
						$totalsavingcart = $datacart['totalsavingcart'];
						if(count($datacart['cart'])>0){
							$totalprice = 0.00;
							$totalsaving = 0.00;
							$totalfinal = 0.00;
							foreach($datacart['cart'] as $key => $cart){

								// recalculating . . .
								if( $datacart['cart'][$key]['specialPrice'] != '0.00'){
									$totalprice += $datacart['cart'][$key]['specialPrice'] * $datacart['cart'][$key]['qty'];
									$totalsaving += ($datacart['cart'][$key]['price'] - $datacart['cart'][$key]['specialPrice']) * $datacart['cart'][$key]['qty'];
								} else {
									$totalprice += $datacart['cart'][$key]['price'] * $datacart['cart'][$key]['qty'];
								}

								$totalfinal += $datacart['cart'][$key]['finalPrice'] * $datacart['cart'][$key]['qty'];

							}
							$totalcart = $totalprice;
							$totalsavingcart = $totalsaving;
							$finaltotalcart = $totalfinal;
						}

						$datacart['totalcart'] = $totalcart;
						$datacart['finaltotalcart'] = $finaltotalcart;
						$datacart['totalsavingcart'] = $totalsavingcart;

						$this->shopping_cart->setCart($datacart);
					} else {
						$this->shopping_cart->unsetCart();
					}
				}

				$status = 200;
				$response = array(
					'msg' => t( 'successfullydeleted' ),
				);

			}

			if($error){
				$status = 503;
				$response = array(
					'msg' => $error,
				);
			}

		}

		$returndata = array(
			'status' => $status,
			'data' => $response
		);

		// make absolute for json file with header
		header('Content-Type: application/json');
		echo json_encode((object) $returndata);
	}

	public function removecart(){
		
		$result = $this->shopping_cart->unsetCart();

		if($result){
			$returndata = array(
				'status' => 200,
				'msg' => t('shoopingcartremovedsuccessfull')
			);
		} else {
			$returndata = array(
				'status' => 503,
				'msg' => t('somethingwronghappened')
			);
		}

		// make absolute for json file with header
		header('Content-Type: application/json');
		echo json_encode((object) $returndata);

	}
}
