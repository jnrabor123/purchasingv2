<?php
  
include("../../application/model/connection.php");

$code = $_GET["code"];

?>

<!DOCTYPE html>
<html>
<head>

  <title>Purchasing</title>

  <!-- Page Logo -->
  <link rel="icon" href="../logo/logo.png" size="200x200" />

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="../vendor/generate/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../vendor/generate/fontawesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../vendor/generate/animate/animate.css">
  <link rel="stylesheet" href="../vendor/waitme/waitMe.css">

  <style>

  		#reject_modal .modal-dialog 
		{
	      width:50%;
	      height:100%;
	    }

		.fa-signal 
		{
			transform: rotate(270deg) scaleX(-1);
		}
		.table thead th, .table tbody td 
		{
	    	vertical-align: middle !important;
	    	text-align: center;
		}
		.design
		{
			border-radius: 15px; border: 1px solid #dc3545; color: #000; text-align: center; width: 90%;
		}
		.color-red
		{
			color: #dc3545;
		}

		.modal-content
		{
			border-top-right-radius: 30px;
	        border-top-left-radius: 30px;
		}

		.modal-header-danger 
		{
	        color:#fff;
	        padding:9px 15px;
	        border-bottom:1px solid #eee;
	        background-color: #d9534f;
	        -webkit-border-top-left-radius: 5px;
	        -webkit-border-top-right-radius: 5px;
	        -moz-border-radius-topleft: 5px;
	        -moz-border-radius-topright: 5px;
	        border-top-right-radius: 30px;
	        border-top-left-radius: 30px;
	    }
		.modal-footer-danger 
		{
	        background-color: #d9534f;
	        border-bottom-right-radius: 0px;
	        border-bottom-left-radius: 0px;
	    }
		.design1
		{
			border-radius: 15px; border: 1px solid #dc3545; color: #000;
		}
  </style>
  
</head>

<body style="background-color: rgb(202, 215, 219);">

