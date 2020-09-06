<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function _remap ($param1=null, $params = array() ){
		if($param1){
			
			$method = strtolower(trim($param1));
			if(method_exists($this, $method)){
				
				return call_user_func_array (array($this, $method), $params);

			} else {
				
				// redirect to 404 if more parameter arguments in method
				if(count($params)>0) show_404();
				else $this->index($param1);

			}
		} else {

			$this->index();

		}
	}
	
	public function index(){
        //title web
        $webtitle = 'Checkout';

        // set meta web page
        $web_meta = web_head_properties(
            
            array(                
                // FB Open Graph
                'og' => array(
                    'og:title' 		=> $webtitle .' - '. get_option('sitename'),
                    'og:description' => get_option('sitedescription')
                ),

                // Twitter Cards
                'twitter' => array(
                    'twitter:title' 	=> $webtitle .' - '. get_option('sitename'),
                    'twitter:description' => get_option('sitedescription'),
                    'twitter:card' => 'summary'
                ),

                // Google+ / Schema.org
                'g+' => array(
                    'name' => $webtitle .' - '. get_option('sitename'),
                    'headline' => $webtitle .' - '. get_option('sitename'),
                    'description' => get_option('sitedescription')
                ),
            )
        );

        $dataview = array( 
                    'title' => $webtitle .' - '. get_option('sitename'),
                    'web_meta' => $web_meta,
                );
        $this->load->view( 'checkout', $dataview);
	}

	public function saveorder( $onpage = null ){
		if( get_cookie('sz_token') === sz_token() ):

			$error = false;
			$timestamp = time2timestamp();

			if($onpage == null OR $onpage=='y'){

				// check address
				if( empty($this->input->post('addr')) ){
					$error = true;
					$msg = t('emptyrequiredfield');
				} else{ 

					if($this->input->post('addr') == 'new'){
						if(
							empty($this->input->post('label')) OR 
							empty($this->input->post('name')) OR 
							empty($this->input->post('handphone')) OR 
							empty($this->input->post('address')) OR 
							empty($this->input->post('city'))
						){
							$error = true;
							$msg = t('emptyrequiredfield');
						} else {

							// check phone number
							$nohp = ( $this->input->post('handphone') ) ? filter_txt($this->input->post('handphone')) : null;
							if(!empty($nohp)){
								if(validatePhoneNumber($nohp)==false ){									
									$error = true;
									$msg = t('phonenumbererror');
								}
							}
						}
					}
				}

				// check payment method availability
				if(empty($this->input->post('paymentmethod'))){
					$error = true;
					$msg = t('paymentmethodempty');					
				}

				/**
				 * CHECK QTY OF PRODUCT
				 */
				// define data cart
				$datacart = array();
				$hasCart = $this->shopping_cart->hasCart();
				if( $hasCart ){

					// get data cart first 
					$datacart = $this->shopping_cart->dataCart();

					foreach($datacart['cart'] as $key => $value){

						$prodqty = 0;
						$prodqtytype = '';
						if(empty($value['attributeId'])){

							$valprod = getval('prodQtyType,prodQty','product', array('prodId'=>$value['productId']));

							$prodqty = $valprod['prodQty'];
							$prodqtytype = $valprod['prodQtyType'];

						} else {

							$valattrprod = getval('pattrQtyType,pattrQty','product_attribute',array('pattrId'=>$value['attributeId']));

							$prodqty = $valattrprod['pattrQty'];
							$prodqtytype = $valattrprod['pattrQtyType'];

						}

						if($prodqtytype=='limited'){
							if($prodqty < $value['qty']){
								$error = true;
								$msg = sprintf( t('orderqtyinsufficient'), $value['name'] ); break;
							}
						}

					}

				} else {
					$error = true;
					$msg = t('shoppingcartnotfound');
				}

				if(!$error){

					$memberid = esc_sql( filter_int( get_cookie('member', true) ) );
					$ordermessage   = filter_txt( $this->input->post('ordermessage', true) );
					$geocontryId = esc_sql( filter_int( $this->input->post('geocountry', true) ) );
					$geozoneId = esc_sql( filter_int( $this->input->post('geozone', true) ) );
					$paymentmethod = esc_sql( filter_txt( $this->input->post('paymentmethod',true) ) );
					$language = (empty( get_cookie('lang')))? $this->config->item('language'): esc_sql( filter_txt( get_cookie('lang', true) ) );
					$currency = esc_sql( filter_txt($datacart['currency']) );
					$visitortype = $this->member->is_login() ? 'member':'guest';

					// get address form
					$recipientname = '';
					$recipientcompany = '';
					$recipientaddr = '';
					$recipientcity = '';
					$recipientpostalcode = '';
					$recipienthp = '';
					if($this->input->post('addr') == 'new'){
						$recipientname = esc_sql( filter_txt( $this->input->post('recipientname') ) );
						$recipientcompany = esc_sql( filter_txt( $this->input->post('company') ) );
						$recipientaddr = esc_sql( filter_txt( $this->input->post('address') ) );
						$recipientcity = esc_sql( filter_txt( $this->input->post('city') ) );
						$recipientpostalcode = esc_sql( filter_txt( $this->input->post('postalcode') ) );
						$nohp = str_replace(" ", "", filter_txt($this->input->post('handphone')));
						$recipienthp = (substr(trim($nohp), 0, 1)=='+') ? $nohp : '+'.$nohp; 
					} else {
						if( $this->member->is_login() ){
							$addrid = esc_sql( filter_int( $this->input->post('addr') ) );
							$addrdata = getval('*','member_addressbook', array('maddrId'=>$addrid) );

							$recipientname = $addrdata['maddrReceiveName'];
							$recipientcompany = $addrdata['maddrCompany'];
							$recipientaddr = $addrdata['maddrAddress'];
							$recipientcity = $addrdata['maddrCity'];
							$recipientpostalcode = $addrdata['maddrPostalCode'];
							$recipienthp = $addrdata['maddrHP'];
						}
					}

					// get next ID
					$nextID = getNextId('orderId','orders');

					// get random order code
					$ordercode = strtoupper( generate_code( 8 ) . '-' . $nextID );

					// make invoice number
					$invoice = orderInvoice();

					// make expired date
					$paymentexpired = get_option('paymentexpired');
					$paymentexpiredremove = get_option('paymentexpiredremove');
			
					// get expired time
					$oexpired = $timestamp+( $paymentexpired * (24*3600));
					$odeleted = $timestamp+( $paymentexpiredremove * (24*3600));
			
					$oreminder=$oexpired-(24*3600);
			
					$reminderstat="n";
					if ($oreminder==$timestamp){
						$reminderstat='y';
					}

					$orderdata = array(
						'orderId' => $nextID,
						'storeId' => $this->session->userdata('visitor_storeid'),
						'empId' => 0,
						'modifiedEmpId' => 0,
						'closingEmpId' => 0,
						'mId' => $memberid,
						'countryId' => $geocontryId,
						'zoneId' => $geozoneId,
						'orderRecipientName' => (string) $recipientname,
						'orderRecipientCompany' => (string) $recipientcompany,
						'orderRecipientAddress' => (string) $recipientaddr,
						'orderRecipientCity' => (string) $recipientcity,
						'orderRecipientPostalCode' => (string) $recipientpostalcode,
						'orderRecipientHP' => (string) $recipienthp,
						'orderInvoice' => $invoice,
						'orderInvoiceDate' => $timestamp,
						'orderCode' => $ordercode,
						'orderDay' => date('d'),
						'orderMonth' => date('m'),
						'orderYear' => date('Y'),
						'orderTime' => date('H:i:s'),
						'orderTimestamp' => $timestamp,
						'orderMessage' => (string) $ordermessage,
						'orderDiscounts' => '0.00', // needs to be discussed
						'orderTaxDefaultId' => ( get_option('taxstatus') == 'y' )? get_option('taxId'):0,
						'orderTax' => '0.00',
						'orderTaxType' => 'percentage',
						'orderTaxAmount' => '0.00',
						'orderSubtotal' => '0.00',
						'orderTotal' => '0.00',
						'orderProfitTotal' => '0.00',
						'orderTimeToExpired' => $oexpired,
						'orderTimeToRemove' => $odeleted,
						'orderReminder' => $oreminder,
						'orderReminderStatus' => $reminderstat,
						'orderPaymentMethod' => $paymentmethod,
						'orderPaymentMeta' => '',
						'orderFlag' => '',
						'orderLang' => $language,
						'orderCurrency' => $currency,
						'orderVisitorType' => $visitortype,
						'orderAdded' => $timestamp,
						'orderModified' => $timestamp
					);
					// insert data
					$query = $this->Env_model->insert('orders', $orderdata);

					if($query){

						$totalprice_ = 0.00;
						$profitprice_ = 0.00;
						
						foreach( $datacart['cart'] as $value ){

							$prodId = esc_sql( filter_int( $value['productId'] ) );
							$attrId = (empty($value['attributeId']))?0:esc_sql( filter_int( $value['attributeId'] ) );
							$qty 	= $value['qty'];
							$priceperunit = ($value['specialPrice']=='0,00')?$value['price']:$value['specialPrice'];
							
							// get product data
							$product = getval(
								'prodId,ssegId,taxId,manufactId,prodSku,prodName,prodUpc,prodIsbn,prodMpn,prodQty,prodBasicPrice,prodPrice,prodSpecialPrice,prodWeight,prodWeightUnit,prodLength,prodWidth,prodHeight,prodLengthUnit,prodBuyCount',
								'product',
								array('prodId'=>$prodId)
							);

							// get next detail order ID
							$nextIDDetail = getNextId('odetId','order_detail');

							// generate detail order code
							$detordercode = generate_code( 8 ) . '-' . $nextIDDetail;

							// get manufacture
							$manufacture = getval(
								"manufactName",
								"manufacturers",
								array('manufactId'=>$product['manufactId'])
							);

							// convert attr to serialize data 
							$attrserialize = serialize( $value['attribute'] );

							// define the price
							$productprice = $product['prodPrice'];
							$productWeight = $product['prodWeight'];
							$productWeightUnit = $product['prodWeightUnit'];
							if( $attrId>0 ){
								$getattrdata = getval(
									"pattrPrice,pattrQty,pattrWeight,pattrWeightUnit",
									"product_attribute",
									array('pattrId'=>$attrId)
								);

								$productprice = $getattrdata['pattrPrice'];
								$productWeight = $getattrdata['pattrWeight'];
								$productWeightUnit = $getattrdata['pattrWeightUnit'];
							}

							// price process
							$totalprice = $priceperunit * $qty;
							
							$totalprice_ += $totalprice;

							// check the product has include tax
							$taxvalue = '0.00';
							if($product['taxId'] > 0){
								$taxvalue = countTax($totalprice, $product['taxId']);
							}

							// get profit
							$profitprice = $totalprice - ($product['prodBasicPrice'] * $qty);
							$profitprice_ += $profitprice;

							$datadetailorder = array(
								'odetId' => $nextIDDetail,
								'orderId' => $nextID,
								'whId' => 0,
								'prodId' => $product['prodId'],
								'pattrId' => (int) $attrId,
								'unitId' => 0,
								'manufactId' => (int) $product['manufactId'],
								'odetCode' => $detordercode,
								'odetProdSku' => (string) $product['prodSku'],
								'odetProdManufacture' => (string) $manufacture,
								'odetProdName' => (string) $product['prodName'],
								'odetProdUpc' => (string) $product['prodUpc'],
								'odetProdIsbn' => (string) $product['prodIsbn'],
								'odetProdMpn' => (string) $product['prodMpn'],
								'odetProdWeight' => $productWeight,
								'odetProdWeightUnit' => $productWeightUnit,
								'odetProdLength' => $product['prodLength'],
								'odetProdWidth' => $product['prodWidth'],
								'odetProdHeight' => $product['prodHeight'],
								'odetprodLengthUnit' => $product['prodLengthUnit'],
								'odetProdBasicPrice' => $product['prodBasicPrice'],
								'odetProdPrice' => $productprice,
								'odetProdSpecialPrice' => $product['prodSpecialPrice'],
								'odetProdAttributes' => (string) $attrserialize,
								'odetProdTaxId' => $product['taxId'],
								'odetTaxAmount' => $taxvalue,
								'odetUnitQty' => (string) '',
								'odetQty' => $qty,
								'odetPricePerunit' => $priceperunit,
								'odetPriceTotal' => $totalprice,
								'odetProfit' => $profitprice,
								'odetAdded' => $timestamp,
								'odetModified' => $timestamp
							);
							$detquery = $this->Env_model->insert('order_detail', $datadetailorder);

							if($detquery){
								// reduce product stock
								if( $attrId>0 ){
									$qtyprod = $product['prodQty'] - $qty;
									$this->Env_model->update('product', array('prodQty'=>$qtyprod), array('prodId' => $product['prodId']));
								} else {
									// get last attr qty
									$lastqty = getval('pattrQty','product_attribute', array('pattrId' => $attrId));
									$qtyattr = $lastqty - $qty;
									$this->Env_model->update('product_attribute', array('pattrQty'=>$qtyattr), array('pattrId' => $attrId));
								}

								// update buyer count
								$countingbuyer = $product['prodBuyCount'] + 1;
								$this->Env_model->update('product', array('prodBuyCount'=>$countingbuyer), array('prodId' => $product['prodId']));
							}

						}

						/**
						 * 
						 * UPDATE PRODUCT DATA
						 * 
						 */
						// get tax ammount
						$taxAmount = 0.00;
						$taxType = 'percentage';
						$taxRate = 0.00;
						if( taxStatus() AND $datacart['allusedefaulttax']){
							// get taxt data
							$generaltax = getGeneralTaxValue(); 

							$taxType = $generaltax['type'];
							$taxRate = $generaltax['rate'];

							if($generaltax['type'] == 'percentage'){
								$taxAmount = ($generaltax['rate'] / 100) * $totalprice_;
							} 
							elseif($generaltax['type'] == 'fixed') {
								$taxAmount = $generaltax['rate'];
							}
						}
						
						// get grand total
						$grandtotalorder = $totalprice_ + $taxAmount;

						// update main order data
						$orderdataupdt = array(
							'orderTax' => $taxRate,
							'orderTaxType' => $taxType,
							'orderTaxAmount' => $taxAmount,
							'orderSubtotal' => $totalprice_,
							'orderTotal' => $grandtotalorder,
							'orderProfitTotal' => $profitprice_,
						);
						$this->Env_model->update('orders',$orderdataupdt, array('orderId' => $nextID));

						/**
						 * 
						 * SET PRODCUT STATUS
						 * 
						 */
						// get next detail order status
						$nextIDStatus = getNextId('orderstatId','order_status');

						// get id status
						$statusdata = getval('optorderstatId,optorderstatName','options_order_status',array('optorderstatRuleType'=>'pending'));
			
						// make status order here
						$datastatus = array(
							'orderstatId' => $nextIDStatus,
							'orderId' => $nextID,
							'optorderstatId' => $statusdata['optorderstatId'],
							'orderstatName' => (string) $statusdata['optorderstatName'],
							'orderstatDate' => $timestamp,
							'orderstatCurrentStatus' => 1
						);
						$this->Env_model->insert('order_status', $datastatus);

						/**
						 * 
						 * SET NEW ADDRESS DATA
						 * 
						 */
						// address proccess
						if($this->input->post('addr') == 'new'){
							if( $this->member->is_login() ){

								$nextIdAddr = getNextId('maddrId','member_addressbook');

								$addrlabel = esc_sql( filter_txt( $this->input->post('label', true) ) );

								// insert address book
								$addrdata = array(
									'maddrId' => $nextIdAddr,
									'mId' => $memberid,
									'cityId' => $regioncity,
									'countryId' => $geocontryId,
									'maddrLabel' => $addrlabel,
									'maddrReceiveName' => $recipientname,
									'maddrCompany' => $recipientcompany,
									'maddrAddress' => $recipientaddr,
									'maddrPostalCode' => $recipientcity,
									'maddrCity' => $recipientcity,
									'maddrHP' => $recipienthp,
									'maddrPriority' => 'secondary'
								);
								$this->Env_model->insert('member_addressbook',$addrdata);
							}
						}

						###################################################
						#                                                 #
						#      EMAIL ORDER DATA TO MEMBER START HERE      #
						#                                                 #
						###################################################
						
						// get member data
						$mem = getval('mName,mEmail,mHP,mDefaultLang,mDefaultCurrency','member',array('mId'=>$memberid));

						$to        = $mem['mEmail'];
						$subject   = 'Konfirmasi Pesanan Anda ['.get_option('sitename').']';

						$message = '
						<style type="text/css">
						.inv table, tr, td {
							border-collapse : collapse; 
							font-size : 12px; 
							font-family : verdana; 
							border-color: black
						}
		
						html, body{
							background-image: none !important;
						}
						</style>';
						
						$message .= t( array( 'table'=>'email_template', 'field'=>'tEmail', 'id'=>1) );

						$emailvars['MEMBERNAME'] = $mem['mName'];
						$emailvars['MEMBEREMAIL'] = $mem['mEmail'];
						$emailvars['MEMBERPHONE'] = $mem['mHP'];
						$emailvars['ORDERDATE'] = date('l, d F Y H:i', $timestamp);
						$emailvars['MEMBERMSG'] = (empty($ordermessage))?' - ': $ordermessage;
						$emailvars['MEMBERRECNAME'] = $recipientname;
						$emailvars['MEMBERADDR'] = $recipientaddr;
						$emailvars['MEMBERTOWN'] = $recipientcity;
						$emailvars['INVOICE'] = $invoice;
						$emailvars['GRANDTOTAL'] = the_price($grandtotalorder, 2, $datacart['currency']);

						$paymentdata = '';
						foreach ( $this->paymentgateway->paymentList('on') as $key => $paymendata ) {
							
							if($key == 'banktransfer'){
								$paymentdata .= "<strong>".$this->paymentgateway->getPaymentName($key)."</strong>";
								$valbank = $this->paymentgateway->getPaymentSetting($key, 'listbank');

								$paymentdata .= "<ul>";
								$listbank = unserialize($valbank);
								foreach ($listbank as $keylb => $valuelb) {
									$paymentdata .= "<li>";
									$paymentdata .= $valuelb['bankname'] . ' (' . $valuelb['desc'] . ') - '.$valuelb['accountnumber'].' ' . 'A/N ' . $valuelb['accountname'];
									$paymentdata .= "</li>";
								}
								$paymentdata .= "</ul>";

								$paymentdata .= "<br/>";
							}
							elseif($key == 'paypal'){
								$paymentdata .= "<strong>".$this->paymentgateway->getPaymentName($key)."</strong>";
								$paymentdata .= "<ul>";
								$paymentdata .= "<li>".$this->paymentgateway->getPaymentSetting($key, 'email')." A/N ".$this->paymentgateway->getPaymentSetting($key, 'accountname')."</li>";
								$paymentdata .= "</ul>";
							}
						}
						$emailvars['PAYMENT'] = $paymentdata;
						$emailvars['ORDEREXP'] = date('l, d F Y H:i', $oexpired);

						$orderdetail = '<ol>';
						foreach($datacart['cart'] as $odet ){
							$orderdetail .= '<li>';
							$orderdetail .= $odet['name'].' - Jumlah: ' . $odet['qty']. '<br/>';
							
							if(count( $odet['attribute']) > 0){
								foreach($odet['attribute'] as $key => $attrname	){
									$orderdetail .= $key . ': '.$attrname. '<br/>';
								}
							}
							if($odet['specialPrice'] == '0.00' ){
								$orderdetail .= the_price($odet['price'], 2, $datacart['currency']);
							} else {
								$orderdetail .= '<s>'.the_price($odet['price'], 2, $datacart['currency']) . '</s> - ' . the_price($odet['specialPrice'], 2, $datacart['currency']);
							}

							if( $odet['taxRate'] > 0 AND $datacart['allusedefaulttax']==false && $datacart['taxstatus']=='y' ){
								$prodTaxAmout = 0.00;
								if($odet['taxRate'] > 0){
									if($odet['taxType'] == 'percentage'){
										$prodTaxAmout = ($odet['taxRate'] / 100) * $odet['price'];
									} 
									elseif($odet['taxType'] == 'fixed') {
										$prodTaxAmout = $odet['taxRate'];
									}
								}
								
								$orderdetail .= '<br/>+Pajak: '.the_price($prodTaxAmout, 2, $datacart['currency']);
							}

							$orderdetail .= '';

							$orderdetail .= '</li>';
						}
						$orderdetail .= '</ol>';
						$emailvars['ORDERDETAIL'] = $orderdetail;
						$emailvars['SHIPMETHOD'] = '-'; // warungkita
						$emailvars['SHIPPRICE'] = 'COD'; // warungkita
						$emailvars['SUBTOTAL'] = the_price($totalprice_, 2, $datacart['currency']);

						$thetax = '';
						$thetaxammount = ' - ';
						if( taxStatus() AND $datacart['allusedefaulttax']){
							$txr_exp = explode('.',$taxRate);
							if($txr_exp[1] == '00'){ $taxRate = $txr_exp[0]; }
							if($taxType == 'percentage'){
								$thetax = ' ('.$taxRate.'%)';
							}
							elseif($taxType == 'fixed'){
								$thetax = ' (+'.the_price($taxRate, 2, $datacart['currency']).')';
							}

							$thetaxammount = the_price($taxAmount, 2, $datacart['currency']);
						}
						$emailvars['TAX'] = $thetax;
						$emailvars['TAXAMOUNT'] = $thetaxammount;

						$message = variable_parser($message, $emailvars);

						#send mail to member
						$option = array();
						$option['from'] = get_option('smtp_username');
						$option['fromname'] = get_option('sitename');
						$option['replyto'] = get_option('siteemail');
						$option['cc'] = '';
						$option['bcc'] = '';
						$option['to'] = $to;
						$option['toname'] = $mem['mName'];
						$option['subject'] = $subject;
						$option['message'] = $message;
						$option['messagetype'] = 'html';
						sendMailPHPMailer($option);

						###################################################
						#                                                 #
						#       EMAIL ORDER DATA TO MEMBER END HERE       #
						#                                                 #
						###################################################
						
						// Insert visitor data cart record
						$serialize = serialize($datacart);
						// encryption the data
						$shoppingcart = encoder($serialize."###".base_url());
						if( $this->member->is_login() ){
							$cartdata = array(
										'cartSessionId'     => session_id(),
										'cartData'          => $shoppingcart,
										'cartModified'    	=> $timestamp,
										'cartIp'            => getIP(),
										'cartStatus'        => 'completed',
										'orderId'           => $nextID
									);
				
							$result = $this->Env_model->update( "cart", $cartdata, "mId='{$memberid}' AND cartVisitorType='member'" );
						}
						
						// update number start Invoice
						if(check_option('invoiceordernumberstart')){
							$invoicenumberstart = ((int) get_option('invoiceordernumberstart')) + 1;
							set_option('invoiceordernumberstart', $invoicenumberstart);
						}else{
							add_option('invoiceordernumberstart', '1');
						}

						// unset data cart
						$this->shopping_cart->unsetCart();

						// completed
						$url = base_url('checkout/checkoutsucceed');
						
						if($onpage=='y'){
							$status = 200;
							$response = array(
								'msg' => t('completedorder'),
								'redirect' => $url
							);
						} else {
							redirect($url);
						}
					}

				}

			} else {
				$error = true;
				$msg = t('memberwrongprocess');
			}

			if($error){

				if($onpage=='y'){
	
					$status = 503;
					$response = array(
						'msg' => $msg,
					);
	
				} else {
	
					$this->session->set_flashdata( 'errormsg', $msg );
	
					$url = !empty( $this->input->post('redirectback') ) ? $this->input->post('redirectback') : base_url();
					redirect( $url );
	
				}
			}
	
			if($onpage=='y'){
	
				$returndata = array(
					'status' => $status,
					'data' => $response
				);
		
				// make absolute for json file with header
				header('Content-Type: application/json');
				echo json_encode((object) $returndata);
	
			}

		endif;
	}

	public function checkoutsucceed(){

		$idorder = esc_sql( filter_int($this->input->get('order', true)));
		$orderstatus = (empty($idorder)) ? false:true;

		$data = getval('*','orders',array('orderId'=>$idorder));

		//title web
        $webtitle = 'Checkout Succeed';

        // set meta web page
        $web_meta = web_head_properties(
            
            array(                
                // FB Open Graph
                'og' => array(
                    'og:title' 		=> $webtitle .' - '. get_option('sitename'),
                    'og:description' => get_option('sitedescription')
                ),

                // Twitter Cards
                'twitter' => array(
                    'twitter:title' 	=> $webtitle .' - '. get_option('sitename'),
                    'twitter:description' => get_option('sitedescription'),
                    'twitter:card' => 'summary'
                ),

                // Google+ / Schema.org
                'g+' => array(
                    'name' => $webtitle .' - '. get_option('sitename'),
                    'headline' => $webtitle .' - '. get_option('sitename'),
                    'description' => get_option('sitedescription')
                ),
            )
        );

        $dataview = array(
                    'title' => $webtitle .' - '. get_option('sitename'),
					'web_meta' => $web_meta,
					'orderdata' => $data,
					'orderstatus' => $orderstatus
                );
        $this->load->view( 'checkout-succeed', $dataview);
	}
	
}
