<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormControl {

    protected $CI;

    public function __construct(){
		// load environment of CI
        $this->CI =& get_instance();

        // load helper
		$this->CI->load->helper('cookie');
    }

    /**
     * Make the multilanguage inputs field
     * 
     * @param array $inputs
     * 
     * @return string
     */
    public function buildTranslationInputs( $inputs = array() ){
        $CI = $this->CI;
        $result     = '';
        $dbtable    = '';
        $dbfield    = '';
        $dbrelid    = '';
        $value      = '';
        $attrClass  = '';

        // get default lang
        $defaultlang = $CI->config->item('language');

        $required  = ( isset($inputs['required']) ) ? $inputs['required']:false;
        $inputsType  = ( isset($inputs['type']) ) ? $inputs['type']:false;
        $label  = ( isset($inputs['label']) ) ? $inputs['label']:false;
        $texteditor  = ( isset($inputs['texteditor']) ) ? $inputs['texteditor']:false;
            
        // check if value data is not empty
        if( isset($inputs['value']) ){
            if( is_array($inputs['value']) ){                               
                $dbtable    = $inputs['value']['table'];
                $dbfield    = $inputs['value']['field'];
                $dbrelid    = $inputs['value']['id'];

                if( !empty($dbtable) AND !empty($dbfield) AND  !empty($dbrelid) ){
                    $querymysql = $CI->db->query("SHOW KEYS FROM ".$CI->db->dbprefix($dbtable)." WHERE Key_name = 'PRIMARY'");
                    $theDB = $querymysql->result_array()[0];
            
                    $value = getval($dbfield, $dbtable,"{$theDB['Column_name']}='{$dbrelid}'");
                } else {
                    show_error( t('errormultilangvalue'),503, t('datacannotbeloaded') );
                }
            } else {
                show_error( t('errormultilangvalue'),503, t('datacannotbeloaded') );
            }
        }

        $sqlclause = "dtRelatedField='{$dbfield}' AND dtRelatedTable='{$dbtable}' AND dtRelatedId='{$dbrelid}'";
	    $sql = "SELECT dtLang,dtTranslation,dtInputType FROM ".$CI->db->dbprefix('dynamic_translations')." WHERE ".$sqlclause;
        
        // unset variable
        unset($inputs['type'], $inputs['required'], $inputs['label'], $inputs['value'], $inputs['texteditor']);
        
        if( $inputsType=='texteditor' ){
            
            $attrId = $inputs['name'];
            $attrClass = '';
            if( isset($inputs['class']) OR isset($inputs['id']) ){
                if(!empty($inputs['class'])){
                    $attrClass = " ".$inputs['class'];
                }
                if(!empty($inputs['id'])){
                    $attrId = $inputs['id'];
                }        
            }

            $result .= '
            <div class="row">';
                if( is_multilang() ){
                $result .= '
                <div class="col-md-12 col-sm-12 mb-2">
                    <div class="tab langtab-'.$attrId.'">
                        <ul class="nav nav-tabs justify-content-end" role="tablist">
                            <li><div class="pt-2 pr-3"><i class="fa fa-language"></i> '.t('translate').':</div> </li>';
                            foreach (langlist() as $keyl => $valuel) {
                                $theflagcode = strtolower( explode("_",  $valuel)[1] );
                                $country = locales($valuel);

                                $result .= '
                                <li class="nav-item">
                                <a class="'.( ($valuel == $defaultlang) ?  ' active show':'').' nav-link" id="tablang-'.$theflagcode.'-'.$attrId.'" data-toggle="tab" href="#lang-'.$theflagcode.'-'.$attrId.'" role="tab" aria-controls="lang-'.$theflagcode.'-'.$attrId.'" aria-selected="true"><i class="flag-icon flag-icon-'.$theflagcode.'"></i> ';
                                    // $result .= ucwords($country);
                                    $result .= strtoupper($theflagcode);

                                    $result .= '</a>
                                </li>
                                ';
                            }
                            $result .= '
                        </ul>
                    </div>
                </div>
                ';
                }
                $result .= '
            </div>
            ';
        }

        $result .= '<div class="input-group mb-2"'.( ($inputsType=='texteditor') ? ' style="display:block;"':'').'>'."\n";

        /**
         * 
         * Multilanguage for input text editor like tinyMCE
         * 
         */
        if($inputsType == 'texteditor'){

            // inject tinyMCE plugin here
            $request_script_files = array();
            $classtexteditor = '';
            if( $texteditor=='standard' ){
                $request_script_files = array('vendors/tinymce/tinymce_standard.js');
                $classtexteditor = ' tinymcestandard';
            }
            elseif($texteditor=='simple'){
                $request_script_files = array('vendors/tinymce/tinymce_simple.js');
                $classtexteditor = ' tinymcesimple';
            }
            elseif($texteditor=='verysimple'){
                $request_script_files = array('vendors/tinymce/tinymce_verysimple.js');
                $classtexteditor = ' tinymceverysimple';
            }

            $reqscriptfiles = array_merge(
                array(
                    'vendors/tinymce/tinymce.min.js',
                ),
                $request_script_files
            );
            $CI->assetsloc->reg_admin_script($reqscriptfiles);

            $result .= '<div class="tab-content">'."\n";

            // define required to attribute
            $required = ($required) ? array('data-parsley-required'=>'true'): array();            

            if( is_multilang() ){
                foreach (langlist() as $keyl2 => $valuel2) {
                    $theflagcode2 = strtolower( explode("_",  $valuel2)[1] );
                    $country2 = locales($valuel2);
                    
                    $dl = array();
                    if( !empty($dbtable) AND !empty($dbfield) AND  !empty($dbrelid) ){
                        if( countdata('dynamic_translations', $sqlclause." AND dtLang='{$valuel2}'") > 0 ){
                            $langsql = $sql . " AND dtLang='{$valuel2}'";
                            $querylang = $CI->db->query($langsql);
                            $dl = $querylang->result_array($querylang)[0];
                        }
			    	}

                    $result .= '<div class="tab-pane fade pt-2 tinymce-multilang'.( ($valuel2 == $defaultlang)? ' active show':'').'" id="lang-'.$theflagcode2.'-'.$attrId.'" role="tabpanel" aria-labelledby="tablang-'.$theflagcode2.'-'.$attrId.'">'."\n";

                    $result .= '<textarea id="'.$attrId.'-'.$theflagcode2.'" name="datalang['.$inputs['name'].']['.$valuel2.'][translation]" placeholder="'.$country2.'" rows="5" class="form-control'.$classtexteditor.$attrClass.'"'.( ($valuel2 == $defaultlang AND count($required) > 0)? ' data-parsley-required="true"':'').'>';

                    $dtranslation = (!empty($dl['dtTranslation']))? $dl['dtTranslation']:'';
                    $texteditorval = ($valuel2 == $defaultlang)?$value:$dtranslation;

                    $result .= $texteditorval;

                    $result .= '</textarea>'."\n";

			    	$result .= '<input type="hidden" name="datalang['.$inputs['name'].']['.$valuel2.'][InputType]" value="texteditor">';

                    $result .= '</div>'."\n";
                }
            }
            
            $result .= '</div>'."\n";
        }

        /**
         * 
         * Multilanguage for input textarea
         * 
         */
        elseif($inputsType == 'textarea'){
            // define required to attribute
            $required = ($required) ? array('data-parsley-required'=>'true'): array();

            $attrId = $inputs['name'];
            $attrRows = 5;

            if( isset($inputs['class']) OR isset($inputs['id']) OR isset($inputs['rows']) ){
                if(!empty($inputs['class'])){
                    $attrClass = " ".$inputs['class'];
                }
                
                if(!empty($inputs['id'])){
                    $attrId = $inputs['id'];
                }

                if(!empty($inputs['rows'])){
                    $attrRows = $inputs['rows'];
                }
            }

            // make standard attributes
            $attrStandard = array(
                'class' => 'form-control' . $attrClass,
                'id' => $attrId,
                'rows' => $attrRows,
                'cols' => '',
                'placeholder' => ucwords( locales($defaultlang) ) . ' ('.t('defaultlanguage').')',
                'value' => $value
            );

            $val_ = array_merge($inputs, $attrStandard, $required);

            $result .= form_textarea($val_);
        }

        /**
         * 
         * Multilanguage for input type text
         * 
         */
        elseif($inputsType == 'text'){
            // define required to attribute
            $required = ($required) ? array('required'=>'required'): array();

            $attrId = $inputs['name'];

            if( isset($inputs['class']) OR isset($inputs['id']) ){
                if(!empty($inputs['class'])){
                    $attrClass = " ".$inputs['class'];
                }
                
                if(!empty($inputs['id'])){
                    $attrId = $inputs['id'];
                }
            }

            // make standard attributes
            $attrStandard = array(
                'class' => 'form-control' . $attrClass,
                'id' => $attrId,
                'placeholder' => ucwords( locales($defaultlang) ) . ' ('.t('defaultlanguage').')',
                'value' => $value
            );

            $val_ = array_merge($inputs, $attrStandard, $required);

            $result .= form_input($val_);
        } 

        else {
            show_error( t('inputtypetranslationerror'), 503, t('error') ); exit;
        }

        // check if this web is multilang
        if( is_multilang() AND $inputsType!='texteditor'){
            $result .= '
	        <div class="input-group-append">
	            <button data-toggle="modal" data-target="#translate_'.$inputs['name'].'" class="btn btn-light shiza_tooltip" title="'.t('translate').'" id="modal_'.$inputs['name'].'" type="button"><i class="fa fa-language"></i></button>
	        </div>';
        }

        $result .= '</div>'."\n";

        /************************************
         * 
         * ajax and result start here
         * 
         ************************************/
        if( is_multilang() AND $inputsType!='texteditor' ){
            $result .= "\n".'<div id="thelang_'.$inputs['name'].'"';

            if( !empty($dbtable) AND !empty($dbfield) AND  !empty($dbrelid) ){
                $countdata = countdata("dynamic_translations",$sqlclause);
                if($countdata > 0){
                    $result .= ' class="';
                    $querythelang = $CI->db->query($sql);
                    $x=1;
                    foreach ( $querythelang->result_array() as $rthelang ) {
                        $result .= "{$rthelang['dtLang']}";
                        if($x!=$countdata){ $result .= ' '; }
                        $x++;
                    }
                    $result .= '"';
                }
            }

            $result .= '></div>
            
            <div id="translateresult_'.$inputs['name'].'">';

            // if value is available show the result
            if( !empty($dbtable) AND !empty($dbfield) AND  !empty($dbrelid) ){
                $query =  $CI->db->query($sql);
                foreach ($query->result_array() as $r ) {
    
                    $theflagcode = strtolower( explode("_",  $r['dtLang'])[1] );
                    $country = locales($r['dtLang']);
    
                    $result .= '
                    <div id="langelement_'.$inputs['name'].'_'.$r['dtLang'].'">';
    
                    if($r['dtInputType']=='text'){
                        $attrinput = array(
							'class' 		=> 'form-control inputlang'.$attrClass,
							'name' 			=> 'datalang['.$inputs['name'].']['.$r['dtLang'].'][translation]',
                            'placeholder' 	=> $country,
                            'value'         => $r['dtTranslation']
						);
                        $result .='
                            <div class="input-group mb-3 mt-15">
                                '. form_input($attrinput) .'
                                <div class="input-group-append"><span class="input-group-text"><i class="flag-icon flag-icon-'.$theflagcode.'"></i></span></div>
                                <div class="input-group-append">
                                    <button class="btn btn-danger" id="rmlang_'.$inputs['name'].'_'.$r['dtLang'].'" type="button"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <input type="hidden" name="datalang['.$inputs['name'].']['.$r['dtLang'].'][InputType]" value="'.$r['dtInputType'].'">';
    
                    }
                    elseif($r['dtInputType']=='textarea'){
                        $attrinput = array(
							'class' 		=> 'form-control inputlang'.$attrClass,
							'name' 			=> 'datalang['.$inputs['name'].']['.$r['dtLang'].'][translation]',
							'placeholder' 	=> $country,
							'rows' 			=> 5,
                			'cols' 			=> '',
                            'value'         => $r['dtTranslation']
						);
                        $result .= '
                            <div class="input-group mb-3 mt-15">
                                '.form_textarea($attrinput).'
                                <div class="input-group-append align-top"><span class="input-group-text"><i class="flag-icon flag-icon-'.$theflagcode.'"></i></span></div>
                                <div class="input-group-append align-top">
                                    <button class="btn btn-danger" id="rmlang_'.$inputs['name'].'_'.$r['dtLang'].'" type="button"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <input type="hidden" name="datalang['.$inputs['name'].']['.$r['dtLang'].'][InputType]" value="textarea">
                        ';
                    }
    
                    $result .= '
                        <script type="text/javascript">
                        $(function () {';
                            $result .= '
                            $("#rmlang_'.$inputs['name'].'_'.$r['dtLang'].'").click(function(){
                                $("#thelang_'.$inputs['name'].'").removeClass(\''.$r['dtLang'].'\');
                                $("#langelement_'.$inputs['name'].'_'.$r['dtLang'].'").remove(\'#langelement_'.$inputs['name'].'_'.$r['dtLang'].'\');
                            });
                        });
                        </script>
                    </div>
                    ';
                }
            }

            $result .= '</div>
            
            <!-- Modal -->
            <div class="modal fade" id="translate_'.$inputs['name'].'" role="dialog" aria-hidden="true">
                <div class="modal-dialog" style="max-width:380px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">'.t('translate').' - '.filter_clean($label).'</h5>
                            <button type="button" class="close btncancel_'.$inputs['name'].'" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">'.t('close').'</span></button>
                        </div>

                        <div class="modal-body" id="content_'.$inputs['name'].'"></div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm btnmodallang_'.$inputs['name'].' btncancel_'.$inputs['name'].'" data-dismiss="modal">'.t('cancel').'</button>
                            <button type="button" class="btn btn-danger btn-sm btnmodallang_'.$inputs['name'].'" id="btnsubmit_'.$inputs['name'].'">'.t('btnapply').'</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- End Modal -->
            
            <script type="text/javascript">
	    	jQuery(function($) {
	    		$("#modal_'.$inputs['name'].'").click(function(){

	    			$("#btnsubmit_'.$inputs['name'].'").attr(\'disabled\',\'disabled\');

	    			var langs = $("#thelang_'.$inputs['name'].'").attr("class");

	    			$.ajax({
			            type: "POST",
			            url: "'. base_url('ajax/translation').'",
			            data : { 
	                        fieldname: "'.$inputs['name'].'",
	                        availabellang: langs,
                            CP: "'.get_cookie('sz_token').'"
                            '.( is_csrf() ? ','.$CI->security->get_csrf_token_name().':"'.$CI->security->get_csrf_hash().'"':'').'
	                    },
			            beforeSend: function(data){
			                $(\'#content_'.$inputs['name'].'\').show().html(\'<div class="h-100 d-flex justify-content-center"><img src="'.web_assets('img/loader/loading.gif').'" alt="loader"></div>\');
			                $(this).attr(\'disabled\',\'disabled\');
			            },
			            success: function(data) {
			                if(data){
			                	$(\'#content_'.$inputs['name'].'\').show().html(data);
			                } else {
			                	$(\'#content_'.$inputs['name'].'\').show().html(\'<center><h4>'.t('datacannotbeloaded').'</h4></center>\');
			                }
			                $(this).removeAttr("disabled");
			            }
			        });
                });
                
                $("#btnsubmit_'.$inputs['name'].'").click(function(){

	    			var vallang = $("input[name=\'chooselang[]\'].choose_'.$inputs['name'].':checked").map(function(){return $(this).val();}).get();

	    			var jsondata = { 
			            	fieldtype: "'.$inputsType.'",
			            	fieldname: "'.$inputs['name'].'",			            	
	                        CP: "'.get_cookie('sz_token').'",
                            val: vallang
                            '.( is_csrf() ? ','.$CI->security->get_csrf_token_name().': "'.$CI->security->get_csrf_hash().'"':'').'
	                    };

	    			$.ajax({
			            type: "POST",
			            url: "'. base_url('ajax/translation/langproccess') .'",
			            data : jsondata,
			            async: true,
			            beforeSend: function(data){
			                $(\'#content_'.$inputs['name'].'\').show().html(\'<div class="h-100 d-flex justify-content-center"><img src="'.web_assets('img/loader/loading.gif').'" alt="loader"></div>\');
			                $(".btnmodallang_'.$inputs['name'].'").attr(\'disabled\',\'disabled\');
			            },
			            success: function(data) {
			                if(data){
			                	if(data == \'503\'){
			                		$(\'#translateresult_'.$inputs['name'].'\').show().html(\''.t('error').' 503\');
			                	} else {
			                		$(\'#translateresult_'.$inputs['name'].'\').show().append(data);
			                	}
			                } else {
			                	$(\'#translateresult_'.$inputs['name'].'\').show().html(\''.t('datacannotbeloaded').'\');
			                }
			                $(".btnmodallang_'.$inputs['name'].'").removeAttr("disabled");
			                $("#translate_'.$inputs['name'].'").modal(\'hide\');
			            }
			        });
	    		});
	    	});
            </script>
            ';
        }

        return $result;
    }

    /**
     * Make inputs field in content
     * 
     * @param array $inputs
     * @param string $layout (vertical|horizontal)
     * @param array $colsetting
     * 
     * @return string to show in html
     */
    public function buildInputs($inputs = array(), $layout = 'vertical', $colsetting = array() ){
        $CI = $this->CI;

        if(count( $inputs ) > 0){
            
            foreach( array_filter($inputs) AS $key => $val ){
                
                // define key before process the form
                $required           = ( isset($val['required']) ) ? $val['required']:false;
                $label              = ( isset($val['label']) ) ? $val['label']:'';
                $name               = ( isset($val['name']) ) ? $val['name']:'';
                $colsetting_label   = ( isset($colsetting['label']) ) ? $colsetting['label']:'';
                $colsetting_input   = ( isset($colsetting['input']) ) ? $colsetting['input']:'';

                $selectoption       = ( isset($val['option']) ) ? $val['option']:null;
                $selectedoption     = ( isset($val['selected']) ) ? $val['selected']:array();
                
                $formType = $val['type'];
                $help = ( isset($val['help']) ) ? $val['help']:'';
                $info = ( isset($val['info']) ) ? $val['info']:'';
                $extra = ( isset($val['extra']) ) ? $val['extra']:'';
                $inputgroup = ( isset($val['input-group']) ) ? $val['input-group']:array();
                $texteditortype = ( isset($val['texteditor']) ) ?  $val['texteditor']:'';

                // restyle for texteditor
                $classtexteditor = '';
                if($layout == 'horizontal' AND $formType =='multilanguage_texteditor'){
                    $classtexteditor = ' texteditor_controllabel';
                }
                
                echo ($formType !='hidden')?'<div class="form-group'.(($layout == 'horizontal') ? ' row':'').'">'."\n":'';

                if( $formType !=  'button' AND $formType !=  'submit' AND $formType !='hidden' AND !empty($label) ){
                    echo '<label';

                    if($layout == 'horizontal'){
                        $classval = ( ($layout == 'horizontal') ? $colsetting_label.' col-form-label'.$classtexteditor:'' ).( ($required)?' req':'' );
                        $classval = trim($classval);
                        echo ' class="'.$classval.'"';
                    } else {
                        echo ' class="d-block'.(($required)?' req':'' ).'"';
                    }

                    echo ' for="'.( ( isset($val['id']) )? $val['id']:explode("[",$name)[0]).'">' . $label . ( !empty($info) ? ' <i class="fa fa-question-circle text-blue shiza_tooltip" title="'.$info.'"></i>':'' ) .'</label>'."\n";
                }

                if( !empty($val['type']) ){

                    $col_element = $colsetting_input;
                    if( $formType =='submit'){ $col_element='col-md-12'; }

                    if($layout == 'horizontal' AND $formType !='hidden'){ echo '<div class="'.$col_element.'">'; }
                    
                    // remove key so as not to insert to attribute
                    unset( $val['type'], $val['help'], $val['label'], $val['required'], $val['option'], $val['selected'], $val['info'],$val['texteditor'],$val['extra'],$val['input-group'] );

                    // define required to attribute
                    $required = ($required) ? array('required'=>'required'): array();

                    /**
                     * content
                     */
                    if( $formType == 'content' ){
                        echo '<div class="pt-2">';
                        echo $val['value'];
                        echo '</div>';
                    }

                    /**
                     * plain text
                     */
                    elseif( $formType == 'plaintext' ){
                        echo '<input type="text" readonly class="form-control-plaintext" value="'.$val['value'].'">';
                    }

                    /**
                     * input type text multilanguage
                     */
                    elseif( $formType == 'multilanguage_text' ){
                        // make standard attributes
                        $attrStandard = array(
                            'type' => 'text',
                            'label' => $label,
                            'name' => $name,
                            'required' => ( count( $required ) > 0 ) ? true:false
                        );
                        
                        $val_ = array_merge($val, $attrStandard);

                        echo self::buildTranslationInputs( $val_ );
                    }

                    /**
                     * input textarea multilanguage
                     */
                    elseif( $formType == 'multilanguage_textarea' ){
                        // make standard attributes
                        $attrStandard = array(
                            'type' => 'textarea',
                            'label' => $label,
                            'name' => $name,
                            'required' => ( count( $required ) > 0 ) ? true:false
                        );
                        
                        $val_ = array_merge($val, $attrStandard);

                        echo self::buildTranslationInputs( $val_ );
                    }

                    /**
                     * input texteditor multilanguage
                     */
                    elseif( $formType == 'multilanguage_texteditor' ){
                        // make standard attributes
                        $attrStandard = array(
                            'type' => 'texteditor',
                            'label' => $label,
                            'name' => $name,
                            'required' => ( count( $required ) > 0 ) ? true:false,
                            'texteditor' => $texteditortype
                        );
                        
                        $val_ = array_merge($val, $attrStandard);

                        echo self::buildTranslationInputs( $val_ );
                    }

                    /**
                     * input texteditor
                     */
                    elseif( $formType == 'texteditor' ){

                        // inject tinyMCE plugin here
                        $request_script_files = array();
                        $classtexteditor = '';
                        if( $texteditortype=='standard' ){
                            $request_script_files = array('vendors/tinymce/tinymce_standard.js');
                            $classtexteditor = ' tinymcestandard';
                        }
                        elseif($texteditortype=='simple'){
                            $request_script_files = array('vendors/tinymce/tinymce_simple.js');
                            $classtexteditor = ' tinymcesimple';
                        }
                        elseif($texteditortype=='verysimple'){
                            $request_script_files = array('vendors/tinymce/tinymce_verysimple.js');
                            $classtexteditor = ' tinymceverysimple';
                        }

                        $reqscriptfiles = array_merge(
                            array(
                                'vendors/tinymce/tinymce.min.js',
                            ),
                            $request_script_files
                        );
                        $CI->assetsloc->reg_admin_script($reqscriptfiles);

                        $attrClass = "";
                        $attrId = explode("[",$name)[0];
                        $attrRows = 5;

                        if( isset($val['class']) OR isset($val['id']) OR isset($val['rows']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        echo '<textarea id="'.$attrId.'" name="'.$val['name'].'" rows="5" class="form-control'.$classtexteditor.$attrClass.'"'.( (count($required) > 0)? ' data-parsley-required="true"':'').'>';
                        
                        echo (isset($val['value'])) ? $val['value']:'';

                        echo '</textarea>'."\n";
                    }

                    /**
                     * input textarea
                     */
                    elseif( $formType == 'textarea' ){

                        $attrClass = "";
                        $attrId = explode("[",$name)[0];
                        $attrRows = 5;

                        if( isset($val['class']) OR isset($val['id']) OR isset($val['rows']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }

                            if(!empty($val['rows'])){
                                $attrRows = $val['rows'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId,
                            'rows' => $attrRows,
                            'cols' => ''
                        );

                        $val_ = array_merge($val, $attrStandard, $required);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_textarea($val_);  

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    } 

                    /**
                     * button
                     */
                    elseif( $formType == 'button' ){
                        $attrClass = "";
                        $clearfix = false;

                        if( isset($val['class']) OR isset($val['position']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }

                            if(!empty($val['position'])){
                                $attrClass .= " float-".$val['position'];
                                $clearfix = true;
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'btn' . $attrClass
                        );

                        $val_ = array_merge($val, $attrStandard);
                        
                        if( isset($val['bordertop']) ){ echo '<hr/>'; }   
                        
                        echo '<button type="button"';
                        foreach( $val_ AS $attr => $value){
                            if($attr == 'label'){ continue; }
                            echo ' '.$attr.'="'.$value.'"';
                        }
                        echo '>'.$label.'</button>'."\n";

                        if( $clearfix ){ echo '<div class="clearfix"></div>'; }
                    }

                    /**
                     * submit
                     */
                    elseif( $formType == 'submit' ){
                        $attrClass = "";
                        $clearfix = false;

                        if( isset($val['class']) OR isset($val['position']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }

                            if(!empty($val['position'])){
                                $attrClass .= " float-".$val['position'];
                                $clearfix = true;
                            }
                        }                        

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'btn' . $attrClass
                        );

                        $val_ = array_merge($val, $attrStandard);
                        
                        if( isset($val['bordertop']) ){ echo '<hr/>'; }                        

                        echo '<button type="submit"';
                        foreach( $val_ AS $attr => $value){
                            if($attr == 'label' OR $attr == 'position' OR $attr == 'bordertop'){ continue; }
                            echo ' '.$attr.'="'.$value.'"';
                        }
                        echo '>'.$label.'</button>'."\n";

                        if( $clearfix ){ echo '<div class="clearfix"></div>'; }
                    } 
                    
                    /**
                     * input select
                     */
                    elseif( $formType == 'select' ){
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];

                        // unset key name in $val
                        unset($val['name']);

                        $selectrequired = (count($required)>0) ? array('data-parsley-required'=>'true'):array();

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'custom-select form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $selectrequired);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_dropdown($name, $selectoption, $selectedoption, $val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }

                    /**
                     * input multiple select
                     */
                    elseif( $formType == 'multipleselect' ){
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];

                        // unset key name in $val
                        unset($val['name']);

                        $selectrequired = (count($required)>0) ? array('data-parsley-required'=>'true'):array();

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'custom-select form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $selectrequired);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_multiselect($name, $selectoption, $selectedoption, $val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }

                    /**
                     * input text
                     */
                    elseif( $formType == 'text' ){                        
                        
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $required);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_input($val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }

                    /**
                     * input email
                     */
                    elseif( $formType == 'email' ){                        
                        
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'type' => 'email',
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $required);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_input($val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }

                    /**
                     * input file
                     */
                    elseif( $formType == 'file' ){
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];

                        if( !empty($val['value']) ){ unset($val['value']); }

                        $filerequired = (count($required)>0) ? array('data-parsley-required'=>'true'):array();

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'form-control-file' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $filerequired);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_upload($val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }

                    /**
                     * input file for image file
                     */
                    elseif( $formType == 'file-img' ){
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];
                        $imglocation = "";

                        if( !empty($val['value']) ){ 
                            $imglocation = $val['value'];
                            unset($val['value']);
                        }

                        $filerequired = (count($required)>0) ? array('data-parsley-required'=>'true'):array();

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'form-control-file' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $filerequired);

                        if(!empty($imglocation)){
                            echo '
                            <div class="mb-2 d-flex">
                                <img class="pull-left" src="'.$imglocation.'" alt="image" style="padding:3px; height:80px; max-width: 100%;border:1px solid #ddd; margin-right:10px; background: #eee;" />
                            </div>
                            ';
                        }

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_upload($val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }                    

                    /**
                     * input hidden
                     */
                    elseif( $formType == 'hidden' ){
                        echo form_hidden($val['name'], $val['value']);
                    }                   

                    /**
                     * input checkbox
                     */
                    elseif( $formType == 'checkbox' ){
                        $title = (!empty($val['title'])) ? $val['title'] :'';
                        $layout_box = (!empty($val['layout'])) ? $val['layout'] :'vertical';

                        // unset title
                        unset($val['title'],$val['layout']);

                        if( is_array( $val['value'] ) ){

                            if( !empty($val['checked'] ) ) unset($val['checked']);

                            $xx = 1;
                            foreach($val['value'] as $key => $value ){
                                $title = (!empty($value['title'])) ? $value['title'] :'';
                                unset( $value['title'] );

                                echo '<div class="custom-control custom-checkbox pt-2'.(( $layout_box == 'horizontal') ? ' custom-control-inline':'').'">'."\n";
                                $attrClass = "";
                                $attrId = explode("[",$name)[0];

                                if( isset($val['class']) OR isset($val['id']) ){
                                    if(!empty($val['class'])){
                                        $attrClass = " ".$val['class'];
                                    }

                                    if(!empty($val['id'])){
                                        $attrId = $val['id'];
                                    }
                                }

                                // make standard attributes
                                $attrStandard = array(
                                    'class' => 'custom-control-input' . $attrClass,
                                    'id' => $attrId.$xx
                                );

                                $v_aray = array_merge($val, $value, $attrStandard, $required );

                                echo form_checkbox($v_aray);
                                echo '<label class="custom-control-label" for="'.$attrId.$xx.'">';
                                echo $title;
                                echo '</label>'."\n".'</div>'."\n";
                                
                                $xx++;
                            }

                        } else {

                            echo '<div class="custom-control custom-checkbox pt-2'.(( $layout_box == 'horizontal')? ' custom-control-inline':'').'">';
                            $attrClass = "";
                            $attrId = explode("[",$name)[0];

                            if( isset($val['class']) OR isset($val['id']) ){
                                if(!empty($val['class'])){
                                    $attrClass = " ".$val['class'];
                                }

                                if(!empty($val['id'])){
                                    $attrId = $val['id'];
                                }
                            }

                            // make standard attributes
                            $attrStandard = array(
                                'class' => 'custom-control-input' . $attrClass,
                                'id' => $attrId
                            );

                            $val_ = array_merge($val, $attrStandard, $required);

                            echo form_checkbox($val_);
                            echo '<label class="custom-control-label" for="'.$attrId.'">';
                            echo $title;
                            echo '</label></div>'."\n";
                        }
                    }

                    /**
                     * input radio button
                     */
                    elseif( $formType == 'radio' ){
                        $title = (!empty($val['title'])) ? $val['title'] :'';
                        $layout_box = (!empty($val['layout'])) ? $val['layout'] :'vertical';

                        // unset title
                        unset($val['title'],$val['layout']);

                        if( is_array( $val['value'] ) ){

                            if( !empty($val['checked'] ) ) unset($val['checked']);

                            $xx = 1;
                            foreach($val['value'] as $key => $value ){
                                $title = (!empty($value['title'])) ? $value['title'] :'';
                                unset( $value['title'] );

                                echo '<div class="custom-control custom-radio pt-2'.(( $layout_box == 'horizontal') ? ' custom-control-inline':'').'">'."\n";
                                $attrClass = "";
                                $attrId = explode("[",$name)[0];

                                if( isset($val['class']) OR isset($val['id']) ){
                                    if(!empty($val['class'])){
                                        $attrClass = " ".$val['class'];
                                    }

                                    if(!empty($val['id'])){
                                        $attrId = $val['id'];
                                    }
                                }

                                // make standard attributes
                                $attrStandard = array(
                                    'class' => 'custom-control-input' . $attrClass,
                                    'id' => $attrId.$xx
                                );

                                $v_aray = array_merge($val, $value, $attrStandard, $required );

                                echo form_radio($v_aray);
                                echo '<label class="custom-control-label" for="'.$attrId.$xx.'">';
                                echo $title;
                                echo '</label>'."\n".'</div>'."\n";
                                
                                $xx++;
                            }

                        } else {

                            echo '<div class="custom-control custom-radio pt-2'.(( $layout_box == 'horizontal')? ' custom-control-inline':'').'">';
                            $attrClass = "";
                            $attrId = explode("[",$name)[0];

                            if( isset($val['class']) OR isset($val['id']) ){
                                if(!empty($val['class'])){
                                    $attrClass = " ".$val['class'];
                                }

                                if(!empty($val['id'])){
                                    $attrId = $val['id'];
                                }
                            }

                            // make standard attributes
                            $attrStandard = array(
                                'class' => 'custom-control-input' . $attrClass,
                                'id' => $attrId
                            );

                            $val_ = array_merge($val, $attrStandard, $required);

                            echo form_radio($val_);
                            echo '<label class="custom-control-label" for="'.$attrId.'">';
                            echo $title;
                            echo '</label></div>'."\n";
                        }
                    }

                    /**
                     * input multiple select
                     */
                    elseif( $formType == 'password' ){
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'type' => 'password',
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $required);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_input($val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }

                    /**
                     * input another type in input tag
                     */
                    else {
                        $attrClass = "";
                        $attrId = explode("[",$name)[0];

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $attrStandard = array(
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $attrStandard, $required);

                        if( count($inputgroup) > 0 ){
                            echo '<div class="input-group">';
                            if( !empty($inputgroup['prepend']) ){

                                echo '<div class="input-group-prepend">';
                                if( $inputgroup['prepend'] != filter_clean($inputgroup['prepend']) ){
                                    echo $inputgroup['prepend'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['prepend'].'</span>';
                                }
                                echo '</div>';
                            }
                        }

                        echo form_input($val_);

                        if( count($inputgroup) > 0 ){
                            if( !empty($inputgroup['append']) ){
                                
                                echo '<div class="input-group-append">';
                                if( $inputgroup['append'] != filter_clean($inputgroup['append']) ){
                                    echo $inputgroup['append'];
                                } else {
                                    echo '<span class="input-group-text">'.$inputgroup['append'].'</span>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }

                    if(!empty($help) AND $formType !='hidden') { 
                        echo '<small';
                        if($formType=='multilanguage_textarea' OR $formType == 'multilanguage_text'){ echo ' style="margin-top: -0.3rem;"'; }
                        echo ' class="form-text text-muted">'.$help.'</small>';
                    }

                    if(!empty($extra) AND $formType !='hidden') {
                        echo '<div class="d-block">';
                        echo $extra;
                        echo '</div>';
                    }
                    
                    if($layout == 'horizontal' AND $formType !='hidden'){ echo '</div>'."\n"; }

                } else {
                    show_error("Variable type cannot empty",503,'Parameter Error');
                }

                echo ($formType !='hidden')?'</div>'."\n\n":"";
            }

        } else {
            show_error("Parameter 1 is empty in buildInputs() method. please insert",503,'Parameter Error');
        }
    }

    /**
     * Make the form and inputs field in content
     * 
     * @param array $tagform
     * @param array $inputs
     * @param array $formtype (multipart)
     * 
     * @return string to show in html
     */
    public function buildForm($tagform = array(), $inputs = array(), $formtype = '' ){
        $error = false;
        $CI = $this->CI;
        
        if(count($tagform)>0){        
            if( empty($tagform['action']) ){
                $error = "Please insert the value in parameter";
            }    

            if(!$error){
                $attr = (isset($tagform['attributes'])) ? $tagform['attributes']:'';
                $hidden = (isset($tagform['hidden'])) ? $tagform['hidden']:'';

                if(empty($tagform['attributes']))   $attr = array();
                if(empty($tagform['hidden']))       $hidden = array();

                if($formtype == 'multipart'){
                    echo form_open_multipart($tagform['action'], $attr, $hidden);
                } else {
                    echo form_open($tagform['action'], $attr, $hidden);
                }

                $layout     = ( isset($inputs['layout']) ) ? $inputs['layout']:'';
                $colsetting = ( isset($inputs['colsetting']) ) ? $inputs['colsetting']:array();
                
                // make input
                $this->buildInputs($inputs['inputs'], $layout, $colsetting);

                echo form_close();
            } else {
                show_error($error, 503, 'Parameter Error');
            }

        } else {
            show_error("Parameter 2 is empty in buildForm() method. please insert",503,'Parameter Error');
        }
        
    }
    
}