<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
    'vendors/parsley/parsley.config.js',
    'vendors/parsley/parsley.min.js',
    'vendors/select2/dist/js/select2.full.min.js'
);
$request_script = "
$( document ).ready(function() {
    $('#valid').parsley();
    $('.select2').select2();

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
            },
            beforeSend: function(data){
                $('.chooseinforelated').remove();
                $('#relatedresult').prepend('<li class=\"loadajaxresult\"><img src=\"".web_assets('img/loader/loading.gif')."\" alt=\"loader\"></li>');
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
                    $('ul#relatedresult').prepend('Data tidak dapat dimuat');
                }
            }
        });

    });
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
if( is_add() ){

    echo form_open_multipart( admin_url( $this->uri->segment(2) . '/addingprocess'), array( 'id'=> 'valid' ) );
?>
<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="tab nav-border-bottom">

                <div class="card-header card-header-flex">

                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-bold nav-tabs-noborder nav-tabs-stretched">
                        <li class="nav-item">
                            <a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php echo t('general'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="linked-tab" data-toggle="tab" href="#linked" role="tab" aria-controls="linked" aria-selected="false"><?php echo t('linked'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="image-tab" data-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false"><?php echo t('image'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false"><?php echo t('data'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="attribute-tab" data-toggle="tab" href="#attribute" role="tab" aria-controls="attribute" aria-selected="false"><?php echo t('attribute'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false"><?php echo t('shipping'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO</a>
                        </li>
                    </ul>

                </div>
                
                <div class="card-body">
                
                    <div class="tab-content">
                        <?php 
                        // setting layout
                        $col_layout = array('label'=>'col-md-2', 'input'=>'col-md-10');
                        $layout_model = 'horizontal';
                        ?>
                        <!--

                        General Input Start Here

                        -->
                        <div class="tab-pane fade py-4 active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <?php
                            // get rules data for checkbox
                            $rulesdata = array();
                            foreach(productRules(TRUE) AS $key => $val){
                                $rulesdata[$key]['title'] = '<strong>'.$val['type'] . '</strong> - '.$val['description'];
                                $rulesdata[$key]['value'] = $key;
                                $rulesdata[$key]['checked'] = ( $key == '1' ) ? true:false;
                            }

                            $buildgeneralform = array(
                                array(
                                    'type' => 'radio',
                                    'label'=> t('productrules'),
                                    'name'=> 'rules',
                                    'value'=> $rulesdata,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'label' => t('published'),
                                    'name' => 'publis',
                                    'value' => 'y',
                                    'title' => t('yes'),
                                    'checked' => true
                                ),
                                array(
                                    'type' => 'multilanguage_text',
                                    'label' => t('productname'),
                                    'name' => 'productname',
                                    'required' => true,
                                ),
                                array(
                                    'type' => 'multilanguage_texteditor',
                                    'texteditor' => 'standard',
                                    'label' => t('description'),
                                    'name' => 'desc',
                                    'required' => true,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'label'=> t('allowreviews'),
                                    'name'=> 'allowreviews',
                                    'value' => 'y',
                                    'title'=> t('yes'),
                                    'checked' => true
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'label'=> t('featured'),
                                    'name'=> 'featured',
                                    'value' => 'y',
                                    'title'=> t('yes')
                                ),
                                array(
                                    'type' => 'text',
                                    'label'=> t('youtubevideo'),
                                    'name'=> 'urlyoutube',
                                    'help' => t('infoyoutubereq')
                                ),
                                array(
                                    'type' => 'multilanguage_texteditor',
                                    'texteditor' => 'verysimple',
                                    'label' => t('note'),
                                    'name' => 'note',
                                ),
                            );
                            $this->formcontrol->buildInputs($buildgeneralform, $layout_model, $col_layout);
                            ?>                        
                        </div>

                        <!--

                        Linked Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="linked" role="tabpanel" aria-labelledby="linked-tab">
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
                                    'label'=> t('relatedproducts'),
                                    'option'=> array(""=>'-- '.t('chooseproduct').' --'),
                                    'name'=>'relatedproduct',
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
                        <div class="tab-pane fade py-4" id="image" role="tabpanel" aria-labelledby="image-tab">
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
                                                <input type="file" name="imgprod[0]">
                                            </td>
                                            <td>
                                                <div>
                                                    <label><input type="radio" name="primary" value="0" checked>
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
                                    var x=document.getElementById('dynamic-image').insertRow(idrow);
                                    var td1=x.insertCell(0);
                                    var td2=x.insertCell(1);
                                    td1.innerHTML="<input type=\"file\" name=\"imgprod["+idrow+"]\">";
                                    td2.innerHTML="<div><label><input type=\"radio\" name=\"primary\" value=\""+idrow+"\"> <?php echo t('primaryimg'); ?></label></div>";
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

                        Data Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="data" role="tabpanel" aria-labelledby="data-tab">
                        <?php                            
                            $builddataform = array(
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
                            );
                            $this->formcontrol->buildInputs($builddataform, $layout_model, $col_layout);
                        ?>
                        </div>
                        
                        <!--

                        Attributes Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
                        attribute
                        </div>
                        
                        <!--

                        Shipping Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                        shipping
                        </div>
                        
                        <!--

                        SEO Input Start Here

                        -->
                        <div class="tab-pane fade py-4" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        seo
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
