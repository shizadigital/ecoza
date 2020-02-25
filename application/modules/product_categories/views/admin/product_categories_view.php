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
    'vendors/parsley/parsley.min.js'
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
					'action' 		=> admin_url( $this->uri->segment(2) . '/prosestambah'),
					'attributes' 	=> array( 'id'=>'valid' )					
				);
				
				// make input structure
				$inputs = array(
					'layout' => 'vertical',
					'inputs' => array(
						array(
							'type' => 'text',
							'label' => t('name'),
							'name' => 'nama',
							'required' => true,
						),
						array(
							'type' => 'textarea',
							'label' => t('description'),
							'name' => 'desc'
						),
						array(
							'type' => 'text',
							'label' => t('color'),
							'name' => 'warna',
							'help' => t('infocategcolor')
						),
						array(
							'type' => 'submit',
							'label' => '<i class="fe fe-plus"></i> '.t('btnadd'),
							'class' => 'btn-primary btn-block',
						)
					),
								
				);

				$this->formcontrol->buildForm($tagForm, $inputs);
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
						<h5 class="card-title mb-0"><?php echo t('categories'); ?></h5>
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
						<div class="input-group">
							<select name="bulktype" class="form-control form-control-sm custom-select" required>
								<option value="">-- <?php echo t('bulkaction'); ?> --</option>
								<option value="bulk_delete"><?php echo t('delete'); ?></option>
							</select>
							<div class="input-group-append">
								<button class="btn btn-light btn-sm submit_bulk" type="button"><i class="fa fa-cog"></i></button>
							</div>
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

					<div class="col-md-6 pt-2">
						<div class="text-right" style="font-style:italic;"><?php echo t('total'). " " . $totaldata; ?></div>
					</div>
					
					<div class="col-md-12 py-3">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								
								<thead>
									<tr>
										<th style="width:25px;" class="text-center">
											<div class="form-group">
												<input type="checkbox" id="check_all" />
											</div>
										</th>
										<th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
										<th><?php echo t('categories'); ?></th>
										<th style="width:80px;" class="text-center"><?php echo t('active'); ?></th>
										<th style="width:120px;" class="text-center"><?php echo t('totalcontent'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
									foreach ($data AS $r){
									?>
									<tr>
										<td class="text-center">
											<div class="form-group">
												<input type="checkbox" class="check_item" name="item[]" value="y" />
												<input type="hidden" name="item_val[]" value="<?php echo $r['catId']; ?>" />
											</div>
										</td>
										<td class="text-center"><?php echo $no; ?></td>
										<td>
											<div class="float-left">
												<?php 
													if(empty($r['catColor'])){
														echo "<img style=\"width:30px; border:1px solid #ddd; height:30px; margin:6px 10px 0 0;\" src=\"".admin_assets('img/transparent_canvas_small.png')."\" alt=\"No Color\" />";
													} else {
														echo "<div style=\"width:30px; height:30px; margin:6px 10px 0 0; background:{$r['catColor']};\"></div>";
													}
												?>
											</div>
											<strong><?php echo $r['catName']; ?></strong><br/>
											<div class="btn-group btn-group-xs">
												<?php if(is_edit()){ ?>
												<a href="<?php echo admin_url($this->uri->segment(2).'/edit/'.$r['catId']); ?>" class="btn btn-sm btn-info"><i class="fe fe-edit"></i> <?php echo t('edit'); ?></a> 
												<?php } 
												if(is_delete()){ ?>
												<a data-toggle="modal" href="#myModal<?php echo $r['catId']; ?>" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i> <?php echo t('delete'); ?></a>
												<!-- Modal -->
												<div class="modal fade" id="myModal<?php echo $r['catId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog" style="width:400px;">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title"><?php echo t('delete'); ?></h5>
																<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo t('close'); ?></span></button>
															</div>
															<div class="modal-body text-center">
																<p><?php echo t('deleteconfirm'); ?></p>
																<?php 
																if(empty($r['catColor'])){
																	$color_ = "#000";
																}else{
																	$color_ = $r['catColor'];
																	} ?>
																<strong><span style="color:<?php echo $color_; ?>;"><?php echo $r['catName']; ?></span></strong>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo t('cancel'); ?></button>
																<a class="btn btn-danger btn-sm" href="<?php echo admin_url($this->uri->segment(2).'/delete/'.$r['catId']); ?>"><i class="icon_trash_alt"></i> <?php echo t('delete'); ?></a>
															</div>
														</div><!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
												<!-- End Modal -->
												<?php } ?>
											</div>
										</td>
										<td class="text-center"><?php if($r['catActive']=='1'){ echo t('yes'); } else { echo t('no'); } ?></td>
										<td class="text-center">
											<?php 
											$totalrel = countdata("category_relationship","catId='{$r['catId']}' AND crelRelatedType='product'"); 
											echo $totalrel; ?>
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
include V_ADMIN_PATH . "footer.php";
?>