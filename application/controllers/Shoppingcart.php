<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoppingcart extends CI_Controller {
	
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

	}

	public function add(){

		$id = esc_sql( filter_int( $this->input->post('product', true) ) );
		$qty = esc_sql( filter_int( $this->input->post('qty', true) ) );
		$prodattrId = empty($this->input->post('productattr')) ? null: esc_sql( filter_int( $this->input->post('productattr', true) ) );

		if(empty($id) OR !is_numeric($id)){
			echo '503||'.t('productidisemtpy');
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
					$price = priceConvertCurrency( $product['prodPrice'], $currency);
					if( $prodattrId !=null ){
						if($productattr['pattrPrice']!='0.00') $price = priceConvertCurrency( $productattr['pattrPrice'], $currency);
					}
					
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

					$specialprice = '0.00';
					//check if the product price have a discount
					if($product['prodSpecialPrice']!='0.00'){
						$specialprice = priceConvertCurrency( $product['prodPrice'], $currency);
					}					

					$updatecart=false;
					$temp_qty = $qty;
					if( $hasCart ){ 
						if(count($datacart['cart'])>0 ){

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

					}
					
					if(!$updatecart){
						$num = 1;
						// count the number of product added
						if( $hasCart ){
							$num = count($datacart['cart'])+1;
						}
	
						for ($i=1; $i<=$num; $i++){

							if ( empty($datacart['cart'][$i]['productid']) ){

								// use minimum order as quantity if order quantity smaller than minimum order
								if($qty < $product['prodMinOrder']){
									$qty = $product['prodMinOrder'];
								}

								// use max order as quantity if order quantity bigger than maximum order
								if($qty > $product['prodMaxOrder'] AND $product['prodMaxOrder'] != 0){
									$qty = $product['prodMaxOrder'];
								}

								// getting 
								$datacart['cart'][$i]['cartId'] = $cartid;
								$datacart['cart'][$i]['productId'] = $id;
								$datacart['cart'][$i]['qty'] = $temp_qty;
								$datacart['cart'][$i]['name'] = $productname;
								$datacart['cart'][$i]['price'] = $price;
								$datacart['cart'][$i]['specialPrice'] = $specialprice;
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

					$datacart['currency'] = $currency;

					$this->shopping_cart->setCart($datacart);
		
					echo "200||" . sprintf( t('addtoshoppingcartsuccessfull'), $productname, $temp_qty );
				}

				if( $error ){
					echo "503||" . $error;
				}
			} else {
				$SETCART['cart'] = array();

				$this->shopping_cart->setCart($SETCART);
			}

		}

	}

	// tester page shopingcart
	public function addqty(){
		
	}
}
