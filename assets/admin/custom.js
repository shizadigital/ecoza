$(document).ready(function() {
    $('.shiza_tooltip').tooltip();
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