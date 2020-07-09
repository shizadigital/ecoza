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
			['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'11', 'dtLang'=>'en_US', 'dtTranslation'=>'Catalog', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135807', 'dtUpdateDate'=>'1583156017'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'12', 'dtLang'=>'en_US', 'dtTranslation'=>'Product Categories', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135835', 'dtUpdateDate'=>'1583135835'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'8', 'dtLang'=>'en_US', 'dtTranslation'=>'Users', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135867', 'dtUpdateDate'=>'1583135867'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'9', 'dtLang'=>'en_US', 'dtTranslation'=>'User Management', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135890', 'dtUpdateDate'=>'1583135890'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'10', 'dtLang'=>'en_US', 'dtTranslation'=>'User Group', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135913', 'dtUpdateDate'=>'1583135913'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'6', 'dtLang'=>'en_US', 'dtTranslation'=>'Settings', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135933', 'dtUpdateDate'=>'1583135933'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'7', 'dtLang'=>'en_US', 'dtTranslation'=>'Website Setting', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135955', 'dtUpdateDate'=>'1583135955'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'4', 'dtLang'=>'en_US', 'dtTranslation'=>'System', 'dtInputType'=>'text', 'dtCreateDate'=>'1583135990', 'dtUpdateDate'=>'1583135990'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'5', 'dtLang'=>'en_US', 'dtTranslation'=>'System Info', 'dtInputType'=>'text', 'dtCreateDate'=>'1583136049', 'dtUpdateDate'=>'1583136049'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'1', 'dtLang'=>'en_US', 'dtTranslation'=>'Development', 'dtInputType'=>'text', 'dtCreateDate'=>'1583136078', 'dtUpdateDate'=>'1583136078'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'2', 'dtLang'=>'en_US', 'dtTranslation'=>'Admin Master Menu', 'dtInputType'=>'text', 'dtCreateDate'=>'1583136102', 'dtUpdateDate'=>'1583136102'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'3', 'dtLang'=>'en_US', 'dtTranslation'=>'Admin Privilege Menu', 'dtInputType'=>'text', 'dtCreateDate'=>'1583136126', 'dtUpdateDate'=>'1583136126'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'13', 'dtLang'=>'en_US', 'dtTranslation'=>'Manufacturers', 'dtInputType'=>'text', 'dtCreateDate'=>'1583163513', 'dtUpdateDate'=>'1583163513'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'14', 'dtLang'=>'en_US', 'dtTranslation'=>'Attributes', 'dtInputType'=>'text', 'dtCreateDate'=>'1583253180', 'dtUpdateDate'=>'1583253180'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'15', 'dtLang'=>'en_US', 'dtTranslation'=>'Product', 'dtInputType'=>'text', 'dtCreateDate'=>'1583254882', 'dtUpdateDate'=>'1583254882'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'16', 'dtLang'=>'en_US', 'dtTranslation'=>'Attributes Group', 'dtInputType'=>'text', 'dtCreateDate'=>'1583255842', 'dtUpdateDate'=>'1583255842'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'17', 'dtLang'=>'en_US', 'dtTranslation'=>'Product Badges', 'dtInputType'=>'text', 'dtCreateDate'=>'1583350660', 'dtUpdateDate'=>'1583350660'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'18', 'dtLang'=>'en_US', 'dtTranslation'=>'Reports', 'dtInputType'=>'text', 'dtCreateDate'=>'1583429030', 'dtUpdateDate'=>'1583429099'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'19', 'dtLang'=>'en_US', 'dtTranslation'=>'Weight Unit', 'dtInputType'=>'text', 'dtCreateDate'=>'1583429622', 'dtUpdateDate'=>'1583429908'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'20', 'dtLang'=>'en_US', 'dtTranslation'=>'Length Unit', 'dtInputType'=>'text', 'dtCreateDate'=>'1583430361', 'dtUpdateDate'=>'1583430361'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'21', 'dtLang'=>'en_US', 'dtTranslation'=>'Tax', 'dtInputType'=>'text', 'dtCreateDate'=>'1584089953', 'dtUpdateDate'=>'1584089953'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'22', 'dtLang'=>'en_US', 'dtTranslation'=>'Tax Rule', 'dtInputType'=>'text', 'dtCreateDate'=>'1584090162', 'dtUpdateDate'=>'1584090162'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'23', 'dtLang'=>'en_US', 'dtTranslation'=>'Currencies', 'dtInputType'=>'text', 'dtCreateDate'=>'1584090568', 'dtUpdateDate'=>'1584090568'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'24', 'dtLang'=>'en_US', 'dtTranslation'=>'Database', 'dtInputType'=>'text', 'dtCreateDate'=>'1588876649', 'dtUpdateDate'=>'1588876649'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'25', 'dtLang'=>'en_US', 'dtTranslation'=>'Shipping', 'dtInputType'=>'text', 'dtCreateDate'=>'1588958087', 'dtUpdateDate'=>'1588958087'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'26', 'dtLang'=>'en_US', 'dtTranslation'=>'Couriers', 'dtInputType'=>'text', 'dtCreateDate'=>'1588961467', 'dtUpdateDate'=>'1588961467'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'27', 'dtLang'=>'en_US', 'dtTranslation'=>'Geo Country', 'dtInputType'=>'text', 'dtCreateDate'=>'1589390020', 'dtUpdateDate'=>'1589390020'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'28', 'dtLang'=>'en_US', 'dtTranslation'=>'Geo Zone', 'dtInputType'=>'text', 'dtCreateDate'=>'1589390105', 'dtUpdateDate'=>'1589390105'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'29', 'dtLang'=>'en_US', 'dtTranslation'=>'Appearance', 'dtInputType'=>'text', 'dtCreateDate'=>'1592164468', 'dtUpdateDate'=>'1592164468'],
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'30', 'dtLang'=>'en_US', 'dtTranslation'=>'Website Menu', 'dtInputType'=>'text', 'dtCreateDate'=>'1592164764', 'dtUpdateDate'=>'1592164764'],
		];
		return $arr;
	}

}

