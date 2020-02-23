<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class multilangLoader {

    protected $ci;

    public function __construct(){
		// load environment of CI
        $this->ci =& get_instance();

        // load helper
		$this->ci->load->helper('cookie');
    }

	public function langInitialize(){
        $ci = $this->ci;

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

            $langdata = $default;

            // get segment 1
            $segment_1 = $ci->uri->segment(1);            

            if( strlen($segment_1) == 2 ){

                $defaulcode = explode('_',$default)[0];

                // check current lang, if same with default lang redirect to default uri
                if( $segment_1 == $defaulcode ){

                    // force slash to the last base_url()
                    $baseurislash = ( substr(base_url(), -1) == '/' ) ? base_url():base_url() .'/';

                    // remove url lang code with base url and redirect
                    $uriredirect = str_replace( $baseurislash.$segment_1, $baseurl_lang, current_url() );

                    redirect($uriredirect);
                } else {

                    //check language availability with segment
                    if( count( langlist() ) > 0 ){
                        
                        $selected = '';
                        foreach( langlist() AS $val){

                            if( preg_match('/'.$segment_1.'_/', $val) ){
                                $selected = $val;
                                break;
                            }

                        }

                        if( !empty($selected) ){

                            $ci->lang->load('frontpage', $selected);

                            $langdata = $selected;

                        } else {

                            $ci->lang->load('frontpage', $default);

                        }
                    } else {

                        $ci->lang->load('frontpage', $default);

                    }
                }

            } else {
                
                $ci->lang->load('frontpage', $default);

            }

            // set cookie for language front page
            if( empty(get_cookie('lang')) ){
                // set lang cookies
                $lang_cook = array(
                    'name'   => 'lang',
                    'value'  => $langdata,
                    'expire' => 0,
                    'path ' => '/'
                );
                $ci->input->set_cookie($lang_cook);
            } else {

                if( $langdata != get_cookie('lang')){
                    $lang_cook = array(
                        'name'   => 'lang',
                        'value'  => $langdata,
                        'expire' => 0,
                        'path ' => '/'
                    );
                    $ci->input->set_cookie($lang_cook);
                }

            }

        }

	}
}
