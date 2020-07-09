<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_comments {
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
		$schema = $this->CI->schema->create_table('comments');
        $schema->increments('commentId', ['type' => 'BIGINT', 'length' => '20']);
        $schema->integer('relatedId', ['type' => 'BIGINT', 'length' => '20', 'unsigned' => TRUE]);
        $schema->integer('commentParentId', ['type' => 'BIGINT', 'length' => '20', 'unsigned' => TRUE]);
        $schema->string('commentContentType', ['length' => '25']);
        $schema->string('commentAuthor');
        $schema->string('commentEmail');
        $schema->string('commentWeblog');
        $schema->text('commentComment');
        $schema->string('commentDay', ['length' => '11']);
        $schema->time('commentHour');
        $schema->date('commentDate');
        $schema->string('commentTimestamp', ['length' => '10']);
        $schema->string('commentIp', ['length' => '25']);
        $schema->string('commentApproved', ['length' => '20']);
        $schema->run();

        // ADD index
        $schema->index('relatedId');
        $schema->index('commentParentId');
	}

	public function seeder(){
		
	}

}

