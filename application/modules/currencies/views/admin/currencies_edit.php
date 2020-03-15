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
    <div class="card card-statistics">

        <div class="card-header">
            <div class="card-heading">
                <h4 class="card-title mb-0"><?php echo t('addnew'); ?></h4>
            </div>
        </div>

        <div class="card-body">
            <?php
                // make tag form structure
				$tagForm = array(
					'action' 		=> admin_url( $this->uri->segment(2) . '/editproccess'),
                    'attributes' 	=> array( 'id'=>'valid' ),                    
					'hidden' 		=> array('ID' => $data['curId'])
                );
                
                // make input structure
				$inputs = array(
                    'layout' => 'horizontal',
                    'colsetting' => array('label'=>'col-md-3', 'input'=>'col-md-7'),
					'inputs' => array(
						array(
							'type' => 'text',
							'label' => t('title'),
							'name' => 'judul',
                            'required' => true,
                            'value' => $data['curTitle']
						),
						array(
							'type' => 'text',
							'label' => t('code'),
							'name' => 'kode',
							'required' => true,
                            'value' => $data['curCode']
						),
						array(
							'type' => 'text',
							'label' => t('prefixsymbol'),
							'name' => 'prefix',
                            'value' => $data['curPrefixSymbol']
						),
						array(
							'type' => 'text',
							'label' => t('suffixsymbol'),
							'name' => 'suffix',
                            'value' => $data['curSuffixSymbol']
						),
						array(
							'type' => 'text',
							'label' => t('decimalplaces'),
                            'name' => 'decimal_place',
							'required' => true,
                            'onkeypress' => 'return isNumberKey(event)',
                            'maxlength' => '1',
                            'value' => $data['curDecimalPlace']
                        ),
						array(
							'type' => 'text',
							'label' => t('ratevalue'),
                            'name' => 'rate',
							'required' => true,
                            'onkeypress' => 'return isNumberComma(event)',
                            'info' => t('ratevaluetooltip'),
                            'help' => t('seperatewithcomma'),
                            'value' => str_replace('.',',', $data['curRate']) 
						),
						array(
							'type' => 'text',
							'label' => t('todefaultcurrency'),
                            'name' => 'rate_foreign',
							'required' => true,
                            'onkeypress' => 'return isNumberComma(event)',
                            'info' => t('todefaultcurrencytooltip'),
                            'help' => t('seperatewithcomma'),
                            'value' => str_replace('.',',', $data['curForeignCurrencyToDefault'])
                        ),
                        array(
                            'type' => 'select',
                            'label' => t('status'),
                            'name' => 'status',
                            'option' => array(
                                '1' => t('enable'),
                                '0' => t('disable')
                            ),
                            'selected' => $data['curStatus']
                        ),
                        array(
                            'type' => 'select',
                            'label' => t('updatemethod'),
                            'name' => 'update_method',
                            'option' => array(
                                'automatic' => t('automatic'),
                                'manual' => t('manual')
                            ),
                            'selected' => $data['curUpdateMethod']
                        ),
						array(
							'type' => 'submit',
							'label' => '<i class="fe fe-refresh-cw"></i> '.t('btnupdate'),
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
<?php
endif;

include V_ADMIN_PATH . "footer.php";
