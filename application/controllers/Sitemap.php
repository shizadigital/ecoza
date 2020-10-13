<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

	}
	
	public function index(){		
		header('Content-Type: text/xml; charset=utf-8');

		$string='<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$string .='
		<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
			<sitemap>
				<loc>'.base_url('sitemap/post').'</loc>
			</sitemap>
			<sitemap>
				<loc>'.base_url('sitemap/page').'</loc>
			</sitemap>
			<sitemap>
				<loc>'.base_url('sitemap/post_category').'</loc>
			</sitemap>
		</sitemapindex>
		';

		echo $string;
	}

	public function post(){
		header('Content-Type: text/xml; charset=utf-8');

		$string='<?xml version="1.0" encoding="UTF-8"?>'."\n";

		$string .= '
			<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
				xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

		$datacontent = $this->Env_model->view_where_order_limit('contentId,contentTitle,contentPost,contentTimestamp,contentDate,contentHour,contentImg,contentDirImg,contentCaptionImg,contentSlug','contents', array('contentType'=>'post', 'contentStatus'=>1),'contentId','DESC','50000');

		foreach ($datacontent as $r){
			$URL = $this->permalink->get('post',$r['contentId']);
			$string .='
					<url>
						<loc>'.$URL.'</loc>
						<lastmod>'.date('c',$r['contentTimestamp']).'</lastmod>
						<changefreq>daily</changefreq>
						<priority>0.8</priority>';

						if($r['contentImg']!=null AND $r['contentDirImg']!=null){
							$string .='
							<image:image>
								<image:loc>'.images_url($r['contentDirImg'].'/medium_'.$r['contentImg']).'</image:loc>
								<image:caption>';
								if(!empty($r['contentCaptionImg'])){
									$string .= '<![CDATA['.filter_txt($r['contentCaptionImg']).']]>';
								}
								$string .= '</image:caption>
								<image:title>'.filter_txt($r['contentTitle']).'</image:title>
							</image:image>';
						}

			$string .='		
					</url>
			';
		}
		
		$string .= '
				</urlset>';
		echo $string;
	}

	public function page(){
		header('Content-Type: text/xml; charset=utf-8');

		$string='<?xml version="1.0" encoding="UTF-8"?>'."\n";

		$string .= '
			<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
				xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

		$datacontent = $this->Env_model->view_where_order_limit('contentId,contentTitle,contentPost,contentTimestamp,contentDate,contentHour,contentImg,contentDirImg,contentCaptionImg,contentSlug','contents', array('contentType'=>'page', 'contentStatus'=>1),'contentId','DESC','50000');

		foreach ($datacontent as $r){
			$URL = $this->permalink->get('page',$r['contentId']);
			$string .='
					<url>
						<loc>'.$URL.'</loc>
						<lastmod>'.date('c',$r['contentTimestamp']).'</lastmod>
						<changefreq>daily</changefreq>
						<priority>0.8</priority>';

						if($r['contentImg']!=null AND $r['contentDirImg']!=null){
							$string .='
							<image:image>
								<image:loc>'.images_url($r['contentDirImg'].'/medium_'.$r['contentImg']).'</image:loc>
								<image:caption>';
								if(!empty($r['contentCaptionImg'])){
									$string .= '<![CDATA['.filter_txt($r['contentCaptionImg']).']]>';
								}
								$string .= '</image:caption>
								<image:title>'.filter_txt($r['contentTitle']).'</image:title>
							</image:image>';
						}

			$string .='		
					</url>
			';
		}
		
		$string .= '
				</urlset>';
		echo $string;
	}

	public function post_category(){
		header('Content-Type: text/xml; charset=utf-8');

		$string='<?xml version="1.0" encoding="UTF-8"?>'."\n";

		$string .= '
				<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
					xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

		$datacateg = $this->Env_model->view_where_order_limit('catId,catName,catSlug','categories', array('catType'=>'post', 'catActive'=>1),'catId','DESC','50000');

		foreach ($datacateg as $r){
			$URL = $this->permalink->get('post-category',$r['catId']);
			$string .='
				<url>
					<loc>'.$URL.'</loc>
					<changefreq>monthly</changefreq>
					<priority>0.3</priority>
				</url>
			';
		}

		$string .= '
				</urlset>';
		echo $string;

	}

}
