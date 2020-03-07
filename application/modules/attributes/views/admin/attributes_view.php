<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
Register style (CSS)
************************************/
$request_css_files = array(
    'vendors/select2/dist/css/select2.min.css'
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
							'type' => 'multilanguage_text',
							'label' => t('label'),
							'name' => 'label',
							'required' => true,
                        ),
						array(
							'type' => 'select',
                            'label' => t('attributesgroup'),
                            'class' => 'select2',
                            'name' => 'attrgroup',
                            'option'=> $datagroup
						),
						array(
							'type' => 'text',
							'label' => t('sorting'),
                            'name' => 'sorting',
                            'help' => t('writewithnumbers')
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
						<h5 class="card-title mb-0"><?php echo t('attributes'); ?></h5>
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
										<th><?php echo t('attributes'); ?></th>
										<th><?php echo t('attributesgroup'); ?></th>
										<th style="width:80px;" class="text-center"><?php echo t('sorting'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
									foreach ($data AS $r){
                                        $label = t( array( 'table'=>'attribute', 'field'=>'attrLabel', 'id'=>$r['attrId']) );
									?>
									<tr>
										<td class="text-center">
											<div class="form-group">
												<input type="checkbox" class="check_item" name="item[]" value="y" />
												<input type="hidden" name="item_val[]" value="<?php echo $r['attrId']; ?>" />
											</div>
										</td>
										<td class="text-center"><?php echo $no; ?></td>
										<td>
											<strong><?php echo $label; ?></strong><br/>
											<div class="btn-group btn-group-xs">
												<?php if(is_edit()){ ?>
												<a href="<?php echo admin_url($this->uri->segment(2).'/edit/'.$r['attrId']); ?>" class="btn btn-sm btn-info"><i class="fe fe-edit"></i> <?php echo t('edit'); ?></a> 
												<?php } 
												if(is_delete()){ ?>
												<a data-toggle="modal" href="#myModal<?php echo $r['attrId']; ?>" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i> <?php echo t('delete'); ?></a>
												<!-- Modal -->
												<div class="modal fade" id="myModal<?php echo $r['attrId']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog" style="width:400px;">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title"><?php echo t('delete'); ?></h5>
																<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo t('close'); ?></span></button>
															</div>
															<div class="modal-body text-center">
																<p><?php echo t('deleteconfirm'); ?></p>
																
																<strong><?php echo t('attribute').': '.$label; ?></strong>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo t('cancel'); ?></button>
																<a class="btn btn-danger btn-sm" href="<?php echo admin_url($this->uri->segment(2).'/delete/'.$r['attrId']); ?>"><i class="icon_trash_alt"></i> <?php echo t('delete'); ?></a>
															</div>
														</div><!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
												<!-- End Modal -->
												<?php } ?>
											</div>
										</td>
										<td>
                                            <?php
                                            // count group
                                            $checkgroup = countdata('attribute_relationship',"attrId='{$r['attrId']}'");
                                            if( $checkgroup > 0 ){
                                                $getgroup = getval(
                                                    'a.attrgroupId,a.attrgroupLabel',
                                                    array('attribute_group a','attribute_relationship b'),
                                                    "b.attrId='{$r['attrId']}' AND a.attrgroupId=b.attrgroupId"
                                                );

                                                echo t( array('table'=>'attribute_group','field'=>'attrgroupLabel', 'id'=>$getgroup['attrgroupId']) );
                                            } else {
                                                echo '<i class="fe fe-minus"></i>';
                                            }
                                            ?>
                                        </td>
										<td class="text-center">
											<?php echo $r['attrSorting']; ?>
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
