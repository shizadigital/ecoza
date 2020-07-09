<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_contents {
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
		$schema = $this->CI->schema->create_table('contents');
        $schema->increments('contentId', ['type' => 'BIGINT', 'length' => '20']);
        $schema->string('contentUsername', ['length' => '150']);
        $schema->text('contentTitle');
        $schema->text('contentPost',['type' => 'LONGTEXT']);
        $schema->string('contentType', ['length' => '25']);
        $schema->string('contentDay', ['length' => '10']);
        $schema->integer('contentDd', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('contentMm', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('contentYy', ['length' => '8', 'unsigned' => TRUE]);
        $schema->date('contentDate');
        $schema->time('contentHour');
        $schema->string('contentTimestamp', ['length' => '11']);
        $schema->datetime('contentDatetime');
        $schema->string('contentAddDate', ['length' => '11']);
        $schema->string('contentSlug');
        $schema->integer('contentRead', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('contentCommentStatus', ['type' => 'TINYINT','length' => '1', 'unsigned' => TRUE]);
        $schema->integer('contentStatus', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->string('contentEditor', ['length' => '100']);
        $schema->string('contentAuthor', ['length' => '100']);
        $schema->string('contentImg');
        $schema->string('contentDirImg', ['length' => '25']);
        $schema->text('contentCaptionImg');
        $schema->integer('contentHeadline', ['length' => '3', 'unsigned' => TRUE]);
        $schema->integer('contentFeature', ['length' => '3', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('contentId');
        $schema->index('contentTimestamp');
        $schema->index('contentStatus');
        $schema->index('contentSlug');
        $schema->index('contentType');
	}

	public function seeder(){
		
	}

}

