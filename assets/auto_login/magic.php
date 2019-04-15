<?php
  
include("../../application/model/connection.php");

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
  <link rel="stylesheet" href="../vendor/flipclock/compiled/flipclock.css">

  <style>
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
  </style>
</head>

<body class="loading" style="background-color: rgb(202, 215, 219);">

<div class="container-fluid">

	<div class="row">

		<div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 50px;">
			<center>
				<p class="clock"></p>
				<p class="message" style="color: red;"></p>
			</center>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4">
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4">
			<center>
				<h1>SELECT TO LOGIN</h1>
				<br/><br/>
				<img src="../logo/ICOS/cose.jpg" style="height: 150px; width: 150px; border-radius: 50%;" />  
				<br/>
				<button type="button" class="btn btn-danger" style="font-size: 20px;" onclick="Magic.auto_login(0);">ROSEL</button>
				<br/><br/>
				<img src="../logo/ICOS/bianca.jpg" style="height: 150px; width: 150px; border-radius: 50%;" /> 
				<br/>
				<button type="button" class="btn btn-danger" style="font-size: 20px;" onclick="Magic.auto_login(1);">BIANCA</button>
			</center>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4">
		</div>

	</div>
</div>


<!-- SCRIPT -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables.net/js/jquery.dataTables.rowsGroup.js"></script>
  <script src="../vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../vendor/waitme/waitMe.js" ></script>
  <script src="../vendor/flipclock/compiled/flipclock.js"></script>  

  <script type="text/javascript">

  	$(document).ready(function() {

  		// Magic.flip_clock();
  		Magic.load_incharge();
  	});

	var Magic = (function ()
	{
		var this_Magic = {};
		var clock;
		var _approver = [];

		this_Magic.auto_login = function(index)
		{

			$.ajax({

				type: 'POST',
				url: '../../application/controller/' + 'Login.php?action=login',
				data:
				{
					username : _approver[index][0],
					password : _approver[index][1]
				},
				dataType: 'json',
				cache: false,
				success: function(data)
				{
					$('.loading').hide();
					alert("Welcome " + data.employee_name);
					window.location = "http://10.164.30.173/purchasingv2/application/view/cancellationorder/receiving.php";

				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }

			});
		};

		this_Magic.flip_clock = function()
		{
			Magic.run_waitMe();

			clock = $('.clock').FlipClock({
		        clockFace : 'HourlyCounter',
		        autoStart : false,
		        countdown: true,
		        callbacks : {
		        	stop : function()
		        	{
		        		Magic.auto_login();
		        	},
		        	start : function()
		        	{
		        		$('.message').html("");
		        	}
		        }
		    });
			
		    clock.setTime(2);
			clock.setCountdown(true);
			clock.start();

			$('.clock').hide();
			$('.message').hide();
		};

		this_Magic.run_waitMe = function()
		{
			$('.loading').waitMe({

			//none, rotateplane, stretch, orbit, roundBounce, win8, 
			//win8_linear, ios, facebook, rotation, timer, pulse, 
			//progressBar, bouncePulse or img
			effect: 'ios',

			//place text under the effect (string).
			text: 'Redirecting...',

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

		this_Magic.load_incharge = function()
		{
			$.ajax({

				type: 'POST',
				url: '../../application/controller/Cancellationorder.php?action=load_incharge',
				dataType: 'json',
				cache: false,
				success: function(data)
				{

					$.each(data, function ()
					{
						var temp = [];
						temp.push(this.employee_no);
						temp.push(this.employee_password);
						_approver.push(temp);
					});
				},
				error: function(data) 
	            {
	              console.log(data);
	            }

			});
		};

		return this_Magic;
	})();

  </script>

</body>
</html>
