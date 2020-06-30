<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {

	private $located = 0;

	protected function _db_routes(){
		
		/* ============= HACK to get dynamic route from db ==============================*/
		require_once(APPPATH.'config/database'.EXT);
		require_once(BASEPATH."database/DB.php");
		
		$d_b =& DB($db['default'],true);
	
		return $d_b;
	}

    protected function get_template(){
		$DB = $this->_db_routes();

        $idstore = 1;
        if(isset($_SESSION['storeid'])){
            $idstore = (int) $_SESSION['storeid'];
		}

        $DB->select('optionValue');
        $DB->from( $DB->dbprefix('options') );
        $DB->where('storeId', $idstore);
        $DB->where('optionName', 'template');
        $query = $DB->get();
        return $query->row()->optionValue;
    }

	/** Locate the controller **/
	public function locate($segments)
	{
		$this->located = 0;
		$ext = $this->config->item('controller_suffix').EXT;

		/* use module route if available */
		if (isset($segments[0]) && $routes = Modules::parse_routes($segments[0], implode('/', $segments)))
		{
			$segments = $routes;
		}

		/* get the segments array elements */
		//list($module, $directory, $controller) = array_pad($segments, 3, NULL);		
		$segmentspad=array_pad($segments, 3, NULL);
		
		$module = $segmentspad[0];
		$directory = $segmentspad[1];
		$controller = $segmentspad[2];
		
		if($this->config->item('admin_slug') == $this->uri->segment(1)){
			/*
			 *
			 * 
			 *  SHIZA ADMIN LOCATE CONTROL FOR CHECK MODULES
			 * 
			 * 
			 */
			if($module == 'admin'){ 			
				$c_module = $directory;
				$c_directory = 'admin';
				
				// create new segments variable for check module
				$c_segments[0] = $c_module;
				$c_segments[1] = $c_directory;
				if( !empty($controller) ){
					$c_segments[2] = $controller;
				}
			} else {
				$c_module = $module;
				$c_directory = $directory;
				$c_segments = $segments;
			}

			/* check modules */
			foreach (Modules::$locations as $location => $offset)
			{
				/* module exists? */
				if (is_dir($source = $location.$c_module.'/controllers/'))
				{
					$this->module = $c_module;
					$this->directory = $offset.$c_module.'/controllers/';

					/* module sub-controller exists? */
					if($c_directory)
					{
						/* module sub-directory exists? */
						if(is_dir($source.$c_directory.'/'))
						{	
							$source .= $c_directory.'/';
							$this->directory .= $c_directory.'/';

							/*
							*
							* 
							*  SHIZA ADMIN LOCATE CONTROL FOR CHECK MODULES
							* 
							* 
							*/
							if($c_directory == 'admin'){

								$this->located = 3;
								return array_slice($segments, 1);

							} else {

								/* module sub-directory controller exists? */
								if($controller)
								{
									if(is_file($source.ucfirst($controller).$ext))
									{
										$this->located = 3;
										return array_slice($c_segments, 2);
									}
									else { $this->located = -1; }
								}

							}
						}
						else {
							if(is_file($source.ucfirst($c_directory).$ext))
							{
								$this->located = 2;
								return array_slice($c_segments, 1);
							}
							else { $this->located = -1; }
						}
					}

					/* module controller exists? */
					if(is_file($source.ucfirst($c_module).$ext))
					{
						$this->located = 1;
						return $c_segments;
					}
				}
			}

		}

		if( ! empty($this->directory)) return;

		/* application sub-directory controller exists? */
		if($directory)
		{
			if(is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($directory).$ext))
			{
				$this->directory = $module.'/';
				return array_slice($segments, 1);
			}

			/* application sub-sub-directory controller exists? */
			if($controller)
			{ 
				if(is_file(APPPATH.'controllers/'.$module.'/'.$directory.'/'.ucfirst($controller).$ext))
				{
					$this->directory = $module.'/'.$directory.'/';
					return array_slice($segments, 2);
				}
			}
		}	

		/* application controllers sub-directory exists? */
		if (is_dir(APPPATH.'controllers/'.$module.'/'))
		{
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}

		/* application controller exists? */
		if (is_file(APPPATH.'controllers/'.ucfirst($module).$ext))
		{
			return $segments;
		}

		$templateset = $this->get_template();
		if(is_file(FCPATH.'sz_templates/'.$templateset.'/controllers/'.ucfirst($module).$ext)){
			
			$this->directory = '../../sz_templates/' . $templateset . '/controllers/';
			return $segments;
        }
		
		$this->located = -1;
	}
}
