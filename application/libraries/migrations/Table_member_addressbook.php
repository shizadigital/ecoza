<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_member_addressbook {
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
		$schema = $this->CI->schema->create_table('member_addressbook');
        $schema->increments('maddrId', ['length' => '11']);
        $schema->integer('mId', ['length' => '15', 'unsigned' => TRUE]);
        $schema->integer('countryId', ['length' => '15', 'unsigned' => TRUE]);
        $schema->string('maddrLabel', ['length' => '255']);
        $schema->string('maddrReceiveName', ['length' => '255']);
        $schema->string('maddrCompany', ['length' => '255']);
        $schema->text('maddrAddress');
        $schema->string('maddrPostalCode', ['length' => '10']);
        $schema->string('maddrCity', ['length' => '125']);
        $schema->string('maddrHP', ['length' => '20']);
        $schema->enum('maddrPriority', ['primary', 'secondary']);
        $schema->run();

        // ADD index
        $schema->index('mId');
        $schema->index('countryId');
        $schema->index('maddrPriority');
	}

	public function seeder(){
		
	}

}

