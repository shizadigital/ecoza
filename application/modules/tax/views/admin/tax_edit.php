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
					<h5 class="card-title mb-0"><?php echo t('edittax'); ?></h5>
				</div>
			</div>

			<div class="card-body">
            <?php 
                $typetax = array('percentage'=> t('percentage').' (%)', 'fixed'=>t('fixedamount'));

				// make tag form structure
				$tagForm = array(
					'action' 		=> admin_url( $this->uri->segment(2) . '/editprocess'),
					'attributes' 	=> array( 'id'=>'valid' ),
					'hidden' 		=> array('ID' => $data['taxId'])
				);
				
				// make input structure
				$inputs = array(
					'layout' => 'horizontal',
					'colsetting' => array('label'=>'col-md-2','input'=>'col-md-9'),
					'inputs' => array(
						array(
							'type' => 'multilanguage_text',
							'label' => t('name'),
							'name' => 'name',
							'required' => true,
                            'help' => t('taxnameinfo'),
                            'value'=> array(
                                'table' => 'tax',
                                'field' => 'taxName',
                                'id' => $data['taxId']
                            ),
						),
						array(
							'type' => 'text',
							'label' => t('rate'),
							'name' => 'rate',
							'required' => true,
                            'help' => t('format').": 123,12 ".t('or')." 123,123",
                            'onkeypress' => 'return isNumberComma(event)',
                            'value' => singleComma($data['taxRate'],'.',',')
						),
						array(
							'type' => 'select',
							'label' => t('type'),
							'name' => 'type',
							'option' => $typetax,
							'selected' => $data['taxType']
						), 
						array(
							'type' => 'checkbox',
							'label' => t('active'),
							'name' => 'active',
							'value' => 'y',
							'title' => t('yes'),
							'checked' => ($data['taxActive']=='y') ?true:false
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
