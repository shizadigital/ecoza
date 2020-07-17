<?php 
function decimalPart( $v, $delimiter='.', $part='left' ){
	$explode = explode($delimiter, $v);

	if($part=='left')
		return $explode[0];
	else
		return $explode[1];
}

function getDisc($bigval=0,$smallval=0,$decimal = 2, $sep = '.'){
	// hitung harga
    $persen = ($smallval / $bigval) * 100;

    if($persen > 100){
        $cetak = FALSE;
    } else {
        if($persen>0){
        	$persen = 100 - $persen;
        	$persen_ = number_format($persen,$decimal,$sep,'.');
            $cetak = $persen_ . '%';
        } else {
            $cetak = '0%';
        }
    }

    return $cetak;
}

function digitFormat($angka, $decimal = 2, $removezerodecimal = false){
	$return = number_format($angka,$decimal,',','.');

	if($removezerodecimal == true){
		// make total zero
		$zerocount = '';
		for($z=0; $z < $decimal; $z++){
			$zerocount .= '0';
		}
		
		// remove zero
		$qtyexp = explode(',',$return);
		if(isset($qtyexp[1]) == $zerocount){ $return = $qtyexp[0]; }
	}

	return $return;
}

function productRules($all = TRUE, $idarray = '1'){	    
    $prodtypeopt = unserialize(get_option('productrules'));
 	
	if( $all ){
        $optdata = array();
        foreach($prodtypeopt AS $key =>$val){
            foreach($val as $k => $data){
                $optdata[$key][$k] = t($data);
            }
        }
		$result = $optdata;
	} else {
		if(count($prodtypeopt) > 0){
			$result['type'] 		= t($prodtypeopt[$idarray]['type']);
			$result['description']  = t($prodtypeopt[$idarray]['description']);
		} else {
			$result = t('productrulesinfo');
		}
	}

	return $result;
}

/*
*
* START ALL ABOUT PRICE AND CURRENCY HERE
*
*/
function currencySymbol($code=null){

	if( empty($code) ){ $code = get_option('defaultcurrency'); }

	$countdata = countdata("currency","curCode='{$code}'");
	if($countdata > 0){
		$getval = getval("curPrefixSymbol,curSuffixSymbol","currency","curCode='{$code}'");

		if(!empty($getval['curPrefixSymbol']) AND empty($getval['curSuffixSymbol'])){
			$result = array(
					"symbol" => $getval['curPrefixSymbol'],
					"position" => "prefix"
				);
		} elseif(empty($getval['curPrefixSymbol']) AND !empty($getval['curSuffixSymbol'])){
			$result = array(
					"symbol" => $getval['curPrefixSymbol'],
					"position" => "suffix"
				);
		} elseif(!empty($getval['curPrefixSymbol']) AND !empty($getval['curSuffixSymbol'])){
			$result = array(
					"prefix_symbol" => $getval['curPrefixSymbol'],
					"suffix_symbol" => $getval['curSuffixSymbol'],
					"position" => "both"
				);
		}
	} else {
		$result = false;
	}

	return $result;	
}

function getCurrencySymbol($code=null){

	if( empty($code) ){ $code = get_option('defaultcurrency'); }

	$currency = currencySymbol($code);

	if($currency){
		if($currency['position'] == 'both'){
			$result = $currency['prefix_symbol'];
		} else {
			$result = $currency['symbol'];
		}
	} else {
		$result = false;
	}

	return $result;
}

function the_price($price, $decimal = 2, $code=null, $symbol = true, $symbol_space = true){
    $ci =& get_instance();

	if( empty($code) ){ $code = get_option('defaultcurrency'); }

	// load cookie helper
    $ci->load->helper('cookie');

	// check default code if cookies currency code not found and if the page is administrator directory
	if( empty(get_cookie('currency')) OR strpos(current_url(), $ci->config->item('admin_slug') ) ){
		$code = get_option('defaultcurrency');
	} else {
		$code = get_cookie('currency');
	}

	$countdata = countdata("currency","curCode='{$code}'");
	if($countdata > 0){

		// convert currency if different code 
		$price = priceConvertCurrency($price, $code);

		// symbol
		if($symbol==true){
			$thesymbols = currencySymbol($code);

			if($thesymbols['position'] == 'prefix'){
				$theprice = $thesymbols['symbol'] 
							. ( ( $symbol_space == true ) ? " ":"" )
							. digitFormat($price, $decimal);
			} elseif($thesymbols['position'] == 'suffix') {
				$theprice = digitFormat($price, $decimal) 
							. ( ( $symbol_space == true ) ? " ":"" ) 
							. $thesymbols['symbol'];
			} elseif($thesymbols['position'] == 'both'){
				$theprice = $thesymbols['prefix_symbol']
							. ( ( $symbol_space == true ) ? " ":"" )
							. digitFormat($price, $decimal)
							. ( ( $symbol_space == true ) ? " ":"" )
							. $thesymbols['suffix_symbol'];
			}
		} else {
			// dafine the price
			$theprice = digitFormat($price, $decimal);
		}

		$result = $theprice;

	} else {
		$result = false;
	}

	return $result;
}

