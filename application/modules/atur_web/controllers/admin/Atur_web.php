<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atur_web extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('atur_web_model');
	}

	public function index(){
		if( is_view() ){
			
			// get tax
			$tax = $this->Env_model->view_where_order('taxId, taxName, taxRate, taxType','tax', "taxDeleted='0' AND taxActive='y'",'taxId','ASC');
			$taxes[''] = t('notax');
			foreach( $tax as $k => $v ){
				$taxes[$v['taxId']] = $v['taxName'] . ( ($v['taxType']=='percentage') ? ' (%)':'');
			}

			$data = array( 
						'title' => t('websetting') . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => '',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'choosetax' => $taxes
					);
			
			$this->load->view( admin_root('atur_web_view'), $data );
		}
	}

	public function prosesedit(){
		$error = false;
		if( is_edit() ){

			if( empty($this->input->post('sitename')) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			// Validate Email
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$error = "<strong>".t('error')."!!</strong> " . t('emailinvalid');
			}

			// check tax
			if($this->input->post('enabletax') == 'y'){
				if( empty( $this->input->post('tax') ) ){
					$error = "<strong>".t('error')."!!</strong> " . t('taxempty');
				}
			}

			// check invoice order format number
			if(strpos($this->input->post('invoiceorderformat'), "{NUMBER}")===false){
				$error = "<strong>".t('error')."</strong> ".t('invoiceformatnumberempty');
			}

			// check invoice order number start
			if(!empty($this->input->post('invoiceordernumberstart'))){
				if(filter_var($this->input->post('invoiceordernumberstart'), FILTER_VALIDATE_INT) === false){
					$error = "<strong>".t('error')."</strong> ".t('invoicestartingwrongdata');
				} else {
					if(get_option('invoiceordernumberstart') >= $this->input->post('invoiceordernumberstart')){
						$error = "<strong>".t('error')."</strong> ".sprintf(t('invoicestartingstillsmaller'),get_option('invoiceordernumberstart'));
					}
				}
			}

			// check payment expired
			if( $this->input->post('paymentexpired') > $this->input->post('removepaymentexpired') ){
				$error = "<strong>".t('error')."</strong> ".t('removepaymentexpiredinfo');
			}

			if(!$error){
				//SETTING HTTPS
				$devmode = ($this->input->post('httpsmode') == 'y') ? "yes":"no";
				if(check_option('httpsmode')){
					set_option('httpsmode', $devmode);
				}else{
					add_option('httpsmode', $devmode);
				} 

				// SETTING FAVICON
				if(!empty($_FILES['favicon']['tmp_name'])){
					$fav_ext = array('jpg','jpeg','png','gif','ico');
					$ext_file = pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION);

					if(in_array($ext_file,$fav_ext)) {
						//Set Favicon site
						if(get_option('favicon')!=''){
							$favicon_data = get_option('favicon');
							$array_fav = unserialize($favicon_data);
							//delete favicon old file
							@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .$array_fav['directory'].DIRECTORY_SEPARATOR.$array_fav['filename']);
						}
						$favUpload = uploadFavicon('favicon',$fav_ext);

						$favserialize = serialize($favUpload);
						set_option('favicon', $favserialize);
					} else {
						$error = "<strong>".t('error')."!!</strong> " .t('faviconuploadfailed') . ' '.implode(", ", $fav_ext);
						show_error($error, 503,'Upload logo gagal'); exit;
				  	}		
					
				}
				
				// SETTING JUDUL WEBSITE
				set_option('sitename', $this->input->post('sitename'));

				// SETTING TAGLINE
				set_option('tagline', $this->input->post('tagline'));

				// SETTING EMAIL WEBSITE
				set_option('siteemail', $this->input->post('email'));

				// SETTING TELP
				set_option('sitephone', $this->input->post('sitephone'));

				// SETTING WEBSITE DESKRIPSI
				set_option('sitedescription', $this->input->post('sitedescription'));

				// SETTING KEYWORD
				set_option('sitekeywords', $this->input->post('sitekeywords'));

				// SETTING LOGO
				if(!empty($_FILES['logo']['tmp_name'])){
					$extensi_allowed = array('jpg','jpeg','png','gif');
					$ext_file = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);

					if(in_array($ext_file,$extensi_allowed)) {
						//Set Favicon site
						if(get_option('weblogo')!=''){
							$logo_data = get_option('weblogo');
							$array_logo = unserialize($logo_data);
							//delete favicon old file
							@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .$array_logo['directory'].DIRECTORY_SEPARATOR.$array_logo['filename']);
						}

						//Insert image file
						$sizeimg = array(
							'xsmall' 	=>'40',
							'small' 	=>'100',
							'medium' 	=>'270',
							'large' 	=>'550'
						);
						$upload = uploadImage('logo', 'weblogo', $sizeimg, $extensi_allowed);
						$logoserialize = serialize($upload);

						if(check_option('weblogo') > 0){
							set_option('weblogo', $logoserialize);
						}else{
							add_option('weblogo', $logoserialize);
						}
					} else {
						$error = "<strong>".t('error')."</strong> ".t('logoextentionfailed');
						show_error($error, 503,t('uploadfailed')); exit;
					}
				}

				// SETTING SITE DEFAULT IMG
				if(!empty($_FILES['sitedefaultimage']['tmp_name'])){
					$extensi_allowed = array('jpg','jpeg','png','gif');
					$ext_file = pathinfo($_FILES['sitedefaultimage']['name'], PATHINFO_EXTENSION);

					if(in_array($ext_file,$extensi_allowed)) {
						//Set Favicon site
						if(get_option('sitedefaultimage')!=''){
							$logo_data = get_option('sitedefaultimage');
							$array_logo = unserialize($logo_data);
							//delete favicon old file
							@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .$array_logo['directory'].DIRECTORY_SEPARATOR.$array_logo['filename']);
						}

						//Insert image file
						$sizeimg = array(
							'xsmall' 	=>'220',
							'small' 	=>'820',
							'standard' 	=>'1200',
							'large' 	=>'1900'
						);
						$upload = uploadImage('sitedefaultimage', 'sitedefaultimage', $sizeimg, $extensi_allowed);
						$logoserialize = serialize($upload);

						if(check_option('sitedefaultimage') > 0){
							set_option('sitedefaultimage', $logoserialize);
						}else{
							add_option('sitedefaultimage', $logoserialize);
						}
					} else {
						$error = "<strong>".t('error')."</strong> ".t('wrongextentionimage');
						show_error($error, 503,t('uploadfailed')); exit;
					}
				}

				// SETTING ADDRESS
				set_option('siteaddress', $this->input->post('siteaddress'));

				// SETTING POSTALCODE
				set_option('postalcode',$this->input->post('postalcode'));

				// SETTING MULTISTORE
				$multistore = (!empty($this->input->post('multistore')) AND $this->input->post('multistore')=='y') ? 'on':'off';
				set_option('multistore',$multistore);

				/*
				*
				* SMTP SETTING
				*
				*/
				// SETTING SMTP USERNAME
				set_option('smtp_username', $this->input->post('smtp_username'));

				// SETTING SMTP PASSWORD
				if( !empty($this->input->post('smtp_password'))){
					set_option('smtp_password', encoder($this->input->post('smtp_password')));
				}

				// SETTING SMTP HOST
				set_option('smtp_host', $this->input->post('smtp_host'));

				// SETTING SMTP PORT
				set_option('smtp_port', $this->input->post('smtp_port'));

				// SETTING SMTP TYPE
				set_option('smtp_ssltype', $this->input->post('smtp_ssltype'));

				// SETTING EMAIL SIGNATURE
				set_option('emailsignature', $this->input->post('emailsignature',true));


				/*
				*
				* SOCIAL MEDIA SETTING
				*
				*/
				$social_url_array = array(
										"facebook"		=> $this->input->post('facebook'),
										"twitter"		=> $this->input->post('twitter'),
										"youtube"		=> $this->input->post('youtube'),
										"instagram"		=> $this->input->post('instagram'),
										"line"			=> $this->input->post('line'),
										"whatsapp"		=> $this->input->post('whatsapp'),
										"googleplay"	=> $this->input->post('googleplay')
									);
				$sosmedurl = serialize($social_url_array);
				set_option('socialmediaurl', $sosmedurl);

				/*
				*
				* ORDER SETTING
				*
				*/

				// SETTING ENABLE TAX
				if(check_option('taxstatus') > 0){
					set_option('taxstatus',$this->input->post('enabletax'));
				} else {
					add_option('taxstatus',$this->input->post('enabletax'));
				}

				// SETTING TAX
				if($this->input->post('enabletax') == 'y'){
					if(check_option('taxId') > 0){
						set_option('taxId',$this->input->post('tax'));
					} else {
						add_option('taxId',$this->input->post('tax'));
					}
				}

				// SETTING INVOICE FORMAT ORDER
				if(check_option('invoiceorderformat') > 0){
					set_option('invoiceorderformat',$this->input->post('invoiceorderformat'));
				} else {
					add_option('invoiceorderformat',$this->input->post('invoiceorderformat'));
				}

				// SETTING INVOICE NUMBER START
				if( !empty($this->input->post('invoiceordernumberstart')) ){
					if(check_option('invoiceordernumberstart') > 0){
						set_option('invoiceordernumberstart',filter_int($this->input->post('invoiceordernumberstart')));
					} else {
						add_option('invoiceordernumberstart',filter_int($this->input->post('invoiceordernumberstart')));
					}
				}

				// SETTING PAYMENT EXPIRED
				if(check_option('paymentexpired') > 0){
					set_option('paymentexpired',$this->input->post('paymentexpired'));
				} else {
					add_option('paymentexpired',$this->input->post('paymentexpired'));
				}

				// SETTING PAYMENT EXPIRED
				if(check_option('removepaymentexpired') > 0){
					set_option('removepaymentexpired',$this->input->post('removepaymentexpired'));
				} else {
					add_option('removepaymentexpired',$this->input->post('removepaymentexpired'));
				}

				// SETTING PAY TO TEXT 
				set_option('invoicepaytotext', $this->input->post('invoicepaytotext',true));

				/**
				 * FINISH HERE
				 */
				$this->session->set_flashdata( 'succeed', t('successfullyupdated') );
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url( $this->uri->segment(2) ) );			
			
		}
	}

}
?>
