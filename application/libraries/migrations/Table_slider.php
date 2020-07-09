<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_slider {
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
		$schema = $this->CI->schema->create_table('slider');
        $schema->increments('slideId', ['length' => '11']);
        $schema->string('slideTitle', ['length' => '150']);
        $schema->string('slideUri');
        $schema->text('slideDesc');
        $schema->string('slideType', ['length' => '20']);
        $schema->string('slideImg');
        $schema->string('slideDirFile', ['length' => '25']);
        $schema->string('slideAnimate', ['length' => '30']);
        $schema->enum('slideOverlay', ['y', 'n']);
        $schema->integer('slidePublish', ['length' => '3', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('slideType');
	}

	public function seeder(){
		
	}

}

