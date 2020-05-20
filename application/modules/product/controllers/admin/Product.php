<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller{ 
	
	private $moduleName = '';
	private $extention_allowed = array();

	private $extention_file = array();

	private $fsize = 10000;

	public function __construct(){
		parent::__construct();
		// load helper required
		$this->load->helper('cookie');
		$this->load->helper('admin_functions');

		// protect the page
		$this->adminauth->auth_login();

		// define module name variable
		$this->moduleName = t( array('table'=>'users_menu', 'field'=>'menuName', 'id'=> 15) );

		$this->extention_allowed = array('jpg','jpeg','png','gif');
		
		$this->extention_file = array('exe','psd','pdf','ai','xls','ppt','pptx','gz','gzip','tar','tgz','zip','rar','mp3','wav','bmp', 'gif', 'jpeg', 'jpg', 'png', 'tiff', 'tif', 'mpeg', 'mpg', 'mpe', 'mov', 'avi', 'doc', 'docx', 'mp4', 'flv', 'aac', '7z', 'svg');

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

			// get all shipping courier
			$courierdata = $this->Env_model->view_where("courierId,courierName", "courier", "courierDeleted='0' AND courierStatus='1'");

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
							'attrgroupopt' => $attributegrpsopt,
							'courier' => $courierdata
						);

			$this->load->view( admin_root('product_add'), $data );
		}
	}

	public function edit($id){
		if( is_edit() ){
			$id = esc_sql( filter_int($id) );
			$getdata = $this->Env_model->getval("*","product", "prodId='{$id}'");

			// get categories
			$categories = $this->Env_model->view_where_order('*','categories', "catActive='1' AND catType='product'",'catId','DESC');
			$datacategories = array();
			foreach( $categories as $k => $v ){
				$datacategories[$v['catId']] = $v['catName'];
			}

			// get selected categories
			$datacategories_selected = $this->Env_model->view_where_order('*','category_relationship', "relatedId='{$id}' AND crelRelatedType='product'",'crelId','DESC');
			$categories_selected = array();
			foreach( $datacategories_selected as $k => $v ){
				$categories_selected[] = $v['catId'];
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

			// get all shipping courier
			$courierdata = $this->Env_model->view_where("courierId,courierName", "courier", "courierDeleted='0' AND courierStatus='1'");

			// get images product
			$prodimgdata = $this->Env_model->view_where_order("*", "product_images", "prodId='{$id}'",'pimgPosition','ASC');

			// get product attribute
			$productattr = array();
			$countattravailable = countdata('product_attribute', array('prodId'=>$id));
			if( $countattravailable > 0 ){				
				$productattr = $this->Env_model->view_where_order("*", "product_attribute", "prodId='{$id}'",'pattrId','ASC');
				$xattv = 0;
				foreach($productattr AS $key => $value){
					$attrval = $this->Env_model->view_where_order("*", "product_attribute_combination", "pattrId='{$value['pattrId']}'",'pattrId','ASC');
					$productattr[$xattv] = $value;
					$productattr[$xattv]['attrval'] = $attrval;
					$xattv++;
				}
			}

			// get related product data
			$prodrelateddata = $this->Env_model->view_where_order("*", "product_related", "prodId='{$id}'",'prelId','ASC');

			// get related product data
			$dataprodcourier = $this->Env_model->view_where_order("*", "product_courier", "prodId='{$id}'",'pcId','ASC');
			$prodcourier = array();
			foreach($dataprodcourier as $datac){
				$prodcourier[] = $datac['courierId'];
			}

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
							'data' => $getdata,
							'categories' => $datacategories,
							'categories_selected' => $categories_selected,
							'manufacturers' => $datamanufacturers,
							'badges' => $databadges,
							'taxes' => $taxes,
							'attrval' => $attributes,
							'attrgroupopt' => $attributegrpsopt,
							'prodimage' => $prodimgdata,
							'productattribute' => $productattr,
							'courier' => $courierdata,
							'prodcourier' => $prodcourier,
							'relatedprod' => $prodrelateddata
						);

			$this->load->view( admin_root('product_edit'), $data );
		}
	}

	public function addingprocess(){
		if(is_add()){
			$error = false;

			$kategori = !empty($this->input->post('categories')) ? $this->input->post('categories'):array();
			$extention_allowed = $this->extention_allowed;
			
			$producttype = $this->input->post('producttype');

			// define attr value
			$attributevalue = array();
			$priceattr 		= array();
			$qtyattr 		= array();
			$qtytypeattr 	= array();
			$weightattr 	= array();
			$defaultattr 	= '';

			// define downloadable value
			$dwltitle 		= array();
			$dwlprice 		= array();
			$dwltype 		= array();
			$dwlfile 		= array();
			$dwlurl 		= array();
			$dwlsample 		= array();
			$dwlfilesample 	= array();
			$dwlurlsample 	= array();
			$dwlmaxdownld 	= array();
			$unlimited 		= array();

			// check attribute value
			if( $producttype == 'configurableproduct' OR $producttype=='downloadableproduct'){
				// define attr value
				$attributevalue = empty($this->input->post('attributevalue'))?array():$this->input->post('attributevalue');
				$priceattr 		= empty($this->input->post('priceattr'))?array():$this->input->post('priceattr');
				$qtyattr 		= empty($this->input->post('qtyattr'))?array():$this->input->post('qtyattr');
				$qtytypeattr 	= empty($this->input->post('qtytypeattr'))?array():$this->input->post('qtytypeattr');
				$weightattr 	= empty($this->input->post('weightattr'))?array():$this->input->post('weightattr');
				$defaultattr 	= empty($this->input->post('defaultattr'))?'':$this->input->post('defaultattr');

				// check attribute default
				if( empty( $defaultattr ) AND count( $priceattr )>0 ){
					$error = t('defaultattrisempty');
					$error .= '<script type="text/javascript">moving_tab_to("#attribute");</script>';
					$error = $error;
				}
			}

			if( $producttype=='simpleproduct' OR $producttype=='servicesproduct' ){
				// checking basic price is empty
				if( empty( $this->input->post('normalprice') ) ){
					$error = t('normalpriceempty');
					$error .= '<script type="text/javascript">moving_tab_to("#general");</script>';
					$error = $error;
				}

				// checking price
				if(!empty($this->input->post('specialprice'))){
					if($this->input->post('specialprice') > $this->input->post('normalprice') OR $this->input->post('specialprice') < $this->input->post('capitalprice') ){

						$error = t('specialpricemorebigthancapitalandnormal');
						$error .= '<script type="text/javascript">moving_tab_to("#general");</script>';
						$error = $error;

					}
				} else {
					if($this->input->post('capitalprice') > $this->input->post('normalprice')){
						$error = t('capitalmorebignormal');
						$error .= '<script type="text/javascript">moving_tab_to("#general");</script>';
						$error = $error;
					}
				}
			}

			if( $producttype=='downloadableproduct' ){
				$dwltitle 		= empty($this->input->post('dwltitle'))?array():$this->input->post('dwltitle');
				$dwlprice 		= empty($this->input->post('dwlprice'))?array():$this->input->post('dwlprice');
				$dwltype 		= empty($this->input->post('dwltype'))?array():$this->input->post('dwltype');
				$dwlfile 		= empty($_FILES['dwlfile'])?array():$_FILES['dwlfile'];
				$dwlurl 		= empty($this->input->post('dwlurl'))?array():$this->input->post('dwlurl');
				$dwlsample 		= empty($this->input->post('dwlsample'))?array():$this->input->post('dwlsample');
				$dwlfilesample 	= empty($_FILES['dwlfilesample'])?array():$_FILES['dwlfilesample'];
				$dwlurlsample 	= empty($this->input->post('dwlurlsample'))?array():$this->input->post('dwlurlsample');
				$dwlmaxdownld 	= empty($this->input->post('dwlmaxdownld'))?array():$this->input->post('dwlmaxdownld');
				$unlimited 		= empty($this->input->post('unlimited'))?array():$this->input->post('unlimited');

				// checking downloadable requirement
				if( count( $dwltitle ) > 0 ){

					foreach($dwltitle as $keyd => $vald){
						
						if($dwltype[$keyd] == 'file' AND empty($dwlfile['name'][$keyd]) ){
							$error = t('donwloadfileurlempty');
							$error .= '<script type="text/javascript">moving_tab_to("#downloadable");</script>';
							$error = $error;
							break;
						}

						if( $dwltype[$keyd] == 'url' ){
							if( empty($dwlurl[$keyd]) ){
								$error = t('donwloadfileurlempty');
								$error .= '<script type="text/javascript">moving_tab_to("#downloadable");</script>';
								$error = $error;
								break;
							}

							if(!filter_var($dwlurl[$keyd], FILTER_VALIDATE_URL) ){
								$error = t('donwloadurlnotvalid');
								$error .= '<script type="text/javascript">moving_tab_to("#downloadable");</script>';
								$error = $error;
								break;
							}
						}

						if($dwlsample[$keyd] == 'url' AND !empty($dwlurlsample[$keyd])){
							if(!filter_var($dwlurlsample[$keyd], FILTER_VALIDATE_URL) ){
								$error = t('donwloadsampleurlnotvalid');
								$error .= '<script type="text/javascript">moving_tab_to("#downloadable");</script>';
								$error = $error;
								break;
							}
						}

					}

				} else {
					$error = t('donwloadfiletitleempty');
					$error .= '<script type="text/javascript">moving_tab_to("#downloadable");</script>';
					$error = $error;
				}
			}

			// Checking field Empty
			if( empty( $this->input->post('productname') ) ){
				$error = t('emptyrequiredfield');
				$error .= '<script type="text/javascript">moving_tab_to("#general");</script>';
				$error = $error;
			}

			// checking basic price is empty
			if( empty( $this->input->post('capitalprice') ) ){
				$error = t('basicpriceempty');
				$error .= '<script type="text/javascript">moving_tab_to("#general");</script>';
				$error = $error;
			}

			// check youtube URL
			if( !empty($this->input->post('urlyoutube')) ){
				if( !youtubeChecker($this->input->post('urlyoutube')) OR !filter_var($this->input->post('urlyoutube'), FILTER_VALIDATE_URL) ){
					$error = t('onlyyoutube');
					$error .= '<script type="text/javascript">moving_tab_to("#general");</script>';
					$error = $error;
				}
			}
			
			// checking basic price is empty
			if( empty( $kategori ) ){
				$error = t('productcatempty');
				$error .= '<script type="text/javascript">moving_tab_to("#linked");</script>';
				$error = $error;
			}

			// checking image empty
			if(count(array_filter($_FILES['imgprod']['name'])) > 0){
				// check images extention
				foreach ($_FILES['imgprod']['tmp_name'] as $kimg => $vimg) {
					$extfilename = strtolower( pathinfo($_FILES['imgprod']['name'][$kimg], PATHINFO_EXTENSION) );  
					if( !in_array($extfilename, $extention_allowed) ){
						$error = t('wrongextentionimage');
						$error .= '<script type="text/javascript">moving_tab_to("#image");</script>';
						$error = $error;
					}
				}

			} else {
				$error = t('imgproductisempty');
				$error .= '<script type="text/javascript">moving_tab_to("#image");</script>';
				$error = $error;
			}

			// check image priority
			if( empty($this->input->post('primary'))){
				$error = t('imagepriorityempty');
				$error .= '<script type="text/javascript">moving_tab_to("#image");</script>';
				$error = $error;
			}

			if(!$error){
				$producttype	= empty( $this->input->post('producttype') ) ? 'simpleproduct':esc_sql( filter_txt( $this->input->post('producttype') ) );

				$rules 			= empty( $this->input->post('rules') ) ? 1:esc_sql( filter_int( $this->input->post('rules') ) );
				$tax 			= empty( $this->input->post('tax') ) ? 1:esc_sql( filter_int( $this->input->post('tax') ) );
				$productname 	= esc_sql( filter_txt( $this->input->post('productname') ) );
				$desc 			= empty( $this->input->post('desc') ) ? '':filter_editor( $this->input->post('desc') );
				$urlyoutube		= empty( $this->input->post('urlyoutube') ) ? '': filter_txt( $this->input->post('urlyoutube') );
				$urlyoutube 	= (!empty($urlyoutube) AND youtubeChecker($urlyoutube) ) ? $urlyoutube:'';
				$note 			= empty( $this->input->post('note') ) ? '':filter_editor( $this->input->post('note') );

				$manufacturers	= empty( $this->input->post('manufacturers') ) ? 0:esc_sql( filter_int( $this->input->post('manufacturers') ) );

				$featured 		= ($this->input->post('featured') == 'y') ? 'y':'n';

				$sku 			= empty( $this->input->post('sku') ) ? '':esc_sql( filter_txt( $this->input->post('sku') ) );
				$upc 			= empty( $this->input->post('upc') ) ? '':esc_sql( filter_txt( $this->input->post('upc') ) );
				$isbn 			= empty( $this->input->post('isbn') ) ? '':esc_sql( filter_txt( $this->input->post('isbn') ) );
				$mpn 			= empty( $this->input->post('mpn') ) ? '':esc_sql( filter_txt( $this->input->post('mpn') ) );
				$maxorder		= empty( $this->input->post('maxorder') ) ? '':esc_sql( filter_int( $this->input->post('maxorder') ) );
				$minorder		= empty( $this->input->post('minorder') ) ? '':esc_sql( filter_int( $this->input->post('minorder') ) );
				$qty			= empty( $this->input->post('qty') ) ? 0.00000000:esc_sql( singleComma( $this->input->post('qty') ) );
				$qty_type		= empty( $this->input->post('qty-type') ) ? '':esc_sql( filter_txt( $this->input->post('qty-type') ) );

				$capitalprice = empty( $this->input->post('capitalprice') ) ? 0.00:esc_sql( singleComma( $this->input->post('capitalprice') ) );
				$normalprice = empty( $this->input->post('normalprice') ) ? 0.00:esc_sql( singleComma( $this->input->post('normalprice') ) );
				$specialPrice = empty( $this->input->post('specialprice') ) ? 0.00:esc_sql( singleComma( $this->input->post('specialprice') ) );

				$displayprod = ($this->input->post('publish')=='y') ? 'y':'n';
				$allowreviews = ($this->input->post('allowreviews')=='y') ? 'y':'n';

				$shipping = ($this->input->post('shipping')=='y') ? 'y':'n';

				$freeshipping = 'n';
				$weight	 = 0.00000000;
				$length	 = 0.00000000;
				$width   = 0.00000000;
				$height	 = 0.00000000;
				if($shipping){
					$freeshipping = ($this->input->post('freeshipping')=='y') ? 'y':'n';
	
					$weight			= empty( $this->input->post('weight') ) ? 0.00000000:esc_sql( singleComma( $this->input->post('weight') ) );
					$length			= empty( $this->input->post('length') ) ? 0.00000000:esc_sql( singleComma( $this->input->post('length') ) );
					$width			= empty( $this->input->post('width') ) ? 0.00000000:esc_sql( singleComma( $this->input->post('width') ) );
					$height			= empty( $this->input->post('height') ) ? 0.00000000:esc_sql( singleComma( $this->input->post('height') ) );
				}

				//Set SKU
				if(empty($sku)){
					$sku = strtoupper( substr($productname, 0, 3) . "-" . generate_code(6) );
				}

				// slug
				$slug = slugURL($productname);

				// absolute minimum and maximum order
				if (empty($minorder) OR $minorder<0){
					$minorder=1;
				}
				if (empty($maxorder) OR $maxorder<0){
					$maxorder=0;
				}

				// get final price
				$finalprice = $normalprice;
				if (!empty($specialPrice) and $specialPrice > 0){
					$finalprice = $specialPrice;
				}

				// quantity condition with attribute
				if( $producttype == 'configurableproduct' ){
					if(count( $priceattr )>0 OR count($qtyattr)>0){
						$qty = 0.00000000;
						$qty_type = '';
						$normalprice = 0.00;
						$finalprice = 0.00;
					}
				}

				//timestamp now
				$now = time2timestamp();

				// get new ID
				$nextID = getNextId('prodId','product');

				$data = array(
					'prodId' => $nextID,
					'userLogin' => $this->session->userdata('username'),
					'manufactId' => $manufacturers,
					'optionProdRules' => $rules,
					'taxId' => $tax,
					'prodType' => $producttype,
					'prodSku' => $sku,
					'prodUpc' => $upc,
					'prodIsbn' => $isbn,
					'prodMpn' => $mpn,
					'prodName' => $productname,
					'prodSlug' => $slug,
					'prodDesc' => $desc,
					'prodFeatured' => $featured,
					'prodBasicPrice' => $capitalprice,
					'prodPrice' => $normalprice,
					'prodSpecialPrice' => $specialPrice,
					'prodFinalPrice' => $finalprice,
					'prodQty' => $qty,
					'prodQtyType' => (string) $qty_type,
					'prodWeight' => $weight,
					'prodWeightUnit' => getWeightDefault(),
					'prodLength' => $length,
					'prodWidth' => $width,
					'prodHeight' => $height,
					'prodLengthUnit' => getLengthDefault(),
					'prodOrigin' => '',
					'prodMinOrder' => $minorder,
					'prodMaxOrder' => $maxorder,
					'prodShipping' => $shipping,
					'prodFreeShipping' => $freeshipping,
					'prodVideo' => (string) $urlyoutube,
					'prodNote' => (string) $note,
					'prodBuyCount' => 0,
					'prodViewCount' => 0,
					'prodAdded' => $now,
					'prodModified' => $now,
					'prodDisplay' => $displayprod,
					'prodAllowReview' => $allowreviews,
					'prodDeleted' => 0
				);

				$query = $this->Env_model->insert('product',$data);

				if($query){
					// insert multi translate
					translate_pushdata('productname', 'product', 'prodName', $nextID );
					translate_pushdata('desc', 'product', 'prodDesc', $nextID );
					translate_pushdata('note', 'product', 'prodNote', $nextID );

					// add store
					$datastore = array(
						'prodId' => $nextID,
						'storeId' => storeId()
					);
					$query = $this->Env_model->insert('product_store', $datastore);

					//insert categories
					if(!empty(count(array_filter($kategori)))){
						foreach ($kategori as $keycat => $valuecat) {
							//get next ID
							$nextcatID = getNextId('crelId','category_relationship');
							//Insert Categories In Group
							$insvaluekat = array(
								'crelId' 			=> $nextcatID,
								'catId'				=> $valuecat,
								'relatedId'   		=> $nextID,
								'crelRelatedType' 	=> 'product'
							);

							$insertcatrel = $this->Env_model->insert('category_relationship', $insvaluekat);
						}
					}

					//insert badge					
					if(!empty($this->input->post('badges'))){
						$badgeprod = filter_int( $this->input->post('badges') );
						//get next ID
						$nextIDbadge = getNextId('bdgrelId','badge_relationship');

						//Insert Badge In Group
						$insvaluebadge = array(
							'bdgrelId'    	=> $nextIDbadge,
							'badgeId'   	=> esc_sql( $badgeprod ),
							'relatedId'		=> $nextID,
							'bdgrelType'	=> 'product',
						);

						$insertbadge = $this->Env_model->insert('badge_relationship', $insvaluebadge);
					}

					// insert related product
					$relprod = empty($this->input->post('relatedproduct'))?array():$this->input->post('relatedproduct');
					if( count($relprod) > 0 ){
						$relatedproduct = array_unique( array_filter($this->input->post('relatedproduct')));
						foreach($relatedproduct as $keyprod => $idprodrel){
							//get next ID
							$nextrelprod = getNextId('prelId','product_related');

							//Insert Images In Group
							$insertrelprod = array(
								'prelId'    => $nextrelprod,
								'prodId'	=> $nextID,
								'relatedId' => $idprodrel
							);

							$insertrp = $this->Env_model->insert('product_related', $insertrelprod);
						}
					}

					// insert related product
					if( $shipping == 'y' ){

						if(count($this->input->post('courier')) > 0){
							$courier = array_filter($this->input->post('courier'));
							foreach($courier as $valc){
								//get next ID
								$cnextid = getNextId('pcId','product_courier');

								//Insert Images In Group
								$insertcourier = array(
									'pcId'    => $cnextid,
									'prodId'	=> $nextID,
									'courierId' => $valc
								);

								$this->Env_model->insert('product_courier', $insertcourier);
							}
						}
						
					}

					// process attribute
					if( $producttype == 'configurableproduct' OR $producttype=='downloadableproduct'){

						if( count($attributevalue) > 0 ){

							foreach( $attributevalue AS $ky => $vl ){

								if( !empty($priceattr[$ky]) ){
									// get new ID
									$nextIDattr = getNextId('pattrId','product_attribute');

									// attr price
									$priceattr_ = empty( $priceattr[$ky] ) ? 0.00:esc_sql( singleComma( $priceattr[$ky] ) );
									$weightattr_ = empty( $weightattr[$ky] ) ? 0.00:esc_sql( singleComma( $weightattr[$ky] ) );
									
									// insert attribute
									$attrval = array(
										'pattrId' => $nextIDattr,
										'prodId' => $nextID,
										'pimgId' => 0,
										'pattrPrice' => $priceattr_,
										'pattrQty' => empty($qtyattr[$ky])?0.00000000:esc_sql(singleComma($qtyattr[$ky])),
										'pattrQtyType' => esc_sql(filter_txt($qtytypeattr[$ky])),
										'pattrWeight' => $weightattr_,
										'pattrWeightUnit' => getWeightDefault(),
										'pattrDefault' => ($defaultattr==$ky)?'y':'n',
										'pattrAddedDate' => $now,
										'pattrModifiedDate' => $now
									);
									$insertattr = $this->Env_model->insert('product_attribute', $attrval);

									if( $insertattr ){
										// split attr value
										$attrval = explode('-', $vl);

										foreach( $attrval AS $kattrval => $vattrval){
											// get new ID
											$nextIDattrcomb = getNextId('pattrcombId','product_attribute_combination');

											$attrvaprod = explode(':',$vattrval);

											// insert attribute combination
											$attrcomb = array(
												'pattrcombId' 	=> $nextIDattrcomb,
												'pattrId'		=> $nextIDattr,
												'attrId' 		=> filter_int($attrvaprod[0]),
												'attrvalId' 	=> filter_int($attrvaprod[1]),
											);
											$this->Env_model->insert('product_attribute_combination', $attrcomb);
										}
									}
								}
							}

						}

					} // END if( $producttype == 'configurableproduct' )
					
					
					// insert product images
					// define first variable img
					$filesimg = $_FILES['imgprod'];

					$sizeimg = array(
						'xsmall' 	=>'90',
						'small' 	=>'350',
						'medium' 	=>'860',
						'large' 	=>'1024'
					);
					$img = uploadImage('imgprod','product',$sizeimg, $extention_allowed);
					$nimg = 1;
					foreach ($filesimg['tmp_name'] as $key2 => $value2) {

						$priority = 'n';
						if($this->input->post('primary')==$key2){
							$priority = 'y';
						}

						$nextIDgambar = getNextId('pimgId','product_images');

						if( array_key_exists('directory', $img) AND array_key_exists('filename', $img) ){
							$img_directory = $img['directory'];
							$img_filename = $img['filename'];
						} else {
							$img_directory = $img[$key2]['directory'];
							$img_filename = $img[$key2]['filename'];
						}

						//Insert Images In Group
						$insvalueimg = array(
							'pimgId'      	=> $nextIDgambar,
							'prodId'		=> $nextID,
							'pimgDir'   	=> $img_directory,
							'pimgImg'   	=> $img_filename,
							'pimgPrimary' 	=> $priority,
							'pimgPosition' 	=> $nimg
						);

						$insertpic = $this->Env_model->insert('product_images', $insvalueimg);
						$nimg++;
					}

					// insert downloadable data
					if( $producttype=='downloadableproduct' AND count($dwltitle) > 0){	
						
						$filedwl = '';
						if( count($_FILES['dwlfile']['tmp_name'])>0 ){
							$filedwl = uploadFile('dwlfile', 'downloadablefile', $this->extention_file, 'dwlfile',  $this->fsize );
						}

						$sampledwl = '';
						if( count($_FILES['dwlfilesample']['tmp_name'])>0 ){
							$sampledwl = uploadFile('dwlfilesample', 'downloadablesample', $this->extention_file, 'dwlsample',  $this->fsize );
						}
						
						foreach($dwltitle as $keydw => $valdw){

							$nextIDdwl = getNextId('pdwlId','product_downloadable');

							$pricedwl = empty( $dwlprice[$keydw] ) ? 0.00:esc_sql( singleComma( $dwlprice[$keydw] ) );

							$dwlmax	= ($unlimited[$keydw]=='y') ? 0:$dwlmaxdownld[$keydw];
							$unlimiteddwl = ($unlimited[$keydw]=='y') ? 'unlimited':'limited';

							// define file download
							$dir_fdwl = (empty($filedwl[$keydw]['directory']))?'':$filedwl[$keydw]['directory'];
							$file_fdwl = (empty($filedwl[$keydw]['filename']))?'':$filedwl[$keydw]['filename'];

							// define file sample download
							$dir_sdwl = (empty($sampledwl[$keydw]['directory']))?'':$sampledwl[$keydw]['directory'];
							$file_sdwl = (empty($sampledwl[$keydw]['filename']))?'':$sampledwl[$keydw]['filename'];

							//Insert Images In Group
							$insdwl = array(
								'pdwlId'      	=> $nextIDdwl,
								'prodId'		=> $nextID,
								'pdwlTitle'   	=> $dwltitle[$keydw],
								'pdwlPrice'   	=> $pricedwl,
								'pdwlDownloadType' 	=> $dwltype[$keydw],
								'pdwlFileDir' 	=> (string) $dir_fdwl,
								'pdwlFile' 		=> (string) $file_fdwl,
								'pdwlURL' 		=> (string) $dwlurl[$keydw],
								'pdwlSampleType' => $dwlsample[$keydw],
								'pdwlSampleDir' => (string) $dir_sdwl,
								'pdwlSampleFile' => (string) $file_sdwl,
								'pdwlSampleURL' => (string) $dwlurlsample[$keydw],
								'pdwlMaxDownloadType' => $unlimiteddwl,
								'pdwlMaxDownload' => $dwlmax,
								'pdwlAddedDate' => $now,
							);

							$insertdwl = $this->Env_model->insert('product_downloadable', $insdwl);
						}
					}

					// insert seo data
					if(!empty($this->input->post('seo_judul')) OR !empty($this->input->post('seo_deskripsi')) OR !empty($this->input->post('kw')) OR !empty($this->input->post('noindex')) OR !empty($this->input->post('nofollow'))){
						insertSeoContent(
							'product',
							$nextID,
							$this->input->post('seo_judul', true),
							$this->input->post('seo_deskripsi', true),
							$this->input->post('kw', true),
							$this->input->post('noindex', true),
							$this->input->post('nofollow', true)
						);
					}

					$this->session->set_flashdata( 'succeed', t('successfullyadd'));
					echo '<script>window.location.href = "'.admin_url('product/edit/'.$nextID).'";</script>';

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
