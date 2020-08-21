<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_order_status {
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
		$schema = $this->CI->schema->create_table('order_status');
        $schema->increments('orderstatId', ['type' => 'BIGINT', 'length' => '25']);
        $schema->integer('orderId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('optorderstatId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('orderstatName', ['length' => '150']);
        $schema->integer('orderstatDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('orderstatCurrentStatus', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('orderId');
        $schema->index('optorderstatId');
	}

	public function seeder(){
		
	}

}

