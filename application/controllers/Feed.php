<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

	}
	
	public function index(){		
		header('Content-Type: text/xml; charset=utf-8');

		$string='<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$string.='<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'."\n";
		$string.='<channel>'."\n";
		$string.='<atom:link href="'.base_url('feed').'" rel="self" type="application/rss+xml" />'."\n";

		$string_ ='<language>'.str_replace('_', '-', t('locale') ).'</language>'."\n";
		$string_.='<pubDate>'.date('D').', '.date('d M Y H:i:s').' '.date('O').'</pubDate>'."\n";
		$string_.='<lastBuildDate>'.date('D').', '.date('d M Y H:i:s').' '.date('O').'</lastBuildDate>'."\n";
		$string_.='<copyright>'.date('Y').' Copyright. '.web_info().'. All rights reserved.</copyright>'."\n";

		///////////////////////// START HEADER RSS HERE /////////////////////////
		/////////////////////////////////////////////////////////////////////////
		$string.='<title>'.web_info().'</title>'."\n";
		$string.='<link>'.base_url().'</link>'."\n";
		$string.='<description>'.get_option('sitedescription').'</description>'."\n";
		$string.= $string_;
		/////////////////////////////////////////////////////////////////////////
		////////////////////////// END HEADER RSS HERE //////////////////////////

		$datacontent = $this->Env_model->view_where_order_limit('contentId,contentTitle,contentPost,contentTimestamp,contentDate,contentHour,contentImg,contentDirImg,contentSlug','contents', array('contentType'=>'post', 'contentStatus'=>1),'contentTimestamp','DESC','200');

		foreach ($datacontent as $r){
			//$isi   = the_excerpt($r['kontenPost'],450,'');
			$isi = the_excerpt($r['contentPost'], 450,'');

			//Untuk RSS
			$DAY = date('D', $r['contentTimestamp']);
			$M =  date('M', $r['contentTimestamp']);
			$exp_m = explode("-",$r['contentDate']);


			$kategori = $this->meta->post_categories($r['contentId']);
			if(count($kategori['id'])>0){
				foreach ($kategori['id'] as $keykat => $valuekat) {
					$rsskat = "<category><![CDATA[{$kategori['name'][$keykat]}]]></category>";
				}
			} else {
				$rsskat = "<category><![CDATA[Uncategorized]]></category>";
			}

			if($r['contentImg']!=null AND $r['contentDirImg']!=null){
				$img = "<img src=\"".images_url($r['contentDirImg'].'/medium_'.$r['contentImg'])."\" border=\"0\" hspace=\"5\" align=\"left\" width=\"120\" />";
			} else { $img = ''; }

			$URL = $this->permalink->get('post',$r['contentId']);

			$string.="\n";
			$string.='<item>'."\n";
			$string.='<title><![CDATA['.strip_tags($r['contentTitle']).']]></title>'."\n";
			$string.='<pubDate>'.$DAY .', '.$exp_m[2]." " .$M." ".$exp_m[0]." ". $r['contentHour'] .' '.date('O', $r['contentTimestamp']).'</pubDate>'."\n";
			$string.='<link>'.$URL.'</link>'."\n";
			$string.= $rsskat."\n";
			$string.='<description><![CDATA['.$img.' '. $isi .' ...]]></description>'."\n";
			$string.='<guid>'.$URL.'</guid>'."\n";
			$string.='</item>'."\n";
		}


		$string.="\n";
		$string.='</channel>'."\n";
		$string.='</rss>'."\n";

		echo $string;
	}

}
