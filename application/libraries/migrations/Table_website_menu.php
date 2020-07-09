<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_website_menu {
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
		$schema = $this->CI->schema->create_table('website_menu');
        $schema->increments('menuId', ['length' => '10']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('menuParentId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('menuRelationshipId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('menuName');
        $schema->string('menuAccessType', ['length' => '50']);
        $schema->text('menuUrlAccess');
        $schema->integer('menuAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('menuSort', ['type' => 'MEDIUMINT','length' => '11', 'unsigned' => TRUE]);
        $schema->enum('menuActive', ['y', 'n']);
        $schema->string('menuAttrClass');
        $schema->run();

        // ADD index
        $schema->index('storeId');
        $schema->index('menuParentId');
        $schema->index('menuRelationshipId');
	}

	public function seeder(){
		
	}

}

