<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_badges {
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
		$schema = $this->CI->schema->create_table('badges');
        $schema->increments('badgeId', ['length' => '11']);
        $schema->string('badgeLabel', ['length' => '60']);
        $schema->text('badgeDesc');
        $schema->string('badgeType', ['length' => '60']);
        $schema->string('badgeDir', ['length' => '25']);
        $schema->string('badgePic');
        $schema->integer('badgeActive', ['length' => '3', 'unsigned' => TRUE]);
        $schema->integer('badgeDeleted', ['length' => '10', 'unsigned' => TRUE]);
        $schema->run();
	}

	public function seeder(){
		
	}

}

