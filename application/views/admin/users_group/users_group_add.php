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

if( is_view() ):
echo form_open( admin_url( $this->uri->segment(2).'/prosestambah/' ), array( 'id'=>'valid') );
?>
<div class="row">

    <div class="col-md-12">
        <div class="card card-statistics">
            <div class="card-header">
                <div class="card-heading">
                    <h4 class="card-title"><?php echo $title_page; ?></h4>
                </div>
            </div>
            <div class="card-body">
                <?php 
                if( !empty( $this->session->has_userdata('sukses') ) ){
                    echo '
                    <div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check"></i> ' . $this->session->flashdata('sukses') . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="mi-close"></i></button>
                    </div>
                    ';
                }
                if( !empty( $this->session->has_userdata('gagal') ) ){
                    echo '
                    <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-times"></i> ' . $this->session->flashdata('gagal') . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="mi-close"></i></button>
                    </div>
                    ';
                }            
                ?>
                <div class="row">
                    
                    <div class="col-md-9">
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-2 col-form-label req"  for="access_name">Nama</label>
                            <div class="col-sm-9 col-md-10">
                                <input type="text" class="form-control" id="access_name" name="access_name" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-md-2 col-form-label" for="mod_active">Aktif</label>

                            <div class="col-sm-9 col-md-10">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="mod_active" id="y" value="y" checked="checked" />
                                    <label class="custom-control-label" for="y">
                                        Ya
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="mod_active" id="n" value="n" />
                                    <label class="custom-control-label" for="n">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr/>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="far icon-plus3"></i> Tambah</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<?php 
echo form_close();
endif;

include V_ADMIN_PATH . "footer.php";
?>