<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_ons {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}

	/**
	 * Read add ons directory 
	 *
	 * @return array
	 */
	public function readDir(){
		$addons = array();

		$addons_dir = scandir(ADDONS_PATH);
		
		foreach( $addons_dir as $dir) {
			if ($dir == "." OR $dir == ".." OR is_file( ADDONS_PATH.$dir )){ continue; }

			$addons[] =  $dir;
		}

		sort($addons);

		return $addons;
	}

	/**
	 * get add ons info in config file
	 *
	 * @param string $directory
	 * @return array
	 */
	private function includeAddonsInfo($directory=null){

		$info = array();

		if($directory==null){
			$dirfile = $this->readDir();

			if( count($dirfile) > 0 ){

				foreach( $dirfile as $dir) {
					if(file_exists( ADDONS_PATH.$dir.DIRECTORY_SEPARATOR.'config.php') ){
						$info[$dir] =  include(ADDONS_PATH.$dir.DIRECTORY_SEPARATOR.'config.php');
					}
				}
			}
		} else {
			if(file_exists( ADDONS_PATH.$directory.DIRECTORY_SEPARATOR.'config.php') ){
				$info =  include(ADDONS_PATH.$directory.DIRECTORY_SEPARATOR.'config.php');
			}
		}

		return $info;

	}

	/**
	 * validation information valiable in config file
	 *
	 * @param string $directory_addons
	 * @return boolean
	 */
	public function infoValidation($directory_addons){
		$valid = false;

		$dirfile = $this->includeAddonsInfo($directory_addons);

		if( count($dirfile) > 0 ){

			$haystack = [
				'ADDONS_NAME', 
				'ADDONS_DESCRIPTION',
				'ADDONS_VERSION_NAME',
				'ADDONS_VERSION_CODE',
				'ADDONS_AUTHOR',
				'ADDONS_AUTHOR_URL',
				'ADDONS_DOCUMENTATION_URL',
				'ADDONS_MENU_NUMBER',
				'ADDONS_MENU_CHILD_IN', 
				'ADDONS_PRIVILEGE'
			];

			foreach( $haystack as $info ) {
				if ( in_array( $info, array_keys($dirfile) ) ){ $valid = true; } else { $valid = false; break; }
			}

		}

		return $valid;

	}

	/**
	 * get information for some add on
	 *
	 * @param string $directory_addons
	 * @return array
	 */
	public function getAddonsInfo( $directory_addons ){
		$result = array();
		if( $this->infoValidation($directory_addons) ){
			$result = $this->includeAddonsInfo($directory_addons);
		}

		return $result;
	}

	/**
	 * get information for all add ons
	 * 
	 * @return array
	 */
	public function getAllAddonsInfo(){
		$result = array();

		if( count($this->includeAddonsInfo())>0 ){
			foreach( array_keys($this->includeAddonsInfo()) as $key){
				if( $this->infoValidation($key) ){
					$result[$key] = $this->includeAddonsInfo($key);
				}
			}
		}

		return $result;
	}


}
