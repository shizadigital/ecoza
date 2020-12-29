<?php 
/**************** CHECKMIGRATION ********************/
function isNotMigration() {
    $ci =& get_instance();
    $segment = trim( strtolower( $ci->uri->segment(1) ) );
    if( $segment != 'migration') return true;
    else return false;
}

/**************** MULTILANG OPTION ********************/
/**
 *
 * get locales name
 *
 * @param string $locales
 * @param bool $country
 * 
 * @return string
 */
function locales($locales=null, $country=FALSE){
    $ci =& get_instance();

    if( $locales == null ){ $locales = $ci->config->item('language'); }

    $locale = $ci->config->load('locales')[$locales];
    
    if( $country === TRUE ) { $result = $locale; }
    else { $result = preg_replace('# \((.*?)\)#', '', $locale); }
    
    return $result;
}

/**
 *
 * get language directory code
 *
 * @return array 
 */
function langlist(){
    $ci =& get_instance();

    // get language directory
    $filedir = scandir(APPPATH . 'language');

    $result = array();

    if( is_dir(APPPATH . 'language') ){
        
        foreach ($filedir as $key => $thefile) {
            if ($thefile != "." && $thefile != ".." && $thefile != 'index.html'){
                $filename = pathinfo($thefile, PATHINFO_FILENAME );

                // check lang array availability here
                if( !array_key_exists( $filename, $ci->config->load('locales') ) ){
                    continue;
                    //show_error('Terdapat nama direktori bahasa yang tidak valid', 503, 'Bahasa tidak valid'); exit;
                }

                $result[]  = $filename;
            }
        }        

    }
    
    return $result;
}

/**
 *
 * Check if this site is multilanguage
 *
 * @return bool 
 */
function is_multilang(){

    $result = FALSE;
    if( count( langlist() ) > 1 ) $result = TRUE;

    return $result;
}

/**
 *
 * Fetching a line of text in multilanguage
 *
 * @param string|array
 * @param bool
 * 
 * @return string
 */
function t($line, $log_errors=FALSE){
    $ci =& get_instance();
    $result = '';

    if( is_array( $line ) ){
        $db_table   = $line['table'];
        $db_field   = $line['field'];
        $relid      = $line['id'];

        $ci->load->helper('cookie');        

        if( is_multilang() AND (get_cookie('admin_lang')!==null OR get_cookie('lang')!==null ) ){
            $lang = '';
            if( strpos(current_url(), $ci->config->item('admin_slug') ) ){
                $lang = empty(get_cookie('admin_lang')) ? t('locale'):get_cookie('admin_lang');
            } else {
                $lang = empty(get_cookie('lang')) ? t('locale'):get_cookie('lang');
            }

            $sqlclause = "dtRelatedField='{$db_field}' AND dtRelatedTable='{$db_table}' AND dtRelatedId='{$relid}' AND dtLang='{$lang}'";
            $countdata = countdata("dynamic_translations",$sqlclause);

            if($countdata > 0){
                $data = getval("dtLang,dtTranslation,dtInputType","dynamic_translations",$sqlclause);
                $result = $data['dtTranslation'];
            } else {
                // get ID field on table
                $querymysql = $ci->db->query("SHOW KEYS FROM ".$ci->db->dbprefix($db_table)." WHERE Key_name = 'PRIMARY'");
                $theDB = $querymysql->result_array()[0];
                
                $data = getval($db_field, $db_table, "{$theDB['Column_name']}='{$relid}'");
                $result = $data;
            }
            
        } else {
            // get ID field on table
            $querymysql = $ci->db->query("SHOW KEYS FROM ".$ci->db->dbprefix($db_table)." WHERE Key_name = 'PRIMARY'");
            $theDB = $querymysql->result_array()[0];

            $data = getval($db_field, $db_table, "{$theDB['Column_name']}='{$relid}'");
            $result = $data;
        }

    } else {
        $result = $ci->lang->line($line, $log_errors);
    }
        
    return $result;
}

/**
 * STORE DATA
 */

function storeId(){
    $ci =& get_instance();

    if( empty($ci->session->userdata('storeid')) ){
        $storeId = getval('storeId', 'store', "storeDefault='y'");
    } else {
        $storeId = esc_sql( filter_int( $ci->security->xss_clean( $ci->session->userdata('storeid') ) ) );
    }

    return $storeId;
}

