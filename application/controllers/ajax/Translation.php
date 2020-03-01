<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translation extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('cookie');
		$this->lang->load('admin',get_cookie('admin_lang'));
		
		// validate ajax with token cookie
		if( $this->input->post('CP') !== get_cookie('sz_token') ){
			exit;
		}
	}

	public function index(){

		if( is_multilang() ){

			$defaultlang =  $this->config->item('language');
			$theflagcodedefault = strtolower( explode("_",  $defaultlang)[1] );

			echo '<div class="row">
				<div class="col-md-12">
					<em><strong>'.t('defaultlanguage').': <i class="flag-icon flag-icon-'.$theflagcodedefault.'"></i> '.ucwords(locales($defaultlang, TRUE)).'</strong></em>
					<hr/>
				</div>
			';

			$array_availablelang = array();
			if( $this->input->post('availabellang') ){
				if( !empty($this->input->post('availabellang') ) ){
					$array_availablelang = explode(" ", $this->input->post('availabellang'));
				}
			}

			foreach (langlist() as $key => $value) {
				if($value == $defaultlang){
					continue;
				}
				$theflagcode = strtolower( explode("_",  $value)[1] );
				$country = locales($value);

				if(in_array($value, $array_availablelang)) {
					$langavail = true;
				}else { 
					$langavail = false;
				}

				echo '
				<div class="col-md-6">
					<div class="form-check">
						<label class="form-check-label">
							<input type="checkbox" class="choose_'.$this->input->post('fieldname').' form-check-input"';

							if($langavail) {
								echo ' disabled="disabled" checked="checked"';
							}else { 
								echo ' name="chooselang[]" value="'.$value.'"';
							}

							echo '> ';
							if($langavail){ echo '<del class="text-muted">'; }
							echo '<i class="flag-icon flag-icon-'.$theflagcode.'"></i> '.ucwords($country);
							if($langavail){ echo '</del>'; }
							echo '
						</label>
					</div>
				</div>
				';
			}
			echo '</div>
			<script type="text/javascript">
			$(function () {
				$(".btncancel_'.$this->input->post('fieldname').'").click(function(){
					$("input[name=\'chooselang[]\'].choose_'.$this->input->post('fieldname').':checked").map(function(){
						var valclass = $(this).val();
						$("#thelang_'.$this->input->post('fieldname').'").removeClass(valclass);
					});                
				});

				$("input[name=\'chooselang[]\'].choose_'.$this->input->post('fieldname').'").click(function() {
					var theclass = $(this).val();

					if( $(this).is(\':checked\') ){
						$(\'#thelang_'.$this->input->post('fieldname').'\').addClass(theclass);
						$("#btnsubmit_'.$this->input->post('fieldname').'").removeAttr("disabled");
					} else {
						$(\'#thelang_'.$this->input->post('fieldname').'\').removeClass(theclass);
						$("#btnsubmit_'.$this->input->post('fieldname').'").attr(\'disabled\',\'disabled\');
					}
				});
			});
			</script>
			';
		}
		
	}

	public function langproccess(){

		if( is_multilang() ){

			if( count($this->input->post('val')) > 0 AND $this->input->post('val') ) {

				foreach ($this->input->post('val') as $key => $value) {
					$theflagcode = strtolower( explode("_",  $value)[1] );
					$country = locales($value);
	
	
					 echo '
						<div id="langelement_'.$this->input->post('fieldname').'_'.$value.'">';
	
					if($this->input->post('fieldtype')=='text'){
						$attrinput = array(
							'class' 		=> 'form-control inputlang',
							'name' 			=> 'datalang['.$this->input->post('fieldname').']['.$value.'][translation]',
							'placeholder' 	=> $country
						);
						echo '
							<div class="input-group mb-3 mt-15">
								'. form_input($attrinput) .'
								<div class="input-group-append">
									<span class="input-group-text bg-light" style="border:unset;"><i class="flag-icon flag-icon-'.$theflagcode.'"></i></span>
								
									<button class="btn btn-danger" id="rmlang_'.$this->input->post('fieldname').'_'.$value.'" type="button"><i class="fa fa-times"></i></button>
								</div>
							</div>
							<input type="hidden" name="datalang['.$this->input->post('fieldname').']['.$value.'][InputType]" value="text">
						';
					}
	
					if($this->input->post('fieldtype')=='textarea'){
						$attrinput = array(
							'class' 		=> 'form-control inputlang',
							'name' 			=> 'datalang['.$this->input->post('fieldname').']['.$value.'][translation]',
							'placeholder' 	=> $country,
							'rows' 			=> 5,
                			'cols' 			=> '',
						);
						echo '
							<div class="input-group" style="margin-top:15px;">
								'.form_textarea($attrinput).'
								<div class="input-group-append align-top">
									<span class="input-group-text bg-light" style="border:unset;"><i class="flag-icon flag-icon-'.$theflagcode.'"></i></span>
								
									<button class="btn btn-danger" id="rmlang_'.$this->input->post('fieldname').'_'.$value.'" type="button"><i class="fa fa-times"></i></button>
								</div>
							</div>
							<input type="hidden" name="datalang['.$this->input->post('fieldname').']['.$value.'][InputType]" value="textarea">
						';
					}
	
					// if($this->input->post('fieldtype')=='texteditor'){
					// 	$postclass_ = $this->input->post('classeditor') ? ' '.$this->input->post('classeditor'):'';
					// 	$postclass = $this->input->post('classeditor') ? $this->input->post('classeditor'):'';
					// 	echo '
					// 		<script src="'.memo_admin_url().'/assets/vendors/tinymce/tinymce_standard.js"></script>
	
					// 		<div class="input-group mb-3 mt-15">
					// 			<textarea class="form-control inputlang'.$postclass_.'" name="datalang['.$this->input->post('fieldname').']['.$value.'][translation]" placeholder="'.$country.'" id="wysiwg_editor_'.$this->input->post('fieldname').'_'.$value.'"></textarea>
					// 			<div class="input-group-append align-top bg-light"><span class="input-group-text"><i class="flag-icon flag-icon-'.$theflagcode.'"></i></span></div>
					// 			<div class="input-group-append align-top">
					// 				<button class="btn btn-danger" id="rmlang_'.$this->input->post('fieldname').'_'.$value.'" type="button"><i class="fa fa-times"></i></button>
					// 			</div>
					// 		</div>
					// 		<input type="hidden" name="datalang['.$this->input->post('fieldname').']['.$value.'][InputType]" value="texteditor">
					// 	';
					// }
	
					echo '<script type="text/javascript">
						jQuery(document).ready(function($){';
							echo '
								$("#rmlang_'.$this->input->post('fieldname').'_'.$value.'").click(function(){
									$("#thelang_'.$this->input->post('fieldname').'").removeClass(\''.$value.'\');
									$("#langelement_'.$this->input->post('fieldname').'_'.$value.'").remove(\'#langelement_'.$this->input->post('fieldname').'_'.$value.'\');
								});
							});
							</script>
						</div>';
				}
	
			} else{
				echo '503';
			}
		}

	}
}
