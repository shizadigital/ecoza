<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_courier_cost {
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
		$schema = $this->CI->schema->create_table('courier_cost');
        $schema->increments('ccostId', ['length' => '11']);
        $schema->integer('courierId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('countryId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('zoneId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('ccostService', ['length' => '11', 'unsigned' => TRUE]);
        $schema->decimal('ccostCost', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->integer('ccostETD', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('ccostNote', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('ccostAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('courierId');
        $schema->index('countryId');
        $schema->index('zoneId');
	}

	public function seeder(){
		
	}

}

