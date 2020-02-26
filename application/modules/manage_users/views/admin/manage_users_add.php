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
    'vendors/hideShowPassword/hideShowPassword.min.js',
    'vendors/pwstrength.bootstrap/pwstrength-bootstrap.min.js'
);
$request_script = "
$( document ).ready(function() {
    $('#valid').parsley();
    $('#repeat_password').hidePassword(true);
    $('#pwdSt_password').hidePassword(true);

    var options = {};
    options.ui = {
        verdicts: ['Weak', 'Normal', 'Medium', 'Strong', 'Very Strong'],
        container: '#pwd-container',
        showVerdictsInsideProgressBar: true,
        viewports: {
            progress: '.pwstrength_viewport_progress'
        }
    };
    $('#pwdSt_password').pwstrength(options);
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if( is_add() ):
echo form_open_multipart( admin_url( $this->uri->segment(2) . '/prosestambah'), array( 'id'=>'valid' ) ); ?>
<div class="row">

    <div class="col-md-12">
        <div class="card card-statistics">
            <div class="card-header">
                <div class="card-heading">
                    <h4 class="card-title mb-0"><?php echo t('addnew'); ?></h4>
                </div>
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

                <div class="row">
                    <div class="col-md-6">
                        <?php 
                            $optionlevel = array(''=>'-- Pilih Level --');
                            foreach ($datalevel AS $dua) {
                                $optionlevel[$dua['levelId']] = $dua['levelName'];
                            }

                            $buildform1 = array(
                                array(
                                    'type' => 'text',
                                    'label' => t('username'),
                                    'name' => 'username',
                                    'required' => true,
                                ),
                                array(
                                    'type' => 'email',
                                    'label' => t('email'),
                                    'name' => 'email',
                                    'required' => true,
                                ),
                                array(
                                    'type' => 'text',
                                    'label' => t('name'),
                                    'name' => 'nama',
                                    'required' => true,
                                ),
                                array(
                                    'type' => 'select',
                                    'label' => t('level'),
                                    'name' => 'level',
                                    'option' => $optionlevel,
                                    'required' => true,
                                )
                            );

                            $this->formcontrol->buildInputs($buildform1);
                        ?>                        
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="req" for="pwdSt_password"><?php echo t('password'); ?></label>
                            <div id="pwd-container">
                                <input type="password" class="form-control sepH_a" id="pwdSt_password" name="pass" required />
                                <div class="pwstrength_viewport_progress sepH_b"></div>
                                <span class="form-text pwstrength_viewport_verdict"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="req" for="repeat_password"><?php echo t('repeatpassword'); ?></label>
                            <input type="password" class="form-control" id="repeat_password" name="ulang_pass" data-parsley-equalto="#pwdSt_password" required />
                        </div>

                        <?php                             
                            $buildform2 = array(
                                array(
                                    'type' => 'file',
                                    'label' => t('picture'),
                                    'name' => 'fupload',
                                    'help' => t('infofile') . ' *.jpg, *.jpeg, *.png'
                                )
                            );

                            $this->formcontrol->buildInputs($buildform2);
                        ?>
                    </div>

                    <div class="col-md-12">
                        <hr/>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fe fe-plus"></i> <?php echo t('btnadd'); ?></button>
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