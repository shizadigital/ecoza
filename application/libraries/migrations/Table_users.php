<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_users {
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
		$schema = $this->CI->schema->create_table('users');
        $schema->increments('userId', ['length' => '11']);
        $schema->string('userLogin', ['length' => '65']);
        $schema->string('userPass');
        $schema->string('userEmail', ['length' => '100']);
        $schema->string('userTlp', ['length' => '25']);
        $schema->string('userDisplayName', ['length' => '250']);
        $schema->integer('levelId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->enum('userBlocked', ['y', 'n']);
        $schema->integer('userDelete', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('userLastLogin', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('userActivationKey');
        $schema->integer('userRegistered', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('userSession');
        $schema->text('userCheckPoint', ['type' => 'LONGTEXT']);
        $schema->string('userDir', ['length' => '20']);
        $schema->text('userPic');
        $schema->enum('userOnlineStatus', ['online', 'offline', 'busy']);
        $schema->string('userLang', ['length' => '10']);
        $schema->run();

        // ADD index
        $schema->index('userLogin');
        $schema->index('userEmail');
        $schema->index('userBlocked');
        $schema->index('userDelete');
	}

	public function seeder(){
		$pass 	= sha1( sha1( encoder( 'password' .'>>>>'. LOGIN_SALT )) . "#" . LOGIN_SALT);
        $passwordunik = password_hash( $pass, PASSWORD_DEFAULT, ['cost' => 10]); 
		$arr = [
            [
				'userLogin' => 'superadmin',
				'userPass' => $passwordunik,
				'userEmail' => 'shizadigitalsolution@gmail.com',
				'userTlp' => '081276540054',
				'userDisplayName' => 'Shiza',
				'levelId' => '1',
				'userBlocked' => 'n',
				'userDelete' => '0',
				'userLastLogin' => '1582310633',
				'userActivationKey' => '',
				'userRegistered' => '1358259589',
				'userSession' => '1g77ng04l81u5trq7clj7hpfl9m4fg00',
				'userCheckPoint' => '',
				'userDir' => '',
				'userPic' => '',
				'userOnlineStatus' => 'online',
				'userLang' => 'id_ID',
            ],
            [
				'userLogin' => 'admin',
				'userPass' => $passwordunik,
				'userEmail' => 'admin@admin.com',
				'userTlp' => '',
				'userDisplayName' => 'Admin Shiza',
				'levelId' => '2',
				'userBlocked' => 'n',
				'userDelete' => '0',
				'userLastLogin' => '1565019560',
				'userActivationKey' => '',
				'userRegistered' => '1565017383',
				'userSession' => 'uhugeprv49jpbfkonhp9bc3l52',
				'userCheckPoint' => '',
				'userDir' => '',
				'userPic' => '',
				'userOnlineStatus' => 'online',
				'userLang' => 'id_ID',
            ],
            
		];
		return $arr;
	}

}

