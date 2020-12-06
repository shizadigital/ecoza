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
    <div class="col-md-12">
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

        <div class="card">

            <div class="card-header">
                <div class="row">

                    <div class="col-md-8">
                        <h5 class="card-title mb-0"><?php echo t('addons'); ?></h5>
                    </div>

                    <div class="col-md-4">
                        <?php echo form_open( admin_url( $this->uri->segment(2).'/' ), array( 'method'=>'get' ) ); ?>
                        <div class="input-group float-right">
                            <input type="text" class="form-control form-control-sm" name="kw" value="<?php if(!empty($this->input->get('kw'))){ echo $this->input->get('kw'); } ?>" placeholder="<?php echo t('searchinstalledaddons'); ?> . . ."/>
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

					<div class="col-md-6 form-inline">
						<?php if( is_delete() ): ?>
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
						<?php endif; ?>
					</div>

					<div class="col-md-6 pt-2">
						<div class="text-right" style="font-style:italic;"><?php echo t('total'). " " . $totaldata; ?></div>
					</div>
					
					<div class="col-md-12 py-3">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								
								<thead>
									<tr>
										<?php if( is_delete() ): ?>
										<th style="width:25px;" class="text-center">
											<input type="checkbox" id="check_all" />
										</th>
										<?php endif; ?>
										<th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
										<th style="width:350px;"><?php echo t('addons'); ?></th>
										<th><?php echo t('description'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;

									foreach ($data AS $key => $r){
                                        $name = empty($this->input->get('kw'))?$r['ADDONS_NAME']:$r['addonsName'];
										$dirname = empty($this->input->get('kw'))?$key:$r['addonsDirName'];
										
										$is_active = ( countdata( 'addons', ['addonsDirName' => $dirname, 'addonsActive'=> 1] ) > 0 ) ? true:false;

										$addonsinfo = $this->add_ons->getAddonsInfo($dirname);

										$segmentactive = 'active';
										$coloractive = 'success';
										$wordactive = t('activate');
										$iconactive = 'fe fe-eye';
										$trclass = "table-light";

										if(empty($this->input->get('kw'))){
											if( $is_active ){
												$segmentactive = 'inactive';
												$coloractive = 'secondary';
												$wordactive = t('deactivate');
												$iconactive = 'fe fe-eye-off';
												$trclass = "table-info";
											}
										} else {
											$segmentactive = 'inactive';
											$coloractive = 'secondary';
											$wordactive = t('deactivate');
											$iconactive = 'fe fe-eye-off';
											$trclass = "table-info";

										}
									?>
									<tr class="<?php echo $trclass; ?>">
										<?php if( is_delete() ): ?>
										<td class="text-center">
											<input type="checkbox" class="check_item" name="item[<?php echo $no; ?>]" value="y" />
											<input type="hidden" name="item_val[<?php echo $no; ?>]" value="<?php echo $dirname; ?>" />
										</td>
										<?php endif; ?>
										
										<td class="text-center"><?php echo $no; ?></td>
										<td>
											<strong><?php echo $name; ?></strong><br/>
											<div class="btn-group btn-group-xs">
												<?php 
												if(is_edit()){
												?>
												<a href="<?php echo admin_url($this->uri->segment(2).'/'.$segmentactive.'/'.$dirname); ?>" class="btn btn-sm btn-<?php echo $coloractive; ?>"><i class="<?php echo $iconactive; ?>"></i> <?php echo $wordactive; ?></a> 
												<?php } 
												if($is_active){
													echo '<a href="'.admin_url($dirname).'" class="btn btn-sm btn-info"><i class="fe fe-menu"></i> '.t('setting').'</a>';
												} else {
													if(is_delete()){
												?>
													<a data-toggle="modal" href="#myModal<?php echo $dirname; ?>" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i> <?php echo t('delete'); ?></a>
													<?php
													modalDelete(
														'myModal'.$dirname,
														'<strong>'.$name.'</strong>',
														admin_url($this->uri->segment(2).'/delete/'.$dirname)
													);
													?>
													<?php 
													}
												} 
												?>
											</div>
										</td>
										<td>
                                            <?php
											echo '<div class="d-block mb-2">'.$addonsinfo['ADDONS_DESCRIPTION'] .'</div>';
											echo '<div class="d-block"><small>'.t('version').' '.$addonsinfo['ADDONS_VERSION_NAME'] .' | '.t('by').' <a href="'.$addonsinfo['ADDONS_AUTHOR_URL'].'" target="_blank" rel="nofollow"><u>'.$addonsinfo['ADDONS_AUTHOR'] .'</u></a> | <a href="'.$addonsinfo['ADDONS_DOCUMENTATION_URL'].'" target="_blank" rel="nofollow"><u>'.t('documentation').'</u></a></small></div>';
                                            ?>
                                        </td>
									</tr>
									<?php $no++; } ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-md-6">
                        <?php
						if(!empty($this->input->get('kw'))){
							echo $pagination;
						}
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
