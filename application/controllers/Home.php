<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$web_meta = web_head_properties(
					
			array(
				'meta_keyword' 		=> get_option('sitekeywords'),
				'meta_description' 	=> get_option('sitedescription'),
				'meta_robots' 		=> get_option('robots'),
				
				// FB Open Graph
				'og' => array(
					'og:title' 		=> get_option('sitename'),
					'og:type' 		=> 'article',
					'og:description' => get_option('sitedescription'),
				),

				// Twitter Cards
				'twitter' => array(
					'twitter:title' 	=> get_option('sitename'),
					'twitter:description' => get_option('sitedescription'),
				),

				// Google+ / Schema.org
				'g+' => array(
					'name' => get_option('sitename'),
					'headline' => get_option('sitename'),
					'description' => get_option('sitedescription'),
				),
			)
		);		
		
		$data = array( 
					'title' =>  get_option('sitename'),
					'web_meta' => $web_meta
				);
		$this->load->view( 'main', $data, false);
	}
}
