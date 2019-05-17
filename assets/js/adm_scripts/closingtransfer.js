$(document).ready(function () {
    var basepath = $("#basepath").val();
    // var acnt_dt_start=$('#acnt_dt_start').val();
    // var acnt_dt_end=$('#acnt_dt_end').val();

     
    $("#ClosingBlanceTransfer").click(function () {
        var formDataserialize = $("#closingtransfer").serialize();
        // var fromYearId = $("#fromYearId").val();
        // var toYearId = $("#toYearId").val();
        $("#ClosingBlanceTransfer").hide();
        $("#transferLoader").show();       
        $("#loader").show();
        $.ajax({
            type: "POST",
            url: basepath + 'Closingblancetransfer/transferclosing',
            dataType: "html",
            //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: formDataserialize,
            success: function (result) {
                $("#datadiv").html(result);
                $("#loader").hide();
                $("#ClosingBlanceTransfer").show();
                $("#transferLoader").hide();       

            }, error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                alert(msg);
            }


        });

    });

   
});