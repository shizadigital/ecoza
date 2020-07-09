<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_email_queue {
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
		$schema = $this->CI->schema->create_table('email_queue');
        $schema->increments('emailId', ['length' => '11']);
        $schema->string('emailTo', ['length' => '255']);
        $schema->text('emailCC');
        $schema->text('emailBCC');
        $schema->string('emailSubject');
        $schema->text('emailMsg', ['type' => 'MEDIUMTEXT']);
        $schema->enum('emailMsgType', ['text', 'html']);
        $schema->string('emailHead');
        $schema->integer('emailDate', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('emailDateSent', ['length' => '10', 'unsigned' => TRUE]);
        $schema->char('emailStatus', ['length' => '1']);
        $schema->text('emailAttachFile');
        $schema->run();

        // ADD index
        $schema->index('emailTo');
	}

	public function seeder(){
		
	}

}

