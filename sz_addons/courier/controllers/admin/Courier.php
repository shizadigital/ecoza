<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courier extends CI_Controller{ 

	private $moduleName = '';
	private $extensi_allowed = '';

	public function __construct(){
		parent::__construct();
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
			$datapage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$table = 'courier';
			$where = "courierDeleted='0'";

			$excClause = '';

            if(!empty($this->input->get('kw'))){
				$kw = $this->security->xss_clean( $this->input->get('kw') );

				$queryserach = "courierName LIKE '%{$kw}%'";
				$excClause = " AND ( $queryserach )";
            }

			$perPage = 30;

			$where = $where.$excClause;
			$datauser = $this->Env_model->view_where_order_limit('*', $table, $where, 'courierId', 'DESC', $perPage, $datapage);

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
						'header_button_action' => array(
											array(
												'title' => t('addnew'),
												'icon'	=> 'fe fe-plus',
												'access' => admin_url('courier/addnew'),
												'permission' => 'add'
											)
										),
						'data' => $datauser,
						'pagination' => $pagination,
						'totaldata' => $rows
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
					'courierCode' => (string) $couriercode,
					'courierUrlTracking' => (string) $urltracking,
					'lengthId' => getLengthDefault('id'),
					'courierMaxLength' => $maxpackagelength,
					'courierMaxWidth' => $maxpackagewidth,
					'courierMaxHeight' => $maxpackageheight,
					'courierMaxWeight' => $maxpackageweight,
					'weightId' => getWeightDefault('id'),
					'courierDirLogo' => (string) $file_dir,
					'courierFileLogo' => (string) $file_img,
					'courierFreeShipping' => $freeshipping,
					'courierStatus' => $active,
					'courierAddedDate' => $now,
					'courierDeleted' => 0
				);
				
				// insert data
				$query = $this->Env_model->insert('courier', $data);
				
			    if($query){

					// add store
					$datastore = array(
						'courierId' => $nextId,
						'storeId' => storeId()
					);
					$query = $this->Env_model->insert('courier_store', $datastore);

					// add cost
					if(count($country)>0){
						foreach($country as $key => $vl){

							$country 		= esc_sql( filter_int( $vl ) );
							$zone 			= esc_sql( filter_int( $this->input->post('zone')[$key] ) );
							$servicename 	= esc_sql( filter_txt( $this->input->post('servicename')[$key] ) );
							$cost 			= singleComma (esc_sql( filter_txt( $this->input->post('cost')[$key] ) ) );
							$etd 			= esc_sql( filter_int( $this->input->post('etd')[$key] ) );
							$note 			= filter_txt( $this->input->post('note')[$key] );

							// cost getId
							$nextcostId = getNextId('ccostId', 'courier_cost');

							$dataarray = array(
								'ccostId' => $nextcostId,
								'courierId' => $nextId,
								'countryId' => $country,
								'zoneId' => $zone,
								'ccostService' => (string) $servicename,
								'ccostCost' => $cost,
								'ccostETD' => (int) $etd,
								'ccostNote' => (string) $note,
								'ccostAddedDate' => $now
							);

							$this->Env_model->insert('courier_cost', $dataarray);
						}
					}

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					echo '<script>window.location.href = "'.admin_url('courier/edit/'.$nextId).'";</script>';
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
			$id = esc_sql( filter_int($id) );
			
			$getdata = $this->Env_model->getval("*","courier", "courierId='{$id}'");

			// get courier cost
			$couriercost = $this->Env_model->view_where_order('*','courier_cost',"courierId='{$getdata['courierId']}'",'ccostId','ASC');

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
							'data' => $getdata,
							'couriercost' => $couriercost,
							'imgextention' => $this->extensi_allowed,
						);

			$this->load->view( admin_root('courier_edit'), $data );
		}
	}

	public function editprocess(){
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
				$id = esc_sql( filter_int( $this->input->post('ID') ) );

				// now
				$now = time2timestamp();

				$file = array();
				// upload image proccess
				if(!empty($_FILES['logo']['tmp_name'])){
					$ext_file = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

					if(in_array($ext_file, $this->extensi_allowed)) {
						$sizeimg = array(
							'xsmall' 	=>'90',
							'small' 	=>'210',
							'medium' 	=>'530',
							'large' 	=>'890'
						);

						$dataimg = getval("courierDirLogo,courierFileLogo", 'courier', "courierId='{$id}'" );
						if(!empty($dataimg['courierDirLogo']) AND !empty($dataimg['courierFileLogo'])){
							
							//delete old file
							foreach($sizeimg AS $imgkey => $valimg){
								@unlink( IMAGES_PATH . DIRECTORY_SEPARATOR .$dataimg['courierDirLogo'].DIRECTORY_SEPARATOR.$imgkey.'_'.$dataimg['courierFileLogo']);
							}
						}

						$img = uploadImage('logo', 'courierlogo', $sizeimg, $this->extensi_allowed);
						$file_img = $img['filename'];
						$file_dir = $img['directory'];
						
						$file = array( 'courierDirLogo'=> $file_dir, 'courierFileLogo'=>$file_img );
					}
				}

				$data = array(
					'courierName' => $couriername,
					'courierCode' => (string) $couriercode,
					'courierUrlTracking' => (string) $urltracking,
					'lengthId' => getLengthDefault('id'),
					'courierMaxLength' => $maxpackagelength,
					'courierMaxWidth' => $maxpackagewidth,
					'courierMaxHeight' => $maxpackageheight,
					'courierMaxWeight' => $maxpackageweight,
					'weightId' => getWeightDefault('id'),
					'courierFreeShipping' => $freeshipping,
					'courierStatus' => $active,
				);

				$data = array_merge($data, $file);
				
				// insert data
				$query = $this->Env_model->update('courier', $data, array('courierId' => $id));
				
			    if($query){

					// add cost
					if(count($country)>0){
						// remove old all cost
						$this->Env_model->delete('courier_cost', array('courierId' => $id));

						foreach($country as $key => $vl){

							$country 		= esc_sql( filter_int( $vl ) );
							$zone 			= esc_sql( filter_int( $this->input->post('zone')[$key] ) );
							$servicename 	= esc_sql( filter_txt( $this->input->post('servicename')[$key] ) );
							$cost 			= singleComma (esc_sql( filter_txt( $this->input->post('cost')[$key] ) ) );
							$etd 			= esc_sql( filter_int( $this->input->post('etd')[$key] ) );
							$note 			= filter_txt( $this->input->post('note')[$key] );

							// cost getId
							$nextcostId = getNextId('ccostId', 'courier_cost');

							$dataarray = array(
								'ccostId' => $nextcostId,
								'courierId' => $id,
								'countryId' => $country,
								'zoneId' => $zone,
								'ccostService' => (string) $servicename,
								'ccostCost' => $cost,
								'ccostETD' => (int) $etd,
								'ccostNote' => (string) $note,
								'ccostAddedDate' => $now
							);

							$this->Env_model->insert('courier_cost', $dataarray);
						}
					}

					$this->session->set_flashdata( 'succeed', t('successfullyupdated'));
					echo '<script>window.location.href = "'.admin_url('courier/edit/'.$id).'";</script>';
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

	protected function deleteAction($id){
		if( is_delete() ){
			$id = esc_sql( filter_int( $id ) );

			$set = array('courierDeleted' => time2timestamp() );
			$query = $this->Env_model->update('courier', $set, "courierId='{$id}'");

			if($query){
				return true;
			} else {
				return false;
			}
		}
	}
	public function delete($id){
		if( is_delete() ){
			$query = Self::deleteAction($id);
			if($query){

				$this->session->set_flashdata( 'succeed', t('successfullydeleted') );

			} else {

				$this->session->set_flashdata( 'failed', t('cannotprocessdata') );

			}

			redirect( admin_url('courier') );
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

							$queryact = Self::deleteAction($id);

							if($queryact){

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

					redirect( admin_url('courier') );
					exit;

				} else {
					$error = "<strong>".t('error')."</strong>".t('bulkactionnotselecteditemyet');
				}

			}
			redirect( admin_url('courier') );
		}

		if($error){
			show_error($error, 503,t('actionfailed'));
			exit;
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
					<button class="btn btn-link" id="deleterow-'.$idrow.'" type="button"><i class="text-danger fe fe-trash-2 shiza_tooltip" title="'.t('delete').'"></i></button>

					<script type="text/javascript">
					$( document ).ready(function() {
						$(\'.shiza_tooltip\').tooltip();

						$(\'#deleterow-'.$idrow.'\').click(function() {
							$( "#rowval-'.$idrow.'" ).remove();
						});

						$(\'#select2product'.$idrow.'\').change(function() {
							$(\'#zoneinput-'.$idrow.'\').html(\'<div class="text-center"><img src="'.base_assets('img/loader/loading.gif').'" alt="loader"></div>\');

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