/**************** Encription ********************/
function encoder($str){
    $iv = substr(hash('sha256', AUTH_SALT), 0, 16); 
    $encrypted = openssl_encrypt($str, 'aes-128-cbc', AUTH_SALT, 0, $iv);

    $encrypted = base64_encode($encrypted);
    return urlencode(trim($encrypted));
}

function decoder($str){
    if(preg_match('/%/', $str)){
        $str = urldecode(trim($str));
    }
    $str = base64_decode($str);

    $iv = substr(hash('sha256', AUTH_SALT), 0, 16);
    $decrypted = openssl_decrypt($str, 'aes-128-cbc', AUTH_SALT, 0, $iv);

    return trim($decrypted);
}

/**************** Options from DB ********************/
function get_option($optname){
    $ci =& get_instance();
    if(isNotMigration()) {
        $getVariablType = gettype($optname);
        $idstore = storeId();
        if($getVariablType === 'array') {
            $ci->db->select('optionName, optionValue');
            $ci->db->from( $ci->db->dbprefix('options') );
            $ci->db->where('storeId', $idstore);
            $ci->db->where_in('optionName', $optname);
            $query = $ci->db->get();
            $getOptions = $query->result();

            $options = [];
            foreach($getOptions AS $optionItem) {
                $optionName = $optionItem->optionName;
                $optionValue = $optionItem->optionValue;
                
                $isSerialize = @unserialize($optionValue);
                if($isSerialize) $options[$optionName] = unserialize($optionValue);
                else $options[$optionName] = $optionValue;
            }

            return $options;
        } else {
            if( check_option($optname) > 0){
                $ci->db->select('optionValue');
                $ci->db->from( $ci->db->dbprefix('options') );
                $ci->db->where('storeId', $idstore);
                $ci->db->where('optionName', $optname);
                $query = $ci->db->get();
                return $query->row()->optionValue;
            } else {
                return null;
            }
        }
    }
}

function check_option($optname){
    $ci =& get_instance();

    $storeId = storeId();

    $ci->db->select('count(*) AS total');
    $ci->db->from( $ci->db->dbprefix('options') );
    $ci->db->where("optionName='{$optname}' AND storeId='{$storeId}'");
    $query = $ci->db->get();
    return $query->row()->total;
}

function set_option($option, $value = ''){
    $ci =& get_instance();

    $idstore = storeId();

    $ci->db->set('optionValue', $value);
    $ci->db->where('storeId', $idstore);
    $ci->db->where('optionName', $option);
    return $ci->db->update( $ci->db->dbprefix('options') );
}

function add_option($option, $value = ''){
    $ci =& get_instance();
    $data = array(
            'optionName' => $option,
            'optionValue' => $value,
            'storeId' => storeId()
    );

    return $ci->db->insert( $ci->db->dbprefix('options'), $data); 
}

function delete_option($option){
    $ci =& get_instance();

    $data = array('optionName' => $option, 'storeId' => storeId());

    return $ci->db->delete( $ci->db->dbprefix('options'), $data); 
}

function loginCP(){
    $ci =& get_instance();
    $ci->load->helper('cookie');
    $create_cp_code = "[[[". AUTH_SALT."]]]>>2ad68f5saa>>".base_url();
    return sha1($create_cp_code).'||'.get_cookie('sz_token');
}

function sz_token(){
    if( empty( get_cookie('sz_token') ) ){
        // create new token code
        $createcode = generate_code(32);
        return $createcode;
    } else {
        return get_cookie('sz_token');
    }
}

/**************** Social media ********************/
function get_social_url($social=''){
    $social_url_opt = get_option('socialmediaurl');

    $array_social_url = unserialize($social_url_opt);

    if(empty($social_url_opt)){
        $social_url = false;
    } else {
        $social_url = ( empty($array_social_url[$social]) ) ? '' : $array_social_url[$social];
    }
    return $social_url;
}

/**
 * 
 * 
 * Templating location 
 *
 *  
 */
/**************** Web Options ********************/
function base_assets($rootassets = null){
    $assets = base_url('assets');
    if(!empty($rootassets)){ $assets = $assets.'/'.$rootassets; }
    return $assets;
}

function vendor_assets_url($rootvendors = null){
    $assets = base_assets('vendors');
    if(!empty($rootvendors)){ $assets = $assets.'/'.$rootvendors; }
    return $assets;
}

function template_url(){
    $result = base_url('sz_templates');
    return $result;
}

