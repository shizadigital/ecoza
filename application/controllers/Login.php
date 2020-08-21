<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		if( $this->member->is_login() ){ redirect( base_url() ); }

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
			
			if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
				$error = true;
				$msg = t('emailinvalid');
			}

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

			if(!$error){
				$authlogin = $this->memberauth_model->login_auth($username);
				$userPass = isset( $authlogin->mPassword )? $authlogin->mPassword:'';

				if ( password_verify($passwordunik, $userPass) ){

					$logindata = $this->memberauth_model->get_auth_data($authlogin->mId, $authlogin->mPassword);
					
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

					// get current domain
					$domain = getDomain( current_url() );
					
					// set cookie here
					$cookie_set = array(
						array(
							'name'   => 'member',
							'value'  => $logindata['mId'],
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'lang',
							'value'  => $defaultlang,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'memberemail',
							'value'  => $logindata['mEmail'],
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'currency',
							'value'  => $defaultcurrency,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'checkpoint',
							'value'  => loginCP(),
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'verifystatus',
							'value'  => $verifystatus,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'lastlog',
							'value'  => $timestamp,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
					);
					foreach($cookie_set as $cook_val){
						set_cookie($cook_val);
					}

					// update member login
					$updt = array(
								'mLastLogin' => time2timestamp()
							);
					$this->memberauth_model->update_login($logindata['mId'], $updt);

					// if member has cart data, insert into database
					if( $this->shopping_cart->hasCart() ){

						// remove old cart first
						if( countdata("cart","mId='{$logindata['mId']}' AND cartVisitorType='member' AND cartData!='' AND cartStatus='onprogress'")>0 ){
							// remove old data cart
							$this->Env_model->delete("cart","mId='{$logindata['mId']}' AND cartVisitorType='member' AND cartData!='' AND cartStatus='onprogress'");
						}
						
						// get cart first
						$datacart = $this->shopping_cart->dataCart();

						// reset cart data with member ID
						$this->shopping_cart->setCart($datacart, $logindata['mId']);

						// unset cart session in guest
						$itemcart = array(
							'SPC_D',
							'cart_timeout'
						);
						$this->session->unset_userdata($itemcart);
					}

					// redirectlogin
					$url = !empty( $this->input->post('redirect') ) ? $this->input->post('redirect') : base_url();
					
					if($onpage=='y'){
						$status = 200;
						$response = array(
							'msg' => t('memberloginsuccessfully'),
							'url' => $url
						);
					} else {
						redirect($url);
					}

				} else {
					$error = true;
					$msg = t('memberlogininvalid');
				}
			}

		} else {
			$error = true;
			$msg = t('memberloginwrongprocess');
		}

		if($error){

			if($onpage=='y'){

				$status = 503;
				$response = array(
					'msg' => $msg,
				);

			} else {

				$this->session->set_flashdata( 'user_input', $username );
				$this->session->set_flashdata( 'pass_input', $password );
				$this->session->set_flashdata( 'errormsg', $msg );

				$url = !empty( $this->input->post('redirect') ) ? $this->input->post('redirect') : base_url();
				redirect( $url );

			}
		}

		if($onpage=='y'){

			$returndata = array(
				'status' => $status,
				'data' => $response
			);
	
			// make absolute for json file with header
			header('Content-Type: application/json');
			echo json_encode((object) $returndata);

		}

	}
	
}
