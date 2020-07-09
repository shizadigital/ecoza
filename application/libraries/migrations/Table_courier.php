<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_courier {
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
		$schema = $this->CI->schema->create_table('courier');
        $schema->increments('courierId', ['length' => '11']);
        $schema->integer('addonsId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('courierName', ['length' => '100']);
        $schema->string('courierCode', ['length' => '20']);
        $schema->text('courierUrlTracking');
        $schema->integer('lengthId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->decimal('courierMaxLength', ['length' => '15,8']);
        $schema->decimal('courierMaxWidth', ['length' => '15,8']);
        $schema->decimal('courierMaxHeight', ['length' => '15,8']);
        $schema->decimal('courierMaxWeight', ['length' => '15,8']);
        $schema->integer('weightId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('courierDirLogo', ['length' => '35']);
        $schema->string('courierFileLogo', ['length' => '255']);
        $schema->enum('courierFreeShipping', ['y', 'n']);
        $schema->integer('courierStatus', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->integer('courierAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('courierDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('courierCode');
        $schema->index('courierStatus');
        $schema->index('courierDeleted');
        $schema->index('lengthId');
        $schema->index('weightId');
	}

	public function seeder(){
		
	}

}