function template_current_url($themeroot = null){
    $mainurl = template_url() . '/' . get_option('template');
    if(!empty($themeroot)){ $mainurl = $mainurl.'/'.$themeroot; }
    return $mainurl;
}

function template_path( $themeroot = null ){
    $mainroot = FCPATH . 'sz_templates' . DIRECTORY_SEPARATOR . get_option('template');
    if(!empty($themeroot)){ $mainroot = $mainroot.'/'.$themeroot; }
    return $mainroot;
}

function template_view_path( $themeroot = null ){
    $mainroot = template_path( DIRECTORY_SEPARATOR .'views' );
    if(!empty($themeroot)){ $mainroot = $mainroot.'/'.$themeroot; }
    return $mainroot;
}

/* template structure */
function html_lang(){
    return explode("_",  t('locale') )[0];
}

function get_header($name = null){
	$name = (string) $name;
	if ( '' !== $name ) {
		$templates = "header-{$name}.php";
	} else {
		$templates = 'header.php';
    }
    
    return template_view_path( $templates );
}

function get_footer($name = null){
	$name = (string) $name;
	if ( '' !== $name ){
		$templates = "footer-{$name}.php";
	} else {
		$templates = 'footer.php';
	}
    
    return template_view_path( $templates );
}

function get_sidebar($name = null, $require_once = true){
	$name = (string) $name;
	if ( '' !== $name ){
		$templates = "sidebar-{$name}.php";
	} else {
		$templates = 'sidebar.php';
	}
    
    return template_view_path( $templates );
}

/*************** Admin Options ********************/
function admin_root($themeroot = null){
    $adminroot = 'admin';
    if(!empty($themeroot)){ $adminroot = $adminroot.'/'.$themeroot; }
    return $adminroot;
}

function admin_assets($rootassets = null){
    $adm_assets = base_assets('admin');
    if(!empty($rootassets)){ $adm_assets = $adm_assets.'/'.$rootassets; }
    return $adm_assets;
}

function admin_url($rootaccess = null){
    $ci =& get_instance();
    
    $adm_url = base_url() . $ci->config->item('admin_slug');
    if(!empty($rootaccess)){ $adm_url = $adm_url.'/'.$rootaccess; }
    return $adm_url;
}

function is_admin(){
    $ci =& get_instance();

    $result = false;
    if($ci->config->item('admin_slug') == $ci->uri->segment(1)){
        $result = true;
    }

    return $result;
    
}

/**************** Files dir URL ********************/
function files_url($dir_uri = '') {    
    $files_url = base_url("storage/files/".$dir_uri);
        return $files_url;
}

function images_url($dir_uri = '') {
    $images_url = base_url("storage/images/".$dir_uri);
        return $images_url;
}

/**************** web information ********************/
function web_info($info = '') {
    switch( $info ) {
        case 'home' :
        case 'url' :
            $output = base_url();
            break;
        case 'deskripsi':
            $output = get_option('sitedescription');
            break;
        case 'tagline':
            $output = get_option('tagline');
            break;
        case 'phpsupport':
            $output = get_option('phpsupport');
            break;
        case 'keyword':
            $output = get_option('sitekeywords');
            break;
        case 'robots':
            $output = get_option('robots');
            break;
        case 'rss':
            $output = base_url()."/rss.xml";
            break;
        case 'version':
            $output = SHIZA_VERSION;
            break;
        case 'name':
        default:
            $output = get_option('sitename');
            break;
    }
    return $output;
}

function siteDefaultImage(){

	$url = null;
    if(check_option('sitedefaultimage') > 0){
        $img_data = get_option('sitedefaultimage');

        $img = '';
        $dir = '';
        if(!empty($img_data)){

            $array_img = unserialize($img_data);

            $img = $array_img['filename'];
            $dir = $array_img['directory'];

        }
        
        $image = "standard_".$img;

        $url = images_url($dir."/".$image);
    }

    return $url;
}

