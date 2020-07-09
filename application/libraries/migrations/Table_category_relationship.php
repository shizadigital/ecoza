<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_category_relationship {
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
		$schema = $this->CI->schema->create_table('category_relationship');
        $schema->increments('crelId', ['type' => 'BIGINT', 'length' => '20']);
        $schema->integer('catId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('relatedId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('crelRelatedType', ['length' => '25']);
        $schema->run();

        // ADD index
        $schema->index('catId');
        $schema->index('relatedId');
        $schema->index('crelRelatedType');
	}

	public function seeder(){
		
	}

}

