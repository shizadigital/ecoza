<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
Register style (CSS)
************************************/
$request_css_files = array(
    'vendors/select2/dist/css/select2.min.css',
	'vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css'
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    'vendors/parsley/parsley.config.js',
    'vendors/parsley/parsley.min.js',
	'vendors/select2/dist/js/select2.full.min.js',
	'vendors/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js'
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

if( is_edit() ){
$inputhidden = array('ID' => $data['attrId']);
echo form_open_multipart( admin_url( $this->uri->segment(2) . '/editprocess'), array( 'id'=>'valid' ), $inputhidden );
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
	<div class="col-md-12">

		<div class="card card-statistics">
			<div class="card-header">
				<div class="card-heading">
					<h5 class="card-title mb-0"><?php echo t('editattribute') . ' - ' .$data['attrLabel']; ?></h5>
				</div>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<?php 
					// count group
					$checkgroup = countdata('attribute_relationship',"attrId='{$data['attrId']}'");
					if( $checkgroup > 0 ){
						// get group 
						$getgroup = getval(
							'a.attrgroupId,a.attrgroupLabel',
							array('attribute_group a','attribute_relationship b'),
							"b.attrId='{$data['attrId']}' AND a.attrgroupId=b.attrgroupId"
						);

						$grpID = $getgroup['attrgroupId'];
					} else {
						$grpID = false;
					}
					
					$build_input = array(
						array(
							'type' => 'multilanguage_text',
							'label' => t('label'),
							'name' => 'label',
							'required' => true,
							'value' =>  array(
								'table' => 'attribute',
								'field' => 'attrLabel',
								'id' => $data['attrId']
							)
						),
						array(
							'type' => 'select',
							'label' => t('attributesgroup'),
							'class' => 'select2',
							'name' => 'attrgroup',
							'option'=> $datagroup,
							'selected' => $grpID,
						),
						array(
							'type' => 'text',
							'label' => t('sorting'),
							'name' => 'sorting',
							'help' => t('writewithnumbers'),
							'value' => $data['attrSorting']
						)
					);

					$this->formcontrol->buildInputs($build_input, 'horizontal', array('label'=>'col-md-2', 'input'=>'col-md-10'));
					?>
					<hr/>
					</div>
					<div class="col-md-12">
						<h4 class="mb-4"><?php echo t('attributevalue'); ?></h4>

						<blockquote class="d-block blockquote text-info">
							<i class="fe fe-info mr-2"></i> <?php echo t('attrvalueinputinfo'); ?>
						</blockquote>

						<div class="d-block mb-3 mt-4">
							<button type="button" class="btn btn-rounded btn-light" id="addattrvalue"><i class="fe fe-plus mr-md-1"></i> <?php echo t('addvalue'); ?></button>
							<script type="text/javascript">
							$( document ).ready(function() {
								$('#addattrvalue').click(function() {
									// Disable button
									$(this).attr('disabled','disabled');
									$(this).addClass('btn-disabled');

									// proccess
									$.post("<?php echo admin_url($this->uri->segment(2) . '/ajax_addfieldattrval'); ?>", {CP: '<?php echo get_cookie('sz_token'); ?>'},
									function(data){
										if( $('tr#novalfound').length ){
											$('tr#novalfound').remove();
										}

										$('#addattrvalue').removeAttr('disabled');
										$('#addattrvalue').removeClass('btn-disabled');
									}).done( function(data){
										$('.attributevalue tbody').append(data);
									});
								});
							});
							</script>
						</div>

						<div class="table-responsive-md">
							<table class="table table-hover table-striped attributevalue">
								<thead>
									<tr>
										<th class="text-center"><?php echo t('visual'); ?></th>
										<th style="width:36px;"><?php echo t('color'); ?></th>
										<th class="text-center"><?php echo t('value'); ?></th>
										<th class="text-center"><?php echo t('label'); ?></th>
										<th style="width:20px;" class="text-center"><i class="fe fe-settings"></i></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if(count($attrval) > 0){

										foreach($attrval AS $val){
											?>
											<tr id="rowval-<?php echo $val['attrvalId']; ?>">
												<td class="align-center">
													<?php
													echo form_hidden('idattrval[]', $val['attrvalId']);
													?>
													<?php
													$selectval = array(
														'text' => t('text'),
														'color' => t('color'),
														//'image' => t('image')
													);
													$extraselectval = array(
														'class' => 'select2',
														'id'=>'visualtype-'.$val['attrvalId'],
													);
													echo form_dropdown('visualtype[]', $selectval, $val['attrvalVisual'], $extraselectval);
													?>
													<script type="text/javascript">
													$( document ).ready(function() {
														<?php 
														if($val['attrvalVisual'] == 'color'){
															echo '
															$("#displaycolor-'.$val['attrvalId'].'").show();
															$("#nocolor-'.$val['attrvalId'].'").hide();
															$("#attrval-'.$val['attrvalId'].'").addClass(\'thecolorpicker\');
															$("#attrval-'.$val['attrvalId'].'").colorpicker()
															.on(\'colorpickerChange colorpickerCreate\', function (e) {
																$("#displaycolor-'.$val['attrvalId'].'").css(\'background-color\', e.value);
															});
															';
														} else {
															echo '
															$("#displaycolor-'.$val['attrvalId'].'").hide();
															$("#nocolor-'.$val['attrvalId'].'").show();
															';
														}
														?>
														$('#visualtype-<?php echo $val['attrvalId'] ?>').change(function () {
															if( $(this).val() == 'text' ){
																$("#nocolor-<?php echo $val['attrvalId']; ?>").show();
																$("#displaycolor-<?php echo $val['attrvalId']; ?>").hide();
																$("#attrval-<?php echo $val['attrvalId']; ?>").val('');
																if( $('#attrval-<?php echo $val['attrvalId']; ?>.thecolorpicker').length ){
																	$("#attrval-<?php echo $val['attrvalId']; ?>").colorpicker('colorpicker').destroy();
																	$("#attrval-<?php echo $val['attrvalId']; ?>").removeClass('thecolorpicker');
																}
															}
															else if( $(this).val() == 'color' ){
																$("#displaycolor-<?php echo $val['attrvalId']; ?>").show();
																$("#nocolor-<?php echo $val['attrvalId']; ?>").hide();
																$("#attrval-<?php echo $val['attrvalId']; ?>").val('');
																$("#attrval-<?php echo $val['attrvalId']; ?>").addClass('thecolorpicker');
																$('#attrval-<?php echo $val['attrvalId']; ?>').colorpicker()
																.on('colorpickerChange colorpickerCreate', function (e) {
																	$("#displaycolor-<?php echo $val['attrvalId']; ?>").css('background-color', e.value);
																});
															}
														});
													});
													</script>
												</td>
												<td class="text-center color-<?php echo $val['attrvalId']; ?>">
													<div id="displaycolor-<?php echo $val['attrvalId']; ?>" class="mt-2" style="width:23px; height:23px; display: inline-flex;"></div>
													<i class="fe fe-minus" id="nocolor-<?php echo $val['attrvalId']; ?>"></i>
												</td>
												<td class="text-center">
												<?php 
													$inputsvalue = array(
														'name' => 'valueattrval[]',
														'class' => 'form-control',
														'value' => $val['attrvalValue'],
														'id' => 'attrval-'.$val['attrvalId'],
													);
 													echo form_input($inputsvalue);
													?>
												</td>
												<td class="text-center">
													<?php 
													$inputstext = array(
														'name' => 'labelattrval[]',
														'class' => 'form-control',
														'value' => $val['attrvalLabel']
													);
 													echo form_input($inputstext);
													?>
												</td>
												<td class="text-center">
													<?php if( is_delete() ){ ?>
													<button type="button" class="btn btn-danger" id="rmvattrvalue-data-<?php echo $val['attrvalId'] ?>"><i class="fe fe-trash-2"></i></button>
													<script type="text/javascript">
													$( document ).ready(function() {
														$('#rmvattrvalue-data-<?php echo $val['attrvalId'] ?>').click(function() {
															if( confirm("<?php echo t('deleteconfirm').' ('.$val['attrvalLabel'].')'; ?>") ){
																// Disable button
																$(this).attr('disabled','disabled');
																$(this).addClass('btn-disabled');

																// proccess
																$.post("<?php echo admin_url($this->uri->segment(2) . '/ajax_removedataattrval'); ?>", {attrval: '<?php echo $val['attrvalId']; ?>', CP: '<?php echo get_cookie('sz_token'); ?>'},
																function(data){
																	$('#rmvattrvalue-data-<?php echo $val['attrvalId'] ?>').removeAttr('disabled');
																	$('#rmvattrvalue-data-<?php echo $val['attrvalId'] ?>').removeClass('btn-disabled');
																}).done(function(data) {
																	if(data == 200){
																		$( "#rowval-<?php echo $val['attrvalId']; ?>" ).remove();
																	}
																});
															}
														});
													});
													</script>
													<?php } else {
														echo '<i class="fe fe-minus pt-2"></i>';
													} ?>
												</td>
											</tr>
											<?php 
										}

									} else {
										echo '<tr id="novalfound"><td colspan="5" class="text-center"><h5 class="py-2">'.t('nodatafound').'</h5></td></tr>';
									}
									?>
								</tbody>									
							</table>
						</div>
					</div>
					<!-- END col-md-12 -->
				</div>

			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
			</div>
		</div>

	</div>
</div>
<?php 
}
echo form_close();

include V_ADMIN_PATH . "footer.php";
?>