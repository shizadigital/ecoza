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
					<h5 class="card-title mb-0"><?php echo t('editmanufacturer') . ' - ' .$data['manufactName']; ?></h5>
				</div>
			</div>

			<div class="card-body">
			<?php 
				// make tag form structure
				$tagForm = array(
					'action' 		=> admin_url( $this->uri->segment(2) . '/editprocess'),
					'attributes' 	=> array( 'id'=>'valid' ),
					'hidden' 		=> array('ID' => $data['manufactId'])
                );
                
                // image availability
                $imgmanufacturer = admin_assets('img/no-image2.png');
                if(!empty($data['manufactDir']) AND !empty($data['manufactImg'])){
                    $imgmanufacturer = images_url($data['manufactDir'].'/small_'.$data['manufactImg']);
                }
				
				// make input structure
				$inputs = array(
					'layout' => 'horizontal',
					'colsetting' => array('label'=>'col-md-2','input'=>'col-md-9'),
					'inputs' => array(
						array(
							'type' => 'text',
							'label' => t('name'),
							'name' => 'nama',
							'required' => true,
							'value' => $data['manufactName']
						),
						array(
							'type' => 'text',
							'label' => t('slug'),
							'name' => 'slug',
							'required' => true,
							'value' => $data['manufactSlug'],
							'help' => t('sluginfo')
						),
						array(
							'type' => 'multilanguage_textarea',
							'label' => t('description'),
							'name' => 'desc',
							'value' => array(
								'table' => 'manufacturers',
								'field' => 'manufactDesc',
								'id' => $data['manufactId']
							)
                        ),
                        array(
                            'type' => 'file-img',
                            'label' => t('picture'),
                            'name' => 'picture',
							'value' => $imgmanufacturer,
                            'help' => t('infomainimg') . ' *.jpg, *.jpeg, *.png, *.gif'
                        ),
						array(
							'type' => 'text',
							'label' => t('sorting'),
							'name' => 'sorting',
							'value' => $data['manufactSort'],
							'help' => t('writewithnumbers')
						),
						array(
							'type' => 'checkbox',
							'label' => t('active'),
							'name' => 'active',
							'value' => 'y',
							'title' => t('yes'),
							'checked' => ($data['manufactActive']=='y') ?true:false
						),
						array(
							'type' => 'submit',
							'label' => '<i class="fe fe-refresh-cw"></i> '. t('btnupdate'),
							'class' => 'btn-primary',
						)
					),
								
				);

				$this->formcontrol->buildForm($tagForm, $inputs, 'multipart');
				?>
			</div>
		</div>

	</div>
</div>
<?php 
}

include V_ADMIN_PATH . "footer.php";
?>
