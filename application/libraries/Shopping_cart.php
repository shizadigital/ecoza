<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping_cart {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}

	/**
	 * Check cart data availability
	 *
	 * @return boolean
	 */
	public function hasCart(){
		$result = false;
		if( get_cookie('sz_token') === sz_token() ):

			if( count( $this->dataCart() ) > 0){
				$result = true;
			}

		endif;

		return $result;
	}

	/**
	 * Get all cart data
	 *
	 * @return array
	 */
	public function dataCart(){
		$ci = $this->CI;

		$data = array();

		if( get_cookie('sz_token') === sz_token() ):

			$storeId = $ci->session->userdata('visitor_storeid');
			
			if( $ci->member->is_login() ){

				$memberid = esc_sql( filter_int( get_cookie('member', true)) );

				// check data of member cart first
				$councart = countdata("cart","memId='{$memberid}' AND storeId='{$storeId}' AND cartVisitorType='member' AND cartData!='' AND cartStatus='onprogress'");

				if($councart > 0){

					$SPC_D = getval("cartData","cart","memId='{$memberid}' AND storeId='{$storeId}' AND cartVisitorType='member' AND cartData!='' AND cartStatus='onprogress'");

				}
			} else {

				$SPC_D = ( $ci->session->has_userdata('SPC_D') AND $ci->session->userdata('SPC_D')!='' )? $ci->session->userdata('SPC_D'): '';

			}

			if( !empty($SPC_D) ){
				
				// decryption the data
				$exp_data = explode("###", decoder($SPC_D));

				// check the token
				if( base_url() === $exp_data[1] ){
					// unserialize
					$data = unserialize($exp_data[0]);
				}
				
			}

		endif;

		return $data;
	}

	/**
	 * Add shopping cart
	 *
	 * @param array $data
	 * @return bool
	 */
	public function setCart( $data = array() ){
		$ci = $this->CI;

		if( is_array($data) AND get_cookie('sz_token') === sz_token() ){

			$storeId = $ci->session->userdata('visitor_storeid');

			$now = time2timestamp();
			
			$serialize = serialize($data);

			// encryption cart data
			$shoppingcart = encoder($serialize."###".base_url());

			if( $ci->member->is_login() ){
				// add data cart for member

				session_regenerate_id();
				$newsessionID = session_id();

				$memberid = esc_sql( filter_int( get_cookie('member', true)) );

				// check member cart first
				$councart = countdata("cart","memId='{$memberid}' AND storeId='{$storeId}' AND cartVisitorType='member' AND cartStatus='onprogress'");

				if( $councart > 0){
					// if data cart is available
					$cartdata = array(
						'cartSessionId'	=> $newsessionID,
						'cartData' 		=> $shoppingcart,
						'cartModified' 	=> $now,
						'cartIp'  		=> getIP()
					);
					$ci->Env_model->update( "cart", $cartdata, "mId='{$_COOKIE['cook_m_id']}' AND cartVisitorType='member' AND cartStatus='onprogress'" );

				} else {
					// if data cart is not available
					$nextID = getNextId('cartId','cart');
					$cartdata = array(
								'cartId' 		=> $nextID,
								'memId' 		=> $memberid,
								'storeId'		=> $storeId,
								'cartSessionId' => $newsessionID,
								'cartData' 		=> $shoppingcart,
								'cartAdded' 	=> $now,
								'cartModified' 	=> $now,
								'cartIp' 		=> getIP(),
								'cartStatus'	=> 'onprogress',
								'cartVisitorType' => 'member',
							);
					$ci->Env_model->insert( "cart", $cartdata );
				}

			} else {
				// add data cart for guest

				$time = 86400; // 1 day

				session_regenerate_id();

				$time = time()+$time;
				
				$newdata = array(
					'cart_timeout' => $time,
					'SPC_D' => $shoppingcart
				);
				$ci->session->set_userdata($newdata);

			}

			return true;

		} else {
			return false;
		}
		
	}

	/**
	 * Remove shopping cart
	 *
	 * @return bool
	 */
	public function unsetCart(){
		$ci = $this->CI;
		$result = false;

		$storeId = $ci->session->userdata('visitor_storeid');

		// unset variable cart
		if( $ci->member->is_login() ){
			$sessionID = session_id();

			$memberid = esc_sql( filter_int( get_cookie('member', true)) );

			// check data of member cart first
			$councart = countdata("cart","memId='{$memberid}' AND storeId='{$storeId}' AND cartVisitorType='member' AND cartSessionId='{$sessionID}'");
			if($councart > 0){
				$del = $ci->Env_model->delete( "cart", "memId='{$memberid}' AND storeId='{$storeId}' AND cartVisitorType='member' AND cartSessionId='{$sessionID}'" );
			} else {
				// get session on progress
				$sessionID = getval("cartSessionId","cart","memId='{$memberid}' AND cartVisitorType='member' AND cartStatus='onprogress'");

				$del = $ci->Env_model->delete( "cart", "memId='{$_COOKIE['cook_m_id']}' AND cartVisitorType='member' AND cartSessionId='{$sessionID}'" );
			}

			if($del){ $result = true; }
		} else {
			if( $ci->session->has_userdata('SPC_D') ){
				$itemcart = array(
					'SPC_D',
					'cart_timeout'
				);
				$ci->session->unset_userdata($itemcart);
				$result = true;
			}
		}

		// regenerate new session ID
		session_regenerate_id();

		return $result;
	}

	public function totalCart(){
		$total = 0;

		if($this->hasCart()){

			$datacart = $this->dataCart();
			if(isset($datacart['cart'])){
				$total = count($datacart['cart']);
			}
		}
		return $total;
	}

	public function miniCart(){

	}
	
}
