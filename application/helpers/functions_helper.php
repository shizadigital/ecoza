<?php 
/**************** Date and Time ********************/
function time2timestamp($settime=''){
    $time = date("Y-m-d H:i:s");

    if(class_exists('DateTime')){
        if($settime!=''){           
            $datetimeclass = new DateTime($settime);
            $timestamp = $datetimeclass->getTimestamp();
        } else {
            $datetimeclass = new DateTime($time);
            $timestamp = $datetimeclass->getTimestamp();
        }
    } else {
        if($settime!=''){
            $timestamp = strtotime($settime);
        } else {
            $timestamp = strtotime($time);
        }
    }
    return $timestamp;
}

function timestamp2time($timestamp = null, $format = 'Y-m-d H:i:s'){
    if( $timestamp != null ){
        return date($format, $timestamp);
    } else {
        $timestamp = time2timestamp();
        return date($format, $timestamp);
    }
}

function getDay($date){
    $seminggu = array( t('sunday'),t('monday'),t('tuesday'),t('wednesday'),t('thursday'),t('friday'),t('saturday') );
    if($date){
        $timestamp = date('w', strtotime($date));
        $hari = $seminggu[$timestamp];

        return $hari;
    } else {
        return false;
    }
}

function getMonth($bln){
    
    switch ($bln){
        case 1: 
            return t('january');
            break;
        case 2:
            return t('february');
            break;
        case 3:
            return t('march');
            break;
        case 4:
            return t('april');
            break;
        case 5:
            return t('may');
            break;
        case 6:
            return t('june');
            break;
        case 7:
            return t('july');
            break;
        case 8:
            return t('august');
            break;
        case 9:
            return t('september');
            break;
        case 10:
            return t('october');
            break;
        case 11:
            return t('november');
            break;
        case 12:
            return t('december');
            break;
    }
}

function hijriah($time){
    $theDate = getdate();
    $wday = $theDate['wday'];
    $hr = $theDate['mday'];
    $theMonth = $theDate['mon'];
    $theYear = $theDate['year'];

    if (($theYear > 1582) || (($theYear == 1582) && ($theMonth > 10)) || (($theYear == 1582) && ($theMonth == 10) && ($hr > 14))) {
        $zjd = (int)((1461 * ($theYear + 4800 + (int)(($theMonth - 14) / 12))) / 4) + (int)((367 * ($theMonth - 2 - 12 * ((int)(($theMonth - 14) / 12)))) / 12) - (int)((3 * (int)((($theYear + 4900 + (int)(($theMonth - 14) / 12)) / 100))) / 4) + $hr - 32075;
    } else {
        $zjd = 367 * $theYear - (int)((7 * ($theYear + 5001 + (int)(($theMonth - 9) / 7))) / 4) + (int)((275 * $theMonth) / 9) + $hr + 1729777;
    }

    $zl         = $zjd - 1948440 + 10632;
    $zn         = (int)(($zl-1)/10631);
    $zl         = $zl - 10631 * $zn + 354;
    $zj         = ((int)((10985 - $zl)/5316))*((int)((50 * $zl)/17719))+((int)($zl/5670))*((int)((43 * $zl)/15238));
    $zl         = $zl-((int)((30 - $zj)/15))*((int)((17719 * $zj)/50))-((int)($zj/16))*((int)((15238 * $zj)/43))+29;
    $theMonth   = (int)((24 * $zl)/709);
    $hijriDay   = $zl-(int)((709 * $theMonth)/24);
    $hijriYear  = 30 * $zn + $zj - 30;

    if ($theMonth==1){ $hijriMonthName = "Muharram"; }
    if ($theMonth==2){ $hijriMonthName = "Safar"; }
    if ($theMonth==3){ $hijriMonthName = "Rabiul Awal"; }
    if ($theMonth==4){ $hijriMonthName = "Rabiul Akhir"; }
    if ($theMonth==5){ $hijriMonthName = "Jamadil Awal"; }
    if ($theMonth==6){ $hijriMonthName = "Jamadil Akhir"; }
    if ($theMonth==7){ $hijriMonthName = "Rejab"; }
    if ($theMonth==8){ $hijriMonthName = "Syaaban"; }
    if ($theMonth==9){ $hijriMonthName = "Ramadhan"; }
    if ($theMonth==10){ $hijriMonthName = "Syawal"; }
    if ($theMonth==11){ $hijriMonthName = "Zulkaedah"; }
    if ($theMonth==12){ $hijriMonthName = "Zulhijjah"; }

    if ($wday==0) { $hijriDayString = "Al-Ahad"; }
    if ($wday==1) { $hijriDayString = "Al-Itsnain"; }
    if ($wday==2) { $hijriDayString = "Ats-tsulatsa'"; }
    if ($wday==3) { $hijriDayString = "Al-Arbi'aa"; }
    if ($wday==4) { $hijriDayString = "Al-Khomis"; }
    if ($wday==5) { $hijriDayString = "Al-Jumuah"; }
    if ($wday==6) { $hijriDayString = "As-Sabt"; }

    //Realisasikan
    switch ($time){
        case 'date':
            return $hijriDay;
            break;
        case 'month':
            return $theMonth;
            break;
        case 'monthname':
            return $hijriMonthName;
            break;
        case 'year':
            return $hijriYear;
            break;
        case 'hour':
            return date("H:i:s");
            break;
        case 'day':
            return $hijriDayString;
            break;
    }
}

