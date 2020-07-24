<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		// load model random string
		$this->load->model('memberauth_model');
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
        //title web
        $webtitle = 'Login';

        // set meta web page
        $web_meta = web_head_properties(
            
            array(                
                // FB Open Graph
                'og' => array(
                    'og:title' 		=> $webtitle .' - '. get_option('sitename'),
                    'og:description' => get_option('sitedescription')
                ),

                // Twitter Cards
                'twitter' => array(
                    'twitter:title' 	=> $webtitle .' - '. get_option('sitename'),
                    'twitter:description' => get_option('sitedescription'),
                    'twitter:card' => 'summary'
                ),

                // Google+ / Schema.org
                'g+' => array(
                    'name' => $webtitle .' - '. get_option('sitename'),
                    'headline' => $webtitle .' - '. get_option('sitename'),
                    'description' => get_option('sitedescription')
                ),
            )
        );

        $dataview = array( 
                    'title' => $webtitle .' - '. get_option('sitename'),
                    'web_meta' => $web_meta,
                );
        $this->load->view( 'login', $dataview);            
	}

	public function action($onpage = null){

		$error = false; $msg = '';

		$username = esc_sql(filter_txt( $this->input->post('username', true) ) );
		$password = esc_sql(filter_txt( $this->input->post('password', true) ) );

		if($onpage == null OR $onpage=='y'){

			$passwordunik = sha1( 
								sha1(
									encoder( $password .'>>>>'. LOGIN_SALT ) 
								) . "#" . LOGIN_SALT
							);

			// validate first data
			if( empty($username) AND !empty($password) ){
				$error = true;
				$msg = t('memberloginusernameinvalid');
			}
			
			if( !empty($username) AND empty($password) ) {
				$error = true;
				$msg = t('memberloginpasswordinvalid');
			} 
			
			if( empty($username) AND empty($password) ) {
				$error = true;
				$msg = t('memberloginusernamepasswordinvalid');
			}

			if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
				$error = true;
				$msg = t('emailinvalid');
			}

			if(!$error){
				$authlogin = $this->memberauth_model->login_auth($username);
				$userPass = isset( $authlogin->mPassword )? $authlogin->mPassword:'';

				if ( password_verify($passwordunik, $userPass) ){

					$logindata = $this->memberauth_model->get_auth_data($authlogin->mEmail, $authlogin->mPassword);
					
					// check verify status
					$verifystatus = 'y';
					if(!empty($logindata['mEmailSecureKey']) OR !empty($logindata['mHPSecureKey'])){
						$verifystatus = 'n';
					}

					// set variable for default language and currency
					$defaultlang = (empty($logindata['mDefaultLang'])) ? $this->config->item('language') : $logindata['mDefaultLang'];
					$defaultcurrency = (empty($logindata['mDefaultCurrency'])) ? get_option('defaultcurrency') : $logindata['mDefaultCurrency'];

					// cookie expiration
					$expiredcook = 86400; // 1 day

					$timestamp = time2timestamp();
					
					// set cookie here
					$cookie_set = array(
						array(
							'name'   => 'member',
							'value'  => $logindata->mId,
							'expire' => $expiredcook,
							'path ' => '/',
						),
						array(
							'name'   => 'lang',
							'value'  => $defaultlang,
							'expire' => $expiredcook,
							'path ' => '/',
						),
						array(
							'name'   => 'memberemail',
							'value'  => $logindata['mEmail'],
							'expire' => $expiredcook,
							'path ' => '/',
						),
						array(
							'name'   => 'currency',
							'value'  => $defaultcurrency,
							'expire' => $expiredcook,
							'path ' => '/',
						),
						array(
							'name'   => 'checkpoint',
							'value'  => loginCP(),
							'expire' => $expiredcook,
							'path ' => '/',
						),
						array(
							'name'   => 'verifystatus',
							'value'  => $verifystatus,
							'expire' => $expiredcook,
							'path ' => '/',
						),
						array(
							'name'   => 'lastlog',
							'value'  => $timestamp,
							'expire' => $expiredcook,
							'path ' => '/',
						),

						// for warungkita cookies
						array(
							'name'   => 'prod_city',
							'value'  => (empty($logindata['cityId'])) ? get_option('defaultcity'):$logindata['cityId'],
							'expire' => $expiredcook,
							'path ' => '/',
						)
					);
					foreach($cookie_set as $cook_val){
						set_cookie($cook_val);
					}

					// update member login
					$updt = array(
								'mLastLogin' => time2timestamp()
							);
					$this->memberauth_model->update_login($logindata->mId, $updt);

					// redirectlogin
					$url = !empty( $this->input->post('redirect') ) ? $this->input->post('redirect') : base_url();
					
					if($onpage=='y'){
						echo "200||".t('memberloginsuccessfully')."||".$url;
					} else {
						redirect($url);
					}

				} else {
					$error = true;
					$msg = t('memberlogininvalid');
				}
			} 

		} else {
			$msg = t('memberloginwrongprocess');
		}

		if($error){

			if($onpage=='y'){

				echo "503||".$msg;

			} else {

				$this->session->set_flashdata( 'user_input', $username );
				$this->session->set_flashdata( 'pass_input', $password );
				$this->session->set_flashdata( 'errormsg', $msg );

				$url = !empty( $this->input->post('redirect') ) ? $this->input->post('redirect') : base_url();
				redirect( $url );

			}
		}

	}
	
}
