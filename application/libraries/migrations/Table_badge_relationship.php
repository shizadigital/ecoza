<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_badge_relationship {
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
		$schema = $this->CI->schema->create_table('badge_relationship');
        $schema->increments('bdgrelId', ['length' => '11']);
        $schema->integer('badgeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('relatedId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('bdgrelType', ['length' => '50']);
        $schema->run();

        // ADD index
        $schema->index('badgeId');
        $schema->index('relatedId');
        $schema->index('bdgrelType');
	}

	public function seeder(){
		
	}

}

