<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_users_menu {
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
		$schema = $this->CI->schema->create_table('users_menu');
        $schema->increments('menuId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('menuParentId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('menuName');
        $schema->enum('menuType', ['module', 'addons', 'link', 'noaccess']);
        $schema->text('menuAccess');
        $schema->integer('menuAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('menuSort', ['type' => 'MEDIUMINT','length' => '5', 'unsigned' => TRUE]);
        $schema->string('menuIcon', ['length' => '100']);
        $schema->string('menuAttrClass', ['length' => '100']);
        $schema->enum('menuActive', ['y', 'n']);
        $schema->enum('menuView', ['y', 'n']);
        $schema->enum('menuAdd', ['y', 'n']);
        $schema->enum('menuEdit', ['y', 'n']);
        $schema->enum('menuDelete', ['y', 'n']);
        $schema->run();

        // ADD index
        $schema->index('menuId');
        $schema->index('menuParentId');
        $schema->index('menuType');
        $schema->index('menuAccess');
	}

	public function seeder(){
		$arr = [
			[
				'menuId' => '1',
				'menuParentId' => '0',
				'menuName' => 'Developer',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1452867589',
				'menuSort' => '9',
				'menuIcon' => 'fe fe-award',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '2',
				'menuParentId' => '1',
				'menuName' => 'Menu Admin Master ',
				'menuType' => 'module',
				'menuAccess' => 'menu_admin_master',
				'menuAddedDate' => '1452867589',
				'menuSort' => '1',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '3',
				'menuParentId' => '1',
				'menuName' => 'Menu Admin Privilage',
				'menuType' => 'module',
				'menuAccess' => 'menu_admin_privilage',
				'menuAddedDate' => '1577632987',
				'menuSort' => '2',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '4',
				'menuParentId' => '0',
				'menuName' => 'System',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1577728905',
				'menuSort' => '7',
				'menuIcon' => 'fe fe-settings',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'y',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '5',
				'menuParentId' => '4',
				'menuName' => 'Info Sistem',
				'menuType' => 'module',
				'menuAccess' => 'info_sistem',
				'menuAddedDate' => '1577729211',
				'menuSort' => '1',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '6',
				'menuParentId' => '0',
				'menuName' => 'Pengaturan',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1577892258',
				'menuSort' => '6',
				'menuIcon' => 'fe fe-sliders',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '7',
				'menuParentId' => '6',
				'menuName' => 'Atur Web',
				'menuType' => 'module',
				'menuAccess' => 'atur_web',
				'menuAddedDate' => '1577892344',
				'menuSort' => '1',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'y',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '8',
				'menuParentId' => '0',
				'menuName' => 'Pengguna',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1578138421',
				'menuSort' => '5',
				'menuIcon' => 'fe fe-user',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '9',
				'menuParentId' => '8',
				'menuName' => 'Kelola Pengguna',
				'menuType' => 'module',
				'menuAccess' => 'manage_users',
				'menuAddedDate' => '1578138586',
				'menuSort' => '1',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '10',
				'menuParentId' => '8',
				'menuName' => 'Grup Pengguna',
				'menuType' => 'module',
				'menuAccess' => 'users_group',
				'menuAddedDate' => '1579535259',
				'menuSort' => '2',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '11',
				'menuParentId' => '0',
				'menuName' => 'Katalog',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1581957645',
				'menuSort' => '1',
				'menuIcon' => 'fe fe-file-text',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '12',
				'menuParentId' => '0',
				'menuName' => 'Laporan',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1583429029',
				'menuSort' => '3',
				'menuIcon' => 'fe fe-clipboard',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '13',
				'menuParentId' => '0',
				'menuName' => 'Pengiriman',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1588957989',
				'menuSort' => '2',
				'menuIcon' => 'fe fe-truck',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '14',
				'menuParentId' => '0',
				'menuName' => 'Tampilan',
				'menuType' => 'noaccess',
				'menuAccess' => '',
				'menuAddedDate' => '1592164468',
				'menuSort' => '4',
				'menuIcon' => 'fe fe-layers',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '15',
				'menuParentId' => '14',
				'menuName' => 'Menu Website',
				'menuType' => 'module',
				'menuAccess' => 'website_menu',
				'menuAddedDate' => '1592164764',
				'menuSort' => '1',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '16',
				'menuParentId' => '0',
				'menuName' => 'Addons',
				'menuType' => 'module',
				'menuAccess' => 'addons',
				'menuAddedDate' => '1607179436',
				'menuSort' => '8',
				'menuIcon' => 'fe fe-folder-plus',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '17',
				'menuParentId' => '11',
				'menuName' => 'Atribut',
				'menuType' => 'addons',
				'menuAccess' => 'attributes',
				'menuAddedDate' => '1607848506',
				'menuSort' => '3',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '18',
				'menuParentId' => '11',
				'menuName' => 'Grup Atribut',
				'menuType' => 'addons',
				'menuAccess' => 'attributes_group',
				'menuAddedDate' => '1607848508',
				'menuSort' => '4',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '19',
				'menuParentId' => '13',
				'menuName' => 'Kurir',
				'menuType' => 'addons',
				'menuAccess' => 'courier',
				'menuAddedDate' => '1607848511',
				'menuSort' => '1',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '20',
				'menuParentId' => '6',
				'menuName' => 'Mata Uang',
				'menuType' => 'addons',
				'menuAccess' => 'currencies',
				'menuAddedDate' => '1607848513',
				'menuSort' => '6',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '21',
				'menuParentId' => '1',
				'menuName' => 'Database',
				'menuType' => 'addons',
				'menuAccess' => 'database',
				'menuAddedDate' => '1607848515',
				'menuSort' => '3',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'n',
				'menuEdit' => 'n',
				'menuDelete' => 'n'
			],
			[
				'menuId' => '22',
				'menuParentId' => '6',
				'menuName' => 'Geo negara',
				'menuType' => 'addons',
				'menuAccess' => 'geo_country',
				'menuAddedDate' => '1607848518',
				'menuSort' => '7',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '23',
				'menuParentId' => '6',
				'menuName' => 'Geo Zona',
				'menuType' => 'addons',
				'menuAccess' => 'geo_zone',
				'menuAddedDate' => '1607848520',
				'menuSort' => '8',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '24',
				'menuParentId' => '6',
				'menuName' => 'Satuan Panjang',
				'menuType' => 'addons',
				'menuAccess' => 'length_unit',
				'menuAddedDate' => '1607848523',
				'menuSort' => '3',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '25',
				'menuParentId' => '11',
				'menuName' => 'Manufaktur',
				'menuType' => 'addons',
				'menuAccess' => 'manufacturers',
				'menuAddedDate' => '1607848526',
				'menuSort' => '5',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '26',
				'menuParentId' => '11',
				'menuName' => 'Produk',
				'menuType' => 'addons',
				'menuAccess' => 'product',
				'menuAddedDate' => '1607848529',
				'menuSort' => '1',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '27',
				'menuParentId' => '11',
				'menuName' => 'Lencana Produk',
				'menuType' => 'addons',
				'menuAccess' => 'product_badges',
				'menuAddedDate' => '1607848532',
				'menuSort' => '6',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '28',
				'menuParentId' => '11',
				'menuName' => 'Kategori Produk',
				'menuType' => 'addons',
				'menuAccess' => 'product_categories',
				'menuAddedDate' => '1607848535',
				'menuSort' => '2',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '29',
				'menuParentId' => '6',
				'menuName' => 'Pajak',
				'menuType' => 'addons',
				'menuAccess' => 'tax',
				'menuAddedDate' => '1607848538',
				'menuSort' => '4',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '30',
				'menuParentId' => '11',
				'menuName' => 'Rule Pajak',
				'menuType' => 'addons',
				'menuAccess' => 'tax_rule',
				'menuAddedDate' => '1607848541',
				'menuSort' => '5',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			],
			[
				'menuId' => '31',
				'menuParentId' => '6',
				'menuName' => 'Satuan Bobot',
				'menuType' => 'addons',
				'menuAccess' => 'weight_unit',
				'menuAddedDate' => '1607848545',
				'menuSort' => '2',
				'menuIcon' => '',
				'menuAttrClass' => '',
				'menuActive' => 'y',
				'menuView' => 'y',
				'menuAdd' => 'y',
				'menuEdit' => 'y',
				'menuDelete' => 'y'
			]
		];
		return $arr;
	}

}

