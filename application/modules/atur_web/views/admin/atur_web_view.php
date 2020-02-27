<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
		Register style (CSS)
************************************/
$request_css_files = array(
    'vendors/bootstrap-tagsinput/bootstrap-tagsinput.css',
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
		Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    'vendors/parsley/parsley.config.js',
    'vendors/parsley/parsley.min.js',
    'vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
);
$request_script = "
$( document ).ready(function() {
    $('#valid').parsley();

    $('.auto_tag').tagsinput({
	    tagClass: function(item){
	        return 'bg-blue text-white';
	    }
	});
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
?>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="card card-statistics">

			<?php
			if( is_edit() ):
				echo form_open_multipart( admin_url( $this->uri->segment(2) . '/prosesedit'), array( 'id'=> 'valid' ) );
			?>
            <div class="tab nav-border-bottom">
                <div class="card-header card-header-flex">

                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-bold nav-tabs-noborder nav-tabs-stretched">
                        <li class="nav-item">
                            <a class="nav-link active show" id="umum-tab" data-toggle="tab" href="#umum" role="tab" aria-controls="umum" aria-selected="true"><?php echo t('general'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="mailsetting-tab" data-toggle="tab" href="#mailsetting" role="tab" aria-controls="mailsetting" aria-selected="false"><?php echo t('email'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="socialmedia-tab" data-toggle="tab" href="#socialmedia" role="tab" aria-controls="socialmedia" aria-selected="false"><?php echo t('socialmedia'); ?></a>
                        </li>
                    </ul>
                    
                </div>

                <div class="card-body">
                    <?php 
                    if( !empty( $this->session->has_userdata('succeed') ) ){
                        echo '
                        <div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check"></i> ' . $this->session->flashdata('succeed') . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
                        </div>
                        ';
                    }
                    if( !empty( $this->session->has_userdata('failed') ) ){
                        echo '
                        <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-times"></i> ' . $this->session->flashdata('failed') . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
                        </div>
                        ';
                    }
                    ?>

                    <div class="tab-content">
                        <div class="tab-pane fade py-3 active show" id="umum" role="tabpanel" aria-labelledby="umum-tab">
                            <?php if( $this->session->userdata('leveluser')=='1'){ ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label pt-2" for="httpsmode">https?</label>

                                <div class="col-sm-9 col-md-10">
                                    <div class="custom-control custom-checkbox pt-2">
                                        <input type="checkbox" class="custom-control-input" id="httpsmode" name="httpsmode" value="y"<?php echo get_option('httpsmode')=="yes" ? " checked=\"checked\"":""; ?>>
                                        <label for="httpsmode" class="custom-control-label"><?php echo t('yes'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="fupload"><?php echo t('favicon'); ?></label>

                                <div class="col-sm-9 col-md-10">
                                    <img class="pull-left" src="<?php echo favicon_img_url(); ?>" alt="favicon" style="width:22px; padding:1px; height:22px; border:1px solid #ddd; margin-right:10px;" />
                                    <input type="file" name="favicon" class="fileInput" id="favicon" />
                                    <small class="form-text text-muted"><?php echo t('infofile'); ?> *.jpg, *.jpeg, *.png, *.gif, *.ico</small>
                                </div>
                            </div>

                            <?php 
                            $buildform1 = array(
                                array(
                                    'type' => 'text',
                                    'label' => t('sitename'),
                                    'name' => 'sitename',
                                    'required' => true,
                                    'value' => get_option('sitename')
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => t('tagline'),
                                    'name' => 'tagline',
                                    'required' => false,
                                    'value' => get_option('tagline')
                                ),
                                array(
                                    'type' => 'email',
                                    'label' => t('email'),
                                    'name' => 'email',
                                    'required' => true,
                                    'value' => get_option('siteemail')
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => t('phone'),
                                    'name' => 'sitephone',
                                    'required' => false,
                                    'value' => get_option('sitephone')
                                ),
                                array(
                                    'type' => 'textarea',
                                    'label' => t('webdescription'),
                                    'name' => 'sitedescription',
                                    'required' => false,
                                    'value' => get_option('sitedescription')
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => t('keywords'),
                                    'name' => 'sitekeywords',
                                    'required' => false,
                                    'value' => get_option('sitekeywords'),
                                    'class' => 'auto_tag',
                                    'help' => t('infokeyword')
                                ),
                                array(
                                    'type' => 'file-img',
                                    'label' => t('logo'),
                                    'name' => 'logo',
                                    'value' => logo_url('small'),
                                    'help' => t('infofile') . " *.jpg, *.jpeg, *.png"
                                ),
                                array(
                                    'type' => 'textarea',
                                    'label' => t('address'),
                                    'name' => 'siteaddress',
                                    'required' => false,
                                    'value' => get_option('siteaddress')
                                )
                            );

                            $colsform = array('label'=>'col-sm-3 col-md-2', 'input'=>'col-sm-9 col-md-10');

                            $this->formcontrol->buildInputs( $buildform1, 'horizontal', $colsform );
                            ?>
                        </div>

                        <div class="tab-pane fade py-3" id="mailsetting" role="tabpanel" aria-labelledby="mailsetting-tab">
                        <?php 
                            $buildform2 = array(
                                array(
                                    'type' => 'email',
                                    'label' => t('smtp_useremail'),
                                    'name' => 'smtp_username',
                                    'value' => get_option('smtp_username')
                                ),
                                array(
                                    'type' => 'password',
                                    'label' => t('smtp_password'),
                                    'name' => 'smtp_password',
                                    'value' => ( check_option('smtp_password') ) ? decoder(get_option('smtp_password')) :''
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => t('smtp_host'),
                                    'name' => 'smtp_host',
                                    'value' => get_option('smtp_host')
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => t('smtp_port'),
                                    'name' => 'smtp_port',
                                    'value' => get_option('smtp_port')
                                ),
                                array(
                                    'type' => 'radio',
                                    'label' => t('smtp_securetype'),
                                    'name' => 'smtp_ssltype',
                                    'value' => array(
                                        array(
                                            'title' => t('none'),
                                            'value' => '',
                                            'checked' => ( empty( get_option('smtp_ssltype') ) ) ? true:false,
                                        ),
                                        array(
                                            'title' => 'SSL',
                                            'value' => 'ssl',
                                            'checked' => ( get_option('smtp_ssltype') =='ssl' ) ? true:false,
                                        ),
                                        array(
                                            'title' => 'TLS',
                                            'value' => 'tls',
                                            'checked' => ( get_option('smtp_ssltype') =='tls' ) ? true:false,
                                        ),
                                    ),
                                    'layout' => 'horizontal',
                                ),
                                array(
                                    'type' => 'textarea',
                                    'label' => t('emailsignature'),
                                    'name' => 'emailsignature',
                                    'value' => get_option('emailsignature')
                                ),
                            );

                            $colsform = array('label'=>'col-sm-3 col-md-2', 'input'=>'col-sm-9 col-md-10');

                            $this->formcontrol->buildInputs( $buildform2, 'horizontal', $colsform );
                            ?>
                        </div>

                        <div class="tab-pane fade py-3" id="socialmedia" role="tabpanel" aria-labelledby="socialmedia-tab">
                            <?php 
                            $buildform3 = array(
                                array(
                                    'type' => 'text',
                                    'label' => 'Facebook',
                                    'name' => 'facebook',
                                    'value' => get_social_url('facebook'),
                                    'data-parsley-type' => 'url'
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => 'Twitter',
                                    'name' => 'twitter',
                                    'value' => get_social_url('twitter'),
                                    'data-parsley-type' => 'url'
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => 'Youtube',
                                    'name' => 'youtube',
                                    'value' => get_social_url('youtube'),
                                    'data-parsley-type' => 'url'
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => 'Instagram',
                                    'name' => 'instagram',
                                    'value' => get_social_url('instagram'),
                                    'data-parsley-type' => 'url'
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => 'Line',
                                    'name' => 'line',
                                    'value' => get_social_url('line'),
                                    'data-parsley-type' => 'url'
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => 'Whatsapp',
                                    'name' => 'whatsapp',
                                    'value' => get_social_url('whatsapp')
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => 'Play Store Apps',
                                    'name' => 'googleplay',
                                    'value' => get_social_url('googleplay'),
                                    'data-parsley-type' => 'url'
                                ),
                            );

                            $colsform = array('label'=>'col-sm-3 col-md-2', 'input'=>'col-sm-9 col-md-10');

                            $this->formcontrol->buildInputs( $buildform3, 'horizontal', $colsform );
                            ?>
                        </div>
                    </div>

                    <div class="form-group mb-5">
                        <hr/>
                        <button class="btn btn-primary float-right" type="submit"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
                    </div>

                </div>
            </div>

			<?php 
				echo form_close();
			endif;
			?>

		</div>
	</div>
</div>
<?php 
include V_ADMIN_PATH . "footer.php";
?>