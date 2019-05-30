$(document).ready(function(){
    var basePath= $("#basepath").val();
    $('#totalDueThisMonthList').on('click',function(){
        $.ajax({        
            type: "POST",
            url: basePath + 'dashboard/ListofDueThisMonthList',
            dataType: "html",
            //contentType:"application/x-www-form-urlencoded; charset=UTF-8",
            success: function(result) {
                $("#DetailList").html(result)
            },
            error: function(jqXHR, exception) {
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
                // alert(msg);  
            }
        });        
    }); // ajax call end


    
}); // document ready end

function OpenStudentList(id) {
    var basePath= $("#basepath").val();
    // alert(id);
    $.ajax({        
        type: "POST",
        url: basePath + 'dashboard/groupByList',
        data:{'viewname':id},
        dataType: "html",
        //contentType:"application/x-www-form-urlencoded; charset=UTF-8",
        success: function(result) {
            $("#DetailList").html(result)
        },
        error: function(jqXHR, exception) {
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
            // alert(msg);  
        }
    });
}


