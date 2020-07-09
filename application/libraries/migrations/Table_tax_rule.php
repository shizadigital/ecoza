<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_tax_rule {
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
		$schema = $this->CI->schema->create_table('tax_rule');
        $schema->increments('txrId', ['length' => '11']);
        $schema->integer('taxId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('txrBehavior', ['length' => '50']);
        $schema->integer('txrPriority', ['length' => '5']);
        $schema->string('txrDesc', ['length' => '120']);
        $schema->run();

        // ADD index
        $schema->index('taxId');
	}

	public function seeder(){
		
	}

}

