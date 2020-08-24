<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Variables {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}

	public function staticlist(){

		$vars = [
			'{HOME_URL}' => substr(base_url(), 0, -1),
			'{SITENAME}' => get_option('sitename'),
			'{SITEMAIL}' => get_option('siteemail'),
			'{SIGNATURE}' => get_option('emailsignature'),
			'{SITEPHONE}' => get_option('sitephone'),
			'{SITELOGOURL}' => logo_url('medium'),
			'{SITELOGO}' => '<img src="'.logo_url('medium').'" alt="'.web_info('tagline').'">',
		];

		return $vars;

	}

	/**
	 *
	 * get variable result
	 *
	 * @param string $string
	 * @param array|string $vars
	 * @param string $to
	 * 
	 * @return string
	 */
	public function parsing($string=null, $vars=null, $to = null){
		$result = null;

		if( $string != null ){ 

			if($vars == null){

				$patternlist = $this->staticlist();
				$result = strtr($string, $patternlist);

			} else {

				if( is_array($vars) ){
				
					$variables = array();
					foreach($vars as $key => $value){
						$key = '{'.strtoupper($key).'}';
						$variables[$key] = $value;
					}

					$variables = array_merge($variables, $this->staticlist()); 
		
					$result = strtr($string, $variables);
		
				} else {
		
					if( $to != null ){
						$result = strtr($string, $vars, $to);
					}
		
				}

			}
			
		}
		
		return $result;
	}

}
