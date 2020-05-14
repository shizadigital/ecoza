<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier extends CI_Controller{ 

	private $moduleName = '';
	private $extensi_allowed = '';

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 26) );

		// file extention allowed
		$this->extensi_allowed = array('jpg','jpeg','png','gif');

		// load model
		$this->load->model('courier_model');
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
												'access' => admin_url('courier/addnew'),
												'permission' => 'add'
											)
										),
					);
			
			$this->load->view( admin_root('courier_view'), $data );
		}
	}

	public function addnew(){
		if( is_add() ){

			
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
													'access' => admin_url('courier'),
													'permission' => 'view'
												)
											),
							'imgextention' => $this->extensi_allowed,
						);

			$this->load->view( admin_root('courier_add'), $data );
		}
	}

	public function addprocess(){
		if( is_add() ){
			$error = false;

			$country 	= empty($this->input->post('country'))?array():$this->input->post('country');
			$zone 		= empty($this->input->post('zone'))?array():$this->input->post('zone');

			if( empty( $this->input->post('couriername') ) OR count($country)<1 OR count($zone)<1 ){
				$error = t('emptyrequiredfield');
			}

			if(count($country)>0){
				foreach(array_filter($country) as $ky => $vl){
					if( empty( $zone[$ky] ) ){
						$error = t('emptyrequiredfield'); break;
					}
				}
			}

			if( !empty( $this->input->post('urltracking') ) ){
				if(!filter_var($this->input->post('urltracking'), FILTER_VALIDATE_URL)){
					$error = t('urlnotvalid');
				}
			}

			// check image upload
			if(!empty($_FILES['logo']['tmp_name'])){
				$ext_file = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

				if(!in_array($ext_file,$this->extensi_allowed)) {
					$error = "<strong>".t('error')."!!</strong> " . t('wrongextentionfile');
				}
			}

			if(getLengthDefault('id') < 1){
				$error = "<strong>".t('error')."!!</strong> " . t('defaultlengthempty');
			}

			if(getWeightDefault('id') < 1){
				$error = "<strong>".t('error')."!!</strong> " . t('defaultweightempty');
			}

			if(!$error){
				$couriername 	= esc_sql( filter_txt( $this->input->post('couriername') ) );
				$couriercode 	= esc_sql( filter_txt( $this->input->post('couriercode') ) );
				$urltracking 	= filter_txt( $this->input->post('urltracking', true) );
				$freeshipping	= ($this->input->post('freeshipping') =='1' ) ? 'y':'n';
				$active	= ($this->input->post('active') =='1' ) ? 1:0;
				$maxpackagewidth = singleComma(esc_sql(filter_txt( $this->input->post('maxpackagewidth') )));
				$maxpackageheight = singleComma(esc_sql(filter_txt( $this->input->post('maxpackageheight') )));
				$maxpackagelength = singleComma(esc_sql(filter_txt( $this->input->post('maxpackagelength') )));
				$maxpackageweight = singleComma(esc_sql(filter_txt( $this->input->post('maxpackageweight') )));

				// getId
				$nextId = getNextId('courierId', 'courier');

				// now
				$now = time2timestamp();

				$file_img = '';
				$file_dir = '';
				// upload image proccess
				if(!empty($_FILES['logo']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

					if(in_array($ext_file,$this->extensi_allowed)) {
						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'210',
							'medium' 	=>'530',
							'large' 	=>'890'
						);
						$img = uploadImage('logo', 'courierlogo', $sizeimg, $this->extensi_allowed);
						$file_img = $img['filename'];
						$file_dir = $img['directory'];
					}
				}

				$data = array(
					'courierId' => $nextId,
					'addonsId' => 0,
					'courierName' => $couriername,
					'courierCode' => $couriercode,
					'courierUrlTracking' => $urltracking,
					'lengthId' => getLengthDefault('id'),
					'courierMaxLength' => $maxpackagelength,
					'courierMaxWidth' => $maxpackagewidth,
					'courierMaxHeight' => $maxpackageheight,
					'courierMaxWeight' => $maxpackageweight,
					'weightId' => getWeightDefault('id'),
					'courierDirLogo' =>$file_dir,
					'courierFileLogo' =>$file_img,
					'courierFreeShipping' => $freeshipping,
					'courierStatus' => $active,
					'courierAddedDate' => $now,
					'courierDeleted' => 0
				);
				
				// insert data
				$query = $this->Env_model->insert('stock_entry', $data);
				
			    if($query){

					// add cost




					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					echo '<script>window.location.href = "'.admin_url('stock_entry').'";</script>';
				} else {
					// error condition
					// format: type|title|description
					echo 'danger|'.t('error').'|'.t('cannotprocessdata');
				}
				
			} else {
				// error condition
				// format: type|title|description
				echo 'danger|'.t('error').'|'.$error;
			}
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
													'access' => admin_url('courier/addnew'),
													'permission' => 'add'
												),
												array(
													'title' => t('back'),
													'icon'	=> 'fe fe-corner-up-left',
													'access' => admin_url('courier'),
													'permission' => 'view'
												)
											),
						);

			$this->load->view( admin_root('courier_edit'), $data );
		}
	}

	public function delete($id){
		if( is_delete() ){

		}
	}

	public function ajax_addnewservice(){
		if( is_add() AND $this->input->post('CP') === get_cookie('sz_token')){
			$error = false;

			$idrow = generate_code(8);

			$wherecountry = "countryDeleted='0' AND countryStatus='1'";
			$country = $this->Env_model->view_where_order('countryId,countryName','geo_country',$wherecountry,'countryName','ASC');

			$wherezone = "zoneDeleted='0' AND zoneStatus='1' AND countryId='".getCountryDefault('id')."'";
			$zone = $this->Env_model->view_where_order('zoneId,zoneName','geo_zone',$wherezone,'zoneName','ASC');

			echo '
			<tr id="rowval-'.$idrow.'">
				<td class="align-center">
					<select name="country['.$idrow.']" class="custom-select" id="select2product'.$idrow.'">';
					foreach($country AS $v){
						echo '<option value="'.$v['countryId'].'"';
						if( getCountryDefault('id') == $v['countryId'] ){ echo ' selected="selected"'; }
						echo '>'.$v['countryName'].'</option>';
					}
					echo '
					</select>
				</td>
				<td class="align-center" id="zoneinput-'.$idrow.'">
					<select name="zone['.$idrow.']" class="custom-select">';
						echo '<option value="">-- '.t('choosecountryfirst').' --</option>';
						foreach($zone AS $vz){
							echo '<option value="'.$vz['zoneId'].'">'.$vz['zoneName'].'</option>';
						}
					echo '
					</select>
				</td>
				<td class="text-center">
					<input type="text" name="servicename['.$idrow.']" class="form-control">
				</td>
				<td class="align-center">
					<input type="text" onkeypress="return isNumberComma(event)" name="cost['.$idrow.']" class="form-control">
				</td>
				<td class="align-center">
					<input type="text" onkeypress="return isNumberKey(event)" name="etd['.$idrow.']" class="form-control">
				</td>
				<td class="align-center">
					<input type="text" name="note['.$idrow.']" class="form-control">
				</td>
				<td class="align-center">
					<button class="btn btn-link" id="deleterow-'.$idrow.'" type="button"><i class="text-danger fe fe-trash-2"></i></button>

					<script type="text/javascript">
					$( document ).ready(function() {
						$(\'#deleterow-'.$idrow.'\').click(function() {
							$( "#rowval-'.$idrow.'" ).remove();
						});

						$(\'#select2product'.$idrow.'\').change(function() {
							$(\'#zoneinput-'.$idrow.'\').html(\'<div class="text-center"><img src="'.web_assets('img/loader/loading.gif').'" alt="loader"></div>\');

							var idzone = $(this).val();

							// proccess
							$.post("'.admin_url($this->uri->segment(2) . '/ajax_getzone').'", 
							{
								id: idzone,
								idrow: \''.$idrow.'\',
								CP: \''.get_cookie('sz_token').'\'
								'.( is_csrf() ? ','.$this->security->get_csrf_token_name().':"'.$this->security->get_csrf_hash().'"':'').'
							},
							function(data){								
								
							}).done( function(data){
								$(\'#zoneinput-'.$idrow.'\').html(data);
							});
						});
						
					});
					</script>
				</td>
			</tr>
			';
		}
	}

	public function ajax_getzone(){
		if( $this->input->post('CP') === get_cookie('sz_token')){
			$id = esc_sql( filter_int( $this->input->post('id', true) ) );
			$idrow = esc_sql( filter_txt( $this->input->post('idrow', true) ) );

			$wherezone = "zoneDeleted='0' AND zoneStatus='1' AND countryId='".$id."'";
			$zone = $this->Env_model->view_where_order('zoneId,zoneName','geo_zone',$wherezone,'zoneName','ASC');

			echo '<select name="zone['.$idrow.']" class="custom-select">';
			echo '<option value="">-- '.t('choosecountryfirst').' --</option>';
			foreach($zone AS $vz){
				echo '<option value="'.$vz['zoneId'].'">'.$vz['zoneName'].'</option>';
			}
			echo '</select>';
		}
	}

}
