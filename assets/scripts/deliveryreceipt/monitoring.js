/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var realtime_count = 0;
var realtime_count_temp = 0;

var realtime_count_request = 0;
var realtime_count_temp_request = 0;

$(document).ready(function () 
{
	DeliveryReceipt.loadmonitoring();
	DeliveryReceipt.loadmonitoringrequest();
	$('#divMonitoringRequest').hide();
	$('#btnChoose').text("CONTROL NUMBER");

	setInterval(function(){ DeliveryReceipt.realtime(); }, 3000);
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

	this_DeliveryReceipt.realtime = function()
	{
		// CONTROL NO
			$.ajax({
				type: 'POST',
				url: base_url + 'Deliveryreceipt.php?action=load_monitoring',
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
				this_DeliveryReceipt.loadmonitoring();
				realtime_count = realtime_count_temp;
			}


		// PART NO
			$.ajax({
				type: 'POST',
				url: base_url + 'Deliveryreceipt.php?action=load_monitoringrequest',
				dataType: 'json',
				cache: false,
				success: function (data)
				{
					realtime_count_temp_request = 0;

					$.each(data, function ()
					{
						realtime_count_temp_request++;
					});
				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }
			});

			if(realtime_count_request != realtime_count_temp_request)
			{
				this_DeliveryReceipt.loadmonitoringrequest();
				realtime_count_request = realtime_count_temp_request;
			}
	};

	this_DeliveryReceipt.loadmonitoring = function ()
	{

		$.ajax({
			type: 'POST',
			url: base_url + 'Deliveryreceipt.php?action=load_monitoring',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#tblMonitoring').DataTable().destroy();

				var tr = "";

				$.each(data, function ()
				{
					var button = "";
					switch(this.status)
					{

						case "FOR RECEIVING": 
							button = "<button class='btn btn-success btn-sm text-white' onclick='DeliveryReceipt.receive(" + this.id + ");' data-toggle='tooltip' title='FOR RECEIVING'><i class='fas fa-spinner fa-spin'></i></button> ";
							break;

						case "RETURNED":
							button = "<button class='btn btn-danger btn-sm text-white' onclick='DeliveryReceipt.return(" + this.id + ");' data-toggle='tooltip' title='RETURNED'><i class='fas fa-undo'></i></button> <button class='btn btn-warning btn-sm text-white' onclick='DeliveryReceipt.reapply(" + this.id + ");' data-toggle='tooltip' title='RE-APPLY'><i class='fas fa-user-shield'></i></button>";
							break;

						case "RECEIVED":
							button = "<button class='btn btn-success btn-sm text-white' onclick='DeliveryReceipt.receive(" + this.id + ");' data-toggle='tooltip' title='RECEIVED'><i class='fas fa-truck'></i></button> ";
							break;

						case "RECEIVED WITH DISCREPANCY":
							button = "<button class='btn btn-danger btn-sm text-white' onclick='DeliveryReceipt.receive(" + this.id + ");' data-toggle='tooltip' title='RECEIVED WITH DISCREPANCY'>* <i class='fas fa-truck'></i></button> ";
							break;
					}

					if(this.status != "CANCELLED")
					{
						button += "<button class='btn btn-warning btn-sm text-white' onclick='DeliveryReceipt.cancel_request(" + this.id + ");' data-toggle='tooltip' title='CANCEL'><i class='fas fa-bell-slash'></i></button>";
					}
					else
					{
						button += "<button class='btn btn-warning btn-sm text-white' onclick='DeliveryReceipt.cancel_view(" + this.id + ");' data-toggle='tooltip' title='CANCEL'><i class='fas fa-bell-slash'></i></button>";
					}

					var request_date = '';
					var received_date = '';

					(this.request_date == null) ? request_date = '' : request_date = this.request_date;
					(this.received_date == null) ? received_date = '' : received_date = this.received_date;

					tr +=
							"<tr align='center'>" +
							"<td>" + button + "</td>" +
							"<td>" + this.employee_no + "<br/>" + request_date + "</td>" +
							"<td>" + this.employee_name + "<br/>" + received_date + "</td>" +
							"<td>" + this.control_no + "</td>" +
							"<td>" + this.status + "</td>" +
							"</tr>";
				});
				
				$("#tblMonitoring tbody").html(tr);
				$('#tblMonitoring').DataTable();

			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_DeliveryReceipt.loadmonitoringrequest = function ()
	{

		$.ajax({
			type: 'POST',
			url: base_url + 'Deliveryreceipt.php?action=load_monitoringrequest',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#tblMonitoringRequest').DataTable().destroy();

				var tr = "";
				var final = [];

				$.each(data, function ()
				{
					var button = "";
					switch(this.status)
					{

						case "WAITING": 
							button = "<button class='btn btn-success btn-sm text-white' onclick='DeliveryReceipt.waiting();' data-toggle='tooltip' title='FOR RECEIVING'><i class='fas fa-spinner fa-spin'></i></button> ";
							break;

						case "NOT RECEIVED":
							button = "<button class='btn btn-danger btn-sm text-white' onclick='DeliveryReceipt.notreceived();' data-toggle='tooltip' title='NOT RECEIVED'><i class='fas fa-minus'></i></button> ";
							break;

						case "RECEIVED":
							button = "<button class='btn btn-success btn-sm text-white' onclick='DeliveryReceipt.receiverequest(" + this.id + ");' data-toggle='tooltip' title='RECEIVED'><i class='fas fa-truck'></i></button> ";
							break;

						case "RECEIVED WITH DISCREPANCY":
							button = "<button class='btn btn-danger btn-sm text-white' onclick='DeliveryReceipt.receiverequest(" + this.id + ");' data-toggle='tooltip' title='RECEIVED WITH DISCREPANCY'>* <i class='fas fa-truck'></i></button> ";
							break;
					}

					if(this.status == "CANCELLED")
					{
						button += "<button class='btn btn-warning btn-sm text-white' onclick='DeliveryReceipt.cancel_view(" + this.id + ");' data-toggle='tooltip' title='CANCEL'><i class='fas fa-bell-slash'></i></button>";
					}

					var temp = [];

					temp.push(button);
					temp.push(this.control_no);
					temp.push(this.part_no);
					temp.push(this.rev);
					temp.push(this.supplier);
					temp.push(this.dr_inv_no);
					temp.push(this.remarks);
					temp.push(this.status);

					final.push(temp);

					// tr +=
					// 		"<tr align='center'>" +
					// 		"<td>" + button + "</td>" +
					// 		"<td>" + this.control_no + "</td>" +
					// 		"<td>" + this.part_no + "</td>" +
					// 		"<td>" + this.rev + "</td>" +
					// 		"<td>" + this.supplier + "</td>" +
					// 		"<td>" + this.dr_inv_no + "</td>" +
					// 		"<td>" + this.remarks + "</td>" +
					// 		"<td>" + this.status + "</td>" +
					// 		"</tr>";
				});

				if(final.length == 0)
				{
					final = "";
				}

				$('#tblMonitoringRequest').DataTable({
					data: final,
					"columnDefs": [
				        {"className": "text-center", "targets": "_all"}
				    ],
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'csv',
							text: "<button class='btn btn-outline-info btn-flat' style='border-radius: 5px;'><i class='fa fa-file-excel'></i> Export</button> ",
							title: 'IDR - Part No'
						}
					]
					});

				// $("#tblMonitoringRequest tbody").html(tr);
				// $('#tblMonitoringRequest').DataTable();

			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_DeliveryReceipt.receive = function (id)
	{
		// MODAL
			$('#modalReceive').attr('hidden', false);

			$('#modalReceive').iziModal('destroy');
			$("#modalReceive").iziModal({
				subtitle: 'Monitoring',
				width: 1500,
				padding: 10,
				overlay: true,
				top: 70
			});
			$("#modalReceive").iziModal('open');

		// DATATABLE

			// DETAILS
				$.ajax({
					type: 'POST',
					url: base_url + 'Deliveryreceipt.php?action=load_monitoring_data',
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
							$('#txtAttention').val(this.employee_name);

							var actual = '';
							var received_by = '';
							var received_date = '';

							(this.actual == null) ? actual = '' : actual = this.actual;
							(this.received_by == null) ? received_by = '' : received_by = this.received_by;
							(this.received_date == null) ? received_date = '' : received_date = this.received_date;

							tr +=
								"<tr align='center'>" +
									"<td>" + this.part_no + "</td>" + 
									"<td>" + this.rev + "</td>" + 
									"<td>" + this.qty + "</td>" + 
									"<td>" + actual + "</td>" + 
									"<td>" + this.supplier + "</td>" + 
									"<td>" + this.dr_inv_no + "</td>" + 
									"<td>" + this.remarks + "</td>" + 
									"<td>" + received_by + "</td>" + 
									"<td>" + received_date + "</td>" + 
								"</tr>";
						});

						$("#tblActualReceiving tbody").html(tr);

					},
					error: function(jqXHR, errorStatus, errorThrown) 
		            {
		              console.log(errorStatus, errorThrown);
		            }
				});

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
	
			// REMARKS
				$.ajax({
					type: 'POST',
					url: base_url + 'Deliveryreceipt.php?action=load_monitoring_remarks',
					data:
					{
						id	: id,
					},
					dataType: 'json',
					cache: false,
					success: function (data)
					{
						$.each(data, function ()
						{
							$('#txtRemarks').text(this.remarks);
						});

					},
					error: function(jqXHR, errorStatus, errorThrown) 
		            {
		              console.log(errorStatus, errorThrown);
		            }
				});
	};

	this_DeliveryReceipt.waiting = function()
	{

		// alertify.warning('For Receiving!');
	};

	this_DeliveryReceipt.return = function(id)
	{
		// MODAL
			$('#modalReturn').attr('hidden', false);

			$('#modalReturn').iziModal('destroy');
			$("#modalReturn").iziModal({
				subtitle: 'Monitoring',
				width: 1500,
				padding: 10,
				overlay: true,
				top: 70
			});
			$("#modalReturn").iziModal('open');

			$.ajax({
				type: 'POST',
				url: base_url + 'Deliveryreceipt.php?action=load_return',
				data:
				{
					id	: id,
				},
				dataType: 'json',
				cache: false,
				success: function (data)
				{
					$.each(data, function ()
					{
						$('#txtReturnName').val(this.return_by);
						$('#txtReturnDate').val(this.return_date);
						$('#txtReturnDetails').val(this.reason);
					});
				},
				error: function(jqXHR, errorStatus, errorThrown) 
	  			{
	  		 	console.log(errorStatus, errorThrown);
	  		    }
			});
	};

	this_DeliveryReceipt.controlno = function()
	{
		$('#btnChoose').text("CONTROL NUMBER");
		$('#divMonitoring').show();
		$('#divMonitoringRequest').hide();
	};

	this_DeliveryReceipt.partno = function()
	{
		$('#btnChoose').text("PART NUMBER");
		$('#divMonitoring').hide();
		$('#divMonitoringRequest').show();
	};

	this_DeliveryReceipt.notreceived = function()
	{

		alertify.warning('Item not received!');
	};

	this_DeliveryReceipt.receiverequest = function (id)
	{
		// MODAL
			$('#modalReceive').attr('hidden', false);

			$('#modalReceive').iziModal('destroy');
			$("#modalReceive").iziModal({
				subtitle: 'Monitoring',
				width: 1500,
				padding: 10,
				overlay: true,
				top: 70
			});
			$("#modalReceive").iziModal('open');

		// DATATABLE

			// DETAILS
				$.ajax({
					type: 'POST',
					url: base_url + 'Deliveryreceipt.php?action=load_receiving_data',
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

							$('#txtAttention').val(this.employee_name);

							var actual = '';
							var received_by = '';
							var received_date = '';

							(this.actual == null) ? actual = '' : actual = this.actual;
							(this.received_by == null) ? received_by = '' : received_by = this.received_by;
							(this.received_date == null) ? received_date = '' : received_date = this.received_date;

							tr +=
								"<tr align='center'>" +
									"<td>" + this.part_no + "</td>" + 
									"<td>" + this.rev + "</td>" + 
									"<td>" + this.qty + "</td>" + 
									"<td>" + actual + "</td>" + 
									"<td>" + this.supplier + "</td>" + 
									"<td>" + this.dr_inv_no + "</td>" + 
									"<td>" + this.remarks + "</td>" + 
									"<td>" + received_by + "</td>" + 
									"<td>" + received_date + "</td>" + 
								"</tr>";
						});

						$("#tblActualReceiving tbody").html(tr);

					},
					error: function(jqXHR, errorStatus, errorThrown) 
		            {
		              console.log(errorStatus, errorThrown);
		            }
				});

			// ATTACHMENTS
				$('#tblAttachments').DataTable().destroy();
	};

	this_DeliveryReceipt.reapply = function(id)
	{
		if(confirm("You want to re-apply the application?"))
		{
			$.ajax({
				type: 'POST',
				url: base_url + 'Deliveryreceipt.php?action=reapply_application',
				cache: false,
				data:
				{
					id : id
				},
				success: function (data)
				{
					this_DeliveryReceipt.loadmonitoring();
					this_DeliveryReceipt.loadmonitoringrequest();
				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }
			});
		}
	};

	this_DeliveryReceipt.cancel_request = function(id)
	{
		// MODAL
			$('#modalCancel').attr('hidden', false);

			$('#modalCancel').iziModal('destroy');
			$("#modalCancel").iziModal({
				subtitle: 'Application',
				width: 1500,
				padding: 10,
				overlay: true,
				top: 70
			});
			$("#modalCancel").iziModal('open');
			$('#txtIdCancel').val(id);

			$('#txtCancelDetails').attr('readonly', false);
			$('#btnCancel').show();
	};

	this_DeliveryReceipt.saveCancel = function()
	{
		event.preventDefault();

		if($('#txtCancelDetails').val() != '')
		{
			if(confirm("This action cannot be undo. Are you sure to continue ?"))
			{
				$.ajax({
						type: 'POST',
						url: base_url + 'Deliveryreceipt.php?action=cancelapplication',
						cache: false,
			            data : 
			            {
			            	id : $('#txtIdCancel').val(),
			            	reason : $('#txtCancelDetails').val(),
			            	cancel_by : $('#txtCancelName').val()
			            },
			            success: function (result)
			            {
			            	alert(result);
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
			alertify.error('Please provide reason!');
		}
	};

	this_DeliveryReceipt.cancel_view = function(id)
	{
		$('#modalCancel').attr('hidden', false);

		$('#modalCancel').iziModal('destroy');
		$("#modalCancel").iziModal({
			subtitle: 'Application',
			width: 1500,
			padding: 10,
			overlay: true,
			top: 70
		});
		$("#modalCancel").iziModal('open');

		// DETAILS
			$.ajax({
				type: 'POST',
				url: base_url + 'Deliveryreceipt.php?action=load_cancelapplication',
				data:
				{
					id	: id,
				},
				dataType: 'json',
				cache: false,
				success: function (data)
				{

					$.each(data, function ()
					{
						$('#txtCancelName').val(this.cancel_by);
						$('#txtCancelDate').val(this.cancel_date);
						$('#txtCancelDetails').val(this.reason);
					});

					$('#txtCancelDetails').attr('readonly', true);
					$('#btnCancel').hide();

				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }
			});
	};	

	return this_DeliveryReceipt;

})();
//END THIS IS THE CLASS