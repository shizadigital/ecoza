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

	echo '<link rel="stylesheet" type="text/css" href="'.web_assets('vendors/prism/prism.css').'">';
	$this->assetsloc->place_element_to_footer('<script src="'.web_assets('vendors/prism/prism.js').'"></script>');
?>
<style>
code[class*="language-"],
pre[class*="language-"] {
    word-wrap: normal !important;
	white-space: pre-line; 
	white-space: pre-wrap;
}
</style>
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

	$linemethod = ($this->input->get('break')=='y') ? true:false;
	?>
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">

					<div class="col-md-12">
						<h5 class="card-title mb-0"><?php echo t('database') . ' '.$tablename; ?></h5>
					</div>

				</div>
			</div>

			<div class="card-body">

				<div class="row">
					<div class="col-md-6">
						<div style="font-style:italic;">
							<a class="btn btn-outline-info btn-sm<?php echo (($linemethod)?"":" active"); ?>" href="<?php echo admin_url($this->uri->segment(2)."/array_migration/".$this->uri->segment(4)); ?>">No Line Break</a>
							<a class="btn btn-outline-info btn-sm<?php echo (($linemethod)?" active":""); ?>" href="<?php echo admin_url($this->uri->segment(2)."/array_migration/".$this->uri->segment(4)."/?break=y"); ?>">Line Break</a>
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-right" style="font-style:italic;"><?php echo t('total'). " " . $totaldata; ?></div>
					</div>
					
					<div class="col-md-12">
						<hr/>
						<pre class="line-numbers"><code class="language-php"><?php
                        echo "[\r\n";
                        $count = count($data);
                        $no = 1;
                        foreach($data as $key => $r){
                            echo "\t[".(($linemethod)?"\r\n":"");
                            
                            $countr = count($r);
                            $nox=1;
                            foreach($r as $k => $v){
                                echo (($linemethod)?"\t\t":"")."'{$k}' => '".str_replace("'","\'",htmlspecialchars($v))."'";

                                if($countr != $nox){ echo ",".(($linemethod)?"\r\n":" "); }
                                $nox++;
                            }

                            echo (($linemethod)?"\r\n\t":"")."]";

                            if($count != $no){ echo ",\r\n"; }
                            $no++;
                        }
                        echo "\r\n]";
                        ?></code></pre>                      
					</div>

				</div>

			</div>

		</div>
    </div>
    
</div>
<?php
endif;

include V_ADMIN_PATH . "footer.php";