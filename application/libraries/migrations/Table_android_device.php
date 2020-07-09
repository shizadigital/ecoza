<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_android_device {
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
		$schema = $this->CI->schema->create_table('android_device');
        $schema->increments('devId', ['length' => '10']);
        $schema->string('devAndroidId', ['length' => '35']);
        $schema->integer('devAccountId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('devAccountType', ['length' => '25']);
        $schema->string('devRegId');
        $schema->string('devIMEI', ['length' => '35']);
        $schema->string('devName');
        $schema->enum('devStatus', ['on', 'off']);
        $schema->string('devSIMSerial', ['length' => '30']);
        $schema->integer('devLog', ['length' => '10', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('devAndroidId');
        $schema->index('devAccountId');
	}

	public function seeder(){
		
	}

}

