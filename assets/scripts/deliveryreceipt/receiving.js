/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var realtime_count = 0;
var realtime_count_temp = 0;

$(document).ready(function () 
{
	DeliveryReceipt.loadreceiving();

	// SUBMIT
		$(document).on('submit', '#modalReceiveForm', function(){
			event.preventDefault();

			if(confirm("This action cannot be undo. Are you sure to continue ?"))
			{
				$.ajax({
			            type : "POST",
			            url : '../../../application/model/Deliveryreceipt_m2.php?action=updateIDR',
			            data : new FormData(this),
			            contentType:false,
			            processData:false,
			            dataType : "json",
			            success: function (result)
			            {
			            	alertify.success('Data Successfully Received!');
			              	$("#modalReceive").iziModal('close');
			              	DeliveryReceipt.loadreceiving();
			              	
			              	DeliveryReceipt.auto_email(result);
			            },
			            error: function (xhr, status, errorThrown) 
			            {
			                console.log(xhr.responseText);
			                alertify.error('Please input actual count!');
			            }

			          });
			}

		});

	setInterval(function(){ DeliveryReceipt.realtime(); }, 3000);

});

//THIS IS THE CLASS
var DeliveryReceipt  = (function ()
{
	// ALERTIFY 
		alertify.set('notifier','position', 'top-right');
		// alertify.success('Success message');
		// alertify.error('Success message');
		// alertify.warning('Success message');
		// alertify.info('Success message');

	//PUBLIC OBJECT TO BE RETURNED
	var this_DeliveryReceipt = {};
	var monitoring_id = '';
	var return_id = '';

	this_DeliveryReceipt.realtime = function()
	{
		$.ajax({
			type: 'POST',
			url: base_url + 'Deliveryreceipt.php?action=load_data',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				realtime_count_temp = 0;

				$.each(data, function ()
				{
					realtime_count_temp++;
				});
			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});

		if(realtime_count != realtime_count_temp)
		{
			this_DeliveryReceipt.loadreceiving();
			realtime_count = realtime_count_temp;
		}
	};

	this_DeliveryReceipt.loadreceiving = function ()
	{
		$.ajax({
			type: 'POST',
			url: base_url + 'Deliveryreceipt.php?action=load_data',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#tblReceiving').DataTable().destroy();

				realtime_count = 0;

				var tr = "";
				$.each(data, function ()
				{
					tr +=
							"<tr align='center'>" +
							"<td>" +
								"<button class='btn btn-info btn-sm' onclick='DeliveryReceipt.receive(" + this.id + ");' data-toggle='tooltip' title='View'><i class='fas fa-edit'></i></button> " +
								"<button class='btn btn-danger btn-sm' onclick='DeliveryReceipt.return(" + this.id + ");' data-toggle='tooltip' title='Return'><i class='fas fa-undo-alt'></i></button> " +
							"</td>" +
							"<td>" + this.request_date + "</td>" +
							"<td>" + this.control_no + "</td>" +
							"<td>" + this.status + "</td>" +
							"</tr>";
					realtime_count++;
				});
				$("#tblReceiving tbody").html(tr);
				$('#tblReceiving').DataTable();

			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_DeliveryReceipt.receive = function (id)
	{
		monitoring_id = id;

		// MODAL
			$('#modalReceive').attr('hidden', false);

			$('#modalReceive').iziModal('destroy');
			$("#modalReceive").iziModal({
				subtitle: 'Quality Control',
				width: 1500,
				padding: 10,
				overlay: true,
				top: 70
			});
			$("#modalReceive").iziModal('open');

		// DATATABLE

			// DETAILS
				this_DeliveryReceipt.reload_details(monitoring_id);

			// ATTACHMENTS
				$.ajax({
					type: 'POST',
					url: base_url + 'Deliveryreceipt.php?action=load_data_attachment',
					data:
					{
						id	: id,
					},
					dataType: 'json',
					cache: false,
					success: function (data)
					{
						$('#tblAttachments').DataTable().destroy();

						var tr = "";
						$.each(data, function ()
						{
							tr +=
							"<tr align='center'>" +
							"<td>" + this.filename + "</td>" +
							"<td>" +
								'<a href="../' + this.location + '" target="_blank">Click Me </a>' +
							"</td>" +
							"</tr>";
						});

						$("#tblAttachments tbody").html(tr);
					},
					error: function(jqXHR, errorStatus, errorThrown) 
		            {
		              console.log(errorStatus, errorThrown);
		            }
				});
	};

	this_DeliveryReceipt.reload_details = function (id)
	{
		$.ajax({
			type: 'POST',
			url: base_url + 'Deliveryreceipt.php?action=load_data_details',
			data:
			{
				id	: id,
			},
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#tblActualReceiving').DataTable().destroy();

				var tr = "";
				$.each(data, function ()
				{
					tr +=
						"<tr align='center'>" +
						"<td>" +
							"<input type='text' class='form-control' style='text-align: center; width: 50%;' id='txtId' name='txtId[]' value='" + this.id + "' readonly />" +
						"</td>" + 
						"<td>" + this.part_no + "</td>" + 
						"<td>" + this.rev + "</td>" + 
						"<td>" +
							"<input type='number' class='form-control' style='text-align: center; width: 50%;' id='txtQty' name='txtQty[]' value='" + this.qty + "' readonly />" +
						"</td>" +
						"<td>" +
							"<input type='number' class='form-control' style='text-align: center; width: 50%;' id='txtActual' name='txtActual[]' value='" + this.qty + "' />" +
						"</td>" +
						"<td>" +
						"<button class='btn btn-danger btn-sm' id='" + this.id + "' onclick='DeliveryReceipt.removeitem(" + this.id + ");' data-toggle='tooltip' title='Remove'><i class='fas fa-trash-alt'></i></button> " +
						"</td>" +
						"</tr>";
				});

				$("#tblActualReceiving tbody").html(tr);

				$('#txtIdModal').val(id);
			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_DeliveryReceipt.return = function (id)
	{
		return_id = id;
		// MODAL
			$('#modalReturn').attr('hidden', false);

			$('#modalReturn').iziModal('destroy');
			$("#modalReturn").iziModal({
				subtitle: 'Quality Control',
				width: 1500,
				padding: 10,
				overlay: true,
				top: 70
			});
			$("#modalReturn").iziModal('open');
	};

	this_DeliveryReceipt.removeitem = function (id)
	{
		event.preventDefault();

		if(confirm("This action cannot be undo. Are you sure to continue ?"))
		{
			$.ajax({
				type: 'POST',
				url: base_url + 'Deliveryreceipt.php?action=remove_receiving_item',
				cache: false,
				data:
				{
					id : id
				},
				success: function (data)
				{
					this_DeliveryReceipt.reload_details(monitoring_id);
					alertify.success('Successfully Removed!');
				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }
			});
		}
	};

	this_DeliveryReceipt.btnreturn = function ()
	{
		if($('#txtDetails').val() != '')
		{
			if(confirm("This action cannot be undo. Are you sure to continue ?"))
			{

				$.ajax({
					type: 'POST',
					url: base_url + 'Deliveryreceipt.php?action=remove_receiving',
					cache: false,
					data:
					{
						id	: return_id,
						reason : $('#txtDetails').val(),
						return_by : $('#txtReturnName').val()
					},
					success: function (data)
					{
						alertify.success('Data Successfully Returned!');
						$("#modalReturn").iziModal('close');
						
						// this_DeliveryReceipt.auto_email(return_id);
						
						this_DeliveryReceipt.loadreceiving();
					},
					error: function(jqXHR, errorStatus, errorThrown) 
		            {
		              console.log(errorStatus, errorThrown);
		            }
				});
			}
		}
		else
		{
			alertify.error('Please provide detailed reason!');
		}
	};

	this_DeliveryReceipt.auto_email = function (id)
	{
		$.ajax({
            url : '../../../assets/email/email_idr_receive.php',
            method : "POST",
            data :
            {
            	id : id
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

	return this_DeliveryReceipt;

})();
//END THIS IS THE CLASS