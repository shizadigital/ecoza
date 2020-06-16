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
	'vendors/nestable/jquery.nestable.js',
);
$request_script = "
$( document ).ready(function() {
    $('.validasi').parsley();
    
    //nestable
    var updateOutput = function(e){
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        maxDepth:".WEBMENUDEEPLIMIT."
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));

    $('#nestable-menu').on('click', function(e){
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if( is_view() ):

if( !empty( $this->session->has_userdata('succeed') ) ){
    echo '
    <div class="row"><div class="col-md-12 col-sm-12">
        <div class="alert alert-icon alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check"></i> ' . $this->session->flashdata('succeed') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
        </div>
    </div></div>
    ';
}
if( !empty( $this->session->has_userdata('failed') ) ){
    echo '
    <div class="row"><div class="col-md-12 col-sm-12">
        <div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-times"></i> ' . $this->session->flashdata('failed') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
        </div>
    </div></div>
    ';
}

$groupId = $menuselected;

// check group menu
$countgroupmenu = countdata("categories","catType='webmenu'");
?>
<div class="row">

    <div class="col-md-12">
        <div class="card card-statistics">
            <div class="card-body">
                <?php echo form_open( admin_url( $this->uri->segment(2).'/' ), array( 'method'=>'get' ) ); ?>

                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <?php echo t('choosegroup'); ?>:
                        </div>
                        <div class="col-auto">
                            <div class="input-group">
                                <select class="custom-select" name="groupmenu">
                                    <?php
                                    foreach ( $menucat as $idgrp => $grpval) {
                                        echo '<option value="'.$idgrp.'"';
                                        if($menuselected == $idgrp){
                                            echo ' selected="selected"';
                                        }
                                        echo '>'.$grpval.'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="input-group-append">
                                   <button class="btn btn-light btn-sm" type="submit"><?php echo t('btnapply'); ?></button>
                                </div>
                            </div>
                        </div>
                        <?php if(is_add()){ ?>
                        <div class="col-auto">
                            <?php echo t('or') . ' <a style="text-decoration: underline;color: #328ac2;" data-toggle="modal" href="#myModaladdnewgrup">'.t('addnew').'</a>'; ?>
                        </div>
                        <?php } ?>
                    </div>
                <?php echo  form_close(); ?>
                <?php if(is_add()){ ?>
                <!-- Modal -->
                <div class="modal fade" id="myModaladdnewgrup" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo t('addnew'); ?></h5>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo t('close'); ?></span></button>
                            </div>
                            <?php echo form_open( admin_url( $this->uri->segment(2).'/addgroup' ), array( 'class'=>'validasi' ) ); ?>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm req"><?php echo t('title'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" name="titlegroup" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo t('cancel'); ?></button>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fe fe-plus"></i> <?php echo t('btnadd'); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div><!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- End Modal -->
                <?php } ?>

            </div>
        </div>
    </div>

    <?php 
    if($countgroupmenu > 0){
    ?>
    <div class="col-md-4">

        <div class="card">

            <div class="card-header">
                <h4 class="card-title"><?php echo t('group'); ?></h4>
            </div>

            <div class="card-body">
                <?php
                $getgroup = getval("catId,catName,catDesc","categories","catType='webmenu' AND catId='{$groupId}'");
                ?>
                <p class="m-b-10"><?php echo t('currentgroup'); ?>: <?php if($this->session->userdata('leveluser')=='1'){ echo '(ID: '.$getgroup['catId'].') '; } ?><strong><?php echo $getgroup['catName']; ?></strong></p>
                <?php if( is_edit() ){ ?>

                <a data-toggle="modal" href="#myModaleditgrup" class="btn btn-dark"><i class="fe fe-edit"></i> <?php echo t('btnupdate'); ?></a>

                <!-- Modal -->
                <div class="modal fade" id="myModaleditgrup" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="width:400px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo t('edit'); ?></h5>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo t('close'); ?></span></button>
                            </div>
                            
                            <?php echo form_open( admin_url( $this->uri->segment(2).'/editgroup' ), array( 'class'=>'validasi' ), array('idgroup'=>$getgroup['catId']) ); ?>
                            
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-3 col-form-label req"><?php echo t('title'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control" name="titlegroup" value="<?php echo $getgroup['catName']; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="primarymenu" class="col-sm-3 col-form-label pt-2"><?php echo t('primary'); ?></label>

                                    <div class="col-sm-9">
                                        <div class="custom-control custom-checkbox pt-2">
                                            <input type="checkbox" class="custom-control-input" id="primarymenu" name="primary" value="y"<?php echo ($getgroup['catDesc']=='primary')? ' checked="checked"':''; ?>>
                                            <label for="primarymenu" class="custom-control-label"> <?php echo t('yes'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo t('cancel'); ?></button>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
                            </div>

                            <?php echo form_close(); ?>
                        </div><!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- End Modal -->
                <?php } ?>

                <?php if( is_delete() ){ ?>
                <a data-toggle="modal" href="#myModaldeletegrup<?php echo $groupId; ?>" class="btn btn-danger"><i class="fe fe-trash"></i> <?php echo t('btndelete'); ?></a>
                <?php
                modalDelete(
                    'myModaldeletegrup'.$groupId,
                    $getgroup['catName'],
                    admin_url($this->uri->segment(2).'/deletegroup/'.$groupId)
                );
                ?>
                <?php } ?>
            </div>

        </div>



        <?php 
        if(is_add()){ ?>
        <div class="card card-statistics">

            <div class="card-header">
                <h4 class="card-title"><?php echo t('addnew'); ?></h4>
            </div>
            
            <?php echo form_open( admin_url( $this->uri->segment(2).'/addnew' ), array( 'class'=>'validasi' ), array('groupmenu'=>$groupId) ); ?>

            <div class="card-body">

                <div class="form-group">
                    <label for="induk"><?php echo t('parent'); ?></label>
                    <select class="custom-select" id="induk" name="induk">
                        <option value="0-0"><?php echo t('noparent'); ?></option>
                        <?php 
                            echo $optadminmenu;
                        ?>
                    </select>
                </div>

                <?php
                    $build_input = array(
                        array(
                            'type' => 'multilanguage_text',
                            'label' => t('menuname'),
                            'name' => 'nama_menu',
                            'required' => true,
                        ),
                        array(
                            'type' => 'text',
                            'label' => t('class'),
                            'name' => 'attrclass',
                            'help' => t('classinfo')
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
                            'selected' => 'pagecontent_link'
                        )
                    );
                    $this->formcontrol->buildInputs($build_input);
                ?>

                <div class="form-group">
                    <div id="pagecontentlink">
                        <label for="pagecontent" class="req"><?php echo t('pages'); ?></label>
                        <select class="custom-select" id="pagecontent" name="pagecontent" required>
                            <option value="">-- <?php echo t('choose'); ?> --</option>
                            <?php 
                                foreach( $datapage as $kp => $vp){
                                    echo '<option value="'.$kp.'">'.$vp.'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div id="newscategorylink" style="display:none;">
                        <label for="newscategory" class="req"><?php echo t('postcategories'); ?></label>
                        <select class="custom-select" id="newscategory" name="newscategory" disabled="disabled">
                            <option value="">-- <?php echo t('choose'); ?> --</option>
                            <?php 
                                foreach( $datacatpost as $pstky => $vlpst){
                                    echo '<option value="'.$pstky.'">'.$vlpst.'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div id="urllink" style="display:none;">
                        <label for="outgoinglink" class="req"><?php echo t('url'); ?></label>
                        <input type="text" class="form-control" id="outgoinglink" disabled="disabled" name="outgoinglink" />
                        <small class="form-text text-muted"><?php echo t('example'); ?>: http://myurl.com/</small>
                    </div>
                </div>

                <script type="text/javascript">
                $( document ).ready(function() {
                    $('#accesstype').change(function(e) {
                        var value = $(this).val();

                        if(value == 'pagecontent_link'){
                            $('#pagecontentlink').show();
                            $('#pagecontent').attr('required','required');
                            $('#pagecontent').removeAttr('disabled');

                            $('#newscategorylink').hide();
                            $('#newscategory').removeAttr("required"); 
                            $('#newscategory').attr("disabled","disabled");

                            $('#urllink').hide();
                            $('#outgoinglink').removeAttr("required"); 
                            $('#outgoinglink').attr("disabled","disabled");
                        }
                        else if(value == 'newscategory_link'){
                            $('#pagecontentlink').hide();
                            $('#pagecontent').removeAttr("required");
                            $('#pagecontent').attr("disabled","disabled");

                            $('#newscategorylink').show();
                            $('#newscategory').attr('required','required');
                            $('#newscategory').removeAttr("disabled");

                            $('#urllink').hide();
                            $('#outgoinglink').removeAttr("required");
                            $('#outgoinglink').attr("disabled","disabled");
                        }
                        else if(value == 'outgoing_link'){
                            $('#pagecontentlink').hide();
                            $('#pagecontent').removeAttr("required");
                            $('#pagecontent').attr("disabled","disabled");

                            $('#newscategorylink').hide();
                            $('#newscategory').removeAttr("required"); 
                            $('#newscategory').attr("disabled","disabled");

                            $('#urllink').show();
                            $('#outgoinglink').attr("required","required");
                            $('#outgoinglink').removeAttr("disabled");
                        }
                        else if(value == 'no_link'){
                            $('#pagecontentlink').hide();
                            $('#pagecontent').removeAttr("required");
                            $('#pagecontent').attr("disabled","disabled");

                            $('#newscategorylink').hide();
                            $('#newscategory').removeAttr("required"); 
                            $('#newscategory').attr("disabled","disabled");

                            $('#urllink').hide();
                            $('#outgoinglink').removeAttr("required"); 
                            $('#outgoinglink').attr("disabled","disabled");
                        }

                    });
                });
                </script>

                <hr/>

                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fe fe-plus"></i> <?php echo t('btnadd'); ?></button>
                </div>

            </div>
            </form>

        </div>
        <?php } ?>






    </div>

    <?php } ?>

</div>


<?php
endif;
include V_ADMIN_PATH . "footer.php";
