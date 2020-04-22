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

if( is_edit() ):
$inputhidden = array('ID' => $data['userId'], 'old_email' => $data['userEmail']);
echo form_open_multipart( admin_url( $this->uri->segment(2) . '/prosesedit'), array( 'id'=>'valid' ), $inputhidden ); ?>
<div class="row">

    <div class="col-md-12">
        <div class="card card-statistics">
            <div class="card-header">
                <div class="card-heading">
                    <h4 class="card-title mb-0"><?php echo t('edit'); ?></h4>
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

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" disabled="disabled" value="<?php echo $data['userLogin']; ?>" required />
                        </div>

                        <div class="form-group">
                            <label class="req" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['userEmail']; ?>" required />
                        </div>

                        <div class="form-group">
                            <label class="req" for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['userDisplayName']; ?>" required />
                        </div>

                        <?php if( ($this->session->userdata('leveluser')=='1' OR $this->session->userdata('leveluser')=='2') ){ ?>
                        <div class="form-group">
                            <label class="req" for="level">Level</label>
                            <select class="custom-select" id="level" name="level" data-parsley-required="true">
                                <option value="">-- Pilih Level --</option>
                                <?php 
                                foreach ($datalevel AS $dua) {
                                    echo "<option value=\"{$dua['levelId']}\"";
                                    if($dua['levelId'] == $data['levelId']){
                                    	echo ' selected="selected"';
                                    }
                                    echo ">{$dua['levelName']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php } else { echo '<input type="hidden" name="level" value="'.$data['levelId'].'">'; } ?>

                        <?php if( ($data['levelId']!='1' AND $data['userId']!='1') AND $this->session->userdata('leveluser')!=$data['levelId']){ ?>
                        <div class="form-group">
                            <label for="blokir">Blokir akun ini</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="blokir" name="block" value="y"<?php if($data['userBlocked']=='y'){ echo " checked=\"checked\""; } ?> />
                                <label for="blokir" class="form-check-label">Ya</label>
                            </div>
                        </div>
                        <?php } else { echo '<input type="hidden" name="block" value="n">'; } ?>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pwdSt_password">Password</label>
                            <div id="pwd-container">
                                <input type="password" class="form-control sepH_a" id="pwdSt_password" name="pass" />
                                <div class="pwstrength_viewport_progress sepH_b"></div>
                                <span class="form-text pwstrength_viewport_verdict"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="repeat_password">Ulangi Password</label>
                            <input type="password" class="form-control" id="repeat_password" name="ulang_pass" data-parsley-equalto="#pwdSt_password" />
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <img src="<?php print $potoadmin; ?>" />
                                </div>
                            </div>
                            <input type="file" name="fupload" class="fileInput" id="fupload" />
                            <small class="form-text text-muted">Ekstensi yang diizinkan *.jpg, *.jpeg, *.png</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr/>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i class="fe fe-refresh-cw"></i> Perbarui</button>
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