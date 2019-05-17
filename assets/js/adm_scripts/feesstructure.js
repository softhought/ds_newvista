$(document).ready(function(){
   
	var basepath = $("#basepath").val();
	$("#caste").focus();
	
	$(document).on('submit','#feesStructureForm',function(e){
		e.preventDefault();
		
		if(validate())
		{
			
		
            var formDataserialize = $("#feesStructureForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'feesstructure/feesStructure_action';
            $("#feescomavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'block');

            $.ajax({
                type: type,
                url: urlpath,
                data: formData,
                dataType: 'json',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                success: function(result) {
					if (result.msg_status == 200) {
							
                        $("#suceessmodal").modal({
                            "backdrop": "static",
                            "keyboard": true,
                            "show": true
                        });
                        var addurl = basepath + "feesstructure/addFeesStructure";
                        var listurl = basepath + "feesstructure";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#feescom_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#feescomavebtn").css({
                        "display": "block",
                        "margin": "0 auto"
                    });
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                }
            });
			
			
		}

	});
	
	
    /* On select Class  select fees */
    $(document).on("change", "#classid", function() {
        var val=$('select[name=classid]').val();

    
        $.ajax({
        type: "POST",
        url: basepath+'feesstructure/getFeesList',
        data: {classid:val},

        success: function(data){
            $("#fees_dropdown").html(data);
            $('.selectpicker').selectpicker();
        },
        error: function (jqXHR, exception) {
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

        });/*end ajax call*/

    });

    $('.deleteBtn').click(function() {
        var splitid=$(this).attr("id").split('_');
        var id=splitid[1];
        var fees_id= $('#deleteBtn_'+id).data('text');      
        // alert(fees_id); 
        $.ajax({
            type: 'POST',
            url: basepath+'feesstructure/deleteFeesStructure',
            data: {fees_id:fees_id},
            dataType: 'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            success: function(result) {
                if (result.msg_status == 200) {                 
                     
                    $("#modal-success").modal({
                        "backdrop": "static",
                        "keyboard": true,
                        "show": true
                    });
                    var addurl = basepath + "feesstructure";
                   
                    $("#appendBody").text(result.msg_data);
                    $("#redirectToListsuccess").attr("href", addurl);

                } 
                else {
                    // alert(fees_id+" have data");                    
                    $("#modal-danger").modal({
                        "backdrop": "static",
                        "keyboard": true,
                        "show": true
                    });
                    var addurl = basepath + "feesstructure";
                   
                    $("#dengAppendBody").text(result.msg_data);
                    $("#redirectToListerror").attr("href", addurl);
                   
                    
                }                
                
            },
            error: function(jqXHR, exception) {
                var msg = '';
            }
        });
       
    });
	

});/* end of document ready */

function validate()
{  
	var classid = $("#classid").val();
	var feesid = $("#feesid").val();
	var amount = $("#amount").val();
	$("#feescommsg").text("").css("dispaly", "none").removeClass("form_error");
	if(classid=="0")
	{
		$("#classid").focus();
		$("#feesstrmsg")
		.text("Error : Select Class")
		.addClass("form_error")
        .css("display", "block");
		return false;
    }
    
    if(feesid=="0")
	{
		$("#feesid").focus();
		$("#feesstrmsg")
		.text("Error : Select Fees")
		.addClass("form_error")
        .css("display", "block");
		return false;
    }
    
    if(amount=="")
	{
		$("#amount").focus();
		$("#feesstrmsg")
		.text("Error : Enter Amount")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}
	return true;
}
// <?php echo base_url(); ?>feesstructure/deleteFeesStructure/
// function deleteFeesStructure()
// {
//     var id=$(this).data('text');
//     alert(this.href);
// }