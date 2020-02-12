<?php 

if(!function_exists('fieldError')){
    /**
     * field validation when page receiving response
     *
     * @param  string $name
     * @return string
     */
    function fieldError($name){
        return view('admin.errors.form.field_error', compact('name'))->render();
    }
}

if(!function_exists('alertShow')){
    /**
     * field validation when page receiving response
     *
     * @param  string $name
     * @return string
     */
    function alertShow($session, $type){

        switch ($type) {
            case 'success':
                if($messageSuccess = $session) {
                    echo '<div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">';
                        echo '<strong>'. $messageSuccess . '</strong>';
                    echo '</div>';
                }
                break;
            case 'failed':
                if($messageError = $session) {
                    echo '<div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">';
                        echo '<strong>'. $messageError . '</strong>';
                    echo '</div>';
                }
                break;
        }
    }
}

if(!function_exists('bc')){
    function bc($menus){
        echo '<div class="col-md-12 breadcrumb">';
        foreach($menus AS $menu) {
            if(isset($menu['url'])) {
                echo '<li class="breadcrumb-item"><a href="'.$menu['url'].'">'.$menu['label'].'</a></li>';
            } else {
                echo '<li class="breadcrumb-item active">'.$menu['label'].'</li>';
            }
        }
        echo '</div>';
    }
}

if(!function_exists('setSession')){
    function setSession($sess_name, $sess_data){

        $dataUser = json_encode($sess_data);
        $dataUserEncrypt = Crypt::encryptString($dataUser);
        
        \Session::put($sess_name, $dataUserEncrypt);
    }
}

if(!function_exists('getSession')){
    function getSession($sess_name, $only_session = false){
        $sessGet = \Session::get($sess_name);
        if($only_session) return $sessGet;

        $sessDecrypt = \Crypt::decryptString($sessGet);
        $sess = json_decode($sessDecrypt);
        
        return $sess;
    }
}

/*
*
* encoder decoder start here
*
*/
if(!function_exists('encoder')){
    /**
     * encode variable value
     *
     * @param  string $str
     * @return string
     */
    function encoder($str){
        $AUTH_SALT = Config::get('shiza.authcode.AUTH_SALT');
        $cipher = Config::get('app.cipher'); //AES-256-CBC

        $iv = substr(hash('sha256', $AUTH_SALT), 0, 16); 
        $encrypted = openssl_encrypt($str, $cipher, $AUTH_SALT, 0, $iv);

        $encrypted = base64_encode($encrypted);
        return urlencode(trim($encrypted));
    }
}
if(!function_exists('decoder')){
    /**
     * decode variable value
     *
     * @param  string $str
     * @return string
     */
    function decoder($str){
        $AUTH_SALT = Config::get('shiza.authcode.AUTH_SALT');
        $cipher = Config::get('app.cipher'); //AES-256-CBC

        if(preg_match('/%/', $str)){
            $str = urldecode(trim($str));
        }
        $str = base64_decode($str);
    
        $iv = substr(hash('sha256', $AUTH_SALT), 0, 16);
        $decrypted = openssl_decrypt($str, $cipher, $AUTH_SALT, 0, $iv);
    
        return trim($decrypted);
    }
}

/*
*
* encoder decoder end here
*
*/

/*
*
* option function start here
*
*/

if(!function_exists('check_option')){
    /**
     * check options value from DB if exist
     *
     * @param  string $optname
     * @return bool 
     */
    function check_option($optname){
        return DB::table('options')->where('optName', $optname)->exists();
    }
}

if(!function_exists('get_option')){
    /**
     * get options value
     *
     * @param  string $optname
     * @return string of database array and bool if not true
     */
    function get_option($optname){
        $result = false;
        if( check_option($optname) ){
            $result = DB::table('options')
                                ->select('optValue')
                                ->where('optName', $optname)
                                ->first();
            $result = $result->optValue;
        }
        return $result;
    }
}

if(!function_exists('set_option')){
    /**
     * update options value
     *
     * @param  string $optname, string $value
     * @return result of database update and bool if not true
     */
    function set_option($option, $value = ''){
        $result = false;
        if( check_option($option) ){
            $result = DB::table('options')
                        ->where('optName', $option)
                        ->update('optValue',$value);
        }
        return $result;
    }
}

if(!function_exists('add_option')){
    /**
     * get options value
     *
     * @param  string $optname, string $value
     * @return result of database insert and bool if not true
     */
    function add_option($option, $value = ''){
        $result = false;
        if( !check_option($option) ){
            $result = DB::table('options')->insert(
                [
                    'optName' => $option,
                    'optValue' => $value
                ]
            );
        }
        return $result;
    }
}

if(!function_exists('delete_option')){
    /**
     * get options value
     *
     * @param  string $optname, string $value
     * @return result of database delete and bool if not true
     */
    function delete_option($option){
        $result = false;
        if( check_option($option) ){
            $result = DB::table('options')->where('optName', $option)->delete();
        }
        return $result;
    }
}

if(!function_exists('get_social_value')){
    /**
     * get options value
     *
     * @param  string $optname, string $value
     * @return string of array and bool if not true
     */
    function get_social_value($social=''){
        $result = false;

        if( check_option('socialmediaurl') ){
            $social_val_opt = get_option('socialmediaurl');

            $array_social_url = unserialize($social_val_opt);

            if(!empty($social_val_opt)){
                $result = ( empty($array_social_url[$social]) ) ? '' : $array_social_url[$social];
            }
        }
        return $result;
    }
}


/*
*
* option function end here
*
*/

if(!function_exists('generate_code')){
    /**
     * generetae random code
     *
     * @param  int $length, bool $unique_char, string $type
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
}

if(!function_exists('generate_code')){
    /**
     * Convert convert size in bytes to human readable
     *
     * @param  int  $size
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
}