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