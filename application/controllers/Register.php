<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		if( $this->member->is_login() ){ redirect( base_url() ); }

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
        $webtitle = t('register');

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
        $this->load->view( 'register', $dataview);            
	}

	public function actionregistercheckout($onpage = null){

		$error = false; $msg = '';

		$email 		= esc_sql(filter_txt( $this->input->post('email', true) ) );
		$password 	= esc_sql(filter_txt( $this->input->post('password', true) ) );
		$phone 		= filter_txt( $this->input->post('phone', true) );

		if($onpage == null OR $onpage=='y'){

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error = true;
				$msg = t('emailinvalid');
			}

			if( empty($email) ){
				$error = true;
				$msg = t('emptyemail');
			}

			if($password != $this->input->post('repassword')){
				$error = "<strong>".t('error')."</strong> ".t('confirmpasserror');
			}

			if(strlen($this->input->post('password'))<=6){
				$error = "<strong>".t('error')."</strong> ".sprintf(t('passtotalcharerror'),'6');
			}

			// check email address availability
			if( countdata('member', "mEmail='{$email}' AND mDeleted=0") > 0 ){
				$error = true;
				$msg = t('emailavailebleerror');
			}

			if( empty($this->input->post('fullname')) ){
				$error = true;
				$msg = t('emptyname');
			}
			
			if( empty($password) ) {
				$error = true;
				$msg = t('emptypasswordfield');
			}
			
			if(empty($phone)){
				$error = true;
				$msg = t('emptyphone');
			}
			
			if(!empty($phone)){
				if(validatePhoneNumber($phone)==false ){
					$error = true;
					$msg = t('phonenumbererror');
				}
			}

			if(!$error){
				$fullname 		= esc_sql(filter_txt($this->input->post('fullname', true)));
				$email 			= esc_sql(filter_txt($this->input->post('email')));
				$gender			= ( $this->input->post('gender') == 'm' ) ? 'm':'f';
				$nohp 			= str_replace(" ", "", $phone);
				$nohp 			= (substr(trim($nohp), 0, 1)=='+') ? $nohp : '+'.$nohp; 

				// get language
				$lang = !empty(get_cookie('lang')) ? get_cookie('lang', true) : $this->config->item('language');

				// get currency
				$currency = !empty(get_cookie('currency')) ? get_cookie('currency', true) : get_option('defaultcurrency');
				
				// pass hash
				$pass 		= $password;
				$pass 		= sha1( 
								sha1(
									encoder( $pass .'>>>>'. LOGIN_SALT )
								) . "#" . LOGIN_SALT
							);

				$passwordunik = password_hash( 
									$pass,
									PASSWORD_DEFAULT,
									['cost' => 10]
								);
				
				// member code
				$memcode = strtoupper(generate_code(6));

				// email key
				$email_key = generate_code(64);
				
				// get next ID
				$nextID = getNextId('mId','member');
				
				// OTP code
				$otp = generate_code(6, false, 'numbers');				
				
				// timestamp now
				$now = time2timestamp();

				$insvalue = array(
					'mId' => $nextID,
					'mName' => $fullname,
					'mEmail' => $email,
					'mPassword' => $passwordunik,
					'mHP' => (string) $nohp,
					'mGender' => $gender,
					'mDefaultLang' => $lang,
					'mDefaultCurrency' => $currency,
					'mNewsletter' => 0,
					'mBirthday' => null,
					'mCode' => $memcode,
					'mEmailSecureKey' => $email_key,
					'mEmailSecureKeyDate' => $now,
					'mHPSecureKey' => $otp,
					'mHPSecureKeyDate' => $now,
					'mRegDate' => $now,
					'mDir' => '',
					'mPic' => '',
					'mType' => 'member',
					'mStatus' => 1,
					'mLastLogin' => 0,
					'mDeleted' => 0
				);

				$query = $this->Env_model->insert('member', $insvalue);

				// define redirect url
				$url = !empty( $this->input->post('redirect') ) ? $this->input->post('redirect') : base_url();

				if($query){

					// save member store
					$datastore = array(
						'mId' => $nextID,
						'storeId' => $this->session->userdata('visitor_storeid')
					);
					$query = $this->Env_model->insert('member_store', $datastore);

					//==== SEND EMAIL TO MEMBER    
					$to        = $email;
					$subject   = t('welcometo')." ".get_option('sitename');

					$message = '
					<style type="text/css">
					.inv table, tr, td {
						border-collapse : collapse; 
						font-size : 12px; 
						font-family : verdana; 
						border-color: black
					}
	
					html, body{
						background-image: none !important;
					}
					</style>';
								
					//Start variable changer
					$message .= getval('tEmail',"email_template","tId='11'");
					
					$emailvars['VERIFYREG'] = base_url('verify/memberregister/'.$email_key);
			
					$message = variable_parser($message, $emailvars);

					#send mail to owner
					$option = array();
					$option['from'] = get_option('smtp_username');
					$option['fromname'] = get_option('sitename');
					$option['replyto'] = get_option('siteemail');
					$option['cc'] = '';
					$option['bcc'] = '';
					$option['to'] = $to;
					$option['toname'] = $fullname;
					$option['subject'] = $subject;
					$option['message'] = $message;
					$option['messagetype'] = 'html';
					sendMailPHPMailer($option);

					/**
					 * 
					 * proccess to login
					 * 
					 */

					// cookie expiration
					$expiredcook = 86400; // 1 day

					// get current domain
					$domain = getDomain( current_url() );

					$cookie_set = array(
						array(
							'name'   => 'member',
							'value'  => $nextID,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'lang',
							'value'  => $lang,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'memberemail',
							'value'  => $email,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'currency',
							'value'  => $currency,
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
							'value'  => 'y',
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						),
						array(
							'name'   => 'lastlog',
							'value'  => $now,
							'expire' => $expiredcook,
							'path ' => '/',
							'domain' => '.'.$domain
						)
					);
					foreach($cookie_set as $cook_val){
						set_cookie($cook_val);
					}

					// update member login
					$updt = array(
								'mLastLogin' => $now
							);
					$this->memberauth_model->update_login($nextID, $updt);

					// if member has cart data, insert into database
					if( $this->shopping_cart->hasCart() ){
						
						// get cart first
						$datacart = $this->shopping_cart->dataCart();

						// reset cart data with member ID
						$this->shopping_cart->setCart($datacart, $nextID);

						// unset cart session in guest
						$itemcart = array(
							'SPC_D',
							'cart_timeout'
						);
						$this->session->unset_userdata($itemcart);
					}
										
					if($onpage=='y'){
						$status = 200;
						$response = array(
							'msg' => t('registersuccessfully'),
							'url' => $url
						);
					} else {
						redirect($url);
					}
				} else {
					if($onpage=='y'){
						$status = 503;
						$response = array(
							'msg' => t('registerfailed'),
						);
					} else {
						$error = true;
						$msg = t('registerfailed');
					}
				}

			}

		} else {
			$error = true;
			$msg = t('cannotprocessdata');
		}

		if($error){

			if($onpage=='y'){

				$status = 503;
				$response = array(
					'msg' => $msg,
				);

			} else {

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
