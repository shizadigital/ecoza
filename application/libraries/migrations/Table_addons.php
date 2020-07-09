<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_addons {
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
		$schema = $this->CI->schema->create_table('addons');
        $schema->increments('addonsId');
        $schema->string('addonsName', ['length' => '150']);
        $schema->string('addonsDirName', ['length' => '150']);
        $schema->string('addonsVersion', ['length' => '15']);
        $schema->integer('addonsAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('addonsActive', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->run();
	}

	public function seeder(){
		
	}

}