function priceConvertCurrency($price = '0.00', $convertTo = ''){
	$the_pricing = '0.00';
	if(get_option('defaultcurrency') == $convertTo){
		$the_pricing = $price;
	} else {
		// get rate data currency
		$getval = getval("curRate,curForeignCurrencyToDefault","currency","curCode='{$convertTo}'");

		$the_pricing = $getval['curRate'] * $price;
	}

	return $the_pricing;
}

/**
 * Get weight unit default symbol
 * 
 * @param string $display
 * 
 * @return string
 */
function getWeightDefault($display = 'unit'){
	$unit = 'Kg';
	$title = 'Kilogram';
	$value = 1.00000000;
	$id = 0;

	if( countdata( 'unit_weight', array('weightDefault'=>'y') ) > 0 ){
		// get rate data currency
		$getval = getval("weightId,weightTitle,weightUnit,weightValue","unit_weight","weightDefault='y'");

		$unit = $getval['weightUnit'];
		$title = $getval['weightTitle'];
		$value = $getval['weightValue'];
		$id = $getval['weightId'];
	}

	if($display == 'unit'){
		$result = $unit;
	} 
	elseif($display == 'title'){
		$result = $title;
	}
	elseif($display == 'value'){
		$result = $value;
	}
	elseif($display == 'id'){
		$result = $id;
	}

	return $result;
}

function getLengthDefault($display = 'unit'){
	$unit = 'cm';
	$title = 'Centimeter';
	$value = 1.00000000;
	$id = 0;

	if( countdata( 'unit_length', array('lengthDefault'=>'y') ) > 0 ){
		// get rate data currency
		$getval = getval("lengthId,lengthTitle,lengthUnit,lengthValue","unit_length","lengthDefault='y'");

		$unit = $getval['lengthUnit'];
		$title = $getval['lengthTitle'];
		$value = $getval['lengthValue'];
		$id = $getval['lengthId'];
	}

	if($display == 'unit'){
		$result = $unit;
	} 
	elseif($display == 'title'){
		$result = $title;
	}
	elseif($display == 'value'){
		$result = $value;
	}
	elseif($display == 'id'){
		$result = $id;
	}

	return $result;
}

function getCountryDefault($display = 'name'){
	$codedefault = get_option('defaultcodecountry');

	if( countdata( 'geo_country', array('countryIsoCode3'=>$codedefault) ) > 0 ){
		// get rate data currency
		$getval = getval("countryId,countryName,countryIsoCode2,countryIsoCode3","geo_country","countryDeleted='0' AND countryIsoCode3='{$codedefault}'");

		$id = $getval['countryId'];
		$name = $getval['countryName'];
		$code2 = $getval['countryIsoCode2'];
		$code3 = $getval['countryIsoCode3'];
	}

	if($display == 'name'){
		$result = $name;
	} 
	elseif($display == 'id'){
		$result = $id;
	}
	elseif($display == 'code2'){
		$result = $code2;
	}
	elseif($display == 'code3'){
		$result = $code3;
	}

	return $result;
}

function orderInvoice(){
	// get invoice format
	$invformat = get_option('invoiceorderformat');
	$invstartnumber = get_option('invoiceordernumberstart');

	$DAY = date("d");
	$MONTH = date("m");
	$YEAR = date("Y");

	$NUMBER = 1;
	if(!empty($invstartnumber)){
		$NUMBER = $invstartnumber+1;
	}

	$invoice = str_ireplace("{DAY}", $DAY, $invformat);
	$invoice = str_ireplace("{MONTH}", $MONTH, $invoice);
	$invoice = str_ireplace("{YEAR}", $YEAR, $invoice);
	$invoice = str_ireplace("{NUMBER}", $NUMBER, $invoice);

	return $invoice;
}

