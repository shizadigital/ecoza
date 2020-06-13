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

echo form_open( admin_url( $this->uri->segment(2) . '/editprocess'), array( 'id'=>'valid' ), array('ID'=> $data['courierId']) );
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
                    <h5 class="card-title mb-0"><?php echo t('edit') . ' - '.$data['courierName']; ?></h5>
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

                        // image availability
                        $imgcourier = admin_assets('img/no-image2.png');
                        if(!empty($data['courierDirLogo']) AND !empty($data['courierFileLogo'])){
                            $imgcourier = images_url($data['courierDirLogo'].'/small_'.$data['courierFileLogo']);
                        }

                        // make input structure
                        $inputs =  array(
                            array(
                                'type' => 'text',
                                'label' => t('couriername').' <span class="text-red">*</span>',
                                'name' => 'couriername',
                                'value' => $data['courierName']
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('couriercode'),
                                'name' => 'couriercode',
                                'value' => $data['courierCode']
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('urltracking'),
                                'name' => 'urltracking',
                                'value' => $data['courierUrlTracking']
                            ),
                            array(
                                'type' => 'file-img',
                                'label' => t('logo'),
                                'name' => 'logo',
                                'help' => t('infomainimg').' '.$imgext,
                                'value' => $imgcourier
                            ),
                            array(
                                'type' => 'checkbox',
                                'label' => t('freeshipping'),
                                'name' => 'freeshipping',
                                'value' => '1',
                                'title' => t('yes'),
                                'checked' => ($data['courierFreeShipping']=='y')?true:false,
                            ),
                            array(
                                'type' => 'checkbox',
                                'label' => t('active'),
                                'name' => 'active',
                                'value' => '1',
                                'title' => t('yes'),
                                'checked' => ($data['courierStatus']=='1')?true:false,
                            ),
                        );
                        $this->formcontrol->buildInputs($inputs, 'horizontal', array('label'=>'col-md-2', 'input'=>'col-md-9'));
                        ?>
                        <hr/>
                    </div>

                    <div class="col-md-12">
                        <h5 class="mb-4"><?php echo t('sizeandweightsetting'); ?></h5>
                        <?php
                        // max package width
                        $v_MaxWidth = explode('.', $data['courierMaxWidth']);
                        $MaxWidth = $v_MaxWidth[0].( ($v_MaxWidth[1]=='00000000')?'':','.$v_MaxWidth[1] );

                        // max package width
                        $v_MaxHeight = explode('.', $data['courierMaxHeight']);
                        $MaxHeight = $v_MaxHeight[0].( ($v_MaxHeight[1]=='00000000')?'':','.$v_MaxHeight[1] );

                        // max package width
                        $v_MaxLength = explode('.', $data['courierMaxLength']);
                        $MaxLength = $v_MaxLength[0].( ($v_MaxLength[1]=='00000000')?'':','.$v_MaxLength[1] );

                        // max package width
                        $v_MaxWeight = explode('.', $data['courierMaxWeight']);
                        $MaxWeight = $v_MaxWeight[0].( ($v_MaxWeight[1]=='00000000')?'':','.$v_MaxWeight[1] );

                        // make input structure
                        $inputscostmax =  array(
                            array(
                                'type' => 'text',
                                'label' => t('maxpackagewidth'),
                                'name' => 'maxpackagewidth',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => $MaxWidth,
                                'input-group' => array(
                                    'append'=> getLengthDefault(),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('maxpackageheight'),
                                'name' => 'maxpackageheight',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => $MaxHeight,
                                'input-group' => array(
                                    'append'=> getLengthDefault(),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('maxpackagelength'),
                                'name' => 'maxpackagelength',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => $MaxLength,
                                'input-group' => array(
                                    'append'=> getLengthDefault(),
                                )
                            ),
                            array(
                                'type' => 'text',
                                'label' => t('maxpackageweight'),
                                'name' => 'maxpackageweight',
                                'onkeypress'=>'return isNumberComma(event)',
                                'value' => $MaxWeight,
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
                                    <?php 
                                    $countcost = count($couriercost);
                                    if( $countcost > 0 ){
                                        foreach( $couriercost as $val ){
                                            $idrow = generate_code(8);

                                            $wherecountry = "countryDeleted='0' AND countryStatus='1'";
                                            $country = $this->Env_model->view_where_order('countryId,countryName','geo_country',$wherecountry,'countryName','ASC');
                                            
                                            $wherezone = "countryId='".$val['countryId']."'";
                                            $zone = $this->Env_model->view_where_order('zoneId,zoneName','geo_zone',$wherezone,'zoneName','ASC');

                                            // max package width
                                            $v_Cost = explode('.', $val['ccostCost']);
                                            $c_Cost = $v_Cost[0].( ($v_Cost[1]=='00000000')?'':','.$v_Cost[1] );

                                            echo '
                                            <tr id="rowval-'.$idrow.'">
                                                <td class="align-center">
                                                    <select name="country['.$idrow.']" class="custom-select" id="select2product'.$idrow.'">';
                                                    foreach($country AS $v){
                                                        echo '<option value="'.$v['countryId'].'"';
                                                        if( $val['countryId'] == $v['countryId'] ){ echo ' selected="selected"'; }
                                                        echo '>'.$v['countryName'].'</option>';
                                                    }
                                                    echo '
                                                    </select>
                                                </td>
                                                <td class="align-center" id="zoneinput-'.$idrow.'">
                                                    <select name="zone['.$idrow.']" class="custom-select">';
                                                        echo '<option value="">-- '.t('choosecountryfirst').' --</option>';
                                                        foreach($zone AS $vz){
                                                            echo '<option value="'.$vz['zoneId'].'"';
                                                            if( $val['zoneId'] == $vz['zoneId'] ){ echo ' selected="selected"'; }
                                                            echo '>'.$vz['zoneName'].'</option>';
                                                        }
                                                    echo '
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" value="'.$val['ccostService'].'" name="servicename['.$idrow.']" class="form-control">
                                                </td>
                                                <td class="align-center">
                                                    <input type="text" value="'.$c_Cost.'" onkeypress="return isNumberComma(event)" name="cost['.$idrow.']" class="form-control">
                                                </td>
                                                <td class="align-center">
                                                    <input type="text" value="'.$val['ccostETD'].'" onkeypress="return isNumberKey(event)" name="etd['.$idrow.']" class="form-control">
                                                </td>
                                                <td class="align-center">
                                                    <input type="text" value="'.$val['ccostNote'].'" name="note['.$idrow.']" class="form-control">
                                                </td>
                                                <td class="align-center">
                                                    <button class="btn btn-link" id="deleterow-'.$idrow.'" type="button"><i class="text-danger fe fe-trash-2 shiza_tooltip" title="'.t('delete').'"></i></button>

                                                    <script type="text/javascript">
                                                    $( document ).ready(function() {
                                                        $(\'#deleterow-'.$idrow.'\').click(function() {
                                                            $( "#rowval-'.$idrow.'" ).remove();
                                                        });

                                                        $(\'#select2product'.$idrow.'\').change(function() {
                                                            $(\'#zoneinput-'.$idrow.'\').html(\'<div class="text-center"><img src="'.base_assets('img/loader/loading.gif').'" alt="loader"></div>\');

                                                            var idzone = $(this).val();

                                                            // proccess
                                                            $.post("'.admin_url($this->uri->segment(2) . '/ajax_getzone').'", 
                                                            {
                                                                id: idzone,
                                                                idrow: \''.$idrow.'\',
                                                                CP: \''.get_cookie('sz_token').'\'
                                                                '.( is_csrf() ? ','.$this->security->get_csrf_token_name().':"'.$this->security->get_csrf_hash().'"':'').'
                                                            },
                                                            function(data){								
                                                                
                                                            }).done( function(data){
                                                                $(\'#zoneinput-'.$idrow.'\').html(data);
                                                            });
                                                        });
                                                        
                                                    });
                                                    </script>
                                                </td>
                                            </tr>
                                            ';
                                        }
                                    } else {
                                    ?>
                                    <tr id="novalfound">
                                        <td colspan="7" class="text-center"><h5 class="py-2"><?php echo t('nodatafound'); ?></h5></td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>    
            </div>
        </div>

    </div>

</div>
<?php
endif;
echo form_close();

include V_ADMIN_PATH . "footer.php";