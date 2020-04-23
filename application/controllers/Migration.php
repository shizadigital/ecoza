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
        Self::create_shiza_ads_table();
        Self::create_shiza_ads_position_table();
        Self::create_shiza_android_device_table();
        Self::create_shiza_attribute_table();
        Self::create_shiza_attribute_group_table();
        Self::create_shiza_attribute_relationship_table();
        Self::create_shiza_attribute_value_table();
        Self::create_shiza_attribute_store_table();
        Self::create_shiza_badges_table();
        Self::create_shiza_badge_relationship_table();
        Self::create_shiza_badge_store_table();
        Self::create_shiza_categories_table();
        Self::create_shiza_category_relationship_table();
        Self::create_shiza_category_store_table();
        Self::create_shiza_currency_table();
        Self::create_shiza_comments_table();
        Self::create_shiza_contents_table();
        Self::create_shiza_cron_list_table();
        Self::create_shiza_dynamic_translations_table();
        Self::create_shiza_email_queue_table();
        Self::create_shiza_email_template_table();
        Self::create_shiza_gallery_pic_table();
        Self::create_shiza_manufacturers_table();
        Self::create_shiza_manufacturers_store_table();
        Self::create_shiza_message_table();
        Self::create_shiza_options_table();
        Self::create_shiza_product_table();
        Self::create_shiza_product_attribute_table();
        Self::create_shiza_product_attribute_combination_table();
        Self::create_shiza_product_related_table();
        Self::create_shiza_product_images_table();
        Self::create_shiza_product_store_table();
        Self::create_shiza_review_table();
        Self::create_shiza_seo_page_table();
        Self::create_shiza_slider_table();
        Self::create_shiza_store_table();
        Self::create_shiza_tax_table();
        Self::create_shiza_tax_rule_table();
        Self::create_shiza_testimonial_table();
        Self::create_shiza_unit_weight_table();
        Self::create_shiza_unit_length_table();
        Self::create_shiza_users_table();
        Self::create_shiza_users_level_table();
        Self::create_shiza_users_menu_table();
        Self::create_shiza_users_menu_access_table();
        Self::create_shiza_website_menu_table();
    }

    protected function create_shiza_ads_table() {

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

    protected function create_shiza_ads_position_table() {

        $schema = $this->schema->create_table('ads_position');
        $schema->increments('adposId');
        $schema->string('adposName');
        $schema->integer('adposW', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('adposH', ['length' => '10', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('adposId');
    }

    protected function create_shiza_android_device_table() {

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

    protected function create_shiza_attribute_table(){

        $schema = $this->schema->create_table('attribute');
        $schema->increments('attrId', ['length' => '11']);
        $schema->string('attrLabel', ['length' => '100']);
        $schema->integer('attrSorting', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('attrDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('attrSorting');

    }

    protected function create_shiza_attribute_group_table(){

        $schema = $this->schema->create_table('attribute_group');
        $schema->increments('attrgroupId', ['length' => '11']);
        $schema->string('attrgroupLabel', ['length' => '100']);
        $schema->integer('attrgroupSorting', ['length' => '5', 'unsigned' => TRUE]);
        $schema->integer('attrgroupDeleted', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('attrgroupSorting');

    }

    protected function create_shiza_attribute_relationship_table(){

        $schema = $this->schema->create_table('attribute_relationship');
        $schema->increments('attrrelId', ['type' => 'BIGINT', 'length' => '25']);
        $schema->integer('attrId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('attrgroupId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('attrId');
        $schema->index('attrgroupId');

    }

    protected function create_shiza_attribute_value_table(){

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

    protected function create_shiza_attribute_store_table(){

        $schema = $this->schema->create_table('attribute_store');
        $schema->increments('attrId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_shiza_badges_table() {
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

    protected function create_shiza_badge_relationship_table() {
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

    protected function create_shiza_badge_store_table(){

        $schema = $this->schema->create_table('badge_store');
        $schema->increments('badgeId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_shiza_categories_table() {
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

    protected function create_shiza_category_relationship_table() {
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

    protected function create_shiza_category_store_table(){

        $schema = $this->schema->create_table('category_store');
        $schema->increments('catId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_shiza_currency_table(){
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
        $schema->integer('curStatus', ['int' => '1', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('curCode');
        $schema->index('curStatus');

    }

    protected function create_shiza_comments_table() {

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

    protected function create_shiza_contents_table() {

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

    protected function create_shiza_cron_list_table() {

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

    protected function create_shiza_dynamic_translations_table() {

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

    protected function create_shiza_email_queue_table() {

        $schema = $this->schema->create_table('email_queue');
        $schema->increments('emailId', ['length' => '11']);
        $schema->string('emailTo', ['length' => '50']);
        $schema->string('emailSubject');
        $schema->text('emailMsg', ['type' => 'MEDIUMTEXT']);
        $schema->enum('emailMsgType', ['text', 'html']);
        $schema->string('emailHead');
        $schema->integer('emailDate', ['length' => '10', 'unsigned' => TRUE]);
        $schema->integer('emailDateSent', ['length' => '10', 'unsigned' => TRUE]);
        $schema->char('emailStatus', ['length' => '1']);
        $schema->char('emailAttachDir', ['length' => '8']);
        $schema->string('emailAttachFile');
        $schema->string('emailAttachType', ['length' => '4']);
        $schema->run();

        // ADD index
        $schema->index('emailId');
    }

    protected function create_shiza_email_template_table() {

        $schema = $this->schema->create_table('email_template');
        $schema->increments('tId', ['length' => '10']);
        $schema->string('tName');
        $schema->text('tEmail', ['type' => 'MEDIUMTEXT']);
        $schema->text('tEmailbak', ['type' => 'MEDIUMTEXT']);
        $schema->run();

    }

    protected function create_shiza_gallery_pic_table() {

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

    protected function create_shiza_manufacturers_table() {

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

    protected function create_shiza_manufacturers_store_table(){

        $schema = $this->schema->create_table('manufacturers_store');
        $schema->increments('manufactId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_shiza_message_table() {

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

    protected function create_shiza_options_table() {

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

    protected function create_shiza_product_table(){
        
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
        $schema->index('prodPermalink');
        $schema->index('prodFinalPrice');
        $schema->index('prodWeight');
        $schema->index('prodDisplay');
        $schema->index('prodDeleted');
    }

    protected function create_shiza_product_attribute_table(){
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

    protected function create_shiza_product_attribute_combination_table(){
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

    protected function create_shiza_product_related_table() {
        $schema = $this->schema->create_table('product_related');
        $schema->increments('prelId', ['type' => 'BIGINT', 'length' => '30']);
        $schema->integer('prodId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->integer('relatedId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('prodId');
    }

    protected function create_shiza_product_images_table() {
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

    protected function create_shiza_product_store_table(){

        $schema = $this->schema->create_table('product_store');
        $schema->increments('prodId', ['length' => '11']);
        $schema->integer('storeId', ['length' => '11', 'unsigned' => TRUE]);
        $schema->run();

        // ADD index
        $schema->index('storeId');

    }

    protected function create_shiza_review_table() {

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

    protected function create_shiza_seo_page_table() {

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

    protected function create_shiza_slider_table() {

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

    protected function create_shiza_store_table() {

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


    protected function create_shiza_tax_table() {

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

    protected function create_shiza_tax_rule_table() {

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

    protected function create_shiza_testimonial_table() {

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

    protected function create_shiza_unit_weight_table() {

        $schema = $this->schema->create_table('unit_weight');
        $schema->increments('weightId', ['length' => '11']);
        $schema->string('weightTitle', ['length' => '35']);
        $schema->string('weightUnit', ['length' => '5']);
        $schema->decimal('weightValue', ['length' => '15,8']);
        $schema->enum('weightDefault', ['y', 'n']);
        $schema->run();
    }

    protected function create_shiza_unit_length_table() {

        $schema = $this->schema->create_table('unit_length');
        $schema->increments('lengthId', ['length' => '11']);
        $schema->string('lengthTitle', ['length' => '35']);
        $schema->string('lengthUnit', ['length' => '5']);
        $schema->decimal('lengthValue', ['length' => '15,8']);
        $schema->enum('lengthDefault', ['y', 'n']);
        $schema->run();
    }

    protected function create_shiza_users_table() {

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

    protected function create_shiza_users_level_table() {

        $schema = $this->schema->create_table('users_level');
        $schema->increments('levelId', ['length' => '10']);
        $schema->string('levelName');
        $schema->enum('levelActive', ['y', 'n']);
        $schema->run();

        // ADD index
        $schema->index('levelId');
    }

    protected function create_shiza_users_menu_table() {

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

    protected function create_shiza_users_menu_access_table() {

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

    protected function create_shiza_website_menu_table() {

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
        $this->schema->drop_table('ads');
        $this->schema->drop_table('ads_position');
        $this->schema->drop_table('android_device');
        $this->schema->drop_table('attribute');
        $this->schema->drop_table('attribute_group');
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
        $this->schema->drop_table('cron_list');
        $this->schema->drop_table('dynamic_translations');
        $this->schema->drop_table('email_queue');
        $this->schema->drop_table('email_template');
        $this->schema->drop_table('gallery_pic');
        $this->schema->drop_table('manufacturers');
        $this->schema->drop_table('manufacturers_store');
        $this->schema->drop_table('message');
        $this->schema->drop_table('options');
        $this->schema->drop_table('product');
        $this->schema->drop_table('product_attribute');
        $this->schema->drop_table('product_attribute_combination');
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
			$this->mc->save('shiza_ads_position', $data);
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
			$this->mc->save('shiza_currency', $data);
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
            ['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'20', 'dtLang'=>'en_US', 'dtTranslation'=>'Length Unit', 'dtInputType'=>'text', 'dtCreateDate'=>'1583430361', 'dtUpdateDate'=>'1583430361'],['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'21', 'dtLang'=>'en_US', 'dtTranslation'=>'Tax', 'dtInputType'=>'text', 'dtCreateDate'=>'1584089953', 'dtUpdateDate'=>'1584089953'],['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'22', 'dtLang'=>'en_US', 'dtTranslation'=>'Tax Rule', 'dtInputType'=>'text', 'dtCreateDate'=>'1584090162', 'dtUpdateDate'=>'1584090162'],['dtRelatedTable'=>'users_menu', 'dtRelatedField'=>'menuName', 'dtRelatedId'=>'23', 'dtLang'=>'en_US', 'dtTranslation'=>'Currencies', 'dtInputType'=>'text', 'dtCreateDate'=>'1584090568', 'dtUpdateDate'=>'1584090568'],
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
			$this->mc->save('shiza_dynamic_translations', $data);
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
				'userLogin' => 'demo',
				'userPass' => $passwordunik,
				'userEmail' => 'demo@demo.com',
				'userTlp' => '',
				'userDisplayName' => 'Demo Shiza',
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
			$this->mc->save('shiza_users', $data);
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
			$this->mc->save('shiza_users_level', $data);
		}
    }
    
    protected function seeder_users_menu_table() {
		$arr = [
			[
                'menuParentId' => '0',
                'menuName' => 'Developer', 
                'menuAccess' => '',
                'menuAddedDate' => '1452867589', 
                'menuSort' => '5',
                'menuIcon' => 'fe fe-award', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'n', 
                'menuEdit' => 'n',
                'menuDelete' => 'n',
            ],
			[
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
                'menuDelete' => 'y',
            ],
			[
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
                'menuDelete' => 'y',
            ],
			[
                'menuParentId' => '0',
                'menuName' => 'System', 
                'menuAccess' => '',
                'menuAddedDate' => '1577728905', 
                'menuSort' => '4',
                'menuIcon' => 'fe fe-settings', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'n', 
                'menuEdit' => 'y',
                'menuDelete' => 'n',
            ],
			[
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
                'menuDelete' => 'y',
            ],
			[
                'menuParentId' => '0',
                'menuName' => 'Pengaturan', 
                'menuAccess' => '',
                'menuAddedDate' => '1577892258', 
                'menuSort' => '3',
                'menuIcon' => 'fe fe-sliders', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'n', 
                'menuEdit' => 'n',
                'menuDelete' => 'n',
            ],
			[
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
                'menuDelete' => 'n',
            ],
			[
                'menuParentId' => '0',
                'menuName' => 'Pengguna', 
                'menuAccess' => '',
                'menuAddedDate' => '1578138421', 
                'menuSort' => '2',
                'menuIcon' => 'fe fe-user', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'n', 
                'menuEdit' => 'n',
                'menuDelete' => 'n',
            ],
			[
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
                'menuDelete' => 'y',
            ],
			[
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
                'menuDelete' => 'y',
            ],
			[
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
                'menuDelete' => 'n',
            ],
			[
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
                'menuDelete' => 'y',
            ],
            [
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
                'menuDelete' => 'y',
            ],
            [
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
                'menuDelete' => 'y',
            ],
            [
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
                'menuDelete' => 'y',
            ],
            [
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
                'menuDelete' => 'y',
            ],
            [
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
                'menuDelete' => 'y',
            ],
            [
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
                'menuDelete' => 'n',
            ],
            [
                'menuParentId' => '6',
                'menuName' => 'Satuan Bobot', 
                'menuAccess' => 'a:1:{s:10:"admin_link";s:11:"weight_unit";}',
                'menuAddedDate' => '1583429908', 
                'menuSort' => '1',
                'menuIcon' => '', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'y', 
                'menuEdit' => 'y',
                'menuDelete' => 'y',
            ],
            [
                'menuParentId' => '6',
                'menuName' => 'Satuan Panjang', 
                'menuAccess' => 'a:1:{s:10:"admin_link";s:11:"length_unit";}',
                'menuAddedDate' => '1583430360', 
                'menuSort' => '2',
                'menuIcon' => '', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'y', 
                'menuEdit' => 'y',
                'menuDelete' => 'y',
            ],
            [
                'menuParentId' => '6',
                'menuName' => 'Pajak', 
                'menuAccess' => 'a:1:{s:10:"admin_link";s:3:"tax";}',
                'menuAddedDate' => '1584089953', 
                'menuSort' => '3',
                'menuIcon' => '', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'y', 
                'menuEdit' => 'y',
                'menuDelete' => 'y',
            ],
            [
                'menuParentId' => '6',
                'menuName' => 'Aturan Pajak', 
                'menuAccess' => 'a:1:{s:10:"admin_link";s:8:"tax_rule";}',
                'menuAddedDate' => '1584090162', 
                'menuSort' => '4',
                'menuIcon' => '', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'y', 
                'menuEdit' => 'y',
                'menuDelete' => 'y',
            ],
            [
                'menuParentId' => '6',
                'menuName' => 'Mata Uang', 
                'menuAccess' => 'a:1:{s:10:"admin_link";s:10:"currencies";}',
                'menuAddedDate' => '1584090345', 
                'menuSort' => '5',
                'menuIcon' => '', 
                'menuAttrClass' => '',
                'menuActive' => 'y', 
                'menuView' => 'y',
                'menuAdd' => 'y', 
                'menuEdit' => 'y',
                'menuDelete' => 'y',
            ],
		];
		foreach ( $arr as $item ) {
			$data = [
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
			$this->mc->save('shiza_users_menu', $data);
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
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '2', 
                'levelId' => '1',
                'menuId' => '2', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '3', 
                'levelId' => '1',
                'menuId' => '3', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '4', 
                'levelId' => '1',
                'menuId' => '4', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '5', 
                'levelId' => '1',
                'menuId' => '5', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '6', 
                'levelId' => '1',
                'menuId' => '6', 
                'lmnView' => 'y',
                'lmnAdd' => 'n', 
                'lmnEdit' => 'n',
                'lmnDelete' => 'n',
            ],
			[
                'lmnId' => '7', 
                'levelId' => '1',
                'menuId' => '7', 
                'lmnView' => 'y',
                'lmnAdd' => 'n', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'n',
            ],
			[
                'lmnId' => '8', 
                'levelId' => '1',
                'menuId' => '8', 
                'lmnView' => 'y',
                'lmnAdd' => 'n', 
                'lmnEdit' => 'n',
                'lmnDelete' => 'n',
            ],
			[
                'lmnId' => '9', 
                'levelId' => '1',
                'menuId' => '9', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '10', 
                'levelId' => '1',
                'menuId' => '10', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '11', 
                'levelId' => '1',
                'menuId' => '11', 
                'lmnView' => 'y',
                'lmnAdd' => 'n', 
                'lmnEdit' => 'n',
                'lmnDelete' => 'n',
            ],
			[
                'lmnId' => '12', 
                'levelId' => '1',
                'menuId' => '12', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '13', 
                'levelId' => '1',
                'menuId' => '13', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '14', 
                'levelId' => '1',
                'menuId' => '14', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '15', 
                'levelId' => '1',
                'menuId' => '15', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '16', 
                'levelId' => '1',
                'menuId' => '16', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '17', 
                'levelId' => '1',
                'menuId' => '17', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '18', 
                'levelId' => '1',
                'menuId' => '18', 
                'lmnView' => 'y',
                'lmnAdd' => 'n', 
                'lmnEdit' => 'n',
                'lmnDelete' => 'n',
            ],
			[
                'lmnId' => '19', 
                'levelId' => '1',
                'menuId' => '19', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '20', 
                'levelId' => '1',
                'menuId' => '20', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '21', 
                'levelId' => '1',
                'menuId' => '21', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '22', 
                'levelId' => '1',
                'menuId' => '22', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
			[
                'lmnId' => '23', 
                'levelId' => '1',
                'menuId' => '23', 
                'lmnView' => 'y',
                'lmnAdd' => 'y', 
                'lmnEdit' => 'y',
                'lmnDelete' => 'y',
            ],
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
			$this->mc->save('shiza_users_menu_access', $data);
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
			$this->mc->save('shiza_email_template', $data);
		}
    }
}
