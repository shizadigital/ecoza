<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
Register style (CSS)
************************************/
$request_css_files = array(
    'vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
    'vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'
);
$request_style = "";
$this->assetsloc->reg_admin_style($request_css_files,$request_style);

/*******************************************
Register Script (JavaScript)
*******************************************/
$request_script_files = array(
    'vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js'
);
$request_script = "
$( document ).ready(function() {
    $('.tglpicker').datepicker({
        autoclose: true,
        orientation: \"bottom\",
        endDate: \"".date("d/m/Y")."\",
        templates: {
            leftArrow: '<i class=\"fe fe-chevrons-left\"></i>',
            rightArrow: '<i class=\"fe fe-chevrons-right\"></i>'
        },
        format:\"dd-mm-yyyy\"
    });

    $('.tanggalpicker').click(function(event) {
        console.log('Preventing');
        event.preventDefault();
        event.stopPropagation();
    });
});";
$this->assetsloc->reg_admin_script($request_script_files,$request_script);

include V_ADMIN_PATH . "header.php";
include V_ADMIN_PATH . "sidebar.php";
include V_ADMIN_PATH . "topbar.php";

if(is_view() ):
?>
<div class="row">

	<div class="col-md-12">
        <div class="card"><div class="card-body">
        <?php echo form_open( admin_url( $this->uri->segment(2).'/' ), array( 'method'=>'get' ) ); ?>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" name="username" value="<?php if(!empty($this->input->get('username'))){ echo $this->input->get('username'); } ?>" class="form-control" placeholder="<?php echo t('username'); ?>">

                        <input type="text" name="startdate" value="<?php if(!empty($this->input->get('startdate'))){ echo $this->input->get('startdate'); } ?>" class="form-control tglpicker" placeholder="<?php echo t('startdate'); ?>">

                        <input type="text" name="enddate" value="<?php if(!empty($this->input->get('enddate'))){ echo $this->input->get('enddate'); } ?>" class="form-control tglpicker" placeholder="<?php echo t('enddate'); ?>">


                        <div class="input-group-append">
                            <button type="submit" class="btn btn-light"><i class="fe fe-filter"></i> <?php echo t('filter'); ?></button>
                            <a href="<?php echo admin_url( $this->uri->segment(2).'/' ) ?>" class="btn btn-secondary"><i class="fe fe-refresh-cw"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php echo form_close(); ?>
        </div></div>
    </div>

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

			<div class="card-body">               

				<?php echo form_open( admin_url( $this->uri->segment(2).'/log_active' ), array( 'id'=>'valid', 'class'=>'form_bulk' ) ); ?>
				<div class="row">
					<div class="col-md-6">
						<?php
						if( is_edit() ){ 
							if(check_option('logactivity')){

								if(get_option('logactivity') == 'y'){

									echo '<a href="'.admin_url($this->uri->segment(2) . '/inactive').'" class="btn btn-danger"><i class="fe fe-x"></i> '.t('inactive').'</a>';

								} else {

									echo '<a href="'.admin_url($this->uri->segment(2) . '/active').'" class="btn btn-success"><i class="fe fe-check"></i> '.t('active').'</a>';

								}

							} else {
								echo '<a href="'.admin_url($this->uri->segment(2) . '/active').'" class="btn btn-success"><i class="fe fe-check"></i> '.t('active').'</a>';
							}
						}
						?>

						<?php if( is_delete() ){ ?>
							<a href="<?php echo admin_url($this->uri->segment(2) . '/truncate') ?>" class="btn btn-danger"><i class="fe fe-trash"></i> <?php echo t('log_remove_log'); ?></a>
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
									<th style="width:25px;" class="text-center"><?php echo t('no_number'); ?></th>
									<th style="width:170px;"><?php echo t('username'); ?></th>
									<th style="width:300px;"><?php echo t('appliances'); ?></th>
									<th style="min-width:300px;"><?php echo t('description'); ?></th>
									<th style="width:90px;" class="text-center"><?php echo t('mainid'); ?></th>
									<th style="width:120px;;"><?php echo t('time'); ?></th>
									<th style="width:110px;" class="text-center"><?php echo t('type'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								if( $totaldata > 0 ){
									$no = (($this->uri->segment(3)) ? $this->uri->segment(3) : 0) + 1;
									foreach( $data AS $keydata => $r ){
								?>
								<tr>
									<td class="text-center"><?php echo $no; ?></td>
									<td>
										<?php 
											echo (!empty($r['userLogin']))?$r['userLogin']:'<i class="fe fe-minus"></i>';
										?>
									</td>
									<td>
										<?php 
											echo '
											<i class="fe fe-globe"></i> IP: '.$r['logIP'].'<br/>
											<i class="fe fe-chrome"></i> Browser: '.$r['logBrowser'].'<br/>
											<i class="fe fe-cpu"></i> OS: '.$r['logOS'].'<br/>
											';
											if( $this->session->userdata('leveluser')=='1' ){ echo '<i class="fe fe-link"></i> URL: '.$r['logURL'].'<br/>'; }
										?>
									</td>
									<td>
										<?php 
											echo (!empty($r['logDescription']))?$r['logDescription']:'<i class="fe fe-minus"></i>';
										?>
									</td>
									<td class="text-center">
										<?php 
											echo ($r['logIdMaster']!=0)?$r['logIdMaster']:'<i class="fe fe-minus"></i>';
										?>
									</td>
									<td>
									<?php
									$stamp = time2timestamp($r['logDateTime']);
									$tglsays = dateSays($stamp);
									$thdate = getDay(date('Y-m-d', $stamp)).', '.date('d', $stamp).' '. getMonth(date('m', $stamp)).' '.date('Y', $stamp);
									echo "<abbr data-toggle=\"tooltip\" title=\"{$thdate} - ".date('H:i', $stamp)."\">{$tglsays} ".t('ago')."</abbr>";
									?>
									</td>
									<td class="text-center">
										<?php 
											echo $r['logType'];
										?>
									</td>
								</tr>
								<?php
									$no++; }
								} else {
								?>
								<tr>
									<td colspan="7" class="text-center"><?php echo t('nodatafound');?></td>
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
