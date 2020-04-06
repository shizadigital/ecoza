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
<!-- start-clients contant-->
<div class="row">
    <div class="col-12">
        <div class="card card-statistics">

            <div class="card-header">
                <div class="row">

                    <div class="col-md-9">
                        <h5 class="card-title mb-0"><?php echo $title_page; ?></h5>
                    </div>
                    
                    <div class="col-md-3">
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

                <div class="row">
                    <div class="col-md-12 form-inline">
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

                    </div>
                    <div class="col-md-12 py-3 table-responsive-sm">
                        <table class="table table-striped table-hover">

                            <thead>
                                <tr>
                                    <th style="width:25px;" class="text-center">
                                        <input type="checkbox" id="check_all" />
                                    </th>
                                    <th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
                                    <th style="min-width:44px;" class="text-center"><?php echo t('images'); ?></th>
                                    <th><?php echo t('username'); ?></th>
                                    <th style="min-width:140px;"><?php echo t('name'); ?></th>
                                    <th style="min-width:120px;" class="text-center"><?php echo t('level'); ?></th>
                                    <th style="min-width:70px;" class="text-center"><?php echo t('status'); ?></th>
                                    <th style="min-width:70px;" class="text-center"><?php echo t('lastlogin'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $modaldelete = array();
                                $no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
                                foreach ($data AS $r){
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if($r['userId']!='1'){ ?>
                                        <div class="form-group">
                                            <input type="checkbox" class="check_item" name="item[<?php echo $no; ?>]" value="y" />
                                            <input type="hidden" name="item_val[<?php echo $no; ?>]" value="<?php echo $r['userId']; ?>" />
                                        </div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <?php 
                                        $userpic = admin_assets('components/core/img/avatars/avatar.png');
                                        if($r['userPic']){
                                            $userpic = images_url($r['userDir'].'/xsmall_'.$r['userPic']); 
                                        }
                                    ?>
                                    <td class="text-center">
                                        <img style="width:42px;height:42px;" src="<?php print $userpic; ?>" />
                                    </td>
                                    <td>
                                        <?php 
                                            echo "<strong>$r[userLogin]</strong><br/>";
                                        ?>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?php if(is_edit()){ ?>
                                            <a href="<?php echo admin_url($this->uri->segment(2)."/edit/".$r['userId']); ?>" class="btn btn-sm btn-info"><i class="fe fe-edit"></i> <?php echo t('edit'); ?></a>
                                            <?php }
                                            if($r['userId']!='1'){
                                            if(is_delete()) { ?>
                                            <a data-toggle="modal" href="#myModal<?php echo $r['userId']; ?>" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i> <?php echo t('delete'); ?></a>
                                            <?php
                                            modalDelete(
                                                'myModal'.$r['userId'],
                                                '<strong>'.$r['userDisplayName'].' ('.$r['userLogin'].')</strong>',
                                                admin_url( $this->uri->segment(2).'/delete/'.$r['userId'])
                                            );
                                            ?>
                                            <?php } 
                                            } ?>
                                        </div>
                                    </td>
                                    <td><?php echo $r['userDisplayName']; ?></td>
                                    <td class="text-center"><?php echo $r['levelName']; ?></td>
                                    <td class="text-center">
                                        <?php 
                                        if($r['userBlocked']=='y'){ echo "<span class=\"badge badge-danger\">".t('inactive')."</span>"; }
                                        else { echo "<span class=\"badge badge-success\">".t('active')."</span>"; }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        if(empty($r['userLastLogin'])){ 
                                            echo "<i class=\"fe fe-minus\"></i>";
                                        } else {
                                            $iddate = date("d",$r['userLastLogin']) .' '. getMonth(date("m",$r['userLastLogin'])) .' '. date("Y",$r['userLastLogin']) . ' ' . date("H:i",$r['userLastLogin']);
                                            echo "<abbr data-toggle=\"tooltip\" title=\"".$iddate."\">".date("d/m/Y H:i",$r['userLastLogin'])."</abbr>";
                                        } ?>
                                    </td>
                                </tr>
                                <?php 
                                $no++; } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo $pagination;
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php 
                        echo "<div class=\"float-right\" style=\"margin-top:5px;font-style:italic;\">Total $totaldata</div>";
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
?>