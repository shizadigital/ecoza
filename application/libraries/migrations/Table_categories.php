<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_categories {
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
		$schema = $this->CI->schema->create_table('categories');
        $schema->increments('catId', ['length' => '11']);
        $schema->string('catName', ['length' => '100']);
        $schema->string('catSlug');
        $schema->text('catDesc');
        $schema->string('catColor', ['length' => '12']);
        $schema->string('catColor', ['length' => '9']);
        $schema->string('catImgDir', ['length' => '35']);
        $schema->integer('catActive', ['length' => '3', 'unsigned' => TRUE]);
        $schema->string('catType', ['length' => '20']);
        $schema->run();

        // ADD index
        $schema->index('catSlug');
        $schema->index('catActive');
        $schema->index('catType');
	}

	public function seeder(){
		$arr = [
			['catId' => '1', 'catName' => 'Main Menu', 'catSlug' => '', 'catDesc' => 'primary', 'catColor' => '', 'catActive' => '1', 'catType' => 'webmenu'],
		];
		return $arr;
	}

}

