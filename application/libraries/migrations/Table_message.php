<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_message {
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
		$schema = $this->CI->schema->create_table('message');
        $schema->increments('msgId', ['length' => '11']);
        $schema->integer('msgReplyId', ['length' => '15', 'unsigned' => TRUE]);
        $schema->string('msgName', ['length' => '150']);
        $schema->string('msgEmail');
        $schema->string('msgEmailSent');
        $schema->string('msgTlp', ['length' => '60']);
        $schema->text('msgContent');
        $schema->string('msgTime', ['length' => '11']);
        $schema->string('msgDay', ['length' => '10']);
        $schema->enum('msgStatus', ['new', 'old']);
        $schema->string('msgStatusPesan', ['length' => '10']);
        $schema->run();

        // ADD index
        $schema->index('msgId');
        $schema->index('msgReplyId');
	}

	public function seeder(){
		
	}

}

