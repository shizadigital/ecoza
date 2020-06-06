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
function is_view($menuid=null){ 
    if(empty($menuid)){
        return get_permission_access('view');
    } else {
        $ci =& get_instance();
        $leveluser = $ci->session->userdata('leveluser');
        return $ci->Adminenv_model->permissionMenuAccess($menuid, $leveluser, 'view');
    }
}
function is_add($menuid=null){ 
    if(empty($menuid)){
        return get_permission_access('add');
    } else {
        $ci =& get_instance();
        $leveluser = $ci->session->userdata('leveluser');
        return $ci->Adminenv_model->permissionMenuAccess($menuid, $leveluser, 'add');
    }
}
function is_edit($menuid=null){
    if(empty($menuid)){
        return get_permission_access('edit');
    } else {
        $ci =& get_instance();
        $leveluser = $ci->session->userdata('leveluser');
        return $ci->Adminenv_model->permissionMenuAccess($menuid, $leveluser, 'edit');
    }
}
function is_delete($menuid=null){
    if(empty($menuid)){
        return get_permission_access('delete');
    } else {
        $ci =& get_instance();
        $leveluser = $ci->session->userdata('leveluser');
        return $ci->Adminenv_model->permissionMenuAccess($menuid, $leveluser, 'delete');
    }
}

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

//------------------------------------
//
// TRANSLATE FEATURE
//
//------------------------------------

/**
 *
 * get admin locale code
 * 
 * @param bool
 * 
 * @return string
 */
function getAdminLocaleCode($short = TRUE){
    $ci =& get_instance();

    // load cookie helper
    $ci->load->helper('cookie');
    
    $locale = $ci->config->item('language');

    if( empty( $ci->session->userdata('username') ) AND empty( $ci->session->userdata('passuser') ) ){
        $locale = $locale;
    } else {
        if( !empty( get_cookie('admin_lang') ) ){
            $locale = get_cookie('admin_lang');
		}
    }    
    
    if( $short === TRUE ) { $result = $locale;}
    else { $result = explode("_",  $locale )[0]; }
    
    return $result;
}

/**
 * Check dynamic translator data
 * 
 * @param string $db_table
 * @param string $relid
 * @param string $db_field
 * @param string $lang
 * 
 * @return int|bool
 */
function translate_datacheck($db_table, $relid, $db_field='', $lang='' ){
	$fieldDB = '';
	if(!empty($db_field)){
		$fieldDB = " AND dtRelatedField='{$db_field}'";
	}

	$langDB = '';
	if(!empty($lang)){
		$langDB = " AND dtLang='{$lang}'";
	}

	$datacount = countdata("dynamic_translations", "dtRelatedTable='{$db_table}' AND dtRelatedId='{$relid}'".$fieldDB.$langDB);

	if($datacount > 0){
		$result = $datacount;
	} else {
		$result = FALSE;
	}

	return $result;
}

/**
 * Remove dynamic translator data
 * 
 * @param string $db_table
 * @param string $relid
 * @param string $db_field
 * 
 * @return int|bool
 */
function translate_removedata($db_table, $relid, $db_field='' ){
    $ci =& get_instance();

	$fieldtable = '';
	if(!empty($db_field)){
		$fieldtable = " AND dtRelatedField='{$db_field}'";
	}

	$checking = translate_datacheck($db_table, $relid, $db_field );

	$result = true;
	if( $checking ):
		$clause = "dtRelatedTable='{$db_table}' AND dtRelatedId='{$relid}'".$fieldtable;
		$result  = $ci->Env_model->delete("dynamic_translations",$clause);

	endif;

	return $result;
}

/**
 * Remove dynamic translator data
 * 
 * @param string $db_table
 * @param string $relid
 * @param string $db_field
 * 
 * @return int|bool
 */
function translate_pushdata($inputname, $db_table, $db_field, $relid ){
    $ci =& get_instance();

    $result = '';
    $datapostlang = $ci->input->post('datalang');

	if(isset($datapostlang[$inputname]) AND count($datapostlang[$inputname]) > 0):

		foreach ($datapostlang[$inputname] as $key => $value) {

			if( empty($value['translation']) ){ continue; }
			
			$lang = $key;

			$type = $value['InputType'];

			$translation = $value['translation'];
			if($type=='text'){
				$translation = filter_txt($value['translation']);
			} elseif($type=='texteditor'){
				$translation = $value['translation'];
			} elseif($type=='textarea'){
				$translation = $value['translation'];
			}

			$checking = translate_datacheck($db_table, $relid, $db_field, $lang );

			if( $checking > 0 ){
				if( empty($translation) ){
					$clause = "dtRelatedTable='{$db_table}' AND dtRelatedField='{$db_field}' AND dtRelatedId='{$relid}'";
					translate_removedata( $db_table, $relid, $db_field );
				} else {

					$data = array(
						'dtTranslation'	=> esc_sql($translation),
						'dtInputType' 	=> $type,
						'dtUpdateDate' 	=> time2timestamp()
					);

					$result = $ci->Env_model->update("dynamic_translations",$data,"dtRelatedTable='{$db_table}' AND dtRelatedField='{$db_field}' AND dtRelatedId='{$relid}' AND dtLang='{$lang}'");

				}
			} else {
				$nextid = getNextId('dtId','dynamic_translations');
				$data = array(
					'dtId' 				=> (int)$nextid,
					'dtRelatedTable' 	=> $db_table,
					'dtRelatedField' 	=> $db_field,
					'dtRelatedId' 		=> $relid,
					'dtLang' 			=> $lang,
					'dtTranslation' 	=> esc_sql($translation),
					'dtInputType' 		=> $type,
					'dtCreateDate' 		=> time2timestamp(),
					'dtUpdateDate' 		=> time2timestamp()
				);

				$result = $ci->Env_model->insert("dynamic_translations",$data);
			}
		}
	else :
		$countdata = translate_datacheck($db_table, $relid, $db_field );

		if( $countdata ){
			$clause = "dtRelatedTable='{$db_table}' AND dtRelatedField='{$db_field}' AND dtRelatedId='{$relid}'";
			translate_removedata( $db_table, $relid, $db_field );
		} 
		
	endif;

	return $result;
}