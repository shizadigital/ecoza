<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_store {
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
		$schema = $this->CI->schema->create_table('store');
        $schema->increments('storeId', ['length' => '11']);
        $schema->string('storeName', ['length' => '40']);
        $schema->string('storeUri', ['length' => '150']);
        $schema->integer('storeAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('storeUpdated', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('storeDefault', ['y', 'n']);
        $schema->enum('storeActive', ['y', 'n']);
        $schema->integer('storeDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeUri');
        $schema->index('storeDefault');
	}

	public function seeder(){

		$uri = (base_url() == 'http://localhost/') ? base_url( basename( getcwd() ) .'/' ):base_url();
		$arr = [
            [
                'storeId' => 1,
                'storeName' => 'My Store',
				'storeUri' => $uri,
                'storeAdded' => time2timestamp(),
                'storeUpdated' => time2timestamp(),
                'storeDefault' => 'y',
                'storeActive' => 'y',
                'storeDeleted' => 0
            ]
		];
		
		return $arr;
	}

}
