<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_manufacturers {
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
		$schema = $this->CI->schema->create_table('manufacturers');
        $schema->increments('manufactId', ['length' => '11']);
        $schema->string('manufactName',['length' => '255']);
        $schema->text('manufactDesc');
        $schema->string('manufactSlug', ['length' => '255']);
        $schema->string('manufactDir', ['length' => '45']);
        $schema->string('manufactImg', ['length' => '255']);
        $schema->integer('manufactSort', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('manufactActive', ['y','n']);
        $schema->integer('manufactDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('manufactSlug');
        $schema->index('manufactActive');
	}

	public function seeder(){
		
	}

}