<div class="container-fluid loading">

	<div class="row">

		<div class="col-sm-12 col-md-12 col-lg-12" id="div_session">

			<div class="col-sm-1 col-md-10 col-lg-1"></div>
			<div class="col-sm-10 col-md-10 col-lg-10" style="margin: auto;">
				<br/>
				<br/>
			    <div class="panel panel-danger" style="border-radius: 20px;">
			      <div class="panel-body">

			      	<div class="col-sm-12 col-md-12 col-lg-12">
			      		<div class="col-sm-5 col-md-5 col-lg-5">
			      			<center>
			      				<label style="font-size: 150%; color: #dc3545; "><span class="fa fa-signal fa-4x"></span> <span class="fa fa-envelope fa-5x"></span></label>
			      			</center>
			      		</div>
			      		<div class="col-sm-7 col-md-7 col-lg-7">
			      			<center>
			      				<h1 style="color: #dc3545; font-weight: bold;">JUST ONE MORE STEP...</h1>
			      				<br/>
			      				<p style="text-align: justify; font-weight: bold;">Please verify the data of request. If data is acceptable click approve and system will send a  generated email to PC section. Thank you!!!</p>
			      			</center>
			      		</div>
			      	</div>
			      	
			      	<div class="col-sm-12 col-md-12 col-lg-12">
			      		<div class="col-sm-4 col-md-4 col-lg-4">
			      			<br/>
			      			<label class="color-red">REQUEST</label><br/>
			      			<input class="design" type="text" id="request_date" readonly /><br/>

			      			<label class="color-red">REQUESTOR</label><br/>
			      			<textarea class="design" rows="3" id="employee_name" style="resize: none;" readonly></textarea>
			      		</div>
			      		<div class="col-sm-4 col-md-4 col-lg-4">
			      			<br/>
			      			<label class="color-red">CONTROL NO.</label><br/>
			      			<input class="design" type="text" id="control_no" readonly /><br/>

			      			<label class="color-red">TYPE</label><br/>
			      			<textarea class="design" rows="3" id="request_type" style="resize: none;" readonly></textarea>
			      		</div>
			      		<div class="col-sm-4 col-md-4 col-lg-4">
			      			<br/>
			      			<label class="color-red">ATTACHMENT</label><br/>
			      			<center><a href="" id="txt_attachment"><span class="fa fa-link"></span> Click Here </a><br/></center>

			      			<label class="color-red">SUPPLIER</label><br/>
			      			<textarea class="design" rows="3" id="supplier" style="resize: none;" readonly></textarea>
			      		</div>
			      	</div>

			      	<div class="col-sm-12 col-md-12 col-lg-12">

			      		<br/>
			      		<div class="table-responsive">
			      		<table class="table table-bordered" id="tblMonitoring" cellspacing="0">
							<thead>
								<tr align='center'>
									<th>#</th>
									<th>Part No.</th>
									<th>Rev</th>
									<th>Qty</th>
									<th>PO No.</th>
									<th>PO Code</th>
									<th>Receipt No.</th>
									<th>Prod <br/> Order No.</th>
									<th>Delivery</th>
									<th>Supplier's <br/> Answer</th>
									<th>Reason</th>
									<th>Remove</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						</div>
			      	</div>

			      </div>

			      <div class="panel-footer" style="border-radius: 0px 0px 20px 20px; background-color: #dc3545; height: 90px;">
			      	<div class="col-sm-12">
			      		<center>
			      			<select id="select_head" style="width: 20%; text-align-last: center;">
			      				<!-- <option val=''>CHOOSE</option>
			      				<option>CRISCELDA FLORES</option>
			      				<option>MAJALHANIE TORIA</option>
			      				<option>RUSSEL CAMBAL</option>
			      				<option>LUNINGNING BAZAR</option> -->
			      			</select>
			      			<br/><br/>
			      			<input type="button" id="btn_approve" name="btn_approve" class="btn btn-danger" value="APPROVE" style="background-color: #fff; color: #dc3545;" onclick="Generate.click_approve();" />
			      			<!-- <input type="button" id="btn_reject" name="btn_reject" class="btn btn-danger" value="REJECT" style="background-color: #fff; color: #dc3545;" onclick="Generate.click_reject();" /> -->
			      			<input type="button" id="btn_reject" name="btn_reject" class="btn btn-danger" value="REJECT" style="background-color: #fff; color: #dc3545;" onclick="Generate.show_reject();" />
			      		</center>
			      	</div>
			      </div>

			    </div>
			</div>
			<div class="col-sm-1 col-md-10 col-lg-1">

				<input type="hidden" id="" name= "" value="" />
			</div>
		</div>

		<div class="col-sm-12 col-md-12 col-lg-12" id="div_expired">

			<div class="col-sm-1 col-md-10 col-lg-1"></div>
			<div class="col-sm-10 col-md-10 col-lg-10" style="margin: auto;">

				<br/>
				<br/>
			    <div class="panel panel-danger" style="border-radius: 20px;">

			    	<div class="panel-body">

			    		<div class="col-sm-12 col-md-12 col-lg-12">
				      		<div class="col-sm-5 col-md-5 col-lg-5">
				      			<center>
				      				<br/>
				      				<label style="font-size: 150%; color: #dc3545; "><span class="glyphicon glyphicon-qrcode fa-5x"></span></label>
				      			</center>
				      		</div>
				      		<div class="col-sm-7 col-md-7 col-lg-7">
				      			<center>
				      				<h2 style="color: #dc3545; font-weight: bold;"><span class="glyphicon glyphicon-thumbs-up"></span> <span class="glyphicon glyphicon-thumbs-up"></span> <span class="glyphicon glyphicon-thumbs-up"></span><br/> THANK YOU,</h2>
				      				<h2 style="color: #dc3545; font-weight: bold;">YOUR SESSION HAS EXPIRED...</h2>
				      			</center>
				      		</div>
				      	</div>

					</div>
					<div class="panel-footer" style="border-radius: 0px 0px 20px 20px; background-color: #dc3545; height: 50px;">
					</div>
			    </div>



			</div>
			<div class="col-sm-1 col-md-10 col-lg-1">
			</div>
		</div>

	</div>
</div>

  <!-- REJECT -->
  <div class="modal fade" id="reject_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        
        <div class="modal-header modal-header-danger ">
          <h4 class="modal-title"><span class="fa fa-trash"></span> REASON </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        
        <div class="modal-body">
         
			<label class="color-red">DETAILED</label><br/>
			<textarea class="form-control design1" rows="5" id="txt_reason" style="resize: none;" onkeyup="this.value = this.value.toUpperCase();"></textarea>

        </div>
        
        <div class="modal-footer">
        	<button type="button" class="btn btn-danger" onclick="Generate.click_reject();"><span class="fa fa-flag"></span> REJECT APPLICATION</button>
        </div>
        
      </div>
    </div>
  </div>


