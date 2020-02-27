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

if( is_edit() ):
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
                    
                    <div class="col-md-9">
                    <?php
                        // hidden field form
                        $hidden = array('ID' => $data['levelId'] );

                        // make tag form structure
                        $tagForm = array(
                            'action' 		=> admin_url( $this->uri->segment(2) . '/prosesedit/'),
                            'attributes' 	=> array( 'id'=>'valid' ),
                            'hidden'        => $hidden
                        );

                        // radio button condition

                        if( $data['levelId']!='1'){
                            $activestatus = array(
                                                'type' => 'radio',
                                                'label' => t('active'),
                                                'name' => 'mod_active',
                                                'value' => array(
                                                    array(
                                                        'title'=> t('yes'),
                                                        'value'=> 'y',
                                                        'checked' => ($data['levelActive']=='y') ? true:false,
                                                    ),
                                                    array(
                                                        'title'=> t('no'),
                                                        'value'=> 'n',
                                                        'checked' => ($data['levelActive']=='n') ? true:false,
                                                    ),
                                                ),
                                                'layout' => 'horizontal',
                                            );
                        } else { 
                            $activestatus = array(
                                'type' => 'content',
                                'label' => t('active'),
                                'value' => '<p class="badge badge-success">'.t('yes').'</p>'
                            );
                        }

                        // make input structure
                        $inputs = array(
                            'layout' => 'horizontal',
                            'colsetting' => array('label'=>'col-sm-3 col-md-2', 'input'=>'col-sm-9 col-md-10'),
                            'inputs' => array(
                                array(
                                    'type' => 'text',
                                    'label' => t('name'),
                                    'name' => 'access_name',
                                    'required' => true,
                                    'value' => $data['levelName']
                                ),
                                $activestatus,                                
                                array(
                                    'type' => 'submit',
                                    'label' => '<i class="fe fe-plus"></i> '.t('btnupdate'),
                                    'class' => 'btn-primary',
                                    'bordertop' => true
                                )
                            ),
                                        
                        );

                        $this->formcontrol->buildForm($tagForm, $inputs);
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<?php 
endif;
 
include V_ADMIN_PATH . "footer.php";
?>