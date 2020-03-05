<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
Register style (CSS)
************************************/
$request_css_files = array(
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
Register Script (JavaScript)
*******************************************/
$request_script_files = array(
);
$request_script = "";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
if( is_add() ){
?>
<div class="row">
    <div class="col-12">

        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-bold">
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

        
        <div class="tab-content">

            <div class="tab-pane fade py-4 active show" id="general" role="tabpanel" aria-labelledby="general-tab">
            general
            </div>

            <div class="tab-pane fade py-4" id="linked" role="tabpanel" aria-labelledby="linked-tab">
            linked
            </div>
            
            <div class="tab-pane fade py-4" id="image" role="tabpanel" aria-labelledby="image-tab">
            image
            </div>
            
            <div class="tab-pane fade py-4" id="data" role="tabpanel" aria-labelledby="data-tab">
            data
            </div>
            
            <div class="tab-pane fade py-4" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
            attribute
            </div>
            
            <div class="tab-pane fade py-4" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
            shipping
            </div>
            
            <div class="tab-pane fade py-4" id="seo" role="tabpanel" aria-labelledby="seo-tab">
            seo
            </div>

        </div>

    </div>
</div>
<?php 
}
include V_ADMIN_PATH . "footer.php";
