<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_dynamic_translations {
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
		$schema = $this->CI->schema->create_table('dynamic_translations');
        $schema->increments('dtId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->string('dtRelatedTable', ['length' => '20']);
        $schema->string('dtRelatedField', ['length' => '20']);
        $schema->integer('dtRelatedId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('dtLang', ['length' => '10']);
        $schema->text('dtTranslation', ['type' => 'LONGTEXT']);
        $schema->enum('dtInputType', ['text', 'textarea', 'texteditor']);
        $schema->integer('dtCreateDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('dtUpdateDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('dtRelatedTable');
        $schema->index('dtRelatedField');
        $schema->index('dtRelatedId');
	}

	public function seeder(){
		$arr = [
			[
				'dtId' => '1',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '1',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Developer',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583136078',
				'dtUpdateDate' => '1583136078'
			],
			[
				'dtId' => '2',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '2',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Admin Master Menu',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583136102',
				'dtUpdateDate' => '1583136102'
			],
			[
				'dtId' => '3',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '3',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Admin Privilege Menu',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583136126',
				'dtUpdateDate' => '1583136126'
			],
			[
				'dtId' => '4',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '4',
				'dtLang' => 'en_US',
				'dtTranslation' => 'System',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583135990',
				'dtUpdateDate' => '1583135990'
			],
			[
				'dtId' => '5',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '5',
				'dtLang' => 'en_US',
				'dtTranslation' => 'System Info',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583136049',
				'dtUpdateDate' => '1583136049'
			],
			[
				'dtId' => '6',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '6',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Settings',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583135933',
				'dtUpdateDate' => '1583135933'
			],
			[
				'dtId' => '7',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '7',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Website Setting',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583135955',
				'dtUpdateDate' => '1583135955'
			],
			[
				'dtId' => '8',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '8',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Users',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583135867',
				'dtUpdateDate' => '1583135867'
			],
			[
				'dtId' => '9',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '9',
				'dtLang' => 'en_US',
				'dtTranslation' => 'User Management',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583135890',
				'dtUpdateDate' => '1583135890'
			],
			[
				'dtId' => '10',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '10',
				'dtLang' => 'en_US',
				'dtTranslation' => 'User Group',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583135913',
				'dtUpdateDate' => '1583135913'
			],
			[
				'dtId' => '11',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '11',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Catalog',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583135807',
				'dtUpdateDate' => '1583156017'
			],
			[
				'dtId' => '12',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '12',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Reports',
				'dtInputType' => 'text',
				'dtCreateDate' => '1583429030',
				'dtUpdateDate' => '1583429099'
			],
			[
				'dtId' => '13',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '13',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Shipping',
				'dtInputType' => 'text',
				'dtCreateDate' => '1588958087',
				'dtUpdateDate' => '1588958087'
			],
			[
				'dtId' => '14',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '14',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Appearance',
				'dtInputType' => 'text',
				'dtCreateDate' => '1592164468',
				'dtUpdateDate' => '1592164468'
			],
			[
				'dtId' => '15',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '15',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Website Menu',
				'dtInputType' => 'text',
				'dtCreateDate' => '1592164764',
				'dtUpdateDate' => '1592164764'
			],
			[
				'dtId' => '16',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '16',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Addons',
				'dtInputType' => 'text',
				'dtCreateDate' => '1592164764',
				'dtUpdateDate' => '1592164764'
			],
			[
				'dtId' => '17',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '17',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Attributes',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848506',
				'dtUpdateDate' => '1607848506'
			],
			[
				'dtId' => '18',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '18',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Attribute Group',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848508',
				'dtUpdateDate' => '1607848508'
			],
			[
				'dtId' => '19',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '19',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Courier',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848511',
				'dtUpdateDate' => '1607848511'
			],
			[
				'dtId' => '20',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '20',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Currencies',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848513',
				'dtUpdateDate' => '1607848513'
			],
			[
				'dtId' => '21',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '22',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Geo Country',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848518',
				'dtUpdateDate' => '1607848518'
			],
			[
				'dtId' => '22',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '23',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Geo Zone',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848520',
				'dtUpdateDate' => '1607848520'
			],
			[
				'dtId' => '23',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '24',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Length Unit',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848523',
				'dtUpdateDate' => '1607848523'
			],
			[
				'dtId' => '24',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '25',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Manufacturers',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848526',
				'dtUpdateDate' => '1607848526'
			],
			[
				'dtId' => '25',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '26',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Product',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848529',
				'dtUpdateDate' => '1607848529'
			],
			[
				'dtId' => '26',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '27',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Product Badges',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848532',
				'dtUpdateDate' => '1607848532'
			],
			[
				'dtId' => '27',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '28',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Product Categories',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848535',
				'dtUpdateDate' => '1607848535'
			],
			[
				'dtId' => '28',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '29',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Tax',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848538',
				'dtUpdateDate' => '1607848538'
			],
			[
				'dtId' => '29',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '30',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Tax Rule',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848541',
				'dtUpdateDate' => '1607848541'
			],
			[
				'dtId' => '30',
				'dtRelatedTable' => 'users_menu',
				'dtRelatedField' => 'menuName',
				'dtRelatedId' => '31',
				'dtLang' => 'en_US',
				'dtTranslation' => 'Weight Unit',
				'dtInputType' => 'text',
				'dtCreateDate' => '1607848545',
				'dtUpdateDate' => '1607848545'
			]
		];
		return $arr;
	}

}

