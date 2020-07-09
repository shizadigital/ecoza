<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate {
    
    protected $CI;
    
    public function __construct(){
        $this->CI =& get_instance();
	}
	
	public function create_file($dbname = null){

		if($dbname != null){
			$dbname = strtolower($dbname);

			$migrationlocation = APPPATH . 'libraries/migrations/';
			if( !is_dir($migrationlocation)) {
				makeDir($migrationlocation,0755);
			}

			$makefile = 'Table_'. $dbname;
			$file = $migrationlocation . $makefile.'.php';

			if(is_file($file)){

				echo "\n".'Sorry,, File '.$makefile.'.php is already exist ^_^'."\n\n";exit;

			} else {
				$viewhandle = fopen ($file, "w");
				$viewdirnamecontent = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');

class Table_{$dbname} {
	/**
	 * !!! CAUTION !!!
	 * 
	 * Don't change the table name and class name because to important to seeder system
	 * 
	 * if you want to change the table name, copy your script code in this file
	 * remove this file with this bash 
	 * 
	 * php index.php Migration remove {table name}
	 * 
	 * then create new database with migration bash and paste you code before
	 */

	private \$CI;

	public function __construct(){
		\$this->CI =& get_instance();

        \$this->CI->load->model('mc');
        \$this->CI->load->library('Schema');
	}

	public function migrate(){
		\$schema = \$this->CI->schema->create_table('{$dbname}');
        \$schema->integer('added', ['length' => '11', 'unsigned' => TRUE]);
		\$schema->integer('modified', ['length' => '11', 'unsigned' => TRUE]);
		\$schema->run();
	}

	public function seeder(){
		\$arr = [
			['added' => '".time2timestamp()."', 'modified' => '".time2timestamp()."'],
		];
		return \$arr;
	}

}

";
				fputs ($viewhandle, $viewdirnamecontent);
				fclose($viewhandle);
			}

			return true;
		}

	}

}