function dateSays($timestamp){

    $selisih = time() - $timestamp;

    $detik = $selisih ;
    $menit = round($selisih / 60 );
    $jam = round($selisih / 3600 );
    $hari = round($selisih / 86400 );
    $minggu = round($selisih / 604800 );
    $bulan = round($selisih / 2600640 );
    $tahun = round($selisih / 31207680 );

    if ($detik <= 60) {
        $waktu = $detik.' '.t('seconds');
    } elseif ($menit <= 60) {
        $waktu = $menit.' '.t('minutes');
    } elseif ($jam <= 24) {
        $waktu = $jam.' '.t('hours');
    } elseif ($hari <= 7) {
        $waktu = $hari.' '.t('days');
    } elseif ($minggu <= 4.3) {
        $waktu = $minggu.' '.t('weeks');
    } elseif ($bulan <= 12) {
        $waktu = $bulan.' '.t('months');
    } else {
        $waktu = $tahun.' '.t('years');
    }
    
    return $waktu;
}

/**************** BB Code Convertion ********************/
function bbcode_to_html($bbtext){
    $bbtags = array(
        '[b]' => '<strong>','[/b]' => '</strong>',
        '[i]' => '<em>','[/i]' => '</em>',
        '[u]' => '<u>','[/u]' => '</u>',
        '[s]' => '<s>','[/s]' => '</s>',

        '[list]' => '<ul>','[/list]' => '</ul>',
        '[list=1]' => '<ul style="list-style-type:decimal;">',
        '[*]' => '<li>','[/*]' => '</li>',
        '[li]' => '<li>','[/li]' => '</li>',

        '[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
        '[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
        '[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
        '[code]' => '<code>','[/code]' => '</code>',
        '[quote]' => '<blockquote>','[/quote]' => '</blockquote>'
    );

    $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);

    $bbextended = array(
        "/\[url](.*?)\[\/url]/i" => "<a href=\"http://$1\" title=\"$1\" rel=\"nofollow\" target=\"_blank\">$1</a>",
        "/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href=\"$1\" title=\"$1\" rel=\"nofollow\" target=\"_blank\">$2</a>",
        "/\[img\]([^[]*)\[\/img\]/i" => "<img src=\"$1\" alt=\" \" />",
        "/\[color=(.*?)\](.*?)\[\/color\]/i" => "<span style=\"color:$1;\">$2</span>",
        "/\[size=(.*?)\](.*?)\[\/size\]/i" => "<span style=\"font-size:$1%;\">$2</span>",
        "/\[font=(.*?)\](.*?)\[\/font\]/i" => "<span style=\"font-family:$1;\">$2</span>"
    );

    foreach($bbextended as $match=>$replacement){
        $bbtext = preg_replace($match, $replacement, $bbtext);
    }
    
    return $bbtext;
}

function html_to_bbcode($bbtext){
    $bbtags = array(
        '<strong>' => '[b]','</strong>' => '[/b]',
        '<em>' => '[i]','</em>' => '[/i]',
        '<u>' => '[u]','</u>' => '[/u]',
        '<s>' => '[s]','</s>' => '[/s]',

        '<ul>' => '[list]','</ul>' => '[/list]',
        '<ul style="list-style-type:decimal;">' => '[list=1]',
        '<li>' => '[*]','</li>' => '[/*]',
        '<li>' => '[li]','</li>' => '[/li]',
        
        '<code>' => '[code]','</code>' => '[/code]',
        '<blockquote>' => '[quote]','</blockquote>' => '[/quote]'
    );

    $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);

    $bbextended = array(
        "/<p style=\"text-align:left;\">(.*?)<\/p>/i" => "[left]$1[/left]",
        "/<p style=\"text-align:center;\">(.*?)<\/p>/i" => "[center]$1[/center]",
        "/<p style=\"text-align:right;\">(.*?)<\/p>/i" => "[right]$1[/right]",

        "/<a href=\"(.*?)\" title=\"(.*?)\" rel=\"nofollow\" target=\"_blank\">(.*?)<\/a>/i" => "[url]$1[/url]",
        "/<a href=\"(.*?)\" title=\"(.*?)\" rel=\"nofollow\" target=\"_blank\">(.*?)<\/a>/i" => "[url=$1]$3[/url]",
        "/<img src=\"([^[]*)\" alt=\" \" \/>/i" => "[img]$1[/img]",
        "/<span style=\"color:(.*?);\">(.*?)<\/span>/i" => "[color=$1]$2[/color]",
        "/<span style=\"font-size:(.*?)%;\">(.*?)<\/span>/i" => "[size=$1]$2[/size]",
        "/<span style=\"font-family:(.*?);\">(.*?)<\/span>/i" => "[font=$1]$2[/font]",
    );

    foreach($bbextended as $match=>$replacement){
        $bbtext = preg_replace($match, $replacement, $bbtext);
    }
    
    return $bbtext;
}

