<?php
/**
 * Escapes data query MySQL
 *
 * @param string $sql
 * @return string
 */
function esc_sql( $sql ){
	$ci =& get_instance();
	
	if( !empty( $sql ) )
		return $ci->db->escape_str($sql);
	
}

function _filter( $tag, $value, $html=true ){
	switch( $tag ){
	case'int':
		if (is_numeric ( $value )){
		$r = (int)preg_replace ( '/\D/i', '', $value);
		}
		else {
			$value = ltrim( $value, ';' );
			$value = explode ( ';', $value );
			$r = (int)preg_replace ( '/\D/i', '', $value[0] );
		}
		return $r;
	break;
	case'text':
		/*
		* array(
		* 'string'	=>'1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~`!@#$%^&*()_+,>< .?/:;"\'{[}]|\_-+=',
		* 'type'	=>''
		* );
		*/
		if( !empty( $value['string'] ) ){
			if(!empty($value['type']) && intval( $value['type'] ) == 2){
	        	$r = stripslashes(strip_tags(htmlspecialchars( trim( $value['string'] ), ENT_QUOTES )));
			} else {
				$r = urldecode( $value['string'] );
				$r = stripslashes(strip_tags(htmlspecialchars( trim( $r ), ENT_QUOTES )));
			}
			return $r;
		}
	break;
	case'editor':
	if( !empty( $value ) ){
		$value = preg_replace( '[\']', '\'\'', $value );
		$value = preg_replace( '[\'\'/]', '\'\'', $value );
		return $value;
	}
	break;
	case'post':
	if( !empty( $value ) ){
		return htmlspecialchars(get_magic_quotes_gpc() ? $value : addslashes($value));
	}
	break;
	case'clear':
	if( !empty( $value ) ){
		return preg_replace( '/[!"\#\$%\'\(\)\?@\[\]\^`\{\}~\*\/]/', '', $value );
	}
	break;
	case'clean':
	if( !empty( $value ) ){
		$value = preg_replace( "'<script[^>]*>.*?</script>'si", '', $value );
        $value = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $value );
        $value = preg_replace( '/<!--.+?-->/', '', $value );
        $value = preg_replace( '/{.+?}/', '', $value );
        $value = preg_replace( '/&nbsp;/', ' ', $value );
        $value = preg_replace( '/&amp;/', ' ', $value );
        $value = preg_replace( '/&quot;/', ' ', $value );		
		$value = preg_replace( '[\']', '&#039;', $value );
		$value = preg_replace( '/&#039;/', '\'\'', $value );
        $value = strip_tags( $value );
        $value = preg_replace("/\r\n\r\n\r\n+/", " ", $value);
        $value = $html ? htmlspecialchars( $value ) : $value;
        return $value;
	}
	break;
	}
}

function filter_int( $value )	{ 	return _filter('int',$value); }
function filter_txt( $value )	{ 	return _filter('text',array('string'=>$value)); }
function filter_post( $value )	{ 	return _filter('post',$value); }
function filter_editor( $value ){ 	return _filter('editor',$value); }
function filter_clear( $value )	{ 	return _filter('clear',$value); }
function filter_clean( $value )	{ 	return _filter('clean',$value); }
?>