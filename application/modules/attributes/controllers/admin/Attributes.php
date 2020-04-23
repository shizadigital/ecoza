<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attributes extends CI_Controller{ 
	
	private $moduleName = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 14) );

		// load model
		$this->load->model('attributes_model');
	}

	public function index(){
		if( is_view() ){

			// get attr group data
			$datagrp = $this->Env_model->view_order('*','attribute_group','attrgroupId','DESC');

			$datagroup[''] = '-- '.t('choose').' --';
			foreach( $datagrp as $k => $v ){
				$datagroup[$v['attrgroupId']] = $v['attrgroupLabel'];
			}

			// get attr data start here
			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'attribute';

			$excClause = '';
			$where = "attrDeleted='0'";

			$querysearchlang ='';
			// search process
            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				// standard lang
				$queryserach = "attrLabel LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";

				// check multilanguage
				$lang = get_cookie('admin_lang');
				if( $lang !== $this->config->item('language') ){
					// check the keyword here
					$dataidresult = $this->Env_model->view_where("dtRelatedId","dynamic_translations","dtRelatedTable='{$table}' AND dtRelatedField='attrLabel' AND dtLang='{$lang}' AND ( dtTranslation LIKE '%{$kw}%') ");

					if( count($dataidresult) > 0 ){ 
						$resultlangsearch = array();
						foreach($dataidresult AS $key => $val){
							$resultlangsearch[] = $val['dtRelatedId'];
						}

						$standardlangcount = countdata($table, $where . $excClause);

						$querysearchlang = ($standardlangcount > 0) ? '(':'';

						$querysearchlang .= '( attrId=\''.implode('\' OR attrId=\'', $resultlangsearch).'\' )';

						if( $standardlangcount > 0 ){
							$querysearchlang .= " OR (".$queryserach.")";
						}

						$querysearchlang .= ($standardlangcount > 0) ? ')':'';

						$excClause = " AND $querysearchlang";
					} else {
						$excClause = " AND attrLabel=''";
					}
				}
            }

			$perPage = 30;
			
			$where = $where.$excClause;

			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'attrId', 'DESC', $perPage, $datapage);
			$rows = countdata($table, $where);
			
			$pagingURI = admin_url( $this->uri->segment(2) );

			$this->load->library('paging');
			$pagination = $this->paging->PaginationAdmin( $pagingURI, $rows, $perPage );

			$data = array( 
						'title' => $this->moduleName . ' - '.get_option('sitename'),
						'page_header_on' => true,
						'title_page' =>  $this->moduleName,
						'title_page_icon' => '',
						'title_page_secondary' => '',
						'breadcrumb' => false,
						'datagroup' => $datagroup,						
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
					);
			
			$this->load->view( admin_root('attributes_view'), $data );
		}
	}

	public function addingprocess(){
		if( is_add() ){
			$error = false;

			if( empty( $this->input->post('label') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$label 		= esc_sql( filter_txt( $this->input->post('label') ) );
				$attrgroup 	= esc_sql( $this->input->post('attrgroup') );
				$sorting	= esc_sql( filter_int( $this->input->post('sorting') ) );
				
				$nextId = getNextId('attrId', 'attribute');

				$datacat = array(
					'attrId' => $nextId,
					'attrLabel' => $label,
					'attrSorting' => (int)$sorting,
					'attrDeleted' => 0
				);
				
				// insert data
				$query = $this->Env_model->insert('attribute', $datacat);
				
			    if($query){
					// insert or update data translation
					translate_pushdata('label', 'attribute', 'attrLabel', $nextId );

					// insert attribute group
					if( !empty($attrgroup) ){
						$nextGrpId = getNextId('attrrelId', 'attribute_relationship');

						$attrgroup = array('attrrelId'=>$nextGrpId, 'attrId'=>$nextId, 'attrgroupId'=>(int)$attrgroup);
						// insert data
						$query = $this->Env_model->insert('attribute_relationship', $attrgroup);
					}

					// add store
					$datastore = array(
						'attrId' => $nextId,
						'storeId' => storeId()
					);
					$query = $this->Env_model->insert('attribute_store', $datastore);

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					redirect( admin_url('attributes/edit/'.$nextId) ); exit;
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('attributes') );
		}
	}

	public function edit($id){
		if( is_edit() ){
			// get attr group data
			$datagrp = $this->Env_model->view_order('*','attribute_group','attrgroupId','DESC');

			$datagroup[''] = '-- '.t('choose').' --';
			foreach( $datagrp as $k => $v ){
				$datagroup[$v['attrgroupId']] = t( array('table'=>'attribute_group','field'=>'attrgroupLabel', 'id'=>$v['attrgroupId']) );
			}
			
			// get attr data
			$id = esc_sql( filter_int($id) );

			$getdata = $this->Env_model->getval("*","attribute", "attrId='{$id}'");

			// get attr val
			$attrval = $this->Env_model->view_where_order('*','attribute_value', "attrId='{$id}'",'attrvalId','ASC');

			$data = array( 
							'title' => $this->moduleName . ' - '.get_option('sitename'),
							'page_header_on' => true,
							'title_page' => $this->moduleName . ' - ' . t('edit'),
							'title_page_icon' => '',
							'title_page_secondary' => '',
							'breadcrumb' => false,
							'header_button_action' => array(
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('attributes')
												)
											),
							'datagroup' => $datagroup,		
							'data' => $getdata,
							'attrval' => $attrval
						);

			$this->load->view( admin_root('attributes_edit'), $data );
		}
	}

	public function editprocess(){
		if( is_edit() ){
			$error = false;

			if( empty( $this->input->post('label') ) ){
				$error = "<strong>".t('error')."!!</strong> ".t('emptyrequiredfield');
			}

			if(!$error){
				$id 		= esc_sql( filter_txt( $this->input->post('ID') ) );
				$label 		= esc_sql( filter_txt( $this->input->post('label') ) );
				$attrgroup 	= esc_sql( $this->input->post('attrgroup') );
				$sorting	= esc_sql( filter_int( $this->input->post('sorting') ) );

				$datacat = array(
					'attrLabel' => $label,
					'attrSorting' => (int)$sorting
				);
				
				// insert data
				$query = $this->Env_model->update('attribute', $datacat, "attrId='{$id}'");
				
			    if($query){
					// insert or update data translation
					translate_pushdata('label', 'attribute', 'attrLabel', $id );

					// insert attribute group
					if( !empty($attrgroup) ){
						// remove old data first
						$this->Env_model->delete('attribute_relationship', "attrId='{$id}'");

						// insert new data 
						$nextGrpId = getNextId('attrrelId', 'attribute_relationship');
						$attrgroup = array('attrrelId'=>$nextGrpId, 'attrId'=>$id, 'attrgroupId'=>(int)$attrgroup);
						// insert data
						$this->Env_model->insert('attribute_relationship', $attrgroup);
					}

					// insert attribute value 
					if( count( $this->input->post('valueattrval') ) > 0 AND count( $this->input->post('labelattrval') ) > 0 ){

						if( is_array_unique( array_filter($this->input->post('valueattrval')) ) AND is_array_unique( array_filter($this->input->post('labelattrval')) )){
							
							foreach( $this->input->post('valueattrval') AS $key => $val ){
								if( empty($this->input->post('labelattrval')[$key]) OR empty($this->input->post('valueattrval')[$key]) ){
									continue;
								}

								$labelvalueattr = esc_sql(filter_txt( $this->input->post('labelattrval')[$key] ));
								if( $this->input->post('visualtype')[$key] == 'text'){
									$labelvalueattr = esc_sql(filter_txt( $this->input->post('valueattrval')[$key] ));
								}

								$dataattr = array(
									'attrId' => $id,
									'attrvalVisual' => $this->input->post('visualtype')[$key],
									'attrvalLabel' => $labelvalueattr,
									'attrvalValue' => esc_sql(filter_txt( $this->input->post('valueattrval')[$key] )),
								);

								if( empty($this->input->post('idattrval')[$key]) ){
									$getnextid = getNextId('attrvalId', 'attribute_value');
									$mergedata = array_merge( array('attrvalId'=> $getnextid ), $dataattr);
									$this->Env_model->insert('attribute_value', $mergedata);
								} else {
									$idattrval = filter_int( $this->input->post('idattrval')[$key] );
									$this->Env_model->update('attribute_value', $dataattr, array('attrvalId'=>$idattrval) );
								}
							}
						} else {
							$error = "<strong>".t('warning')."!!</strong> " . t('attrvaluearrayerror');
						}
					}

					if(!$error){
						$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					}
			    } else {
			    	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
				}
			}

			if($error){
				$this->session->set_flashdata( 'failed', $error );
			}

			redirect( admin_url('attributes/edit/'.$id) );
		}
	}

	protected function deleteAction($id){
		if( is_delete() ){
			// get attr data
			$id = esc_sql( filter_int($id) );

			// update to delete with timestamp
			$data_ = array( 'attrDeleted' => time2timestamp() );
			$act = $this->Env_model->update( 'attribute', $data_, array('attrId'=> $id) );

			if($act){
				// remove translate
				translate_removedata('attribute', $id );
				return true;
			} else {
				return false;
			}
		}
	}
	public function delete($id){
		if( is_delete() ){
			$update = Self::deleteAction($id);
			if( $update ){
				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );
			} else {
				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
			}
			redirect( admin_url('attributes') );
		}
	}

	public function bulk_action(){
		$error = false;
		if(empty($this->input->post('bulktype'))){
			$error = "<strong>".t('error')."!!</strong> ". t('bulkactionnotselectedyet');
		}

		if(!$error){
			if( $this->input->post('bulktype')=='bulk_delete' AND is_delete() ){
				$theitem = (!empty($this->input->post('item'))) ? array_filter($this->input->post('item')):array();

				if( count($theitem) > 0 ){
					$stat_hapus = FALSE;

					foreach ($theitem as $key => $value) {
						if($value == 'y'){
							$id = filter_int($this->input->post('item_val')[$key]);

							// update to delete with timestamp
							$update = Self::deleteAction($id);

							if($update){

								$stat_hapus = TRUE;

							} else {

								$stat_hapus = FALSE; break;

							}
						}
					}

					if($stat_hapus){
						$this->session->set_flashdata( 'succeed', t('successfullydeleted') );
					} else {
					  	$this->session->set_flashdata( 'failed', t('cannotprocessdata') );
					}

					redirect( admin_url('attributes') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('attributes') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
		}
	}

	public function ajax_addfieldattrval(){
		if( is_edit() AND $this->input->post('CP') === get_cookie('sz_token') ){
			$idrow = generate_code(8);

			echo '
			<tr id="rowval-'.$idrow.'">
				<td class="align-center">
					'.form_hidden('idattrval[]', '');
					$selectval = array(
						'text' => t('text'),
						'color' => t('color'),
						//'image' => t('image')
					);
					$extraselectval = array(
						'class' => 'select2',
						'id'=>'visualtype-'.$idrow,
					);
					echo form_dropdown('visualtype[]', $selectval, 'text', $extraselectval);
				echo '
					<script type="text/javascript">
					$( document ).ready(function() {
						$(\'.select2\').select2();

						$("#nocolor-'.$idrow.'").show();
						$("#displaycolor-'.$idrow.'").hide();

						$("#visualtype-'.$idrow.'").change(function () {
							if( $(this).val() == \'text\' ){
								$(".attrvaltd-'.$idrow.' .textlabel").empty();
								$(".attrvaltd-'.$idrow.' .textlabel").show();
								$(".attrvaltd-'.$idrow.' .fieldlabel").hide();
								$(".attrvaltd-'.$idrow.' .fieldlabel input").val(\'\');

								$("#nocolor-'.$idrow.'").show();
								$("#displaycolor-'.$idrow.'").hide();
								$("#attrval-'.$idrow.'").val(\'\');
								if( $("#attrval-'.$idrow.'.thecolorpicker").length ){
									$("#attrval-'.$idrow.'").colorpicker(\'colorpicker\').destroy();
									$("#attrval-'.$idrow.'").removeClass(\'thecolorpicker\');
								}
							}
							else if( $(this).val() == \'color\' ){
								$(".attrvaltd-'.$idrow.' .textlabel").empty();
								$(".attrvaltd-'.$idrow.' .textlabel").hide();
								$(".attrvaltd-'.$idrow.' .fieldlabel").show();
								$(".attrvaltd-'.$idrow.' .fieldlabel input").val(\'\');
								
								$("#displaycolor-'.$idrow.'").show();
								$("#nocolor-'.$idrow.'").hide();
								$("#attrval-'.$idrow.'").val(\'\');
								$("#attrval-'.$idrow.'").addClass(\'thecolorpicker\');
								$(\'#attrval-'.$idrow.'\').colorpicker()
								.on(\'colorpickerChange colorpickerCreate\', function (e) {
									$("#displaycolor-'.$idrow.'").css(\'background-color\', e.value);
								});
							}
						});

						$("#attrval-'.$idrow.'").keyup(function() {
							var datavalattr = $(this).val();
							$(".attrvaltd-'.$idrow.' .textlabel").text(datavalattr);
							$(".attrvaltd-'.$idrow.' .fieldlabel input").val(datavalattr);
						});
					});
					</script>
				</td>
				<td class="text-center color-'.$idrow.'">
					<div id="displaycolor-'.$idrow.'" class="mt-2" style="width:23px; height:23px; background-color:#000000; display: inline-flex;"></div>
					<i class="fe fe-minus" id="nocolor-'.$idrow.'"></i>
				</td>
				<td class="text-center">';
					$inputsvalue = array(
						'name' => 'valueattrval[]',
						'class' => 'form-control',
						'id' => 'attrval-'.$idrow,
					);
					echo form_input($inputsvalue);
				echo '
				</td>
				<td class="text-center attrvaltd-'.$idrow.'">
					<div class="fieldlabel" style="display:none;">';
					$inputstext = array(
						'name' => 'labelattrval[]',
						'class' => 'form-control',
					);
					echo form_input($inputstext);
				echo '
					</div>
					<div class="textlabel"></div>
				</td>
				<td class="text-center">
					<button type="button" class="btn btn-danger" id="deleteattrval-'.$idrow.'"><i class="fe fe-trash-2"></i></button>
					<script type="text/javascript">
					$( document ).ready(function() {
						$(\'#deleteattrval-'.$idrow.'\').click(function() {
							$( "#rowval-'.$idrow.'" ).remove();
						});
					});
					</script>
				</td>
			</tr>
			';
		}
	}

	public function ajax_removedataattrval(){
		if( is_delete() AND $this->input->post('CP') === get_cookie('sz_token') ){
			
			$id = filter_int( $this->input->post('attrval') );
			$query = $this->Env_model->delete('attribute_value', array('attrvalId'=>$id));

			if($query){
				echo 200;
			}

		}
	}

}
