<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_users_level {
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

	private $CI;

	public function __construct(){
		$this->CI =& get_instance();

        $this->CI->load->model('mc');
        $this->CI->load->library('Schema');
	}

	public function migrate(){
		$schema = $this->CI->schema->create_table('users_level');
        $schema->increments('levelId', ['length' => '10']);
        $schema->string('levelName');
        $schema->enum('levelActive', ['y', 'n']);
        $schema->run();

        // ADD index
        $schema->index('levelId');
	}

	public function seeder(){
		$arr = [
			['levelName' => 'Super Admin', 'levelActive' => 'y'],
			['levelName' => 'Admin', 'levelActive' => 'y'],
		];
		return $arr;
	}

}

