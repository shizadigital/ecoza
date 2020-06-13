<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$attrval_colpan_table = 7;

/************************************
Register style (CSS)
************************************/
$request_css_files = array(
    'vendors/select2/dist/css/select2.min.css',
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    // 'vendors/parsley/parsley.config.js',
    // 'vendors/parsley/parsley.min.js',
    'vendors/select2/dist/js/select2.full.min.js',
);
$request_script = "
$( document ).ready(function() {
    // $('#valid').parsley();
    $('.select2').select2();

    // submit with ajax
    ajaxSubmit('#valid');

    // load product
    $('.select2relatedproduct').select2({
        minimumInputLength: 2,
        allowClear: true,
        tags: false,
        ajax: {
            url: '".admin_url($this->uri->segment(2)."/ajax_related_getallproduct/")."',
            dataType: 'json',
            type: 'POST',
            delay: 500,
            data: function(params) {
                
                //get class related
                var classval = $('#relatedlist').attr('class');

                return {
                    search: params.term,
                    CP: '".get_cookie('sz_token')."',
                    class: classval
                    ".( is_csrf() ? ','.$this->security->get_csrf_token_name().':"'.$this->security->get_csrf_hash().'"':'')."
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            }
        }
    });

    $('.select2relatedproduct').change(function() {

        var selectdata = $(this).val();
        $('.select2relatedproduct').empty();

        $.ajax({
            type: 'POST',
            url: '".admin_url($this->uri->segment(2)."/ajax_related_product/")."',
            data : {
                val: selectdata,
                CP: '".get_cookie('sz_token')."'
                ".( is_csrf() ? ','.$this->security->get_csrf_token_name().':"'.$this->security->get_csrf_hash().'"':'')."
            },
            beforeSend: function(data){
                $('.chooseinforelated').remove();
                $('#relatedresult').prepend('<li class=\"loadajaxresult\"><img src=\"".base_assets('img/loader/loading.gif')."\" alt=\"loader\"></li>');
            },
            success: function(data) {
                $('.loadajaxresult').remove();
                if(data){
                    if(data == '503'){
                        $('ul#relatedresult').prepend('Error 503');
                    } else {
                        $( '#relatedlist' ).addClass( selectdata );
                        $( 'ul#relatedresult' ).prepend( data );
                    }
                } else {
                    $('ul#relatedresult').prepend('".t('datacannotbeloaded')."');
                }
            }
        });

    });

    $('#generateattrval-btn').click(function() {
        var selectdata = [];
        $('.attrval-generator-input:checked').each(function() {
            selectdata.push($(this).val());
        });

        var groupattr = $('#groupattr').val();

        $(this).attr('disabled','disabled');
        $(this).addClass('btn-disabled');

        var attrval = [];
        $('.attrvaluedata').each(function() {
            attrval.push($(this).val());
        });

        if( selectdata.length > 0 || groupattr.length > 0){

            $.ajax({
                type: 'POST',
                url: '".admin_url($this->uri->segment(2)."/ajax_generate_attrvalue/")."',
                data : {
                    val: selectdata,
                    group: groupattr,
                    CP: '".get_cookie('sz_token')."',
                    attravailable: attrval
                    ".( is_csrf() ? ','.$this->security->get_csrf_token_name().':"'.$this->security->get_csrf_hash().'"':'')."
                },
                beforeSend: function(data){
                    if( $('#noitemattrinfo').length > 0 ){
                        $('#noitemattrinfo').remove();
                    }

                    $('.attributevalue tbody').append('<tr class=\"loaderresult\"><td colspan=\"{$attrval_colpan_table}\" class=\"text-center\"><div class=\"py-2\"><img src=\"".base_assets('img/loader/loading.gif')."\" alt=\"loader\"></div></td></tr>');
                },
                success: function(data) {
                    $('.loaderresult').remove();
                    $('#generateattrval-btn').removeAttr('disabled');
                    $('#generateattrval-btn').removeClass('btn-disabled');
                    if(data){

                        if('.loaderattrerror'.length > 0){
                            $('.loaderattrerror').remove();
                        }
                        
                        if(data == '503'){
                            $('.attributevalue tbody').append('<tr class=\"loaderattrerror\"><td colspan=\"{$attrval_colpan_table}\" class=\"text-center\">Error 503</td></tr>');
                        } else {
                            $('body').removeClass('air__sidebar--toggled');
                            $( '.attributevalue tbody' ).append( data );
                            $('.attrval-generator-input').prop('checked', false);

                            moving_tab_to('#attribute');
                            
                            // hide normal price, qty and qty type field in general tab
                            $(\"#general-qty\").attr('disabled', true);
                            $(\"#general-qty\").val('');
                            $(\"#general-qtytype\").attr('disabled', true);
                            $(\"#general-qtytype\").attr('disabled', true);
                            $(\"#nprice\").attr('disabled', true);
                            $(\"#nprice\").val('');

                            // empty element in price desc
                            $('#hasil_selisih').html('');
                            $('#hasil_potongan').html('');
                        }
                    } else {
                        $('.attributevalue tbody').append('<tr class=\"loaderattrerror\"><td colspan=\"{$attrval_colpan_table}\" class=\"text-center\">".t('datacannotbeloaded')."</td></tr>');
                    }
                }
            });
        } else {
            $('#generateattrval-btn').removeAttr('disabled');
            $('#generateattrval-btn').removeClass('btn-disabled');

            $.notify(
                {
                    title: '<strong>".t('warning')."!</strong>',
                    message: '".t('warninginserttheattribute').".',
                },
                {
                    type: 'danger',
                },
            )
        }
    });

    $('#groupattr').change(function() {
        var vattrgrp = $(this).val().length;

        if( vattrgrp != 0){
            $('#attrelement').fadeOut();
        } else {
            $('#attrelement').fadeIn();
        }
    });
});

function qtySet(qtyset,stockdestination){
    $(document).ready(function($) {
        var sto = $(stockdestination);
        if($(qtyset).val() == 'unlimited'){
            sto.attr('readonly','readonly');
            sto.attr('disabled','disabled');
        }
        else{
            sto.removeAttr('readonly');
            sto.removeAttr('disabled');
            if(sto.val() == ''){
                sto.val('0');
            }
            sto.parent().find('input[type=text]').focus();
        }
    });
}

// make moving to another tap
function moving_tab_to(objct) {
    $(document).ready(function($){

        $('div.producttab > .card-header > ul.nav-tabs li a').each(function () {
            if ($(this).hasClass('active')) { $(this).removeClass('active'); }
            if ($(this).hasClass('show')) { $(this).removeClass('show'); }
        });

        $('div.producttab > .card-body > .tab-content.paneltab-product > .tab-pane').each(function () {
            if ($(this).hasClass('active')) { $(this).removeClass('active'); }
            if ($(this).hasClass('show')) { $(this).removeClass('show'); }
        });
        
        var objtab = objct.replace('#', '');
        $('#tab-' + objtab).addClass('active');

        var objcttab = objct.replace('#tab-', '#');

        $(objcttab).addClass('active show');
    });
}
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
if( is_add() ){
?>
<!-- Attribute setting start here -->
<div class="air__sidebar">
    <a href="javascript: void(0);" class="air__sidebar__close air__sidebar__actionToggle fe fe-x-circle"></a>
    <h5><strong><?php echo t('attributesetting'); ?></strong></h5>

    <div class="air__utils__line mb-4" style="margin-top: 19px;"></div>
        <div class="air__sidebar__scroll">
        <p class="text-muted descrriptiontext-attr">
            <span class="textshort-attr"></span>
            <span class="textfull-attr">
                <?php echo t('addattributetoproductinfo'); ?>
            </span>
            <button type="button" class="btn btn-light btn-sm read-more-text-attr"><?php echo t('readmore'); ?></button>
        </p>
        <script type="text/javascript">
            $(document).ready(function(){    
                var maxChars = 124;
                var ellipsis = "...";
                $(".descrriptiontext-attr").each(function() {
                    var text = $(this).find(".textfull-attr").text();
                    var html = $(this).find(".textfull-attr").html();        
                    if(text.length > maxChars){            
                        var shortHtml = html.substring(0, maxChars - 3) + "<span class='ellipsis'>" + ellipsis + "</span>";
                        $(this).find(".textshort-attr").html(shortHtml);            
                    }
                    $(this).find(".textfull-attr").hide();
                });
                $(".read-more-text-attr").click(function(){        
                    var readMoreText = "<?php echo t('readmore'); ?>";
                    var readLessText = "<?php echo t('readless'); ?>";        
                    var $shortElem = $(this).parent().find(".textshort-attr");
                    var $fullElem = $(this).parent().find(".textfull-attr");        
                    
                    if($shortElem.is(":visible")){           
                        $shortElem.hide();
                        $fullElem.show();
                        $(this).text(readLessText);
                    }
                    else{
                        $shortElem.show();
                        $fullElem.hide();
                        $(this).text(readMoreText);
                    }       
                });
            });
        </script>

        <div class="row">

            <div class="col-md-12 mb-5">

                <h5 class="mb2"><?php echo t('selectgroup'); ?></h5>

                <div class="mb-4">
                    <div class="form-group">
                        <?php
                        $extraopt = array(
                            'class' => 'custom-select',
                            'id'=> 'groupattr'
                        );
                        echo form_dropdown('groupattr', $attrgroupopt, '', $extraopt);
                        ?>
                    </div>
                </div>
                
                <div id="attrelement">

                    <p class="text-center"><?php echo ucwords( t('or') ); ?></p>


                    <h5 class="mb2"><?php echo t('selectattributes'); ?></h5>
                    
                <?php 
                foreach($attrval as $kattr => $vattr){
                    // check if attribute value is not empty
                    if(count($vattr['attrvalues']) > 0){
                        echo '<div class="card"><div class="card-body">';
                        echo '<h5 class="mb-3">'.$vattr['attrLabel'].'</h5>';
                        foreach($vattr['attrvalues'] as $kval => $vav){
                            echo '
                            <div class="form-group mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="attrvalcheck[]" value="'.$vattr['attrId'].'-'.$vav['attrvalId'].'" class="custom-control-input attrval-generator-input" id="attrvalcheck-'.$vav['attrvalId'].'"  />
                                    <label class="custom-control-label" for="attrvalcheck-'.$vav['attrvalId'].'">
                                    ';
                                    if( $vav['attrvalVisual']== 'color' ){
                                        echo '<div style="height:12px;width:12px; display:inline-block; margin-right:4px;background-color:'.$vav['attrvalValue'].';"></div>';
                                    }
                                    echo $vav['attrvalLabel'].'
                                    </label>
                                </div>
                            </div>
                            ';
                        }
                        echo '</div></div>';
                    }
                }
                ?>
                </div>

                <button type="button" id="generateattrval-btn" class="btn btn-block btn-primary"><i class="fe fe-zap"></i> <?php echo t('generate'); ?></button>
            </div>

        </div>
        
    </div>
</div>
<!-- Attribute setting end here -->

<?php
$hiddenfield = array(
    'ID'=>$data['prodId'],
    'oldprodtype' => $data['prodType']
);
echo form_open_multipart( admin_url( $this->uri->segment(2) . '/editprocess'), array( 'id'=> 'valid' ), $hiddenfield );

// data count attribute for this product
$countattravailable = countdata('product_attribute', array('prodId'=>$data['prodId']));
?>
<div class="row">
    <div class="col-12 mb-4">
        <?php 
        if( !empty( $this->session->has_userdata('succeed') ) ){
            echo '
            <div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check"></i> ' . $this->session->flashdata('succeed') . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
            </div>
            ';
        }
        if( !empty( $this->session->has_userdata('failed') ) ){
            echo '
            <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-times"></i> ' . $this->session->flashdata('failed') . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
            </div>
            ';
        }
        ?>
        <div class="row"><div class="col-md-5 ml-auto ml-2">
            <div class="form-group row mb-0">
                <label class="col-md-4 col-form-label" for="producttype"><?php echo t('producttype'); ?>: </label>
                <div class="col-md-8">
                    <select name="producttype" id="producttypechoice" class="select2 producttype">
                        <option value="simpleproduct"<?php if($data['prodType']=='simpleproduct'){ echo ' selected="selected"'; } ?>><?php echo t('simpleproduct'); ?></option>
                        <option value="configurableproduct"<?php if($data['prodType']=='configurableproduct'){ echo ' selected="selected"'; } ?>><?php echo t('configurableproduct'); ?></option>
                        <option value="downloadableproduct"<?php if($data['prodType']=='downloadableproduct'){ echo ' selected="selected"'; } ?>><?php echo t('downloadableproduct'); ?></option>
                        <option value="servicesproduct"<?php if($data['prodType']=='servicesproduct'){ echo ' selected="selected"'; } ?>><?php echo t('servicesproduct'); ?></option>
                    </select>
                </div>
            </div>
        </div></div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('input[name=shipping].shipping').change(function(e) {
                    if ( $(this).val() == 'y') {
                        var prodtypechoose = $('#producttypechoice').val();

                        if(prodtypechoose == 'simpleproduct' || prodtypechoose =='configurableproduct'){
                            $("#listtab-shipping").show();
                        }
                    } else {
                        $("#listtab-shipping").hide();
                    }
                });
                
                $('#producttypechoice').change(function(e) {
                    var value = $(this).val();
                    
                    if( $('.attrtrdata').length > 0 && (value != 'configurableproduct' && value != 'downloadableproduct')){
                        if( confirm("<?php echo t('warningattravailablevalue'); ?>") ){
                            moving_tab_to('#general');
                            $('.attrtrdata').remove();                            
                            $('.attributevalue tbody').html('<tr id="noitemattrinfo"><td colspan="<?php echo $attrval_colpan_table; ?>" class="text-center"><?php echo t('nodatafound');?></td></tr>');
                        } else {
                            $(this).val($.data(this, 'current'));
                            return false;
                        }
                    }

                    if( 
                        ($.data(this, 'current') == 'configurableproduct' && $("#tab-attribute").hasClass('active')) || 
                        ($.data(this, 'current') == 'downloadableproduct' && ($("#tab-downloadable").hasClass('active') || $("#tab-attribute").hasClass('active'))) 
                    ){
                        moving_tab_to('#general');
                    }

                    // define shipping choose
                    var shipping_val = $("input[name=\'shipping\'].shipping:checked").val();

                    if(value == 'simpleproduct'){
                        // hide attribute
                        $("#listtab-attribute").hide();

                        // hide downloadable
                        $("#listtab-downloadable").hide();

                        if(shipping_val == 'y'){
                            // show shipping
                            $("#listtab-shipping").show();
                        }

                        // enable field in general tab
                        $("#general-qty").removeAttr('disabled');
                        $("#general-qtytype").removeAttr('disabled');
                        $("#general-qtytype").removeAttr('disabled');
                        $("#nprice").removeAttr('disabled');                    
                    }
                    else if(value == 'configurableproduct'){
                        // show attribute
                        $("#listtab-attribute").show();

                        // hide downloadable
                        $("#listtab-downloadable").hide();

                        if(shipping_val == 'y'){
                            // show shipping
                            $("#listtab-shipping").show();
                        }
                    }
                    else if(value == 'downloadableproduct'){
                        // moving tab
                        if($("#tab-shipping").hasClass('active')){
                            moving_tab_to('#general');
                        }

                        // show attribute
                        $("#listtab-attribute").show();

                        // show downloadable
                        $("#listtab-downloadable").show();
                        
                        // hide shipping
                        $("#listtab-shipping").hide();
                    }
                    else if(value == 'servicesproduct'){
                        // moving tab
                        if($("#tab-shipping").hasClass('active')){
                            moving_tab_to('#general');
                        }
                        
                        // hide shipping
                        $("#listtab-shipping").hide();

                        // hide downloadable
                        $("#listtab-downloadable").hide();
                        
                        // hide downloadable
                        $("#listtab-attribute").hide();

                    }
                    
                    $.data(this, 'current', $(this).val());
                });
            });
        </script>

    </div>

    <div class="col-12">

        <div class="card">

            <div class="tab nav-border-bottom producttab">

                <div class="card-header card-header-flex">
                    <?php 
                    $attr_dnone = '';
                    $shipping_dnone = '';
                    $downloadable_dnone = '';

                    if($data['prodType']!='configurableproduct' AND $data['prodType']!='downloadableproduct'){
                        $attr_dnone = ' style="display:none;"';
                    }
                    
                    if($data['prodType']=='downloadableproduct'){
                        $shipping_dnone = ' style="display:none;"';
                    }
                    if($data['prodType']=='servicesproduct'){
                        $shipping_dnone = ' style="display:none;"';
                    }
                    if($data['prodShipping']!='y'){
                        $shipping_dnone = ' style="display:none;"';
                    }

                    if($data['prodType']!='downloadableproduct'){
                        $downloadable_dnone = ' style="display:none;"';
                    }
                    if($data['prodType']=='servicesproduct'){
                        $downloadable_dnone = ' style="display:none;"';
                    }
                    ?>

                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-bold nav-tabs-noborder nav-tabs-stretched">
                        <li class="nav-item" id="listtab-general">
                            <a class="nav-link active show" id="tab-general" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo t('general'); ?></a>
                        </li>
                        <li class="nav-item" id="listtab-data">
                            <a class="nav-link" id="tab-data" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false"><?php echo t('data'); ?></a>
                        </li>
                        <li class="nav-item" id="listtab-linked">
                            <a class="nav-link" id="tab-linked" data-toggle="tab" href="#linked" role="tab" aria-controls="linked" aria-selected="false"><?php echo t('linked'); ?></a>
                        </li>
                        <li class="nav-item" id="listtab-image">
                            <a class="nav-link" id="tab-image" data-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false"><?php echo t('image'); ?></a>
                        </li>

                        <li class="nav-item" id="listtab-attribute"<?php echo $attr_dnone; ?>>
                            <a class="nav-link" id="tab-attribute" data-toggle="tab" href="#attribute" role="tab" aria-controls="attribute" aria-selected="false"><?php echo t('attribute'); ?></a>
                        </li>

                        <li class="nav-item" id="listtab-shipping"<?php echo $shipping_dnone; ?>>
                            <a class="nav-link" id="tab-shipping" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false"><?php echo t('shipping'); ?></a>
                        </li>

                        <li class="nav-item" id="listtab-downloadable"<?php echo $downloadable_dnone; ?>>
                            <a class="nav-link" id="tab-downloadable" data-toggle="tab" href="#downloadable" role="tab" aria-controls="downloadable" aria-selected="false"><?php echo t('downloadableinfo'); ?></a>
                        </li>
                        
                        <li class="nav-item" id="listtab-seo">
                            <a class="nav-link" id="tab-seo" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO</a>
                        </li>
                    </ul>

                </div>
                
                <div class="card-body">
                
                    <div class="tab-content paneltab-product">
                        <?php 
                        // setting layout
                        $col_layout = array('label'=>'col-md-2', 'input'=>'col-md-10');
                        $layout_model = 'horizontal';
                        ?>
                        <!--

                        General Input Start Here

                        -->
                        <div class="tab-pane fade py-4 active show" id="general" role="tabpanel" aria-labelledby="tab-general">
                            <div class="row">
                                <div class="col-md-9">
                                    <?php
                                    // get rules data for checkbox
                                    $rulesdata = array();
                                    foreach(productRules(TRUE) AS $key => $val){
                                        $rulesdata[$key]['title'] = '<strong>'.$val['type'] . '</strong> - '.$val['description'];
                                        $rulesdata[$key]['value'] = $key;
                                        $rulesdata[$key]['checked'] = ( $key == $data['optionProdRules'] ) ? true:false;
                                    }

                                    $buildgeneralform1 = array(
                                        array(
                                            'type' => 'radio',
                                            'label'=> '<h4 class="d-inline-block">'.t('productrules').':</h4>',
                                            'name'=> 'rules',
                                            'value'=> $rulesdata,
                                        ),
                                        array(
                                            'type' => 'multilanguage_text',
                                            'label' => '<h4 class="d-inline-block">'.t('productname').': <span class="text-danger">*</span></h4>',
                                            'name' => 'productname',
                                            'value' => array(
                                                'table' => 'product',
                                                'field' => 'prodName',
                                                'id' => $data['prodId']
                                            ),
                                        ),
                                        array(
                                            'type' => 'multilanguage_texteditor',
                                            'texteditor' => 'standard',
                                            'label' => '<h4 class="d-inline-block">'.t('description').':</h4>',
                                            'name' => 'desc',
                                            'value' => array(
                                                'table' => 'product',
                                                'field' => 'prodDesc',
                                                'id' => $data['prodId']
                                            ),
                                        ),
                                        array(
                                            'type' => 'text',
                                            'label'=> '<h4 class="d-inline-block">'.t('youtubevideo').':</h4>',
                                            'name'=> 'urlyoutube',
                                            'help' => t('infoyoutubereq'),
                                            'input-group' => array(
                                                'prepend'=> '<span class="input-group-text"><i class="fa fa-youtube-play mr-1"></i> YouTube</span>',
                                            ),
                                            'value' => $data['prodVideo']
                                        ),
                                        array(
                                            'type' => 'multilanguage_texteditor',
                                            'texteditor' => 'verysimple',
                                            'label' => '<h4 class="d-inline-block">'.t('note').':</h4>',
                                            'name' => 'note',
                                            'value' => array(
                                                'table' => 'product',
                                                'field' => 'prodNote',
                                                'id' => $data['prodId']
                                            ),
                                        ),
                                    );
                                    $this->formcontrol->buildInputs($buildgeneralform1);
                                    ?>

                                </div>

                                <div class="col-md-3">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card"><div class="card-body">
                                            <h4 class="mb-4"><?php echo t('setting'); ?></h4>
                                            <?php
                                            $buildgeneralform2 = array(
                                                array(
                                                    'type' => 'checkbox',
                                                    'name' => 'publish',
                                                    'value' => 'y',
                                                    'title' => t('published'),
                                                    'checked' => ($data['prodDisplay']=='y') ? true:false,
                                                ),
                                                array(
                                                    'type' => 'checkbox',
                                                    'name'=> 'allowreviews',
                                                    'value' => 'y',
                                                    'title'=> t('allowreviews'),
                                                    'checked' => ($data['prodAllowReview']=='y') ? true:false,
                                                ),
                                                array(
                                                    'type' => 'checkbox',
                                                    'name'=> 'featured',
                                                    'value' => 'y',
                                                    'title'=> t('featured'),
                                                    'checked' => ($data['prodFeatured']=='y') ? true:false,
                                                ),
                                            );

                                            $this->formcontrol->buildInputs($buildgeneralform2);
                                            ?>
                                            </div></div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card"><div class="card-body">
                                                <h4 class="mb-4"><?php echo t('quantity'); ?></h4>
                                                <?php
                                                // configurable condition
                                                if(($data['prodType']=='configurableproduct' OR $data['prodType']=='downloadableproduct') AND $countattravailable>0){
                                                    $qtysetting = array(
                                                        'disabled' => 'disabled',
                                                        'value' => '',
                                                    );

                                                    $qtytypesetting = array(
                                                        'disabled' => 'disabled',
                                                    );
                                                } else {
                                                    $prodqty = $data['prodQty'];
                                                    $qtyexp = explode('.',$prodqty);
                                                    if($qtyexp[1]==00000000){ $prodqty = $qtyexp[0]; }

                                                    $qtysetting = array(
                                                        'value' => singleComma($prodqty, ".", ","),
                                                    );
                                                    if($data['prodQtyType'] == 'unlimited'){
                                                        $qtysetting = array(
                                                            'value' => '',
                                                            'disabled' => 'disabled',
                                                        );
                                                    }

                                                    $qtytypesetting = array(
                                                        'selected' => $data['prodQtyType']
                                                    );
                                                }
                                                $qtyfield = array(
                                                    'type' => 'text',
                                                    'name'=> 'qty',
                                                    'id' => 'general-qty',
                                                    'onkeypress'=>'return isNumberComma(event)',
                                                    'label'=> t('quantity'),
                                                );
                                                $qtyfield_array = array_merge($qtyfield,$qtysetting);

                                                $qtytypefield = array(
                                                    'type' => 'select',
                                                    'label'=> t('qtytype'),
                                                    'name'=> 'qty-type',
                                                    'id' => 'general-qtytype',
                                                    'class' => 'select2',
                                                    'option'=> array('limited'=>t('limited'),'unlimited'=>t('unlimited')),
                                                );
                                                $qtytypefield_array = array_merge($qtytypefield, $qtytypesetting);
                                                
                                                $builddataform4 = array(
                                                    $qtyfield_array,
                                                    $qtytypefield_array,                                                    
                                                );
                                                $this->formcontrol->buildInputs($builddataform4);
                                                ?>
                                                <script type="text/javascript">
                                                    $(document).ready(function($) {
                                                        $('#general-qtytype').on('change', function(){
                                                            qtySet($(this),'#general-qty');
                                                        }); 
                                                    });
                                                </script>
                                            </div></div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card"><div class="card-body">
                                                <h4 class="mb-4"><?php echo t('price'); ?></h4>
                                                <?php
                                                // basic price
                                                $c_price = explode('.', $data['prodBasicPrice']);
                                                $capitalprice = $c_price[0].( ($c_price[1]=='00')?'':','.$c_price[1] );

                                                // normal price
                                                $n_price = explode('.', $data['prodPrice']);
                                                $normalprice = $n_price[0].( ($n_price[1]=='00')?'':','.$n_price[1] );

                                                // special price
                                                $s_price = explode('.', $data['prodSpecialPrice']);
                                                $specialprice = $s_price[0].( ($s_price[1]=='00')?'':','.$s_price[1] );

                                                // configurable condition
                                                $classadditional = '';
                                                if(($data['prodType']=='configurableproduct' OR $data['prodType']=='downloadableproduct') AND $countattravailable>0){
                                                    $price_setting = array(
                                                        'disabled' => 'disabled',
                                                        'value' => '',
                                                    );
                                                } else {
                                                    $price_setting = array(
                                                        'value' => $normalprice,
                                                    );
                                                }
                                                $normalform = array(
                                                    'type'=>'text',
                                                    'label'=> t('normalprice').' <span class="text-danger">*</span>',
                                                    'name'=> 'normalprice',
                                                    'id' => 'nprice',
                                                    'class' => 'input_price_field input_special_price' . $classadditional,
                                                    'onkeypress'=>'return isNumberComma(event)',
                                                    'input-group' => array(
                                                        'prepend'=> getCurrencySymbol(),
                                                    ),
                                                    'extra' => '
                                                    <small class="form-text text-muted" id="hasil_selisih">
                                                    '.t('differencefromcapitalprice').': 0%
                                                    </small>
                                                    '
                                                );
                                                $normalprice_array = array_merge($normalform,$price_setting);
                                                
                                                $builddataform2 = array(
                                                    array(
                                                        'type'=>'text',
                                                        'label'=> t('capitalprice').' <span class="text-danger">*</span>',
                                                        'name'=> 'capitalprice',
                                                        'id' => 'bprice',
                                                        'class' => 'input_price_field',
                                                        'onkeypress'=>'return isNumberComma(event)',
                                                        'input-group' => array(
                                                            'prepend'=> getCurrencySymbol(),
                                                        ),
                                                        'value' => $capitalprice
                                                    ),
                                                    $normalprice_array
                                                    ,
                                                    array(
                                                        'type'=>'text',
                                                        'label'=> t('specialprice'),
                                                        'name'=> 'specialprice',
                                                        'onkeypress'=>'return isNumberComma(event)',
                                                        'id' => 'sprice',
                                                        'class' => 'input_special_price',
                                                        'input-group' => array(
                                                            'prepend'=> getCurrencySymbol(),
                                                        ),
                                                        'extra' => '
                                                        <small class="form-text text-muted" id="hasil_potongan">
                                                        '.t('discount').': 0%
                                                        </small>
                                                        ',
                                                        'value'=>$specialprice
                                                    ),
                                                );
                                                $this->formcontrol->buildInputs($builddataform2);
                                                ?>
                                                <script>
                                                    $(function () {
                                                        $(".input_special_price").keyup(function() {
                                                            var harga_normal = $("#nprice").val().replace(',', '.');
                                                            var harga_spesial = $("#sprice").val().replace(',', '.');
                                                            countingDiffPrice(harga_normal, harga_spesial, "#hasil_potongan", '<?php echo t('discount'); ?>: ', "<?php echo t('specialpricemorebigger'); ?>");
                                                        });

                                                        $(".input_price_field").keyup(function() {
                                                            var harga_normal = $("#nprice").val().replace(',', '.');
                                                            var harga_modal = $("#bprice").val().replace(',', '.');
                                                            countingDiffPrice(harga_normal, harga_modal, "#hasil_selisih", '<?php echo t('differencefromcapitalprice'); ?>: ', "<?php echo t('capitalpricemorebigger'); ?>");
                                                        });
                                                    });
                                                </script>
                                            </div></div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card"><div class="card-body">
                                                <h4 class="mb-4"><?php echo t('tax'); ?></h4>
                                                <?php                            
                                                $builddataform3 = array(
                                                    array(
                                                        'type' => 'select',
                                                        'name'=> 'tax',
                                                        'option' => $taxes,
                                                        'selected' => $data['taxId']
                                                    ),
                                                );
                                                $this->formcontrol->buildInputs($builddataform3);
                                                ?>
                                            </div></div>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--

                        Data Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="data" role="tabpanel" aria-labelledby="tab-data">
                        
                            <?php                            
                            $builddataform1 = array(
                                array(
                                    'type' => 'text',
                                    'label'=> 'SKU',
                                    'name'=> 'sku',
                                    'info' => t('abbr_sku'),
                                    'value' => $data['prodSku']
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> 'UPC',
                                    'name'=> 'upc',
                                    'info' => t('abbr_upc'),
                                    'value' => $data['prodUpc']
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> 'ISBN',
                                    'name'=> 'isbn',
                                    'info' => t('abbr_isbn'),
                                    'value' => $data['prodIsbn']
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> 'MPN',
                                    'name'=> 'mpn',
                                    'info' => t('abbr_mpn'),
                                    'value' => $data['prodMpn']
                                ),
                                array(
                                    'type' => 'radio',
                                    'label'=> t('shipping'),
                                    'name'=> 'shipping',
                                    'class' => 'shipping',
                                    'value' => array(
                                        array(
                                            'value'=>'y',
                                            'title' => t('yes'),
                                            'checked' => ($data['prodShipping']=='y') ? true:false   
                                        ),
                                        array(
                                            'value'=>'n',
                                            'title' => t('no'),
                                            'checked' => ($data['prodShipping']!='y') ? true:false
                                        ),
                                    ),
                                    'layout' => 'horizontal'
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> t('maximumorder'),
                                    'name'=> 'maxorder',
                                    'placeholder'=> 'Max',
                                    'onkeypress'=> 'return isNumberKey(event)',
                                    'info' => t('infomaximumorderfiled'),
                                    'value' => $data['prodMaxOrder'],
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> t('minimumorder'),
                                    'name'=> 'minorder',
                                    'placeholder'=> 'Min',
                                    'onkeypress'=> 'return isNumberKey(event)',
                                    'value' => ($data['prodMinOrder']<1) ? 1: $data['prodMinOrder']
                                ),

                            );
                            $this->formcontrol->buildInputs($builddataform1, $layout_model, $col_layout);
                            ?>

                        </div>

                        <!--

                        Linked Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="linked" role="tabpanel" aria-labelledby="tab-linked">
                            <?php                
                            
                            $relatedcontent = '<li class="chooseinforelated">'.t('chooseproduct').'</li>';
                            $relatedclassdata = '';

                            $countreldata = count($relatedprod);
                            if( $countreldata > 0 ){
                                $relatedcontent = '';
                                $norel = 1;
                                foreach($relatedprod as $reldata){

                                    $gdatarel = getval("prodId,prodName,prodSku","product","prodDeleted=0 AND prodId='{$reldata['relatedId']}'");
                                    
                                    $relatedcontent .= '<li id="prodrel-' . $gdatarel['prodId'] .'">';
                                    $relatedcontent .= '
                                    <a title="'.t('remove').'" href="javascript:void(0)" id="rmrelateditem-' . $gdatarel['prodId'] .'" class="mr-1 pt-2"><i class="fe fe-x-circle text-danger"></i></a> ' . $gdatarel['prodName'] . ( (!empty($gdatarel['prodSku'])) ? ' ['.$gdatarel['prodSku'].']':'') . '
                                    <input type="hidden" value="' . $gdatarel['prodId'] .'" name="relatedproduct[]">
                                    <script>
                                    $( document ).ready(function() {
                                        $("#rmrelateditem-' . $gdatarel['prodId'] .'").click(function() {
                                            // dispose tooltip
                                            $(\'#rmrelateditem-' . $gdatarel['prodId'] .'\').tooltip(\'dispose\');

                                            // remove id from class
                                            $("#relatedlist").removeClass( "' . $gdatarel['prodId'] .'" );

                                            $("#prodrel-' . $gdatarel['prodId'] .'").remove();
                                        });
                                        $(\'#rmrelateditem-' . $gdatarel['prodId'] .'\').tooltip();
                                    });
                                    </script>
                                    ';
                                    $relatedcontent .= '</li>';

                                    $relatedclassdata .= ' class="'. $gdatarel['prodId'];
                                    if( $norel!= $countreldata){ $relatedclassdata .= ' '; }
                                    $relatedclassdata .= '"';

                                    $norel++; 
                                }
                            }
                            
                            $buildlinkedform = array(
                                array(
                                    'type' => 'multipleselect',
                                    'label'=> t('categories'),
                                    'name'=> 'categories[]',
                                    'class' => 'select2',
                                    'option'=> $categories,
                                    'required' => true,
                                    'selected' => $categories_selected,
                                ),
                                array(
                                    'type' => 'select',
                                    'label'=> t('manufacturers'),
                                    'name'=> 'manufacturers',
                                    'class' => 'select2',
                                    'option'=> $manufacturers,
                                    'selected'=> $data['manufactId'],
                                ),
                                array(
                                    'type' => 'select',
                                    'label'=> t('badges'),
                                    'name'=> 'badges',
                                    'class' => 'select2',
                                    'option'=> $badges,
                                    'selected'=> (empty($badgesrel['badgeId']))?'':$badgesrel['badgeId'],
                                ),
                                array(
                                    'type' => 'select',
                                    'label'=> t('relatedproducts'),
                                    'option'=> array(""=>'-- '.t('chooseproduct').' --'),
                                    'name'=>'relatedproductsearch',
                                    'id'=>'relatedproduct',
                                    'class' => 'select2relatedproduct',
                                    'extra' => '
                                    <div class="alert alert-light">
                                        <div id="relatedlist"'.$relatedclassdata.'></div>
                                        <ul class="list-unstyled" id="relatedresult" style="height:100px;overflow-y:auto;">
                                            '.$relatedcontent.'
                                        </ul>
                                    </div>
                                    '
                                ),
                            );
                            $this->formcontrol->buildInputs($buildlinkedform, $layout_model, $col_layout);
                            ?>
                        </div>
                        
                        <!--

                        Images Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="image" role="tabpanel" aria-labelledby="tab-image">
                            <div class="row">
                                <div class="col-md-6">
                                <h4 class="mb-4"><?php echo t('productimgmanagement'); ?></h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo t('images'); ?></th>
                                                <th class="text-center" style="width:30px;"><?php echo t('remove'); ?></th>
                                                <th><?php echo t('imgpriority'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $np = 1;
                                            foreach($prodimage AS $keyimg => $rp){
                                            ?>
                                            <tr id="col-pic-<?php echo $rp['pimgId']; ?>">
                                                <td>
                                                    <img src="<?php echo images_url($rp['pimgDir']."/small_".$rp['pimgImg']); ?>" alt="<?php echo $data['prodName']; ?>" class="img-thumbnail" style="max-width:250px;">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger" id="remove-picture<?php echo $rp['pimgId']; ?>"><i class="fa fa-trash"></i></button>
                                                    <script type="text/javascript">
                                                        $('#remove-picture<?php echo $rp['pimgId']; ?>').click(function(){

                                                            if($('#primaryidentify-<?php echo $rp['pimgId']; ?>').is(":checked")){
                                                                $.notify(
                                                                    {
                                                                        title: '<strong><?php echo t('warning'); ?>!</strong> ',
                                                                        message: '<?php echo t('primaryimgcannotberemoved'); ?>',
                                                                    },
                                                                    {
                                                                        type: 'warning',
                                                                    },
                                                                )
                                                            } else {

                                                                if(confirm('<?php echo t('deleteimgconfirm'); ?>')){
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: '<?php echo admin_url($this->uri->segment(2)."/ajax_deleteimageproduct/"); ?>',
                                                                        cache: false,
                                                                        data: {
                                                                            idp: '<?php echo $rp['pimgId']; ?>',
                                                                            CP: '<?php echo get_cookie('sz_token'); ?>'
                                                                            <?php echo ( is_csrf() ? ','.$this->security->get_csrf_token_name().':"'.$this->security->get_csrf_hash().'"':''); ?>
                                                                        },
                                                                        beforeSend: function(){
                                                                            btn = $('#remove-picture<?php echo $rp['pimgId']; ?>');
                                                                            btn.attr('disabled','disabled');
                                                                            btn.addClass('btn-disabled');

                                                                            $('#loading_ajax').show();
                                                                        },
                                                                        success: function(data) {
                                                                            if(data){
                                                                                if(data == 'ok'){
                                                                                    $('tr#col-pic-<?php echo $rp['pimgId']; ?>').fadeOut(300, function() { $(this).remove(); });
                                                                                    $.notify(
                                                                                        {
                                                                                            title: '<strong><?php echo t('succeed'); ?>!</strong> ',
                                                                                            message: '<?php echo t('successfullydeleted'); ?>',
                                                                                        },
                                                                                        {
                                                                                            type: 'success',
                                                                                        },
                                                                                    );
                                                                                } else {
                                                                                    var splitdata = data.split('||');
                                                                                    var msg;
                                                                                    if( splitdata[1].length > 0 ){
                                                                                        msg = splitdata[1];
                                                                                    } else {
                                                                                        msg = '<?php echo t('failedforremove'); ?>';
                                                                                    }
                                                                                    $.notify(
                                                                                        {
                                                                                            title: '<strong><?php echo t('error'); ?>!</strong> ',
                                                                                            message: msg,
                                                                                        },
                                                                                        {
                                                                                            type: 'danger',
                                                                                        },
                                                                                    );

                                                                                    btn = $('#remove-picture<?php echo $rp['pimgId']; ?>');
                                                                                    btn.removeAttr('disabled');
                                                                                    btn.removeClass('btn-disabled');
                                                                                }
                                                                            } else {
                                                                                $.notify(
                                                                                    {
                                                                                        title: '<strong><?php echo t('error'); ?>!</strong> ',
                                                                                        message: '<?php echo t('failedforremove'); ?>, <?php echo t('noprocess') ?>',
                                                                                    },
                                                                                    {
                                                                                        type: 'danger',
                                                                                    },
                                                                                );

                                                                                btn = $('#remove-picture<?php echo $rp['pimgId']; ?>');
                                                                                btn.removeAttr('disabled');
                                                                                btn.removeClass('btn-disabled');
                                                                            }
                                                                            $('#loading_ajax').delay( 800 ).fadeOut( 'slow' );
                                                                        }
                                                                    });
                                                                }                                                            
                                                            }
                                                        });
                                                    </script>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="imgID[<?php echo $np; ?>]" value="<?php echo $rp['pimgId']; ?>">
                                                    <input type="hidden" name="identify[<?php echo $np; ?>]" value="<?php echo $np; ?>">
                                                    <div class="radio"><label>
                                                        <input type="radio" id="primaryidentify-<?php echo $rp['pimgId']; ?>" name="primary" value="<?php echo $np; ?>"<?php echo ($rp['pimgPrimary']=='y') ? ' checked':''; ?>>
                                                        <?php echo t('primaryimg'); ?>
                                                    </label></div>
                                                </td>
                                            </tr>
                                            <?php $np++;
                                            }

                                            // define for next var $np
                                            $npnext = $np;
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                        // get old primary image
                                        $getprimaryimage = getval("pimgPrimary, pimgId",'product_images',array('pimgPrimary'=>'y','prodId'=>$data['prodId']));

                                        echo form_hidden( 'oldprimaryimage', $getprimaryimage['pimgId'] );
                                    ?>
                                </div>
                                </div>

                                <div class="col-md-6">
                                    <p class="text-right mb-10">
                                        <button type="button" onclick="addimg()" class="btn btn-info btn-xs"><i class="fa fa-plus-square"></i> <?php echo t('btnaddfield'); ?></button> 
                                        <button type="button" onclick="removeimg()" class="btn btn-warning btn-xs"><i class="fa fa-minus-square"></i> <?php echo t('btnremovefield'); ?></button>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?php echo t('images'); ?></th>
                                                    <th><?php echo t('imgpriority'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="dynamic-image">
                                                <tr>
                                                    <td>
                                                        <input type="file" name="imgprod[<?php echo $npnext; ?>]">
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <label><input type="radio" name="primary" value="<?php echo $npnext; ?>">
                                                            <?php echo t('primaryimg'); ?></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="help-block"><i class="fa fa-info-circle fa-lg" style="color:#5DBDE0;"></i> <?php echo t('infomainimg'); ?> *.jpg, *.jpeg, *.png, *.gif</p>

                                    <script type="text/javascript">
                                        var idrow = 1;

                                        function addimg(){
                                            var newnp = <?php echo $npnext; ?> + idrow;
                                            
                                            var x=document.getElementById('dynamic-image').insertRow(idrow);
                                            var td1=x.insertCell(0);
                                            var td2=x.insertCell(1);
                                            td1.innerHTML="<input type=\"file\" name=\"imgprod["+newnp+"]\">";
                                            td2.innerHTML="<div><label><input type=\"radio\" name=\"primary\" value=\""+newnp+"\"> <?php echo t('primaryimg'); ?></label></div>";
                                            idrow++;
                                        }

                                        function removeimg(){
                                            if(idrow>1){
                                                var x=document.getElementById('dynamic-image').deleteRow(idrow-1);
                                                idrow--;
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                            <!-- END ROW -->
                        </div>  
                        
                        <!--

                        Attributes Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="attribute" role="tabpanel" aria-labelledby="tab-attribute">
                            
                            <h4 class="mb-4 mt-0"><?php echo t('configurations'); ?></h4>

                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo t('configattrinfo'); ?>
                                </div>
                                <div class="col-md-3">
                                    <div class="float-right">
                                        <button type="button" class="air__sidebar__actionToggle btn btn-light btn-rounded"><i class="fe fe-menu"></i> </i><?php echo t('addattribute'); ?></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-4">

                                    <div class="table-responsive-md">
                                        <table class="table table-hover table-striped attributevalue">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo t('combinations'); ?></th>
                                                    <th style="width:200px;" class="text-center"><?php echo t('price'); ?></th>
                                                    <th style="width:100px;" class="text-center"><?php echo t('quantity'); ?></th>
                                                    <th style="width:130px;" class="text-center"><?php echo t('qtytype'); ?></th>
                                                    <th style="width:140px;" class="text-center"><?php echo t('weight'); ?></th>
                                                    <th style="width:60px;" class="text-center"><?php echo t('default'); ?></th>
                                                    <th style="width:30px;" class="text-center"><i class="fe fe-settings"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if(($data['prodType']=='configurableproduct' OR $data['prodType']=='downloadableproduct') AND $countattravailable>0){
                                                    
                                                    $numbattr = 1;
                                                    foreach( $productattribute as $keyattr => $valattr ){
                                                        $codeid = generate_code(8);

                                                        $nx = 1;
				                                        $countattr = count($valattr['attrval']);
                                                        $words = '';
                                                        $attridspattern = '';
                                                        foreach( $valattr['attrval'] as $attrdata ){
                                                            // get attribute
                                                            $attr_data = getval("attrId,attrLabel","attribute","attrId='{$attrdata['attrId']}'");

                                                            // get attribute value
                                                            $attrval_data = getval("attrvalId,attrvalVisual,attrvalValue,attrvalLabel","attribute_value","attrvalId='{$attrdata['attrvalId']}'");

                                                            $words .= $attr_data['attrLabel'] . ': ' . $attrval_data['attrvalLabel'] . (($countattr != $nx)? ', ':'');
                                                            $attridspattern .= $attr_data['attrId'].':'.$attrval_data['attrvalId'] . (($countattr != $nx)? '-':'');

                                                            $nx++;
                                                        }

                                                        echo '<tr id="row-'.$keyattr.'-'.$codeid.'" class="attrtrdata">';
                                                        echo '<td>';
                                                            echo $words;
                                                            echo '<input type="hidden" class="attrvaluedata" name="attributevalue['.$numbattr.']" value="'.$attridspattern.'" />';
                                                            echo '<input type="hidden" name="attributeId['.$numbattr.']" value="'.$valattr['pattrId'].'" />';
                                                        echo '</td>';

                                                        echo '
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">'.getCurrencySymbol().'</span>
                                                                </div>';
                                                            
                                                            $attr_price = explode('.', $valattr['pattrPrice']);
                                                            $attributeprice = $attr_price[0].( ($attr_price[1]=='00')?'':','.$attr_price[1] );

                                                            $attrprice = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)');
                                                            echo form_input('priceattr['.$numbattr.']', $attributeprice, $attrprice);
                                                            
                                                        echo '
                                                            </div>
                                                        </td>';
                                                        
                                                        echo '
                                                        <td>';
                                                            $valattr_pattrQty = $valattr['pattrQty'];
                                                            $qtysetting = array();
                                                            if($valattr['pattrQtyType'] == 'unlimited'){
                                                                $qtysetting = array(
                                                                    'disabled' => 'disabled',
                                                                );
                                                                $valattr_pattrQty = '';
                                                            }

                                                            $qtyattrexp = explode('.',$valattr_pattrQty);
                                                            if(isset($qtyattrexp[1])){
                                                                if($qtyattrexp[1]==00000000){ $valattr_pattrQty = $qtyattrexp[0]; }
                                                            }
                                                            
                                                            $valattr_pattrQty = singleComma($valattr_pattrQty, ".", ",");

                                                            $attrqty = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)', 'id'=>'qtyinputset-'.$keyattr.'-'.$codeid);
                                                            $attrqty = array_merge($attrqty,$qtysetting);
                                                            echo form_input('qtyattr['.$numbattr.']', $valattr_pattrQty, $attrqty);
                                                        echo '
                                                        </td>';

                                                        echo '
                                                        <td>';
                                                            $optqtytype = array('limited'=>t('limited'),'unlimited'=>t('unlimited'));
                                                            echo form_dropdown('qtytypeattr['.$numbattr.']', $optqtytype, $valattr['pattrQtyType'], array( 'class'=>'custom-select', 'id'=>'qtytypeset-'.$keyattr.'-'.$codeid ));
                                                        echo '
                                                        </td>';

                                                        echo '
                                                        <td>
                                                            <div class="input-group">';
                                                            $attr_weight = explode('.', $valattr['pattrWeight']);
                                                            $attributeweight = $attr_weight[0].( ($attr_weight[1]=='00000000')?'':','.$attr_weight[1] );

                                                            $attrweight = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)');
                                                            echo form_input('weightattr['.$numbattr.']', $attributeweight, $attrweight);
                                                        echo '
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">'.getWeightDefault().'</span>
                                                                </div>
                                                            </div>
                                                        </td>';

                                                        echo '
                                                        <td class="text-center">';
                                                            $defaultchecked = array();
                                                            if($valattr['pattrDefault'] == 'y'){
                                                                $defaultchecked = array('checked'=>'checked');
                                                            }
                                                            $defaultattrset = array('name'=>'defaultattr','value'=>$numbattr);
                                                            $defaultattr = array_merge($defaultattrset,$defaultchecked);
                                                            echo form_radio($defaultattr);
                                                        echo '
                                                        </td>';

                                                        echo '
                                                        <td>
                                                        <button class="btn btn-link" id="removeattr-'.$keyattr.'-'.$codeid.'" title="'.t('remove').': '.$words.'"><i class="fe fe-trash-2 text-red"></i></button>
                                                        <script type="text/javascript">
                                                        $( document ).ready(function() {
                                                            $("#removeattr-'.$keyattr.'-'.$codeid.'").tooltip();
                                                            $("#removeattr-'.$keyattr.'-'.$codeid.'").click(function() {
                                                                if( confirm("'.t('deleteconfirm').' ('.$words.')") ){

                                                                    if( $(\'.attrtrdata\').length < 2 ){
                                                                        // enable field in general tab
                                                                        $("#general-qty").removeAttr(\'disabled\');
                                                                        $("#general-qtytype").removeAttr(\'disabled\');
                                                                        $("#general-qtytype").removeAttr(\'disabled\');
                                                                    }

                                                                    $(this).tooltip(\'dispose\');
                                                                    $("#row-'.$keyattr.'-'.$codeid.'").remove();
                                                                }
                                                            });

                                                            $(\'#qtytypeset-'.$keyattr.'-'.$codeid.'\').on(\'change\', function(){
                                                                qtySet($(this),\'#qtyinputset-'.$keyattr.'-'.$codeid.'\');
                                                            });
                                                        });
                                                        </script>
                                                        </td>';

                                                        echo '</tr>';

                                                        $numbattr++;
                                                    }
                                                } else {
                                                ?>
                                                    <tr id="noitemattrinfo"><td colspan="<?php echo $attrval_colpan_table; ?>" class="text-center"><?php echo t('nodatafound');?></td></tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                        
                        <!--

                        Shipping Input Start Here

                        -->
                        <div class="tab-pane fade py-3" id="shipping" role="tabpanel" aria-labelledby="tab-shipping">
                            
                            <div class="row">
                                <div class="col-md-12"><h5><?php echo t('packagedimension'); ?></h5></div>
                                <div class="col-md-3">
                                <?php 
                                // length
                                $p_length = explode('.', $data['prodLength']);
                                $length = $p_length[0].( ($p_length[1]=='00')?'':','.$p_length[1] );

                                $widthinput1 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('length'),
                                        'name'=> 'length',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => $length,
                                        'input-group' => array(
                                            'append'=> empty($data['prodLengthUnit']) ? getLengthDefault():$data['prodLengthUnit'],
                                        ),
                                    )
                                );
                                $this->formcontrol->buildInputs($widthinput1);
                                ?>
                                </div>
                                <div class="col-md-3">
                                <?php 
                                // width
                                $p_width = explode('.', $data['prodWidth']);
                                $width = $p_width[0].( ($p_width[1]=='00')?'':','.$p_width[1] );

                                $widthinput2 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('width'),
                                        'name'=> 'width',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => $width,
                                        'input-group' => array(
                                            'append'=> empty($data['prodLengthUnit']) ? getLengthDefault():$data['prodLengthUnit'],
                                        ),
                                    )
                                );
                                $this->formcontrol->buildInputs($widthinput2);
                                ?>
                                </div>
                                <div class="col-md-3">
                                <?php 
                                // width
                                $p_height = explode('.', $data['prodHeight']);
                                $height = $p_height[0].( ($p_height[1]=='00')?'':','.$p_height[1] );

                                $widthinput2 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('height'),
                                        'name'=> 'height',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => $height,
                                        'input-group' => array(
                                            'append'=> empty($data['prodLengthUnit']) ? getLengthDefault():$data['prodLengthUnit'],
                                        ),
                                    )
                                );
                                $this->formcontrol->buildInputs($widthinput2);
                                ?>
                                </div>
                                <div class="col-md-3">
                                <?php 
                                // width
                                $p_weight = explode('.', $data['prodWeight']);
                                $weight = $p_weight[0].( ($p_weight[1]=='00')?'':','.$p_weight[1] );

                                $widthinput2 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('weight'),
                                        'name'=> 'weight',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => $weight,
                                        'input-group' => array(
                                            'append'=> (empty($data['prodWeightUnit'])) ? getWeightDefault():$data['prodWeightUnit'],
                                        ),
                                    )
                                );
                                $this->formcontrol->buildInputs($widthinput2);
                                ?>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-12"><h5><?php echo t('freeshipping'); ?></h5></div>
                                <div class="col-md-12">
                                <?php
                                $freeshippinginput = array(
                                    array(
                                        'type' => 'checkbox',
                                        'name' => 'freeshipping',
                                        'value' => 'y',
                                        'title' => t('yes'),
                                        'checked' => ($data['prodFreeShipping']=='y')?true:false
                                    ),
                                );

                                $this->formcontrol->buildInputs($freeshippinginput);
                                ?>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-12"><h5><?php echo t('availablecouriers'); ?></h5></div>
                                <div class="col-md-12">
                                    <?php 
                                    $c_x = 1;
                                    foreach( $courier as $cdata ){

                                        $courierdata = array(
                                            array(
                                                'type' => 'checkbox',
                                                'name' => 'courier['.$c_x.']',
                                                'value' => $cdata['courierId'],
                                                'title' => $cdata['courierName'],
                                                'id' => 'courier-'.$c_x,
                                                'checked' => (in_array($cdata['courierId'],$prodcourier)) ?true:false
                                            ),
                                        );
        
                                        $this->formcontrol->buildInputs($courierdata);

                                        $c_x++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <!--

                       Downloadable Product Start Here

                        -->
                        <div class="tab-pane fade py-4" id="downloadable" role="tabpanel" aria-labelledby="tab-downloadable">
                            <div class="row">
                                <div class="col-md-12 d-block mb-3">
                                    <button type="button" class="btn btn-rounded btn-light" id="adddownload"><i class="fe fe-plus mr-md-1"></i> <?php echo t('addlink'); ?></button>
                                    <script type="text/javascript">
                                    $( document ).ready(function() {
                                        $('#adddownload').click(function() {
                                            // Disable button
                                            $(this).attr('disabled','disabled');
                                            $(this).addClass('btn-disabled');

                                            if( $('tr#noitemattrinfo').length ){
                                                $('tr#noitemattrinfo').remove();
                                            }

                                            var code = generatedCode(8);
                                            
                                            $('.downloadfield tbody').append(
                                                '<tr id="rowdwl-'+code+'" class="attrtrdata">\
                                                    <td class="text-center">\
                                                        <input type="text" class="form-control" name="dwltitle['+code+']" />\
                                                    </td>\
                                                    <td class="text-center">\
                                                        <div class="input-group">\
                                                            <div class="input-group-prepend">\
                                                                <span class="input-group-text"><?php echo getCurrencySymbol(); ?></span>\
                                                            </div>\
                                                            <input type="text" class="form-control" name="dwlprice['+code+']" onkeypress="return isNumberComma(event)" />\
                                                        </div>\
                                                    </td>\
                                                    <td class="text-center">\
                                                        <select name="dwltype['+code+']" id="dwltype-'+code+'" class="custom-select form-control mb-1">\
                                                            <option value="file"><?php echo t('file'); ?></option>\
                                                            <option value="url">URL</option>\
                                                        </select>\
                                                        <div class="filetype'+code+' text-left">\
                                                            <div class="custom-file">\
                                                                <input type="file" class="custom-file-input" name="dwlfile['+code+']">\
                                                                <label class="custom-file-label" for="customFile">Choose file</label>\
                                                            </div>\
                                                        </div>\
                                                        <div class="urltype'+code+'" style="display:none;">\
                                                            <input type="text" placeholder="URL" class="form-control" name="dwlurl['+code+']" />\
                                                        </div>\
                                                        <scri'+'pt type="text/javascript">\
                                                        \$( document ).ready(function() {\
                                                            \$(\'#dwltype-'+code+'\').change(function() {\
                                                                var valtype = $(this).val();\
                                                                if(valtype == \'file\'){\
                                                                    \$(\'.filetype'+code+'\').show();\
                                                                    \$(\'.urltype'+code+'\').hide();\
                                                                } else {\
                                                                    \$(\'.filetype'+code+'\').hide();\
                                                                    \$(\'.urltype'+code+'\').show();\
                                                                }\
                                                            });\
                                                        });\
                                                        </scr'+'ipt>\
                                                    </td>\
                                                    <td class="text-center">\
                                                        <select name="dwlsample['+code+']" id="dwlsample-'+code+'" class="custom-select form-control mb-1">\
                                                            <option value="file"><?php echo t('file'); ?></option>\
                                                            <option value="url">URL</option>\
                                                        </select>\
                                                        <div class="filesample'+code+' text-left">\
                                                            <div class="custom-file">\
                                                                <input type="file" class="custom-file-input" name="dwlfilesample['+code+']">\
                                                                <label class="custom-file-label" for="customFile">Choose file</label>\
                                                            </div>\
                                                        </div>\
                                                        <div class="urlsample'+code+'" style="display:none;">\
                                                            <input type="text" placeholder="URL" class="form-control" name="dwlurlsample['+code+']" />\
                                                        </div>\
                                                        <scri'+'pt type="text/javascript">\
                                                        \$( document ).ready(function() {\
                                                            \$(\'#dwlsample-'+code+'\').change(function() {\
                                                                var valtypesample = $(this).val();\
                                                                if(valtypesample == \'file\'){\
                                                                    \$(\'.filesample'+code+'\').show();\
                                                                    \$(\'.urlsample'+code+'\').hide();\
                                                                } else {\
                                                                    \$(\'.filesample'+code+'\').hide();\
                                                                    \$(\'.urlsample'+code+'\').show();\
                                                                }\
                                                            });\
                                                        });\
                                                        </scr'+'ipt>\
                                                    </td>\
                                                    <td class="text-center">\
                                                        <input type="text" class="form-control mb-2" id="dwlmaxdownld-'+code+'" name="dwlmaxdownld['+code+']" onkeypress="return isNumberKey(event)" />\
                                                        <div class="custom-control custom-checkbox">\
                                                            <input type="checkbox" name="unlimited['+code+']" value="y" class="custom-control-input" id="unlimtd'+code+'" />\
                                                            <label class="custom-control-label" for="unlimtd'+code+'"><?php echo t('unlimited'); ?></label>\
                                                        </div>\
                                                    </td>\
                                                    <td class="text-center">\
                                                        <button class="btn btn-link" id="removedwld-'+code+'" title="<?php echo t('remove'); ?>"><i class="fe fe-trash-2 text-red"></i></button>\
                                                        <scri'+'pt type="text/javascript">\
                                                        \$( document ).ready(function() {\
                                                            \$("#removedwld-'+code+'").tooltip();\
                                                            \$("#removedwld-'+code+'").click(function() {\
                                                                \$(this).tooltip(\'dispose\');\
                                                                \$("#rowdwl-'+code+'").remove();\
                                                            });\
                                                            \
                                                            \$(\'input.custom-file-input\').change(function(e){\
                                                                var fileName = e.target.files[0].name;\
                                                                \$(this).next(\'.custom-file-label\').html(fileName);\
                                                            });\
                                                            \
                                                            $(\'#unlimtd'+code+':checkbox\').change(function() {\
                                                                if (this.checked) {\
                                                                    \$(\'#dwlmaxdownld-'+code+'\').attr(\'disabled\', true);\
                                                                } else {\
                                                                    \$(\'#dwlmaxdownld-'+code+'\').removeAttr(\'disabled\');\
                                                                }\
                                                            });\
                                                        });\
                                                        </scr'+'ipt>\
                                                    </td>\
                                                </tr>'
                                            );

                                            $('#adddownload').removeAttr('disabled');
                                            $('#adddownload').removeClass('btn-disabled');
                                        });
                                    });
                                    </script>
                                </div>

                                <div class="col-md-12">
                                    
                                    <div class="table-responsive-md">
                                        <table class="table table-hover table-striped downloadfield">
                                            <thead>
                                                <tr>
                                                    <th style="width:140px;" class="text-center"><?php echo t('title'); ?> <span class="text-red">*</span></th>
                                                    <th style="width:160px;" class="text-center"><?php echo t('price'); ?></th>
                                                    <th style="width:150px;" class="text-center"><?php echo t('file'); ?> <span class="text-red">*</span></th>
                                                    <th style="width:150px;" class="text-center"><?php echo t('sample'); ?></th>
                                                    <th style="width:100px;" class="text-center"><?php echo t('maxdownloads'); ?></th>
                                                    <th style="width:30px;" class="text-center"><i class="fe fe-settings"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $countdownloadable = count($downloadable);

                                                if($countdownloadable > 0 AND $data['prodType']=='downloadableproduct'){

                                                    foreach($downloadable as $file){
                                                        $gencode = generate_code(8);

                                                        // price                                                        
                                                        $dwl_price = explode('.', $file['pdwlPrice']);
                                                        $capitalprice = $dwl_price[0].( ($dwl_price[1]=='00')?'':','.$dwl_price[1] );

                                                        echo '
                                                        <tr id="rowdwl-'.$gencode.'" class="attrtrdata">
                                                            <td class="text-center">
                                                                <input type="hidden" value="'.$file['pdwlId'].'" name="dwlid['.$gencode.']" />
                                                                <input type="text" value="'.$file['pdwlTitle'].'" class="form-control" name="dwltitle['.$gencode.']" />
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">'.getCurrencySymbol().'</span>
                                                                    </div>
                                                                    <input type="text" value="'.$capitalprice.'" class="form-control" name="dwlprice['.$gencode.']" onkeypress="return isNumberComma(event)" />
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <select name="dwltype['.$gencode.']" id="dwltype-'.$gencode.'" class="custom-select form-control mb-1">
                                                                    <option value="file"'.(($file['pdwlDownloadType']=='file')?' selected="selected"':'').'>'.t('file').'</option>
                                                                    <option value="url"'.(($file['pdwlDownloadType']=='url')?' selected="selected"':'').'>URL</option>
                                                                </select>
                                                                <div class="filetype'.$gencode.' text-left"'.(($file['pdwlDownloadType']!='file')?' style="display:none;"':'').'>';
                                                                    if(!empty($file['pdwlFileDir']) AND !empty($file['pdwlFile'])){
                                                                        echo '<div class="d-block mt-1 mb-2">
                                                                        <a href="'.admin_url( $this->uri->segment(2) . '/download/file/?id='.$file['pdwlId']).'" class="btn btn-success btn-sm btn-block"><i class="fe fe-download"></i> '.t('download').'</a>
                                                                        </div>';
                                                                    }
                                                                    echo '
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" name="dwlfile['.$gencode.']">
                                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="urltype'.$gencode.'"'.(($file['pdwlDownloadType']!='url')?' style="display:none;"':'').'>';
                                                                    if(!empty($file['pdwlURL'])){
                                                                        echo '<div class="d-block mt-1 mb-2">
                                                                        <a href="'.$file['pdwlURL'].'" target="_blank" class="btn btn-success btn-sm btn-block"><i class="fe fe-download"></i> '.t('download').'</a>
                                                                        </div>';
                                                                    }
                                                                    echo '
                                                                    <input type="text" value="'.$file['pdwlURL'].'" placeholder="URL" class="form-control" name="dwlurl['.$gencode.']" />
                                                                </div>
                                                                <script type="text/javascript">
                                                                $( document ).ready(function() {
                                                                    $(\'#dwltype-'.$gencode.'\').change(function() {
                                                                        var valtype = $(this).val();
                                                                        if(valtype == \'file\'){
                                                                            $(\'.filetype'.$gencode.'\').show();
                                                                            $(\'.urltype'.$gencode.'\').hide();
                                                                        } else {
                                                                            $(\'.filetype'.$gencode.'\').hide();
                                                                            $(\'.urltype'.$gencode.'\').show();
                                                                        }
                                                                    });
                                                                });
                                                                </script>
                                                            </td>
                                                            <td class="text-center">
                                                                <select name="dwlsample['.$gencode.']" id="dwlsample-'.$gencode.'" class="custom-select form-control mb-1">
                                                                    <option value="file"'.(($file['pdwlSampleType']=='file')?' selected="selected"':'').'>'.t('file').'</option>
                                                                    <option value="url"'.(($file['pdwlSampleType']=='url')?' selected="selected"':'').'>URL</option>
                                                                </select>
                                                                <div class="filesample'.$gencode.' text-left"'.(($file['pdwlSampleType']!='file')?' style="display:none;"':'').'>';
                                                                    if(!empty($file['pdwlSampleDir']) AND !empty($file['pdwlSampleFile'])){
                                                                        echo '<div class="d-block mt-1 mb-2">
                                                                        <a href="'.admin_url( $this->uri->segment(2) . '/download/sample/?id='.$file['pdwlId']).'" class="btn btn-success btn-sm btn-block"><i class="fe fe-download"></i> '.t('download').'</a>
                                                                        </div>';
                                                                    }
                                                                    echo '                                                                    
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" name="dwlfilesample['.$gencode.']">
                                                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="urlsample'.$gencode.'"'.(($file['pdwlSampleType']!='url')?' style="display:none;"':'').'>';
                                                                    if(!empty($file['pdwlSampleURL'])){
                                                                        echo '<div class="d-block mt-1 mb-2">
                                                                        <a href="'.$file['pdwlSampleURL'].'" target="_blank" class="btn btn-success btn-sm btn-block"><i class="fe fe-download"></i> '.t('download').'</a>
                                                                        </div>';
                                                                    }
                                                                    echo '
                                                                    <input type="text" value="'.$file['pdwlSampleURL'].'" placeholder="URL" class="form-control" name="dwlurlsample['.$gencode.']" />
                                                                </div>
                                                                <script type="text/javascript">
                                                                $( document ).ready(function() {
                                                                    $(\'#dwlsample-'.$gencode.'\').change(function() {
                                                                        var valtypesample = $(this).val();
                                                                        if(valtypesample == \'file\'){
                                                                            $(\'.filesample'.$gencode.'\').show();
                                                                            $(\'.urlsample'.$gencode.'\').hide();
                                                                        } else {
                                                                            $(\'.filesample'.$gencode.'\').hide();
                                                                            $(\'.urlsample'.$gencode.'\').show();
                                                                        }
                                                                    });
                                                                });
                                                                </script>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="text" value="'.(($file['pdwlMaxDownloadType']!='unlimited')? $file['pdwlMaxDownload']:'').'" class="form-control mb-2" id="dwlmaxdownld-'.$gencode.'"'.(($file['pdwlMaxDownloadType']=='unlimited')? ' disabled="disabled"':'').' name="dwlmaxdownld['.$gencode.']" onkeypress="return isNumberKey(event)" />
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" name="unlimited['.$gencode.']" value="y" class="custom-control-input" id="unlimtd'.$gencode.'"'.(($file['pdwlMaxDownloadType']=='unlimited')? ' checked="checked"':'').' />
                                                                    <label class="custom-control-label" for="unlimtd'.$gencode.'">'.t('unlimited').'</label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-link" id="removedwld-'.$gencode.'" title="'.t('remove').'"><i class="fe fe-trash-2 text-red"></i></button>
                                                                <script type="text/javascript">
                                                                $( document ).ready(function() {
                                                                    $("#removedwld-'.$gencode.'").tooltip();
                                                                    $("#removedwld-'.$gencode.'").click(function() {
                                                                        $(this).tooltip(\'dispose\');
                                                                        $("#rowdwl-'.$gencode.'").remove();
                                                                    });
                                                                    
                                                                    $(\'input.custom-file-input\').change(function(e){
                                                                        var fileName = e.target.files[0].name;
                                                                        $(this).next(\'.custom-file-label\').html(fileName);
                                                                    });
                                                                    
                                                                    $(\'#unlimtd'.$gencode.':checkbox\').change(function() {
                                                                        if (this.checked) {
                                                                            $(\'#dwlmaxdownld-'.$gencode.'\').attr(\'disabled\', true);
                                                                        } else {
                                                                            $(\'#dwlmaxdownld-'.$gencode.'\').removeAttr(\'disabled\');
                                                                        }
                                                                    });
                                                                });
                                                                </script>
                                                            </td>
                                                        </tr>
                                                        ';
                                                    }

                                                } else {
                                                    echo '<tr id="noitemattrinfo"><td colspan="6" class="text-center">'.t('nodatafound').'</td></tr>';
                                                }                                                    
                                                ?>                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                                                
                        <!--

                        SEO Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="seo" role="tabpanel" aria-labelledby="tab-seo">
                        <?php
                        $dataseo = getSeoPage($data['prodId'],'product');
                        $exprobot = explode(",", $dataseo['seoRobots']);
                
                        $robotseo_0 = empty($exprobot[0]) ? '' : $exprobot[0];
                        $robotseo_1 = empty($exprobot[1]) ? '' : $exprobot[1];
                        ?>
                        <div class="row">
                                <div class="col-md-12">
                                    <h5><span class="heading_text"><?php echo t('optimizationtitle'); ?> (SEO)</span></h5>
                                    <hr/>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <span class="text-muted">
                                    <?php echo t('infooptimization'); ?>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $seoinput1 = array(
                                        array(
                                            'type' => 'text',
                                            'label' => t('title'),
                                            'name' => 'seo_judul',
                                            'value'=> $dataseo['seoTitle']
                                        ),
                                        array(
                                            'type' => 'textarea',
                                            'label' => t('description'),
                                            'name' => 'seo_deskripsi',
                                            'cols' => '30',
                                            'rows' => '4',
                                            'help' => t('infodescseo'),
                                            'value'=> $dataseo['seoDesc']
                                        ),
                                    );
    
                                    $this->formcontrol->buildInputs($seoinput1);
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $seoinput2 = array(
                                        array(
                                            'type' => 'text',
                                            'label' => t('keyword'),
                                            'name' => 'kw',
                                            'help' => t('infokeyword'),
                                            'value'=> $dataseo['seoKeyword']
                                        ),
                                        array(
                                            'type' => 'checkbox',
                                            'title' => 'Robot Meta NOINDEX',
                                            'name' => 'noindex',
                                            'value' => 'noindex',
                                            'help' => t('infonoindex'),
                                            'checked' => ($robotseo_0=='noindex' OR $robotseo_1=='noindex')?true:false
                                        ),
                                        array(
                                            'type' => 'checkbox',
                                            'title' => 'Robot Meta NOFOLLOW',
                                            'name' => 'nofollow',
                                            'value' => 'nofollow',
                                            'help' => t('infonofollow'),
                                            'checked' => ($robotseo_0=='nofollow' OR $robotseo_1=='nofollow')?true:false
                                        ),
                                    );
    
                                    $this->formcontrol->buildInputs($seoinput2);
                                    ?>
                                </div>
                            </div>
                        
                        </div>

                    </div>
                    <!-- END .tab-content  -->
                    
                </div>
                <!-- END .card-body  -->

                <div class="card-footer">
                    <button class="btn btn-primary float-right" type="submit"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
                    <div class="clearfix"></div>
                </div>

            </div>
            <!-- END .nav-border-bottom -->
        
        </div>
        <!-- END .card -->

    </div>
    <!-- END .col-12 -->
</div>
<!-- END .row -->
<?php 
    
    echo form_close();
    
}
include V_ADMIN_PATH . "footer.php";
