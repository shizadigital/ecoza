<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_currency {
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
		$schema = $this->CI->schema->create_table('currency');
        $schema->increments('curId', ['length' => '11']);
        $schema->string('curTitle', ['length' => '30']);
        $schema->string('curCode', ['length' => '5']);
        $schema->string('curPrefixSymbol', ['length' => '12']);
        $schema->string('curSuffixSymbol', ['length' => '12']);
        $schema->decimal('curRate', ['length' => '14,8', 'unsigned'=>TRUE]);
        $schema->decimal('curForeignCurrencyToDefault', ['length' => '14,8', 'unsigned'=>TRUE]);
        $schema->char('curDecimalPlace', ['length' => '1']);
        $schema->integer('curModifiedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('curUpdateMethod', ['automatic', 'manual']);
        $schema->integer('curStatus',  ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('curCode');
        $schema->index('curStatus');
	}

	public function seeder(){
		$arr = [
            [
                'curTitle' => 'Rupiah',
				'curCode' => 'IDR',
				'curPrefixSymbol' => 'Rp',
				'curSuffixSymbol' => '',
				'curRate' => 1.00000000,
				'curForeignCurrencyToDefault' => 1.00000000,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Dollar Amerika',
				'curCode' => 'USD',
				'curPrefixSymbol' => '$',
				'curSuffixSymbol' => '',
				'curRate' => 0.00007173,
				'curForeignCurrencyToDefault' => 13940.50000000,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Ringgit Malaysia',
				'curCode' => 'MYR',
				'curPrefixSymbol' => 'RM',
				'curSuffixSymbol' => '',
				'curRate' => 0.00029496,
				'curForeignCurrencyToDefault' => 3390.26409300,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Dollar Singapura',
				'curCode' => 'SGD',
				'curPrefixSymbol' => '$',
				'curSuffixSymbol' => '',
				'curRate' => 0.00009759,
				'curForeignCurrencyToDefault' => 10246.61901100,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Euro',
				'curCode' => 'EUR',
				'curPrefixSymbol' => '',
				'curSuffixSymbol' => '€',
				'curRate' => 0.00006390,
				'curForeignCurrencyToDefault' => 15650.27737800,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Pound Sterling',
				'curCode' => 'GBP',
				'curPrefixSymbol' => '£',
				'curSuffixSymbol' => '',
				'curRate' => 0.00005758,
				'curForeignCurrencyToDefault' => 17366.98878200,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Baht',
				'curCode' => 'THB',
				'curPrefixSymbol' => '฿',
				'curSuffixSymbol' => '',
				'curRate' => 0.00221236,
				'curForeignCurrencyToDefault' => 452.00649000,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
        ];
		return $arr;
	}

}

