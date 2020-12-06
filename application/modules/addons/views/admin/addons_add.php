<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
		Register style (CSS)
************************************/
$request_css_files = array(
	'vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css'
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
		Register Script (JavaScript)
*******************************************/
$request_script_files = array(
);
$request_script = "
$( document ).ready(function() {
    // submit data
    ajaxSubmit('#valid');
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if( is_add() ){
?>
<div class="row justify-content-md-center">
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
	<div class="col-md-6">

		<div class="card card-statistics">
			<div class="card-header">
				<div class="card-heading">
					<h5 class="card-title mb-0"><?php echo t('uploadaddons'); ?></h5>
				</div>
			</div>

			<div class="card-body">
				<?php 
				echo form_open( admin_url( $this->uri->segment(2) . '/uploadaddon'), array( 'id'=>'valid' ) );
				// make input structure
				$inputs = array(
						array(
							'type' => 'file',
							'label' => '<h5>'.t('uploadaddonsdesc').'</h5>',
							'name' => 'addons',
							'help' => t('infofile') . '*.zip',
							'accept' => "application/x-zip,application/zip,application/x-zip-compressed,application/s-compressed,multipart/x-zip",
						),
						array(
							'type' => 'submit',
							'label' => '<i class="fe fe-upload"></i> '. t('uploadaddons'),
							'class' => 'btn-primary'
						)	
				);

				$this->formcontrol->buildInputs($inputs);
				echo form_close();
				?>
			</div>
		</div>

	</div>
</div>
<?php 
}

include V_ADMIN_PATH . "footer.php";
?>
