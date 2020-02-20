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
echo form_open( admin_url( $this->uri->segment(2).'/updatelist/' ) );
?>
<!-- start-clients contant-->
<div class="row">
    <div class="col-12">
        <div class="card card-statistics">

            <div class="card-body">
            	<?php 
				if( !empty( $this->session->has_userdata('sukses') ) ){
				    echo '
					<div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
						<i class="fa fa-check"></i> ' . $this->session->flashdata('sukses') . '
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
					</div>
					';
				}
				if( !empty( $this->session->has_userdata('gagal') ) ){
				    echo '
					<div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
						<i class="fa fa-times"></i> ' . $this->session->flashdata('gagal') . '
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
					</div>
					';
				}            
				?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fe fe-refresh-cw"></i> <?php echo 'Perbarui List'; ?></button>
                        </div>
                    </div>

                    <div class="col-md-12 table-responsive-sm">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:25px;" class="text-center">No</th>
                                    <th style="min-width:220px;">Nama</th>                                       
                                    <th class="text-center" style="min-width:60px;">
                                        Aktif<br/>
                                        <input type="checkbox" id="mod_active_all" />
                                    </th>
                                    <th class="text-center" style="width:160px;">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $totalnya = count($datalevel);
                                foreach($datalevel AS $r){
                                    $active_checked = ($r['levelActive']=='y') ? " checked=\"checked\"" : '' ;

                                    // get total account in this level
                                    $totallevel = countdata('users',"levelId='{$r['levelId']}'");                                    
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td>
                                        <?php 
                                        echo $r['levelName']."<br/>
                                        <span class=\"text-muted\" style=\"font-size:12px;\">Total Akun: {$totallevel}</span>";
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="idaccess[]" value="<?php echo $r['levelId']; ?>" />
                                        <?php if($r['levelId']=='1'){ ?>
                                        <input type="hidden" name="mod_active[1]" value="y" /><i class="fe fe-check"></i>
                                        <?php } else { ?>
                                        <input type="checkbox"<?php echo $active_checked; ?> name="mod_active[<?php echo $r['levelId']; ?>]" id="mod_active<?php echo $r['levelId']; ?>" class="mod_active" value="y" />
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        if( is_edit() ){
                                            echo "<a href=\"".admin_url($this->uri->segment(2)."/edit/".$r['levelId'])."\" class=\"btn btn-info btn-sm\"><i class=\"fe fe-edit\"></i> Edit</a>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php $no++; } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fe fe-refresh-cw"></i> <?php echo 'Perbarui List'; ?></button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <?php                                               
                            echo "<div class=\"float-right\" style=\"font-style:italic;\">Total {$totalnya}</div>";
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript"> 
$(document).ready(function(){
    //Check all active
    $("#mod_active_all").click(function(){
        if ( (this).checked == true ){
           $('.mod_active').prop('checked', true);
        } else {
           $('.mod_active').prop('checked', false);
        }
    });

});
</script>

<?php 
echo form_close();
endif;

include V_ADMIN_PATH . "footer.php";
?>