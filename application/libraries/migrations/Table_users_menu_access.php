<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_users_menu_access {
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
		$schema = $this->CI->schema->create_table('users_menu_access');
        $schema->increments('lmnId', ['length' => '10']);
        $schema->integer('levelId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('menuId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->enum('lmnView', ['y', 'n']);
        $schema->enum('lmnAdd', ['y', 'n']);
        $schema->enum('lmnEdit', ['y', 'n']);
        $schema->enum('lmnDelete', ['y', 'n']);
        $schema->run();

        // ADD index
        $schema->index('levelId');
        $schema->index('menuId');
	}

	public function seeder(){
		$arr = [
            [
                'lmnId' => '1',
                'levelId' => '1',
                'menuId' => '1',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '2',
                'levelId' => '1',
                'menuId' => '2',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '3',
                'levelId' => '1',
                'menuId' => '3',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '4',
                'levelId' => '1',
                'menuId' => '4',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '5',
                'levelId' => '1',
                'menuId' => '5',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '6',
                'levelId' => '1',
                'menuId' => '6',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'n',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '7',
                'levelId' => '1',
                'menuId' => '7',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'y',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '8',
                'levelId' => '1',
                'menuId' => '8',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'n',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '9',
                'levelId' => '1',
                'menuId' => '9',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '10',
                'levelId' => '1',
                'menuId' => '10',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '11',
                'levelId' => '1',
                'menuId' => '11',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'n',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '12',
                'levelId' => '1',
                'menuId' => '12',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '13',
                'levelId' => '1',
                'menuId' => '13',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '14',
                'levelId' => '1',
                'menuId' => '14',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '15',
                'levelId' => '1',
                'menuId' => '15',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '16',
                'levelId' => '1',
                'menuId' => '16',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '17',
                'levelId' => '1',
                'menuId' => '17',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '18',
                'levelId' => '1',
                'menuId' => '18',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'n',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '19',
                'levelId' => '1',
                'menuId' => '19',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '20',
                'levelId' => '1',
                'menuId' => '20',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '21',
                'levelId' => '1',
                'menuId' => '21',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '22',
                'levelId' => '1',
                'menuId' => '22',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '23',
                'levelId' => '1',
                'menuId' => '23',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '24',
                'levelId' => '1',
                'menuId' => '24',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'n',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '25',
                'levelId' => '1',
                'menuId' => '25',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'n',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '26',
                'levelId' => '1',
                'menuId' => '26',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '27',
                'levelId' => '1',
                'menuId' => '27',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '28',
                'levelId' => '1',
                'menuId' => '28',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ],
            [
                'lmnId' => '29',
                'levelId' => '1',
                'menuId' => '29',
                'lmnView' => 'y',
                'lmnAdd' => 'n',
                'lmnEdit' => 'n',
                'lmnDelete' => 'n'
            ],
            [
                'lmnId' => '30',
                'levelId' => '1',
                'menuId' => '30',
                'lmnView' => 'y',
                'lmnAdd' => 'y',
                'lmnEdit' => 'y',
                'lmnDelete' => 'y'
            ]
        ];
		return $arr;
	}

}

