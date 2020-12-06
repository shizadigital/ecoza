<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
Register style (CSS)
************************************/
$request_css_files = array(
    'vendors/select2/dist/css/select2.min.css',
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    'vendors/select2/dist/js/select2.full.min.js',
);
$request_script = "
$( document ).ready(function() {
    $('.select2').select2();

    // submit data
    ajaxSubmit('#valid');     
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if( is_add() ):
echo form_open( admin_url( $this->uri->segment(2) . '/addprocess'), array( 'id'=>'valid' ) );
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
                    <h5 class="card-title mb-0"><?php echo t('addnew'); ?></h5>
                </div>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-12">
                        <h5 class="mb-4"><?php echo t('generalsetting'); ?></h5>
                        <?php
                        $imgext = '';
                        $countimg = count($imgextention);
                        $ximg = 1;
                        foreach( $imgextention as $extimg ){
                            $imgext .= $extimg;
                            if($ximg != $countimg){
                                $imgext .= ', ';
                            }
                            $ximg++;
                        }

                        // make input structure
                        $inputs =  array(
                            array(
                                'type' => 'text',
                                'label' => t('couriername').' <span class="text-red">*</span>',
                                'name' => 'couriername',
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('couriercode'),
                                'name' => 'couriercode',
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('urltracking'),
                                'name' => 'urltracking',
                            ),
                            array(
                                'type' => 'file-img',
                                'label' => t('logo'),
                                'name' => 'logo',
                                'help' => t('infomainimg').' '.$imgext,
                            ),
                            array(
                                'type' => 'checkbox',
                                'label' => t('freeshipping'),
                                'name' => 'freeshipping',
                                'value' => '1',
                                'title' => t('yes'),
                                'checked' => false
                            ),
                            array(
                                'type' => 'checkbox',
                                'label' => t('active'),
                                'name' => 'active',
                                'value' => '1',
                                'title' => t('yes'),
                                'checked' => true
                            ),
                        );
                        $this->formcontrol->buildInputs($inputs, 'horizontal', array('label'=>'col-md-2', 'input'=>'col-md-9'));
                        ?>
                        <hr/>
                    </div>

                    <div class="col-md-12">
                        <h5 class="mb-4"><?php echo t('sizeandweightsetting'); ?></h5>
                        <?php
                        // make input structure
                        $inputscostmax =  array(
                            array(
                                'type' => 'text',
                                'label' => t('maxpackagewidth'),
                                'name' => 'maxpackagewidth',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => 0,
                                'input-group' => array(
                                    'append'=> getLengthDefault(),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('maxpackageheight'),
                                'name' => 'maxpackageheight',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => 0,
                                'input-group' => array(
                                    'append'=> getLengthDefault(),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('maxpackagelength'),
                                'name' => 'maxpackagelength',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => 0,
                                'input-group' => array(
                                    'append'=> getLengthDefault(),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('maxpackageweight'),
                                'name' => 'maxpackageweight',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => 0,
                                'input-group' => array(
                                    'append'=> getWeightDefault(),
                                )
                            ),
                        );
                        $this->formcontrol->buildInputs($inputscostmax, 'horizontal', array('label'=>'col-md-2', 'input'=>'col-md-9'));
                        ?>
                        <hr/>
                    </div>
                    
                    <div class="col-md-12">
                        <h5 class="mb-4"><?php echo t('shippinglocationandcost'); ?></h5>
                        <div class="d-block mb-3 mt-4">
							<button type="button" class="btn btn-rounded btn-light" id="addattrvalue"><i class="fe fe-plus mr-md-1"></i> <?php echo t('addservice'); ?></button>
							<script type="text/javascript">
							$( document ).ready(function() {
								$('#addattrvalue').click(function() {
									// Disable button
									$(this).attr('disabled','disabled');
									$(this).addClass('btn-disabled');

                                    $('#loading_ajax').show();

									// proccess
									$.post("<?php echo admin_url($this->uri->segment(2) . '/ajax_addnewservice'); ?>", 
                                    {
                                        CP: '<?php echo get_cookie('sz_token'); ?>'
                                        <?php echo ( is_csrf() ? ','.$this->security->get_csrf_token_name().':"'.$this->security->get_csrf_hash().'"':''); ?>
                                    },
									function(data){
										if( $('tr#novalfound').length ){
											$('tr#novalfound').remove();
										}

										$('#addattrvalue').removeAttr('disabled');
										$('#addattrvalue').removeClass('btn-disabled');
									}).done( function(data){
                                        $('#loading_ajax').hide();

										$('.servicetable tbody').append(data);
									});
								});
							});
							</script>
						</div>

                        <div class="table-responsive-md">
                            <table class="table table-hover table-striped servicetable">
								<thead>
									<tr>
										<th class="text-center" style="width:150px;"><?php echo t('country'); ?> <span class="text-danger">*</span></th>
										<th class="text-center" style="width:150px;"><?php echo t('zone'); ?> <span class="text-danger">*</span></th>
										<th class="text-center"><?php echo t('servicename'); ?></th>
										<th class="text-center" style="width:130px;"><?php echo t('cost'); ?></th>
										<th class="text-center" style="width:130px;">ETD <i class="fe fe-info shiza_tooltip text-blue" title="<?php echo t('estimatedtimeofdelivery'); ?>"></i></th>
										<th class="text-center" style="width:200px;"><?php echo t('note'); ?></th>
										<th style="width:20px;" class="text-center"><i class="fe fe-settings"></i></th>
									</tr>
								</thead>
								<tbody>
                                    <tr id="novalfound"><td colspan="7" class="text-center"><h5 class="py-2"><?php echo t('nodatafound'); ?></h5></td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fe fe-plus"></i> <?php echo t('btnadd'); ?></button>    
            </div>
        </div>

    </div>

</div>
<?php
endif;
echo form_close();

include V_ADMIN_PATH . "footer.php";