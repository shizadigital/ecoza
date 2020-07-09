<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_product_downloadable {
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
		$schema = $this->CI->schema->create_table('product_downloadable');
        $schema->increments('pdwlId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('pdwlTitle', ['length' => '255']);
        $schema->decimal('pdwlPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->enum('pdwlDownloadType', ['file', 'url']);
        $schema->string('pdwlFileDir', ['length' => '30']);
        $schema->string('pdwlFile', ['length' => '255']);
        $schema->text('pdwlURL');
        $schema->enum('pdwlSampleType', ['file', 'url']);
        $schema->string('pdwlSampleDir', ['length' => '30']);
        $schema->string('pdwlSampleFile', ['length' => '255']);
        $schema->text('pdwlSampleURL');
        $schema->enum('pdwlMaxDownloadType', ['unlimited', 'limited']);
        $schema->integer('pdwlMaxDownload', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('pdwlAddedDate',['length'=>'11', 'unsigned'=>TRUE]);
        $schema->run();

        // ADD index
        $schema->index('prodId');
	}

	public function seeder(){
		
	}

}

