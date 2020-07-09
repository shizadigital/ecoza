<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_product_attribute_combination {
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
		$schema = $this->CI->schema->create_table('product_attribute_combination');
        $schema->increments('pattrcombId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('pattrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('attrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('attrvalId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('pattrId');
        $schema->index('attrvalId');
        $schema->index('attrId');
	}

	public function seeder(){
		
	}

}

