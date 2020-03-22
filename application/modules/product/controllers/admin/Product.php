<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller{ 
	
	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 15) );

		// load model
		$this->load->model('product_model');
	}

	public function index(){
		if( is_view() ){

			$data = array( 
						'title' => $this->moduleName . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' =>  $this->moduleName,
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('product/addnew'),
												'permission' => 'add'
											)
										),
					);
			
			$this->load->view( admin_root('product_view'), $data );
		}
	}

	public function addnew(){
		if( is_add() ){
			// get categories
			$categories = $this->Env_model->view_where_order('*','categories', "catActive='1' AND catType='product'",'catId','DESC');
			$datacategories = array();
			foreach( $categories as $k => $v ){
				$datacategories[$v['catId']] = $v['catName'];
			}

			// get manufacturers
			$manufacturers = $this->Env_model->view_where_order('*','manufacturers', "manufactActive='y' AND manufactDeleted='0'",'manufactName','ASC');
			$datamanufacturers[''] = '-- '.t('choose').' --';
			foreach( $manufacturers as $k => $v ){
				$datamanufacturers[$v['manufactId']] = $v['manufactName'];
			}

			// get badges
			$badges = $this->Env_model->view_where_order('*','badges', "badgeDeleted='0' AND badgeType='product' AND badgeActive='1'",'badgeLabel','ASC');
			$databadges[''] = '-- '.t('choose').' --';
			foreach( $badges as $k => $v ){
				$databadges[$v['badgeId']] = $v['badgeLabel'];
			}

			// get tax
			$tax = $this->Env_model->view_where_order('taxId, taxName, taxRate, taxType','tax', "taxDeleted='0' AND taxActive='y'",'taxId','ASC');
			$taxes[''] = t('notax');
			foreach( $tax as $k => $v ){
				$taxes[$v['taxId']] = $v['taxName'] . ( ($v['taxType']=='percentage') ? ' (%)':'');
			}

			// get attributes
			$attributes = $this->Env_model->view_where("attrId,attrLabel,attrSorting", "attribute", "attrDeleted=0 ");
			foreach( $attributes as $k => $val ){
				
				$dataattrval = $this->Env_model->view_where("attrvalId,attrvalVisual,attrvalValue,attrvalLabel", "attribute_value", "attrId='{$val['attrId']}'");
				
				$attributes[$k]['attrvalues'] = $dataattrval;
			}

			// get all attribute groups
			$attributegrp = $this->Env_model->view_where("attrgroupId,attrgroupLabel", "attribute_group", "attrgroupDeleted=0 ");
			$attributegrpsopt[''] = t('nogroup');
			foreach( $attributegrp as $k => $v ){
				$attributegrpsopt[$v['attrgroupId']] = $v['attrgroupLabel'];
			}

			$data = array( 
							'title' => $this->moduleName . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => $this->moduleName . ' - ' . t('addnew'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('product')
												)
											),
							'categories' => $datacategories,
							'manufacturers' => $datamanufacturers,
							'badges' => $databadges,
							'taxes' => $taxes,
							'attrval' => $attributes,
							'attrgroupopt' => $attributegrpsopt
						);

			$this->load->view( admin_root('product_add'), $data );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$data = array( 
							'title' => $this->moduleName . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => $this->moduleName . ' - ' . t('edit'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('addnew'),
													'icon'	=> 'fe fe-plus',
													'access' => admin_url('product/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('product')
												)
											),
						);

			$this->load->view( admin_root('product_edit'), $data );
		}
	}

	public function delete($id){
		if( is_delete() ){

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

			$data = $this->Env_model->view_where("prodId,prodName,prodCode","product","(prodDeleted=0 AND prodDisplay='y') AND (prodName LIKE '%{$kw}%')".$exceptID);

			$result = array();
			foreach($data AS $v){
				$result[] = [
					'id'=>$v['prodId'],
					'text' => $v['prodName'] . ( (!empty($v['prodCode']))? ' ['.$v['prodCode'].']':'')
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

			$data = getval("prodId,prodName,prodCode","product","prodDeleted=0 AND prodDisplay='y' AND prodId='{$id}'");
			
			$result = '<li id="prodrel-' . $data['prodId'] .'">';

			$result .= '
			<a title="'.t('remove').'" href="javascript:void(0)" id="rmrelateditem-' . $data['prodId'] .'" class="mr-1 pt-2"><i class="fe fe-x-circle text-danger"></i></a> ' . $data['prodName'] . ( (!empty($data['prodCode'])) ? ' ['.$data['prodCode'].']':'') . '
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
		if( is_view() AND $this->input->post('CP') === get_cookie('sz_token') ){
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

				if( count($attravailable) > 0 ){
					if( in_array($attridspattern, $attravailable) ){
						continue;
					}
				}

				echo '<tr id="row-'.$key.'-'.$codeid.'" class="attrtrdata">';

				echo '<td>';
					echo $words;
					echo '<input type="hidden" class="attrvaluedata" name="attributevalue[]" value="'.$attridspattern.'" />';
				echo '</td>';

				echo '
				<td>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">'.getCurrencySymbol().'</span>
						</div>';
					$attrprice = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)');
					echo form_input('priceattr['.$key.']', '', $attrprice);
					
				echo '
					</div>
				</td>';
				
				echo '
				<td>';
					$attrqty = array('class'=>'form-control', 'onkeypress'=>'return isNumberKey(event)');
					echo form_input('qtyattr['.$key.']', '', $attrqty);
				echo '
				</td>';

				echo '
				<td>';
					$optqtytype = array('limited'=>t('limited'),'unlimited'=>t('unlimited'));
					echo form_dropdown('qtytype', $optqtytype, 'limited', array( 'class'=>'custom-select' ));
				echo '
				</td>';

				echo '
				<td>
					<div class="input-group">';
					$attrweight = array('class'=>'form-control', 'onkeypress'=>'return isNumberComma(event)');
					echo form_input('weightattr['.$key.']', '', $attrweight);
				echo '
						<div class="input-group-append">
							<span class="input-group-text">'.getWeightUnitDefault().'</span>
						</div>
					</div>
				</td>';

				echo '
				<td>
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
								$("#nprice").removeAttr(\'disabled\');
								$("#nprice").attr(\'required\', \'required\');
							}

							$(this).tooltip(\'dispose\');
							$("#row-'.$key.'-'.$codeid.'").remove();
						}
					});
				});
				</script>
				</td>';

				echo '</tr>';

			}
		}
	}
}
