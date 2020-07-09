<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_review {
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
		$schema = $this->CI->schema->create_table('review');
        $schema->increments('reviewId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('mId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('reviewRelatedId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('reviewType', ['length' => '20']);
        $schema->text('reviewDesc');
        $schema->integer('reviewValue', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('reviewStatus', ['y', 'n']);
        $schema->integer('reviewAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('reviewUpdatedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('reviewRelatedId');
        $schema->index('reviewType');
	}

	public function seeder(){
		
	}

}

