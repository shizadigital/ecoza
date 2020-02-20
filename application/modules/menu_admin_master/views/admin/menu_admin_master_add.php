<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************
		Register style
*****************************/
$request_css_files = array(
	'vendors/select2/dist/css/select2.min.css'
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
		Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    'vendors/parsley/parsley.config.js',
    'vendors/parsley/parsley.min.js',
    'vendors/select2/dist/js/select2.full.min.js'
);
$request_script = "
function ajaxicon(thevalue){
    $.ajax({
        type: 'GET',
        url: '".admin_url()."/main/iconscomponent/',
        data : { theval: thevalue },
        beforeSend: function(data){
            $('#content_icon').show().html('<div class=\"h-100 d-flex justify-content-center\"><i class=\"fa fa-spinner fa-pulse fa-3x fa-fw\"></i></div>');
            $(this).attr('disabled','disabled');
        },
        success: function(data) {
            if(data){
                $('#content_icon').html(data);
            } else {
                $('#content_icon').html('<center><h4>Data tidak dapat dimuat</h4></center>');
            }
            $(this).removeAttr('disabled');
        }
    });
}

$( document ).ready(function() {
    $('#valid').parsley();

    $('.select2').select2({
        placeholder: \"Pilih induk menu...\"
    });

    ajaxicon('feather');
    $('#pilihanicon').change(function(){
        var val = $(this).val();
        ajaxicon(val);
	});
	
	$('#modularmvc').change(function(){
		if($( this ).val()=='hmvc'){
			$('.alert-hmvc').show();
			$('.alert-mvc').hide();
		} else {
			$('.alert-mvc').show();
			$('.alert-hmvc').hide();
		}
	});
});
";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";
?>
<style type="text/css">
    #urllink { display:none; }
    #modulelink { display:block; }
</style>
<script type="text/javascript">
    function linktype(menu_akses){
        switch (this.menu_akses.value) {
            case '':
            case 'admin_link':
                document.getElementById("modulelink").style.display = 'block';
                document.getElementById("modul").setAttribute("data-parsley-required","true");
                document.getElementById("modul").removeAttribute("disabled");

                document.getElementById("urllink").style.display = 'none';
                document.getElementById("outlink").setAttribute("data-parsley-required","false");
                document.getElementById("outlink").setAttribute("disabled","disabled");
                document.getElementById("outlink").removeAttribute("value"); 
            break;
            case 'out_link':
                document.getElementById("modulelink").style.display = 'none';
                document.getElementById("modul").setAttribute("data-parsley-required","false");
                document.getElementById("modul").setAttribute("disabled","disabled");
                document.getElementById("modul").removeAttribute("value");

                document.getElementById("urllink").style.display = 'block';
                document.getElementById("outlink").setAttribute("data-parsley-required","true");
                document.getElementById("outlink").removeAttribute("disabled");
            break;
            case 'no_link':
                document.getElementById("modulelink").style.display = 'none';
                document.getElementById("modul").setAttribute("data-parsley-required","false");
                document.getElementById("modul").setAttribute("disabled","disabled");
                document.getElementById("modul").removeAttribute("value");

                document.getElementById("urllink").style.display = 'none';
                document.getElementById("outlink").setAttribute("data-parsley-required","false");
                document.getElementById("outlink").setAttribute("disabled","disabled");
                document.getElementById("outlink").removeAttribute("value"); 
            break;
        }
    }
