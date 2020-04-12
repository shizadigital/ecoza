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

function digitFormat($angka, $decimal = 2){
	$return=number_format($angka,$decimal,',','.');
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
function getWeightUnitDefault($display = 'unit'){
	$unit = 'Kg';
	$title = 'Kilogram';
	$value = 1.00000000;

	if( countdata( 'unit_weight', array('weightDefault'=>'y') ) > 0 ){
		// get rate data currency
		$getval = getval("weightTitle,weightUnit,weightValue","unit_weight","weightDefault='y'");

		$unit = $getval['weightUnit'];
		$title = $getval['weightTitle'];
		$value = $getval['weightValue'];
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

	return $result;
}

function orderInvoice(){
	// get invoice format
	$invformat = get_option('invoiceformat');
	$invstartnumber = get_option('invoicenumberstart');

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