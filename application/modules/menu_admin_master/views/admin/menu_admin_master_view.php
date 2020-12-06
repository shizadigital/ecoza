<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************
		Register style
*****************************/
$request_css_files = array(
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
		Register Script (JavaScript)
*******************************************/
$request_script_files = array(
	'vendors/nestable/jquery.nestable.js',
);

$request_script = "
$( document ).ready(function() {
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
        maxDepth:".ADMINMENUDEEPLIMIT."
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
?>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="card">

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
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="mi-close"></i></button>
					</div>
					';
				}
				?>
				<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-bold">
					<li class="nav-item">
						<a href="#atur-menu" class="nav-link<?php if( empty($this->input->get('tab')) OR $this->input->get('tab')=="atur-menu"){ echo " active"; } ?>" data-toggle="tab">
							<i class="fe fe-menu mr-1"></i> <?php echo t('menusetting'); ?>
						</a>
					</li>
					<li class="nav-item">
						<a href="#atur-izin-menu" class="nav-link<?php if( $this->input->get('tab')=="atur-izin-menu"){ echo " active"; } ?>" data-toggle="tab">
							<i class="fe fe-user-check mr-1"></i> <?php echo t('setprivilege'); ?>
						</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade<?php if( empty($this->input->get('tab')) OR $this->input->get('tab')=="atur-menu"){ echo " show active"; } ?>" id="atur-menu">

						<div class="mb-4 mt-4 alert alert-light" role="alert"><i class="fe fe-info"></i> <?php echo t('menuinfo'); ?></div>

						<?php 
						if( is_edit() ):
						echo form_open( admin_url( $this->uri->segment(2) . '/updatemenuposition'), array( 'class'=> 'validasi' ) ); ?>
						
					    <div class="row nestable-contant">
				            <div class="col-md-12">
				                <div id="nestable-menu">
				                	<div class="float-left">
				                		<button class="btn btn-primary btn-sm" type="submit"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
				                	</div>
				                    <div class="float-right">
				                        <button type="button" class="btn btn-warning btn-sm" data-action="expand-all"><span class="fa fa-expand"></span> <?php echo t('expand'); ?></button>
				                        <button type="button" class="btn btn-danger btn-sm" data-action="collapse-all"><span class="fa fa-compress"></span> <?php echo t('collapse'); ?></button>
				                    </div>
				                    <div class="clearfix"></div>
				                </div>
				            </div>

				            <div class="col-md-12 mt-3">
				                <section>
				                    <div class="dd" id="nestable">
				                    <ol class="dd-list">
				                        <?php
				                        $queryMenu1 = $data_menu;
				                        foreach ($data_menu as $dm1) {
				                            echo "<li class=\"dd-item\" data-id=\"{$dm1['menuId']}\">
				                                <div class=\"dd-handle\">
				                                    <span class=\"{$dm1['menuIcon']}\"></span> ".t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=>$dm1['menuId']) ) . (($dm1['menuActive']!='y')?' <span class="badge bg-danger">'.t('inactive').'</span>':'') . "
												</div>";
												if($dm1['menuType']!=='addons'){
													echo "
													<div class=\"nestable-ctn\">
														" . ((is_edit()) ? "<a class=\"btn-sm btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm1['menuId'])."\">".t('edit')."</a> ":"") ."
														" . ((is_delete()) ? "<a class=\"btn-sm btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm1['menuName'].") ".t('deleteconfirm')."')){ window.location='".admin_url($this->uri->segment(2).'/prosesdelete/'.$dm1['menuId'])."'; };\">".t('delete')."</a>":"") . "
													</div>";
												} else {
													echo "
													<div class=\"nestable-ctn\">
														<strong>".t('addons')."</strong>
													</div>";
												}

				                            if(count($dm1['level_2'])>0){

				                                echo "<ol class=\"dd-list\">";
				                                foreach ($dm1['level_2'] as $dm2) {
				                                    echo "<li class=\"dd-item\" data-id=\"{$dm2['menuId']}\">
														<div class=\"dd-handle\">".t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=>$dm2['menuId']) ) . (($dm2['menuActive']!='y')?' <span class="badge bg-danger">'.t('inactive').'</span>':'') . "</div>";
														
														if($dm2['menuType']!=='addons'){
															echo "
															<div class=\"nestable-ctn\">
																" . ((is_edit()) ? "<a class=\"btn-sm btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm2['menuId'])."\">".t('edit')."</a> ":"") ."
																" . ((is_delete()) ? "<a class=\"btn-sm btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm2['menuName'].") ".t('deleteconfirm')."')){ window.location='".admin_url($this->uri->segment(2)."/prosesdelete/".$dm2['menuId'])."'; };\">".t('delete')."</a>":"") . "
															</div>";
														} else {
															echo "
															<div class=\"nestable-ctn\">
																<strong>".t('addons')."</strong>
															</div>";
														}

				                                    if(count($dm2['level_3'])>0){

				                                        echo "<ol class=\"dd-list\">";
				                                        foreach ($dm2['level_3'] as $dm3) {
				                                            echo "<li class=\"dd-item\" data-id=\"{$dm3['menuId']}\">
																<div class=\"dd-handle\">".t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=>$dm3['menuId']) ) . (($dm3['menuActive']!='y')?' <span class="badge bg-danger">'.t('inactive').'</span>':'') . "</div>";
																
																if($dm3['menuType']!=='addons'){
																	echo "
																	<div class=\"nestable-ctn\">
																		" . ((is_edit()) ? "<a class=\"btn-sm btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm3['menuId'])."\">".t('edit')."</a> ":"") ."
																		" . ((is_delete()) ? "<a class=\"btn-sm btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm3['menuName'].") ".t('deleteconfirm')."')){ window.location='".admin_url($this->uri->segment(2)."/prosesdelete/".$dm3['menuId'])."'; };\">".t('delete')."</a>":"") . "
																	</div>";
																} else {
																	echo "
																	<div class=\"nestable-ctn\">
																		<strong>".t('addons')."</strong>
																	</div>";
																}

				                                            if(count($dm3['level_4'])>0){

				                                                echo "<ol class=\"dd-list\">";
				                                                foreach ($dm3['level_4'] as $dm4) {
				                                                    echo "<li class=\"dd-item\" data-id=\"{$dm4['menuId']}\">
																	<div class=\"dd-handle\">".t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=>$dm4['menuId']) ) . (($dm4['menuActive']!='y')?' <span class="badge bg-danger">'.t('inactive').'</span>':'') . "</div>";
																
																	if($dm4['menuType']!=='addons'){
																		echo "
																		<div class=\"nestable-ctn\">
																			" . ((is_edit()) ? "<a class=\"btn-sm btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm4['menuId'])."\">".t('edit')."</a> ":"") ."
																			" . ((is_delete()) ? "<a class=\"btn-sm btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm4['menuName'].") ".t('deleteconfirm')."')){ window.location='".admin_url($this->uri->segment(2)."/prosesdelete/".$dm4['menuId'])."'; };\">".t('delete')."</a>":"") . "
																		</div>";
																	} else {
																		echo "
																		<div class=\"nestable-ctn\">
																			<strong>".t('addons')."</strong>
																		</div>";
																	}
				                                                    echo "</li>";
				                                                }
				                                                echo "</ol>";
				                                            }
				                                            echo "</li>";
				                                        }
				                                        echo "</ol>";
				                                    }
				                                    echo "</li>";
				                                }
				                                echo "</ol>";
				                            }
				                            echo "</li>";
				                        }
				                        ?>
				                    </ol>
				                </div>
				                </section>
				            </div>

				            <div class="col-md-12 mt-3">
				                <input type="hidden" id="nestable-output" name="menu_data">
				                <div class="form-group">
				                	<hr/>
				                    <button class="btn btn-primary btn-sm" type="submit"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
				                </div>
				            </div>

				        </div>
						<?php 
						echo form_close();
						endif;
						?>
					</div>


					<div class="tab-pane fade<?php if( $this->input->get('tab')=="atur-izin-menu"){ echo " show active"; } ?>" id="atur-izin-menu">
						<?php 
						if( is_edit() ):
						echo form_open( admin_url( $this->uri->segment(2) . '/updatepermissionmenu'), array( 'class'=> 'validasi' ) ); ?>

		                <div class="form-group mb-4 mt-4">
		                    <div class="clearfix"></div>
		                    <button class="btn btn-primary btn-sm float-right" type="submit"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
		                    <div class="clearfix"></div>
		                </div>

						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
										<th style="min-width:200px;"><?php echo t('menu'); ?></th>
										<th class="text-center" style="width:85px;">
											<?php echo t('active'); ?><br/>
			                                <input type="checkbox" id="mod_active_all" />
										</th>
										<th class="text-center" style="width:85px;">
											<?php echo t('view'); ?><br/>
			                                <input type="checkbox" id="mod_view_all" />
										</th>
										<th class="text-center" style="width:85px;">
											<?php echo t('add'); ?><br/>
			                                <input type="checkbox" id="mod_add_all" />
										</th>
										<th class="text-center" style="width:85px;">
											<?php echo t('edit'); ?><br/>
			                                <input type="checkbox" id="mod_edit_all" />
										</th>
										<th class="text-center" style="width:85px;">
											<?php echo t('delete'); ?><br/>
			                                <input type="checkbox" id="mod_delete_all" />
										</th>
										<th class="text-center" style="width:125px; background:#eaffe2;">
											<?php echo t('all'); ?><br/>
			                                <input type="checkbox" id="mod_all_all" />
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									function menuDataField($no, $mn){
										$ci =& get_instance();
										if($mn['menuType']=='addons'){
											$addon = $ci->add_ons->getAddonsInfo( $mn['menuAccess'] );
										}
									?>
										<tr>
											<td class="text-center"><?php echo $no; ?></td>
											<td>
												<?php echo t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=>$mn['menuId']) ); ?>
												<input name="idmn[<?php echo $no; ?>]" type="hidden" value="<?php echo $mn['menuId']; ?>"/>
											</td>
											<td class="text-center">
												<?php
												if($mn['menuType']=='addons'){
													if($mn['menuActive'] == 'y'){
														echo '<i class="fe fe-check"></i>';
													} else {
														echo '<i class="fe fe-minus"></i>';
													}
												} else {
												?>
												<input type="checkbox"<?php echo ($mn['menuActive'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_active[<?php echo $mn['menuId']; ?>]" id="mn_active<?php echo $mn['menuId']; ?>" class="mn_active" value="y" />
												<?php } ?>
											</td>
											<td class="text-center">
												<?php
												if($mn['menuType']=='addons'){
													if($addon['ADDONS_PRIVILEGE']['view']=='y'){
														echo '<i class="fe fe-check"></i>';
													} else {
														echo '<i class="fe fe-minus"></i>';
													}
												} else {
												?>
												<input type="checkbox"<?php echo ($mn['menuView'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_view[<?php echo $mn['menuId']; ?>]" id="mn_view<?php echo $mn['menuId']; ?>" class="mn_view" value="y" />
												<?php } ?>
											</td>
											<td class="text-center">
												<?php
												if($mn['menuType']=='addons'){
													if($addon['ADDONS_PRIVILEGE']['add']=='y'){
														echo '<i class="fe fe-check"></i>';
													} else {
														echo '<i class="fe fe-minus"></i>';
													}
												} else {
												?>
												<input type="checkbox"<?php echo ($mn['menuAdd'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_add[<?php echo $mn['menuId']; ?>]" id="mn_add<?php echo $mn['menuId']; ?>" class="mn_add" value="y" />
												<?php } ?>
											</td>
											<td class="text-center">
												<?php
												if($mn['menuType']=='addons'){
													if($addon['ADDONS_PRIVILEGE']['edit']=='y'){
														echo '<i class="fe fe-check"></i>';
													} else {
														echo '<i class="fe fe-minus"></i>';
													}
												} else {
												?>
												<input type="checkbox"<?php echo ($mn['menuEdit'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_edit[<?php echo $mn['menuId']; ?>]" id="mn_edit<?php echo $mn['menuId']; ?>" class="mn_edit" value="y" />
												<?php } ?>
											</td>
											<td class="text-center">
												<?php
												if($mn['menuType']=='addons'){
													if($addon['ADDONS_PRIVILEGE']['delete']=='y'){
														echo '<i class="fe fe-check"></i>';
													} else {
														echo '<i class="fe fe-minus"></i>';
													}
												} else {
												?>
												<input type="checkbox"<?php echo ($mn['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_delete[<?php echo $mn['menuId']; ?>]" id="mn_delete<?php echo $mn['menuId']; ?>" class="mn_delete" value="y" />
												<?php } ?>
											</td>
											<td class="text-center" style="background:#eaffe2;">
												<?php
												if($mn['menuType']!='addons'){
												?>
												<input type="checkbox"<?php echo ($mn['menuActive'] == 'y' AND $mn['menuView'] == 'y' AND $mn['menuAdd'] == 'y' AND $mn['menuEdit'] == 'y' AND $mn['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_all[<?php echo $mn['menuId']; ?>]" id="mn_all<?php echo $mn['menuId']; ?>" class="mn_all" value="y" />

												<script type="text/javascript"> 
	                                            $(document).ready(function(){
	                                                //Check all Crud for a module
	                                                $("#mn_all<?php echo $mn['menuId']; ?>").click(function(){
	                                                    if ( (this).checked == true ){
	                                                       $('#mn_active<?php echo $mn['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_view<?php echo $mn['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_add<?php echo $mn['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_edit<?php echo $mn['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_delete<?php echo $mn['menuId']; ?>').prop('checked', true);
	                                                    } else {
	                                                       $('#mn_active<?php echo $mn['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_view<?php echo $mn['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_add<?php echo $mn['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_edit<?php echo $mn['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_delete<?php echo $mn['menuId']; ?>').prop('checked', false);
	                                                    }
	                                                });

	                                            });
	                                            </script>
												<?php } else {
													echo '<i class="fe fe-minus"></i>';
												} ?>
											</td>
										</tr>
									<?php
									}

									$no = 0;
									foreach ($data_menu as $mn1) {
										$no++;
										
										menuDataField($no, $mn1);
										
										if(count($mn1['level_2']) > 0){											
											foreach ($mn1['level_2'] as $mn2) {
												$no++;

												menuDataField($no, $mn2);											
											
												if(count($mn2['level_3']) > 0){
													foreach ($mn2['level_3'] as $mn3) {
														$no++;

														menuDataField($no, $mn3);
													 
														if(count($mn3['level_4']) > 0){
															foreach ($mn3['level_4'] as $mn4) {
																$no++;

																menuDataField($no, $mn4);
															
															}
														}
													}

												}

											}
										}
									}
									?>
								</tbody>
							</table>
						</div>

						<script type="text/javascript"> 
						$(document).ready(function(){
							//Check all active
						    $("#mod_active_all").click(function(){
						        if ( (this).checked == true ){
						           $('.mn_active').prop('checked', true);
						        } else {
						           $('.mn_active').prop('checked', false);
						        }
						    });
						    
						    //Check all view
						    $("#mod_view_all").click(function(){
						        if ( (this).checked == true ){
						           $('.mn_view').prop('checked', true);
						        } else {
						           $('.mn_view').prop('checked', false);
						        }
						    });

						    //Check all add
						    $("#mod_add_all").click(function(){
						        if ( (this).checked == true ){
						           $('.mn_add').prop('checked', true);
						        } else {
						           $('.mn_add').prop('checked', false);
						        }
						    });

						    //Check all edit
						    $("#mod_edit_all").click(function(){
						        if ( (this).checked == true ){
						           $('.mn_edit').prop('checked', true);
						        } else {
						           $('.mn_edit').prop('checked', false);
						        }
						    });

						    //Check all delete
						    $("#mod_delete_all").click(function(){
						        if ( (this).checked == true ){
						           $('.mn_delete').prop('checked', true);
						        } else {
						           $('.mn_delete').prop('checked', false);
						        }
						    });

						    //Check all all
						    $("#mod_all_all").click(function(){
						        if ( (this).checked == true ){
						           $('.mn_active').prop('checked', true);
						           $('.mn_view').prop('checked', true);
						           $('.mn_add').prop('checked', true);
						           $('.mn_edit').prop('checked', true);
						           $('.mn_delete').prop('checked', true);
						           $('.mn_all').prop('checked', true);
						        } else {
						           $('.mn_active').prop('checked', false);
						           $('.mn_view').prop('checked', false);
						           $('.mn_add').prop('checked', false);
						           $('.mn_edit').prop('checked', false);
						           $('.mn_delete').prop('checked', false);
						           $('.mn_all').prop('checked', false);
						        }
						    });

						});
						</script>

						<div class="form-group mt-3">
		                    <div class="clearfix"></div>
		                    <button class="btn btn-primary btn-sm float-right" type="submit"><i class="fe fe-refresh-cw"></i> <?php echo t('btnupdate'); ?></button>
		                    <div class="clearfix"></div>
		                </div>

						<?php 
						echo form_close();
						endif;
						?>
					</div>

				</div>
				<!-- END .tab-content-->

			</div>
		</div>

	</div>

</div>

<?php 
include V_ADMIN_PATH . "footer.php";
?>