/**************** Head web ********************/
function web_head_properties($opt = array()){

    $view = "<meta name=\"keywords\" content=\"".(empty($opt['meta_keyword'])? get_option('sitekeywords') :$opt['meta_keyword'])."\" />\n";
    $view .= "<meta name=\"description\" content=\"".(empty($opt['meta_description'])? get_option('sitedescription'):$opt['meta_description'])."\" />\n";
    $view .= "<meta name=\"robots\" content=\"".(empty($opt['meta_robots'])?get_option('robots'):$opt['meta_robots'])."\"/>\n"; 

    /**
     * Set FB Open Graph
     */
    if (!array_key_exists('og:locale', $opt['og']) OR empty($opt['og']['og:locale']) ) {
        $view .= "<meta property=\"og:locale\" content=\"".t('locale')."\"/>\n";
    }

    if (!array_key_exists('og:url', $opt['og']) OR empty($opt['og']['og:url']) ) {
        $view .= "<meta property=\"og:url\" content=\"".this_url()."\"/>\n";
    }

    if (!array_key_exists('og:site_name', $opt['og']) OR empty($opt['og']['og:site_name']) ) {
        $view .= "<meta property=\"og:site_name\" content=\"".web_info()."\"/>\n";
    }

    if ( (!array_key_exists('og:image', $opt['og']) OR empty($opt['og']['og:image']) ) AND check_option('sitedefaultimage')>0 ) {
        $view .= "<meta property=\"og:image\" content=\"".siteDefaultImage()."\"/>\n";
    }

    if ( (!array_key_exists('og:image:url', $opt['og']) OR empty($opt['og']['og:image:url'])) AND check_option('sitedefaultimage')>0 ) {
        $view .= "<meta property=\"og:image:url\" content=\"".siteDefaultImage()."\"/>\n";
    }

    foreach($opt['og'] as $og_key => $og_val ){
        $view .= empty($og_val)?"":"<meta property=\"".$og_key."\" content=\"".$og_val."\"/>\n";
    }

    /**
     * Set Twitter Card
     */
    if(!array_key_exists('twitter:site', $opt['twitter']) OR empty($opt['twitter']['twitter:site'])){
        if(!empty(get_social_url('twitter'))){
            preg_match("/^https?:\/\/(www\.)?twitter\.com\/(#!\/)?(?<username>[^\/]+)(\/\w+)*$/", get_social_url('twitter'), $twmatches);

            $view .= "<meta name=\"twitter:site\" content=\"@".$twmatches['username']."\"/>\n";
        }
    } else {
        $view .= "<meta name=\"twitter:site\" content=\"".$opt['twitter']['twitter:site']."\"/>\n";
    }

    if (!array_key_exists('twitter:title', $opt['twitter']) OR empty($opt['twitter']['twitter:title']) ) {
        $view .= "<meta name=\"twitter:title\" content=\"".get_option('sitename')."\"/>\n";
    }

    if (!array_key_exists('twitter:description', $opt['twitter']) OR empty($opt['twitter']['twitter:description']) ) {
        $view .= "<meta name=\"twitter:description\" content=\"".get_option('sitedescription')."\"/>\n";
    }

    if (!array_key_exists('twitter:url', $opt['twitter']) OR empty($opt['twitter']['twitter:url']) ) {
        $view .= "<meta name=\"twitter:url\" content=\"".this_url()."\"/>\n";
    }

    if (( !array_key_exists('twitter:image:src', $opt['twitter']) OR empty($opt['twitter']['twitter:image:src'])) AND check_option('sitedefaultimage')>0 ) {
        $view .= "<meta name=\"twitter:image:src\" content=\"".siteDefaultImage()."\"/>\n";
    }

    if ((!array_key_exists('twitter:image', $opt['twitter']) OR empty($opt['twitter']['twitter:image'])) AND check_option('sitedefaultimage')>0 ) {
        $view .= "<meta name=\"twitter:image\" content=\"".siteDefaultImage()."\"/>\n";
    }

    if (!array_key_exists('twitter:card', $opt['twitter']) OR empty($opt['twitter']['twitter:card']) ) {
        $view .= "<meta name=\"twitter:card\" content=\"summary\"/>\n";
    }

    foreach($opt['twitter'] as $twitter_key => $twitter_val ){      
        $view .= empty($twitter_val)?"":"<meta name=\"".$twitter_key."\" content=\"".$twitter_val."\"/>\n";
    }


    /**
     * Set G+ Properties
     */
    if (!array_key_exists('name', $opt['g+']) OR empty($opt['g+']['name']) ) {
        $view .= "<meta itemprop=\"name\" content=\"".get_option('sitename')."\"/>\n";
    }

    if (!array_key_exists('headline', $opt['g+']) OR empty($opt['g+']['headline']) ) {
        $view .= "<meta itemprop=\"headline\" content=\"".get_option('sitename')."\"/>\n";
    }

    if (!array_key_exists('description', $opt['g+']) OR empty($opt['g+']['description']) ) {
        $view .= "<meta itemprop=\"description\" content=\"".get_option('sitedescription')."\"/>\n";
    }

    if ((!array_key_exists('image', $opt['g+']) OR empty($opt['g+']['image'])) AND check_option('sitedefaultimage')>0 ) {
        $view .= "<meta itemprop=\"image\" content=\"".siteDefaultImage()."\"/>\n";
    }

    foreach($opt['g+'] as $gplus_key => $gplus__val ){
        $view .= empty($gplus__val)?"":"<meta itemprop=\"".$gplus_key."\" content=\"".$gplus__val."\"/>\n";
    }

    $view .= "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"".web_info('nama')." &raquo; News Feed\" href=\"".base_url('feed')."\" />\n";

    if(!empty($opt['web_canonical'])){
        $view .= "<link rel=\"canonical\" href=\"".$opt['web_canonical']."\" />\n";
    } else {
        $view .= "<link rel=\"canonical\" href=\"".this_url()."\" />\n";
    }

    return $view;
}

