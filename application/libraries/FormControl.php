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
                $required = ( isset($val['required']) ) ? $val['required']:false;
                $label = ( isset($val['label']) ) ? $val['label']:'';
                $name = ( isset($val['name']) ) ? $val['name']:'';
                $colsetting_label = ( isset($colsetting['label']) ) ? $colsetting['label']:'';
                $colsetting_input = ( isset($colsetting['input']) ) ? $colsetting['input']:'';
                
                // define type
                $formType = $val['type'];
                
                echo '<div class="form-group'.(($layout == 'horizontal') ? ' row':'').'">'."\n";

                if( $formType !=  'button' AND $formType !=  'submit'){
                    echo '<label';

                    if($required OR $layout == 'horizontal'){
                        echo ' class="'.( ($required)?'req':'' ) . ( ($layout == 'horizontal') ? ' '.$colsetting_label.' col-form-label':'' ).'"';
                    }

                    echo ' for="'.( ( isset($val['id']) )? $val['id']:$name).'">' . $label . '</label>'."\n";
                }

                if( !empty($val['type']) ){

                    $col_element = $colsetting_input;
                    if( $formType =='submit'){ $col_element='col-md-12'; }

                    if($layout == 'horizontal'){ echo '<div class="'.$col_element.'">'; }
                    
                    // remove type key
                    unset($val['type']);
                    unset($val['label']);
                    unset($val['required']);

                    // define required to attribute
                    $required = ($required) ? array('required'=>'required'): array();

                    /**
                     * input textarea
                     */
                    if( $formType == 'textarea' ){

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

                        $val = array_merge($val, $class_input, $required);

                        echo form_textarea($val);  
                    } 

                    /**
                     * button
                     */
                    elseif( $formType == 'button' ){
                        $attrClass = "";

                        if( isset($val['class']) ){
                            if(!empty($val['class'])){
                                $attrClass = " ".$val['class'];
                            }
                        }

                        // make standard attributes
                        $class_input = array(
                            'class' => 'btn' . $attrClass
                        );

                        $val = array_merge($val, $class_input);
                        
                        echo '<button type="button"';
                        foreach( $val AS $attr => $value){
                            if($attr == 'label'){ continue; }
                            echo ' '.$attr.'="'.$value.'"';
                        }
                        echo '>'.$label.'</button>'."\n";
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

                        $val = array_merge($val, $class_input);
                        
                        if( isset($val['bordertop']) ){ echo '<hr/>'; }                        

                        echo '<button type="submit"';
                        foreach( $val AS $attr => $value){
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

                        $val = array_merge($val, $class_input, $required);

                        echo form_input($val);                        
                    }

                    /**
                     * input file
                     */
                    elseif( $formType == 'file' ){

                    }

                    /**
                     * input hidden
                     */
                    elseif( $formType == 'hidden' ){
                        echo form_hidden($val['name'], $val['value']);
                    }

                    /**
                     * input radio button
                     */
                    elseif( $formType == 'radio' ){

                    }

                    /**
                     * input checkbox
                     */
                    elseif( $formType == 'checkbox' ){

                    }

                    /**
                     * input multiple select
                     */
                    elseif( $formType == 'multipleselect' ){

                    }

                    /**
                     * input multiple select
                     */
                    elseif( $formType == 'password' ){

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

                        $val = array_merge($val, $class_input, $required);

                        echo form_input($val);
                    }
                    
                    if($layout == 'horizontal'){ echo '</div>'."\n"; }

                } else {
                    show_error("Variable type cannot empty",503,'Parameter Error');
                }

                echo '</div>'."\n\n";
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