</script>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">Tambah Menu</h5>
			</div>

			<div class="card-body">
				<?php 
				if( is_add() ):
				echo form_open( admin_url( $this->uri->segment(2) . '/prosestambah'), array( 'id'=>'valid' ) ); ?>
				<?php 
				if( !empty( $this->session->has_userdata('gagal') ) ){
		            echo '
					<div class="alert alert-icon alert-danger alert-dismissible fade show" role="alert">
						<i class="fe fe-x"></i> ' . $this->session->flashdata('gagal') . '
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fe fe-x"></i></button>
					</div>
					';
				}
				?>

				<div class="row">
					<div class="col-md-9 col-sm-12">

						<div class="form-group row">
							<label class="col-form-label col-lg-2" for="module_name">Induk</label>
							<div class="col-lg-10">
								<select class="form-control select2" id="induk" name="induk">
                        			<option value="0-0">Tidak ada induk</option>
                        			<?php 
		                            $queryinduk = $data_menu;
		                            $xx1 = 1;
		                            foreach ($queryinduk as $pm1) {
		                                echo "<option value=\"1-{$pm1['menuId']}\">{$xx1}. ".$pm1['menuName']."</option>";

		                                if(count($pm1['level_2'])>0){

		                                    $xx2 = 1;
		                                    foreach ($pm1['level_2'] as $pm2) {
		                                        echo "<option value=\"2-{$pm2['menuId']}\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$xx1}.{$xx2}. ".$pm2['menuName']."</option>";

		                                        if(count($pm2['level_3'])>0){

		                                            $xx3 = 1;
		                                            foreach ($pm2['level_3'] as $pm3) {
		                                                echo "<option value=\"3-{$pm3['menuId']}\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$xx1}.{$xx2}.{$xx3} ".$pm3['menuName']."</option>";
		                                                
		                                                if(count($pm3['level_4'])>0){

		                                                    $xx4 = 1;
		                                                    foreach ($pm3['level_4'] as $pm4) {
		                                                        echo "<option value=\"4-{$pm4['menuId']}\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$xx1}.{$xx2}.{$xx3}.{$xx4} ".$pm4['menuName']."</option>";

		                                                        $xx4++;
		                                                    }
		                                                }
		                                                $xx3++;
		                                            }
		                                        }
		                                        $xx2++;
		                                    }
		                                }
		                                $xx1++;
		                            }
		                        ?>
                        		</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2 req" for="menu_name">Nama</label>
							<div class="col-lg-10">
								<input type="text" name="menu_name" class="form-control" id="menu_name" required>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2" for="menu_akses">Metode Akses</label>
							<div class="col-lg-10">
								<select class="form-control" id="menu_akses" name="menu_akses" onchange="linktype(this.value);">
			                        <option value="admin_link" selected="selected">Modul MVC</option>
			                        <option value="out_link">Outside URL</option>
			                        <option value="no_link">Tidak ada akses</option>
			                    </select>
			                    <span class="form-text text-muted">Bagian ini tidak akan dapat diperbarui. Mohon untuk memperhatikan inputan data.</span>
							</div>
						</div>

						<div id="modulelink">

							<div class="form-group row">
								<label class="col-form-label col-lg-2" for="modularmvc">Tipe Modul</label>
								<div class="col-lg-10">
									<select class="form-control" id="modularmvc" name="modulartype">
										<option value="hmvc" selected="selected">Modular HMVC</option>
										<option value="mvc">Standar Codeigniter</option>
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-form-label col-lg-2 req" for="modul">Akses MVC</label>
								<div class="col-lg-10">
									<input type="text" name="aksesmvc" class="form-control" id="modul" data-parsley-required="true">
									
									<div class="alert-hmvc">
										<!-- Info alert -->
										<div class="alert alert-light alert-arrow-left mt-2 mb-0" role="alert">
											Direkomendasikan tidak menulisnya dengan menggunakan spasi. Semua kebutuhan MVC (Model View dan Controller) akan dibuat sesuai dengan penamaan pada bidang ini. Silahkan periksa file dengan struktur berikut setelah Anda melakukan penambahan.
											<ol class="mb-0">
												<li><code>modules/{nama_akses}/models/{Nama_akses}_model.php</code></li>
												<li><code>modules/{nama_akses}/views/admin/{nama_akses}_view.php</code></li>
												<li><code>modules/{nama_akses}/views/admin/{nama_akses}_add.php</code></li>
												<li><code>modules/{nama_akses}/views/admin/{nama_akses}_edit.php</code></li>
												<li><code>modules/{nama_akses}/controllers/admin/{Nama_akses}.php</code></li>
											</ol>
										</div>
										<!-- /info alert -->
									</div>

									<div class="alert-mvc" style="display:none;">
										<!-- Info alert -->
										<div class="alert alert-light alert-arrow-left mt-2 mb-0" role="alert">
											Direkomendasikan tidak menulisnya dengan menggunakan spasi. Semua kebutuhan MVC (Model View dan Controller) akan dibuat sesuai dengan penamaan pada bidang ini. Silahkan periksa file dengan struktur berikut setelah Anda melakukan penambahan.
											<ol class="mb-0">
												<li><code>models/{Nama_akses}_model.php</code></li>
												<li><code>views/admin/{nama_akses}/{nama_akses}_view.php</code></li>
												<li><code>views/admin/{nama_akses}/{nama_akses}_add.php</code></li>
												<li><code>views/admin/{nama_akses}/{nama_akses}_edit.php</code></li>
												<li><code>controllers/admin/{Nama_akses}.php</code></li>
											</ol>
										</div>
										<!-- /info alert -->
									</div>
									
								</div>
							</div>
						</div>
						<div id="urllink">
							<div class="form-group row">
								<label class="col-form-label col-lg-2 req" for="outlink">URL</label>
								<div class="col-lg-10">
			                        <input type="text" class="form-control" id="outlink" disabled="disabled" name="outlink" data-parsley-required="false" data-parsley-type="url" />
			                        <span class="form-text text-muted">Contoh: http://url-tujuan.com/</span>
			                    </div>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2" for="iconmenu">Icon Menu</label>
							<div class="col-lg-10">
								<input type="text" name="iconmenu" class="form-control" id="iconmenu">
								<span class="form-text text-muted">Pilih icon disini <button data-toggle="modal" data-target="#pilihicon" id="modal_pilihicon" type="button" class="btn btn-xs btn-light" style="padding-top: 2px;padding-bottom: 2px;"><i class="fe fe-gift"></i> Pilih</button></span>

								<!-- Modal Icon -->
				                <div class="modal fade" id="pilihicon" role="dialog" aria-hidden="true">
				                    <div class="modal-dialog" style="max-width:90%;">
				                        <div class="modal-content">
				                            <div class="modal-header">
				                                <h5 class="modal-title"><?php echo 'Pilih icon disini'; ?></h5>
				                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo 'tutup'; ?></span></button>
				                            </div>

				                            <div class="modal-body">
				                                <div class="row">
				                                    <div class="col-md-6 mt-2">
				                                        <select class="custom-select" id="pilihanicon">
				                                            <option value="feather">Feather Icons</option>
				                                            <option value="font-awesome">Font Awesome</option>
				                                            <option value="icomoon">Icomoon Free</option>
				                                            <option value="linearicons">Linearicons Free</option>
				                                        </select>
				                                    </div>
				                                    <div class="col-md-12 mt-4">
				                                        <div id="content_icon"></div>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="modal-footer">
				                                <button type="button" class="btn btn-secondary btn-sm btnmodallang_nama_menu" id="btncancel_nama_menu" data-dismiss="modal"><?php echo 'Tutup'; ?></button>
				                            </div>
				                        </div><!-- /.modal-content -->
				                    </div>
				                    <!-- /.modal-dialog -->
				                </div>
				                <!-- End Modal -->

							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2" for="attrclass">Class</label>
							<div class="col-lg-10">
								<input type="text" name="attrclass" class="form-control" id="attrclass">
								<span class="form-text text-muted">Class adalah attribut dari tag HTML. Gunakan spasi untuk penamaan class yang lebih dari 1 class.</span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-2 req">Aktif</label>
							<div class="col-lg-10">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="aktif" id="yaktif" value="y" checked="checked">
									<label class="form-check-label" for="yaktif">Ya</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="aktif" id="naktif" value="n">
									<label class="form-check-label" for="naktif">Tidak</label>
								</div>
							</div>
						</div>

					</div>

					<div class="col-md-3 col-sm-12">
						<h5>Hak Akses</h5><hr/>
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="mn_view" value="y">
								View
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="mn_add" value="y">
								Tambah
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="mn_edit" value="y">
								Edit
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="mn_hapus" value="y">
								Hapus
							</label>
						</div>
					</div>

					<div class="col-md-12 col-sm-12">
						<hr/>
						<div class="form-group">
							<button class="btn btn-primary" type="submit"><i class="icon-plus3"></i> <?php echo 'Tambah'; ?></button>
						</div>
					</div>
				</div>
				<?php 
				echo form_close();
				endif;
				?>
			</div>

		</div>
	</div>
</div>
<?php 
include V_ADMIN_PATH . "footer.php";
?>