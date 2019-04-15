/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var realtime_count = 0;
var realtime_count_temp = 0;

$(document).ready(function () 
{
	Receiving.load_dashboard();

	setInterval(function(){ Receiving.realtime(); }, 5000);

	

});


//THIS IS THE CLASS
var Receiving = (function ()
{
	// ALERTIFY 
		alertify.set('notifier','position', 'top-right');
		// alertify.success('Success message');
		// alertify.error('Success message');
		// alertify.warning('Success message');
		// alertify.info('Success message');

	// PUBLIC OBJECT TO BE RETURNED
	var this_Receiving = {};
	var _id = '';

	this_Receiving.realtime = function()
	{
		$.ajax({
			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=load_dashboard_by_receiving',
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
			this_Receiving.load_dashboard();
			realtime_count = realtime_count_temp;
		}
	};

	this_Receiving.load_dashboard = function()
	{
		Receiving.run_waitMe("loading");

		$.ajax({
			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=load_dashboard_by_receiving',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#tblMonitoring').DataTable().destroy();

				var tr = "";

				$.each(data, function ()
				{	
					var button = "";

					button += "<button type='button' title='VIEW' onclick='Receiving.view_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-eye'></span></button> ";
					// ATTACHMENT
					if(this.file_upload != null && this.file_upload != '')
						button += "<a href='../" + this.file_upload + "' target='_blank'> <button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm'><span class='fa fa-link'></span></button> </a>";
					else
						button += "<button type='button' title='DOCUMENT' class='btn btn-outline-danger btn-sm' disabled><span class='fa fa-link'></span></button> ";
					// REJECT
					button += "<button type='button' title='REJECT' onclick='Receiving.show_reject_application(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-trash'></span></button> ";
					
					tr +=
							"<tr align='center'>" +
							"<td>" + button + "</td>" +
							"<td>" + this.control_no + "</td>" +
							"<td>" + this.employee_name + "</td>" +
							"<td>" + this.request_date + "</td>" +
							"<td>" + this.request_type + "</td>" +
							"<td>" + this.supplier + "</td>" +
							"<td>" + this.status + "</td>" +
							"<td>" + "<span class='fa fa-spinner fa-spin fa-2x' style='color: #dc3545;'></span>" + "</td>" +
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

	this_Receiving.view_details = function(id)
	{
		Receiving.run_waitMe("loading_modal");

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
					$('#txt_requestor').val(this.employee_email);

					if(this.status == "WAITING")
					{
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
					}
					
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

	this_Receiving.run_waitMe = function(classname)
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

	this_Receiving.finish_encode = function()
	{
		var id = $('#txt_id').val();
		var incharge = $('#txt_name').val();
		Receiving.run_waitMe("loading_modal");

		$.ajax({
  			type: 'POST',
			url: base_url + 'Cancellationorder.php?action=received_pc_incharge',
			data: 
			{
				id : id,
				incharge : incharge
			},
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				alertify.success("Successfully Received!");
				$('.loading_modal').waitMe("hide");
				$('#view_modal').modal('hide');
				this_Receiving.email_requestor(id);
				Receiving.load_dashboard();
			},
			error: function(data)
			{
				console.log(data);
			}
		});
	};

	this_Receiving.email_requestor = function(id)
	{
		$.ajax({
  			type: 'GET',
			url: '../../../assets/pdf/ci_report.php?id=' + id + '&report=email',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				alertify.success("Email Sent!");
			},
			error: function(data)
			{
				console.log(data);
			}
		});
	};

	this_Receiving.show_reject_application = function(id)
	{
		_id = id;
		$('#txt_reason').val('');
		$('#reject_modal').modal('show');
	};

	this_Receiving.reject_application = function()
	{
		var reason = $('#txt_reason').val();

		if(reason != '')
		{
			if(confirm("Are you sure to continue?"))
			{
				$.ajax({
		  			type: 'POST',
					url: base_url + 'Cancellationorder.php?action=rejected_by_pc',
					data: 
					{
						id : _id,
						name : $('#txt_name').val(),
						reason : reason
					},
					dataType: 'json',
					cache: false,
					success: function (data)
					{
						$('#reject_modal').modal('hide');
						Receiving.load_dashboard();
						alertify.success('Successfully Rejected!');
					},
					error: function(data) 
		            {
		              console.log(data);
		            }
		  		});
			}
		}
		else
		{
			alertify.error('Please provide detailed reason!');
		}
	};

	return this_Receiving;

})();
//END THIS IS THE CLASS