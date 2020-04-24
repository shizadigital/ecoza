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
$( document ).ready(function() {
    $('#valid').parsley();
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
if( is_view() ){
?>
<div class="row">
	<?php 
	if( !empty( $this->session->has_userdata('succeed') ) ){
		echo '<div class="col-md-12">
		<div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
			<i class="fa fa-check"></i> ' . $this->session->flashdata('succeed') . '
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
		</div>
		</div>
		';
	}
	if( !empty( $this->session->has_userdata('failed') ) ){
		echo '<div class="col-md-12">
		<div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
			<i class="fa fa-times"></i> ' . $this->session->flashdata('failed') . '
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
		</div>
		</div>
		';
	}
	?>
	<?php if( is_add() ): ?>
	<div class="col-md-4">

		<div class="card">
			<div class="card-header"><h5 class="mb-0"><?php echo t('addnew'); ?></h5></div>

			<div class="card-body">
				<?php 
				// make tag form structure
				$tagForm = array(
					'action' 		=> admin_url( $this->uri->segment(2) . '/addingprocess'),
					'attributes' 	=> array( 'id'=>'valid' )					
                );                
				
				// make input structure
				$inputs = array(
					'layout' => 'vertical',
					'inputs' => array(
						array(
							'type' => 'text',
							'label' => t('label'),
							'name' => 'label',
							'required' => true,
                        ),
                        array(
							'type' => 'multilanguage_textarea',
							'label' => t('description'),
							'name' => 'desc',
                        ),
                        array(
                            'type' => 'file-img',
                            'label' => t('image'),
                            'name' => 'picture',
							'required' => true,
                            'help' => t('infomainimg') . ' *.jpg, *.jpeg, *.png, *.gif'
                        ),
						array(
							'type' => 'submit',
							'label' => '<i class="fe fe-plus"></i> '.t('btnadd'),
							'class' => 'btn-primary btn-block',
						)
					),
								
				);

				$this->formcontrol->buildForm($tagForm, $inputs, 'multipart');
				?>
			</div>
		</div>

	</div>
	<?php endif; ?>
	<?php if( is_view() ): ?>
	<div class="col-md-<?php if( !is_add() ){ echo '12'; } else { echo '8'; } ?>">
		<div class="card">

			<div class="card-header">
				<div class="row">

					<div class="col-md-8">
						<h5 class="card-title mb-0"><?php echo t('productbadges'); ?></h5>
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
										<th style="width:90px;" class="text-center"><?php echo t('pictures'); ?></th>
										<th><?php echo t('productbadges'); ?></th>
										<th style="width:80px;" class="text-center"><?php echo t('totalproduct'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
									foreach ($data AS $r){
                                        $label = $r['badgeLabel'];
									?>
									<tr>
										<?php if( is_delete() ){ ?>
										<td class="text-center">
											<div class="form-group">
												<input type="checkbox" class="check_item" name="item[<?php echo $no; ?>]" value="y" />
												<input type="hidden" name="item_val[<?php echo $no; ?>]" value="<?php echo $r['badgeId']; ?>" />
											</div>
										</td>
										<?php } ?>
										<td class="text-center"><?php echo $no; ?></td>
                                        <td class="text-center">
                                            <?php 
                                            $imgbadge = admin_assets('img/no-image2.png');
                                            if(!empty($r['badgeDir']) AND !empty($r['badgePic'])){
                                                $imgbadge = images_url($r['badgeDir'].'/xsmall_'.$r['badgePic']);
                                            }
                                            ?>
                                            <img style="width:88px; border:1px solid #ddd; margin:6px 10px 0 0;" src="<?php echo $imgbadge; ?>" alt="<?php echo $label; ?>" />
                                        </td>
										<td>
											<strong><?php echo $label; ?></strong><br/>
											<div class="btn-group btn-group-xs">
												<?php if(is_edit()){ ?>
												<a href="<?php echo admin_url($this->uri->segment(2).'/edit/'.$r['badgeId']); ?>" class="btn btn-sm btn-info"><i class="fe fe-edit"></i> <?php echo t('edit'); ?></a> 
												<?php } 
												if(is_delete()){ ?>
												<a data-toggle="modal" href="#myModal<?php echo $r['badgeId']; ?>" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i> <?php echo t('delete'); ?></a>
												<?php
                                                    modalDelete(
                                                        'myModal'.$r['badgeId'],
                                                        '<strong>'.t('productbadges').': '.$label.'</strong>',
                                                        admin_url($this->uri->segment(2).'/delete/'.$r['badgeId'])
                                                    );
												?>
												<?php } ?>
											</div>
										</td>
										<td class="text-center">
                                            <?php
                                            // count group
                                            $relationship = countdata('badge_relationship',"badgeId='{$r['badgeId']}' AND bdgrelType='product'");
                                            if( $relationship > 0 ){
                                                echo $relationship;
                                            } else {
                                                echo '0';
                                            }
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
	<?php endif; ?>
</div>
<?php
}
include V_ADMIN_PATH . "footer.php";
