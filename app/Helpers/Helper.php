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
