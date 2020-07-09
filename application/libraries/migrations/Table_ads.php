<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_ads {
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
		$schema = $this->CI->schema->create_table('ads');
        $schema->increments('adsId');
        $schema->integer('adposId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('adsTitle', ['length' => '150']);
        $schema->string('adsUri');
        $schema->text('adsDesc');
        $schema->string('adsType', ['length' => '20']);
        $schema->text('adsCode');
        $schema->text('adsImg');
        $schema->text('adsSwf');
        $schema->string('adsDirFile', ['length' => '25']);
        $schema->date('adsStartDate');
        $schema->date('adsEndDate');
        $schema->integer('adsPublish', ['length' => '3', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('adposId');
	}

	public function seeder(){
		
	}

}

