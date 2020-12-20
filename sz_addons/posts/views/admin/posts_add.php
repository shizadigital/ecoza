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

if( is_add() ):
echo form_open_multipart( admin_url( $this->uri->segment(2) . '/addprocess'), array( 'id'=>'valid' ) );
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
	<div class="col-md-9">
		<?php 
		$formtitle = array(					
			array(
				'type' => 'multilanguage_text',
				'label' => t('title'),
				'name' => 'title',
				'required' => true,
			),
			array(
				'type' => 'multilanguage_texteditor',
				'texteditor' => 'standard',
				'label' => t('description'),
				'name' => 'desc',
			),
		);
		$this->formcontrol->buildInputs($formtitle);
		?>
		
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0"><span class="heading_text"><?php echo t('optimizationtitle'); ?> (SEO)</span></h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12 mb-4">
						<span class="text-muted">
						<?php echo t('infooptimization'); ?>
						</span>
					</div>
					<div class="col-md-6">
						<?php
						$seoinput1 = array(
							array(
								'type' => 'text',
								'label' => t('title'),
								'name' => 'seo_judul',
							),
							array(
								'type' => 'textarea',
								'label' => t('description'),
								'name' => 'seo_deskripsi',
								'cols' => '30',
								'rows' => '4',
								'help' => t('infodescseo'),
							),
						);

						$this->formcontrol->buildInputs($seoinput1);
						?>
					</div>
					<div class="col-md-6">
						<?php
						$seoinput2 = array(
							array(
								'type' => 'text',
								'label' => t('keyword'),
								'name' => 'kw',
								'help' => t('infokeyword')
							),
							array(
								'type' => 'checkbox',
								'title' => 'Robot Meta NOINDEX',
								'name' => 'noindex',
								'value' => 'noindex',
								'help' => t('infonoindex'),
							),
							array(
								'type' => 'checkbox',
								'title' => 'Robot Meta NOFOLLOW',
								'name' => 'nofollow',
								'value' => 'nofollow',
								'help' => t('infonofollow'),
							),
						);

						$this->formcontrol->buildInputs($seoinput2);
						?>
					</div>
				</div>

			</div>
		</div>

	</div>

	<div class="col-md-3">
		<div class="card">
			<div class="card-body">
				<?php 
				$formtitle = array(
					array(
						'type' => 'checkbox',
						'label'=> t('allowcomments'),
						'name' => 'allowcomment',
						'value' => '1',
						'title' => t('yes'),
						'help' => t('infoallowcomments'),
						'checked' => true
					),
					array(
						'type' => 'checkbox',
						'label'=> t('todraft'),
						'name' => 'draftstatus',
						'value' => '1',
						'title' => t('yes'),
						'help' => t('infotodraft')
					),
					array(
						'type' => 'text',
						'name' => 'editor',
						'label' => t('editor')
					),
				);
				$this->formcontrol->buildInputs($formtitle);
				?>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<?php 
				$formtitle = array(
					array(
						'type' => 'file-img',
						'label' => t('picture'),
						'name' => 'picture',
						'help' => t('infofile') . ' *.jpg, *.jpeg, *.png'
					),
					array(
						'type' => 'multilanguage_text',
						'name' => 'imgcaption',
						'label' => t('imgcaption')
					),
				);
				$this->formcontrol->buildInputs($formtitle);
				?>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="form-group mb-2">
					<label for="kategori" class="req"><?php echo t('categories'); ?></label>
					<div class="p-3" style="max-height:170px; border:1px solid #ddd;overflow:auto; ">
						<?php
							foreach($categories as $id => $k){
								echo "<div class=\"form-check\">
										<input class=\"form-check-input\" type=\"checkbox\" value=\"{$k['catId']}\" id=\"kategori{$k['catId']}\" name=\"kategori[]\" required />
										<label class=\"form-check-label\" for=\"kategori{$k['catId']}\">
											{$k['catName']}
										</label>
									</div>";
							}
						?>
					</div>
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-block btn-primary"><i class="fe fe-plus"></i> <?php echo t('btnadd'); ?></button>
	</div>
</div>
<?php
echo form_close();
endif;
include V_ADMIN_PATH . "footer.php";
