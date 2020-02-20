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
                            <a class="nav-link active show" id="umum-tab" data-toggle="tab" href="#umum" role="tab" aria-controls="umum" aria-selected="true">Umum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="mailsetting-tab" data-toggle="tab" href="#mailsetting" role="tab" aria-controls="mailsetting" aria-selected="false">Email</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="socialmedia-tab" data-toggle="tab" href="#socialmedia" role="tab" aria-controls="socialmedia" aria-selected="false">Sosial Media</a>
                        </li>
                    </ul>
                    
                </div>

                <div class="card-body">
                    <?php 
                    if( !empty( $this->session->has_userdata('sukses') ) ){
                        echo '
                        <div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check"></i> ' . $this->session->flashdata('sukses') . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
                        </div>
                        ';
                    }
                    if( !empty( $this->session->has_userdata('gagal') ) ){
                        echo '
                        <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
                            <i class="fa fa-times"></i> ' . $this->session->flashdata('gagal') . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
                        </div>
                        ';
                    }
                    ?>

                    <div class="tab-content">
                        <div class="tab-pane fade py-3 active show" id="umum" role="tabpanel" aria-labelledby="umum-tab">
                            <?php if( $this->session->userdata('leveluser')=='1'){ ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="httpsmode">https?</label>

                                <div class="col-sm-9 col-md-10">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="httpsmode" name="httpsmode" value="y"<?php echo get_option('httpsmode')=="yes" ? " checked=\"checked\"":""; ?>>
                                        <label for="httpsmode" class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="fupload">Favicon</label>

                                <div class="col-sm-9 col-md-10">
                                    <img class="pull-left" src="<?php echo favicon_img_url(); ?>" alt="favicon" style="width:22px; padding:1px; height:22px; border:1px solid #ddd; margin-right:10px;" />
                                    <input type="file" name="favicon" class="fileInput" id="favicon" />
                                    <small class="form-text text-muted">Ekstensi yang diizinkan *.jpg, *.jpeg, *.png, *.gif, *.ico</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label req" for="sitename">Judul Website</label>
                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_option('sitename'); ?>" class="form-control" id="sitename" name="sitename" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="tagline">Tagline</label>
                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_option('tagline'); ?>" class="form-control" id="tagline" name="tagline" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label req" for="email">Email Website</label>
                                <div class="col-sm-9 col-md-10">
                                    <input type="email" value="<?php echo get_option('siteemail'); ?>" class="form-control" id="email" name="email" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="sitephone">Telp/Hp</label>
                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_option('sitephone'); ?>" class="form-control" id="sitephone" name="sitephone" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="sitedescription">Deskripsi Website</label>

                                <div class="col-sm-9 col-md-10">
                                    <textarea id="sitedescription" name="sitedescription" cols="30" rows="4" class="form-control"><?php echo get_option('sitedescription'); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="sitekeywords">Kata Kunci</label>
                                <div class="col-sm-9 col-md-10">
                                    <input type="text" class="auto_tag" id="sitekeywords" name="sitekeywords" value="<?php echo get_option('sitekeywords'); ?>" />
                                    <small class="form-text text-muted">Pisahkan kata kunci dengan tanda koma (,)</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="logo">Logo</label>
                                <div class="col-sm-9 col-md-10">
                                    <div class="mb-3" style="display: block;">
                                        <img class="pull-left" src="<?php echo logo_url('small'); ?>" alt="logo" style="padding:1px; height:70px; max-width: 100%;border:1px solid #ddd; margin-right:10px; background: #eee;" />
                                    </div>
                                    <div class="clearfix"></div>
                                    <input type="file" name="logo" class="fileInput" id="logo" />
                                    <small class="form-text text-muted">Ekstensi yang diizinkan *.jpg, *.jpeg, *.png</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="siteaddress">Alamat</label>

                                <div class="col-sm-9 col-md-10">
                                    <textarea id="siteaddress" name="siteaddress" cols="30" rows="4" class="form-control"><?php echo get_option('siteaddress'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade py-3" id="mailsetting" role="tabpanel" aria-labelledby="mailsetting-tab">
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="smtp_username">Nama User SMTP</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="email" value="<?php echo get_option('smtp_username'); ?>" class="form-control" id="smtp_username" name="smtp_username" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="smtp_password">Password SMTP</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="password" value="<?php echo ( check_option('smtp_password') ) ? decoder(get_option('smtp_password')) :''; ?>" class="form-control" id="smtp_password" name="smtp_password" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="smtp_host">Host SMTP</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_option('smtp_host'); ?>" class="form-control" id="smtp_host" name="smtp_host" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="smtp_port">Port SMTP</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_option('smtp_port'); ?>" class="form-control" id="smtp_port" name="smtp_port" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label">Tipe SSL SMTP</label>

                                <div class="col-sm-9 col-md-10">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" id="smtptypenone" name="smtp_ssltype" value=""<?php echo ( empty( get_option('smtp_ssltype') ) ) ? ' checked="checked"':''; ?>>
                                        <label class="custom-control-label" for="smtptypenone">
                                            Tidak Ada
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" id="smtptypessl" name="smtp_ssltype" value="ssl"<?php echo ( get_option('smtp_ssltype') =='ssl' ) ? ' checked="checked"':''; ?>>
                                        <label class="custom-control-label" for="smtptypessl">
                                            SSL
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input class="custom-control-input" type="radio" id="smtptypetls" name="smtp_ssltype" value="tls"<?php echo ( get_option('smtp_ssltype') =='tls' ) ? ' checked="checked"':''; ?>>
                                        <label class="custom-control-label" for="smtptypetls">
                                            TLS
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr/>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="emailsignature">Tanda Tangan Email</label>
                                <div class="col-sm-9 col-md-10">
                                    <textarea type="text" cols="30" rows="4" class="form-control" id="emailsignature" name="emailsignature"><?php echo get_option('emailsignature'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade py-3" id="socialmedia" role="tabpanel" aria-labelledby="socialmedia-tab">
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="fb">Facebook</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_social_url('facebook'); ?>" class="form-control" id="fb" name="facebook" data-parsley-type="url" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="twitter">Twitter</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_social_url('twitter'); ?>" class="form-control" id="twitter" name="twitter" data-parsley-type="url" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="youtube">Youtube</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_social_url('youtube'); ?>" class="form-control" id="youtube" name="youtube" data-parsley-type="url" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="instagram">Instagram</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_social_url('instagram'); ?>" class="form-control" id="instagram" name="instagram" data-parsley-type="url" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="line">Line</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_social_url('line'); ?>" class="form-control" id="line" name="line" data-parsley-type="url" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="whatsapp">Whatsapp</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_social_url('whatsapp'); ?>" class="form-control" id="whatsapp" name="whatsapp" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-md-2 col-form-label" for="googleplay">Play Store Apps</label>

                                <div class="col-sm-9 col-md-10">
                                    <input type="text" value="<?php echo get_social_url('googleplay'); ?>" class="form-control" id="googleplay" name="googleplay" data-parsley-type="url" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-5">
                        <hr/>
                        <button class="btn btn-primary float-right" type="submit"><i class="fe fe-refresh-cw"></i> Perbarui</button>
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