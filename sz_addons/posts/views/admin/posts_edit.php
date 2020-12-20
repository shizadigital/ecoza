<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
Register style (CSS)
************************************/
$request_css_files = array(
    'vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
    'vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
    'vendors/tempus-dominus-bs4/build/css/tempusdominus-bootstrap-4.min.css',
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    'vendors/parsley/parsley.config.js',
	'vendors/parsley/parsley.min.js',
    'vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
    'vendors/moment/min/moment.min.js',
    'vendors/tempus-dominus-bs4/build/js/tempusdominus-bootstrap-4.min.js'
);
$request_script = "
$( document ).ready(function() {
	$('#valid').parsley();

	$('.tglpicker').datepicker({
        autoclose: true,
        orientation: \"bottom\",
        endDate: \"".date("d/m/Y")."\",
        templates: {
            leftArrow: '<i class=\"fe fe-chevrons-left\"></i>',
            rightArrow: '<i class=\"fe fe-chevrons-right\"></i>'
        },
        format:\"dd-mm-yyyy\"
    });

    $('.tanggalpicker').click(function(event) {
        console.log('Preventing');
        event.preventDefault();
        event.stopPropagation();
	});
	
	$('.timepicker').datetimepicker({
        format: 'HH:mm',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-arrow-up',
            down: 'fa fa-arrow-down',
            previous: 'fa fa-arrow-left',
            next: 'fa fa-arrow-right',
        },
    });
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if( is_add() ):
$hidden = array('ID'=>$data['contentId']);
echo form_open_multipart( admin_url( $this->uri->segment(2) . '/editprocess'), array( 'id'=>'valid' ), $hidden );
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
				'value' => array(
					'table' => 'contents',
					'field' => 'contentTitle',
					'id' => $data['contentId']
				)
			),
			array(
				'type' => 'text',
				'label' => t('slug'),
				'name' => 'postslug',
				'value' => $data['contentSlug'],
				'input-group' => array(
					'prepend' => base_url('post/'.$data['contentId'].'-')
				),
				'help' => t('sluginfo'),
				'required' => true
			),
			array(
				'type' => 'multilanguage_texteditor',
				'texteditor' => 'standard',
				'label' => t('description'),
				'name' => 'desc',
				'value' => array(
					'table' => 'contents',
					'field' => 'contentPost',
					'id' => $data['contentId']
				)
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
					<?php
                        $seodata = getSeoPage($data['contentId'],'post');
                        $exprobot = explode(",", $seodata['seoRobots']);
                
                        $robotseo_0 = empty($exprobot[0]) ? '' : $exprobot[0];
						$robotseo_1 = empty($exprobot[1]) ? '' : $exprobot[1];
					?>
					<div class="col-md-6">
						<?php
						$seoinput1 = array(
							array(
								'type' => 'text',
								'label' => t('title'),
								'name' => 'seo_judul',
								'value' => $seodata['seoTitle']
							),
							array(
								'type' => 'textarea',
								'label' => t('description'),
								'name' => 'seo_deskripsi',
								'cols' => '30',
								'rows' => '4',
								'help' => t('infodescseo'),
								'value' => $seodata['seoDesc']
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
								'help' => t('infokeyword'),
								'value'=> $seodata['seoKeyword']
							),
							array(
								'type' => 'checkbox',
								'title' => 'Robot Meta NOINDEX',
								'name' => 'noindex',
								'value' => 'noindex',
								'help' => t('infonoindex'),
								'checked' => ($robotseo_0=='noindex' OR $robotseo_1=='noindex')?true:false
							),
							array(
								'type' => 'checkbox',
								'title' => 'Robot Meta NOFOLLOW',
								'name' => 'nofollow',
								'value' => 'nofollow',
								'help' => t('infonofollow'),
								'checked' => ($robotseo_0=='nofollow' OR $robotseo_1=='nofollow')?true:false
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
						'checked' => ($data['contentCommentStatus']==1)?true:false
					),
					array(
						'type' => 'checkbox',
						'label'=> t('todraft'),
						'name' => 'draftstatus',
						'value' => '1',
						'title' => t('yes'),
						'help' => t('infotodraft'),
						'checked' => ($data['contentStatus']==1)?false:true
					),
					array(
						'type' => 'text',
						'name' => 'editor',
						'label' => t('editor'),
						'value'=> $data['contentEditor']
					),
				);
				$this->formcontrol->buildInputs($formtitle);
				?>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<?php 
				// image availability
                $imgcategory = admin_assets('img/no-image2.png');
                if(!empty($data['contentDirImg']) AND !empty($data['contentImg'])){
                    $imgcategory = images_url($data['contentDirImg'].'/medium_'.$data['contentImg']);
				}
				
				$formtitle = array(
					array(
						'type' => 'file-img',
						'label' => t('picture'),
						'name' => 'picture',
						'help' => t('infofile') . ' *.jpg, *.jpeg, *.png',
						'value' => $imgcategory,
					),
					array(
						'type' => 'multilanguage_text',
						'name' => 'imgcaption',
						'label' => t('imgcaption'),
						'value' => array(
							'table' => 'contents',
							'field' => 'contentCaptionImg',
							'id' => $data['contentId']
						)
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
										<input class=\"form-check-input\" type=\"checkbox\" value=\"{$k['catId']}\" id=\"kategori{$k['catId']}\" name=\"kategori[]\"";
								
								if(in_array($k['catId'],$categories_selected)){
									echo " checked=\"checked\"";
								}

								echo " required />
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
		<div class="card">
			<div class="card-body">
				<?php 
				$ex_jam = explode(":", $data['contentHour']);
				$jam = $ex_jam[0].":".$ex_jam[1];
				$formtitle = array(
					array(
						'type' => 'text',
						'label' => t('date'),
						'name' => 'addeddate',
						'class' => 'tglpicker',
						'onkeydown' => "return false",
						'input-group' => array(
							'append' => '<span class="input-group-text"><i class="fe fe-calendar"></i></span>'
						),
						'value' => $data['contentDd'].'-'.$data['contentMm'].'-'.$data['contentYy'],
						'required' => true,
					),
					array(
						'type' => 'text',
						'label' => t('time'),
						'name' => 'addedtime',
						'class' => 'timepicker',
						'onkeydown' => "return false",
						'data-toggle' => "datetimepicker",
						'data-target' => "#addedtime",
						'input-group' => array(
							'append' => '<span class="input-group-text"><i class="fe fe-clock"></i></span>'
						),
						'value' => $jam,
						'required' => true,
					),
				);
				$this->formcontrol->buildInputs($formtitle);
				?>
			</div>
		</div>

		<button type="submit" class="btn btn-block btn-primary"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
	</div>
</div>
<?php
echo form_close();
endif;
include V_ADMIN_PATH . "footer.php";
