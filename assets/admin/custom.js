$(document).ready(function() {
    $('.shiza_tooltip').tooltip();

    $('input.custom-file-input').change(function(e){
        var fileName = e.target.files[0].name;
        $(this).next('.custom-file-label').html(fileName);
    });
});

/**
 * function js start here
 */

// decimal with comma
function isNumberComma(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode == 44) {
        return true;
    } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }
}

// only integer value
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

// for counting discount in field
function countingDiffPrice(harga1,harga2,printke,ket1,ket_salah){
    $(function (){
        var harga_1 = harga1;
        var harga_2 = harga2;

        // hitung harga
        var persen = (harga_2 / harga_1) * 100;

        if(persen > 100){
            var cetak = '<span class="text-danger">'+ket_salah+'</span>';
        } else {
            if(persen){
                var selisih = 100 - persen;
                var cetak = selisih + '%';
            } else {
                var cetak = '0%';
            }
        }

        $(printke).html( ket1 + cetak);
    });
}

function numberFormat(value, dec=2, comma=',', sep='.') {
    var parts = value.toFixed(dec).split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, sep);
    return parts.join(comma);
}

function generatedCode(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
       result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
