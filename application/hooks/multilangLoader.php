<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class multilangLoader {

	public function langInitialize(){
		// load environment of CI
        $ci =& get_instance();

        // load helper
        $ci->load->helper('language');
		$ci->load->helper('cookie');

        // get default lang
        $default = $ci->config->item('language');
        
        if( $ci->config->item('admin_slug') == $ci->uri->segment(1) ){
            
            if( empty( $ci->session->userdata('namauser') ) AND empty( $ci->session->userdata('passuser') ) ){

                if( empty(get_cookie('admin_lang')) ){
                    $ci->lang->load('admin', $default);
                } else {
                    $ci->lang->load('admin', get_cookie('admin_lang'));
                }

            } else {

                $ci->lang->load('admin', get_cookie('admin_lang'));

            }

        } else {

            if( empty(get_cookie('lang')) ){
                $ci->lang->load('frontpage', $default);
            } else {
                $ci->lang->load('frontpage', get_cookie('lang'));
            }

        }

	}
}
