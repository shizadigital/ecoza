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
	'vendors/nestable-master/jquery.nestable.js',
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
?>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Menu</h5>
				<div class="header-elements">
					<div class="list-icons">
		        		<a class="list-icons-item" data-action="collapse"></a>
		        	</div>
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
				<ul class="nav nav-tabs nav-tabs-highlight">
					<li class="nav-item">
						<a href="#atur-menu" class="nav-link<?php if( empty($this->input->get('tab')) OR $this->input->get('tab')=="atur-menu"){ echo " active"; } ?>" data-toggle="tab">
							<div><i class="icon-menu7 mr-2 d-block mb-1 mt-1"></i> Atur Menu</div>
						</a>
					</li>
					<li class="nav-item">
						<a href="#atur-izin-menu" class="nav-link<?php if( $this->input->get('tab')=="atur-izin-menu"){ echo " active"; } ?>" data-toggle="tab">
							<div><i class="icon-puzzle2 mr-2 d-block mb-1 mt-1"></i> Atur Izin Menu</div>
						</a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade<?php if( empty($this->input->get('tab')) OR $this->input->get('tab')=="atur-menu"){ echo " show active"; } ?>" id="atur-menu">

						<p class="mb-4"><i class="icon-info22"></i> Geser daftar menu sesuai urutan yang Anda inginkan, dan tekan tombol perbarui untuk menyimpan posisi menu</p>

						<?php 
						if( is_edit() ):
						echo form_open( admin_url( $this->uri->segment(2) . '/updatemenuposition'), array( 'class'=> 'validasi' ) ); ?>
						
					    <div class="row nestable-contant">
				            <div class="col-md-12">
				                <div id="nestable-menu">
				                	<div class="float-left">
				                		<button class="btn btn-primary btn-sm" type="submit"><i class="icon-pencil7"></i> Perbarui</button>
				                	</div>
				                    <div class="float-right">
				                        <button type="button" class="btn btn-warning btn-sm" data-action="expand-all"><span class="fa fa-expand"></span> <?php echo 'Expand'; ?></button>
				                        <button type="button" class="btn btn-danger btn-sm" data-action="collapse-all"><span class="fa fa-compress"></span> <?php echo 'Collapse'; ?></button>
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
				                                    <span class=\"{$dm1['menuIcon']}\"></span> ".$dm1['menuName'] . (($dm1['menuActive']!='y')?' <span class="badge bg-danger">Tidak Aktif</span>':'') . "
				                                </div>
				                                <div class=\"nestable-ctn\">
				                                    " . ((is_edit()) ? "<a class=\"btn-xs btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm1['menuId'])."\">".'Edit'."</a> ":"") ."
				                                    " . ((is_delete()) ? "<a class=\"btn-xs btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm1['menuName'].") ".'Apakah Anda yakin menghapus menu ini'."')){ window.location='".admin_url($this->uri->segment(2).'/prosesdelete/'.$dm1['menuId'])."'; };\">".'Hapus'."</a>":"") . "
				                                </div>";

				                            if(count($dm1['level_2'])>0){

				                                echo "<ol class=\"dd-list\">";
				                                foreach ($dm1['level_2'] as $dm2) {
				                                    echo "<li class=\"dd-item\" data-id=\"{$dm2['menuId']}\">
				                                        <div class=\"dd-handle\">".$dm2['menuName'] . (($dm2['menuActive']!='y')?' <span class="badge bg-danger">Tidak Aktif</span>':'') . "</div>
				                                        <div class=\"nestable-ctn\">
				                                            " . ((is_edit()) ? "<a class=\"btn-xs btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm2['menuId'])."\">".'Edit'."</a> ":"") ."
				                                            " . ((is_delete()) ? "<a class=\"btn-xs btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm2['menuName'].") ".'Apakah Anda yakin menghapus menu ini'."')){ window.location='".admin_url($this->uri->segment(2)."/prosesdelete/".$dm2['menuId'])."'; };\">".'Hapus'."</a>":"") . "
				                                        </div>";

				                                    if(count($dm2['level_3'])>0){

				                                        echo "<ol class=\"dd-list\">";
				                                        foreach ($dm2['level_3'] as $dm3) {
				                                            echo "<li class=\"dd-item\" data-id=\"{$dm3['menuId']}\">
				                                                <div class=\"dd-handle\">".$dm3['menuName'] . (($dm3['menuActive']!='y')?' <span class="badge bg-danger">Tidak Aktif</span>':'') . "</div>
				                                                <div class=\"nestable-ctn\">
				                                                    " . ((is_edit()) ? "<a class=\"btn-xs btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm3['menuId'])."\">".'Edit'."</a> ":"") ."
				                                                    " . ((is_delete()) ? "<a class=\"btn-xs btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm3['menuName'].") ".'Apakah Anda yakin menghapus menu ini'."')){ window.location='".admin_url($this->uri->segment(2)."/prosesdelete/".$dm3['menuId'])."'; };\">".'Hapus'."</a>":"") . "
				                                                </div>";

				                                            if(count($dm3['level_4'])>0){

				                                                echo "<ol class=\"dd-list\">";
				                                                foreach ($dm3['level_4'] as $dm4) {
				                                                    echo "<li class=\"dd-item\" data-id=\"{$dm4['menuId']}\">
				                                                    <div class=\"dd-handle\">".$dm4['menuName'] . (($dm4['menuActive']!='y')?' <span class="badge bg-danger">Tidak Aktif</span>':'') . "</div>
				                                                    <div class=\"nestable-ctn\">
				                                                        " . ((is_edit()) ? "<a class=\"btn-xs btn btn-outline-success\" href=\"".admin_url($this->uri->segment(2)."/edit/".$dm4['menuId'])."\">".'Edit'."</a> ":"") ."
				                                                        " . ((is_delete()) ? "<a class=\"btn-xs btn btn-outline-danger\" href=\"javascript: if (window.confirm('(".$dm4['menuName'].") ".'Apakah Anda yakin menghapus menu ini'."')){ window.location='".admin_url($this->uri->segment(2)."/prosesdelete/".$dm4['menuId'])."'; };\">".'Delete'."</a>":"") . "
				                                                    </div>";
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
				                    <button class="btn btn-primary btn-sm" type="submit"><i class="icon-pencil7"></i> <?php echo 'Perbarui'; ?></button>
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

		                <div class="form-group">
		                    <div class="clearfix"></div>
		                    <button class="btn btn-primary btn-sm float-right" type="submit"><i class="icon-loop3"></i> <?php echo 'Perbarui'; ?></button>
		                    <div class="clearfix"></div>
		                </div>

						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th style="width:25px;" class="text-center">No</th>
										<th style="min-width:200px;">First Name</th>
										<th class="text-center" style="width:85px;">
											Active<br/>
			                                <input type="checkbox" id="mod_active_all" />
										</th>
										<th class="text-center" style="width:85px;">
											View<br/>
			                                <input type="checkbox" id="mod_view_all" />
										</th>
										<th class="text-center" style="width:85px;">
											Tambah<br/>
			                                <input type="checkbox" id="mod_add_all" />
										</th>
										<th class="text-center" style="width:85px;">
											Edit<br/>
			                                <input type="checkbox" id="mod_edit_all" />
										</th>
										<th class="text-center" style="width:85px;">
											Hapus<br/>
			                                <input type="checkbox" id="mod_delete_all" />
										</th>
										<th class="text-center" style="width:125px; background:#eaffe2;">
											Semua<br/>
			                                <input type="checkbox" id="mod_all_all" />
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									foreach ($data_menu as $mn1) {
										$no++;
									?>
										<tr>
											<td class="text-center"><?php echo $no; ?></td>
											<td>
												<?php echo $mn1['menuName']; ?>
												<input name="idmn[<?php echo $no; ?>]" type="hidden" value="<?php echo $mn1['menuId']; ?>"/>
											</td>
											<td class="text-center">
												<input type="checkbox"<?php echo ($mn1['menuActive'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_active[<?php echo $mn1['menuId']; ?>]" id="mn_active<?php echo $mn1['menuId']; ?>" class="mn_active" value="y" />
											</td>
											<td class="text-center">
												<input type="checkbox"<?php echo ($mn1['menuView'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_view[<?php echo $mn1['menuId']; ?>]" id="mn_view<?php echo $mn1['menuId']; ?>" class="mn_view" value="y" />
											</td>
											<td class="text-center">
												<input type="checkbox"<?php echo ($mn1['menuAdd'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_add[<?php echo $mn1['menuId']; ?>]" id="mn_add<?php echo $mn1['menuId']; ?>" class="mn_add" value="y" />
											</td>
											<td class="text-center">
												<input type="checkbox"<?php echo ($mn1['menuEdit'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_edit[<?php echo $mn1['menuId']; ?>]" id="mn_edit<?php echo $mn1['menuId']; ?>" class="mn_edit" value="y" />
											</td>
											<td class="text-center">
												<input type="checkbox"<?php echo ($mn1['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_delete[<?php echo $mn1['menuId']; ?>]" id="mn_delete<?php echo $mn1['menuId']; ?>" class="mn_delete" value="y" />
											</td>
											<td class="text-center" style="background:#eaffe2;">
												<input type="checkbox"<?php echo ($mn1['menuActive'] == 'y' AND $mn1['menuView'] == 'y' AND $mn1['menuAdd'] == 'y' AND $mn1['menuEdit'] == 'y' AND $mn1['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_all[<?php echo $mn1['menuId']; ?>]" id="mn_all<?php echo $mn1['menuId']; ?>" class="mn_all" value="y" />

												<script type="text/javascript"> 
	                                            $(document).ready(function(){
	                                                //Check all Crud for a module
	                                                $("#mn_all<?php echo $mn1['menuId']; ?>").click(function(){
	                                                    if ( (this).checked == true ){
	                                                       $('#mn_active<?php echo $mn1['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_view<?php echo $mn1['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_add<?php echo $mn1['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_edit<?php echo $mn1['menuId']; ?>').prop('checked', true);
	                                                       $('#mn_delete<?php echo $mn1['menuId']; ?>').prop('checked', true);
	                                                    } else {
	                                                       $('#mn_active<?php echo $mn1['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_view<?php echo $mn1['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_add<?php echo $mn1['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_edit<?php echo $mn1['menuId']; ?>').prop('checked', false);
	                                                       $('#mn_delete<?php echo $mn1['menuId']; ?>').prop('checked', false);
	                                                    }
	                                                });

	                                            });
	                                            </script>
											</td>
										</tr>
									<?php
										if(count($mn1['level_2']) > 0){											
											foreach ($mn1['level_2'] as $mn2) {
												$no++;
											?>
											<tr>
												<td class="text-center"><?php echo $no; ?></td>
												<td>
													<i class="mi-remove"></i> <?php echo $mn2['menuName']; ?>
													<input name="idmn[<?php echo $no; ?>]" type="hidden" value="<?php echo $mn2['menuId']; ?>"/>
												</td>
												<td class="text-center">
													<input type="checkbox"<?php echo ($mn2['menuActive'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_active[<?php echo $mn2['menuId']; ?>]" id="mn_active<?php echo $mn2['menuId']; ?>" class="mn_active" value="y" />
												</td>
												<td class="text-center">
													<input type="checkbox"<?php echo ($mn2['menuView'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_view[<?php echo $mn2['menuId']; ?>]" id="mn_view<?php echo $mn2['menuId']; ?>" class="mn_view" value="y" />
												</td>
												<td class="text-center">
													<input type="checkbox"<?php echo ($mn2['menuAdd'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_add[<?php echo $mn2['menuId']; ?>]" id="mn_add<?php echo $mn2['menuId']; ?>" class="mn_add" value="y" />
												</td>
												<td class="text-center">
													<input type="checkbox"<?php echo ($mn2['menuEdit'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_edit[<?php echo $mn2['menuId']; ?>]" id="mn_edit<?php echo $mn2['menuId']; ?>" class="mn_edit" value="y" />
												</td>
												<td class="text-center">
													<input type="checkbox"<?php echo ($mn2['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_delete[<?php echo $mn2['menuId']; ?>]" id="mn_delete<?php echo $mn2['menuId']; ?>" class="mn_delete" value="y" />
												</td>
												<td class="text-center" style="background:#eaffe2;">
													<input type="checkbox"<?php echo ($mn2['menuActive'] == 'y' AND $mn2['menuView'] == 'y' AND $mn2['menuAdd'] == 'y' AND $mn2['menuEdit'] == 'y' AND $mn2['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_all[<?php echo $mn2['menuId']; ?>]" id="mn_all<?php echo $mn2['menuId']; ?>" class="mn_all" value="y" />
													<script type="text/javascript"> 
		                                            $(document).ready(function(){
		                                                //Check all Crud for a module
		                                                $("#mn_all<?php echo $mn2['menuId']; ?>").click(function(){
		                                                    if ( (this).checked == true ){
		                                                       $('#mn_active<?php echo $mn2['menuId']; ?>').prop('checked', true);
		                                                       $('#mn_view<?php echo $mn2['menuId']; ?>').prop('checked', true);
		                                                       $('#mn_add<?php echo $mn2['menuId']; ?>').prop('checked', true);
		                                                       $('#mn_edit<?php echo $mn2['menuId']; ?>').prop('checked', true);
		                                                       $('#mn_delete<?php echo $mn2['menuId']; ?>').prop('checked', true);
		                                                    } else {
		                                                       $('#mn_active<?php echo $mn2['menuId']; ?>').prop('checked', false);
		                                                       $('#mn_view<?php echo $mn2['menuId']; ?>').prop('checked', false);
		                                                       $('#mn_add<?php echo $mn2['menuId']; ?>').prop('checked', false);
		                                                       $('#mn_edit<?php echo $mn2['menuId']; ?>').prop('checked', false);
		                                                       $('#mn_delete<?php echo $mn2['menuId']; ?>').prop('checked', false);
		                                                    }
		                                                });

		                                            });
		                                            </script>
												</td>
											</tr>
											<?php
												if(count($mn2['level_3']) > 0){
													foreach ($mn2['level_3'] as $mn3) {
														$no++;
													?>
													<tr>
														<td class="text-center"><?php echo $no; ?></td>
														<td>
															<i class="mi-remove"></i><i class="mi-remove"></i> <?php echo $mn3['menuName']; ?>
															<input name="idmn[<?php echo $no; ?>]" type="hidden" value="<?php echo $mn3['menuId']; ?>"/>
														</td>
														<td class="text-center">
															<input type="checkbox"<?php echo ($mn3['menuActive'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_active[<?php echo $mn3['menuId']; ?>]" id="mn_active<?php echo $mn3['menuId']; ?>" class="mn_active" value="y" />
														</td>
														<td class="text-center">
															<input type="checkbox"<?php echo ($mn3['menuView'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_view[<?php echo $mn3['menuId']; ?>]" id="mn_view<?php echo $mn3['menuId']; ?>" class="mn_view" value="y" />
														</td>
														<td class="text-center">
															<input type="checkbox"<?php echo ($mn3['menuAdd'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_add[<?php echo $mn3['menuId']; ?>]" id="mn_add<?php echo $mn3['menuId']; ?>" class="mn_add" value="y" />
														</td>
														<td class="text-center">
															<input type="checkbox"<?php echo ($mn3['menuEdit'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_edit[<?php echo $mn3['menuId']; ?>]" id="mn_edit<?php echo $mn3['menuId']; ?>" class="mn_edit" value="y" />
														</td>
														<td class="text-center">
															<input type="checkbox"<?php echo ($mn3['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_delete[<?php echo $mn3['menuId']; ?>]" id="mn_delete<?php echo $mn3['menuId']; ?>" class="mn_delete" value="y" />
														</td>
														<td class="text-center" style="background:#eaffe2;">
															<input type="checkbox"<?php echo ($mn3['menuActive'] == 'y' AND $mn3['menuView'] == 'y' AND $mn3['menuAdd'] == 'y' AND $mn3['menuEdit'] == 'y' AND $mn3['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_all[<?php echo $mn3['menuId']; ?>]" id="mn_all<?php echo $mn3['menuId']; ?>" class="mn_all" value="y" />
															<script type="text/javascript"> 
				                                            $(document).ready(function(){
				                                                //Check all Crud for a module
				                                                $("#mn_all<?php echo $mn3['menuId']; ?>").click(function(){
				                                                    if ( (this).checked == true ){
				                                                       $('#mn_active<?php echo $mn3['menuId']; ?>').prop('checked', true);
				                                                       $('#mn_view<?php echo $mn3['menuId']; ?>').prop('checked', true);
				                                                       $('#mn_add<?php echo $mn3['menuId']; ?>').prop('checked', true);
				                                                       $('#mn_edit<?php echo $mn3['menuId']; ?>').prop('checked', true);
				                                                       $('#mn_delete<?php echo $mn3['menuId']; ?>').prop('checked', true);
				                                                    } else {
				                                                       $('#mn_active<?php echo $mn3['menuId']; ?>').prop('checked', false);
				                                                       $('#mn_view<?php echo $mn3['menuId']; ?>').prop('checked', false);
				                                                       $('#mn_add<?php echo $mn3['menuId']; ?>').prop('checked', false);
				                                                       $('#mn_edit<?php echo $mn3['menuId']; ?>').prop('checked', false);
				                                                       $('#mn_delete<?php echo $mn3['menuId']; ?>').prop('checked', false);
				                                                    }
				                                                });

				                                            });
				                                            </script>
														</td>
													</tr>
													<?php 
														if(count($mn3['level_4']) > 0){
															foreach ($mn3['level_4'] as $mn4) {
																$no++;
															?>
															<tr>
																<td class="text-center"><?php echo $no; ?></td>
																<td>
																	<i class="mi-remove"></i><i class="mi-remove"></i> <?php echo $mn4['menuName']; ?>
																	<input name="idmn[<?php echo $no; ?>]" type="hidden" value="<?php echo $mn4['menuId']; ?>"/>
																</td>
																<td class="text-center">
																	<input type="checkbox"<?php echo ($mn4['menuActive'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_active[<?php echo $mn4['menuId']; ?>]" id="mn_active<?php echo $mn4['menuId']; ?>" class="mn_active" value="y" />
																</td>
																<td class="text-center">
																	<input type="checkbox"<?php echo ($mn4['menuView'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_view[<?php echo $mn4['menuId']; ?>]" id="mn_view<?php echo $mn4['menuId']; ?>" class="mn_view" value="y" />
																</td>
																<td class="text-center">
																	<input type="checkbox"<?php echo ($mn4['menuAdd'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_add[<?php echo $mn4['menuId']; ?>]" id="mn_add<?php echo $mn4['menuId']; ?>" class="mn_add" value="y" />
																</td>
																<td class="text-center">
																	<input type="checkbox"<?php echo ($mn4['menuEdit'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_edit[<?php echo $mn4['menuId']; ?>]" id="mn_edit<?php echo $mn4['menuId']; ?>" class="mn_edit" value="y" />
																</td>
																<td class="text-center">
																	<input type="checkbox"<?php echo ($mn4['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_delete[<?php echo $mn4['menuId']; ?>]" id="mn_delete<?php echo $mn4['menuId']; ?>" class="mn_delete" value="y" />
																</td>
																<td class="text-center" style="background:#eaffe2;">
																	<input type="checkbox"<?php echo ($mn4['menuActive'] == 'y' AND $mn4['menuView'] == 'y' AND $mn4['menuAdd'] == 'y' AND $mn4['menuEdit'] == 'y' AND $mn4['menuDelete'] == 'y')? " checked=\"checked\"" : ""; ?> name="mn_all[<?php echo $mn4['menuId']; ?>]" id="mn_all<?php echo $mn4['menuId']; ?>" class="mn_all" value="y" />

																	<script type="text/javascript"> 
						                                            $(document).ready(function(){
						                                                //Check all Crud for a module
						                                                $("#mn_all<?php echo $mn4['menuId']; ?>").click(function(){
						                                                    if ( (this).checked == true ){
						                                                       $('#mn_active<?php echo $mn4['menuId']; ?>').prop('checked', true);
						                                                       $('#mn_view<?php echo $mn4['menuId']; ?>').prop('checked', true);
						                                                       $('#mn_add<?php echo $mn4['menuId']; ?>').prop('checked', true);
						                                                       $('#mn_edit<?php echo $mn4['menuId']; ?>').prop('checked', true);
						                                                       $('#mn_delete<?php echo $mn4['menuId']; ?>').prop('checked', true);
						                                                    } else {
						                                                       $('#mn_active<?php echo $mn4['menuId']; ?>').prop('checked', false);
						                                                       $('#mn_view<?php echo $mn4['menuId']; ?>').prop('checked', false);
						                                                       $('#mn_add<?php echo $mn4['menuId']; ?>').prop('checked', false);
						                                                       $('#mn_edit<?php echo $mn4['menuId']; ?>').prop('checked', false);
						                                                       $('#mn_delete<?php echo $mn4['menuId']; ?>').prop('checked', false);
						                                                    }
						                                                });

						                                            });
						                                            </script>
																</td>
															</tr>

															<?php
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
		                    <button class="btn btn-primary btn-sm float-right" type="submit"><i class="icon-loop3"></i> <?php echo 'Perbarui'; ?></button>
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