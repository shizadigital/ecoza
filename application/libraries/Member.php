<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member {
    
    protected $CI;
    
    public function __construct(){
		$this->CI =& get_instance();
		
		if(get_cookie('sz_token') !== sz_token()) base_url();
	}

	/**
	 * get member ID with filter
	 *
	 * @return void
	 */
	public function memberId(){
		if( $this->is_login() ){
			return esc_sql( filter_int( get_cookie('member',true) ) );
		}
	}

	/**
	 * Check member is login or not
	 *
	 * @return boolean
	 */
	public function is_login(){
		$return = false;
		if( !empty(get_cookie('member')) AND !empty(get_cookie('checkpoint'))  AND !empty(get_cookie('lastlog')) AND !empty(get_cookie('memberemail')) ){
			$return = true;
		}

		return $return;
	}

	/**
	 * Check member address
	 *
	 * @return boolean
	 */
	public function hasAddress(){
		$result = false;
		if( $this->is_login() ){
			$memberid = esc_sql( filter_int( get_cookie('member',true) ) );

			if( countdata('member_addressbook',array('mId'=>$memberid)) > 0 ){
				$result = true;
			}

		}

		return $result;
	}

	/**
	 * get all address of member
	 *
	 * @return array
	 */
	public function getAddressData(){
		$result = array();

		if($this->hasAddress()){
			$ci = $this->CI;

			$memberid = esc_sql( filter_int( get_cookie('member',true) ) );

			$result = $ci->Env_model->view_where_order('*','member_addressbook',array('mId'=>$memberid),'maddrId','ASC');
		}

		return $result;

	}

	/**
	 * get primary address of member
	 *
	 * @param string $name
	 * @return array
	 */
	public function getPrimaryAddress($field = null){
		$result = array();

		if($this->hasAddress()){
			$memberid = esc_sql( filter_int( get_cookie('member',true) ) );

			$data = getval('*','member_addressbook',array('mId'=>$memberid,'maddrPriority'=>'primary'));
			$result = ( $field != null ) ? $data[$field] : $data;
		}

		return $result;
	}

	/**
	 * Get all data member
	 *
	 * @param string $field
	 * @return array|string
	 */
	public function getMemberData($field = null){
		if( $this->is_login() ){
			$memberid = esc_sql( filter_int( get_cookie('member',true) ) );

			$data = getval('*','member',array('mId'=>$memberid,'mDeleted'=>'0'));
			return ( $field != null ) ? $data[$field] : $data;
		}
	}

	
}
