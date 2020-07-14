<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_payment_gateway {
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
		$schema = $this->CI->schema->create_table('payment_gateway');
        $schema->increments('paymentId', ['length' => '11']);
        $schema->string('paymentGateway', ['length' => '255']);
		$schema->text('paymentSetting');
		$schema->text('paymentValue');
		$schema->integer('paymentSorting', ['type'=>'TINYINT','length' => '2', 'unsigned' => TRUE]);
		$schema->run();
	}

	public function seeder(){
		$arr = [
			['paymentId' => '1', 'paymentGateway' => 'banktransfer', 'paymentSetting' => 'name', 'paymentValue' => 'Bank Transfer', 'paymentSorting' => '1'],
			['paymentId' => '2', 'paymentGateway' => 'banktransfer', 'paymentSetting' => 'type', 'paymentValue' => 'Invoices', 'paymentSorting' => '0'],
			['paymentId' => '3', 'paymentGateway' => 'banktransfer', 'paymentSetting' => 'visible', 'paymentValue' => 'on', 'paymentSorting' => '0'],
			['paymentId' => '4', 'paymentGateway' => 'banktransfer', 'paymentSetting' => 'instructions', 'paymentValue' => '', 'paymentSorting' => '0'],
			['paymentId' => '5', 'paymentGateway' => 'banktransfer', 'paymentSetting' => 'listbank', 'paymentValue' => 'a:2:{s:3:"bni";a:6:{s:8:"bankname";s:3:"BNI";s:4:"desc";s:21:"Bank Negara Indonesia";s:11:"accountname";s:20:"Afrioni Jaya Saputra";s:13:"accountnumber";s:10:"0340169800";s:7:"icondir";s:0:"";s:7:"iconpic";s:0:"";}s:3:"bsm";a:6:{s:8:"bankname";s:3:"BSM";s:4:"desc";s:20:"Bank Syariah Mandiri";s:11:"accountname";s:20:"Afrioni Jaya Saputra";s:13:"accountnumber";s:10:"7070656218";s:7:"icondir";s:0:"";s:7:"iconpic";s:0:"";}}', 'paymentSorting' => '0'],
			['paymentId' => '6', 'paymentGateway' => 'paypal', 'paymentSetting' => 'name', 'paymentValue' => 'PayPal', 'paymentSorting' => '2'],
			['paymentId' => '7', 'paymentGateway' => 'paypal', 'paymentSetting' => 'accountname', 'paymentValue' => 'Afrioni Jaya Saputra', 'paymentSorting' => '2'],
			['paymentId' => '8', 'paymentGateway' => 'paypal', 'paymentSetting' => 'type', 'paymentValue' => 'Invoices', 'paymentSorting' => '2'],
			['paymentId' => '9', 'paymentGateway' => 'paypal', 'paymentSetting' => 'visible', 'paymentValue' => 'off', 'paymentSorting' => '2'],
			['paymentId' => '10', 'paymentGateway' => 'paypal', 'paymentSetting' => 'email', 'paymentValue' => 'memoindomedia@gmail.com', 'paymentSorting' => '2'],
			['paymentId' => '11', 'paymentGateway' => 'paypal', 'paymentSetting' => 'forceonetime', 'paymentValue' => 'on', 'paymentSorting' => '2'],
			['paymentId' => '12', 'paymentGateway' => 'paypal', 'paymentSetting' => 'forcesubscriptions', 'paymentValue' => '', 'paymentSorting' => '2'],
			['paymentId' => '13', 'paymentGateway' => 'paypal', 'paymentSetting' => 'requireshipping', 'paymentValue' => 'on', 'paymentSorting' => '2'],
			['paymentId' => '14', 'paymentGateway' => 'paypal', 'paymentSetting' => 'overrideaddress', 'paymentValue' => 'on', 'paymentSorting' => '2'],
			['paymentId' => '15', 'paymentGateway' => 'paypal', 'paymentSetting' => 'apiusername', 'paymentValue' => 'memoindomedia_api1.gmail.com', 'paymentSorting' => '2'],
			['paymentId' => '16', 'paymentGateway' => 'paypal', 'paymentSetting' => 'apipassword', 'paymentValue' => 'R2QE6GZU6TY9M56X', 'paymentSorting' => '2'],
			['paymentId' => '17', 'paymentGateway' => 'paypal', 'paymentSetting' => 'apisignature', 'paymentValue' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AFtBPMB6l6KjxNafIcHFwDAC3-FC', 'paymentSorting' => '2'],
			['paymentId' => '18', 'paymentGateway' => 'paypal', 'paymentSetting' => 'sandbox', 'paymentValue' => '', 'paymentSorting' => '2'],
			['paymentId' => '19', 'paymentGateway' => 'paypal', 'paymentSetting' => 'convertto', 'paymentValue' => '2', 'paymentSorting' => '2'],
			['paymentId' => '20', 'paymentGateway' => 'paypal', 'paymentSetting' => 'icon', 'paymentValue' => 'a:2:{s:3:"dir";s:0:"";s:3:"pic";s:0:"";}', 'paymentSorting' => '2']
		];
		return $arr;
	}

}

