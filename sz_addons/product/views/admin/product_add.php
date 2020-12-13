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
            url: '".admin_url($this->uri->segment(2)."/ajax/ajax_related_getallproduct/")."',
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
            url: '".admin_url($this->uri->segment(2)."/ajax/ajax_related_product/")."',
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
                url: '".admin_url($this->uri->segment(2)."/ajax/ajax_generate_attrvalue/")."',
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
echo form_open_multipart( admin_url( $this->uri->segment(2) . '/addingprocess'), array( 'id'=> 'valid' ) );
?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="row"><div class="col-md-5 ml-auto ml-2">
            <div class="form-group row mb-0">
                <label class="col-md-4 col-form-label" for="producttype"><?php echo t('producttype'); ?>: </label>
                <div class="col-md-8">
                    <select name="producttype" id="producttypechoice" class="select2 producttype">
                        <option value="simpleproduct" selected="selected"><?php echo t('simpleproduct'); ?></option>
                        <option value="configurableproduct"><?php echo t('configurableproduct'); ?></option>
                        <option value="downloadableproduct"><?php echo t('downloadableproduct'); ?></option>
                        <option value="servicesproduct"><?php echo t('servicesproduct'); ?></option>
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
                        <li class="nav-item" id="listtab-attribute" style="display:none;">
                            <a class="nav-link" id="tab-attribute" data-toggle="tab" href="#attribute" role="tab" aria-controls="attribute" aria-selected="false"><?php echo t('attribute'); ?></a>
                        </li>
                        <li class="nav-item" id="listtab-shipping">
                            <a class="nav-link" id="tab-shipping" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false"><?php echo t('shipping'); ?></a>
                        </li>
                        <li class="nav-item" id="listtab-downloadable" style="display:none;">
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
                                        $rulesdata[$key]['checked'] = ( $key == '1' ) ? true:false;
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
                                        ),
                                        array(
                                            'type' => 'multilanguage_texteditor',
                                            'texteditor' => 'standard',
                                            'label' => '<h4 class="d-inline-block">'.t('description').':</h4>',
                                            'name' => 'desc',
                                        ),
                                        array(
                                            'type' => 'text',
                                            'label'=> '<h4 class="d-inline-block">'.t('youtubevideo').':</h4>',
                                            'name'=> 'urlyoutube',
                                            'help' => t('infoyoutubereq'),
                                            'input-group' => array(
                                                'prepend'=> '<span class="input-group-text"><i class="fa fa-youtube-play mr-1"></i> YouTube</span>',
                                            )
                                        ),
                                        array(
                                            'type' => 'multilanguage_texteditor',
                                            'texteditor' => 'verysimple',
                                            'label' => '<h4 class="d-inline-block">'.t('note').':</h4>',
                                            'name' => 'note',
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
                                                    'checked' => true
                                                ),
                                                array(
                                                    'type' => 'checkbox',
                                                    'name'=> 'allowreviews',
                                                    'value' => 'y',
                                                    'title'=> t('allowreviews'),
                                                    'checked' => true
                                                ),
                                                array(
                                                    'type' => 'checkbox',
                                                    'name'=> 'featured',
                                                    'value' => 'y',
                                                    'title'=> t('featured')
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
                                                $builddataform4 = array(
                                                    array(
                                                        'type' => 'text',
                                                        'name'=> 'qty',
                                                        'id' => 'general-qty',
                                                        'label'=> t('quantity'),
                                                    ),
                                                    array(
                                                        'type' => 'select',
                                                        'label'=> t('qtytype'),
                                                        'name'=> 'qty-type',
                                                        'id' => 'general-qtytype',
                                                        'class' => 'select2',
                                                        'option'=> array('limited'=>t('limited'),'unlimited'=>t('unlimited')),
                                                    ),
                                                    
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
                                                        )
                                                    ),
                                                    array(
                                                        'type'=>'text',
                                                        'label'=> t('normalprice').' <span class="text-danger">*</span>',
                                                        'name'=> 'normalprice',
                                                        'id' => 'nprice',
                                                        'class' => 'input_price_field input_special_price',
                                                        'onkeypress'=>'return isNumberComma(event)',
                                                        'input-group' => array(
                                                            'prepend'=> getCurrencySymbol(),
                                                        ),
                                                        'extra' => '
                                                        <small class="form-text text-muted" id="hasil_selisih">
                                                        '.t('differencefromcapitalprice').': 0%
                                                        </small>
                                                        '
                                                    ),
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
                                                        '
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
                                                        'option' => $taxes
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
                                    'info' => t('abbr_sku')
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> 'UPC',
                                    'name'=> 'upc',
                                    'info' => t('abbr_upc')
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> 'ISBN',
                                    'name'=> 'isbn',
                                    'info' => t('abbr_isbn')
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> 'MPN',
                                    'name'=> 'mpn',
                                    'info' => t('abbr_mpn')
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
                                            'checked' => true   
                                        ),
                                        array(
                                            'value'=>'n',
                                            'title' => t('no'),
                                            'checked' => false   
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
                                    'info' => t('infomaximumorderfiled')
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> t('minimumorder'),
                                    'name'=> 'minorder',
                                    'placeholder'=> 'Min',
                                    'onkeypress'=> 'return isNumberKey(event)',
                                    'value' => '1'
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
                            $buildlinkedform = array(
                                array(
                                    'type' => 'multipleselect',
                                    'label'=> t('categories'),
                                    'name'=> 'categories[]',
                                    'class' => 'select2',
                                    'option'=> $categories,
                                    'required' => true,
                                ),
                                array(
                                    'type' => 'select',
                                    'label'=> t('manufacturers'),
                                    'name'=> 'manufacturers',
                                    'class' => 'select2',
                                    'option'=> $manufacturers,
                                ),
                                array(
                                    'type' => 'select',
                                    'label'=> t('badges'),
                                    'name'=> 'badges',
                                    'class' => 'select2',
                                    'option'=> $badges,
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
                                        <div id="relatedlist"></div>
                                        <ul class="list-unstyled" id="relatedresult" style="height:100px;overflow-y:auto;">
                                            <li class="chooseinforelated">'.t('chooseproduct').'</li>
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
                                                <input type="file" name="imgprod[1]">
                                            </td>
                                            <td>
                                                <div>
                                                    <label><input type="radio" name="primary" value="1" checked>
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
                                    var identify = idrow+1;

                                    var x=document.getElementById('dynamic-image').insertRow(idrow);
                                    var td1=x.insertCell(0);
                                    var td2=x.insertCell(1);
                                    td1.innerHTML="<input type=\"file\" name=\"imgprod["+identify+"]\">";
                                    td2.innerHTML="<div><label><input type=\"radio\" name=\"primary\" value=\""+identify+"\"> <?php echo t('primaryimg'); ?></label></div>";
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
                                                <tr id="noitemattrinfo"><td colspan="<?php echo $attrval_colpan_table; ?>" class="text-center"><?php echo t('nodatafound');?></td></tr>
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
                                $widthinput1 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('length'),
                                        'name'=> 'length',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => 0,
                                        'input-group' => array(
                                            'append'=> getLengthDefault(),
                                        ),
                                    )
                                );
                                $this->formcontrol->buildInputs($widthinput1);
                                ?>
                                </div>
                                <div class="col-md-3">
                                <?php 
                                $widthinput2 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('width'),
                                        'name'=> 'width',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => 0,
                                        'input-group' => array(
                                            'append'=> getLengthDefault(),
                                        ),
                                    )
                                );
                                $this->formcontrol->buildInputs($widthinput2);
                                ?>
                                </div>
                                <div class="col-md-3">
                                <?php 
                                $widthinput2 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('height'),
                                        'name'=> 'height',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => 0,
                                        'input-group' => array(
                                            'append'=> getLengthDefault(),
                                        ),
                                    )
                                );
                                $this->formcontrol->buildInputs($widthinput2);
                                ?>
                                </div>
                                <div class="col-md-3">
                                <?php 
                                $widthinput2 = array(
                                    array(
                                        'type' => 'text',
                                        'label'=> t('weight'),
                                        'name'=> 'weight',
                                        'onkeypress'=>'return isNumberComma(event)',
                                        'value' => 0,
                                        'input-group' => array(
                                            'append'=> getWeightDefault(),
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
                                        'checked' => false
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
                                                'checked' => false
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
                                                <tr id="noitemattrinfo"><td colspan="6" class="text-center"><?php echo t('nodatafound');?></td></tr>
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
                                        ),
                                        array(
                                            'type' => 'textarea',
                                            'label' => t('description'),
                                            'name' => 'seo_deskripsi',
                                            'cols' => '30',
                                            'rows' => '4',
                                            'help' => t('infodescseo'),
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
                                            'help' => t('infokeyword')
                                        ),
                                        array(
                                            'type' => 'checkbox',
                                            'title' => 'Robot Meta NOINDEX',
                                            'name' => 'noindex',
                                            'value' => 'noindex',
                                            'help' => t('infonoindex'),
                                        ),
                                        array(
                                            'type' => 'checkbox',
                                            'title' => 'Robot Meta NOFOLLOW',
                                            'name' => 'nofollow',
                                            'value' => 'nofollow',
                                            'help' => t('infonofollow'),
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
                    <button class="btn btn-primary float-right" type="submit"><i class="fe fe-plus"></i> <?php echo t('btnaddproduct'); ?></button>
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
