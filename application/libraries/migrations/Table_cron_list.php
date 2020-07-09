<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_cron_list {
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
		$schema = $this->CI->schema->create_table('cron_list');
        $schema->increments('cronId', ['length' => '10']);
        $schema->string('cronName', ['length' => '50']);
        $schema->text('cronData');
        $schema->string('cronDesc');
        $schema->text('cronDirModule');
        $schema->integer('cronLastAct', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('cronReport');
        $schema->run();
	}

	public function seeder(){
		
	}

}

