<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**--------------------------------------------------------
 * CREATED BY SHIZA
 * --------------------------------------------------------
 * 
 * CREATE NEW MIGRATION
 * 
 * php index.php Migration create {table name}
 * 
 * --------------------------------------------------------
 * 
 * INSTALL MIGRATION
 * 
 * php index.php Migration install
 * 
 * or
 * 
 * php index.php Migration install {table name}
 * 
 * --------------------------------------------------------
 * 
 * INSTALL MIGRATION WITH SEEDER
 * 
 * php index.php Migration install seed
 * 
 * or 
 * 
 * php index.php Migration install seed {table name}
 * 
 * --------------------------------------------------------
 * 
 * REMOVE MIGRATION
 * 
 * php index.php Migration remove
 * 
 * or 
 * 
 * php index.php Migration remove {table name}
 * 
 */

class Migration extends CI_Controller {

	private $locatemigration;

    function __construct()
    {
        parent::__construct();

        $this->load->model('mc');
		$this->load->library(['Schema','Migrate']);
		
		$this->locatemigration = APPPATH . 'libraries/migrations/';

	}

	/**
	 * drop all tables
	 * 
	 * @return null
	 */
    protected function drop_all() {

        $data = $this->mc->showAllTables();

        // drop database table with prefix setting
        foreach ($data AS $key => $r){
            $table = str_replace(getenv('DB_PREFIX'), '', $key);

            // drop data
            $this->schema->drop_table($table);
        }
        
    }

	/**
	 * drop only one table
	 * 
	 * @return null
	 */
    protected function drop_one($name) {
        $this->schema->drop_table($name);
	}

	/**
	 * Create new file for migration
	 *
	 * @param $dbname
	 * @return void
	 */
	public function create( $dbname = null ){
		// create migration
		if( $dbname !== null ) $this->migrate->create_file($dbname);
	}

	/**
	 * install action for migration and seeder
	 *
	 * @param $action
	 * @param $tablename
	 * @return void
	 */
	public function install($action = null, $tablename = null){
		switch($action) {
			case 'seed':
					if($tablename == null)$this->drop_all();
					else $this->drop_one($tablename);
					$this->migrate($tablename);
					$this->seed($tablename);
				break;
			default: 
				if( $action === null ) $this->migrate();
				else {
					$tablename = strtolower($action);
					$this->migrate($tablename);
				}
				break;

		}
		//
    }
	
	/**
	 * migration for migrate table
	 * 
	 * @param string $tablename
	 * @return null
	 */
	protected function migrate( $tablename = null ){
		if($tablename!=null){
			$filemigration = 'Table_' . strtolower($tablename);
			if( is_file($this->locatemigration.$filemigration.'.php') ){
				$this->migrate_action($tablename);
			} else {
				echo "\n".'Sorry,, File '.$filemigration.'.php is not already exist ^_^'."\n\n";exit;
			}
		} else {
			// install all seeder here
			if( is_dir($this->locatemigration) ){
				$migrationsdir = scandir($this->locatemigration);
				
				foreach ($migrationsdir as $thefile) {
					if ($thefile != "." && $thefile != ".."){
						if( $thefile =='index.html' ){ continue; }
	
						$filename = pathinfo($thefile, PATHINFO_FILENAME );

						$tablename = str_replace("Table_", "", $filename);
						$this->migrate_action($tablename);
					}
				}
				//
			}
			//
		}
		//
	}
	
	/**
	 * migration action for migration
	 * 
	 * @param string $tablename
	 * @return null
	 */
	protected function migrate_action($tablename){

		if($tablename!=null){
			$tablename = strtolower($tablename);
	
			// load library
			$filemigration = 'Table_' . $tablename;
			$this->load->library('migrations/'.$filemigration);
	
			$obj = $filemigration;
			if( method_exists($obj, 'migrate') ){
				// drop table
				$this->drop_one($tablename);
				
				$obj = strtolower($obj);
				$this->$obj->migrate();
			}

		}

	}

	/**
	 * seed for insert data
	 * 
	 * @param string $tablename
	 * 
	 * @return null
	 */
    protected function seed( $tablename = null ) {
		if($tablename !=null){
			$filemigration = 'Table_' . strtolower($tablename);
			if( is_file($this->locatemigration.$filemigration.'.php') ){
				$this->seeder_action($tablename);
			} else {
				echo "\n".'Sorry,, File '.$filemigration.'.php is not already exist ^_^'."\n\n";exit;
			}
		} else {
			// install all seeder here
			if( is_dir($this->locatemigration) ){
				$migrationsdir = scandir($this->locatemigration);
				foreach ($migrationsdir as $thefile) {
					if ($thefile != "." && $thefile != ".."){
						if( $thefile =='index.html' ){ continue; }
	
						$filename = pathinfo($thefile, PATHINFO_FILENAME );

						$tablename = str_replace("Table_", "", $filename);
						$this->seeder_action($tablename);
					}
				}

			}

		}
	}