function favicon_img_url(){
    $favicon_data = get_option('favicon');
    
    if($favicon_data!=''){
        $array_fav = unserialize($favicon_data);
        $url = images_url()."/".$array_fav['directory']."/".$array_fav['filename'];
    } else {
        $url = base_url()."favicon.ico";
    }

    return $url;
}

function the_favicon($display = true){
    // Tampilkan
    if ( $display ){        
        echo "\n".'<link rel="icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n";
        echo '<link rel="icon" href="'.favicon_img_url().'" type="image/ico">'."\n";
        echo '<link rel="shortcut icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n";
        echo '<link rel="shortcut icon" href="'.favicon_img_url().'">'."\n";
    }
    else {      
        return "\n".'<link rel="icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n".
        '<link rel="icon" href="'.favicon_img_url().'" type="image/ico">'."\n".
        '<link rel="shortcut icon" href="'.favicon_img_url().'" type="image/x-icon">'."\n".
        '<link rel="shortcut icon" href="'.favicon_img_url().'">'."\n";
    }
}

function logo_url($_size=NULL){

    $url = base_url("logo.png");

    if(check_option('weblogo') > 0){
        $logo_data = get_option('weblogo');

        $array_logo = unserialize($logo_data);
        
        $image = "medium_".$array_logo['filename'];
        if($_size != NULL){
            $image = $_size."_".$array_logo['filename'];
        }

        $url = images_url($array_logo['directory']."/".$image);
    }

    return $url;
}

function modalDelete($idModal = null, $content ='', $urldestination = ''){
    $ci =& get_instance();
    $ci->load->library('assetsloc');

    if( !empty($idModal) AND !empty($content) AND !empty($urldestination) ){
        
        $data = '<!-- Modal -->
        <div class="modal fade" id="'.$idModal.'" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:400px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">'.t('delete').'</h5>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.t('close').'</span></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>'. t('deleteconfirm').'</p>
                        '.$content.'
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">'.t('cancel').'</button>
                        <a class="btn btn-danger btn-sm" href="'.$urldestination.'"><i class="icon_trash_alt"></i> '.t('delete').'</a>
                    </div>
                </div><!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- End Modal -->';

        $ci->assetsloc->place_element_to_footer($data);

    } else {
        return false;
    }
}

function is_csrf(){
    $ci =& get_instance();
    $result = false;
    if($ci->config->item('csrf_protection')){
        $result = true;
    } 
    return $result;
}

