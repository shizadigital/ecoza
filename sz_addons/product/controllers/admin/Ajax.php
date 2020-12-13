<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller{ 

	public function __construct(){
		parent::__construct();
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();
	}

	public function index(){
		show_404();
	}

	public function ajax_deleteimageproduct(){
		if( is_delete() AND $this->input->post('CP') === get_cookie('sz_token') ){
			$ID = esc_sql(filter_int($this->input->post('idp')));
			$getpic = getval("pimgImg,pimgDir,pimgPrimary", "product_images","pimgId='{$ID}'");

			$msg = '';
			$sql = false;
			if($getpic['pimgPrimary'] == 'n' ){
				if(!empty($getpic['pimgDir']) AND !empty($getpic['pimgImg'])){
					$sizeimg = array( 'xsmall', 'small', 'medium', 'large' );
					foreach($sizeimg as $imgsize){
						@unlink( IMAGES_PATH . $getpic['pimgDir'].DIRECTORY_SEPARATOR.$imgsize.'_'.$getpic['pimgImg']);
					}
				}

				// remove image
				$sql = $this->Env_model->delete('product_images',"pimgId='{$ID}'");
			} else {
				$msg = t('primaryimgcannotberemoved');
			}

			if($sql){
				echo "ok";
			} else {
				echo "nok||".$msg;
			}
		}
	}

	public function ajax_related_getallproduct(){
		if( is_view() AND $this->input->post('CP') === get_cookie('sz_token') ){
			$kw = $this->security->xss_clean( $this->input->post('search') );
			$classlist = ( $this->input->post('class') ) ? $this->security->xss_clean( $this->input->post('class') ):'';

			$exceptID = '';
			if( !empty( $classlist ) ){
				$listID = explode(" ", $classlist);

				$exceptID = " AND ( prodId!='" . implode("' AND prodId!='", $listID). "')";
			}

			$data = $this->Env_model->view_where("prodId,prodName,prodSku","product","(prodDeleted=0 AND prodDisplay='y') AND (prodName LIKE '%{$kw}%')".$exceptID);

			$result = array();
			foreach($data AS $v){
				$result[] = [
					'id'=>$v['prodId'],
					'text' => $v['prodName'] . ( (!empty($v['prodSku']))? ' ['.$v['prodSku'].']':'')
				];
			}
			header('Content-Type: application/json');
			echo json_encode($result);
		} else {
			exit;
		}
	}

	public function ajax_related_product(){
		if( is_view() AND $this->input->post('CP') === get_cookie('sz_token') ){
			$id = $this->security->xss_clean( $this->input->post('val') );

			$data = getval("prodId,prodName,prodSku","product","prodDeleted=0 AND prodId='{$id}'");
			
			$result = '<li id="prodrel-' . $data['prodId'] .'">';

			$result .= '
			<a title="'.t('remove').'" href="javascript:void(0)" id="rmrelateditem-' . $data['prodId'] .'" class="mr-1 pt-2"><i class="fe fe-x-circle text-danger"></i></a> ' . $data['prodName'] . ( (!empty($data['prodSku'])) ? ' ['.$data['prodSku'].']':'') . '
			<input type="hidden" value="' . $data['prodId'] .'" name="relatedproduct[]">
			<script>
			$( document ).ready(function() {
				$("#rmrelateditem-' . $data['prodId'] .'").click(function() {
					// dispose tooltip
					$(\'#rmrelateditem-' . $data['prodId'] .'\').tooltip(\'dispose\');

					// remove id from class
					$("#relatedlist").removeClass( "' . $data['prodId'] .'" );

					$("#prodrel-' . $data['prodId'] .'").remove();
				});
				$(\'#rmrelateditem-' . $data['prodId'] .'\').tooltip();
			});
			</script>
			';

			$result .= '</li>';

			echo $result;
		} else {
			exit;
		}
	}
	
	public function ajax_generate_attrvalue(){
		if( ( is_add() OR is_edit() ) AND $this->input->post('CP') === get_cookie('sz_token') ){
			$valattr = $this->security->xss_clean( $this->input->post('val') );
			$groupattr = $this->security->xss_clean( $this->input->post('group') );
			$attravailable = $this->security->xss_clean( $this->input->post('attravailable') );
			$attravailable = empty($attravailable) ? array():$attravailable;

			$dataattrval = array();

			if( empty( $groupattr ) ){

				foreach($valattr as $sval){

					// split data
					$expattrval = explode("-",$sval);

					$dataattrval[$expattrval[0]][] = $expattrval[0].'-'.$expattrval[1];
				}
			
			} else {
				$groupattr = filter_int( $groupattr );

				// get the attribute relationship first
				$tableattr = array('attribute_relationship a','attribute b');
				$attrrel = $this->Env_model->view_where_order("a.attrId",$tableattr,"a.attrgroupId='{$groupattr}' AND a.attrId=b.attrId AND b.attrDeleted=0",'a.attrId', 'ASC');

				foreach($attrrel as $val){

					// get attrval 
					$attrvaldata = $this->Env_model->view_where("attrvalId","attribute_value","attrId='{$val['attrId']}'");
					foreach( $attrvaldata as $aval ){
						$dataattrval[$val['attrId']][] = $val['attrId'].'-'.$aval['attrvalId'];
					}

				}
			}
			
			// combination array
			$arrayCombination = getCombination($dataattrval);

			$countattravailable = count($attravailable);

			$ncomb = ($countattravailable > 0) ? $countattravailable+1:1;
			foreach($arrayCombination as $key => $val){
				// generate unique code for identity
				$codeid = generate_code(8);
				
				$nx = 1;
				$countattr = count($val);
				$words = '';
				$attridspattern = '';
				foreach( $val as $attrdata ){
					// split data 
					$exp_attrval = explode("-",$attrdata);
					$attr = $exp_attrval[0];
					$attrval = $exp_attrval[1];
					
					// get attribute
					$attr_data = getval("attrId,attrLabel","attribute","attrId='{$attr}'");

					// get attribute value
					$attrval_data = getval("attrvalId,attrvalVisual,attrvalValue,attrvalLabel","attribute_value","attrvalId='{$attrval}'");

					$words .= $attr_data['attrLabel'] . ': ' . $attrval_data['attrvalLabel'] . (($countattr != $nx)? ', ':'');
					$attridspattern .= $attr_data['attrId'].':'.$attrval_data['attrvalId'] . (($countattr != $nx)? '-':'');

					$nx++;
				}

				if( $countattravailable > 0 ){
					if( in_array($attridspattern, $attravailable) ){
						continue;
					}
				}

				echo '<tr id="row-'.$key.'-'.$codeid.'" class="attrtrdata">';

				echo '<td>';
					echo $words;
					echo '<input type="hidden" class="attrvaluedata" name="attributevalue['.$ncomb.']" value="'.$attridspattern.'" />';
				echo '</td>';

				echo '
				<td class="text-center">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">'.getCurrencySymbol().'</span>
						</div>';
					$attrprice = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)');
					echo form_input('priceattr['.$ncomb.']', '', $attrprice);
					
				echo '
					</div>
				</td>';
				
				echo '
				<td class="text-center">';
					$attrqty = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)', 'id'=>'qtyinputset-'.$key.'-'.$codeid);
					echo form_input('qtyattr['.$ncomb.']', '', $attrqty);
				echo '
				</td>';

				echo '
				<td class="text-center">';
					$optqtytype = array('limited'=>t('limited'),'unlimited'=>t('unlimited'));
					echo form_dropdown('qtytypeattr['.$ncomb.']', $optqtytype, 'limited', array( 'class'=>'custom-select', 'id'=>'qtytypeset-'.$key.'-'.$codeid ));
				echo '
				</td>';

				echo '
				<td class="text-center">
					<div class="input-group">';
					$attrweight = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)');
					echo form_input('weightattr['.$ncomb.']', '', $attrweight);
				echo '
						<div class="input-group-append">
							<span class="input-group-text">'.getWeightDefault().'</span>
						</div>
					</div>
				</td>';

				echo '
				<td class="text-center">';
					$defaultchecked = array();
					if($ncomb == 1 AND $countattravailable < 1){
						$defaultchecked = array('checked'=>'checked');
					}
					$defaultattrset = array('name'=>'defaultattr','value'=>$ncomb);
					$defaultattr = array_merge($defaultattrset,$defaultchecked);
					echo form_radio($defaultattr);
				echo '
				</td>';

				echo '
				<td class="text-center">
				<button class="btn btn-link" id="removeattr-'.$key.'-'.$codeid.'" title="'.t('remove').': '.$words.'"><i class="fe fe-trash-2 text-red"></i></button>
				<script type="text/javascript">
				$( document ).ready(function() {
					$("#removeattr-'.$key.'-'.$codeid.'").tooltip();
					$("#removeattr-'.$key.'-'.$codeid.'").click(function() {
						if( confirm("'.t('deleteconfirm').' ('.$words.')") ){

							if( $(\'.attrtrdata\').length < 2 ){
								// enable field in general tab
								$("#general-qty").removeAttr(\'disabled\');
								$("#general-qtytype").removeAttr(\'disabled\');
								$("#general-qtytype").removeAttr(\'disabled\');
							}

							$(this).tooltip(\'dispose\');
							$("#row-'.$key.'-'.$codeid.'").remove();
						}
					});

					$(\'#qtytypeset-'.$key.'-'.$codeid.'\').on(\'change\', function(){
						qtySet($(this),\'#qtyinputset-'.$key.'-'.$codeid.'\');
					});
				});
				</script>
				</td>';

				echo '</tr>';

				$ncomb++;
			}
		}
	}
	
}
