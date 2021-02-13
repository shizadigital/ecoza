<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_activity_log {
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
		$schema = $this->CI->schema->create_table('activity_log');
        $schema->increments('logId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
		$schema->string('userLogin', ['length' => '100']);
		$schema->text('logTable');
		$schema->text('logIdMaster');
		$schema->string('logType', ['length' => '100']);
		$schema->text('logDescription');
		$schema->text('logURL');
		$schema->datetime('logDateTime');
		$schema->string('logIP', ['length' => '100']);
		$schema->string('logBrowser', ['length' => '255']);
		$schema->string('logOS', ['length' => '255']);
		$schema->run();

        $schema->index('storeId');
        $schema->index('logTable');
        $schema->index('userLogin');
	}

	public function seeder(){
	}

}

