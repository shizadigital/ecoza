<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_ads_position {
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
		$schema = $this->CI->schema->create_table('ads_position');
        $schema->increments('adposId');
        $schema->string('adposName');
        $schema->integer('adposW', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('adposH', ['length' => '10', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('adposId');
	}

	public function seeder(){
		$arr = [
			['adposName' => 'header', 'adposW' => '650', 'adposH' => '90'],
			['adposName' => 'headline_bottom', 'adposW' => '1000', 'adposH' => '90'],
			['adposName' => 'left_1', 'adposW' => '250', 'adposH' => '250'],
			['adposName' => 'left_2', 'adposW' => '250', 'adposH' => '250'],
			['adposName' => 'left_3', 'adposW' => '250', 'adposH' => '250'],
			['adposName' => 'left_4', 'adposW' => '250', 'adposH' => '250'],
			['adposName' => 'left_5', 'adposW' => '250', 'adposH' => '250'],
			['adposName' => 'left_6', 'adposW' => '250', 'adposH' => '250'],
			['adposName' => 'center_main_1', 'adposW' => '630', 'adposH' => '90'],
			['adposName' => 'center_main_2', 'adposW' => '630', 'adposH' => '90'],
			['adposName' => 'center_main_3', 'adposW' => '630', 'adposH' => '90'],
			['adposName' => 'center_main_4', 'adposW' => '630', 'adposH' => '90'],
			['adposName' => 'center_main_5', 'adposW' => '630', 'adposH' => '90'],
			['adposName' => 'center_main_6', 'adposW' => '630', 'adposH' => '90'],
			['adposName' => 'right_1', 'adposW' => '300', 'adposH' => '250'],
			['adposName' => 'right_2', 'adposW' => '300', 'adposH' => '250'],
			['adposName' => 'right_3', 'adposW' => '300', 'adposH' => '250'],
			['adposName' => 'right_4', 'adposW' => '300', 'adposH' => '250'],
			['adposName' => 'right_5', 'adposW' => '300', 'adposH' => '250'],
			['adposName' => 'right_6', 'adposW' => '300', 'adposH' => '250'],
		];
		return $arr;
	}

}

