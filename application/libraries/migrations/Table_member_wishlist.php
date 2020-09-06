<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_member_wishlist {
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
		$schema = $this->CI->schema->create_table('member_wishlist');
		$schema->increments('wlId',  ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('mId', ['length' => '11', 'unsigned' => TRUE]);
		$schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
		$schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
		$schema->integer('wlAdded', ['length' => '11', 'unsigned' => TRUE]);
		$schema->run();

        // ADD index
        $schema->index('mId');
        $schema->index('prodId');
        $schema->index('storeId');
	}

	public function seeder(){
		
	}

}

