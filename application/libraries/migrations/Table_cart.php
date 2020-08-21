<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_cart {
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
		$schema = $this->CI->schema->create_table('cart');
        $schema->increments('cartId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('mId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('orderId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('cartSessionId', ['length' => '100']);
        $schema->text('cartData',['type' => 'LONGTEXT']);
        $schema->integer('cartAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('cartModified', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('cartIp', ['length' => '20']);
        $schema->enum('cartStatus', ['onprogress', 'completed']);
        $schema->enum('cartVisitorType', ['member', 'guest']);
        $schema->run();

        // ADD index
        $schema->index('mId');
        $schema->index('orderId');
        $schema->index('storeId');
	}

	public function seeder(){
		
	}

}