<!-- SCRIPT -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables.net/js/jquery.dataTables.rowsGroup.js"></script>
  <script src="../vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../vendor/waitme/waitMe.js" ></script>
  <script src="../vendor/bootstrap/bootstrap.min.js"></script>
  <script type="text/javascript">

  	$(document).ready(function() {

  		Generate.load_generate();
  		

  	});

	var Generate = (function ()
	{
		var this_Generate = {};

		var _section = '';

		this_Generate.load_generate = function()
		{
			var code = "<?php echo $code; ?>";
	  		
	  		Generate.run_waitMe();

	  		$.ajax({
	  			type: 'POST',
				url: '../../application/controller/Cancellationorder.php?action=load_generate',
				data: 
				{
					code : code
				},
				dataType: 'json',
				cache: false,
				success: function (data)
				{
					// Condition
						var status = '';

					$('#tblMonitoring').DataTable().destroy();

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
						_section = this.employee_section;
						document.getElementById("txt_attachment").href = this.file_upload;

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
									"<td>" + "<button class='btn btn-danger' onclick='Generate.btn_remove(" + this.id2 + ");'><span class='fa fa-minus fa-2x'></span></button>" + "</td>" +
								"</tr>";
						x++;

						status = this.status;
					});

					Generate.load_approver();
					
					$("#tblMonitoring tbody").html(tr);

					if(status.indexOf("FOR APPROVAL") != -1)
					{
						$('#div_session').show();
						$('#div_expired').hide();
					}
					else
					{
						$('#div_session').hide();
						$('#div_expired').show();
					}
					
					$('.loading').waitMe("hide");
				},
				error: function(data) 
	            {
	              console.log(data);
	            }
	  		});
		};

		this_Generate.run_waitMe = function()
		{
			$('.loading').waitMe({

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

		this_Generate.btn_remove = function(id)
		{
			if(confirm("Do you want to remove?"))
  			{
  				$.ajax({
	  			type: 'POST',
				url: '../../application/controller/Cancellationorder.php?action=remove_item',
				data: 
				{
					id : id
				},
				dataType: 'json',
				cache: false,
				success: function (data)
				{
					Generate.load_generate();
				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }
	       	 	});
  			}
		};

		this_Generate.click_approve = function()
		{
			var head = $('#select_head').val();
			if(head != null)
			{
				if(confirm("Are you sure to proceed?"))
		  		{
			  		Generate.run_waitMe();

			  		$.ajax({
			  			type: 'POST',
						url: '../../application/controller/Cancellationorder.php?action=approved_by_purchasing',
						data: 
						{
							code : "<?php echo $code; ?>",
							name : head
						},
						dataType: 'json',
						cache: false,
						success: function (data)
						{
							Generate.load_generate();
							Generate.auto_email();
							alert("Successfully Approved!");
							$('.loading').waitMe("hide");
						},
						error: function(data) 
			            {
			              console.log(data);
			            }
			  		});
		  		}
	  		}
	  		else
	  			alert('SELECT YOUR NAME!');
		};

		this_Generate.show_reject = function()
		{
			if($('#select_head').val() != null)
			{
				$('#txt_reason').val('');
				$('#reject_modal').modal('show');
			}
			else
	  			alert('SELECT YOUR NAME!');
		};

		this_Generate.click_reject = function()
		{
			var reason = $('#txt_reason').val();
			var head = $('#select_head').val();

			if(reason != '')
			{
		  		if(confirm("Are you sure to proceed?"))
		  		{
			  		Generate.run_waitMe();

			  		$.ajax({
			  			type: 'POST',
						url: '../../application/controller/Cancellationorder.php?action=rejected_by_purchasing',
						data: 
						{
							code : "<?php echo $code; ?>",
							name : head,
							reason : reason
						},
						dataType: 'json',
						cache: false,
						success: function (data)
						{
							$('#reject_modal').modal('hide');
							$('.loading').waitMe("hide");
							Generate.load_generate();
							alert("Successfully Rejected!");
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
				alert('Please provide detailed reason!');
			}
		};

		this_Generate.auto_email = function()
		{
			$.ajax({
	  			type: 'POST',
				url: '../../assets/email/email_icos_purhead_to_pcstaff.php',
				data: 
				{
					control_no : $('#control_no').val()
				},
				dataType: 'json',
				cache: false,
				success: function (data)
				{
					console.log("working");
				},
				error: function(data) 
	            {
	              console.log(data);
	            }
	  		});
		};

		this_Generate.load_approver = function()
		{
			$.ajax({
	  			type: 'POST',
	  			url: '../../application/controller/Cancellationorder.php?action=load_approver',
	  			data:
	  			{
	  				section : _section
	  			},
				dataType: 'json',
				cache: false,
				success: function (data)
				{
					var option = '<option disabled selected>CHOOSE</option>';
					$.each(data, function ()
					{
						option +=
						'<option value="' + this.employee_name + '">' + this.employee_name + '</option>';
					});
					$('#select_head').html(option);
				},
				error: function(data) 
	            {
	              console.log(data);
	            }
	  		});
		};

		

		return this_Generate;

	})();
  	

  	

  	

  	

  </script>

</body>
</html>


