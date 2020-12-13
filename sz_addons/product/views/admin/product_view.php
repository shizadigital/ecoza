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

if( is_view() ):
?>
<div class="row">
    <div class="col-12">
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

        <div class="card card-statistics">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-8">
                                <div class="mt-xxs-0 btn-group btn-group-toggle">
                                    <?php 
                                    $countdtproddraft = countdata("product","prodDisplay='n' AND prodDeleted='0'");

                                    if(empty($this->input->get('prodDisplay'))){
                                        echo '
                                        <label class="btn btn-sm btn-round btn-primary">
                                            '.t('all').'
                                        </label>
                                        <a href="'.admin_url($this->uri->segment(2).'/?prodDisplay=draft').'" class="btn btn-sm btn-outline-primary btn-round">
                                            '.t('draft').' ('.$countdtproddraft.')
                                        </a>';
                                    } else {
                                        echo '
                                        <a href="'.admin_url($this->uri->segment(2)).'" class="btn btn-sm btn-outline-primary btn-round">
                                            '.t('all').'
                                        </a>
                                        <label class="btn btn-sm btn-round btn-primary">
                                            '.t('draft').' ('.$countdtproddraft.')
                                        </label>
                                        ';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php echo form_open( admin_url( $this->uri->segment(2).'/' ), array( 'method'=>'get' ) ); ?>
                                <div class="input-group float-right">
                                    <input type="text" class="form-control form-control-sm" name="kw" value="<?php if(!empty($this->input->get('kw'))){ echo $this->input->get('kw'); } ?>" placeholder="<?php echo t('search'); ?> . . ."/>
                                    <div class="input-group-append">
                                    <button class="btn btn-light btn-sm" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">               

                <?php echo form_open( admin_url( $this->uri->segment(2).'/bulk_action' ), array( 'id'=>'valid', 'class'=>'form_bulk' ) ); ?>
                <div class="row">
                    <div class="col-md-6 form-inline">
                        <?php if( is_delete() ){ ?>
                        <div class="input-group">
                            <select name="bulktype" class="form-control form-control-sm custom-select" required>
                                <option value="">-- <?php echo t('bulkaction'); ?> --</option>
                                <option value="bulk_delete"><?php echo t('delete'); ?></option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-light btn-sm submit_bulk" type="button"><i class="fa fa-cog"></i></button>
                            </div>
                        </div>
                        <script type="text/javascript">
                        $(document).ready(function(){

                            $(".submit_bulk").click( function(){
                                var bulktype = $( "select[name=bulktype]" ).val();

                                if(bulktype=='bulk_delete'){
                                    var apply = confirm("<?php echo t('confirmbulkactiondelete'); ?>");
                                    if(apply == true){
                                        $('.form_bulk').submit();
                                    }
                                } else {
                                    $('.form_bulk').submit();
                                }
                            });
                            
                            //Check all view
                            $("#check_all").click(function(){
                                if ( (this).checked == true ){
                                   $('.check_item').prop('checked', true);
                                } else {
                                   $('.check_item').prop('checked', false);
                                }
                            });

                        });
                        </script>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <?php 
                        echo "<div class=\"float-right\" style=\"margin-top:5px;font-style:italic;\">".t('total')." $totaldata</div>";
                        ?>
                    </div>

                    <div class="col-md-12 py-3 table-responsive-md">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <?php if( is_delete() ){ ?>
                                    <th style="width:25px;" class="text-center">
                                        <input type="checkbox" id="check_all" />
                                    </th>
                                    <?php } ?>
                                    <th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
                                    <th style="width:120px;" class="text-center"><?php echo t('images'); ?></th>
                                    <th style="min-width:125px;"><?php echo t('name'); ?></th>
                                    <th style="width:110px;" class="text-center"><?php echo t('qty'); ?></th>
                                    <th style="width:130px;" class="text-center"><?php echo t('capitalprice'); ?></th>
                                    <th style="width:130px;" class="text-center"><?php echo t('price'); ?></th>
                                    <th style="width:80px;" class="text-center"><?php echo t('status'); ?></th>
                                    <th style="width:100px;" class="text-center"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if( $totaldata > 0 ){
                                    $no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
                                    foreach( $data AS $keydata => $r ){
                                        // define some variable
                                        $attrcounting = countdata('product_attribute',"prodId='{$r['prodId']}'");
                                        //Get Primary Image Product
                                        $imgprod = getval("pimgDir,pimgImg","product_images","prodId='{$r['prodId']}' AND pimgPrimary='y'");

                                        $prodName = t( array('table'=>'product','field'=>'prodName', 'id'=>$r['prodId']) );

                                        // get qty
                                        $qty = $r['prodQty'];
                                        $limitedinfo = $r['prodQtyType'];
                                        if($r['prodType']=='configurableproduct') {
                                            if( $attrcounting > 0){
                                                $getsum = getval('SUM(pattrQty) AS SUMqty',"product_attribute","prodId='{$r['prodId']}'");
                                                $qty = $getsum;
                                                if(countdata("product_attribute","prodId='{$r['prodId']}' AND pattrQtyType='unlimited'")>0){
                                                    $limitedinfo = '<small><span class="text-info">'.t('limitedattrinfo').'</span></small>';
                                                } else {
                                                    $limitedinfo = 'limited';
                                                }
                                            }
                                        }
                                        
                                        $qtyexp = explode('.',$qty);
                                        if($qtyexp[1]==00000000){ $qty=$qtyexp[0]; }

                                        $qty = singleComma($qty, ".", ","); 

                                        // get product price
                                        $price = 0;
                                        if( $r['prodType']=='simpleproduct' ){
                                            $price = $r['prodPrice'];
                                        } 
                                        elseif($r['prodType']=='configurableproduct') {
                                            if( $attrcounting > 0){
                                                $getprc = getval('pattrPrice',"product_attribute","prodId='{$r['prodId']}' AND pattrDefault='y'");
                                                $price = $getprc;
                                            }
                                        }
                                ?>
                                <tr>
                                    <?php if( is_delete() ){ ?>
                                    <td class="text-center">
                                        <div class="form-group">
                                            <input type="checkbox" class="check_item" name="item[<?php echo $no; ?>]" value="y" />
                                            <input type="hidden" name="item_val[<?php echo $no; ?>]" value="<?php echo $r['prodId']; ?>" />
                                        </div>
                                    </td>
                                    <?php } ?>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center">
                                        <?php
                                        $theimgprod = admin_assets('img/no-image2.png');
                                        if(!empty($imgprod['pimgDir']) AND !empty($imgprod['pimgImg'])){
                                            $theimgprod = images_url($imgprod['pimgDir']."/small_".$imgprod['pimgImg']);
                                        }
                                        ?>
                                        <img src="<?php echo $theimgprod; ?>" alt="<?php echo $prodName; ?>" class="rounded img-thumbnail" style="max-width:100px;" >
                                    </td>
                                    <td>
                                        <?php 
                                            echo $prodName.'<br/>';
                                            echo '<small>';
                                            echo 'SKU: '. $r['prodSku'];

                                            // get categories
                                            $arraytablecat = array('categories a', 'category_relationship b');
                                            $categories = $CI->Env_model->view_where_order('a.*',$arraytablecat, "a.catActive='1' AND a.catType='product' AND b.relatedId='{$r['prodId']}' AND b.crelRelatedType='product' AND a.catId=b.catId",'catId','DESC');
                                            echo $countcat = count($categories);
                                            if($countcat>0){
                                                echo '<br/>'.t('categories').": ";
                                                $ncat = 1;
                                                foreach($categories as $valcat){
                                                    echo (!empty($valcat['catColor'])?'<span style="color:'.$valcat['catColor'].';">':'').$valcat['catName'].(!empty($valcat['catColor'])?'</span>':'');
                                                    if($ncat!=$countcat){ echo ', '; }
                                                    $ncat++;
                                                }
                                            }
                                            echo '</small>';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            if($limitedinfo == 'limited'){ echo $qty; }
                                            else {
                                                if($limitedinfo=='unlimited'){ echo t('unlimited'); }
                                                else {
                                                    echo $qty.'<br/>';
                                                    echo $limitedinfo;
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo the_price($r['prodBasicPrice']); ?></td>
                                    <td class="text-center"><?php echo the_price($price); ?></td>
                                    <td class="text-center">
                                        <i class="fe fe-<?php echo ($r['prodDisplay']=='y') ? 'check text-success':'x text-danger'; ?>"></i>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                                <?php echo t('action'); ?>
                                                <span class="caret"></span>
                                                <span class="sr-only">Split button!</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">                                                
                                                <?php if(is_edit()){ ?>
                                                <a class="dropdown-item" href="<?php echo admin_url($this->uri->segment(2) .'/edit/'.$r['prodId']); ?>"><i class="fa fa-pencil"></i> <?php echo t('edit'); ?></a>
                                                <?php } ?>

                                                <a class="dropdown-item" href="<?php echo admin_url($this->uri->segment(2) .'/disable_'.(($r['prodDisplay']=='y') ? 'n': 'y').'/'.$r['prodId']); ?>"><i class="fa fa-<?php echo ($r['prodDisplay']=='y') ? 'lock':'unlock' ?>"></i> <?php echo ($r['prodDisplay']=='y') ? t('disable'):t('enable'); ?></a>

                                                <div role="separator" class="dropdown-divider"></div>
                                                <?php if(is_delete()){ ?>
                                                <a class="dropdown-item" data-toggle="modal" href="#<?php echo 'myModal'.$r['prodId']; ?>"><i class="fa fa-trash"></i> <?php echo t('delete'); ?></a>
                                                <?php
                                                modalDelete(
                                                    'myModal'.$r['prodId'],
                                                    '<strong>'.$prodName.' ('.$r['prodSku'].')</strong>',
                                                    admin_url( $this->uri->segment(2).'/delete/'.$r['prodId'])
                                                );
                                                ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    $no++; }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="9" class="text-center"><?php echo t('nodatafound');?></td>
                                </tr>
                                <?php 
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo $pagination;
                        ?>
                    </div>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div>

    </div>
</div>
<?php 
endif;

include V_ADMIN_PATH . "footer.php";
