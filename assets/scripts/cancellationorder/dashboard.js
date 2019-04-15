/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var realtime_count = 0;
var realtime_count_temp = 0;

$(document).ready(function () 
{
	Dashboard.load_dashboard();
	Dashboard.load_dashboard_partno();
	Dashboard.controlno();

	setInterval(function(){ Dashboard.realtime(); }, 5000);

});


//THIS IS THE CLASS
var Dashboard = (function ()
{
	// ALERTIFY 
		alertify.set('notifier','position', 'top-right');
		// alertify.success('Success message');
		// alertify.error('Success message');
		// alertify.warning('Success message');
		// alertify.info('Success message');

	//PUBLIC OBJECT TO BE RETURNED
	var this_Dashboard = {};

	this_Dashboard.realtime = function()
	{
		$.ajax({
			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=load_dashboard',
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
			this_Dashboard.load_dashboard();
			realtime_count = realtime_count_temp;
		}
	};

	this_Dashboard.load_dashboard = function()
	{
		Dashboard.run_waitMe("loading");

		$.ajax({
			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=load_dashboard',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#tblMonitoring').DataTable().destroy();

				var tr = "";

				$.each(data, function ()
				{	
					var button = "";
					// DETAILS

						button += "<button type='button' title='View' onclick='Dashboard.view_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-eye'></span></button> ";
					// DOWNLOAD

						button += "<button type='button' title='Download' onclick='Dashboard.download_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-download'></span></button> ";
					// ATTACHMENT
						if(this.file_upload != null && this.file_upload != '')
							button += "<a href='../" + this.file_upload + "' target='_blank'> <button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm'><span class='fa fa-link'></span></button> </a>";
						else
							button += "<button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm' disabled><span class='fa fa-link'></span></button> ";
					// REPORT PDF
						if(this.status == 'RECEIVED AND ENCODED')
							button += "<button type='button' title='PDF' onclick='Dashboard.view_pdf(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-file-pdf'></span></button> ";
						else
							button += "<button type='button' title='PDF' class='btn btn-outline-danger btn-sm' disabled><span class='fa fa-file-pdf'></span></button> ";

						tr +=
								"<tr align='center'>" +
								"<td>" + button + "</td>" +
								"<td>" + this.control_no + "</td>" +
								"<td>" + this.employee_name + "</td>" +
								"<td>" + this.request_date + "</td>" +
								"<td>" + this.request_type + "</td>" +
								"<td>" + this.supplier + "</td>" +
								"<td>" + this.status + "</td>" +
								"<td>" + this_Dashboard.icon(this.approved_by_purchasing, this.status) + "</td>" +
								"<td>" + this_Dashboard.icon(this.received_by, this.status) + "</td>" +
								"</tr>";
				});
				
				$("#tblMonitoring tbody").html(tr);
				$('#tblMonitoring').DataTable();

				$('.loading').waitMe("hide");

			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_Dashboard.load_dashboard_partno = function()
	{
		Dashboard.run_waitMe("loading");

		$.ajax({
			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=load_dashboard_partno',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
			// 1 
				// $('#tblMonitoringRequest').DataTable().destroy();

				// var tr = "";

				// $.each(data, function ()
				// {	
				// 	var button = "";
				// 	// DETAILS
				// 		button += "<button type='button' title='View' onclick='Dashboard.view_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-eye'></span></button> ";
				// 	// DOWNLOAD
				// 		button += "<button type='button' title='Download' onclick='Dashboard.download_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-download'></span></button> ";
				// 	// ATTACHMENT
				// 		if(this.file_upload != null && this.file_upload != '')
				// 			button += "<a href='../" + this.file_upload + "' target='_blank'> <button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm'><span class='fa fa-link'></span></button> </a>";
				// 		else
				// 			button += "<button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm' disabled><span class='fa fa-link'></span></button> ";
				// 	// REPORT PDF
				// 		if(this.status == 'RECEIVED AND ENCODED')
				// 			button += "<button type='button' title='PDF' onclick='Dashboard.view_pdf(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-file-pdf'></span></button> ";
				// 		else
				// 			button += "<button type='button' title='PDF' class='btn btn-outline-danger btn-sm' disabled><span class='fa fa-file-pdf'></span></button> ";

				// 		tr +=
				// 				"<tr align='center'>" +
				// 				"<td>" + button + "</td>" +
				// 				"<td>" + this.part_no + "</td>" +
				// 				"<td>" + this.rev + "</td>" +
				// 				"<td>" + this.control_no + "</td>" +
				// 				"<td>" + this.supplier + "</td>" +
				// 				"<td>" + this.status + "</td>" +
				// 				"</tr>";
				// });
				
				// $("#tblMonitoringRequest tbody").html(tr);
				// $('#tblMonitoringRequest').DataTable();

			// 2

				var final = [];
				$.each(data, function ()
				{	

					var temp = [];

					var button = "";
					// DETAILS
						button += "<button type='button' title='View' onclick='Dashboard.view_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-eye'></span></button> ";
					// DOWNLOAD
						button += "<button type='button' title='Download' onclick='Dashboard.download_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-download'></span></button> ";
					// ATTACHMENT
						if(this.file_upload != null && this.file_upload != '')
							button += "<a href='../" + this.file_upload + "' target='_blank'> <button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm'><span class='fa fa-link'></span></button> </a>";
						else
							button += "<button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm' disabled><span class='fa fa-link'></span></button> ";
					// REPORT PDF
						if(this.status == 'RECEIVED AND ENCODED')
							button += "<button type='button' title='PDF' onclick='Dashboard.view_pdf(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-file-pdf'></span></button> ";
						else
							button += "<button type='button' title='PDF' class='btn btn-outline-danger btn-sm' disabled><span class='fa fa-file-pdf'></span></button> ";

					temp.push(button);
					temp.push(this.part_no);
					temp.push(this.rev);
					temp.push(this.control_no);
					temp.push(this.supplier);
					temp.push(this.status);

					final.push(temp);
				});

				if(final.length == 0)
				{
					final = "";
				}

	   			$('#tblMonitoringRequest').DataTable({
					data: final,
					rowsGroup:[0, 3, 4, 5],
					"columnDefs": [
				        {"className": "text-center", "targets": "_all"}
				    ],
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'csv',
							text: "<button class='btn btn-outline-danger btn-flat' style='border-radius: 5px;'><i class='fa fa-file-excel'></i> Export</button> ",
							title: 'ICOS - Part No'
						}
					]
					});

				$('.loading').waitMe("hide");

			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_Dashboard.icon = function(value, status)
	{
		if(status.indexOf("REJECTED") != -1)
		{
			return "<span class='fa fa-minus-circle fa-2x' style='color: #dc3545;'></span>";
		}
		else
		{
			switch(value)
			{
				case null:
					return "<span class='fa fa-spinner fa-spin fa-2x' style='color: #dc3545;'></span>";
					break;
				default:
					return value;
			}
		}
	};

	this_Dashboard.view_details = function(id)
	{
		Dashboard.run_waitMe("loading_modal");

		$.ajax({
  			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=load_generate_by_id',
			data: 
			{
				id : id
			},
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#tblView').DataTable().destroy();

				var tr = "";
				var x = 1;

				$.each(data, function ()
				{
					var button = "";

					$('#control_no').val(this.control_no);
					$('#employee_name').val(this.employee_name);
					$('#request_date').val(this.request_date);
					$('#request_type').val(this.request_type);
					$('#supplier').val(this.supplier);
					$('#txt_id').val(this.id);

					$('#txt_approved_by').val(this.approved_by_purchasing);
					$('#txt_approved_date').val(this.date_approved_by_purchasing);
					$('#txt_received_by').val(this.received_by);
					$('#txt_received_date').val(this.date_received_by);
					$('#txt_rejected_by').val(this.rejected_by);
					$('#txt_rejected_date').val(this.date_rejected);
					$('#txt_reason').val(this.rejected_reason);

					if(this.email_by == null || this.email_by == '')
						$('#txt_sent_by').val('');
					else
						$('#txt_sent_by').val(this.email_by + "\n" + this.email_date);

					if(this.a_status == "RECEIVED AND ENCODED" && this.email_by == null)
					{
						$('#email_by').val('');
						$('#btn_email').show();
					}
					else if(this.a_status == "RECEIVED AND ENCODED" && this.email_by != null)
					{
						$('#email_by').val(this.email_by + "\n" + this.email_date);
						$('#btn_email').hide();
					}
					else
					{
						$('#email_by').val('');
						$('#btn_email').hide();
					}

					tr +=
						"<tr align='center'>" +
							"<td>" + x + "</td>" +

							"<td>" + this.part_no + "</td>" +
							"<td>" + this.rev + "</td>" +
							"<td>" + this.quantity + "</td>" +
							"<td>" + this.po_no + "</td>" +
							"<td>" + this.po_code + "</td>" +

							"<td>" + this.receipt_no + "</td>" +
							"<td>" + this.prod_code_no + "</td>" +
							"<td>" + this.delivery_date + "</td>" +
							"<td>" + this.supplier_answer + "</td>" +
							"<td>" + this.reason + "</td>" +
							"<td>" + this.status + "</td>" +
						"</tr>";
					x++;
					
				});

				
				$("#tblView tbody").html(tr);

				$('.loading_modal').waitMe("hide");

				$('#view_modal').modal('show');
			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
  		});
	};

	this_Dashboard.download_details = function(id)
	{

		window.location = '../../../application/model/Cancellationorder_m2.php?action=download_details&id=' + id;
	};

	this_Dashboard.run_waitMe = function(classname)
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

	this_Dashboard.view_pdf = function(id)
	{
		
		window.open('../../../assets/pdf/ci_report.php?id=' + id + '&report=pdf', '_blank', "height=900,width=700px", 'toolbar=no');
	};

	this_Dashboard.email = function()
	{
		$.ajax({
  			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=save_email',
			data: 
			{
				id : $('#txt_id').val(),
				name : $('#txt_name').val()
			},
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				alertify.success('Success Sent!');
				$('#view_modal').modal('hide');
			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});		
	};

	this_Dashboard.controlno = function()
	{
		$('#btnChoose').text("CONTROL NUMBER");
		$('#divMonitoring').show();
		$('#divMonitoringRequest').hide();
	};

	this_Dashboard.partno = function()
	{
		$('#btnChoose').text("PART NUMBER");
		$('#divMonitoring').hide();
		$('#divMonitoringRequest').show();
	};

	return this_Dashboard;

})();
//END THIS IS THE CLASS