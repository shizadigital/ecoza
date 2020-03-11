<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paging {
	protected $CI;

	public function __construct(){
        $this->CI =& get_instance();

        $this->CI->load->library('pagination');
	}

	public function PaginationAdmin( $url, $totalrows, $per_page, $options = array() ){
		$url 		= ( empty($url) )?base_url():$url;
		$per_page 	= ( empty($per_page) )? 30: filter_int($per_page);

        $segment = (empty($options['uri_segment'])) ? 3 : $options['uri_segment'];
        
        $getURI = '';
        if (count($this->CI->input->get()) > 0){
            if( !empty($options['page_query_string'])){ unset($options['page_query_string']); }
            if( !empty($options['query_string_segment']) ){ unset($options['query_string_segment']); }

            $querystrsegment = 'page';

            $dataURI = array();
            foreach ($this->CI->input->get() as $key => $value) {
                if( $querystrsegment == $key ){ continue; }
                $dataURI[] = $key.'='.$value;
            }            
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = $querystrsegment;
            $getURI = '/?'.implode('&', $dataURI);
        }

		//konfigurasi pagination
        $config['base_url'] = $url.$getURI; //site url
        $config['total_rows'] = filter_int($totalrows); //total row
        $config['per_page'] = $per_page;  //show record per halaman
        $config["uri_segment"] = $segment;  // uri parameter

        $choice = filter_int($totalrows) / $per_page;
        $config["num_links"] = floor($choice);

        $defaults = array(
            'attributes'       => array('class' => 'page-link'),
        	'first_link'       => '&laquo; First',
            'prev_link'        => '&lsaquo; Prev ',
	        'next_link'        => 'Next &rsaquo;',
            'last_link'        => 'Last &raquo;',
	        'full_tag_open'    => '<nav aria-label="..."><ul class="pagination">',
	        'full_tag_close'   => '</ul></nav>',
	        'num_tag_open'     => '<li class="page-item">',
	        'num_tag_close'    => '</li>',
	        'cur_tag_open'     => '<li class="page-item active"><a class="page-link" href="javascript:void(0)">',
	        'cur_tag_close'    => '<span class="sr-only">(current)</span></a></li>',
	        'next_tag_open'    => '<li class="page-item">',
	        'next_tagl_close'  => '</li>',
	        'prev_tag_open'    => '<li class="page-item">',
	        'prev_tagl_close'  => '</li>',
	        'first_tag_open'   => '<li class="page-item">',
	        'first_tagl_close' => '</li>',
	        'last_tag_open'    => '<li class="page-item">',
	        'last_tagl_close'  => '</li>',
        );

        // Merge options
		$options = array_merge($defaults, $options);

        if( !empty($options['page_query_string'])){ $config['page_query_string'] = $options['page_query_string']; }
        if( !empty($options['query_string_segment']) ){ $config['query_string_segment'] = $options['query_string_segment']; }
 
        // Pagination style set start here
        $config['attributes'] = $options['attributes'];

      	$config['first_link']       = $options['first_link'];
        $config['prev_link']        = $options['prev_link'];
        $config['next_link']        = $options['next_link'];
        $config['last_link']        = $options['last_link'];
        $config['full_tag_open']    = $options['full_tag_open'];
        $config['full_tag_close']   = $options['full_tag_close'];
        $config['num_tag_open']     = $options['num_tag_open'];
        $config['num_tag_close']    = $options['num_tag_close'];
        $config['cur_tag_open']     = $options['cur_tag_open'];
        $config['cur_tag_close']    = $options['cur_tag_close'];
        $config['next_tag_open']    = $options['next_tag_open'];
        $config['next_tagl_close']  = $options['next_tagl_close'];
        $config['prev_tag_open']    = $options['prev_tag_open'];
        $config['prev_tagl_close']  = $options['prev_tagl_close'];
        $config['first_tag_open']   = $options['first_tag_open'];
        $config['first_tagl_close'] = $options['first_tagl_close'];
        $config['last_tag_open']    = $options['last_tag_open'];
        $config['last_tagl_close']  = $options['last_tagl_close'];
 
        $this->CI->pagination->initialize($config);
 
        return $this->CI->pagination->create_links();
	}
}