function setSeoContent($method = null, $typepage = null, $id = null, $title = null, $desc = null, $keyword = null, $noindex = null, $nofollow = null){
    $ci =& get_instance();
    $result = false;
        
    $id = esc_sql(filter_int($id));
    $typepage = esc_sql(filter_txt($typepage));
    $title = esc_sql(filter_txt($title));
    $seodeskripsi = esc_sql(filter_txt($desc));
    $keyword = esc_sql(filter_txt($keyword));

    if($method=='insert'){

        if(!empty($title) OR !empty($seodeskripsi) OR !empty($keyword) OR !empty($noindex) OR !empty($nofollow)){
            if(!empty($typepage) AND !empty($id)){

                if(!empty($noindex) AND !empty($nofollow)){
                    $SEO_robots = $noindex.",".$nofollow;
                } elseif(empty($noindex) AND !empty($nofollow)){
                    $SEO_robots = $nofollow;
                } elseif(!empty($noindex) AND empty($nofollow)){
                    $SEO_robots = $noindex;
                } else {
                    $SEO_robots = '';
                }
            
                $nextIDSeo = getNextId('seoId','seo_page');
            
                //Insert Badge In Group
                $insvalueseo = array(
                    'seoId'    	=> $nextIDSeo,
                    'relatiedId'=> $id,
                    'seoTypePage'=> $typepage,
                    'seoTitle'	=> (string) $title,
                    'seoDesc'	=> (string) $seodeskripsi,
                    'seoKeyword'=> (string) $keyword,
                    'seoRobots'	=> (string) $SEO_robots
                );
            
                $query = $ci->db->insert( $ci->db->dbprefix('seo_page'), $insvalueseo);

                if($query){
                    $result = true;
                }

            }
        }

    } elseif($method=='update'){
        //update SEO
        if(!empty($title) OR !empty($seodeskripsi) OR !empty($keyword) OR !empty($noindex) OR !empty($nofollow)){
                        
            if(!empty($noindex) AND !empty($nofollow)){
                $SEO_robots = $noindex.",".$nofollow;
            } elseif(empty($noindex) AND !empty($nofollow)){
                $SEO_robots = $nofollow;
            } elseif(!empty($noindex) AND empty($nofollow)){
                $SEO_robots = $noindex;
            } else {
                $SEO_robots = '';
            }

            $numseo = countdata('seo_page',array('relatiedId'=> $id,'seoTypePage'=> $typepage));

            if($numseo>0){
                //Insert Badge In Group
                $upvalueseo = array(
                    'relatiedId'=> $id,
                    'seoTypePage'=> $typepage,
                    'seoTitle'	=> (string) $title,
                    'seoDesc'	=> (string) $seodeskripsi,
                    'seoKeyword'=> (string) $keyword,
                    'seoRobots'	=> (string) $SEO_robots
                );

                $ci->db->where( array('relatiedId'=> $id, 'seoTypePage'=> $typepage) );
                $query = $ci->db->update( $ci->db->dbprefix('seo_page'), $upvalueseo );

                if($query){
                    $result = true;
                }
            } else {        
                $nextIDSeo = getNextId('seoId','seo_page');

                //Insert new seo
                $insvalueseo = array(
                    'seoId'    	=> $nextIDSeo,
                    'relatiedId'=> $id,
                    'seoTypePage'=> $typepage,
                    'seoTitle'	=> (string) $title,
                    'seoDesc'	=> (string) $seodeskripsi,
                    'seoKeyword'=> (string) $keyword,
                    'seoRobots'	=> (string) $SEO_robots
                );
        
                $query = $ci->db->insert( $ci->db->dbprefix('seo_page'), $insvalueseo);

                if($query){
                    $result = true;
                }
            }
        } else {
            $numseo = countdata('seo_page',array('relatiedId'=> $id,'seoTypePage'=> $typepage));

            if($numseo>0){
                $ci->db->where( array('relatiedId'=> $id,'seoTypePage'=> $typepage) );
                $query = $ci->db->delete( $ci->db->dbprefix('seo_page'));

                if($query){
                    $result = true;
                }
            }
        }
    }

    return $result;
}

function getSeoPage($id = null, $type = null){
    $result = array(
        'seoId' => '',
        'relatiedId' => '',
        'seoTypePage' => '',
        'seoTitle' => '',
        'seoDesc' => '',
        'seoKeyword' => '',
        'seoRobots' => ''
    );

    if(!empty($id) AND !empty($type) ){
        $id = esc_sql(filter_int($id));
        $type = esc_sql(filter_txt($type));
        
        if(countdata('seo_page', array('relatiedId'=>$id,'seoTypePage'=>$type)) > 0){
            $result = getval('seoId,relatiedId,seoTypePage,seoTitle,seoDesc,seoKeyword,seoRobots', 'seo_page', array('relatiedId'=>$id,'seoTypePage'=>$type));
        }
    }

    return $result;
}

function this_url(){
	$currentURL = current_url(); //http://myhost/main

	$params = empty($_SERVER['QUERY_STRING']) ? '':'?'.$_SERVER['QUERY_STRING']; //?my_query=val&query2=val2...
	$fullURL = $currentURL . $params; 

	return $fullURL;
}