/**
 * Create a web friendly URL slug from a string.
 * 
 * Although supported, transliteration is discouraged because
 *     1) most web browsers support UTF-8 characters in URLs
 *     2) transliteration causes a loss of information
 *
 * @author Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license http://creativecommons.org/publicdomain/zero/1.0/
 *
 * @param string $str
 * @param array $options
 * @return string
 */
function slugURL($str, $options = array()) {
    if($str){
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );
        
        // Merge options
        $options = array_merge($defaults, $options);
        
        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
            'ß' => 'ss', 
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
            'Ž' => 'Z', 
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z', 

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
            'Ż' => 'Z', 
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );
        
        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
        
        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }
        
        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
        
        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
        
        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
        
        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);
        
        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
}

function getOS() {
    $ci =& get_instance();
    $ci->load->library('user_agent');

    $os_platform =   "Unknown";

    if( $ci->agent->platform() ){
        $os_platform =   $ci->agent->platform();
    }

    return $os_platform;
}

function getBrowser($versionview = false) {
    $ci =& get_instance();
    $ci->load->library('browser');

    $browser = $ci->browser->getBrowser();
    if( $versionview == true){
        $browser .= ' ' .$ci->browser->getVersion();
    }

    return $browser;
}

/**
 * 
 * Create random code.
 *
 * @param int $length
 * @param bool $unique_char
 * @param string $type
 * @return string
 */
function generate_code($length=6, $unique_char = false, $type = null){
    $source='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($type == 'numbers'){
        $source='1234567890';
    } elseif($type == 'letters'){
        $source='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    
    if($unique_char==true){ $source .= '~`!@#$%^&*()_+,>< .?/:;"\'{[}]|\_-+='; }
    $code = '';
    for ($i=0;$i<$length;$i++){
        $sourceLen=strlen($source);
        $randNo=rand(1,$sourceLen-1);
        $code.=substr($source,$randNo,1);
    }
    return $code;
}

/*** network ****/
function getIP(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) OR filter_var($client, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)){
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) OR filter_var($forward, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)){
        $ip = $forward;
    } elseif (filter_var($remote, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) OR filter_var($remote, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)){
        $ip = $remote;
    } else {
        #this is bad user, sredirect or just exit here
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            exit;
        }
    }

    return $ip;
}

/*** CLI ****/
function cli($cmd, $multithread = TRUE) {
    if(substr($cmd,0,3)=='php'){
        if(strtolower(substr(php_uname(), 0, 7)) == 'windows'){
            if(PHP_CLI_FILENAME == ''){
                $cmd = ($_SERVER['PHPRC'] ? $_SERVER['PHPRC'].DIRECTORY_SEPARATOR:'') .$cmd;
            }
        }
        else{
            $charlen = strlen($cmd);
            $cmd = substr($cmd, 4, $charlen);
            $cmd = PHP_CLI_FILENAME ." $cmd";
        }
    }

    if($multithread == TRUE){
        if(strtolower(substr(php_uname(), 0, 7)) == 'windows'){
            pclose(popen('start /B '. $cmd, 'r'));
        }
        else {
            exec($cmd . ' > /dev/null 2>&1 &');
        }
    }
    else{
        exec($cmd,$output,$err);
        return array($output,$err);
    }
}

/*** cron log ****/
function cron_activity_log($cronName,$report) {
    $ci =& get_instance();

    $now = time2timestamp();
    
    if( empty($cronName)){ 
        return false; 
    } else{
        $data = array( 'cronLastAct' => $now );

        if(!empty($report)){ $data = array_merge($data, array('cronReport'=>$report) ); }

        return $ci->Env_model->update('cron_list', $data, "cronName='{$cronName}'");
    }
}

/**** set and filter comma in number ***/
function singleComma($value, $sepin= ",", $sepout = "."){
    $ex_val = explode($sepin, $value);              

    if(count($ex_val) > 1){ $value_ = $ex_val[0].$sepout; }
    else { $value_ = $ex_val[0]; }

    foreach ($ex_val as $keyval => $valueval) {
        if($valueval == $ex_val[0]){ continue; }
        $value_ .= $valueval;
    }

    return $value_;
}

/**
* Convert convert size of in bytes to human readable
*
* @param  int  $size
*
* @return  string
*/
function theSize($size){
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
    $u = 0;
    while ((round($size / 1024) > 0) && ($u < 4))
    {
        $size = $size / 1024;
        $u++;
    }

    return (number_format($size, 0) . " " . $units[ $u ]);
}

/**
* check array unique
*
* @param  array $array
*
* @return boolean
*/
function is_array_unique($array){
    $result = false;
    if( array_unique($array) == $array AND is_array( $array ) ){
        $result = true;
    }

    return $result;
}

/**
*
* Data Transaction
*
*/
function getNextId($idfield,$tablename){
    $ci =& get_instance();

    // to model
    return $ci->Env_model->getNextId($idfield, $tablename);
}

function nextSort($table, $sortfieldname, $where=null){
    $ci =& get_instance();

    // to model
    return $ci->Env_model->nextSort($table, $sortfieldname, $where);
}

function getval($fieldToDisplay,$table,$fieldReference=null,$method_data = 'array'){
    $ci =& get_instance();

    // to model
    return $ci->Env_model->getval($fieldToDisplay, $table, $fieldReference, $method_data);
}

