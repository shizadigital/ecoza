<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_options {
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
		$schema = $this->CI->schema->create_table('options');
        $schema->increments('optionId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('optionName', ['length' => '100']);
        $schema->text('optionValue', ['type' => 'LONGTEXT']);
        $schema->run();

        // ADD index
        $schema->index('optionId');
        $schema->index('storeId');
        $schema->index('optionName');
	}

	public function seeder(){
		$arr = [
            ['optionName' => 'sitename', 'storeId' => 1, 'optionValue' => 'E-Commerce Shiza'],
            ['optionName' => 'sitekeywords', 'storeId' => 1, 'optionValue' => 'framework, ci, codeigniter,shiza,ecommerce,ecoza'],
            ['optionName' => 'sitedescription', 'storeId' => 1, 'optionValue' => 'E-Commerce Shiza diciptakan untuk mempermudah pengguna dalam berjual beli online.'],
            ['optionName' => 'template', 'storeId' => 1, 'optionValue' => 'ogani'],
            ['optionName' => 'timezone', 'storeId' => 1, 'optionValue' => 'Asia/Jakarta'],
            ['optionName' => 'phpminsupport', 'storeId' => 1, 'optionValue' => '7.0.1'],
            ['optionName' => 'siteaddress', 'storeId' => 1, 'optionValue' => 'Jalan Cumi-cumi II No. 6 Kec. Marphoyan Damai - Pekanbaru'],
            ['optionName' => 'robots', 'storeId' => 1, 'optionValue' => 'index,follow'],
            ['optionName' => 'socialmediaurl', 'storeId' => 1, 'optionValue' => 'a:7:{s:8:"facebook";s:33:"https://www.facebook.com/shiza.id";s:7:"twitter";s:0:"";s:7:"youtube";s:0:"";s:9:"instagram";s:34:"https://www.instagram.com/shiza.id";s:4:"line";s:0:"";s:8:"whatsapp";s:0:"";s:10:"googleplay";s:0:"";}'],
            ['optionName' => 'ringkaspost', 'storeId' => 1, 'optionValue' => '197'],
            ['optionName' => 'favicon', 'storeId' => 1, 'optionValue' => ''],
            ['optionName' => 'latitude', 'storeId' => 1, 'optionValue' => ''],
            ['optionName' => 'longitude', 'storeId' => 1, 'optionValue' => ''],
            ['optionName' => 'siteemail', 'storeId' => 1, 'optionValue' => 'info@shiza.id'],
            ['optionName' => 'tagline', 'storeId' => 1, 'optionValue' => 'This is tagline'],
            ['optionName' => 'emailsignature', 'storeId' => 1, 'optionValue' => '-- <br/>Best Regards, <br/>Admin'],
            ['optionName' => 'emailheader', 'storeId' => 1, 'optionValue' => ''],
            ['optionName' => 'httpsmode', 'storeId' => 1, 'optionValue' => 'no'],
            ['optionName' => 'sitephone', 'storeId' => 1, 'optionValue' => '081276540054'],
            ['optionName' => 'smtp_username', 'storeId' => 1, 'optionValue' => 'info@mail.com'],
            ['optionName' => 'smtp_password', 'storeId' => 1, 'optionValue' => 'TFJlbkV3R1BvOUt4Zlg3eWs1VlpOZz09'],
            ['optionName' => 'smtp_host', 'storeId' => 1, 'optionValue' => 'myhostmail.com'],
            ['optionName' => 'smtp_ssltype', 'storeId' => 1, 'optionValue' => 'ssl'],
            ['optionName' => 'smtp_port', 'storeId' => 1, 'optionValue' => '465'],
            ['optionName' => 'productrules', 'storeId' => 1, 'optionValue' => 'a:4:{i:1;a:2:{s:4:"type";s:11:"add_to_cart";s:11:"description";s:16:"add_to_cart_desc";}i:2;a:2:{s:4:"type";s:16:"contact_to_order";s:11:"description";s:21:"contact_to_order_desc";}i:3;a:2:{s:4:"type";s:11:"coming_soon";s:11:"description";s:16:"coming_soon_desc";}i:4;a:2:{s:4:"type";s:8:"sold_out";s:11:"description";s:13:"sold_out_desc";}}'],
            ['optionName' => 'defaultcurrency', 'storeId' => 1, 'optionValue' => 'IDR'],
            ['optionName' => 'multistore', 'storeId' => 1, 'optionValue' => 'off'],
            ['optionName' => 'postalcode', 'storeId' => 1, 'optionValue' => '28000'],
            ['optionName' => 'defaultcodecountry', 'storeId' => 1, 'optionValue' => 'IDN'],
            ['optionName' => 'invoicepaytotext', 'storeId' => 1, 'optionValue' => ''],
            ['optionName' => 'paymentexpired', 'storeId' => 1, 'optionValue' => '3'],
            ['optionName' => 'paymentexpiredremove', 'storeId' => 1, 'optionValue' => '5'],
            ['optionName' => 'invoiceorderformat', 'storeId' => 1, 'optionValue' => 'INV-{NUMBER}'],
            ['optionName' => 'invoiceordernumberstart', 'storeId' => 1, 'optionValue' => '1'],
            ['optionName' => 'invoiceorderduedate', 'storeId' => 1, 'optionValue' => '2'],
            ['optionName' => 'taxstatus', 'storeId' => 1, 'optionValue' => 'y'],
            ['optionName' => 'taxId', 'storeId' => 1, 'optionValue' => '1'],
        ];
		return $arr;
	}

}

