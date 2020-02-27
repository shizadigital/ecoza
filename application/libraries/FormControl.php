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
            
            foreach( $inputs AS $key => $val ){
                
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
                
                echo ($formType !='hidden')?'<div class="form-group'.(($layout == 'horizontal') ? ' row':'').'">'."\n":'';

                if( $formType !=  'button' AND $formType !=  'submit' AND $formType !='hidden'){
                    echo '<label';

                    if($required OR $layout == 'horizontal'){
                        $classval = ( ($layout == 'horizontal') ? $colsetting_label.' col-form-label':'' ).( ($required)?' req':'' );
                        $classval = trim($classval);
                        echo ' class="'.$classval.'"';
                    }

                    echo ' for="'.( ( isset($val['id']) )? $val['id']:$name).'">' . $label . '</label>'."\n";
                }

                if( !empty($val['type']) ){

                    $col_element = $colsetting_input;
                    if( $formType =='submit'){ $col_element='col-md-12'; }

                    if($layout == 'horizontal' AND $formType !='hidden'){ echo '<div class="'.$col_element.'">'; }
                    
                    // remove key so as not to insert to attribute
                    unset( $val['type'], $val['help'], $val['label'], $val['required'], $val['option'], $val['selected'] );

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
                     * input textarea
                     */
                    elseif( $formType == 'textarea' ){

                        $attrClass = "";
                        $attrId = $name;
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
                        $class_input = array(
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId,
                            'rows' => $attrRows,
                            'cols' => ''
                        );

                        $val_ = array_merge($val, $class_input, $required);

                        echo form_textarea($val_);  
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
                        $class_input = array(
                            'class' => 'btn' . $attrClass
                        );

                        $val_ = array_merge($val, $class_input);
                        
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
                        $class_input = array(
                            'class' => 'btn' . $attrClass
                        );

                        $val_ = array_merge($val, $class_input);
                        
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
                        $attrId = $name;

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
                        $class_input = array(
                            'class' => 'custom-select form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $class_input, $selectrequired);

                        echo form_dropdown($name, $selectoption, $selectedoption, $val_);
                    }

                    /**
                     * input multiple select
                     */
                    elseif( $formType == 'multipleselect' ){
                        $attrClass = "";
                        $attrId = $name;

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
                        $class_input = array(
                            'class' => 'custom-select form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $class_input, $selectrequired);

                        echo form_multiselect($name, $selectoption, $selectedoption, $val_);
                    }

                    /**
                     * input text
                     */
                    elseif( $formType == 'text' ){                        
                        
                        $attrClass = "";
                        $attrId = $name;

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $class_input = array(
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $class_input, $required);

                        echo form_input($val_);
                    }

                    /**
                     * input text
                     */
                    elseif( $formType == 'email' ){                        
                        
                        $attrClass = "";
                        $attrId = $name;

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $class_input = array(
                            'type' => 'email',
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $class_input, $required);

                        echo form_input($val_);
                    }

                    /**
                     * input file
                     */
                    elseif( $formType == 'file' ){
                        $attrClass = "";
                        $attrId = $name;

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
                        $class_input = array(
                            'class' => 'form-control-file' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $class_input, $filerequired);

                        echo form_upload($val_);
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
                                $attrId = $name;

                                if( isset($val['class']) OR isset($val['id']) ){
                                    if(!empty($val['class'])){
                                        $attrClass = " ".$val['class'];
                                    }

                                    if(!empty($val['id'])){
                                        $attrId = $val['id'];
                                    }
                                }

                                // make standard attributes
                                $class_input = array(
                                    'class' => 'custom-control-input' . $attrClass,
                                    'id' => $attrId.$xx
                                );

                                $v_aray = array_merge($val, $value, $class_input, $required );

                                echo form_checkbox($v_aray);
                                echo '<label class="custom-control-label" for="'.$attrId.$xx.'">';
                                echo $title;
                                echo '</label>'."\n".'</div>'."\n";
                                
                                $xx++;
                            }

                        } else {

                            echo '<div class="custom-control custom-checkbox pt-2'.(( $layout_box == 'horizontal')? ' custom-control-inline':'').'">';
                            $attrClass = "";
                            $attrId = $name;

                            if( isset($val['class']) OR isset($val['id']) ){
                                if(!empty($val['class'])){
                                    $attrClass = " ".$val['class'];
                                }

                                if(!empty($val['id'])){
                                    $attrId = $val['id'];
                                }
                            }

                            // make standard attributes
                            $class_input = array(
                                'class' => 'custom-control-input' . $attrClass,
                                'id' => $attrId
                            );

                            $val_ = array_merge($val, $class_input, $required);

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
                                $attrId = $name;

                                if( isset($val['class']) OR isset($val['id']) ){
                                    if(!empty($val['class'])){
                                        $attrClass = " ".$val['class'];
                                    }

                                    if(!empty($val['id'])){
                                        $attrId = $val['id'];
                                    }
                                }

                                // make standard attributes
                                $class_input = array(
                                    'class' => 'custom-control-input' . $attrClass,
                                    'id' => $attrId.$xx
                                );

                                $v_aray = array_merge($val, $value, $class_input, $required );

                                echo form_radio($v_aray);
                                echo '<label class="custom-control-label" for="'.$attrId.$xx.'">';
                                echo $title;
                                echo '</label>'."\n".'</div>'."\n";
                                
                                $xx++;
                            }

                        } else {

                            echo '<div class="custom-control custom-radio pt-2'.(( $layout_box == 'horizontal')? ' custom-control-inline':'').'">';
                            $attrClass = "";
                            $attrId = $name;

                            if( isset($val['class']) OR isset($val['id']) ){
                                if(!empty($val['class'])){
                                    $attrClass = " ".$val['class'];
                                }

                                if(!empty($val['id'])){
                                    $attrId = $val['id'];
                                }
                            }

                            // make standard attributes
                            $class_input = array(
                                'class' => 'custom-control-input' . $attrClass,
                                'id' => $attrId
                            );

                            $val_ = array_merge($val, $class_input, $required);

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
                        $attrId = $name;

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $class_input = array(
                            'type' => 'password',
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $class_input, $required);

                        echo form_input($val_);
                    }

                    /**
                     * input another type in input tag
                     */
                    else {
                        $attrClass = "";
                        $attrId = $name;

                        if( isset($val['class']) OR isset($val['id']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                            
                            if(!empty($val['id'])){
                                $attrId = $val['id'];
                            }
                        }

                        // make standard attributes
                        $class_input = array(
                            'class' => 'form-control' . $attrClass,
                            'id' => $attrId
                        );

                        $val_ = array_merge($val, $class_input, $required);

                        echo form_input($val_);
                    }

                    if(!empty($help AND $formType !='hidden')) { echo '<small class="form-text text-muted">'.$help.'</small>'; }
                    
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