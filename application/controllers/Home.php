<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$web_meta = web_head_properties(
					array(
						'meta_keyword' 		=> get_option('sitekeywords'),
						'meta_description' 	=> get_option('sitedescription'),
						'meta_robots' 		=> get_option('robots'),
						'meta_ogimage'		=> '',
						'meta_ogtitle'		=> get_option('sitename'),
						'meta_ogtype'		=> '',
						'meta_ogdescription'=> get_option('sitedescription'),
						'meta_ogurl'		=> base_url(),
						'meta_ogsitename'	=> get_option('sitename'),
						'meta_articlesection'=> '',
						'meta_twtimg'		=> '',
						'meta_twttitle'		=> get_option('sitename'),
						'meta_twtdescription'=> get_option('sitedescription'),
						'meta_twtcard'		=> '',
						'meta_twtsite'		=> get_option('sitename'),
						'meta_twtcreator'		=> '',
						'web_canonical'		=> base_url()
					)
				);
		
		$data = array( 
					'title' =>  get_option('sitename'),
					'web_meta' => $web_meta
				);
		$this->load->view( 'main', $data, false);
	}
}
