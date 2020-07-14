<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_order_detail {
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
		$schema = $this->CI->schema->create_table('order_detail');
        $schema->increments('odetId', ['type' => 'BIGINT', 'length' => '35']);
        $schema->integer('orderId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('whId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('pattrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('unitId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('manufactId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('odetCode', ['length' => '25']);
        $schema->string('odetProdSku', ['length' => '65']);
        $schema->string('odetProdManufacture', ['length' => '255']);
        $schema->string('odetProdName', ['length' => '255']);
        $schema->string('odetProdUpc', ['length' => '15']);
        $schema->string('odetProdIsbn', ['length' => '18']);
        $schema->string('odetProdMpn', ['length' => '65']);
        $schema->decimal('odetProdWeight', ['length' => '15,8']);
        $schema->string('odetProdWeightUnit', ['length' => '5']);
        $schema->decimal('odetProdBasicPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('odetProdPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->integer('odetProdTaxId', ['length' => '11', 'unsigned'=>TRUE]);
        $schema->text('odetProdAttributes');
        $schema->string('odetUnitQty', ['length' => '150']);
        $schema->decimal('odetQty', ['length' => '15,8', 'unsigned'=>TRUE]);
        $schema->decimal('odetPricePerunit', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('odetPriceTotal', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('odetProfit', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->integer('odetAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('odetModified', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('orderId');
        $schema->index('whId');
        $schema->index('prodId');
        $schema->index('pattrId');
        $schema->index('unitId');
        $schema->index('odetCode');
	}

	public function seeder(){
		
	}

}

