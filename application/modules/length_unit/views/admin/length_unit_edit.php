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

if( is_edit() ){
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
					<h5 class="card-title mb-0"><?php echo t('editlength'); ?></h5>
				</div>
			</div>

			<div class="card-body">
			<?php 
				// make tag form structure
				$tagForm = array(
					'action' 		=> admin_url( $this->uri->segment(2) . '/editprocess'),
					'attributes' 	=> array( 'id'=>'valid' ),
					'hidden' 		=> array('ID' => $data['lengthId'])
				);
				
				// make input structure
				$inputs = array(
					'layout' => 'horizontal',
					'colsetting' => array('label'=>'col-md-2','input'=>'col-md-9'),
					'inputs' => array(
						array(
							'type' => 'multilanguage_text',
							'label' => t('unitname'),
							'name' => 'unitname',
							'required' => true,
                            'help' => t('example').": kg",
                            'value' => array(
                                'table' => 'unit_length',
                                'field' => 'lengthUnit',
                                'id' => $data['lengthId']
                            )
						),
						array(
							'type' => 'multilanguage_text',
							'label' => t('unitexplanation'),
							'name' => 'unitexplanation',
							'required' => true,
							'help' => t('example').": Kilogram",
                            'value' => array(
                                'table' => 'unit_length',
                                'field' => 'lengthTitle',
                                'id' => $data['lengthId']
                            )
						),
						array(
							'type' => 'text',
							'label' => t('value'),
							'name' => 'value',
							'onkeypress' => 'return isNumberComma(event)',
							'help' => t('commainfo'),
                            'required' => true,
                            'value' => str_replace('.',',',$data['lengthValue']),
                        ),
						array(
							'type' => 'checkbox',
							'label' => t('default'),
							'name' => 'default',
							'value' => 'y',
							'title' => t('yes'),
							'checked' => ($data['lengthDefault']=='y') ?true:false
						),
						array(
							'type' => 'submit',
							'label' => '<i class="fe fe-refresh-cw"></i> '. t('btnupdate'),
                            'class' => 'btn-primary',
                            'bordertop'=>true
                            
						)
					),
								
				);

				$this->formcontrol->buildForm($tagForm, $inputs);
				?>
			</div>
		</div>

	</div>
</div>
<?php 
}

include V_ADMIN_PATH . "footer.php";
?>