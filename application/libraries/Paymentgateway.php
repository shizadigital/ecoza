<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentgateway {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}

	/**
	 * Get payment setting
	 *
	 * @param boolean $gateway
	 * @param boolean $option
	 * @return string|null
	 */
	public function getPaymentSetting($gateway=false, $setting=false ){
		$result = null;

		if($gateway AND $setting){

			$opt_name = esc_sql($setting);
			$gateway = esc_sql($gateway);

			$dataval = getval('paymentValue','payment_gateway',array('paymentGateway'=> $gateway,'paymentSetting'=>$opt_name));

			$result = $dataval;

		}	

		return $result;
	}

	/**
	 * Get all payment list
	 *
	 * @param string|null $visible
	 * @return array
	 */
	public function paymentList($visible = null){
		$ci = $this->CI;

		$select = 'DISTINCT(a.paymentGateway), a.paymentValue, a.paymentSorting, a.paymentGateway, a.paymentSetting, b.paymentValue as visible';
		$where = "a.paymentSetting='name' AND b.paymentSetting='visible'";

		if($visible == 'on'){			
			$where .= " AND b.paymentValue='on'";
		}
		elseif($visible == 'off'){			
			$where .= " AND b.paymentValue='off'";
		}
		
		$getdata = $ci->Env_model->view_join_where_order($select,'payment_gateway a','payment_gateway b', 'a.paymentGateway=b.paymentGateway', '', $where, 'a.paymentSorting', 'ASC');

		$listdata = array();
		foreach($getdata as $list){
			
			$listdata[$list['paymentGateway']] = $list['paymentValue']; 

		}
		
		return $listdata;
	}

	/**
	 * Get name of payment method
	 *
	 * @param string|null $key
	 * @return string
	 */
	public function getPaymentName($key=null){
		$result = null;

		if($key!= null){

			$result = getval('paymentValue','payment_gateway',array('paymentGateway'=> $key,'paymentSetting'=>'name'));

		}	

		return $result;
	}

	/**
	 * Get type of payment method
	 *
	 * @param string|null $key
	 * @return string
	 */
	public function getPaymentType($key=null){
		$result = null;

		if($key!= null){

			$result = getval('paymentValue','payment_gateway',array('paymentGateway'=> $key,'paymentSetting'=>'type'));

		}	

		return $result;
	}
}