	/**
	 * seeder action
	 * 
	 * @param string @tablename
	 * @return null
	 */
	protected function seeder_action($tablename = null){
		if($tablename != null){
			$tablename = strtolower($tablename);
			$filemigration = 'Table_' . $tablename;
	
			// load library
			$this->load->library('migrations/'.$filemigration);
	
			$obj = $filemigration;
			if( method_exists($obj, 'seeder') ){	

				$obj = strtolower($obj);
				$dataseeder = $this->$obj->seeder();

				if($dataseeder){
					foreach ( $dataseeder as $item ) {
						$this->mc->save($tablename, $item);
					}
				}
			}
			//
		}
		//
	}

	/**
	 * remove table
	 * 
	 * @param string $tablename
	 * @return null
	 */
	public function remove($tablename = null){
		if($tablename != null){
			$tablename = strtolower($tablename);
			$filemigration = 'Table_' . $tablename;
			if( is_file($this->locatemigration.$filemigration.'.php') ){
				// unlink file
				@unlink( $this->locatemigration.$filemigration.'.php' );

				// drop table
				$this->drop_one($tablename);
			}
		} else {
			// install all seeder here
			if( is_dir($this->locatemigration) ){
				$migrationsdir = scandir($this->locatemigration);
				foreach ($migrationsdir as $thefile) {
					if ($thefile != "." && $thefile != ".."){
						if( $thefile =='index.html' ){ continue; }
	
						$filename = pathinfo($thefile, PATHINFO_FILENAME );

						$tablename = str_replace("Table_", "", $filename);

						// unlink file
						@unlink( $this->locatemigration.$filename.'.php' );

						// drop table
						$this->drop_one($tablename);
					}
				}
				//
			}
		}
		//
	}

	/**
	 * alter table for modify table
	 * 
	 * php index.php Migration alter ${table_name} ~> first init if column didnt't exists
	 * php index.php Migration alter ${table_name} false ~> first init if column didnt't exists all file table migration
	 * php index.php Migration alter ${table_name} refresh ~> if column is exists
	 * php index.php Migration alter ${table_name} drop ~> only drop column without add column
	 * 
	 * @param string $tablename
	 * @return null
	 */
	public function alter($tablename = null, $drop = false) {
		if($tablename !== null && $tablename !== 'false') {
			$filemigration = 'Table_' . strtolower($tablename);
			// only drop without add column
			if($drop === 'drop') $drop = 'drop';
			else $drop = $drop === 'refresh' ? true : false;
	
			if(!is_null($tablename)) {
				$file = $this->locatemigration . $filemigration . '.php';
				if( is_file($file) ) $this->alter_action($tablename, $drop);
				else echo "\n".'Sorry,, File '.$filemigration.'.php is not already exist ^_^'."\n\n";exit;
			} else {
				echo "\n".'Sorry,, File '.$filemigration.'.php is not already exist ^_^'."\n\n";exit;
			}
		} else {
			// install all seeder here
			if( is_dir($this->locatemigration) ){
				$migrationsdir = scandir($this->locatemigration);
				foreach ($migrationsdir as $thefile) {
					if ($thefile != "." && $thefile != ".."){
						if( $thefile =='index.html' ){ continue; }
	
						$filename = pathinfo($thefile, PATHINFO_FILENAME );

						$tablename = str_replace("Table_", "", $filename);
						$this->alter_action($tablename, $drop);
					}
				}

			}
		}
	}

	/**
	 * alter action for modify table
	 * 
	 * @param string $tablename
	 * @return null
	 */
	protected function alter_action($tablename = null, $drop = false) {
		if($tablename != null){
			$tablename = strtolower($tablename);
			$filemigration = 'Table_' . $tablename;
	
			// load library
			$this->load->library('migrations/'.$filemigration);
	
			$obj = $filemigration;
			if( method_exists($obj, 'alter') ){	
				$obj = strtolower($obj);
				$fields = $this->$obj->alter($tablename);
				$schema = $this->schema->create_table($tablename);
				if($drop) {
					foreach($fields AS $field => $value) {
						$schema->drop_column(['table' => $tablename, 'field' => $field]);
					}
				}
				
				if($drop !== 'drop') $schema->add_column([ 'table' => $tablename, 'fields' => $fields ]);
		
				echo 'Successfully alter the table ' . $tablename . PHP_EOL;
			}
			//
		}
		//
	}
    
}
