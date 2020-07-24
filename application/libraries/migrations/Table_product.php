<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_product {
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
        $schema = $this->CI->schema->create_table('product');
        $schema->increments('prodId', ['length' => '11']);
        $schema->string('userLogin', ['length' => '100']);
        $schema->integer('manufactId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('optionProdRules', ['type'=>'TINYINT', 'length' => '3', 'unsigned' => TRUE]);
        $schema->integer('taxId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('prodType', ['length' => '25']);
        $schema->string('prodSku', ['length' => '65']);
        $schema->string('prodUpc', ['length' => '15']);
        $schema->string('prodIsbn', ['length' => '18']);
        $schema->string('prodMpn', ['length' => '65']);
        $schema->string('prodName', ['length' => '255']);
        $schema->text('prodDesc');
        $schema->enum('prodFeatured', ['y', 'n']);
        $schema->decimal('prodBasicPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('prodPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('prodSpecialPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('prodFinalPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('prodQty', ['length' => '15,8']);
        $schema->enum('prodQtyType', ['unlimited', 'limited']);
        $schema->decimal('prodWeight', ['length' => '15,8']);
        $schema->string('prodWeightUnit', ['length' => '5']);
        $schema->decimal('prodLength', ['length' => '15,8']);
        $schema->decimal('prodWidth', ['length' => '15,8']);
        $schema->decimal('prodHeight', ['length' => '15,8']);
        $schema->string('prodLengthUnit', ['length' => '5']);
        $schema->string('prodOrigin', ['length' => '100']);
        $schema->integer('prodMinOrder', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('prodMaxOrder', ['length' => '11', 'unsigned' => TRUE]);
        $schema->char('prodShipping', ['length' => '1']);
        $schema->enum('prodFreeShipping', ['y', 'n']);
        $schema->string('prodVideo', ['length' => '50']);
        $schema->text('prodNote');
        $schema->integer('prodBuyCount', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('prodViewCount', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('prodAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('prodModified', ['length' => '11', 'unsigned' => TRUE]);
        $schema->char('prodDisplay', ['length' => '1']);
        $schema->char('prodAllowReview', ['length' => '1']);
        $schema->integer('prodDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('taxId');
        $schema->index('prodType');
        $schema->index('prodFinalPrice');
        $schema->index('prodWeight');
        $schema->index('prodDisplay');
        $schema->index('prodDeleted');
    }

    public function seeder(){
        
    }

}

