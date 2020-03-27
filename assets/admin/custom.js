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

// FORM SUBMIT VALIDATED
function ajaxSubmit(formId){
    $(formId).on('submit',function(){
        var form = $(this);
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function(data){
                form.find('input[type=submit]').attr('disabled','disabled');
                form.find('input[type=submit]').addClass('btn-disabled');
                form.find('button[type=submit]').attr('disabled','disabled');
                form.find('button[type=submit]').addClass('btn-disabled');
                $('#loading_ajax').show();
            },
            success: function(data) {
                if(data){
                    data = data.trim();
                    if(
                        data.slice(0,38)=='<script type="text/javascript">window.location.href' || 
                        data.slice(0,28)=='<script>window.location.href'
                    ){
                        $('#result_ajax').html(data);
                    }else{
                        var splitdata = data.split('|');

                        if(
                            splitdata[0]=='default' || 
                            splitdata[0]=='primary' || 
                            splitdata[0]=='secondary' || 
                            splitdata[0]=='success' || 
                            splitdata[0]=='warning' || 
                            splitdata[0]=='danger' || 
                            splitdata[0]=='info' || 
                            splitdata[0]=='light' || 
                            splitdata[0]=='dark' 
                        ){
                            $.notify(
                                {
                                    title: '<strong>'+splitdata[1]+'</strong>',
                                    message: splitdata[2],
                                },
                                {
                                    type: splitdata[0],
                                    placement: {
                                        align: 'center',
                                    },
                                },
                            );
                        } else {
                            $('#result_ajax').html(data);
                        }
                        $('#loading_ajax').hide();
                    }
                }
                form.find('input[type=submit]').removeAttr('disabled');
                form.find('input[type=submit]').removeClass('btn-disabled');
                form.find('button[type=submit]').removeAttr('disabled');
                form.find('button[type=submit]').removeClass('btn-disabled');
            }
        }).fail(function( e ) {
            $.notify(
                {
                    title: '<strong>ERROR</strong>',
                    message: 'Process Failed',
                },
                {
                    type: 'danger',
                    placement: {
                        align: 'center',
                    },
                },
            );
            form.find('input[type=submit]').removeAttr('disabled');
            form.find('input[type=submit]').removeClass('btn-disabled');
            form.find('button[type=submit]').removeAttr('disabled');
            form.find('button[type=submit]').removeClass('btn-disabled');

            $('#loading_ajax').delay( 800 ).fadeOut( 'slow' );
        });
        return false;
    });
}