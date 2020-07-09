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
	}

	public function seeder(){
		$arr = [
            [
                'menuId' => '1',
                'menuParentId' => '0',
                'menuName' => 'Developer',
                'menuAccess' => '',
                'menuAddedDate' => '1452867589',
                'menuSort' => '8',
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
                'menuAccess' => 'a:1:{s:10:"admin_link";s:17:"menu_admin_master";}',
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
                'menuAccess' => 'a:1:{s:10:"admin_link";s:20:"menu_admin_privilage";}',
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
                'menuAccess' => 'a:1:{s:10:"admin_link";s:11:"info_sistem";}',
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
                'menuAccess' => 'a:1:{s:10:"admin_link";s:8:"atur_web";}',
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
                'menuAccess' => 'a:1:{s:10:"admin_link";s:12:"manage_users";}',
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
                'menuAccess' => 'a:1:{s:10:"admin_link";s:11:"users_group";}',
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
                'menuParentId' => '11',
                'menuName' => 'Kategori Produk',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:18:"product_categories";}',
                'menuAddedDate' => '1581958817',
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
                'menuId' => '13',
                'menuParentId' => '11',
                'menuName' => 'Pabrikan',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:13:"manufacturers";}',
                'menuAddedDate' => '1583163512',
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
                'menuId' => '14',
                'menuParentId' => '11',
                'menuName' => 'Atribut',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:10:"attributes";}',
                'menuAddedDate' => '1583253180',
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
                'menuId' => '15',
                'menuParentId' => '11',
                'menuName' => 'Produk',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:7:"product";}',
                'menuAddedDate' => '1583254882',
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
                'menuParentId' => '11',
                'menuName' => 'Atribut Grup',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:16:"attributes_group";}',
                'menuAddedDate' => '1583255841',
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
                'menuId' => '17',
                'menuParentId' => '11',
                'menuName' => 'Lencana Produk',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:14:"product_badges";}',
                'menuAddedDate' => '1583350660',
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
                'menuId' => '18',
                'menuParentId' => '0',
                'menuName' => 'Laporan',
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
                'menuId' => '19',
                'menuParentId' => '6',
                'menuName' => 'Satuan Bobot',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:11:"weight_unit";}',
                'menuAddedDate' => '1583429908',
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
                'menuId' => '20',
                'menuParentId' => '6',
                'menuName' => 'Satuan Panjang',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:11:"length_unit";}',
                'menuAddedDate' => '1583430360',
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
                'menuId' => '21',
                'menuParentId' => '6',
                'menuName' => 'Pajak',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:3:"tax";}',
                'menuAddedDate' => '1584089953',
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
                'menuId' => '22',
                'menuParentId' => '6',
                'menuName' => 'Aturan Pajak',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:8:"tax_rule";}',
                'menuAddedDate' => '1584090162',
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
                'menuId' => '23',
                'menuParentId' => '6',
                'menuName' => 'Mata Uang',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:10:"currencies";}',
                'menuAddedDate' => '1584090345',
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
                'menuId' => '24',
                'menuParentId' => '1',
                'menuName' => 'Database',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:8:"database";}',
                'menuAddedDate' => '1588876649',
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
                'menuId' => '25',
                'menuParentId' => '0',
                'menuName' => 'Pengiriman',
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
                'menuId' => '26',
                'menuParentId' => '25',
                'menuName' => 'Pengirim',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:7:"courier";}',
                'menuAddedDate' => '1588961466',
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
                'menuParentId' => '6',
                'menuName' => 'Geo Negara',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:11:"geo_country";}',
                'menuAddedDate' => '1589390020',
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
                'menuId' => '28',
                'menuParentId' => '6',
                'menuName' => 'Geo Zona',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:8:"geo_zone";}',
                'menuAddedDate' => '1589390105',
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
                'menuId' => '29',
                'menuParentId' => '0',
                'menuName' => 'Tampilan',
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
                'menuId' => '30',
                'menuParentId' => '29',
                'menuName' => 'Menu Website',
                'menuAccess' => 'a:1:{s:10:"admin_link";s:12:"website_menu";}',
                'menuAddedDate' => '1592164764',
                'menuSort' => '1',
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

