<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

    protected $CI;
    protected $segment;

    public function __construct(){
        $this->CI =& get_instance();

        $this->segment = trim( strtolower( $this->CI->uri->segment(1) ) );
    }

    protected function get_template(){

    	if( $this->segment != 'migration' ) :
    		
	        $this->CI->load->database();

	        $idstore = 1;
	        if(isset($_SESSION['storeid'])){
	            $idstore = (int) $_SESSION['storeid'];
	        }

	        $this->CI->db->select('optionValue');
	        $this->CI->db->from( $this->CI->db->dbprefix('options') );
	        $this->CI->db->where('storeId', $idstore);
	        $this->CI->db->where('optionName', 'template');
	        $query = $this->CI->db->get();
	        return $query->row()->optionValue;

        endif;
    }

    public function view($view, $vars = array(), $return = FALSE){
        list($path, $_view) = Modules::find($view, $this->_module, 'views/');
        
        if ($path != FALSE) {
            $this->_ci_view_paths = array_merge($this->_ci_view_paths, array($path => TRUE));
            $view = $_view;
        }

        if(!is_admin()){
            // load template view
            $templatedir = FCPATH .'sz_templates/'.$this->get_template().'/views';
            if(file_exists($templatedir) != FALSE){
                $this->_ci_view_paths = array_merge($this->_ci_view_paths, array( $templatedir.'/' =>TRUE));
				$view = $_view;
            }
        }
 
        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => ((method_exists($this,'_ci_object_to_array')) ? $this->_ci_object_to_array($vars) : $this->_ci_prepare_view_vars($vars)), '_ci_return' => $return));
    }

    /** Load a module helper **/
    public function helper($helper = array())
    {
        if (is_array($helper)) return $this->helpers($helper);

        if (isset($this->_ci_helpers[$helper])) return;

        list($path, $_helper) = Modules::find($helper.'_helper', $this->_module, 'helpers/');

        if($this->CI->config->item('admin_slug') != $this->CI->uri->segment(1)){

            $templatedir = FCPATH .'sz_templates/'.$this->get_template();  
            if(file_exists($templatedir.'/helpers/'.$helper.'_helper'.EXT) != FALSE){
                $path = $templatedir.'/helpers/';
            }
        }

        if ($path === FALSE) return parent::helper($helper);

        Modules::load_file($_helper, $path);
        $this->_ci_helpers[$_helper] = TRUE;
        return $this;
    }

    /** Load an array of helpers **/
    public function helpers($helpers = array())
    {
        foreach ($helpers as $_helper) $this->helper($_helper);
        return $this;
    }

    /** Load a module library **/
    public function library($library, $params = NULL, $object_name = NULL)
    {
        if (is_array($library)) return $this->libraries($library);

        $class = strtolower(basename($library));

        if (isset($this->_ci_classes[$class]) && $_alias = $this->_ci_classes[$class])
            return $this;

        ($_alias = strtolower($object_name)) OR $_alias = $class;

        list($path, $_library) = Modules::find($library, $this->_module, 'libraries/');

        if($this->CI->config->item('admin_slug') != $this->CI->uri->segment(1)){

            $templatedir = FCPATH .'sz_templates/'.$this->get_template();  
            if(file_exists($templatedir.'/libraries/'.$library.EXT) != FALSE){
                $path = $templatedir.'/libraries/';
            }
        }

        /* load library config file as params */
        if ($params == NULL)
        {
            list($path2, $file) = Modules::find($_alias, $this->_module, 'config/');
            ($path2) && $params = Modules::load_file($file, $path2, 'config');
        }

        if ($path === FALSE)
        {
            $this->_ci_load_library($library, $params, $object_name);
        }
        else
        {
            Modules::load_file($_library, $path);

            $library = ucfirst($_library);
            CI::$APP->$_alias = new $library($params);

            $this->_ci_classes[$class] = $_alias;
        }
        return $this;
    }

    /** Load an array of libraries **/
    public function libraries($libraries)
    {
        foreach ($libraries as $library => $alias) 
        {
            (is_int($library)) ? $this->library($alias) : $this->library($library, NULL, $alias);
        }
        return $this;
    }

}
