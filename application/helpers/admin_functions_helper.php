<?php 
/*** admin status online ****/
function get_adm_ol_status(){
    $ci =& get_instance();

    $word = '';
    $result = '<span class="ml-1 text-white font-size-12 text-uppercase air__topbar__status badge ';
    // get admin session
    if( !empty( $ci->session->userdata('adminid') ) ){
        $ID = esc_sql( filter_int( $ci->session->userdata('adminid') ) );
        $status = $ci->Adminenv_model->getadminonline($ID);

        
        if( $status->userOnlineStatus == 'online' ){
            $result .= 'bg-success';
        } elseif( $status->userOnlineStatus == 'offline' ){
            $result .= 'bg-secondary';
        } elseif( $status->userOnlineStatus == 'busy' ){
            $result .= 'bg-warning';
        }

        $word = ucwords($status->userOnlineStatus);
        
    } else {
        $result .= 'bg-danger';
        $word = 'Unknown';
    }

    $result .= '">'.$word.'</span>';

    return $result;
}

function update_adm_ol_status($status){
    $ci =& get_instance();

    if( !empty( $ci->session->userdata('adminid') ) ){
        $iduser = $ci->session->userdata('adminid');
        // update status
        return $ci->Adminenv_model->updateadminonline( $iduser, $status);
    } else {
        return false;
    }
}

/**
*
* ADMIN MENU
*
*/

/* checking admin menu child */
function is_adminmenuchild_active( $id ){
    $ci =& get_instance();
    $result = FALSE;

    $countchildmenu = $ci->Adminenv_model->rowAdminMenuChild($id);

    if($countchildmenu > 0){
        $datachild = $ci->Adminenv_model->AdminMenuChild($id);
        foreach ( $datachild as $dcm1) {

            $array_childaccess = unserialize($dcm1['menuAccess']);
            $thechildaccess = '';
            if($array_childaccess['admin_link']){ 
                $thechildaccess = explode('&', $array_childaccess['admin_link'])[0];
            }

            if( ( $ci->uri->segment(2) == $thechildaccess ) AND !empty( $ci->uri->segment(2) ) ){
                $result = TRUE; break;
            }
        }                        
    }

    return $result;
}

/**
*
* Admin Permission Content
*
*/
function get_permission_access($type = ''){
    $result = false;

    if( !empty($type) ){
        $ci =& get_instance();
        $querymodule = $ci->uri->segment(2);
        $datachild = $ci->Adminenv_model->permissionAdminMenu($querymodule,$type);

        $leveluser = $ci->session->userdata('leveluser');

        if( $datachild['status'] == true ){
            $result = $ci->Adminenv_model->permissionMenuAccess($datachild['id'], $leveluser,$type);
        }
    }

    return $result;
}
function is_view(){ return get_permission_access('view'); }
function is_add(){ return get_permission_access('add'); }
function is_edit(){ return get_permission_access('edit'); }
function is_delete(){ return get_permission_access('delete'); }

/**
*
* Upload Favicon
*
*/
function uploadFavicon($filekeyarray, $ext_allowed = array('jpg','jpeg','png','gif','ico') ){
    global $_FILES;
    $error = false;
    $ci =& get_instance();
    $dir = 'favicon';

    $filename = $_FILES[$filekeyarray]['name'];

    if(!empty($filename)):

        $extfilename = strtolower( pathinfo($filename, PATHINFO_EXTENSION) );

        // dir extra with month and year
        $dirextra = date('m').date('Y');

        // check extention
        if( in_array($extfilename, $ext_allowed) ){
            makeDirUpload($dir, $dirextra, 'images');
        } else {
            $error = "<strong>ERROR</strong> Saat ini ekstensi file gambar yang diizinkan adalah \"<code>";
            foreach ($ext_allowed as $extkey => $extvalue) {
                $error .= "*.{$extvalue}, ";
            }
            // Hilangkan , pada loop foreach
            $error .= substr( $error, 0, strlen( $error ) - 2 );
            $error .= "</code>\", silahkan periksa \"izin folder\" atau hubungi webmaster";
        }

        if(!$error){
            // buat nama file baru
            $name           = pathinfo($filename, PATHINFO_FILENAME);
            $nameconv       = str_replace(' ','_',strtolower(trim(preg_replace("/[^a-zA-Z0-9 _]/", '', $name))));
            $codeacak       = substr(md5(uniqid('')),-6,6);
            $filenamebaru   = $codeacak.$dirextra."_".$nameconv.".".$extfilename;

            // buat lokasi folder beserta file
            $dirname = IMAGES_PATH.$dir;
            $diruploadimg = $dirname.DIRECTORY_SEPARATOR.$dirextra.DIRECTORY_SEPARATOR;
            $file_upload    = $diruploadimg . $filenamebaru;

            $extension_allowed = implode("|", $ext_allowed);

            //Simpan gambar dalam ukuran sebenarnya
            $config['upload_path']      = $diruploadimg;
            $config['allowed_types']    = $extension_allowed;
            $config['file_name']        = $filenamebaru;
            $config['overwrite']        = true;
            $config['max_size']         = 200;
            // $config['max_width']        = 90;
            // $config['max_height']       = 90;

            $ci->load->library('upload', $config);
            if( $ci->upload->do_upload($filekeyarray) ) {

                // file after upload data
                $dataupld = $ci->upload->data();

                $config['image_library']  = 'gd2';
                $config['source_image']   = $diruploadimg . $dataupld['file_name'];
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = true;
                $config['width']        = 20;
                $config['height']       = 20;

                $ci->load->library('image_lib', $config);
                $ci->image_lib->initialize($config);
                $ci->image_lib->resize();
                $ci->image_lib->clear();
                
                $newdir = $dir.'/'.$dirextra;
                $arrayarg = array(
                    'filename'      => $filenamebaru,
                    'directory'     => $newdir
                );

                return $arrayarg;

            } else {
                $error = "<strong>ERROR</strong> Favicon gagal di-uploadke server";
                show_error($error, 503,'Upload favicon gagal'); exit;
            }

        } 

        if($error) {
            show_error($error, 503,'Pembuatan directory gagal'); exit;
        }
    endif;
}