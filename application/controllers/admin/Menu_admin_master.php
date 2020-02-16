<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_admin_master extends CI_Controller {

	protected $menu_data = array();

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// load model
		$this->load->model('menu_admin_master_model');

		// start load menu data here
		$queryMenu1 = $this->menu_admin_master_model->getAdminMenuInPage();
		$x=0;
        foreach ($queryMenu1 as $dm1) {
        	$this->menu_data[$x] = $dm1;

            $numnumMenu2 = $this->menu_admin_master_model->rowsAdminMenuInPage($dm1['menuId']);
            if($numnumMenu2>0){
            	$queryMenu2 = $this->menu_admin_master_model->getAdminMenuInPage($dm1['menuId']);

            	$xx=0;
            	foreach ($queryMenu2 as $dm2) {
                	$this->menu_data[$x]['level_2'][$xx] = $dm2;

                	$numnumMenu3 = $this->menu_admin_master_model->rowsAdminMenuInPage($dm2['menuId']);
	                if($numnumMenu3>0){
	                	$queryMenu3 = $this->menu_admin_master_model->getAdminMenuInPage($dm2['menuId']);

	                	$xxx=0;
	                	foreach ($queryMenu3 as $dm3) {
                			$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx] = $dm3;

                			$numnumMenu4 = $this->menu_admin_master_model->rowsAdminMenuInPage($dm3['menuId']);
			                if($numnumMenu4>0){
			                	$queryMenu4 = $this->menu_admin_master_model->getAdminMenuInPage($dm3['menuId']);

			                	$xxxx=0;
			                	foreach ($queryMenu4 as $dm4) {
			                		$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['level_4'][$xxxx] = $dm4;

			                		$xxxx++;
			                	}
			                } else {
			                	$this->menu_data[$x]['level_2'][$xx]['level_3'][$xxx]['level_4'] = array();
			                }

	                		$xxx++;
	                	}
	                } else {
	                	$this->menu_data[$x]['level_2'][$xx]['level_3'] = array();
	                }

                	$xx++;
                }

            } else {
            	$this->menu_data[$x]['level_2'] = array();
            }

            $x++;
        }
		// end load menu data here
	}

	public function index(){
		if( is_view() ){

			$data = array( 
						'title' => 'Menu Admin Master - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => '',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(
											array(
												'title' => 'Tambah',
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('menu_admin_master/tambah'),
												'permission' => 'add'
											)
										),
						'data_menu' => $this->menu_data
					);
			
			$this->load->view( admin_root('menu_admin_master/menu_admin_master_view'), $data );
		}
	}

	public function tambah(){
		if( is_add() ){

			$data = array( 
							'title' => 'Tambah Menu Admin Master - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => 'Tambah Menu Admin Master',
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => 'Kembali',
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('menu_admin_master')
												)
											),
							'data_menu' => $this->menu_data
						);
				
			$this->load->view( admin_root('menu_admin_master/menu_admin_master_add'), $data );
		}
	}

	public function edit($id){
		if( is_edit() ){

			// load data
			$menu = $this->Env_model->view_where('*','users_menu', "menuId='{$id}'");

			$data = array( 
							'title' => 'Edit Menu Admin Master - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => 'Edit Menu Admin Master ' . $menu[0]['menuName'],
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => 'Tambah',
													'icon'	=> 'fe fe-plus',
													'access' => admin_url('menu_admin_master/tambah'),
													'permission' => 'add'
												),
												array(
													'title' => 'Kembali',
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('menu_admin_master')
												)
											),
							'data_menu' => $this->menu_data,
							'data' => $menu[0]
						);
				
			$this->load->view( admin_root('menu_admin_master/menu_admin_master_edit'), $data );
		}
	}

	public function prosestambah(){
		$error = false;
		if( is_add() ){
			if($this->input->post('menu_akses')=='admin_link'){        
		        $CekDataAccess = $this->input->post('aksesmvc');

		        if( empty( $this->input->post('aksesmvc') ) ){
		        	$error = "<strong>Error</strong> Akses MVC tidak boleh kosong";
		        }
		    } elseif($this->input->post('menu_akses')=='out_link'){
		        $CekDataAccess = $this->input->post('outlink');		        

		        if( empty( $this->input->post('outlink') ) ){
		        	$error = "<strong>Error</strong> URL tidak boleh kosong";
		        }
		    } elseif($this->input->post('menu_akses')=='no_link'){
		        $CekDataAccess = "ok";
		    }

		    if( empty($this->input->post('menu_name')) OR empty($CekDataAccess) ){
		        $error = "<strong>Error</strong> Bidang wajib tidak boleh kosong";
		    }

		    $exp_induk = explode("-",$this->input->post('induk'));
    		$levelberikut=$exp_induk[0]+1;

    		if($levelberikut > ADMINMENUDEEPLIMIT ){
		        $error = "<strong>Error</strong> Maaf, Anda hanya dapat membuat menu hingga kedalaman tertentu saja.";
		    }

		    if(!$error){
		    	$menu_name = esc_sql( filter_txt( $this->input->post('menu_name') ) );
		    	$iconmenu = esc_sql( filter_txt( $this->input->post('iconmenu') ) );
		    	$attrclass = esc_sql( filter_txt( $this->input->post('attrclass') ) );
        		$parentMenu	= esc_sql(filter_int($exp_induk[1]));

		    	$dataAccess='';
		    	if($this->input->post('menu_akses')=='admin_link'){
			        $aksesmvc = esc_sql( filter_txt( $this->input->post('aksesmvc') ) );

			        //format file name like url permalink but use underscore for separator
			    	$access = slugURL($aksesmvc, array('delimiter'=> '_'));

			        $arrmod = array(
		    			"admin_link" => $access
		    		  );
		    		$dataAccess = serialize($arrmod);
			    } elseif($this->input->post('menu_akses')=='out_link'){
			        $outlink = esc_sql( filter_txt( $this->input->post('outlink') ) );  

			        $arrmod = array(
		    			"out_link" => $outlink
		    		  );
		    		$dataAccess = serialize($arrmod);
			    } elseif($this->input->post('menu_akses')=='no_link'){
			        $dataAccess = "";
			    }

			    $mn_view   = (empty($this->input->post('mn_view'))) ? "n" : "y";
				$mn_add    = (empty($this->input->post('mn_add'))) ? "n" :"y";
				$mn_edit   = (empty($this->input->post('mn_edit'))) ? "n" :"y";
				$mn_hapus = (empty($this->input->post('mn_hapus'))) ? "n" :"y";

			    $nextId = $this->Env_model->getNextId('menuId', 'users_menu');
			    $nextSort = $this->Env_model->nextSort("users_menu","menuSort","menuParentId='{$parentMenu}'");

			    $addDate = time2timestamp();

			    $data = array(
			    	'menuId' => $nextId,
			    	'menuParentId' => (int)$parentMenu,
			    	'menuName' => $menu_name,
			    	'menuAccess' => $dataAccess,
			    	'menuAddedDate' => $addDate,
			    	'menuSort' => (int)$nextSort,
			    	'menuIcon' => (string)$iconmenu,
			    	'menuAttrClass' => (string)$attrclass,
			    	'menuActive' => $this->input->post('aktif'),
			    	'menuView' => $mn_view,
			    	'menuAdd' => $mn_add,
			    	'menuEdit' => $mn_edit,
			    	'menuDelete' => $mn_hapus
			    );

			    // insert data menu here
			    $query = $this->Env_model->insert('users_menu',$data);

			    $infosuccess = '';
			    if($query){
			    	// make file MVC start here

			    	// check MVC access first
			    	if($this->input->post('menu_akses')=='admin_link'){

			    		//format file name like url permalink but use underscore for separator
			    		$filename = slugURL($aksesmvc, array('delimiter'=> '_'));

				    	// make model file
				    	define('MODEL_PATH', APPPATH.'models'.DIRECTORY_SEPARATOR);
				    	$modelfilename = ucwords($filename);
				    	if(!file_exists(MODEL_PATH . $modelfilename.'_model.php')){
				    		// make model content
				    		$filemodel = MODEL_PATH . $modelfilename.'_model.php';
							$modelhandle = fopen ($filemodel, "w");
							$modeldirnamecontent = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');

class {$modelfilename}_model extends CI_model{ 

}\n?>";
							fputs ($modelhandle, $modeldirnamecontent);
							fclose($modelhandle);
				    	}

				    	// make view file
				    	define('VIEW_PATH', APPPATH.'views'.DIRECTORY_SEPARATOR);
				    	define('VIEW_ADMIN_PATH', VIEW_PATH.'admin'.DIRECTORY_SEPARATOR);
				    	$viewdirname = strtolower($filename);
				    	$viewfilename = strtolower($filename);
				    	if(!is_dir(VIEW_ADMIN_PATH . $viewdirname)){

				    		$mkdirview = makeDir(VIEW_ADMIN_PATH . $viewdirname, 0644);
				    		if($mkdirview){

				    			$pagesample = array('view','add','edit');
				    			foreach ($pagesample as $key => $val) {
				    				// make view content
						    		$fileview = VIEW_ADMIN_PATH . $viewdirname . DIRECTORY_SEPARATOR . $viewfilename.'_'.$val.'.php';
									$viewhandle = fopen ($fileview, "w");
									$viewdirnamecontent = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');

/************************************
		Register style (CSS)
************************************/
\$request_css_files = array(
);
\$request_style = \"\";
\$this->assetsloc->reg_admin_style(\$request_css_files,\$request_style);

/*******************************************
		Register Script (JavaScript)
*******************************************/
\$request_script_files = array(
);
\$request_script = \"\";
\$this->assetsloc->reg_admin_script(\$request_script_files,\$request_script);

include V_ADMIN_PATH . \"header.php\";
include V_ADMIN_PATH . \"sidebar.php\";
include V_ADMIN_PATH . \"topbar.php\";

// Your code of view here
 
include V_ADMIN_PATH . \"footer.php\";
?>";
									fputs ($viewhandle, $viewdirnamecontent);
									fclose($viewhandle);
				    			} // end foreach
				    		}
				    	}

				    	// make controller file
				    	define('CONTROLLER_PATH', APPPATH.'controllers'.DIRECTORY_SEPARATOR);
				    	define('CONTROLLER_ADMIN_PATH', CONTROLLER_PATH.'admin'.DIRECTORY_SEPARATOR);
				    	$c_filename = ucwords($filename);
				    	$c_filename_lower = strtolower($c_filename);
				    	if(!file_exists(CONTROLLER_ADMIN_PATH . $c_filename.'.php')){
				    		// make controller content
				    		$file_c = CONTROLLER_ADMIN_PATH . $c_filename.'.php';
							$c_handle = fopen ($file_c, "w");
							$c_dirnamecontent = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');

class {$c_filename} extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		// load helper required
		\$this->load->helper('cookie');
		\$this->load->helper('admin_functions');

		// protect the page
		\$this->adminauth->auth_login();

		// load model
		\$this->load->model('{$filename}_model');
	}

	public function index(){
		if( is_view() ){

			\$data = array( 
						'title' => '{$menu_name} - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' => '{$menu_name}',
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'header_button_action' => array(
											array(
												'title' => 'Tambah',
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('{$c_filename_lower}/tambah'),
												'permission' => 'add'
											)
										),
					);
			
			\$this->load->view( admin_root('{$c_filename_lower}/{$c_filename_lower}_view'), \$data );
		}
	}

	public function tambah(){
		if( is_add() ){
			\$data = array( 
							'title' => '{$menu_name} - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => 'Tambah {$menu_name}',
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => 'Kembali',
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('{$c_filename_lower}')
												)
											),
						);

			\$this->load->view( admin_root('{$c_filename_lower}/{$c_filename_lower}_add'), \$data );
		}
	}

	public function edit(\$id){
		if( is_edit() ){
			\$data = array( 
							'title' => '{$menu_name} - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => 'Edit {$menu_name}',
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'header_button_action' => array(
												array(
													'title' => 'Tambah',
													'icon'	=> 'fe fe-plus',
													'access' => admin_url('{$c_filename_lower}/tambah'),
													'permission' => 'add'
												),
												array(
													'title' => 'Kembali',
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('{$c_filename_lower}')
												)
											),
						);

			\$this->load->view( admin_root('{$c_filename_lower}/{$c_filename_lower}_edit'), \$data );
		}
	}

	public function delete(\$id){
		if( is_delete() ){

		}
	}

}\n?>";
							fputs ($c_handle, $c_dirnamecontent);
							fclose($c_handle);
				    	}

				    	$infosuccess = ', silahkan periksa direktori <code>models/'.ucwords($filename).'_model.php</code>, <code>views/admin/'.strtolower($filename).'/'.strtolower($filename).'_view.php</code>, <code>views/admin/'.strtolower($filename).'/'.strtolower($filename).'_add.php</code>, <code>views/admin/'.strtolower($filename).'/'.strtolower($filename).'_edit.php</code> dan <code>controllers/admin/'.ucwords($filename).'.php</code>';
			    	}
			    }

			    $this->session->set_flashdata( 'sukses', 'Data berhasil ditambah'.$infosuccess );
		    	redirect( admin_url('menu_admin_master/edit/'.$nextId) );
		    }

		    if($error){
		    	$this->session->set_flashdata( 'gagal', $error );
		    	redirect( admin_url('menu_admin_master/tambah') );
		    }
		}
	}

	public function prosesedit($id){
		$error = false;
		if( is_edit() ){
		    if( empty($this->input->post('menu_name')) ){
		        $error = "<strong>Error</strong> Bidang wajib tidak boleh kosong";
		    }

		    $exp_induk = explode("-",$this->input->post('induk'));
    		$levelberikut=$exp_induk[0]+1;

    		if($levelberikut > ADMINMENUDEEPLIMIT ){
		        $error = "<strong>Error</strong> Maaf, Anda hanya dapat membuat menu hingga kedalaman tertentu saja.";
		    }

		    if(!$error){
		    	$menu_name = esc_sql( filter_txt( $this->input->post('menu_name') ) );
		    	$iconmenu = esc_sql( filter_txt( $this->input->post('iconmenu') ) );
		    	$attrclass = esc_sql( filter_txt( $this->input->post('attrclass') ) );
        		$parentMenu	= esc_sql(filter_int($exp_induk[1]));

			    $mn_view   = (empty($this->input->post('mn_view'))) ? "n" : "y";
				$mn_add    = (empty($this->input->post('mn_add'))) ? "n" :"y";
				$mn_edit   = (empty($this->input->post('mn_edit'))) ? "n" :"y";
				$mn_hapus = (empty($this->input->post('mn_hapus'))) ? "n" :"y";

			    $data = array(
			    	'menuParentId' => (int)$parentMenu,
			    	'menuName' => $menu_name,
			    	'menuIcon' => (string)$iconmenu,
			    	'menuAttrClass' => (string)$attrclass,
			    	'menuActive' => $this->input->post('aktif'),
			    	'menuView' => $mn_view,
			    	'menuAdd' => $mn_add,
			    	'menuEdit' => $mn_edit,
			    	'menuDelete' => $mn_hapus
			    );

			    // insert data menu here
			    $query = $this->Env_model->update( 'users_menu', $data, array("menuId"=>$id) );

			    if($query){
			    	$this->session->set_flashdata( 'sukses', 'Data berhasil ditambah');
			    } else {
			    	$this->session->set_flashdata( 'gagal', 'Data gagal disimpan' );
			    }
		    }

		    if($error){
		    	$this->session->set_flashdata( 'gagal', $error );
		    }
		    redirect( admin_url('menu_admin_master/edit/'.$id) );	
		}
	}

	public function prosesdelete($id){
		if( is_delete() ){
			// get data for remove file
			$datamenunya = $this->Env_model->getval("menuId, menuAccess", "users_menu", "menuId='{$id}'");
			if(!empty($datamenunya['menuAccess'])){
				$arrlink = unserialize($datamenunya['menuAccess']);
                $arrlinkkeys = array_keys($arrlink);

                if($arrlinkkeys[0]=='admin_link'){
                	// remove model file
			    	define('MODEL_PATH', APPPATH.'models'.DIRECTORY_SEPARATOR);
			    	$modelfilename = ucwords($arrlink['admin_link']);
			    	if(file_exists(MODEL_PATH . $modelfilename.'_model.php')){
			    		// remove file
			    		@unlink(MODEL_PATH . $modelfilename.'_model.php');
			    	}

			    	// remove view file
			    	define('VIEW_PATH', APPPATH.'views'.DIRECTORY_SEPARATOR);
			    	define('VIEW_ADMIN_PATH', VIEW_PATH.'admin'.DIRECTORY_SEPARATOR);
			    	$viewdirname = strtolower($arrlink['admin_link']);
			    	$viewfilename = strtolower($arrlink['admin_link']);
			    	if(is_dir( VIEW_ADMIN_PATH . $viewdirname )){

			    		$pagesample = array('view','add','edit');
				    	foreach ($pagesample as $key => $val) {
				    		if(file_exists(VIEW_ADMIN_PATH . $viewdirname . DIRECTORY_SEPARATOR . $viewfilename.'_'.$val.'.php')){
				    			// remove file
				    			@unlink(VIEW_ADMIN_PATH . $viewdirname . DIRECTORY_SEPARATOR . $viewfilename.'_'.$val.'.php');
				    		}
				    	}
				    	@unlink(VIEW_ADMIN_PATH . $viewdirname . DIRECTORY_SEPARATOR . 'index.html');

				    	// remove dir
				    	rmdir (VIEW_ADMIN_PATH . $viewdirname);
			    	}

			    	// remove controller file
			    	// make controller file
			    	define('CONTROLLER_PATH', APPPATH.'controllers'.DIRECTORY_SEPARATOR);
			    	define('CONTROLLER_ADMIN_PATH', CONTROLLER_PATH.'admin'.DIRECTORY_SEPARATOR);
			    	$c_filename = ucwords($arrlink['admin_link']);
			    	if(file_exists(CONTROLLER_ADMIN_PATH . $c_filename.'.php')){
			    		// remove file
			    		@unlink(CONTROLLER_ADMIN_PATH . $c_filename.'.php');
			    	}
                }
			}

			// remove data from database
			$delete = $this->Env_model->delete('users_menu', "menuId='{$id}'" );

			if( $delete ){
				// remove data relationship from database
				$delaccess = $this->Env_model->delete('users_menu_access', "menuId='{$id}'" );
		    	$this->session->set_flashdata( 'sukses', 'Data berhasil dihapus' );
			} else {
		    	$this->session->set_flashdata( 'gagal', 'Data gagal dihapus' );
		    }
		    redirect( admin_url('menu_admin_master') );
		}
	}

	public function updatemenuposition(){
		if( is_edit() ){

			$menuData = json_decode( $this->input->post('menu_data'), true);

			$sort1 = 1;
		    foreach ($menuData as $key1 => $value1) {
		        $query1 = $this->Env_model->update('users_menu', array('menuParentId' => '0', 'menuSort' => $sort1), array('menuId' => $value1['id']));
		        
		        if(!empty($value1['children'])){
		            $sort2 = 1;
		            foreach ($value1['children'] as $key2 => $value2) {
		            	$query2 = $this->Env_model->update('users_menu', array('menuParentId' => $value1['id'], 'menuSort' => $sort2), array('menuId' => $value2['id']));

		                if(!empty($value2['children'])){
		                    $sort3 = 1;
		                    foreach ($value2['children'] as $key3 => $value3) { 
		                    	$query3 = $this->Env_model->update('users_menu', array('menuParentId' => $value2['id'], 'menuSort' => $sort3), array('menuId' => $value3['id']));

		                        if(!empty($value3['children'])){
		                            $sort4 = 1;
		                            foreach ($value3['children'] as $key4 => $value4) {
		                            	$query4 = $this->Env_model->update('users_menu', array('menuParentId' => $value3['id'], 'menuSort' => $sort4), array('menuId' => $value4['id']));
		                                $sort4++;
		                            }
		                        }
		                        $sort3++;
		                    }
		                }
		                $sort2++;
		            }
		        }
		        $sort1++;
		    }

		    $this->session->set_flashdata( 'sukses', 'Data berhasil diperbarui' );
		    redirect( admin_url('menu_admin_master') );

		}
	}

	public function updatepermissionmenu(){
		if( is_edit() ){
			$query = false;
			foreach ($this->input->post('idmn') as $key => $value) {
				$activev = (empty($this->input->post('mn_active')[$value])) ? "n" : $this->input->post('mn_active')[$value];
				$viewv   = (empty($this->input->post('mn_view')[$value])) ? "n" : $this->input->post('mn_view')[$value];
				$addv    = (empty($this->input->post('mn_add')[$value])) ? "n" : $this->input->post('mn_add')[$value];
				$editv   = (empty($this->input->post('mn_edit')[$value])) ? "n" : $this->input->post('mn_edit')[$value];
				$deletev = (empty($this->input->post('mn_delete')[$value])) ? "n" : $this->input->post('mn_delete')[$value];

				$dataupdate = array(
					'menuActive'=> $activev,
					'menuView'	=> $viewv,
					'menuAdd' 	=> $addv,
					'menuEdit' 	=> $editv,
					'menuDelete'=> $deletev
				);

				$query = $this->Env_model->update("users_menu", $dataupdate, array('menuId'=>$value));

				if($query == false){ break; }
			}

			if($query){
				$this->session->set_flashdata( 'sukses', 'Data berhasil diperbarui' );
			} else {
				$this->session->set_flashdata( 'gagal', 'Data gagal diperbarui' );
			}

			redirect( admin_url('menu_admin_master/?tab=atur-izin-menu') );
		}
	}

}
