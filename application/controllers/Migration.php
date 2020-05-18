<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CREATED BY SHIZA
 * 
 * 
 * php index.php Migration install
 * 
 * or with seed
 * 
 * php index.php Migration install seed
 * 
 */

class Migration extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('mc');
        $this->load->library('Schema');

    }

	public function install($action = null){
        Self::drop();
        Self::create();

        if($action == 'seed') Self::seed();
    }
    
    protected function create() {
        Self::create_addons_table();
        Self::create_ads_table();
        Self::create_ads_position_table();
        Self::create_android_device_table();
        Self::create_attribute_table();
        Self::create_attribute_group_table();
        Self::create_attribute_group_store_table();
        Self::create_attribute_relationship_table();
        Self::create_attribute_value_table();
        Self::create_attribute_store_table();
        Self::create_badges_table();
        Self::create_badge_relationship_table();
        Self::create_badge_store_table();
        Self::create_categories_table();
        Self::create_category_relationship_table();
        Self::create_category_store_table();
        Self::create_currency_table();
        Self::create_comments_table();
        Self::create_contents_table();
        Self::create_courier_table();
        Self::create_courier_cost_table();
        Self::create_courier_store_table();
        Self::create_cron_list_table();
        Self::create_dynamic_translations_table();
        Self::create_email_blacklist_table();
        Self::create_email_queue_table();
        Self::create_email_template_table();
        Self::create_gallery_pic_table();
        Self::create_geo_country_table();
        Self::create_geo_zone_table();
        Self::create_manufacturers_table();
        Self::create_manufacturers_store_table();
        Self::create_message_table();
        Self::create_options_table();
        Self::create_product_table();
        Self::create_product_attribute_table();
        Self::create_product_attribute_combination_table();
        Self::create_product_downloadable_table();
        Self::create_product_related_table();
        Self::create_product_images_table();
        Self::create_product_store_table();
        Self::create_review_table();
        Self::create_seo_page_table();
        Self::create_slider_table();
        Self::create_store_table();
        Self::create_tax_table();
        Self::create_tax_rule_table();
        Self::create_testimonial_table();
        Self::create_unit_weight_table();
        Self::create_unit_length_table();
        Self::create_users_table();
        Self::create_users_level_table();
        Self::create_users_menu_table();
        Self::create_users_menu_access_table();
        Self::create_website_menu_table();
    }

    protected function create_addons_table(){
        $schema = $this->schema->create_table('addons');
        $schema->increments('addonsId');
        $schema->string('addonsName', ['length' => '150']);
        $schema->string('addonsDirName', ['length' => '150']);
        $schema->string('addonsVersion', ['length' => '15']);
        $schema->integer('addonsAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('addonsActive', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->run();
    }

    protected function create_ads_table() {

        $schema = $this->schema->create_table('ads');
        $schema->increments('adsId');
        $schema->integer('adposId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('adsTitle', ['length' => '150']);
        $schema->string('adsUri');
        $schema->text('adsDesc');
        $schema->string('adsType', ['length' => '20']);
        $schema->text('adsCode');
        $schema->text('adsImg');
        $schema->text('adsSwf');
        $schema->string('adsDirFile', ['length' => '25']);
        $schema->date('adsStartDate');
        $schema->date('adsEndDate');
        $schema->integer('adsPublish', ['length' => '3', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('adposId');
    }

    protected function create_ads_position_table() {

        $schema = $this->schema->create_table('ads_position');
        $schema->increments('adposId');
        $schema->string('adposName');
        $schema->integer('adposW', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('adposH', ['length' => '10', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('adposId');
    }

    protected function create_android_device_table() {

        $schema = $this->schema->create_table('android_device');
        $schema->increments('devId', ['length' => '10']);
        $schema->string('devAndroidId', ['length' => '35']);
        $schema->integer('devAccountId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('devAccountType', ['length' => '25']);
        $schema->string('devRegId');
        $schema->string('devIMEI', ['length' => '35']);
        $schema->string('devName');
        $schema->enum('devStatus', ['on', 'off']);
        $schema->string('devSIMSerial', ['length' => '30']);
        $schema->integer('devLog', ['length' => '10', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('devAndroidId');
        $schema->index('devAccountId');
    }

    protected function create_attribute_table(){

        $schema = $this->schema->create_table('attribute');
        $schema->increments('attrId', ['length' => '11']);
        $schema->string('attrLabel', ['length' => '100']);
        $schema->integer('attrSorting', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('attrDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('attrSorting');

    }

    protected function create_attribute_group_table(){

        $schema = $this->schema->create_table('attribute_group');
        $schema->increments('attrgroupId', ['length' => '11']);
        $schema->string('attrgroupLabel', ['length' => '100']);
        $schema->integer('attrgroupSorting', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('attrgroupDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('attrgroupSorting');

    }

    protected function create_attribute_group_store_table(){
        $schema = $this->schema->create_table('attribute_group_store');
        $schema->increments('attrgroupId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');
    }

    protected function create_attribute_relationship_table(){

        $schema = $this->schema->create_table('attribute_relationship');
        $schema->increments('attrrelId', ['type' => 'BIGINT', 'length' => '25']);
        $schema->integer('attrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('attrgroupId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('attrId');
        $schema->index('attrgroupId');

    }

    protected function create_attribute_value_table(){

        $schema = $this->schema->create_table('attribute_value');
        $schema->increments('attrvalId', ['type' => 'BIGINT', 'length' => '25']);
        $schema->integer('attrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('attrvalVisual', ['color', 'text', 'image']);
        $schema->text('attrvalValue');
        $schema->string('attrvalLabel', ['length' => '255']);
        $schema->run();

        // ADD index
        $schema->index('attrId');

    }

    protected function create_attribute_store_table(){

        $schema = $this->schema->create_table('attribute_store');
        $schema->increments('attrId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_badges_table() {
        $schema = $this->schema->create_table('badges');
        $schema->increments('badgeId', ['length' => '11']);
        $schema->string('badgeLabel', ['length' => '60']);
        $schema->text('badgeDesc');
        $schema->string('badgeType', ['length' => '60']);
        $schema->string('badgeDir', ['length' => '25']);
        $schema->string('badgePic');
        $schema->integer('badgeActive', ['length' => '3', 'unsigned' => TRUE]);
        $schema->integer('badgeDeleted', ['length' => '10', 'unsigned' => TRUE]);
        $schema->run();
    }

    protected function create_badge_relationship_table() {
        $schema = $this->schema->create_table('badge_relationship');
        $schema->increments('bdgrelId', ['length' => '11']);
        $schema->integer('badgeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('relatedId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('bdgrelType', ['length' => '50']);
        $schema->run();

        // ADD index
        $schema->index('badgeId');
        $schema->index('relatedId');
        $schema->index('bdgrelType');

    }

    protected function create_badge_store_table(){

        $schema = $this->schema->create_table('badge_store');
        $schema->increments('badgeId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_categories_table() {
        $schema = $this->schema->create_table('categories');
        $schema->increments('catId', ['length' => '11']);
        $schema->string('catName', ['length' => '100']);
        $schema->string('catSlug');
        $schema->text('catDesc');
        $schema->string('catColor', ['length' => '12']);
        $schema->integer('catActive', ['length' => '3', 'unsigned' => TRUE]);
        $schema->string('catType', ['length' => '20']);
        $schema->run();

        // ADD index
        $schema->index('catSlug');
        $schema->index('catActive');
        $schema->index('catType');
    }

    protected function create_category_relationship_table() {
        $schema = $this->schema->create_table('category_relationship');
        $schema->increments('crelId', ['type' => 'BIGINT', 'length' => '20']);
        $schema->integer('catId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('relatedId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('crelRelatedType', ['length' => '25']);
        $schema->run();

        // ADD index
        $schema->index('catId');
        $schema->index('relatedId');
        $schema->index('crelRelatedType');
    }

    protected function create_category_store_table(){

        $schema = $this->schema->create_table('category_store');
        $schema->increments('catId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_currency_table(){
        $schema = $this->schema->create_table('currency');
        $schema->increments('curId', ['length' => '11']);
        $schema->string('curTitle', ['length' => '30']);
        $schema->string('curCode', ['length' => '5']);
        $schema->string('curPrefixSymbol', ['length' => '12']);
        $schema->string('curSuffixSymbol', ['length' => '12']);
        $schema->decimal('curRate', ['length' => '14,8', 'unsigned'=>TRUE]);
        $schema->decimal('curForeignCurrencyToDefault', ['length' => '14,8', 'unsigned'=>TRUE]);
        $schema->char('curDecimalPlace', ['length' => '1']);
        $schema->integer('curModifiedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('curUpdateMethod', ['automatic', 'manual']);
        $schema->integer('curStatus',  ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('curCode');
        $schema->index('curStatus');

    }

    protected function create_comments_table() {

        $schema = $this->schema->create_table('comments');
        $schema->increments('commentId', ['type' => 'BIGINT', 'length' => '20']);
        $schema->integer('relatedId', ['type' => 'BIGINT', 'length' => '20', 'unsigned' => TRUE]);
        $schema->integer('commentParentId', ['type' => 'BIGINT', 'length' => '20', 'unsigned' => TRUE]);
        $schema->string('commentContentType', ['length' => '25']);
        $schema->string('commentAuthor');
        $schema->string('commentEmail');
        $schema->string('commentWeblog');
        $schema->text('commentComment');
        $schema->string('commentDay', ['length' => '11']);
        $schema->time('commentHour');
        $schema->date('commentDate');
        $schema->string('commentTimestamp', ['length' => '10']);
        $schema->string('commentIp', ['length' => '25']);
        $schema->string('commentApproved', ['length' => '20']);
        $schema->run();

        // ADD index
        $schema->index('relatedId');
        $schema->index('commentParentId');
    }

    protected function create_contents_table() {

        $schema = $this->schema->create_table('contents');
        $schema->increments('contentId', ['type' => 'BIGINT', 'length' => '20']);
        $schema->string('contentUsername', ['length' => '150']);
        $schema->text('contentTitle',['type' => 'LONGTEXT']);
        $schema->string('contentType', ['length' => '25']);
        $schema->string('contentDay', ['length' => '10']);
        $schema->integer('contentDd', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('contentMm', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('contentYy', ['length' => '8', 'unsigned' => TRUE]);
        $schema->date('contentDate');
        $schema->time('contentHour');
        $schema->string('contentTimestamp', ['length' => '11']);
        $schema->datetime('contentDatetime');
        $schema->string('contentAddDate', ['length' => '11']);
        $schema->string('contentSlug');
        $schema->integer('contentRead', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('contentCommentStatus', ['length' => '3', 'unsigned' => TRUE]);
        $schema->integer('contentStatus', ['length' => '3', 'unsigned' => TRUE]);
        $schema->string('contentEditor', ['length' => '100']);
        $schema->string('contentAuthor', ['length' => '100']);
        $schema->string('contentImg');
        $schema->string('contentDirImg', ['length' => '25']);
        $schema->text('contentTextImg');
        $schema->integer('contentHeadline', ['length' => '3', 'unsigned' => TRUE]);
        $schema->integer('contentFeature', ['length' => '3', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('contentId');
        $schema->index('contentTimestamp');
        $schema->index('contentStatus');
        $schema->index('contentSlug');
        $schema->index('contentType');
    }

    protected function create_courier_table(){
        $schema = $this->schema->create_table('courier');
        $schema->increments('courierId', ['length' => '11']);
        $schema->integer('addonsId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('courierName', ['length' => '100']);
        $schema->string('courierCode', ['length' => '20']);
        $schema->text('courierUrlTracking');
        $schema->integer('lengthId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->decimal('courierMaxLength', ['length' => '15,8']);
        $schema->decimal('courierMaxWidth', ['length' => '15,8']);
        $schema->decimal('courierMaxHeight', ['length' => '15,8']);
        $schema->decimal('courierMaxWeight', ['length' => '15,8']);
        $schema->integer('weightId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('courierDirLogo', ['length' => '35']);
        $schema->string('courierFileLogo', ['length' => '255']);
        $schema->enum('courierFreeShipping', ['y', 'n']);
        $schema->integer('courierStatus', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->integer('courierAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('courierDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('courierCode');
        $schema->index('courierStatus');
        $schema->index('courierDeleted');
        $schema->index('lengthId');
        $schema->index('weightId');
    }

    protected function create_courier_cost_table(){
        $schema = $this->schema->create_table('courier_cost');
        $schema->increments('ccostId', ['length' => '11']);
        $schema->integer('courierId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('countryId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('zoneId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('ccostService', ['length' => '11', 'unsigned' => TRUE]);
        $schema->decimal('ccostCost', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->integer('ccostETD', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('ccostNote', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('ccostAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('courierId');
        $schema->index('countryId');
        $schema->index('zoneId');
    }

    protected function create_courier_store_table(){

        $schema = $this->schema->create_table('courier_store');
        $schema->increments('courierId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_cron_list_table() {

        $schema = $this->schema->create_table('cron_list');
        $schema->increments('cronId', ['length' => '10']);
        $schema->string('cronName', ['length' => '50']);
        $schema->text('cronData');
        $schema->string('cronDesc');
        $schema->text('cronDirModule');
        $schema->integer('cronLastAct', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('cronReport');
        $schema->run();
    }

    protected function create_dynamic_translations_table() {

        $schema = $this->schema->create_table('dynamic_translations');
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

    protected function create_email_blacklist_table(){
        $schema = $this->schema->create_table('email_blacklist');
        $schema->increments('eblId', ['length' => '11']);
        $schema->string('eblEmail', ['length' => '255']);
        $schema->string('eblReason', ['length' => '30']);
        $schema->run();

        // ADD index
        $schema->index('eblEmail');
    }

    protected function create_email_queue_table() {

        $schema = $this->schema->create_table('email_queue');
        $schema->increments('emailId', ['length' => '11']);
        $schema->string('emailTo', ['length' => '255']);
        $schema->text('emailCC');
        $schema->text('emailBCC');
        $schema->string('emailSubject');
        $schema->text('emailMsg', ['type' => 'MEDIUMTEXT']);
        $schema->enum('emailMsgType', ['text', 'html']);
        $schema->string('emailHead');
        $schema->integer('emailDate', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('emailDateSent', ['length' => '10', 'unsigned' => TRUE]);
        $schema->char('emailStatus', ['length' => '1']);
        $schema->text('emailAttachFile');
        $schema->run();

        // ADD index
        $schema->index('emailId');
    }

    protected function create_email_template_table() {

        $schema = $this->schema->create_table('email_template');
        $schema->increments('tId', ['length' => '10']);
        $schema->string('tName');
        $schema->text('tEmail', ['type' => 'MEDIUMTEXT']);
        $schema->text('tEmailbak', ['type' => 'MEDIUMTEXT']);
        $schema->run();

    }

    protected function create_gallery_pic_table() {

        $schema = $this->schema->create_table('gallery_pic');
        $schema->increments('galpicId', ['type' => 'BIGINT', 'length' => '25']);
        $schema->integer('contentId', ['length' => '11']);
        $schema->text('galpicText');
        $schema->text('galpicPicture');
        $schema->string('galpicDir', ['length' => '25']);
        $schema->string('galpicPhotographer', ['length' => '225']);
        $schema->run();

        // ADD index
        $schema->index('contentId');
    }

    protected function create_geo_country_table() {

        $schema = $this->schema->create_table('geo_country');
        $schema->increments('countryId', ['length' => '11']);
        $schema->string('countryName', ['length' => '130']);
        $schema->string('countryIsoCode2', ['length' => '2']);
        $schema->string('countryIsoCode3', ['length' => '3']);
        $schema->integer('countryStatus', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->integer('countryDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();
    }

    protected function create_geo_zone_table() {

        $schema = $this->schema->create_table('geo_zone');
        $schema->increments('zoneId', ['length' => '11']);
        $schema->integer('countryId', ['length' => '11']);
        $schema->string('zoneName', ['length' => '130']);
        $schema->string('zoneCode', ['length' => '35']);
        $schema->integer('zoneStatus', ['type' => 'TINYINT', 'length' => '1', 'unsigned' => TRUE]);
        $schema->integer('zoneDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('countryId');
    }

    protected function create_manufacturers_table() {

        $schema = $this->schema->create_table('manufacturers');
        $schema->increments('manufactId', ['length' => '11']);
        $schema->string('manufactName',['length' => '255']);
        $schema->text('manufactDesc');
        $schema->string('manufactSlug', ['length' => '255']);
        $schema->string('manufactDir', ['length' => '45']);
        $schema->string('manufactImg', ['length' => '255']);
        $schema->integer('manufactSort', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('manufactActive', ['y','n']);
        $schema->integer('manufactDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('manufactSlug');
        $schema->index('manufactActive');
    }

    protected function create_manufacturers_store_table(){

        $schema = $this->schema->create_table('manufacturers_store');
        $schema->increments('manufactId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_message_table() {

        $schema = $this->schema->create_table('message');
        $schema->increments('msgId', ['length' => '11']);
        $schema->integer('msgReplyId', ['length' => '15', 'unsigned' => TRUE]);
        $schema->string('msgName', ['length' => '150']);
        $schema->string('msgEmail');
        $schema->string('msgEmailSent');
        $schema->string('msgTlp', ['length' => '60']);
        $schema->text('msgContent');
        $schema->string('msgTime', ['length' => '11']);
        $schema->string('msgDay', ['length' => '10']);
        $schema->enum('msgStatus', ['new', 'old']);
        $schema->string('msgStatusPesan', ['length' => '10']);
        $schema->run();

        // ADD index
        $schema->index('msgId');
        $schema->index('msgReplyId');
    }

    protected function create_options_table() {

        $schema = $this->schema->create_table('options');
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

    protected function create_product_table(){
        
        $schema = $this->schema->create_table('product');
        $schema->increments('prodId', ['length' => '11']);
        $schema->string('userLogin', ['length' => '100']);
        $schema->integer('manufactId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('optionProdRules', ['type'=>'TINYINT', 'length' => '3', 'unsigned' => TRUE]);
        $schema->string('prodType', ['length' => '25']);
        $schema->string('prodSku', ['length' => '65']);
        $schema->string('prodUpc', ['length' => '15']);
        $schema->string('prodIsbn', ['length' => '18']);
        $schema->string('prodMpn', ['length' => '65']);
        $schema->string('prodName', ['length' => '255']);
        $schema->string('prodSlug', ['length' => '255']);
        $schema->text('prodDesc');
        $schema->enum('prodFeatured', ['y', 'n']);
        $schema->decimal('prodBasicPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('prodPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('prodSpecPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('prodFinalPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->integer('prodQty', ['length' => '11', 'unsigned'=>TRUE]);
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
        $schema->index('prodType');
        $schema->index('prodSlug');
        $schema->index('prodFinalPrice');
        $schema->index('prodWeight');
        $schema->index('prodDisplay');
        $schema->index('prodDeleted');
    }

    protected function create_product_attribute_table(){
        $schema = $this->schema->create_table('product_attribute');
        $schema->increments('pattrId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('pimgId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->decimal('pattrPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('pattrSpecPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('pattrFinalPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->integer('pattrQty', ['type'=> 'SMALLINT', 'length' => '5', 'unsigned' => TRUE]);
        $schema->enum('pattrQtyType', ['unlimited', 'limited']);        
        $schema->decimal('pattrWeight', ['length' => '15,8']);
        $schema->string('pattrWeightUnit', ['length' => '5']);
        $schema->string('pattrPath', ['length' => '11']);
        $schema->integer('pattrDownloadLimit', ['type'=>'BIGINT', 'length' => '25']);
        $schema->enum('pattrDownloadFrom', ['email', 'server', 'externaluri']);
        $schema->text('pattrExternalUrl');
        $schema->enum('pattrDefault', ['y', 'n']);
        $schema->integer('pattrAddedDate',['length'=>'11', 'unsigned'=>TRUE]);
        $schema->integer('pattrModifiedDate',['length'=>'11', 'unsigned'=>TRUE]);
        $schema->run();

        // ADD index
        $schema->index('prodId');
        $schema->index('pimgId');
        $schema->index('pattrFinalPrice');
    }

    protected function create_product_attribute_combination_table(){
        $schema = $this->schema->create_table('product_attribute_combination');
        $schema->increments('pattrcombId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('pattrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('attrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('attrvalId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('pattrId');
        $schema->index('attrvalId');
        $schema->index('attrId');
    }

    protected function create_product_downloadable_table() {
        $schema = $this->schema->create_table('product_downloadable');
        $schema->increments('pdwlId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('pdwlTitle', ['length' => '255']);
        $schema->decimal('pdwlPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('pdwlSpecPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->decimal('pdwlFinalPrice', ['length' => '15,2', 'unsigned'=>TRUE]);
        $schema->enum('pdwlDownloadType', ['file', 'url']);
        $schema->string('pdwlFileDir', ['length' => '25']);
        $schema->string('pdwlFile', ['length' => '255']);
        $schema->enum('pdwlSampleType', ['file', 'url']);
        $schema->string('pdwlSampleDir', ['length' => '25']);
        $schema->string('pdwlSampleFile', ['length' => '255']);
        $schema->enum('pdwlMaxDownloadType', ['unlimited', 'limited']);
        $schema->integer('pdwlMaxDownload', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('pdwlAddedDate',['length'=>'11', 'unsigned'=>TRUE]);
        $schema->run();

        // ADD index
        $schema->index('prodId');
    }

    protected function create_product_related_table() {
        $schema = $this->schema->create_table('product_related');
        $schema->increments('prelId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('relatedId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('prodId');
    }

    protected function create_product_images_table() {
        $schema = $this->schema->create_table('product_images');
        $schema->increments('pimgId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('pimgDir', ['length' => '25']);
        $schema->string('pimgImg');
        $schema->enum('pimgPrimary', ['y', 'n']);
        $schema->integer('pimgPosition', ['type'=> 'SMALLINT','length' => '3', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('prodId');
    }

    protected function create_product_store_table(){

        $schema = $this->schema->create_table('product_store');
        $schema->increments('prodId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_review_table() {

        $schema = $this->schema->create_table('review');
        $schema->increments('reviewId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('mId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('reviewRelatedId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('reviewType', ['length' => '20']);
        $schema->text('reviewDesc');
        $schema->integer('reviewValue', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('reviewStatus', ['y', 'n']);
        $schema->integer('reviewAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('reviewUpdatedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('reviewRelatedId');
        $schema->index('reviewType');
    }

    protected function create_seo_page_table() {

        $schema = $this->schema->create_table('seo_page');
        $schema->increments('seoId', ['type' => 'BIGINT', 'length' => '20']);
        $schema->integer('relatiedId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->string('seoTypePage', ['length' => '25']);
        $schema->text('seoTitle');
        $schema->text('seoDesc');
        $schema->string('seoKeyword', ['length' => '200']);
        $schema->string('seoRobots', ['length' => '20']);
        $schema->run();

        // ADD index
        $schema->index('relatiedId');
        $schema->index('seoTypePage');
    }

    protected function create_slider_table() {

        $schema = $this->schema->create_table('slider');
        $schema->increments('slideId', ['length' => '11']);
        $schema->string('slideTitle', ['length' => '150']);
        $schema->string('slideUri');
        $schema->text('slideDesc');
        $schema->string('slideType', ['length' => '20']);
        $schema->string('slideImg');
        $schema->string('slideDirFile', ['length' => '25']);
        $schema->string('slideAnimate', ['length' => '30']);
        $schema->enum('slideOverlay', ['y', 'n']);
        $schema->integer('slidePublish', ['length' => '3', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('slideType');
    }

    protected function create_store_table() {

        $schema = $this->schema->create_table('store');
        $schema->increments('storeId', ['length' => '11']);
        $schema->string('storeName', ['length' => '40']);
        $schema->integer('storeAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('storeUpdated', ['length' => '11', 'unsigned' => TRUE]);
        $schema->enum('storeDefault', ['y', 'n']);
        $schema->enum('storeActive', ['y', 'n']);
        $schema->integer('storeDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeDefault');
    }


    protected function create_tax_table() {

        $schema = $this->schema->create_table('tax');
        $schema->increments('taxId', ['length' => '11']);
        $schema->string('taxName', ['length' => '90']);
        $schema->decimal('taxRate', ['length' => '15,4']);
        $schema->enum('taxType', ['percentage', 'fix']);
        $schema->enum('taxActive', ['y', 'n']);
        $schema->integer('taxAdded', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('taxModified', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('taxDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

    }

    protected function create_tax_rule_table() {

        $schema = $this->schema->create_table('tax_rule');
        $schema->increments('txrId', ['length' => '11']);
        $schema->integer('taxId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->string('txrBehavior', ['length' => '50']);
        $schema->integer('txrPriority', ['length' => '5']);
        $schema->string('txrDesc', ['length' => '120']);
        $schema->run();

        // ADD index
        $schema->index('taxId');

    }

    protected function create_testimonial_table() {

        $schema = $this->schema->create_table('testimonial');
        $schema->increments('testiId', ['length' => '11']);
        $schema->string('testiName', ['length' => '100']);
        $schema->string('testiOcupation', ['length' => '100']);
        $schema->text('testiContent');
        $schema->string('testiDir', ['length' => '25']);
        $schema->string('testiImg');
        $schema->integer('testiStatus', ['type' => 'TINYINT', 'length' => '2', 'unsigned' => TRUE]);
        $schema->run();
    }

    protected function create_unit_weight_table() {

        $schema = $this->schema->create_table('unit_weight');
        $schema->increments('weightId', ['length' => '11']);
        $schema->string('weightTitle', ['length' => '35']);
        $schema->string('weightUnit', ['length' => '5']);
        $schema->decimal('weightValue', ['length' => '15,8']);
        $schema->enum('weightDefault', ['y', 'n']);
        $schema->run();
    }

    protected function create_unit_length_table() {

        $schema = $this->schema->create_table('unit_length');
        $schema->increments('lengthId', ['length' => '11']);
        $schema->string('lengthTitle', ['length' => '35']);
        $schema->string('lengthUnit', ['length' => '5']);
        $schema->decimal('lengthValue', ['length' => '15,8']);
        $schema->enum('lengthDefault', ['y', 'n']);
        $schema->run();
    }

    protected function create_users_table() {

        $schema = $this->schema->create_table('users');
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

    protected function create_users_level_table() {

        $schema = $this->schema->create_table('users_level');
        $schema->increments('levelId', ['length' => '10']);
        $schema->string('levelName');
        $schema->enum('levelActive', ['y', 'n']);
        $schema->run();

        // ADD index
        $schema->index('levelId');
    }

    protected function create_users_menu_table() {

        $schema = $this->schema->create_table('users_menu');
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

    protected function create_users_menu_access_table() {

        $schema = $this->schema->create_table('users_menu_access');
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

    protected function create_website_menu_table() {

        $schema = $this->schema->create_table('website_menu');
        $schema->increments('menuId', ['length' => '10']);
        $schema->integer('menuParentId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('menuRelationshipId', ['length' => '10', 'unsigned' => TRUE]);
        $schema->string('menuName');
        $schema->string('menuAccessType', ['length' => '50']);
        $schema->text('menuUrlAccess');
        $schema->integer('menuAddedDate', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('menuSort', ['type' => 'MEDIUMINT','length' => '11', 'unsigned' => TRUE]);
        $schema->enum('menuActive', ['y', 'n']);
        $schema->string('menuAttrClass');
        $schema->run();

        // ADD index
        $schema->index('menuParentId');
        $schema->index('menuRelationshipId');
    }

    protected function drop() {
        $this->schema->drop_table('addons');
        $this->schema->drop_table('ads');
        $this->schema->drop_table('ads_position');
        $this->schema->drop_table('android_device');
        $this->schema->drop_table('attribute');
        $this->schema->drop_table('attribute_group');
        $this->schema->drop_table('attribute_group_store');
        $this->schema->drop_table('attribute_relationship');
        $this->schema->drop_table('attribute_value');
        $this->schema->drop_table('attribute_store');
        $this->schema->drop_table('badges');
        $this->schema->drop_table('badge_relationship');
        $this->schema->drop_table('badge_store');
        $this->schema->drop_table('categories');
        $this->schema->drop_table('category_relationship');
        $this->schema->drop_table('category_store');
        $this->schema->drop_table('currency');
        $this->schema->drop_table('comments');
        $this->schema->drop_table('contents');
        $this->schema->drop_table('courier');
        $this->schema->drop_table('courier_cost');
        $this->schema->drop_table('courier_store');
        $this->schema->drop_table('cron_list');
        $this->schema->drop_table('dynamic_translations');
        $this->schema->drop_table('email_blacklist');
        $this->schema->drop_table('email_queue');
        $this->schema->drop_table('email_template');
        $this->schema->drop_table('gallery_pic');
        $this->schema->drop_table('geo_country');
        $this->schema->drop_table('geo_zone');
        $this->schema->drop_table('manufacturers');
        $this->schema->drop_table('manufacturers_store');
        $this->schema->drop_table('message');
        $this->schema->drop_table('options');
        $this->schema->drop_table('product');
        $this->schema->drop_table('product_attribute');
        $this->schema->drop_table('product_attribute_combination');
        $this->schema->drop_table('product_downloadable');
        $this->schema->drop_table('product_related');
        $this->schema->drop_table('product_images');
        $this->schema->drop_table('product_store');
        $this->schema->drop_table('review');
        $this->schema->drop_table('seo_page');
        $this->schema->drop_table('slider');
        $this->schema->drop_table('store');
        $this->schema->drop_table('tax');
        $this->schema->drop_table('tax_rule');
        $this->schema->drop_table('testimonial');
        $this->schema->drop_table('unit_weight');
        $this->schema->drop_table('unit_length');
        $this->schema->drop_table('users');
        $this->schema->drop_table('users_level');
        $this->schema->drop_table('users_menu');
        $this->schema->drop_table('users_menu_access');
        $this->schema->drop_table('website_menu');
    }

    function drop_one($name)
    {
        $this->schema->drop_table($name);
    }

    protected function test() {
        $fopen = fopen('file.txt', 'w');
        fputs($fopen, 'ok');
        fclose($fopen);
    }

    // ======= SEED
    protected function seed() {
        Self::seeder_ads_position_table();
        Self::seeder_currency_table();
        Self::seeder_dynamic_translations_table();
        Self::seeder_email_template_table();
        Self::seeder_options_table();
        Self::seeder_store_table();
        Self::seeder_users_table();
        Self::seeder_users_level_table();
        Self::seeder_users_menu_table();
        Self::seeder_users_menu_access_table();
        Self::seeder_geo_country_table();
        Self::seeder_geo_zone_table();
    }

    protected function seeder_ads_position_table() {

		$arr = [
			['name' => 'header', 'w' => '650', 'h' => '90'],
			['name' => 'headline_bottom', 'w' => '1000', 'h' => '90'],
			['name' => 'left_1', 'w' => '250', 'h' => '250'],
			['name' => 'left_2', 'w' => '250', 'h' => '250'],
			['name' => 'left_3', 'w' => '250', 'h' => '250'],
			['name' => 'left_4', 'w' => '250', 'h' => '250'],
			['name' => 'left_5', 'w' => '250', 'h' => '250'],
			['name' => 'left_6', 'w' => '250', 'h' => '250'],
			['name' => 'center_main_1', 'w' => '630', 'h' => '90'],
			['name' => 'center_main_2', 'w' => '630', 'h' => '90'],
			['name' => 'center_main_3', 'w' => '630', 'h' => '90'],
			['name' => 'center_main_4', 'w' => '630', 'h' => '90'],
			['name' => 'center_main_5', 'w' => '630', 'h' => '90'],
			['name' => 'center_main_6', 'w' => '630', 'h' => '90'],
			['name' => 'right_1', 'w' => '300', 'h' => '250'],
			['name' => 'right_2', 'w' => '300', 'h' => '250'],
			['name' => 'right_3', 'w' => '300', 'h' => '250'],
			['name' => 'right_4', 'w' => '300', 'h' => '250'],
			['name' => 'right_5', 'w' => '300', 'h' => '250'],
			['name' => 'right_6', 'w' => '300', 'h' => '250'],
		];
		foreach ( $arr as $item ) {
			$data = [
				'adposName' => $item['name'],
				'adposW' => $item['w'],
				'adposH' => $item['h'],
			];
			$this->mc->save('ads_position', $data);
		}
    }

    protected function seeder_currency_table() {

        $arr = [
            [
                'curTitle' => 'Rupiah',
				'curCode' => 'IDR',
				'curPrefixSymbol' => 'Rp',
				'curSuffixSymbol' => '',
				'curRate' => 1.00000000,
				'curForeignCurrencyToDefault' => 1.00000000,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Dollar Amerika',
				'curCode' => 'USD',
				'curPrefixSymbol' => '$',
				'curSuffixSymbol' => '',
				'curRate' => 0.00007173,
				'curForeignCurrencyToDefault' => 13940.50000000,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Ringgit Malaysia',
				'curCode' => 'MYR',
				'curPrefixSymbol' => 'RM',
				'curSuffixSymbol' => '',
				'curRate' => 0.00029496,
				'curForeignCurrencyToDefault' => 3390.26409300,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Dollar Singapura',
				'curCode' => 'SGD',
				'curPrefixSymbol' => '$',
				'curSuffixSymbol' => '',
				'curRate' => 0.00009759,
				'curForeignCurrencyToDefault' => 10246.61901100,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Euro',
				'curCode' => 'EUR',
				'curPrefixSymbol' => '',
				'curSuffixSymbol' => '€',
				'curRate' => 0.00006390,
				'curForeignCurrencyToDefault' => 15650.27737800,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Pound Sterling',
				'curCode' => 'GBP',
				'curPrefixSymbol' => '£',
				'curSuffixSymbol' => '',
				'curRate' => 0.00005758,
				'curForeignCurrencyToDefault' => 17366.98878200,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
            [
                'curTitle' => 'Baht',
				'curCode' => 'THB',
				'curPrefixSymbol' => '฿',
				'curSuffixSymbol' => '',
				'curRate' => 0.00221236,
				'curForeignCurrencyToDefault' => 452.00649000,
				'curDecimalPlace' => '2',
				'curModifiedDate' => 1563796386,
				'curUpdateMethod' => 'automatic',
				'curStatus' => 1,
            ],
        ];
        
		foreach ( $arr as $item ) {
			$data = [
				'curTitle' => $item['curTitle'],
				'curCode' => $item['curCode'],
				'curPrefixSymbol' => $item['curPrefixSymbol'],
				'curSuffixSymbol' => $item['curSuffixSymbol'],
				'curRate' => $item['curRate'],
				'curForeignCurrencyToDefault' => $item['curForeignCurrencyToDefault'],
				'curDecimalPlace' => $item['curDecimalPlace'],
				'curModifiedDate' => $item['curModifiedDate'],
				'curUpdateMethod' => $item['curUpdateMethod'],
				'curStatus' => $item['curStatus'],
			];
			$this->mc->save('currency', $data);
		}
    }

    protected function seeder_dynamic_translations_table() {

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
		];
		foreach ( $arr as $item ) {
			$data = [
                'dtRelatedTable'=>$item['dtRelatedTable'],
                'dtRelatedField'=>$item['dtRelatedField'],
                'dtRelatedId'=>$item['dtRelatedId'],
                'dtLang'=>$item['dtLang'],
                'dtTranslation'=>$item['dtTranslation'],
                'dtInputType'=>$item['dtInputType'],
                'dtCreateDate'=>$item['dtCreateDate'],
                'dtUpdateDate'=>$item['dtUpdateDate']
			];
			$this->mc->save('dynamic_translations', $data);
		}
    }

    protected function seeder_options_table() {
		$arr = [
            ['optionName' => 'sitename', 'storeId' => 1, 'optionValue' => 'E-Commerce Shiza'],
            ['optionName' => 'sitekeywords', 'storeId' => 1, 'optionValue' => 'framework, ci, codeigniter,shiza,ecommerce,ecoza'],
            ['optionName' => 'sitedescription', 'storeId' => 1, 'optionValue' => 'E-Commerce Shiza diciptakan untuk mempermudah pengguna dalam berjual beli online.'],
            ['optionName' => 'template', 'storeId' => 1, 'optionValue' => 'themekeren'],
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
        ];
        foreach ( $arr as $item ) {
            $data = [
                'optionName' => $item['optionName'],
                'storeId' => $item['storeId'],
                'optionValue' => $item['optionValue'],
            ];
            $this->mc->save('options', $data);
        }
    }

    protected function seeder_store_table() {
        $arr = [
            [
                'storeId' => 1,
                'storeName' => 'My Store',
                'storeAdded' => time2timestamp(),
                'storeUpdated' => time2timestamp(),
                'storeDefault' => 'y',
                'storeActive' => 'y',
                'storeDeleted' => 0
            ]
        ];
        foreach ( $arr as $item ) {
            $data = [
                'storeId' => $item['storeId'],
                'storeName' => $item['storeName'],
                'storeAdded' => $item['storeAdded'],
                'storeUpdated' => $item['storeUpdated'],
                'storeDefault' => $item['storeDefault'],
                'storeActive' => $item['storeActive'],
                'storeDeleted' => $item['storeDeleted'],
            ];
            $this->mc->save('store', $data);
        }
    }
    
    protected function seeder_users_table() {
        
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
		foreach ( $arr as $item ) {
			$data = [
				'userLogin' => $item['userLogin'],
				'userPass' => $item['userPass'],
				'userEmail' => $item['userEmail'],
				'userTlp' => $item['userTlp'],
				'userDisplayName' => $item['userDisplayName'],
				'levelId' => $item['levelId'],
				'userBlocked' => $item['userBlocked'],
				'userDelete' => $item['userDelete'],
				'userLastLogin' => $item['userLastLogin'],
				'userActivationKey' => $item['userActivationKey'],
				'userRegistered' => $item['userRegistered'],
				'userSession' => $item['userSession'],
				'userCheckPoint' => $item['userCheckPoint'],
				'userDir' => $item['userDir'],
				'userPic' => $item['userPic'],
				'userOnlineStatus' => $item['userOnlineStatus'],
				'userLang' => $item['userLang'],
			];
			$this->mc->save('users', $data);
		}
    }
    
    protected function seeder_users_level_table() {

		$arr = [
			['levelName' => 'Super Admin', 'levelActive' => 'y'],
			['levelName' => 'Admin', 'levelActive' => 'y'],
		];
		foreach ( $arr as $item ) {
			$data = [
				'levelName' => $item['levelName'],
				'levelActive' => $item['levelActive'],
			];
			$this->mc->save('users_level', $data);
		}
    }
    
    protected function seeder_users_menu_table() {
		$arr = [
            [
                'menuId' => '1',
                'menuParentId' => '0',
                'menuName' => 'Developer',
                'menuAccess' => '',
                'menuAddedDate' => '1452867589',
                'menuSort' => '7',
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
                'menuSort' => '6',
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
                'menuSort' => '5',
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
                'menuSort' => '4',
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
            ]
        ];
		foreach ( $arr as $item ) {
			$data = [
				'menuId' => $item['menuId'],
				'menuParentId' => $item['menuParentId'],
				'menuName' => $item['menuName'],
				'menuAccess' => $item['menuAccess'],
				'menuAddedDate' => $item['menuAddedDate'],
				'menuSort' => $item['menuSort'],
				'menuIcon' => $item['menuIcon'],
				'menuAttrClass' => $item['menuAttrClass'],
				'menuActive' => $item['menuActive'],
				'menuView' => $item['menuView'],
				'menuAdd' => $item['menuAdd'],
				'menuEdit' => $item['menuEdit'],
				'menuDelete' => $item['menuDelete'],
			];
			$this->mc->save('users_menu', $data);
		}
    }

    protected function seeder_users_menu_access_table() {
        
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
            ]
        ];
		foreach ( $arr as $item ) {
			$data = [
				'lmnId' => $item['lmnId'],
				'levelId' => $item['levelId'],
				'menuId' => $item['menuId'],
				'lmnView' => $item['lmnView'],
				'lmnAdd' => $item['lmnAdd'],
				'lmnEdit' => $item['lmnEdit'],
				'lmnDelete' => $item['lmnDelete'],
			];
			$this->mc->save('users_menu_access', $data);
		}
    }
    
    protected function seeder_email_template_table() {

		$arr = [
			[
                'tName' => 'Customer - Informasi Pembayaran', 
                'tEmail' => '<p>Bapak/Ibu {MEMBERNAME},<br />Dengan Hormat , Kami menerima pesanaan Poin dengan Nomor Invoice {INVOICE}.<br />------------------------------------------------------------<br />Lakukan pembayaran senilai {GRANDTOTAL} ke salah satu rekening:<br /><br />{BANK}<br />------------------------------------------------------------<br />Agar poin anda cepat diproses, konfirmasi pembayaran anda via sms/email.</p><p>Ke:</p><p>{SYSTEMMAIL}</p><p>{SYSTEMPHONE}</p><p><br />Pembayaran harus sesuai dengan yang tertera: {GRANDTOTAL} (Tidak dibulatkan).<br />Jika harus dibulatkan, informasikan ke kami melalui SMS/EMAIL, atau tulis pada kolom keterangan : {INVOICE} saat melakukan konfirmasi.<br /><br />Terima kasih atas kepercayaan anda pada {SYSTEMNAME}<br /><br />{SIGNATURE}<br /><br /><br />DETAIL ORDER:<br /><br />Customer Name : {MEMBERNAME}<br />Email : {MEMBEREMAIL}<br />Mobile Phone : {MEMBERTEL}<br />Order Date : {ORDERDATE}<br /><br />Your order:<br /><br />{ORDERPOINTDETAIL}<br /><br />Detail Pembayaran:<br />Kode Transaksi: {CODEID}<br />Total: {ORDERTOTAL}<br />----------------------------------------<br />Grand Total : {GRANDTOTAL}</p>', 
                'tEmailbak' => 'Mr/Mrs/Miss {MEMBERNAME}, <br /><span lang="en">Dear Sirs , We have received your order with invoice numbers</span>&nbsp;{INVOICE}. <br />------------------------------------------------------------ <br /><span lang="en">Please make a payment of</span>&nbsp;{GRANDTOTAL} <span lang="en">to one of the accounts</span>:<br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br /><span lang="en">In order to your order can be processed and delivered faster, confirm your payment via SMS/Email</span>. <br />Confirm your order via menu order and click the <strong>order confirmation</strong> button on the order that you have paid.<br /><br /><span lang="en">We hope you make a payment according to the total</span>&nbsp;{GRANDTOTAL} (<span lang="en">unrounded</span>). <br /><span lang="en">If it should be rounded</span>,&nbsp;<span lang="en">please inform us via SMS or email,</span> or write information coloumn at: {INVOICE} <br /><br /><span lang="en">Payments received no later than</span>: {ORDEREXP} <br /><span lang="en">After we receive your payment, your order will be handling and we will send it .</span>&nbsp;<br /><span lang="en">Receipt number will be informed via email after we send the package so that you can tracking.</span>&nbsp;<br /><br /><span lang="en">To cancel this order , click the <strong>Cancel</strong> button in the order you want to cancel. </span><br /><br /><span lang="en">Thank you for shopping at</span>&nbsp;{SITEURL} <br /><br />{SIGNATURE} <br /><br /><br />DETAIL ORDER: <br /><br />Customer Name : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Mobile Phone : {MEMBERTEL} <br />Order Date : {ORDERDATE} <br /><br />Your order: <br /><br />{ORDERDETAIL} <br /><br /><br />Your order will be sent to: <br />{MEMBERRECNAME} <br />{MEMBERADD} <br />{MEMBERTOWN} <br /><br />Shipping Method : {SHIPMETHOD} <br />Special Info : {MEMBERMSG} <br /><br />Detail Cost<br />Subtotal : {SUBTOTAL} <br />Tax({TAX}%) : {TAXAMOUNT} <br />Discount: {DISCOUNT} <br />Transaction Code: {CODEID} <br />Shipping Cost : {SHIPPRICE} <br />Shipping Cost Discount: {DISCOUNTSHIP} <br />---------------------------------------- <br />Grand Total : {GRANDTOTAL}'
            ],
			[
                'tName' => 'Order Reminder', 
                'tEmail' => 'Mr/Mrs/Miss {MEMBERNAME},<br />Dear Sir,<br /><span lang="en">This email is a reminder of your order with an invoice number</span>&nbsp;{INVOICE}.<br />&nbsp;------------------------------------------------------------ <br /><br />Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts: <br /><br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br />Your order details can be seen at the bottom of this email or click here:<br />{VERIFYCODE}<br />In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />Confirm yout order from the following link:<br />{ORDERCONFIRMATION}<br />We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br /><br />Payments received no later than: {ORDEREXP}<br />After we receive your payment, your order will be handling and we will send it . <br />Receipt number will be informed via email after we send the package so that you can tracking. <br /><br /><br />Thank you for shopping at {SITEURL}<br /><br />{SIGNATURE}', 
                'tEmailbak' => 'Mr/Mrs/Miss {MEMBERNAME},<br />Dear Sir,<br /><span lang="en">This email is a reminder of your order with an invoice number</span>&nbsp;{INVOICE}.<br />&nbsp;------------------------------------------------------------ <br /><br />Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts: <br /><br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br />Your order details can be seen at the bottom of this email or click here:<br />{VERIFYCODE}<br />In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />Confirm yout order from the following link:<br />{ORDERCONFIRMATION}<br />We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br /><br />Payments received no later than: {ORDEREXP}<br />After we receive your payment, your order will be handling and we will send it . <br />Receipt number will be informed via email after we send the package so that you can tracking. <br /><br /><br />Thank you for shopping at {SITEURL}<br /><br />{SIGNATURE}'
            ],
			[
                'tName' => 'Payment Received', 
                'tEmail' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With respect, <br /><br />We would like to inform you that your payment for the invoice number {INVOICE} has been received <br />on {CHECKRECDATE}. We have checked our account and with this fully ensure that your payment has been received. <br /><br />We are currently preparing the products you ordered and will be sent as soon as possible. <br />If your order has been sent, we will re-send email notifications.<br /><br />Thank you for payments you make and of course on your TRUST in&nbsp;{SITEURL}. <br /><br />{SIGNATURE}', 
                'tEmailbak' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With respect, <br /><br />We would like to inform you that your payment for the invoice number {INVOICE} has been received <br />on {CHECKRECDATE}. We have checked our account and with this fully ensure that your payment has been received. <br /><br />We are currently preparing the products you ordered and will be sent as soon as possible. <br />If your order has been sent, we will re-send email notifications.<br /><br />Thank you for payments you make and of course on your TRUST in&nbsp;{SITEURL}. <br /><br />{SIGNATURE}'
            ],
			[
                'tName' => 'Package Delivery Information', 
                'tEmail' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform you that your order in {SITEURL} has been processed. Products that we have sent you a message with the following information: <br />{SENTINFO} <br />{DIGITALPRODUCTLINK} <br /><br />Please inform us as soon as the order is received. Call us back if you have not received your order until the deadline. <br /><br />- <span id="result_box" lang="en"><span class="hps">If</span> <span class="hps">you are satisfied</span> <span class="hps">with</span> <span class="hps">our service and products</span><span>,</span> <span class="hps">please</span> <span class="hps">write</span> <span class="hps">a testimonial</span> <span class="hps">to</span> <span class="hps">reply to</span> <span class="hps">this email</span></span>. <br />- If you are not satisfied, submit your complaint. Your complaint must be delivered within max 1 week from when the order is received. <br /><br />Thanks for the order and the trust to us! <br /><br /><br />{SIGNATURE}', 
                'tEmailbak' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform you that your order in {SITEURL} has been processed. Products that we have sent you a message with the following information: <br />{SENTINFO} <br />{DIGITALPRODUCTLINK} <br /><br />Please inform us as soon as the order is received. Call us back if you have not received your order until the deadline. <br /><br />- <span id="result_box" lang="en"><span class="hps">If</span> <span class="hps">you are satisfied</span> <span class="hps">with</span> <span class="hps">our service and products</span><span>,</span> <span class="hps">please</span> <span class="hps">write</span> <span class="hps">a testimonial</span> <span class="hps">to</span> <span class="hps">reply to</span> <span class="hps">this email</span></span>. <br />- If you are not satisfied, submit your complaint. Your complaint must be delivered within max 1 week from when the order is received. <br /><br />Thanks for the order and the trust to us! <br /><br /><br />{SIGNATURE}'
            ],
			[
                'tName' => 'Order Delete', 
                'tEmail' => 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform that your order invoice number&nbsp;{INVOICE} has abort. The reason for cancellation due to one of the following reasons:<br />- You do not transfer until the payment due.<br />- Email data or the address you provide is invalid. <br />- You order two times or more.<br />-&nbsp;The other reason. <br /><br />You can order the products you ordered back to visit our website at&nbsp;{SITEURL} . <br />We beg your understanding on this matter and apologize if it has caused inconvenience. <br />Thank you for your attention.<br /><br /><br />{SIGNATURE}', 
                'tEmailbak' => 'Bapak/Ibu {MEMBERNAME},<br/>Dengan hormat, <br/><br/>Kami ingin menginformasikan bahwa pesanan Anda dengan nomor invoice {INVOICE} telah kami batalkan.<br/> Alasan pembatalan karena salah satu sebab berikut ini:<br/><br/> - Anda tidak melakukan transfer sampai batas waktu pembayaran. <br/> - Data email atau alamat yang Anda berikan tidak valid.<br/> - Anda memesan 2 kali atau lebih.<br/> - Alasan lainnya.<br/><br/>Anda dapat memesan kembali produk yang Anda pesan dengan mengunjungi website kami di {SITEURL}	.<br/>Kami memohon pengertian dari Bapak/Ibu atas hal ini dan memohon maaf jika telah menimbulkan ketidaknyamanan.<br/>Terima kasih atas perhatian Anda!<br/><br/>{SIGNATURE}'
            ],
			[
                'tName' => 'Payment Confirmation', 
                'tEmail' => 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}', 
                'tEmailbak' => 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}'
            ],
			[
                'tName' => 'Customer - Verify Email Change', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p>Dear Bapak/Ibu {MEMBERNAME},<br /><br />Anda telah melakukan permintaan perubahan alamat email anda di {SYSTEMNAME}.<br />Verify your email by clicking this link :<br /><br />{EMAILCHANGEVERIFYURL}<br /><br />(Copy and paste the link above into your browser if it can not click)<br /><br />Thank You.</p><p><strong>Abaikan email ini jika anda tidak merasa melakukan aktifitas ini</strong>.</p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Member - Verifikasi Email (Welcome)', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p><br />Anda telah bergabung di {SYSTEMNAME}.<br />Silahkan verifikasi akun anda dengan meng-klik link dibawah ini agar anda dapat masuk ke sistem kami:<br /><br /><a href="{VERIFYLINK}">{VERIFYLINK}</a><br /><br />(Copy paste link jika tidak bisa diklik)</p><p>Terima kasih.<br />&nbsp;</p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>With respect,<br /><br />Thanks for joining us on {SYSTEMNAME}.<br />Verify your email by clicking this link :<br /><br /><a href="{VERIFYLINK}">{VERIFYLINK}</a><br /><br />(Copy and paste the link above into your browser if it can not click)<br /><br />This link will expire within 1 hour. You can request verification email on customer area.<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Customer - Reset Password', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>With respect,<br /><br />Thanks for joining us on {SYSTEMNAME}.<br />Verify your email by clicking this link :<br /><br /><a href="{VERIFYLINK}">{VERIFYLINK}</a><br /><br />(Copy and paste the link above into your browser if it can not click)<br /><br />This link will expire within 1 hour. You can request verification email on customer area.<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table><table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {CUSTOMERNAME}, <br /> With respect, <br /><br /> Your password has been successfully changed. <br /> From now on, you have to log in using your email and your new password. <br /><br /> Thank You. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {CUSTOMERNAME},<br /><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> <span lang="en">Your password has been successfully changed.</span><br /><span lang="en">From now on, you have to log in using your email and your new password.</span><br /><br /> Thank You. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Customer - Selamat Datang (Admin)', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /><br />Terima kasih telah mendaftar di {SYSTEMNAME}.<br />Silahkan set password anda melalui link dibawah ini:<br />{FORGOTPASSWORDLINK}<br /><br />(copy link diatas ke browser jika tidak bisa di klik)<br /><br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {FORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /> Terima kasih. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - Welcome', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /> Terima kasih. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Customer - Forgot Password', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br />Dengan hormat,<br /><br />Anda atau orang lain telah melakukan permintaan reset password melalui fitur LUPA PASSWORD.<br />Jika anda ingin benar-benar melakukan reset password, klik link dibawah ini:<br /><br />{FORGOTPASSWORDLINK}<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /> Dengan hormat,<br /><br /> Anda atau seseorang telah melakukan request untuk melakukan reset password melalui fasilitas LUPA PASSWORD.<br />Password anda yang lama belum berubah. Jika anda ingin melakukan reset, lakukan langkah berikut: <br /><br /> {FORGOTPASSWORDLINK} <br /><br />Jika link diatas tidak bisa di-klik, silahkan copy dan paste link ke browser anda. <br /><br /> Masa berlaku link ini hanya 60 Menit.<br /> Abaikan email ini jika anda tidak merasa pernah melakukan permohonan reset password.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - Forgot Password', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - Verify Email Change', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {SUPPLIEREMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Dear,<br /><br /><span lang="en">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang="en">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Customer - Reset Password Success', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br />Dengan Hormat,<br /><br />Password anda sukses diganti.<br />Sekarang anda dapat login menggunakan password baru anda.<br /><br />Terima kasih.<br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td>Bapak/Ibu {SUPPLIERNAME},<br />Dengan hormat,<br /><br /> Password anda telah berhasil diubah. <br /> Mulai saat ini, anda harus login menggunakan email dan password baru anda. Gunakan kembali fitur FORGOT PASSWORD jika anda kembali lupa password. <br /><br /> Terima kasih. <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - Verify Email', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang="en">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}</td></tr><tr><td><span id="result_box" class="short_text" lang="en"><span class="hps">With</span> <span class="hps">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang="en">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang="en">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Purchase Order Information to Supplier', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Quotation Information to Owner', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Customer - Receipt', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="5" align="center"><tbody><tr><td colspan="2" align="center">{HEADER}</td></tr><tr><td colspan="2" align="center"><strong style="font-size: 24px;">RECEIPT</strong><br /><br /></td></tr><tr><td valign="top" width="35%">Number</td><td valign="top">:&nbsp;{KWITANSINUMBER}</td></tr><tr><td valign="top">Received From</td><td valign="top">:&nbsp;{MEMBERNAME}</td></tr><tr><td valign="top">In Payment for</td><td>:&nbsp;</td></tr><tr><td colspan="2">{DETAILKWITANSI}</td></tr><tr><td>Amount</td><td>: {GRANDTOTAL}</td></tr><tr><td colspan="2">&nbsp;<br /><br /><br /></td></tr><tr><td colspan="2" align="left"><hr /><div style="font-size: 10px; color: #999999;">{ADDITIONALINFO}</div></td></tr><tr><td colspan="2" align="left">&nbsp;<br /><br />{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="5" align="center"><tbody><tr><td colspan="2" align="center">{HEADER}</td></tr><tr><td colspan="2" align="center"><strong style="font-size: 24px;">RECEIPT</strong><br /><br /></td></tr><tr><td valign="top" width="35%"><em>Number</em></td><td valign="top">:&nbsp;{KWITANSINUMBER}</td></tr><tr><td valign="top"><em>Received From</em></td><td valign="top">:&nbsp;{MEMBERNAME}</td></tr><tr><td valign="top"><em>The SUM of</em></td><td>:&nbsp;<em>{TERBILANG} Rupiah</em></td></tr><tr><td valign="top"><em>In Payment for</em></td><td>:&nbsp;</td></tr><tr><td colspan="2">{DETAILKWITANSI}</td></tr><tr><td><em>Amount</em></td><td>:&nbsp;Rp {GRANDTOTAL}</td></tr><tr><td colspan="2">&nbsp;<br /><br /><br /></td></tr><tr><td colspan="2" align="left"><hr /><div style="font-size: 10px; color: #999999;">{PAYMENTINFO}</div></td></tr></tbody></table>'
            ],
			[
                'tName' => 'Re-Order PO Information', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Purchase Order Has Been Revised to Supplier', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Purchase Order Has Been Revised to Owner', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Owner - New Custom Design Information', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new custom design from customer with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - New Design Information', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Reminder of approval new PO to Supplier', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Reminder of approval new PO to Owner', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - Approve New Design', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have an <strong>approved</strong> new design from {MEMBERNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - Sending New Design', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Your new design&nbsp;<strong>{DESIGNNAME}</strong> has been sending by {MEMBERNAME}.<strong><br /><br /></strong>Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Owner - Custom Design Deleted By Customer', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> One of a new custom design has been canceled by each customer with design name <strong>{DESIGNNAME}</strong>.<br /><br />Thank You.<br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Owner - Pembayaran Order Poin Diterima', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td><p>Yang Terhormat {MEMBERNAME},<br /><br />Kami telah menerima pembayaran atas pesanan <strong>POIN</strong> anda dengan nomor invoice: #{INVOICE}</p><p>Secara otomaris poin anda telah ditambahkan.<br /><br />Terima kasih.<br /><br />&nbsp;</p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Supplier - Notification for create PO from Quotation', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Owner - Inactive Customer', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Owner - Customer is not Spending More than 2 Weeks', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Owner - Quotation request from new design', 
                'tEmail' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have an <strong>requested</strong> quotation of new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br />thank you.<br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table style="width: 800px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td align="center">{HEADER}<br /><br /></td></tr><tr><td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Coba Email Template', 
                'tEmail' => '<p>Assalamualaikum Wr Wb Yaa</p>', 
                'tEmailbak' => '<p>Assalamualaikum Wr Wb</p>'
            ],
			[
                'tName' => 'Email Customer Baru Dari Facebook', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /><br />Terima kasih telah mendaftar di {SYSTEMNAME}.<br />Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br /><br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}<br />&nbsp;</td></tr><tr><td>Bapak/Ibu {MEMBERNAME},<br /><br />Terima kasih telah mendaftar di {SYSTEMNAME}.<br />Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br /><br />&nbsp;</td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
			[
                'tName' => 'Pemberitahuan Pesan Baru', 
                'tEmail' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p>Bapak/Ibu {MEMBERNAME},<br />Dengan hormat,<br /><br />Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />&nbsp;</p><p><a href="{INBOXANSWERLINK}"><input name="Balas" type="button" value="Balas" /></a></p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>', 
                'tEmailbak' => '<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:800px"><tbody><tr><td>{HEADER}</td></tr><tr><td><p>Bapak/Ibu {MEMBERNAME},<br />Dengan hormat,<br /><br />Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />&nbsp;</p><p><input name="Balas" type="button" value="Balas" /></p></td></tr><tr><td>{SIGNATURE}</td></tr></tbody></table>'
            ],
		];
		foreach ( $arr as $item ) {
			$data = [
				'tName' => $item['tName'],
				'tEmail' => $item['tEmail'],
				'tEmailbak' => $item['tEmailbak'],
			];
			$this->mc->save('email_template', $data);
		}
    }

    protected function seeder_geo_country_table(){
        $arr = [
            ['countryId' => '1', 'countryName' => 'Afghanistan', 'countryIsoCode2' => 'AF', 'countryIsoCode3' => 'AFG', 'countryStatus' => '1'],
            ['countryId' => '2', 'countryName' => 'Albania', 'countryIsoCode2' => 'AL', 'countryIsoCode3' => 'ALB', 'countryStatus' => '1'],
            ['countryId' => '3', 'countryName' => 'Algeria', 'countryIsoCode2' => 'DZ', 'countryIsoCode3' => 'DZA', 'countryStatus' => '1'],
            ['countryId' => '4', 'countryName' => 'American Samoa', 'countryIsoCode2' => 'AS', 'countryIsoCode3' => 'ASM', 'countryStatus' => '1'],
            ['countryId' => '5', 'countryName' => 'Andorra', 'countryIsoCode2' => 'AD', 'countryIsoCode3' => 'AND', 'countryStatus' => '1'],
            ['countryId' => '6', 'countryName' => 'Angola', 'countryIsoCode2' => 'AO', 'countryIsoCode3' => 'AGO', 'countryStatus' => '1'],
            ['countryId' => '7', 'countryName' => 'Anguilla', 'countryIsoCode2' => 'AI', 'countryIsoCode3' => 'AIA', 'countryStatus' => '1'],
            ['countryId' => '8', 'countryName' => 'Antarctica', 'countryIsoCode2' => 'AQ', 'countryIsoCode3' => 'ATA', 'countryStatus' => '1'],
            ['countryId' => '9', 'countryName' => 'Antigua and Barbuda', 'countryIsoCode2' => 'AG', 'countryIsoCode3' => 'ATG', 'countryStatus' => '1'],
            ['countryId' => '10', 'countryName' => 'Argentina', 'countryIsoCode2' => 'AR', 'countryIsoCode3' => 'ARG', 'countryStatus' => '1'],
            ['countryId' => '11', 'countryName' => 'Armenia', 'countryIsoCode2' => 'AM', 'countryIsoCode3' => 'ARM', 'countryStatus' => '1'],
            ['countryId' => '12', 'countryName' => 'Aruba', 'countryIsoCode2' => 'AW', 'countryIsoCode3' => 'ABW', 'countryStatus' => '1'],
            ['countryId' => '13', 'countryName' => 'Australia', 'countryIsoCode2' => 'AU', 'countryIsoCode3' => 'AUS', 'countryStatus' => '1'],
            ['countryId' => '14', 'countryName' => 'Austria', 'countryIsoCode2' => 'AT', 'countryIsoCode3' => 'AUT', 'countryStatus' => '1'],
            ['countryId' => '15', 'countryName' => 'Azerbaijan', 'countryIsoCode2' => 'AZ', 'countryIsoCode3' => 'AZE', 'countryStatus' => '1'],
            ['countryId' => '16', 'countryName' => 'Bahamas', 'countryIsoCode2' => 'BS', 'countryIsoCode3' => 'BHS', 'countryStatus' => '1'],
            ['countryId' => '17', 'countryName' => 'Bahrain', 'countryIsoCode2' => 'BH', 'countryIsoCode3' => 'BHR', 'countryStatus' => '1'],
            ['countryId' => '18', 'countryName' => 'Bangladesh', 'countryIsoCode2' => 'BD', 'countryIsoCode3' => 'BGD', 'countryStatus' => '1'],
            ['countryId' => '19', 'countryName' => 'Barbados', 'countryIsoCode2' => 'BB', 'countryIsoCode3' => 'BRB', 'countryStatus' => '1'],
            ['countryId' => '20', 'countryName' => 'Belarus', 'countryIsoCode2' => 'BY', 'countryIsoCode3' => 'BLR', 'countryStatus' => '1'],
            ['countryId' => '21', 'countryName' => 'Belgium', 'countryIsoCode2' => 'BE', 'countryIsoCode3' => 'BEL', 'countryStatus' => '1'],
            ['countryId' => '22', 'countryName' => 'Belize', 'countryIsoCode2' => 'BZ', 'countryIsoCode3' => 'BLZ', 'countryStatus' => '1'],
            ['countryId' => '23', 'countryName' => 'Benin', 'countryIsoCode2' => 'BJ', 'countryIsoCode3' => 'BEN', 'countryStatus' => '1'],
            ['countryId' => '24', 'countryName' => 'Bermuda', 'countryIsoCode2' => 'BM', 'countryIsoCode3' => 'BMU', 'countryStatus' => '1'],
            ['countryId' => '25', 'countryName' => 'Bhutan', 'countryIsoCode2' => 'BT', 'countryIsoCode3' => 'BTN', 'countryStatus' => '1'],
            ['countryId' => '26', 'countryName' => 'Bolivia', 'countryIsoCode2' => 'BO', 'countryIsoCode3' => 'BOL', 'countryStatus' => '1'],
            ['countryId' => '27', 'countryName' => 'Bosnia and Herzegovina', 'countryIsoCode2' => 'BA', 'countryIsoCode3' => 'BIH', 'countryStatus' => '1'],
            ['countryId' => '28', 'countryName' => 'Botswana', 'countryIsoCode2' => 'BW', 'countryIsoCode3' => 'BWA', 'countryStatus' => '1'],
            ['countryId' => '29', 'countryName' => 'Bouvet Island', 'countryIsoCode2' => 'BV', 'countryIsoCode3' => 'BVT', 'countryStatus' => '1'],
            ['countryId' => '30', 'countryName' => 'Brazil', 'countryIsoCode2' => 'BR', 'countryIsoCode3' => 'BRA', 'countryStatus' => '1'],
            ['countryId' => '31', 'countryName' => 'British Indian Ocean Territory', 'countryIsoCode2' => 'IO', 'countryIsoCode3' => 'IOT', 'countryStatus' => '1'],
            ['countryId' => '32', 'countryName' => 'Brunei Darussalam', 'countryIsoCode2' => 'BN', 'countryIsoCode3' => 'BRN', 'countryStatus' => '1'],
            ['countryId' => '33', 'countryName' => 'Bulgaria', 'countryIsoCode2' => 'BG', 'countryIsoCode3' => 'BGR', 'countryStatus' => '1'],
            ['countryId' => '34', 'countryName' => 'Burkina Faso', 'countryIsoCode2' => 'BF', 'countryIsoCode3' => 'BFA', 'countryStatus' => '1'],
            ['countryId' => '35', 'countryName' => 'Burundi', 'countryIsoCode2' => 'BI', 'countryIsoCode3' => 'BDI', 'countryStatus' => '1'],
            ['countryId' => '36', 'countryName' => 'Cambodia', 'countryIsoCode2' => 'KH', 'countryIsoCode3' => 'KHM', 'countryStatus' => '1'],
            ['countryId' => '37', 'countryName' => 'Cameroon', 'countryIsoCode2' => 'CM', 'countryIsoCode3' => 'CMR', 'countryStatus' => '1'],
            ['countryId' => '38', 'countryName' => 'Canada', 'countryIsoCode2' => 'CA', 'countryIsoCode3' => 'CAN', 'countryStatus' => '1'],
            ['countryId' => '39', 'countryName' => 'Cape Verde', 'countryIsoCode2' => 'CV', 'countryIsoCode3' => 'CPV', 'countryStatus' => '1'],
            ['countryId' => '40', 'countryName' => 'Cayman Islands', 'countryIsoCode2' => 'KY', 'countryIsoCode3' => 'CYM', 'countryStatus' => '1'],
            ['countryId' => '41', 'countryName' => 'Central African Republic', 'countryIsoCode2' => 'CF', 'countryIsoCode3' => 'CAF', 'countryStatus' => '1'],
            ['countryId' => '42', 'countryName' => 'Chad', 'countryIsoCode2' => 'TD', 'countryIsoCode3' => 'TCD', 'countryStatus' => '1'],
            ['countryId' => '43', 'countryName' => 'Chile', 'countryIsoCode2' => 'CL', 'countryIsoCode3' => 'CHL', 'countryStatus' => '1'],
            ['countryId' => '44', 'countryName' => 'China', 'countryIsoCode2' => 'CN', 'countryIsoCode3' => 'CHN', 'countryStatus' => '1'],
            ['countryId' => '45', 'countryName' => 'Christmas Island', 'countryIsoCode2' => 'CX', 'countryIsoCode3' => 'CXR', 'countryStatus' => '1'],
            ['countryId' => '46', 'countryName' => 'Cocos (Keeling) Islands', 'countryIsoCode2' => 'CC', 'countryIsoCode3' => 'CCK', 'countryStatus' => '1'],
            ['countryId' => '47', 'countryName' => 'Colombia', 'countryIsoCode2' => 'CO', 'countryIsoCode3' => 'COL', 'countryStatus' => '1'],
            ['countryId' => '48', 'countryName' => 'Comoros', 'countryIsoCode2' => 'KM', 'countryIsoCode3' => 'COM', 'countryStatus' => '1'],
            ['countryId' => '49', 'countryName' => 'Congo', 'countryIsoCode2' => 'CG', 'countryIsoCode3' => 'COG', 'countryStatus' => '1'],
            ['countryId' => '50', 'countryName' => 'Cook Islands', 'countryIsoCode2' => 'CK', 'countryIsoCode3' => 'COK', 'countryStatus' => '1'],
            ['countryId' => '51', 'countryName' => 'Costa Rica', 'countryIsoCode2' => 'CR', 'countryIsoCode3' => 'CRI', 'countryStatus' => '1'],
            ['countryId' => '52', 'countryName' => 'Cote D\'Ivoire', 'countryIsoCode2' => 'CI', 'countryIsoCode3' => 'CIV', 'countryStatus' => '1'],
            ['countryId' => '53', 'countryName' => 'Croatia', 'countryIsoCode2' => 'HR', 'countryIsoCode3' => 'HRV', 'countryStatus' => '1'],
            ['countryId' => '54', 'countryName' => 'Cuba', 'countryIsoCode2' => 'CU', 'countryIsoCode3' => 'CUB', 'countryStatus' => '1'],
            ['countryId' => '55', 'countryName' => 'Cyprus', 'countryIsoCode2' => 'CY', 'countryIsoCode3' => 'CYP', 'countryStatus' => '1'],
            ['countryId' => '56', 'countryName' => 'Czech Republic', 'countryIsoCode2' => 'CZ', 'countryIsoCode3' => 'CZE', 'countryStatus' => '1'],
            ['countryId' => '57', 'countryName' => 'Denmark', 'countryIsoCode2' => 'DK', 'countryIsoCode3' => 'DNK', 'countryStatus' => '1'],
            ['countryId' => '58', 'countryName' => 'Djibouti', 'countryIsoCode2' => 'DJ', 'countryIsoCode3' => 'DJI', 'countryStatus' => '1'],
            ['countryId' => '59', 'countryName' => 'Dominica', 'countryIsoCode2' => 'DM', 'countryIsoCode3' => 'DMA', 'countryStatus' => '1'],
            ['countryId' => '60', 'countryName' => 'Dominican Republic', 'countryIsoCode2' => 'DO', 'countryIsoCode3' => 'DOM', 'countryStatus' => '1'],
            ['countryId' => '61', 'countryName' => 'East Timor', 'countryIsoCode2' => 'TL', 'countryIsoCode3' => 'TLS', 'countryStatus' => '1'],
            ['countryId' => '62', 'countryName' => 'Ecuador', 'countryIsoCode2' => 'EC', 'countryIsoCode3' => 'ECU', 'countryStatus' => '1'],
            ['countryId' => '63', 'countryName' => 'Egypt', 'countryIsoCode2' => 'EG', 'countryIsoCode3' => 'EGY', 'countryStatus' => '1'],
            ['countryId' => '64', 'countryName' => 'El Salvador', 'countryIsoCode2' => 'SV', 'countryIsoCode3' => 'SLV', 'countryStatus' => '1'],
            ['countryId' => '65', 'countryName' => 'Equatorial Guinea', 'countryIsoCode2' => 'GQ', 'countryIsoCode3' => 'GNQ', 'countryStatus' => '1'],
            ['countryId' => '66', 'countryName' => 'Eritrea', 'countryIsoCode2' => 'ER', 'countryIsoCode3' => 'ERI', 'countryStatus' => '1'],
            ['countryId' => '67', 'countryName' => 'Estonia', 'countryIsoCode2' => 'EE', 'countryIsoCode3' => 'EST', 'countryStatus' => '1'],
            ['countryId' => '68', 'countryName' => 'Ethiopia', 'countryIsoCode2' => 'ET', 'countryIsoCode3' => 'ETH', 'countryStatus' => '1'],
            ['countryId' => '69', 'countryName' => 'Falkland Islands (Malvinas)', 'countryIsoCode2' => 'FK', 'countryIsoCode3' => 'FLK', 'countryStatus' => '1'],
            ['countryId' => '70', 'countryName' => 'Faroe Islands', 'countryIsoCode2' => 'FO', 'countryIsoCode3' => 'FRO', 'countryStatus' => '1'],
            ['countryId' => '71', 'countryName' => 'Fiji', 'countryIsoCode2' => 'FJ', 'countryIsoCode3' => 'FJI', 'countryStatus' => '1'],
            ['countryId' => '72', 'countryName' => 'Finland', 'countryIsoCode2' => 'FI', 'countryIsoCode3' => 'FIN', 'countryStatus' => '1'],
            ['countryId' => '74', 'countryName' => 'France, Metropolitan', 'countryIsoCode2' => 'FR', 'countryIsoCode3' => 'FRA', 'countryStatus' => '1'],
            ['countryId' => '75', 'countryName' => 'French Guiana', 'countryIsoCode2' => 'GF', 'countryIsoCode3' => 'GUF', 'countryStatus' => '1'],
            ['countryId' => '76', 'countryName' => 'French Polynesia', 'countryIsoCode2' => 'PF', 'countryIsoCode3' => 'PYF', 'countryStatus' => '1'],
            ['countryId' => '77', 'countryName' => 'French Southern Territories', 'countryIsoCode2' => 'TF', 'countryIsoCode3' => 'ATF', 'countryStatus' => '1'],
            ['countryId' => '78', 'countryName' => 'Gabon', 'countryIsoCode2' => 'GA', 'countryIsoCode3' => 'GAB', 'countryStatus' => '1'],
            ['countryId' => '79', 'countryName' => 'Gambia', 'countryIsoCode2' => 'GM', 'countryIsoCode3' => 'GMB', 'countryStatus' => '1'],
            ['countryId' => '80', 'countryName' => 'Georgia', 'countryIsoCode2' => 'GE', 'countryIsoCode3' => 'GEO', 'countryStatus' => '1'],
            ['countryId' => '81', 'countryName' => 'Germany', 'countryIsoCode2' => 'DE', 'countryIsoCode3' => 'DEU', 'countryStatus' => '1'],
            ['countryId' => '82', 'countryName' => 'Ghana', 'countryIsoCode2' => 'GH', 'countryIsoCode3' => 'GHA', 'countryStatus' => '1'],
            ['countryId' => '83', 'countryName' => 'Gibraltar', 'countryIsoCode2' => 'GI', 'countryIsoCode3' => 'GIB', 'countryStatus' => '1'],
            ['countryId' => '84', 'countryName' => 'Greece', 'countryIsoCode2' => 'GR', 'countryIsoCode3' => 'GRC', 'countryStatus' => '1'],
            ['countryId' => '85', 'countryName' => 'Greenland', 'countryIsoCode2' => 'GL', 'countryIsoCode3' => 'GRL', 'countryStatus' => '1'],
            ['countryId' => '86', 'countryName' => 'Grenada', 'countryIsoCode2' => 'GD', 'countryIsoCode3' => 'GRD', 'countryStatus' => '1'],
            ['countryId' => '87', 'countryName' => 'Guadeloupe', 'countryIsoCode2' => 'GP', 'countryIsoCode3' => 'GLP', 'countryStatus' => '1'],
            ['countryId' => '88', 'countryName' => 'Guam', 'countryIsoCode2' => 'GU', 'countryIsoCode3' => 'GUM', 'countryStatus' => '1'],
            ['countryId' => '89', 'countryName' => 'Guatemala', 'countryIsoCode2' => 'GT', 'countryIsoCode3' => 'GTM', 'countryStatus' => '1'],
            ['countryId' => '90', 'countryName' => 'Guinea', 'countryIsoCode2' => 'GN', 'countryIsoCode3' => 'GIN', 'countryStatus' => '1'],
            ['countryId' => '91', 'countryName' => 'Guinea-Bissau', 'countryIsoCode2' => 'GW', 'countryIsoCode3' => 'GNB', 'countryStatus' => '1'],
            ['countryId' => '92', 'countryName' => 'Guyana', 'countryIsoCode2' => 'GY', 'countryIsoCode3' => 'GUY', 'countryStatus' => '1'],
            ['countryId' => '93', 'countryName' => 'Haiti', 'countryIsoCode2' => 'HT', 'countryIsoCode3' => 'HTI', 'countryStatus' => '1'],
            ['countryId' => '94', 'countryName' => 'Heard and Mc Donald Islands', 'countryIsoCode2' => 'HM', 'countryIsoCode3' => 'HMD', 'countryStatus' => '1'],
            ['countryId' => '95', 'countryName' => 'Honduras', 'countryIsoCode2' => 'HN', 'countryIsoCode3' => 'HND', 'countryStatus' => '1'],
            ['countryId' => '96', 'countryName' => 'Hong Kong', 'countryIsoCode2' => 'HK', 'countryIsoCode3' => 'HKG', 'countryStatus' => '1'],
            ['countryId' => '97', 'countryName' => 'Hungary', 'countryIsoCode2' => 'HU', 'countryIsoCode3' => 'HUN', 'countryStatus' => '1'],
            ['countryId' => '98', 'countryName' => 'Iceland', 'countryIsoCode2' => 'IS', 'countryIsoCode3' => 'ISL', 'countryStatus' => '1'],
            ['countryId' => '99', 'countryName' => 'India', 'countryIsoCode2' => 'IN', 'countryIsoCode3' => 'IND', 'countryStatus' => '1'],
            ['countryId' => '100', 'countryName' => 'Indonesia', 'countryIsoCode2' => 'ID', 'countryIsoCode3' => 'IDN', 'countryStatus' => '1'],
            ['countryId' => '101', 'countryName' => 'Iran (Islamic Republic of)', 'countryIsoCode2' => 'IR', 'countryIsoCode3' => 'IRN', 'countryStatus' => '1'],
            ['countryId' => '102', 'countryName' => 'Iraq', 'countryIsoCode2' => 'IQ', 'countryIsoCode3' => 'IRQ', 'countryStatus' => '1'],
            ['countryId' => '103', 'countryName' => 'Ireland', 'countryIsoCode2' => 'IE', 'countryIsoCode3' => 'IRL', 'countryStatus' => '1'],
            ['countryId' => '104', 'countryName' => 'Israel', 'countryIsoCode2' => 'IL', 'countryIsoCode3' => 'ISR', 'countryStatus' => '1'],
            ['countryId' => '105', 'countryName' => 'Italy', 'countryIsoCode2' => 'IT', 'countryIsoCode3' => 'ITA', 'countryStatus' => '1'],
            ['countryId' => '106', 'countryName' => 'Jamaica', 'countryIsoCode2' => 'JM', 'countryIsoCode3' => 'JAM', 'countryStatus' => '1'],
            ['countryId' => '107', 'countryName' => 'Japan', 'countryIsoCode2' => 'JP', 'countryIsoCode3' => 'JPN', 'countryStatus' => '1'],
            ['countryId' => '108', 'countryName' => 'Jordan', 'countryIsoCode2' => 'JO', 'countryIsoCode3' => 'JOR', 'countryStatus' => '1'],
            ['countryId' => '109', 'countryName' => 'Kazakhstan', 'countryIsoCode2' => 'KZ', 'countryIsoCode3' => 'KAZ', 'countryStatus' => '1'],
            ['countryId' => '110', 'countryName' => 'Kenya', 'countryIsoCode2' => 'KE', 'countryIsoCode3' => 'KEN', 'countryStatus' => '1'],
            ['countryId' => '111', 'countryName' => 'Kiribati', 'countryIsoCode2' => 'KI', 'countryIsoCode3' => 'KIR', 'countryStatus' => '1'],
            ['countryId' => '112', 'countryName' => 'North Korea', 'countryIsoCode2' => 'KP', 'countryIsoCode3' => 'PRK', 'countryStatus' => '1'],
            ['countryId' => '113', 'countryName' => 'South Korea', 'countryIsoCode2' => 'KR', 'countryIsoCode3' => 'KOR', 'countryStatus' => '1'],
            ['countryId' => '114', 'countryName' => 'Kuwait', 'countryIsoCode2' => 'KW', 'countryIsoCode3' => 'KWT', 'countryStatus' => '1'],
            ['countryId' => '115', 'countryName' => 'Kyrgyzstan', 'countryIsoCode2' => 'KG', 'countryIsoCode3' => 'KGZ', 'countryStatus' => '1'],
            ['countryId' => '116', 'countryName' => 'Lao People\'s Democratic Republic', 'countryIsoCode2' => 'LA', 'countryIsoCode3' => 'LAO', 'countryStatus' => '1'],
            ['countryId' => '117', 'countryName' => 'Latvia', 'countryIsoCode2' => 'LV', 'countryIsoCode3' => 'LVA', 'countryStatus' => '1'],
            ['countryId' => '118', 'countryName' => 'Lebanon', 'countryIsoCode2' => 'LB', 'countryIsoCode3' => 'LBN', 'countryStatus' => '1'],
            ['countryId' => '119', 'countryName' => 'Lesotho', 'countryIsoCode2' => 'LS', 'countryIsoCode3' => 'LSO', 'countryStatus' => '1'],
            ['countryId' => '120', 'countryName' => 'Liberia', 'countryIsoCode2' => 'LR', 'countryIsoCode3' => 'LBR', 'countryStatus' => '1'],
            ['countryId' => '121', 'countryName' => 'Libyan Arab Jamahiriya', 'countryIsoCode2' => 'LY', 'countryIsoCode3' => 'LBY', 'countryStatus' => '1'],
            ['countryId' => '122', 'countryName' => 'Liechtenstein', 'countryIsoCode2' => 'LI', 'countryIsoCode3' => 'LIE', 'countryStatus' => '1'],
            ['countryId' => '123', 'countryName' => 'Lithuania', 'countryIsoCode2' => 'LT', 'countryIsoCode3' => 'LTU', 'countryStatus' => '1'],
            ['countryId' => '124', 'countryName' => 'Luxembourg', 'countryIsoCode2' => 'LU', 'countryIsoCode3' => 'LUX', 'countryStatus' => '1'],
            ['countryId' => '125', 'countryName' => 'Macau', 'countryIsoCode2' => 'MO', 'countryIsoCode3' => 'MAC', 'countryStatus' => '1'],
            ['countryId' => '126', 'countryName' => 'FYROM', 'countryIsoCode2' => 'MK', 'countryIsoCode3' => 'MKD', 'countryStatus' => '1'],
            ['countryId' => '127', 'countryName' => 'Madagascar', 'countryIsoCode2' => 'MG', 'countryIsoCode3' => 'MDG', 'countryStatus' => '1'],
            ['countryId' => '128', 'countryName' => 'Malawi', 'countryIsoCode2' => 'MW', 'countryIsoCode3' => 'MWI', 'countryStatus' => '1'],
            ['countryId' => '129', 'countryName' => 'Malaysia', 'countryIsoCode2' => 'MY', 'countryIsoCode3' => 'MYS', 'countryStatus' => '1'],
            ['countryId' => '130', 'countryName' => 'Maldives', 'countryIsoCode2' => 'MV', 'countryIsoCode3' => 'MDV', 'countryStatus' => '1'],
            ['countryId' => '131', 'countryName' => 'Mali', 'countryIsoCode2' => 'ML', 'countryIsoCode3' => 'MLI', 'countryStatus' => '1'],
            ['countryId' => '132', 'countryName' => 'Malta', 'countryIsoCode2' => 'MT', 'countryIsoCode3' => 'MLT', 'countryStatus' => '1'],
            ['countryId' => '133', 'countryName' => 'Marshall Islands', 'countryIsoCode2' => 'MH', 'countryIsoCode3' => 'MHL', 'countryStatus' => '1'],
            ['countryId' => '134', 'countryName' => 'Martinique', 'countryIsoCode2' => 'MQ', 'countryIsoCode3' => 'MTQ', 'countryStatus' => '1'],
            ['countryId' => '135', 'countryName' => 'Mauritania', 'countryIsoCode2' => 'MR', 'countryIsoCode3' => 'MRT', 'countryStatus' => '1'],
            ['countryId' => '136', 'countryName' => 'Mauritius', 'countryIsoCode2' => 'MU', 'countryIsoCode3' => 'MUS', 'countryStatus' => '1'],
            ['countryId' => '137', 'countryName' => 'Mayotte', 'countryIsoCode2' => 'YT', 'countryIsoCode3' => 'MYT', 'countryStatus' => '1'],
            ['countryId' => '138', 'countryName' => 'Mexico', 'countryIsoCode2' => 'MX', 'countryIsoCode3' => 'MEX', 'countryStatus' => '1'],
            ['countryId' => '139', 'countryName' => 'Micronesia, Federated States of', 'countryIsoCode2' => 'FM', 'countryIsoCode3' => 'FSM', 'countryStatus' => '1'],
            ['countryId' => '140', 'countryName' => 'Moldova, Republic of', 'countryIsoCode2' => 'MD', 'countryIsoCode3' => 'MDA', 'countryStatus' => '1'],
            ['countryId' => '141', 'countryName' => 'Monaco', 'countryIsoCode2' => 'MC', 'countryIsoCode3' => 'MCO', 'countryStatus' => '1'],
            ['countryId' => '142', 'countryName' => 'Mongolia', 'countryIsoCode2' => 'MN', 'countryIsoCode3' => 'MNG', 'countryStatus' => '1'],
            ['countryId' => '143', 'countryName' => 'Montserrat', 'countryIsoCode2' => 'MS', 'countryIsoCode3' => 'MSR', 'countryStatus' => '1'],
            ['countryId' => '144', 'countryName' => 'Morocco', 'countryIsoCode2' => 'MA', 'countryIsoCode3' => 'MAR', 'countryStatus' => '1'],
            ['countryId' => '145', 'countryName' => 'Mozambique', 'countryIsoCode2' => 'MZ', 'countryIsoCode3' => 'MOZ', 'countryStatus' => '1'],
            ['countryId' => '146', 'countryName' => 'Myanmar', 'countryIsoCode2' => 'MM', 'countryIsoCode3' => 'MMR', 'countryStatus' => '1'],
            ['countryId' => '147', 'countryName' => 'Namibia', 'countryIsoCode2' => 'NA', 'countryIsoCode3' => 'NAM', 'countryStatus' => '1'],
            ['countryId' => '148', 'countryName' => 'Nauru', 'countryIsoCode2' => 'NR', 'countryIsoCode3' => 'NRU', 'countryStatus' => '1'],
            ['countryId' => '149', 'countryName' => 'Nepal', 'countryIsoCode2' => 'NP', 'countryIsoCode3' => 'NPL', 'countryStatus' => '1'],
            ['countryId' => '150', 'countryName' => 'Netherlands', 'countryIsoCode2' => 'NL', 'countryIsoCode3' => 'NLD', 'countryStatus' => '1'],
            ['countryId' => '151', 'countryName' => 'Netherlands Antilles', 'countryIsoCode2' => 'AN', 'countryIsoCode3' => 'ANT', 'countryStatus' => '1'],
            ['countryId' => '152', 'countryName' => 'New Caledonia', 'countryIsoCode2' => 'NC', 'countryIsoCode3' => 'NCL', 'countryStatus' => '1'],
            ['countryId' => '153', 'countryName' => 'New Zealand', 'countryIsoCode2' => 'NZ', 'countryIsoCode3' => 'NZL', 'countryStatus' => '1'],
            ['countryId' => '154', 'countryName' => 'Nicaragua', 'countryIsoCode2' => 'NI', 'countryIsoCode3' => 'NIC', 'countryStatus' => '1'],
            ['countryId' => '155', 'countryName' => 'Niger', 'countryIsoCode2' => 'NE', 'countryIsoCode3' => 'NER', 'countryStatus' => '1'],
            ['countryId' => '156', 'countryName' => 'Nigeria', 'countryIsoCode2' => 'NG', 'countryIsoCode3' => 'NGA', 'countryStatus' => '1'],
            ['countryId' => '157', 'countryName' => 'Niue', 'countryIsoCode2' => 'NU', 'countryIsoCode3' => 'NIU', 'countryStatus' => '1'],
            ['countryId' => '158', 'countryName' => 'Norfolk Island', 'countryIsoCode2' => 'NF', 'countryIsoCode3' => 'NFK', 'countryStatus' => '1'],
            ['countryId' => '159', 'countryName' => 'Northern Mariana Islands', 'countryIsoCode2' => 'MP', 'countryIsoCode3' => 'MNP', 'countryStatus' => '1'],
            ['countryId' => '160', 'countryName' => 'Norway', 'countryIsoCode2' => 'NO', 'countryIsoCode3' => 'NOR', 'countryStatus' => '1'],
            ['countryId' => '161', 'countryName' => 'Oman', 'countryIsoCode2' => 'OM', 'countryIsoCode3' => 'OMN', 'countryStatus' => '1'],
            ['countryId' => '162', 'countryName' => 'Pakistan', 'countryIsoCode2' => 'PK', 'countryIsoCode3' => 'PAK', 'countryStatus' => '1'],
            ['countryId' => '163', 'countryName' => 'Palau', 'countryIsoCode2' => 'PW', 'countryIsoCode3' => 'PLW', 'countryStatus' => '1'],
            ['countryId' => '164', 'countryName' => 'Panama', 'countryIsoCode2' => 'PA', 'countryIsoCode3' => 'PAN', 'countryStatus' => '1'],
            ['countryId' => '165', 'countryName' => 'Papua New Guinea', 'countryIsoCode2' => 'PG', 'countryIsoCode3' => 'PNG', 'countryStatus' => '1'],
            ['countryId' => '166', 'countryName' => 'Paraguay', 'countryIsoCode2' => 'PY', 'countryIsoCode3' => 'PRY', 'countryStatus' => '1'],
            ['countryId' => '167', 'countryName' => 'Peru', 'countryIsoCode2' => 'PE', 'countryIsoCode3' => 'PER', 'countryStatus' => '1'],
            ['countryId' => '168', 'countryName' => 'Philippines', 'countryIsoCode2' => 'PH', 'countryIsoCode3' => 'PHL', 'countryStatus' => '1'],
            ['countryId' => '169', 'countryName' => 'Pitcairn', 'countryIsoCode2' => 'PN', 'countryIsoCode3' => 'PCN', 'countryStatus' => '1'],
            ['countryId' => '170', 'countryName' => 'Poland', 'countryIsoCode2' => 'PL', 'countryIsoCode3' => 'POL', 'countryStatus' => '1'],
            ['countryId' => '171', 'countryName' => 'Portugal', 'countryIsoCode2' => 'PT', 'countryIsoCode3' => 'PRT', 'countryStatus' => '1'],
            ['countryId' => '172', 'countryName' => 'Puerto Rico', 'countryIsoCode2' => 'PR', 'countryIsoCode3' => 'PRI', 'countryStatus' => '1'],
            ['countryId' => '173', 'countryName' => 'Qatar', 'countryIsoCode2' => 'QA', 'countryIsoCode3' => 'QAT', 'countryStatus' => '1'],
            ['countryId' => '174', 'countryName' => 'Reunion', 'countryIsoCode2' => 'RE', 'countryIsoCode3' => 'REU', 'countryStatus' => '1'],
            ['countryId' => '175', 'countryName' => 'Romania', 'countryIsoCode2' => 'RO', 'countryIsoCode3' => 'ROM', 'countryStatus' => '1'],
            ['countryId' => '176', 'countryName' => 'Russian Federation', 'countryIsoCode2' => 'RU', 'countryIsoCode3' => 'RUS', 'countryStatus' => '1'],
            ['countryId' => '177', 'countryName' => 'Rwanda', 'countryIsoCode2' => 'RW', 'countryIsoCode3' => 'RWA', 'countryStatus' => '1'],
            ['countryId' => '178', 'countryName' => 'Saint Kitts and Nevis', 'countryIsoCode2' => 'KN', 'countryIsoCode3' => 'KNA', 'countryStatus' => '1'],
            ['countryId' => '179', 'countryName' => 'Saint Lucia', 'countryIsoCode2' => 'LC', 'countryIsoCode3' => 'LCA', 'countryStatus' => '1'],
            ['countryId' => '180', 'countryName' => 'Saint Vincent and the Grenadines', 'countryIsoCode2' => 'VC', 'countryIsoCode3' => 'VCT', 'countryStatus' => '1'],
            ['countryId' => '181', 'countryName' => 'Samoa', 'countryIsoCode2' => 'WS', 'countryIsoCode3' => 'WSM', 'countryStatus' => '1'],
            ['countryId' => '182', 'countryName' => 'San Marino', 'countryIsoCode2' => 'SM', 'countryIsoCode3' => 'SMR', 'countryStatus' => '1'],
            ['countryId' => '183', 'countryName' => 'Sao Tome and Principe', 'countryIsoCode2' => 'ST', 'countryIsoCode3' => 'STP', 'countryStatus' => '1'],
            ['countryId' => '184', 'countryName' => 'Saudi Arabia', 'countryIsoCode2' => 'SA', 'countryIsoCode3' => 'SAU', 'countryStatus' => '1'],
            ['countryId' => '185', 'countryName' => 'Senegal', 'countryIsoCode2' => 'SN', 'countryIsoCode3' => 'SEN', 'countryStatus' => '1'],
            ['countryId' => '186', 'countryName' => 'Seychelles', 'countryIsoCode2' => 'SC', 'countryIsoCode3' => 'SYC', 'countryStatus' => '1'],
            ['countryId' => '187', 'countryName' => 'Sierra Leone', 'countryIsoCode2' => 'SL', 'countryIsoCode3' => 'SLE', 'countryStatus' => '1'],
            ['countryId' => '188', 'countryName' => 'Singapore', 'countryIsoCode2' => 'SG', 'countryIsoCode3' => 'SGP', 'countryStatus' => '1'],
            ['countryId' => '189', 'countryName' => 'Slovak Republic', 'countryIsoCode2' => 'SK', 'countryIsoCode3' => 'SVK', 'countryStatus' => '1'],
            ['countryId' => '190', 'countryName' => 'Slovenia', 'countryIsoCode2' => 'SI', 'countryIsoCode3' => 'SVN', 'countryStatus' => '1'],
            ['countryId' => '191', 'countryName' => 'Solomon Islands', 'countryIsoCode2' => 'SB', 'countryIsoCode3' => 'SLB', 'countryStatus' => '1'],
            ['countryId' => '192', 'countryName' => 'Somalia', 'countryIsoCode2' => 'SO', 'countryIsoCode3' => 'SOM', 'countryStatus' => '1'],
            ['countryId' => '193', 'countryName' => 'South Africa', 'countryIsoCode2' => 'ZA', 'countryIsoCode3' => 'ZAF', 'countryStatus' => '1'],
            ['countryId' => '194', 'countryName' => 'South Georgia &amp; South Sandwich Islands', 'countryIsoCode2' => 'GS', 'countryIsoCode3' => 'SGS', 'countryStatus' => '1'],
            ['countryId' => '195', 'countryName' => 'Spain', 'countryIsoCode2' => 'ES', 'countryIsoCode3' => 'ESP', 'countryStatus' => '1'],
            ['countryId' => '196', 'countryName' => 'Sri Lanka', 'countryIsoCode2' => 'LK', 'countryIsoCode3' => 'LKA', 'countryStatus' => '1'],
            ['countryId' => '197', 'countryName' => 'St. Helena', 'countryIsoCode2' => 'SH', 'countryIsoCode3' => 'SHN', 'countryStatus' => '1'],
            ['countryId' => '198', 'countryName' => 'St. Pierre and Miquelon', 'countryIsoCode2' => 'PM', 'countryIsoCode3' => 'SPM', 'countryStatus' => '1'],
            ['countryId' => '199', 'countryName' => 'Sudan', 'countryIsoCode2' => 'SD', 'countryIsoCode3' => 'SDN', 'countryStatus' => '1'],
            ['countryId' => '200', 'countryName' => 'Suriname', 'countryIsoCode2' => 'SR', 'countryIsoCode3' => 'SUR', 'countryStatus' => '1'],
            ['countryId' => '201', 'countryName' => 'Svalbard and Jan Mayen Islands', 'countryIsoCode2' => 'SJ', 'countryIsoCode3' => 'SJM', 'countryStatus' => '1'],
            ['countryId' => '202', 'countryName' => 'Swaziland', 'countryIsoCode2' => 'SZ', 'countryIsoCode3' => 'SWZ', 'countryStatus' => '1'],
            ['countryId' => '203', 'countryName' => 'Sweden', 'countryIsoCode2' => 'SE', 'countryIsoCode3' => 'SWE', 'countryStatus' => '1'],
            ['countryId' => '204', 'countryName' => 'Switzerland', 'countryIsoCode2' => 'CH', 'countryIsoCode3' => 'CHE', 'countryStatus' => '1'],
            ['countryId' => '205', 'countryName' => 'Syrian Arab Republic', 'countryIsoCode2' => 'SY', 'countryIsoCode3' => 'SYR', 'countryStatus' => '1'],
            ['countryId' => '206', 'countryName' => 'Taiwan', 'countryIsoCode2' => 'TW', 'countryIsoCode3' => 'TWN', 'countryStatus' => '1'],
            ['countryId' => '207', 'countryName' => 'Tajikistan', 'countryIsoCode2' => 'TJ', 'countryIsoCode3' => 'TJK', 'countryStatus' => '1'],
            ['countryId' => '208', 'countryName' => 'Tanzania, United Republic of', 'countryIsoCode2' => 'TZ', 'countryIsoCode3' => 'TZA', 'countryStatus' => '1'],
            ['countryId' => '209', 'countryName' => 'Thailand', 'countryIsoCode2' => 'TH', 'countryIsoCode3' => 'THA', 'countryStatus' => '1'],
            ['countryId' => '210', 'countryName' => 'Togo', 'countryIsoCode2' => 'TG', 'countryIsoCode3' => 'TGO', 'countryStatus' => '1'],
            ['countryId' => '211', 'countryName' => 'Tokelau', 'countryIsoCode2' => 'TK', 'countryIsoCode3' => 'TKL', 'countryStatus' => '1'],
            ['countryId' => '212', 'countryName' => 'Tonga', 'countryIsoCode2' => 'TO', 'countryIsoCode3' => 'TON', 'countryStatus' => '1'],
            ['countryId' => '213', 'countryName' => 'Trinidad and Tobago', 'countryIsoCode2' => 'TT', 'countryIsoCode3' => 'TTO', 'countryStatus' => '1'],
            ['countryId' => '214', 'countryName' => 'Tunisia', 'countryIsoCode2' => 'TN', 'countryIsoCode3' => 'TUN', 'countryStatus' => '1'],
            ['countryId' => '215', 'countryName' => 'Turkey', 'countryIsoCode2' => 'TR', 'countryIsoCode3' => 'TUR', 'countryStatus' => '1'],
            ['countryId' => '216', 'countryName' => 'Turkmenistan', 'countryIsoCode2' => 'TM', 'countryIsoCode3' => 'TKM', 'countryStatus' => '1'],
            ['countryId' => '217', 'countryName' => 'Turks and Caicos Islands', 'countryIsoCode2' => 'TC', 'countryIsoCode3' => 'TCA', 'countryStatus' => '1'],
            ['countryId' => '218', 'countryName' => 'Tuvalu', 'countryIsoCode2' => 'TV', 'countryIsoCode3' => 'TUV', 'countryStatus' => '1'],
            ['countryId' => '219', 'countryName' => 'Uganda', 'countryIsoCode2' => 'UG', 'countryIsoCode3' => 'UGA', 'countryStatus' => '1'],
            ['countryId' => '220', 'countryName' => 'Ukraine', 'countryIsoCode2' => 'UA', 'countryIsoCode3' => 'UKR', 'countryStatus' => '1'],
            ['countryId' => '221', 'countryName' => 'United Arab Emirates', 'countryIsoCode2' => 'AE', 'countryIsoCode3' => 'ARE', 'countryStatus' => '1'],
            ['countryId' => '222', 'countryName' => 'United Kingdom', 'countryIsoCode2' => 'GB', 'countryIsoCode3' => 'GBR', 'countryStatus' => '1'],
            ['countryId' => '223', 'countryName' => 'United States', 'countryIsoCode2' => 'US', 'countryIsoCode3' => 'USA', 'countryStatus' => '1'],
            ['countryId' => '224', 'countryName' => 'United States Minor Outlying Islands', 'countryIsoCode2' => 'UM', 'countryIsoCode3' => 'UMI', 'countryStatus' => '1'],
            ['countryId' => '225', 'countryName' => 'Uruguay', 'countryIsoCode2' => 'UY', 'countryIsoCode3' => 'URY', 'countryStatus' => '1'],
            ['countryId' => '226', 'countryName' => 'Uzbekistan', 'countryIsoCode2' => 'UZ', 'countryIsoCode3' => 'UZB', 'countryStatus' => '1'],
            ['countryId' => '227', 'countryName' => 'Vanuatu', 'countryIsoCode2' => 'VU', 'countryIsoCode3' => 'VUT', 'countryStatus' => '1'],
            ['countryId' => '228', 'countryName' => 'Vatican City State (Holy See)', 'countryIsoCode2' => 'VA', 'countryIsoCode3' => 'VAT', 'countryStatus' => '1'],
            ['countryId' => '229', 'countryName' => 'Venezuela', 'countryIsoCode2' => 'VE', 'countryIsoCode3' => 'VEN', 'countryStatus' => '1'],
            ['countryId' => '230', 'countryName' => 'Viet Nam', 'countryIsoCode2' => 'VN', 'countryIsoCode3' => 'VNM', 'countryStatus' => '1'],
            ['countryId' => '231', 'countryName' => 'Virgin Islands (British)', 'countryIsoCode2' => 'VG', 'countryIsoCode3' => 'VGB', 'countryStatus' => '1'],
            ['countryId' => '232', 'countryName' => 'Virgin Islands (U.S.)', 'countryIsoCode2' => 'VI', 'countryIsoCode3' => 'VIR', 'countryStatus' => '1'],
            ['countryId' => '233', 'countryName' => 'Wallis and Futuna Islands', 'countryIsoCode2' => 'WF', 'countryIsoCode3' => 'WLF', 'countryStatus' => '1'],
            ['countryId' => '234', 'countryName' => 'Western Sahara', 'countryIsoCode2' => 'EH', 'countryIsoCode3' => 'ESH', 'countryStatus' => '1'],
            ['countryId' => '235', 'countryName' => 'Yemen', 'countryIsoCode2' => 'YE', 'countryIsoCode3' => 'YEM', 'countryStatus' => '1'],
            ['countryId' => '237', 'countryName' => 'Democratic Republic of Congo', 'countryIsoCode2' => 'CD', 'countryIsoCode3' => 'COD', 'countryStatus' => '1'],
            ['countryId' => '238', 'countryName' => 'Zambia', 'countryIsoCode2' => 'ZM', 'countryIsoCode3' => 'ZMB', 'countryStatus' => '1'],
            ['countryId' => '239', 'countryName' => 'Zimbabwe', 'countryIsoCode2' => 'ZW', 'countryIsoCode3' => 'ZWE', 'countryStatus' => '1'],
            ['countryId' => '242', 'countryName' => 'Montenegro', 'countryIsoCode2' => 'ME', 'countryIsoCode3' => 'MNE', 'countryStatus' => '1'],
            ['countryId' => '243', 'countryName' => 'Serbia', 'countryIsoCode2' => 'RS', 'countryIsoCode3' => 'SRB', 'countryStatus' => '1'],
            ['countryId' => '244', 'countryName' => 'Aaland Islands', 'countryIsoCode2' => 'AX', 'countryIsoCode3' => 'ALA', 'countryStatus' => '1'],
            ['countryId' => '245', 'countryName' => 'Bonaire, Sint Eustatius and Saba', 'countryIsoCode2' => 'BQ', 'countryIsoCode3' => 'BES', 'countryStatus' => '1'],
            ['countryId' => '246', 'countryName' => 'Curacao', 'countryIsoCode2' => 'CW', 'countryIsoCode3' => 'CUW', 'countryStatus' => '1'],
            ['countryId' => '247', 'countryName' => 'Palestinian Territory, Occupied', 'countryIsoCode2' => 'PS', 'countryIsoCode3' => 'PSE', 'countryStatus' => '1'],
            ['countryId' => '248', 'countryName' => 'South Sudan', 'countryIsoCode2' => 'SS', 'countryIsoCode3' => 'SSD', 'countryStatus' => '1'],
            ['countryId' => '249', 'countryName' => 'St. Barthelemy', 'countryIsoCode2' => 'BL', 'countryIsoCode3' => 'BLM', 'countryStatus' => '1'],
            ['countryId' => '250', 'countryName' => 'St. Martin (French part)', 'countryIsoCode2' => 'MF', 'countryIsoCode3' => 'MAF', 'countryStatus' => '1'],
            ['countryId' => '251', 'countryName' => 'Canary Islands', 'countryIsoCode2' => 'IC', 'countryIsoCode3' => 'ICA', 'countryStatus' => '1'],
            ['countryId' => '252', 'countryName' => 'Ascension Island (British)', 'countryIsoCode2' => 'AC', 'countryIsoCode3' => 'ASC', 'countryStatus' => '1'],
            ['countryId' => '253', 'countryName' => 'Kosovo, Republic of', 'countryIsoCode2' => 'XK', 'countryIsoCode3' => 'UNK', 'countryStatus' => '1'],
            ['countryId' => '254', 'countryName' => 'Isle of Man', 'countryIsoCode2' => 'IM', 'countryIsoCode3' => 'IMN', 'countryStatus' => '1'],
            ['countryId' => '255', 'countryName' => 'Tristan da Cunha', 'countryIsoCode2' => 'TA', 'countryIsoCode3' => 'SHN', 'countryStatus' => '1'],
            ['countryId' => '256', 'countryName' => 'Guernsey', 'countryIsoCode2' => 'GG', 'countryIsoCode3' => 'GGY', 'countryStatus' => '1'],
            ['countryId' => '257', 'countryName' => 'Jersey', 'countryIsoCode2' => 'JE', 'countryIsoCode3' => 'JEY', 'countryStatus' => '1']
        ];

		foreach ( $arr as $item ) {
			$data = [
				'countryId' => $item['countryId'],
				'countryName' => $item['countryName'],
				'countryIsoCode2' => $item['countryIsoCode2'],
				'countryIsoCode3' => $item['countryIsoCode3'],
                'countryStatus' => $item['countryStatus'],
                'countryDeleted' => 0
			];
			$this->mc->save('geo_country', $data);
		}
    }

    protected function seeder_geo_zone_table(){

        $arr = [
            ['zoneId' => '1', 'countryId' => '1', 'zoneName' => 'Badakhshan', 'zoneCode' => 'BDS', 'zoneStatus' => '1'],
            ['zoneId' => '2', 'countryId' => '1', 'zoneName' => 'Badghis', 'zoneCode' => 'BDG', 'zoneStatus' => '1'],
            ['zoneId' => '3', 'countryId' => '1', 'zoneName' => 'Baghlan', 'zoneCode' => 'BGL', 'zoneStatus' => '1'],
            ['zoneId' => '4', 'countryId' => '1', 'zoneName' => 'Balkh', 'zoneCode' => 'BAL', 'zoneStatus' => '1'],
            ['zoneId' => '5', 'countryId' => '1', 'zoneName' => 'Bamian', 'zoneCode' => 'BAM', 'zoneStatus' => '1'],
            ['zoneId' => '6', 'countryId' => '1', 'zoneName' => 'Farah', 'zoneCode' => 'FRA', 'zoneStatus' => '1'],
            ['zoneId' => '7', 'countryId' => '1', 'zoneName' => 'Faryab', 'zoneCode' => 'FYB', 'zoneStatus' => '1'],
            ['zoneId' => '8', 'countryId' => '1', 'zoneName' => 'Ghazni', 'zoneCode' => 'GHA', 'zoneStatus' => '1'],
            ['zoneId' => '9', 'countryId' => '1', 'zoneName' => 'Ghowr', 'zoneCode' => 'GHO', 'zoneStatus' => '1'],
            ['zoneId' => '10', 'countryId' => '1', 'zoneName' => 'Helmand', 'zoneCode' => 'HEL', 'zoneStatus' => '1'],
            ['zoneId' => '11', 'countryId' => '1', 'zoneName' => 'Herat', 'zoneCode' => 'HER', 'zoneStatus' => '1'],
            ['zoneId' => '12', 'countryId' => '1', 'zoneName' => 'Jowzjan', 'zoneCode' => 'JOW', 'zoneStatus' => '1'],
            ['zoneId' => '13', 'countryId' => '1', 'zoneName' => 'Kabul', 'zoneCode' => 'KAB', 'zoneStatus' => '1'],
            ['zoneId' => '14', 'countryId' => '1', 'zoneName' => 'Kandahar', 'zoneCode' => 'KAN', 'zoneStatus' => '1'],
            ['zoneId' => '15', 'countryId' => '1', 'zoneName' => 'Kapisa', 'zoneCode' => 'KAP', 'zoneStatus' => '1'],
            ['zoneId' => '16', 'countryId' => '1', 'zoneName' => 'Khost', 'zoneCode' => 'KHO', 'zoneStatus' => '1'],
            ['zoneId' => '17', 'countryId' => '1', 'zoneName' => 'Konar', 'zoneCode' => 'KNR', 'zoneStatus' => '1'],
            ['zoneId' => '18', 'countryId' => '1', 'zoneName' => 'Kondoz', 'zoneCode' => 'KDZ', 'zoneStatus' => '1'],
            ['zoneId' => '19', 'countryId' => '1', 'zoneName' => 'Laghman', 'zoneCode' => 'LAG', 'zoneStatus' => '1'],
            ['zoneId' => '20', 'countryId' => '1', 'zoneName' => 'Lowgar', 'zoneCode' => 'LOW', 'zoneStatus' => '1'],
            ['zoneId' => '21', 'countryId' => '1', 'zoneName' => 'Nangrahar', 'zoneCode' => 'NAN', 'zoneStatus' => '1'],
            ['zoneId' => '22', 'countryId' => '1', 'zoneName' => 'Nimruz', 'zoneCode' => 'NIM', 'zoneStatus' => '1'],
            ['zoneId' => '23', 'countryId' => '1', 'zoneName' => 'Nurestan', 'zoneCode' => 'NUR', 'zoneStatus' => '1'],
            ['zoneId' => '24', 'countryId' => '1', 'zoneName' => 'Oruzgan', 'zoneCode' => 'ORU', 'zoneStatus' => '1'],
            ['zoneId' => '25', 'countryId' => '1', 'zoneName' => 'Paktia', 'zoneCode' => 'PIA', 'zoneStatus' => '1'],
            ['zoneId' => '26', 'countryId' => '1', 'zoneName' => 'Paktika', 'zoneCode' => 'PKA', 'zoneStatus' => '1'],
            ['zoneId' => '27', 'countryId' => '1', 'zoneName' => 'Parwan', 'zoneCode' => 'PAR', 'zoneStatus' => '1'],
            ['zoneId' => '28', 'countryId' => '1', 'zoneName' => 'Samangan', 'zoneCode' => 'SAM', 'zoneStatus' => '1'],
            ['zoneId' => '29', 'countryId' => '1', 'zoneName' => 'Sar-e Pol', 'zoneCode' => 'SAR', 'zoneStatus' => '1'],
            ['zoneId' => '30', 'countryId' => '1', 'zoneName' => 'Takhar', 'zoneCode' => 'TAK', 'zoneStatus' => '1'],
            ['zoneId' => '31', 'countryId' => '1', 'zoneName' => 'Wardak', 'zoneCode' => 'WAR', 'zoneStatus' => '1'],
            ['zoneId' => '32', 'countryId' => '1', 'zoneName' => 'Zabol', 'zoneCode' => 'ZAB', 'zoneStatus' => '1'],
            ['zoneId' => '33', 'countryId' => '2', 'zoneName' => 'Berat', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '34', 'countryId' => '2', 'zoneName' => 'Bulqize', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '35', 'countryId' => '2', 'zoneName' => 'Delvine', 'zoneCode' => 'DL', 'zoneStatus' => '1'],
            ['zoneId' => '36', 'countryId' => '2', 'zoneName' => 'Devoll', 'zoneCode' => 'DV', 'zoneStatus' => '1'],
            ['zoneId' => '37', 'countryId' => '2', 'zoneName' => 'Diber', 'zoneCode' => 'DI', 'zoneStatus' => '1'],
            ['zoneId' => '38', 'countryId' => '2', 'zoneName' => 'Durres', 'zoneCode' => 'DR', 'zoneStatus' => '1'],
            ['zoneId' => '39', 'countryId' => '2', 'zoneName' => 'Elbasan', 'zoneCode' => 'EL', 'zoneStatus' => '1'],
            ['zoneId' => '40', 'countryId' => '2', 'zoneName' => 'Kolonje', 'zoneCode' => 'ER', 'zoneStatus' => '1'],
            ['zoneId' => '41', 'countryId' => '2', 'zoneName' => 'Fier', 'zoneCode' => 'FR', 'zoneStatus' => '1'],
            ['zoneId' => '42', 'countryId' => '2', 'zoneName' => 'Gjirokaster', 'zoneCode' => 'GJ', 'zoneStatus' => '1'],
            ['zoneId' => '43', 'countryId' => '2', 'zoneName' => 'Gramsh', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '44', 'countryId' => '2', 'zoneName' => 'Has', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '45', 'countryId' => '2', 'zoneName' => 'Kavaje', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '46', 'countryId' => '2', 'zoneName' => 'Kurbin', 'zoneCode' => 'KB', 'zoneStatus' => '1'],
            ['zoneId' => '47', 'countryId' => '2', 'zoneName' => 'Kucove', 'zoneCode' => 'KC', 'zoneStatus' => '1'],
            ['zoneId' => '48', 'countryId' => '2', 'zoneName' => 'Korce', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '49', 'countryId' => '2', 'zoneName' => 'Kruje', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '50', 'countryId' => '2', 'zoneName' => 'Kukes', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '51', 'countryId' => '2', 'zoneName' => 'Librazhd', 'zoneCode' => 'LB', 'zoneStatus' => '1'],
            ['zoneId' => '52', 'countryId' => '2', 'zoneName' => 'Lezhe', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '53', 'countryId' => '2', 'zoneName' => 'Lushnje', 'zoneCode' => 'LU', 'zoneStatus' => '1'],
            ['zoneId' => '54', 'countryId' => '2', 'zoneName' => 'Malesi e Madhe', 'zoneCode' => 'MM', 'zoneStatus' => '1'],
            ['zoneId' => '55', 'countryId' => '2', 'zoneName' => 'Mallakaster', 'zoneCode' => 'MK', 'zoneStatus' => '1'],
            ['zoneId' => '56', 'countryId' => '2', 'zoneName' => 'Mat', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '57', 'countryId' => '2', 'zoneName' => 'Mirdite', 'zoneCode' => 'MR', 'zoneStatus' => '1'],
            ['zoneId' => '58', 'countryId' => '2', 'zoneName' => 'Peqin', 'zoneCode' => 'PQ', 'zoneStatus' => '1'],
            ['zoneId' => '59', 'countryId' => '2', 'zoneName' => 'Permet', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '60', 'countryId' => '2', 'zoneName' => 'Pogradec', 'zoneCode' => 'PG', 'zoneStatus' => '1'],
            ['zoneId' => '61', 'countryId' => '2', 'zoneName' => 'Puke', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '62', 'countryId' => '2', 'zoneName' => 'Shkoder', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '63', 'countryId' => '2', 'zoneName' => 'Skrapar', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '64', 'countryId' => '2', 'zoneName' => 'Sarande', 'zoneCode' => 'SR', 'zoneStatus' => '1'],
            ['zoneId' => '65', 'countryId' => '2', 'zoneName' => 'Tepelene', 'zoneCode' => 'TE', 'zoneStatus' => '1'],
            ['zoneId' => '66', 'countryId' => '2', 'zoneName' => 'Tropoje', 'zoneCode' => 'TP', 'zoneStatus' => '1'],
            ['zoneId' => '67', 'countryId' => '2', 'zoneName' => 'Tirane', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '68', 'countryId' => '2', 'zoneName' => 'Vlore', 'zoneCode' => 'VL', 'zoneStatus' => '1'],
            ['zoneId' => '69', 'countryId' => '3', 'zoneName' => 'Adrar', 'zoneCode' => 'ADR', 'zoneStatus' => '1'],
            ['zoneId' => '70', 'countryId' => '3', 'zoneName' => 'Ain Defla', 'zoneCode' => 'ADE', 'zoneStatus' => '1'],
            ['zoneId' => '71', 'countryId' => '3', 'zoneName' => 'Ain Temouchent', 'zoneCode' => 'ATE', 'zoneStatus' => '1'],
            ['zoneId' => '72', 'countryId' => '3', 'zoneName' => 'Alger', 'zoneCode' => 'ALG', 'zoneStatus' => '1'],
            ['zoneId' => '73', 'countryId' => '3', 'zoneName' => 'Annaba', 'zoneCode' => 'ANN', 'zoneStatus' => '1'],
            ['zoneId' => '74', 'countryId' => '3', 'zoneName' => 'Batna', 'zoneCode' => 'BAT', 'zoneStatus' => '1'],
            ['zoneId' => '75', 'countryId' => '3', 'zoneName' => 'Bechar', 'zoneCode' => 'BEC', 'zoneStatus' => '1'],
            ['zoneId' => '76', 'countryId' => '3', 'zoneName' => 'Bejaia', 'zoneCode' => 'BEJ', 'zoneStatus' => '1'],
            ['zoneId' => '77', 'countryId' => '3', 'zoneName' => 'Biskra', 'zoneCode' => 'BIS', 'zoneStatus' => '1'],
            ['zoneId' => '78', 'countryId' => '3', 'zoneName' => 'Blida', 'zoneCode' => 'BLI', 'zoneStatus' => '1'],
            ['zoneId' => '79', 'countryId' => '3', 'zoneName' => 'Bordj Bou Arreridj', 'zoneCode' => 'BBA', 'zoneStatus' => '1'],
            ['zoneId' => '80', 'countryId' => '3', 'zoneName' => 'Bouira', 'zoneCode' => 'BOA', 'zoneStatus' => '1'],
            ['zoneId' => '81', 'countryId' => '3', 'zoneName' => 'Boumerdes', 'zoneCode' => 'BMD', 'zoneStatus' => '1'],
            ['zoneId' => '82', 'countryId' => '3', 'zoneName' => 'Chlef', 'zoneCode' => 'CHL', 'zoneStatus' => '1'],
            ['zoneId' => '83', 'countryId' => '3', 'zoneName' => 'Constantine', 'zoneCode' => 'CON', 'zoneStatus' => '1'],
            ['zoneId' => '84', 'countryId' => '3', 'zoneName' => 'Djelfa', 'zoneCode' => 'DJE', 'zoneStatus' => '1'],
            ['zoneId' => '85', 'countryId' => '3', 'zoneName' => 'El Bayadh', 'zoneCode' => 'EBA', 'zoneStatus' => '1'],
            ['zoneId' => '86', 'countryId' => '3', 'zoneName' => 'El Oued', 'zoneCode' => 'EOU', 'zoneStatus' => '1'],
            ['zoneId' => '87', 'countryId' => '3', 'zoneName' => 'El Tarf', 'zoneCode' => 'ETA', 'zoneStatus' => '1'],
            ['zoneId' => '88', 'countryId' => '3', 'zoneName' => 'Ghardaia', 'zoneCode' => 'GHA', 'zoneStatus' => '1'],
            ['zoneId' => '89', 'countryId' => '3', 'zoneName' => 'Guelma', 'zoneCode' => 'GUE', 'zoneStatus' => '1'],
            ['zoneId' => '90', 'countryId' => '3', 'zoneName' => 'Illizi', 'zoneCode' => 'ILL', 'zoneStatus' => '1'],
            ['zoneId' => '91', 'countryId' => '3', 'zoneName' => 'Jijel', 'zoneCode' => 'JIJ', 'zoneStatus' => '1'],
            ['zoneId' => '92', 'countryId' => '3', 'zoneName' => 'Khenchela', 'zoneCode' => 'KHE', 'zoneStatus' => '1'],
            ['zoneId' => '93', 'countryId' => '3', 'zoneName' => 'Laghouat', 'zoneCode' => 'LAG', 'zoneStatus' => '1'],
            ['zoneId' => '94', 'countryId' => '3', 'zoneName' => 'Muaskar', 'zoneCode' => 'MUA', 'zoneStatus' => '1'],
            ['zoneId' => '95', 'countryId' => '3', 'zoneName' => 'Medea', 'zoneCode' => 'MED', 'zoneStatus' => '1'],
            ['zoneId' => '96', 'countryId' => '3', 'zoneName' => 'Mila', 'zoneCode' => 'MIL', 'zoneStatus' => '1'],
            ['zoneId' => '97', 'countryId' => '3', 'zoneName' => 'Mostaganem', 'zoneCode' => 'MOS', 'zoneStatus' => '1'],
            ['zoneId' => '98', 'countryId' => '3', 'zoneName' => 'M\'Sila', 'zoneCode' => 'MSI', 'zoneStatus' => '1'],
            ['zoneId' => '99', 'countryId' => '3', 'zoneName' => 'Naama', 'zoneCode' => 'NAA', 'zoneStatus' => '1'],
            ['zoneId' => '100', 'countryId' => '3', 'zoneName' => 'Oran', 'zoneCode' => 'ORA', 'zoneStatus' => '1'],
            ['zoneId' => '101', 'countryId' => '3', 'zoneName' => 'Ouargla', 'zoneCode' => 'OUA', 'zoneStatus' => '1'],
            ['zoneId' => '102', 'countryId' => '3', 'zoneName' => 'Oum el-Bouaghi', 'zoneCode' => 'OEB', 'zoneStatus' => '1'],
            ['zoneId' => '103', 'countryId' => '3', 'zoneName' => 'Relizane', 'zoneCode' => 'REL', 'zoneStatus' => '1'],
            ['zoneId' => '104', 'countryId' => '3', 'zoneName' => 'Saida', 'zoneCode' => 'SAI', 'zoneStatus' => '1'],
            ['zoneId' => '105', 'countryId' => '3', 'zoneName' => 'Setif', 'zoneCode' => 'SET', 'zoneStatus' => '1'],
            ['zoneId' => '106', 'countryId' => '3', 'zoneName' => 'Sidi Bel Abbes', 'zoneCode' => 'SBA', 'zoneStatus' => '1'],
            ['zoneId' => '107', 'countryId' => '3', 'zoneName' => 'Skikda', 'zoneCode' => 'SKI', 'zoneStatus' => '1'],
            ['zoneId' => '108', 'countryId' => '3', 'zoneName' => 'Souk Ahras', 'zoneCode' => 'SAH', 'zoneStatus' => '1'],
            ['zoneId' => '109', 'countryId' => '3', 'zoneName' => 'Tamanghasset', 'zoneCode' => 'TAM', 'zoneStatus' => '1'],
            ['zoneId' => '110', 'countryId' => '3', 'zoneName' => 'Tebessa', 'zoneCode' => 'TEB', 'zoneStatus' => '1'],
            ['zoneId' => '111', 'countryId' => '3', 'zoneName' => 'Tiaret', 'zoneCode' => 'TIA', 'zoneStatus' => '1'],
            ['zoneId' => '112', 'countryId' => '3', 'zoneName' => 'Tindouf', 'zoneCode' => 'TIN', 'zoneStatus' => '1'],
            ['zoneId' => '113', 'countryId' => '3', 'zoneName' => 'Tipaza', 'zoneCode' => 'TIP', 'zoneStatus' => '1'],
            ['zoneId' => '114', 'countryId' => '3', 'zoneName' => 'Tissemsilt', 'zoneCode' => 'TIS', 'zoneStatus' => '1'],
            ['zoneId' => '115', 'countryId' => '3', 'zoneName' => 'Tizi Ouzou', 'zoneCode' => 'TOU', 'zoneStatus' => '1'],
            ['zoneId' => '116', 'countryId' => '3', 'zoneName' => 'Tlemcen', 'zoneCode' => 'TLE', 'zoneStatus' => '1'],
            ['zoneId' => '117', 'countryId' => '4', 'zoneName' => 'Eastern', 'zoneCode' => 'E', 'zoneStatus' => '1'],
            ['zoneId' => '118', 'countryId' => '4', 'zoneName' => 'Manu\'a', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '119', 'countryId' => '4', 'zoneName' => 'Rose Island', 'zoneCode' => 'R', 'zoneStatus' => '1'],
            ['zoneId' => '120', 'countryId' => '4', 'zoneName' => 'Swains Island', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '121', 'countryId' => '4', 'zoneName' => 'Western', 'zoneCode' => 'W', 'zoneStatus' => '1'],
            ['zoneId' => '122', 'countryId' => '5', 'zoneName' => 'Andorra la Vella', 'zoneCode' => 'ALV', 'zoneStatus' => '1'],
            ['zoneId' => '123', 'countryId' => '5', 'zoneName' => 'Canillo', 'zoneCode' => 'CAN', 'zoneStatus' => '1'],
            ['zoneId' => '124', 'countryId' => '5', 'zoneName' => 'Encamp', 'zoneCode' => 'ENC', 'zoneStatus' => '1'],
            ['zoneId' => '125', 'countryId' => '5', 'zoneName' => 'Escaldes-Engordany', 'zoneCode' => 'ESE', 'zoneStatus' => '1'],
            ['zoneId' => '126', 'countryId' => '5', 'zoneName' => 'La Massana', 'zoneCode' => 'LMA', 'zoneStatus' => '1'],
            ['zoneId' => '127', 'countryId' => '5', 'zoneName' => 'Ordino', 'zoneCode' => 'ORD', 'zoneStatus' => '1'],
            ['zoneId' => '128', 'countryId' => '5', 'zoneName' => 'Sant Julia de Loria', 'zoneCode' => 'SJL', 'zoneStatus' => '1'],
            ['zoneId' => '129', 'countryId' => '6', 'zoneName' => 'Bengo', 'zoneCode' => 'BGO', 'zoneStatus' => '1'],
            ['zoneId' => '130', 'countryId' => '6', 'zoneName' => 'Benguela', 'zoneCode' => 'BGU', 'zoneStatus' => '1'],
            ['zoneId' => '131', 'countryId' => '6', 'zoneName' => 'Bie', 'zoneCode' => 'BIE', 'zoneStatus' => '1'],
            ['zoneId' => '132', 'countryId' => '6', 'zoneName' => 'Cabinda', 'zoneCode' => 'CAB', 'zoneStatus' => '1'],
            ['zoneId' => '133', 'countryId' => '6', 'zoneName' => 'Cuando-Cubango', 'zoneCode' => 'CCU', 'zoneStatus' => '1'],
            ['zoneId' => '134', 'countryId' => '6', 'zoneName' => 'Cuanza Norte', 'zoneCode' => 'CNO', 'zoneStatus' => '1'],
            ['zoneId' => '135', 'countryId' => '6', 'zoneName' => 'Cuanza Sul', 'zoneCode' => 'CUS', 'zoneStatus' => '1'],
            ['zoneId' => '136', 'countryId' => '6', 'zoneName' => 'Cunene', 'zoneCode' => 'CNN', 'zoneStatus' => '1'],
            ['zoneId' => '137', 'countryId' => '6', 'zoneName' => 'Huambo', 'zoneCode' => 'HUA', 'zoneStatus' => '1'],
            ['zoneId' => '138', 'countryId' => '6', 'zoneName' => 'Huila', 'zoneCode' => 'HUI', 'zoneStatus' => '1'],
            ['zoneId' => '139', 'countryId' => '6', 'zoneName' => 'Luanda', 'zoneCode' => 'LUA', 'zoneStatus' => '1'],
            ['zoneId' => '140', 'countryId' => '6', 'zoneName' => 'Lunda Norte', 'zoneCode' => 'LNO', 'zoneStatus' => '1'],
            ['zoneId' => '141', 'countryId' => '6', 'zoneName' => 'Lunda Sul', 'zoneCode' => 'LSU', 'zoneStatus' => '1'],
            ['zoneId' => '142', 'countryId' => '6', 'zoneName' => 'Malange', 'zoneCode' => 'MAL', 'zoneStatus' => '1'],
            ['zoneId' => '143', 'countryId' => '6', 'zoneName' => 'Moxico', 'zoneCode' => 'MOX', 'zoneStatus' => '1'],
            ['zoneId' => '144', 'countryId' => '6', 'zoneName' => 'Namibe', 'zoneCode' => 'NAM', 'zoneStatus' => '1'],
            ['zoneId' => '145', 'countryId' => '6', 'zoneName' => 'Uige', 'zoneCode' => 'UIG', 'zoneStatus' => '1'],
            ['zoneId' => '146', 'countryId' => '6', 'zoneName' => 'Zaire', 'zoneCode' => 'ZAI', 'zoneStatus' => '1'],
            ['zoneId' => '147', 'countryId' => '9', 'zoneName' => 'Saint George', 'zoneCode' => 'ASG', 'zoneStatus' => '1'],
            ['zoneId' => '148', 'countryId' => '9', 'zoneName' => 'Saint John', 'zoneCode' => 'ASJ', 'zoneStatus' => '1'],
            ['zoneId' => '149', 'countryId' => '9', 'zoneName' => 'Saint Mary', 'zoneCode' => 'ASM', 'zoneStatus' => '1'],
            ['zoneId' => '150', 'countryId' => '9', 'zoneName' => 'Saint Paul', 'zoneCode' => 'ASL', 'zoneStatus' => '1'],
            ['zoneId' => '151', 'countryId' => '9', 'zoneName' => 'Saint Peter', 'zoneCode' => 'ASR', 'zoneStatus' => '1'],
            ['zoneId' => '152', 'countryId' => '9', 'zoneName' => 'Saint Philip', 'zoneCode' => 'ASH', 'zoneStatus' => '1'],
            ['zoneId' => '153', 'countryId' => '9', 'zoneName' => 'Barbuda', 'zoneCode' => 'BAR', 'zoneStatus' => '1'],
            ['zoneId' => '154', 'countryId' => '9', 'zoneName' => 'Redonda', 'zoneCode' => 'RED', 'zoneStatus' => '1'],
            ['zoneId' => '155', 'countryId' => '10', 'zoneName' => 'Antartida e Islas del Atlantico', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '156', 'countryId' => '10', 'zoneName' => 'Buenos Aires', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '157', 'countryId' => '10', 'zoneName' => 'Catamarca', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '158', 'countryId' => '10', 'zoneName' => 'Chaco', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '159', 'countryId' => '10', 'zoneName' => 'Chubut', 'zoneCode' => 'CU', 'zoneStatus' => '1'],
            ['zoneId' => '160', 'countryId' => '10', 'zoneName' => 'Cordoba', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '161', 'countryId' => '10', 'zoneName' => 'Corrientes', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '162', 'countryId' => '10', 'zoneName' => 'Distrito Federal', 'zoneCode' => 'DF', 'zoneStatus' => '1'],
            ['zoneId' => '163', 'countryId' => '10', 'zoneName' => 'Entre Rios', 'zoneCode' => 'ER', 'zoneStatus' => '1'],
            ['zoneId' => '164', 'countryId' => '10', 'zoneName' => 'Formosa', 'zoneCode' => 'FO', 'zoneStatus' => '1'],
            ['zoneId' => '165', 'countryId' => '10', 'zoneName' => 'Jujuy', 'zoneCode' => 'JU', 'zoneStatus' => '1'],
            ['zoneId' => '166', 'countryId' => '10', 'zoneName' => 'La Pampa', 'zoneCode' => 'LP', 'zoneStatus' => '1'],
            ['zoneId' => '167', 'countryId' => '10', 'zoneName' => 'La Rioja', 'zoneCode' => 'LR', 'zoneStatus' => '1'],
            ['zoneId' => '168', 'countryId' => '10', 'zoneName' => 'Mendoza', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '169', 'countryId' => '10', 'zoneName' => 'Misiones', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '170', 'countryId' => '10', 'zoneName' => 'Neuquen', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '171', 'countryId' => '10', 'zoneName' => 'Rio Negro', 'zoneCode' => 'RN', 'zoneStatus' => '1'],
            ['zoneId' => '172', 'countryId' => '10', 'zoneName' => 'Salta', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '173', 'countryId' => '10', 'zoneName' => 'San Juan', 'zoneCode' => 'SJ', 'zoneStatus' => '1'],
            ['zoneId' => '174', 'countryId' => '10', 'zoneName' => 'San Luis', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '175', 'countryId' => '10', 'zoneName' => 'Santa Cruz', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '176', 'countryId' => '10', 'zoneName' => 'Santa Fe', 'zoneCode' => 'SF', 'zoneStatus' => '1'],
            ['zoneId' => '177', 'countryId' => '10', 'zoneName' => 'Santiago del Estero', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '178', 'countryId' => '10', 'zoneName' => 'Tierra del Fuego', 'zoneCode' => 'TF', 'zoneStatus' => '1'],
            ['zoneId' => '179', 'countryId' => '10', 'zoneName' => 'Tucuman', 'zoneCode' => 'TU', 'zoneStatus' => '1'],
            ['zoneId' => '180', 'countryId' => '11', 'zoneName' => 'Aragatsotn', 'zoneCode' => 'AGT', 'zoneStatus' => '1'],
            ['zoneId' => '181', 'countryId' => '11', 'zoneName' => 'Ararat', 'zoneCode' => 'ARR', 'zoneStatus' => '1'],
            ['zoneId' => '182', 'countryId' => '11', 'zoneName' => 'Armavir', 'zoneCode' => 'ARM', 'zoneStatus' => '1'],
            ['zoneId' => '183', 'countryId' => '11', 'zoneName' => 'Geghark\'unik\'', 'zoneCode' => 'GEG', 'zoneStatus' => '1'],
            ['zoneId' => '184', 'countryId' => '11', 'zoneName' => 'Kotayk\'', 'zoneCode' => 'KOT', 'zoneStatus' => '1'],
            ['zoneId' => '185', 'countryId' => '11', 'zoneName' => 'Lorri', 'zoneCode' => 'LOR', 'zoneStatus' => '1'],
            ['zoneId' => '186', 'countryId' => '11', 'zoneName' => 'Shirak', 'zoneCode' => 'SHI', 'zoneStatus' => '1'],
            ['zoneId' => '187', 'countryId' => '11', 'zoneName' => 'Syunik\'', 'zoneCode' => 'SYU', 'zoneStatus' => '1'],
            ['zoneId' => '188', 'countryId' => '11', 'zoneName' => 'Tavush', 'zoneCode' => 'TAV', 'zoneStatus' => '1'],
            ['zoneId' => '189', 'countryId' => '11', 'zoneName' => 'Vayots\' Dzor', 'zoneCode' => 'VAY', 'zoneStatus' => '1'],
            ['zoneId' => '190', 'countryId' => '11', 'zoneName' => 'Yerevan', 'zoneCode' => 'YER', 'zoneStatus' => '1'],
            ['zoneId' => '191', 'countryId' => '13', 'zoneName' => 'Australian Capital Territory', 'zoneCode' => 'ACT', 'zoneStatus' => '1'],
            ['zoneId' => '192', 'countryId' => '13', 'zoneName' => 'New South Wales', 'zoneCode' => 'NSW', 'zoneStatus' => '1'],
            ['zoneId' => '193', 'countryId' => '13', 'zoneName' => 'Northern Territory', 'zoneCode' => 'NT', 'zoneStatus' => '1'],
            ['zoneId' => '194', 'countryId' => '13', 'zoneName' => 'Queensland', 'zoneCode' => 'QLD', 'zoneStatus' => '1'],
            ['zoneId' => '195', 'countryId' => '13', 'zoneName' => 'South Australia', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '196', 'countryId' => '13', 'zoneName' => 'Tasmania', 'zoneCode' => 'TAS', 'zoneStatus' => '1'],
            ['zoneId' => '197', 'countryId' => '13', 'zoneName' => 'Victoria', 'zoneCode' => 'VIC', 'zoneStatus' => '1'],
            ['zoneId' => '198', 'countryId' => '13', 'zoneName' => 'Western Australia', 'zoneCode' => 'WA', 'zoneStatus' => '1'],
            ['zoneId' => '199', 'countryId' => '14', 'zoneName' => 'Burgenland', 'zoneCode' => 'BUR', 'zoneStatus' => '1'],
            ['zoneId' => '200', 'countryId' => '14', 'zoneName' => 'Kärnten', 'zoneCode' => 'KAR', 'zoneStatus' => '1'],
            ['zoneId' => '201', 'countryId' => '14', 'zoneName' => 'Niederösterreich', 'zoneCode' => 'NOS', 'zoneStatus' => '1'],
            ['zoneId' => '202', 'countryId' => '14', 'zoneName' => 'Oberösterreich', 'zoneCode' => 'OOS', 'zoneStatus' => '1'],
            ['zoneId' => '203', 'countryId' => '14', 'zoneName' => 'Salzburg', 'zoneCode' => 'SAL', 'zoneStatus' => '1'],
            ['zoneId' => '204', 'countryId' => '14', 'zoneName' => 'Steiermark', 'zoneCode' => 'STE', 'zoneStatus' => '1'],
            ['zoneId' => '205', 'countryId' => '14', 'zoneName' => 'Tirol', 'zoneCode' => 'TIR', 'zoneStatus' => '1'],
            ['zoneId' => '206', 'countryId' => '14', 'zoneName' => 'Vorarlberg', 'zoneCode' => 'VOR', 'zoneStatus' => '1'],
            ['zoneId' => '207', 'countryId' => '14', 'zoneName' => 'Wien', 'zoneCode' => 'WIE', 'zoneStatus' => '1'],
            ['zoneId' => '208', 'countryId' => '15', 'zoneName' => 'Ali Bayramli', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '209', 'countryId' => '15', 'zoneName' => 'Abseron', 'zoneCode' => 'ABS', 'zoneStatus' => '1'],
            ['zoneId' => '210', 'countryId' => '15', 'zoneName' => 'AgcabAdi', 'zoneCode' => 'AGC', 'zoneStatus' => '1'],
            ['zoneId' => '211', 'countryId' => '15', 'zoneName' => 'Agdam', 'zoneCode' => 'AGM', 'zoneStatus' => '1'],
            ['zoneId' => '212', 'countryId' => '15', 'zoneName' => 'Agdas', 'zoneCode' => 'AGS', 'zoneStatus' => '1'],
            ['zoneId' => '213', 'countryId' => '15', 'zoneName' => 'Agstafa', 'zoneCode' => 'AGA', 'zoneStatus' => '1'],
            ['zoneId' => '214', 'countryId' => '15', 'zoneName' => 'Agsu', 'zoneCode' => 'AGU', 'zoneStatus' => '1'],
            ['zoneId' => '215', 'countryId' => '15', 'zoneName' => 'Astara', 'zoneCode' => 'AST', 'zoneStatus' => '1'],
            ['zoneId' => '216', 'countryId' => '15', 'zoneName' => 'Baki', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '217', 'countryId' => '15', 'zoneName' => 'BabAk', 'zoneCode' => 'BAB', 'zoneStatus' => '1'],
            ['zoneId' => '218', 'countryId' => '15', 'zoneName' => 'BalakAn', 'zoneCode' => 'BAL', 'zoneStatus' => '1'],
            ['zoneId' => '219', 'countryId' => '15', 'zoneName' => 'BArdA', 'zoneCode' => 'BAR', 'zoneStatus' => '1'],
            ['zoneId' => '220', 'countryId' => '15', 'zoneName' => 'Beylaqan', 'zoneCode' => 'BEY', 'zoneStatus' => '1'],
            ['zoneId' => '221', 'countryId' => '15', 'zoneName' => 'Bilasuvar', 'zoneCode' => 'BIL', 'zoneStatus' => '1'],
            ['zoneId' => '222', 'countryId' => '15', 'zoneName' => 'Cabrayil', 'zoneCode' => 'CAB', 'zoneStatus' => '1'],
            ['zoneId' => '223', 'countryId' => '15', 'zoneName' => 'Calilabab', 'zoneCode' => 'CAL', 'zoneStatus' => '1'],
            ['zoneId' => '224', 'countryId' => '15', 'zoneName' => 'Culfa', 'zoneCode' => 'CUL', 'zoneStatus' => '1'],
            ['zoneId' => '225', 'countryId' => '15', 'zoneName' => 'Daskasan', 'zoneCode' => 'DAS', 'zoneStatus' => '1'],
            ['zoneId' => '226', 'countryId' => '15', 'zoneName' => 'Davaci', 'zoneCode' => 'DAV', 'zoneStatus' => '1'],
            ['zoneId' => '227', 'countryId' => '15', 'zoneName' => 'Fuzuli', 'zoneCode' => 'FUZ', 'zoneStatus' => '1'],
            ['zoneId' => '228', 'countryId' => '15', 'zoneName' => 'Ganca', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '229', 'countryId' => '15', 'zoneName' => 'Gadabay', 'zoneCode' => 'GAD', 'zoneStatus' => '1'],
            ['zoneId' => '230', 'countryId' => '15', 'zoneName' => 'Goranboy', 'zoneCode' => 'GOR', 'zoneStatus' => '1'],
            ['zoneId' => '231', 'countryId' => '15', 'zoneName' => 'Goycay', 'zoneCode' => 'GOY', 'zoneStatus' => '1'],
            ['zoneId' => '232', 'countryId' => '15', 'zoneName' => 'Haciqabul', 'zoneCode' => 'HAC', 'zoneStatus' => '1'],
            ['zoneId' => '233', 'countryId' => '15', 'zoneName' => 'Imisli', 'zoneCode' => 'IMI', 'zoneStatus' => '1'],
            ['zoneId' => '234', 'countryId' => '15', 'zoneName' => 'Ismayilli', 'zoneCode' => 'ISM', 'zoneStatus' => '1'],
            ['zoneId' => '235', 'countryId' => '15', 'zoneName' => 'Kalbacar', 'zoneCode' => 'KAL', 'zoneStatus' => '1'],
            ['zoneId' => '236', 'countryId' => '15', 'zoneName' => 'Kurdamir', 'zoneCode' => 'KUR', 'zoneStatus' => '1'],
            ['zoneId' => '237', 'countryId' => '15', 'zoneName' => 'Lankaran', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '238', 'countryId' => '15', 'zoneName' => 'Lacin', 'zoneCode' => 'LAC', 'zoneStatus' => '1'],
            ['zoneId' => '239', 'countryId' => '15', 'zoneName' => 'Lankaran', 'zoneCode' => 'LAN', 'zoneStatus' => '1'],
            ['zoneId' => '240', 'countryId' => '15', 'zoneName' => 'Lerik', 'zoneCode' => 'LER', 'zoneStatus' => '1'],
            ['zoneId' => '241', 'countryId' => '15', 'zoneName' => 'Masalli', 'zoneCode' => 'MAS', 'zoneStatus' => '1'],
            ['zoneId' => '242', 'countryId' => '15', 'zoneName' => 'Mingacevir', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '243', 'countryId' => '15', 'zoneName' => 'Naftalan', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '244', 'countryId' => '15', 'zoneName' => 'Neftcala', 'zoneCode' => 'NEF', 'zoneStatus' => '1'],
            ['zoneId' => '245', 'countryId' => '15', 'zoneName' => 'Oguz', 'zoneCode' => 'OGU', 'zoneStatus' => '1'],
            ['zoneId' => '246', 'countryId' => '15', 'zoneName' => 'Ordubad', 'zoneCode' => 'ORD', 'zoneStatus' => '1'],
            ['zoneId' => '247', 'countryId' => '15', 'zoneName' => 'Qabala', 'zoneCode' => 'QAB', 'zoneStatus' => '1'],
            ['zoneId' => '248', 'countryId' => '15', 'zoneName' => 'Qax', 'zoneCode' => 'QAX', 'zoneStatus' => '1'],
            ['zoneId' => '249', 'countryId' => '15', 'zoneName' => 'Qazax', 'zoneCode' => 'QAZ', 'zoneStatus' => '1'],
            ['zoneId' => '250', 'countryId' => '15', 'zoneName' => 'Qobustan', 'zoneCode' => 'QOB', 'zoneStatus' => '1'],
            ['zoneId' => '251', 'countryId' => '15', 'zoneName' => 'Quba', 'zoneCode' => 'QBA', 'zoneStatus' => '1'],
            ['zoneId' => '252', 'countryId' => '15', 'zoneName' => 'Qubadli', 'zoneCode' => 'QBI', 'zoneStatus' => '1'],
            ['zoneId' => '253', 'countryId' => '15', 'zoneName' => 'Qusar', 'zoneCode' => 'QUS', 'zoneStatus' => '1'],
            ['zoneId' => '254', 'countryId' => '15', 'zoneName' => 'Saki', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '255', 'countryId' => '15', 'zoneName' => 'Saatli', 'zoneCode' => 'SAT', 'zoneStatus' => '1'],
            ['zoneId' => '256', 'countryId' => '15', 'zoneName' => 'Sabirabad', 'zoneCode' => 'SAB', 'zoneStatus' => '1'],
            ['zoneId' => '257', 'countryId' => '15', 'zoneName' => 'Sadarak', 'zoneCode' => 'SAD', 'zoneStatus' => '1'],
            ['zoneId' => '258', 'countryId' => '15', 'zoneName' => 'Sahbuz', 'zoneCode' => 'SAH', 'zoneStatus' => '1'],
            ['zoneId' => '259', 'countryId' => '15', 'zoneName' => 'Saki', 'zoneCode' => 'SAK', 'zoneStatus' => '1'],
            ['zoneId' => '260', 'countryId' => '15', 'zoneName' => 'Salyan', 'zoneCode' => 'SAL', 'zoneStatus' => '1'],
            ['zoneId' => '261', 'countryId' => '15', 'zoneName' => 'Sumqayit', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '262', 'countryId' => '15', 'zoneName' => 'Samaxi', 'zoneCode' => 'SMI', 'zoneStatus' => '1'],
            ['zoneId' => '263', 'countryId' => '15', 'zoneName' => 'Samkir', 'zoneCode' => 'SKR', 'zoneStatus' => '1'],
            ['zoneId' => '264', 'countryId' => '15', 'zoneName' => 'Samux', 'zoneCode' => 'SMX', 'zoneStatus' => '1'],
            ['zoneId' => '265', 'countryId' => '15', 'zoneName' => 'Sarur', 'zoneCode' => 'SAR', 'zoneStatus' => '1'],
            ['zoneId' => '266', 'countryId' => '15', 'zoneName' => 'Siyazan', 'zoneCode' => 'SIY', 'zoneStatus' => '1'],
            ['zoneId' => '267', 'countryId' => '15', 'zoneName' => 'Susa', 'zoneCode' => 'SS', 'zoneStatus' => '1'],
            ['zoneId' => '268', 'countryId' => '15', 'zoneName' => 'Susa', 'zoneCode' => 'SUS', 'zoneStatus' => '1'],
            ['zoneId' => '269', 'countryId' => '15', 'zoneName' => 'Tartar', 'zoneCode' => 'TAR', 'zoneStatus' => '1'],
            ['zoneId' => '270', 'countryId' => '15', 'zoneName' => 'Tovuz', 'zoneCode' => 'TOV', 'zoneStatus' => '1'],
            ['zoneId' => '271', 'countryId' => '15', 'zoneName' => 'Ucar', 'zoneCode' => 'UCA', 'zoneStatus' => '1'],
            ['zoneId' => '272', 'countryId' => '15', 'zoneName' => 'Xankandi', 'zoneCode' => 'XA', 'zoneStatus' => '1'],
            ['zoneId' => '273', 'countryId' => '15', 'zoneName' => 'Xacmaz', 'zoneCode' => 'XAC', 'zoneStatus' => '1'],
            ['zoneId' => '274', 'countryId' => '15', 'zoneName' => 'Xanlar', 'zoneCode' => 'XAN', 'zoneStatus' => '1'],
            ['zoneId' => '275', 'countryId' => '15', 'zoneName' => 'Xizi', 'zoneCode' => 'XIZ', 'zoneStatus' => '1'],
            ['zoneId' => '276', 'countryId' => '15', 'zoneName' => 'Xocali', 'zoneCode' => 'XCI', 'zoneStatus' => '1'],
            ['zoneId' => '277', 'countryId' => '15', 'zoneName' => 'Xocavand', 'zoneCode' => 'XVD', 'zoneStatus' => '1'],
            ['zoneId' => '278', 'countryId' => '15', 'zoneName' => 'Yardimli', 'zoneCode' => 'YAR', 'zoneStatus' => '1'],
            ['zoneId' => '279', 'countryId' => '15', 'zoneName' => 'Yevlax', 'zoneCode' => 'YEV', 'zoneStatus' => '1'],
            ['zoneId' => '280', 'countryId' => '15', 'zoneName' => 'Zangilan', 'zoneCode' => 'ZAN', 'zoneStatus' => '1'],
            ['zoneId' => '281', 'countryId' => '15', 'zoneName' => 'Zaqatala', 'zoneCode' => 'ZAQ', 'zoneStatus' => '1'],
            ['zoneId' => '282', 'countryId' => '15', 'zoneName' => 'Zardab', 'zoneCode' => 'ZAR', 'zoneStatus' => '1'],
            ['zoneId' => '283', 'countryId' => '15', 'zoneName' => 'Naxcivan', 'zoneCode' => 'NX', 'zoneStatus' => '1'],
            ['zoneId' => '284', 'countryId' => '16', 'zoneName' => 'Acklins', 'zoneCode' => 'ACK', 'zoneStatus' => '1'],
            ['zoneId' => '285', 'countryId' => '16', 'zoneName' => 'Berry Islands', 'zoneCode' => 'BER', 'zoneStatus' => '1'],
            ['zoneId' => '286', 'countryId' => '16', 'zoneName' => 'Bimini', 'zoneCode' => 'BIM', 'zoneStatus' => '1'],
            ['zoneId' => '287', 'countryId' => '16', 'zoneName' => 'Black Point', 'zoneCode' => 'BLK', 'zoneStatus' => '1'],
            ['zoneId' => '288', 'countryId' => '16', 'zoneName' => 'Cat Island', 'zoneCode' => 'CAT', 'zoneStatus' => '1'],
            ['zoneId' => '289', 'countryId' => '16', 'zoneName' => 'Central Abaco', 'zoneCode' => 'CAB', 'zoneStatus' => '1'],
            ['zoneId' => '290', 'countryId' => '16', 'zoneName' => 'Central Andros', 'zoneCode' => 'CAN', 'zoneStatus' => '1'],
            ['zoneId' => '291', 'countryId' => '16', 'zoneName' => 'Central Eleuthera', 'zoneCode' => 'CEL', 'zoneStatus' => '1'],
            ['zoneId' => '292', 'countryId' => '16', 'zoneName' => 'City of Freeport', 'zoneCode' => 'FRE', 'zoneStatus' => '1'],
            ['zoneId' => '293', 'countryId' => '16', 'zoneName' => 'Crooked Island', 'zoneCode' => 'CRO', 'zoneStatus' => '1'],
            ['zoneId' => '294', 'countryId' => '16', 'zoneName' => 'East Grand Bahama', 'zoneCode' => 'EGB', 'zoneStatus' => '1'],
            ['zoneId' => '295', 'countryId' => '16', 'zoneName' => 'Exuma', 'zoneCode' => 'EXU', 'zoneStatus' => '1'],
            ['zoneId' => '296', 'countryId' => '16', 'zoneName' => 'Grand Cay', 'zoneCode' => 'GRD', 'zoneStatus' => '1'],
            ['zoneId' => '297', 'countryId' => '16', 'zoneName' => 'Harbour Island', 'zoneCode' => 'HAR', 'zoneStatus' => '1'],
            ['zoneId' => '298', 'countryId' => '16', 'zoneName' => 'Hope Town', 'zoneCode' => 'HOP', 'zoneStatus' => '1'],
            ['zoneId' => '299', 'countryId' => '16', 'zoneName' => 'Inagua', 'zoneCode' => 'INA', 'zoneStatus' => '1'],
            ['zoneId' => '300', 'countryId' => '16', 'zoneName' => 'Long Island', 'zoneCode' => 'LNG', 'zoneStatus' => '1'],
            ['zoneId' => '301', 'countryId' => '16', 'zoneName' => 'Mangrove Cay', 'zoneCode' => 'MAN', 'zoneStatus' => '1'],
            ['zoneId' => '302', 'countryId' => '16', 'zoneName' => 'Mayaguana', 'zoneCode' => 'MAY', 'zoneStatus' => '1'],
            ['zoneId' => '303', 'countryId' => '16', 'zoneName' => 'Moore\'s Island', 'zoneCode' => 'MOO', 'zoneStatus' => '1'],
            ['zoneId' => '304', 'countryId' => '16', 'zoneName' => 'North Abaco', 'zoneCode' => 'NAB', 'zoneStatus' => '1'],
            ['zoneId' => '305', 'countryId' => '16', 'zoneName' => 'North Andros', 'zoneCode' => 'NAN', 'zoneStatus' => '1'],
            ['zoneId' => '306', 'countryId' => '16', 'zoneName' => 'North Eleuthera', 'zoneCode' => 'NEL', 'zoneStatus' => '1'],
            ['zoneId' => '307', 'countryId' => '16', 'zoneName' => 'Ragged Island', 'zoneCode' => 'RAG', 'zoneStatus' => '1'],
            ['zoneId' => '308', 'countryId' => '16', 'zoneName' => 'Rum Cay', 'zoneCode' => 'RUM', 'zoneStatus' => '1'],
            ['zoneId' => '309', 'countryId' => '16', 'zoneName' => 'San Salvador', 'zoneCode' => 'SAL', 'zoneStatus' => '1'],
            ['zoneId' => '310', 'countryId' => '16', 'zoneName' => 'South Abaco', 'zoneCode' => 'SAB', 'zoneStatus' => '1'],
            ['zoneId' => '311', 'countryId' => '16', 'zoneName' => 'South Andros', 'zoneCode' => 'SAN', 'zoneStatus' => '1'],
            ['zoneId' => '312', 'countryId' => '16', 'zoneName' => 'South Eleuthera', 'zoneCode' => 'SEL', 'zoneStatus' => '1'],
            ['zoneId' => '313', 'countryId' => '16', 'zoneName' => 'Spanish Wells', 'zoneCode' => 'SWE', 'zoneStatus' => '1'],
            ['zoneId' => '314', 'countryId' => '16', 'zoneName' => 'West Grand Bahama', 'zoneCode' => 'WGB', 'zoneStatus' => '1'],
            ['zoneId' => '315', 'countryId' => '17', 'zoneName' => 'Capital', 'zoneCode' => 'CAP', 'zoneStatus' => '1'],
            ['zoneId' => '316', 'countryId' => '17', 'zoneName' => 'Central', 'zoneCode' => 'CEN', 'zoneStatus' => '1'],
            ['zoneId' => '317', 'countryId' => '17', 'zoneName' => 'Muharraq', 'zoneCode' => 'MUH', 'zoneStatus' => '1'],
            ['zoneId' => '318', 'countryId' => '17', 'zoneName' => 'Northern', 'zoneCode' => 'NOR', 'zoneStatus' => '1'],
            ['zoneId' => '319', 'countryId' => '17', 'zoneName' => 'Southern', 'zoneCode' => 'SOU', 'zoneStatus' => '1'],
            ['zoneId' => '320', 'countryId' => '18', 'zoneName' => 'Barisal', 'zoneCode' => 'BAR', 'zoneStatus' => '1'],
            ['zoneId' => '321', 'countryId' => '18', 'zoneName' => 'Chittagong', 'zoneCode' => 'CHI', 'zoneStatus' => '1'],
            ['zoneId' => '322', 'countryId' => '18', 'zoneName' => 'Dhaka', 'zoneCode' => 'DHA', 'zoneStatus' => '1'],
            ['zoneId' => '323', 'countryId' => '18', 'zoneName' => 'Khulna', 'zoneCode' => 'KHU', 'zoneStatus' => '1'],
            ['zoneId' => '324', 'countryId' => '18', 'zoneName' => 'Rajshahi', 'zoneCode' => 'RAJ', 'zoneStatus' => '1'],
            ['zoneId' => '325', 'countryId' => '18', 'zoneName' => 'Sylhet', 'zoneCode' => 'SYL', 'zoneStatus' => '1'],
            ['zoneId' => '326', 'countryId' => '19', 'zoneName' => 'Christ Church', 'zoneCode' => 'CC', 'zoneStatus' => '1'],
            ['zoneId' => '327', 'countryId' => '19', 'zoneName' => 'Saint Andrew', 'zoneCode' => 'AND', 'zoneStatus' => '1'],
            ['zoneId' => '328', 'countryId' => '19', 'zoneName' => 'Saint George', 'zoneCode' => 'GEO', 'zoneStatus' => '1'],
            ['zoneId' => '329', 'countryId' => '19', 'zoneName' => 'Saint James', 'zoneCode' => 'JAM', 'zoneStatus' => '1'],
            ['zoneId' => '330', 'countryId' => '19', 'zoneName' => 'Saint John', 'zoneCode' => 'JOH', 'zoneStatus' => '1'],
            ['zoneId' => '331', 'countryId' => '19', 'zoneName' => 'Saint Joseph', 'zoneCode' => 'JOS', 'zoneStatus' => '1'],
            ['zoneId' => '332', 'countryId' => '19', 'zoneName' => 'Saint Lucy', 'zoneCode' => 'LUC', 'zoneStatus' => '1'],
            ['zoneId' => '333', 'countryId' => '19', 'zoneName' => 'Saint Michael', 'zoneCode' => 'MIC', 'zoneStatus' => '1'],
            ['zoneId' => '334', 'countryId' => '19', 'zoneName' => 'Saint Peter', 'zoneCode' => 'PET', 'zoneStatus' => '1'],
            ['zoneId' => '335', 'countryId' => '19', 'zoneName' => 'Saint Philip', 'zoneCode' => 'PHI', 'zoneStatus' => '1'],
            ['zoneId' => '336', 'countryId' => '19', 'zoneName' => 'Saint Thomas', 'zoneCode' => 'THO', 'zoneStatus' => '1'],
            ['zoneId' => '337', 'countryId' => '20', 'zoneName' => 'Brestskaya (Brest)', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '338', 'countryId' => '20', 'zoneName' => 'Homyel\'skaya (Homyel\')', 'zoneCode' => 'HO', 'zoneStatus' => '1'],
            ['zoneId' => '339', 'countryId' => '20', 'zoneName' => 'Horad Minsk', 'zoneCode' => 'HM', 'zoneStatus' => '1'],
            ['zoneId' => '340', 'countryId' => '20', 'zoneName' => 'Hrodzyenskaya (Hrodna)', 'zoneCode' => 'HR', 'zoneStatus' => '1'],
            ['zoneId' => '341', 'countryId' => '20', 'zoneName' => 'Mahilyowskaya (Mahilyow)', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '342', 'countryId' => '20', 'zoneName' => 'Minskaya', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '343', 'countryId' => '20', 'zoneName' => 'Vitsyebskaya (Vitsyebsk)', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '344', 'countryId' => '21', 'zoneName' => 'Antwerpen', 'zoneCode' => 'VAN', 'zoneStatus' => '1'],
            ['zoneId' => '345', 'countryId' => '21', 'zoneName' => 'Brabant Wallon', 'zoneCode' => 'WBR', 'zoneStatus' => '1'],
            ['zoneId' => '346', 'countryId' => '21', 'zoneName' => 'Hainaut', 'zoneCode' => 'WHT', 'zoneStatus' => '1'],
            ['zoneId' => '347', 'countryId' => '21', 'zoneName' => 'Liège', 'zoneCode' => 'WLG', 'zoneStatus' => '1'],
            ['zoneId' => '348', 'countryId' => '21', 'zoneName' => 'Limburg', 'zoneCode' => 'VLI', 'zoneStatus' => '1'],
            ['zoneId' => '349', 'countryId' => '21', 'zoneName' => 'Luxembourg', 'zoneCode' => 'WLX', 'zoneStatus' => '1'],
            ['zoneId' => '350', 'countryId' => '21', 'zoneName' => 'Namur', 'zoneCode' => 'WNA', 'zoneStatus' => '1'],
            ['zoneId' => '351', 'countryId' => '21', 'zoneName' => 'Oost-Vlaanderen', 'zoneCode' => 'VOV', 'zoneStatus' => '1'],
            ['zoneId' => '352', 'countryId' => '21', 'zoneName' => 'Vlaams Brabant', 'zoneCode' => 'VBR', 'zoneStatus' => '1'],
            ['zoneId' => '353', 'countryId' => '21', 'zoneName' => 'West-Vlaanderen', 'zoneCode' => 'VWV', 'zoneStatus' => '1'],
            ['zoneId' => '354', 'countryId' => '22', 'zoneName' => 'Belize', 'zoneCode' => 'BZ', 'zoneStatus' => '1'],
            ['zoneId' => '355', 'countryId' => '22', 'zoneName' => 'Cayo', 'zoneCode' => 'CY', 'zoneStatus' => '1'],
            ['zoneId' => '356', 'countryId' => '22', 'zoneName' => 'Corozal', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '357', 'countryId' => '22', 'zoneName' => 'Orange Walk', 'zoneCode' => 'OW', 'zoneStatus' => '1'],
            ['zoneId' => '358', 'countryId' => '22', 'zoneName' => 'Stann Creek', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '359', 'countryId' => '22', 'zoneName' => 'Toledo', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '360', 'countryId' => '23', 'zoneName' => 'Alibori', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '361', 'countryId' => '23', 'zoneName' => 'Atakora', 'zoneCode' => 'AK', 'zoneStatus' => '1'],
            ['zoneId' => '362', 'countryId' => '23', 'zoneName' => 'Atlantique', 'zoneCode' => 'AQ', 'zoneStatus' => '1'],
            ['zoneId' => '363', 'countryId' => '23', 'zoneName' => 'Borgou', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '364', 'countryId' => '23', 'zoneName' => 'Collines', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '365', 'countryId' => '23', 'zoneName' => 'Donga', 'zoneCode' => 'DO', 'zoneStatus' => '1'],
            ['zoneId' => '366', 'countryId' => '23', 'zoneName' => 'Kouffo', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '367', 'countryId' => '23', 'zoneName' => 'Littoral', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '368', 'countryId' => '23', 'zoneName' => 'Mono', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '369', 'countryId' => '23', 'zoneName' => 'Oueme', 'zoneCode' => 'OU', 'zoneStatus' => '1'],
            ['zoneId' => '370', 'countryId' => '23', 'zoneName' => 'Plateau', 'zoneCode' => 'PL', 'zoneStatus' => '1'],
            ['zoneId' => '371', 'countryId' => '23', 'zoneName' => 'Zou', 'zoneCode' => 'ZO', 'zoneStatus' => '1'],
            ['zoneId' => '372', 'countryId' => '24', 'zoneName' => 'Devonshire', 'zoneCode' => 'DS', 'zoneStatus' => '1'],
            ['zoneId' => '373', 'countryId' => '24', 'zoneName' => 'Hamilton City', 'zoneCode' => 'HC', 'zoneStatus' => '1'],
            ['zoneId' => '374', 'countryId' => '24', 'zoneName' => 'Hamilton', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '375', 'countryId' => '24', 'zoneName' => 'Paget', 'zoneCode' => 'PG', 'zoneStatus' => '1'],
            ['zoneId' => '376', 'countryId' => '24', 'zoneName' => 'Pembroke', 'zoneCode' => 'PB', 'zoneStatus' => '1'],
            ['zoneId' => '377', 'countryId' => '24', 'zoneName' => 'Saint George City', 'zoneCode' => 'GC', 'zoneStatus' => '1'],
            ['zoneId' => '378', 'countryId' => '24', 'zoneName' => 'Saint George\'s', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '379', 'countryId' => '24', 'zoneName' => 'Sandys', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '380', 'countryId' => '24', 'zoneName' => 'Smith\'s', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '381', 'countryId' => '24', 'zoneName' => 'Southampton', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '382', 'countryId' => '24', 'zoneName' => 'Warwick', 'zoneCode' => 'WA', 'zoneStatus' => '1'],
            ['zoneId' => '383', 'countryId' => '25', 'zoneName' => 'Bumthang', 'zoneCode' => 'BUM', 'zoneStatus' => '1'],
            ['zoneId' => '384', 'countryId' => '25', 'zoneName' => 'Chukha', 'zoneCode' => 'CHU', 'zoneStatus' => '1'],
            ['zoneId' => '385', 'countryId' => '25', 'zoneName' => 'Dagana', 'zoneCode' => 'DAG', 'zoneStatus' => '1'],
            ['zoneId' => '386', 'countryId' => '25', 'zoneName' => 'Gasa', 'zoneCode' => 'GAS', 'zoneStatus' => '1'],
            ['zoneId' => '387', 'countryId' => '25', 'zoneName' => 'Haa', 'zoneCode' => 'HAA', 'zoneStatus' => '1'],
            ['zoneId' => '388', 'countryId' => '25', 'zoneName' => 'Lhuntse', 'zoneCode' => 'LHU', 'zoneStatus' => '1'],
            ['zoneId' => '389', 'countryId' => '25', 'zoneName' => 'Mongar', 'zoneCode' => 'MON', 'zoneStatus' => '1'],
            ['zoneId' => '390', 'countryId' => '25', 'zoneName' => 'Paro', 'zoneCode' => 'PAR', 'zoneStatus' => '1'],
            ['zoneId' => '391', 'countryId' => '25', 'zoneName' => 'Pemagatshel', 'zoneCode' => 'PEM', 'zoneStatus' => '1'],
            ['zoneId' => '392', 'countryId' => '25', 'zoneName' => 'Punakha', 'zoneCode' => 'PUN', 'zoneStatus' => '1'],
            ['zoneId' => '393', 'countryId' => '25', 'zoneName' => 'Samdrup Jongkhar', 'zoneCode' => 'SJO', 'zoneStatus' => '1'],
            ['zoneId' => '394', 'countryId' => '25', 'zoneName' => 'Samtse', 'zoneCode' => 'SAT', 'zoneStatus' => '1'],
            ['zoneId' => '395', 'countryId' => '25', 'zoneName' => 'Sarpang', 'zoneCode' => 'SAR', 'zoneStatus' => '1'],
            ['zoneId' => '396', 'countryId' => '25', 'zoneName' => 'Thimphu', 'zoneCode' => 'THI', 'zoneStatus' => '1'],
            ['zoneId' => '397', 'countryId' => '25', 'zoneName' => 'Trashigang', 'zoneCode' => 'TRG', 'zoneStatus' => '1'],
            ['zoneId' => '398', 'countryId' => '25', 'zoneName' => 'Trashiyangste', 'zoneCode' => 'TRY', 'zoneStatus' => '1'],
            ['zoneId' => '399', 'countryId' => '25', 'zoneName' => 'Trongsa', 'zoneCode' => 'TRO', 'zoneStatus' => '1'],
            ['zoneId' => '400', 'countryId' => '25', 'zoneName' => 'Tsirang', 'zoneCode' => 'TSI', 'zoneStatus' => '1'],
            ['zoneId' => '401', 'countryId' => '25', 'zoneName' => 'Wangdue Phodrang', 'zoneCode' => 'WPH', 'zoneStatus' => '1'],
            ['zoneId' => '402', 'countryId' => '25', 'zoneName' => 'Zhemgang', 'zoneCode' => 'ZHE', 'zoneStatus' => '1'],
            ['zoneId' => '403', 'countryId' => '26', 'zoneName' => 'Beni', 'zoneCode' => 'BEN', 'zoneStatus' => '1'],
            ['zoneId' => '404', 'countryId' => '26', 'zoneName' => 'Chuquisaca', 'zoneCode' => 'CHU', 'zoneStatus' => '1'],
            ['zoneId' => '405', 'countryId' => '26', 'zoneName' => 'Cochabamba', 'zoneCode' => 'COC', 'zoneStatus' => '1'],
            ['zoneId' => '406', 'countryId' => '26', 'zoneName' => 'La Paz', 'zoneCode' => 'LPZ', 'zoneStatus' => '1'],
            ['zoneId' => '407', 'countryId' => '26', 'zoneName' => 'Oruro', 'zoneCode' => 'ORU', 'zoneStatus' => '1'],
            ['zoneId' => '408', 'countryId' => '26', 'zoneName' => 'Pando', 'zoneCode' => 'PAN', 'zoneStatus' => '1'],
            ['zoneId' => '409', 'countryId' => '26', 'zoneName' => 'Potosi', 'zoneCode' => 'POT', 'zoneStatus' => '1'],
            ['zoneId' => '410', 'countryId' => '26', 'zoneName' => 'Santa Cruz', 'zoneCode' => 'SCZ', 'zoneStatus' => '1'],
            ['zoneId' => '411', 'countryId' => '26', 'zoneName' => 'Tarija', 'zoneCode' => 'TAR', 'zoneStatus' => '1'],
            ['zoneId' => '412', 'countryId' => '27', 'zoneName' => 'Brcko district', 'zoneCode' => 'BRO', 'zoneStatus' => '1'],
            ['zoneId' => '413', 'countryId' => '27', 'zoneName' => 'Unsko-Sanski Kanton', 'zoneCode' => 'FUS', 'zoneStatus' => '1'],
            ['zoneId' => '414', 'countryId' => '27', 'zoneName' => 'Posavski Kanton', 'zoneCode' => 'FPO', 'zoneStatus' => '1'],
            ['zoneId' => '415', 'countryId' => '27', 'zoneName' => 'Tuzlanski Kanton', 'zoneCode' => 'FTU', 'zoneStatus' => '1'],
            ['zoneId' => '416', 'countryId' => '27', 'zoneName' => 'Zenicko-Dobojski Kanton', 'zoneCode' => 'FZE', 'zoneStatus' => '1'],
            ['zoneId' => '417', 'countryId' => '27', 'zoneName' => 'Bosanskopodrinjski Kanton', 'zoneCode' => 'FBP', 'zoneStatus' => '1'],
            ['zoneId' => '418', 'countryId' => '27', 'zoneName' => 'Srednjebosanski Kanton', 'zoneCode' => 'FSB', 'zoneStatus' => '1'],
            ['zoneId' => '419', 'countryId' => '27', 'zoneName' => 'Hercegovacko-neretvanski Kanton', 'zoneCode' => 'FHN', 'zoneStatus' => '1'],
            ['zoneId' => '420', 'countryId' => '27', 'zoneName' => 'Zapadnohercegovacka Zupanija', 'zoneCode' => 'FZH', 'zoneStatus' => '1'],
            ['zoneId' => '421', 'countryId' => '27', 'zoneName' => 'Kanton Sarajevo', 'zoneCode' => 'FSA', 'zoneStatus' => '1'],
            ['zoneId' => '422', 'countryId' => '27', 'zoneName' => 'Zapadnobosanska', 'zoneCode' => 'FZA', 'zoneStatus' => '1'],
            ['zoneId' => '423', 'countryId' => '27', 'zoneName' => 'Banja Luka', 'zoneCode' => 'SBL', 'zoneStatus' => '1'],
            ['zoneId' => '424', 'countryId' => '27', 'zoneName' => 'Doboj', 'zoneCode' => 'SDO', 'zoneStatus' => '1'],
            ['zoneId' => '425', 'countryId' => '27', 'zoneName' => 'Bijeljina', 'zoneCode' => 'SBI', 'zoneStatus' => '1'],
            ['zoneId' => '426', 'countryId' => '27', 'zoneName' => 'Vlasenica', 'zoneCode' => 'SVL', 'zoneStatus' => '1'],
            ['zoneId' => '427', 'countryId' => '27', 'zoneName' => 'Sarajevo-Romanija or Sokolac', 'zoneCode' => 'SSR', 'zoneStatus' => '1'],
            ['zoneId' => '428', 'countryId' => '27', 'zoneName' => 'Foca', 'zoneCode' => 'SFO', 'zoneStatus' => '1'],
            ['zoneId' => '429', 'countryId' => '27', 'zoneName' => 'Trebinje', 'zoneCode' => 'STR', 'zoneStatus' => '1'],
            ['zoneId' => '430', 'countryId' => '28', 'zoneName' => 'Central', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '431', 'countryId' => '28', 'zoneName' => 'Ghanzi', 'zoneCode' => 'GH', 'zoneStatus' => '1'],
            ['zoneId' => '432', 'countryId' => '28', 'zoneName' => 'Kgalagadi', 'zoneCode' => 'KD', 'zoneStatus' => '1'],
            ['zoneId' => '433', 'countryId' => '28', 'zoneName' => 'Kgatleng', 'zoneCode' => 'KT', 'zoneStatus' => '1'],
            ['zoneId' => '434', 'countryId' => '28', 'zoneName' => 'Kweneng', 'zoneCode' => 'KW', 'zoneStatus' => '1'],
            ['zoneId' => '435', 'countryId' => '28', 'zoneName' => 'Ngamiland', 'zoneCode' => 'NG', 'zoneStatus' => '1'],
            ['zoneId' => '436', 'countryId' => '28', 'zoneName' => 'North East', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '437', 'countryId' => '28', 'zoneName' => 'North West', 'zoneCode' => 'NW', 'zoneStatus' => '1'],
            ['zoneId' => '438', 'countryId' => '28', 'zoneName' => 'South East', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '439', 'countryId' => '28', 'zoneName' => 'Southern', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '440', 'countryId' => '30', 'zoneName' => 'Acre', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '441', 'countryId' => '30', 'zoneName' => 'Alagoas', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '442', 'countryId' => '30', 'zoneName' => 'Amapá', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '443', 'countryId' => '30', 'zoneName' => 'Amazonas', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '444', 'countryId' => '30', 'zoneName' => 'Bahia', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '445', 'countryId' => '30', 'zoneName' => 'Ceará', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '446', 'countryId' => '30', 'zoneName' => 'Distrito Federal', 'zoneCode' => 'DF', 'zoneStatus' => '1'],
            ['zoneId' => '447', 'countryId' => '30', 'zoneName' => 'Espírito Santo', 'zoneCode' => 'ES', 'zoneStatus' => '1'],
            ['zoneId' => '448', 'countryId' => '30', 'zoneName' => 'Goiás', 'zoneCode' => 'GO', 'zoneStatus' => '1'],
            ['zoneId' => '449', 'countryId' => '30', 'zoneName' => 'Maranhão', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '450', 'countryId' => '30', 'zoneName' => 'Mato Grosso', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '451', 'countryId' => '30', 'zoneName' => 'Mato Grosso do Sul', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '452', 'countryId' => '30', 'zoneName' => 'Minas Gerais', 'zoneCode' => 'MG', 'zoneStatus' => '1'],
            ['zoneId' => '453', 'countryId' => '30', 'zoneName' => 'Pará', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '454', 'countryId' => '30', 'zoneName' => 'Paraíba', 'zoneCode' => 'PB', 'zoneStatus' => '1'],
            ['zoneId' => '455', 'countryId' => '30', 'zoneName' => 'Paraná', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '456', 'countryId' => '30', 'zoneName' => 'Pernambuco', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '457', 'countryId' => '30', 'zoneName' => 'Piauí', 'zoneCode' => 'PI', 'zoneStatus' => '1'],
            ['zoneId' => '458', 'countryId' => '30', 'zoneName' => 'Rio de Janeiro', 'zoneCode' => 'RJ', 'zoneStatus' => '1'],
            ['zoneId' => '459', 'countryId' => '30', 'zoneName' => 'Rio Grande do Norte', 'zoneCode' => 'RN', 'zoneStatus' => '1'],
            ['zoneId' => '460', 'countryId' => '30', 'zoneName' => 'Rio Grande do Sul', 'zoneCode' => 'RS', 'zoneStatus' => '1'],
            ['zoneId' => '461', 'countryId' => '30', 'zoneName' => 'Rondônia', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '462', 'countryId' => '30', 'zoneName' => 'Roraima', 'zoneCode' => 'RR', 'zoneStatus' => '1'],
            ['zoneId' => '463', 'countryId' => '30', 'zoneName' => 'Santa Catarina', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '464', 'countryId' => '30', 'zoneName' => 'São Paulo', 'zoneCode' => 'SP', 'zoneStatus' => '1'],
            ['zoneId' => '465', 'countryId' => '30', 'zoneName' => 'Sergipe', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '466', 'countryId' => '30', 'zoneName' => 'Tocantins', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '467', 'countryId' => '31', 'zoneName' => 'Peros Banhos', 'zoneCode' => 'PB', 'zoneStatus' => '1'],
            ['zoneId' => '468', 'countryId' => '31', 'zoneName' => 'Salomon Islands', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '469', 'countryId' => '31', 'zoneName' => 'Nelsons Island', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '470', 'countryId' => '31', 'zoneName' => 'Three Brothers', 'zoneCode' => 'TB', 'zoneStatus' => '1'],
            ['zoneId' => '471', 'countryId' => '31', 'zoneName' => 'Eagle Islands', 'zoneCode' => 'EA', 'zoneStatus' => '1'],
            ['zoneId' => '472', 'countryId' => '31', 'zoneName' => 'Danger Island', 'zoneCode' => 'DI', 'zoneStatus' => '1'],
            ['zoneId' => '473', 'countryId' => '31', 'zoneName' => 'Egmont Islands', 'zoneCode' => 'EG', 'zoneStatus' => '1'],
            ['zoneId' => '474', 'countryId' => '31', 'zoneName' => 'Diego Garcia', 'zoneCode' => 'DG', 'zoneStatus' => '1'],
            ['zoneId' => '475', 'countryId' => '32', 'zoneName' => 'Belait', 'zoneCode' => 'BEL', 'zoneStatus' => '1'],
            ['zoneId' => '476', 'countryId' => '32', 'zoneName' => 'Brunei and Muara', 'zoneCode' => 'BRM', 'zoneStatus' => '1'],
            ['zoneId' => '477', 'countryId' => '32', 'zoneName' => 'Temburong', 'zoneCode' => 'TEM', 'zoneStatus' => '1'],
            ['zoneId' => '478', 'countryId' => '32', 'zoneName' => 'Tutong', 'zoneCode' => 'TUT', 'zoneStatus' => '1'],
            ['zoneId' => '479', 'countryId' => '33', 'zoneName' => 'Blagoevgrad', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '480', 'countryId' => '33', 'zoneName' => 'Burgas', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '481', 'countryId' => '33', 'zoneName' => 'Dobrich', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '482', 'countryId' => '33', 'zoneName' => 'Gabrovo', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '483', 'countryId' => '33', 'zoneName' => 'Haskovo', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '484', 'countryId' => '33', 'zoneName' => 'Kardjali', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '485', 'countryId' => '33', 'zoneName' => 'Kyustendil', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '486', 'countryId' => '33', 'zoneName' => 'Lovech', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '487', 'countryId' => '33', 'zoneName' => 'Montana', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '488', 'countryId' => '33', 'zoneName' => 'Pazardjik', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '489', 'countryId' => '33', 'zoneName' => 'Pernik', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '490', 'countryId' => '33', 'zoneName' => 'Pleven', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '491', 'countryId' => '33', 'zoneName' => 'Plovdiv', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '492', 'countryId' => '33', 'zoneName' => 'Razgrad', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '493', 'countryId' => '33', 'zoneName' => 'Shumen', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '494', 'countryId' => '33', 'zoneName' => 'Silistra', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '495', 'countryId' => '33', 'zoneName' => 'Sliven', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '496', 'countryId' => '33', 'zoneName' => 'Smolyan', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '497', 'countryId' => '33', 'zoneName' => 'Sofia', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '498', 'countryId' => '33', 'zoneName' => 'Sofia - town', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '499', 'countryId' => '33', 'zoneName' => 'Stara Zagora', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '500', 'countryId' => '33', 'zoneName' => 'Targovishte', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '501', 'countryId' => '33', 'zoneName' => 'Varna', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '502', 'countryId' => '33', 'zoneName' => 'Veliko Tarnovo', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '503', 'countryId' => '33', 'zoneName' => 'Vidin', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '504', 'countryId' => '33', 'zoneName' => 'Vratza', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '505', 'countryId' => '33', 'zoneName' => 'Yambol', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '506', 'countryId' => '34', 'zoneName' => 'Bale', 'zoneCode' => 'BAL', 'zoneStatus' => '1'],
            ['zoneId' => '507', 'countryId' => '34', 'zoneName' => 'Bam', 'zoneCode' => 'BAM', 'zoneStatus' => '1'],
            ['zoneId' => '508', 'countryId' => '34', 'zoneName' => 'Banwa', 'zoneCode' => 'BAN', 'zoneStatus' => '1'],
            ['zoneId' => '509', 'countryId' => '34', 'zoneName' => 'Bazega', 'zoneCode' => 'BAZ', 'zoneStatus' => '1'],
            ['zoneId' => '510', 'countryId' => '34', 'zoneName' => 'Bougouriba', 'zoneCode' => 'BOR', 'zoneStatus' => '1'],
            ['zoneId' => '511', 'countryId' => '34', 'zoneName' => 'Boulgou', 'zoneCode' => 'BLG', 'zoneStatus' => '1'],
            ['zoneId' => '512', 'countryId' => '34', 'zoneName' => 'Boulkiemde', 'zoneCode' => 'BOK', 'zoneStatus' => '1'],
            ['zoneId' => '513', 'countryId' => '34', 'zoneName' => 'Comoe', 'zoneCode' => 'COM', 'zoneStatus' => '1'],
            ['zoneId' => '514', 'countryId' => '34', 'zoneName' => 'Ganzourgou', 'zoneCode' => 'GAN', 'zoneStatus' => '1'],
            ['zoneId' => '515', 'countryId' => '34', 'zoneName' => 'Gnagna', 'zoneCode' => 'GNA', 'zoneStatus' => '1'],
            ['zoneId' => '516', 'countryId' => '34', 'zoneName' => 'Gourma', 'zoneCode' => 'GOU', 'zoneStatus' => '1'],
            ['zoneId' => '517', 'countryId' => '34', 'zoneName' => 'Houet', 'zoneCode' => 'HOU', 'zoneStatus' => '1'],
            ['zoneId' => '518', 'countryId' => '34', 'zoneName' => 'Ioba', 'zoneCode' => 'IOA', 'zoneStatus' => '1'],
            ['zoneId' => '519', 'countryId' => '34', 'zoneName' => 'Kadiogo', 'zoneCode' => 'KAD', 'zoneStatus' => '1'],
            ['zoneId' => '520', 'countryId' => '34', 'zoneName' => 'Kenedougou', 'zoneCode' => 'KEN', 'zoneStatus' => '1'],
            ['zoneId' => '521', 'countryId' => '34', 'zoneName' => 'Komondjari', 'zoneCode' => 'KOD', 'zoneStatus' => '1'],
            ['zoneId' => '522', 'countryId' => '34', 'zoneName' => 'Kompienga', 'zoneCode' => 'KOP', 'zoneStatus' => '1'],
            ['zoneId' => '523', 'countryId' => '34', 'zoneName' => 'Kossi', 'zoneCode' => 'KOS', 'zoneStatus' => '1'],
            ['zoneId' => '524', 'countryId' => '34', 'zoneName' => 'Koulpelogo', 'zoneCode' => 'KOL', 'zoneStatus' => '1'],
            ['zoneId' => '525', 'countryId' => '34', 'zoneName' => 'Kouritenga', 'zoneCode' => 'KOT', 'zoneStatus' => '1'],
            ['zoneId' => '526', 'countryId' => '34', 'zoneName' => 'Kourweogo', 'zoneCode' => 'KOW', 'zoneStatus' => '1'],
            ['zoneId' => '527', 'countryId' => '34', 'zoneName' => 'Leraba', 'zoneCode' => 'LER', 'zoneStatus' => '1'],
            ['zoneId' => '528', 'countryId' => '34', 'zoneName' => 'Loroum', 'zoneCode' => 'LOR', 'zoneStatus' => '1'],
            ['zoneId' => '529', 'countryId' => '34', 'zoneName' => 'Mouhoun', 'zoneCode' => 'MOU', 'zoneStatus' => '1'],
            ['zoneId' => '530', 'countryId' => '34', 'zoneName' => 'Nahouri', 'zoneCode' => 'NAH', 'zoneStatus' => '1'],
            ['zoneId' => '531', 'countryId' => '34', 'zoneName' => 'Namentenga', 'zoneCode' => 'NAM', 'zoneStatus' => '1'],
            ['zoneId' => '532', 'countryId' => '34', 'zoneName' => 'Nayala', 'zoneCode' => 'NAY', 'zoneStatus' => '1'],
            ['zoneId' => '533', 'countryId' => '34', 'zoneName' => 'Noumbiel', 'zoneCode' => 'NOU', 'zoneStatus' => '1'],
            ['zoneId' => '534', 'countryId' => '34', 'zoneName' => 'Oubritenga', 'zoneCode' => 'OUB', 'zoneStatus' => '1'],
            ['zoneId' => '535', 'countryId' => '34', 'zoneName' => 'Oudalan', 'zoneCode' => 'OUD', 'zoneStatus' => '1'],
            ['zoneId' => '536', 'countryId' => '34', 'zoneName' => 'Passore', 'zoneCode' => 'PAS', 'zoneStatus' => '1'],
            ['zoneId' => '537', 'countryId' => '34', 'zoneName' => 'Poni', 'zoneCode' => 'PON', 'zoneStatus' => '1'],
            ['zoneId' => '538', 'countryId' => '34', 'zoneName' => 'Sanguie', 'zoneCode' => 'SAG', 'zoneStatus' => '1'],
            ['zoneId' => '539', 'countryId' => '34', 'zoneName' => 'Sanmatenga', 'zoneCode' => 'SAM', 'zoneStatus' => '1'],
            ['zoneId' => '540', 'countryId' => '34', 'zoneName' => 'Seno', 'zoneCode' => 'SEN', 'zoneStatus' => '1'],
            ['zoneId' => '541', 'countryId' => '34', 'zoneName' => 'Sissili', 'zoneCode' => 'SIS', 'zoneStatus' => '1'],
            ['zoneId' => '542', 'countryId' => '34', 'zoneName' => 'Soum', 'zoneCode' => 'SOM', 'zoneStatus' => '1'],
            ['zoneId' => '543', 'countryId' => '34', 'zoneName' => 'Sourou', 'zoneCode' => 'SOR', 'zoneStatus' => '1'],
            ['zoneId' => '544', 'countryId' => '34', 'zoneName' => 'Tapoa', 'zoneCode' => 'TAP', 'zoneStatus' => '1'],
            ['zoneId' => '545', 'countryId' => '34', 'zoneName' => 'Tuy', 'zoneCode' => 'TUY', 'zoneStatus' => '1'],
            ['zoneId' => '546', 'countryId' => '34', 'zoneName' => 'Yagha', 'zoneCode' => 'YAG', 'zoneStatus' => '1'],
            ['zoneId' => '547', 'countryId' => '34', 'zoneName' => 'Yatenga', 'zoneCode' => 'YAT', 'zoneStatus' => '1'],
            ['zoneId' => '548', 'countryId' => '34', 'zoneName' => 'Ziro', 'zoneCode' => 'ZIR', 'zoneStatus' => '1'],
            ['zoneId' => '549', 'countryId' => '34', 'zoneName' => 'Zondoma', 'zoneCode' => 'ZOD', 'zoneStatus' => '1'],
            ['zoneId' => '550', 'countryId' => '34', 'zoneName' => 'Zoundweogo', 'zoneCode' => 'ZOW', 'zoneStatus' => '1'],
            ['zoneId' => '551', 'countryId' => '35', 'zoneName' => 'Bubanza', 'zoneCode' => 'BB', 'zoneStatus' => '1'],
            ['zoneId' => '552', 'countryId' => '35', 'zoneName' => 'Bujumbura', 'zoneCode' => 'BJ', 'zoneStatus' => '1'],
            ['zoneId' => '553', 'countryId' => '35', 'zoneName' => 'Bururi', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '554', 'countryId' => '35', 'zoneName' => 'Cankuzo', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '555', 'countryId' => '35', 'zoneName' => 'Cibitoke', 'zoneCode' => 'CI', 'zoneStatus' => '1'],
            ['zoneId' => '556', 'countryId' => '35', 'zoneName' => 'Gitega', 'zoneCode' => 'GI', 'zoneStatus' => '1'],
            ['zoneId' => '557', 'countryId' => '35', 'zoneName' => 'Karuzi', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '558', 'countryId' => '35', 'zoneName' => 'Kayanza', 'zoneCode' => 'KY', 'zoneStatus' => '1'],
            ['zoneId' => '559', 'countryId' => '35', 'zoneName' => 'Kirundo', 'zoneCode' => 'KI', 'zoneStatus' => '1'],
            ['zoneId' => '560', 'countryId' => '35', 'zoneName' => 'Makamba', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '561', 'countryId' => '35', 'zoneName' => 'Muramvya', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '562', 'countryId' => '35', 'zoneName' => 'Muyinga', 'zoneCode' => 'MY', 'zoneStatus' => '1'],
            ['zoneId' => '563', 'countryId' => '35', 'zoneName' => 'Mwaro', 'zoneCode' => 'MW', 'zoneStatus' => '1'],
            ['zoneId' => '564', 'countryId' => '35', 'zoneName' => 'Ngozi', 'zoneCode' => 'NG', 'zoneStatus' => '1'],
            ['zoneId' => '565', 'countryId' => '35', 'zoneName' => 'Rutana', 'zoneCode' => 'RT', 'zoneStatus' => '1'],
            ['zoneId' => '566', 'countryId' => '35', 'zoneName' => 'Ruyigi', 'zoneCode' => 'RY', 'zoneStatus' => '1'],
            ['zoneId' => '567', 'countryId' => '36', 'zoneName' => 'Phnom Penh', 'zoneCode' => 'PP', 'zoneStatus' => '1'],
            ['zoneId' => '568', 'countryId' => '36', 'zoneName' => 'Preah Seihanu (Kompong Som or Sihanoukville)', 'zoneCode' => 'PS', 'zoneStatus' => '1'],
            ['zoneId' => '569', 'countryId' => '36', 'zoneName' => 'Pailin', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '570', 'countryId' => '36', 'zoneName' => 'Keb', 'zoneCode' => 'KB', 'zoneStatus' => '1'],
            ['zoneId' => '571', 'countryId' => '36', 'zoneName' => 'Banteay Meanchey', 'zoneCode' => 'BM', 'zoneStatus' => '1'],
            ['zoneId' => '572', 'countryId' => '36', 'zoneName' => 'Battambang', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '573', 'countryId' => '36', 'zoneName' => 'Kampong Cham', 'zoneCode' => 'KM', 'zoneStatus' => '1'],
            ['zoneId' => '574', 'countryId' => '36', 'zoneName' => 'Kampong Chhnang', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '575', 'countryId' => '36', 'zoneName' => 'Kampong Speu', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '576', 'countryId' => '36', 'zoneName' => 'Kampong Som', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '577', 'countryId' => '36', 'zoneName' => 'Kampong Thom', 'zoneCode' => 'KT', 'zoneStatus' => '1'],
            ['zoneId' => '578', 'countryId' => '36', 'zoneName' => 'Kampot', 'zoneCode' => 'KP', 'zoneStatus' => '1'],
            ['zoneId' => '579', 'countryId' => '36', 'zoneName' => 'Kandal', 'zoneCode' => 'KL', 'zoneStatus' => '1'],
            ['zoneId' => '580', 'countryId' => '36', 'zoneName' => 'Kaoh Kong', 'zoneCode' => 'KK', 'zoneStatus' => '1'],
            ['zoneId' => '581', 'countryId' => '36', 'zoneName' => 'Kratie', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '582', 'countryId' => '36', 'zoneName' => 'Mondul Kiri', 'zoneCode' => 'MK', 'zoneStatus' => '1'],
            ['zoneId' => '583', 'countryId' => '36', 'zoneName' => 'Oddar Meancheay', 'zoneCode' => 'OM', 'zoneStatus' => '1'],
            ['zoneId' => '584', 'countryId' => '36', 'zoneName' => 'Pursat', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '585', 'countryId' => '36', 'zoneName' => 'Preah Vihear', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '586', 'countryId' => '36', 'zoneName' => 'Prey Veng', 'zoneCode' => 'PG', 'zoneStatus' => '1'],
            ['zoneId' => '587', 'countryId' => '36', 'zoneName' => 'Ratanak Kiri', 'zoneCode' => 'RK', 'zoneStatus' => '1'],
            ['zoneId' => '588', 'countryId' => '36', 'zoneName' => 'Siemreap', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '589', 'countryId' => '36', 'zoneName' => 'Stung Treng', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '590', 'countryId' => '36', 'zoneName' => 'Svay Rieng', 'zoneCode' => 'SR', 'zoneStatus' => '1'],
            ['zoneId' => '591', 'countryId' => '36', 'zoneName' => 'Takeo', 'zoneCode' => 'TK', 'zoneStatus' => '1'],
            ['zoneId' => '592', 'countryId' => '37', 'zoneName' => 'Adamawa (Adamaoua)', 'zoneCode' => 'ADA', 'zoneStatus' => '1'],
            ['zoneId' => '593', 'countryId' => '37', 'zoneName' => 'Centre', 'zoneCode' => 'CEN', 'zoneStatus' => '1'],
            ['zoneId' => '594', 'countryId' => '37', 'zoneName' => 'East (Est)', 'zoneCode' => 'EST', 'zoneStatus' => '1'],
            ['zoneId' => '595', 'countryId' => '37', 'zoneName' => 'Extreme North (Extreme-Nord)', 'zoneCode' => 'EXN', 'zoneStatus' => '1'],
            ['zoneId' => '596', 'countryId' => '37', 'zoneName' => 'Littoral', 'zoneCode' => 'LIT', 'zoneStatus' => '1'],
            ['zoneId' => '597', 'countryId' => '37', 'zoneName' => 'North (Nord)', 'zoneCode' => 'NOR', 'zoneStatus' => '1'],
            ['zoneId' => '598', 'countryId' => '37', 'zoneName' => 'Northwest (Nord-Ouest)', 'zoneCode' => 'NOT', 'zoneStatus' => '1'],
            ['zoneId' => '599', 'countryId' => '37', 'zoneName' => 'West (Ouest)', 'zoneCode' => 'OUE', 'zoneStatus' => '1'],
            ['zoneId' => '600', 'countryId' => '37', 'zoneName' => 'South (Sud)', 'zoneCode' => 'SUD', 'zoneStatus' => '1'],
            ['zoneId' => '601', 'countryId' => '37', 'zoneName' => 'Southwest (Sud-Ouest).', 'zoneCode' => 'SOU', 'zoneStatus' => '1'],
            ['zoneId' => '602', 'countryId' => '38', 'zoneName' => 'Alberta', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '603', 'countryId' => '38', 'zoneName' => 'British Columbia', 'zoneCode' => 'BC', 'zoneStatus' => '1'],
            ['zoneId' => '604', 'countryId' => '38', 'zoneName' => 'Manitoba', 'zoneCode' => 'MB', 'zoneStatus' => '1'],
            ['zoneId' => '605', 'countryId' => '38', 'zoneName' => 'New Brunswick', 'zoneCode' => 'NB', 'zoneStatus' => '1'],
            ['zoneId' => '606', 'countryId' => '38', 'zoneName' => 'Newfoundland and Labrador', 'zoneCode' => 'NL', 'zoneStatus' => '1'],
            ['zoneId' => '607', 'countryId' => '38', 'zoneName' => 'Northwest Territories', 'zoneCode' => 'NT', 'zoneStatus' => '1'],
            ['zoneId' => '608', 'countryId' => '38', 'zoneName' => 'Nova Scotia', 'zoneCode' => 'NS', 'zoneStatus' => '1'],
            ['zoneId' => '609', 'countryId' => '38', 'zoneName' => 'Nunavut', 'zoneCode' => 'NU', 'zoneStatus' => '1'],
            ['zoneId' => '610', 'countryId' => '38', 'zoneName' => 'Ontario', 'zoneCode' => 'ON', 'zoneStatus' => '1'],
            ['zoneId' => '611', 'countryId' => '38', 'zoneName' => 'Prince Edward Island', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '612', 'countryId' => '38', 'zoneName' => 'Qu&eacute;bec', 'zoneCode' => 'QC', 'zoneStatus' => '1'],
            ['zoneId' => '613', 'countryId' => '38', 'zoneName' => 'Saskatchewan', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '614', 'countryId' => '38', 'zoneName' => 'Yukon Territory', 'zoneCode' => 'YT', 'zoneStatus' => '1'],
            ['zoneId' => '615', 'countryId' => '39', 'zoneName' => 'Boa Vista', 'zoneCode' => 'BV', 'zoneStatus' => '1'],
            ['zoneId' => '616', 'countryId' => '39', 'zoneName' => 'Brava', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '617', 'countryId' => '39', 'zoneName' => 'Calheta de Sao Miguel', 'zoneCode' => 'CS', 'zoneStatus' => '1'],
            ['zoneId' => '618', 'countryId' => '39', 'zoneName' => 'Maio', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '619', 'countryId' => '39', 'zoneName' => 'Mosteiros', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '620', 'countryId' => '39', 'zoneName' => 'Paul', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '621', 'countryId' => '39', 'zoneName' => 'Porto Novo', 'zoneCode' => 'PN', 'zoneStatus' => '1'],
            ['zoneId' => '622', 'countryId' => '39', 'zoneName' => 'Praia', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '623', 'countryId' => '39', 'zoneName' => 'Ribeira Grande', 'zoneCode' => 'RG', 'zoneStatus' => '1'],
            ['zoneId' => '624', 'countryId' => '39', 'zoneName' => 'Sal', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '625', 'countryId' => '39', 'zoneName' => 'Santa Catarina', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '626', 'countryId' => '39', 'zoneName' => 'Santa Cruz', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '627', 'countryId' => '39', 'zoneName' => 'Sao Domingos', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '628', 'countryId' => '39', 'zoneName' => 'Sao Filipe', 'zoneCode' => 'SF', 'zoneStatus' => '1'],
            ['zoneId' => '629', 'countryId' => '39', 'zoneName' => 'Sao Nicolau', 'zoneCode' => 'SN', 'zoneStatus' => '1'],
            ['zoneId' => '630', 'countryId' => '39', 'zoneName' => 'Sao Vicente', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '631', 'countryId' => '39', 'zoneName' => 'Tarrafal', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '632', 'countryId' => '40', 'zoneName' => 'Creek', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '633', 'countryId' => '40', 'zoneName' => 'Eastern', 'zoneCode' => 'EA', 'zoneStatus' => '1'],
            ['zoneId' => '634', 'countryId' => '40', 'zoneName' => 'Midland', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '635', 'countryId' => '40', 'zoneName' => 'South Town', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '636', 'countryId' => '40', 'zoneName' => 'Spot Bay', 'zoneCode' => 'SP', 'zoneStatus' => '1'],
            ['zoneId' => '637', 'countryId' => '40', 'zoneName' => 'Stake Bay', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '638', 'countryId' => '40', 'zoneName' => 'West End', 'zoneCode' => 'WD', 'zoneStatus' => '1'],
            ['zoneId' => '639', 'countryId' => '40', 'zoneName' => 'Western', 'zoneCode' => 'WN', 'zoneStatus' => '1'],
            ['zoneId' => '640', 'countryId' => '41', 'zoneName' => 'Bamingui-Bangoran', 'zoneCode' => 'BBA', 'zoneStatus' => '1'],
            ['zoneId' => '641', 'countryId' => '41', 'zoneName' => 'Basse-Kotto', 'zoneCode' => 'BKO', 'zoneStatus' => '1'],
            ['zoneId' => '642', 'countryId' => '41', 'zoneName' => 'Haute-Kotto', 'zoneCode' => 'HKO', 'zoneStatus' => '1'],
            ['zoneId' => '643', 'countryId' => '41', 'zoneName' => 'Haut-Mbomou', 'zoneCode' => 'HMB', 'zoneStatus' => '1'],
            ['zoneId' => '644', 'countryId' => '41', 'zoneName' => 'Kemo', 'zoneCode' => 'KEM', 'zoneStatus' => '1'],
            ['zoneId' => '645', 'countryId' => '41', 'zoneName' => 'Lobaye', 'zoneCode' => 'LOB', 'zoneStatus' => '1'],
            ['zoneId' => '646', 'countryId' => '41', 'zoneName' => 'Mambere-KadeÔ', 'zoneCode' => 'MKD', 'zoneStatus' => '1'],
            ['zoneId' => '647', 'countryId' => '41', 'zoneName' => 'Mbomou', 'zoneCode' => 'MBO', 'zoneStatus' => '1'],
            ['zoneId' => '648', 'countryId' => '41', 'zoneName' => 'Nana-Mambere', 'zoneCode' => 'NMM', 'zoneStatus' => '1'],
            ['zoneId' => '649', 'countryId' => '41', 'zoneName' => 'Ombella-M\'Poko', 'zoneCode' => 'OMP', 'zoneStatus' => '1'],
            ['zoneId' => '650', 'countryId' => '41', 'zoneName' => 'Ouaka', 'zoneCode' => 'OUK', 'zoneStatus' => '1'],
            ['zoneId' => '651', 'countryId' => '41', 'zoneName' => 'Ouham', 'zoneCode' => 'OUH', 'zoneStatus' => '1'],
            ['zoneId' => '652', 'countryId' => '41', 'zoneName' => 'Ouham-Pende', 'zoneCode' => 'OPE', 'zoneStatus' => '1'],
            ['zoneId' => '653', 'countryId' => '41', 'zoneName' => 'Vakaga', 'zoneCode' => 'VAK', 'zoneStatus' => '1'],
            ['zoneId' => '654', 'countryId' => '41', 'zoneName' => 'Nana-Grebizi', 'zoneCode' => 'NGR', 'zoneStatus' => '1'],
            ['zoneId' => '655', 'countryId' => '41', 'zoneName' => 'Sangha-Mbaere', 'zoneCode' => 'SMB', 'zoneStatus' => '1'],
            ['zoneId' => '656', 'countryId' => '41', 'zoneName' => 'Bangui', 'zoneCode' => 'BAN', 'zoneStatus' => '1'],
            ['zoneId' => '657', 'countryId' => '42', 'zoneName' => 'Batha', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '658', 'countryId' => '42', 'zoneName' => 'Biltine', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '659', 'countryId' => '42', 'zoneName' => 'Borkou-Ennedi-Tibesti', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '660', 'countryId' => '42', 'zoneName' => 'Chari-Baguirmi', 'zoneCode' => 'CB', 'zoneStatus' => '1'],
            ['zoneId' => '661', 'countryId' => '42', 'zoneName' => 'Guera', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '662', 'countryId' => '42', 'zoneName' => 'Kanem', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '663', 'countryId' => '42', 'zoneName' => 'Lac', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '664', 'countryId' => '42', 'zoneName' => 'Logone Occidental', 'zoneCode' => 'LC', 'zoneStatus' => '1'],
            ['zoneId' => '665', 'countryId' => '42', 'zoneName' => 'Logone Oriental', 'zoneCode' => 'LR', 'zoneStatus' => '1'],
            ['zoneId' => '666', 'countryId' => '42', 'zoneName' => 'Mayo-Kebbi', 'zoneCode' => 'MK', 'zoneStatus' => '1'],
            ['zoneId' => '667', 'countryId' => '42', 'zoneName' => 'Moyen-Chari', 'zoneCode' => 'MC', 'zoneStatus' => '1'],
            ['zoneId' => '668', 'countryId' => '42', 'zoneName' => 'Ouaddai', 'zoneCode' => 'OU', 'zoneStatus' => '1'],
            ['zoneId' => '669', 'countryId' => '42', 'zoneName' => 'Salamat', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '670', 'countryId' => '42', 'zoneName' => 'Tandjile', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '671', 'countryId' => '43', 'zoneName' => 'Aisen del General Carlos Ibanez', 'zoneCode' => 'AI', 'zoneStatus' => '1'],
            ['zoneId' => '672', 'countryId' => '43', 'zoneName' => 'Antofagasta', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '673', 'countryId' => '43', 'zoneName' => 'Araucania', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '674', 'countryId' => '43', 'zoneName' => 'Atacama', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '675', 'countryId' => '43', 'zoneName' => 'Bio-Bio', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '676', 'countryId' => '43', 'zoneName' => 'Coquimbo', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '677', 'countryId' => '43', 'zoneName' => 'Libertador General Bernardo O\'Higgins', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '678', 'countryId' => '43', 'zoneName' => 'Los Lagos', 'zoneCode' => 'LL', 'zoneStatus' => '1'],
            ['zoneId' => '679', 'countryId' => '43', 'zoneName' => 'Magallanes y de la Antartica Chilena', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '680', 'countryId' => '43', 'zoneName' => 'Maule', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '681', 'countryId' => '43', 'zoneName' => 'Region Metropolitana', 'zoneCode' => 'RM', 'zoneStatus' => '1'],
            ['zoneId' => '682', 'countryId' => '43', 'zoneName' => 'Tarapaca', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '683', 'countryId' => '43', 'zoneName' => 'Valparaiso', 'zoneCode' => 'VS', 'zoneStatus' => '1'],
            ['zoneId' => '684', 'countryId' => '44', 'zoneName' => 'Anhui', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '685', 'countryId' => '44', 'zoneName' => 'Beijing', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '686', 'countryId' => '44', 'zoneName' => 'Chongqing', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '687', 'countryId' => '44', 'zoneName' => 'Fujian', 'zoneCode' => 'FU', 'zoneStatus' => '1'],
            ['zoneId' => '688', 'countryId' => '44', 'zoneName' => 'Gansu', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '689', 'countryId' => '44', 'zoneName' => 'Guangdong', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '690', 'countryId' => '44', 'zoneName' => 'Guangxi', 'zoneCode' => 'GX', 'zoneStatus' => '1'],
            ['zoneId' => '691', 'countryId' => '44', 'zoneName' => 'Guizhou', 'zoneCode' => 'GZ', 'zoneStatus' => '1'],
            ['zoneId' => '692', 'countryId' => '44', 'zoneName' => 'Hainan', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '693', 'countryId' => '44', 'zoneName' => 'Hebei', 'zoneCode' => 'HB', 'zoneStatus' => '1'],
            ['zoneId' => '694', 'countryId' => '44', 'zoneName' => 'Heilongjiang', 'zoneCode' => 'HL', 'zoneStatus' => '1'],
            ['zoneId' => '695', 'countryId' => '44', 'zoneName' => 'Henan', 'zoneCode' => 'HE', 'zoneStatus' => '1'],
            ['zoneId' => '696', 'countryId' => '44', 'zoneName' => 'Hong Kong', 'zoneCode' => 'HK', 'zoneStatus' => '1'],
            ['zoneId' => '697', 'countryId' => '44', 'zoneName' => 'Hubei', 'zoneCode' => 'HU', 'zoneStatus' => '1'],
            ['zoneId' => '698', 'countryId' => '44', 'zoneName' => 'Hunan', 'zoneCode' => 'HN', 'zoneStatus' => '1'],
            ['zoneId' => '699', 'countryId' => '44', 'zoneName' => 'Inner Mongolia', 'zoneCode' => 'IM', 'zoneStatus' => '1'],
            ['zoneId' => '700', 'countryId' => '44', 'zoneName' => 'Jiangsu', 'zoneCode' => 'JI', 'zoneStatus' => '1'],
            ['zoneId' => '701', 'countryId' => '44', 'zoneName' => 'Jiangxi', 'zoneCode' => 'JX', 'zoneStatus' => '1'],
            ['zoneId' => '702', 'countryId' => '44', 'zoneName' => 'Jilin', 'zoneCode' => 'JL', 'zoneStatus' => '1'],
            ['zoneId' => '703', 'countryId' => '44', 'zoneName' => 'Liaoning', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '704', 'countryId' => '44', 'zoneName' => 'Macau', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '705', 'countryId' => '44', 'zoneName' => 'Ningxia', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '706', 'countryId' => '44', 'zoneName' => 'Shaanxi', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '707', 'countryId' => '44', 'zoneName' => 'Shandong', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '708', 'countryId' => '44', 'zoneName' => 'Shanghai', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '709', 'countryId' => '44', 'zoneName' => 'Shanxi', 'zoneCode' => 'SX', 'zoneStatus' => '1'],
            ['zoneId' => '710', 'countryId' => '44', 'zoneName' => 'Sichuan', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '711', 'countryId' => '44', 'zoneName' => 'Tianjin', 'zoneCode' => 'TI', 'zoneStatus' => '1'],
            ['zoneId' => '712', 'countryId' => '44', 'zoneName' => 'Xinjiang', 'zoneCode' => 'XI', 'zoneStatus' => '1'],
            ['zoneId' => '713', 'countryId' => '44', 'zoneName' => 'Yunnan', 'zoneCode' => 'YU', 'zoneStatus' => '1'],
            ['zoneId' => '714', 'countryId' => '44', 'zoneName' => 'Zhejiang', 'zoneCode' => 'ZH', 'zoneStatus' => '1'],
            ['zoneId' => '715', 'countryId' => '46', 'zoneName' => 'Direction Island', 'zoneCode' => 'D', 'zoneStatus' => '1'],
            ['zoneId' => '716', 'countryId' => '46', 'zoneName' => 'Home Island', 'zoneCode' => 'H', 'zoneStatus' => '1'],
            ['zoneId' => '717', 'countryId' => '46', 'zoneName' => 'Horsburgh Island', 'zoneCode' => 'O', 'zoneStatus' => '1'],
            ['zoneId' => '718', 'countryId' => '46', 'zoneName' => 'South Island', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '719', 'countryId' => '46', 'zoneName' => 'West Island', 'zoneCode' => 'W', 'zoneStatus' => '1'],
            ['zoneId' => '720', 'countryId' => '47', 'zoneName' => 'Amazonas', 'zoneCode' => 'AMZ', 'zoneStatus' => '1'],
            ['zoneId' => '721', 'countryId' => '47', 'zoneName' => 'Antioquia', 'zoneCode' => 'ANT', 'zoneStatus' => '1'],
            ['zoneId' => '722', 'countryId' => '47', 'zoneName' => 'Arauca', 'zoneCode' => 'ARA', 'zoneStatus' => '1'],
            ['zoneId' => '723', 'countryId' => '47', 'zoneName' => 'Atlantico', 'zoneCode' => 'ATL', 'zoneStatus' => '1'],
            ['zoneId' => '724', 'countryId' => '47', 'zoneName' => 'Bogota D.C.', 'zoneCode' => 'BDC', 'zoneStatus' => '1'],
            ['zoneId' => '725', 'countryId' => '47', 'zoneName' => 'Bolivar', 'zoneCode' => 'BOL', 'zoneStatus' => '1'],
            ['zoneId' => '726', 'countryId' => '47', 'zoneName' => 'Boyaca', 'zoneCode' => 'BOY', 'zoneStatus' => '1'],
            ['zoneId' => '727', 'countryId' => '47', 'zoneName' => 'Caldas', 'zoneCode' => 'CAL', 'zoneStatus' => '1'],
            ['zoneId' => '728', 'countryId' => '47', 'zoneName' => 'Caqueta', 'zoneCode' => 'CAQ', 'zoneStatus' => '1'],
            ['zoneId' => '729', 'countryId' => '47', 'zoneName' => 'Casanare', 'zoneCode' => 'CAS', 'zoneStatus' => '1'],
            ['zoneId' => '730', 'countryId' => '47', 'zoneName' => 'Cauca', 'zoneCode' => 'CAU', 'zoneStatus' => '1'],
            ['zoneId' => '731', 'countryId' => '47', 'zoneName' => 'Cesar', 'zoneCode' => 'CES', 'zoneStatus' => '1'],
            ['zoneId' => '732', 'countryId' => '47', 'zoneName' => 'Choco', 'zoneCode' => 'CHO', 'zoneStatus' => '1'],
            ['zoneId' => '733', 'countryId' => '47', 'zoneName' => 'Cordoba', 'zoneCode' => 'COR', 'zoneStatus' => '1'],
            ['zoneId' => '734', 'countryId' => '47', 'zoneName' => 'Cundinamarca', 'zoneCode' => 'CAM', 'zoneStatus' => '1'],
            ['zoneId' => '735', 'countryId' => '47', 'zoneName' => 'Guainia', 'zoneCode' => 'GNA', 'zoneStatus' => '1'],
            ['zoneId' => '736', 'countryId' => '47', 'zoneName' => 'Guajira', 'zoneCode' => 'GJR', 'zoneStatus' => '1'],
            ['zoneId' => '737', 'countryId' => '47', 'zoneName' => 'Guaviare', 'zoneCode' => 'GVR', 'zoneStatus' => '1'],
            ['zoneId' => '738', 'countryId' => '47', 'zoneName' => 'Huila', 'zoneCode' => 'HUI', 'zoneStatus' => '1'],
            ['zoneId' => '739', 'countryId' => '47', 'zoneName' => 'Magdalena', 'zoneCode' => 'MAG', 'zoneStatus' => '1'],
            ['zoneId' => '740', 'countryId' => '47', 'zoneName' => 'Meta', 'zoneCode' => 'MET', 'zoneStatus' => '1'],
            ['zoneId' => '741', 'countryId' => '47', 'zoneName' => 'Narino', 'zoneCode' => 'NAR', 'zoneStatus' => '1'],
            ['zoneId' => '742', 'countryId' => '47', 'zoneName' => 'Norte de Santander', 'zoneCode' => 'NDS', 'zoneStatus' => '1'],
            ['zoneId' => '743', 'countryId' => '47', 'zoneName' => 'Putumayo', 'zoneCode' => 'PUT', 'zoneStatus' => '1'],
            ['zoneId' => '744', 'countryId' => '47', 'zoneName' => 'Quindio', 'zoneCode' => 'QUI', 'zoneStatus' => '1'],
            ['zoneId' => '745', 'countryId' => '47', 'zoneName' => 'Risaralda', 'zoneCode' => 'RIS', 'zoneStatus' => '1'],
            ['zoneId' => '746', 'countryId' => '47', 'zoneName' => 'San Andres y Providencia', 'zoneCode' => 'SAP', 'zoneStatus' => '1'],
            ['zoneId' => '747', 'countryId' => '47', 'zoneName' => 'Santander', 'zoneCode' => 'SAN', 'zoneStatus' => '1'],
            ['zoneId' => '748', 'countryId' => '47', 'zoneName' => 'Sucre', 'zoneCode' => 'SUC', 'zoneStatus' => '1'],
            ['zoneId' => '749', 'countryId' => '47', 'zoneName' => 'Tolima', 'zoneCode' => 'TOL', 'zoneStatus' => '1'],
            ['zoneId' => '750', 'countryId' => '47', 'zoneName' => 'Valle del Cauca', 'zoneCode' => 'VDC', 'zoneStatus' => '1'],
            ['zoneId' => '751', 'countryId' => '47', 'zoneName' => 'Vaupes', 'zoneCode' => 'VAU', 'zoneStatus' => '1'],
            ['zoneId' => '752', 'countryId' => '47', 'zoneName' => 'Vichada', 'zoneCode' => 'VIC', 'zoneStatus' => '1'],
            ['zoneId' => '753', 'countryId' => '48', 'zoneName' => 'Grande Comore', 'zoneCode' => 'G', 'zoneStatus' => '1'],
            ['zoneId' => '754', 'countryId' => '48', 'zoneName' => 'Anjouan', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '755', 'countryId' => '48', 'zoneName' => 'Moheli', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '756', 'countryId' => '49', 'zoneName' => 'Bouenza', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '757', 'countryId' => '49', 'zoneName' => 'Brazzaville', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '758', 'countryId' => '49', 'zoneName' => 'Cuvette', 'zoneCode' => 'CU', 'zoneStatus' => '1'],
            ['zoneId' => '759', 'countryId' => '49', 'zoneName' => 'Cuvette-Ouest', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '760', 'countryId' => '49', 'zoneName' => 'Kouilou', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '761', 'countryId' => '49', 'zoneName' => 'Lekoumou', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '762', 'countryId' => '49', 'zoneName' => 'Likouala', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '763', 'countryId' => '49', 'zoneName' => 'Niari', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '764', 'countryId' => '49', 'zoneName' => 'Plateaux', 'zoneCode' => 'PL', 'zoneStatus' => '1'],
            ['zoneId' => '765', 'countryId' => '49', 'zoneName' => 'Pool', 'zoneCode' => 'PO', 'zoneStatus' => '1'],
            ['zoneId' => '766', 'countryId' => '49', 'zoneName' => 'Sangha', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '767', 'countryId' => '50', 'zoneName' => 'Pukapuka', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '768', 'countryId' => '50', 'zoneName' => 'Rakahanga', 'zoneCode' => 'RK', 'zoneStatus' => '1'],
            ['zoneId' => '769', 'countryId' => '50', 'zoneName' => 'Manihiki', 'zoneCode' => 'MK', 'zoneStatus' => '1'],
            ['zoneId' => '770', 'countryId' => '50', 'zoneName' => 'Penrhyn', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '771', 'countryId' => '50', 'zoneName' => 'Nassau Island', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '772', 'countryId' => '50', 'zoneName' => 'Surwarrow', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '773', 'countryId' => '50', 'zoneName' => 'Palmerston', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '774', 'countryId' => '50', 'zoneName' => 'Aitutaki', 'zoneCode' => 'AI', 'zoneStatus' => '1'],
            ['zoneId' => '775', 'countryId' => '50', 'zoneName' => 'Manuae', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '776', 'countryId' => '50', 'zoneName' => 'Takutea', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '777', 'countryId' => '50', 'zoneName' => 'Mitiaro', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '778', 'countryId' => '50', 'zoneName' => 'Atiu', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '779', 'countryId' => '50', 'zoneName' => 'Mauke', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '780', 'countryId' => '50', 'zoneName' => 'Rarotonga', 'zoneCode' => 'RR', 'zoneStatus' => '1'],
            ['zoneId' => '781', 'countryId' => '50', 'zoneName' => 'Mangaia', 'zoneCode' => 'MG', 'zoneStatus' => '1'],
            ['zoneId' => '782', 'countryId' => '51', 'zoneName' => 'Alajuela', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '783', 'countryId' => '51', 'zoneName' => 'Cartago', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '784', 'countryId' => '51', 'zoneName' => 'Guanacaste', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '785', 'countryId' => '51', 'zoneName' => 'Heredia', 'zoneCode' => 'HE', 'zoneStatus' => '1'],
            ['zoneId' => '786', 'countryId' => '51', 'zoneName' => 'Limon', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '787', 'countryId' => '51', 'zoneName' => 'Puntarenas', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '788', 'countryId' => '51', 'zoneName' => 'San Jose', 'zoneCode' => 'SJ', 'zoneStatus' => '1'],
            ['zoneId' => '789', 'countryId' => '52', 'zoneName' => 'Abengourou', 'zoneCode' => 'ABE', 'zoneStatus' => '1'],
            ['zoneId' => '790', 'countryId' => '52', 'zoneName' => 'Abidjan', 'zoneCode' => 'ABI', 'zoneStatus' => '1'],
            ['zoneId' => '791', 'countryId' => '52', 'zoneName' => 'Aboisso', 'zoneCode' => 'ABO', 'zoneStatus' => '1'],
            ['zoneId' => '792', 'countryId' => '52', 'zoneName' => 'Adiake', 'zoneCode' => 'ADI', 'zoneStatus' => '1'],
            ['zoneId' => '793', 'countryId' => '52', 'zoneName' => 'Adzope', 'zoneCode' => 'ADZ', 'zoneStatus' => '1'],
            ['zoneId' => '794', 'countryId' => '52', 'zoneName' => 'Agboville', 'zoneCode' => 'AGB', 'zoneStatus' => '1'],
            ['zoneId' => '795', 'countryId' => '52', 'zoneName' => 'Agnibilekrou', 'zoneCode' => 'AGN', 'zoneStatus' => '1'],
            ['zoneId' => '796', 'countryId' => '52', 'zoneName' => 'Alepe', 'zoneCode' => 'ALE', 'zoneStatus' => '1'],
            ['zoneId' => '797', 'countryId' => '52', 'zoneName' => 'Bocanda', 'zoneCode' => 'BOC', 'zoneStatus' => '1'],
            ['zoneId' => '798', 'countryId' => '52', 'zoneName' => 'Bangolo', 'zoneCode' => 'BAN', 'zoneStatus' => '1'],
            ['zoneId' => '799', 'countryId' => '52', 'zoneName' => 'Beoumi', 'zoneCode' => 'BEO', 'zoneStatus' => '1'],
            ['zoneId' => '800', 'countryId' => '52', 'zoneName' => 'Biankouma', 'zoneCode' => 'BIA', 'zoneStatus' => '1'],
            ['zoneId' => '801', 'countryId' => '52', 'zoneName' => 'Bondoukou', 'zoneCode' => 'BDK', 'zoneStatus' => '1'],
            ['zoneId' => '802', 'countryId' => '52', 'zoneName' => 'Bongouanou', 'zoneCode' => 'BGN', 'zoneStatus' => '1'],
            ['zoneId' => '803', 'countryId' => '52', 'zoneName' => 'Bouafle', 'zoneCode' => 'BFL', 'zoneStatus' => '1'],
            ['zoneId' => '804', 'countryId' => '52', 'zoneName' => 'Bouake', 'zoneCode' => 'BKE', 'zoneStatus' => '1'],
            ['zoneId' => '805', 'countryId' => '52', 'zoneName' => 'Bouna', 'zoneCode' => 'BNA', 'zoneStatus' => '1'],
            ['zoneId' => '806', 'countryId' => '52', 'zoneName' => 'Boundiali', 'zoneCode' => 'BDL', 'zoneStatus' => '1'],
            ['zoneId' => '807', 'countryId' => '52', 'zoneName' => 'Dabakala', 'zoneCode' => 'DKL', 'zoneStatus' => '1'],
            ['zoneId' => '808', 'countryId' => '52', 'zoneName' => 'Dabou', 'zoneCode' => 'DBU', 'zoneStatus' => '1'],
            ['zoneId' => '809', 'countryId' => '52', 'zoneName' => 'Daloa', 'zoneCode' => 'DAL', 'zoneStatus' => '1'],
            ['zoneId' => '810', 'countryId' => '52', 'zoneName' => 'Danane', 'zoneCode' => 'DAN', 'zoneStatus' => '1'],
            ['zoneId' => '811', 'countryId' => '52', 'zoneName' => 'Daoukro', 'zoneCode' => 'DAO', 'zoneStatus' => '1'],
            ['zoneId' => '812', 'countryId' => '52', 'zoneName' => 'Dimbokro', 'zoneCode' => 'DIM', 'zoneStatus' => '1'],
            ['zoneId' => '813', 'countryId' => '52', 'zoneName' => 'Divo', 'zoneCode' => 'DIV', 'zoneStatus' => '1'],
            ['zoneId' => '814', 'countryId' => '52', 'zoneName' => 'Duekoue', 'zoneCode' => 'DUE', 'zoneStatus' => '1'],
            ['zoneId' => '815', 'countryId' => '52', 'zoneName' => 'Ferkessedougou', 'zoneCode' => 'FER', 'zoneStatus' => '1'],
            ['zoneId' => '816', 'countryId' => '52', 'zoneName' => 'Gagnoa', 'zoneCode' => 'GAG', 'zoneStatus' => '1'],
            ['zoneId' => '817', 'countryId' => '52', 'zoneName' => 'Grand-Bassam', 'zoneCode' => 'GBA', 'zoneStatus' => '1'],
            ['zoneId' => '818', 'countryId' => '52', 'zoneName' => 'Grand-Lahou', 'zoneCode' => 'GLA', 'zoneStatus' => '1'],
            ['zoneId' => '819', 'countryId' => '52', 'zoneName' => 'Guiglo', 'zoneCode' => 'GUI', 'zoneStatus' => '1'],
            ['zoneId' => '820', 'countryId' => '52', 'zoneName' => 'Issia', 'zoneCode' => 'ISS', 'zoneStatus' => '1'],
            ['zoneId' => '821', 'countryId' => '52', 'zoneName' => 'Jacqueville', 'zoneCode' => 'JAC', 'zoneStatus' => '1'],
            ['zoneId' => '822', 'countryId' => '52', 'zoneName' => 'Katiola', 'zoneCode' => 'KAT', 'zoneStatus' => '1'],
            ['zoneId' => '823', 'countryId' => '52', 'zoneName' => 'Korhogo', 'zoneCode' => 'KOR', 'zoneStatus' => '1'],
            ['zoneId' => '824', 'countryId' => '52', 'zoneName' => 'Lakota', 'zoneCode' => 'LAK', 'zoneStatus' => '1'],
            ['zoneId' => '825', 'countryId' => '52', 'zoneName' => 'Man', 'zoneCode' => 'MAN', 'zoneStatus' => '1'],
            ['zoneId' => '826', 'countryId' => '52', 'zoneName' => 'Mankono', 'zoneCode' => 'MKN', 'zoneStatus' => '1'],
            ['zoneId' => '827', 'countryId' => '52', 'zoneName' => 'Mbahiakro', 'zoneCode' => 'MBA', 'zoneStatus' => '1'],
            ['zoneId' => '828', 'countryId' => '52', 'zoneName' => 'Odienne', 'zoneCode' => 'ODI', 'zoneStatus' => '1'],
            ['zoneId' => '829', 'countryId' => '52', 'zoneName' => 'Oume', 'zoneCode' => 'OUM', 'zoneStatus' => '1'],
            ['zoneId' => '830', 'countryId' => '52', 'zoneName' => 'Sakassou', 'zoneCode' => 'SAK', 'zoneStatus' => '1'],
            ['zoneId' => '831', 'countryId' => '52', 'zoneName' => 'San-Pedro', 'zoneCode' => 'SPE', 'zoneStatus' => '1'],
            ['zoneId' => '832', 'countryId' => '52', 'zoneName' => 'Sassandra', 'zoneCode' => 'SAS', 'zoneStatus' => '1'],
            ['zoneId' => '833', 'countryId' => '52', 'zoneName' => 'Seguela', 'zoneCode' => 'SEG', 'zoneStatus' => '1'],
            ['zoneId' => '834', 'countryId' => '52', 'zoneName' => 'Sinfra', 'zoneCode' => 'SIN', 'zoneStatus' => '1'],
            ['zoneId' => '835', 'countryId' => '52', 'zoneName' => 'Soubre', 'zoneCode' => 'SOU', 'zoneStatus' => '1'],
            ['zoneId' => '836', 'countryId' => '52', 'zoneName' => 'Tabou', 'zoneCode' => 'TAB', 'zoneStatus' => '1'],
            ['zoneId' => '837', 'countryId' => '52', 'zoneName' => 'Tanda', 'zoneCode' => 'TAN', 'zoneStatus' => '1'],
            ['zoneId' => '838', 'countryId' => '52', 'zoneName' => 'Tiebissou', 'zoneCode' => 'TIE', 'zoneStatus' => '1'],
            ['zoneId' => '839', 'countryId' => '52', 'zoneName' => 'Tingrela', 'zoneCode' => 'TIN', 'zoneStatus' => '1'],
            ['zoneId' => '840', 'countryId' => '52', 'zoneName' => 'Tiassale', 'zoneCode' => 'TIA', 'zoneStatus' => '1'],
            ['zoneId' => '841', 'countryId' => '52', 'zoneName' => 'Touba', 'zoneCode' => 'TBA', 'zoneStatus' => '1'],
            ['zoneId' => '842', 'countryId' => '52', 'zoneName' => 'Toulepleu', 'zoneCode' => 'TLP', 'zoneStatus' => '1'],
            ['zoneId' => '843', 'countryId' => '52', 'zoneName' => 'Toumodi', 'zoneCode' => 'TMD', 'zoneStatus' => '1'],
            ['zoneId' => '844', 'countryId' => '52', 'zoneName' => 'Vavoua', 'zoneCode' => 'VAV', 'zoneStatus' => '1'],
            ['zoneId' => '845', 'countryId' => '52', 'zoneName' => 'Yamoussoukro', 'zoneCode' => 'YAM', 'zoneStatus' => '1'],
            ['zoneId' => '846', 'countryId' => '52', 'zoneName' => 'Zuenoula', 'zoneCode' => 'ZUE', 'zoneStatus' => '1'],
            ['zoneId' => '847', 'countryId' => '53', 'zoneName' => 'Bjelovarsko-bilogorska', 'zoneCode' => 'BB', 'zoneStatus' => '1'],
            ['zoneId' => '848', 'countryId' => '53', 'zoneName' => 'Grad Zagreb', 'zoneCode' => 'GZ', 'zoneStatus' => '1'],
            ['zoneId' => '849', 'countryId' => '53', 'zoneName' => 'Dubrovačko-neretvanska', 'zoneCode' => 'DN', 'zoneStatus' => '1'],
            ['zoneId' => '850', 'countryId' => '53', 'zoneName' => 'Istarska', 'zoneCode' => 'IS', 'zoneStatus' => '1'],
            ['zoneId' => '851', 'countryId' => '53', 'zoneName' => 'Karlovačka', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '852', 'countryId' => '53', 'zoneName' => 'Koprivničko-križevačka', 'zoneCode' => 'KK', 'zoneStatus' => '1'],
            ['zoneId' => '853', 'countryId' => '53', 'zoneName' => 'Krapinsko-zagorska', 'zoneCode' => 'KZ', 'zoneStatus' => '1'],
            ['zoneId' => '854', 'countryId' => '53', 'zoneName' => 'Ličko-senjska', 'zoneCode' => 'LS', 'zoneStatus' => '1'],
            ['zoneId' => '855', 'countryId' => '53', 'zoneName' => 'Međimurska', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '856', 'countryId' => '53', 'zoneName' => 'Osječko-baranjska', 'zoneCode' => 'OB', 'zoneStatus' => '1'],
            ['zoneId' => '857', 'countryId' => '53', 'zoneName' => 'Požeško-slavonska', 'zoneCode' => 'PS', 'zoneStatus' => '1'],
            ['zoneId' => '858', 'countryId' => '53', 'zoneName' => 'Primorsko-goranska', 'zoneCode' => 'PG', 'zoneStatus' => '1'],
            ['zoneId' => '859', 'countryId' => '53', 'zoneName' => 'Šibensko-kninska', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '860', 'countryId' => '53', 'zoneName' => 'Sisačko-moslavačka', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '861', 'countryId' => '53', 'zoneName' => 'Brodsko-posavska', 'zoneCode' => 'BP', 'zoneStatus' => '1'],
            ['zoneId' => '862', 'countryId' => '53', 'zoneName' => 'Splitsko-dalmatinska', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '863', 'countryId' => '53', 'zoneName' => 'Varaždinska', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '864', 'countryId' => '53', 'zoneName' => 'Virovitičko-podravska', 'zoneCode' => 'VP', 'zoneStatus' => '1'],
            ['zoneId' => '865', 'countryId' => '53', 'zoneName' => 'Vukovarsko-srijemska', 'zoneCode' => 'VS', 'zoneStatus' => '1'],
            ['zoneId' => '866', 'countryId' => '53', 'zoneName' => 'Zadarska', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '867', 'countryId' => '53', 'zoneName' => 'Zagrebačka', 'zoneCode' => 'ZG', 'zoneStatus' => '1'],
            ['zoneId' => '868', 'countryId' => '54', 'zoneName' => 'Camaguey', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '869', 'countryId' => '54', 'zoneName' => 'Ciego de Avila', 'zoneCode' => 'CD', 'zoneStatus' => '1'],
            ['zoneId' => '870', 'countryId' => '54', 'zoneName' => 'Cienfuegos', 'zoneCode' => 'CI', 'zoneStatus' => '1'],
            ['zoneId' => '871', 'countryId' => '54', 'zoneName' => 'Ciudad de La Habana', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '872', 'countryId' => '54', 'zoneName' => 'Granma', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '873', 'countryId' => '54', 'zoneName' => 'Guantanamo', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '874', 'countryId' => '54', 'zoneName' => 'Holguin', 'zoneCode' => 'HO', 'zoneStatus' => '1'],
            ['zoneId' => '875', 'countryId' => '54', 'zoneName' => 'Isla de la Juventud', 'zoneCode' => 'IJ', 'zoneStatus' => '1'],
            ['zoneId' => '876', 'countryId' => '54', 'zoneName' => 'La Habana', 'zoneCode' => 'LH', 'zoneStatus' => '1'],
            ['zoneId' => '877', 'countryId' => '54', 'zoneName' => 'Las Tunas', 'zoneCode' => 'LT', 'zoneStatus' => '1'],
            ['zoneId' => '878', 'countryId' => '54', 'zoneName' => 'Matanzas', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '879', 'countryId' => '54', 'zoneName' => 'Pinar del Rio', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '880', 'countryId' => '54', 'zoneName' => 'Sancti Spiritus', 'zoneCode' => 'SS', 'zoneStatus' => '1'],
            ['zoneId' => '881', 'countryId' => '54', 'zoneName' => 'Santiago de Cuba', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '882', 'countryId' => '54', 'zoneName' => 'Villa Clara', 'zoneCode' => 'VC', 'zoneStatus' => '1'],
            ['zoneId' => '883', 'countryId' => '55', 'zoneName' => 'Famagusta', 'zoneCode' => 'F', 'zoneStatus' => '1'],
            ['zoneId' => '884', 'countryId' => '55', 'zoneName' => 'Kyrenia', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '885', 'countryId' => '55', 'zoneName' => 'Larnaca', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '886', 'countryId' => '55', 'zoneName' => 'Limassol', 'zoneCode' => 'I', 'zoneStatus' => '1'],
            ['zoneId' => '887', 'countryId' => '55', 'zoneName' => 'Nicosia', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '888', 'countryId' => '55', 'zoneName' => 'Paphos', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '889', 'countryId' => '56', 'zoneName' => 'Ústecký', 'zoneCode' => 'U', 'zoneStatus' => '1'],
            ['zoneId' => '890', 'countryId' => '56', 'zoneName' => 'Jihočeský', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '891', 'countryId' => '56', 'zoneName' => 'Jihomoravský', 'zoneCode' => 'B', 'zoneStatus' => '1'],
            ['zoneId' => '892', 'countryId' => '56', 'zoneName' => 'Karlovarský', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '893', 'countryId' => '56', 'zoneName' => 'Královehradecký', 'zoneCode' => 'H', 'zoneStatus' => '1'],
            ['zoneId' => '894', 'countryId' => '56', 'zoneName' => 'Liberecký', 'zoneCode' => 'L', 'zoneStatus' => '1'],
            ['zoneId' => '895', 'countryId' => '56', 'zoneName' => 'Moravskoslezský', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '896', 'countryId' => '56', 'zoneName' => 'Olomoucký', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '897', 'countryId' => '56', 'zoneName' => 'Pardubický', 'zoneCode' => 'E', 'zoneStatus' => '1'],
            ['zoneId' => '898', 'countryId' => '56', 'zoneName' => 'Plzeňský', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '899', 'countryId' => '56', 'zoneName' => 'Praha', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '900', 'countryId' => '56', 'zoneName' => 'Středočeský', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '901', 'countryId' => '56', 'zoneName' => 'Vysočina', 'zoneCode' => 'J', 'zoneStatus' => '1'],
            ['zoneId' => '902', 'countryId' => '56', 'zoneName' => 'Zlínský', 'zoneCode' => 'Z', 'zoneStatus' => '1'],
            ['zoneId' => '903', 'countryId' => '57', 'zoneName' => 'Arhus', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '904', 'countryId' => '57', 'zoneName' => 'Bornholm', 'zoneCode' => 'BH', 'zoneStatus' => '1'],
            ['zoneId' => '905', 'countryId' => '57', 'zoneName' => 'Copenhagen', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '906', 'countryId' => '57', 'zoneName' => 'Faroe Islands', 'zoneCode' => 'FO', 'zoneStatus' => '1'],
            ['zoneId' => '907', 'countryId' => '57', 'zoneName' => 'Frederiksborg', 'zoneCode' => 'FR', 'zoneStatus' => '1'],
            ['zoneId' => '908', 'countryId' => '57', 'zoneName' => 'Fyn', 'zoneCode' => 'FY', 'zoneStatus' => '1'],
            ['zoneId' => '909', 'countryId' => '57', 'zoneName' => 'Kobenhavn', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '910', 'countryId' => '57', 'zoneName' => 'Nordjylland', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '911', 'countryId' => '57', 'zoneName' => 'Ribe', 'zoneCode' => 'RI', 'zoneStatus' => '1'],
            ['zoneId' => '912', 'countryId' => '57', 'zoneName' => 'Ringkobing', 'zoneCode' => 'RK', 'zoneStatus' => '1'],
            ['zoneId' => '913', 'countryId' => '57', 'zoneName' => 'Roskilde', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '914', 'countryId' => '57', 'zoneName' => 'Sonderjylland', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '915', 'countryId' => '57', 'zoneName' => 'Storstrom', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '916', 'countryId' => '57', 'zoneName' => 'Vejle', 'zoneCode' => 'VK', 'zoneStatus' => '1'],
            ['zoneId' => '917', 'countryId' => '57', 'zoneName' => 'Vestj&aelig;lland', 'zoneCode' => 'VJ', 'zoneStatus' => '1'],
            ['zoneId' => '918', 'countryId' => '57', 'zoneName' => 'Viborg', 'zoneCode' => 'VB', 'zoneStatus' => '1'],
            ['zoneId' => '919', 'countryId' => '58', 'zoneName' => '\'Ali Sabih', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '920', 'countryId' => '58', 'zoneName' => 'Dikhil', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '921', 'countryId' => '58', 'zoneName' => 'Djibouti', 'zoneCode' => 'J', 'zoneStatus' => '1'],
            ['zoneId' => '922', 'countryId' => '58', 'zoneName' => 'Obock', 'zoneCode' => 'O', 'zoneStatus' => '1'],
            ['zoneId' => '923', 'countryId' => '58', 'zoneName' => 'Tadjoura', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '924', 'countryId' => '59', 'zoneName' => 'Saint Andrew Parish', 'zoneCode' => 'AND', 'zoneStatus' => '1'],
            ['zoneId' => '925', 'countryId' => '59', 'zoneName' => 'Saint David Parish', 'zoneCode' => 'DAV', 'zoneStatus' => '1'],
            ['zoneId' => '926', 'countryId' => '59', 'zoneName' => 'Saint George Parish', 'zoneCode' => 'GEO', 'zoneStatus' => '1'],
            ['zoneId' => '927', 'countryId' => '59', 'zoneName' => 'Saint John Parish', 'zoneCode' => 'JOH', 'zoneStatus' => '1'],
            ['zoneId' => '928', 'countryId' => '59', 'zoneName' => 'Saint Joseph Parish', 'zoneCode' => 'JOS', 'zoneStatus' => '1'],
            ['zoneId' => '929', 'countryId' => '59', 'zoneName' => 'Saint Luke Parish', 'zoneCode' => 'LUK', 'zoneStatus' => '1'],
            ['zoneId' => '930', 'countryId' => '59', 'zoneName' => 'Saint Mark Parish', 'zoneCode' => 'MAR', 'zoneStatus' => '1'],
            ['zoneId' => '931', 'countryId' => '59', 'zoneName' => 'Saint Patrick Parish', 'zoneCode' => 'PAT', 'zoneStatus' => '1'],
            ['zoneId' => '932', 'countryId' => '59', 'zoneName' => 'Saint Paul Parish', 'zoneCode' => 'PAU', 'zoneStatus' => '1'],
            ['zoneId' => '933', 'countryId' => '59', 'zoneName' => 'Saint Peter Parish', 'zoneCode' => 'PET', 'zoneStatus' => '1'],
            ['zoneId' => '934', 'countryId' => '60', 'zoneName' => 'Distrito Nacional', 'zoneCode' => 'DN', 'zoneStatus' => '1'],
            ['zoneId' => '935', 'countryId' => '60', 'zoneName' => 'Azua', 'zoneCode' => 'AZ', 'zoneStatus' => '1'],
            ['zoneId' => '936', 'countryId' => '60', 'zoneName' => 'Baoruco', 'zoneCode' => 'BC', 'zoneStatus' => '1'],
            ['zoneId' => '937', 'countryId' => '60', 'zoneName' => 'Barahona', 'zoneCode' => 'BH', 'zoneStatus' => '1'],
            ['zoneId' => '938', 'countryId' => '60', 'zoneName' => 'Dajabon', 'zoneCode' => 'DJ', 'zoneStatus' => '1'],
            ['zoneId' => '939', 'countryId' => '60', 'zoneName' => 'Duarte', 'zoneCode' => 'DU', 'zoneStatus' => '1'],
            ['zoneId' => '940', 'countryId' => '60', 'zoneName' => 'Elias Pina', 'zoneCode' => 'EL', 'zoneStatus' => '1'],
            ['zoneId' => '941', 'countryId' => '60', 'zoneName' => 'El Seybo', 'zoneCode' => 'SY', 'zoneStatus' => '1'],
            ['zoneId' => '942', 'countryId' => '60', 'zoneName' => 'Espaillat', 'zoneCode' => 'ET', 'zoneStatus' => '1'],
            ['zoneId' => '943', 'countryId' => '60', 'zoneName' => 'Hato Mayor', 'zoneCode' => 'HM', 'zoneStatus' => '1'],
            ['zoneId' => '944', 'countryId' => '60', 'zoneName' => 'Independencia', 'zoneCode' => 'IN', 'zoneStatus' => '1'],
            ['zoneId' => '945', 'countryId' => '60', 'zoneName' => 'La Altagracia', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '946', 'countryId' => '60', 'zoneName' => 'La Romana', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '947', 'countryId' => '60', 'zoneName' => 'La Vega', 'zoneCode' => 'VE', 'zoneStatus' => '1'],
            ['zoneId' => '948', 'countryId' => '60', 'zoneName' => 'Maria Trinidad Sanchez', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '949', 'countryId' => '60', 'zoneName' => 'Monsenor Nouel', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '950', 'countryId' => '60', 'zoneName' => 'Monte Cristi', 'zoneCode' => 'MC', 'zoneStatus' => '1'],
            ['zoneId' => '951', 'countryId' => '60', 'zoneName' => 'Monte Plata', 'zoneCode' => 'MP', 'zoneStatus' => '1'],
            ['zoneId' => '952', 'countryId' => '60', 'zoneName' => 'Pedernales', 'zoneCode' => 'PD', 'zoneStatus' => '1'],
            ['zoneId' => '953', 'countryId' => '60', 'zoneName' => 'Peravia (Bani)', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '954', 'countryId' => '60', 'zoneName' => 'Puerto Plata', 'zoneCode' => 'PP', 'zoneStatus' => '1'],
            ['zoneId' => '955', 'countryId' => '60', 'zoneName' => 'Salcedo', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '956', 'countryId' => '60', 'zoneName' => 'Samana', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '957', 'countryId' => '60', 'zoneName' => 'Sanchez Ramirez', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '958', 'countryId' => '60', 'zoneName' => 'San Cristobal', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '959', 'countryId' => '60', 'zoneName' => 'San Jose de Ocoa', 'zoneCode' => 'JO', 'zoneStatus' => '1'],
            ['zoneId' => '960', 'countryId' => '60', 'zoneName' => 'San Juan', 'zoneCode' => 'SJ', 'zoneStatus' => '1'],
            ['zoneId' => '961', 'countryId' => '60', 'zoneName' => 'San Pedro de Macoris', 'zoneCode' => 'PM', 'zoneStatus' => '1'],
            ['zoneId' => '962', 'countryId' => '60', 'zoneName' => 'Santiago', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '963', 'countryId' => '60', 'zoneName' => 'Santiago Rodriguez', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '964', 'countryId' => '60', 'zoneName' => 'Santo Domingo', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '965', 'countryId' => '60', 'zoneName' => 'Valverde', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '966', 'countryId' => '61', 'zoneName' => 'Aileu', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '967', 'countryId' => '61', 'zoneName' => 'Ainaro', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '968', 'countryId' => '61', 'zoneName' => 'Baucau', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '969', 'countryId' => '61', 'zoneName' => 'Bobonaro', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '970', 'countryId' => '61', 'zoneName' => 'Cova Lima', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '971', 'countryId' => '61', 'zoneName' => 'Dili', 'zoneCode' => 'DI', 'zoneStatus' => '1'],
            ['zoneId' => '972', 'countryId' => '61', 'zoneName' => 'Ermera', 'zoneCode' => 'ER', 'zoneStatus' => '1'],
            ['zoneId' => '973', 'countryId' => '61', 'zoneName' => 'Lautem', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '974', 'countryId' => '61', 'zoneName' => 'Liquica', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '975', 'countryId' => '61', 'zoneName' => 'Manatuto', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '976', 'countryId' => '61', 'zoneName' => 'Manufahi', 'zoneCode' => 'MF', 'zoneStatus' => '1'],
            ['zoneId' => '977', 'countryId' => '61', 'zoneName' => 'Oecussi', 'zoneCode' => 'OE', 'zoneStatus' => '1'],
            ['zoneId' => '978', 'countryId' => '61', 'zoneName' => 'Viqueque', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '979', 'countryId' => '62', 'zoneName' => 'Azuay', 'zoneCode' => 'AZU', 'zoneStatus' => '1'],
            ['zoneId' => '980', 'countryId' => '62', 'zoneName' => 'Bolivar', 'zoneCode' => 'BOL', 'zoneStatus' => '1'],
            ['zoneId' => '981', 'countryId' => '62', 'zoneName' => 'Ca&ntilde;ar', 'zoneCode' => 'CAN', 'zoneStatus' => '1'],
            ['zoneId' => '982', 'countryId' => '62', 'zoneName' => 'Carchi', 'zoneCode' => 'CAR', 'zoneStatus' => '1'],
            ['zoneId' => '983', 'countryId' => '62', 'zoneName' => 'Chimborazo', 'zoneCode' => 'CHI', 'zoneStatus' => '1'],
            ['zoneId' => '984', 'countryId' => '62', 'zoneName' => 'Cotopaxi', 'zoneCode' => 'COT', 'zoneStatus' => '1'],
            ['zoneId' => '985', 'countryId' => '62', 'zoneName' => 'El Oro', 'zoneCode' => 'EOR', 'zoneStatus' => '1'],
            ['zoneId' => '986', 'countryId' => '62', 'zoneName' => 'Esmeraldas', 'zoneCode' => 'ESM', 'zoneStatus' => '1'],
            ['zoneId' => '987', 'countryId' => '62', 'zoneName' => 'Gal&aacute;pagos', 'zoneCode' => 'GPS', 'zoneStatus' => '1'],
            ['zoneId' => '988', 'countryId' => '62', 'zoneName' => 'Guayas', 'zoneCode' => 'GUA', 'zoneStatus' => '1'],
            ['zoneId' => '989', 'countryId' => '62', 'zoneName' => 'Imbabura', 'zoneCode' => 'IMB', 'zoneStatus' => '1'],
            ['zoneId' => '990', 'countryId' => '62', 'zoneName' => 'Loja', 'zoneCode' => 'LOJ', 'zoneStatus' => '1'],
            ['zoneId' => '991', 'countryId' => '62', 'zoneName' => 'Los Rios', 'zoneCode' => 'LRO', 'zoneStatus' => '1'],
            ['zoneId' => '992', 'countryId' => '62', 'zoneName' => 'Manab&iacute;', 'zoneCode' => 'MAN', 'zoneStatus' => '1'],
            ['zoneId' => '993', 'countryId' => '62', 'zoneName' => 'Morona Santiago', 'zoneCode' => 'MSA', 'zoneStatus' => '1'],
            ['zoneId' => '994', 'countryId' => '62', 'zoneName' => 'Napo', 'zoneCode' => 'NAP', 'zoneStatus' => '1'],
            ['zoneId' => '995', 'countryId' => '62', 'zoneName' => 'Orellana', 'zoneCode' => 'ORE', 'zoneStatus' => '1'],
            ['zoneId' => '996', 'countryId' => '62', 'zoneName' => 'Pastaza', 'zoneCode' => 'PAS', 'zoneStatus' => '1'],
            ['zoneId' => '997', 'countryId' => '62', 'zoneName' => 'Pichincha', 'zoneCode' => 'PIC', 'zoneStatus' => '1'],
            ['zoneId' => '998', 'countryId' => '62', 'zoneName' => 'Sucumb&iacute;os', 'zoneCode' => 'SUC', 'zoneStatus' => '1'],
            ['zoneId' => '999', 'countryId' => '62', 'zoneName' => 'Tungurahua', 'zoneCode' => 'TUN', 'zoneStatus' => '1'],
            ['zoneId' => '1000', 'countryId' => '62', 'zoneName' => 'Zamora Chinchipe', 'zoneCode' => 'ZCH', 'zoneStatus' => '1'],
            ['zoneId' => '1001', 'countryId' => '63', 'zoneName' => 'Ad Daqahliyah', 'zoneCode' => 'DHY', 'zoneStatus' => '1'],
            ['zoneId' => '1002', 'countryId' => '63', 'zoneName' => 'Al Bahr al Ahmar', 'zoneCode' => 'BAM', 'zoneStatus' => '1'],
            ['zoneId' => '1003', 'countryId' => '63', 'zoneName' => 'Al Buhayrah', 'zoneCode' => 'BHY', 'zoneStatus' => '1'],
            ['zoneId' => '1004', 'countryId' => '63', 'zoneName' => 'Al Fayyum', 'zoneCode' => 'FYM', 'zoneStatus' => '1'],
            ['zoneId' => '1005', 'countryId' => '63', 'zoneName' => 'Al Gharbiyah', 'zoneCode' => 'GBY', 'zoneStatus' => '1'],
            ['zoneId' => '1006', 'countryId' => '63', 'zoneName' => 'Al Iskandariyah', 'zoneCode' => 'IDR', 'zoneStatus' => '1'],
            ['zoneId' => '1007', 'countryId' => '63', 'zoneName' => 'Al Isma\'iliyah', 'zoneCode' => 'IML', 'zoneStatus' => '1'],
            ['zoneId' => '1008', 'countryId' => '63', 'zoneName' => 'Al Jizah', 'zoneCode' => 'JZH', 'zoneStatus' => '1'],
            ['zoneId' => '1009', 'countryId' => '63', 'zoneName' => 'Al Minufiyah', 'zoneCode' => 'MFY', 'zoneStatus' => '1'],
            ['zoneId' => '1010', 'countryId' => '63', 'zoneName' => 'Al Minya', 'zoneCode' => 'MNY', 'zoneStatus' => '1'],
            ['zoneId' => '1011', 'countryId' => '63', 'zoneName' => 'Al Qahirah', 'zoneCode' => 'QHR', 'zoneStatus' => '1'],
            ['zoneId' => '1012', 'countryId' => '63', 'zoneName' => 'Al Qalyubiyah', 'zoneCode' => 'QLY', 'zoneStatus' => '1'],
            ['zoneId' => '1013', 'countryId' => '63', 'zoneName' => 'Al Wadi al Jadid', 'zoneCode' => 'WJD', 'zoneStatus' => '1'],
            ['zoneId' => '1014', 'countryId' => '63', 'zoneName' => 'Ash Sharqiyah', 'zoneCode' => 'SHQ', 'zoneStatus' => '1'],
            ['zoneId' => '1015', 'countryId' => '63', 'zoneName' => 'As Suways', 'zoneCode' => 'SWY', 'zoneStatus' => '1'],
            ['zoneId' => '1016', 'countryId' => '63', 'zoneName' => 'Aswan', 'zoneCode' => 'ASW', 'zoneStatus' => '1'],
            ['zoneId' => '1017', 'countryId' => '63', 'zoneName' => 'Asyut', 'zoneCode' => 'ASY', 'zoneStatus' => '1'],
            ['zoneId' => '1018', 'countryId' => '63', 'zoneName' => 'Bani Suwayf', 'zoneCode' => 'BSW', 'zoneStatus' => '1'],
            ['zoneId' => '1019', 'countryId' => '63', 'zoneName' => 'Bur Sa\'id', 'zoneCode' => 'BSD', 'zoneStatus' => '1'],
            ['zoneId' => '1020', 'countryId' => '63', 'zoneName' => 'Dumyat', 'zoneCode' => 'DMY', 'zoneStatus' => '1'],
            ['zoneId' => '1021', 'countryId' => '63', 'zoneName' => 'Janub Sina\'', 'zoneCode' => 'JNS', 'zoneStatus' => '1'],
            ['zoneId' => '1022', 'countryId' => '63', 'zoneName' => 'Kafr ash Shaykh', 'zoneCode' => 'KSH', 'zoneStatus' => '1'],
            ['zoneId' => '1023', 'countryId' => '63', 'zoneName' => 'Matruh', 'zoneCode' => 'MAT', 'zoneStatus' => '1'],
            ['zoneId' => '1024', 'countryId' => '63', 'zoneName' => 'Qina', 'zoneCode' => 'QIN', 'zoneStatus' => '1'],
            ['zoneId' => '1025', 'countryId' => '63', 'zoneName' => 'Shamal Sina\'', 'zoneCode' => 'SHS', 'zoneStatus' => '1'],
            ['zoneId' => '1026', 'countryId' => '63', 'zoneName' => 'Suhaj', 'zoneCode' => 'SUH', 'zoneStatus' => '1'],
            ['zoneId' => '1027', 'countryId' => '64', 'zoneName' => 'Ahuachapan', 'zoneCode' => 'AH', 'zoneStatus' => '1'],
            ['zoneId' => '1028', 'countryId' => '64', 'zoneName' => 'Cabanas', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '1029', 'countryId' => '64', 'zoneName' => 'Chalatenango', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '1030', 'countryId' => '64', 'zoneName' => 'Cuscatlan', 'zoneCode' => 'CU', 'zoneStatus' => '1'],
            ['zoneId' => '1031', 'countryId' => '64', 'zoneName' => 'La Libertad', 'zoneCode' => 'LB', 'zoneStatus' => '1'],
            ['zoneId' => '1032', 'countryId' => '64', 'zoneName' => 'La Paz', 'zoneCode' => 'PZ', 'zoneStatus' => '1'],
            ['zoneId' => '1033', 'countryId' => '64', 'zoneName' => 'La Union', 'zoneCode' => 'UN', 'zoneStatus' => '1'],
            ['zoneId' => '1034', 'countryId' => '64', 'zoneName' => 'Morazan', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '1035', 'countryId' => '64', 'zoneName' => 'San Miguel', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '1036', 'countryId' => '64', 'zoneName' => 'San Salvador', 'zoneCode' => 'SS', 'zoneStatus' => '1'],
            ['zoneId' => '1037', 'countryId' => '64', 'zoneName' => 'San Vicente', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '1038', 'countryId' => '64', 'zoneName' => 'Santa Ana', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '1039', 'countryId' => '64', 'zoneName' => 'Sonsonate', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '1040', 'countryId' => '64', 'zoneName' => 'Usulutan', 'zoneCode' => 'US', 'zoneStatus' => '1'],
            ['zoneId' => '1041', 'countryId' => '65', 'zoneName' => 'Provincia Annobon', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '1042', 'countryId' => '65', 'zoneName' => 'Provincia Bioko Norte', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '1043', 'countryId' => '65', 'zoneName' => 'Provincia Bioko Sur', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '1044', 'countryId' => '65', 'zoneName' => 'Provincia Centro Sur', 'zoneCode' => 'CS', 'zoneStatus' => '1'],
            ['zoneId' => '1045', 'countryId' => '65', 'zoneName' => 'Provincia Kie-Ntem', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '1046', 'countryId' => '65', 'zoneName' => 'Provincia Litoral', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '1047', 'countryId' => '65', 'zoneName' => 'Provincia Wele-Nzas', 'zoneCode' => 'WN', 'zoneStatus' => '1'],
            ['zoneId' => '1048', 'countryId' => '66', 'zoneName' => 'Central (Maekel)', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1049', 'countryId' => '66', 'zoneName' => 'Anseba (Keren)', 'zoneCode' => 'KE', 'zoneStatus' => '1'],
            ['zoneId' => '1050', 'countryId' => '66', 'zoneName' => 'Southern Red Sea (Debub-Keih-Bahri)', 'zoneCode' => 'DK', 'zoneStatus' => '1'],
            ['zoneId' => '1051', 'countryId' => '66', 'zoneName' => 'Northern Red Sea (Semien-Keih-Bahri)', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '1052', 'countryId' => '66', 'zoneName' => 'Southern (Debub)', 'zoneCode' => 'DE', 'zoneStatus' => '1'],
            ['zoneId' => '1053', 'countryId' => '66', 'zoneName' => 'Gash-Barka (Barentu)', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '1054', 'countryId' => '67', 'zoneName' => 'Harjumaa (Tallinn)', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '1055', 'countryId' => '67', 'zoneName' => 'Hiiumaa (Kardla)', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '1056', 'countryId' => '67', 'zoneName' => 'Ida-Virumaa (Johvi)', 'zoneCode' => 'IV', 'zoneStatus' => '1'],
            ['zoneId' => '1057', 'countryId' => '67', 'zoneName' => 'Jarvamaa (Paide)', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '1058', 'countryId' => '67', 'zoneName' => 'Jogevamaa (Jogeva)', 'zoneCode' => 'JO', 'zoneStatus' => '1'],
            ['zoneId' => '1059', 'countryId' => '67', 'zoneName' => 'Laane-Virumaa (Rakvere)', 'zoneCode' => 'LV', 'zoneStatus' => '1'],
            ['zoneId' => '1060', 'countryId' => '67', 'zoneName' => 'Laanemaa (Haapsalu)', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '1061', 'countryId' => '67', 'zoneName' => 'Parnumaa (Parnu)', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '1062', 'countryId' => '67', 'zoneName' => 'Polvamaa (Polva)', 'zoneCode' => 'PO', 'zoneStatus' => '1'],
            ['zoneId' => '1063', 'countryId' => '67', 'zoneName' => 'Raplamaa (Rapla)', 'zoneCode' => 'RA', 'zoneStatus' => '1'],
            ['zoneId' => '1064', 'countryId' => '67', 'zoneName' => 'Saaremaa (Kuessaare)', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '1065', 'countryId' => '67', 'zoneName' => 'Tartumaa (Tartu)', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '1066', 'countryId' => '67', 'zoneName' => 'Valgamaa (Valga)', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '1067', 'countryId' => '67', 'zoneName' => 'Viljandimaa (Viljandi)', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '1068', 'countryId' => '67', 'zoneName' => 'Vorumaa (Voru)', 'zoneCode' => 'VO', 'zoneStatus' => '1'],
            ['zoneId' => '1069', 'countryId' => '68', 'zoneName' => 'Afar', 'zoneCode' => 'AF', 'zoneStatus' => '1'],
            ['zoneId' => '1070', 'countryId' => '68', 'zoneName' => 'Amhara', 'zoneCode' => 'AH', 'zoneStatus' => '1'],
            ['zoneId' => '1071', 'countryId' => '68', 'zoneName' => 'Benishangul-Gumaz', 'zoneCode' => 'BG', 'zoneStatus' => '1'],
            ['zoneId' => '1072', 'countryId' => '68', 'zoneName' => 'Gambela', 'zoneCode' => 'GB', 'zoneStatus' => '1'],
            ['zoneId' => '1073', 'countryId' => '68', 'zoneName' => 'Hariai', 'zoneCode' => 'HR', 'zoneStatus' => '1'],
            ['zoneId' => '1074', 'countryId' => '68', 'zoneName' => 'Oromia', 'zoneCode' => 'OR', 'zoneStatus' => '1'],
            ['zoneId' => '1075', 'countryId' => '68', 'zoneName' => 'Somali', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '1076', 'countryId' => '68', 'zoneName' => 'Southern Nations - Nationalities and Peoples Region', 'zoneCode' => 'SN', 'zoneStatus' => '1'],
            ['zoneId' => '1077', 'countryId' => '68', 'zoneName' => 'Tigray', 'zoneCode' => 'TG', 'zoneStatus' => '1'],
            ['zoneId' => '1078', 'countryId' => '68', 'zoneName' => 'Addis Ababa', 'zoneCode' => 'AA', 'zoneStatus' => '1'],
            ['zoneId' => '1079', 'countryId' => '68', 'zoneName' => 'Dire Dawa', 'zoneCode' => 'DD', 'zoneStatus' => '1'],
            ['zoneId' => '1080', 'countryId' => '71', 'zoneName' => 'Central Division', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '1081', 'countryId' => '71', 'zoneName' => 'Northern Division', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '1082', 'countryId' => '71', 'zoneName' => 'Eastern Division', 'zoneCode' => 'E', 'zoneStatus' => '1'],
            ['zoneId' => '1083', 'countryId' => '71', 'zoneName' => 'Western Division', 'zoneCode' => 'W', 'zoneStatus' => '1'],
            ['zoneId' => '1084', 'countryId' => '71', 'zoneName' => 'Rotuma', 'zoneCode' => 'R', 'zoneStatus' => '1'],
            ['zoneId' => '1085', 'countryId' => '72', 'zoneName' => 'Ahvenanmaan lääni', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '1086', 'countryId' => '72', 'zoneName' => 'Etelä-Suomen lääni', 'zoneCode' => 'ES', 'zoneStatus' => '1'],
            ['zoneId' => '1087', 'countryId' => '72', 'zoneName' => 'Itä-Suomen lääni', 'zoneCode' => 'IS', 'zoneStatus' => '1'],
            ['zoneId' => '1088', 'countryId' => '72', 'zoneName' => 'Länsi-Suomen lääni', 'zoneCode' => 'LS', 'zoneStatus' => '1'],
            ['zoneId' => '1089', 'countryId' => '72', 'zoneName' => 'Lapin lääni', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '1090', 'countryId' => '72', 'zoneName' => 'Oulun lääni', 'zoneCode' => 'OU', 'zoneStatus' => '1'],
            ['zoneId' => '1114', 'countryId' => '74', 'zoneName' => 'Ain', 'zoneCode' => '01', 'zoneStatus' => '1'],
            ['zoneId' => '1115', 'countryId' => '74', 'zoneName' => 'Aisne', 'zoneCode' => '02', 'zoneStatus' => '1'],
            ['zoneId' => '1116', 'countryId' => '74', 'zoneName' => 'Allier', 'zoneCode' => '03', 'zoneStatus' => '1'],
            ['zoneId' => '1117', 'countryId' => '74', 'zoneName' => 'Alpes de Haute Provence', 'zoneCode' => '04', 'zoneStatus' => '1'],
            ['zoneId' => '1118', 'countryId' => '74', 'zoneName' => 'Hautes-Alpes', 'zoneCode' => '05', 'zoneStatus' => '1'],
            ['zoneId' => '1119', 'countryId' => '74', 'zoneName' => 'Alpes Maritimes', 'zoneCode' => '06', 'zoneStatus' => '1'],
            ['zoneId' => '1120', 'countryId' => '74', 'zoneName' => 'Ard&egrave;che', 'zoneCode' => '07', 'zoneStatus' => '1'],
            ['zoneId' => '1121', 'countryId' => '74', 'zoneName' => 'Ardennes', 'zoneCode' => '08', 'zoneStatus' => '1'],
            ['zoneId' => '1122', 'countryId' => '74', 'zoneName' => 'Ari&egrave;ge', 'zoneCode' => '09', 'zoneStatus' => '1'],
            ['zoneId' => '1123', 'countryId' => '74', 'zoneName' => 'Aube', 'zoneCode' => '10', 'zoneStatus' => '1'],
            ['zoneId' => '1124', 'countryId' => '74', 'zoneName' => 'Aude', 'zoneCode' => '11', 'zoneStatus' => '1'],
            ['zoneId' => '1125', 'countryId' => '74', 'zoneName' => 'Aveyron', 'zoneCode' => '12', 'zoneStatus' => '1'],
            ['zoneId' => '1126', 'countryId' => '74', 'zoneName' => 'Bouches du Rh&ocirc;ne', 'zoneCode' => '13', 'zoneStatus' => '1'],
            ['zoneId' => '1127', 'countryId' => '74', 'zoneName' => 'Calvados', 'zoneCode' => '14', 'zoneStatus' => '1'],
            ['zoneId' => '1128', 'countryId' => '74', 'zoneName' => 'Cantal', 'zoneCode' => '15', 'zoneStatus' => '1'],
            ['zoneId' => '1129', 'countryId' => '74', 'zoneName' => 'Charente', 'zoneCode' => '16', 'zoneStatus' => '1'],
            ['zoneId' => '1130', 'countryId' => '74', 'zoneName' => 'Charente Maritime', 'zoneCode' => '17', 'zoneStatus' => '1'],
            ['zoneId' => '1131', 'countryId' => '74', 'zoneName' => 'Cher', 'zoneCode' => '18', 'zoneStatus' => '1'],
            ['zoneId' => '1132', 'countryId' => '74', 'zoneName' => 'Corr&egrave;ze', 'zoneCode' => '19', 'zoneStatus' => '1'],
            ['zoneId' => '1133', 'countryId' => '74', 'zoneName' => 'Corse du Sud', 'zoneCode' => '2A', 'zoneStatus' => '1'],
            ['zoneId' => '1134', 'countryId' => '74', 'zoneName' => 'Haute Corse', 'zoneCode' => '2B', 'zoneStatus' => '1'],
            ['zoneId' => '1135', 'countryId' => '74', 'zoneName' => 'C&ocirc;te d&#039;or', 'zoneCode' => '21', 'zoneStatus' => '1'],
            ['zoneId' => '1136', 'countryId' => '74', 'zoneName' => 'C&ocirc;tes d&#039;Armor', 'zoneCode' => '22', 'zoneStatus' => '1'],
            ['zoneId' => '1137', 'countryId' => '74', 'zoneName' => 'Creuse', 'zoneCode' => '23', 'zoneStatus' => '1'],
            ['zoneId' => '1138', 'countryId' => '74', 'zoneName' => 'Dordogne', 'zoneCode' => '24', 'zoneStatus' => '1'],
            ['zoneId' => '1139', 'countryId' => '74', 'zoneName' => 'Doubs', 'zoneCode' => '25', 'zoneStatus' => '1'],
            ['zoneId' => '1140', 'countryId' => '74', 'zoneName' => 'Dr&ocirc;me', 'zoneCode' => '26', 'zoneStatus' => '1'],
            ['zoneId' => '1141', 'countryId' => '74', 'zoneName' => 'Eure', 'zoneCode' => '27', 'zoneStatus' => '1'],
            ['zoneId' => '1142', 'countryId' => '74', 'zoneName' => 'Eure et Loir', 'zoneCode' => '28', 'zoneStatus' => '1'],
            ['zoneId' => '1143', 'countryId' => '74', 'zoneName' => 'Finist&egrave;re', 'zoneCode' => '29', 'zoneStatus' => '1'],
            ['zoneId' => '1144', 'countryId' => '74', 'zoneName' => 'Gard', 'zoneCode' => '30', 'zoneStatus' => '1'],
            ['zoneId' => '1145', 'countryId' => '74', 'zoneName' => 'Haute Garonne', 'zoneCode' => '31', 'zoneStatus' => '1'],
            ['zoneId' => '1146', 'countryId' => '74', 'zoneName' => 'Gers', 'zoneCode' => '32', 'zoneStatus' => '1'],
            ['zoneId' => '1147', 'countryId' => '74', 'zoneName' => 'Gironde', 'zoneCode' => '33', 'zoneStatus' => '1'],
            ['zoneId' => '1148', 'countryId' => '74', 'zoneName' => 'H&eacute;rault', 'zoneCode' => '34', 'zoneStatus' => '1'],
            ['zoneId' => '1149', 'countryId' => '74', 'zoneName' => 'Ille et Vilaine', 'zoneCode' => '35', 'zoneStatus' => '1'],
            ['zoneId' => '1150', 'countryId' => '74', 'zoneName' => 'Indre', 'zoneCode' => '36', 'zoneStatus' => '1'],
            ['zoneId' => '1151', 'countryId' => '74', 'zoneName' => 'Indre et Loire', 'zoneCode' => '37', 'zoneStatus' => '1'],
            ['zoneId' => '1152', 'countryId' => '74', 'zoneName' => 'Is&eacute;re', 'zoneCode' => '38', 'zoneStatus' => '1'],
            ['zoneId' => '1153', 'countryId' => '74', 'zoneName' => 'Jura', 'zoneCode' => '39', 'zoneStatus' => '1'],
            ['zoneId' => '1154', 'countryId' => '74', 'zoneName' => 'Landes', 'zoneCode' => '40', 'zoneStatus' => '1'],
            ['zoneId' => '1155', 'countryId' => '74', 'zoneName' => 'Loir et Cher', 'zoneCode' => '41', 'zoneStatus' => '1'],
            ['zoneId' => '1156', 'countryId' => '74', 'zoneName' => 'Loire', 'zoneCode' => '42', 'zoneStatus' => '1'],
            ['zoneId' => '1157', 'countryId' => '74', 'zoneName' => 'Haute Loire', 'zoneCode' => '43', 'zoneStatus' => '1'],
            ['zoneId' => '1158', 'countryId' => '74', 'zoneName' => 'Loire Atlantique', 'zoneCode' => '44', 'zoneStatus' => '1'],
            ['zoneId' => '1159', 'countryId' => '74', 'zoneName' => 'Loiret', 'zoneCode' => '45', 'zoneStatus' => '1'],
            ['zoneId' => '1160', 'countryId' => '74', 'zoneName' => 'Lot', 'zoneCode' => '46', 'zoneStatus' => '1'],
            ['zoneId' => '1161', 'countryId' => '74', 'zoneName' => 'Lot et Garonne', 'zoneCode' => '47', 'zoneStatus' => '1'],
            ['zoneId' => '1162', 'countryId' => '74', 'zoneName' => 'Loz&egrave;re', 'zoneCode' => '48', 'zoneStatus' => '1'],
            ['zoneId' => '1163', 'countryId' => '74', 'zoneName' => 'Maine et Loire', 'zoneCode' => '49', 'zoneStatus' => '1'],
            ['zoneId' => '1164', 'countryId' => '74', 'zoneName' => 'Manche', 'zoneCode' => '50', 'zoneStatus' => '1'],
            ['zoneId' => '1165', 'countryId' => '74', 'zoneName' => 'Marne', 'zoneCode' => '51', 'zoneStatus' => '1'],
            ['zoneId' => '1166', 'countryId' => '74', 'zoneName' => 'Haute Marne', 'zoneCode' => '52', 'zoneStatus' => '1'],
            ['zoneId' => '1167', 'countryId' => '74', 'zoneName' => 'Mayenne', 'zoneCode' => '53', 'zoneStatus' => '1'],
            ['zoneId' => '1168', 'countryId' => '74', 'zoneName' => 'Meurthe et Moselle', 'zoneCode' => '54', 'zoneStatus' => '1'],
            ['zoneId' => '1169', 'countryId' => '74', 'zoneName' => 'Meuse', 'zoneCode' => '55', 'zoneStatus' => '1'],
            ['zoneId' => '1170', 'countryId' => '74', 'zoneName' => 'Morbihan', 'zoneCode' => '56', 'zoneStatus' => '1'],
            ['zoneId' => '1171', 'countryId' => '74', 'zoneName' => 'Moselle', 'zoneCode' => '57', 'zoneStatus' => '1'],
            ['zoneId' => '1172', 'countryId' => '74', 'zoneName' => 'Ni&egrave;vre', 'zoneCode' => '58', 'zoneStatus' => '1'],
            ['zoneId' => '1173', 'countryId' => '74', 'zoneName' => 'Nord', 'zoneCode' => '59', 'zoneStatus' => '1'],
            ['zoneId' => '1174', 'countryId' => '74', 'zoneName' => 'Oise', 'zoneCode' => '60', 'zoneStatus' => '1'],
            ['zoneId' => '1175', 'countryId' => '74', 'zoneName' => 'Orne', 'zoneCode' => '61', 'zoneStatus' => '1'],
            ['zoneId' => '1176', 'countryId' => '74', 'zoneName' => 'Pas de Calais', 'zoneCode' => '62', 'zoneStatus' => '1'],
            ['zoneId' => '1177', 'countryId' => '74', 'zoneName' => 'Puy de D&ocirc;me', 'zoneCode' => '63', 'zoneStatus' => '1'],
            ['zoneId' => '1178', 'countryId' => '74', 'zoneName' => 'Pyr&eacute;n&eacute;es Atlantiques', 'zoneCode' => '64', 'zoneStatus' => '1'],
            ['zoneId' => '1179', 'countryId' => '74', 'zoneName' => 'Hautes Pyr&eacute;n&eacute;es', 'zoneCode' => '65', 'zoneStatus' => '1'],
            ['zoneId' => '1180', 'countryId' => '74', 'zoneName' => 'Pyr&eacute;n&eacute;es Orientales', 'zoneCode' => '66', 'zoneStatus' => '1'],
            ['zoneId' => '1181', 'countryId' => '74', 'zoneName' => 'Bas Rhin', 'zoneCode' => '67', 'zoneStatus' => '1'],
            ['zoneId' => '1182', 'countryId' => '74', 'zoneName' => 'Haut Rhin', 'zoneCode' => '68', 'zoneStatus' => '1'],
            ['zoneId' => '1183', 'countryId' => '74', 'zoneName' => 'Rh&ocirc;ne', 'zoneCode' => '69', 'zoneStatus' => '1'],
            ['zoneId' => '1184', 'countryId' => '74', 'zoneName' => 'Haute Sa&ocirc;ne', 'zoneCode' => '70', 'zoneStatus' => '1'],
            ['zoneId' => '1185', 'countryId' => '74', 'zoneName' => 'Sa&ocirc;ne et Loire', 'zoneCode' => '71', 'zoneStatus' => '1'],
            ['zoneId' => '1186', 'countryId' => '74', 'zoneName' => 'Sarthe', 'zoneCode' => '72', 'zoneStatus' => '1'],
            ['zoneId' => '1187', 'countryId' => '74', 'zoneName' => 'Savoie', 'zoneCode' => '73', 'zoneStatus' => '1'],
            ['zoneId' => '1188', 'countryId' => '74', 'zoneName' => 'Haute Savoie', 'zoneCode' => '74', 'zoneStatus' => '1'],
            ['zoneId' => '1189', 'countryId' => '74', 'zoneName' => 'Paris', 'zoneCode' => '75', 'zoneStatus' => '1'],
            ['zoneId' => '1190', 'countryId' => '74', 'zoneName' => 'Seine Maritime', 'zoneCode' => '76', 'zoneStatus' => '1'],
            ['zoneId' => '1191', 'countryId' => '74', 'zoneName' => 'Seine et Marne', 'zoneCode' => '77', 'zoneStatus' => '1'],
            ['zoneId' => '1192', 'countryId' => '74', 'zoneName' => 'Yvelines', 'zoneCode' => '78', 'zoneStatus' => '1'],
            ['zoneId' => '1193', 'countryId' => '74', 'zoneName' => 'Deux S&egrave;vres', 'zoneCode' => '79', 'zoneStatus' => '1'],
            ['zoneId' => '1194', 'countryId' => '74', 'zoneName' => 'Somme', 'zoneCode' => '80', 'zoneStatus' => '1'],
            ['zoneId' => '1195', 'countryId' => '74', 'zoneName' => 'Tarn', 'zoneCode' => '81', 'zoneStatus' => '1'],
            ['zoneId' => '1196', 'countryId' => '74', 'zoneName' => 'Tarn et Garonne', 'zoneCode' => '82', 'zoneStatus' => '1'],
            ['zoneId' => '1197', 'countryId' => '74', 'zoneName' => 'Var', 'zoneCode' => '83', 'zoneStatus' => '1'],
            ['zoneId' => '1198', 'countryId' => '74', 'zoneName' => 'Vaucluse', 'zoneCode' => '84', 'zoneStatus' => '1'],
            ['zoneId' => '1199', 'countryId' => '74', 'zoneName' => 'Vend&eacute;e', 'zoneCode' => '85', 'zoneStatus' => '1'],
            ['zoneId' => '1200', 'countryId' => '74', 'zoneName' => 'Vienne', 'zoneCode' => '86', 'zoneStatus' => '1'],
            ['zoneId' => '1201', 'countryId' => '74', 'zoneName' => 'Haute Vienne', 'zoneCode' => '87', 'zoneStatus' => '1'],
            ['zoneId' => '1202', 'countryId' => '74', 'zoneName' => 'Vosges', 'zoneCode' => '88', 'zoneStatus' => '1'],
            ['zoneId' => '1203', 'countryId' => '74', 'zoneName' => 'Yonne', 'zoneCode' => '89', 'zoneStatus' => '1'],
            ['zoneId' => '1204', 'countryId' => '74', 'zoneName' => 'Territoire de Belfort', 'zoneCode' => '90', 'zoneStatus' => '1'],
            ['zoneId' => '1205', 'countryId' => '74', 'zoneName' => 'Essonne', 'zoneCode' => '91', 'zoneStatus' => '1'],
            ['zoneId' => '1206', 'countryId' => '74', 'zoneName' => 'Hauts de Seine', 'zoneCode' => '92', 'zoneStatus' => '1'],
            ['zoneId' => '1207', 'countryId' => '74', 'zoneName' => 'Seine St-Denis', 'zoneCode' => '93', 'zoneStatus' => '1'],
            ['zoneId' => '1208', 'countryId' => '74', 'zoneName' => 'Val de Marne', 'zoneCode' => '94', 'zoneStatus' => '1'],
            ['zoneId' => '1209', 'countryId' => '74', 'zoneName' => 'Val d\'Oise', 'zoneCode' => '95', 'zoneStatus' => '1'],
            ['zoneId' => '1210', 'countryId' => '76', 'zoneName' => 'Archipel des Marquises', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '1211', 'countryId' => '76', 'zoneName' => 'Archipel des Tuamotu', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '1212', 'countryId' => '76', 'zoneName' => 'Archipel des Tubuai', 'zoneCode' => 'I', 'zoneStatus' => '1'],
            ['zoneId' => '1213', 'countryId' => '76', 'zoneName' => 'Iles du Vent', 'zoneCode' => 'V', 'zoneStatus' => '1'],
            ['zoneId' => '1214', 'countryId' => '76', 'zoneName' => 'Iles Sous-le-Vent', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '1215', 'countryId' => '77', 'zoneName' => 'Iles Crozet', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '1216', 'countryId' => '77', 'zoneName' => 'Iles Kerguelen', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '1217', 'countryId' => '77', 'zoneName' => 'Ile Amsterdam', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '1218', 'countryId' => '77', 'zoneName' => 'Ile Saint-Paul', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '1219', 'countryId' => '77', 'zoneName' => 'Adelie Land', 'zoneCode' => 'D', 'zoneStatus' => '1'],
            ['zoneId' => '1220', 'countryId' => '78', 'zoneName' => 'Estuaire', 'zoneCode' => 'ES', 'zoneStatus' => '1'],
            ['zoneId' => '1221', 'countryId' => '78', 'zoneName' => 'Haut-Ogooue', 'zoneCode' => 'HO', 'zoneStatus' => '1'],
            ['zoneId' => '1222', 'countryId' => '78', 'zoneName' => 'Moyen-Ogooue', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '1223', 'countryId' => '78', 'zoneName' => 'Ngounie', 'zoneCode' => 'NG', 'zoneStatus' => '1'],
            ['zoneId' => '1224', 'countryId' => '78', 'zoneName' => 'Nyanga', 'zoneCode' => 'NY', 'zoneStatus' => '1'],
            ['zoneId' => '1225', 'countryId' => '78', 'zoneName' => 'Ogooue-Ivindo', 'zoneCode' => 'OI', 'zoneStatus' => '1'],
            ['zoneId' => '1226', 'countryId' => '78', 'zoneName' => 'Ogooue-Lolo', 'zoneCode' => 'OL', 'zoneStatus' => '1'],
            ['zoneId' => '1227', 'countryId' => '78', 'zoneName' => 'Ogooue-Maritime', 'zoneCode' => 'OM', 'zoneStatus' => '1'],
            ['zoneId' => '1228', 'countryId' => '78', 'zoneName' => 'Woleu-Ntem', 'zoneCode' => 'WN', 'zoneStatus' => '1'],
            ['zoneId' => '1229', 'countryId' => '79', 'zoneName' => 'Banjul', 'zoneCode' => 'BJ', 'zoneStatus' => '1'],
            ['zoneId' => '1230', 'countryId' => '79', 'zoneName' => 'Basse', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '1231', 'countryId' => '79', 'zoneName' => 'Brikama', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '1232', 'countryId' => '79', 'zoneName' => 'Janjangbure', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '1233', 'countryId' => '79', 'zoneName' => 'Kanifeng', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '1234', 'countryId' => '79', 'zoneName' => 'Kerewan', 'zoneCode' => 'KE', 'zoneStatus' => '1'],
            ['zoneId' => '1235', 'countryId' => '79', 'zoneName' => 'Kuntaur', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '1236', 'countryId' => '79', 'zoneName' => 'Mansakonko', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1237', 'countryId' => '79', 'zoneName' => 'Lower River', 'zoneCode' => 'LR', 'zoneStatus' => '1'],
            ['zoneId' => '1238', 'countryId' => '79', 'zoneName' => 'Central River', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '1239', 'countryId' => '79', 'zoneName' => 'North Bank', 'zoneCode' => 'NB', 'zoneStatus' => '1'],
            ['zoneId' => '1240', 'countryId' => '79', 'zoneName' => 'Upper River', 'zoneCode' => 'UR', 'zoneStatus' => '1'],
            ['zoneId' => '1241', 'countryId' => '79', 'zoneName' => 'Western', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '1242', 'countryId' => '80', 'zoneName' => 'Abkhazia', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '1243', 'countryId' => '80', 'zoneName' => 'Ajaria', 'zoneCode' => 'AJ', 'zoneStatus' => '1'],
            ['zoneId' => '1244', 'countryId' => '80', 'zoneName' => 'Tbilisi', 'zoneCode' => 'TB', 'zoneStatus' => '1'],
            ['zoneId' => '1245', 'countryId' => '80', 'zoneName' => 'Guria', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '1246', 'countryId' => '80', 'zoneName' => 'Imereti', 'zoneCode' => 'IM', 'zoneStatus' => '1'],
            ['zoneId' => '1247', 'countryId' => '80', 'zoneName' => 'Kakheti', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '1248', 'countryId' => '80', 'zoneName' => 'Kvemo Kartli', 'zoneCode' => 'KK', 'zoneStatus' => '1'],
            ['zoneId' => '1249', 'countryId' => '80', 'zoneName' => 'Mtskheta-Mtianeti', 'zoneCode' => 'MM', 'zoneStatus' => '1'],
            ['zoneId' => '1250', 'countryId' => '80', 'zoneName' => 'Racha Lechkhumi and Kvemo Svanet', 'zoneCode' => 'RL', 'zoneStatus' => '1'],
            ['zoneId' => '1251', 'countryId' => '80', 'zoneName' => 'Samegrelo-Zemo Svaneti', 'zoneCode' => 'SZ', 'zoneStatus' => '1'],
            ['zoneId' => '1252', 'countryId' => '80', 'zoneName' => 'Samtskhe-Javakheti', 'zoneCode' => 'SJ', 'zoneStatus' => '1'],
            ['zoneId' => '1253', 'countryId' => '80', 'zoneName' => 'Shida Kartli', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '1254', 'countryId' => '81', 'zoneName' => 'Baden-Württemberg', 'zoneCode' => 'BAW', 'zoneStatus' => '1'],
            ['zoneId' => '1255', 'countryId' => '81', 'zoneName' => 'Bayern', 'zoneCode' => 'BAY', 'zoneStatus' => '1'],
            ['zoneId' => '1256', 'countryId' => '81', 'zoneName' => 'Berlin', 'zoneCode' => 'BER', 'zoneStatus' => '1'],
            ['zoneId' => '1257', 'countryId' => '81', 'zoneName' => 'Brandenburg', 'zoneCode' => 'BRG', 'zoneStatus' => '1'],
            ['zoneId' => '1258', 'countryId' => '81', 'zoneName' => 'Bremen', 'zoneCode' => 'BRE', 'zoneStatus' => '1'],
            ['zoneId' => '1259', 'countryId' => '81', 'zoneName' => 'Hamburg', 'zoneCode' => 'HAM', 'zoneStatus' => '1'],
            ['zoneId' => '1260', 'countryId' => '81', 'zoneName' => 'Hessen', 'zoneCode' => 'HES', 'zoneStatus' => '1'],
            ['zoneId' => '1261', 'countryId' => '81', 'zoneName' => 'Mecklenburg-Vorpommern', 'zoneCode' => 'MEC', 'zoneStatus' => '1'],
            ['zoneId' => '1262', 'countryId' => '81', 'zoneName' => 'Niedersachsen', 'zoneCode' => 'NDS', 'zoneStatus' => '1'],
            ['zoneId' => '1263', 'countryId' => '81', 'zoneName' => 'Nordrhein-Westfalen', 'zoneCode' => 'NRW', 'zoneStatus' => '1'],
            ['zoneId' => '1264', 'countryId' => '81', 'zoneName' => 'Rheinland-Pfalz', 'zoneCode' => 'RHE', 'zoneStatus' => '1'],
            ['zoneId' => '1265', 'countryId' => '81', 'zoneName' => 'Saarland', 'zoneCode' => 'SAR', 'zoneStatus' => '1'],
            ['zoneId' => '1266', 'countryId' => '81', 'zoneName' => 'Sachsen', 'zoneCode' => 'SAS', 'zoneStatus' => '1'],
            ['zoneId' => '1267', 'countryId' => '81', 'zoneName' => 'Sachsen-Anhalt', 'zoneCode' => 'SAC', 'zoneStatus' => '1'],
            ['zoneId' => '1268', 'countryId' => '81', 'zoneName' => 'Schleswig-Holstein', 'zoneCode' => 'SCN', 'zoneStatus' => '1'],
            ['zoneId' => '1269', 'countryId' => '81', 'zoneName' => 'Thüringen', 'zoneCode' => 'THE', 'zoneStatus' => '1'],
            ['zoneId' => '1270', 'countryId' => '82', 'zoneName' => 'Ashanti Region', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '1271', 'countryId' => '82', 'zoneName' => 'Brong-Ahafo Region', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '1272', 'countryId' => '82', 'zoneName' => 'Central Region', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '1273', 'countryId' => '82', 'zoneName' => 'Eastern Region', 'zoneCode' => 'EA', 'zoneStatus' => '1'],
            ['zoneId' => '1274', 'countryId' => '82', 'zoneName' => 'Greater Accra Region', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '1275', 'countryId' => '82', 'zoneName' => 'Northern Region', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '1276', 'countryId' => '82', 'zoneName' => 'Upper East Region', 'zoneCode' => 'UE', 'zoneStatus' => '1'],
            ['zoneId' => '1277', 'countryId' => '82', 'zoneName' => 'Upper West Region', 'zoneCode' => 'UW', 'zoneStatus' => '1'],
            ['zoneId' => '1278', 'countryId' => '82', 'zoneName' => 'Volta Region', 'zoneCode' => 'VO', 'zoneStatus' => '1'],
            ['zoneId' => '1279', 'countryId' => '82', 'zoneName' => 'Western Region', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '1280', 'countryId' => '84', 'zoneName' => 'Attica', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '1281', 'countryId' => '84', 'zoneName' => 'Central Greece', 'zoneCode' => 'CN', 'zoneStatus' => '1'],
            ['zoneId' => '1282', 'countryId' => '84', 'zoneName' => 'Central Macedonia', 'zoneCode' => 'CM', 'zoneStatus' => '1'],
            ['zoneId' => '1283', 'countryId' => '84', 'zoneName' => 'Crete', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '1284', 'countryId' => '84', 'zoneName' => 'East Macedonia and Thrace', 'zoneCode' => 'EM', 'zoneStatus' => '1'],
            ['zoneId' => '1285', 'countryId' => '84', 'zoneName' => 'Epirus', 'zoneCode' => 'EP', 'zoneStatus' => '1'],
            ['zoneId' => '1286', 'countryId' => '84', 'zoneName' => 'Ionian Islands', 'zoneCode' => 'II', 'zoneStatus' => '1'],
            ['zoneId' => '1287', 'countryId' => '84', 'zoneName' => 'North Aegean', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '1288', 'countryId' => '84', 'zoneName' => 'Peloponnesos', 'zoneCode' => 'PP', 'zoneStatus' => '1'],
            ['zoneId' => '1289', 'countryId' => '84', 'zoneName' => 'South Aegean', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '1290', 'countryId' => '84', 'zoneName' => 'Thessaly', 'zoneCode' => 'TH', 'zoneStatus' => '1'],
            ['zoneId' => '1291', 'countryId' => '84', 'zoneName' => 'West Greece', 'zoneCode' => 'WG', 'zoneStatus' => '1'],
            ['zoneId' => '1292', 'countryId' => '84', 'zoneName' => 'West Macedonia', 'zoneCode' => 'WM', 'zoneStatus' => '1'],
            ['zoneId' => '1293', 'countryId' => '85', 'zoneName' => 'Avannaa', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '1294', 'countryId' => '85', 'zoneName' => 'Tunu', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '1295', 'countryId' => '85', 'zoneName' => 'Kitaa', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '1296', 'countryId' => '86', 'zoneName' => 'Saint Andrew', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '1297', 'countryId' => '86', 'zoneName' => 'Saint David', 'zoneCode' => 'D', 'zoneStatus' => '1'],
            ['zoneId' => '1298', 'countryId' => '86', 'zoneName' => 'Saint George', 'zoneCode' => 'G', 'zoneStatus' => '1'],
            ['zoneId' => '1299', 'countryId' => '86', 'zoneName' => 'Saint John', 'zoneCode' => 'J', 'zoneStatus' => '1'],
            ['zoneId' => '1300', 'countryId' => '86', 'zoneName' => 'Saint Mark', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '1301', 'countryId' => '86', 'zoneName' => 'Saint Patrick', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '1302', 'countryId' => '86', 'zoneName' => 'Carriacou', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '1303', 'countryId' => '86', 'zoneName' => 'Petit Martinique', 'zoneCode' => 'Q', 'zoneStatus' => '1'],
            ['zoneId' => '1304', 'countryId' => '89', 'zoneName' => 'Alta Verapaz', 'zoneCode' => 'AV', 'zoneStatus' => '1'],
            ['zoneId' => '1305', 'countryId' => '89', 'zoneName' => 'Baja Verapaz', 'zoneCode' => 'BV', 'zoneStatus' => '1'],
            ['zoneId' => '1306', 'countryId' => '89', 'zoneName' => 'Chimaltenango', 'zoneCode' => 'CM', 'zoneStatus' => '1'],
            ['zoneId' => '1307', 'countryId' => '89', 'zoneName' => 'Chiquimula', 'zoneCode' => 'CQ', 'zoneStatus' => '1'],
            ['zoneId' => '1308', 'countryId' => '89', 'zoneName' => 'El Peten', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '1309', 'countryId' => '89', 'zoneName' => 'El Progreso', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '1310', 'countryId' => '89', 'zoneName' => 'El Quiche', 'zoneCode' => 'QC', 'zoneStatus' => '1'],
            ['zoneId' => '1311', 'countryId' => '89', 'zoneName' => 'Escuintla', 'zoneCode' => 'ES', 'zoneStatus' => '1'],
            ['zoneId' => '1312', 'countryId' => '89', 'zoneName' => 'Guatemala', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '1313', 'countryId' => '89', 'zoneName' => 'Huehuetenango', 'zoneCode' => 'HU', 'zoneStatus' => '1'],
            ['zoneId' => '1314', 'countryId' => '89', 'zoneName' => 'Izabal', 'zoneCode' => 'IZ', 'zoneStatus' => '1'],
            ['zoneId' => '1315', 'countryId' => '89', 'zoneName' => 'Jalapa', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '1316', 'countryId' => '89', 'zoneName' => 'Jutiapa', 'zoneCode' => 'JU', 'zoneStatus' => '1'],
            ['zoneId' => '1317', 'countryId' => '89', 'zoneName' => 'Quetzaltenango', 'zoneCode' => 'QZ', 'zoneStatus' => '1'],
            ['zoneId' => '1318', 'countryId' => '89', 'zoneName' => 'Retalhuleu', 'zoneCode' => 'RE', 'zoneStatus' => '1'],
            ['zoneId' => '1319', 'countryId' => '89', 'zoneName' => 'Sacatepequez', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '1320', 'countryId' => '89', 'zoneName' => 'San Marcos', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '1321', 'countryId' => '89', 'zoneName' => 'Santa Rosa', 'zoneCode' => 'SR', 'zoneStatus' => '1'],
            ['zoneId' => '1322', 'countryId' => '89', 'zoneName' => 'Solola', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '1323', 'countryId' => '89', 'zoneName' => 'Suchitepequez', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '1324', 'countryId' => '89', 'zoneName' => 'Totonicapan', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '1325', 'countryId' => '89', 'zoneName' => 'Zacapa', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '1326', 'countryId' => '90', 'zoneName' => 'Conakry', 'zoneCode' => 'CNK', 'zoneStatus' => '1'],
            ['zoneId' => '1327', 'countryId' => '90', 'zoneName' => 'Beyla', 'zoneCode' => 'BYL', 'zoneStatus' => '1'],
            ['zoneId' => '1328', 'countryId' => '90', 'zoneName' => 'Boffa', 'zoneCode' => 'BFA', 'zoneStatus' => '1'],
            ['zoneId' => '1329', 'countryId' => '90', 'zoneName' => 'Boke', 'zoneCode' => 'BOK', 'zoneStatus' => '1'],
            ['zoneId' => '1330', 'countryId' => '90', 'zoneName' => 'Coyah', 'zoneCode' => 'COY', 'zoneStatus' => '1'],
            ['zoneId' => '1331', 'countryId' => '90', 'zoneName' => 'Dabola', 'zoneCode' => 'DBL', 'zoneStatus' => '1'],
            ['zoneId' => '1332', 'countryId' => '90', 'zoneName' => 'Dalaba', 'zoneCode' => 'DLB', 'zoneStatus' => '1'],
            ['zoneId' => '1333', 'countryId' => '90', 'zoneName' => 'Dinguiraye', 'zoneCode' => 'DGR', 'zoneStatus' => '1'],
            ['zoneId' => '1334', 'countryId' => '90', 'zoneName' => 'Dubreka', 'zoneCode' => 'DBR', 'zoneStatus' => '1'],
            ['zoneId' => '1335', 'countryId' => '90', 'zoneName' => 'Faranah', 'zoneCode' => 'FRN', 'zoneStatus' => '1'],
            ['zoneId' => '1336', 'countryId' => '90', 'zoneName' => 'Forecariah', 'zoneCode' => 'FRC', 'zoneStatus' => '1'],
            ['zoneId' => '1337', 'countryId' => '90', 'zoneName' => 'Fria', 'zoneCode' => 'FRI', 'zoneStatus' => '1'],
            ['zoneId' => '1338', 'countryId' => '90', 'zoneName' => 'Gaoual', 'zoneCode' => 'GAO', 'zoneStatus' => '1'],
            ['zoneId' => '1339', 'countryId' => '90', 'zoneName' => 'Gueckedou', 'zoneCode' => 'GCD', 'zoneStatus' => '1'],
            ['zoneId' => '1340', 'countryId' => '90', 'zoneName' => 'Kankan', 'zoneCode' => 'KNK', 'zoneStatus' => '1'],
            ['zoneId' => '1341', 'countryId' => '90', 'zoneName' => 'Kerouane', 'zoneCode' => 'KRN', 'zoneStatus' => '1'],
            ['zoneId' => '1342', 'countryId' => '90', 'zoneName' => 'Kindia', 'zoneCode' => 'KND', 'zoneStatus' => '1'],
            ['zoneId' => '1343', 'countryId' => '90', 'zoneName' => 'Kissidougou', 'zoneCode' => 'KSD', 'zoneStatus' => '1'],
            ['zoneId' => '1344', 'countryId' => '90', 'zoneName' => 'Koubia', 'zoneCode' => 'KBA', 'zoneStatus' => '1'],
            ['zoneId' => '1345', 'countryId' => '90', 'zoneName' => 'Koundara', 'zoneCode' => 'KDA', 'zoneStatus' => '1'],
            ['zoneId' => '1346', 'countryId' => '90', 'zoneName' => 'Kouroussa', 'zoneCode' => 'KRA', 'zoneStatus' => '1'],
            ['zoneId' => '1347', 'countryId' => '90', 'zoneName' => 'Labe', 'zoneCode' => 'LAB', 'zoneStatus' => '1'],
            ['zoneId' => '1348', 'countryId' => '90', 'zoneName' => 'Lelouma', 'zoneCode' => 'LLM', 'zoneStatus' => '1'],
            ['zoneId' => '1349', 'countryId' => '90', 'zoneName' => 'Lola', 'zoneCode' => 'LOL', 'zoneStatus' => '1'],
            ['zoneId' => '1350', 'countryId' => '90', 'zoneName' => 'Macenta', 'zoneCode' => 'MCT', 'zoneStatus' => '1'],
            ['zoneId' => '1351', 'countryId' => '90', 'zoneName' => 'Mali', 'zoneCode' => 'MAL', 'zoneStatus' => '1'],
            ['zoneId' => '1352', 'countryId' => '90', 'zoneName' => 'Mamou', 'zoneCode' => 'MAM', 'zoneStatus' => '1'],
            ['zoneId' => '1353', 'countryId' => '90', 'zoneName' => 'Mandiana', 'zoneCode' => 'MAN', 'zoneStatus' => '1'],
            ['zoneId' => '1354', 'countryId' => '90', 'zoneName' => 'Nzerekore', 'zoneCode' => 'NZR', 'zoneStatus' => '1'],
            ['zoneId' => '1355', 'countryId' => '90', 'zoneName' => 'Pita', 'zoneCode' => 'PIT', 'zoneStatus' => '1'],
            ['zoneId' => '1356', 'countryId' => '90', 'zoneName' => 'Siguiri', 'zoneCode' => 'SIG', 'zoneStatus' => '1'],
            ['zoneId' => '1357', 'countryId' => '90', 'zoneName' => 'Telimele', 'zoneCode' => 'TLM', 'zoneStatus' => '1'],
            ['zoneId' => '1358', 'countryId' => '90', 'zoneName' => 'Tougue', 'zoneCode' => 'TOG', 'zoneStatus' => '1'],
            ['zoneId' => '1359', 'countryId' => '90', 'zoneName' => 'Yomou', 'zoneCode' => 'YOM', 'zoneStatus' => '1'],
            ['zoneId' => '1360', 'countryId' => '91', 'zoneName' => 'Bafata Region', 'zoneCode' => 'BF', 'zoneStatus' => '1'],
            ['zoneId' => '1361', 'countryId' => '91', 'zoneName' => 'Biombo Region', 'zoneCode' => 'BB', 'zoneStatus' => '1'],
            ['zoneId' => '1362', 'countryId' => '91', 'zoneName' => 'Bissau Region', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '1363', 'countryId' => '91', 'zoneName' => 'Bolama Region', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '1364', 'countryId' => '91', 'zoneName' => 'Cacheu Region', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '1365', 'countryId' => '91', 'zoneName' => 'Gabu Region', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '1366', 'countryId' => '91', 'zoneName' => 'Oio Region', 'zoneCode' => 'OI', 'zoneStatus' => '1'],
            ['zoneId' => '1367', 'countryId' => '91', 'zoneName' => 'Quinara Region', 'zoneCode' => 'QU', 'zoneStatus' => '1'],
            ['zoneId' => '1368', 'countryId' => '91', 'zoneName' => 'Tombali Region', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '1369', 'countryId' => '92', 'zoneName' => 'Barima-Waini', 'zoneCode' => 'BW', 'zoneStatus' => '1'],
            ['zoneId' => '1370', 'countryId' => '92', 'zoneName' => 'Cuyuni-Mazaruni', 'zoneCode' => 'CM', 'zoneStatus' => '1'],
            ['zoneId' => '1371', 'countryId' => '92', 'zoneName' => 'Demerara-Mahaica', 'zoneCode' => 'DM', 'zoneStatus' => '1'],
            ['zoneId' => '1372', 'countryId' => '92', 'zoneName' => 'East Berbice-Corentyne', 'zoneCode' => 'EC', 'zoneStatus' => '1'],
            ['zoneId' => '1373', 'countryId' => '92', 'zoneName' => 'Essequibo Islands-West Demerara', 'zoneCode' => 'EW', 'zoneStatus' => '1'],
            ['zoneId' => '1374', 'countryId' => '92', 'zoneName' => 'Mahaica-Berbice', 'zoneCode' => 'MB', 'zoneStatus' => '1'],
            ['zoneId' => '1375', 'countryId' => '92', 'zoneName' => 'Pomeroon-Supenaam', 'zoneCode' => 'PM', 'zoneStatus' => '1'],
            ['zoneId' => '1376', 'countryId' => '92', 'zoneName' => 'Potaro-Siparuni', 'zoneCode' => 'PI', 'zoneStatus' => '1'],
            ['zoneId' => '1377', 'countryId' => '92', 'zoneName' => 'Upper Demerara-Berbice', 'zoneCode' => 'UD', 'zoneStatus' => '1'],
            ['zoneId' => '1378', 'countryId' => '92', 'zoneName' => 'Upper Takutu-Upper Essequibo', 'zoneCode' => 'UT', 'zoneStatus' => '1'],
            ['zoneId' => '1379', 'countryId' => '93', 'zoneName' => 'Artibonite', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '1380', 'countryId' => '93', 'zoneName' => 'Centre', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '1381', 'countryId' => '93', 'zoneName' => 'Grand\'Anse', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '1382', 'countryId' => '93', 'zoneName' => 'Nord', 'zoneCode' => 'ND', 'zoneStatus' => '1'],
            ['zoneId' => '1383', 'countryId' => '93', 'zoneName' => 'Nord-Est', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '1384', 'countryId' => '93', 'zoneName' => 'Nord-Ouest', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '1385', 'countryId' => '93', 'zoneName' => 'Ouest', 'zoneCode' => 'OU', 'zoneStatus' => '1'],
            ['zoneId' => '1386', 'countryId' => '93', 'zoneName' => 'Sud', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '1387', 'countryId' => '93', 'zoneName' => 'Sud-Est', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '1388', 'countryId' => '94', 'zoneName' => 'Flat Island', 'zoneCode' => 'F', 'zoneStatus' => '1'],
            ['zoneId' => '1389', 'countryId' => '94', 'zoneName' => 'McDonald Island', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '1390', 'countryId' => '94', 'zoneName' => 'Shag Island', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '1391', 'countryId' => '94', 'zoneName' => 'Heard Island', 'zoneCode' => 'H', 'zoneStatus' => '1'],
            ['zoneId' => '1392', 'countryId' => '95', 'zoneName' => 'Atlantida', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '1393', 'countryId' => '95', 'zoneName' => 'Choluteca', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '1394', 'countryId' => '95', 'zoneName' => 'Colon', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '1395', 'countryId' => '95', 'zoneName' => 'Comayagua', 'zoneCode' => 'CM', 'zoneStatus' => '1'],
            ['zoneId' => '1396', 'countryId' => '95', 'zoneName' => 'Copan', 'zoneCode' => 'CP', 'zoneStatus' => '1'],
            ['zoneId' => '1397', 'countryId' => '95', 'zoneName' => 'Cortes', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '1398', 'countryId' => '95', 'zoneName' => 'El Paraiso', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '1399', 'countryId' => '95', 'zoneName' => 'Francisco Morazan', 'zoneCode' => 'FM', 'zoneStatus' => '1'],
            ['zoneId' => '1400', 'countryId' => '95', 'zoneName' => 'Gracias a Dios', 'zoneCode' => 'GD', 'zoneStatus' => '1'],
            ['zoneId' => '1401', 'countryId' => '95', 'zoneName' => 'Intibuca', 'zoneCode' => 'IN', 'zoneStatus' => '1'],
            ['zoneId' => '1402', 'countryId' => '95', 'zoneName' => 'Islas de la Bahia (Bay Islands)', 'zoneCode' => 'IB', 'zoneStatus' => '1'],
            ['zoneId' => '1403', 'countryId' => '95', 'zoneName' => 'La Paz', 'zoneCode' => 'PZ', 'zoneStatus' => '1'],
            ['zoneId' => '1404', 'countryId' => '95', 'zoneName' => 'Lempira', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '1405', 'countryId' => '95', 'zoneName' => 'Ocotepeque', 'zoneCode' => 'OC', 'zoneStatus' => '1'],
            ['zoneId' => '1406', 'countryId' => '95', 'zoneName' => 'Olancho', 'zoneCode' => 'OL', 'zoneStatus' => '1'],
            ['zoneId' => '1407', 'countryId' => '95', 'zoneName' => 'Santa Barbara', 'zoneCode' => 'SB', 'zoneStatus' => '1'],
            ['zoneId' => '1408', 'countryId' => '95', 'zoneName' => 'Valle', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '1409', 'countryId' => '95', 'zoneName' => 'Yoro', 'zoneCode' => 'YO', 'zoneStatus' => '1'],
            ['zoneId' => '1410', 'countryId' => '96', 'zoneName' => 'Central and Western Hong Kong Island', 'zoneCode' => 'HCW', 'zoneStatus' => '1'],
            ['zoneId' => '1411', 'countryId' => '96', 'zoneName' => 'Eastern Hong Kong Island', 'zoneCode' => 'HEA', 'zoneStatus' => '1'],
            ['zoneId' => '1412', 'countryId' => '96', 'zoneName' => 'Southern Hong Kong Island', 'zoneCode' => 'HSO', 'zoneStatus' => '1'],
            ['zoneId' => '1413', 'countryId' => '96', 'zoneName' => 'Wan Chai Hong Kong Island', 'zoneCode' => 'HWC', 'zoneStatus' => '1'],
            ['zoneId' => '1414', 'countryId' => '96', 'zoneName' => 'Kowloon City Kowloon', 'zoneCode' => 'KKC', 'zoneStatus' => '1'],
            ['zoneId' => '1415', 'countryId' => '96', 'zoneName' => 'Kwun Tong Kowloon', 'zoneCode' => 'KKT', 'zoneStatus' => '1'],
            ['zoneId' => '1416', 'countryId' => '96', 'zoneName' => 'Sham Shui Po Kowloon', 'zoneCode' => 'KSS', 'zoneStatus' => '1'],
            ['zoneId' => '1417', 'countryId' => '96', 'zoneName' => 'Wong Tai Sin Kowloon', 'zoneCode' => 'KWT', 'zoneStatus' => '1'],
            ['zoneId' => '1418', 'countryId' => '96', 'zoneName' => 'Yau Tsim Mong Kowloon', 'zoneCode' => 'KYT', 'zoneStatus' => '1'],
            ['zoneId' => '1419', 'countryId' => '96', 'zoneName' => 'Islands New Territories', 'zoneCode' => 'NIS', 'zoneStatus' => '1'],
            ['zoneId' => '1420', 'countryId' => '96', 'zoneName' => 'Kwai Tsing New Territories', 'zoneCode' => 'NKT', 'zoneStatus' => '1'],
            ['zoneId' => '1421', 'countryId' => '96', 'zoneName' => 'North New Territories', 'zoneCode' => 'NNO', 'zoneStatus' => '1'],
            ['zoneId' => '1422', 'countryId' => '96', 'zoneName' => 'Sai Kung New Territories', 'zoneCode' => 'NSK', 'zoneStatus' => '1'],
            ['zoneId' => '1423', 'countryId' => '96', 'zoneName' => 'Sha Tin New Territories', 'zoneCode' => 'NST', 'zoneStatus' => '1'],
            ['zoneId' => '1424', 'countryId' => '96', 'zoneName' => 'Tai Po New Territories', 'zoneCode' => 'NTP', 'zoneStatus' => '1'],
            ['zoneId' => '1425', 'countryId' => '96', 'zoneName' => 'Tsuen Wan New Territories', 'zoneCode' => 'NTW', 'zoneStatus' => '1'],
            ['zoneId' => '1426', 'countryId' => '96', 'zoneName' => 'Tuen Mun New Territories', 'zoneCode' => 'NTM', 'zoneStatus' => '1'],
            ['zoneId' => '1427', 'countryId' => '96', 'zoneName' => 'Yuen Long New Territories', 'zoneCode' => 'NYL', 'zoneStatus' => '1'],
            ['zoneId' => '1467', 'countryId' => '98', 'zoneName' => 'Austurland', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '1468', 'countryId' => '98', 'zoneName' => 'Hofuoborgarsvaeoi', 'zoneCode' => 'HF', 'zoneStatus' => '1'],
            ['zoneId' => '1469', 'countryId' => '98', 'zoneName' => 'Norourland eystra', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '1470', 'countryId' => '98', 'zoneName' => 'Norourland vestra', 'zoneCode' => 'NV', 'zoneStatus' => '1'],
            ['zoneId' => '1471', 'countryId' => '98', 'zoneName' => 'Suourland', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '1472', 'countryId' => '98', 'zoneName' => 'Suournes', 'zoneCode' => 'SN', 'zoneStatus' => '1'],
            ['zoneId' => '1473', 'countryId' => '98', 'zoneName' => 'Vestfiroir', 'zoneCode' => 'VF', 'zoneStatus' => '1'],
            ['zoneId' => '1474', 'countryId' => '98', 'zoneName' => 'Vesturland', 'zoneCode' => 'VL', 'zoneStatus' => '1'],
            ['zoneId' => '1475', 'countryId' => '99', 'zoneName' => 'Andaman and Nicobar Islands', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '1476', 'countryId' => '99', 'zoneName' => 'Andhra Pradesh', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '1477', 'countryId' => '99', 'zoneName' => 'Arunachal Pradesh', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '1478', 'countryId' => '99', 'zoneName' => 'Assam', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '1479', 'countryId' => '99', 'zoneName' => 'Bihar', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '1480', 'countryId' => '99', 'zoneName' => 'Chandigarh', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '1481', 'countryId' => '99', 'zoneName' => 'Dadra and Nagar Haveli', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '1482', 'countryId' => '99', 'zoneName' => 'Daman and Diu', 'zoneCode' => 'DM', 'zoneStatus' => '1'],
            ['zoneId' => '1483', 'countryId' => '99', 'zoneName' => 'Delhi', 'zoneCode' => 'DE', 'zoneStatus' => '1'],
            ['zoneId' => '1484', 'countryId' => '99', 'zoneName' => 'Goa', 'zoneCode' => 'GO', 'zoneStatus' => '1'],
            ['zoneId' => '1485', 'countryId' => '99', 'zoneName' => 'Gujarat', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '1486', 'countryId' => '99', 'zoneName' => 'Haryana', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '1487', 'countryId' => '99', 'zoneName' => 'Himachal Pradesh', 'zoneCode' => 'HP', 'zoneStatus' => '1'],
            ['zoneId' => '1488', 'countryId' => '99', 'zoneName' => 'Jammu and Kashmir', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '1489', 'countryId' => '99', 'zoneName' => 'Karnataka', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '1490', 'countryId' => '99', 'zoneName' => 'Kerala', 'zoneCode' => 'KE', 'zoneStatus' => '1'],
            ['zoneId' => '1491', 'countryId' => '99', 'zoneName' => 'Lakshadweep Islands', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '1492', 'countryId' => '99', 'zoneName' => 'Madhya Pradesh', 'zoneCode' => 'MP', 'zoneStatus' => '1'],
            ['zoneId' => '1493', 'countryId' => '99', 'zoneName' => 'Maharashtra', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1494', 'countryId' => '99', 'zoneName' => 'Manipur', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '1495', 'countryId' => '99', 'zoneName' => 'Meghalaya', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '1496', 'countryId' => '99', 'zoneName' => 'Mizoram', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '1497', 'countryId' => '99', 'zoneName' => 'Nagaland', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '1498', 'countryId' => '99', 'zoneName' => 'Orissa', 'zoneCode' => 'OR', 'zoneStatus' => '1'],
            ['zoneId' => '1499', 'countryId' => '99', 'zoneName' => 'Puducherry', 'zoneCode' => 'PO', 'zoneStatus' => '1'],
            ['zoneId' => '1500', 'countryId' => '99', 'zoneName' => 'Punjab', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '1501', 'countryId' => '99', 'zoneName' => 'Rajasthan', 'zoneCode' => 'RA', 'zoneStatus' => '1'],
            ['zoneId' => '1502', 'countryId' => '99', 'zoneName' => 'Sikkim', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '1503', 'countryId' => '99', 'zoneName' => 'Tamil Nadu', 'zoneCode' => 'TN', 'zoneStatus' => '1'],
            ['zoneId' => '1504', 'countryId' => '99', 'zoneName' => 'Tripura', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '1505', 'countryId' => '99', 'zoneName' => 'Uttar Pradesh', 'zoneCode' => 'UP', 'zoneStatus' => '1'],
            ['zoneId' => '1506', 'countryId' => '99', 'zoneName' => 'West Bengal', 'zoneCode' => 'WB', 'zoneStatus' => '1'],
            ['zoneId' => '1507', 'countryId' => '100', 'zoneName' => 'Aceh', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '1508', 'countryId' => '100', 'zoneName' => 'Bali', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '1509', 'countryId' => '100', 'zoneName' => 'Banten', 'zoneCode' => 'BT', 'zoneStatus' => '1'],
            ['zoneId' => '1510', 'countryId' => '100', 'zoneName' => 'Bengkulu', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '1511', 'countryId' => '100', 'zoneName' => 'Kalimantan Utara', 'zoneCode' => 'BD', 'zoneStatus' => '1'],
            ['zoneId' => '1512', 'countryId' => '100', 'zoneName' => 'Gorontalo', 'zoneCode' => 'GO', 'zoneStatus' => '1'],
            ['zoneId' => '1513', 'countryId' => '100', 'zoneName' => 'Jakarta', 'zoneCode' => 'JK', 'zoneStatus' => '1'],
            ['zoneId' => '1514', 'countryId' => '100', 'zoneName' => 'Jambi', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '1515', 'countryId' => '100', 'zoneName' => 'Jawa Barat', 'zoneCode' => 'JB', 'zoneStatus' => '1'],
            ['zoneId' => '1516', 'countryId' => '100', 'zoneName' => 'Jawa Tengah', 'zoneCode' => 'JT', 'zoneStatus' => '1'],
            ['zoneId' => '1517', 'countryId' => '100', 'zoneName' => 'Jawa Timur', 'zoneCode' => 'JI', 'zoneStatus' => '1'],
            ['zoneId' => '1518', 'countryId' => '100', 'zoneName' => 'Kalimantan Barat', 'zoneCode' => 'KB', 'zoneStatus' => '1'],
            ['zoneId' => '1519', 'countryId' => '100', 'zoneName' => 'Kalimantan Selatan', 'zoneCode' => 'KS', 'zoneStatus' => '1'],
            ['zoneId' => '1520', 'countryId' => '100', 'zoneName' => 'Kalimantan Tengah', 'zoneCode' => 'KT', 'zoneStatus' => '1'],
            ['zoneId' => '1521', 'countryId' => '100', 'zoneName' => 'Kalimantan Timur', 'zoneCode' => 'KI', 'zoneStatus' => '1'],
            ['zoneId' => '1522', 'countryId' => '100', 'zoneName' => 'Kepulauan Bangka Belitung', 'zoneCode' => 'BB', 'zoneStatus' => '1'],
            ['zoneId' => '1523', 'countryId' => '100', 'zoneName' => 'Lampung', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '1524', 'countryId' => '100', 'zoneName' => 'Maluku', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1525', 'countryId' => '100', 'zoneName' => 'Maluku Utara', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '1526', 'countryId' => '100', 'zoneName' => 'Nusa Tenggara Barat', 'zoneCode' => 'NB', 'zoneStatus' => '1'],
            ['zoneId' => '1527', 'countryId' => '100', 'zoneName' => 'Nusa Tenggara Timur', 'zoneCode' => 'NT', 'zoneStatus' => '1'],
            ['zoneId' => '1528', 'countryId' => '100', 'zoneName' => 'Papua', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '1529', 'countryId' => '100', 'zoneName' => 'Riau', 'zoneCode' => 'RI', 'zoneStatus' => '1'],
            ['zoneId' => '1530', 'countryId' => '100', 'zoneName' => 'Sulawesi Selatan', 'zoneCode' => 'SN', 'zoneStatus' => '1'],
            ['zoneId' => '1531', 'countryId' => '100', 'zoneName' => 'Sulawesi Tengah', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '1532', 'countryId' => '100', 'zoneName' => 'Sulawesi Tenggara', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '1533', 'countryId' => '100', 'zoneName' => 'Sulawesi Utara', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '1534', 'countryId' => '100', 'zoneName' => 'Sumatera Barat', 'zoneCode' => 'SB', 'zoneStatus' => '1'],
            ['zoneId' => '1535', 'countryId' => '100', 'zoneName' => 'Sumatera Selatan', 'zoneCode' => 'SS', 'zoneStatus' => '1'],
            ['zoneId' => '1536', 'countryId' => '100', 'zoneName' => 'Sumatera Utara', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '1537', 'countryId' => '100', 'zoneName' => 'Yogyakarta', 'zoneCode' => 'YO', 'zoneStatus' => '1'],
            ['zoneId' => '1538', 'countryId' => '101', 'zoneName' => 'Tehran', 'zoneCode' => 'TEH', 'zoneStatus' => '1'],
            ['zoneId' => '1539', 'countryId' => '101', 'zoneName' => 'Qom', 'zoneCode' => 'QOM', 'zoneStatus' => '1'],
            ['zoneId' => '1540', 'countryId' => '101', 'zoneName' => 'Markazi', 'zoneCode' => 'MKZ', 'zoneStatus' => '1'],
            ['zoneId' => '1541', 'countryId' => '101', 'zoneName' => 'Qazvin', 'zoneCode' => 'QAZ', 'zoneStatus' => '1'],
            ['zoneId' => '1542', 'countryId' => '101', 'zoneName' => 'Gilan', 'zoneCode' => 'GIL', 'zoneStatus' => '1'],
            ['zoneId' => '1543', 'countryId' => '101', 'zoneName' => 'Ardabil', 'zoneCode' => 'ARD', 'zoneStatus' => '1'],
            ['zoneId' => '1544', 'countryId' => '101', 'zoneName' => 'Zanjan', 'zoneCode' => 'ZAN', 'zoneStatus' => '1'],
            ['zoneId' => '1545', 'countryId' => '101', 'zoneName' => 'East Azarbaijan', 'zoneCode' => 'EAZ', 'zoneStatus' => '1'],
            ['zoneId' => '1546', 'countryId' => '101', 'zoneName' => 'West Azarbaijan', 'zoneCode' => 'WEZ', 'zoneStatus' => '1'],
            ['zoneId' => '1547', 'countryId' => '101', 'zoneName' => 'Kurdistan', 'zoneCode' => 'KRD', 'zoneStatus' => '1'],
            ['zoneId' => '1548', 'countryId' => '101', 'zoneName' => 'Hamadan', 'zoneCode' => 'HMD', 'zoneStatus' => '1'],
            ['zoneId' => '1549', 'countryId' => '101', 'zoneName' => 'Kermanshah', 'zoneCode' => 'KRM', 'zoneStatus' => '1'],
            ['zoneId' => '1550', 'countryId' => '101', 'zoneName' => 'Ilam', 'zoneCode' => 'ILM', 'zoneStatus' => '1'],
            ['zoneId' => '1551', 'countryId' => '101', 'zoneName' => 'Lorestan', 'zoneCode' => 'LRS', 'zoneStatus' => '1'],
            ['zoneId' => '1552', 'countryId' => '101', 'zoneName' => 'Khuzestan', 'zoneCode' => 'KZT', 'zoneStatus' => '1'],
            ['zoneId' => '1553', 'countryId' => '101', 'zoneName' => 'Chahar Mahaal and Bakhtiari', 'zoneCode' => 'CMB', 'zoneStatus' => '1'],
            ['zoneId' => '1554', 'countryId' => '101', 'zoneName' => 'Kohkiluyeh and Buyer Ahmad', 'zoneCode' => 'KBA', 'zoneStatus' => '1'],
            ['zoneId' => '1555', 'countryId' => '101', 'zoneName' => 'Bushehr', 'zoneCode' => 'BSH', 'zoneStatus' => '1'],
            ['zoneId' => '1556', 'countryId' => '101', 'zoneName' => 'Fars', 'zoneCode' => 'FAR', 'zoneStatus' => '1'],
            ['zoneId' => '1557', 'countryId' => '101', 'zoneName' => 'Hormozgan', 'zoneCode' => 'HRM', 'zoneStatus' => '1'],
            ['zoneId' => '1558', 'countryId' => '101', 'zoneName' => 'Sistan and Baluchistan', 'zoneCode' => 'SBL', 'zoneStatus' => '1'],
            ['zoneId' => '1559', 'countryId' => '101', 'zoneName' => 'Kerman', 'zoneCode' => 'KRB', 'zoneStatus' => '1'],
            ['zoneId' => '1560', 'countryId' => '101', 'zoneName' => 'Yazd', 'zoneCode' => 'YZD', 'zoneStatus' => '1'],
            ['zoneId' => '1561', 'countryId' => '101', 'zoneName' => 'Esfahan', 'zoneCode' => 'EFH', 'zoneStatus' => '1'],
            ['zoneId' => '1562', 'countryId' => '101', 'zoneName' => 'Semnan', 'zoneCode' => 'SMN', 'zoneStatus' => '1'],
            ['zoneId' => '1563', 'countryId' => '101', 'zoneName' => 'Mazandaran', 'zoneCode' => 'MZD', 'zoneStatus' => '1'],
            ['zoneId' => '1564', 'countryId' => '101', 'zoneName' => 'Golestan', 'zoneCode' => 'GLS', 'zoneStatus' => '1'],
            ['zoneId' => '1565', 'countryId' => '101', 'zoneName' => 'North Khorasan', 'zoneCode' => 'NKH', 'zoneStatus' => '1'],
            ['zoneId' => '1566', 'countryId' => '101', 'zoneName' => 'Razavi Khorasan', 'zoneCode' => 'RKH', 'zoneStatus' => '1'],
            ['zoneId' => '1567', 'countryId' => '101', 'zoneName' => 'South Khorasan', 'zoneCode' => 'SKH', 'zoneStatus' => '1'],
            ['zoneId' => '1568', 'countryId' => '102', 'zoneName' => 'Baghdad', 'zoneCode' => 'BD', 'zoneStatus' => '1'],
            ['zoneId' => '1569', 'countryId' => '102', 'zoneName' => 'Salah ad Din', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '1570', 'countryId' => '102', 'zoneName' => 'Diyala', 'zoneCode' => 'DY', 'zoneStatus' => '1'],
            ['zoneId' => '1571', 'countryId' => '102', 'zoneName' => 'Wasit', 'zoneCode' => 'WS', 'zoneStatus' => '1'],
            ['zoneId' => '1572', 'countryId' => '102', 'zoneName' => 'Maysan', 'zoneCode' => 'MY', 'zoneStatus' => '1'],
            ['zoneId' => '1573', 'countryId' => '102', 'zoneName' => 'Al Basrah', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '1574', 'countryId' => '102', 'zoneName' => 'Dhi Qar', 'zoneCode' => 'DQ', 'zoneStatus' => '1'],
            ['zoneId' => '1575', 'countryId' => '102', 'zoneName' => 'Al Muthanna', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '1576', 'countryId' => '102', 'zoneName' => 'Al Qadisyah', 'zoneCode' => 'QA', 'zoneStatus' => '1'],
            ['zoneId' => '1577', 'countryId' => '102', 'zoneName' => 'Babil', 'zoneCode' => 'BB', 'zoneStatus' => '1'],
            ['zoneId' => '1578', 'countryId' => '102', 'zoneName' => 'Al Karbala', 'zoneCode' => 'KB', 'zoneStatus' => '1'],
            ['zoneId' => '1579', 'countryId' => '102', 'zoneName' => 'An Najaf', 'zoneCode' => 'NJ', 'zoneStatus' => '1'],
            ['zoneId' => '1580', 'countryId' => '102', 'zoneName' => 'Al Anbar', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '1581', 'countryId' => '102', 'zoneName' => 'Ninawa', 'zoneCode' => 'NN', 'zoneStatus' => '1'],
            ['zoneId' => '1582', 'countryId' => '102', 'zoneName' => 'Dahuk', 'zoneCode' => 'DH', 'zoneStatus' => '1'],
            ['zoneId' => '1583', 'countryId' => '102', 'zoneName' => 'Arbil', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '1584', 'countryId' => '102', 'zoneName' => 'At Ta\'mim', 'zoneCode' => 'TM', 'zoneStatus' => '1'],
            ['zoneId' => '1585', 'countryId' => '102', 'zoneName' => 'As Sulaymaniyah', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '1586', 'countryId' => '103', 'zoneName' => 'Carlow', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '1587', 'countryId' => '103', 'zoneName' => 'Cavan', 'zoneCode' => 'CV', 'zoneStatus' => '1'],
            ['zoneId' => '1588', 'countryId' => '103', 'zoneName' => 'Clare', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '1589', 'countryId' => '103', 'zoneName' => 'Cork', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '1590', 'countryId' => '103', 'zoneName' => 'Donegal', 'zoneCode' => 'DO', 'zoneStatus' => '1'],
            ['zoneId' => '1591', 'countryId' => '103', 'zoneName' => 'Dublin', 'zoneCode' => 'DU', 'zoneStatus' => '1'],
            ['zoneId' => '1592', 'countryId' => '103', 'zoneName' => 'Galway', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '1593', 'countryId' => '103', 'zoneName' => 'Kerry', 'zoneCode' => 'KE', 'zoneStatus' => '1'],
            ['zoneId' => '1594', 'countryId' => '103', 'zoneName' => 'Kildare', 'zoneCode' => 'KI', 'zoneStatus' => '1'],
            ['zoneId' => '1595', 'countryId' => '103', 'zoneName' => 'Kilkenny', 'zoneCode' => 'KL', 'zoneStatus' => '1'],
            ['zoneId' => '1596', 'countryId' => '103', 'zoneName' => 'Laois', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '1597', 'countryId' => '103', 'zoneName' => 'Leitrim', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '1598', 'countryId' => '103', 'zoneName' => 'Limerick', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '1599', 'countryId' => '103', 'zoneName' => 'Longford', 'zoneCode' => 'LO', 'zoneStatus' => '1'],
            ['zoneId' => '1600', 'countryId' => '103', 'zoneName' => 'Louth', 'zoneCode' => 'LU', 'zoneStatus' => '1'],
            ['zoneId' => '1601', 'countryId' => '103', 'zoneName' => 'Mayo', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1602', 'countryId' => '103', 'zoneName' => 'Meath', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '1603', 'countryId' => '103', 'zoneName' => 'Monaghan', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '1604', 'countryId' => '103', 'zoneName' => 'Offaly', 'zoneCode' => 'OF', 'zoneStatus' => '1'],
            ['zoneId' => '1605', 'countryId' => '103', 'zoneName' => 'Roscommon', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '1606', 'countryId' => '103', 'zoneName' => 'Sligo', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '1607', 'countryId' => '103', 'zoneName' => 'Tipperary', 'zoneCode' => 'TI', 'zoneStatus' => '1'],
            ['zoneId' => '1608', 'countryId' => '103', 'zoneName' => 'Waterford', 'zoneCode' => 'WA', 'zoneStatus' => '1'],
            ['zoneId' => '1609', 'countryId' => '103', 'zoneName' => 'Westmeath', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '1610', 'countryId' => '103', 'zoneName' => 'Wexford', 'zoneCode' => 'WX', 'zoneStatus' => '1'],
            ['zoneId' => '1611', 'countryId' => '103', 'zoneName' => 'Wicklow', 'zoneCode' => 'WI', 'zoneStatus' => '1'],
            ['zoneId' => '1612', 'countryId' => '104', 'zoneName' => 'Be\'er Sheva', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '1613', 'countryId' => '104', 'zoneName' => 'Bika\'at Hayarden', 'zoneCode' => 'BH', 'zoneStatus' => '1'],
            ['zoneId' => '1614', 'countryId' => '104', 'zoneName' => 'Eilat and Arava', 'zoneCode' => 'EA', 'zoneStatus' => '1'],
            ['zoneId' => '1615', 'countryId' => '104', 'zoneName' => 'Galil', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '1616', 'countryId' => '104', 'zoneName' => 'Haifa', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '1617', 'countryId' => '104', 'zoneName' => 'Jehuda Mountains', 'zoneCode' => 'JM', 'zoneStatus' => '1'],
            ['zoneId' => '1618', 'countryId' => '104', 'zoneName' => 'Jerusalem', 'zoneCode' => 'JE', 'zoneStatus' => '1'],
            ['zoneId' => '1619', 'countryId' => '104', 'zoneName' => 'Negev', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '1620', 'countryId' => '104', 'zoneName' => 'Semaria', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '1621', 'countryId' => '104', 'zoneName' => 'Sharon', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '1622', 'countryId' => '104', 'zoneName' => 'Tel Aviv (Gosh Dan)', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '1643', 'countryId' => '106', 'zoneName' => 'Clarendon Parish', 'zoneCode' => 'CLA', 'zoneStatus' => '1'],
            ['zoneId' => '1644', 'countryId' => '106', 'zoneName' => 'Hanover Parish', 'zoneCode' => 'HAN', 'zoneStatus' => '1'],
            ['zoneId' => '1645', 'countryId' => '106', 'zoneName' => 'Kingston Parish', 'zoneCode' => 'KIN', 'zoneStatus' => '1'],
            ['zoneId' => '1646', 'countryId' => '106', 'zoneName' => 'Manchester Parish', 'zoneCode' => 'MAN', 'zoneStatus' => '1'],
            ['zoneId' => '1647', 'countryId' => '106', 'zoneName' => 'Portland Parish', 'zoneCode' => 'POR', 'zoneStatus' => '1'],
            ['zoneId' => '1648', 'countryId' => '106', 'zoneName' => 'Saint Andrew Parish', 'zoneCode' => 'AND', 'zoneStatus' => '1'],
            ['zoneId' => '1649', 'countryId' => '106', 'zoneName' => 'Saint Ann Parish', 'zoneCode' => 'ANN', 'zoneStatus' => '1'],
            ['zoneId' => '1650', 'countryId' => '106', 'zoneName' => 'Saint Catherine Parish', 'zoneCode' => 'CAT', 'zoneStatus' => '1'],
            ['zoneId' => '1651', 'countryId' => '106', 'zoneName' => 'Saint Elizabeth Parish', 'zoneCode' => 'ELI', 'zoneStatus' => '1'],
            ['zoneId' => '1652', 'countryId' => '106', 'zoneName' => 'Saint James Parish', 'zoneCode' => 'JAM', 'zoneStatus' => '1'],
            ['zoneId' => '1653', 'countryId' => '106', 'zoneName' => 'Saint Mary Parish', 'zoneCode' => 'MAR', 'zoneStatus' => '1'],
            ['zoneId' => '1654', 'countryId' => '106', 'zoneName' => 'Saint Thomas Parish', 'zoneCode' => 'THO', 'zoneStatus' => '1'],
            ['zoneId' => '1655', 'countryId' => '106', 'zoneName' => 'Trelawny Parish', 'zoneCode' => 'TRL', 'zoneStatus' => '1'],
            ['zoneId' => '1656', 'countryId' => '106', 'zoneName' => 'Westmoreland Parish', 'zoneCode' => 'WML', 'zoneStatus' => '1'],
            ['zoneId' => '1657', 'countryId' => '107', 'zoneName' => 'Aichi', 'zoneCode' => 'AI', 'zoneStatus' => '1'],
            ['zoneId' => '1658', 'countryId' => '107', 'zoneName' => 'Akita', 'zoneCode' => 'AK', 'zoneStatus' => '1'],
            ['zoneId' => '1659', 'countryId' => '107', 'zoneName' => 'Aomori', 'zoneCode' => 'AO', 'zoneStatus' => '1'],
            ['zoneId' => '1660', 'countryId' => '107', 'zoneName' => 'Chiba', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '1661', 'countryId' => '107', 'zoneName' => 'Ehime', 'zoneCode' => 'EH', 'zoneStatus' => '1'],
            ['zoneId' => '1662', 'countryId' => '107', 'zoneName' => 'Fukui', 'zoneCode' => 'FK', 'zoneStatus' => '1'],
            ['zoneId' => '1663', 'countryId' => '107', 'zoneName' => 'Fukuoka', 'zoneCode' => 'FU', 'zoneStatus' => '1'],
            ['zoneId' => '1664', 'countryId' => '107', 'zoneName' => 'Fukushima', 'zoneCode' => 'FS', 'zoneStatus' => '1'],
            ['zoneId' => '1665', 'countryId' => '107', 'zoneName' => 'Gifu', 'zoneCode' => 'GI', 'zoneStatus' => '1'],
            ['zoneId' => '1666', 'countryId' => '107', 'zoneName' => 'Gumma', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '1667', 'countryId' => '107', 'zoneName' => 'Hiroshima', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '1668', 'countryId' => '107', 'zoneName' => 'Hokkaido', 'zoneCode' => 'HO', 'zoneStatus' => '1'],
            ['zoneId' => '1669', 'countryId' => '107', 'zoneName' => 'Hyogo', 'zoneCode' => 'HY', 'zoneStatus' => '1'],
            ['zoneId' => '1670', 'countryId' => '107', 'zoneName' => 'Ibaraki', 'zoneCode' => 'IB', 'zoneStatus' => '1'],
            ['zoneId' => '1671', 'countryId' => '107', 'zoneName' => 'Ishikawa', 'zoneCode' => 'IS', 'zoneStatus' => '1'],
            ['zoneId' => '1672', 'countryId' => '107', 'zoneName' => 'Iwate', 'zoneCode' => 'IW', 'zoneStatus' => '1'],
            ['zoneId' => '1673', 'countryId' => '107', 'zoneName' => 'Kagawa', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '1674', 'countryId' => '107', 'zoneName' => 'Kagoshima', 'zoneCode' => 'KG', 'zoneStatus' => '1'],
            ['zoneId' => '1675', 'countryId' => '107', 'zoneName' => 'Kanagawa', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '1676', 'countryId' => '107', 'zoneName' => 'Kochi', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '1677', 'countryId' => '107', 'zoneName' => 'Kumamoto', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '1678', 'countryId' => '107', 'zoneName' => 'Kyoto', 'zoneCode' => 'KY', 'zoneStatus' => '1'],
            ['zoneId' => '1679', 'countryId' => '107', 'zoneName' => 'Mie', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '1680', 'countryId' => '107', 'zoneName' => 'Miyagi', 'zoneCode' => 'MY', 'zoneStatus' => '1'],
            ['zoneId' => '1681', 'countryId' => '107', 'zoneName' => 'Miyazaki', 'zoneCode' => 'MZ', 'zoneStatus' => '1'],
            ['zoneId' => '1682', 'countryId' => '107', 'zoneName' => 'Nagano', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '1683', 'countryId' => '107', 'zoneName' => 'Nagasaki', 'zoneCode' => 'NG', 'zoneStatus' => '1'],
            ['zoneId' => '1684', 'countryId' => '107', 'zoneName' => 'Nara', 'zoneCode' => 'NR', 'zoneStatus' => '1'],
            ['zoneId' => '1685', 'countryId' => '107', 'zoneName' => 'Niigata', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '1686', 'countryId' => '107', 'zoneName' => 'Oita', 'zoneCode' => 'OI', 'zoneStatus' => '1'],
            ['zoneId' => '1687', 'countryId' => '107', 'zoneName' => 'Okayama', 'zoneCode' => 'OK', 'zoneStatus' => '1'],
            ['zoneId' => '1688', 'countryId' => '107', 'zoneName' => 'Okinawa', 'zoneCode' => 'ON', 'zoneStatus' => '1'],
            ['zoneId' => '1689', 'countryId' => '107', 'zoneName' => 'Osaka', 'zoneCode' => 'OS', 'zoneStatus' => '1'],
            ['zoneId' => '1690', 'countryId' => '107', 'zoneName' => 'Saga', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '1691', 'countryId' => '107', 'zoneName' => 'Saitama', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '1692', 'countryId' => '107', 'zoneName' => 'Shiga', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '1693', 'countryId' => '107', 'zoneName' => 'Shimane', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '1694', 'countryId' => '107', 'zoneName' => 'Shizuoka', 'zoneCode' => 'SZ', 'zoneStatus' => '1'],
            ['zoneId' => '1695', 'countryId' => '107', 'zoneName' => 'Tochigi', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '1696', 'countryId' => '107', 'zoneName' => 'Tokushima', 'zoneCode' => 'TS', 'zoneStatus' => '1'],
            ['zoneId' => '1697', 'countryId' => '107', 'zoneName' => 'Tokyo', 'zoneCode' => 'TK', 'zoneStatus' => '1'],
            ['zoneId' => '1698', 'countryId' => '107', 'zoneName' => 'Tottori', 'zoneCode' => 'TT', 'zoneStatus' => '1'],
            ['zoneId' => '1699', 'countryId' => '107', 'zoneName' => 'Toyama', 'zoneCode' => 'TY', 'zoneStatus' => '1'],
            ['zoneId' => '1700', 'countryId' => '107', 'zoneName' => 'Wakayama', 'zoneCode' => 'WA', 'zoneStatus' => '1'],
            ['zoneId' => '1701', 'countryId' => '107', 'zoneName' => 'Yamagata', 'zoneCode' => 'YA', 'zoneStatus' => '1'],
            ['zoneId' => '1702', 'countryId' => '107', 'zoneName' => 'Yamaguchi', 'zoneCode' => 'YM', 'zoneStatus' => '1'],
            ['zoneId' => '1703', 'countryId' => '107', 'zoneName' => 'Yamanashi', 'zoneCode' => 'YN', 'zoneStatus' => '1'],
            ['zoneId' => '1704', 'countryId' => '108', 'zoneName' => '\'Amman', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '1705', 'countryId' => '108', 'zoneName' => 'Ajlun', 'zoneCode' => 'AJ', 'zoneStatus' => '1'],
            ['zoneId' => '1706', 'countryId' => '108', 'zoneName' => 'Al \'Aqabah', 'zoneCode' => 'AA', 'zoneStatus' => '1'],
            ['zoneId' => '1707', 'countryId' => '108', 'zoneName' => 'Al Balqa\'', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '1708', 'countryId' => '108', 'zoneName' => 'Al Karak', 'zoneCode' => 'AK', 'zoneStatus' => '1'],
            ['zoneId' => '1709', 'countryId' => '108', 'zoneName' => 'Al Mafraq', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '1710', 'countryId' => '108', 'zoneName' => 'At Tafilah', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '1711', 'countryId' => '108', 'zoneName' => 'Az Zarqa\'', 'zoneCode' => 'AZ', 'zoneStatus' => '1'],
            ['zoneId' => '1712', 'countryId' => '108', 'zoneName' => 'Irbid', 'zoneCode' => 'IR', 'zoneStatus' => '1'],
            ['zoneId' => '1713', 'countryId' => '108', 'zoneName' => 'Jarash', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '1714', 'countryId' => '108', 'zoneName' => 'Ma\'an', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1715', 'countryId' => '108', 'zoneName' => 'Madaba', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '1716', 'countryId' => '109', 'zoneName' => 'Almaty', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '1717', 'countryId' => '109', 'zoneName' => 'Almaty City', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '1718', 'countryId' => '109', 'zoneName' => 'Aqmola', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '1719', 'countryId' => '109', 'zoneName' => 'Aqtobe', 'zoneCode' => 'AQ', 'zoneStatus' => '1'],
            ['zoneId' => '1720', 'countryId' => '109', 'zoneName' => 'Astana City', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '1721', 'countryId' => '109', 'zoneName' => 'Atyrau', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '1722', 'countryId' => '109', 'zoneName' => 'Batys Qazaqstan', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '1723', 'countryId' => '109', 'zoneName' => 'Bayqongyr City', 'zoneCode' => 'BY', 'zoneStatus' => '1'],
            ['zoneId' => '1724', 'countryId' => '109', 'zoneName' => 'Mangghystau', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1725', 'countryId' => '109', 'zoneName' => 'Ongtustik Qazaqstan', 'zoneCode' => 'ON', 'zoneStatus' => '1'],
            ['zoneId' => '1726', 'countryId' => '109', 'zoneName' => 'Pavlodar', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '1727', 'countryId' => '109', 'zoneName' => 'Qaraghandy', 'zoneCode' => 'QA', 'zoneStatus' => '1'],
            ['zoneId' => '1728', 'countryId' => '109', 'zoneName' => 'Qostanay', 'zoneCode' => 'QO', 'zoneStatus' => '1'],
            ['zoneId' => '1729', 'countryId' => '109', 'zoneName' => 'Qyzylorda', 'zoneCode' => 'QY', 'zoneStatus' => '1'],
            ['zoneId' => '1730', 'countryId' => '109', 'zoneName' => 'Shyghys Qazaqstan', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '1731', 'countryId' => '109', 'zoneName' => 'Soltustik Qazaqstan', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '1732', 'countryId' => '109', 'zoneName' => 'Zhambyl', 'zoneCode' => 'ZH', 'zoneStatus' => '1'],
            ['zoneId' => '1733', 'countryId' => '110', 'zoneName' => 'Central', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '1734', 'countryId' => '110', 'zoneName' => 'Coast', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '1735', 'countryId' => '110', 'zoneName' => 'Eastern', 'zoneCode' => 'EA', 'zoneStatus' => '1'],
            ['zoneId' => '1736', 'countryId' => '110', 'zoneName' => 'Nairobi Area', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '1737', 'countryId' => '110', 'zoneName' => 'North Eastern', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '1738', 'countryId' => '110', 'zoneName' => 'Nyanza', 'zoneCode' => 'NY', 'zoneStatus' => '1'],
            ['zoneId' => '1739', 'countryId' => '110', 'zoneName' => 'Rift Valley', 'zoneCode' => 'RV', 'zoneStatus' => '1'],
            ['zoneId' => '1740', 'countryId' => '110', 'zoneName' => 'Western', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '1741', 'countryId' => '111', 'zoneName' => 'Abaiang', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '1742', 'countryId' => '111', 'zoneName' => 'Abemama', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '1743', 'countryId' => '111', 'zoneName' => 'Aranuka', 'zoneCode' => 'AK', 'zoneStatus' => '1'],
            ['zoneId' => '1744', 'countryId' => '111', 'zoneName' => 'Arorae', 'zoneCode' => 'AO', 'zoneStatus' => '1'],
            ['zoneId' => '1745', 'countryId' => '111', 'zoneName' => 'Banaba', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '1746', 'countryId' => '111', 'zoneName' => 'Beru', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '1747', 'countryId' => '111', 'zoneName' => 'Butaritari', 'zoneCode' => 'bT', 'zoneStatus' => '1'],
            ['zoneId' => '1748', 'countryId' => '111', 'zoneName' => 'Kanton', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '1749', 'countryId' => '111', 'zoneName' => 'Kiritimati', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '1750', 'countryId' => '111', 'zoneName' => 'Kuria', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '1751', 'countryId' => '111', 'zoneName' => 'Maiana', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '1752', 'countryId' => '111', 'zoneName' => 'Makin', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '1753', 'countryId' => '111', 'zoneName' => 'Marakei', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '1754', 'countryId' => '111', 'zoneName' => 'Nikunau', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '1755', 'countryId' => '111', 'zoneName' => 'Nonouti', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '1756', 'countryId' => '111', 'zoneName' => 'Onotoa', 'zoneCode' => 'ON', 'zoneStatus' => '1'],
            ['zoneId' => '1757', 'countryId' => '111', 'zoneName' => 'Tabiteuea', 'zoneCode' => 'TT', 'zoneStatus' => '1'],
            ['zoneId' => '1758', 'countryId' => '111', 'zoneName' => 'Tabuaeran', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '1759', 'countryId' => '111', 'zoneName' => 'Tamana', 'zoneCode' => 'TM', 'zoneStatus' => '1'],
            ['zoneId' => '1760', 'countryId' => '111', 'zoneName' => 'Tarawa', 'zoneCode' => 'TW', 'zoneStatus' => '1'],
            ['zoneId' => '1761', 'countryId' => '111', 'zoneName' => 'Teraina', 'zoneCode' => 'TE', 'zoneStatus' => '1'],
            ['zoneId' => '1762', 'countryId' => '112', 'zoneName' => 'Chagang-do', 'zoneCode' => 'CHA', 'zoneStatus' => '1'],
            ['zoneId' => '1763', 'countryId' => '112', 'zoneName' => 'Hamgyong-bukto', 'zoneCode' => 'HAB', 'zoneStatus' => '1'],
            ['zoneId' => '1764', 'countryId' => '112', 'zoneName' => 'Hamgyong-namdo', 'zoneCode' => 'HAN', 'zoneStatus' => '1'],
            ['zoneId' => '1765', 'countryId' => '112', 'zoneName' => 'Hwanghae-bukto', 'zoneCode' => 'HWB', 'zoneStatus' => '1'],
            ['zoneId' => '1766', 'countryId' => '112', 'zoneName' => 'Hwanghae-namdo', 'zoneCode' => 'HWN', 'zoneStatus' => '1'],
            ['zoneId' => '1767', 'countryId' => '112', 'zoneName' => 'Kangwon-do', 'zoneCode' => 'KAN', 'zoneStatus' => '1'],
            ['zoneId' => '1768', 'countryId' => '112', 'zoneName' => 'P\'yongan-bukto', 'zoneCode' => 'PYB', 'zoneStatus' => '1'],
            ['zoneId' => '1769', 'countryId' => '112', 'zoneName' => 'P\'yongan-namdo', 'zoneCode' => 'PYN', 'zoneStatus' => '1'],
            ['zoneId' => '1770', 'countryId' => '112', 'zoneName' => 'Ryanggang-do (Yanggang-do)', 'zoneCode' => 'YAN', 'zoneStatus' => '1'],
            ['zoneId' => '1771', 'countryId' => '112', 'zoneName' => 'Rason Directly Governed City', 'zoneCode' => 'NAJ', 'zoneStatus' => '1'],
            ['zoneId' => '1772', 'countryId' => '112', 'zoneName' => 'P\'yongyang Special City', 'zoneCode' => 'PYO', 'zoneStatus' => '1'],
            ['zoneId' => '1773', 'countryId' => '113', 'zoneName' => 'Ch\'ungch\'ong-bukto', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '1774', 'countryId' => '113', 'zoneName' => 'Ch\'ungch\'ong-namdo', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '1775', 'countryId' => '113', 'zoneName' => 'Cheju-do', 'zoneCode' => 'CD', 'zoneStatus' => '1'],
            ['zoneId' => '1776', 'countryId' => '113', 'zoneName' => 'Cholla-bukto', 'zoneCode' => 'CB', 'zoneStatus' => '1'],
            ['zoneId' => '1777', 'countryId' => '113', 'zoneName' => 'Cholla-namdo', 'zoneCode' => 'CN', 'zoneStatus' => '1'],
            ['zoneId' => '1778', 'countryId' => '113', 'zoneName' => 'Inch\'on-gwangyoksi', 'zoneCode' => 'IG', 'zoneStatus' => '1'],
            ['zoneId' => '1779', 'countryId' => '113', 'zoneName' => 'Kangwon-do', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '1780', 'countryId' => '113', 'zoneName' => 'Kwangju-gwangyoksi', 'zoneCode' => 'KG', 'zoneStatus' => '1'],
            ['zoneId' => '1781', 'countryId' => '113', 'zoneName' => 'Kyonggi-do', 'zoneCode' => 'KD', 'zoneStatus' => '1'],
            ['zoneId' => '1782', 'countryId' => '113', 'zoneName' => 'Kyongsang-bukto', 'zoneCode' => 'KB', 'zoneStatus' => '1'],
            ['zoneId' => '1783', 'countryId' => '113', 'zoneName' => 'Kyongsang-namdo', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '1784', 'countryId' => '113', 'zoneName' => 'Pusan-gwangyoksi', 'zoneCode' => 'PG', 'zoneStatus' => '1'],
            ['zoneId' => '1785', 'countryId' => '113', 'zoneName' => 'Soul-t\'ukpyolsi', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '1786', 'countryId' => '113', 'zoneName' => 'Taegu-gwangyoksi', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '1787', 'countryId' => '113', 'zoneName' => 'Taejon-gwangyoksi', 'zoneCode' => 'TG', 'zoneStatus' => '1'],
            ['zoneId' => '1788', 'countryId' => '114', 'zoneName' => 'Al \'Asimah', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '1789', 'countryId' => '114', 'zoneName' => 'Al Ahmadi', 'zoneCode' => 'AA', 'zoneStatus' => '1'],
            ['zoneId' => '1790', 'countryId' => '114', 'zoneName' => 'Al Farwaniyah', 'zoneCode' => 'AF', 'zoneStatus' => '1'],
            ['zoneId' => '1791', 'countryId' => '114', 'zoneName' => 'Al Jahra\'', 'zoneCode' => 'AJ', 'zoneStatus' => '1'],
            ['zoneId' => '1792', 'countryId' => '114', 'zoneName' => 'Hawalli', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '1793', 'countryId' => '115', 'zoneName' => 'Bishkek', 'zoneCode' => 'GB', 'zoneStatus' => '1'],
            ['zoneId' => '1794', 'countryId' => '115', 'zoneName' => 'Batken', 'zoneCode' => 'B', 'zoneStatus' => '1'],
            ['zoneId' => '1795', 'countryId' => '115', 'zoneName' => 'Chu', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '1796', 'countryId' => '115', 'zoneName' => 'Jalal-Abad', 'zoneCode' => 'J', 'zoneStatus' => '1'],
            ['zoneId' => '1797', 'countryId' => '115', 'zoneName' => 'Naryn', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '1798', 'countryId' => '115', 'zoneName' => 'Osh', 'zoneCode' => 'O', 'zoneStatus' => '1'],
            ['zoneId' => '1799', 'countryId' => '115', 'zoneName' => 'Talas', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '1800', 'countryId' => '115', 'zoneName' => 'Ysyk-Kol', 'zoneCode' => 'Y', 'zoneStatus' => '1'],
            ['zoneId' => '1801', 'countryId' => '116', 'zoneName' => 'Vientiane', 'zoneCode' => 'VT', 'zoneStatus' => '1'],
            ['zoneId' => '1802', 'countryId' => '116', 'zoneName' => 'Attapu', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '1803', 'countryId' => '116', 'zoneName' => 'Bokeo', 'zoneCode' => 'BK', 'zoneStatus' => '1'],
            ['zoneId' => '1804', 'countryId' => '116', 'zoneName' => 'Bolikhamxai', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '1805', 'countryId' => '116', 'zoneName' => 'Champasak', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '1806', 'countryId' => '116', 'zoneName' => 'Houaphan', 'zoneCode' => 'HO', 'zoneStatus' => '1'],
            ['zoneId' => '1807', 'countryId' => '116', 'zoneName' => 'Khammouan', 'zoneCode' => 'KH', 'zoneStatus' => '1'],
            ['zoneId' => '1808', 'countryId' => '116', 'zoneName' => 'Louang Namtha', 'zoneCode' => 'LM', 'zoneStatus' => '1'],
            ['zoneId' => '1809', 'countryId' => '116', 'zoneName' => 'Louangphabang', 'zoneCode' => 'LP', 'zoneStatus' => '1'],
            ['zoneId' => '1810', 'countryId' => '116', 'zoneName' => 'Oudomxai', 'zoneCode' => 'OU', 'zoneStatus' => '1'],
            ['zoneId' => '1811', 'countryId' => '116', 'zoneName' => 'Phongsali', 'zoneCode' => 'PH', 'zoneStatus' => '1'],
            ['zoneId' => '1812', 'countryId' => '116', 'zoneName' => 'Salavan', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '1813', 'countryId' => '116', 'zoneName' => 'Savannakhet', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '1814', 'countryId' => '116', 'zoneName' => 'Vientiane', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '1815', 'countryId' => '116', 'zoneName' => 'Xaignabouli', 'zoneCode' => 'XA', 'zoneStatus' => '1'],
            ['zoneId' => '1816', 'countryId' => '116', 'zoneName' => 'Xekong', 'zoneCode' => 'XE', 'zoneStatus' => '1'],
            ['zoneId' => '1817', 'countryId' => '116', 'zoneName' => 'Xiangkhoang', 'zoneCode' => 'XI', 'zoneStatus' => '1'],
            ['zoneId' => '1818', 'countryId' => '116', 'zoneName' => 'Xaisomboun', 'zoneCode' => 'XN', 'zoneStatus' => '1'],
            ['zoneId' => '1852', 'countryId' => '119', 'zoneName' => 'Berea', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '1853', 'countryId' => '119', 'zoneName' => 'Butha-Buthe', 'zoneCode' => 'BB', 'zoneStatus' => '1'],
            ['zoneId' => '1854', 'countryId' => '119', 'zoneName' => 'Leribe', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '1855', 'countryId' => '119', 'zoneName' => 'Mafeteng', 'zoneCode' => 'MF', 'zoneStatus' => '1'],
            ['zoneId' => '1856', 'countryId' => '119', 'zoneName' => 'Maseru', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '1857', 'countryId' => '119', 'zoneName' => 'Mohale\'s Hoek', 'zoneCode' => 'MH', 'zoneStatus' => '1'],
            ['zoneId' => '1858', 'countryId' => '119', 'zoneName' => 'Mokhotlong', 'zoneCode' => 'MK', 'zoneStatus' => '1'],
            ['zoneId' => '1859', 'countryId' => '119', 'zoneName' => 'Qacha\'s Nek', 'zoneCode' => 'QN', 'zoneStatus' => '1'],
            ['zoneId' => '1860', 'countryId' => '119', 'zoneName' => 'Quthing', 'zoneCode' => 'QT', 'zoneStatus' => '1'],
            ['zoneId' => '1861', 'countryId' => '119', 'zoneName' => 'Thaba-Tseka', 'zoneCode' => 'TT', 'zoneStatus' => '1'],
            ['zoneId' => '1862', 'countryId' => '120', 'zoneName' => 'Bomi', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '1863', 'countryId' => '120', 'zoneName' => 'Bong', 'zoneCode' => 'BG', 'zoneStatus' => '1'],
            ['zoneId' => '1864', 'countryId' => '120', 'zoneName' => 'Grand Bassa', 'zoneCode' => 'GB', 'zoneStatus' => '1'],
            ['zoneId' => '1865', 'countryId' => '120', 'zoneName' => 'Grand Cape Mount', 'zoneCode' => 'CM', 'zoneStatus' => '1'],
            ['zoneId' => '1866', 'countryId' => '120', 'zoneName' => 'Grand Gedeh', 'zoneCode' => 'GG', 'zoneStatus' => '1'],
            ['zoneId' => '1867', 'countryId' => '120', 'zoneName' => 'Grand Kru', 'zoneCode' => 'GK', 'zoneStatus' => '1'],
            ['zoneId' => '1868', 'countryId' => '120', 'zoneName' => 'Lofa', 'zoneCode' => 'LO', 'zoneStatus' => '1'],
            ['zoneId' => '1869', 'countryId' => '120', 'zoneName' => 'Margibi', 'zoneCode' => 'MG', 'zoneStatus' => '1'],
            ['zoneId' => '1870', 'countryId' => '120', 'zoneName' => 'Maryland', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '1871', 'countryId' => '120', 'zoneName' => 'Montserrado', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '1872', 'countryId' => '120', 'zoneName' => 'Nimba', 'zoneCode' => 'NB', 'zoneStatus' => '1'],
            ['zoneId' => '1873', 'countryId' => '120', 'zoneName' => 'River Cess', 'zoneCode' => 'RC', 'zoneStatus' => '1'],
            ['zoneId' => '1874', 'countryId' => '120', 'zoneName' => 'Sinoe', 'zoneCode' => 'SN', 'zoneStatus' => '1'],
            ['zoneId' => '1875', 'countryId' => '121', 'zoneName' => 'Ajdabiya', 'zoneCode' => 'AJ', 'zoneStatus' => '1'],
            ['zoneId' => '1876', 'countryId' => '121', 'zoneName' => 'Al \'Aziziyah', 'zoneCode' => 'AZ', 'zoneStatus' => '1'],
            ['zoneId' => '1877', 'countryId' => '121', 'zoneName' => 'Al Fatih', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '1878', 'countryId' => '121', 'zoneName' => 'Al Jabal al Akhdar', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '1879', 'countryId' => '121', 'zoneName' => 'Al Jufrah', 'zoneCode' => 'JU', 'zoneStatus' => '1'],
            ['zoneId' => '1880', 'countryId' => '121', 'zoneName' => 'Al Khums', 'zoneCode' => 'KH', 'zoneStatus' => '1'],
            ['zoneId' => '1881', 'countryId' => '121', 'zoneName' => 'Al Kufrah', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '1882', 'countryId' => '121', 'zoneName' => 'An Nuqat al Khams', 'zoneCode' => 'NK', 'zoneStatus' => '1'],
            ['zoneId' => '1883', 'countryId' => '121', 'zoneName' => 'Ash Shati\'', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '1884', 'countryId' => '121', 'zoneName' => 'Awbari', 'zoneCode' => 'AW', 'zoneStatus' => '1'],
            ['zoneId' => '1885', 'countryId' => '121', 'zoneName' => 'Az Zawiyah', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '1886', 'countryId' => '121', 'zoneName' => 'Banghazi', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '1887', 'countryId' => '121', 'zoneName' => 'Darnah', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '1888', 'countryId' => '121', 'zoneName' => 'Ghadamis', 'zoneCode' => 'GD', 'zoneStatus' => '1'],
            ['zoneId' => '1889', 'countryId' => '121', 'zoneName' => 'Gharyan', 'zoneCode' => 'GY', 'zoneStatus' => '1'],
            ['zoneId' => '1890', 'countryId' => '121', 'zoneName' => 'Misratah', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '1891', 'countryId' => '121', 'zoneName' => 'Murzuq', 'zoneCode' => 'MZ', 'zoneStatus' => '1'],
            ['zoneId' => '1892', 'countryId' => '121', 'zoneName' => 'Sabha', 'zoneCode' => 'SB', 'zoneStatus' => '1'],
            ['zoneId' => '1893', 'countryId' => '121', 'zoneName' => 'Sawfajjin', 'zoneCode' => 'SW', 'zoneStatus' => '1'],
            ['zoneId' => '1894', 'countryId' => '121', 'zoneName' => 'Surt', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '1895', 'countryId' => '121', 'zoneName' => 'Tarabulus (Tripoli)', 'zoneCode' => 'TL', 'zoneStatus' => '1'],
            ['zoneId' => '1896', 'countryId' => '121', 'zoneName' => 'Tarhunah', 'zoneCode' => 'TH', 'zoneStatus' => '1'],
            ['zoneId' => '1897', 'countryId' => '121', 'zoneName' => 'Tubruq', 'zoneCode' => 'TU', 'zoneStatus' => '1'],
            ['zoneId' => '1898', 'countryId' => '121', 'zoneName' => 'Yafran', 'zoneCode' => 'YA', 'zoneStatus' => '1'],
            ['zoneId' => '1899', 'countryId' => '121', 'zoneName' => 'Zlitan', 'zoneCode' => 'ZL', 'zoneStatus' => '1'],
            ['zoneId' => '1900', 'countryId' => '122', 'zoneName' => 'Vaduz', 'zoneCode' => 'V', 'zoneStatus' => '1'],
            ['zoneId' => '1901', 'countryId' => '122', 'zoneName' => 'Schaan', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '1902', 'countryId' => '122', 'zoneName' => 'Balzers', 'zoneCode' => 'B', 'zoneStatus' => '1'],
            ['zoneId' => '1903', 'countryId' => '122', 'zoneName' => 'Triesen', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '1904', 'countryId' => '122', 'zoneName' => 'Eschen', 'zoneCode' => 'E', 'zoneStatus' => '1'],
            ['zoneId' => '1905', 'countryId' => '122', 'zoneName' => 'Mauren', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '1906', 'countryId' => '122', 'zoneName' => 'Triesenberg', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '1907', 'countryId' => '122', 'zoneName' => 'Ruggell', 'zoneCode' => 'R', 'zoneStatus' => '1'],
            ['zoneId' => '1908', 'countryId' => '122', 'zoneName' => 'Gamprin', 'zoneCode' => 'G', 'zoneStatus' => '1'],
            ['zoneId' => '1909', 'countryId' => '122', 'zoneName' => 'Schellenberg', 'zoneCode' => 'L', 'zoneStatus' => '1'],
            ['zoneId' => '1910', 'countryId' => '122', 'zoneName' => 'Planken', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '1911', 'countryId' => '123', 'zoneName' => 'Alytus', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '1912', 'countryId' => '123', 'zoneName' => 'Kaunas', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '1913', 'countryId' => '123', 'zoneName' => 'Klaipeda', 'zoneCode' => 'KL', 'zoneStatus' => '1'],
            ['zoneId' => '1914', 'countryId' => '123', 'zoneName' => 'Marijampole', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '1915', 'countryId' => '123', 'zoneName' => 'Panevezys', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '1916', 'countryId' => '123', 'zoneName' => 'Siauliai', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '1917', 'countryId' => '123', 'zoneName' => 'Taurage', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '1918', 'countryId' => '123', 'zoneName' => 'Telsiai', 'zoneCode' => 'TE', 'zoneStatus' => '1'],
            ['zoneId' => '1919', 'countryId' => '123', 'zoneName' => 'Utena', 'zoneCode' => 'UT', 'zoneStatus' => '1'],
            ['zoneId' => '1920', 'countryId' => '123', 'zoneName' => 'Vilnius', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '1921', 'countryId' => '124', 'zoneName' => 'Diekirch', 'zoneCode' => 'DD', 'zoneStatus' => '1'],
            ['zoneId' => '1922', 'countryId' => '124', 'zoneName' => 'Clervaux', 'zoneCode' => 'DC', 'zoneStatus' => '1'],
            ['zoneId' => '1923', 'countryId' => '124', 'zoneName' => 'Redange', 'zoneCode' => 'DR', 'zoneStatus' => '1'],
            ['zoneId' => '1924', 'countryId' => '124', 'zoneName' => 'Vianden', 'zoneCode' => 'DV', 'zoneStatus' => '1'],
            ['zoneId' => '1925', 'countryId' => '124', 'zoneName' => 'Wiltz', 'zoneCode' => 'DW', 'zoneStatus' => '1'],
            ['zoneId' => '1926', 'countryId' => '124', 'zoneName' => 'Grevenmacher', 'zoneCode' => 'GG', 'zoneStatus' => '1'],
            ['zoneId' => '1927', 'countryId' => '124', 'zoneName' => 'Echternach', 'zoneCode' => 'GE', 'zoneStatus' => '1'],
            ['zoneId' => '1928', 'countryId' => '124', 'zoneName' => 'Remich', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '1929', 'countryId' => '124', 'zoneName' => 'Luxembourg', 'zoneCode' => 'LL', 'zoneStatus' => '1'],
            ['zoneId' => '1930', 'countryId' => '124', 'zoneName' => 'Capellen', 'zoneCode' => 'LC', 'zoneStatus' => '1'],
            ['zoneId' => '1931', 'countryId' => '124', 'zoneName' => 'Esch-sur-Alzette', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '1932', 'countryId' => '124', 'zoneName' => 'Mersch', 'zoneCode' => 'LM', 'zoneStatus' => '1'],
            ['zoneId' => '1933', 'countryId' => '125', 'zoneName' => 'Our Lady Fatima Parish', 'zoneCode' => 'OLF', 'zoneStatus' => '1'],
            ['zoneId' => '1934', 'countryId' => '125', 'zoneName' => 'St. Anthony Parish', 'zoneCode' => 'ANT', 'zoneStatus' => '1'],
            ['zoneId' => '1935', 'countryId' => '125', 'zoneName' => 'St. Lazarus Parish', 'zoneCode' => 'LAZ', 'zoneStatus' => '1'],
            ['zoneId' => '1936', 'countryId' => '125', 'zoneName' => 'Cathedral Parish', 'zoneCode' => 'CAT', 'zoneStatus' => '1'],
            ['zoneId' => '1937', 'countryId' => '125', 'zoneName' => 'St. Lawrence Parish', 'zoneCode' => 'LAW', 'zoneStatus' => '1'],
            ['zoneId' => '1938', 'countryId' => '127', 'zoneName' => 'Antananarivo', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '1939', 'countryId' => '127', 'zoneName' => 'Antsiranana', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '1940', 'countryId' => '127', 'zoneName' => 'Fianarantsoa', 'zoneCode' => 'FN', 'zoneStatus' => '1'],
            ['zoneId' => '1941', 'countryId' => '127', 'zoneName' => 'Mahajanga', 'zoneCode' => 'MJ', 'zoneStatus' => '1'],
            ['zoneId' => '1942', 'countryId' => '127', 'zoneName' => 'Toamasina', 'zoneCode' => 'TM', 'zoneStatus' => '1'],
            ['zoneId' => '1943', 'countryId' => '127', 'zoneName' => 'Toliara', 'zoneCode' => 'TL', 'zoneStatus' => '1'],
            ['zoneId' => '1944', 'countryId' => '128', 'zoneName' => 'Balaka', 'zoneCode' => 'BLK', 'zoneStatus' => '1'],
            ['zoneId' => '1945', 'countryId' => '128', 'zoneName' => 'Blantyre', 'zoneCode' => 'BLT', 'zoneStatus' => '1'],
            ['zoneId' => '1946', 'countryId' => '128', 'zoneName' => 'Chikwawa', 'zoneCode' => 'CKW', 'zoneStatus' => '1'],
            ['zoneId' => '1947', 'countryId' => '128', 'zoneName' => 'Chiradzulu', 'zoneCode' => 'CRD', 'zoneStatus' => '1'],
            ['zoneId' => '1948', 'countryId' => '128', 'zoneName' => 'Chitipa', 'zoneCode' => 'CTP', 'zoneStatus' => '1'],
            ['zoneId' => '1949', 'countryId' => '128', 'zoneName' => 'Dedza', 'zoneCode' => 'DDZ', 'zoneStatus' => '1'],
            ['zoneId' => '1950', 'countryId' => '128', 'zoneName' => 'Dowa', 'zoneCode' => 'DWA', 'zoneStatus' => '1'],
            ['zoneId' => '1951', 'countryId' => '128', 'zoneName' => 'Karonga', 'zoneCode' => 'KRG', 'zoneStatus' => '1'],
            ['zoneId' => '1952', 'countryId' => '128', 'zoneName' => 'Kasungu', 'zoneCode' => 'KSG', 'zoneStatus' => '1'],
            ['zoneId' => '1953', 'countryId' => '128', 'zoneName' => 'Likoma', 'zoneCode' => 'LKM', 'zoneStatus' => '1'],
            ['zoneId' => '1954', 'countryId' => '128', 'zoneName' => 'Lilongwe', 'zoneCode' => 'LLG', 'zoneStatus' => '1'],
            ['zoneId' => '1955', 'countryId' => '128', 'zoneName' => 'Machinga', 'zoneCode' => 'MCG', 'zoneStatus' => '1'],
            ['zoneId' => '1956', 'countryId' => '128', 'zoneName' => 'Mangochi', 'zoneCode' => 'MGC', 'zoneStatus' => '1'],
            ['zoneId' => '1957', 'countryId' => '128', 'zoneName' => 'Mchinji', 'zoneCode' => 'MCH', 'zoneStatus' => '1'],
            ['zoneId' => '1958', 'countryId' => '128', 'zoneName' => 'Mulanje', 'zoneCode' => 'MLJ', 'zoneStatus' => '1'],
            ['zoneId' => '1959', 'countryId' => '128', 'zoneName' => 'Mwanza', 'zoneCode' => 'MWZ', 'zoneStatus' => '1'],
            ['zoneId' => '1960', 'countryId' => '128', 'zoneName' => 'Mzimba', 'zoneCode' => 'MZM', 'zoneStatus' => '1'],
            ['zoneId' => '1961', 'countryId' => '128', 'zoneName' => 'Ntcheu', 'zoneCode' => 'NTU', 'zoneStatus' => '1'],
            ['zoneId' => '1962', 'countryId' => '128', 'zoneName' => 'Nkhata Bay', 'zoneCode' => 'NKB', 'zoneStatus' => '1'],
            ['zoneId' => '1963', 'countryId' => '128', 'zoneName' => 'Nkhotakota', 'zoneCode' => 'NKH', 'zoneStatus' => '1'],
            ['zoneId' => '1964', 'countryId' => '128', 'zoneName' => 'Nsanje', 'zoneCode' => 'NSJ', 'zoneStatus' => '1'],
            ['zoneId' => '1965', 'countryId' => '128', 'zoneName' => 'Ntchisi', 'zoneCode' => 'NTI', 'zoneStatus' => '1'],
            ['zoneId' => '1966', 'countryId' => '128', 'zoneName' => 'Phalombe', 'zoneCode' => 'PHL', 'zoneStatus' => '1'],
            ['zoneId' => '1967', 'countryId' => '128', 'zoneName' => 'Rumphi', 'zoneCode' => 'RMP', 'zoneStatus' => '1'],
            ['zoneId' => '1968', 'countryId' => '128', 'zoneName' => 'Salima', 'zoneCode' => 'SLM', 'zoneStatus' => '1'],
            ['zoneId' => '1969', 'countryId' => '128', 'zoneName' => 'Thyolo', 'zoneCode' => 'THY', 'zoneStatus' => '1'],
            ['zoneId' => '1970', 'countryId' => '128', 'zoneName' => 'Zomba', 'zoneCode' => 'ZBA', 'zoneStatus' => '1'],
            ['zoneId' => '1971', 'countryId' => '129', 'zoneName' => 'Johor', 'zoneCode' => 'MY-01', 'zoneStatus' => '1'],
            ['zoneId' => '1972', 'countryId' => '129', 'zoneName' => 'Kedah', 'zoneCode' => 'MY-02', 'zoneStatus' => '1'],
            ['zoneId' => '1973', 'countryId' => '129', 'zoneName' => 'Kelantan', 'zoneCode' => 'MY-03', 'zoneStatus' => '1'],
            ['zoneId' => '1974', 'countryId' => '129', 'zoneName' => 'Labuan', 'zoneCode' => 'MY-15', 'zoneStatus' => '1'],
            ['zoneId' => '1975', 'countryId' => '129', 'zoneName' => 'Melaka', 'zoneCode' => 'MY-04', 'zoneStatus' => '1'],
            ['zoneId' => '1976', 'countryId' => '129', 'zoneName' => 'Negeri Sembilan', 'zoneCode' => 'MY-05', 'zoneStatus' => '1'],
            ['zoneId' => '1977', 'countryId' => '129', 'zoneName' => 'Pahang', 'zoneCode' => 'MY-06', 'zoneStatus' => '1'],
            ['zoneId' => '1978', 'countryId' => '129', 'zoneName' => 'Perak', 'zoneCode' => 'MY-08', 'zoneStatus' => '1'],
            ['zoneId' => '1979', 'countryId' => '129', 'zoneName' => 'Perlis', 'zoneCode' => 'MY-09', 'zoneStatus' => '1'],
            ['zoneId' => '1980', 'countryId' => '129', 'zoneName' => 'Pulau Pinang', 'zoneCode' => 'MY-07', 'zoneStatus' => '1'],
            ['zoneId' => '1981', 'countryId' => '129', 'zoneName' => 'Sabah', 'zoneCode' => 'MY-12', 'zoneStatus' => '1'],
            ['zoneId' => '1982', 'countryId' => '129', 'zoneName' => 'Sarawak', 'zoneCode' => 'MY-13', 'zoneStatus' => '1'],
            ['zoneId' => '1983', 'countryId' => '129', 'zoneName' => 'Selangor', 'zoneCode' => 'MY-10', 'zoneStatus' => '1'],
            ['zoneId' => '1984', 'countryId' => '129', 'zoneName' => 'Terengganu', 'zoneCode' => 'MY-11', 'zoneStatus' => '1'],
            ['zoneId' => '1985', 'countryId' => '129', 'zoneName' => 'Kuala Lumpur', 'zoneCode' => 'MY-14', 'zoneStatus' => '1'],
            ['zoneId' => '1986', 'countryId' => '130', 'zoneName' => 'Thiladhunmathi Uthuru', 'zoneCode' => 'THU', 'zoneStatus' => '1'],
            ['zoneId' => '1987', 'countryId' => '130', 'zoneName' => 'Thiladhunmathi Dhekunu', 'zoneCode' => 'THD', 'zoneStatus' => '1'],
            ['zoneId' => '1988', 'countryId' => '130', 'zoneName' => 'Miladhunmadulu Uthuru', 'zoneCode' => 'MLU', 'zoneStatus' => '1'],
            ['zoneId' => '1989', 'countryId' => '130', 'zoneName' => 'Miladhunmadulu Dhekunu', 'zoneCode' => 'MLD', 'zoneStatus' => '1'],
            ['zoneId' => '1990', 'countryId' => '130', 'zoneName' => 'Maalhosmadulu Uthuru', 'zoneCode' => 'MAU', 'zoneStatus' => '1'],
            ['zoneId' => '1991', 'countryId' => '130', 'zoneName' => 'Maalhosmadulu Dhekunu', 'zoneCode' => 'MAD', 'zoneStatus' => '1'],
            ['zoneId' => '1992', 'countryId' => '130', 'zoneName' => 'Faadhippolhu', 'zoneCode' => 'FAA', 'zoneStatus' => '1'],
            ['zoneId' => '1993', 'countryId' => '130', 'zoneName' => 'Male Atoll', 'zoneCode' => 'MAA', 'zoneStatus' => '1'],
            ['zoneId' => '1994', 'countryId' => '130', 'zoneName' => 'Ari Atoll Uthuru', 'zoneCode' => 'AAU', 'zoneStatus' => '1'],
            ['zoneId' => '1995', 'countryId' => '130', 'zoneName' => 'Ari Atoll Dheknu', 'zoneCode' => 'AAD', 'zoneStatus' => '1'],
            ['zoneId' => '1996', 'countryId' => '130', 'zoneName' => 'Felidhe Atoll', 'zoneCode' => 'FEA', 'zoneStatus' => '1'],
            ['zoneId' => '1997', 'countryId' => '130', 'zoneName' => 'Mulaku Atoll', 'zoneCode' => 'MUA', 'zoneStatus' => '1'],
            ['zoneId' => '1998', 'countryId' => '130', 'zoneName' => 'Nilandhe Atoll Uthuru', 'zoneCode' => 'NAU', 'zoneStatus' => '1'],
            ['zoneId' => '1999', 'countryId' => '130', 'zoneName' => 'Nilandhe Atoll Dhekunu', 'zoneCode' => 'NAD', 'zoneStatus' => '1'],
            ['zoneId' => '2000', 'countryId' => '130', 'zoneName' => 'Kolhumadulu', 'zoneCode' => 'KLH', 'zoneStatus' => '1'],
            ['zoneId' => '2001', 'countryId' => '130', 'zoneName' => 'Hadhdhunmathi', 'zoneCode' => 'HDH', 'zoneStatus' => '1'],
            ['zoneId' => '2002', 'countryId' => '130', 'zoneName' => 'Huvadhu Atoll Uthuru', 'zoneCode' => 'HAU', 'zoneStatus' => '1'],
            ['zoneId' => '2003', 'countryId' => '130', 'zoneName' => 'Huvadhu Atoll Dhekunu', 'zoneCode' => 'HAD', 'zoneStatus' => '1'],
            ['zoneId' => '2004', 'countryId' => '130', 'zoneName' => 'Fua Mulaku', 'zoneCode' => 'FMU', 'zoneStatus' => '1'],
            ['zoneId' => '2005', 'countryId' => '130', 'zoneName' => 'Addu', 'zoneCode' => 'ADD', 'zoneStatus' => '1'],
            ['zoneId' => '2006', 'countryId' => '131', 'zoneName' => 'Gao', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '2007', 'countryId' => '131', 'zoneName' => 'Kayes', 'zoneCode' => 'KY', 'zoneStatus' => '1'],
            ['zoneId' => '2008', 'countryId' => '131', 'zoneName' => 'Kidal', 'zoneCode' => 'KD', 'zoneStatus' => '1'],
            ['zoneId' => '2009', 'countryId' => '131', 'zoneName' => 'Koulikoro', 'zoneCode' => 'KL', 'zoneStatus' => '1'],
            ['zoneId' => '2010', 'countryId' => '131', 'zoneName' => 'Mopti', 'zoneCode' => 'MP', 'zoneStatus' => '1'],
            ['zoneId' => '2011', 'countryId' => '131', 'zoneName' => 'Segou', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '2012', 'countryId' => '131', 'zoneName' => 'Sikasso', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '2013', 'countryId' => '131', 'zoneName' => 'Tombouctou', 'zoneCode' => 'TB', 'zoneStatus' => '1'],
            ['zoneId' => '2014', 'countryId' => '131', 'zoneName' => 'Bamako Capital District', 'zoneCode' => 'CD', 'zoneStatus' => '1'],
            ['zoneId' => '2015', 'countryId' => '132', 'zoneName' => 'Attard', 'zoneCode' => 'ATT', 'zoneStatus' => '1'],
            ['zoneId' => '2016', 'countryId' => '132', 'zoneName' => 'Balzan', 'zoneCode' => 'BAL', 'zoneStatus' => '1'],
            ['zoneId' => '2017', 'countryId' => '132', 'zoneName' => 'Birgu', 'zoneCode' => 'BGU', 'zoneStatus' => '1'],
            ['zoneId' => '2018', 'countryId' => '132', 'zoneName' => 'Birkirkara', 'zoneCode' => 'BKK', 'zoneStatus' => '1'],
            ['zoneId' => '2019', 'countryId' => '132', 'zoneName' => 'Birzebbuga', 'zoneCode' => 'BRZ', 'zoneStatus' => '1'],
            ['zoneId' => '2020', 'countryId' => '132', 'zoneName' => 'Bormla', 'zoneCode' => 'BOR', 'zoneStatus' => '1'],
            ['zoneId' => '2021', 'countryId' => '132', 'zoneName' => 'Dingli', 'zoneCode' => 'DIN', 'zoneStatus' => '1'],
            ['zoneId' => '2022', 'countryId' => '132', 'zoneName' => 'Fgura', 'zoneCode' => 'FGU', 'zoneStatus' => '1'],
            ['zoneId' => '2023', 'countryId' => '132', 'zoneName' => 'Floriana', 'zoneCode' => 'FLO', 'zoneStatus' => '1'],
            ['zoneId' => '2024', 'countryId' => '132', 'zoneName' => 'Gudja', 'zoneCode' => 'GDJ', 'zoneStatus' => '1'],
            ['zoneId' => '2025', 'countryId' => '132', 'zoneName' => 'Gzira', 'zoneCode' => 'GZR', 'zoneStatus' => '1'],
            ['zoneId' => '2026', 'countryId' => '132', 'zoneName' => 'Gargur', 'zoneCode' => 'GRG', 'zoneStatus' => '1'],
            ['zoneId' => '2027', 'countryId' => '132', 'zoneName' => 'Gaxaq', 'zoneCode' => 'GXQ', 'zoneStatus' => '1'],
            ['zoneId' => '2028', 'countryId' => '132', 'zoneName' => 'Hamrun', 'zoneCode' => 'HMR', 'zoneStatus' => '1'],
            ['zoneId' => '2029', 'countryId' => '132', 'zoneName' => 'Iklin', 'zoneCode' => 'IKL', 'zoneStatus' => '1'],
            ['zoneId' => '2030', 'countryId' => '132', 'zoneName' => 'Isla', 'zoneCode' => 'ISL', 'zoneStatus' => '1'],
            ['zoneId' => '2031', 'countryId' => '132', 'zoneName' => 'Kalkara', 'zoneCode' => 'KLK', 'zoneStatus' => '1'],
            ['zoneId' => '2032', 'countryId' => '132', 'zoneName' => 'Kirkop', 'zoneCode' => 'KRK', 'zoneStatus' => '1'],
            ['zoneId' => '2033', 'countryId' => '132', 'zoneName' => 'Lija', 'zoneCode' => 'LIJ', 'zoneStatus' => '1'],
            ['zoneId' => '2034', 'countryId' => '132', 'zoneName' => 'Luqa', 'zoneCode' => 'LUQ', 'zoneStatus' => '1'],
            ['zoneId' => '2035', 'countryId' => '132', 'zoneName' => 'Marsa', 'zoneCode' => 'MRS', 'zoneStatus' => '1'],
            ['zoneId' => '2036', 'countryId' => '132', 'zoneName' => 'Marsaskala', 'zoneCode' => 'MKL', 'zoneStatus' => '1'],
            ['zoneId' => '2037', 'countryId' => '132', 'zoneName' => 'Marsaxlokk', 'zoneCode' => 'MXL', 'zoneStatus' => '1'],
            ['zoneId' => '2038', 'countryId' => '132', 'zoneName' => 'Mdina', 'zoneCode' => 'MDN', 'zoneStatus' => '1'],
            ['zoneId' => '2039', 'countryId' => '132', 'zoneName' => 'Melliea', 'zoneCode' => 'MEL', 'zoneStatus' => '1'],
            ['zoneId' => '2040', 'countryId' => '132', 'zoneName' => 'Mgarr', 'zoneCode' => 'MGR', 'zoneStatus' => '1'],
            ['zoneId' => '2041', 'countryId' => '132', 'zoneName' => 'Mosta', 'zoneCode' => 'MST', 'zoneStatus' => '1'],
            ['zoneId' => '2042', 'countryId' => '132', 'zoneName' => 'Mqabba', 'zoneCode' => 'MQA', 'zoneStatus' => '1'],
            ['zoneId' => '2043', 'countryId' => '132', 'zoneName' => 'Msida', 'zoneCode' => 'MSI', 'zoneStatus' => '1'],
            ['zoneId' => '2044', 'countryId' => '132', 'zoneName' => 'Mtarfa', 'zoneCode' => 'MTF', 'zoneStatus' => '1'],
            ['zoneId' => '2045', 'countryId' => '132', 'zoneName' => 'Naxxar', 'zoneCode' => 'NAX', 'zoneStatus' => '1'],
            ['zoneId' => '2046', 'countryId' => '132', 'zoneName' => 'Paola', 'zoneCode' => 'PAO', 'zoneStatus' => '1'],
            ['zoneId' => '2047', 'countryId' => '132', 'zoneName' => 'Pembroke', 'zoneCode' => 'PEM', 'zoneStatus' => '1'],
            ['zoneId' => '2048', 'countryId' => '132', 'zoneName' => 'Pieta', 'zoneCode' => 'PIE', 'zoneStatus' => '1'],
            ['zoneId' => '2049', 'countryId' => '132', 'zoneName' => 'Qormi', 'zoneCode' => 'QOR', 'zoneStatus' => '1'],
            ['zoneId' => '2050', 'countryId' => '132', 'zoneName' => 'Qrendi', 'zoneCode' => 'QRE', 'zoneStatus' => '1'],
            ['zoneId' => '2051', 'countryId' => '132', 'zoneName' => 'Rabat', 'zoneCode' => 'RAB', 'zoneStatus' => '1'],
            ['zoneId' => '2052', 'countryId' => '132', 'zoneName' => 'Safi', 'zoneCode' => 'SAF', 'zoneStatus' => '1'],
            ['zoneId' => '2053', 'countryId' => '132', 'zoneName' => 'San Giljan', 'zoneCode' => 'SGI', 'zoneStatus' => '1'],
            ['zoneId' => '2054', 'countryId' => '132', 'zoneName' => 'Santa Lucija', 'zoneCode' => 'SLU', 'zoneStatus' => '1'],
            ['zoneId' => '2055', 'countryId' => '132', 'zoneName' => 'San Pawl il-Bahar', 'zoneCode' => 'SPB', 'zoneStatus' => '1'],
            ['zoneId' => '2056', 'countryId' => '132', 'zoneName' => 'San Gwann', 'zoneCode' => 'SGW', 'zoneStatus' => '1'],
            ['zoneId' => '2057', 'countryId' => '132', 'zoneName' => 'Santa Venera', 'zoneCode' => 'SVE', 'zoneStatus' => '1'],
            ['zoneId' => '2058', 'countryId' => '132', 'zoneName' => 'Siggiewi', 'zoneCode' => 'SIG', 'zoneStatus' => '1'],
            ['zoneId' => '2059', 'countryId' => '132', 'zoneName' => 'Sliema', 'zoneCode' => 'SLM', 'zoneStatus' => '1'],
            ['zoneId' => '2060', 'countryId' => '132', 'zoneName' => 'Swieqi', 'zoneCode' => 'SWQ', 'zoneStatus' => '1'],
            ['zoneId' => '2061', 'countryId' => '132', 'zoneName' => 'Ta Xbiex', 'zoneCode' => 'TXB', 'zoneStatus' => '1'],
            ['zoneId' => '2062', 'countryId' => '132', 'zoneName' => 'Tarxien', 'zoneCode' => 'TRX', 'zoneStatus' => '1'],
            ['zoneId' => '2063', 'countryId' => '132', 'zoneName' => 'Valletta', 'zoneCode' => 'VLT', 'zoneStatus' => '1'],
            ['zoneId' => '2064', 'countryId' => '132', 'zoneName' => 'Xgajra', 'zoneCode' => 'XGJ', 'zoneStatus' => '1'],
            ['zoneId' => '2065', 'countryId' => '132', 'zoneName' => 'Zabbar', 'zoneCode' => 'ZBR', 'zoneStatus' => '1'],
            ['zoneId' => '2066', 'countryId' => '132', 'zoneName' => 'Zebbug', 'zoneCode' => 'ZBG', 'zoneStatus' => '1'],
            ['zoneId' => '2067', 'countryId' => '132', 'zoneName' => 'Zejtun', 'zoneCode' => 'ZJT', 'zoneStatus' => '1'],
            ['zoneId' => '2068', 'countryId' => '132', 'zoneName' => 'Zurrieq', 'zoneCode' => 'ZRQ', 'zoneStatus' => '1'],
            ['zoneId' => '2069', 'countryId' => '132', 'zoneName' => 'Fontana', 'zoneCode' => 'FNT', 'zoneStatus' => '1'],
            ['zoneId' => '2070', 'countryId' => '132', 'zoneName' => 'Ghajnsielem', 'zoneCode' => 'GHJ', 'zoneStatus' => '1'],
            ['zoneId' => '2071', 'countryId' => '132', 'zoneName' => 'Gharb', 'zoneCode' => 'GHR', 'zoneStatus' => '1'],
            ['zoneId' => '2072', 'countryId' => '132', 'zoneName' => 'Ghasri', 'zoneCode' => 'GHS', 'zoneStatus' => '1'],
            ['zoneId' => '2073', 'countryId' => '132', 'zoneName' => 'Kercem', 'zoneCode' => 'KRC', 'zoneStatus' => '1'],
            ['zoneId' => '2074', 'countryId' => '132', 'zoneName' => 'Munxar', 'zoneCode' => 'MUN', 'zoneStatus' => '1'],
            ['zoneId' => '2075', 'countryId' => '132', 'zoneName' => 'Nadur', 'zoneCode' => 'NAD', 'zoneStatus' => '1'],
            ['zoneId' => '2076', 'countryId' => '132', 'zoneName' => 'Qala', 'zoneCode' => 'QAL', 'zoneStatus' => '1'],
            ['zoneId' => '2077', 'countryId' => '132', 'zoneName' => 'Victoria', 'zoneCode' => 'VIC', 'zoneStatus' => '1'],
            ['zoneId' => '2078', 'countryId' => '132', 'zoneName' => 'San Lawrenz', 'zoneCode' => 'SLA', 'zoneStatus' => '1'],
            ['zoneId' => '2079', 'countryId' => '132', 'zoneName' => 'Sannat', 'zoneCode' => 'SNT', 'zoneStatus' => '1'],
            ['zoneId' => '2080', 'countryId' => '132', 'zoneName' => 'Xagra', 'zoneCode' => 'ZAG', 'zoneStatus' => '1'],
            ['zoneId' => '2081', 'countryId' => '132', 'zoneName' => 'Xewkija', 'zoneCode' => 'XEW', 'zoneStatus' => '1'],
            ['zoneId' => '2082', 'countryId' => '132', 'zoneName' => 'Zebbug', 'zoneCode' => 'ZEB', 'zoneStatus' => '1'],
            ['zoneId' => '2083', 'countryId' => '133', 'zoneName' => 'Ailinginae', 'zoneCode' => 'ALG', 'zoneStatus' => '1'],
            ['zoneId' => '2084', 'countryId' => '133', 'zoneName' => 'Ailinglaplap', 'zoneCode' => 'ALL', 'zoneStatus' => '1'],
            ['zoneId' => '2085', 'countryId' => '133', 'zoneName' => 'Ailuk', 'zoneCode' => 'ALK', 'zoneStatus' => '1'],
            ['zoneId' => '2086', 'countryId' => '133', 'zoneName' => 'Arno', 'zoneCode' => 'ARN', 'zoneStatus' => '1'],
            ['zoneId' => '2087', 'countryId' => '133', 'zoneName' => 'Aur', 'zoneCode' => 'AUR', 'zoneStatus' => '1'],
            ['zoneId' => '2088', 'countryId' => '133', 'zoneName' => 'Bikar', 'zoneCode' => 'BKR', 'zoneStatus' => '1'],
            ['zoneId' => '2089', 'countryId' => '133', 'zoneName' => 'Bikini', 'zoneCode' => 'BKN', 'zoneStatus' => '1'],
            ['zoneId' => '2090', 'countryId' => '133', 'zoneName' => 'Bokak', 'zoneCode' => 'BKK', 'zoneStatus' => '1'],
            ['zoneId' => '2091', 'countryId' => '133', 'zoneName' => 'Ebon', 'zoneCode' => 'EBN', 'zoneStatus' => '1'],
            ['zoneId' => '2092', 'countryId' => '133', 'zoneName' => 'Enewetak', 'zoneCode' => 'ENT', 'zoneStatus' => '1'],
            ['zoneId' => '2093', 'countryId' => '133', 'zoneName' => 'Erikub', 'zoneCode' => 'EKB', 'zoneStatus' => '1'],
            ['zoneId' => '2094', 'countryId' => '133', 'zoneName' => 'Jabat', 'zoneCode' => 'JBT', 'zoneStatus' => '1'],
            ['zoneId' => '2095', 'countryId' => '133', 'zoneName' => 'Jaluit', 'zoneCode' => 'JLT', 'zoneStatus' => '1'],
            ['zoneId' => '2096', 'countryId' => '133', 'zoneName' => 'Jemo', 'zoneCode' => 'JEM', 'zoneStatus' => '1'],
            ['zoneId' => '2097', 'countryId' => '133', 'zoneName' => 'Kili', 'zoneCode' => 'KIL', 'zoneStatus' => '1'],
            ['zoneId' => '2098', 'countryId' => '133', 'zoneName' => 'Kwajalein', 'zoneCode' => 'KWJ', 'zoneStatus' => '1'],
            ['zoneId' => '2099', 'countryId' => '133', 'zoneName' => 'Lae', 'zoneCode' => 'LAE', 'zoneStatus' => '1'],
            ['zoneId' => '2100', 'countryId' => '133', 'zoneName' => 'Lib', 'zoneCode' => 'LIB', 'zoneStatus' => '1'],
            ['zoneId' => '2101', 'countryId' => '133', 'zoneName' => 'Likiep', 'zoneCode' => 'LKP', 'zoneStatus' => '1'],
            ['zoneId' => '2102', 'countryId' => '133', 'zoneName' => 'Majuro', 'zoneCode' => 'MJR', 'zoneStatus' => '1'],
            ['zoneId' => '2103', 'countryId' => '133', 'zoneName' => 'Maloelap', 'zoneCode' => 'MLP', 'zoneStatus' => '1'],
            ['zoneId' => '2104', 'countryId' => '133', 'zoneName' => 'Mejit', 'zoneCode' => 'MJT', 'zoneStatus' => '1'],
            ['zoneId' => '2105', 'countryId' => '133', 'zoneName' => 'Mili', 'zoneCode' => 'MIL', 'zoneStatus' => '1'],
            ['zoneId' => '2106', 'countryId' => '133', 'zoneName' => 'Namorik', 'zoneCode' => 'NMK', 'zoneStatus' => '1'],
            ['zoneId' => '2107', 'countryId' => '133', 'zoneName' => 'Namu', 'zoneCode' => 'NAM', 'zoneStatus' => '1'],
            ['zoneId' => '2108', 'countryId' => '133', 'zoneName' => 'Rongelap', 'zoneCode' => 'RGL', 'zoneStatus' => '1'],
            ['zoneId' => '2109', 'countryId' => '133', 'zoneName' => 'Rongrik', 'zoneCode' => 'RGK', 'zoneStatus' => '1'],
            ['zoneId' => '2110', 'countryId' => '133', 'zoneName' => 'Toke', 'zoneCode' => 'TOK', 'zoneStatus' => '1'],
            ['zoneId' => '2111', 'countryId' => '133', 'zoneName' => 'Ujae', 'zoneCode' => 'UJA', 'zoneStatus' => '1'],
            ['zoneId' => '2112', 'countryId' => '133', 'zoneName' => 'Ujelang', 'zoneCode' => 'UJL', 'zoneStatus' => '1'],
            ['zoneId' => '2113', 'countryId' => '133', 'zoneName' => 'Utirik', 'zoneCode' => 'UTK', 'zoneStatus' => '1'],
            ['zoneId' => '2114', 'countryId' => '133', 'zoneName' => 'Wotho', 'zoneCode' => 'WTH', 'zoneStatus' => '1'],
            ['zoneId' => '2115', 'countryId' => '133', 'zoneName' => 'Wotje', 'zoneCode' => 'WTJ', 'zoneStatus' => '1'],
            ['zoneId' => '2116', 'countryId' => '135', 'zoneName' => 'Adrar', 'zoneCode' => 'AD', 'zoneStatus' => '1'],
            ['zoneId' => '2117', 'countryId' => '135', 'zoneName' => 'Assaba', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '2118', 'countryId' => '135', 'zoneName' => 'Brakna', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '2119', 'countryId' => '135', 'zoneName' => 'Dakhlet Nouadhibou', 'zoneCode' => 'DN', 'zoneStatus' => '1'],
            ['zoneId' => '2120', 'countryId' => '135', 'zoneName' => 'Gorgol', 'zoneCode' => 'GO', 'zoneStatus' => '1'],
            ['zoneId' => '2121', 'countryId' => '135', 'zoneName' => 'Guidimaka', 'zoneCode' => 'GM', 'zoneStatus' => '1'],
            ['zoneId' => '2122', 'countryId' => '135', 'zoneName' => 'Hodh Ech Chargui', 'zoneCode' => 'HC', 'zoneStatus' => '1'],
            ['zoneId' => '2123', 'countryId' => '135', 'zoneName' => 'Hodh El Gharbi', 'zoneCode' => 'HG', 'zoneStatus' => '1'],
            ['zoneId' => '2124', 'countryId' => '135', 'zoneName' => 'Inchiri', 'zoneCode' => 'IN', 'zoneStatus' => '1'],
            ['zoneId' => '2125', 'countryId' => '135', 'zoneName' => 'Tagant', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '2126', 'countryId' => '135', 'zoneName' => 'Tiris Zemmour', 'zoneCode' => 'TZ', 'zoneStatus' => '1'],
            ['zoneId' => '2127', 'countryId' => '135', 'zoneName' => 'Trarza', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '2128', 'countryId' => '135', 'zoneName' => 'Nouakchott', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '2129', 'countryId' => '136', 'zoneName' => 'Beau Bassin-Rose Hill', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '2130', 'countryId' => '136', 'zoneName' => 'Curepipe', 'zoneCode' => 'CU', 'zoneStatus' => '1'],
            ['zoneId' => '2131', 'countryId' => '136', 'zoneName' => 'Port Louis', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '2132', 'countryId' => '136', 'zoneName' => 'Quatre Bornes', 'zoneCode' => 'QB', 'zoneStatus' => '1'],
            ['zoneId' => '2133', 'countryId' => '136', 'zoneName' => 'Vacoas-Phoenix', 'zoneCode' => 'VP', 'zoneStatus' => '1'],
            ['zoneId' => '2134', 'countryId' => '136', 'zoneName' => 'Agalega Islands', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '2135', 'countryId' => '136', 'zoneName' => 'Cargados Carajos Shoals (Saint Brandon Islands)', 'zoneCode' => 'CC', 'zoneStatus' => '1'],
            ['zoneId' => '2136', 'countryId' => '136', 'zoneName' => 'Rodrigues', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '2137', 'countryId' => '136', 'zoneName' => 'Black River', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '2138', 'countryId' => '136', 'zoneName' => 'Flacq', 'zoneCode' => 'FL', 'zoneStatus' => '1'],
            ['zoneId' => '2139', 'countryId' => '136', 'zoneName' => 'Grand Port', 'zoneCode' => 'GP', 'zoneStatus' => '1'],
            ['zoneId' => '2140', 'countryId' => '136', 'zoneName' => 'Moka', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '2141', 'countryId' => '136', 'zoneName' => 'Pamplemousses', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '2142', 'countryId' => '136', 'zoneName' => 'Plaines Wilhems', 'zoneCode' => 'PW', 'zoneStatus' => '1'],
            ['zoneId' => '2143', 'countryId' => '136', 'zoneName' => 'Port Louis', 'zoneCode' => 'PL', 'zoneStatus' => '1'],
            ['zoneId' => '2144', 'countryId' => '136', 'zoneName' => 'Riviere du Rempart', 'zoneCode' => 'RR', 'zoneStatus' => '1'],
            ['zoneId' => '2145', 'countryId' => '136', 'zoneName' => 'Savanne', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2146', 'countryId' => '138', 'zoneName' => 'Baja California Norte', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '2147', 'countryId' => '138', 'zoneName' => 'Baja California Sur', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '2148', 'countryId' => '138', 'zoneName' => 'Campeche', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '2149', 'countryId' => '138', 'zoneName' => 'Chiapas', 'zoneCode' => 'CI', 'zoneStatus' => '1'],
            ['zoneId' => '2150', 'countryId' => '138', 'zoneName' => 'Chihuahua', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2151', 'countryId' => '138', 'zoneName' => 'Coahuila de Zaragoza', 'zoneCode' => 'CZ', 'zoneStatus' => '1'],
            ['zoneId' => '2152', 'countryId' => '138', 'zoneName' => 'Colima', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '2153', 'countryId' => '138', 'zoneName' => 'Distrito Federal', 'zoneCode' => 'DF', 'zoneStatus' => '1'],
            ['zoneId' => '2154', 'countryId' => '138', 'zoneName' => 'Durango', 'zoneCode' => 'DU', 'zoneStatus' => '1'],
            ['zoneId' => '2155', 'countryId' => '138', 'zoneName' => 'Guanajuato', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '2156', 'countryId' => '138', 'zoneName' => 'Guerrero', 'zoneCode' => 'GE', 'zoneStatus' => '1'],
            ['zoneId' => '2157', 'countryId' => '138', 'zoneName' => 'Hidalgo', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '2158', 'countryId' => '138', 'zoneName' => 'Jalisco', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '2159', 'countryId' => '138', 'zoneName' => 'Mexico', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '2160', 'countryId' => '138', 'zoneName' => 'Michoacan de Ocampo', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '2161', 'countryId' => '138', 'zoneName' => 'Morelos', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '2162', 'countryId' => '138', 'zoneName' => 'Nayarit', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '2163', 'countryId' => '138', 'zoneName' => 'Nuevo Leon', 'zoneCode' => 'NL', 'zoneStatus' => '1'],
            ['zoneId' => '2164', 'countryId' => '138', 'zoneName' => 'Oaxaca', 'zoneCode' => 'OA', 'zoneStatus' => '1'],
            ['zoneId' => '2165', 'countryId' => '138', 'zoneName' => 'Puebla', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '2166', 'countryId' => '138', 'zoneName' => 'Queretaro de Arteaga', 'zoneCode' => 'QA', 'zoneStatus' => '1'],
            ['zoneId' => '2167', 'countryId' => '138', 'zoneName' => 'Quintana Roo', 'zoneCode' => 'QR', 'zoneStatus' => '1'],
            ['zoneId' => '2168', 'countryId' => '138', 'zoneName' => 'San Luis Potosi', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2169', 'countryId' => '138', 'zoneName' => 'Sinaloa', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '2170', 'countryId' => '138', 'zoneName' => 'Sonora', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '2171', 'countryId' => '138', 'zoneName' => 'Tabasco', 'zoneCode' => 'TB', 'zoneStatus' => '1'],
            ['zoneId' => '2172', 'countryId' => '138', 'zoneName' => 'Tamaulipas', 'zoneCode' => 'TM', 'zoneStatus' => '1'],
            ['zoneId' => '2173', 'countryId' => '138', 'zoneName' => 'Tlaxcala', 'zoneCode' => 'TL', 'zoneStatus' => '1'],
            ['zoneId' => '2174', 'countryId' => '138', 'zoneName' => 'Veracruz-Llave', 'zoneCode' => 'VE', 'zoneStatus' => '1'],
            ['zoneId' => '2175', 'countryId' => '138', 'zoneName' => 'Yucatan', 'zoneCode' => 'YU', 'zoneStatus' => '1'],
            ['zoneId' => '2176', 'countryId' => '138', 'zoneName' => 'Zacatecas', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '2177', 'countryId' => '139', 'zoneName' => 'Chuuk', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '2178', 'countryId' => '139', 'zoneName' => 'Kosrae', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '2179', 'countryId' => '139', 'zoneName' => 'Pohnpei', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '2180', 'countryId' => '139', 'zoneName' => 'Yap', 'zoneCode' => 'Y', 'zoneStatus' => '1'],
            ['zoneId' => '2181', 'countryId' => '140', 'zoneName' => 'Gagauzia', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '2182', 'countryId' => '140', 'zoneName' => 'Chisinau', 'zoneCode' => 'CU', 'zoneStatus' => '1'],
            ['zoneId' => '2183', 'countryId' => '140', 'zoneName' => 'Balti', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2184', 'countryId' => '140', 'zoneName' => 'Cahul', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '2185', 'countryId' => '140', 'zoneName' => 'Edinet', 'zoneCode' => 'ED', 'zoneStatus' => '1'],
            ['zoneId' => '2186', 'countryId' => '140', 'zoneName' => 'Lapusna', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '2187', 'countryId' => '140', 'zoneName' => 'Orhei', 'zoneCode' => 'OR', 'zoneStatus' => '1'],
            ['zoneId' => '2188', 'countryId' => '140', 'zoneName' => 'Soroca', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '2189', 'countryId' => '140', 'zoneName' => 'Tighina', 'zoneCode' => 'TI', 'zoneStatus' => '1'],
            ['zoneId' => '2190', 'countryId' => '140', 'zoneName' => 'Ungheni', 'zoneCode' => 'UN', 'zoneStatus' => '1'],
            ['zoneId' => '2191', 'countryId' => '140', 'zoneName' => 'St‚nga Nistrului', 'zoneCode' => 'SN', 'zoneStatus' => '1'],
            ['zoneId' => '2192', 'countryId' => '141', 'zoneName' => 'Fontvieille', 'zoneCode' => 'FV', 'zoneStatus' => '1'],
            ['zoneId' => '2193', 'countryId' => '141', 'zoneName' => 'La Condamine', 'zoneCode' => 'LC', 'zoneStatus' => '1'],
            ['zoneId' => '2194', 'countryId' => '141', 'zoneName' => 'Monaco-Ville', 'zoneCode' => 'MV', 'zoneStatus' => '1'],
            ['zoneId' => '2195', 'countryId' => '141', 'zoneName' => 'Monte-Carlo', 'zoneCode' => 'MC', 'zoneStatus' => '1'],
            ['zoneId' => '2196', 'countryId' => '142', 'zoneName' => 'Ulanbaatar', 'zoneCode' => '1', 'zoneStatus' => '1'],
            ['zoneId' => '2197', 'countryId' => '142', 'zoneName' => 'Orhon', 'zoneCode' => '035', 'zoneStatus' => '1'],
            ['zoneId' => '2198', 'countryId' => '142', 'zoneName' => 'Darhan uul', 'zoneCode' => '037', 'zoneStatus' => '1'],
            ['zoneId' => '2199', 'countryId' => '142', 'zoneName' => 'Hentiy', 'zoneCode' => '039', 'zoneStatus' => '1'],
            ['zoneId' => '2200', 'countryId' => '142', 'zoneName' => 'Hovsgol', 'zoneCode' => '041', 'zoneStatus' => '1'],
            ['zoneId' => '2201', 'countryId' => '142', 'zoneName' => 'Hovd', 'zoneCode' => '043', 'zoneStatus' => '1'],
            ['zoneId' => '2202', 'countryId' => '142', 'zoneName' => 'Uvs', 'zoneCode' => '046', 'zoneStatus' => '1'],
            ['zoneId' => '2203', 'countryId' => '142', 'zoneName' => 'Tov', 'zoneCode' => '047', 'zoneStatus' => '1'],
            ['zoneId' => '2204', 'countryId' => '142', 'zoneName' => 'Selenge', 'zoneCode' => '049', 'zoneStatus' => '1'],
            ['zoneId' => '2205', 'countryId' => '142', 'zoneName' => 'Suhbaatar', 'zoneCode' => '051', 'zoneStatus' => '1'],
            ['zoneId' => '2206', 'countryId' => '142', 'zoneName' => 'Omnogovi', 'zoneCode' => '053', 'zoneStatus' => '1'],
            ['zoneId' => '2207', 'countryId' => '142', 'zoneName' => 'Ovorhangay', 'zoneCode' => '055', 'zoneStatus' => '1'],
            ['zoneId' => '2208', 'countryId' => '142', 'zoneName' => 'Dzavhan', 'zoneCode' => '057', 'zoneStatus' => '1'],
            ['zoneId' => '2209', 'countryId' => '142', 'zoneName' => 'DundgovL', 'zoneCode' => '059', 'zoneStatus' => '1'],
            ['zoneId' => '2210', 'countryId' => '142', 'zoneName' => 'Dornod', 'zoneCode' => '061', 'zoneStatus' => '1'],
            ['zoneId' => '2211', 'countryId' => '142', 'zoneName' => 'Dornogov', 'zoneCode' => '063', 'zoneStatus' => '1'],
            ['zoneId' => '2212', 'countryId' => '142', 'zoneName' => 'Govi-Sumber', 'zoneCode' => '064', 'zoneStatus' => '1'],
            ['zoneId' => '2213', 'countryId' => '142', 'zoneName' => 'Govi-Altay', 'zoneCode' => '065', 'zoneStatus' => '1'],
            ['zoneId' => '2214', 'countryId' => '142', 'zoneName' => 'Bulgan', 'zoneCode' => '067', 'zoneStatus' => '1'],
            ['zoneId' => '2215', 'countryId' => '142', 'zoneName' => 'Bayanhongor', 'zoneCode' => '069', 'zoneStatus' => '1'],
            ['zoneId' => '2216', 'countryId' => '142', 'zoneName' => 'Bayan-Olgiy', 'zoneCode' => '071', 'zoneStatus' => '1'],
            ['zoneId' => '2217', 'countryId' => '142', 'zoneName' => 'Arhangay', 'zoneCode' => '073', 'zoneStatus' => '1'],
            ['zoneId' => '2218', 'countryId' => '143', 'zoneName' => 'Saint Anthony', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '2219', 'countryId' => '143', 'zoneName' => 'Saint Georges', 'zoneCode' => 'G', 'zoneStatus' => '1'],
            ['zoneId' => '2220', 'countryId' => '143', 'zoneName' => 'Saint Peter', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '2221', 'countryId' => '144', 'zoneName' => 'Agadir', 'zoneCode' => 'AGD', 'zoneStatus' => '1'],
            ['zoneId' => '2222', 'countryId' => '144', 'zoneName' => 'Al Hoceima', 'zoneCode' => 'HOC', 'zoneStatus' => '1'],
            ['zoneId' => '2223', 'countryId' => '144', 'zoneName' => 'Azilal', 'zoneCode' => 'AZI', 'zoneStatus' => '1'],
            ['zoneId' => '2224', 'countryId' => '144', 'zoneName' => 'Beni Mellal', 'zoneCode' => 'BME', 'zoneStatus' => '1'],
            ['zoneId' => '2225', 'countryId' => '144', 'zoneName' => 'Ben Slimane', 'zoneCode' => 'BSL', 'zoneStatus' => '1'],
            ['zoneId' => '2226', 'countryId' => '144', 'zoneName' => 'Boulemane', 'zoneCode' => 'BLM', 'zoneStatus' => '1'],
            ['zoneId' => '2227', 'countryId' => '144', 'zoneName' => 'Casablanca', 'zoneCode' => 'CBL', 'zoneStatus' => '1'],
            ['zoneId' => '2228', 'countryId' => '144', 'zoneName' => 'Chaouen', 'zoneCode' => 'CHA', 'zoneStatus' => '1'],
            ['zoneId' => '2229', 'countryId' => '144', 'zoneName' => 'El Jadida', 'zoneCode' => 'EJA', 'zoneStatus' => '1'],
            ['zoneId' => '2230', 'countryId' => '144', 'zoneName' => 'El Kelaa des Sraghna', 'zoneCode' => 'EKS', 'zoneStatus' => '1'],
            ['zoneId' => '2231', 'countryId' => '144', 'zoneName' => 'Er Rachidia', 'zoneCode' => 'ERA', 'zoneStatus' => '1'],
            ['zoneId' => '2232', 'countryId' => '144', 'zoneName' => 'Essaouira', 'zoneCode' => 'ESS', 'zoneStatus' => '1'],
            ['zoneId' => '2233', 'countryId' => '144', 'zoneName' => 'Fes', 'zoneCode' => 'FES', 'zoneStatus' => '1'],
            ['zoneId' => '2234', 'countryId' => '144', 'zoneName' => 'Figuig', 'zoneCode' => 'FIG', 'zoneStatus' => '1'],
            ['zoneId' => '2235', 'countryId' => '144', 'zoneName' => 'Guelmim', 'zoneCode' => 'GLM', 'zoneStatus' => '1'],
            ['zoneId' => '2236', 'countryId' => '144', 'zoneName' => 'Ifrane', 'zoneCode' => 'IFR', 'zoneStatus' => '1'],
            ['zoneId' => '2237', 'countryId' => '144', 'zoneName' => 'Kenitra', 'zoneCode' => 'KEN', 'zoneStatus' => '1'],
            ['zoneId' => '2238', 'countryId' => '144', 'zoneName' => 'Khemisset', 'zoneCode' => 'KHM', 'zoneStatus' => '1'],
            ['zoneId' => '2239', 'countryId' => '144', 'zoneName' => 'Khenifra', 'zoneCode' => 'KHN', 'zoneStatus' => '1'],
            ['zoneId' => '2240', 'countryId' => '144', 'zoneName' => 'Khouribga', 'zoneCode' => 'KHO', 'zoneStatus' => '1'],
            ['zoneId' => '2241', 'countryId' => '144', 'zoneName' => 'Laayoune', 'zoneCode' => 'LYN', 'zoneStatus' => '1'],
            ['zoneId' => '2242', 'countryId' => '144', 'zoneName' => 'Larache', 'zoneCode' => 'LAR', 'zoneStatus' => '1'],
            ['zoneId' => '2243', 'countryId' => '144', 'zoneName' => 'Marrakech', 'zoneCode' => 'MRK', 'zoneStatus' => '1'],
            ['zoneId' => '2244', 'countryId' => '144', 'zoneName' => 'Meknes', 'zoneCode' => 'MKN', 'zoneStatus' => '1'],
            ['zoneId' => '2245', 'countryId' => '144', 'zoneName' => 'Nador', 'zoneCode' => 'NAD', 'zoneStatus' => '1'],
            ['zoneId' => '2246', 'countryId' => '144', 'zoneName' => 'Ouarzazate', 'zoneCode' => 'ORZ', 'zoneStatus' => '1'],
            ['zoneId' => '2247', 'countryId' => '144', 'zoneName' => 'Oujda', 'zoneCode' => 'OUJ', 'zoneStatus' => '1'],
            ['zoneId' => '2248', 'countryId' => '144', 'zoneName' => 'Rabat-Sale', 'zoneCode' => 'RSA', 'zoneStatus' => '1'],
            ['zoneId' => '2249', 'countryId' => '144', 'zoneName' => 'Safi', 'zoneCode' => 'SAF', 'zoneStatus' => '1'],
            ['zoneId' => '2250', 'countryId' => '144', 'zoneName' => 'Settat', 'zoneCode' => 'SET', 'zoneStatus' => '1'],
            ['zoneId' => '2251', 'countryId' => '144', 'zoneName' => 'Sidi Kacem', 'zoneCode' => 'SKA', 'zoneStatus' => '1'],
            ['zoneId' => '2252', 'countryId' => '144', 'zoneName' => 'Tangier', 'zoneCode' => 'TGR', 'zoneStatus' => '1'],
            ['zoneId' => '2253', 'countryId' => '144', 'zoneName' => 'Tan-Tan', 'zoneCode' => 'TAN', 'zoneStatus' => '1'],
            ['zoneId' => '2254', 'countryId' => '144', 'zoneName' => 'Taounate', 'zoneCode' => 'TAO', 'zoneStatus' => '1'],
            ['zoneId' => '2255', 'countryId' => '144', 'zoneName' => 'Taroudannt', 'zoneCode' => 'TRD', 'zoneStatus' => '1'],
            ['zoneId' => '2256', 'countryId' => '144', 'zoneName' => 'Tata', 'zoneCode' => 'TAT', 'zoneStatus' => '1'],
            ['zoneId' => '2257', 'countryId' => '144', 'zoneName' => 'Taza', 'zoneCode' => 'TAZ', 'zoneStatus' => '1'],
            ['zoneId' => '2258', 'countryId' => '144', 'zoneName' => 'Tetouan', 'zoneCode' => 'TET', 'zoneStatus' => '1'],
            ['zoneId' => '2259', 'countryId' => '144', 'zoneName' => 'Tiznit', 'zoneCode' => 'TIZ', 'zoneStatus' => '1'],
            ['zoneId' => '2260', 'countryId' => '144', 'zoneName' => 'Ad Dakhla', 'zoneCode' => 'ADK', 'zoneStatus' => '1'],
            ['zoneId' => '2261', 'countryId' => '144', 'zoneName' => 'Boujdour', 'zoneCode' => 'BJD', 'zoneStatus' => '1'],
            ['zoneId' => '2262', 'countryId' => '144', 'zoneName' => 'Es Smara', 'zoneCode' => 'ESM', 'zoneStatus' => '1'],
            ['zoneId' => '2263', 'countryId' => '145', 'zoneName' => 'Cabo Delgado', 'zoneCode' => 'CD', 'zoneStatus' => '1'],
            ['zoneId' => '2264', 'countryId' => '145', 'zoneName' => 'Gaza', 'zoneCode' => 'GZ', 'zoneStatus' => '1'],
            ['zoneId' => '2265', 'countryId' => '145', 'zoneName' => 'Inhambane', 'zoneCode' => 'IN', 'zoneStatus' => '1'],
            ['zoneId' => '2266', 'countryId' => '145', 'zoneName' => 'Manica', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '2267', 'countryId' => '145', 'zoneName' => 'Maputo (city)', 'zoneCode' => 'MC', 'zoneStatus' => '1'],
            ['zoneId' => '2268', 'countryId' => '145', 'zoneName' => 'Maputo', 'zoneCode' => 'MP', 'zoneStatus' => '1'],
            ['zoneId' => '2269', 'countryId' => '145', 'zoneName' => 'Nampula', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '2270', 'countryId' => '145', 'zoneName' => 'Niassa', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '2271', 'countryId' => '145', 'zoneName' => 'Sofala', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '2272', 'countryId' => '145', 'zoneName' => 'Tete', 'zoneCode' => 'TE', 'zoneStatus' => '1'],
            ['zoneId' => '2273', 'countryId' => '145', 'zoneName' => 'Zambezia', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '2274', 'countryId' => '146', 'zoneName' => 'Ayeyarwady', 'zoneCode' => 'AY', 'zoneStatus' => '1'],
            ['zoneId' => '2275', 'countryId' => '146', 'zoneName' => 'Bago', 'zoneCode' => 'BG', 'zoneStatus' => '1'],
            ['zoneId' => '2276', 'countryId' => '146', 'zoneName' => 'Magway', 'zoneCode' => 'MG', 'zoneStatus' => '1'],
            ['zoneId' => '2277', 'countryId' => '146', 'zoneName' => 'Mandalay', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '2278', 'countryId' => '146', 'zoneName' => 'Sagaing', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '2279', 'countryId' => '146', 'zoneName' => 'Tanintharyi', 'zoneCode' => 'TN', 'zoneStatus' => '1'],
            ['zoneId' => '2280', 'countryId' => '146', 'zoneName' => 'Yangon', 'zoneCode' => 'YG', 'zoneStatus' => '1'],
            ['zoneId' => '2281', 'countryId' => '146', 'zoneName' => 'Chin State', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2282', 'countryId' => '146', 'zoneName' => 'Kachin State', 'zoneCode' => 'KC', 'zoneStatus' => '1'],
            ['zoneId' => '2283', 'countryId' => '146', 'zoneName' => 'Kayah State', 'zoneCode' => 'KH', 'zoneStatus' => '1'],
            ['zoneId' => '2284', 'countryId' => '146', 'zoneName' => 'Kayin State', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '2285', 'countryId' => '146', 'zoneName' => 'Mon State', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '2286', 'countryId' => '146', 'zoneName' => 'Rakhine State', 'zoneCode' => 'RK', 'zoneStatus' => '1'],
            ['zoneId' => '2287', 'countryId' => '146', 'zoneName' => 'Shan State', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '2288', 'countryId' => '147', 'zoneName' => 'Caprivi', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '2289', 'countryId' => '147', 'zoneName' => 'Erongo', 'zoneCode' => 'ER', 'zoneStatus' => '1'],
            ['zoneId' => '2290', 'countryId' => '147', 'zoneName' => 'Hardap', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '2291', 'countryId' => '147', 'zoneName' => 'Karas', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '2292', 'countryId' => '147', 'zoneName' => 'Kavango', 'zoneCode' => 'KV', 'zoneStatus' => '1'],
            ['zoneId' => '2293', 'countryId' => '147', 'zoneName' => 'Khomas', 'zoneCode' => 'KH', 'zoneStatus' => '1'],
            ['zoneId' => '2294', 'countryId' => '147', 'zoneName' => 'Kunene', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '2295', 'countryId' => '147', 'zoneName' => 'Ohangwena', 'zoneCode' => 'OW', 'zoneStatus' => '1'],
            ['zoneId' => '2296', 'countryId' => '147', 'zoneName' => 'Omaheke', 'zoneCode' => 'OK', 'zoneStatus' => '1'],
            ['zoneId' => '2297', 'countryId' => '147', 'zoneName' => 'Omusati', 'zoneCode' => 'OT', 'zoneStatus' => '1'],
            ['zoneId' => '2298', 'countryId' => '147', 'zoneName' => 'Oshana', 'zoneCode' => 'ON', 'zoneStatus' => '1'],
            ['zoneId' => '2299', 'countryId' => '147', 'zoneName' => 'Oshikoto', 'zoneCode' => 'OO', 'zoneStatus' => '1'],
            ['zoneId' => '2300', 'countryId' => '147', 'zoneName' => 'Otjozondjupa', 'zoneCode' => 'OJ', 'zoneStatus' => '1'],
            ['zoneId' => '2301', 'countryId' => '148', 'zoneName' => 'Aiwo', 'zoneCode' => 'AO', 'zoneStatus' => '1'],
            ['zoneId' => '2302', 'countryId' => '148', 'zoneName' => 'Anabar', 'zoneCode' => 'AA', 'zoneStatus' => '1'],
            ['zoneId' => '2303', 'countryId' => '148', 'zoneName' => 'Anetan', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '2304', 'countryId' => '148', 'zoneName' => 'Anibare', 'zoneCode' => 'AI', 'zoneStatus' => '1'],
            ['zoneId' => '2305', 'countryId' => '148', 'zoneName' => 'Baiti', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2306', 'countryId' => '148', 'zoneName' => 'Boe', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '2307', 'countryId' => '148', 'zoneName' => 'Buada', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '2308', 'countryId' => '148', 'zoneName' => 'Denigomodu', 'zoneCode' => 'DE', 'zoneStatus' => '1'],
            ['zoneId' => '2309', 'countryId' => '148', 'zoneName' => 'Ewa', 'zoneCode' => 'EW', 'zoneStatus' => '1'],
            ['zoneId' => '2310', 'countryId' => '148', 'zoneName' => 'Ijuw', 'zoneCode' => 'IJ', 'zoneStatus' => '1'],
            ['zoneId' => '2311', 'countryId' => '148', 'zoneName' => 'Meneng', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '2312', 'countryId' => '148', 'zoneName' => 'Nibok', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '2313', 'countryId' => '148', 'zoneName' => 'Uaboe', 'zoneCode' => 'UA', 'zoneStatus' => '1'],
            ['zoneId' => '2314', 'countryId' => '148', 'zoneName' => 'Yaren', 'zoneCode' => 'YA', 'zoneStatus' => '1'],
            ['zoneId' => '2315', 'countryId' => '149', 'zoneName' => 'Bagmati', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2316', 'countryId' => '149', 'zoneName' => 'Bheri', 'zoneCode' => 'BH', 'zoneStatus' => '1'],
            ['zoneId' => '2317', 'countryId' => '149', 'zoneName' => 'Dhawalagiri', 'zoneCode' => 'DH', 'zoneStatus' => '1'],
            ['zoneId' => '2318', 'countryId' => '149', 'zoneName' => 'Gandaki', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '2319', 'countryId' => '149', 'zoneName' => 'Janakpur', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '2320', 'countryId' => '149', 'zoneName' => 'Karnali', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '2321', 'countryId' => '149', 'zoneName' => 'Kosi', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '2322', 'countryId' => '149', 'zoneName' => 'Lumbini', 'zoneCode' => 'LU', 'zoneStatus' => '1'],
            ['zoneId' => '2323', 'countryId' => '149', 'zoneName' => 'Mahakali', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '2324', 'countryId' => '149', 'zoneName' => 'Mechi', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '2325', 'countryId' => '149', 'zoneName' => 'Narayani', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '2326', 'countryId' => '149', 'zoneName' => 'Rapti', 'zoneCode' => 'RA', 'zoneStatus' => '1'],
            ['zoneId' => '2327', 'countryId' => '149', 'zoneName' => 'Sagarmatha', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2328', 'countryId' => '149', 'zoneName' => 'Seti', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '2329', 'countryId' => '150', 'zoneName' => 'Drenthe', 'zoneCode' => 'DR', 'zoneStatus' => '1'],
            ['zoneId' => '2330', 'countryId' => '150', 'zoneName' => 'Flevoland', 'zoneCode' => 'FL', 'zoneStatus' => '1'],
            ['zoneId' => '2331', 'countryId' => '150', 'zoneName' => 'Friesland', 'zoneCode' => 'FR', 'zoneStatus' => '1'],
            ['zoneId' => '2332', 'countryId' => '150', 'zoneName' => 'Gelderland', 'zoneCode' => 'GE', 'zoneStatus' => '1'],
            ['zoneId' => '2333', 'countryId' => '150', 'zoneName' => 'Groningen', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '2334', 'countryId' => '150', 'zoneName' => 'Limburg', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '2335', 'countryId' => '150', 'zoneName' => 'Noord-Brabant', 'zoneCode' => 'NB', 'zoneStatus' => '1'],
            ['zoneId' => '2336', 'countryId' => '150', 'zoneName' => 'Noord-Holland', 'zoneCode' => 'NH', 'zoneStatus' => '1'],
            ['zoneId' => '2337', 'countryId' => '150', 'zoneName' => 'Overijssel', 'zoneCode' => 'OV', 'zoneStatus' => '1'],
            ['zoneId' => '2338', 'countryId' => '150', 'zoneName' => 'Utrecht', 'zoneCode' => 'UT', 'zoneStatus' => '1'],
            ['zoneId' => '2339', 'countryId' => '150', 'zoneName' => 'Zeeland', 'zoneCode' => 'ZE', 'zoneStatus' => '1'],
            ['zoneId' => '2340', 'countryId' => '150', 'zoneName' => 'Zuid-Holland', 'zoneCode' => 'ZH', 'zoneStatus' => '1'],
            ['zoneId' => '2341', 'countryId' => '152', 'zoneName' => 'Iles Loyaute', 'zoneCode' => 'L', 'zoneStatus' => '1'],
            ['zoneId' => '2342', 'countryId' => '152', 'zoneName' => 'Nord', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '2343', 'countryId' => '152', 'zoneName' => 'Sud', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '2344', 'countryId' => '153', 'zoneName' => 'Auckland', 'zoneCode' => 'AUK', 'zoneStatus' => '1'],
            ['zoneId' => '2345', 'countryId' => '153', 'zoneName' => 'Bay of Plenty', 'zoneCode' => 'BOP', 'zoneStatus' => '1'],
            ['zoneId' => '2346', 'countryId' => '153', 'zoneName' => 'Canterbury', 'zoneCode' => 'CAN', 'zoneStatus' => '1'],
            ['zoneId' => '2347', 'countryId' => '153', 'zoneName' => 'Coromandel', 'zoneCode' => 'COR', 'zoneStatus' => '1'],
            ['zoneId' => '2348', 'countryId' => '153', 'zoneName' => 'Gisborne', 'zoneCode' => 'GIS', 'zoneStatus' => '1'],
            ['zoneId' => '2349', 'countryId' => '153', 'zoneName' => 'Fiordland', 'zoneCode' => 'FIO', 'zoneStatus' => '1'],
            ['zoneId' => '2350', 'countryId' => '153', 'zoneName' => 'Hawke\'s Bay', 'zoneCode' => 'HKB', 'zoneStatus' => '1'],
            ['zoneId' => '2351', 'countryId' => '153', 'zoneName' => 'Marlborough', 'zoneCode' => 'MBH', 'zoneStatus' => '1'],
            ['zoneId' => '2352', 'countryId' => '153', 'zoneName' => 'Manawatu-Wanganui', 'zoneCode' => 'MWT', 'zoneStatus' => '1'],
            ['zoneId' => '2353', 'countryId' => '153', 'zoneName' => 'Mt Cook-Mackenzie', 'zoneCode' => 'MCM', 'zoneStatus' => '1'],
            ['zoneId' => '2354', 'countryId' => '153', 'zoneName' => 'Nelson', 'zoneCode' => 'NSN', 'zoneStatus' => '1'],
            ['zoneId' => '2355', 'countryId' => '153', 'zoneName' => 'Northland', 'zoneCode' => 'NTL', 'zoneStatus' => '1'],
            ['zoneId' => '2356', 'countryId' => '153', 'zoneName' => 'Otago', 'zoneCode' => 'OTA', 'zoneStatus' => '1'],
            ['zoneId' => '2357', 'countryId' => '153', 'zoneName' => 'Southland', 'zoneCode' => 'STL', 'zoneStatus' => '1'],
            ['zoneId' => '2358', 'countryId' => '153', 'zoneName' => 'Taranaki', 'zoneCode' => 'TKI', 'zoneStatus' => '1'],
            ['zoneId' => '2359', 'countryId' => '153', 'zoneName' => 'Wellington', 'zoneCode' => 'WGN', 'zoneStatus' => '1'],
            ['zoneId' => '2360', 'countryId' => '153', 'zoneName' => 'Waikato', 'zoneCode' => 'WKO', 'zoneStatus' => '1'],
            ['zoneId' => '2361', 'countryId' => '153', 'zoneName' => 'Wairarapa', 'zoneCode' => 'WAI', 'zoneStatus' => '1'],
            ['zoneId' => '2362', 'countryId' => '153', 'zoneName' => 'West Coast', 'zoneCode' => 'WTC', 'zoneStatus' => '1'],
            ['zoneId' => '2363', 'countryId' => '154', 'zoneName' => 'Atlantico Norte', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '2364', 'countryId' => '154', 'zoneName' => 'Atlantico Sur', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '2365', 'countryId' => '154', 'zoneName' => 'Boaco', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '2366', 'countryId' => '154', 'zoneName' => 'Carazo', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '2367', 'countryId' => '154', 'zoneName' => 'Chinandega', 'zoneCode' => 'CI', 'zoneStatus' => '1'],
            ['zoneId' => '2368', 'countryId' => '154', 'zoneName' => 'Chontales', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '2369', 'countryId' => '154', 'zoneName' => 'Esteli', 'zoneCode' => 'ES', 'zoneStatus' => '1'],
            ['zoneId' => '2370', 'countryId' => '154', 'zoneName' => 'Granada', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '2371', 'countryId' => '154', 'zoneName' => 'Jinotega', 'zoneCode' => 'JI', 'zoneStatus' => '1'],
            ['zoneId' => '2372', 'countryId' => '154', 'zoneName' => 'Leon', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '2373', 'countryId' => '154', 'zoneName' => 'Madriz', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '2374', 'countryId' => '154', 'zoneName' => 'Managua', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '2375', 'countryId' => '154', 'zoneName' => 'Masaya', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '2376', 'countryId' => '154', 'zoneName' => 'Matagalpa', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '2377', 'countryId' => '154', 'zoneName' => 'Nuevo Segovia', 'zoneCode' => 'NS', 'zoneStatus' => '1'],
            ['zoneId' => '2378', 'countryId' => '154', 'zoneName' => 'Rio San Juan', 'zoneCode' => 'RS', 'zoneStatus' => '1'],
            ['zoneId' => '2379', 'countryId' => '154', 'zoneName' => 'Rivas', 'zoneCode' => 'RI', 'zoneStatus' => '1'],
            ['zoneId' => '2380', 'countryId' => '155', 'zoneName' => 'Agadez', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '2381', 'countryId' => '155', 'zoneName' => 'Diffa', 'zoneCode' => 'DF', 'zoneStatus' => '1'],
            ['zoneId' => '2382', 'countryId' => '155', 'zoneName' => 'Dosso', 'zoneCode' => 'DS', 'zoneStatus' => '1'],
            ['zoneId' => '2383', 'countryId' => '155', 'zoneName' => 'Maradi', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '2384', 'countryId' => '155', 'zoneName' => 'Niamey', 'zoneCode' => 'NM', 'zoneStatus' => '1'],
            ['zoneId' => '2385', 'countryId' => '155', 'zoneName' => 'Tahoua', 'zoneCode' => 'TH', 'zoneStatus' => '1'],
            ['zoneId' => '2386', 'countryId' => '155', 'zoneName' => 'Tillaberi', 'zoneCode' => 'TL', 'zoneStatus' => '1'],
            ['zoneId' => '2387', 'countryId' => '155', 'zoneName' => 'Zinder', 'zoneCode' => 'ZD', 'zoneStatus' => '1'],
            ['zoneId' => '2388', 'countryId' => '156', 'zoneName' => 'Abia', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '2389', 'countryId' => '156', 'zoneName' => 'Abuja Federal Capital Territory', 'zoneCode' => 'CT', 'zoneStatus' => '1'],
            ['zoneId' => '2390', 'countryId' => '156', 'zoneName' => 'Adamawa', 'zoneCode' => 'AD', 'zoneStatus' => '1'],
            ['zoneId' => '2391', 'countryId' => '156', 'zoneName' => 'Akwa Ibom', 'zoneCode' => 'AK', 'zoneStatus' => '1'],
            ['zoneId' => '2392', 'countryId' => '156', 'zoneName' => 'Anambra', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '2393', 'countryId' => '156', 'zoneName' => 'Bauchi', 'zoneCode' => 'BC', 'zoneStatus' => '1'],
            ['zoneId' => '2394', 'countryId' => '156', 'zoneName' => 'Bayelsa', 'zoneCode' => 'BY', 'zoneStatus' => '1'],
            ['zoneId' => '2395', 'countryId' => '156', 'zoneName' => 'Benue', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '2396', 'countryId' => '156', 'zoneName' => 'Borno', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '2397', 'countryId' => '156', 'zoneName' => 'Cross River', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '2398', 'countryId' => '156', 'zoneName' => 'Delta', 'zoneCode' => 'DE', 'zoneStatus' => '1'],
            ['zoneId' => '2399', 'countryId' => '156', 'zoneName' => 'Ebonyi', 'zoneCode' => 'EB', 'zoneStatus' => '1'],
            ['zoneId' => '2400', 'countryId' => '156', 'zoneName' => 'Edo', 'zoneCode' => 'ED', 'zoneStatus' => '1'],
            ['zoneId' => '2401', 'countryId' => '156', 'zoneName' => 'Ekiti', 'zoneCode' => 'EK', 'zoneStatus' => '1'],
            ['zoneId' => '2402', 'countryId' => '156', 'zoneName' => 'Enugu', 'zoneCode' => 'EN', 'zoneStatus' => '1'],
            ['zoneId' => '2403', 'countryId' => '156', 'zoneName' => 'Gombe', 'zoneCode' => 'GO', 'zoneStatus' => '1'],
            ['zoneId' => '2404', 'countryId' => '156', 'zoneName' => 'Imo', 'zoneCode' => 'IM', 'zoneStatus' => '1'],
            ['zoneId' => '2405', 'countryId' => '156', 'zoneName' => 'Jigawa', 'zoneCode' => 'JI', 'zoneStatus' => '1'],
            ['zoneId' => '2406', 'countryId' => '156', 'zoneName' => 'Kaduna', 'zoneCode' => 'KD', 'zoneStatus' => '1'],
            ['zoneId' => '2407', 'countryId' => '156', 'zoneName' => 'Kano', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '2408', 'countryId' => '156', 'zoneName' => 'Katsina', 'zoneCode' => 'KT', 'zoneStatus' => '1'],
            ['zoneId' => '2409', 'countryId' => '156', 'zoneName' => 'Kebbi', 'zoneCode' => 'KE', 'zoneStatus' => '1'],
            ['zoneId' => '2410', 'countryId' => '156', 'zoneName' => 'Kogi', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '2411', 'countryId' => '156', 'zoneName' => 'Kwara', 'zoneCode' => 'KW', 'zoneStatus' => '1'],
            ['zoneId' => '2412', 'countryId' => '156', 'zoneName' => 'Lagos', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '2413', 'countryId' => '156', 'zoneName' => 'Nassarawa', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '2414', 'countryId' => '156', 'zoneName' => 'Niger', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '2415', 'countryId' => '156', 'zoneName' => 'Ogun', 'zoneCode' => 'OG', 'zoneStatus' => '1'],
            ['zoneId' => '2416', 'countryId' => '156', 'zoneName' => 'Ondo', 'zoneCode' => 'ONG', 'zoneStatus' => '1'],
            ['zoneId' => '2417', 'countryId' => '156', 'zoneName' => 'Osun', 'zoneCode' => 'OS', 'zoneStatus' => '1'],
            ['zoneId' => '2418', 'countryId' => '156', 'zoneName' => 'Oyo', 'zoneCode' => 'OY', 'zoneStatus' => '1'],
            ['zoneId' => '2419', 'countryId' => '156', 'zoneName' => 'Plateau', 'zoneCode' => 'PL', 'zoneStatus' => '1'],
            ['zoneId' => '2420', 'countryId' => '156', 'zoneName' => 'Rivers', 'zoneCode' => 'RI', 'zoneStatus' => '1'],
            ['zoneId' => '2421', 'countryId' => '156', 'zoneName' => 'Sokoto', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '2422', 'countryId' => '156', 'zoneName' => 'Taraba', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '2423', 'countryId' => '156', 'zoneName' => 'Yobe', 'zoneCode' => 'YO', 'zoneStatus' => '1'],
            ['zoneId' => '2424', 'countryId' => '156', 'zoneName' => 'Zamfara', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '2425', 'countryId' => '159', 'zoneName' => 'Northern Islands', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '2426', 'countryId' => '159', 'zoneName' => 'Rota', 'zoneCode' => 'R', 'zoneStatus' => '1'],
            ['zoneId' => '2427', 'countryId' => '159', 'zoneName' => 'Saipan', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '2428', 'countryId' => '159', 'zoneName' => 'Tinian', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '2429', 'countryId' => '160', 'zoneName' => 'Akershus', 'zoneCode' => 'AK', 'zoneStatus' => '1'],
            ['zoneId' => '2430', 'countryId' => '160', 'zoneName' => 'Aust-Agder', 'zoneCode' => 'AA', 'zoneStatus' => '1'],
            ['zoneId' => '2431', 'countryId' => '160', 'zoneName' => 'Buskerud', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '2432', 'countryId' => '160', 'zoneName' => 'Finnmark', 'zoneCode' => 'FM', 'zoneStatus' => '1'],
            ['zoneId' => '2433', 'countryId' => '160', 'zoneName' => 'Hedmark', 'zoneCode' => 'HM', 'zoneStatus' => '1'],
            ['zoneId' => '2434', 'countryId' => '160', 'zoneName' => 'Hordaland', 'zoneCode' => 'HL', 'zoneStatus' => '1'],
            ['zoneId' => '2435', 'countryId' => '160', 'zoneName' => 'More og Romdal', 'zoneCode' => 'MR', 'zoneStatus' => '1'],
            ['zoneId' => '2436', 'countryId' => '160', 'zoneName' => 'Nord-Trondelag', 'zoneCode' => 'NT', 'zoneStatus' => '1'],
            ['zoneId' => '2437', 'countryId' => '160', 'zoneName' => 'Nordland', 'zoneCode' => 'NL', 'zoneStatus' => '1'],
            ['zoneId' => '2438', 'countryId' => '160', 'zoneName' => 'Ostfold', 'zoneCode' => 'OF', 'zoneStatus' => '1'],
            ['zoneId' => '2439', 'countryId' => '160', 'zoneName' => 'Oppland', 'zoneCode' => 'OP', 'zoneStatus' => '1'],
            ['zoneId' => '2440', 'countryId' => '160', 'zoneName' => 'Oslo', 'zoneCode' => 'OL', 'zoneStatus' => '1'],
            ['zoneId' => '2441', 'countryId' => '160', 'zoneName' => 'Rogaland', 'zoneCode' => 'RL', 'zoneStatus' => '1'],
            ['zoneId' => '2442', 'countryId' => '160', 'zoneName' => 'Sor-Trondelag', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '2443', 'countryId' => '160', 'zoneName' => 'Sogn og Fjordane', 'zoneCode' => 'SJ', 'zoneStatus' => '1'],
            ['zoneId' => '2444', 'countryId' => '160', 'zoneName' => 'Svalbard', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '2445', 'countryId' => '160', 'zoneName' => 'Telemark', 'zoneCode' => 'TM', 'zoneStatus' => '1'],
            ['zoneId' => '2446', 'countryId' => '160', 'zoneName' => 'Troms', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '2447', 'countryId' => '160', 'zoneName' => 'Vest-Agder', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '2448', 'countryId' => '160', 'zoneName' => 'Vestfold', 'zoneCode' => 'VF', 'zoneStatus' => '1'],
            ['zoneId' => '2449', 'countryId' => '161', 'zoneName' => 'Ad Dakhiliyah', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '2450', 'countryId' => '161', 'zoneName' => 'Al Batinah', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2451', 'countryId' => '161', 'zoneName' => 'Al Wusta', 'zoneCode' => 'WU', 'zoneStatus' => '1'],
            ['zoneId' => '2452', 'countryId' => '161', 'zoneName' => 'Ash Sharqiyah', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '2453', 'countryId' => '161', 'zoneName' => 'Az Zahirah', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '2454', 'countryId' => '161', 'zoneName' => 'Masqat', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '2455', 'countryId' => '161', 'zoneName' => 'Musandam', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '2456', 'countryId' => '161', 'zoneName' => 'Zufar', 'zoneCode' => 'ZU', 'zoneStatus' => '1'],
            ['zoneId' => '2457', 'countryId' => '162', 'zoneName' => 'Balochistan', 'zoneCode' => 'B', 'zoneStatus' => '1'],
            ['zoneId' => '2458', 'countryId' => '162', 'zoneName' => 'Federally Administered Tribal Areas', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '2459', 'countryId' => '162', 'zoneName' => 'Islamabad Capital Territory', 'zoneCode' => 'I', 'zoneStatus' => '1'],
            ['zoneId' => '2460', 'countryId' => '162', 'zoneName' => 'North-West Frontier', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '2461', 'countryId' => '162', 'zoneName' => 'Punjab', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '2462', 'countryId' => '162', 'zoneName' => 'Sindh', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '2463', 'countryId' => '163', 'zoneName' => 'Aimeliik', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '2464', 'countryId' => '163', 'zoneName' => 'Airai', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '2465', 'countryId' => '163', 'zoneName' => 'Angaur', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '2466', 'countryId' => '163', 'zoneName' => 'Hatohobei', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '2467', 'countryId' => '163', 'zoneName' => 'Kayangel', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '2468', 'countryId' => '163', 'zoneName' => 'Koror', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '2469', 'countryId' => '163', 'zoneName' => 'Melekeok', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '2470', 'countryId' => '163', 'zoneName' => 'Ngaraard', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '2471', 'countryId' => '163', 'zoneName' => 'Ngarchelong', 'zoneCode' => 'NG', 'zoneStatus' => '1'],
            ['zoneId' => '2472', 'countryId' => '163', 'zoneName' => 'Ngardmau', 'zoneCode' => 'ND', 'zoneStatus' => '1'],
            ['zoneId' => '2473', 'countryId' => '163', 'zoneName' => 'Ngatpang', 'zoneCode' => 'NT', 'zoneStatus' => '1'],
            ['zoneId' => '2474', 'countryId' => '163', 'zoneName' => 'Ngchesar', 'zoneCode' => 'NC', 'zoneStatus' => '1'],
            ['zoneId' => '2475', 'countryId' => '163', 'zoneName' => 'Ngeremlengui', 'zoneCode' => 'NR', 'zoneStatus' => '1'],
            ['zoneId' => '2476', 'countryId' => '163', 'zoneName' => 'Ngiwal', 'zoneCode' => 'NW', 'zoneStatus' => '1'],
            ['zoneId' => '2477', 'countryId' => '163', 'zoneName' => 'Peleliu', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '2478', 'countryId' => '163', 'zoneName' => 'Sonsorol', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '2479', 'countryId' => '164', 'zoneName' => 'Bocas del Toro', 'zoneCode' => 'BT', 'zoneStatus' => '1'],
            ['zoneId' => '2480', 'countryId' => '164', 'zoneName' => 'Chiriqui', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2481', 'countryId' => '164', 'zoneName' => 'Cocle', 'zoneCode' => 'CC', 'zoneStatus' => '1'],
            ['zoneId' => '2482', 'countryId' => '164', 'zoneName' => 'Colon', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '2483', 'countryId' => '164', 'zoneName' => 'Darien', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '2484', 'countryId' => '164', 'zoneName' => 'Herrera', 'zoneCode' => 'HE', 'zoneStatus' => '1'],
            ['zoneId' => '2485', 'countryId' => '164', 'zoneName' => 'Los Santos', 'zoneCode' => 'LS', 'zoneStatus' => '1'],
            ['zoneId' => '2486', 'countryId' => '164', 'zoneName' => 'Panama', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '2487', 'countryId' => '164', 'zoneName' => 'San Blas', 'zoneCode' => 'SB', 'zoneStatus' => '1'],
            ['zoneId' => '2488', 'countryId' => '164', 'zoneName' => 'Veraguas', 'zoneCode' => 'VG', 'zoneStatus' => '1'],
            ['zoneId' => '2489', 'countryId' => '165', 'zoneName' => 'Bougainville', 'zoneCode' => 'BV', 'zoneStatus' => '1'],
            ['zoneId' => '2490', 'countryId' => '165', 'zoneName' => 'Central', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '2491', 'countryId' => '165', 'zoneName' => 'Chimbu', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2492', 'countryId' => '165', 'zoneName' => 'Eastern Highlands', 'zoneCode' => 'EH', 'zoneStatus' => '1'],
            ['zoneId' => '2493', 'countryId' => '165', 'zoneName' => 'East New Britain', 'zoneCode' => 'EB', 'zoneStatus' => '1'],
            ['zoneId' => '2494', 'countryId' => '165', 'zoneName' => 'East Sepik', 'zoneCode' => 'ES', 'zoneStatus' => '1'],
            ['zoneId' => '2495', 'countryId' => '165', 'zoneName' => 'Enga', 'zoneCode' => 'EN', 'zoneStatus' => '1'],
            ['zoneId' => '2496', 'countryId' => '165', 'zoneName' => 'Gulf', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '2497', 'countryId' => '165', 'zoneName' => 'Madang', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '2498', 'countryId' => '165', 'zoneName' => 'Manus', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '2499', 'countryId' => '165', 'zoneName' => 'Milne Bay', 'zoneCode' => 'MB', 'zoneStatus' => '1'],
            ['zoneId' => '2500', 'countryId' => '165', 'zoneName' => 'Morobe', 'zoneCode' => 'MR', 'zoneStatus' => '1'],
            ['zoneId' => '2501', 'countryId' => '165', 'zoneName' => 'National Capital', 'zoneCode' => 'NC', 'zoneStatus' => '1'],
            ['zoneId' => '2502', 'countryId' => '165', 'zoneName' => 'New Ireland', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '2503', 'countryId' => '165', 'zoneName' => 'Northern', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '2504', 'countryId' => '165', 'zoneName' => 'Sandaun', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2505', 'countryId' => '165', 'zoneName' => 'Southern Highlands', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '2506', 'countryId' => '165', 'zoneName' => 'Western', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '2507', 'countryId' => '165', 'zoneName' => 'Western Highlands', 'zoneCode' => 'WH', 'zoneStatus' => '1'],
            ['zoneId' => '2508', 'countryId' => '165', 'zoneName' => 'West New Britain', 'zoneCode' => 'WB', 'zoneStatus' => '1'],
            ['zoneId' => '2509', 'countryId' => '166', 'zoneName' => 'Alto Paraguay', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '2510', 'countryId' => '166', 'zoneName' => 'Alto Parana', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '2511', 'countryId' => '166', 'zoneName' => 'Amambay', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '2512', 'countryId' => '166', 'zoneName' => 'Asuncion', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '2513', 'countryId' => '166', 'zoneName' => 'Boqueron', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '2514', 'countryId' => '166', 'zoneName' => 'Caaguazu', 'zoneCode' => 'CG', 'zoneStatus' => '1'],
            ['zoneId' => '2515', 'countryId' => '166', 'zoneName' => 'Caazapa', 'zoneCode' => 'CZ', 'zoneStatus' => '1'],
            ['zoneId' => '2516', 'countryId' => '166', 'zoneName' => 'Canindeyu', 'zoneCode' => 'CN', 'zoneStatus' => '1'],
            ['zoneId' => '2517', 'countryId' => '166', 'zoneName' => 'Central', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '2518', 'countryId' => '166', 'zoneName' => 'Concepcion', 'zoneCode' => 'CC', 'zoneStatus' => '1'],
            ['zoneId' => '2519', 'countryId' => '166', 'zoneName' => 'Cordillera', 'zoneCode' => 'CD', 'zoneStatus' => '1'],
            ['zoneId' => '2520', 'countryId' => '166', 'zoneName' => 'Guaira', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '2521', 'countryId' => '166', 'zoneName' => 'Itapua', 'zoneCode' => 'IT', 'zoneStatus' => '1'],
            ['zoneId' => '2522', 'countryId' => '166', 'zoneName' => 'Misiones', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '2523', 'countryId' => '166', 'zoneName' => 'Neembucu', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '2524', 'countryId' => '166', 'zoneName' => 'Paraguari', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '2525', 'countryId' => '166', 'zoneName' => 'Presidente Hayes', 'zoneCode' => 'PH', 'zoneStatus' => '1'],
            ['zoneId' => '2526', 'countryId' => '166', 'zoneName' => 'San Pedro', 'zoneCode' => 'SP', 'zoneStatus' => '1'],
            ['zoneId' => '2527', 'countryId' => '167', 'zoneName' => 'Amazonas', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '2528', 'countryId' => '167', 'zoneName' => 'Ancash', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '2529', 'countryId' => '167', 'zoneName' => 'Apurimac', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '2530', 'countryId' => '167', 'zoneName' => 'Arequipa', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '2531', 'countryId' => '167', 'zoneName' => 'Ayacucho', 'zoneCode' => 'AY', 'zoneStatus' => '1'],
            ['zoneId' => '2532', 'countryId' => '167', 'zoneName' => 'Cajamarca', 'zoneCode' => 'CJ', 'zoneStatus' => '1'],
            ['zoneId' => '2533', 'countryId' => '167', 'zoneName' => 'Callao', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '2534', 'countryId' => '167', 'zoneName' => 'Cusco', 'zoneCode' => 'CU', 'zoneStatus' => '1'],
            ['zoneId' => '2535', 'countryId' => '167', 'zoneName' => 'Huancavelica', 'zoneCode' => 'HV', 'zoneStatus' => '1'],
            ['zoneId' => '2536', 'countryId' => '167', 'zoneName' => 'Huanuco', 'zoneCode' => 'HO', 'zoneStatus' => '1'],
            ['zoneId' => '2537', 'countryId' => '167', 'zoneName' => 'Ica', 'zoneCode' => 'IC', 'zoneStatus' => '1'],
            ['zoneId' => '2538', 'countryId' => '167', 'zoneName' => 'Junin', 'zoneCode' => 'JU', 'zoneStatus' => '1'],
            ['zoneId' => '2539', 'countryId' => '167', 'zoneName' => 'La Libertad', 'zoneCode' => 'LD', 'zoneStatus' => '1'],
            ['zoneId' => '2540', 'countryId' => '167', 'zoneName' => 'Lambayeque', 'zoneCode' => 'LY', 'zoneStatus' => '1'],
            ['zoneId' => '2541', 'countryId' => '167', 'zoneName' => 'Lima', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '2542', 'countryId' => '167', 'zoneName' => 'Loreto', 'zoneCode' => 'LO', 'zoneStatus' => '1'],
            ['zoneId' => '2543', 'countryId' => '167', 'zoneName' => 'Madre de Dios', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '2544', 'countryId' => '167', 'zoneName' => 'Moquegua', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '2545', 'countryId' => '167', 'zoneName' => 'Pasco', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '2546', 'countryId' => '167', 'zoneName' => 'Piura', 'zoneCode' => 'PI', 'zoneStatus' => '1'],
            ['zoneId' => '2547', 'countryId' => '167', 'zoneName' => 'Puno', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '2548', 'countryId' => '167', 'zoneName' => 'San Martin', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '2549', 'countryId' => '167', 'zoneName' => 'Tacna', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '2550', 'countryId' => '167', 'zoneName' => 'Tumbes', 'zoneCode' => 'TU', 'zoneStatus' => '1'],
            ['zoneId' => '2551', 'countryId' => '167', 'zoneName' => 'Ucayali', 'zoneCode' => 'UC', 'zoneStatus' => '1'],
            ['zoneId' => '2552', 'countryId' => '168', 'zoneName' => 'Abra', 'zoneCode' => 'ABR', 'zoneStatus' => '1'],
            ['zoneId' => '2553', 'countryId' => '168', 'zoneName' => 'Agusan del Norte', 'zoneCode' => 'ANO', 'zoneStatus' => '1'],
            ['zoneId' => '2554', 'countryId' => '168', 'zoneName' => 'Agusan del Sur', 'zoneCode' => 'ASU', 'zoneStatus' => '1'],
            ['zoneId' => '2555', 'countryId' => '168', 'zoneName' => 'Aklan', 'zoneCode' => 'AKL', 'zoneStatus' => '1'],
            ['zoneId' => '2556', 'countryId' => '168', 'zoneName' => 'Albay', 'zoneCode' => 'ALB', 'zoneStatus' => '1'],
            ['zoneId' => '2557', 'countryId' => '168', 'zoneName' => 'Antique', 'zoneCode' => 'ANT', 'zoneStatus' => '1'],
            ['zoneId' => '2558', 'countryId' => '168', 'zoneName' => 'Apayao', 'zoneCode' => 'APY', 'zoneStatus' => '1'],
            ['zoneId' => '2559', 'countryId' => '168', 'zoneName' => 'Aurora', 'zoneCode' => 'AUR', 'zoneStatus' => '1'],
            ['zoneId' => '2560', 'countryId' => '168', 'zoneName' => 'Basilan', 'zoneCode' => 'BAS', 'zoneStatus' => '1'],
            ['zoneId' => '2561', 'countryId' => '168', 'zoneName' => 'Bataan', 'zoneCode' => 'BTA', 'zoneStatus' => '1'],
            ['zoneId' => '2562', 'countryId' => '168', 'zoneName' => 'Batanes', 'zoneCode' => 'BTE', 'zoneStatus' => '1'],
            ['zoneId' => '2563', 'countryId' => '168', 'zoneName' => 'Batangas', 'zoneCode' => 'BTG', 'zoneStatus' => '1'],
            ['zoneId' => '2564', 'countryId' => '168', 'zoneName' => 'Biliran', 'zoneCode' => 'BLR', 'zoneStatus' => '1'],
            ['zoneId' => '2565', 'countryId' => '168', 'zoneName' => 'Benguet', 'zoneCode' => 'BEN', 'zoneStatus' => '1'],
            ['zoneId' => '2566', 'countryId' => '168', 'zoneName' => 'Bohol', 'zoneCode' => 'BOL', 'zoneStatus' => '1'],
            ['zoneId' => '2567', 'countryId' => '168', 'zoneName' => 'Bukidnon', 'zoneCode' => 'BUK', 'zoneStatus' => '1'],
            ['zoneId' => '2568', 'countryId' => '168', 'zoneName' => 'Bulacan', 'zoneCode' => 'BUL', 'zoneStatus' => '1'],
            ['zoneId' => '2569', 'countryId' => '168', 'zoneName' => 'Cagayan', 'zoneCode' => 'CAG', 'zoneStatus' => '1'],
            ['zoneId' => '2570', 'countryId' => '168', 'zoneName' => 'Camarines Norte', 'zoneCode' => 'CNO', 'zoneStatus' => '1'],
            ['zoneId' => '2571', 'countryId' => '168', 'zoneName' => 'Camarines Sur', 'zoneCode' => 'CSU', 'zoneStatus' => '1'],
            ['zoneId' => '2572', 'countryId' => '168', 'zoneName' => 'Camiguin', 'zoneCode' => 'CAM', 'zoneStatus' => '1'],
            ['zoneId' => '2573', 'countryId' => '168', 'zoneName' => 'Capiz', 'zoneCode' => 'CAP', 'zoneStatus' => '1'],
            ['zoneId' => '2574', 'countryId' => '168', 'zoneName' => 'Catanduanes', 'zoneCode' => 'CAT', 'zoneStatus' => '1'],
            ['zoneId' => '2575', 'countryId' => '168', 'zoneName' => 'Cavite', 'zoneCode' => 'CAV', 'zoneStatus' => '1'],
            ['zoneId' => '2576', 'countryId' => '168', 'zoneName' => 'Cebu', 'zoneCode' => 'CEB', 'zoneStatus' => '1'],
            ['zoneId' => '2577', 'countryId' => '168', 'zoneName' => 'Compostela', 'zoneCode' => 'CMP', 'zoneStatus' => '1'],
            ['zoneId' => '2578', 'countryId' => '168', 'zoneName' => 'Davao del Norte', 'zoneCode' => 'DNO', 'zoneStatus' => '1'],
            ['zoneId' => '2579', 'countryId' => '168', 'zoneName' => 'Davao del Sur', 'zoneCode' => 'DSU', 'zoneStatus' => '1'],
            ['zoneId' => '2580', 'countryId' => '168', 'zoneName' => 'Davao Oriental', 'zoneCode' => 'DOR', 'zoneStatus' => '1'],
            ['zoneId' => '2581', 'countryId' => '168', 'zoneName' => 'Eastern Samar', 'zoneCode' => 'ESA', 'zoneStatus' => '1'],
            ['zoneId' => '2582', 'countryId' => '168', 'zoneName' => 'Guimaras', 'zoneCode' => 'GUI', 'zoneStatus' => '1'],
            ['zoneId' => '2583', 'countryId' => '168', 'zoneName' => 'Ifugao', 'zoneCode' => 'IFU', 'zoneStatus' => '1'],
            ['zoneId' => '2584', 'countryId' => '168', 'zoneName' => 'Ilocos Norte', 'zoneCode' => 'INO', 'zoneStatus' => '1'],
            ['zoneId' => '2585', 'countryId' => '168', 'zoneName' => 'Ilocos Sur', 'zoneCode' => 'ISU', 'zoneStatus' => '1'],
            ['zoneId' => '2586', 'countryId' => '168', 'zoneName' => 'Iloilo', 'zoneCode' => 'ILO', 'zoneStatus' => '1'],
            ['zoneId' => '2587', 'countryId' => '168', 'zoneName' => 'Isabela', 'zoneCode' => 'ISA', 'zoneStatus' => '1'],
            ['zoneId' => '2588', 'countryId' => '168', 'zoneName' => 'Kalinga', 'zoneCode' => 'KAL', 'zoneStatus' => '1'],
            ['zoneId' => '2589', 'countryId' => '168', 'zoneName' => 'Laguna', 'zoneCode' => 'LAG', 'zoneStatus' => '1'],
            ['zoneId' => '2590', 'countryId' => '168', 'zoneName' => 'Lanao del Norte', 'zoneCode' => 'LNO', 'zoneStatus' => '1'],
            ['zoneId' => '2591', 'countryId' => '168', 'zoneName' => 'Lanao del Sur', 'zoneCode' => 'LSU', 'zoneStatus' => '1'],
            ['zoneId' => '2592', 'countryId' => '168', 'zoneName' => 'La Union', 'zoneCode' => 'UNI', 'zoneStatus' => '1'],
            ['zoneId' => '2593', 'countryId' => '168', 'zoneName' => 'Leyte', 'zoneCode' => 'LEY', 'zoneStatus' => '1'],
            ['zoneId' => '2594', 'countryId' => '168', 'zoneName' => 'Maguindanao', 'zoneCode' => 'MAG', 'zoneStatus' => '1'],
            ['zoneId' => '2595', 'countryId' => '168', 'zoneName' => 'Marinduque', 'zoneCode' => 'MRN', 'zoneStatus' => '1'],
            ['zoneId' => '2596', 'countryId' => '168', 'zoneName' => 'Masbate', 'zoneCode' => 'MSB', 'zoneStatus' => '1'],
            ['zoneId' => '2597', 'countryId' => '168', 'zoneName' => 'Mindoro Occidental', 'zoneCode' => 'MIC', 'zoneStatus' => '1'],
            ['zoneId' => '2598', 'countryId' => '168', 'zoneName' => 'Mindoro Oriental', 'zoneCode' => 'MIR', 'zoneStatus' => '1'],
            ['zoneId' => '2599', 'countryId' => '168', 'zoneName' => 'Misamis Occidental', 'zoneCode' => 'MSC', 'zoneStatus' => '1'],
            ['zoneId' => '2600', 'countryId' => '168', 'zoneName' => 'Misamis Oriental', 'zoneCode' => 'MOR', 'zoneStatus' => '1'],
            ['zoneId' => '2601', 'countryId' => '168', 'zoneName' => 'Mountain', 'zoneCode' => 'MOP', 'zoneStatus' => '1'],
            ['zoneId' => '2602', 'countryId' => '168', 'zoneName' => 'Negros Occidental', 'zoneCode' => 'NOC', 'zoneStatus' => '1'],
            ['zoneId' => '2603', 'countryId' => '168', 'zoneName' => 'Negros Oriental', 'zoneCode' => 'NOR', 'zoneStatus' => '1'],
            ['zoneId' => '2604', 'countryId' => '168', 'zoneName' => 'North Cotabato', 'zoneCode' => 'NCT', 'zoneStatus' => '1'],
            ['zoneId' => '2605', 'countryId' => '168', 'zoneName' => 'Northern Samar', 'zoneCode' => 'NSM', 'zoneStatus' => '1'],
            ['zoneId' => '2606', 'countryId' => '168', 'zoneName' => 'Nueva Ecija', 'zoneCode' => 'NEC', 'zoneStatus' => '1'],
            ['zoneId' => '2607', 'countryId' => '168', 'zoneName' => 'Nueva Vizcaya', 'zoneCode' => 'NVZ', 'zoneStatus' => '1'],
            ['zoneId' => '2608', 'countryId' => '168', 'zoneName' => 'Palawan', 'zoneCode' => 'PLW', 'zoneStatus' => '1'],
            ['zoneId' => '2609', 'countryId' => '168', 'zoneName' => 'Pampanga', 'zoneCode' => 'PMP', 'zoneStatus' => '1'],
            ['zoneId' => '2610', 'countryId' => '168', 'zoneName' => 'Pangasinan', 'zoneCode' => 'PNG', 'zoneStatus' => '1'],
            ['zoneId' => '2611', 'countryId' => '168', 'zoneName' => 'Quezon', 'zoneCode' => 'QZN', 'zoneStatus' => '1'],
            ['zoneId' => '2612', 'countryId' => '168', 'zoneName' => 'Quirino', 'zoneCode' => 'QRN', 'zoneStatus' => '1'],
            ['zoneId' => '2613', 'countryId' => '168', 'zoneName' => 'Rizal', 'zoneCode' => 'RIZ', 'zoneStatus' => '1'],
            ['zoneId' => '2614', 'countryId' => '168', 'zoneName' => 'Romblon', 'zoneCode' => 'ROM', 'zoneStatus' => '1'],
            ['zoneId' => '2615', 'countryId' => '168', 'zoneName' => 'Samar', 'zoneCode' => 'SMR', 'zoneStatus' => '1'],
            ['zoneId' => '2616', 'countryId' => '168', 'zoneName' => 'Sarangani', 'zoneCode' => 'SRG', 'zoneStatus' => '1'],
            ['zoneId' => '2617', 'countryId' => '168', 'zoneName' => 'Siquijor', 'zoneCode' => 'SQJ', 'zoneStatus' => '1'],
            ['zoneId' => '2618', 'countryId' => '168', 'zoneName' => 'Sorsogon', 'zoneCode' => 'SRS', 'zoneStatus' => '1'],
            ['zoneId' => '2619', 'countryId' => '168', 'zoneName' => 'South Cotabato', 'zoneCode' => 'SCO', 'zoneStatus' => '1'],
            ['zoneId' => '2620', 'countryId' => '168', 'zoneName' => 'Southern Leyte', 'zoneCode' => 'SLE', 'zoneStatus' => '1'],
            ['zoneId' => '2621', 'countryId' => '168', 'zoneName' => 'Sultan Kudarat', 'zoneCode' => 'SKU', 'zoneStatus' => '1'],
            ['zoneId' => '2622', 'countryId' => '168', 'zoneName' => 'Sulu', 'zoneCode' => 'SLU', 'zoneStatus' => '1'],
            ['zoneId' => '2623', 'countryId' => '168', 'zoneName' => 'Surigao del Norte', 'zoneCode' => 'SNO', 'zoneStatus' => '1'],
            ['zoneId' => '2624', 'countryId' => '168', 'zoneName' => 'Surigao del Sur', 'zoneCode' => 'SSU', 'zoneStatus' => '1'],
            ['zoneId' => '2625', 'countryId' => '168', 'zoneName' => 'Tarlac', 'zoneCode' => 'TAR', 'zoneStatus' => '1'],
            ['zoneId' => '2626', 'countryId' => '168', 'zoneName' => 'Tawi-Tawi', 'zoneCode' => 'TAW', 'zoneStatus' => '1'],
            ['zoneId' => '2627', 'countryId' => '168', 'zoneName' => 'Zambales', 'zoneCode' => 'ZBL', 'zoneStatus' => '1'],
            ['zoneId' => '2628', 'countryId' => '168', 'zoneName' => 'Zamboanga del Norte', 'zoneCode' => 'ZNO', 'zoneStatus' => '1'],
            ['zoneId' => '2629', 'countryId' => '168', 'zoneName' => 'Zamboanga del Sur', 'zoneCode' => 'ZSU', 'zoneStatus' => '1'],
            ['zoneId' => '2630', 'countryId' => '168', 'zoneName' => 'Zamboanga Sibugay', 'zoneCode' => 'ZSI', 'zoneStatus' => '1'],
            ['zoneId' => '2631', 'countryId' => '170', 'zoneName' => 'Dolnoslaskie', 'zoneCode' => 'DO', 'zoneStatus' => '1'],
            ['zoneId' => '2632', 'countryId' => '170', 'zoneName' => 'Kujawsko-Pomorskie', 'zoneCode' => 'KP', 'zoneStatus' => '1'],
            ['zoneId' => '2633', 'countryId' => '170', 'zoneName' => 'Lodzkie', 'zoneCode' => 'LO', 'zoneStatus' => '1'],
            ['zoneId' => '2634', 'countryId' => '170', 'zoneName' => 'Lubelskie', 'zoneCode' => 'LL', 'zoneStatus' => '1'],
            ['zoneId' => '2635', 'countryId' => '170', 'zoneName' => 'Lubuskie', 'zoneCode' => 'LU', 'zoneStatus' => '1'],
            ['zoneId' => '2636', 'countryId' => '170', 'zoneName' => 'Malopolskie', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '2637', 'countryId' => '170', 'zoneName' => 'Mazowieckie', 'zoneCode' => 'MZ', 'zoneStatus' => '1'],
            ['zoneId' => '2638', 'countryId' => '170', 'zoneName' => 'Opolskie', 'zoneCode' => 'OP', 'zoneStatus' => '1'],
            ['zoneId' => '2639', 'countryId' => '170', 'zoneName' => 'Podkarpackie', 'zoneCode' => 'PP', 'zoneStatus' => '1'],
            ['zoneId' => '2640', 'countryId' => '170', 'zoneName' => 'Podlaskie', 'zoneCode' => 'PL', 'zoneStatus' => '1'],
            ['zoneId' => '2641', 'countryId' => '170', 'zoneName' => 'Pomorskie', 'zoneCode' => 'PM', 'zoneStatus' => '1'],
            ['zoneId' => '2642', 'countryId' => '170', 'zoneName' => 'Slaskie', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '2643', 'countryId' => '170', 'zoneName' => 'Swietokrzyskie', 'zoneCode' => 'SW', 'zoneStatus' => '1'],
            ['zoneId' => '2644', 'countryId' => '170', 'zoneName' => 'Warminsko-Mazurskie', 'zoneCode' => 'WM', 'zoneStatus' => '1'],
            ['zoneId' => '2645', 'countryId' => '170', 'zoneName' => 'Wielkopolskie', 'zoneCode' => 'WP', 'zoneStatus' => '1'],
            ['zoneId' => '2646', 'countryId' => '170', 'zoneName' => 'Zachodniopomorskie', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '2647', 'countryId' => '198', 'zoneName' => 'Saint Pierre', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '2648', 'countryId' => '198', 'zoneName' => 'Miquelon', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '2649', 'countryId' => '171', 'zoneName' => 'A&ccedil;ores', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '2650', 'countryId' => '171', 'zoneName' => 'Aveiro', 'zoneCode' => 'AV', 'zoneStatus' => '1'],
            ['zoneId' => '2651', 'countryId' => '171', 'zoneName' => 'Beja', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '2652', 'countryId' => '171', 'zoneName' => 'Braga', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '2653', 'countryId' => '171', 'zoneName' => 'Bragan&ccedil;a', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2654', 'countryId' => '171', 'zoneName' => 'Castelo Branco', 'zoneCode' => 'CB', 'zoneStatus' => '1'],
            ['zoneId' => '2655', 'countryId' => '171', 'zoneName' => 'Coimbra', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '2656', 'countryId' => '171', 'zoneName' => '&Eacute;vora', 'zoneCode' => 'EV', 'zoneStatus' => '1'],
            ['zoneId' => '2657', 'countryId' => '171', 'zoneName' => 'Faro', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '2658', 'countryId' => '171', 'zoneName' => 'Guarda', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '2659', 'countryId' => '171', 'zoneName' => 'Leiria', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '2660', 'countryId' => '171', 'zoneName' => 'Lisboa', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '2661', 'countryId' => '171', 'zoneName' => 'Madeira', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '2662', 'countryId' => '171', 'zoneName' => 'Portalegre', 'zoneCode' => 'PO', 'zoneStatus' => '1'],
            ['zoneId' => '2663', 'countryId' => '171', 'zoneName' => 'Porto', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '2664', 'countryId' => '171', 'zoneName' => 'Santar&eacute;m', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2665', 'countryId' => '171', 'zoneName' => 'Set&uacute;bal', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '2666', 'countryId' => '171', 'zoneName' => 'Viana do Castelo', 'zoneCode' => 'VC', 'zoneStatus' => '1'],
            ['zoneId' => '2667', 'countryId' => '171', 'zoneName' => 'Vila Real', 'zoneCode' => 'VR', 'zoneStatus' => '1'],
            ['zoneId' => '2668', 'countryId' => '171', 'zoneName' => 'Viseu', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '2669', 'countryId' => '173', 'zoneName' => 'Ad Dawhah', 'zoneCode' => 'DW', 'zoneStatus' => '1'],
            ['zoneId' => '2670', 'countryId' => '173', 'zoneName' => 'Al Ghuwayriyah', 'zoneCode' => 'GW', 'zoneStatus' => '1'],
            ['zoneId' => '2671', 'countryId' => '173', 'zoneName' => 'Al Jumayliyah', 'zoneCode' => 'JM', 'zoneStatus' => '1'],
            ['zoneId' => '2672', 'countryId' => '173', 'zoneName' => 'Al Khawr', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '2673', 'countryId' => '173', 'zoneName' => 'Al Wakrah', 'zoneCode' => 'WK', 'zoneStatus' => '1'],
            ['zoneId' => '2674', 'countryId' => '173', 'zoneName' => 'Ar Rayyan', 'zoneCode' => 'RN', 'zoneStatus' => '1'],
            ['zoneId' => '2675', 'countryId' => '173', 'zoneName' => 'Jarayan al Batinah', 'zoneCode' => 'JB', 'zoneStatus' => '1'],
            ['zoneId' => '2676', 'countryId' => '173', 'zoneName' => 'Madinat ash Shamal', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '2677', 'countryId' => '173', 'zoneName' => 'Umm Sa\'id', 'zoneCode' => 'UD', 'zoneStatus' => '1'],
            ['zoneId' => '2678', 'countryId' => '173', 'zoneName' => 'Umm Salal', 'zoneCode' => 'UL', 'zoneStatus' => '1'],
            ['zoneId' => '2679', 'countryId' => '175', 'zoneName' => 'Alba', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '2680', 'countryId' => '175', 'zoneName' => 'Arad', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '2681', 'countryId' => '175', 'zoneName' => 'Arges', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '2682', 'countryId' => '175', 'zoneName' => 'Bacau', 'zoneCode' => 'BC', 'zoneStatus' => '1'],
            ['zoneId' => '2683', 'countryId' => '175', 'zoneName' => 'Bihor', 'zoneCode' => 'BH', 'zoneStatus' => '1'],
            ['zoneId' => '2684', 'countryId' => '175', 'zoneName' => 'Bistrita-Nasaud', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '2685', 'countryId' => '175', 'zoneName' => 'Botosani', 'zoneCode' => 'BT', 'zoneStatus' => '1'],
            ['zoneId' => '2686', 'countryId' => '175', 'zoneName' => 'Brasov', 'zoneCode' => 'BV', 'zoneStatus' => '1'],
            ['zoneId' => '2687', 'countryId' => '175', 'zoneName' => 'Braila', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '2688', 'countryId' => '175', 'zoneName' => 'Bucuresti', 'zoneCode' => 'B', 'zoneStatus' => '1'],
            ['zoneId' => '2689', 'countryId' => '175', 'zoneName' => 'Buzau', 'zoneCode' => 'BZ', 'zoneStatus' => '1'],
            ['zoneId' => '2690', 'countryId' => '175', 'zoneName' => 'Caras-Severin', 'zoneCode' => 'CS', 'zoneStatus' => '1'],
            ['zoneId' => '2691', 'countryId' => '175', 'zoneName' => 'Calarasi', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '2692', 'countryId' => '175', 'zoneName' => 'Cluj', 'zoneCode' => 'CJ', 'zoneStatus' => '1'],
            ['zoneId' => '2693', 'countryId' => '175', 'zoneName' => 'Constanta', 'zoneCode' => 'CT', 'zoneStatus' => '1'],
            ['zoneId' => '2694', 'countryId' => '175', 'zoneName' => 'Covasna', 'zoneCode' => 'CV', 'zoneStatus' => '1'],
            ['zoneId' => '2695', 'countryId' => '175', 'zoneName' => 'Dimbovita', 'zoneCode' => 'DB', 'zoneStatus' => '1'],
            ['zoneId' => '2696', 'countryId' => '175', 'zoneName' => 'Dolj', 'zoneCode' => 'DJ', 'zoneStatus' => '1'],
            ['zoneId' => '2697', 'countryId' => '175', 'zoneName' => 'Galati', 'zoneCode' => 'GL', 'zoneStatus' => '1'],
            ['zoneId' => '2698', 'countryId' => '175', 'zoneName' => 'Giurgiu', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '2699', 'countryId' => '175', 'zoneName' => 'Gorj', 'zoneCode' => 'GJ', 'zoneStatus' => '1'],
            ['zoneId' => '2700', 'countryId' => '175', 'zoneName' => 'Harghita', 'zoneCode' => 'HR', 'zoneStatus' => '1'],
            ['zoneId' => '2701', 'countryId' => '175', 'zoneName' => 'Hunedoara', 'zoneCode' => 'HD', 'zoneStatus' => '1'],
            ['zoneId' => '2702', 'countryId' => '175', 'zoneName' => 'Ialomita', 'zoneCode' => 'IL', 'zoneStatus' => '1'],
            ['zoneId' => '2703', 'countryId' => '175', 'zoneName' => 'Iasi', 'zoneCode' => 'IS', 'zoneStatus' => '1'],
            ['zoneId' => '2704', 'countryId' => '175', 'zoneName' => 'Ilfov', 'zoneCode' => 'IF', 'zoneStatus' => '1'],
            ['zoneId' => '2705', 'countryId' => '175', 'zoneName' => 'Maramures', 'zoneCode' => 'MM', 'zoneStatus' => '1'],
            ['zoneId' => '2706', 'countryId' => '175', 'zoneName' => 'Mehedinti', 'zoneCode' => 'MH', 'zoneStatus' => '1'],
            ['zoneId' => '2707', 'countryId' => '175', 'zoneName' => 'Mures', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '2708', 'countryId' => '175', 'zoneName' => 'Neamt', 'zoneCode' => 'NT', 'zoneStatus' => '1'],
            ['zoneId' => '2709', 'countryId' => '175', 'zoneName' => 'Olt', 'zoneCode' => 'OT', 'zoneStatus' => '1'],
            ['zoneId' => '2710', 'countryId' => '175', 'zoneName' => 'Prahova', 'zoneCode' => 'PH', 'zoneStatus' => '1'],
            ['zoneId' => '2711', 'countryId' => '175', 'zoneName' => 'Satu-Mare', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '2712', 'countryId' => '175', 'zoneName' => 'Salaj', 'zoneCode' => 'SJ', 'zoneStatus' => '1'],
            ['zoneId' => '2713', 'countryId' => '175', 'zoneName' => 'Sibiu', 'zoneCode' => 'SB', 'zoneStatus' => '1'],
            ['zoneId' => '2714', 'countryId' => '175', 'zoneName' => 'Suceava', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '2715', 'countryId' => '175', 'zoneName' => 'Teleorman', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '2716', 'countryId' => '175', 'zoneName' => 'Timis', 'zoneCode' => 'TM', 'zoneStatus' => '1'],
            ['zoneId' => '2717', 'countryId' => '175', 'zoneName' => 'Tulcea', 'zoneCode' => 'TL', 'zoneStatus' => '1'],
            ['zoneId' => '2718', 'countryId' => '175', 'zoneName' => 'Vaslui', 'zoneCode' => 'VS', 'zoneStatus' => '1'],
            ['zoneId' => '2719', 'countryId' => '175', 'zoneName' => 'Valcea', 'zoneCode' => 'VL', 'zoneStatus' => '1'],
            ['zoneId' => '2720', 'countryId' => '175', 'zoneName' => 'Vrancea', 'zoneCode' => 'VN', 'zoneStatus' => '1'],
            ['zoneId' => '2721', 'countryId' => '176', 'zoneName' => 'Abakan', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '2722', 'countryId' => '176', 'zoneName' => 'Aginskoye', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '2723', 'countryId' => '176', 'zoneName' => 'Anadyr', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '2724', 'countryId' => '176', 'zoneName' => 'Arkahangelsk', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '2725', 'countryId' => '176', 'zoneName' => 'Astrakhan', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '2726', 'countryId' => '176', 'zoneName' => 'Barnaul', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2727', 'countryId' => '176', 'zoneName' => 'Belgorod', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '2728', 'countryId' => '176', 'zoneName' => 'Birobidzhan', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '2729', 'countryId' => '176', 'zoneName' => 'Blagoveshchensk', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '2730', 'countryId' => '176', 'zoneName' => 'Bryansk', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '2731', 'countryId' => '176', 'zoneName' => 'Cheboksary', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2732', 'countryId' => '176', 'zoneName' => 'Chelyabinsk', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '2733', 'countryId' => '176', 'zoneName' => 'Cherkessk', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '2734', 'countryId' => '176', 'zoneName' => 'Chita', 'zoneCode' => 'CI', 'zoneStatus' => '1'],
            ['zoneId' => '2735', 'countryId' => '176', 'zoneName' => 'Dudinka', 'zoneCode' => 'DU', 'zoneStatus' => '1'],
            ['zoneId' => '2736', 'countryId' => '176', 'zoneName' => 'Elista', 'zoneCode' => 'EL', 'zoneStatus' => '1'],
            ['zoneId' => '2738', 'countryId' => '176', 'zoneName' => 'Gorno-Altaysk', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '2739', 'countryId' => '176', 'zoneName' => 'Groznyy', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '2740', 'countryId' => '176', 'zoneName' => 'Irkutsk', 'zoneCode' => 'IR', 'zoneStatus' => '1'],
            ['zoneId' => '2741', 'countryId' => '176', 'zoneName' => 'Ivanovo', 'zoneCode' => 'IV', 'zoneStatus' => '1'],
            ['zoneId' => '2742', 'countryId' => '176', 'zoneName' => 'Izhevsk', 'zoneCode' => 'IZ', 'zoneStatus' => '1'],
            ['zoneId' => '2743', 'countryId' => '176', 'zoneName' => 'Kalinigrad', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '2744', 'countryId' => '176', 'zoneName' => 'Kaluga', 'zoneCode' => 'KL', 'zoneStatus' => '1'],
            ['zoneId' => '2745', 'countryId' => '176', 'zoneName' => 'Kasnodar', 'zoneCode' => 'KS', 'zoneStatus' => '1'],
            ['zoneId' => '2746', 'countryId' => '176', 'zoneName' => 'Kazan', 'zoneCode' => 'KZ', 'zoneStatus' => '1'],
            ['zoneId' => '2747', 'countryId' => '176', 'zoneName' => 'Kemerovo', 'zoneCode' => 'KE', 'zoneStatus' => '1'],
            ['zoneId' => '2748', 'countryId' => '176', 'zoneName' => 'Khabarovsk', 'zoneCode' => 'KH', 'zoneStatus' => '1'],
            ['zoneId' => '2749', 'countryId' => '176', 'zoneName' => 'Khanty-Mansiysk', 'zoneCode' => 'KM', 'zoneStatus' => '1'],
            ['zoneId' => '2750', 'countryId' => '176', 'zoneName' => 'Kostroma', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '2751', 'countryId' => '176', 'zoneName' => 'Krasnodar', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '2752', 'countryId' => '176', 'zoneName' => 'Krasnoyarsk', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '2753', 'countryId' => '176', 'zoneName' => 'Kudymkar', 'zoneCode' => 'KU', 'zoneStatus' => '1'],
            ['zoneId' => '2754', 'countryId' => '176', 'zoneName' => 'Kurgan', 'zoneCode' => 'KG', 'zoneStatus' => '1'],
            ['zoneId' => '2755', 'countryId' => '176', 'zoneName' => 'Kursk', 'zoneCode' => 'KK', 'zoneStatus' => '1'],
            ['zoneId' => '2756', 'countryId' => '176', 'zoneName' => 'Kyzyl', 'zoneCode' => 'KY', 'zoneStatus' => '1'],
            ['zoneId' => '2757', 'countryId' => '176', 'zoneName' => 'Lipetsk', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '2758', 'countryId' => '176', 'zoneName' => 'Magadan', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '2759', 'countryId' => '176', 'zoneName' => 'Makhachkala', 'zoneCode' => 'MK', 'zoneStatus' => '1'],
            ['zoneId' => '2760', 'countryId' => '176', 'zoneName' => 'Maykop', 'zoneCode' => 'MY', 'zoneStatus' => '1'],
            ['zoneId' => '2761', 'countryId' => '176', 'zoneName' => 'Moscow', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '2762', 'countryId' => '176', 'zoneName' => 'Murmansk', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '2763', 'countryId' => '176', 'zoneName' => 'Nalchik', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '2764', 'countryId' => '176', 'zoneName' => 'Naryan Mar', 'zoneCode' => 'NR', 'zoneStatus' => '1'],
            ['zoneId' => '2765', 'countryId' => '176', 'zoneName' => 'Nazran', 'zoneCode' => 'NZ', 'zoneStatus' => '1'],
            ['zoneId' => '2766', 'countryId' => '176', 'zoneName' => 'Nizhniy Novgorod', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '2767', 'countryId' => '176', 'zoneName' => 'Novgorod', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '2768', 'countryId' => '176', 'zoneName' => 'Novosibirsk', 'zoneCode' => 'NV', 'zoneStatus' => '1'],
            ['zoneId' => '2769', 'countryId' => '176', 'zoneName' => 'Omsk', 'zoneCode' => 'OM', 'zoneStatus' => '1'],
            ['zoneId' => '2770', 'countryId' => '176', 'zoneName' => 'Orel', 'zoneCode' => 'OR', 'zoneStatus' => '1'],
            ['zoneId' => '2771', 'countryId' => '176', 'zoneName' => 'Orenburg', 'zoneCode' => 'OE', 'zoneStatus' => '1'],
            ['zoneId' => '2772', 'countryId' => '176', 'zoneName' => 'Palana', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '2773', 'countryId' => '176', 'zoneName' => 'Penza', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '2774', 'countryId' => '176', 'zoneName' => 'Perm', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '2775', 'countryId' => '176', 'zoneName' => 'Petropavlovsk-Kamchatskiy', 'zoneCode' => 'PK', 'zoneStatus' => '1'],
            ['zoneId' => '2776', 'countryId' => '176', 'zoneName' => 'Petrozavodsk', 'zoneCode' => 'PT', 'zoneStatus' => '1'],
            ['zoneId' => '2777', 'countryId' => '176', 'zoneName' => 'Pskov', 'zoneCode' => 'PS', 'zoneStatus' => '1'],
            ['zoneId' => '2778', 'countryId' => '176', 'zoneName' => 'Rostov-na-Donu', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '2779', 'countryId' => '176', 'zoneName' => 'Ryazan', 'zoneCode' => 'RY', 'zoneStatus' => '1'],
            ['zoneId' => '2780', 'countryId' => '176', 'zoneName' => 'Salekhard', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '2781', 'countryId' => '176', 'zoneName' => 'Samara', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2782', 'countryId' => '176', 'zoneName' => 'Saransk', 'zoneCode' => 'SR', 'zoneStatus' => '1'],
            ['zoneId' => '2783', 'countryId' => '176', 'zoneName' => 'Saratov', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '2784', 'countryId' => '176', 'zoneName' => 'Smolensk', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '2785', 'countryId' => '176', 'zoneName' => 'St. Petersburg', 'zoneCode' => 'SP', 'zoneStatus' => '1'],
            ['zoneId' => '2786', 'countryId' => '176', 'zoneName' => 'Stavropol', 'zoneCode' => 'ST', 'zoneStatus' => '1'],
            ['zoneId' => '2787', 'countryId' => '176', 'zoneName' => 'Syktyvkar', 'zoneCode' => 'SY', 'zoneStatus' => '1'],
            ['zoneId' => '2788', 'countryId' => '176', 'zoneName' => 'Tambov', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '2789', 'countryId' => '176', 'zoneName' => 'Tomsk', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '2790', 'countryId' => '176', 'zoneName' => 'Tula', 'zoneCode' => 'TU', 'zoneStatus' => '1'],
            ['zoneId' => '2791', 'countryId' => '176', 'zoneName' => 'Tura', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '2792', 'countryId' => '176', 'zoneName' => 'Tver', 'zoneCode' => 'TV', 'zoneStatus' => '1'],
            ['zoneId' => '2793', 'countryId' => '176', 'zoneName' => 'Tyumen', 'zoneCode' => 'TY', 'zoneStatus' => '1'],
            ['zoneId' => '2794', 'countryId' => '176', 'zoneName' => 'Ufa', 'zoneCode' => 'UF', 'zoneStatus' => '1'],
            ['zoneId' => '2795', 'countryId' => '176', 'zoneName' => 'Ul\'yanovsk', 'zoneCode' => 'UL', 'zoneStatus' => '1'],
            ['zoneId' => '2796', 'countryId' => '176', 'zoneName' => 'Ulan-Ude', 'zoneCode' => 'UU', 'zoneStatus' => '1'],
            ['zoneId' => '2797', 'countryId' => '176', 'zoneName' => 'Ust\'-Ordynskiy', 'zoneCode' => 'US', 'zoneStatus' => '1'],
            ['zoneId' => '2798', 'countryId' => '176', 'zoneName' => 'Vladikavkaz', 'zoneCode' => 'VL', 'zoneStatus' => '1'],
            ['zoneId' => '2799', 'countryId' => '176', 'zoneName' => 'Vladimir', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '2800', 'countryId' => '176', 'zoneName' => 'Vladivostok', 'zoneCode' => 'VV', 'zoneStatus' => '1'],
            ['zoneId' => '2801', 'countryId' => '176', 'zoneName' => 'Volgograd', 'zoneCode' => 'VG', 'zoneStatus' => '1'],
            ['zoneId' => '2802', 'countryId' => '176', 'zoneName' => 'Vologda', 'zoneCode' => 'VD', 'zoneStatus' => '1'],
            ['zoneId' => '2803', 'countryId' => '176', 'zoneName' => 'Voronezh', 'zoneCode' => 'VO', 'zoneStatus' => '1'],
            ['zoneId' => '2804', 'countryId' => '176', 'zoneName' => 'Vyatka', 'zoneCode' => 'VY', 'zoneStatus' => '1'],
            ['zoneId' => '2805', 'countryId' => '176', 'zoneName' => 'Yakutsk', 'zoneCode' => 'YA', 'zoneStatus' => '1'],
            ['zoneId' => '2806', 'countryId' => '176', 'zoneName' => 'Yaroslavl', 'zoneCode' => 'YR', 'zoneStatus' => '1'],
            ['zoneId' => '2807', 'countryId' => '176', 'zoneName' => 'Yekaterinburg', 'zoneCode' => 'YE', 'zoneStatus' => '1'],
            ['zoneId' => '2808', 'countryId' => '176', 'zoneName' => 'Yoshkar-Ola', 'zoneCode' => 'YO', 'zoneStatus' => '1'],
            ['zoneId' => '2809', 'countryId' => '177', 'zoneName' => 'Butare', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '2810', 'countryId' => '177', 'zoneName' => 'Byumba', 'zoneCode' => 'BY', 'zoneStatus' => '1'],
            ['zoneId' => '2811', 'countryId' => '177', 'zoneName' => 'Cyangugu', 'zoneCode' => 'CY', 'zoneStatus' => '1'],
            ['zoneId' => '2812', 'countryId' => '177', 'zoneName' => 'Gikongoro', 'zoneCode' => 'GK', 'zoneStatus' => '1'],
            ['zoneId' => '2813', 'countryId' => '177', 'zoneName' => 'Gisenyi', 'zoneCode' => 'GS', 'zoneStatus' => '1'],
            ['zoneId' => '2814', 'countryId' => '177', 'zoneName' => 'Gitarama', 'zoneCode' => 'GT', 'zoneStatus' => '1'],
            ['zoneId' => '2815', 'countryId' => '177', 'zoneName' => 'Kibungo', 'zoneCode' => 'KG', 'zoneStatus' => '1'],
            ['zoneId' => '2816', 'countryId' => '177', 'zoneName' => 'Kibuye', 'zoneCode' => 'KY', 'zoneStatus' => '1'],
            ['zoneId' => '2817', 'countryId' => '177', 'zoneName' => 'Kigali Rurale', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '2818', 'countryId' => '177', 'zoneName' => 'Kigali-ville', 'zoneCode' => 'KV', 'zoneStatus' => '1'],
            ['zoneId' => '2819', 'countryId' => '177', 'zoneName' => 'Ruhengeri', 'zoneCode' => 'RU', 'zoneStatus' => '1'],
            ['zoneId' => '2820', 'countryId' => '177', 'zoneName' => 'Umutara', 'zoneCode' => 'UM', 'zoneStatus' => '1'],
            ['zoneId' => '2821', 'countryId' => '178', 'zoneName' => 'Christ Church Nichola Town', 'zoneCode' => 'CCN', 'zoneStatus' => '1'],
            ['zoneId' => '2822', 'countryId' => '178', 'zoneName' => 'Saint Anne Sandy Point', 'zoneCode' => 'SAS', 'zoneStatus' => '1'],
            ['zoneId' => '2823', 'countryId' => '178', 'zoneName' => 'Saint George Basseterre', 'zoneCode' => 'SGB', 'zoneStatus' => '1'],
            ['zoneId' => '2824', 'countryId' => '178', 'zoneName' => 'Saint George Gingerland', 'zoneCode' => 'SGG', 'zoneStatus' => '1'],
            ['zoneId' => '2825', 'countryId' => '178', 'zoneName' => 'Saint James Windward', 'zoneCode' => 'SJW', 'zoneStatus' => '1'],
            ['zoneId' => '2826', 'countryId' => '178', 'zoneName' => 'Saint John Capesterre', 'zoneCode' => 'SJC', 'zoneStatus' => '1'],
            ['zoneId' => '2827', 'countryId' => '178', 'zoneName' => 'Saint John Figtree', 'zoneCode' => 'SJF', 'zoneStatus' => '1'],
            ['zoneId' => '2828', 'countryId' => '178', 'zoneName' => 'Saint Mary Cayon', 'zoneCode' => 'SMC', 'zoneStatus' => '1'],
            ['zoneId' => '2829', 'countryId' => '178', 'zoneName' => 'Saint Paul Capesterre', 'zoneCode' => 'CAP', 'zoneStatus' => '1'],
            ['zoneId' => '2830', 'countryId' => '178', 'zoneName' => 'Saint Paul Charlestown', 'zoneCode' => 'CHA', 'zoneStatus' => '1'],
            ['zoneId' => '2831', 'countryId' => '178', 'zoneName' => 'Saint Peter Basseterre', 'zoneCode' => 'SPB', 'zoneStatus' => '1'],
            ['zoneId' => '2832', 'countryId' => '178', 'zoneName' => 'Saint Thomas Lowland', 'zoneCode' => 'STL', 'zoneStatus' => '1'],
            ['zoneId' => '2833', 'countryId' => '178', 'zoneName' => 'Saint Thomas Middle Island', 'zoneCode' => 'STM', 'zoneStatus' => '1'],
            ['zoneId' => '2834', 'countryId' => '178', 'zoneName' => 'Trinity Palmetto Point', 'zoneCode' => 'TPP', 'zoneStatus' => '1'],
            ['zoneId' => '2835', 'countryId' => '179', 'zoneName' => 'Anse-la-Raye', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '2836', 'countryId' => '179', 'zoneName' => 'Castries', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '2837', 'countryId' => '179', 'zoneName' => 'Choiseul', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2838', 'countryId' => '179', 'zoneName' => 'Dauphin', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '2839', 'countryId' => '179', 'zoneName' => 'Dennery', 'zoneCode' => 'DE', 'zoneStatus' => '1'],
            ['zoneId' => '2840', 'countryId' => '179', 'zoneName' => 'Gros-Islet', 'zoneCode' => 'GI', 'zoneStatus' => '1'],
            ['zoneId' => '2841', 'countryId' => '179', 'zoneName' => 'Laborie', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '2842', 'countryId' => '179', 'zoneName' => 'Micoud', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '2843', 'countryId' => '179', 'zoneName' => 'Praslin', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '2844', 'countryId' => '179', 'zoneName' => 'Soufriere', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '2845', 'countryId' => '179', 'zoneName' => 'Vieux-Fort', 'zoneCode' => 'VF', 'zoneStatus' => '1'],
            ['zoneId' => '2846', 'countryId' => '180', 'zoneName' => 'Charlotte', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '2847', 'countryId' => '180', 'zoneName' => 'Grenadines', 'zoneCode' => 'R', 'zoneStatus' => '1'],
            ['zoneId' => '2848', 'countryId' => '180', 'zoneName' => 'Saint Andrew', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '2849', 'countryId' => '180', 'zoneName' => 'Saint David', 'zoneCode' => 'D', 'zoneStatus' => '1'],
            ['zoneId' => '2850', 'countryId' => '180', 'zoneName' => 'Saint George', 'zoneCode' => 'G', 'zoneStatus' => '1'],
            ['zoneId' => '2851', 'countryId' => '180', 'zoneName' => 'Saint Patrick', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '2852', 'countryId' => '181', 'zoneName' => 'A\'ana', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '2853', 'countryId' => '181', 'zoneName' => 'Aiga-i-le-Tai', 'zoneCode' => 'AI', 'zoneStatus' => '1'],
            ['zoneId' => '2854', 'countryId' => '181', 'zoneName' => 'Atua', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '2855', 'countryId' => '181', 'zoneName' => 'Fa\'asaleleaga', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '2856', 'countryId' => '181', 'zoneName' => 'Gaga\'emauga', 'zoneCode' => 'GE', 'zoneStatus' => '1'],
            ['zoneId' => '2857', 'countryId' => '181', 'zoneName' => 'Gagaifomauga', 'zoneCode' => 'GF', 'zoneStatus' => '1'],
            ['zoneId' => '2858', 'countryId' => '181', 'zoneName' => 'Palauli', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '2859', 'countryId' => '181', 'zoneName' => 'Satupa\'itea', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2860', 'countryId' => '181', 'zoneName' => 'Tuamasaga', 'zoneCode' => 'TU', 'zoneStatus' => '1'],
            ['zoneId' => '2861', 'countryId' => '181', 'zoneName' => 'Va\'a-o-Fonoti', 'zoneCode' => 'VF', 'zoneStatus' => '1'],
            ['zoneId' => '2862', 'countryId' => '181', 'zoneName' => 'Vaisigano', 'zoneCode' => 'VS', 'zoneStatus' => '1'],
            ['zoneId' => '2863', 'countryId' => '182', 'zoneName' => 'Acquaviva', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '2864', 'countryId' => '182', 'zoneName' => 'Borgo Maggiore', 'zoneCode' => 'BM', 'zoneStatus' => '1'],
            ['zoneId' => '2865', 'countryId' => '182', 'zoneName' => 'Chiesanuova', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2866', 'countryId' => '182', 'zoneName' => 'Domagnano', 'zoneCode' => 'DO', 'zoneStatus' => '1'],
            ['zoneId' => '2867', 'countryId' => '182', 'zoneName' => 'Faetano', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '2868', 'countryId' => '182', 'zoneName' => 'Fiorentino', 'zoneCode' => 'FI', 'zoneStatus' => '1'],
            ['zoneId' => '2869', 'countryId' => '182', 'zoneName' => 'Montegiardino', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '2870', 'countryId' => '182', 'zoneName' => 'Citta di San Marino', 'zoneCode' => 'SM', 'zoneStatus' => '1'],
            ['zoneId' => '2871', 'countryId' => '182', 'zoneName' => 'Serravalle', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '2872', 'countryId' => '183', 'zoneName' => 'Sao Tome', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '2873', 'countryId' => '183', 'zoneName' => 'Principe', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '2874', 'countryId' => '184', 'zoneName' => 'Al Bahah', 'zoneCode' => 'BH', 'zoneStatus' => '1'],
            ['zoneId' => '2875', 'countryId' => '184', 'zoneName' => 'Al Hudud ash Shamaliyah', 'zoneCode' => 'HS', 'zoneStatus' => '1'],
            ['zoneId' => '2876', 'countryId' => '184', 'zoneName' => 'Al Jawf', 'zoneCode' => 'JF', 'zoneStatus' => '1'],
            ['zoneId' => '2877', 'countryId' => '184', 'zoneName' => 'Al Madinah', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '2878', 'countryId' => '184', 'zoneName' => 'Al Qasim', 'zoneCode' => 'QS', 'zoneStatus' => '1'],
            ['zoneId' => '2879', 'countryId' => '184', 'zoneName' => 'Ar Riyad', 'zoneCode' => 'RD', 'zoneStatus' => '1'],
            ['zoneId' => '2880', 'countryId' => '184', 'zoneName' => 'Ash Sharqiyah (Eastern)', 'zoneCode' => 'AQ', 'zoneStatus' => '1'],
            ['zoneId' => '2881', 'countryId' => '184', 'zoneName' => '\'Asir', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '2882', 'countryId' => '184', 'zoneName' => 'Ha\'il', 'zoneCode' => 'HL', 'zoneStatus' => '1'],
            ['zoneId' => '2883', 'countryId' => '184', 'zoneName' => 'Jizan', 'zoneCode' => 'JZ', 'zoneStatus' => '1'],
            ['zoneId' => '2884', 'countryId' => '184', 'zoneName' => 'Makkah', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '2885', 'countryId' => '184', 'zoneName' => 'Najran', 'zoneCode' => 'NR', 'zoneStatus' => '1'],
            ['zoneId' => '2886', 'countryId' => '184', 'zoneName' => 'Tabuk', 'zoneCode' => 'TB', 'zoneStatus' => '1'],
            ['zoneId' => '2887', 'countryId' => '185', 'zoneName' => 'Dakar', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '2888', 'countryId' => '185', 'zoneName' => 'Diourbel', 'zoneCode' => 'DI', 'zoneStatus' => '1'],
            ['zoneId' => '2889', 'countryId' => '185', 'zoneName' => 'Fatick', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '2890', 'countryId' => '185', 'zoneName' => 'Kaolack', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '2891', 'countryId' => '185', 'zoneName' => 'Kolda', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '2892', 'countryId' => '185', 'zoneName' => 'Louga', 'zoneCode' => 'LO', 'zoneStatus' => '1'],
            ['zoneId' => '2893', 'countryId' => '185', 'zoneName' => 'Matam', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '2894', 'countryId' => '185', 'zoneName' => 'Saint-Louis', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '2895', 'countryId' => '185', 'zoneName' => 'Tambacounda', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '2896', 'countryId' => '185', 'zoneName' => 'Thies', 'zoneCode' => 'TH', 'zoneStatus' => '1'],
            ['zoneId' => '2897', 'countryId' => '185', 'zoneName' => 'Ziguinchor', 'zoneCode' => 'ZI', 'zoneStatus' => '1'],
            ['zoneId' => '2898', 'countryId' => '186', 'zoneName' => 'Anse aux Pins', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '2899', 'countryId' => '186', 'zoneName' => 'Anse Boileau', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '2900', 'countryId' => '186', 'zoneName' => 'Anse Etoile', 'zoneCode' => 'AE', 'zoneStatus' => '1'],
            ['zoneId' => '2901', 'countryId' => '186', 'zoneName' => 'Anse Louis', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '2902', 'countryId' => '186', 'zoneName' => 'Anse Royale', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '2903', 'countryId' => '186', 'zoneName' => 'Baie Lazare', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '2904', 'countryId' => '186', 'zoneName' => 'Baie Sainte Anne', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '2905', 'countryId' => '186', 'zoneName' => 'Beau Vallon', 'zoneCode' => 'BV', 'zoneStatus' => '1'],
            ['zoneId' => '2906', 'countryId' => '186', 'zoneName' => 'Bel Air', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2907', 'countryId' => '186', 'zoneName' => 'Bel Ombre', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '2908', 'countryId' => '186', 'zoneName' => 'Cascade', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '2909', 'countryId' => '186', 'zoneName' => 'Glacis', 'zoneCode' => 'GL', 'zoneStatus' => '1'],
            ['zoneId' => '2910', 'countryId' => '186', 'zoneName' => 'Grand\' Anse (on Mahe)', 'zoneCode' => 'GM', 'zoneStatus' => '1'],
            ['zoneId' => '2911', 'countryId' => '186', 'zoneName' => 'Grand\' Anse (on Praslin)', 'zoneCode' => 'GP', 'zoneStatus' => '1'],
            ['zoneId' => '2912', 'countryId' => '186', 'zoneName' => 'La Digue', 'zoneCode' => 'DG', 'zoneStatus' => '1'],
            ['zoneId' => '2913', 'countryId' => '186', 'zoneName' => 'La Riviere Anglaise', 'zoneCode' => 'RA', 'zoneStatus' => '1'],
            ['zoneId' => '2914', 'countryId' => '186', 'zoneName' => 'Mont Buxton', 'zoneCode' => 'MB', 'zoneStatus' => '1'],
            ['zoneId' => '2915', 'countryId' => '186', 'zoneName' => 'Mont Fleuri', 'zoneCode' => 'MF', 'zoneStatus' => '1'],
            ['zoneId' => '2916', 'countryId' => '186', 'zoneName' => 'Plaisance', 'zoneCode' => 'PL', 'zoneStatus' => '1'],
            ['zoneId' => '2917', 'countryId' => '186', 'zoneName' => 'Pointe La Rue', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '2918', 'countryId' => '186', 'zoneName' => 'Port Glaud', 'zoneCode' => 'PG', 'zoneStatus' => '1'],
            ['zoneId' => '2919', 'countryId' => '186', 'zoneName' => 'Saint Louis', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '2920', 'countryId' => '186', 'zoneName' => 'Takamaka', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '2921', 'countryId' => '187', 'zoneName' => 'Eastern', 'zoneCode' => 'E', 'zoneStatus' => '1'],
            ['zoneId' => '2922', 'countryId' => '187', 'zoneName' => 'Northern', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '2923', 'countryId' => '187', 'zoneName' => 'Southern', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '2924', 'countryId' => '187', 'zoneName' => 'Western', 'zoneCode' => 'W', 'zoneStatus' => '1'],
            ['zoneId' => '2925', 'countryId' => '189', 'zoneName' => 'Banskobystrický', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2926', 'countryId' => '189', 'zoneName' => 'Bratislavský', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '2927', 'countryId' => '189', 'zoneName' => 'Košický', 'zoneCode' => 'KO', 'zoneStatus' => '1'],
            ['zoneId' => '2928', 'countryId' => '189', 'zoneName' => 'Nitriansky', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '2929', 'countryId' => '189', 'zoneName' => 'Prešovský', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '2930', 'countryId' => '189', 'zoneName' => 'Trenčiansky', 'zoneCode' => 'TC', 'zoneStatus' => '1'],
            ['zoneId' => '2931', 'countryId' => '189', 'zoneName' => 'Trnavský', 'zoneCode' => 'TV', 'zoneStatus' => '1'],
            ['zoneId' => '2932', 'countryId' => '189', 'zoneName' => 'Žilinský', 'zoneCode' => 'ZI', 'zoneStatus' => '1'],
            ['zoneId' => '2933', 'countryId' => '191', 'zoneName' => 'Central', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '2934', 'countryId' => '191', 'zoneName' => 'Choiseul', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '2935', 'countryId' => '191', 'zoneName' => 'Guadalcanal', 'zoneCode' => 'GC', 'zoneStatus' => '1'],
            ['zoneId' => '2936', 'countryId' => '191', 'zoneName' => 'Honiara', 'zoneCode' => 'HO', 'zoneStatus' => '1'],
            ['zoneId' => '2937', 'countryId' => '191', 'zoneName' => 'Isabel', 'zoneCode' => 'IS', 'zoneStatus' => '1'],
            ['zoneId' => '2938', 'countryId' => '191', 'zoneName' => 'Makira', 'zoneCode' => 'MK', 'zoneStatus' => '1'],
            ['zoneId' => '2939', 'countryId' => '191', 'zoneName' => 'Malaita', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '2940', 'countryId' => '191', 'zoneName' => 'Rennell and Bellona', 'zoneCode' => 'RB', 'zoneStatus' => '1'],
            ['zoneId' => '2941', 'countryId' => '191', 'zoneName' => 'Temotu', 'zoneCode' => 'TM', 'zoneStatus' => '1'],
            ['zoneId' => '2942', 'countryId' => '191', 'zoneName' => 'Western', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '2943', 'countryId' => '192', 'zoneName' => 'Awdal', 'zoneCode' => 'AW', 'zoneStatus' => '1'],
            ['zoneId' => '2944', 'countryId' => '192', 'zoneName' => 'Bakool', 'zoneCode' => 'BK', 'zoneStatus' => '1'],
            ['zoneId' => '2945', 'countryId' => '192', 'zoneName' => 'Banaadir', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '2946', 'countryId' => '192', 'zoneName' => 'Bari', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '2947', 'countryId' => '192', 'zoneName' => 'Bay', 'zoneCode' => 'BY', 'zoneStatus' => '1'],
            ['zoneId' => '2948', 'countryId' => '192', 'zoneName' => 'Galguduud', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '2949', 'countryId' => '192', 'zoneName' => 'Gedo', 'zoneCode' => 'GE', 'zoneStatus' => '1'],
            ['zoneId' => '2950', 'countryId' => '192', 'zoneName' => 'Hiiraan', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '2951', 'countryId' => '192', 'zoneName' => 'Jubbada Dhexe', 'zoneCode' => 'JD', 'zoneStatus' => '1'],
            ['zoneId' => '2952', 'countryId' => '192', 'zoneName' => 'Jubbada Hoose', 'zoneCode' => 'JH', 'zoneStatus' => '1'],
            ['zoneId' => '2953', 'countryId' => '192', 'zoneName' => 'Mudug', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '2954', 'countryId' => '192', 'zoneName' => 'Nugaal', 'zoneCode' => 'NU', 'zoneStatus' => '1'],
            ['zoneId' => '2955', 'countryId' => '192', 'zoneName' => 'Sanaag', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '2956', 'countryId' => '192', 'zoneName' => 'Shabeellaha Dhexe', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '2957', 'countryId' => '192', 'zoneName' => 'Shabeellaha Hoose', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '2958', 'countryId' => '192', 'zoneName' => 'Sool', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '2959', 'countryId' => '192', 'zoneName' => 'Togdheer', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '2960', 'countryId' => '192', 'zoneName' => 'Woqooyi Galbeed', 'zoneCode' => 'WG', 'zoneStatus' => '1'],
            ['zoneId' => '2961', 'countryId' => '193', 'zoneName' => 'Eastern Cape', 'zoneCode' => 'EC', 'zoneStatus' => '1'],
            ['zoneId' => '2962', 'countryId' => '193', 'zoneName' => 'Free State', 'zoneCode' => 'FS', 'zoneStatus' => '1'],
            ['zoneId' => '2963', 'countryId' => '193', 'zoneName' => 'Gauteng', 'zoneCode' => 'GT', 'zoneStatus' => '1'],
            ['zoneId' => '2964', 'countryId' => '193', 'zoneName' => 'KwaZulu-Natal', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '2965', 'countryId' => '193', 'zoneName' => 'Limpopo', 'zoneCode' => 'LP', 'zoneStatus' => '1'],
            ['zoneId' => '2966', 'countryId' => '193', 'zoneName' => 'Mpumalanga', 'zoneCode' => 'MP', 'zoneStatus' => '1'],
            ['zoneId' => '2967', 'countryId' => '193', 'zoneName' => 'North West', 'zoneCode' => 'NW', 'zoneStatus' => '1'],
            ['zoneId' => '2968', 'countryId' => '193', 'zoneName' => 'Northern Cape', 'zoneCode' => 'NC', 'zoneStatus' => '1'],
            ['zoneId' => '2969', 'countryId' => '193', 'zoneName' => 'Western Cape', 'zoneCode' => 'WC', 'zoneStatus' => '1'],
            ['zoneId' => '2970', 'countryId' => '195', 'zoneName' => 'La Coru&ntilde;a', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '2971', 'countryId' => '195', 'zoneName' => '&Aacute;lava', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '2972', 'countryId' => '195', 'zoneName' => 'Albacete', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '2973', 'countryId' => '195', 'zoneName' => 'Alicante', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '2974', 'countryId' => '195', 'zoneName' => 'Almeria', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '2975', 'countryId' => '195', 'zoneName' => 'Asturias', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '2976', 'countryId' => '195', 'zoneName' => '&Aacute;vila', 'zoneCode' => 'AV', 'zoneStatus' => '1'],
            ['zoneId' => '2977', 'countryId' => '195', 'zoneName' => 'Badajoz', 'zoneCode' => 'BJ', 'zoneStatus' => '1'],
            ['zoneId' => '2978', 'countryId' => '195', 'zoneName' => 'Baleares', 'zoneCode' => 'IB', 'zoneStatus' => '1'],
            ['zoneId' => '2979', 'countryId' => '195', 'zoneName' => 'Barcelona', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '2980', 'countryId' => '195', 'zoneName' => 'Burgos', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '2981', 'countryId' => '195', 'zoneName' => 'C&aacute;ceres', 'zoneCode' => 'CC', 'zoneStatus' => '1'],
            ['zoneId' => '2982', 'countryId' => '195', 'zoneName' => 'C&aacute;diz', 'zoneCode' => 'CZ', 'zoneStatus' => '1'],
            ['zoneId' => '2983', 'countryId' => '195', 'zoneName' => 'Cantabria', 'zoneCode' => 'CT', 'zoneStatus' => '1'],
            ['zoneId' => '2984', 'countryId' => '195', 'zoneName' => 'Castell&oacute;n', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '2985', 'countryId' => '195', 'zoneName' => 'Ceuta', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '2986', 'countryId' => '195', 'zoneName' => 'Ciudad Real', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '2987', 'countryId' => '195', 'zoneName' => 'C&oacute;rdoba', 'zoneCode' => 'CD', 'zoneStatus' => '1'],
            ['zoneId' => '2988', 'countryId' => '195', 'zoneName' => 'Cuenca', 'zoneCode' => 'CU', 'zoneStatus' => '1'],
            ['zoneId' => '2989', 'countryId' => '195', 'zoneName' => 'Girona', 'zoneCode' => 'GI', 'zoneStatus' => '1'],
            ['zoneId' => '2990', 'countryId' => '195', 'zoneName' => 'Granada', 'zoneCode' => 'GD', 'zoneStatus' => '1'],
            ['zoneId' => '2991', 'countryId' => '195', 'zoneName' => 'Guadalajara', 'zoneCode' => 'GJ', 'zoneStatus' => '1'],
            ['zoneId' => '2992', 'countryId' => '195', 'zoneName' => 'Guip&uacute;zcoa', 'zoneCode' => 'GP', 'zoneStatus' => '1'],
            ['zoneId' => '2993', 'countryId' => '195', 'zoneName' => 'Huelva', 'zoneCode' => 'HL', 'zoneStatus' => '1'],
            ['zoneId' => '2994', 'countryId' => '195', 'zoneName' => 'Huesca', 'zoneCode' => 'HS', 'zoneStatus' => '1'],
            ['zoneId' => '2995', 'countryId' => '195', 'zoneName' => 'Ja&eacute;n', 'zoneCode' => 'JN', 'zoneStatus' => '1'],
            ['zoneId' => '2996', 'countryId' => '195', 'zoneName' => 'La Rioja', 'zoneCode' => 'RJ', 'zoneStatus' => '1'],
            ['zoneId' => '2997', 'countryId' => '195', 'zoneName' => 'Las Palmas', 'zoneCode' => 'PM', 'zoneStatus' => '1'],
            ['zoneId' => '2998', 'countryId' => '195', 'zoneName' => 'Leon', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '2999', 'countryId' => '195', 'zoneName' => 'Lleida', 'zoneCode' => 'LL', 'zoneStatus' => '1'],
            ['zoneId' => '3000', 'countryId' => '195', 'zoneName' => 'Lugo', 'zoneCode' => 'LG', 'zoneStatus' => '1'],
            ['zoneId' => '3001', 'countryId' => '195', 'zoneName' => 'Madrid', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '3002', 'countryId' => '195', 'zoneName' => 'Malaga', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3003', 'countryId' => '195', 'zoneName' => 'Melilla', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '3004', 'countryId' => '195', 'zoneName' => 'Murcia', 'zoneCode' => 'MU', 'zoneStatus' => '1'],
            ['zoneId' => '3005', 'countryId' => '195', 'zoneName' => 'Navarra', 'zoneCode' => 'NV', 'zoneStatus' => '1'],
            ['zoneId' => '3006', 'countryId' => '195', 'zoneName' => 'Ourense', 'zoneCode' => 'OU', 'zoneStatus' => '1'],
            ['zoneId' => '3007', 'countryId' => '195', 'zoneName' => 'Palencia', 'zoneCode' => 'PL', 'zoneStatus' => '1'],
            ['zoneId' => '3008', 'countryId' => '195', 'zoneName' => 'Pontevedra', 'zoneCode' => 'PO', 'zoneStatus' => '1'],
            ['zoneId' => '3009', 'countryId' => '195', 'zoneName' => 'Salamanca', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '3010', 'countryId' => '195', 'zoneName' => 'Santa Cruz de Tenerife', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '3011', 'countryId' => '195', 'zoneName' => 'Segovia', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '3012', 'countryId' => '195', 'zoneName' => 'Sevilla', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '3013', 'countryId' => '195', 'zoneName' => 'Soria', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '3014', 'countryId' => '195', 'zoneName' => 'Tarragona', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3015', 'countryId' => '195', 'zoneName' => 'Teruel', 'zoneCode' => 'TE', 'zoneStatus' => '1'],
            ['zoneId' => '3016', 'countryId' => '195', 'zoneName' => 'Toledo', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '3017', 'countryId' => '195', 'zoneName' => 'Valencia', 'zoneCode' => 'VC', 'zoneStatus' => '1'],
            ['zoneId' => '3018', 'countryId' => '195', 'zoneName' => 'Valladolid', 'zoneCode' => 'VD', 'zoneStatus' => '1'],
            ['zoneId' => '3019', 'countryId' => '195', 'zoneName' => 'Vizcaya', 'zoneCode' => 'VZ', 'zoneStatus' => '1'],
            ['zoneId' => '3020', 'countryId' => '195', 'zoneName' => 'Zamora', 'zoneCode' => 'ZM', 'zoneStatus' => '1'],
            ['zoneId' => '3021', 'countryId' => '195', 'zoneName' => 'Zaragoza', 'zoneCode' => 'ZR', 'zoneStatus' => '1'],
            ['zoneId' => '3022', 'countryId' => '196', 'zoneName' => 'Central', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '3023', 'countryId' => '196', 'zoneName' => 'Eastern', 'zoneCode' => 'EA', 'zoneStatus' => '1'],
            ['zoneId' => '3024', 'countryId' => '196', 'zoneName' => 'North Central', 'zoneCode' => 'NC', 'zoneStatus' => '1'],
            ['zoneId' => '3025', 'countryId' => '196', 'zoneName' => 'Northern', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '3026', 'countryId' => '196', 'zoneName' => 'North Western', 'zoneCode' => 'NW', 'zoneStatus' => '1'],
            ['zoneId' => '3027', 'countryId' => '196', 'zoneName' => 'Sabaragamuwa', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '3028', 'countryId' => '196', 'zoneName' => 'Southern', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '3029', 'countryId' => '196', 'zoneName' => 'Uva', 'zoneCode' => 'UV', 'zoneStatus' => '1'],
            ['zoneId' => '3030', 'countryId' => '196', 'zoneName' => 'Western', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '3032', 'countryId' => '197', 'zoneName' => 'Saint Helena', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '3034', 'countryId' => '199', 'zoneName' => 'A\'ali an Nil', 'zoneCode' => 'ANL', 'zoneStatus' => '1'],
            ['zoneId' => '3035', 'countryId' => '199', 'zoneName' => 'Al Bahr al Ahmar', 'zoneCode' => 'BAM', 'zoneStatus' => '1'],
            ['zoneId' => '3036', 'countryId' => '199', 'zoneName' => 'Al Buhayrat', 'zoneCode' => 'BRT', 'zoneStatus' => '1'],
            ['zoneId' => '3037', 'countryId' => '199', 'zoneName' => 'Al Jazirah', 'zoneCode' => 'JZR', 'zoneStatus' => '1'],
            ['zoneId' => '3038', 'countryId' => '199', 'zoneName' => 'Al Khartum', 'zoneCode' => 'KRT', 'zoneStatus' => '1'],
            ['zoneId' => '3039', 'countryId' => '199', 'zoneName' => 'Al Qadarif', 'zoneCode' => 'QDR', 'zoneStatus' => '1'],
            ['zoneId' => '3040', 'countryId' => '199', 'zoneName' => 'Al Wahdah', 'zoneCode' => 'WDH', 'zoneStatus' => '1'],
            ['zoneId' => '3041', 'countryId' => '199', 'zoneName' => 'An Nil al Abyad', 'zoneCode' => 'ANB', 'zoneStatus' => '1'],
            ['zoneId' => '3042', 'countryId' => '199', 'zoneName' => 'An Nil al Azraq', 'zoneCode' => 'ANZ', 'zoneStatus' => '1'],
            ['zoneId' => '3043', 'countryId' => '199', 'zoneName' => 'Ash Shamaliyah', 'zoneCode' => 'ASH', 'zoneStatus' => '1'],
            ['zoneId' => '3044', 'countryId' => '199', 'zoneName' => 'Bahr al Jabal', 'zoneCode' => 'BJA', 'zoneStatus' => '1'],
            ['zoneId' => '3045', 'countryId' => '199', 'zoneName' => 'Gharb al Istiwa\'iyah', 'zoneCode' => 'GIS', 'zoneStatus' => '1'],
            ['zoneId' => '3046', 'countryId' => '199', 'zoneName' => 'Gharb Bahr al Ghazal', 'zoneCode' => 'GBG', 'zoneStatus' => '1'],
            ['zoneId' => '3047', 'countryId' => '199', 'zoneName' => 'Gharb Darfur', 'zoneCode' => 'GDA', 'zoneStatus' => '1'],
            ['zoneId' => '3048', 'countryId' => '199', 'zoneName' => 'Gharb Kurdufan', 'zoneCode' => 'GKU', 'zoneStatus' => '1'],
            ['zoneId' => '3049', 'countryId' => '199', 'zoneName' => 'Janub Darfur', 'zoneCode' => 'JDA', 'zoneStatus' => '1'],
            ['zoneId' => '3050', 'countryId' => '199', 'zoneName' => 'Janub Kurdufan', 'zoneCode' => 'JKU', 'zoneStatus' => '1'],
            ['zoneId' => '3051', 'countryId' => '199', 'zoneName' => 'Junqali', 'zoneCode' => 'JQL', 'zoneStatus' => '1'],
            ['zoneId' => '3052', 'countryId' => '199', 'zoneName' => 'Kassala', 'zoneCode' => 'KSL', 'zoneStatus' => '1'],
            ['zoneId' => '3053', 'countryId' => '199', 'zoneName' => 'Nahr an Nil', 'zoneCode' => 'NNL', 'zoneStatus' => '1'],
            ['zoneId' => '3054', 'countryId' => '199', 'zoneName' => 'Shamal Bahr al Ghazal', 'zoneCode' => 'SBG', 'zoneStatus' => '1'],
            ['zoneId' => '3055', 'countryId' => '199', 'zoneName' => 'Shamal Darfur', 'zoneCode' => 'SDA', 'zoneStatus' => '1'],
            ['zoneId' => '3056', 'countryId' => '199', 'zoneName' => 'Shamal Kurdufan', 'zoneCode' => 'SKU', 'zoneStatus' => '1'],
            ['zoneId' => '3057', 'countryId' => '199', 'zoneName' => 'Sharq al Istiwa\'iyah', 'zoneCode' => 'SIS', 'zoneStatus' => '1'],
            ['zoneId' => '3058', 'countryId' => '199', 'zoneName' => 'Sinnar', 'zoneCode' => 'SNR', 'zoneStatus' => '1'],
            ['zoneId' => '3059', 'countryId' => '199', 'zoneName' => 'Warab', 'zoneCode' => 'WRB', 'zoneStatus' => '1'],
            ['zoneId' => '3060', 'countryId' => '200', 'zoneName' => 'Brokopondo', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '3061', 'countryId' => '200', 'zoneName' => 'Commewijne', 'zoneCode' => 'CM', 'zoneStatus' => '1'],
            ['zoneId' => '3062', 'countryId' => '200', 'zoneName' => 'Coronie', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '3063', 'countryId' => '200', 'zoneName' => 'Marowijne', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3064', 'countryId' => '200', 'zoneName' => 'Nickerie', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '3065', 'countryId' => '200', 'zoneName' => 'Para', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '3066', 'countryId' => '200', 'zoneName' => 'Paramaribo', 'zoneCode' => 'PM', 'zoneStatus' => '1'],
            ['zoneId' => '3067', 'countryId' => '200', 'zoneName' => 'Saramacca', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '3068', 'countryId' => '200', 'zoneName' => 'Sipaliwini', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '3069', 'countryId' => '200', 'zoneName' => 'Wanica', 'zoneCode' => 'WA', 'zoneStatus' => '1'],
            ['zoneId' => '3070', 'countryId' => '202', 'zoneName' => 'Hhohho', 'zoneCode' => 'H', 'zoneStatus' => '1'],
            ['zoneId' => '3071', 'countryId' => '202', 'zoneName' => 'Lubombo', 'zoneCode' => 'L', 'zoneStatus' => '1'],
            ['zoneId' => '3072', 'countryId' => '202', 'zoneName' => 'Manzini', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '3073', 'countryId' => '202', 'zoneName' => 'Shishelweni', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '3074', 'countryId' => '203', 'zoneName' => 'Blekinge', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '3075', 'countryId' => '203', 'zoneName' => 'Dalarna', 'zoneCode' => 'W', 'zoneStatus' => '1'],
            ['zoneId' => '3076', 'countryId' => '203', 'zoneName' => 'Gävleborg', 'zoneCode' => 'X', 'zoneStatus' => '1'],
            ['zoneId' => '3077', 'countryId' => '203', 'zoneName' => 'Gotland', 'zoneCode' => 'I', 'zoneStatus' => '1'],
            ['zoneId' => '3078', 'countryId' => '203', 'zoneName' => 'Halland', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '3079', 'countryId' => '203', 'zoneName' => 'Jämtland', 'zoneCode' => 'Z', 'zoneStatus' => '1'],
            ['zoneId' => '3080', 'countryId' => '203', 'zoneName' => 'Jönköping', 'zoneCode' => 'F', 'zoneStatus' => '1'],
            ['zoneId' => '3081', 'countryId' => '203', 'zoneName' => 'Kalmar', 'zoneCode' => 'H', 'zoneStatus' => '1'],
            ['zoneId' => '3082', 'countryId' => '203', 'zoneName' => 'Kronoberg', 'zoneCode' => 'G', 'zoneStatus' => '1'],
            ['zoneId' => '3083', 'countryId' => '203', 'zoneName' => 'Norrbotten', 'zoneCode' => 'BD', 'zoneStatus' => '1'],
            ['zoneId' => '3084', 'countryId' => '203', 'zoneName' => 'Örebro', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '3085', 'countryId' => '203', 'zoneName' => 'Östergötland', 'zoneCode' => 'E', 'zoneStatus' => '1'],
            ['zoneId' => '3086', 'countryId' => '203', 'zoneName' => 'Sk&aring;ne', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '3087', 'countryId' => '203', 'zoneName' => 'Södermanland', 'zoneCode' => 'D', 'zoneStatus' => '1'],
            ['zoneId' => '3088', 'countryId' => '203', 'zoneName' => 'Stockholm', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '3089', 'countryId' => '203', 'zoneName' => 'Uppsala', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '3090', 'countryId' => '203', 'zoneName' => 'Värmland', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '3091', 'countryId' => '203', 'zoneName' => 'Västerbotten', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '3092', 'countryId' => '203', 'zoneName' => 'Västernorrland', 'zoneCode' => 'Y', 'zoneStatus' => '1'],
            ['zoneId' => '3093', 'countryId' => '203', 'zoneName' => 'Västmanland', 'zoneCode' => 'U', 'zoneStatus' => '1'],
            ['zoneId' => '3094', 'countryId' => '203', 'zoneName' => 'Västra Götaland', 'zoneCode' => 'O', 'zoneStatus' => '1'],
            ['zoneId' => '3095', 'countryId' => '204', 'zoneName' => 'Aargau', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '3096', 'countryId' => '204', 'zoneName' => 'Appenzell Ausserrhoden', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3097', 'countryId' => '204', 'zoneName' => 'Appenzell Innerrhoden', 'zoneCode' => 'AI', 'zoneStatus' => '1'],
            ['zoneId' => '3098', 'countryId' => '204', 'zoneName' => 'Basel-Stadt', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '3099', 'countryId' => '204', 'zoneName' => 'Basel-Landschaft', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '3100', 'countryId' => '204', 'zoneName' => 'Bern', 'zoneCode' => 'BE', 'zoneStatus' => '1'],
            ['zoneId' => '3101', 'countryId' => '204', 'zoneName' => 'Fribourg', 'zoneCode' => 'FR', 'zoneStatus' => '1'],
            ['zoneId' => '3102', 'countryId' => '204', 'zoneName' => 'Gen&egrave;ve', 'zoneCode' => 'GE', 'zoneStatus' => '1'],
            ['zoneId' => '3103', 'countryId' => '204', 'zoneName' => 'Glarus', 'zoneCode' => 'GL', 'zoneStatus' => '1'],
            ['zoneId' => '3104', 'countryId' => '204', 'zoneName' => 'Graubünden', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '3105', 'countryId' => '204', 'zoneName' => 'Jura', 'zoneCode' => 'JU', 'zoneStatus' => '1'],
            ['zoneId' => '3106', 'countryId' => '204', 'zoneName' => 'Luzern', 'zoneCode' => 'LU', 'zoneStatus' => '1'],
            ['zoneId' => '3107', 'countryId' => '204', 'zoneName' => 'Neuch&acirc;tel', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '3108', 'countryId' => '204', 'zoneName' => 'Nidwald', 'zoneCode' => 'NW', 'zoneStatus' => '1'],
            ['zoneId' => '3109', 'countryId' => '204', 'zoneName' => 'Obwald', 'zoneCode' => 'OW', 'zoneStatus' => '1'],
            ['zoneId' => '3110', 'countryId' => '204', 'zoneName' => 'St. Gallen', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '3111', 'countryId' => '204', 'zoneName' => 'Schaffhausen', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '3112', 'countryId' => '204', 'zoneName' => 'Schwyz', 'zoneCode' => 'SZ', 'zoneStatus' => '1'],
            ['zoneId' => '3113', 'countryId' => '204', 'zoneName' => 'Solothurn', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '3114', 'countryId' => '204', 'zoneName' => 'Thurgau', 'zoneCode' => 'TG', 'zoneStatus' => '1'],
            ['zoneId' => '3115', 'countryId' => '204', 'zoneName' => 'Ticino', 'zoneCode' => 'TI', 'zoneStatus' => '1'],
            ['zoneId' => '3116', 'countryId' => '204', 'zoneName' => 'Uri', 'zoneCode' => 'UR', 'zoneStatus' => '1'],
            ['zoneId' => '3117', 'countryId' => '204', 'zoneName' => 'Valais', 'zoneCode' => 'VS', 'zoneStatus' => '1'],
            ['zoneId' => '3118', 'countryId' => '204', 'zoneName' => 'Vaud', 'zoneCode' => 'VD', 'zoneStatus' => '1'],
            ['zoneId' => '3119', 'countryId' => '204', 'zoneName' => 'Zug', 'zoneCode' => 'ZG', 'zoneStatus' => '1'],
            ['zoneId' => '3120', 'countryId' => '204', 'zoneName' => 'Zürich', 'zoneCode' => 'ZH', 'zoneStatus' => '1'],
            ['zoneId' => '3121', 'countryId' => '205', 'zoneName' => 'Al Hasakah', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '3122', 'countryId' => '205', 'zoneName' => 'Al Ladhiqiyah', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '3123', 'countryId' => '205', 'zoneName' => 'Al Qunaytirah', 'zoneCode' => 'QU', 'zoneStatus' => '1'],
            ['zoneId' => '3124', 'countryId' => '205', 'zoneName' => 'Ar Raqqah', 'zoneCode' => 'RQ', 'zoneStatus' => '1'],
            ['zoneId' => '3125', 'countryId' => '205', 'zoneName' => 'As Suwayda', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '3126', 'countryId' => '205', 'zoneName' => 'Dara', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '3127', 'countryId' => '205', 'zoneName' => 'Dayr az Zawr', 'zoneCode' => 'DZ', 'zoneStatus' => '1'],
            ['zoneId' => '3128', 'countryId' => '205', 'zoneName' => 'Dimashq', 'zoneCode' => 'DI', 'zoneStatus' => '1'],
            ['zoneId' => '3129', 'countryId' => '205', 'zoneName' => 'Halab', 'zoneCode' => 'HL', 'zoneStatus' => '1'],
            ['zoneId' => '3130', 'countryId' => '205', 'zoneName' => 'Hamah', 'zoneCode' => 'HM', 'zoneStatus' => '1'],
            ['zoneId' => '3131', 'countryId' => '205', 'zoneName' => 'Hims', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '3132', 'countryId' => '205', 'zoneName' => 'Idlib', 'zoneCode' => 'ID', 'zoneStatus' => '1'],
            ['zoneId' => '3133', 'countryId' => '205', 'zoneName' => 'Rif Dimashq', 'zoneCode' => 'RD', 'zoneStatus' => '1'],
            ['zoneId' => '3134', 'countryId' => '205', 'zoneName' => 'Tartus', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3135', 'countryId' => '206', 'zoneName' => 'Chang-hua', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '3136', 'countryId' => '206', 'zoneName' => 'Chia-i', 'zoneCode' => 'CI', 'zoneStatus' => '1'],
            ['zoneId' => '3137', 'countryId' => '206', 'zoneName' => 'Hsin-chu', 'zoneCode' => 'HS', 'zoneStatus' => '1'],
            ['zoneId' => '3138', 'countryId' => '206', 'zoneName' => 'Hua-lien', 'zoneCode' => 'HL', 'zoneStatus' => '1'],
            ['zoneId' => '3139', 'countryId' => '206', 'zoneName' => 'I-lan', 'zoneCode' => 'IL', 'zoneStatus' => '1'],
            ['zoneId' => '3140', 'countryId' => '206', 'zoneName' => 'Kao-hsiung county', 'zoneCode' => 'KH', 'zoneStatus' => '1'],
            ['zoneId' => '3141', 'countryId' => '206', 'zoneName' => 'Kin-men', 'zoneCode' => 'KM', 'zoneStatus' => '1'],
            ['zoneId' => '3142', 'countryId' => '206', 'zoneName' => 'Lien-chiang', 'zoneCode' => 'LC', 'zoneStatus' => '1'],
            ['zoneId' => '3143', 'countryId' => '206', 'zoneName' => 'Miao-li', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '3144', 'countryId' => '206', 'zoneName' => 'Nan-t\'ou', 'zoneCode' => 'NT', 'zoneStatus' => '1'],
            ['zoneId' => '3145', 'countryId' => '206', 'zoneName' => 'P\'eng-hu', 'zoneCode' => 'PH', 'zoneStatus' => '1'],
            ['zoneId' => '3146', 'countryId' => '206', 'zoneName' => 'P\'ing-tung', 'zoneCode' => 'PT', 'zoneStatus' => '1'],
            ['zoneId' => '3147', 'countryId' => '206', 'zoneName' => 'T\'ai-chung', 'zoneCode' => 'TG', 'zoneStatus' => '1'],
            ['zoneId' => '3148', 'countryId' => '206', 'zoneName' => 'T\'ai-nan', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3149', 'countryId' => '206', 'zoneName' => 'T\'ai-pei county', 'zoneCode' => 'TP', 'zoneStatus' => '1'],
            ['zoneId' => '3150', 'countryId' => '206', 'zoneName' => 'T\'ai-tung', 'zoneCode' => 'TT', 'zoneStatus' => '1'],
            ['zoneId' => '3151', 'countryId' => '206', 'zoneName' => 'T\'ao-yuan', 'zoneCode' => 'TY', 'zoneStatus' => '1'],
            ['zoneId' => '3152', 'countryId' => '206', 'zoneName' => 'Yun-lin', 'zoneCode' => 'YL', 'zoneStatus' => '1'],
            ['zoneId' => '3153', 'countryId' => '206', 'zoneName' => 'Chia-i city', 'zoneCode' => 'CC', 'zoneStatus' => '1'],
            ['zoneId' => '3154', 'countryId' => '206', 'zoneName' => 'Chi-lung', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '3155', 'countryId' => '206', 'zoneName' => 'Hsin-chu', 'zoneCode' => 'HC', 'zoneStatus' => '1'],
            ['zoneId' => '3156', 'countryId' => '206', 'zoneName' => 'T\'ai-chung', 'zoneCode' => 'TH', 'zoneStatus' => '1'],
            ['zoneId' => '3157', 'countryId' => '206', 'zoneName' => 'T\'ai-nan', 'zoneCode' => 'TN', 'zoneStatus' => '1'],
            ['zoneId' => '3158', 'countryId' => '206', 'zoneName' => 'Kao-hsiung city', 'zoneCode' => 'KC', 'zoneStatus' => '1'],
            ['zoneId' => '3159', 'countryId' => '206', 'zoneName' => 'T\'ai-pei city', 'zoneCode' => 'TC', 'zoneStatus' => '1'],
            ['zoneId' => '3160', 'countryId' => '207', 'zoneName' => 'Gorno-Badakhstan', 'zoneCode' => 'GB', 'zoneStatus' => '1'],
            ['zoneId' => '3161', 'countryId' => '207', 'zoneName' => 'Khatlon', 'zoneCode' => 'KT', 'zoneStatus' => '1'],
            ['zoneId' => '3162', 'countryId' => '207', 'zoneName' => 'Sughd', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '3163', 'countryId' => '208', 'zoneName' => 'Arusha', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3164', 'countryId' => '208', 'zoneName' => 'Dar es Salaam', 'zoneCode' => 'DS', 'zoneStatus' => '1'],
            ['zoneId' => '3165', 'countryId' => '208', 'zoneName' => 'Dodoma', 'zoneCode' => 'DO', 'zoneStatus' => '1'],
            ['zoneId' => '3166', 'countryId' => '208', 'zoneName' => 'Iringa', 'zoneCode' => 'IR', 'zoneStatus' => '1'],
            ['zoneId' => '3167', 'countryId' => '208', 'zoneName' => 'Kagera', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '3168', 'countryId' => '208', 'zoneName' => 'Kigoma', 'zoneCode' => 'KI', 'zoneStatus' => '1'],
            ['zoneId' => '3169', 'countryId' => '208', 'zoneName' => 'Kilimanjaro', 'zoneCode' => 'KJ', 'zoneStatus' => '1'],
            ['zoneId' => '3170', 'countryId' => '208', 'zoneName' => 'Lindi', 'zoneCode' => 'LN', 'zoneStatus' => '1'],
            ['zoneId' => '3171', 'countryId' => '208', 'zoneName' => 'Manyara', 'zoneCode' => 'MY', 'zoneStatus' => '1'],
            ['zoneId' => '3172', 'countryId' => '208', 'zoneName' => 'Mara', 'zoneCode' => 'MR', 'zoneStatus' => '1'],
            ['zoneId' => '3173', 'countryId' => '208', 'zoneName' => 'Mbeya', 'zoneCode' => 'MB', 'zoneStatus' => '1'],
            ['zoneId' => '3174', 'countryId' => '208', 'zoneName' => 'Morogoro', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '3175', 'countryId' => '208', 'zoneName' => 'Mtwara', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '3176', 'countryId' => '208', 'zoneName' => 'Mwanza', 'zoneCode' => 'MW', 'zoneStatus' => '1'],
            ['zoneId' => '3177', 'countryId' => '208', 'zoneName' => 'Pemba North', 'zoneCode' => 'PN', 'zoneStatus' => '1'],
            ['zoneId' => '3178', 'countryId' => '208', 'zoneName' => 'Pemba South', 'zoneCode' => 'PS', 'zoneStatus' => '1'],
            ['zoneId' => '3179', 'countryId' => '208', 'zoneName' => 'Pwani', 'zoneCode' => 'PW', 'zoneStatus' => '1'],
            ['zoneId' => '3180', 'countryId' => '208', 'zoneName' => 'Rukwa', 'zoneCode' => 'RK', 'zoneStatus' => '1'],
            ['zoneId' => '3181', 'countryId' => '208', 'zoneName' => 'Ruvuma', 'zoneCode' => 'RV', 'zoneStatus' => '1'],
            ['zoneId' => '3182', 'countryId' => '208', 'zoneName' => 'Shinyanga', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '3183', 'countryId' => '208', 'zoneName' => 'Singida', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '3184', 'countryId' => '208', 'zoneName' => 'Tabora', 'zoneCode' => 'TB', 'zoneStatus' => '1'],
            ['zoneId' => '3185', 'countryId' => '208', 'zoneName' => 'Tanga', 'zoneCode' => 'TN', 'zoneStatus' => '1'],
            ['zoneId' => '3186', 'countryId' => '208', 'zoneName' => 'Zanzibar Central/South', 'zoneCode' => 'ZC', 'zoneStatus' => '1'],
            ['zoneId' => '3187', 'countryId' => '208', 'zoneName' => 'Zanzibar North', 'zoneCode' => 'ZN', 'zoneStatus' => '1'],
            ['zoneId' => '3188', 'countryId' => '208', 'zoneName' => 'Zanzibar Urban/West', 'zoneCode' => 'ZU', 'zoneStatus' => '1'],
            ['zoneId' => '3189', 'countryId' => '209', 'zoneName' => 'Amnat Charoen', 'zoneCode' => 'Amnat Charoen', 'zoneStatus' => '1'],
            ['zoneId' => '3190', 'countryId' => '209', 'zoneName' => 'Ang Thong', 'zoneCode' => 'Ang Thong', 'zoneStatus' => '1'],
            ['zoneId' => '3191', 'countryId' => '209', 'zoneName' => 'Ayutthaya', 'zoneCode' => 'Ayutthaya', 'zoneStatus' => '1'],
            ['zoneId' => '3192', 'countryId' => '209', 'zoneName' => 'Bangkok', 'zoneCode' => 'Bangkok', 'zoneStatus' => '1'],
            ['zoneId' => '3193', 'countryId' => '209', 'zoneName' => 'Buriram', 'zoneCode' => 'Buriram', 'zoneStatus' => '1'],
            ['zoneId' => '3194', 'countryId' => '209', 'zoneName' => 'Chachoengsao', 'zoneCode' => 'Chachoengsao', 'zoneStatus' => '1'],
            ['zoneId' => '3195', 'countryId' => '209', 'zoneName' => 'Chai Nat', 'zoneCode' => 'Chai Nat', 'zoneStatus' => '1'],
            ['zoneId' => '3196', 'countryId' => '209', 'zoneName' => 'Chaiyaphum', 'zoneCode' => 'Chaiyaphum', 'zoneStatus' => '1'],
            ['zoneId' => '3197', 'countryId' => '209', 'zoneName' => 'Chanthaburi', 'zoneCode' => 'Chanthaburi', 'zoneStatus' => '1'],
            ['zoneId' => '3198', 'countryId' => '209', 'zoneName' => 'Chiang Mai', 'zoneCode' => 'Chiang Mai', 'zoneStatus' => '1'],
            ['zoneId' => '3199', 'countryId' => '209', 'zoneName' => 'Chiang Rai', 'zoneCode' => 'Chiang Rai', 'zoneStatus' => '1'],
            ['zoneId' => '3200', 'countryId' => '209', 'zoneName' => 'Chon Buri', 'zoneCode' => 'Chon Buri', 'zoneStatus' => '1'],
            ['zoneId' => '3201', 'countryId' => '209', 'zoneName' => 'Chumphon', 'zoneCode' => 'Chumphon', 'zoneStatus' => '1'],
            ['zoneId' => '3202', 'countryId' => '209', 'zoneName' => 'Kalasin', 'zoneCode' => 'Kalasin', 'zoneStatus' => '1'],
            ['zoneId' => '3203', 'countryId' => '209', 'zoneName' => 'Kamphaeng Phet', 'zoneCode' => 'Kamphaeng Phet', 'zoneStatus' => '1'],
            ['zoneId' => '3204', 'countryId' => '209', 'zoneName' => 'Kanchanaburi', 'zoneCode' => 'Kanchanaburi', 'zoneStatus' => '1'],
            ['zoneId' => '3205', 'countryId' => '209', 'zoneName' => 'Khon Kaen', 'zoneCode' => 'Khon Kaen', 'zoneStatus' => '1'],
            ['zoneId' => '3206', 'countryId' => '209', 'zoneName' => 'Krabi', 'zoneCode' => 'Krabi', 'zoneStatus' => '1'],
            ['zoneId' => '3207', 'countryId' => '209', 'zoneName' => 'Lampang', 'zoneCode' => 'Lampang', 'zoneStatus' => '1'],
            ['zoneId' => '3208', 'countryId' => '209', 'zoneName' => 'Lamphun', 'zoneCode' => 'Lamphun', 'zoneStatus' => '1'],
            ['zoneId' => '3209', 'countryId' => '209', 'zoneName' => 'Loei', 'zoneCode' => 'Loei', 'zoneStatus' => '1'],
            ['zoneId' => '3210', 'countryId' => '209', 'zoneName' => 'Lop Buri', 'zoneCode' => 'Lop Buri', 'zoneStatus' => '1'],
            ['zoneId' => '3211', 'countryId' => '209', 'zoneName' => 'Mae Hong Son', 'zoneCode' => 'Mae Hong Son', 'zoneStatus' => '1'],
            ['zoneId' => '3212', 'countryId' => '209', 'zoneName' => 'Maha Sarakham', 'zoneCode' => 'Maha Sarakham', 'zoneStatus' => '1'],
            ['zoneId' => '3213', 'countryId' => '209', 'zoneName' => 'Mukdahan', 'zoneCode' => 'Mukdahan', 'zoneStatus' => '1'],
            ['zoneId' => '3214', 'countryId' => '209', 'zoneName' => 'Nakhon Nayok', 'zoneCode' => 'Nakhon Nayok', 'zoneStatus' => '1'],
            ['zoneId' => '3215', 'countryId' => '209', 'zoneName' => 'Nakhon Pathom', 'zoneCode' => 'Nakhon Pathom', 'zoneStatus' => '1'],
            ['zoneId' => '3216', 'countryId' => '209', 'zoneName' => 'Nakhon Phanom', 'zoneCode' => 'Nakhon Phanom', 'zoneStatus' => '1'],
            ['zoneId' => '3217', 'countryId' => '209', 'zoneName' => 'Nakhon Ratchasima', 'zoneCode' => 'Nakhon Ratchasima', 'zoneStatus' => '1'],
            ['zoneId' => '3218', 'countryId' => '209', 'zoneName' => 'Nakhon Sawan', 'zoneCode' => 'Nakhon Sawan', 'zoneStatus' => '1'],
            ['zoneId' => '3219', 'countryId' => '209', 'zoneName' => 'Nakhon Si Thammarat', 'zoneCode' => 'Nakhon Si Thammarat', 'zoneStatus' => '1'],
            ['zoneId' => '3220', 'countryId' => '209', 'zoneName' => 'Nan', 'zoneCode' => 'Nan', 'zoneStatus' => '1'],
            ['zoneId' => '3221', 'countryId' => '209', 'zoneName' => 'Narathiwat', 'zoneCode' => 'Narathiwat', 'zoneStatus' => '1'],
            ['zoneId' => '3222', 'countryId' => '209', 'zoneName' => 'Nong Bua Lamphu', 'zoneCode' => 'Nong Bua Lamphu', 'zoneStatus' => '1'],
            ['zoneId' => '3223', 'countryId' => '209', 'zoneName' => 'Nong Khai', 'zoneCode' => 'Nong Khai', 'zoneStatus' => '1'],
            ['zoneId' => '3224', 'countryId' => '209', 'zoneName' => 'Nonthaburi', 'zoneCode' => 'Nonthaburi', 'zoneStatus' => '1'],
            ['zoneId' => '3225', 'countryId' => '209', 'zoneName' => 'Pathum Thani', 'zoneCode' => 'Pathum Thani', 'zoneStatus' => '1'],
            ['zoneId' => '3226', 'countryId' => '209', 'zoneName' => 'Pattani', 'zoneCode' => 'Pattani', 'zoneStatus' => '1'],
            ['zoneId' => '3227', 'countryId' => '209', 'zoneName' => 'Phangnga', 'zoneCode' => 'Phangnga', 'zoneStatus' => '1'],
            ['zoneId' => '3228', 'countryId' => '209', 'zoneName' => 'Phatthalung', 'zoneCode' => 'Phatthalung', 'zoneStatus' => '1'],
            ['zoneId' => '3229', 'countryId' => '209', 'zoneName' => 'Phayao', 'zoneCode' => 'Phayao', 'zoneStatus' => '1'],
            ['zoneId' => '3230', 'countryId' => '209', 'zoneName' => 'Phetchabun', 'zoneCode' => 'Phetchabun', 'zoneStatus' => '1'],
            ['zoneId' => '3231', 'countryId' => '209', 'zoneName' => 'Phetchaburi', 'zoneCode' => 'Phetchaburi', 'zoneStatus' => '1'],
            ['zoneId' => '3232', 'countryId' => '209', 'zoneName' => 'Phichit', 'zoneCode' => 'Phichit', 'zoneStatus' => '1'],
            ['zoneId' => '3233', 'countryId' => '209', 'zoneName' => 'Phitsanulok', 'zoneCode' => 'Phitsanulok', 'zoneStatus' => '1'],
            ['zoneId' => '3234', 'countryId' => '209', 'zoneName' => 'Phrae', 'zoneCode' => 'Phrae', 'zoneStatus' => '1'],
            ['zoneId' => '3235', 'countryId' => '209', 'zoneName' => 'Phuket', 'zoneCode' => 'Phuket', 'zoneStatus' => '1'],
            ['zoneId' => '3236', 'countryId' => '209', 'zoneName' => 'Prachin Buri', 'zoneCode' => 'Prachin Buri', 'zoneStatus' => '1'],
            ['zoneId' => '3237', 'countryId' => '209', 'zoneName' => 'Prachuap Khiri Khan', 'zoneCode' => 'Prachuap Khiri Khan', 'zoneStatus' => '1'],
            ['zoneId' => '3238', 'countryId' => '209', 'zoneName' => 'Ranong', 'zoneCode' => 'Ranong', 'zoneStatus' => '1'],
            ['zoneId' => '3239', 'countryId' => '209', 'zoneName' => 'Ratchaburi', 'zoneCode' => 'Ratchaburi', 'zoneStatus' => '1'],
            ['zoneId' => '3240', 'countryId' => '209', 'zoneName' => 'Rayong', 'zoneCode' => 'Rayong', 'zoneStatus' => '1'],
            ['zoneId' => '3241', 'countryId' => '209', 'zoneName' => 'Roi Et', 'zoneCode' => 'Roi Et', 'zoneStatus' => '1'],
            ['zoneId' => '3242', 'countryId' => '209', 'zoneName' => 'Sa Kaeo', 'zoneCode' => 'Sa Kaeo', 'zoneStatus' => '1'],
            ['zoneId' => '3243', 'countryId' => '209', 'zoneName' => 'Sakon Nakhon', 'zoneCode' => 'Sakon Nakhon', 'zoneStatus' => '1'],
            ['zoneId' => '3244', 'countryId' => '209', 'zoneName' => 'Samut Prakan', 'zoneCode' => 'Samut Prakan', 'zoneStatus' => '1'],
            ['zoneId' => '3245', 'countryId' => '209', 'zoneName' => 'Samut Sakhon', 'zoneCode' => 'Samut Sakhon', 'zoneStatus' => '1'],
            ['zoneId' => '3246', 'countryId' => '209', 'zoneName' => 'Samut Songkhram', 'zoneCode' => 'Samut Songkhram', 'zoneStatus' => '1'],
            ['zoneId' => '3247', 'countryId' => '209', 'zoneName' => 'Sara Buri', 'zoneCode' => 'Sara Buri', 'zoneStatus' => '1'],
            ['zoneId' => '3248', 'countryId' => '209', 'zoneName' => 'Satun', 'zoneCode' => 'Satun', 'zoneStatus' => '1'],
            ['zoneId' => '3249', 'countryId' => '209', 'zoneName' => 'Sing Buri', 'zoneCode' => 'Sing Buri', 'zoneStatus' => '1'],
            ['zoneId' => '3250', 'countryId' => '209', 'zoneName' => 'Sisaket', 'zoneCode' => 'Sisaket', 'zoneStatus' => '1'],
            ['zoneId' => '3251', 'countryId' => '209', 'zoneName' => 'Songkhla', 'zoneCode' => 'Songkhla', 'zoneStatus' => '1'],
            ['zoneId' => '3252', 'countryId' => '209', 'zoneName' => 'Sukhothai', 'zoneCode' => 'Sukhothai', 'zoneStatus' => '1'],
            ['zoneId' => '3253', 'countryId' => '209', 'zoneName' => 'Suphan Buri', 'zoneCode' => 'Suphan Buri', 'zoneStatus' => '1'],
            ['zoneId' => '3254', 'countryId' => '209', 'zoneName' => 'Surat Thani', 'zoneCode' => 'Surat Thani', 'zoneStatus' => '1'],
            ['zoneId' => '3255', 'countryId' => '209', 'zoneName' => 'Surin', 'zoneCode' => 'Surin', 'zoneStatus' => '1'],
            ['zoneId' => '3256', 'countryId' => '209', 'zoneName' => 'Tak', 'zoneCode' => 'Tak', 'zoneStatus' => '1'],
            ['zoneId' => '3257', 'countryId' => '209', 'zoneName' => 'Trang', 'zoneCode' => 'Trang', 'zoneStatus' => '1'],
            ['zoneId' => '3258', 'countryId' => '209', 'zoneName' => 'Trat', 'zoneCode' => 'Trat', 'zoneStatus' => '1'],
            ['zoneId' => '3259', 'countryId' => '209', 'zoneName' => 'Ubon Ratchathani', 'zoneCode' => 'Ubon Ratchathani', 'zoneStatus' => '1'],
            ['zoneId' => '3260', 'countryId' => '209', 'zoneName' => 'Udon Thani', 'zoneCode' => 'Udon Thani', 'zoneStatus' => '1'],
            ['zoneId' => '3261', 'countryId' => '209', 'zoneName' => 'Uthai Thani', 'zoneCode' => 'Uthai Thani', 'zoneStatus' => '1'],
            ['zoneId' => '3262', 'countryId' => '209', 'zoneName' => 'Uttaradit', 'zoneCode' => 'Uttaradit', 'zoneStatus' => '1'],
            ['zoneId' => '3263', 'countryId' => '209', 'zoneName' => 'Yala', 'zoneCode' => 'Yala', 'zoneStatus' => '1'],
            ['zoneId' => '3264', 'countryId' => '209', 'zoneName' => 'Yasothon', 'zoneCode' => 'Yasothon', 'zoneStatus' => '1'],
            ['zoneId' => '3265', 'countryId' => '210', 'zoneName' => 'Kara', 'zoneCode' => 'K', 'zoneStatus' => '1'],
            ['zoneId' => '3266', 'countryId' => '210', 'zoneName' => 'Plateaux', 'zoneCode' => 'P', 'zoneStatus' => '1'],
            ['zoneId' => '3267', 'countryId' => '210', 'zoneName' => 'Savanes', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '3268', 'countryId' => '210', 'zoneName' => 'Centrale', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '3269', 'countryId' => '210', 'zoneName' => 'Maritime', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '3270', 'countryId' => '211', 'zoneName' => 'Atafu', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '3271', 'countryId' => '211', 'zoneName' => 'Fakaofo', 'zoneCode' => 'F', 'zoneStatus' => '1'],
            ['zoneId' => '3272', 'countryId' => '211', 'zoneName' => 'Nukunonu', 'zoneCode' => 'N', 'zoneStatus' => '1'],
            ['zoneId' => '3273', 'countryId' => '212', 'zoneName' => 'Ha\'apai', 'zoneCode' => 'H', 'zoneStatus' => '1'],
            ['zoneId' => '3274', 'countryId' => '212', 'zoneName' => 'Tongatapu', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '3275', 'countryId' => '212', 'zoneName' => 'Vava\'u', 'zoneCode' => 'V', 'zoneStatus' => '1'],
            ['zoneId' => '3276', 'countryId' => '213', 'zoneName' => 'Couva/Tabaquite/Talparo', 'zoneCode' => 'CT', 'zoneStatus' => '1'],
            ['zoneId' => '3277', 'countryId' => '213', 'zoneName' => 'Diego Martin', 'zoneCode' => 'DM', 'zoneStatus' => '1'],
            ['zoneId' => '3278', 'countryId' => '213', 'zoneName' => 'Mayaro/Rio Claro', 'zoneCode' => 'MR', 'zoneStatus' => '1'],
            ['zoneId' => '3279', 'countryId' => '213', 'zoneName' => 'Penal/Debe', 'zoneCode' => 'PD', 'zoneStatus' => '1'],
            ['zoneId' => '3280', 'countryId' => '213', 'zoneName' => 'Princes Town', 'zoneCode' => 'PT', 'zoneStatus' => '1'],
            ['zoneId' => '3281', 'countryId' => '213', 'zoneName' => 'Sangre Grande', 'zoneCode' => 'SG', 'zoneStatus' => '1'],
            ['zoneId' => '3282', 'countryId' => '213', 'zoneName' => 'San Juan/Laventille', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '3283', 'countryId' => '213', 'zoneName' => 'Siparia', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '3284', 'countryId' => '213', 'zoneName' => 'Tunapuna/Piarco', 'zoneCode' => 'TP', 'zoneStatus' => '1'],
            ['zoneId' => '3285', 'countryId' => '213', 'zoneName' => 'Port of Spain', 'zoneCode' => 'PS', 'zoneStatus' => '1'],
            ['zoneId' => '3286', 'countryId' => '213', 'zoneName' => 'San Fernando', 'zoneCode' => 'SF', 'zoneStatus' => '1'],
            ['zoneId' => '3287', 'countryId' => '213', 'zoneName' => 'Arima', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3288', 'countryId' => '213', 'zoneName' => 'Point Fortin', 'zoneCode' => 'PF', 'zoneStatus' => '1'],
            ['zoneId' => '3289', 'countryId' => '213', 'zoneName' => 'Chaguanas', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '3290', 'countryId' => '213', 'zoneName' => 'Tobago', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '3291', 'countryId' => '214', 'zoneName' => 'Ariana', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3292', 'countryId' => '214', 'zoneName' => 'Beja', 'zoneCode' => 'BJ', 'zoneStatus' => '1'],
            ['zoneId' => '3293', 'countryId' => '214', 'zoneName' => 'Ben Arous', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '3294', 'countryId' => '214', 'zoneName' => 'Bizerte', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '3295', 'countryId' => '214', 'zoneName' => 'Gabes', 'zoneCode' => 'GB', 'zoneStatus' => '1'],
            ['zoneId' => '3296', 'countryId' => '214', 'zoneName' => 'Gafsa', 'zoneCode' => 'GF', 'zoneStatus' => '1'],
            ['zoneId' => '3297', 'countryId' => '214', 'zoneName' => 'Jendouba', 'zoneCode' => 'JE', 'zoneStatus' => '1'],
            ['zoneId' => '3298', 'countryId' => '214', 'zoneName' => 'Kairouan', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '3299', 'countryId' => '214', 'zoneName' => 'Kasserine', 'zoneCode' => 'KS', 'zoneStatus' => '1'],
            ['zoneId' => '3300', 'countryId' => '214', 'zoneName' => 'Kebili', 'zoneCode' => 'KB', 'zoneStatus' => '1'],
            ['zoneId' => '3301', 'countryId' => '214', 'zoneName' => 'Kef', 'zoneCode' => 'KF', 'zoneStatus' => '1'],
            ['zoneId' => '3302', 'countryId' => '214', 'zoneName' => 'Mahdia', 'zoneCode' => 'MH', 'zoneStatus' => '1'],
            ['zoneId' => '3303', 'countryId' => '214', 'zoneName' => 'Manouba', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '3304', 'countryId' => '214', 'zoneName' => 'Medenine', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '3305', 'countryId' => '214', 'zoneName' => 'Monastir', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '3306', 'countryId' => '214', 'zoneName' => 'Nabeul', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '3307', 'countryId' => '214', 'zoneName' => 'Sfax', 'zoneCode' => 'SF', 'zoneStatus' => '1'],
            ['zoneId' => '3308', 'countryId' => '214', 'zoneName' => 'Sidi', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '3309', 'countryId' => '214', 'zoneName' => 'Siliana', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '3310', 'countryId' => '214', 'zoneName' => 'Sousse', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '3311', 'countryId' => '214', 'zoneName' => 'Tataouine', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3312', 'countryId' => '214', 'zoneName' => 'Tozeur', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '3313', 'countryId' => '214', 'zoneName' => 'Tunis', 'zoneCode' => 'TU', 'zoneStatus' => '1'],
            ['zoneId' => '3314', 'countryId' => '214', 'zoneName' => 'Zaghouan', 'zoneCode' => 'ZA', 'zoneStatus' => '1'],
            ['zoneId' => '3315', 'countryId' => '215', 'zoneName' => 'Adana', 'zoneCode' => 'ADA', 'zoneStatus' => '1'],
            ['zoneId' => '3316', 'countryId' => '215', 'zoneName' => 'Adıyaman', 'zoneCode' => 'ADI', 'zoneStatus' => '1'],
            ['zoneId' => '3317', 'countryId' => '215', 'zoneName' => 'Afyonkarahisar', 'zoneCode' => 'AFY', 'zoneStatus' => '1'],
            ['zoneId' => '3318', 'countryId' => '215', 'zoneName' => 'Ağrı', 'zoneCode' => 'AGR', 'zoneStatus' => '1'],
            ['zoneId' => '3319', 'countryId' => '215', 'zoneName' => 'Aksaray', 'zoneCode' => 'AKS', 'zoneStatus' => '1'],
            ['zoneId' => '3320', 'countryId' => '215', 'zoneName' => 'Amasya', 'zoneCode' => 'AMA', 'zoneStatus' => '1'],
            ['zoneId' => '3321', 'countryId' => '215', 'zoneName' => 'Ankara', 'zoneCode' => 'ANK', 'zoneStatus' => '1'],
            ['zoneId' => '3322', 'countryId' => '215', 'zoneName' => 'Antalya', 'zoneCode' => 'ANT', 'zoneStatus' => '1'],
            ['zoneId' => '3323', 'countryId' => '215', 'zoneName' => 'Ardahan', 'zoneCode' => 'ARD', 'zoneStatus' => '1'],
            ['zoneId' => '3324', 'countryId' => '215', 'zoneName' => 'Artvin', 'zoneCode' => 'ART', 'zoneStatus' => '1'],
            ['zoneId' => '3325', 'countryId' => '215', 'zoneName' => 'Aydın', 'zoneCode' => 'AYI', 'zoneStatus' => '1'],
            ['zoneId' => '3326', 'countryId' => '215', 'zoneName' => 'Balıkesir', 'zoneCode' => 'BAL', 'zoneStatus' => '1'],
            ['zoneId' => '3327', 'countryId' => '215', 'zoneName' => 'Bartın', 'zoneCode' => 'BAR', 'zoneStatus' => '1'],
            ['zoneId' => '3328', 'countryId' => '215', 'zoneName' => 'Batman', 'zoneCode' => 'BAT', 'zoneStatus' => '1'],
            ['zoneId' => '3329', 'countryId' => '215', 'zoneName' => 'Bayburt', 'zoneCode' => 'BAY', 'zoneStatus' => '1'],
            ['zoneId' => '3330', 'countryId' => '215', 'zoneName' => 'Bilecik', 'zoneCode' => 'BIL', 'zoneStatus' => '1'],
            ['zoneId' => '3331', 'countryId' => '215', 'zoneName' => 'Bingöl', 'zoneCode' => 'BIN', 'zoneStatus' => '1'],
            ['zoneId' => '3332', 'countryId' => '215', 'zoneName' => 'Bitlis', 'zoneCode' => 'BIT', 'zoneStatus' => '1'],
            ['zoneId' => '3333', 'countryId' => '215', 'zoneName' => 'Bolu', 'zoneCode' => 'BOL', 'zoneStatus' => '1'],
            ['zoneId' => '3334', 'countryId' => '215', 'zoneName' => 'Burdur', 'zoneCode' => 'BRD', 'zoneStatus' => '1'],
            ['zoneId' => '3335', 'countryId' => '215', 'zoneName' => 'Bursa', 'zoneCode' => 'BRS', 'zoneStatus' => '1'],
            ['zoneId' => '3336', 'countryId' => '215', 'zoneName' => 'Çanakkale', 'zoneCode' => 'CKL', 'zoneStatus' => '1'],
            ['zoneId' => '3337', 'countryId' => '215', 'zoneName' => 'Çankırı', 'zoneCode' => 'CKR', 'zoneStatus' => '1'],
            ['zoneId' => '3338', 'countryId' => '215', 'zoneName' => 'Çorum', 'zoneCode' => 'COR', 'zoneStatus' => '1'],
            ['zoneId' => '3339', 'countryId' => '215', 'zoneName' => 'Denizli', 'zoneCode' => 'DEN', 'zoneStatus' => '1'],
            ['zoneId' => '3340', 'countryId' => '215', 'zoneName' => 'Diyarbakır', 'zoneCode' => 'DIY', 'zoneStatus' => '1'],
            ['zoneId' => '3341', 'countryId' => '215', 'zoneName' => 'Düzce', 'zoneCode' => 'DUZ', 'zoneStatus' => '1'],
            ['zoneId' => '3342', 'countryId' => '215', 'zoneName' => 'Edirne', 'zoneCode' => 'EDI', 'zoneStatus' => '1'],
            ['zoneId' => '3343', 'countryId' => '215', 'zoneName' => 'Elazığ', 'zoneCode' => 'ELA', 'zoneStatus' => '1'],
            ['zoneId' => '3344', 'countryId' => '215', 'zoneName' => 'Erzincan', 'zoneCode' => 'EZC', 'zoneStatus' => '1'],
            ['zoneId' => '3345', 'countryId' => '215', 'zoneName' => 'Erzurum', 'zoneCode' => 'EZR', 'zoneStatus' => '1'],
            ['zoneId' => '3346', 'countryId' => '215', 'zoneName' => 'Eskişehir', 'zoneCode' => 'ESK', 'zoneStatus' => '1'],
            ['zoneId' => '3347', 'countryId' => '215', 'zoneName' => 'Gaziantep', 'zoneCode' => 'GAZ', 'zoneStatus' => '1'],
            ['zoneId' => '3348', 'countryId' => '215', 'zoneName' => 'Giresun', 'zoneCode' => 'GIR', 'zoneStatus' => '1'],
            ['zoneId' => '3349', 'countryId' => '215', 'zoneName' => 'Gümüşhane', 'zoneCode' => 'GMS', 'zoneStatus' => '1'],
            ['zoneId' => '3350', 'countryId' => '215', 'zoneName' => 'Hakkari', 'zoneCode' => 'HKR', 'zoneStatus' => '1'],
            ['zoneId' => '3351', 'countryId' => '215', 'zoneName' => 'Hatay', 'zoneCode' => 'HTY', 'zoneStatus' => '1'],
            ['zoneId' => '3352', 'countryId' => '215', 'zoneName' => 'Iğdır', 'zoneCode' => 'IGD', 'zoneStatus' => '1'],
            ['zoneId' => '3353', 'countryId' => '215', 'zoneName' => 'Isparta', 'zoneCode' => 'ISP', 'zoneStatus' => '1'],
            ['zoneId' => '3354', 'countryId' => '215', 'zoneName' => 'İstanbul', 'zoneCode' => 'IST', 'zoneStatus' => '1'],
            ['zoneId' => '3355', 'countryId' => '215', 'zoneName' => 'İzmir', 'zoneCode' => 'IZM', 'zoneStatus' => '1'],
            ['zoneId' => '3356', 'countryId' => '215', 'zoneName' => 'Kahramanmaraş', 'zoneCode' => 'KAH', 'zoneStatus' => '1'],
            ['zoneId' => '3357', 'countryId' => '215', 'zoneName' => 'Karabük', 'zoneCode' => 'KRB', 'zoneStatus' => '1'],
            ['zoneId' => '3358', 'countryId' => '215', 'zoneName' => 'Karaman', 'zoneCode' => 'KRM', 'zoneStatus' => '1'],
            ['zoneId' => '3359', 'countryId' => '215', 'zoneName' => 'Kars', 'zoneCode' => 'KRS', 'zoneStatus' => '1'],
            ['zoneId' => '3360', 'countryId' => '215', 'zoneName' => 'Kastamonu', 'zoneCode' => 'KAS', 'zoneStatus' => '1'],
            ['zoneId' => '3361', 'countryId' => '215', 'zoneName' => 'Kayseri', 'zoneCode' => 'KAY', 'zoneStatus' => '1'],
            ['zoneId' => '3362', 'countryId' => '215', 'zoneName' => 'Kilis', 'zoneCode' => 'KLS', 'zoneStatus' => '1'],
            ['zoneId' => '3363', 'countryId' => '215', 'zoneName' => 'Kırıkkale', 'zoneCode' => 'KRK', 'zoneStatus' => '1'],
            ['zoneId' => '3364', 'countryId' => '215', 'zoneName' => 'Kırklareli', 'zoneCode' => 'KLR', 'zoneStatus' => '1'],
            ['zoneId' => '3365', 'countryId' => '215', 'zoneName' => 'Kırşehir', 'zoneCode' => 'KRH', 'zoneStatus' => '1'],
            ['zoneId' => '3366', 'countryId' => '215', 'zoneName' => 'Kocaeli', 'zoneCode' => 'KOC', 'zoneStatus' => '1'],
            ['zoneId' => '3367', 'countryId' => '215', 'zoneName' => 'Konya', 'zoneCode' => 'KON', 'zoneStatus' => '1'],
            ['zoneId' => '3368', 'countryId' => '215', 'zoneName' => 'Kütahya', 'zoneCode' => 'KUT', 'zoneStatus' => '1'],
            ['zoneId' => '3369', 'countryId' => '215', 'zoneName' => 'Malatya', 'zoneCode' => 'MAL', 'zoneStatus' => '1'],
            ['zoneId' => '3370', 'countryId' => '215', 'zoneName' => 'Manisa', 'zoneCode' => 'MAN', 'zoneStatus' => '1'],
            ['zoneId' => '3371', 'countryId' => '215', 'zoneName' => 'Mardin', 'zoneCode' => 'MAR', 'zoneStatus' => '1'],
            ['zoneId' => '3372', 'countryId' => '215', 'zoneName' => 'Mersin', 'zoneCode' => 'MER', 'zoneStatus' => '1'],
            ['zoneId' => '3373', 'countryId' => '215', 'zoneName' => 'Muğla', 'zoneCode' => 'MUG', 'zoneStatus' => '1'],
            ['zoneId' => '3374', 'countryId' => '215', 'zoneName' => 'Muş', 'zoneCode' => 'MUS', 'zoneStatus' => '1'],
            ['zoneId' => '3375', 'countryId' => '215', 'zoneName' => 'Nevşehir', 'zoneCode' => 'NEV', 'zoneStatus' => '1'],
            ['zoneId' => '3376', 'countryId' => '215', 'zoneName' => 'Niğde', 'zoneCode' => 'NIG', 'zoneStatus' => '1'],
            ['zoneId' => '3377', 'countryId' => '215', 'zoneName' => 'Ordu', 'zoneCode' => 'ORD', 'zoneStatus' => '1'],
            ['zoneId' => '3378', 'countryId' => '215', 'zoneName' => 'Osmaniye', 'zoneCode' => 'OSM', 'zoneStatus' => '1'],
            ['zoneId' => '3379', 'countryId' => '215', 'zoneName' => 'Rize', 'zoneCode' => 'RIZ', 'zoneStatus' => '1'],
            ['zoneId' => '3380', 'countryId' => '215', 'zoneName' => 'Sakarya', 'zoneCode' => 'SAK', 'zoneStatus' => '1'],
            ['zoneId' => '3381', 'countryId' => '215', 'zoneName' => 'Samsun', 'zoneCode' => 'SAM', 'zoneStatus' => '1'],
            ['zoneId' => '3382', 'countryId' => '215', 'zoneName' => 'Şanlıurfa', 'zoneCode' => 'SAN', 'zoneStatus' => '1'],
            ['zoneId' => '3383', 'countryId' => '215', 'zoneName' => 'Siirt', 'zoneCode' => 'SII', 'zoneStatus' => '1'],
            ['zoneId' => '3384', 'countryId' => '215', 'zoneName' => 'Sinop', 'zoneCode' => 'SIN', 'zoneStatus' => '1'],
            ['zoneId' => '3385', 'countryId' => '215', 'zoneName' => 'Şırnak', 'zoneCode' => 'SIR', 'zoneStatus' => '1'],
            ['zoneId' => '3386', 'countryId' => '215', 'zoneName' => 'Sivas', 'zoneCode' => 'SIV', 'zoneStatus' => '1'],
            ['zoneId' => '3387', 'countryId' => '215', 'zoneName' => 'Tekirdağ', 'zoneCode' => 'TEL', 'zoneStatus' => '1'],
            ['zoneId' => '3388', 'countryId' => '215', 'zoneName' => 'Tokat', 'zoneCode' => 'TOK', 'zoneStatus' => '1'],
            ['zoneId' => '3389', 'countryId' => '215', 'zoneName' => 'Trabzon', 'zoneCode' => 'TRA', 'zoneStatus' => '1'],
            ['zoneId' => '3390', 'countryId' => '215', 'zoneName' => 'Tunceli', 'zoneCode' => 'TUN', 'zoneStatus' => '1'],
            ['zoneId' => '3391', 'countryId' => '215', 'zoneName' => 'Uşak', 'zoneCode' => 'USK', 'zoneStatus' => '1'],
            ['zoneId' => '3392', 'countryId' => '215', 'zoneName' => 'Van', 'zoneCode' => 'VAN', 'zoneStatus' => '1'],
            ['zoneId' => '3393', 'countryId' => '215', 'zoneName' => 'Yalova', 'zoneCode' => 'YAL', 'zoneStatus' => '1'],
            ['zoneId' => '3394', 'countryId' => '215', 'zoneName' => 'Yozgat', 'zoneCode' => 'YOZ', 'zoneStatus' => '1'],
            ['zoneId' => '3395', 'countryId' => '215', 'zoneName' => 'Zonguldak', 'zoneCode' => 'ZON', 'zoneStatus' => '1'],
            ['zoneId' => '3396', 'countryId' => '216', 'zoneName' => 'Ahal Welayaty', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '3397', 'countryId' => '216', 'zoneName' => 'Balkan Welayaty', 'zoneCode' => 'B', 'zoneStatus' => '1'],
            ['zoneId' => '3398', 'countryId' => '216', 'zoneName' => 'Dashhowuz Welayaty', 'zoneCode' => 'D', 'zoneStatus' => '1'],
            ['zoneId' => '3399', 'countryId' => '216', 'zoneName' => 'Lebap Welayaty', 'zoneCode' => 'L', 'zoneStatus' => '1'],
            ['zoneId' => '3400', 'countryId' => '216', 'zoneName' => 'Mary Welayaty', 'zoneCode' => 'M', 'zoneStatus' => '1'],
            ['zoneId' => '3401', 'countryId' => '217', 'zoneName' => 'Ambergris Cays', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '3402', 'countryId' => '217', 'zoneName' => 'Dellis Cay', 'zoneCode' => 'DC', 'zoneStatus' => '1'],
            ['zoneId' => '3403', 'countryId' => '217', 'zoneName' => 'French Cay', 'zoneCode' => 'FC', 'zoneStatus' => '1'],
            ['zoneId' => '3404', 'countryId' => '217', 'zoneName' => 'Little Water Cay', 'zoneCode' => 'LW', 'zoneStatus' => '1'],
            ['zoneId' => '3405', 'countryId' => '217', 'zoneName' => 'Parrot Cay', 'zoneCode' => 'RC', 'zoneStatus' => '1'],
            ['zoneId' => '3406', 'countryId' => '217', 'zoneName' => 'Pine Cay', 'zoneCode' => 'PN', 'zoneStatus' => '1'],
            ['zoneId' => '3407', 'countryId' => '217', 'zoneName' => 'Salt Cay', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '3408', 'countryId' => '217', 'zoneName' => 'Grand Turk', 'zoneCode' => 'GT', 'zoneStatus' => '1'],
            ['zoneId' => '3409', 'countryId' => '217', 'zoneName' => 'South Caicos', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '3410', 'countryId' => '217', 'zoneName' => 'East Caicos', 'zoneCode' => 'EC', 'zoneStatus' => '1'],
            ['zoneId' => '3411', 'countryId' => '217', 'zoneName' => 'Middle Caicos', 'zoneCode' => 'MC', 'zoneStatus' => '1'],
            ['zoneId' => '3412', 'countryId' => '217', 'zoneName' => 'North Caicos', 'zoneCode' => 'NC', 'zoneStatus' => '1'],
            ['zoneId' => '3413', 'countryId' => '217', 'zoneName' => 'Providenciales', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '3414', 'countryId' => '217', 'zoneName' => 'West Caicos', 'zoneCode' => 'WC', 'zoneStatus' => '1'],
            ['zoneId' => '3415', 'countryId' => '218', 'zoneName' => 'Nanumanga', 'zoneCode' => 'NMG', 'zoneStatus' => '1'],
            ['zoneId' => '3416', 'countryId' => '218', 'zoneName' => 'Niulakita', 'zoneCode' => 'NLK', 'zoneStatus' => '1'],
            ['zoneId' => '3417', 'countryId' => '218', 'zoneName' => 'Niutao', 'zoneCode' => 'NTO', 'zoneStatus' => '1'],
            ['zoneId' => '3418', 'countryId' => '218', 'zoneName' => 'Funafuti', 'zoneCode' => 'FUN', 'zoneStatus' => '1'],
            ['zoneId' => '3419', 'countryId' => '218', 'zoneName' => 'Nanumea', 'zoneCode' => 'NME', 'zoneStatus' => '1'],
            ['zoneId' => '3420', 'countryId' => '218', 'zoneName' => 'Nui', 'zoneCode' => 'NUI', 'zoneStatus' => '1'],
            ['zoneId' => '3421', 'countryId' => '218', 'zoneName' => 'Nukufetau', 'zoneCode' => 'NFT', 'zoneStatus' => '1'],
            ['zoneId' => '3422', 'countryId' => '218', 'zoneName' => 'Nukulaelae', 'zoneCode' => 'NLL', 'zoneStatus' => '1'],
            ['zoneId' => '3423', 'countryId' => '218', 'zoneName' => 'Vaitupu', 'zoneCode' => 'VAI', 'zoneStatus' => '1'],
            ['zoneId' => '3424', 'countryId' => '219', 'zoneName' => 'Kalangala', 'zoneCode' => 'KAL', 'zoneStatus' => '1'],
            ['zoneId' => '3425', 'countryId' => '219', 'zoneName' => 'Kampala', 'zoneCode' => 'KMP', 'zoneStatus' => '1'],
            ['zoneId' => '3426', 'countryId' => '219', 'zoneName' => 'Kayunga', 'zoneCode' => 'KAY', 'zoneStatus' => '1'],
            ['zoneId' => '3427', 'countryId' => '219', 'zoneName' => 'Kiboga', 'zoneCode' => 'KIB', 'zoneStatus' => '1'],
            ['zoneId' => '3428', 'countryId' => '219', 'zoneName' => 'Luwero', 'zoneCode' => 'LUW', 'zoneStatus' => '1'],
            ['zoneId' => '3429', 'countryId' => '219', 'zoneName' => 'Masaka', 'zoneCode' => 'MAS', 'zoneStatus' => '1'],
            ['zoneId' => '3430', 'countryId' => '219', 'zoneName' => 'Mpigi', 'zoneCode' => 'MPI', 'zoneStatus' => '1'],
            ['zoneId' => '3431', 'countryId' => '219', 'zoneName' => 'Mubende', 'zoneCode' => 'MUB', 'zoneStatus' => '1'],
            ['zoneId' => '3432', 'countryId' => '219', 'zoneName' => 'Mukono', 'zoneCode' => 'MUK', 'zoneStatus' => '1'],
            ['zoneId' => '3433', 'countryId' => '219', 'zoneName' => 'Nakasongola', 'zoneCode' => 'NKS', 'zoneStatus' => '1'],
            ['zoneId' => '3434', 'countryId' => '219', 'zoneName' => 'Rakai', 'zoneCode' => 'RAK', 'zoneStatus' => '1'],
            ['zoneId' => '3435', 'countryId' => '219', 'zoneName' => 'Sembabule', 'zoneCode' => 'SEM', 'zoneStatus' => '1'],
            ['zoneId' => '3436', 'countryId' => '219', 'zoneName' => 'Wakiso', 'zoneCode' => 'WAK', 'zoneStatus' => '1'],
            ['zoneId' => '3437', 'countryId' => '219', 'zoneName' => 'Bugiri', 'zoneCode' => 'BUG', 'zoneStatus' => '1'],
            ['zoneId' => '3438', 'countryId' => '219', 'zoneName' => 'Busia', 'zoneCode' => 'BUS', 'zoneStatus' => '1'],
            ['zoneId' => '3439', 'countryId' => '219', 'zoneName' => 'Iganga', 'zoneCode' => 'IGA', 'zoneStatus' => '1'],
            ['zoneId' => '3440', 'countryId' => '219', 'zoneName' => 'Jinja', 'zoneCode' => 'JIN', 'zoneStatus' => '1'],
            ['zoneId' => '3441', 'countryId' => '219', 'zoneName' => 'Kaberamaido', 'zoneCode' => 'KAB', 'zoneStatus' => '1'],
            ['zoneId' => '3442', 'countryId' => '219', 'zoneName' => 'Kamuli', 'zoneCode' => 'KML', 'zoneStatus' => '1'],
            ['zoneId' => '3443', 'countryId' => '219', 'zoneName' => 'Kapchorwa', 'zoneCode' => 'KPC', 'zoneStatus' => '1'],
            ['zoneId' => '3444', 'countryId' => '219', 'zoneName' => 'Katakwi', 'zoneCode' => 'KTK', 'zoneStatus' => '1'],
            ['zoneId' => '3445', 'countryId' => '219', 'zoneName' => 'Kumi', 'zoneCode' => 'KUM', 'zoneStatus' => '1'],
            ['zoneId' => '3446', 'countryId' => '219', 'zoneName' => 'Mayuge', 'zoneCode' => 'MAY', 'zoneStatus' => '1'],
            ['zoneId' => '3447', 'countryId' => '219', 'zoneName' => 'Mbale', 'zoneCode' => 'MBA', 'zoneStatus' => '1'],
            ['zoneId' => '3448', 'countryId' => '219', 'zoneName' => 'Pallisa', 'zoneCode' => 'PAL', 'zoneStatus' => '1'],
            ['zoneId' => '3449', 'countryId' => '219', 'zoneName' => 'Sironko', 'zoneCode' => 'SIR', 'zoneStatus' => '1'],
            ['zoneId' => '3450', 'countryId' => '219', 'zoneName' => 'Soroti', 'zoneCode' => 'SOR', 'zoneStatus' => '1'],
            ['zoneId' => '3451', 'countryId' => '219', 'zoneName' => 'Tororo', 'zoneCode' => 'TOR', 'zoneStatus' => '1'],
            ['zoneId' => '3452', 'countryId' => '219', 'zoneName' => 'Adjumani', 'zoneCode' => 'ADJ', 'zoneStatus' => '1'],
            ['zoneId' => '3453', 'countryId' => '219', 'zoneName' => 'Apac', 'zoneCode' => 'APC', 'zoneStatus' => '1'],
            ['zoneId' => '3454', 'countryId' => '219', 'zoneName' => 'Arua', 'zoneCode' => 'ARU', 'zoneStatus' => '1'],
            ['zoneId' => '3455', 'countryId' => '219', 'zoneName' => 'Gulu', 'zoneCode' => 'GUL', 'zoneStatus' => '1'],
            ['zoneId' => '3456', 'countryId' => '219', 'zoneName' => 'Kitgum', 'zoneCode' => 'KIT', 'zoneStatus' => '1'],
            ['zoneId' => '3457', 'countryId' => '219', 'zoneName' => 'Kotido', 'zoneCode' => 'KOT', 'zoneStatus' => '1'],
            ['zoneId' => '3458', 'countryId' => '219', 'zoneName' => 'Lira', 'zoneCode' => 'LIR', 'zoneStatus' => '1'],
            ['zoneId' => '3459', 'countryId' => '219', 'zoneName' => 'Moroto', 'zoneCode' => 'MRT', 'zoneStatus' => '1'],
            ['zoneId' => '3460', 'countryId' => '219', 'zoneName' => 'Moyo', 'zoneCode' => 'MOY', 'zoneStatus' => '1'],
            ['zoneId' => '3461', 'countryId' => '219', 'zoneName' => 'Nakapiripirit', 'zoneCode' => 'NAK', 'zoneStatus' => '1'],
            ['zoneId' => '3462', 'countryId' => '219', 'zoneName' => 'Nebbi', 'zoneCode' => 'NEB', 'zoneStatus' => '1'],
            ['zoneId' => '3463', 'countryId' => '219', 'zoneName' => 'Pader', 'zoneCode' => 'PAD', 'zoneStatus' => '1'],
            ['zoneId' => '3464', 'countryId' => '219', 'zoneName' => 'Yumbe', 'zoneCode' => 'YUM', 'zoneStatus' => '1'],
            ['zoneId' => '3465', 'countryId' => '219', 'zoneName' => 'Bundibugyo', 'zoneCode' => 'BUN', 'zoneStatus' => '1'],
            ['zoneId' => '3466', 'countryId' => '219', 'zoneName' => 'Bushenyi', 'zoneCode' => 'BSH', 'zoneStatus' => '1'],
            ['zoneId' => '3467', 'countryId' => '219', 'zoneName' => 'Hoima', 'zoneCode' => 'HOI', 'zoneStatus' => '1'],
            ['zoneId' => '3468', 'countryId' => '219', 'zoneName' => 'Kabale', 'zoneCode' => 'KBL', 'zoneStatus' => '1'],
            ['zoneId' => '3469', 'countryId' => '219', 'zoneName' => 'Kabarole', 'zoneCode' => 'KAR', 'zoneStatus' => '1'],
            ['zoneId' => '3470', 'countryId' => '219', 'zoneName' => 'Kamwenge', 'zoneCode' => 'KAM', 'zoneStatus' => '1'],
            ['zoneId' => '3471', 'countryId' => '219', 'zoneName' => 'Kanungu', 'zoneCode' => 'KAN', 'zoneStatus' => '1'],
            ['zoneId' => '3472', 'countryId' => '219', 'zoneName' => 'Kasese', 'zoneCode' => 'KAS', 'zoneStatus' => '1'],
            ['zoneId' => '3473', 'countryId' => '219', 'zoneName' => 'Kibaale', 'zoneCode' => 'KBA', 'zoneStatus' => '1'],
            ['zoneId' => '3474', 'countryId' => '219', 'zoneName' => 'Kisoro', 'zoneCode' => 'KIS', 'zoneStatus' => '1'],
            ['zoneId' => '3475', 'countryId' => '219', 'zoneName' => 'Kyenjojo', 'zoneCode' => 'KYE', 'zoneStatus' => '1'],
            ['zoneId' => '3476', 'countryId' => '219', 'zoneName' => 'Masindi', 'zoneCode' => 'MSN', 'zoneStatus' => '1'],
            ['zoneId' => '3477', 'countryId' => '219', 'zoneName' => 'Mbarara', 'zoneCode' => 'MBR', 'zoneStatus' => '1'],
            ['zoneId' => '3478', 'countryId' => '219', 'zoneName' => 'Ntungamo', 'zoneCode' => 'NTU', 'zoneStatus' => '1'],
            ['zoneId' => '3479', 'countryId' => '219', 'zoneName' => 'Rukungiri', 'zoneCode' => 'RUK', 'zoneStatus' => '1'],
            ['zoneId' => '3480', 'countryId' => '220', 'zoneName' => 'Cherkas\'ka Oblast\'', 'zoneCode' => '71', 'zoneStatus' => '1'],
            ['zoneId' => '3481', 'countryId' => '220', 'zoneName' => 'Chernihivs\'ka Oblast\'', 'zoneCode' => '74', 'zoneStatus' => '1'],
            ['zoneId' => '3482', 'countryId' => '220', 'zoneName' => 'Chernivets\'ka Oblast\'', 'zoneCode' => '77', 'zoneStatus' => '1'],
            ['zoneId' => '3483', 'countryId' => '220', 'zoneName' => 'Crimea', 'zoneCode' => '43', 'zoneStatus' => '1'],
            ['zoneId' => '3484', 'countryId' => '220', 'zoneName' => 'Dnipropetrovs\'ka Oblast\'', 'zoneCode' => '12', 'zoneStatus' => '1'],
            ['zoneId' => '3485', 'countryId' => '220', 'zoneName' => 'Donets\'ka Oblast\'', 'zoneCode' => '14', 'zoneStatus' => '1'],
            ['zoneId' => '3486', 'countryId' => '220', 'zoneName' => 'Ivano-Frankivs\'ka Oblast\'', 'zoneCode' => '26', 'zoneStatus' => '1'],
            ['zoneId' => '3487', 'countryId' => '220', 'zoneName' => 'Khersons\'ka Oblast\'', 'zoneCode' => '65', 'zoneStatus' => '1'],
            ['zoneId' => '3488', 'countryId' => '220', 'zoneName' => 'Khmel\'nyts\'ka Oblast\'', 'zoneCode' => '68', 'zoneStatus' => '1'],
            ['zoneId' => '3489', 'countryId' => '220', 'zoneName' => 'Kirovohrads\'ka Oblast\'', 'zoneCode' => '35', 'zoneStatus' => '1'],
            ['zoneId' => '3490', 'countryId' => '220', 'zoneName' => 'Kyiv', 'zoneCode' => '30', 'zoneStatus' => '1'],
            ['zoneId' => '3491', 'countryId' => '220', 'zoneName' => 'Kyivs\'ka Oblast\'', 'zoneCode' => '32', 'zoneStatus' => '1'],
            ['zoneId' => '3492', 'countryId' => '220', 'zoneName' => 'Luhans\'ka Oblast\'', 'zoneCode' => '09', 'zoneStatus' => '1'],
            ['zoneId' => '3493', 'countryId' => '220', 'zoneName' => 'L\'vivs\'ka Oblast\'', 'zoneCode' => '46', 'zoneStatus' => '1'],
            ['zoneId' => '3494', 'countryId' => '220', 'zoneName' => 'Mykolayivs\'ka Oblast\'', 'zoneCode' => '48', 'zoneStatus' => '1'],
            ['zoneId' => '3495', 'countryId' => '220', 'zoneName' => 'Odes\'ka Oblast\'', 'zoneCode' => '51', 'zoneStatus' => '1'],
            ['zoneId' => '3496', 'countryId' => '220', 'zoneName' => 'Poltavs\'ka Oblast\'', 'zoneCode' => '53', 'zoneStatus' => '1'],
            ['zoneId' => '3497', 'countryId' => '220', 'zoneName' => 'Rivnens\'ka Oblast\'', 'zoneCode' => '56', 'zoneStatus' => '1'],
            ['zoneId' => '3498', 'countryId' => '220', 'zoneName' => 'Sevastopol\'', 'zoneCode' => '40', 'zoneStatus' => '1'],
            ['zoneId' => '3499', 'countryId' => '220', 'zoneName' => 'Sums\'ka Oblast\'', 'zoneCode' => '59', 'zoneStatus' => '1'],
            ['zoneId' => '3500', 'countryId' => '220', 'zoneName' => 'Ternopil\'s\'ka Oblast\'', 'zoneCode' => '61', 'zoneStatus' => '1'],
            ['zoneId' => '3501', 'countryId' => '220', 'zoneName' => 'Vinnyts\'ka Oblast\'', 'zoneCode' => '05', 'zoneStatus' => '1'],
            ['zoneId' => '3502', 'countryId' => '220', 'zoneName' => 'Volyns\'ka Oblast\'', 'zoneCode' => '07', 'zoneStatus' => '1'],
            ['zoneId' => '3503', 'countryId' => '220', 'zoneName' => 'Zakarpats\'ka Oblast\'', 'zoneCode' => '21', 'zoneStatus' => '1'],
            ['zoneId' => '3504', 'countryId' => '220', 'zoneName' => 'Zaporiz\'ka Oblast\'', 'zoneCode' => '23', 'zoneStatus' => '1'],
            ['zoneId' => '3505', 'countryId' => '220', 'zoneName' => 'Zhytomyrs\'ka oblast\'', 'zoneCode' => '18', 'zoneStatus' => '1'],
            ['zoneId' => '3506', 'countryId' => '221', 'zoneName' => 'Abu Dhabi', 'zoneCode' => 'ADH', 'zoneStatus' => '1'],
            ['zoneId' => '3507', 'countryId' => '221', 'zoneName' => '\'Ajman', 'zoneCode' => 'AJ', 'zoneStatus' => '1'],
            ['zoneId' => '3508', 'countryId' => '221', 'zoneName' => 'Al Fujayrah', 'zoneCode' => 'FU', 'zoneStatus' => '1'],
            ['zoneId' => '3509', 'countryId' => '221', 'zoneName' => 'Ash Shariqah', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '3510', 'countryId' => '221', 'zoneName' => 'Dubai', 'zoneCode' => 'DU', 'zoneStatus' => '1'],
            ['zoneId' => '3511', 'countryId' => '221', 'zoneName' => 'R\'as al Khaymah', 'zoneCode' => 'RK', 'zoneStatus' => '1'],
            ['zoneId' => '3512', 'countryId' => '221', 'zoneName' => 'Umm al Qaywayn', 'zoneCode' => 'UQ', 'zoneStatus' => '1'],
            ['zoneId' => '3513', 'countryId' => '222', 'zoneName' => 'Aberdeen', 'zoneCode' => 'ABN', 'zoneStatus' => '1'],
            ['zoneId' => '3514', 'countryId' => '222', 'zoneName' => 'Aberdeenshire', 'zoneCode' => 'ABNS', 'zoneStatus' => '1'],
            ['zoneId' => '3515', 'countryId' => '222', 'zoneName' => 'Anglesey', 'zoneCode' => 'ANG', 'zoneStatus' => '1'],
            ['zoneId' => '3516', 'countryId' => '222', 'zoneName' => 'Angus', 'zoneCode' => 'AGS', 'zoneStatus' => '1'],
            ['zoneId' => '3517', 'countryId' => '222', 'zoneName' => 'Argyll and Bute', 'zoneCode' => 'ARY', 'zoneStatus' => '1'],
            ['zoneId' => '3518', 'countryId' => '222', 'zoneName' => 'Bedfordshire', 'zoneCode' => 'BEDS', 'zoneStatus' => '1'],
            ['zoneId' => '3519', 'countryId' => '222', 'zoneName' => 'Berkshire', 'zoneCode' => 'BERKS', 'zoneStatus' => '1'],
            ['zoneId' => '3520', 'countryId' => '222', 'zoneName' => 'Blaenau Gwent', 'zoneCode' => 'BLA', 'zoneStatus' => '1'],
            ['zoneId' => '3521', 'countryId' => '222', 'zoneName' => 'Bridgend', 'zoneCode' => 'BRI', 'zoneStatus' => '1'],
            ['zoneId' => '3522', 'countryId' => '222', 'zoneName' => 'Bristol', 'zoneCode' => 'BSTL', 'zoneStatus' => '1'],
            ['zoneId' => '3523', 'countryId' => '222', 'zoneName' => 'Buckinghamshire', 'zoneCode' => 'BUCKS', 'zoneStatus' => '1'],
            ['zoneId' => '3524', 'countryId' => '222', 'zoneName' => 'Caerphilly', 'zoneCode' => 'CAE', 'zoneStatus' => '1'],
            ['zoneId' => '3525', 'countryId' => '222', 'zoneName' => 'Cambridgeshire', 'zoneCode' => 'CAMBS', 'zoneStatus' => '1'],
            ['zoneId' => '3526', 'countryId' => '222', 'zoneName' => 'Cardiff', 'zoneCode' => 'CDF', 'zoneStatus' => '1'],
            ['zoneId' => '3527', 'countryId' => '222', 'zoneName' => 'Carmarthenshire', 'zoneCode' => 'CARM', 'zoneStatus' => '1'],
            ['zoneId' => '3528', 'countryId' => '222', 'zoneName' => 'Ceredigion', 'zoneCode' => 'CDGN', 'zoneStatus' => '1'],
            ['zoneId' => '3529', 'countryId' => '222', 'zoneName' => 'Cheshire', 'zoneCode' => 'CHES', 'zoneStatus' => '1'],
            ['zoneId' => '3530', 'countryId' => '222', 'zoneName' => 'Clackmannanshire', 'zoneCode' => 'CLACK', 'zoneStatus' => '1'],
            ['zoneId' => '3531', 'countryId' => '222', 'zoneName' => 'Conwy', 'zoneCode' => 'CON', 'zoneStatus' => '1'],
            ['zoneId' => '3532', 'countryId' => '222', 'zoneName' => 'Cornwall', 'zoneCode' => 'CORN', 'zoneStatus' => '1'],
            ['zoneId' => '3533', 'countryId' => '222', 'zoneName' => 'Denbighshire', 'zoneCode' => 'DNBG', 'zoneStatus' => '1'],
            ['zoneId' => '3534', 'countryId' => '222', 'zoneName' => 'Derbyshire', 'zoneCode' => 'DERBY', 'zoneStatus' => '1'],
            ['zoneId' => '3535', 'countryId' => '222', 'zoneName' => 'Devon', 'zoneCode' => 'DVN', 'zoneStatus' => '1'],
            ['zoneId' => '3536', 'countryId' => '222', 'zoneName' => 'Dorset', 'zoneCode' => 'DOR', 'zoneStatus' => '1'],
            ['zoneId' => '3537', 'countryId' => '222', 'zoneName' => 'Dumfries and Galloway', 'zoneCode' => 'DGL', 'zoneStatus' => '1'],
            ['zoneId' => '3538', 'countryId' => '222', 'zoneName' => 'Dundee', 'zoneCode' => 'DUND', 'zoneStatus' => '1'],
            ['zoneId' => '3539', 'countryId' => '222', 'zoneName' => 'Durham', 'zoneCode' => 'DHM', 'zoneStatus' => '1'],
            ['zoneId' => '3540', 'countryId' => '222', 'zoneName' => 'East Ayrshire', 'zoneCode' => 'ARYE', 'zoneStatus' => '1'],
            ['zoneId' => '3541', 'countryId' => '222', 'zoneName' => 'East Dunbartonshire', 'zoneCode' => 'DUNBE', 'zoneStatus' => '1'],
            ['zoneId' => '3542', 'countryId' => '222', 'zoneName' => 'East Lothian', 'zoneCode' => 'LOTE', 'zoneStatus' => '1'],
            ['zoneId' => '3543', 'countryId' => '222', 'zoneName' => 'East Renfrewshire', 'zoneCode' => 'RENE', 'zoneStatus' => '1'],
            ['zoneId' => '3544', 'countryId' => '222', 'zoneName' => 'East Riding of Yorkshire', 'zoneCode' => 'ERYS', 'zoneStatus' => '1'],
            ['zoneId' => '3545', 'countryId' => '222', 'zoneName' => 'East Sussex', 'zoneCode' => 'SXE', 'zoneStatus' => '1'],
            ['zoneId' => '3546', 'countryId' => '222', 'zoneName' => 'Edinburgh', 'zoneCode' => 'EDIN', 'zoneStatus' => '1'],
            ['zoneId' => '3547', 'countryId' => '222', 'zoneName' => 'Essex', 'zoneCode' => 'ESX', 'zoneStatus' => '1'],
            ['zoneId' => '3548', 'countryId' => '222', 'zoneName' => 'Falkirk', 'zoneCode' => 'FALK', 'zoneStatus' => '1'],
            ['zoneId' => '3549', 'countryId' => '222', 'zoneName' => 'Fife', 'zoneCode' => 'FFE', 'zoneStatus' => '1'],
            ['zoneId' => '3550', 'countryId' => '222', 'zoneName' => 'Flintshire', 'zoneCode' => 'FLINT', 'zoneStatus' => '1'],
            ['zoneId' => '3551', 'countryId' => '222', 'zoneName' => 'Glasgow', 'zoneCode' => 'GLAS', 'zoneStatus' => '1'],
            ['zoneId' => '3552', 'countryId' => '222', 'zoneName' => 'Gloucestershire', 'zoneCode' => 'GLOS', 'zoneStatus' => '1'],
            ['zoneId' => '3553', 'countryId' => '222', 'zoneName' => 'Greater London', 'zoneCode' => 'LDN', 'zoneStatus' => '1'],
            ['zoneId' => '3554', 'countryId' => '222', 'zoneName' => 'Greater Manchester', 'zoneCode' => 'MCH', 'zoneStatus' => '1'],
            ['zoneId' => '3555', 'countryId' => '222', 'zoneName' => 'Gwynedd', 'zoneCode' => 'GDD', 'zoneStatus' => '1'],
            ['zoneId' => '3556', 'countryId' => '222', 'zoneName' => 'Hampshire', 'zoneCode' => 'HANTS', 'zoneStatus' => '1'],
            ['zoneId' => '3557', 'countryId' => '222', 'zoneName' => 'Herefordshire', 'zoneCode' => 'HWR', 'zoneStatus' => '1'],
            ['zoneId' => '3558', 'countryId' => '222', 'zoneName' => 'Hertfordshire', 'zoneCode' => 'HERTS', 'zoneStatus' => '1'],
            ['zoneId' => '3559', 'countryId' => '222', 'zoneName' => 'Highlands', 'zoneCode' => 'HLD', 'zoneStatus' => '1'],
            ['zoneId' => '3560', 'countryId' => '222', 'zoneName' => 'Inverclyde', 'zoneCode' => 'IVER', 'zoneStatus' => '1'],
            ['zoneId' => '3561', 'countryId' => '222', 'zoneName' => 'Isle of Wight', 'zoneCode' => 'IOW', 'zoneStatus' => '1'],
            ['zoneId' => '3562', 'countryId' => '222', 'zoneName' => 'Kent', 'zoneCode' => 'KNT', 'zoneStatus' => '1'],
            ['zoneId' => '3563', 'countryId' => '222', 'zoneName' => 'Lancashire', 'zoneCode' => 'LANCS', 'zoneStatus' => '1'],
            ['zoneId' => '3564', 'countryId' => '222', 'zoneName' => 'Leicestershire', 'zoneCode' => 'LEICS', 'zoneStatus' => '1'],
            ['zoneId' => '3565', 'countryId' => '222', 'zoneName' => 'Lincolnshire', 'zoneCode' => 'LINCS', 'zoneStatus' => '1'],
            ['zoneId' => '3566', 'countryId' => '222', 'zoneName' => 'Merseyside', 'zoneCode' => 'MSY', 'zoneStatus' => '1'],
            ['zoneId' => '3567', 'countryId' => '222', 'zoneName' => 'Merthyr Tydfil', 'zoneCode' => 'MERT', 'zoneStatus' => '1'],
            ['zoneId' => '3568', 'countryId' => '222', 'zoneName' => 'Midlothian', 'zoneCode' => 'MLOT', 'zoneStatus' => '1'],
            ['zoneId' => '3569', 'countryId' => '222', 'zoneName' => 'Monmouthshire', 'zoneCode' => 'MMOUTH', 'zoneStatus' => '1'],
            ['zoneId' => '3570', 'countryId' => '222', 'zoneName' => 'Moray', 'zoneCode' => 'MORAY', 'zoneStatus' => '1'],
            ['zoneId' => '3571', 'countryId' => '222', 'zoneName' => 'Neath Port Talbot', 'zoneCode' => 'NPRTAL', 'zoneStatus' => '1'],
            ['zoneId' => '3572', 'countryId' => '222', 'zoneName' => 'Newport', 'zoneCode' => 'NEWPT', 'zoneStatus' => '1'],
            ['zoneId' => '3573', 'countryId' => '222', 'zoneName' => 'Norfolk', 'zoneCode' => 'NOR', 'zoneStatus' => '1'],
            ['zoneId' => '3574', 'countryId' => '222', 'zoneName' => 'North Ayrshire', 'zoneCode' => 'ARYN', 'zoneStatus' => '1'],
            ['zoneId' => '3575', 'countryId' => '222', 'zoneName' => 'North Lanarkshire', 'zoneCode' => 'LANN', 'zoneStatus' => '1'],
            ['zoneId' => '3576', 'countryId' => '222', 'zoneName' => 'North Yorkshire', 'zoneCode' => 'YSN', 'zoneStatus' => '1'],
            ['zoneId' => '3577', 'countryId' => '222', 'zoneName' => 'Northamptonshire', 'zoneCode' => 'NHM', 'zoneStatus' => '1'],
            ['zoneId' => '3578', 'countryId' => '222', 'zoneName' => 'Northumberland', 'zoneCode' => 'NLD', 'zoneStatus' => '1'],
            ['zoneId' => '3579', 'countryId' => '222', 'zoneName' => 'Nottinghamshire', 'zoneCode' => 'NOT', 'zoneStatus' => '1'],
            ['zoneId' => '3580', 'countryId' => '222', 'zoneName' => 'Orkney Islands', 'zoneCode' => 'ORK', 'zoneStatus' => '1'],
            ['zoneId' => '3581', 'countryId' => '222', 'zoneName' => 'Oxfordshire', 'zoneCode' => 'OFE', 'zoneStatus' => '1'],
            ['zoneId' => '3582', 'countryId' => '222', 'zoneName' => 'Pembrokeshire', 'zoneCode' => 'PEM', 'zoneStatus' => '1'],
            ['zoneId' => '3583', 'countryId' => '222', 'zoneName' => 'Perth and Kinross', 'zoneCode' => 'PERTH', 'zoneStatus' => '1'],
            ['zoneId' => '3584', 'countryId' => '222', 'zoneName' => 'Powys', 'zoneCode' => 'PWS', 'zoneStatus' => '1'],
            ['zoneId' => '3585', 'countryId' => '222', 'zoneName' => 'Renfrewshire', 'zoneCode' => 'REN', 'zoneStatus' => '1'],
            ['zoneId' => '3586', 'countryId' => '222', 'zoneName' => 'Rhondda Cynon Taff', 'zoneCode' => 'RHON', 'zoneStatus' => '1'],
            ['zoneId' => '3587', 'countryId' => '222', 'zoneName' => 'Rutland', 'zoneCode' => 'RUT', 'zoneStatus' => '1'],
            ['zoneId' => '3588', 'countryId' => '222', 'zoneName' => 'Scottish Borders', 'zoneCode' => 'BOR', 'zoneStatus' => '1'],
            ['zoneId' => '3589', 'countryId' => '222', 'zoneName' => 'Shetland Islands', 'zoneCode' => 'SHET', 'zoneStatus' => '1'],
            ['zoneId' => '3590', 'countryId' => '222', 'zoneName' => 'Shropshire', 'zoneCode' => 'SPE', 'zoneStatus' => '1'],
            ['zoneId' => '3591', 'countryId' => '222', 'zoneName' => 'Somerset', 'zoneCode' => 'SOM', 'zoneStatus' => '1'],
            ['zoneId' => '3592', 'countryId' => '222', 'zoneName' => 'South Ayrshire', 'zoneCode' => 'ARYS', 'zoneStatus' => '1'],
            ['zoneId' => '3593', 'countryId' => '222', 'zoneName' => 'South Lanarkshire', 'zoneCode' => 'LANS', 'zoneStatus' => '1'],
            ['zoneId' => '3594', 'countryId' => '222', 'zoneName' => 'South Yorkshire', 'zoneCode' => 'YSS', 'zoneStatus' => '1'],
            ['zoneId' => '3595', 'countryId' => '222', 'zoneName' => 'Staffordshire', 'zoneCode' => 'SFD', 'zoneStatus' => '1'],
            ['zoneId' => '3596', 'countryId' => '222', 'zoneName' => 'Stirling', 'zoneCode' => 'STIR', 'zoneStatus' => '1'],
            ['zoneId' => '3597', 'countryId' => '222', 'zoneName' => 'Suffolk', 'zoneCode' => 'SFK', 'zoneStatus' => '1'],
            ['zoneId' => '3598', 'countryId' => '222', 'zoneName' => 'Surrey', 'zoneCode' => 'SRY', 'zoneStatus' => '1'],
            ['zoneId' => '3599', 'countryId' => '222', 'zoneName' => 'Swansea', 'zoneCode' => 'SWAN', 'zoneStatus' => '1'],
            ['zoneId' => '3600', 'countryId' => '222', 'zoneName' => 'Torfaen', 'zoneCode' => 'TORF', 'zoneStatus' => '1'],
            ['zoneId' => '3601', 'countryId' => '222', 'zoneName' => 'Tyne and Wear', 'zoneCode' => 'TWR', 'zoneStatus' => '1'],
            ['zoneId' => '3602', 'countryId' => '222', 'zoneName' => 'Vale of Glamorgan', 'zoneCode' => 'VGLAM', 'zoneStatus' => '1'],
            ['zoneId' => '3603', 'countryId' => '222', 'zoneName' => 'Warwickshire', 'zoneCode' => 'WARKS', 'zoneStatus' => '1'],
            ['zoneId' => '3604', 'countryId' => '222', 'zoneName' => 'West Dunbartonshire', 'zoneCode' => 'WDUN', 'zoneStatus' => '1'],
            ['zoneId' => '3605', 'countryId' => '222', 'zoneName' => 'West Lothian', 'zoneCode' => 'WLOT', 'zoneStatus' => '1'],
            ['zoneId' => '3606', 'countryId' => '222', 'zoneName' => 'West Midlands', 'zoneCode' => 'WMD', 'zoneStatus' => '1'],
            ['zoneId' => '3607', 'countryId' => '222', 'zoneName' => 'West Sussex', 'zoneCode' => 'SXW', 'zoneStatus' => '1'],
            ['zoneId' => '3608', 'countryId' => '222', 'zoneName' => 'West Yorkshire', 'zoneCode' => 'YSW', 'zoneStatus' => '1'],
            ['zoneId' => '3609', 'countryId' => '222', 'zoneName' => 'Western Isles', 'zoneCode' => 'WIL', 'zoneStatus' => '1'],
            ['zoneId' => '3610', 'countryId' => '222', 'zoneName' => 'Wiltshire', 'zoneCode' => 'WLT', 'zoneStatus' => '1'],
            ['zoneId' => '3611', 'countryId' => '222', 'zoneName' => 'Worcestershire', 'zoneCode' => 'WORCS', 'zoneStatus' => '1'],
            ['zoneId' => '3612', 'countryId' => '222', 'zoneName' => 'Wrexham', 'zoneCode' => 'WRX', 'zoneStatus' => '1'],
            ['zoneId' => '3613', 'countryId' => '223', 'zoneName' => 'Alabama', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '3614', 'countryId' => '223', 'zoneName' => 'Alaska', 'zoneCode' => 'AK', 'zoneStatus' => '1'],
            ['zoneId' => '3615', 'countryId' => '223', 'zoneName' => 'American Samoa', 'zoneCode' => 'AS', 'zoneStatus' => '1'],
            ['zoneId' => '3616', 'countryId' => '223', 'zoneName' => 'Arizona', 'zoneCode' => 'AZ', 'zoneStatus' => '1'],
            ['zoneId' => '3617', 'countryId' => '223', 'zoneName' => 'Arkansas', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3618', 'countryId' => '223', 'zoneName' => 'Armed Forces Africa', 'zoneCode' => 'AF', 'zoneStatus' => '1'],
            ['zoneId' => '3619', 'countryId' => '223', 'zoneName' => 'Armed Forces Americas', 'zoneCode' => 'AA', 'zoneStatus' => '1'],
            ['zoneId' => '3620', 'countryId' => '223', 'zoneName' => 'Armed Forces Canada', 'zoneCode' => 'AC', 'zoneStatus' => '1'],
            ['zoneId' => '3621', 'countryId' => '223', 'zoneName' => 'Armed Forces Europe', 'zoneCode' => 'AE', 'zoneStatus' => '1'],
            ['zoneId' => '3622', 'countryId' => '223', 'zoneName' => 'Armed Forces Middle East', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '3623', 'countryId' => '223', 'zoneName' => 'Armed Forces Pacific', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '3624', 'countryId' => '223', 'zoneName' => 'California', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '3625', 'countryId' => '223', 'zoneName' => 'Colorado', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '3626', 'countryId' => '223', 'zoneName' => 'Connecticut', 'zoneCode' => 'CT', 'zoneStatus' => '1'],
            ['zoneId' => '3627', 'countryId' => '223', 'zoneName' => 'Delaware', 'zoneCode' => 'DE', 'zoneStatus' => '1'],
            ['zoneId' => '3628', 'countryId' => '223', 'zoneName' => 'District of Columbia', 'zoneCode' => 'DC', 'zoneStatus' => '1'],
            ['zoneId' => '3629', 'countryId' => '223', 'zoneName' => 'Federated States Of Micronesia', 'zoneCode' => 'FM', 'zoneStatus' => '1'],
            ['zoneId' => '3630', 'countryId' => '223', 'zoneName' => 'Florida', 'zoneCode' => 'FL', 'zoneStatus' => '1'],
            ['zoneId' => '3631', 'countryId' => '223', 'zoneName' => 'Georgia', 'zoneCode' => 'GA', 'zoneStatus' => '1'],
            ['zoneId' => '3632', 'countryId' => '223', 'zoneName' => 'Guam', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '3633', 'countryId' => '223', 'zoneName' => 'Hawaii', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '3634', 'countryId' => '223', 'zoneName' => 'Idaho', 'zoneCode' => 'ID', 'zoneStatus' => '1'],
            ['zoneId' => '3635', 'countryId' => '223', 'zoneName' => 'Illinois', 'zoneCode' => 'IL', 'zoneStatus' => '1'],
            ['zoneId' => '3636', 'countryId' => '223', 'zoneName' => 'Indiana', 'zoneCode' => 'IN', 'zoneStatus' => '1'],
            ['zoneId' => '3637', 'countryId' => '223', 'zoneName' => 'Iowa', 'zoneCode' => 'IA', 'zoneStatus' => '1'],
            ['zoneId' => '3638', 'countryId' => '223', 'zoneName' => 'Kansas', 'zoneCode' => 'KS', 'zoneStatus' => '1'],
            ['zoneId' => '3639', 'countryId' => '223', 'zoneName' => 'Kentucky', 'zoneCode' => 'KY', 'zoneStatus' => '1'],
            ['zoneId' => '3640', 'countryId' => '223', 'zoneName' => 'Louisiana', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '3641', 'countryId' => '223', 'zoneName' => 'Maine', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '3642', 'countryId' => '223', 'zoneName' => 'Marshall Islands', 'zoneCode' => 'MH', 'zoneStatus' => '1'],
            ['zoneId' => '3643', 'countryId' => '223', 'zoneName' => 'Maryland', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '3644', 'countryId' => '223', 'zoneName' => 'Massachusetts', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3645', 'countryId' => '223', 'zoneName' => 'Michigan', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '3646', 'countryId' => '223', 'zoneName' => 'Minnesota', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '3647', 'countryId' => '223', 'zoneName' => 'Mississippi', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '3648', 'countryId' => '223', 'zoneName' => 'Missouri', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '3649', 'countryId' => '223', 'zoneName' => 'Montana', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '3650', 'countryId' => '223', 'zoneName' => 'Nebraska', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '3651', 'countryId' => '223', 'zoneName' => 'Nevada', 'zoneCode' => 'NV', 'zoneStatus' => '1'],
            ['zoneId' => '3652', 'countryId' => '223', 'zoneName' => 'New Hampshire', 'zoneCode' => 'NH', 'zoneStatus' => '1'],
            ['zoneId' => '3653', 'countryId' => '223', 'zoneName' => 'New Jersey', 'zoneCode' => 'NJ', 'zoneStatus' => '1'],
            ['zoneId' => '3654', 'countryId' => '223', 'zoneName' => 'New Mexico', 'zoneCode' => 'NM', 'zoneStatus' => '1'],
            ['zoneId' => '3655', 'countryId' => '223', 'zoneName' => 'New York', 'zoneCode' => 'NY', 'zoneStatus' => '1'],
            ['zoneId' => '3656', 'countryId' => '223', 'zoneName' => 'North Carolina', 'zoneCode' => 'NC', 'zoneStatus' => '1'],
            ['zoneId' => '3657', 'countryId' => '223', 'zoneName' => 'North Dakota', 'zoneCode' => 'ND', 'zoneStatus' => '1'],
            ['zoneId' => '3658', 'countryId' => '223', 'zoneName' => 'Northern Mariana Islands', 'zoneCode' => 'MP', 'zoneStatus' => '1'],
            ['zoneId' => '3659', 'countryId' => '223', 'zoneName' => 'Ohio', 'zoneCode' => 'OH', 'zoneStatus' => '1'],
            ['zoneId' => '3660', 'countryId' => '223', 'zoneName' => 'Oklahoma', 'zoneCode' => 'OK', 'zoneStatus' => '1'],
            ['zoneId' => '3661', 'countryId' => '223', 'zoneName' => 'Oregon', 'zoneCode' => 'OR', 'zoneStatus' => '1'],
            ['zoneId' => '3662', 'countryId' => '223', 'zoneName' => 'Palau', 'zoneCode' => 'PW', 'zoneStatus' => '1'],
            ['zoneId' => '3663', 'countryId' => '223', 'zoneName' => 'Pennsylvania', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '3664', 'countryId' => '223', 'zoneName' => 'Puerto Rico', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '3665', 'countryId' => '223', 'zoneName' => 'Rhode Island', 'zoneCode' => 'RI', 'zoneStatus' => '1'],
            ['zoneId' => '3666', 'countryId' => '223', 'zoneName' => 'South Carolina', 'zoneCode' => 'SC', 'zoneStatus' => '1'],
            ['zoneId' => '3667', 'countryId' => '223', 'zoneName' => 'South Dakota', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '3668', 'countryId' => '223', 'zoneName' => 'Tennessee', 'zoneCode' => 'TN', 'zoneStatus' => '1'],
            ['zoneId' => '3669', 'countryId' => '223', 'zoneName' => 'Texas', 'zoneCode' => 'TX', 'zoneStatus' => '1'],
            ['zoneId' => '3670', 'countryId' => '223', 'zoneName' => 'Utah', 'zoneCode' => 'UT', 'zoneStatus' => '1'],
            ['zoneId' => '3671', 'countryId' => '223', 'zoneName' => 'Vermont', 'zoneCode' => 'VT', 'zoneStatus' => '1'],
            ['zoneId' => '3672', 'countryId' => '223', 'zoneName' => 'Virgin Islands', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '3673', 'countryId' => '223', 'zoneName' => 'Virginia', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '3674', 'countryId' => '223', 'zoneName' => 'Washington', 'zoneCode' => 'WA', 'zoneStatus' => '1'],
            ['zoneId' => '3675', 'countryId' => '223', 'zoneName' => 'West Virginia', 'zoneCode' => 'WV', 'zoneStatus' => '1'],
            ['zoneId' => '3676', 'countryId' => '223', 'zoneName' => 'Wisconsin', 'zoneCode' => 'WI', 'zoneStatus' => '1'],
            ['zoneId' => '3677', 'countryId' => '223', 'zoneName' => 'Wyoming', 'zoneCode' => 'WY', 'zoneStatus' => '1'],
            ['zoneId' => '3678', 'countryId' => '224', 'zoneName' => 'Baker Island', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '3679', 'countryId' => '224', 'zoneName' => 'Howland Island', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '3680', 'countryId' => '224', 'zoneName' => 'Jarvis Island', 'zoneCode' => 'JI', 'zoneStatus' => '1'],
            ['zoneId' => '3681', 'countryId' => '224', 'zoneName' => 'Johnston Atoll', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '3682', 'countryId' => '224', 'zoneName' => 'Kingman Reef', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '3683', 'countryId' => '224', 'zoneName' => 'Midway Atoll', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3684', 'countryId' => '224', 'zoneName' => 'Navassa Island', 'zoneCode' => 'NI', 'zoneStatus' => '1'],
            ['zoneId' => '3685', 'countryId' => '224', 'zoneName' => 'Palmyra Atoll', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '3686', 'countryId' => '224', 'zoneName' => 'Wake Island', 'zoneCode' => 'WI', 'zoneStatus' => '1'],
            ['zoneId' => '3687', 'countryId' => '225', 'zoneName' => 'Artigas', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3688', 'countryId' => '225', 'zoneName' => 'Canelones', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '3689', 'countryId' => '225', 'zoneName' => 'Cerro Largo', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '3690', 'countryId' => '225', 'zoneName' => 'Colonia', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '3691', 'countryId' => '225', 'zoneName' => 'Durazno', 'zoneCode' => 'DU', 'zoneStatus' => '1'],
            ['zoneId' => '3692', 'countryId' => '225', 'zoneName' => 'Flores', 'zoneCode' => 'FS', 'zoneStatus' => '1'],
            ['zoneId' => '3693', 'countryId' => '225', 'zoneName' => 'Florida', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '3694', 'countryId' => '225', 'zoneName' => 'Lavalleja', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '3695', 'countryId' => '225', 'zoneName' => 'Maldonado', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3696', 'countryId' => '225', 'zoneName' => 'Montevideo', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '3697', 'countryId' => '225', 'zoneName' => 'Paysandu', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '3698', 'countryId' => '225', 'zoneName' => 'Rio Negro', 'zoneCode' => 'RN', 'zoneStatus' => '1'],
            ['zoneId' => '3699', 'countryId' => '225', 'zoneName' => 'Rivera', 'zoneCode' => 'RV', 'zoneStatus' => '1'],
            ['zoneId' => '3700', 'countryId' => '225', 'zoneName' => 'Rocha', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '3701', 'countryId' => '225', 'zoneName' => 'Salto', 'zoneCode' => 'SL', 'zoneStatus' => '1'],
            ['zoneId' => '3702', 'countryId' => '225', 'zoneName' => 'San Jose', 'zoneCode' => 'SJ', 'zoneStatus' => '1'],
            ['zoneId' => '3703', 'countryId' => '225', 'zoneName' => 'Soriano', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '3704', 'countryId' => '225', 'zoneName' => 'Tacuarembo', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3705', 'countryId' => '225', 'zoneName' => 'Treinta y Tres', 'zoneCode' => 'TT', 'zoneStatus' => '1'],
            ['zoneId' => '3706', 'countryId' => '226', 'zoneName' => 'Andijon', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '3707', 'countryId' => '226', 'zoneName' => 'Buxoro', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '3708', 'countryId' => '226', 'zoneName' => 'Farg\'ona', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '3709', 'countryId' => '226', 'zoneName' => 'Jizzax', 'zoneCode' => 'JI', 'zoneStatus' => '1'],
            ['zoneId' => '3710', 'countryId' => '226', 'zoneName' => 'Namangan', 'zoneCode' => 'NG', 'zoneStatus' => '1'],
            ['zoneId' => '3711', 'countryId' => '226', 'zoneName' => 'Navoiy', 'zoneCode' => 'NW', 'zoneStatus' => '1'],
            ['zoneId' => '3712', 'countryId' => '226', 'zoneName' => 'Qashqadaryo', 'zoneCode' => 'QA', 'zoneStatus' => '1'],
            ['zoneId' => '3713', 'countryId' => '226', 'zoneName' => 'Qoraqalpog\'iston Republikasi', 'zoneCode' => 'QR', 'zoneStatus' => '1'],
            ['zoneId' => '3714', 'countryId' => '226', 'zoneName' => 'Samarqand', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '3715', 'countryId' => '226', 'zoneName' => 'Sirdaryo', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '3716', 'countryId' => '226', 'zoneName' => 'Surxondaryo', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '3717', 'countryId' => '226', 'zoneName' => 'Toshkent City', 'zoneCode' => 'TK', 'zoneStatus' => '1'],
            ['zoneId' => '3718', 'countryId' => '226', 'zoneName' => 'Toshkent Region', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '3719', 'countryId' => '226', 'zoneName' => 'Xorazm', 'zoneCode' => 'XO', 'zoneStatus' => '1'],
            ['zoneId' => '3720', 'countryId' => '227', 'zoneName' => 'Malampa', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3721', 'countryId' => '227', 'zoneName' => 'Penama', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '3722', 'countryId' => '227', 'zoneName' => 'Sanma', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '3723', 'countryId' => '227', 'zoneName' => 'Shefa', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '3724', 'countryId' => '227', 'zoneName' => 'Tafea', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3725', 'countryId' => '227', 'zoneName' => 'Torba', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '3726', 'countryId' => '229', 'zoneName' => 'Amazonas', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '3727', 'countryId' => '229', 'zoneName' => 'Anzoategui', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '3728', 'countryId' => '229', 'zoneName' => 'Apure', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '3729', 'countryId' => '229', 'zoneName' => 'Aragua', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3730', 'countryId' => '229', 'zoneName' => 'Barinas', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '3731', 'countryId' => '229', 'zoneName' => 'Bolivar', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '3732', 'countryId' => '229', 'zoneName' => 'Carabobo', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '3733', 'countryId' => '229', 'zoneName' => 'Cojedes', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '3734', 'countryId' => '229', 'zoneName' => 'Delta Amacuro', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '3735', 'countryId' => '229', 'zoneName' => 'Dependencias Federales', 'zoneCode' => 'DF', 'zoneStatus' => '1'],
            ['zoneId' => '3736', 'countryId' => '229', 'zoneName' => 'Distrito Federal', 'zoneCode' => 'DI', 'zoneStatus' => '1'],
            ['zoneId' => '3737', 'countryId' => '229', 'zoneName' => 'Falcon', 'zoneCode' => 'FA', 'zoneStatus' => '1'],
            ['zoneId' => '3738', 'countryId' => '229', 'zoneName' => 'Guarico', 'zoneCode' => 'GU', 'zoneStatus' => '1'],
            ['zoneId' => '3739', 'countryId' => '229', 'zoneName' => 'Lara', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '3740', 'countryId' => '229', 'zoneName' => 'Merida', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '3741', 'countryId' => '229', 'zoneName' => 'Miranda', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '3742', 'countryId' => '229', 'zoneName' => 'Monagas', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '3743', 'countryId' => '229', 'zoneName' => 'Nueva Esparta', 'zoneCode' => 'NE', 'zoneStatus' => '1'],
            ['zoneId' => '3744', 'countryId' => '229', 'zoneName' => 'Portuguesa', 'zoneCode' => 'PO', 'zoneStatus' => '1'],
            ['zoneId' => '3745', 'countryId' => '229', 'zoneName' => 'Sucre', 'zoneCode' => 'SU', 'zoneStatus' => '1'],
            ['zoneId' => '3746', 'countryId' => '229', 'zoneName' => 'Tachira', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3747', 'countryId' => '229', 'zoneName' => 'Trujillo', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '3748', 'countryId' => '229', 'zoneName' => 'Vargas', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '3749', 'countryId' => '229', 'zoneName' => 'Yaracuy', 'zoneCode' => 'YA', 'zoneStatus' => '1'],
            ['zoneId' => '3750', 'countryId' => '229', 'zoneName' => 'Zulia', 'zoneCode' => 'ZU', 'zoneStatus' => '1'],
            ['zoneId' => '3751', 'countryId' => '230', 'zoneName' => 'An Giang', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '3752', 'countryId' => '230', 'zoneName' => 'Bac Giang', 'zoneCode' => 'BG', 'zoneStatus' => '1'],
            ['zoneId' => '3753', 'countryId' => '230', 'zoneName' => 'Bac Kan', 'zoneCode' => 'BK', 'zoneStatus' => '1'],
            ['zoneId' => '3754', 'countryId' => '230', 'zoneName' => 'Bac Lieu', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '3755', 'countryId' => '230', 'zoneName' => 'Bac Ninh', 'zoneCode' => 'BC', 'zoneStatus' => '1'],
            ['zoneId' => '3756', 'countryId' => '230', 'zoneName' => 'Ba Ria-Vung Tau', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '3757', 'countryId' => '230', 'zoneName' => 'Ben Tre', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '3758', 'countryId' => '230', 'zoneName' => 'Binh Dinh', 'zoneCode' => 'BH', 'zoneStatus' => '1'],
            ['zoneId' => '3759', 'countryId' => '230', 'zoneName' => 'Binh Duong', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '3760', 'countryId' => '230', 'zoneName' => 'Binh Phuoc', 'zoneCode' => 'BP', 'zoneStatus' => '1'],
            ['zoneId' => '3761', 'countryId' => '230', 'zoneName' => 'Binh Thuan', 'zoneCode' => 'BT', 'zoneStatus' => '1'],
            ['zoneId' => '3762', 'countryId' => '230', 'zoneName' => 'Ca Mau', 'zoneCode' => 'CM', 'zoneStatus' => '1'],
            ['zoneId' => '3763', 'countryId' => '230', 'zoneName' => 'Can Tho', 'zoneCode' => 'CT', 'zoneStatus' => '1'],
            ['zoneId' => '3764', 'countryId' => '230', 'zoneName' => 'Cao Bang', 'zoneCode' => 'CB', 'zoneStatus' => '1'],
            ['zoneId' => '3765', 'countryId' => '230', 'zoneName' => 'Dak Lak', 'zoneCode' => 'DL', 'zoneStatus' => '1'],
            ['zoneId' => '3766', 'countryId' => '230', 'zoneName' => 'Dak Nong', 'zoneCode' => 'DG', 'zoneStatus' => '1'],
            ['zoneId' => '3767', 'countryId' => '230', 'zoneName' => 'Da Nang', 'zoneCode' => 'DN', 'zoneStatus' => '1'],
            ['zoneId' => '3768', 'countryId' => '230', 'zoneName' => 'Dien Bien', 'zoneCode' => 'DB', 'zoneStatus' => '1'],
            ['zoneId' => '3769', 'countryId' => '230', 'zoneName' => 'Dong Nai', 'zoneCode' => 'DI', 'zoneStatus' => '1'],
            ['zoneId' => '3770', 'countryId' => '230', 'zoneName' => 'Dong Thap', 'zoneCode' => 'DT', 'zoneStatus' => '1'],
            ['zoneId' => '3771', 'countryId' => '230', 'zoneName' => 'Gia Lai', 'zoneCode' => 'GL', 'zoneStatus' => '1'],
            ['zoneId' => '3772', 'countryId' => '230', 'zoneName' => 'Ha Giang', 'zoneCode' => 'HG', 'zoneStatus' => '1'],
            ['zoneId' => '3773', 'countryId' => '230', 'zoneName' => 'Hai Duong', 'zoneCode' => 'HD', 'zoneStatus' => '1'],
            ['zoneId' => '3774', 'countryId' => '230', 'zoneName' => 'Hai Phong', 'zoneCode' => 'HP', 'zoneStatus' => '1'],
            ['zoneId' => '3775', 'countryId' => '230', 'zoneName' => 'Ha Nam', 'zoneCode' => 'HM', 'zoneStatus' => '1'],
            ['zoneId' => '3776', 'countryId' => '230', 'zoneName' => 'Ha Noi', 'zoneCode' => 'HI', 'zoneStatus' => '1'],
            ['zoneId' => '3777', 'countryId' => '230', 'zoneName' => 'Ha Tay', 'zoneCode' => 'HT', 'zoneStatus' => '1'],
            ['zoneId' => '3778', 'countryId' => '230', 'zoneName' => 'Ha Tinh', 'zoneCode' => 'HH', 'zoneStatus' => '1'],
            ['zoneId' => '3779', 'countryId' => '230', 'zoneName' => 'Hoa Binh', 'zoneCode' => 'HB', 'zoneStatus' => '1'],
            ['zoneId' => '3780', 'countryId' => '230', 'zoneName' => 'Ho Chi Minh City', 'zoneCode' => 'HC', 'zoneStatus' => '1'],
            ['zoneId' => '3781', 'countryId' => '230', 'zoneName' => 'Hau Giang', 'zoneCode' => 'HU', 'zoneStatus' => '1'],
            ['zoneId' => '3782', 'countryId' => '230', 'zoneName' => 'Hung Yen', 'zoneCode' => 'HY', 'zoneStatus' => '1'],
            ['zoneId' => '3783', 'countryId' => '232', 'zoneName' => 'Saint Croix', 'zoneCode' => 'C', 'zoneStatus' => '1'],
            ['zoneId' => '3784', 'countryId' => '232', 'zoneName' => 'Saint John', 'zoneCode' => 'J', 'zoneStatus' => '1'],
            ['zoneId' => '3785', 'countryId' => '232', 'zoneName' => 'Saint Thomas', 'zoneCode' => 'T', 'zoneStatus' => '1'],
            ['zoneId' => '3786', 'countryId' => '233', 'zoneName' => 'Alo', 'zoneCode' => 'A', 'zoneStatus' => '1'],
            ['zoneId' => '3787', 'countryId' => '233', 'zoneName' => 'Sigave', 'zoneCode' => 'S', 'zoneStatus' => '1'],
            ['zoneId' => '3788', 'countryId' => '233', 'zoneName' => 'Wallis', 'zoneCode' => 'W', 'zoneStatus' => '1'],
            ['zoneId' => '3789', 'countryId' => '235', 'zoneName' => 'Abyan', 'zoneCode' => 'AB', 'zoneStatus' => '1'],
            ['zoneId' => '3790', 'countryId' => '235', 'zoneName' => 'Adan', 'zoneCode' => 'AD', 'zoneStatus' => '1'],
            ['zoneId' => '3791', 'countryId' => '235', 'zoneName' => 'Amran', 'zoneCode' => 'AM', 'zoneStatus' => '1'],
            ['zoneId' => '3792', 'countryId' => '235', 'zoneName' => 'Al Bayda', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '3793', 'countryId' => '235', 'zoneName' => 'Ad Dali', 'zoneCode' => 'DA', 'zoneStatus' => '1'],
            ['zoneId' => '3794', 'countryId' => '235', 'zoneName' => 'Dhamar', 'zoneCode' => 'DH', 'zoneStatus' => '1'],
            ['zoneId' => '3795', 'countryId' => '235', 'zoneName' => 'Hadramawt', 'zoneCode' => 'HD', 'zoneStatus' => '1'],
            ['zoneId' => '3796', 'countryId' => '235', 'zoneName' => 'Hajjah', 'zoneCode' => 'HJ', 'zoneStatus' => '1'],
            ['zoneId' => '3797', 'countryId' => '235', 'zoneName' => 'Al Hudaydah', 'zoneCode' => 'HU', 'zoneStatus' => '1'],
            ['zoneId' => '3798', 'countryId' => '235', 'zoneName' => 'Ibb', 'zoneCode' => 'IB', 'zoneStatus' => '1'],
            ['zoneId' => '3799', 'countryId' => '235', 'zoneName' => 'Al Jawf', 'zoneCode' => 'JA', 'zoneStatus' => '1'],
            ['zoneId' => '3800', 'countryId' => '235', 'zoneName' => 'Lahij', 'zoneCode' => 'LA', 'zoneStatus' => '1'],
            ['zoneId' => '3801', 'countryId' => '235', 'zoneName' => 'Ma\'rib', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3802', 'countryId' => '235', 'zoneName' => 'Al Mahrah', 'zoneCode' => 'MR', 'zoneStatus' => '1'],
            ['zoneId' => '3803', 'countryId' => '235', 'zoneName' => 'Al Mahwit', 'zoneCode' => 'MW', 'zoneStatus' => '1'],
            ['zoneId' => '3804', 'countryId' => '235', 'zoneName' => 'Sa\'dah', 'zoneCode' => 'SD', 'zoneStatus' => '1'],
            ['zoneId' => '3805', 'countryId' => '235', 'zoneName' => 'San\'a', 'zoneCode' => 'SN', 'zoneStatus' => '1'],
            ['zoneId' => '3806', 'countryId' => '235', 'zoneName' => 'Shabwah', 'zoneCode' => 'SH', 'zoneStatus' => '1'],
            ['zoneId' => '3807', 'countryId' => '235', 'zoneName' => 'Ta\'izz', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3812', 'countryId' => '237', 'zoneName' => 'Bas-Congo', 'zoneCode' => 'BC', 'zoneStatus' => '1'],
            ['zoneId' => '3813', 'countryId' => '237', 'zoneName' => 'Bandundu', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '3814', 'countryId' => '237', 'zoneName' => 'Equateur', 'zoneCode' => 'EQ', 'zoneStatus' => '1'],
            ['zoneId' => '3815', 'countryId' => '237', 'zoneName' => 'Katanga', 'zoneCode' => 'KA', 'zoneStatus' => '1'],
            ['zoneId' => '3816', 'countryId' => '237', 'zoneName' => 'Kasai-Oriental', 'zoneCode' => 'KE', 'zoneStatus' => '1'],
            ['zoneId' => '3817', 'countryId' => '237', 'zoneName' => 'Kinshasa', 'zoneCode' => 'KN', 'zoneStatus' => '1'],
            ['zoneId' => '3818', 'countryId' => '237', 'zoneName' => 'Kasai-Occidental', 'zoneCode' => 'KW', 'zoneStatus' => '1'],
            ['zoneId' => '3819', 'countryId' => '237', 'zoneName' => 'Maniema', 'zoneCode' => 'MA', 'zoneStatus' => '1'],
            ['zoneId' => '3820', 'countryId' => '237', 'zoneName' => 'Nord-Kivu', 'zoneCode' => 'NK', 'zoneStatus' => '1'],
            ['zoneId' => '3821', 'countryId' => '237', 'zoneName' => 'Orientale', 'zoneCode' => 'OR', 'zoneStatus' => '1'],
            ['zoneId' => '3822', 'countryId' => '237', 'zoneName' => 'Sud-Kivu', 'zoneCode' => 'SK', 'zoneStatus' => '1'],
            ['zoneId' => '3823', 'countryId' => '238', 'zoneName' => 'Central', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '3824', 'countryId' => '238', 'zoneName' => 'Copperbelt', 'zoneCode' => 'CB', 'zoneStatus' => '1'],
            ['zoneId' => '3825', 'countryId' => '238', 'zoneName' => 'Eastern', 'zoneCode' => 'EA', 'zoneStatus' => '1'],
            ['zoneId' => '3826', 'countryId' => '238', 'zoneName' => 'Luapula', 'zoneCode' => 'LP', 'zoneStatus' => '1'],
            ['zoneId' => '3827', 'countryId' => '238', 'zoneName' => 'Lusaka', 'zoneCode' => 'LK', 'zoneStatus' => '1'],
            ['zoneId' => '3828', 'countryId' => '238', 'zoneName' => 'Northern', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '3829', 'countryId' => '238', 'zoneName' => 'North-Western', 'zoneCode' => 'NW', 'zoneStatus' => '1'],
            ['zoneId' => '3830', 'countryId' => '238', 'zoneName' => 'Southern', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '3831', 'countryId' => '238', 'zoneName' => 'Western', 'zoneCode' => 'WE', 'zoneStatus' => '1'],
            ['zoneId' => '3832', 'countryId' => '239', 'zoneName' => 'Bulawayo', 'zoneCode' => 'BU', 'zoneStatus' => '1'],
            ['zoneId' => '3833', 'countryId' => '239', 'zoneName' => 'Harare', 'zoneCode' => 'HA', 'zoneStatus' => '1'],
            ['zoneId' => '3834', 'countryId' => '239', 'zoneName' => 'Manicaland', 'zoneCode' => 'ML', 'zoneStatus' => '1'],
            ['zoneId' => '3835', 'countryId' => '239', 'zoneName' => 'Mashonaland Central', 'zoneCode' => 'MC', 'zoneStatus' => '1'],
            ['zoneId' => '3836', 'countryId' => '239', 'zoneName' => 'Mashonaland East', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '3837', 'countryId' => '239', 'zoneName' => 'Mashonaland West', 'zoneCode' => 'MW', 'zoneStatus' => '1'],
            ['zoneId' => '3838', 'countryId' => '239', 'zoneName' => 'Masvingo', 'zoneCode' => 'MV', 'zoneStatus' => '1'],
            ['zoneId' => '3839', 'countryId' => '239', 'zoneName' => 'Matabeleland North', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '3840', 'countryId' => '239', 'zoneName' => 'Matabeleland South', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '3841', 'countryId' => '239', 'zoneName' => 'Midlands', 'zoneCode' => 'MD', 'zoneStatus' => '1'],
            ['zoneId' => '3842', 'countryId' => '105', 'zoneName' => 'Agrigento', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '3843', 'countryId' => '105', 'zoneName' => 'Alessandria', 'zoneCode' => 'AL', 'zoneStatus' => '1'],
            ['zoneId' => '3844', 'countryId' => '105', 'zoneName' => 'Ancona', 'zoneCode' => 'AN', 'zoneStatus' => '1'],
            ['zoneId' => '3845', 'countryId' => '105', 'zoneName' => 'Aosta', 'zoneCode' => 'AO', 'zoneStatus' => '1'],
            ['zoneId' => '3846', 'countryId' => '105', 'zoneName' => 'Arezzo', 'zoneCode' => 'AR', 'zoneStatus' => '1'],
            ['zoneId' => '3847', 'countryId' => '105', 'zoneName' => 'Ascoli Piceno', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '3848', 'countryId' => '105', 'zoneName' => 'Asti', 'zoneCode' => 'AT', 'zoneStatus' => '1'],
            ['zoneId' => '3849', 'countryId' => '105', 'zoneName' => 'Avellino', 'zoneCode' => 'AV', 'zoneStatus' => '1'],
            ['zoneId' => '3850', 'countryId' => '105', 'zoneName' => 'Bari', 'zoneCode' => 'BA', 'zoneStatus' => '1'],
            ['zoneId' => '3851', 'countryId' => '105', 'zoneName' => 'Belluno', 'zoneCode' => 'BL', 'zoneStatus' => '1'],
            ['zoneId' => '3852', 'countryId' => '105', 'zoneName' => 'Benevento', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '3853', 'countryId' => '105', 'zoneName' => 'Bergamo', 'zoneCode' => 'BG', 'zoneStatus' => '1'],
            ['zoneId' => '3854', 'countryId' => '105', 'zoneName' => 'Biella', 'zoneCode' => 'BI', 'zoneStatus' => '1'],
            ['zoneId' => '3855', 'countryId' => '105', 'zoneName' => 'Bologna', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '3856', 'countryId' => '105', 'zoneName' => 'Bolzano', 'zoneCode' => 'BZ', 'zoneStatus' => '1'],
            ['zoneId' => '3857', 'countryId' => '105', 'zoneName' => 'Brescia', 'zoneCode' => 'BS', 'zoneStatus' => '1'],
            ['zoneId' => '3858', 'countryId' => '105', 'zoneName' => 'Brindisi', 'zoneCode' => 'BR', 'zoneStatus' => '1'],
            ['zoneId' => '3859', 'countryId' => '105', 'zoneName' => 'Cagliari', 'zoneCode' => 'CA', 'zoneStatus' => '1'],
            ['zoneId' => '3860', 'countryId' => '105', 'zoneName' => 'Caltanissetta', 'zoneCode' => 'CL', 'zoneStatus' => '1'],
            ['zoneId' => '3861', 'countryId' => '105', 'zoneName' => 'Campobasso', 'zoneCode' => 'CB', 'zoneStatus' => '1'],
            ['zoneId' => '3863', 'countryId' => '105', 'zoneName' => 'Caserta', 'zoneCode' => 'CE', 'zoneStatus' => '1'],
            ['zoneId' => '3864', 'countryId' => '105', 'zoneName' => 'Catania', 'zoneCode' => 'CT', 'zoneStatus' => '1'],
            ['zoneId' => '3865', 'countryId' => '105', 'zoneName' => 'Catanzaro', 'zoneCode' => 'CZ', 'zoneStatus' => '1'],
            ['zoneId' => '3866', 'countryId' => '105', 'zoneName' => 'Chieti', 'zoneCode' => 'CH', 'zoneStatus' => '1'],
            ['zoneId' => '3867', 'countryId' => '105', 'zoneName' => 'Como', 'zoneCode' => 'CO', 'zoneStatus' => '1'],
            ['zoneId' => '3868', 'countryId' => '105', 'zoneName' => 'Cosenza', 'zoneCode' => 'CS', 'zoneStatus' => '1'],
            ['zoneId' => '3869', 'countryId' => '105', 'zoneName' => 'Cremona', 'zoneCode' => 'CR', 'zoneStatus' => '1'],
            ['zoneId' => '3870', 'countryId' => '105', 'zoneName' => 'Crotone', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '3871', 'countryId' => '105', 'zoneName' => 'Cuneo', 'zoneCode' => 'CN', 'zoneStatus' => '1'],
            ['zoneId' => '3872', 'countryId' => '105', 'zoneName' => 'Enna', 'zoneCode' => 'EN', 'zoneStatus' => '1'],
            ['zoneId' => '3873', 'countryId' => '105', 'zoneName' => 'Ferrara', 'zoneCode' => 'FE', 'zoneStatus' => '1'],
            ['zoneId' => '3874', 'countryId' => '105', 'zoneName' => 'Firenze', 'zoneCode' => 'FI', 'zoneStatus' => '1'],
            ['zoneId' => '3875', 'countryId' => '105', 'zoneName' => 'Foggia', 'zoneCode' => 'FG', 'zoneStatus' => '1'],
            ['zoneId' => '3876', 'countryId' => '105', 'zoneName' => 'Forli-Cesena', 'zoneCode' => 'FC', 'zoneStatus' => '1'],
            ['zoneId' => '3877', 'countryId' => '105', 'zoneName' => 'Frosinone', 'zoneCode' => 'FR', 'zoneStatus' => '1'],
            ['zoneId' => '3878', 'countryId' => '105', 'zoneName' => 'Genova', 'zoneCode' => 'GE', 'zoneStatus' => '1'],
            ['zoneId' => '3879', 'countryId' => '105', 'zoneName' => 'Gorizia', 'zoneCode' => 'GO', 'zoneStatus' => '1'],
            ['zoneId' => '3880', 'countryId' => '105', 'zoneName' => 'Grosseto', 'zoneCode' => 'GR', 'zoneStatus' => '1'],
            ['zoneId' => '3881', 'countryId' => '105', 'zoneName' => 'Imperia', 'zoneCode' => 'IM', 'zoneStatus' => '1'],
            ['zoneId' => '3882', 'countryId' => '105', 'zoneName' => 'Isernia', 'zoneCode' => 'IS', 'zoneStatus' => '1'],
            ['zoneId' => '3883', 'countryId' => '105', 'zoneName' => 'L&#39;Aquila', 'zoneCode' => 'AQ', 'zoneStatus' => '1'],
            ['zoneId' => '3884', 'countryId' => '105', 'zoneName' => 'La Spezia', 'zoneCode' => 'SP', 'zoneStatus' => '1'],
            ['zoneId' => '3885', 'countryId' => '105', 'zoneName' => 'Latina', 'zoneCode' => 'LT', 'zoneStatus' => '1'],
            ['zoneId' => '3886', 'countryId' => '105', 'zoneName' => 'Lecce', 'zoneCode' => 'LE', 'zoneStatus' => '1'],
            ['zoneId' => '3887', 'countryId' => '105', 'zoneName' => 'Lecco', 'zoneCode' => 'LC', 'zoneStatus' => '1'],
            ['zoneId' => '3888', 'countryId' => '105', 'zoneName' => 'Livorno', 'zoneCode' => 'LI', 'zoneStatus' => '1'],
            ['zoneId' => '3889', 'countryId' => '105', 'zoneName' => 'Lodi', 'zoneCode' => 'LO', 'zoneStatus' => '1'],
            ['zoneId' => '3890', 'countryId' => '105', 'zoneName' => 'Lucca', 'zoneCode' => 'LU', 'zoneStatus' => '1'],
            ['zoneId' => '3891', 'countryId' => '105', 'zoneName' => 'Macerata', 'zoneCode' => 'MC', 'zoneStatus' => '1'],
            ['zoneId' => '3892', 'countryId' => '105', 'zoneName' => 'Mantova', 'zoneCode' => 'MN', 'zoneStatus' => '1'],
            ['zoneId' => '3893', 'countryId' => '105', 'zoneName' => 'Massa-Carrara', 'zoneCode' => 'MS', 'zoneStatus' => '1'],
            ['zoneId' => '3894', 'countryId' => '105', 'zoneName' => 'Matera', 'zoneCode' => 'MT', 'zoneStatus' => '1'],
            ['zoneId' => '3896', 'countryId' => '105', 'zoneName' => 'Messina', 'zoneCode' => 'ME', 'zoneStatus' => '1'],
            ['zoneId' => '3897', 'countryId' => '105', 'zoneName' => 'Milano', 'zoneCode' => 'MI', 'zoneStatus' => '1'],
            ['zoneId' => '3898', 'countryId' => '105', 'zoneName' => 'Modena', 'zoneCode' => 'MO', 'zoneStatus' => '1'],
            ['zoneId' => '3899', 'countryId' => '105', 'zoneName' => 'Napoli', 'zoneCode' => 'NA', 'zoneStatus' => '1'],
            ['zoneId' => '3900', 'countryId' => '105', 'zoneName' => 'Novara', 'zoneCode' => 'NO', 'zoneStatus' => '1'],
            ['zoneId' => '3901', 'countryId' => '105', 'zoneName' => 'Nuoro', 'zoneCode' => 'NU', 'zoneStatus' => '1'],
            ['zoneId' => '3904', 'countryId' => '105', 'zoneName' => 'Oristano', 'zoneCode' => 'OR', 'zoneStatus' => '1'],
            ['zoneId' => '3905', 'countryId' => '105', 'zoneName' => 'Padova', 'zoneCode' => 'PD', 'zoneStatus' => '1'],
            ['zoneId' => '3906', 'countryId' => '105', 'zoneName' => 'Palermo', 'zoneCode' => 'PA', 'zoneStatus' => '1'],
            ['zoneId' => '3907', 'countryId' => '105', 'zoneName' => 'Parma', 'zoneCode' => 'PR', 'zoneStatus' => '1'],
            ['zoneId' => '3908', 'countryId' => '105', 'zoneName' => 'Pavia', 'zoneCode' => 'PV', 'zoneStatus' => '1'],
            ['zoneId' => '3909', 'countryId' => '105', 'zoneName' => 'Perugia', 'zoneCode' => 'PG', 'zoneStatus' => '1'],
            ['zoneId' => '3910', 'countryId' => '105', 'zoneName' => 'Pesaro e Urbino', 'zoneCode' => 'PU', 'zoneStatus' => '1'],
            ['zoneId' => '3911', 'countryId' => '105', 'zoneName' => 'Pescara', 'zoneCode' => 'PE', 'zoneStatus' => '1'],
            ['zoneId' => '3912', 'countryId' => '105', 'zoneName' => 'Piacenza', 'zoneCode' => 'PC', 'zoneStatus' => '1'],
            ['zoneId' => '3913', 'countryId' => '105', 'zoneName' => 'Pisa', 'zoneCode' => 'PI', 'zoneStatus' => '1'],
            ['zoneId' => '3914', 'countryId' => '105', 'zoneName' => 'Pistoia', 'zoneCode' => 'PT', 'zoneStatus' => '1'],
            ['zoneId' => '3915', 'countryId' => '105', 'zoneName' => 'Pordenone', 'zoneCode' => 'PN', 'zoneStatus' => '1'],
            ['zoneId' => '3916', 'countryId' => '105', 'zoneName' => 'Potenza', 'zoneCode' => 'PZ', 'zoneStatus' => '1'],
            ['zoneId' => '3917', 'countryId' => '105', 'zoneName' => 'Prato', 'zoneCode' => 'PO', 'zoneStatus' => '1'],
            ['zoneId' => '3918', 'countryId' => '105', 'zoneName' => 'Ragusa', 'zoneCode' => 'RG', 'zoneStatus' => '1'],
            ['zoneId' => '3919', 'countryId' => '105', 'zoneName' => 'Ravenna', 'zoneCode' => 'RA', 'zoneStatus' => '1'],
            ['zoneId' => '3920', 'countryId' => '105', 'zoneName' => 'Reggio Calabria', 'zoneCode' => 'RC', 'zoneStatus' => '1'],
            ['zoneId' => '3921', 'countryId' => '105', 'zoneName' => 'Reggio Emilia', 'zoneCode' => 'RE', 'zoneStatus' => '1'],
            ['zoneId' => '3922', 'countryId' => '105', 'zoneName' => 'Rieti', 'zoneCode' => 'RI', 'zoneStatus' => '1'],
            ['zoneId' => '3923', 'countryId' => '105', 'zoneName' => 'Rimini', 'zoneCode' => 'RN', 'zoneStatus' => '1'],
            ['zoneId' => '3924', 'countryId' => '105', 'zoneName' => 'Roma', 'zoneCode' => 'RM', 'zoneStatus' => '1'],
            ['zoneId' => '3925', 'countryId' => '105', 'zoneName' => 'Rovigo', 'zoneCode' => 'RO', 'zoneStatus' => '1'],
            ['zoneId' => '3926', 'countryId' => '105', 'zoneName' => 'Salerno', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '3927', 'countryId' => '105', 'zoneName' => 'Sassari', 'zoneCode' => 'SS', 'zoneStatus' => '1'],
            ['zoneId' => '3928', 'countryId' => '105', 'zoneName' => 'Savona', 'zoneCode' => 'SV', 'zoneStatus' => '1'],
            ['zoneId' => '3929', 'countryId' => '105', 'zoneName' => 'Siena', 'zoneCode' => 'SI', 'zoneStatus' => '1'],
            ['zoneId' => '3930', 'countryId' => '105', 'zoneName' => 'Siracusa', 'zoneCode' => 'SR', 'zoneStatus' => '1'],
            ['zoneId' => '3931', 'countryId' => '105', 'zoneName' => 'Sondrio', 'zoneCode' => 'SO', 'zoneStatus' => '1'],
            ['zoneId' => '3932', 'countryId' => '105', 'zoneName' => 'Taranto', 'zoneCode' => 'TA', 'zoneStatus' => '1'],
            ['zoneId' => '3933', 'countryId' => '105', 'zoneName' => 'Teramo', 'zoneCode' => 'TE', 'zoneStatus' => '1'],
            ['zoneId' => '3934', 'countryId' => '105', 'zoneName' => 'Terni', 'zoneCode' => 'TR', 'zoneStatus' => '1'],
            ['zoneId' => '3935', 'countryId' => '105', 'zoneName' => 'Torino', 'zoneCode' => 'TO', 'zoneStatus' => '1'],
            ['zoneId' => '3936', 'countryId' => '105', 'zoneName' => 'Trapani', 'zoneCode' => 'TP', 'zoneStatus' => '1'],
            ['zoneId' => '3937', 'countryId' => '105', 'zoneName' => 'Trento', 'zoneCode' => 'TN', 'zoneStatus' => '1'],
            ['zoneId' => '3938', 'countryId' => '105', 'zoneName' => 'Treviso', 'zoneCode' => 'TV', 'zoneStatus' => '1'],
            ['zoneId' => '3939', 'countryId' => '105', 'zoneName' => 'Trieste', 'zoneCode' => 'TS', 'zoneStatus' => '1'],
            ['zoneId' => '3940', 'countryId' => '105', 'zoneName' => 'Udine', 'zoneCode' => 'UD', 'zoneStatus' => '1'],
            ['zoneId' => '3941', 'countryId' => '105', 'zoneName' => 'Varese', 'zoneCode' => 'VA', 'zoneStatus' => '1'],
            ['zoneId' => '3942', 'countryId' => '105', 'zoneName' => 'Venezia', 'zoneCode' => 'VE', 'zoneStatus' => '1'],
            ['zoneId' => '3943', 'countryId' => '105', 'zoneName' => 'Verbano-Cusio-Ossola', 'zoneCode' => 'VB', 'zoneStatus' => '1'],
            ['zoneId' => '3944', 'countryId' => '105', 'zoneName' => 'Vercelli', 'zoneCode' => 'VC', 'zoneStatus' => '1'],
            ['zoneId' => '3945', 'countryId' => '105', 'zoneName' => 'Verona', 'zoneCode' => 'VR', 'zoneStatus' => '1'],
            ['zoneId' => '3946', 'countryId' => '105', 'zoneName' => 'Vibo Valentia', 'zoneCode' => 'VV', 'zoneStatus' => '1'],
            ['zoneId' => '3947', 'countryId' => '105', 'zoneName' => 'Vicenza', 'zoneCode' => 'VI', 'zoneStatus' => '1'],
            ['zoneId' => '3948', 'countryId' => '105', 'zoneName' => 'Viterbo', 'zoneCode' => 'VT', 'zoneStatus' => '1'],
            ['zoneId' => '3949', 'countryId' => '222', 'zoneName' => 'County Antrim', 'zoneCode' => 'ANT', 'zoneStatus' => '1'],
            ['zoneId' => '3950', 'countryId' => '222', 'zoneName' => 'County Armagh', 'zoneCode' => 'ARM', 'zoneStatus' => '1'],
            ['zoneId' => '3951', 'countryId' => '222', 'zoneName' => 'County Down', 'zoneCode' => 'DOW', 'zoneStatus' => '1'],
            ['zoneId' => '3952', 'countryId' => '222', 'zoneName' => 'County Fermanagh', 'zoneCode' => 'FER', 'zoneStatus' => '1'],
            ['zoneId' => '3953', 'countryId' => '222', 'zoneName' => 'County Londonderry', 'zoneCode' => 'LDY', 'zoneStatus' => '1'],
            ['zoneId' => '3954', 'countryId' => '222', 'zoneName' => 'County Tyrone', 'zoneCode' => 'TYR', 'zoneStatus' => '1'],
            ['zoneId' => '3955', 'countryId' => '222', 'zoneName' => 'Cumbria', 'zoneCode' => 'CMA', 'zoneStatus' => '1'],
            ['zoneId' => '3956', 'countryId' => '190', 'zoneName' => 'Pomurska', 'zoneCode' => '1', 'zoneStatus' => '1'],
            ['zoneId' => '3957', 'countryId' => '190', 'zoneName' => 'Podravska', 'zoneCode' => '2', 'zoneStatus' => '1'],
            ['zoneId' => '3958', 'countryId' => '190', 'zoneName' => 'Koroška', 'zoneCode' => '3', 'zoneStatus' => '1'],
            ['zoneId' => '3959', 'countryId' => '190', 'zoneName' => 'Savinjska', 'zoneCode' => '4', 'zoneStatus' => '1'],
            ['zoneId' => '3960', 'countryId' => '190', 'zoneName' => 'Zasavska', 'zoneCode' => '5', 'zoneStatus' => '1'],
            ['zoneId' => '3961', 'countryId' => '190', 'zoneName' => 'Spodnjeposavska', 'zoneCode' => '6', 'zoneStatus' => '1'],
            ['zoneId' => '3962', 'countryId' => '190', 'zoneName' => 'Jugovzhodna Slovenija', 'zoneCode' => '7', 'zoneStatus' => '1'],
            ['zoneId' => '3963', 'countryId' => '190', 'zoneName' => 'Osrednjeslovenska', 'zoneCode' => '8', 'zoneStatus' => '1'],
            ['zoneId' => '3964', 'countryId' => '190', 'zoneName' => 'Gorenjska', 'zoneCode' => '9', 'zoneStatus' => '1'],
            ['zoneId' => '3965', 'countryId' => '190', 'zoneName' => 'Notranjsko-kraška', 'zoneCode' => '10', 'zoneStatus' => '1'],
            ['zoneId' => '3966', 'countryId' => '190', 'zoneName' => 'Goriška', 'zoneCode' => '11', 'zoneStatus' => '1'],
            ['zoneId' => '3967', 'countryId' => '190', 'zoneName' => 'Obalno-kraška', 'zoneCode' => '12', 'zoneStatus' => '1'],
            ['zoneId' => '3968', 'countryId' => '33', 'zoneName' => 'Ruse', 'zoneCode' => '', 'zoneStatus' => '1'],
            ['zoneId' => '3969', 'countryId' => '101', 'zoneName' => 'Alborz', 'zoneCode' => 'ALB', 'zoneStatus' => '1'],
            ['zoneId' => '3970', 'countryId' => '21', 'zoneName' => 'Brussels-Capital Region', 'zoneCode' => 'BRU', 'zoneStatus' => '1'],
            ['zoneId' => '3971', 'countryId' => '138', 'zoneName' => 'Aguascalientes', 'zoneCode' => 'AG', 'zoneStatus' => '1'],
            ['zoneId' => '3973', 'countryId' => '242', 'zoneName' => 'Andrijevica', 'zoneCode' => '01', 'zoneStatus' => '1'],
            ['zoneId' => '3974', 'countryId' => '242', 'zoneName' => 'Bar', 'zoneCode' => '02', 'zoneStatus' => '1'],
            ['zoneId' => '3975', 'countryId' => '242', 'zoneName' => 'Berane', 'zoneCode' => '03', 'zoneStatus' => '1'],
            ['zoneId' => '3976', 'countryId' => '242', 'zoneName' => 'Bijelo Polje', 'zoneCode' => '04', 'zoneStatus' => '1'],
            ['zoneId' => '3977', 'countryId' => '242', 'zoneName' => 'Budva', 'zoneCode' => '05', 'zoneStatus' => '1'],
            ['zoneId' => '3978', 'countryId' => '242', 'zoneName' => 'Cetinje', 'zoneCode' => '06', 'zoneStatus' => '1'],
            ['zoneId' => '3979', 'countryId' => '242', 'zoneName' => 'Danilovgrad', 'zoneCode' => '07', 'zoneStatus' => '1'],
            ['zoneId' => '3980', 'countryId' => '242', 'zoneName' => 'Herceg-Novi', 'zoneCode' => '08', 'zoneStatus' => '1'],
            ['zoneId' => '3981', 'countryId' => '242', 'zoneName' => 'Kolašin', 'zoneCode' => '09', 'zoneStatus' => '1'],
            ['zoneId' => '3982', 'countryId' => '242', 'zoneName' => 'Kotor', 'zoneCode' => '10', 'zoneStatus' => '1'],
            ['zoneId' => '3983', 'countryId' => '242', 'zoneName' => 'Mojkovac', 'zoneCode' => '11', 'zoneStatus' => '1'],
            ['zoneId' => '3984', 'countryId' => '242', 'zoneName' => 'Nikšić', 'zoneCode' => '12', 'zoneStatus' => '1'],
            ['zoneId' => '3985', 'countryId' => '242', 'zoneName' => 'Plav', 'zoneCode' => '13', 'zoneStatus' => '1'],
            ['zoneId' => '3986', 'countryId' => '242', 'zoneName' => 'Pljevlja', 'zoneCode' => '14', 'zoneStatus' => '1'],
            ['zoneId' => '3987', 'countryId' => '242', 'zoneName' => 'Plužine', 'zoneCode' => '15', 'zoneStatus' => '1'],
            ['zoneId' => '3988', 'countryId' => '242', 'zoneName' => 'Podgorica', 'zoneCode' => '16', 'zoneStatus' => '1'],
            ['zoneId' => '3989', 'countryId' => '242', 'zoneName' => 'Rožaje', 'zoneCode' => '17', 'zoneStatus' => '1'],
            ['zoneId' => '3990', 'countryId' => '242', 'zoneName' => 'Šavnik', 'zoneCode' => '18', 'zoneStatus' => '1'],
            ['zoneId' => '3991', 'countryId' => '242', 'zoneName' => 'Tivat', 'zoneCode' => '19', 'zoneStatus' => '1'],
            ['zoneId' => '3992', 'countryId' => '242', 'zoneName' => 'Ulcinj', 'zoneCode' => '20', 'zoneStatus' => '1'],
            ['zoneId' => '3993', 'countryId' => '242', 'zoneName' => 'Žabljak', 'zoneCode' => '21', 'zoneStatus' => '1'],
            ['zoneId' => '3994', 'countryId' => '243', 'zoneName' => 'Belgrade', 'zoneCode' => '00', 'zoneStatus' => '1'],
            ['zoneId' => '3995', 'countryId' => '243', 'zoneName' => 'North Bačka', 'zoneCode' => '01', 'zoneStatus' => '1'],
            ['zoneId' => '3996', 'countryId' => '243', 'zoneName' => 'Central Banat', 'zoneCode' => '02', 'zoneStatus' => '1'],
            ['zoneId' => '3997', 'countryId' => '243', 'zoneName' => 'North Banat', 'zoneCode' => '03', 'zoneStatus' => '1'],
            ['zoneId' => '3998', 'countryId' => '243', 'zoneName' => 'South Banat', 'zoneCode' => '04', 'zoneStatus' => '1'],
            ['zoneId' => '3999', 'countryId' => '243', 'zoneName' => 'West Bačka', 'zoneCode' => '05', 'zoneStatus' => '1'],
            ['zoneId' => '4000', 'countryId' => '243', 'zoneName' => 'South Bačka', 'zoneCode' => '06', 'zoneStatus' => '1'],
            ['zoneId' => '4001', 'countryId' => '243', 'zoneName' => 'Srem', 'zoneCode' => '07', 'zoneStatus' => '1'],
            ['zoneId' => '4002', 'countryId' => '243', 'zoneName' => 'Mačva', 'zoneCode' => '08', 'zoneStatus' => '1'],
            ['zoneId' => '4003', 'countryId' => '243', 'zoneName' => 'Kolubara', 'zoneCode' => '09', 'zoneStatus' => '1'],
            ['zoneId' => '4004', 'countryId' => '243', 'zoneName' => 'Podunavlje', 'zoneCode' => '10', 'zoneStatus' => '1'],
            ['zoneId' => '4005', 'countryId' => '243', 'zoneName' => 'Braničevo', 'zoneCode' => '11', 'zoneStatus' => '1'],
            ['zoneId' => '4006', 'countryId' => '243', 'zoneName' => 'Šumadija', 'zoneCode' => '12', 'zoneStatus' => '1'],
            ['zoneId' => '4007', 'countryId' => '243', 'zoneName' => 'Pomoravlje', 'zoneCode' => '13', 'zoneStatus' => '1'],
            ['zoneId' => '4008', 'countryId' => '243', 'zoneName' => 'Bor', 'zoneCode' => '14', 'zoneStatus' => '1'],
            ['zoneId' => '4009', 'countryId' => '243', 'zoneName' => 'Zaječar', 'zoneCode' => '15', 'zoneStatus' => '1'],
            ['zoneId' => '4010', 'countryId' => '243', 'zoneName' => 'Zlatibor', 'zoneCode' => '16', 'zoneStatus' => '1'],
            ['zoneId' => '4011', 'countryId' => '243', 'zoneName' => 'Moravica', 'zoneCode' => '17', 'zoneStatus' => '1'],
            ['zoneId' => '4012', 'countryId' => '243', 'zoneName' => 'Raška', 'zoneCode' => '18', 'zoneStatus' => '1'],
            ['zoneId' => '4013', 'countryId' => '243', 'zoneName' => 'Rasina', 'zoneCode' => '19', 'zoneStatus' => '1'],
            ['zoneId' => '4014', 'countryId' => '243', 'zoneName' => 'Nišava', 'zoneCode' => '20', 'zoneStatus' => '1'],
            ['zoneId' => '4015', 'countryId' => '243', 'zoneName' => 'Toplica', 'zoneCode' => '21', 'zoneStatus' => '1'],
            ['zoneId' => '4016', 'countryId' => '243', 'zoneName' => 'Pirot', 'zoneCode' => '22', 'zoneStatus' => '1'],
            ['zoneId' => '4017', 'countryId' => '243', 'zoneName' => 'Jablanica', 'zoneCode' => '23', 'zoneStatus' => '1'],
            ['zoneId' => '4018', 'countryId' => '243', 'zoneName' => 'Pčinja', 'zoneCode' => '24', 'zoneStatus' => '1'],
            ['zoneId' => '4020', 'countryId' => '245', 'zoneName' => 'Bonaire', 'zoneCode' => 'BO', 'zoneStatus' => '1'],
            ['zoneId' => '4021', 'countryId' => '245', 'zoneName' => 'Saba', 'zoneCode' => 'SA', 'zoneStatus' => '1'],
            ['zoneId' => '4022', 'countryId' => '245', 'zoneName' => 'Sint Eustatius', 'zoneCode' => 'SE', 'zoneStatus' => '1'],
            ['zoneId' => '4023', 'countryId' => '248', 'zoneName' => 'Central Equatoria', 'zoneCode' => 'EC', 'zoneStatus' => '1'],
            ['zoneId' => '4024', 'countryId' => '248', 'zoneName' => 'Eastern Equatoria', 'zoneCode' => 'EE', 'zoneStatus' => '1'],
            ['zoneId' => '4025', 'countryId' => '248', 'zoneName' => 'Jonglei', 'zoneCode' => 'JG', 'zoneStatus' => '1'],
            ['zoneId' => '4026', 'countryId' => '248', 'zoneName' => 'Lakes', 'zoneCode' => 'LK', 'zoneStatus' => '1'],
            ['zoneId' => '4027', 'countryId' => '248', 'zoneName' => 'Northern Bahr el-Ghazal', 'zoneCode' => 'BN', 'zoneStatus' => '1'],
            ['zoneId' => '4028', 'countryId' => '248', 'zoneName' => 'Unity', 'zoneCode' => 'UY', 'zoneStatus' => '1'],
            ['zoneId' => '4029', 'countryId' => '248', 'zoneName' => 'Upper Nile', 'zoneCode' => 'NU', 'zoneStatus' => '1'],
            ['zoneId' => '4030', 'countryId' => '248', 'zoneName' => 'Warrap', 'zoneCode' => 'WR', 'zoneStatus' => '1'],
            ['zoneId' => '4031', 'countryId' => '248', 'zoneName' => 'Western Bahr el-Ghazal', 'zoneCode' => 'BW', 'zoneStatus' => '1'],
            ['zoneId' => '4032', 'countryId' => '248', 'zoneName' => 'Western Equatoria', 'zoneCode' => 'EW', 'zoneStatus' => '1'],
            ['zoneId' => '4035', 'countryId' => '129', 'zoneName' => 'Putrajaya', 'zoneCode' => 'MY-16', 'zoneStatus' => '1'],
            ['zoneId' => '4036', 'countryId' => '117', 'zoneName' => 'Ainaži, Salacgrīvas novads', 'zoneCode' => '0661405', 'zoneStatus' => '1'],
            ['zoneId' => '4037', 'countryId' => '117', 'zoneName' => 'Aizkraukle, Aizkraukles novads', 'zoneCode' => '0320201', 'zoneStatus' => '1'],
            ['zoneId' => '4038', 'countryId' => '117', 'zoneName' => 'Aizkraukles novads', 'zoneCode' => '0320200', 'zoneStatus' => '1'],
            ['zoneId' => '4039', 'countryId' => '117', 'zoneName' => 'Aizpute, Aizputes novads', 'zoneCode' => '0640605', 'zoneStatus' => '1'],
            ['zoneId' => '4040', 'countryId' => '117', 'zoneName' => 'Aizputes novads', 'zoneCode' => '0640600', 'zoneStatus' => '1'],
            ['zoneId' => '4041', 'countryId' => '117', 'zoneName' => 'Aknīste, Aknīstes novads', 'zoneCode' => '0560805', 'zoneStatus' => '1'],
            ['zoneId' => '4042', 'countryId' => '117', 'zoneName' => 'Aknīstes novads', 'zoneCode' => '0560800', 'zoneStatus' => '1'],
            ['zoneId' => '4043', 'countryId' => '117', 'zoneName' => 'Aloja, Alojas novads', 'zoneCode' => '0661007', 'zoneStatus' => '1'],
            ['zoneId' => '4044', 'countryId' => '117', 'zoneName' => 'Alojas novads', 'zoneCode' => '0661000', 'zoneStatus' => '1'],
            ['zoneId' => '4045', 'countryId' => '117', 'zoneName' => 'Alsungas novads', 'zoneCode' => '0624200', 'zoneStatus' => '1'],
            ['zoneId' => '4046', 'countryId' => '117', 'zoneName' => 'Alūksne, Alūksnes novads', 'zoneCode' => '0360201', 'zoneStatus' => '1'],
            ['zoneId' => '4047', 'countryId' => '117', 'zoneName' => 'Alūksnes novads', 'zoneCode' => '0360200', 'zoneStatus' => '1'],
            ['zoneId' => '4048', 'countryId' => '117', 'zoneName' => 'Amatas novads', 'zoneCode' => '0424701', 'zoneStatus' => '1'],
            ['zoneId' => '4049', 'countryId' => '117', 'zoneName' => 'Ape, Apes novads', 'zoneCode' => '0360805', 'zoneStatus' => '1'],
            ['zoneId' => '4050', 'countryId' => '117', 'zoneName' => 'Apes novads', 'zoneCode' => '0360800', 'zoneStatus' => '1'],
            ['zoneId' => '4051', 'countryId' => '117', 'zoneName' => 'Auce, Auces novads', 'zoneCode' => '0460805', 'zoneStatus' => '1'],
            ['zoneId' => '4052', 'countryId' => '117', 'zoneName' => 'Auces novads', 'zoneCode' => '0460800', 'zoneStatus' => '1'],
            ['zoneId' => '4053', 'countryId' => '117', 'zoneName' => 'Ādažu novads', 'zoneCode' => '0804400', 'zoneStatus' => '1'],
            ['zoneId' => '4054', 'countryId' => '117', 'zoneName' => 'Babītes novads', 'zoneCode' => '0804900', 'zoneStatus' => '1'],
            ['zoneId' => '4055', 'countryId' => '117', 'zoneName' => 'Baldone, Baldones novads', 'zoneCode' => '0800605', 'zoneStatus' => '1'],
            ['zoneId' => '4056', 'countryId' => '117', 'zoneName' => 'Baldones novads', 'zoneCode' => '0800600', 'zoneStatus' => '1'],
            ['zoneId' => '4057', 'countryId' => '117', 'zoneName' => 'Baloži, Ķekavas novads', 'zoneCode' => '0800807', 'zoneStatus' => '1'],
            ['zoneId' => '4058', 'countryId' => '117', 'zoneName' => 'Baltinavas novads', 'zoneCode' => '0384400', 'zoneStatus' => '1'],
            ['zoneId' => '4059', 'countryId' => '117', 'zoneName' => 'Balvi, Balvu novads', 'zoneCode' => '0380201', 'zoneStatus' => '1'],
            ['zoneId' => '4060', 'countryId' => '117', 'zoneName' => 'Balvu novads', 'zoneCode' => '0380200', 'zoneStatus' => '1'],
            ['zoneId' => '4061', 'countryId' => '117', 'zoneName' => 'Bauska, Bauskas novads', 'zoneCode' => '0400201', 'zoneStatus' => '1'],
            ['zoneId' => '4062', 'countryId' => '117', 'zoneName' => 'Bauskas novads', 'zoneCode' => '0400200', 'zoneStatus' => '1'],
            ['zoneId' => '4063', 'countryId' => '117', 'zoneName' => 'Beverīnas novads', 'zoneCode' => '0964700', 'zoneStatus' => '1'],
            ['zoneId' => '4064', 'countryId' => '117', 'zoneName' => 'Brocēni, Brocēnu novads', 'zoneCode' => '0840605', 'zoneStatus' => '1'],
            ['zoneId' => '4065', 'countryId' => '117', 'zoneName' => 'Brocēnu novads', 'zoneCode' => '0840601', 'zoneStatus' => '1'],
            ['zoneId' => '4066', 'countryId' => '117', 'zoneName' => 'Burtnieku novads', 'zoneCode' => '0967101', 'zoneStatus' => '1'],
            ['zoneId' => '4067', 'countryId' => '117', 'zoneName' => 'Carnikavas novads', 'zoneCode' => '0805200', 'zoneStatus' => '1'],
            ['zoneId' => '4068', 'countryId' => '117', 'zoneName' => 'Cesvaine, Cesvaines novads', 'zoneCode' => '0700807', 'zoneStatus' => '1'],
            ['zoneId' => '4069', 'countryId' => '117', 'zoneName' => 'Cesvaines novads', 'zoneCode' => '0700800', 'zoneStatus' => '1'],
            ['zoneId' => '4070', 'countryId' => '117', 'zoneName' => 'Cēsis, Cēsu novads', 'zoneCode' => '0420201', 'zoneStatus' => '1'],
            ['zoneId' => '4071', 'countryId' => '117', 'zoneName' => 'Cēsu novads', 'zoneCode' => '0420200', 'zoneStatus' => '1'],
            ['zoneId' => '4072', 'countryId' => '117', 'zoneName' => 'Ciblas novads', 'zoneCode' => '0684901', 'zoneStatus' => '1'],
            ['zoneId' => '4073', 'countryId' => '117', 'zoneName' => 'Dagda, Dagdas novads', 'zoneCode' => '0601009', 'zoneStatus' => '1'],
            ['zoneId' => '4074', 'countryId' => '117', 'zoneName' => 'Dagdas novads', 'zoneCode' => '0601000', 'zoneStatus' => '1'],
            ['zoneId' => '4075', 'countryId' => '117', 'zoneName' => 'Daugavpils', 'zoneCode' => '0050000', 'zoneStatus' => '1'],
            ['zoneId' => '4076', 'countryId' => '117', 'zoneName' => 'Daugavpils novads', 'zoneCode' => '0440200', 'zoneStatus' => '1'],
            ['zoneId' => '4077', 'countryId' => '117', 'zoneName' => 'Dobele, Dobeles novads', 'zoneCode' => '0460201', 'zoneStatus' => '1'],
            ['zoneId' => '4078', 'countryId' => '117', 'zoneName' => 'Dobeles novads', 'zoneCode' => '0460200', 'zoneStatus' => '1'],
            ['zoneId' => '4079', 'countryId' => '117', 'zoneName' => 'Dundagas novads', 'zoneCode' => '0885100', 'zoneStatus' => '1'],
            ['zoneId' => '4080', 'countryId' => '117', 'zoneName' => 'Durbe, Durbes novads', 'zoneCode' => '0640807', 'zoneStatus' => '1'],
            ['zoneId' => '4081', 'countryId' => '117', 'zoneName' => 'Durbes novads', 'zoneCode' => '0640801', 'zoneStatus' => '1'],
            ['zoneId' => '4082', 'countryId' => '117', 'zoneName' => 'Engures novads', 'zoneCode' => '0905100', 'zoneStatus' => '1'],
            ['zoneId' => '4083', 'countryId' => '117', 'zoneName' => 'Ērgļu novads', 'zoneCode' => '0705500', 'zoneStatus' => '1'],
            ['zoneId' => '4084', 'countryId' => '117', 'zoneName' => 'Garkalnes novads', 'zoneCode' => '0806000', 'zoneStatus' => '1'],
            ['zoneId' => '4085', 'countryId' => '117', 'zoneName' => 'Grobiņa, Grobiņas novads', 'zoneCode' => '0641009', 'zoneStatus' => '1'],
            ['zoneId' => '4086', 'countryId' => '117', 'zoneName' => 'Grobiņas novads', 'zoneCode' => '0641000', 'zoneStatus' => '1'],
            ['zoneId' => '4087', 'countryId' => '117', 'zoneName' => 'Gulbene, Gulbenes novads', 'zoneCode' => '0500201', 'zoneStatus' => '1'],
            ['zoneId' => '4088', 'countryId' => '117', 'zoneName' => 'Gulbenes novads', 'zoneCode' => '0500200', 'zoneStatus' => '1'],
            ['zoneId' => '4089', 'countryId' => '117', 'zoneName' => 'Iecavas novads', 'zoneCode' => '0406400', 'zoneStatus' => '1'],
            ['zoneId' => '4090', 'countryId' => '117', 'zoneName' => 'Ikšķile, Ikšķiles novads', 'zoneCode' => '0740605', 'zoneStatus' => '1'],
            ['zoneId' => '4091', 'countryId' => '117', 'zoneName' => 'Ikšķiles novads', 'zoneCode' => '0740600', 'zoneStatus' => '1'],
            ['zoneId' => '4092', 'countryId' => '117', 'zoneName' => 'Ilūkste, Ilūkstes novads', 'zoneCode' => '0440807', 'zoneStatus' => '1'],
            ['zoneId' => '4093', 'countryId' => '117', 'zoneName' => 'Ilūkstes novads', 'zoneCode' => '0440801', 'zoneStatus' => '1'],
            ['zoneId' => '4094', 'countryId' => '117', 'zoneName' => 'Inčukalna novads', 'zoneCode' => '0801800', 'zoneStatus' => '1'],
            ['zoneId' => '4095', 'countryId' => '117', 'zoneName' => 'Jaunjelgava, Jaunjelgavas novads', 'zoneCode' => '0321007', 'zoneStatus' => '1'],
            ['zoneId' => '4096', 'countryId' => '117', 'zoneName' => 'Jaunjelgavas novads', 'zoneCode' => '0321000', 'zoneStatus' => '1'],
            ['zoneId' => '4097', 'countryId' => '117', 'zoneName' => 'Jaunpiebalgas novads', 'zoneCode' => '0425700', 'zoneStatus' => '1'],
            ['zoneId' => '4098', 'countryId' => '117', 'zoneName' => 'Jaunpils novads', 'zoneCode' => '0905700', 'zoneStatus' => '1'],
            ['zoneId' => '4099', 'countryId' => '117', 'zoneName' => 'Jelgava', 'zoneCode' => '0090000', 'zoneStatus' => '1'],
            ['zoneId' => '4100', 'countryId' => '117', 'zoneName' => 'Jelgavas novads', 'zoneCode' => '0540200', 'zoneStatus' => '1'],
            ['zoneId' => '4101', 'countryId' => '117', 'zoneName' => 'Jēkabpils', 'zoneCode' => '0110000', 'zoneStatus' => '1'],
            ['zoneId' => '4102', 'countryId' => '117', 'zoneName' => 'Jēkabpils novads', 'zoneCode' => '0560200', 'zoneStatus' => '1'],
            ['zoneId' => '4103', 'countryId' => '117', 'zoneName' => 'Jūrmala', 'zoneCode' => '0130000', 'zoneStatus' => '1'],
            ['zoneId' => '4104', 'countryId' => '117', 'zoneName' => 'Kalnciems, Jelgavas novads', 'zoneCode' => '0540211', 'zoneStatus' => '1'],
            ['zoneId' => '4105', 'countryId' => '117', 'zoneName' => 'Kandava, Kandavas novads', 'zoneCode' => '0901211', 'zoneStatus' => '1'],
            ['zoneId' => '4106', 'countryId' => '117', 'zoneName' => 'Kandavas novads', 'zoneCode' => '0901201', 'zoneStatus' => '1'],
            ['zoneId' => '4107', 'countryId' => '117', 'zoneName' => 'Kārsava, Kārsavas novads', 'zoneCode' => '0681009', 'zoneStatus' => '1'],
            ['zoneId' => '4108', 'countryId' => '117', 'zoneName' => 'Kārsavas novads', 'zoneCode' => '0681000', 'zoneStatus' => '1'],
            ['zoneId' => '4109', 'countryId' => '117', 'zoneName' => 'Kocēnu novads ,bij. Valmieras)', 'zoneCode' => '0960200', 'zoneStatus' => '1'],
            ['zoneId' => '4110', 'countryId' => '117', 'zoneName' => 'Kokneses novads', 'zoneCode' => '0326100', 'zoneStatus' => '1'],
            ['zoneId' => '4111', 'countryId' => '117', 'zoneName' => 'Krāslava, Krāslavas novads', 'zoneCode' => '0600201', 'zoneStatus' => '1'],
            ['zoneId' => '4112', 'countryId' => '117', 'zoneName' => 'Krāslavas novads', 'zoneCode' => '0600202', 'zoneStatus' => '1'],
            ['zoneId' => '4113', 'countryId' => '117', 'zoneName' => 'Krimuldas novads', 'zoneCode' => '0806900', 'zoneStatus' => '1'],
            ['zoneId' => '4114', 'countryId' => '117', 'zoneName' => 'Krustpils novads', 'zoneCode' => '0566900', 'zoneStatus' => '1'],
            ['zoneId' => '4115', 'countryId' => '117', 'zoneName' => 'Kuldīga, Kuldīgas novads', 'zoneCode' => '0620201', 'zoneStatus' => '1'],
            ['zoneId' => '4116', 'countryId' => '117', 'zoneName' => 'Kuldīgas novads', 'zoneCode' => '0620200', 'zoneStatus' => '1'],
            ['zoneId' => '4117', 'countryId' => '117', 'zoneName' => 'Ķeguma novads', 'zoneCode' => '0741001', 'zoneStatus' => '1'],
            ['zoneId' => '4118', 'countryId' => '117', 'zoneName' => 'Ķegums, Ķeguma novads', 'zoneCode' => '0741009', 'zoneStatus' => '1'],
            ['zoneId' => '4119', 'countryId' => '117', 'zoneName' => 'Ķekavas novads', 'zoneCode' => '0800800', 'zoneStatus' => '1'],
            ['zoneId' => '4120', 'countryId' => '117', 'zoneName' => 'Lielvārde, Lielvārdes novads', 'zoneCode' => '0741413', 'zoneStatus' => '1'],
            ['zoneId' => '4121', 'countryId' => '117', 'zoneName' => 'Lielvārdes novads', 'zoneCode' => '0741401', 'zoneStatus' => '1'],
            ['zoneId' => '4122', 'countryId' => '117', 'zoneName' => 'Liepāja', 'zoneCode' => '0170000', 'zoneStatus' => '1'],
            ['zoneId' => '4123', 'countryId' => '117', 'zoneName' => 'Limbaži, Limbažu novads', 'zoneCode' => '0660201', 'zoneStatus' => '1'],
            ['zoneId' => '4124', 'countryId' => '117', 'zoneName' => 'Limbažu novads', 'zoneCode' => '0660200', 'zoneStatus' => '1'],
            ['zoneId' => '4125', 'countryId' => '117', 'zoneName' => 'Līgatne, Līgatnes novads', 'zoneCode' => '0421211', 'zoneStatus' => '1'],
            ['zoneId' => '4126', 'countryId' => '117', 'zoneName' => 'Līgatnes novads', 'zoneCode' => '0421200', 'zoneStatus' => '1'],
            ['zoneId' => '4127', 'countryId' => '117', 'zoneName' => 'Līvāni, Līvānu novads', 'zoneCode' => '0761211', 'zoneStatus' => '1'],
            ['zoneId' => '4128', 'countryId' => '117', 'zoneName' => 'Līvānu novads', 'zoneCode' => '0761201', 'zoneStatus' => '1'],
            ['zoneId' => '4129', 'countryId' => '117', 'zoneName' => 'Lubāna, Lubānas novads', 'zoneCode' => '0701413', 'zoneStatus' => '1'],
            ['zoneId' => '4130', 'countryId' => '117', 'zoneName' => 'Lubānas novads', 'zoneCode' => '0701400', 'zoneStatus' => '1'],
            ['zoneId' => '4131', 'countryId' => '117', 'zoneName' => 'Ludza, Ludzas novads', 'zoneCode' => '0680201', 'zoneStatus' => '1'],
            ['zoneId' => '4132', 'countryId' => '117', 'zoneName' => 'Ludzas novads', 'zoneCode' => '0680200', 'zoneStatus' => '1'],
            ['zoneId' => '4133', 'countryId' => '117', 'zoneName' => 'Madona, Madonas novads', 'zoneCode' => '0700201', 'zoneStatus' => '1'],
            ['zoneId' => '4134', 'countryId' => '117', 'zoneName' => 'Madonas novads', 'zoneCode' => '0700200', 'zoneStatus' => '1'],
            ['zoneId' => '4135', 'countryId' => '117', 'zoneName' => 'Mazsalaca, Mazsalacas novads', 'zoneCode' => '0961011', 'zoneStatus' => '1'],
            ['zoneId' => '4136', 'countryId' => '117', 'zoneName' => 'Mazsalacas novads', 'zoneCode' => '0961000', 'zoneStatus' => '1'],
            ['zoneId' => '4137', 'countryId' => '117', 'zoneName' => 'Mālpils novads', 'zoneCode' => '0807400', 'zoneStatus' => '1'],
            ['zoneId' => '4138', 'countryId' => '117', 'zoneName' => 'Mārupes novads', 'zoneCode' => '0807600', 'zoneStatus' => '1'],
            ['zoneId' => '4139', 'countryId' => '117', 'zoneName' => 'Mērsraga novads', 'zoneCode' => '0887600', 'zoneStatus' => '1'],
            ['zoneId' => '4140', 'countryId' => '117', 'zoneName' => 'Naukšēnu novads', 'zoneCode' => '0967300', 'zoneStatus' => '1'],
            ['zoneId' => '4141', 'countryId' => '117', 'zoneName' => 'Neretas novads', 'zoneCode' => '0327100', 'zoneStatus' => '1'],
            ['zoneId' => '4142', 'countryId' => '117', 'zoneName' => 'Nīcas novads', 'zoneCode' => '0647900', 'zoneStatus' => '1'],
            ['zoneId' => '4143', 'countryId' => '117', 'zoneName' => 'Ogre, Ogres novads', 'zoneCode' => '0740201', 'zoneStatus' => '1'],
            ['zoneId' => '4144', 'countryId' => '117', 'zoneName' => 'Ogres novads', 'zoneCode' => '0740202', 'zoneStatus' => '1'],
            ['zoneId' => '4145', 'countryId' => '117', 'zoneName' => 'Olaine, Olaines novads', 'zoneCode' => '0801009', 'zoneStatus' => '1'],
            ['zoneId' => '4146', 'countryId' => '117', 'zoneName' => 'Olaines novads', 'zoneCode' => '0801000', 'zoneStatus' => '1'],
            ['zoneId' => '4147', 'countryId' => '117', 'zoneName' => 'Ozolnieku novads', 'zoneCode' => '0546701', 'zoneStatus' => '1'],
            ['zoneId' => '4148', 'countryId' => '117', 'zoneName' => 'Pārgaujas novads', 'zoneCode' => '0427500', 'zoneStatus' => '1'],
            ['zoneId' => '4149', 'countryId' => '117', 'zoneName' => 'Pāvilosta, Pāvilostas novads', 'zoneCode' => '0641413', 'zoneStatus' => '1'],
            ['zoneId' => '4150', 'countryId' => '117', 'zoneName' => 'Pāvilostas novads', 'zoneCode' => '0641401', 'zoneStatus' => '1'],
            ['zoneId' => '4151', 'countryId' => '117', 'zoneName' => 'Piltene, Ventspils novads', 'zoneCode' => '0980213', 'zoneStatus' => '1'],
            ['zoneId' => '4152', 'countryId' => '117', 'zoneName' => 'Pļaviņas, Pļaviņu novads', 'zoneCode' => '0321413', 'zoneStatus' => '1'],
            ['zoneId' => '4153', 'countryId' => '117', 'zoneName' => 'Pļaviņu novads', 'zoneCode' => '0321400', 'zoneStatus' => '1'],
            ['zoneId' => '4154', 'countryId' => '117', 'zoneName' => 'Preiļi, Preiļu novads', 'zoneCode' => '0760201', 'zoneStatus' => '1'],
            ['zoneId' => '4155', 'countryId' => '117', 'zoneName' => 'Preiļu novads', 'zoneCode' => '0760202', 'zoneStatus' => '1'],
            ['zoneId' => '4156', 'countryId' => '117', 'zoneName' => 'Priekule, Priekules novads', 'zoneCode' => '0641615', 'zoneStatus' => '1'],
            ['zoneId' => '4157', 'countryId' => '117', 'zoneName' => 'Priekules novads', 'zoneCode' => '0641600', 'zoneStatus' => '1'],
            ['zoneId' => '4158', 'countryId' => '117', 'zoneName' => 'Priekuļu novads', 'zoneCode' => '0427300', 'zoneStatus' => '1'],
            ['zoneId' => '4159', 'countryId' => '117', 'zoneName' => 'Raunas novads', 'zoneCode' => '0427700', 'zoneStatus' => '1'],
            ['zoneId' => '4160', 'countryId' => '117', 'zoneName' => 'Rēzekne', 'zoneCode' => '0210000', 'zoneStatus' => '1'],
            ['zoneId' => '4161', 'countryId' => '117', 'zoneName' => 'Rēzeknes novads', 'zoneCode' => '0780200', 'zoneStatus' => '1'],
            ['zoneId' => '4162', 'countryId' => '117', 'zoneName' => 'Riebiņu novads', 'zoneCode' => '0766300', 'zoneStatus' => '1'],
            ['zoneId' => '4163', 'countryId' => '117', 'zoneName' => 'Rīga', 'zoneCode' => '0010000', 'zoneStatus' => '1'],
            ['zoneId' => '4164', 'countryId' => '117', 'zoneName' => 'Rojas novads', 'zoneCode' => '0888300', 'zoneStatus' => '1'],
            ['zoneId' => '4165', 'countryId' => '117', 'zoneName' => 'Ropažu novads', 'zoneCode' => '0808400', 'zoneStatus' => '1'],
            ['zoneId' => '4166', 'countryId' => '117', 'zoneName' => 'Rucavas novads', 'zoneCode' => '0648500', 'zoneStatus' => '1'],
            ['zoneId' => '4167', 'countryId' => '117', 'zoneName' => 'Rugāju novads', 'zoneCode' => '0387500', 'zoneStatus' => '1'],
            ['zoneId' => '4168', 'countryId' => '117', 'zoneName' => 'Rundāles novads', 'zoneCode' => '0407700', 'zoneStatus' => '1'],
            ['zoneId' => '4169', 'countryId' => '117', 'zoneName' => 'Rūjiena, Rūjienas novads', 'zoneCode' => '0961615', 'zoneStatus' => '1'],
            ['zoneId' => '4170', 'countryId' => '117', 'zoneName' => 'Rūjienas novads', 'zoneCode' => '0961600', 'zoneStatus' => '1'],
            ['zoneId' => '4171', 'countryId' => '117', 'zoneName' => 'Sabile, Talsu novads', 'zoneCode' => '0880213', 'zoneStatus' => '1'],
            ['zoneId' => '4172', 'countryId' => '117', 'zoneName' => 'Salacgrīva, Salacgrīvas novads', 'zoneCode' => '0661415', 'zoneStatus' => '1'],
            ['zoneId' => '4173', 'countryId' => '117', 'zoneName' => 'Salacgrīvas novads', 'zoneCode' => '0661400', 'zoneStatus' => '1'],
            ['zoneId' => '4174', 'countryId' => '117', 'zoneName' => 'Salas novads', 'zoneCode' => '0568700', 'zoneStatus' => '1'],
            ['zoneId' => '4175', 'countryId' => '117', 'zoneName' => 'Salaspils novads', 'zoneCode' => '0801200', 'zoneStatus' => '1'],
            ['zoneId' => '4176', 'countryId' => '117', 'zoneName' => 'Salaspils, Salaspils novads', 'zoneCode' => '0801211', 'zoneStatus' => '1'],
            ['zoneId' => '4177', 'countryId' => '117', 'zoneName' => 'Saldus novads', 'zoneCode' => '0840200', 'zoneStatus' => '1'],
            ['zoneId' => '4178', 'countryId' => '117', 'zoneName' => 'Saldus, Saldus novads', 'zoneCode' => '0840201', 'zoneStatus' => '1'],
            ['zoneId' => '4179', 'countryId' => '117', 'zoneName' => 'Saulkrasti, Saulkrastu novads', 'zoneCode' => '0801413', 'zoneStatus' => '1'],
            ['zoneId' => '4180', 'countryId' => '117', 'zoneName' => 'Saulkrastu novads', 'zoneCode' => '0801400', 'zoneStatus' => '1'],
            ['zoneId' => '4181', 'countryId' => '117', 'zoneName' => 'Seda, Strenču novads', 'zoneCode' => '0941813', 'zoneStatus' => '1'],
            ['zoneId' => '4182', 'countryId' => '117', 'zoneName' => 'Sējas novads', 'zoneCode' => '0809200', 'zoneStatus' => '1'],
            ['zoneId' => '4183', 'countryId' => '117', 'zoneName' => 'Sigulda, Siguldas novads', 'zoneCode' => '0801615', 'zoneStatus' => '1'],
            ['zoneId' => '4184', 'countryId' => '117', 'zoneName' => 'Siguldas novads', 'zoneCode' => '0801601', 'zoneStatus' => '1'],
            ['zoneId' => '4185', 'countryId' => '117', 'zoneName' => 'Skrīveru novads', 'zoneCode' => '0328200', 'zoneStatus' => '1'],
            ['zoneId' => '4186', 'countryId' => '117', 'zoneName' => 'Skrunda, Skrundas novads', 'zoneCode' => '0621209', 'zoneStatus' => '1'],
            ['zoneId' => '4187', 'countryId' => '117', 'zoneName' => 'Skrundas novads', 'zoneCode' => '0621200', 'zoneStatus' => '1'],
            ['zoneId' => '4188', 'countryId' => '117', 'zoneName' => 'Smiltene, Smiltenes novads', 'zoneCode' => '0941615', 'zoneStatus' => '1'],
            ['zoneId' => '4189', 'countryId' => '117', 'zoneName' => 'Smiltenes novads', 'zoneCode' => '0941600', 'zoneStatus' => '1'],
            ['zoneId' => '4190', 'countryId' => '117', 'zoneName' => 'Staicele, Alojas novads', 'zoneCode' => '0661017', 'zoneStatus' => '1'],
            ['zoneId' => '4191', 'countryId' => '117', 'zoneName' => 'Stende, Talsu novads', 'zoneCode' => '0880215', 'zoneStatus' => '1'],
            ['zoneId' => '4192', 'countryId' => '117', 'zoneName' => 'Stopiņu novads', 'zoneCode' => '0809600', 'zoneStatus' => '1'],
            ['zoneId' => '4193', 'countryId' => '117', 'zoneName' => 'Strenči, Strenču novads', 'zoneCode' => '0941817', 'zoneStatus' => '1'],
            ['zoneId' => '4194', 'countryId' => '117', 'zoneName' => 'Strenču novads', 'zoneCode' => '0941800', 'zoneStatus' => '1'],
            ['zoneId' => '4195', 'countryId' => '117', 'zoneName' => 'Subate, Ilūkstes novads', 'zoneCode' => '0440815', 'zoneStatus' => '1'],
            ['zoneId' => '4196', 'countryId' => '117', 'zoneName' => 'Talsi, Talsu novads', 'zoneCode' => '0880201', 'zoneStatus' => '1'],
            ['zoneId' => '4197', 'countryId' => '117', 'zoneName' => 'Talsu novads', 'zoneCode' => '0880200', 'zoneStatus' => '1'],
            ['zoneId' => '4198', 'countryId' => '117', 'zoneName' => 'Tērvetes novads', 'zoneCode' => '0468900', 'zoneStatus' => '1'],
            ['zoneId' => '4199', 'countryId' => '117', 'zoneName' => 'Tukuma novads', 'zoneCode' => '0900200', 'zoneStatus' => '1'],
            ['zoneId' => '4200', 'countryId' => '117', 'zoneName' => 'Tukums, Tukuma novads', 'zoneCode' => '0900201', 'zoneStatus' => '1'],
            ['zoneId' => '4201', 'countryId' => '117', 'zoneName' => 'Vaiņodes novads', 'zoneCode' => '0649300', 'zoneStatus' => '1'],
            ['zoneId' => '4202', 'countryId' => '117', 'zoneName' => 'Valdemārpils, Talsu novads', 'zoneCode' => '0880217', 'zoneStatus' => '1'],
            ['zoneId' => '4203', 'countryId' => '117', 'zoneName' => 'Valka, Valkas novads', 'zoneCode' => '0940201', 'zoneStatus' => '1'],
            ['zoneId' => '4204', 'countryId' => '117', 'zoneName' => 'Valkas novads', 'zoneCode' => '0940200', 'zoneStatus' => '1'],
            ['zoneId' => '4205', 'countryId' => '117', 'zoneName' => 'Valmiera', 'zoneCode' => '0250000', 'zoneStatus' => '1'],
            ['zoneId' => '4206', 'countryId' => '117', 'zoneName' => 'Vangaži, Inčukalna novads', 'zoneCode' => '0801817', 'zoneStatus' => '1'],
            ['zoneId' => '4207', 'countryId' => '117', 'zoneName' => 'Varakļāni, Varakļānu novads', 'zoneCode' => '0701817', 'zoneStatus' => '1'],
            ['zoneId' => '4208', 'countryId' => '117', 'zoneName' => 'Varakļānu novads', 'zoneCode' => '0701800', 'zoneStatus' => '1'],
            ['zoneId' => '4209', 'countryId' => '117', 'zoneName' => 'Vārkavas novads', 'zoneCode' => '0769101', 'zoneStatus' => '1'],
            ['zoneId' => '4210', 'countryId' => '117', 'zoneName' => 'Vecpiebalgas novads', 'zoneCode' => '0429300', 'zoneStatus' => '1'],
            ['zoneId' => '4211', 'countryId' => '117', 'zoneName' => 'Vecumnieku novads', 'zoneCode' => '0409500', 'zoneStatus' => '1'],
            ['zoneId' => '4212', 'countryId' => '117', 'zoneName' => 'Ventspils', 'zoneCode' => '0270000', 'zoneStatus' => '1'],
            ['zoneId' => '4213', 'countryId' => '117', 'zoneName' => 'Ventspils novads', 'zoneCode' => '0980200', 'zoneStatus' => '1'],
            ['zoneId' => '4214', 'countryId' => '117', 'zoneName' => 'Viesīte, Viesītes novads', 'zoneCode' => '0561815', 'zoneStatus' => '1'],
            ['zoneId' => '4215', 'countryId' => '117', 'zoneName' => 'Viesītes novads', 'zoneCode' => '0561800', 'zoneStatus' => '1'],
            ['zoneId' => '4216', 'countryId' => '117', 'zoneName' => 'Viļaka, Viļakas novads', 'zoneCode' => '0381615', 'zoneStatus' => '1'],
            ['zoneId' => '4217', 'countryId' => '117', 'zoneName' => 'Viļakas novads', 'zoneCode' => '0381600', 'zoneStatus' => '1'],
            ['zoneId' => '4218', 'countryId' => '117', 'zoneName' => 'Viļāni, Viļānu novads', 'zoneCode' => '0781817', 'zoneStatus' => '1'],
            ['zoneId' => '4219', 'countryId' => '117', 'zoneName' => 'Viļānu novads', 'zoneCode' => '0781800', 'zoneStatus' => '1'],
            ['zoneId' => '4220', 'countryId' => '117', 'zoneName' => 'Zilupe, Zilupes novads', 'zoneCode' => '0681817', 'zoneStatus' => '1'],
            ['zoneId' => '4221', 'countryId' => '117', 'zoneName' => 'Zilupes novads', 'zoneCode' => '0681801', 'zoneStatus' => '1'],
            ['zoneId' => '4222', 'countryId' => '43', 'zoneName' => 'Arica y Parinacota', 'zoneCode' => 'AP', 'zoneStatus' => '1'],
            ['zoneId' => '4223', 'countryId' => '43', 'zoneName' => 'Los Rios', 'zoneCode' => 'LR', 'zoneStatus' => '1'],
            ['zoneId' => '4224', 'countryId' => '220', 'zoneName' => 'Kharkivs\'ka Oblast\'', 'zoneCode' => '63', 'zoneStatus' => '1'],
            ['zoneId' => '4225', 'countryId' => '118', 'zoneName' => 'Beirut', 'zoneCode' => 'LB-BR', 'zoneStatus' => '1'],
            ['zoneId' => '4226', 'countryId' => '118', 'zoneName' => 'Bekaa', 'zoneCode' => 'LB-BE', 'zoneStatus' => '1'],
            ['zoneId' => '4227', 'countryId' => '118', 'zoneName' => 'Mount Lebanon', 'zoneCode' => 'LB-ML', 'zoneStatus' => '1'],
            ['zoneId' => '4228', 'countryId' => '118', 'zoneName' => 'Nabatieh', 'zoneCode' => 'LB-NB', 'zoneStatus' => '1'],
            ['zoneId' => '4229', 'countryId' => '118', 'zoneName' => 'North', 'zoneCode' => 'LB-NR', 'zoneStatus' => '1'],
            ['zoneId' => '4230', 'countryId' => '118', 'zoneName' => 'South', 'zoneCode' => 'LB-ST', 'zoneStatus' => '1'],
            ['zoneId' => '4231', 'countryId' => '99', 'zoneName' => 'Telangana', 'zoneCode' => 'TS', 'zoneStatus' => '1'],
            ['zoneId' => '4232', 'countryId' => '44', 'zoneName' => 'Qinghai', 'zoneCode' => 'QH', 'zoneStatus' => '1'],
            ['zoneId' => '4233', 'countryId' => '100', 'zoneName' => 'Papua Barat', 'zoneCode' => 'PB', 'zoneStatus' => '1'],
            ['zoneId' => '4234', 'countryId' => '100', 'zoneName' => 'Sulawesi Barat', 'zoneCode' => 'SR', 'zoneStatus' => '1'],
            ['zoneId' => '4235', 'countryId' => '100', 'zoneName' => 'Kepulauan Riau', 'zoneCode' => 'KR', 'zoneStatus' => '1'],
            ['zoneId' => '4236', 'countryId' => '105', 'zoneName' => 'Barletta-Andria-Trani', 'zoneCode' => 'BT', 'zoneStatus' => '1'],
            ['zoneId' => '4237', 'countryId' => '105', 'zoneName' => 'Fermo', 'zoneCode' => 'FM', 'zoneStatus' => '1'],
            ['zoneId' => '4238', 'countryId' => '105', 'zoneName' => 'Monza Brianza', 'zoneCode' => 'MB', 'zoneStatus' => '1']
        ];

		foreach ( $arr as $item ) {
			$data = [
				'zoneId' => $item['zoneId'],
				'countryId' => $item['countryId'],
				'zoneName' => $item['zoneName'],
				'zoneCode' => $item['zoneCode'],
                'zoneStatus' => $item['zoneStatus'],
                'zoneDeleted' => 0
			];
			$this->mc->save('geo_zone', $data);
		}
    }
}
