<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
		Register style (CSS)
************************************/
$request_css_files = array();
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
    
    $('#accesstype').change(function(e) {
        var value = $(this).val();

        if(value == 'pagecontent_link'){
            $('#pagecontentlink').show();
            $('#pagecontent').attr('required','required');
            $('#pagecontent').removeAttr('disabled');

            $('#newscategorylink').hide();
            $('#newscategory').removeAttr(\"required\"); 
            $('#newscategory').attr(\"disabled\",\"disabled\");

            $('#urllink').hide();
            $('#outgoinglink').removeAttr(\"required\"); 
            $('#outgoinglink').attr(\"disabled\",\"disabled\");
        }
        else if(value == 'newscategory_link'){
            $('#pagecontentlink').hide();
            $('#pagecontent').removeAttr(\"required\");
            $('#pagecontent').attr(\"disabled\",\"disabled\");

            $('#newscategorylink').show();
            $('#newscategory').attr('required','required');
            $('#newscategory').removeAttr(\"disabled\");

            $('#urllink').hide();
            $('#outgoinglink').removeAttr(\"required\");
            $('#outgoinglink').attr(\"disabled\",\"disabled\");
        }
        else if(value == 'outgoing_link'){
            $('#pagecontentlink').hide();
            $('#pagecontent').removeAttr(\"required\");
            $('#pagecontent').attr(\"disabled\",\"disabled\");

            $('#newscategorylink').hide();
            $('#newscategory').removeAttr(\"required\"); 
            $('#newscategory').attr(\"disabled\",\"disabled\");

            $('#urllink').show();
            $('#outgoinglink').attr(\"required\",\"required\");
            $('#outgoinglink').removeAttr(\"disabled\");
        }
        else if(value == 'no_link'){
            $('#pagecontentlink').hide();
            $('#pagecontent').removeAttr(\"required\");
            $('#pagecontent').attr(\"disabled\",\"disabled\");

            $('#newscategorylink').hide();
            $('#newscategory').removeAttr(\"required\"); 
            $('#newscategory').attr(\"disabled\",\"disabled\");

            $('#urllink').hide();
            $('#outgoinglink').removeAttr(\"required\"); 
            $('#outgoinglink').attr(\"disabled\",\"disabled\");
        }

    });
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if( is_edit() ){

echo form_open( admin_url( $this->uri->segment(2) . '/editprocess'), array( 'id'=>'valid' ), array('ID' => $data['menuId'], 'groupid'=>$groupid));
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
	<div class="col-md-12">

		<div class="card card-statistics">
			<div class="card-header">
				<div class="card-heading">
					<h5 class="card-title mb-0"><?php echo t('editmenu'); ?></h5>
				</div>
			</div>

			<div class="card-body">
                <?php 
                $collabel = 'col-md-2';
                $colinput = 'col-md-9';
                $colsetting = array('label'=>$collabel,'input'=>$colinput);
                ?>
                <div class="form-group row">
                    <label class="<?php echo $collabel; ?> col-form-label" for="induk"><?php echo t('parent'); ?></label>
                    <div class="<?php echo $colinput; ?>">
                        <select class="custom-select" id="induk" name="induk">
                            <option value="0-0"><?php echo t('noparent'); ?></option>
                            <?php 
                                echo $optadminmenu;
                            ?>
                        </select>
                    </div>
                </div>
			    <?php 
				
				// make input structure
                $inputs1 = array(
                    array(
                        'type' => 'multilanguage_text',
                        'label' => t('menuname'),
                        'name' => 'nama_menu',
                        'required' => true,
                        'value' => array(
                            'table' => 'website_menu',
                            'field' => 'menuName',
                            'id' => $data['menuId']
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => t('class'),
                        'name' => 'attrclass',
                        'help' => t('classinfo'),
                        'value' => $data['menuAttrClass'],
                    ),
                    array(
                        'type' => 'select',
                        'label' => t('methodaccess'),
                        'name' => 'menu_akses',
                        'id' => 'accesstype',
                        'option' => array(
                            'pagecontent_link' => t('pages'),
                            'newscategory_link' => t('postcategories'),
                            'outgoing_link' => t('url'),
                            'no_link' => t('noaccess'),
                        ),
                        'selected' => $data['menuAccessType']
                    ),

                );

                $this->formcontrol->buildInputs($inputs1,'horizontal',$colsetting);
                ?>
                <div class="form-group row" id="pagecontentlink"<?php echo ($data['menuAccessType']!='pagecontent_link')? ' style="display:none;"':''; ?>>
                    <label for="pagecontent"  class="<?php echo $collabel; ?> col-form-label req"><?php echo t('pages'); ?></label>
                    <div class="<?php echo $colinput; ?>">
                        <select class="custom-select" id="pagecontent" name="pagecontent"<?php echo ($data['menuAccessType']!='pagecontent_link')? ' disabled="disabled"':' required="required"'; ?>>
                            <option value="">-- <?php echo t('choose'); ?> --</option>
                            <?php 
                                foreach( $datapage as $kp => $vp){
                                    echo '<option value="'.$kp.'"';
                                    if($vp == $data['menuRelationshipId']){
                                        echo ' selected="selected"';
                                    }
                                    echo '>'.$vp.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="newscategorylink"<?php echo ($data['menuAccessType']!='newscategory_link')? ' style="display:none;"':''; ?>>
                    <label for="newscategory" class="<?php echo $collabel; ?> col-form-label req"><?php echo t('postcategories'); ?></label>
                    <div class="<?php echo $colinput; ?>">
                        <select class="custom-select" id="newscategory" name="newscategory"<?php echo ($data['menuAccessType']!='newscategory_link')? ' disabled="disabled"':' required="required"'; ?>>
                            <option value="">-- <?php echo t('choose'); ?> --</option>
                            <?php 
                                foreach( $datacatpost as $pstky => $vlpst){
                                    echo '<option value="'.$pstky.'"';
                                    if($vp == $data['menuRelationshipId']){
                                        echo ' selected="selected"';
                                    }
                                    echo '>'.$vlpst.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="urllink"<?php echo ($data['menuAccessType']!='outgoing_link')? ' style="display:none;"':''; ?>>
                    <label for="outgoinglink" class="<?php echo $collabel; ?> col-form-label req"><?php echo t('url'); ?></label>
                    <div class="<?php echo $colinput; ?>">
                        <input type="text" class="form-control" id="outgoinglink" value="<?php echo variable_parser($data['menuUrlAccess']); ?>"<?php echo ($data['menuAccessType']!='outgoing_link')? ' disabled="disabled"':' required="required"'; ?> name="outgoinglink" />
                        <small class="form-text text-muted"><?php echo t('example'); ?>: http://myurl.com/</small>
                    </div>
                </div>
                <?php
                $inputs2 = array(
                    array(
                        'type' => 'checkbox',
                        'label' => t('active'),
                        'name' => 'active',
                        'value' => '1',
                        'title' => t('yes'),
                        'checked' => ($data['menuActive']=='y') ?true:false
                    ),
                    array(
                        'type' => 'submit',
                        'label' => '<i class="fe fe-refresh-cw"></i> '. t('btnupdate'),
                        'class' => 'btn-primary',
                        'bordertop' =>true
                    )
                );
				$this->formcontrol->buildInputs($inputs2,'horizontal',$colsetting);
				?>
			</div>
		</div>

	</div>
</div>
<?php 
echo form_close();
}

include V_ADMIN_PATH . "footer.php";
?>