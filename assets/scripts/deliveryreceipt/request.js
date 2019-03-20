/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var row = 1;
var file = 1;

$(document).ready(function () 
{

	DeliveryReceipt.load_attention();

	// DATE PICKER
		$("#txtRequestDate").datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'
		});
		$("#txtRequestDate").datepicker('setDate', new Date());

	// REMOVE
		$(document).on('click', '.btnRemove', function(){  
	    	var row = $(this).attr("id");   
	    	$('#rowCount' + row + '').remove();  
	    	row--;
	    });

	    $(document).on('click', '.btnRemoveFile', function(){  
	    	var file = $(this).attr("id");   
	    	$('#rowCountFile' + file + '').remove();  
	    	file--;
	    });

	// SUBMIT
	    $(document).on('submit', '#drForm', function(){

	    	event.preventDefault();

	    	if((row != 1 || file != 1) && $('#txtRequestAttention').val() != null)
	    	{
		    	if(confirm("All data are correct?"))
		    	{
		    		$.ajax({
			            type : "POST",
			            url : '../../../application/model/Deliveryreceipt_m2.php?action=insertIDR',
			            data : new FormData(this),
			            contentType:false,
			            processData:false,
			            dataType : "json",
			            success: function (result)
			            {
							alertify.success('Data Successfully Added!');
							DeliveryReceipt.auto_email(result, $('#txtRequestAttention').val() );
							DeliveryReceipt.clear();
			            },
			            error: function (xhr, status, errorThrown) 
			            {
			                console.log(xhr.responseText);
			            }

			          });
		    	}
	    	}
	    	else
	    	{
	    		alertify.error('Please provide atleast one request or select attention name!');
	    	}
	    });

});

//THIS IS THE CLASS
var DeliveryReceipt = (function ()
{
	// ALERTIFY 
		alertify.set('notifier','position', 'top-right');
		// alertify.success('Success message');
		// alertify.error('Success message');
		// alertify.warning('Success message');
		// alertify.info('Success message');

	//PUBLIC OBJECT TO BE RETURNED
	var this_DeliveryReceipt = {};

	this_DeliveryReceipt.add_row = function ()
	{
		if(row < 20)
		{
			$('#dynamic_drtrable').append('<tr id="rowCount' + row + '"><td><input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtPartNo" name="txtPartNo[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtRev" name="txtRev[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="number" class="form-control" style="border-radius: 50px; text-align: center;" id="txtQty" name="txtQty[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtSupplier" name="txtSupplier[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtDR" name="txtDR[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtRemarks" name="txtRemarks[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><button type="button" id="' + row + '" name="btnRemove" class="btn btn-danger pull-left btnRemove" data-toggle="tooltip" title="Remove"><i class="fa fa-minus"></i></button></td></tr>');
			row++;
		}
		else
		{
			alertify.error('Already reach maximum details');
		}
	};

	this_DeliveryReceipt.add_attachment = function ()
	{
		if(file < 10)
		{
			$('#dynamic_dr_attachment').append('<tr id="rowCountFile' + file + '"><td><input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtDescription" name="txtDescription[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="file" class="form-control" id="txtFile" name="txtFile[]" /></td><td><center><button type="button" id="' + file + '" name="btnRemoveFile" class="btn btn-danger pull-left btnRemoveFile" data-toggle="tooltip" title="Remove"><i class="fa fa-minus"></i></button></center></td></tr>');
			file++;
		}
		else
		{
			alertify.error('Already reach maximum details');
		}
	};

	this_DeliveryReceipt.clear = function ()
	{
		$('#drForm')[0].reset();
		$("#txtRequestDate").datepicker('setDate', new Date());
		this_DeliveryReceipt.clear_row();
	};

	this_DeliveryReceipt.clear_row = function ()
	{
		row = 1;
		var rowCount = document.getElementById("dynamic_drtrable").rows.length;

		for(var a = 1; a < rowCount; a++)
		{
			$('#rowCount' + a + '').remove(); 
	    }

	    file = 1;
		var rowCountFile = document.getElementById("dynamic_dr_attachment").rows.length;

		for(var a = 1; a < rowCountFile; a++)
		{
			$('#rowCountFile' + a + '').remove(); 
	    }
	};

	this_DeliveryReceipt.auto_email = function (id, email)
	{
		$.ajax({
            url : '../../../assets/email/email_idr_request.php',
            method : "POST",
            data :
            {
            	id : id,
            	rawdata : email
            },
            dataType : "json",
            success: function (result)
            {
            	alertify.success('Email Sent!');
            },
            error: function (xhr, status, errorThrown) 
            {
                console.log(xhr.responseText);
            }

          });
	};

	this_DeliveryReceipt.load_attention = function()
	{

		$.ajax({
            url : base_url + 'Deliveryreceipt.php?action=load_attention',
            method : "POST",
            dataType : "json",
            success: function (data)
            {
            	$.each(data, function ()
				{
					$('#txtRequestAttention').append('<option value="' + this.employee_email + "/" + this.employee_group + '">' + this.employee_name + '</option>');
				});
            },
            error: function (xhr, status, errorThrown) 
            {
                console.log(xhr.responseText);
            }

          });
	};

	return this_DeliveryReceipt;

})();
//END THIS IS THE CLASS