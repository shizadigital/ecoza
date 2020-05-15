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
    <?php 
    if( !empty( $this->session->has_userdata('succeed') ) ){
        echo '
        <div class="col-md-12">
        <div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check"></i> ' . $this->session->flashdata('succeed') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
        </div>
        </div>
        ';
    }
    if( !empty( $this->session->has_userdata('failed') ) ){
        echo '
        <div class="col-md-12">
        <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-times"></i> ' . $this->session->flashdata('failed') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
        </div>
        </div>
        ';
    }
    ?>
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title mb-0"><?php echo t('courier'); ?></h5>
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

					<div class="col-md-6 pt-2">
						<div class="text-right" style="font-style:italic;"><?php echo t('total'). " " . $totaldata; ?></div>
					</div>
					
					<div class="col-md-12 py-3">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<?php if( is_delete() ){ ?>
										<th style="width:25px;" class="text-center">
											<div class="form-group">
												<input type="checkbox" id="check_all" />
											</div>
										</th>
										<?php } ?>
										<th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
                                        <th style="width:120px;" class="text-center"><?php echo t('images'); ?></th>
										<th><?php echo t('name'); ?></th>
										<th style="width:80px;" class="text-center"><?php echo t('active'); ?></th>
										<th style="width:180px;" class="text-center"><?php echo t('freeshipping'); ?></th>
                                        <th style="width:100px;" class="text-center"><i class="fa fa-cog"></i></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
									foreach ($data AS $r){
									?>
									<tr>
										<?php if( is_delete() ){ ?>
										<td class="text-center">
											<div class="form-group">
												<input type="checkbox" class="check_item" name="item[<?php echo $no; ?>]" value="y" />
												<input type="hidden" name="item_val[<?php echo $no; ?>]" value="<?php echo $r['courierId']; ?>" />
											</div>
										</td>
										<?php } ?>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-center">
                                            <?php
                                            $theimg = admin_assets('img/no-image2.png');
                                            if(!empty($r['courierDirLogo']) AND !empty($r['courierFileLogo'])){
                                                $theimg = images_url($r['courierDirLogo']."/small_".$r['courierFileLogo']);
                                            }
                                            ?>
                                            <img src="<?php echo $theimg; ?>" alt="<?php echo $r['courierName']; ?>" class="rounded img-thumbnail" style="max-width:100px;" >
                                        </td>
										<td>
                                            <strong><?php echo $r['courierName']; ?></strong><br/>
                                            <?php
                                            if( !empty( $r['courierUrlTracking'] ) ){
                                                echo '<code>'.$r['courierUrlTracking'].'</code>';
                                            }
                                            ?>
										</td>
										<td class="text-center">
                                            <?php if($r['courierFreeShipping']=='y'){ echo '<i class="fe fe-check text-success"></i>'; } else { echo '<i class="fe fe-minus"></i>'; } ?>
										</td>
										<td class="text-center">
                                            <?php if($r['courierStatus']=='1'){ echo '<i class="fe fe-check text-success"></i>'; } else { echo '<i class="fe fe-minus"></i>'; } ?>
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
                                                    <a class="dropdown-item" href="<?php echo admin_url($this->uri->segment(2) .'/edit/'.$r['courierId']); ?>"><i class="fa fa-pencil"></i> <?php echo t('edit'); ?></a>
                                                    <?php } ?>
                                                    <?php if(is_delete()){ ?>
                                                    <a class="dropdown-item" data-toggle="modal" href="#<?php echo 'myModal'.$r['courierId']; ?>"><i class="fa fa-trash"></i> <?php echo t('delete'); ?></a>
                                                    <?php
                                                    modalDelete(
                                                        'myModal'.$r['courierId'],
                                                        '<strong>'.$r['courierName'].'</strong>',
                                                        admin_url( $this->uri->segment(2).'/delete/'.$r['courierId'])
                                                    );
                                                    ?>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </td>
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

                <?php echo form_close(); ?>

			</div>

        </div>

    </div>
</div>
<?php
endif;

include V_ADMIN_PATH . "footer.php";
