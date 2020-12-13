<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_addons {
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
		$schema = $this->CI->schema->create_table('addons');
        $schema->increments('addonsId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('addonsName', ['length' => '200']);
        $schema->string('addonsDirName', ['length' => '255']);
        $schema->text('addonsDesc');
        $schema->string('addonsVersion', ['length' => '15']);
        $schema->integer('addonsAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('addonsActive', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
		$schema->run();
		
		$schema->index('addonsDirName');
	}

	public function seeder(){
		return [
			[
				'addonsId' => '1',
				'addonsName' => 'Atribut',
				'addonsDirName' => 'attributes',
				'addonsDesc' => 'Product Attributes',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848506',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '2',
				'addonsName' => 'Grup Atribut',
				'addonsDirName' => 'attributes_group',
				'addonsDesc' => 'Attribute Group for manage the attributes',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848508',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '3',
				'addonsName' => 'Kurir',
				'addonsDirName' => 'courier',
				'addonsDesc' => 'Courier for shipping product',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848511',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '4',
				'addonsName' => 'Mata Uang',
				'addonsDirName' => 'currencies',
				'addonsDesc' => 'Pengaturan mata uang untuk berbagai macam kebutuhan harga',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848513',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '5',
				'addonsName' => 'Database',
				'addonsDirName' => 'database',
				'addonsDesc' => 'Pengelolaan database CMS untuk migration seeder',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848515',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '6',
				'addonsName' => 'Geo negara',
				'addonsDirName' => 'geo_country',
				'addonsDesc' => 'Geo Country',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848518',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '7',
				'addonsName' => 'Geo Zona',
				'addonsDirName' => 'geo_zone',
				'addonsDesc' => 'Pengaturan zona daerah',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848520',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '8',
				'addonsName' => 'Satuan Panjang',
				'addonsDirName' => 'length_unit',
				'addonsDesc' => 'Length Unit',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848523',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '9',
				'addonsName' => 'Manufaktur',
				'addonsDirName' => 'manufacturers',
				'addonsDesc' => 'Manufacture for product',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848526',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '10',
				'addonsName' => 'Produk',
				'addonsDirName' => 'product',
				'addonsDesc' => 'Product management',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848529',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '11',
				'addonsName' => 'Lencana Produk',
				'addonsDirName' => 'product_badges',
				'addonsDesc' => 'Fitur lencana produk',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848532',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '12',
				'addonsName' => 'Kategori Produk',
				'addonsDirName' => 'product_categories',
				'addonsDesc' => 'Mengelola kategori produk',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848535',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '13',
				'addonsName' => 'Pajak',
				'addonsDirName' => 'tax',
				'addonsDesc' => 'Pengelolaan pajak',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848538',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '14',
				'addonsName' => 'Rule Pajak',
				'addonsDirName' => 'tax_rule',
				'addonsDesc' => 'Pengelolaan aturan pajak',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848541',
				'addonsActive' => '1'
			],
			[
				'addonsId' => '15',
				'addonsName' => 'Satuan Bobot',
				'addonsDirName' => 'weight_unit',
				'addonsDesc' => 'Pengelolaan satuan bobot',
				'addonsVersion' => '1.0',
				'addonsAdded' => '1607848545',
				'addonsActive' => '1'
			]
		];
	}

}

