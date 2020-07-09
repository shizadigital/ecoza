<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_product_attribute {
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
		$schema = $this->CI->schema->create_table('product_attribute');
        $schema->increments('pattrId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('pimgId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->decimal('pattrPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('pattrQty', ['length' => '15,8']);
        $schema->enum('pattrQtyType', ['unlimited', 'limited']);        
        $schema->decimal('pattrWeight', ['length' => '15,8']);
        $schema->string('pattrWeightUnit', ['length' => '5']);
        $schema->enum('pattrDefault', ['y', 'n']);
        $schema->integer('pattrAddedDate',['length'=>'11', 'unsigned'=>TRUE]);
        $schema->integer('pattrModifiedDate',['length'=>'11', 'unsigned'=>TRUE]);
        $schema->run();

        // ADD index
        $schema->index('prodId');
        $schema->index('pimgId');
	}

	public function seeder(){
		
	}

}

