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

if( is_view() ):
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
		<div class="card">

			<div class="card-header">
				<div class="row">

					<div class="col-md-12">
						<h5 class="card-title mb-0"><?php echo t('database'); ?></h5>
					</div>

				</div>
			</div>

			<div class="card-body">

				<div class="row">

					<div class="col-md-12 pt-2">
						<div class="text-right" style="font-style:italic;"><?php echo t('total'). " " . $totaldata; ?></div>
					</div>
					
					<div class="col-md-12 py-3">
					
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								
								<thead>
									<tr>
										<th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
										<th style="width:280px;"><?php echo t('tablename'); ?></th>
										<th style="width:150px;" class="text-center"><?php echo t('rows'); ?></th>
										<th style="width:150px;" class="text-center"><?php echo t('engine'); ?></th>
										<th style="width:150px;" class="text-center"><?php echo t('dbcollation'); ?></th>
										<th style="width:80px;" class="text-center"><i class="fe fe-settings"></i></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = 1;
									foreach ($data AS $key => $r){
										$table = str_replace($_ENV['DB_PREFIX'], '', $key);
									?>
									<tr>
										<td class="text-center"><?php echo $no; ?></td>
										<td><?php echo $key; ?></td>
										<td class="text-center"><?php echo $r['Rows']; ?></td>
										<td class="text-center"><?php echo $r['Engine']; ?></td>
										<td class="text-center"><?php echo $r['Collation']; ?></td>
										<td class="text-center">
											<div class="btn-group dropdown">
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
													<?php echo t('action'); ?>
													<span class="caret"></span>
													<span class="sr-only">Split button!</span>
												</button>
												<ul class="dropdown-menu dropdown-menu-right">
													
													<a href="<?php echo admin_url($this->uri->segment(2)."/array_migration/".$key); ?>" class="dropdown-item"><i class="fe fe-eye"></i> Get Array for Migration</a>

												</ul>
											</div>
										</td>
									</tr>
									<?php $no++; } ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-md-12">
						<?php
							echo "<div class=\"text-right\" style=\"margin-top:5px;font-style:italic;\">".t('total')." $totaldata</div>"
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
