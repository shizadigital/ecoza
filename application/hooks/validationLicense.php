<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class validationLicense {

	public function __construct(){
        $this->CI =& get_instance();
	}

	public function getLicense(){
		global $license2016;

		require_once ( dirname( dirname(__FILE__) ) . '/config/license.php' );

		$license = unserialize( decoder( $license2016 ) );

		unset($license2016);

		return $license;
	}

	private function is_serial($redirect = false){
		$license = $this->getLicense();

		$check = false;

		if( SERIAL_KEY == $license['serialnumber'] ){
			if ((int)$license['expire']!==0){
				if((int)$license['expire'] < time()){
					$check = false;
				}
			} else { $check = true; }
		}

		unset($license);
		if($check == true){ return true; } 
		else {
			if($redirect == true) {
				redirect( 'licenseinvalid.html' );
				exit;
			} else 
				return false; 
		}
	}

	public function license_check($return = '',$redirect = false){
		$license = $this->getLicense();
		$result = false;

		if( $this->is_serial() ){ 
			if( $return == 'domain' ){
				
				$http = 'http' . ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']=='https') ? 's' : '') . '://';

				if( get_option('httpsmode')=='yes' ){
					$http = 'https://';
				}

				//$domainopt = str_replace($http, "", get_option('siteurl'));
				$domainopt = str_replace($http, "", $_SERVER['SERVER_NAME']);

				if(in_array($domainopt,$license['domain']) AND count($license['domain'])>0){

					if(isset($_SERVER['HTTP_USER_AGENT'])){
						$host = str_replace("www.","",getenv('SERVER_NAME'));
						if(!empty($host) and !in_array($host, $license['domain'])){
							$result = false;
						} else { $result = true; }
					} else { $result = true; }
					
				}
			}
			elseif( $return == 'admindirectory' ){
				if( $this->CI->config->item('admin_slug') == $license['admindirectory']){ $result = true; } else { $result = false; }
			}
			// disable language license for while
			// elseif( $return == 'language' ){
			// 	$listlanguage = langlist();
			// 	if(count(array_intersect($license['language'], $listlanguage)) == count($license['language'])){ $result = true; } else { $result = false; }
			// }
		}

		unset($license);
		if( $result ){
			return $result;
		} else {
			if($redirect==true){
				redirect( 'licenseinvalid.html' );
				exit;
			} else {
				return false;
			}
		}
	}

	public function license_handler(){
		$result = false;

		if( $this->is_serial() ){ 
			if( 
				$this->license_check('domain')
				AND $this->license_check('admindirectory')
				// AND $this->license_check('language') disable multilanguage for while
			) $result = true;
		}
		
		if( $result ){ 
			return true;
		} else { 
			redirect( 'licenseinvalid.html' );
			exit;
		}
	}

}
