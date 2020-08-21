<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_orders {
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
        $schema = $this->CI->schema->create_table('orders');
        $schema->increments('orderId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('empId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('modifiedEmpId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('closingEmpId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('mId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('countryId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('zoneId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('orderRecipientName', ['length' => '255']);
        $schema->string('orderRecipientCompany', ['length' => '255']);
        $schema->text('orderRecipientAddress');
        $schema->text('orderRecipientCity');
        $schema->string('orderRecipientPostalCode', ['length' => '7']);
        $schema->string('orderRecipientHP', ['length' => '25']);
        $schema->string('orderInvoice', ['length' => '20']);
        $schema->integer('orderInvoiceDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('orderCode', ['length' => '25']);
        $schema->integer('orderDay', ['type' => 'SMALLINT', 'length' => '2', 'unsigned' => TRUE]);
        $schema->integer('orderMonth', ['type' => 'SMALLINT', 'length' => '2', 'unsigned' => TRUE]);
        $schema->integer('orderYear', ['type' => 'MEDIUMINT', 'length' => '4', 'unsigned' => TRUE]);
        $schema->time('orderTime');
        $schema->integer('orderTimestamp', ['length' => '11', 'unsigned' => TRUE]);
        $schema->text('orderMessage');
        $schema->decimal('orderDiscounts', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('orderTax', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->enum('orderTaxType', ['percentage', 'fixed']);
        $schema->decimal('orderTaxAmount', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('orderSubtotal', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('orderTotal', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('orderProfitTotal', ['length' => '15,2']);
        $schema->integer('orderTimeToExpired', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('orderTimeToRemove', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('orderReminder', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('orderReminderStatus', ['y', 'n']);
        $schema->string('orderPaymentMethod', ['length' => '50']);
        $schema->text('orderPaymentMeta');
        $schema->string('orderFlag', ['length' => '25']);
        $schema->string('orderLang', ['length' => '9']);
        $schema->string('orderCurrency', ['length' => '4']);
        $schema->enum('orderVisitorType', ['member', 'guest']);
        $schema->integer('orderAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('orderModified', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');
        $schema->index('empId');
        $schema->index('mId');
        $schema->index('countryId');
        $schema->index('zoneId');
        $schema->index('orderInvoice');
        $schema->index('orderCode');
    }

    public function seeder(){
        
    }

}