/**
 * get tax status
 *
 * @return bool
 */
function taxStatus(){

	$statustax = get_option('taxstatus');

	if($statustax == 'y'){
		return true;
	} else {
		return false;
	}

}

/**
 * get tax value
 *
 * @return array
 */
function getGeneralTaxValue(){

	if(taxStatus()){

		$taxid = get_option('taxId');

		// get tax data
		$taxdata = getval('taxRate,taxType,taxActive', 'tax', array('taxId'=>$taxid));

		if($taxdata['taxActive']=='y'){

			return array('rate' => $taxdata['taxRate'], 'type' => $taxdata['taxType']);

		}

	}

	return false;
}

/**
 * count value with selected tax
 * 
 * @param double $value
 * @param int $taxid
 * 
 * @return double
 */
function countTax($value, $taxid){
	$result = 0;
	if(taxStatus() AND !empty($value) AND !empty($taxid)){

		$taxdata = getval('taxRate,taxType,taxActive', 'tax', array('taxId'=>$taxid));

		if($taxdata['taxActive']=='y'){

			if($taxdata['taxType'] == 'percentage'){
				$result = ($taxdata['taxRate'] / 100) * $value;
			} 
			elseif($taxdata['taxType'] == 'fixed') {
				$result = $taxdata['taxRate'];
			}

		}
		
	}
	return $result;
}

function getAttrUsed($productid){
	$ci =& get_instance();

	if(empty($productid)) return array();

	$prodid = esc_sql( filter_int($productid) );

	$whereprod = array('prodId'=>$prodid, 'prodDisplay'=>'y', 'prodDeleted'=>'0');
	$data = getval('*', 'product', $whereprod);

	$result = array();

	if( $data['prodType']=='configurableproduct' OR $data['prodType']=='downloadableproduct'){

		$countattravailable = countdata('product_attribute', array('prodId'=>$data['prodId']));						
		if( $countattravailable > 0){

			$tblatr = array('product_attribute a', 'product_attribute_combination b');
			$whereattr = "a.prodId='{$data['prodId']}' AND a.pattrId=b.pattrId";
			$attrdataused = $ci->Env_model->view_where_order("DISTINCT(b.attrId), b.attrId", $tblatr, $whereattr,'b.attrId','ASC');
			$n = 0;
			foreach($attrdataused AS $value){
				$attrlabel = getval('attrLabel','attribute', array('attrId'=>$value['attrId']));
				$result[$value['attrId']] = $attrlabel;

				$n++;
			}
		}

	}

	return $result;
}

function getAttrValueUsed($productid, $attrid=null){
	$ci =& get_instance();

	if(empty($productid)) return array();

	$prodid = esc_sql( filter_int($productid) );

	$whereprod = array('prodId'=>$prodid, 'prodDisplay'=>'y', 'prodDeleted'=>'0');
	$data = getval('*', 'product', $whereprod);

	$result = array();

	if( $data['prodType']=='configurableproduct' OR $data['prodType']=='downloadableproduct'){

		$countattravailable = countdata('product_attribute', array('prodId'=>$data['prodId']));						
		if( $countattravailable > 0){

			$tblatr = array('product_attribute a', 'product_attribute_combination b');

			$wherewithattrid = ( $attrid!=null) ? " AND b.attrId='".esc_sql( filter_int($attrid))."'":"";
			$whereattr = "a.prodId='{$data['prodId']}' AND a.pattrId=b.pattrId";
			$attrdataused = $ci->Env_model->view_where_order("DISTINCT(b.attrvalId), b.attrvalId", $tblatr, $whereattr.$wherewithattrid,'b.attrvalId','ASC');

			// get default atttr val
			$defaultdata = $ci->Env_model->view_where_order("b.attrvalId", $tblatr, $whereattr." AND a.pattrDefault='y'",'b.attrvalId','ASC');
			$default = array();
			foreach($defaultdata as $rdef){
				$default[] = $rdef['attrvalId'];
			}

			$n = 0;
			foreach($attrdataused AS $value){

				$attrValueData = getval('attrId,attrvalVisual,attrvalValue,attrvalLabel','attribute_value', array('attrvalId'=>$value['attrvalId']));
				$attrValueData['default'] = ( in_array( $value['attrvalId'], $default) ) ? true:false;
				$result[$value['attrvalId']] = $attrValueData;				

				$n++;
			}
		}

	}

	return $result;
}

function getDefaultAttrValue(){
	
}
