<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atur_web extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('atur_web_model');
	}

	public function index(){
		if( is_view() ){

			$data = array( 
						'title' => 'Atur Web - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => '',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(
										),
					);
			
			$this->load->view( admin_root('atur_web_view'), $data );
		}
	}

	public function prosesedit(){
		$error = false;
		if( is_edit() ){

			if( empty($this->input->post('sitename')) ){
				$error = "<strong>Error</strong> Bidang wajib tidak boleh kosong";
			}

			// Validate Email
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$error = "<strong>Error</strong> alamat email tidak valid";
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
						$error = "<strong>ERROR</strong> Ekstensi favicon yang diizinkan hanya ".implode(", ", $fav_ext);
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
							'medium' 	=>'220',
							'large' 	=>'350'
						);
						$upload = uploadImage('logo', 'weblogo', $sizeimg, $extensi_allowed);
						$logoserialize = serialize($upload);

						if(check_option('weblogo')){
							set_option('weblogo', $logoserialize);
						}else{
							add_option('weblogo', $logoserialize);
						}
					} else {
						$error = "<strong>Error</strong> Ekstensi logo tidak diizinkan";
						show_error($error, 503,'Upload logo gagal'); exit;
					}
				}

				// SETTING ADDRESS
				set_option('siteaddress', $this->input->post('siteaddress'));

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
				set_option('emailsignature', filter_txt($this->input->post('emailsignature')));


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

				$this->session->set_flashdata( 'sukses', 'Data berhasil diperbarui' );
			}

			if($error){
				$this->session->set_flashdata( 'gagal', $error );
			}

			redirect( admin_url( $this->uri->segment(2) ) );			
			
		}
	}

}
?>