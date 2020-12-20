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
);
$request_script = "";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if(is_view() ):
?>
<div class="row">
    <div class="col-12">
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
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-8">
                                <div class="mt-xxs-0 btn-group btn-group-toggle">
                                    <?php 
                                    $countdtproddraft = countdata("contents","contentStatus='0' AND contentType='post'");

                                    if(empty($this->input->get('postdisplay'))){
                                        echo '
                                        <label class="btn btn-sm btn-round btn-primary">
                                            '.t('all').'
                                        </label>
                                        <a href="'.admin_url($this->uri->segment(2).'/?postdisplay=draft').'" class="btn btn-sm btn-outline-primary btn-round">
                                            '.t('draft').' ('.$countdtproddraft.')
                                        </a>';
                                    } else {
                                        echo '
                                        <a href="'.admin_url($this->uri->segment(2)).'" class="btn btn-sm btn-outline-primary btn-round">
                                            '.t('all').'
                                        </a>
                                        <label class="btn btn-sm btn-round btn-primary">
                                            '.t('draft').' ('.$countdtproddraft.')
                                        </label>
                                        ';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php echo form_open( admin_url( $this->uri->segment(2).'/' ), array( 'method'=>'get' ) ); ?>
                                <div class="input-group float-right">
                                    <input type="text" class="form-control form-control-sm" name="kw" value="<?php if(!empty($this->input->get('kw'))){ echo $this->input->get('kw'); } ?>" placeholder="<?php echo t('search'); ?> . . ."/>
                                    <div class="input-group-append">
                                    <button class="btn btn-light btn-sm" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">               

                <?php echo form_open( admin_url( $this->uri->segment(2).'/bulk_action' ), array( 'id'=>'valid', 'class'=>'form_bulk' ) ); ?>
                <div class="row">
                    <div class="col-md-6 form-inline">
                        <?php if( is_delete() ){ ?>
                        <div class="input-group">
                            <select name="bulktype" class="form-control form-control-sm custom-select" required>
                                <option value="">-- <?php echo t('bulkaction'); ?> --</option>
                                <option value="bulk_delete"><?php echo t('delete'); ?></option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-light btn-sm submit_bulk" type="button"><i class="fa fa-cog"></i></button>
                            </div>
                        </div>
                        <script type="text/javascript">
                        $(document).ready(function(){

                            $(".submit_bulk").click( function(){
                                var bulktype = $( "select[name=bulktype]" ).val();

                                if(bulktype=='bulk_delete'){
                                    var apply = confirm("<?php echo t('confirmbulkactiondelete'); ?>");
                                    if(apply == true){
                                        $('.form_bulk').submit();
                                    }
                                } else {
                                    $('.form_bulk').submit();
                                }
                            });
                            
                            //Check all view
                            $("#check_all").click(function(){
                                if ( (this).checked == true ){
                                   $('.check_item').prop('checked', true);
                                } else {
                                   $('.check_item').prop('checked', false);
                                }
                            });

                        });
                        </script>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <?php 
                        echo "<div class=\"float-right\" style=\"margin-top:5px;font-style:italic;\">".t('total')." $totaldata</div>";
                        ?>
                    </div>

                    <div class="col-md-12 py-3 table-responsive-md">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <?php if( is_delete() ){ ?>
                                    <th style="width:25px;" class="text-center">
                                        <input type="checkbox" id="check_all" />
                                    </th>
                                    <?php } ?>
                                    <th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
                                    <th style="min-width:125px;"><?php echo t('title'); ?></th>
                                    <th style="width:110px;" class="text-center"><?php echo t('be_read'); ?></th>
                                    <th style="width:130px;" class="text-center"><?php echo t('date'); ?></th>
                                    <th style="width:130px;" class="text-center"><?php echo t('categories'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if( $totaldata > 0 ){
                                    $no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
                                    foreach( $data AS $keydata => $r ){
										// define some variable
										$title = t( array( 'table'=>'contents', 'field'=>'contentTitle', 'id'=>$r['contentId']) );
                                ?>
                                <tr>
                                    <?php if( is_delete() ){ ?>
                                    <td class="text-center">
                                        <div class="form-group">
                                            <input type="checkbox" class="check_item" name="item[<?php echo $no; ?>]" value="y" />
                                            <input type="hidden" name="item_val[<?php echo $no; ?>]" value="<?php echo $r['contentId']; ?>" />
                                        </div>
                                    </td>
                                    <?php } ?>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td>
                                        <?php 
                                            echo '<strong>'.$title. (($r['contentStatus']==0)? ' <em style="color:#999;">('.t('draft').')</em>':'').'</strong>';
										?>
										<br/>
                                        <div class="btn-group btn-group-sm">
											<a href="<?php echo base_url('/post/'.$r['contentId'].'-'.$r['contentSlug']); ?>" class="btn btn-sm btn-secondary" target="_blank"><i class="fe fe-link-2"></i> <?php echo t('view'); ?></a>
											<?php if(is_edit()){ ?>
											<a href="<?php echo admin_url($this->uri->segment(2).'/edit/'.$r['contentId']); ?>" class="btn btn-sm btn-info"><i class="fe fe-edit"></i> <?php echo t('edit'); ?></a> 
											<?php } 
											if(is_delete()){ ?>
											<a data-toggle="modal" href="#myModal<?php echo $r['contentId']; ?>" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i> <?php echo t('delete'); ?></a>
											<?php
											if(empty($r['catColor'])){
												$color_ = "#000";
											}else{
												$color_ = $r['catColor'];
											}
											modalDelete(
												'myModal'.$r['contentId'],
												'<strong>'.$title.'</strong>',
												admin_url($this->uri->segment(2).'/delete/'.$r['contentId'])
											);
											?>
											<?php } ?>
										</div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            echo number_format($r['contentRead'],0,',','.');
                                        ?>
                                    </td>
                                    <td class="text-center">
									<?php
									$tglsays = dateSays($r['contentTimestamp']);
									$thdate = getDay($r['contentDate']).', '.$r['contentDd'].' '. getMonth($r['contentMm']).' '.$r['contentYy'];
                                    echo "<abbr data-toggle=\"tooltip\" title=\"{$thdate} - {$r['contentHour']}\">{$tglsays} ".t('ago')."</abbr>";
									?>
									</td>
                                    <td class="text-center">
									<?php										
									$tablecat = array('categories a','category_relationship b');
									$where = "a.catId = b.catId AND b.relatedId='$r[contentId]' AND b.crelRelatedType='post'";
									$categs = $this->Env_model->view_where_order('catName,catSlug,catColor',$tablecat, $where, 'a.catId', 'ASC');
									
									$numkat = countdata($tablecat,$where);
									$i = 1;
									foreach($categs as $kat){
										echo "<span style=\"font-size:12px;color:{$kat['catColor']};\">".$kat['catName']."</span>";
										
										if($i!=$numkat){ echo ", "; }
										$i++;
									}
									?>
									</td>
                                </tr>
                                <?php
                                    $no++; }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center"><?php echo t('nodatafound');?></td>
                                </tr>
                                <?php 
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <?php
                        echo $pagination;
                        ?>
                    </div>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div>

    </div>
</div>
<?php 
endif;
include V_ADMIN_PATH . "footer.php";
