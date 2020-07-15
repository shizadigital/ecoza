<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_member {
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
        $schema = $this->CI->schema->create_table('member');
        $schema->increments('mId', ['length' => '11']);
        $schema->string('mName', ['length' => '255']);
        $schema->string('mEmail', ['length' => '255']);
        $schema->string('mPassword', ['length' => '255']);
        $schema->string('mHP', ['length' => '20']);
        $schema->enum('mGender', ['m', 'f']);
        $schema->string('mDefaultLang', ['length' => '10']);
        $schema->string('mDefaultCurrency', ['length' => '5']);
        $schema->integer('mNewsletter', ['type'=>'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->date('mBirthday');
        $schema->string('mCode', ['length' => '255']);
        $schema->string('mEmailSecureKey', ['length' => '150']);
        $schema->integer('mEmailSecureKeyDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('mHPSecureKey', ['length' => '150']);
        $schema->integer('mHPSecureKeyDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('mRegDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('mDir', ['length' => '25']);
        $schema->string('mPic', ['length' => '255']);
        $schema->enum('mType', ['guest', 'member']);
        $schema->integer('mStatus', ['type'=>'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->integer('mLastLogin', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('mDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('mDeleted');
        $schema->index('mType');
        $schema->index('mEmailSecureKey');
        $schema->index('mHPSecureKey');
    }

    public function seeder(){
        
    }

}
