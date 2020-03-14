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
    'vendors/parsley/parsley.config.js',
    'vendors/parsley/parsley.min.js',
);
$request_script = "
$(function () {
    $('#valid').parsley();
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
if( is_view() ):
?>
<div class="row">
    <div class="col-md-12">

        <div class="card">

            <div class="card-header">
                <div class="row">

                    <div class="col-md-8">
                        <h5 class="card-title mb-0"><?php echo t('currencies'); ?></h5>
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

            <?php echo form_open( admin_url( $this->uri->segment(2).'/bulk_action' ), array( 'id'=>'valid', 'class'=>'form_bulk' ) ); ?>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-12 pt-2">
                        <div class="text-right" style="font-style:italic;"><?php echo t('total'). " " . $totaldata; ?></div>
                    </div>

                    <div class="col-md-12 py-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
                                        <th style="min-width:140px;"><?php echo t('currencies'); ?></th>
                                        <th style="width:70px;" class="text-center"><?php echo t('code'); ?></th>
                                        <th style="width:90px;" class="text-center"><?php echo t('symbol'); ?></th>
                                        <th class="text-center" style="width:120px;"><?php echo t('ratevalue'); ?> (<?php echo get_option('defaultcurrency'); ?>) <i class="fa fa-question-circle fa-lg text-primary" data-toggle="tooltip" data-original-title="<?php echo t('ratevalueinfo'); ?> <?php echo get_option('defaultcurrency'); ?>."></i></th>
                                        <th class="text-center" style="width:120px;"><?php echo t('foreigncurrencytodefault'); ?> <?php echo get_option('defaultcurrency'); ?> <i class="fa fa-question-circle fa-lg text-primary" data-toggle="tooltip" data-original-title="Nilai per mata uang asing terhadap <?php echo get_option('defaultcurrency'); ?>."></i></th>
                                        <th style="width:80px;" class="text-center"><?php echo t('enabled'); ?></th>
                                        <th style="width:120px;" class="text-center"><?php echo t('updatemethod'); ?></th>
                                        <th style="width:90px;" class="text-center"><?php echo t('update'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
                                    foreach ($data AS $r){
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td>
                                            <?php 
                                                echo "$r[curTitle]"; if( $r['curCode']==get_option('defaultcurrency') ){ echo "<strong><span style=\"\">(Default)</span></strong>"; } echo "<br/>";
                                            ?>
                                            <div class="btn-group btn-group-xs">
                                                <?php
                                                if($r['curStatus'] == 1){
                                                    echo "<a href=\"".admin_url($this->uri->segment(2).'/editstatus/'.$r['curId'].'/?s=0')."\" class=\"btn btn-xs btn-secondary\"><i class=\"fa fa-eye-slash\"></i> ".t('disable')."</a>";
                                                } else {
                                                    echo "<a href=\"".admin_url($this->uri->segment(2).'/editstatus/'.$r['curId'].'/?s=1')."\" class=\"btn btn-xs btn-success\"><i class=\"fa fa-eye\"></i> ".t('enable')."</a>";
                                                }
                                                ?>
                                                <?php if( is_edit() ){ ?>
                                                    <a href="<?php echo admin_url($this->uri->segment(2).'/edit/'.$r['curId']); ?>" class="btn btn-sm btn-info"><i class="fe fe-edit"></i> <?php echo t('edit'); ?></a>
                                                <?php } ?>
                                                <?php if( $r['curCode']!=get_option('defaultcurrency')){ ?>
                                                <?php if( is_delete() ){ ?>
                                                    <a data-toggle="modal" href="#myModal<?php echo $r['curId']; ?>" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i> <?php echo t('delete'); ?></a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal<?php echo $r['curId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" style="width:400px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo t('delete'); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo t('close'); ?></span></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <p><?php echo t('confirmdelete'); ?></p>
                                                                <strong><?php echo $r['curTitle']; ?></strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo t('batal'); ?></button>
                                                                <a class="btn btn-danger btn-sm" href="<?php echo admin_url($this->uri->segment(2).'/delete/'.$r['curId']); ?>"><i class="icon_trash_alt"></i> <?php echo t('delete'); ?></a>                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- End Modal -->
                                                <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo $r['curCode']; ?></td>
                                        <td class="text-center">
                                            <?php 
                                                if(!empty($r['curPrefixSymbol']) AND empty($r['curSuffixSymbol'])){
                                                    echo $r['curPrefixSymbol'] . " (Prefix)";
                                                } elseif(empty($r['curPrefixSymbol']) AND !empty($r['curSuffixSymbol'])){
                                                    echo $r['curSuffixSymbol'] . " (Suffix)";
                                                } elseif(!empty($r['curPrefixSymbol']) AND !empty($r['curSuffixSymbol'])){
                                                    echo $r['curPrefixSymbol'] . " (Prefix) and " . $r['curSuffixSymbol'] . " (Suffix)";
                                                } else {
                                                    echo t('nosymbol');
                                                }
                                            ?>
                                        </td>
                                        <td class="text-right"><?php echo number_format($r['curRate'],8, ',', '.'); ?></td>
                                        <td class="text-right">
                                            <?php echo the_price($r['curForeignCurrencyToDefault']); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo ($r['curStatus'] == 1) ? '<i class="fe fe-check text-success"></i>':'<i class="fe fe-x text-danger"></i>'; ?>
                                            <?php if( is_edit() ){ ?>
                                            <script type="text/javascript">
                                                $(document).ready(function($) {
                                                    $('#method_update<?php echo $r['curId']; ?>').change(function(){
                                                        var value = $(this).val();
                                                        // disable all select
                                                        $('.select_method_cur').attr('disabled','disabled');

                                                        $.post("<?php echo admin_url(); ?>/ajax_currency.php", {action:'method_update', method:value },
                                                        function(data){
                                                            if(data){
                                                                //$('#method_loader<?php echo $r['curId']; ?>').show().html(data);
                                                                window.location.href = "<?php echo admin_url()."/?module="; ?>";
                                                            } else {
                                                                $('#method_loader<?php echo $r['curId']; ?>').show().html('<center><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i><br/><h4><?php echo t('ajaxprocess'); ?><h4/></center>');
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                            <?php } ?>
                                        </td>
                                        <td id="method_loader<?php echo $r['curId']; ?>" class="text-center">
                                            <?php if( is_edit() ){ ?>
                                            <select id="method_update<?php echo $r['curId']; ?>" class="form-control select_method_cur">
                                                <option value="<?php echo $r['curId']; ?>#automatic"<?php if($r['curUpdateMethod']=='automatic'){ echo " selected=\"selected\""; } ?>><?php echo t('automatic'); ?></option>
                                                <option value="<?php echo $r['curId']; ?>#manual"<?php if($r['curUpdateMethod']=='manual'){ echo " selected=\"selected\""; } ?>><?php echo t('manual'); ?></option>
                                            </select>
                                            <?php 
                                            } else {
                                                if($r['curUpdateMethod']=='automatic'){ echo t('automatic'); } else { echo t('manual'); }
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?php
                                        $bulan = getMonth( date("m",$r['curModifiedDate']) );
                                        $date = date("d",$r['curModifiedDate']) ." " . $bulan ." ". date("Y",$r['curModifiedDate']);
                                        echo '<abbr title="'.$date . ' - ' . date('H:i', $r['curModifiedDate']).'" class="shiza_tooltip">'.date("d/m/Y", $r['curModifiedDate']).'</abbr>'; ?></td>
                                        
                                    </tr>
                                    <?php $no++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <?php
                        echo $pagination;
                        ?>
                    </div>

                    <div class="col-md-6">
                        <?php
                            echo "<div class=\"text-right\" style=\"margin-top:5px;font-style:italic;\">".t('total')." $totaldata</div>"
                        ?>
                    </div>

                    </div>

            </div>

            <?php echo form_close(); ?>

        </div>

    </div>
</div>
<?php
endif;
include V_ADMIN_PATH . "footer.php";
