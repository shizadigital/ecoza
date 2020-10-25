<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_options_order_status {
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
		$schema = $this->CI->schema->create_table('options_order_status');
        $schema->increments('optorderstatId', ['length' => '11']);
        $schema->string('optorderstatName', ['length' => '150']);
        $schema->enum('optorderstatRuleType', ['pending','shipped','step','completed','returned']);
        $schema->integer('optorderstatDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('optorderstatDeleted');
	}

	public function seeder(){
		$arr = [
            ['optorderstatId' => '1', 'optorderstatName' => 'Pending', 'optorderstatRuleType' => 'pending', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '2', 'optorderstatName' => 'Processing', 'optorderstatRuleType' => 'step', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '3', 'optorderstatName' => 'Shipped', 'optorderstatRuleType' => 'shipped', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '4', 'optorderstatName' => 'Complete', 'optorderstatRuleType' => 'completed', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '5', 'optorderstatName' => 'Canceled', 'optorderstatRuleType' => 'returned', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '6', 'optorderstatName' => 'Denied', 'optorderstatRuleType' => 'returned', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '7', 'optorderstatName' => 'Canceled Reversal', 'optorderstatRuleType' => 'step', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '8', 'optorderstatName' => 'Failed', 'optorderstatRuleType' => 'returned', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '9', 'optorderstatName' => 'Refunded', 'optorderstatRuleType' => 'returned', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '10', 'optorderstatName' => 'Reversed', 'optorderstatRuleType' => 'returned', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '11', 'optorderstatName' => 'Chargeback', 'optorderstatRuleType' => 'step', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '12', 'optorderstatName' => 'Expired', 'optorderstatRuleType' => 'returned', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '13', 'optorderstatName' => 'Processed', 'optorderstatRuleType' => 'step', 'optorderstatDeleted'=>0],
            ['optorderstatId' => '14', 'optorderstatName' => 'Voided', 'optorderstatRuleType' => 'returned', 'optorderstatDeleted'=>0]
        ];
		return $arr;
	}

}

