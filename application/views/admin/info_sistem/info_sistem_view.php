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

?>
<!-- start-clients contant-->
<div class="row">
    <div class="col-12">
        <div class="card card-statistics">
            <div class="card-body">

                <div class="tab nav-border-bottom">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="umum-tab" data-toggle="tab" href="#umum" role="tab" aria-controls="umum" aria-selected="true">Umum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="phpinfo-tab" data-toggle="tab" href="#phpinfo" role="tab" aria-controls="phpinfo" aria-selected="false">PHP Info</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                    	<div class="tab-pane fade py-4 active show" id="umum" role="tabpanel" aria-labelledby="umum-tab">
                    		<div class="row">
                    			<div class="col-md-5">
                    				<h4>Website Requirement</h4>
									<div class="table-responsive-sm">
	                    				<table class="table table-bordered table-hover">
	                    					<?php
											foreach($data as $key => $val){
												$statclass='light';
												$faclass = "minus";
												if( $val['result']['type']=='ok' ){ $statclass = "success"; $faclass = "check"; }
												if( $val['result']['type']=='error' ){ $statclass = "danger"; $faclass = "times"; }
												?><tr>
													<td width="230"><b><?php print $val['name'];?></b></td>
													<td>
														<span class="badge badge-<?php print $statclass; ?>"><i class="fa fa-<?php echo $faclass; ?>"></i> <?php print strtoupper($val['result']['type']); ?></span>
														<?php
														if(isset($val['result']['desc'])){
															?><div class="desc"><?php print $val['result']['desc'];?></div><?php
														}?>
													</td>
												</tr>
												<?php
											}
											?>
	                    				</table>
	                    			</div>
                    			</div>
                    			<div class="col-md-4">
                    				<h4>Function Exists</h4>
                    				<div class="mb-4">
                    					<?php if(!empty($this->input->get('functionexists'))):

                    					if (function_exists($this->input->get('functionexists'))){
                    					?>
		                					<div class="alert alert-icon alert-success fade show" role="alert">
		                                        <i class="fa fa-check"></i> <code><?php echo $this->input->get('functionexists'); ?>()</code> is AVAILABLE
		                                    </div>
	                                	<?php
	                                	} else {
	                                	?>
	                                		<div class="alert alert-icon alert-danger fade show" role="alert">
		                                        <i class="fa fa-times"></i> <code><?php echo $this->input->get('functionexists'); ?>()</code> is NOT AVAILABLE
		                                    </div>
	                                	<?php 		
	                                	}
	                                	endif;
	                                	?>
	                                	<?php echo form_open( admin_url( $this->uri->segment(2) . '/'), array( 'method'=>'GET' ) ); ?>
				                            <div class="input-group">
				                                <input type="text" class="form-control form-control-sm" name="functionexists" placeholder="Type the function"<?php echo !empty($this->input->get('functionexists'))? " value='{$this->input->get('functionexists')}'":""; ?>>
				                                <div class="input-group-append">
				                                   <button class="btn btn-light btn-sm" type="submit"><i class="fa fa-search"></i></button>
				                                </div>
				                            </div>
				                            <small class="form-text text-muted">Example 'date' for date() function </small>
				                        <?php echo form_close(); ?>
                    				</div>
                    				<h4>Class Exists</h4>
                    				<div class="mb-4">
                    					<?php if(!empty($this->input->get('classexists'))):

                    					if (class_exists($this->input->get('classexists'))){
                    					?>
		                					<div class="alert alert-icon alert-success fade show" role="alert">
		                                        <i class="zmdi zmdi-check-circle"></i> <code>class <?php echo $this->input->get('classexists'); ?></code> is AVAILABLE
		                                    </div>
	                                	<?php
	                                	} else {
	                                	?>
	                                		<div class="alert alert-icon alert-danger fade show" role="alert">
		                                        <i class="fa fa-times"></i> <code>class <?php echo $this->input->get('classexists'); ?></code> is NOT AVAILABLE
		                                    </div>
	                                	<?php 		
	                                	}
	                                	endif;
	                                	?>
                    					<?php echo form_open( admin_url( $this->uri->segment(2) . '/'), array( 'method'=>'GET' ) ); ?>
				                            <div class="input-group">
				                                <input type="text" class="form-control form-control-sm" name="classexists" placeholder="Type the function"<?php echo !empty($this->input->get('classexists'))? " value='{$this->input->get('classexists')}'":""; ?>>
				                                <div class="input-group-append">
				                                   <button class="btn btn-light btn-sm" type="submit"><i class="fa fa-search"></i></button>
				                                </div>
				                            </div>
				                            <small class="form-text text-muted">Example 'DateTime' for class DateTime</small>
				                        <?php echo form_close(); ?>
                    				</div>
                    				<hr/>
                    				<h4>PHP Location</h4>
                					<div class="table-responsive-sm">
                    					<table class="table table-bordered table-hover">
                    						<?php
											$myphp_location = explode(" ", exec("whereis php") );
											if(count($myphp_location) > 0){
											    $no = 1;
												foreach ($myphp_location as $key => $value) {
												    //if( $no === 1 ){ continue; }
													echo '<tr>';
													echo '<td style="width:30px;" class="text-center">'.$no.'</td>';
													echo '<td>'.$value.'</td>';
													echo '</tr>';
													$no++;
												}
											}
											?>
                    					</table>
                    				</div>
                    			</div>
                    			<div class="col-md-3">
                    				<h4>Information</h4>
                    				<div class="mb-4">
                    				<p><strong>Memo Version</strong>: <?php echo FRAMEWORK_VERSION; ?></p>
                    				<p><strong>CodeIgniter Version</strong>: <?php echo CI_VERSION; ?></p>
                    				<p><strong>Time Zone</strong>: <?php echo date_default_timezone_get(); ?></p>
                    				<p><strong>PHP Version</strong>: <?php echo phpversion(); ?></p>
                    				<p><strong>MySQL Version</strong>: <?php echo $mysqlversion; ?></p>
                    				<hr/>
                    				<p><strong>Your IP</strong>: <?php echo getIP(); ?></p>
                    				<p><strong>Your OS</strong>: <?php echo getOS(); ?></p>
                    				<p><strong>Your Browser</strong>: <?php echo getBrowser(); ?></p>
                    				</div>
                    			</div>
                    		</div>
                    	</div>

                    	<div class="tab-pane fade py-4" id="phpinfo" role="tabpanel" aria-labelledby="phpinfo-tab">
                			<?php 
                			ob_start();
						    phpinfo();
						    $phpinfo = ob_get_contents();
						    ob_end_clean();
						    $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
						    echo "
						        <style type='text/css'>
						            #phpinfo { color:#333 !important; }
						            #phpinfo pre {margin: 0; font-family: monospace;}
						            #phpinfo a:link {color: #009; text-decoration: none; background-color: #fff;}
						            #phpinfo a:hover {text-decoration: underline;}
						            #phpinfo table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
						            #phpinfo .center {text-align: center;}
						            #phpinfo .center table {margin: 1em auto; text-align: left;}
						            #phpinfo .center th {text-align: center !important;}
						            #phpinfo td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
						            #phpinfo h1 {font-size: 150%;}
						            #phpinfo h2 {font-size: 125%;}
						            #phpinfo .p {text-align: left;}
						            #phpinfo .e {background-color: #ccf; width: 300px; font-weight: bold;}
						            #phpinfo .h {background-color: #99c; font-weight: bold;}
						            #phpinfo .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
						            #phpinfo .v i {color: #999;}
						            #phpinfo img {float: right; border: 0;}
						            #phpinfo hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
						        </style>
						        <div id='phpinfo'>
						            $phpinfo
						        </div>
						        ";
							?>
                    	</div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php
 
include V_ADMIN_PATH . "footer.php";
?>