<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**--------------------------------------------------------
 * CREATED BY SHIZA
 * --------------------------------------------------------
 * 
 * CREATE NEW MIGRATION
 * 
 * php index.php Migration create {database name}
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

    protected function drop_all() {

        $data = $this->mc->showAllTables();

        // drop database table with prefix setting
        foreach ($data AS $key => $r){
            $table = str_replace($_ENV['DB_PREFIX'], '', $key);

            // drop data
            $this->schema->drop_table($table);
        }
        
    }

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
		if( $dbname !== null ){
			$this->migrate->create_file($dbname);
		}

	}

	/**
	 * install action for migration and seeder
	 *
	 * @param $action
	 * @param $tablename
	 * @return void
	 */
	public function install($action = null, $tablename = null){
        
        if($action == 'seed'){

			if($tablename == null){
				$this->drop_all($tablename);
			} else {
				$this->drop_one($tablename);
			}

			$this->migrate($tablename);
			$this->seed($tablename);

		} else {

			if( $action != null ){
				$tablename = strtolower($action);
				$this->migrate($tablename);

			} else {
				$this->migrate();
			}
		}
    }
	
    // ======= MIGRATE
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

			}
		}

	}
	
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

    // ======= SEED
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

	protected function seeder_action($tablename = null){

		if($tablename!=null){
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

		}

	}


	// ======= REMOVE
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

			}
		}

	}
    
}
