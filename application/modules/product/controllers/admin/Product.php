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

			// get categories
			$manufacturers = $this->Env_model->view_where_order('*','manufacturers', "manufactActive='y' AND manufactDeleted='0'",'manufactName','ASC');
			$datamanufacturers[''] = '-- '.t('choose').' --';
			foreach( $manufacturers as $k => $v ){
				$datamanufacturers[$v['manufactId']] = $v['manufactName'];
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

}