function countdata($table,$whereClause=null){
    $ci =& get_instance();

    // to model
    return $ci->Env_model->countdata($table, $whereClause);
}

/**
*
* Content
*
*/
function the_excerpt($content, $number = false, $dotted = ' ...', $display = false){
    if($number==false){
        $number = get_option('ringkaspost');
    }   

    $number = esc_sql(filter_int($number));

    $filter_content     = htmlspecialchars_decode(htmlentities(strip_tags($content)));
    $cut_content        = substr($filter_content,0,$number);
    $cut_perspace       = substr($filter_content,0,strrpos($cut_content," "));

    if(strlen($filter_content)>$number){ $result = $cut_perspace . $dotted; }
    else { $result = strpos($cut_perspace," ") ? $filter_content : $cut_content; }

    if($display){ echo $result; } else { return $result; }
}

/**
*
* Gravatar
*
* @param  string  $email The email address
* @param  int  $s Size in pixels, defaults to 80px [ 1 - 2048 ]
* @param  int  $random Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
* @param  string  $r Maximum rating (inclusive) [ g | pg | r | x ]
* @param  bool  $img True to return a complete IMG tag False for just the URL
* @param  string  $atts  Optional, additional key/value attributes to include in the IMG tag
*
* @source https://gravatar.com/site/implement/images/php/
*    
* @return  string
*/
function gravatar( $email, $s = 80, $random = true,  $r = 'g', $img = false, $atts = array() ) {
    
    $result = false;

    if($random == true){
        $monn = array('mm','identicon','monsterid','wavatar');
        $monster =  array_rand($monn);
        $d = $monn[$monster]; 
    } else {
        $d = 'mm';
    }

    $url = 'https://secure.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= ".jpg?d=$d";

    $file_headers = @get_headers($url);
    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $exists = false;
    }
    else {
        $exists = true;
    }

    if ( $img AND $exists ) {
        $url = '<img src="' . $url . '"';

        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';

        $url .= ' />';
    }
    
    $result = $url;

    return $result;
}

