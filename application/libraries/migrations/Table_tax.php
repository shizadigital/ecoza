<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_tax {
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
		$schema = $this->CI->schema->create_table('tax');
        $schema->increments('taxId', ['length' => '11']);
        $schema->string('taxName', ['length' => '90']);
        $schema->decimal('taxRate', ['length' => '15,4']);
        $schema->enum('taxType', ['percentage', 'fixed']);
        $schema->enum('taxActive', ['y', 'n']);
        $schema->integer('taxAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('taxModified', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('taxDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();
	}

	public function seeder(){
		$arr = [
            ['taxId' => '1', 'taxName' => 'Pajak PPN (10%)', 'taxRate' => '10.0000', 'taxType' => 'percentage', 'taxActive' => 'y', 'taxAdded' => '1593813276', 'taxModified' => '1593813276', 'taxDeleted' => '0']
        ];
		return $arr;
	}

}

