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
	// var _section = '';

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

					button += "<button type='button' title='View' onclick='Dashboard.view_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-eye'></span></button> ";
					button += "<button type='button' title='Download' onclick='Dashboard.download_details(" + this.id + ");' class='btn btn-outline-danger btn-sm'><span class='fa fa-download'></span></button> ";
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
					// $('#txt_id').val(this.id);

					$('#txt_approved_by').val(this.approved_by_purchasing);
					$('#txt_approved_date').val(this.date_approved_by_purchasing);
					$('#txt_received_by').val(this.received_by);
					$('#txt_received_date').val(this.date_received_by);
					$('#txt_rejected_by').val(this.rejected_by);
					$('#txt_rejected_date').val(this.date_rejected);

					// (this.a_status == "FOR RECEIVED - PC") ? $('#btn_received_encoded').show() : $('#btn_received_encoded').hide();

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

	return this_Dashboard;

})();
//END THIS IS THE CLASS