/**
*
* Make Directory
*
* @param string $namadir
* @param string $permission
* @param string $recursive
*
* @return bool
*
*/
function makeDir($namadir, $permission = 0755, $recursive = false){
    //Check Directory
    if(is_dir($namadir)==false){
        $makedirname = mkdir($namadir, $permission, $recursive);
        if($makedirname){
            // Buat file index
            $dirnamefileindex = "{$namadir}/index.html";
            $dirnamehandle = fopen ($dirnamefileindex, "w");
            $fileindexdirnamecontent = "<!DOCTYPE html>
<html>
<head>
    <title>403 Forbidden</title>
</head>
<body>

<p>Directory access is forbidden.</p>

</body>
</html>";
            fputs ($dirnamehandle, $fileindexdirnamecontent);
            fclose($dirnamehandle);

            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

/**
*
* Membuat direktori upload
*
*/
function makeDirUpload($dir, $dirextra, $type ='images', $error_handling=true){
    $error = false;

    $dirname = STORAGE_PATH.$type.DIRECTORY_SEPARATOR.$dir;
    $dirupload = $dirname.DIRECTORY_SEPARATOR.$dirextra;

    if(is_dir($dirname)==false){ // periksa direktori berdasarkan nama direktori
        $makedirname = makeDir($dirname,0755);
        if($makedirname){ 
            $makedir_upload = makeDir($dirupload,0755);
            if(!$makedir_upload){
                $error = "<strong>ERROR</strong> Proses pembuatan direktori <code>" .$dirextra. "</code> gagal, silahkan periksa \"izin folder\" atau hubungi webmaster";

            }
        } else {
            $error = "<strong>ERROR</strong> Proses pembuatan direktori <code>" .$dir. "</code> gagal, silahkan periksa \"izin folder\" atau hubungi webmaster";
        }
    } else {
        if(file_exists($dirupload)==false){
            $makedir_upload = makeDir($dirupload,0755);
            if(!$makedir_upload){               
                $error = "<strong>ERROR</strong> Proses pembuatan direktori <code>".$dirextra."</code> gagal, silahkan periksa \"izin folder\" atau hubungi webmaster";
            }
        }
    }

    if(!$error){
        $result = true;
    } else {
        if($error_handling==true) { show_error($error, 503,'Pembuatan directory gagal'); exit; }
        $result = false;
    }

    return $result;
}

/**
*
* Upload File
*
*
* @param string $filekeyarray
* @param string $dir
* @param array $ext_allowed
* @param null $specialname Null for default value and string for insert the value
* @param int $size_allowed
*
* @return array
*/
function uploadFile($filekeyarray, $dir=null, $ext_allowed = array(), $specialname=null,  $size_allowed = 2048 ){
    global $_FILES;
    $error = false;
    $ci =& get_instance();

    $extentionvalid = false;

    // change image data to array
    if( !is_array( $_FILES[$filekeyarray]['name'] ) ){
        $_FILES[$filekeyarray]['name']     = array( 0 => $_FILES[$filekeyarray]['name']);
        $_FILES[$filekeyarray]['type']     = array( 0 => $_FILES[$filekeyarray]['type']);
        $_FILES[$filekeyarray]['tmp_name'] = array( 0 => $_FILES[$filekeyarray]['tmp_name']);
        $_FILES[$filekeyarray]['error']    = array( 0 => $_FILES[$filekeyarray]['error']);
        $_FILES[$filekeyarray]['size']     = array( 0 => $_FILES[$filekeyarray]['size']);
    }

    $filecount = count(array_filter($_FILES[$filekeyarray]['name']));

    // check valid extention here
    if( $filecount > 0){
        foreach (array_filter($_FILES[$filekeyarray]['name']) as $key => $value) {
            $extfilename = strtolower( pathinfo($_FILES[$filekeyarray]['name'][$key], PATHINFO_EXTENSION) );  
            if( in_array($extfilename, $ext_allowed) ){
                $extentionvalid = true;
            } else {
                $extentionvalid = false; break;
            }
        }
    }

    // dir extra with month and year
    $dirextra = date('m').date('Y');

    if( empty($dir) ){
        $error = "<strong>ERROR</strong> Direktori khusus file pada parameter ke 3 kosong, silakan gunakan nama yang unik untuk membuat direktori khusus";
    }

    if( $filecount > 0 ):
        
        // check extention
        if( $extentionvalid ){
            makeDirUpload($dir, $dirextra, 'files');
        } else {
            $error = "<strong>ERROR</strong> Saat ini ekstensi file yang diizinkan adalah \"<code>";
            foreach ($ext_allowed as $extkey => $extvalue) {
                $error .= "*.{$extvalue}, ";
            }
            // Hilangkan , pada loop terakhir foreach
            $error .= substr( $error, 0, strlen( $error ) - 2 );
            $error .= "</code>\", silahkan periksa \"izin folder\" atau hubungi webmaster";
        }

        if(!$error){
            if( empty($specialname) ){
                $specialname = web_info();
            } else {
                $specialname = filter_txt($specialname);
            }

            // buat lokasi folder beserta file
            $dirname = FILES_PATH.$dir;
            $diruploadimg = $dirname.DIRECTORY_SEPARATOR.$dirextra.DIRECTORY_SEPARATOR;

            // pecah ekstensi dengan batas |
            $extension_allowed = implode("|", $ext_allowed);

            if( $filecount > 0 ){
                $files = $_FILES;

                foreach (array_filter($files[$filekeyarray]['name']) as $key => $value) {

                    // reverse data
                    $_FILES[$filekeyarray]['name']     = $files[$filekeyarray]['name'][$key];
                    $_FILES[$filekeyarray]['type']     = $files[$filekeyarray]['type'][$key];
                    $_FILES[$filekeyarray]['tmp_name'] = $files[$filekeyarray]['tmp_name'][$key];
                    $_FILES[$filekeyarray]['error']    = $files[$filekeyarray]['error'][$key];
                    $_FILES[$filekeyarray]['size']     = $files[$filekeyarray]['size'][$key];

                    // buat nama file baru
                    $name           = pathinfo($_FILES[$filekeyarray]['name'], PATHINFO_FILENAME);
                    $extfile        = pathinfo($_FILES[$filekeyarray]['name'], PATHINFO_EXTENSION);
                    $nameconv       = str_replace(' ','_',strtolower(trim(preg_replace("/[^a-zA-Z0-9 _]/", '', $specialname)))) .'_'. sha1( $name );
                    $codeacak       = substr(md5(uniqid('')),-6,6);
                    $filenamebaru   = $codeacak.$dirextra."_".$nameconv.".".$extfile;
                    $file_upload    = $diruploadimg . $filenamebaru;

                    $config['upload_path']      = $diruploadimg;
                    $config['allowed_types']    = $extension_allowed;
                    $config['file_name']        = $filenamebaru;
                    $config['overwrite']        = true;
                    $config['max_size']         = $size_allowed;

                    $ci->load->library('upload');
                    $ci->upload->initialize($config);
                    if( $ci->upload->do_upload($filekeyarray) ) {

                        // get data after upload
                        $dataupld = $ci->upload->data();

                        $newdir = $dir.'/'.$dirextra;

                        if($filecount > 1){
                            $arrayarg[$key] = array(
                                'filename'      => $filenamebaru,
                                'directory'     => $newdir
                            );
                        } else {
                            $arrayarg = array(
                                'filename'      => $filenamebaru,
                                'directory'     => $newdir
                            );
                        }

                    } else {
                        $error = "<strong>ERROR</strong> file gagal di-upload ke server";
                        show_error($error, 503,'Upload file gagal'); exit;
                    }

                }

                return $arrayarg;

            } else {
                $error = "<strong>ERROR</strong> file gagal di-upload ke server";
                show_error($error, 503,'Upload file gagal'); exit;
            }

        } else {
            show_error($error, 503,'Pembuatan directory gagal'); exit;
        }

    endif;
}

/**
*
* Upload Image
*
* @param string $filekeyarray
* @param null $dir
* @param array $sizeofimage
* @param array $ext_allowed
* @param null $specialname
* @param int $size_allowed
*
* @return array
*/
function uploadImage($filekeyarray, $dir=null, $sizeofimage = array(), $ext_allowed = array('jpg','jpeg','png'), $specialname=null,  $size_allowed = 2048 ){
    global $_FILES;
    $error = false;
    $ci =& get_instance();

    $extentionvalid = false;

    // change image data to array
    if( !is_array( $_FILES[$filekeyarray]['name'] ) ){
        $_FILES[$filekeyarray]['name']     = array( 0 => $_FILES[$filekeyarray]['name']);
        $_FILES[$filekeyarray]['type']     = array( 0 => $_FILES[$filekeyarray]['type']);
        $_FILES[$filekeyarray]['tmp_name'] = array( 0 => $_FILES[$filekeyarray]['tmp_name']);
        $_FILES[$filekeyarray]['error']    = array( 0 => $_FILES[$filekeyarray]['error']);
        $_FILES[$filekeyarray]['size']     = array( 0 => $_FILES[$filekeyarray]['size']);
    }

    $imgcount = count(array_filter($_FILES[$filekeyarray]['name']));

    // check valid extention here
    if( $imgcount > 0){
        foreach (array_filter($_FILES[$filekeyarray]['name']) as $key => $value) {
            $extfilename = strtolower( pathinfo($_FILES[$filekeyarray]['name'][$key], PATHINFO_EXTENSION) );  
            if( in_array($extfilename, $ext_allowed) ){
                $extentionvalid = true;
            } else {
                $extentionvalid = false; break;
            }
        }
    }

    if( count($sizeofimage) < 1 ){
        // default size
        $sizeofimage = array(
            'xsmall' => 90,
            'small' => 120,
            'medium' => 350,
            'large' => 650,
            'xlarge' => 980
        );
    }

    // dir extra with month and year
    $dirextra = date('m').date('Y');

    if( empty($dir) ){
        $error = "<strong>ERROR</strong> Direktori khusus file pada parameter ke 3 kosong, silakan gunakan nama yang unik untuk membuat direktori khusus";
    }

    if( $imgcount > 0 ):

        // check extention
        if( $extentionvalid ){
            makeDirUpload($dir, $dirextra, 'images');
        } else {
            $error = "<strong>ERROR</strong> Saat ini ekstensi file gambar yang diizinkan adalah \"<code>";
            foreach ($ext_allowed as $extkey => $extvalue) {
                $error .= "*.{$extvalue}, ";
            }
            // Hilangkan , pada loop terakhir foreach
            $error .= substr( $error, 0, strlen( $error ) - 2 );
            $error .= "</code>\", silahkan periksa \"izin folder\" atau hubungi webmaster";
        }

        if(!$error){
            if( empty($specialname) ){
                $specialname = web_info();
            } else {
                $specialname = filter_txt($specialname);
            }

            // buat lokasi folder beserta file
            $dirname = IMAGES_PATH.$dir;
            $diruploadimg = $dirname.DIRECTORY_SEPARATOR.$dirextra.DIRECTORY_SEPARATOR;

            // pecah ekstensi dengan batas |
            $extension_allowed = implode("|", $ext_allowed);

            if( $imgcount > 0 ){
                $files = $_FILES;

                foreach (array_filter($files[$filekeyarray]['name']) as $key => $value) {

                    // reverse data
                    $_FILES[$filekeyarray]['name']     = $files[$filekeyarray]['name'][$key];
                    $_FILES[$filekeyarray]['type']     = $files[$filekeyarray]['type'][$key];
                    $_FILES[$filekeyarray]['tmp_name'] = $files[$filekeyarray]['tmp_name'][$key];
                    $_FILES[$filekeyarray]['error']    = $files[$filekeyarray]['error'][$key];
                    $_FILES[$filekeyarray]['size']     = $files[$filekeyarray]['size'][$key];

                    // buat nama file baru
                    $name           = pathinfo($_FILES[$filekeyarray]['name'], PATHINFO_FILENAME);
                    $extfile        = pathinfo($_FILES[$filekeyarray]['name'], PATHINFO_EXTENSION);
                    $nameconv       = str_replace(' ','_',strtolower(trim(preg_replace("/[^a-zA-Z0-9 _]/", '', $specialname)))) .'_'. sha1( $name );
                    $codeacak       = substr(md5(uniqid('')),-6,6);
                    $filenamebaru   = $codeacak.$dirextra."_".$nameconv.".".$extfile;
                    $file_upload    = $diruploadimg . $filenamebaru;

                    //Simpan gambar dalam ukuran sebenarnya
                    $config['upload_path']      = $diruploadimg;
                    $config['allowed_types']    = $extension_allowed;
                    $config['file_name']        = $filenamebaru;
                    $config['overwrite']        = true;
                    $config['max_size']         = $size_allowed;

                    $ci->load->library('upload');
                    $ci->upload->initialize($config);
                    if( $ci->upload->do_upload($filekeyarray) ) {

                        // get data after upload
                        $dataupld = $ci->upload->data();
                    
                        // kompres gambar
                        if( count($sizeofimage)>0 ){
                            $imgsz = getimagesize($files[$filekeyarray]['tmp_name'][$key]);
                            $src_width = $imgsz[0];
                            $src_height = $imgsz[1];

                            $ci->load->library('image_lib');
                            foreach ($sizeofimage as $ksz => $vsz) {
                                $config['image_library']  = 'gd2';
                                $config['source_image']   = $diruploadimg . $dataupld['file_name'];
                                $config['create_thumb'] = false;
                                $config['maintain_ratio'] = false;

                                $compress_width = $vsz;
                                $compress_height = ($compress_width/$src_width)*$src_height;
                                $compress_height = ceil($compress_height);

                                $config['width']        = $compress_width;
                                $config['height']       = $compress_height;
                                $config['new_image']= $diruploadimg . $ksz . '_'.$dataupld['file_name'];

                                $ci->image_lib->initialize($config);
                                $ci->image_lib->resize();
                                $ci->image_lib->clear();
                            }
                        }

                        $newdir = $dir.'/'.$dirextra;

                        if($imgcount > 1){
                            $arrayarg[$key] = array(
                                'filename'      => $filenamebaru,
                                'directory'     => $newdir
                            );
                        } else {
                            $arrayarg = array(
                                'filename'      => $filenamebaru,
                                'directory'     => $newdir
                            );
                        }

                    } else {
                        $error = "<strong>ERROR</strong> Gambar gagal di-upload ke server";
                        show_error($error, 503,'Upload file gagal'); exit;
                    }
                }

                return $arrayarg;

            } else {
                $error = "<strong>ERROR</strong> Gambar gagal di-upload ke server";
                show_error($error, 503,'Upload file gagal'); exit;
            }

        } else {
            show_error($error, 503,'Pembuatan directory gagal'); exit;
        }

    endif;
}

/**
*
* Phone Number
*
*/
function phoneConvertFormat($hp, $format='0'){
    // kadang ada penulisan no hp 0811 239 345
    $hp = str_replace(" ","",$hp);
    // kadang ada penulisan no hp (0274) 778787
    $hp = str_replace("(","",$hp);
    // kadang ada penulisan no hp (0274) 778787
    $hp = str_replace(")","",$hp);
    // kadang ada penulisan no hp 0811.239.345
    $hp = str_replace(".","",$hp);

	if(!preg_match('/[^+0-9]/',trim($hp))){
		if($format=='0'){
	        // cek apakah no hp karakter 1-3 adalah +62
	        if(substr(trim($hp), 0, 3)=='+62') { $hp = '0'.substr(trim($hp), 3); }
	        // cek apakah no hp karakter 1 adalah 0
	        elseif(substr(trim($hp), 0, 1)=='0'){ $hp = trim($hp); }
	        // cek apakah no hp karakter 1 adalah 0
	        elseif(substr(trim($hp), 0, 2)=='62'){ $hp = '0'.substr(trim($hp), 2); }
	    } elseif($format=='+62') {
	    	// cek apakah no hp karakter 1-3 adalah +62
	        if(substr(trim($hp), 0, 3)=='+62') { $hp = trim($hp); }
	        // cek apakah no hp karakter 1 adalah 0
	        elseif(substr(trim($hp), 0, 1)=='0'){ $hp = '+62'.substr(trim($hp), 1); }
	        // cek apakah no hp karakter 1 adalah 0
	        elseif(substr(trim($hp), 0, 2)=='62'){ $hp = '+62'.substr(trim($hp), 2); }
	    }
    }

	return $hp;
}

/**
*
* Combination Array
*
* @param array $arrays
*
* @return array
*/
function getCombination( $arrays ){
    $result = array(array());
	foreach ($arrays as $property => $property_values) {
		$tmp = array();
		foreach ($result as $result_item) {
			foreach ($property_values as $property_value) {
				$tmp[] = array_merge($result_item, array($property => $property_value));
			}
		}
		$result = $tmp;
	}
	return $result;
}

/**
 * check email black list
 *
 * @param string $email
 * @return boolean
 */
function is_emailblacklist($email = null){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ return true; }

    $email = esc_sql(filter_txt($email)); 
    $result = false;    
    if( countdata('email_blacklist', array('eblEmail'=>$email)) > 0 ) $result =true;

    return $result;
}

/**
 *
 * Send mail to queue in database
 *
 * @param string $emailto
 * @param string $subject
 * @param string $msg
 * @param mixed $cc
 * @param mixed $bcc
 * @param string $emailtype
 * @param string $emailhead
 * @param array $emailattach
 *
 * @return bool
 */
function sendMailToQueue($emailto, $subject='', $msg='', $cc='', $bcc='', $emailtype = 'html', $emailhead='', $emailattach=array()){
    $ci =& get_instance();

    $result = false;
    $dataattach = '';

    $countqueue = countdata('email_queue', array('emailMsg'=>$msg, 'emailTo'=>$emailto));
    if( $countqueue < 1 AND !is_emailblacklist($emailto) ){

        if(count($emailattach) > 0){
            $dirextra = date('m').date('Y');
            
            $dirnamequeue ='emailqueue';
            // make dir in files 
            $makedir = makeDirUpload($dirnamequeue , $dirextra, 'files');

            $dirname = FILES_PATH.$dirnamequeue;
            $dirattach = $dirname.DIRECTORY_SEPARATOR.$dirextra.DIRECTORY_SEPARATOR;
            if($makedir){
                if(!empty( $emailattach['filename']) AND !empty( $emailattach['filepath'])){
                    @copy($emailattach['filepath'], $dirattach);
                } else {
                    foreach( $emailattach as $val){
                        if( is_array($val) ){
                            @copy($val['filepath'], $dirattach);
                        }
                    }
                }
            }

            $dataattach = serialize($emailattach);
        }

        if(is_array($cc)){
            $cc = serialize($cc);
        }
        if(is_array($bcc)){
            $bcc = serialize($bcc);
        }

        $nexid = getNextId('emailId','email_queue');
        $data = array(
                'emailId' => $nexid,
                'emailTo' => $emailto,
                'emailCC' => (string) $cc,
                'emailBCC' => (string) $bcc,
                'emailSubject' => (string) $subject,
                'emailMsg' => (string) $msg,
                'emailMsgType' => $emailtype,
                'emailHead' => (string) $emailhead,
                'emailDate' => time2timestamp(),
                'emailDateSent' => 0,
                'emailStatus' => 'n',
                'emailAttachFile'=> $dataattach,
        );

        $query = $ci->db->insert( $ci->db->dbprefix('email_queue'), $data);

        if($query){ $result = true; }
    }

    return $result;
}

/**
 *
 * Send mail with php mailer
 *
 * @param array $options
 *
 * @return bool
 */
function sendMailPHPMailer($options){
    // Unclude the file
    $ci =& get_instance();
    $ci->load->library('SendMailPhpMailer');
    $mail = $ci->sendmailphpmailer->load();
    
	foreach($options as $key=>$value){
		$$key = $value;
	}
	
	if(empty($mailopt)){
		$mailopt = EMAIL_OPTION;
	} else {
		$mailopt = $mailopt;
    }
    
    $result = false;
	
	if ($mailopt == "standard"){

		$mail->IsSMTP();
		
		$mail->setFrom($from, $fromname);
		$mail->addAddress($to, $toname);
		$mail->addReplyTo($replyto, "Reply");
        
        if(is_array($cc)){
            foreach($cc as $ccval){
		        $mail->addCC($ccval);
            }
        }
        else {
            $mail->addCC($cc);
        }

        if(is_array($bcc)){
            foreach($bcc as $bccval){
		        $mail->addBCC($bccval);
            }
        }
        else {
            $mail->addBCC($bcc);
        }

		if($messagetype=='html'){
			$mail->isHTML(true); 
		}else{
			$mail->isHTML(false); 
		}
		$mail->CharSet = "UTF-8";
		$mail->Subject = $subject;
		$mail->Body    = $message;

		// Attachments
		if(!empty($attachment)){
            if( count($attachment) > 0 ){
                if(!empty( $attachment['filename']) AND !empty( $attachment['filepath'])){
                    $mail->addAttachment( $attachment['filepath'], $attachment['filename']);
                } else {
                    foreach( $attachment as $val){
                        if( is_array($val) ){
                            $mail->addAttachment( $val['filepath'], $val['filename']);
                        }
                    }
                }
            }
        }
        		
		//set email SMTP
		$mail->WordWrap = 50;
		$mail->Host = get_option('smtp_host');
		$mail->Port = get_option('smtp_port');
		$mail->SMTPAuth = true;
		$mail->Username = get_option('smtp_username');
		$mail->Password = decoder(get_option('smtp_password'));
    	$mail->SMTPSecure = get_option('smtp_ssltype');
		if(!$mail->send()) {
			$result = FALSE;
		} else {
			$result = TRUE;
        }
        
	}else if($mailopt == "queue"){
		#header
		$header = $fromname."#".$from;
		if ($replyto) $header .= "#".$replyto;
		if ($cc) $header .= "#".$cc;
		if ($bcc) $header .= "#".$bcc;
        
		$result = sendMailToQueue($to, $subject, $message, $cc, $bcc, $messagetype, $header, $attachment);
    }
    
	if($result == FALSE AND $mailopt != 'queue'){
        $result = sendMailToQueue($to, $subject, $message, $cc, $bcc, $messagetype, $header, $attachment);
    }
    
    return $result;
}

/**
 *
 * Check youtube url
 *
 * @param string $url
 *
 * @return bool
 */
function youtubeChecker($url){
    $result = false;

    if(filter_var($url, FILTER_VALIDATE_URL)){
    
        if ( strpos($url, 'youtube.') != false ) {
            $result = true;
        } elseif ( strpos($url, 'youtu.be') != false ) {
            $result = true;
        }

    }

    return $result;
}

/**
 *
 * get youtube id value
 *
 * @param string $url
 *
 * @return string
 */
function getYoutubeId($url){
    
    if( youtubeChecker($url) ){
        parse_str(parse_url($url, PHP_URL_QUERY), $variables);
        return $variables['v'];
    }
}

/**
 *
 * get variable result
 *
 * @param string $content
 * 
 * @return string
 */
function variable_parser($content=null){
    $ci =& get_instance();

    $result = null;

    if( $content != null ){ 
        $patternlist = $ci->config->load('variables');

        if( is_array_unique($patternlist) ){
            foreach ($patternlist as $pattern => $replace) {
                $content = str_ireplace($pattern,$replace,$content);
            }

            $result = $content;
        }
        
    }
    
    return $result;
}