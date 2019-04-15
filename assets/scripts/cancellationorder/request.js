/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 var row = 1;

$(document).ready(function () 
{	
	$('#div_upload1').hide();
	$('#div_upload2').hide();
	$('#div_upload3').hide();

	// DATE PICKER
		$("#txtRequestDate").datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'
		});
		$("#txtRequestDate").datepicker('setDate', new Date());

	// REMOVE
		$(document).on('click', '.btnRemove', function(){  
	    	var id = $(this).attr("id");   
	    	$('#row_' + id + '').remove();  
	    	row--;
	    });

	// SUBMIT
		$(document).on('submit', '#manualForm', function(){

			event.preventDefault();

			var supplier = $('#txtRequestSupplier').val();
			var type = $('#txtRequestType').val();

			$('#generate_code').val(Cancellationorder.generate_code());

			if(supplier != '' && type != null && row != 1)
			{
				if(confirm("All data are correct?"))
				{
					Cancellationorder.run_waitMe("loading_manual");

					$.ajax({
			            type : "POST",
			            url : '../../../application/model/Cancellationorder_m2.php?action=insert_manual',
			            data : new FormData(this),
			            contentType:false,
			            processData:false,
			            dataType : "json",
			            success: function (result)
			            {
							$('.loading_manual').waitMe("hide");
							alertify.success('Data Successfully Added!');
							alertify.success('Control no: ' + result[0]);
							Cancellationorder.auto_email(result[1], result[2]);
							Cancellationorder.clear();
			            },
			            error: function (xhr, status, errorThrown) 
			            {
			                console.log(xhr.responseText);
			            }

			          });
				}
			}
			else
				alertify.error('Please complete the details!');
		});

});

//THIS IS THE CLASS
var Cancellationorder = (function ()
{
	// ALERTIFY 
		alertify.set('notifier','position', 'top-right');
		// alertify.success('Success message');
		// alertify.error('Success message');
		// alertify.warning('Success message');
		// alertify.info('Success message');

	//PUBLIC OBJECT TO BE RETURNED
	var this_Cancellationorder = {};

	this_Cancellationorder.add_row = function()
	{
		if(row < 16)
		{
			$('#dynamic_rstable').append(
				'<tr id="row_' + row + '" style="vertical-align: center;"><td><input type="text" class="form-control round" id="txt_partno" name="txt_partno[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control round" id="txt_rev" name="txt_rev[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="number" class="form-control round" id="txt_qty" name="txt_qty[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control round" id="txt_pono" name="txt_pono[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control round" id="txt_pocode" name="txt_pocode[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control round" id="txt_receiptno" name="txt_receiptno[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control round" id="txt_prodorder" name="txt_prodorder[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><input type="text" class="form-control round" id="txt_deliverydate" name="txt_deliverydate[]" onkeyup="this.value = this.value.toUpperCase()" /></td><td><center><input type="radio" value="OK" name="questionaire' + row + '" class="radioBtnClass' + row + '" style="transform: scale(2);"></input></center></td><td><center><input type="radio" value="NG" name="questionaire' + row + '" class="radioBtnClass' + row + '" style="transform: scale(2);"></input></center></td><td><textarea class="form-control" style="border-radius: 50px;" id="txt_reason" name="txt_reason[]" onkeyup="this.value = this.value.toUpperCase()"></textarea></td><td><center><button type="button" id="' + row + '" name="btnRemove" class="btn btn-danger pull-left btnRemove" data-toggle="tooltip" title="Remove"><i class="fa fa-minus"></i></button></center></td></tr>');
			row++;
		}
		else
		{
			alertify.error('Already reach maximum details');
		}
	};

	this_Cancellationorder.show_manual = function()
	{
		$('#div_manual1').show();
		$('#div_manual2').show('animated fadeInLeft');
		$('#div_manual3').show();

		$('#div_upload1').hide();
		$('#div_upload2').hide('animated fadeOutLeft');
		$('#div_upload3').hide();
	};

	this_Cancellationorder.show_upload = function()
	{
		$('#div_manual1').hide();
		$('#div_manual2').hide('animated fadeOutLeft');
		$('#div_manual3').hide();

		$('#div_upload1').show();
		$('#div_upload2').show('animated fadeInLeft');
		$('#div_upload3').show();
	};

	this_Cancellationorder.clear = function()
	{
		$('#manualForm')[0].reset();
		$("#txtRequestDate").datepicker('setDate', new Date());
		$('#dynamic_rstable tbody').empty();
		row = 1;
	};

	this_Cancellationorder.run_waitMe = function(classname)
	{
		$('.' + classname).waitMe({

		//none, rotateplane, stretch, orbit, roundBounce, win8, 
		//win8_linear, ios, facebook, rotation, timer, pulse, 
		//progressBar, bouncePulse or img
		effect: 'progressBar',

		//place text under the effect (string).
		text: 'Please waiting...',

		//background for container (string).
		bg: 'rgba(255,255,255,0.7)',

		//color for background animation and text (string).
		color: '#e22b4c',

		//max size
		maxSize: 'Please waiting',

		//wait time im ms to close
		waitTime: -1,

		//url to image
		source: '',

		//or 'horizontal'
		textPos: 'vertical',

		//font size
		fontSize: '20',

		// callback
		onClose: function() {}

		});
	};

	this_Cancellationorder.generate_code = 	function()
	{
		var temppass = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		for (var i = 0; i < 30; i++)
		{
			temppass += possible.charAt(Math.floor(Math.random() * possible.length));
		}
		return temppass;
	};

	this_Cancellationorder.download = function()
	{

		window.location = "../../../assets/forms/request_slip_form.xls";
	};

	this_Cancellationorder.upload = function()
	{
		if($("#file_upload").val() != '')
		{
			var dataForm = new FormData();
					
			 dataForm.append('filesssss', $("#file_upload").prop('files')[0]);
			 dataForm.append('session_id', $('#session_id').val());
			 dataForm.append('generate_code', Cancellationorder.generate_code());
			 dataForm.append('session_section', $('#session_section').val());
			 dataForm.append('txtAttachment', $("#txtAttachment_upload").prop('files')[0]);
			 

			 Cancellationorder.run_waitMe("loading_upload");

			 $.ajax({
					type: 'POST',
					url: '../../../application/model/Cancellationorder_m2.php?action=upload',
					data: dataForm,
					contentType: false,
		        	processData: false,
		        	method: 'POST',
					dataType: "json",
					cache: false,
					success: function (result)
					{

						$('.loading_upload').waitMe("hide");
						alertify.success('Data Successfully Added!');
						alertify.success('Control no: ' + result[0]);
						Cancellationorder.auto_email(result[1], result[2]);

						$("#file_upload").val('');
						$("#txtAttachment_upload").val('');
						$('#txtRequestSupplier_upload').val('');
						$('#txtRequestType_upload').val('CHOOSE');
					},
					error: function(data)
					{
						console.log(data);
					}
				});
		}
		else
		{
			alertify.error("Please select file!");
		}
	};

	this_Cancellationorder.auto_email = function(type, generate_code)
	{
		$.ajax({
            url : '../../../assets/email/email_icos.php',
            method : "POST",
            data :
            {
            	type : type,
            	generate_code : generate_code,
            	section : $('#session_section').val()
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

	return this_Cancellationorder;

})();
//END THIS IS THE CLASS