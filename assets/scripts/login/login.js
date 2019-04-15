/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () 
{
	Login.showLogin();
});

//THIS IS THE CLASS
var Login = (function ()
{
	// ALERTIFY 
		alertify.set('notifier','position', 'top-right');
		// alertify.success('Success message');
		// alertify.error('Success message');
		// alertify.warning('Success message');
		// alertify.info('Success message');

	//PUBLIC OBJECT TO BE RETURNED
	var this_Login = {};
	var _reset = [];

	this_Login.loginCheck = function ()
	{
		var username = $('#txtUsername').val();
		var password = $('#txtPassword').val();

		if(username === '' || password === '')
		{
			alertify.error('Please Complete Details!');
		}
		else
		{
			$.ajax({

				type: 'POST',
				url: 'application/controller/' + 'Login.php?action=login',
				data:
				{
					username : username,
					password : password
				},
				dataType: 'json',
				cache: false,
				success: function(data)
				{
					if(data == false)
					{
						alertify.warning("Account does'nt exist!");
					}
					else
					{
						alert("Welcome " + data.employee_name);
						window.location = "http://10.164.30.173/purchasingv2/application/view/admin/index.php";
					}
				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }

			});
		}
	};

	this_Login.showLogin = function ()
	{
		$('#modalLogin').iziModal('destroy');
		$("#modalLogin").iziModal({
			subtitle: 'Login',
			width: 1500,
			padding: 10,
			overlay: true,
			top: 70
		});
		$("#modalLogin").iziModal('open');
	};

	this_Login.registerUser = function ()
	{
		$('#modalRegister').iziModal('destroy');
		$("#modalRegister").iziModal({
			subtitle: 'Registration',
			width: 1500,
			padding: 10,
			overlay: true,
			top: 70
		});
		$("#modalRegister").iziModal('open');
	};

	this_Login.registerClear = function ()
	{

		$('#modalFormRegister')[0].reset();
	};

	this_Login.registerRegistration = function ()
	{
		var idnumber = $('#txtRegisterIdNumber').val();
		var password = $('#txtRegisterPassword').val();
		var retype = $('#txtRegisterReType').val();
		var name = $('#txtRegisterFullname').val();
		var section = $('#txtRegisterSection').val();
		var position = $('#txtRegisterPosition').val();
		var email = $('#txtRegisterEmail').val();
		
		if(idnumber === '' || password === '' || retype === '' || name === '' || section === '' || position === '' || email === '')
		{
			alertify.error('Please complete your details');
		}
		else if(retype != password)
		{
			alertify.error('Please verify your password');
		}
		else
		{
			alertify.confirm(
				'Notification', 
				'All data are correct?', 
				function()
				{ 
					$.ajax({
						type: 'POST',
						url: 'application/controller/Login.php?action=insert_user',
						cache: false,
						data:
						{
							idnumber : idnumber,
							password : password,
							name : name,
							section : section,
							position : position,
							email : email
						},
						success: function(data)
						{
							alertify.success('User Successfully Added');
							this_Login.registerClear();
							$("#modalRegister").iziModal('close');
						},
						error: function()
						{
							console.log(errorStatus, errorThrown);
						}
					});
					

				}, 
				function()
				{ 
					alertify.error('Cancel');
				});
		}
	};

	this_Login.forgotPassword = function ()
	{

		alertify.warning('We working on it! Sorry for the inconvenience.');
	};

	this_Login.manageAccounts = function ()
	{

		alertify.warning('We working on it! Sorry for the inconvenience.');
	};

	this_Login.changePassword = function ()
	{

		alertify.warning('We working on it! Sorry for the inconvenience.');
	};

	this_Login.signOut = function ()
	{
		if(confirm("Do you want to leave? [Y/N]"))
		{
			window.location = "../../config/destroy.php";
		}
	};

	this_Login.reset_password = function()
	{
		$('#modalForgot').iziModal('destroy');
		$("#modalForgot").iziModal({
			subtitle: 'Reset',
			width: 1500,
			padding: 10,
			overlay: true,
			top: 70
		});
		$("#modalForgot").iziModal('open');

		$('#txt_id').attr('readonly', false);
		$('#txt_password').attr('readonly', true);
		$('#txt_repassword').attr('readonly', true);
		$('#btn_reset').hide();
	};

	this_Login.verify_id = function()
	{

		$.ajax({
				type: 'POST',
				url: 'application/controller/Login.php?action=verify_id',
				data:
				{
					id : $('#txt_id').val()
				},
				dataType: 'json',
				cache: false,
				success: function(data)
				{
					if(data.length > 0)
					{
						alertify.success('Verified!');
						$('#txt_id').attr('readonly', true);
						$('#txt_password').attr('readonly', false);
						$('#txt_repassword').attr('readonly', false);
						_reset = data;
						$('#btn_reset').show();
					}
					else
						alertify.error('No existing account! Contact Admin');
				},
				error: function(data) 
	            {
	              console.log(data);
	              alertify.error('Please enter number!');
	            }

			});
	};

	this_Login.reset_now = function()
	{
		var pass = $('#txt_password').val();
		var repass = $('#txt_repassword').val();

		if(pass == repass && (pass != '' && repass != ''))
		{
			$.ajax({
				type: 'POST',
				url: 'application/controller/Login.php?action=save_reset_password',
				data:
				{
					id : _reset[0]["id"],
					password : pass
				},
				dataType: 'json',
				cache: false,
				success: function(data)
				{
					alertify.success('Successfully Changed!');
					$('#modalForgot').iziModal('destroy');
					$("#modalForgot").iziModal('hide');
				},
				error: function(data) 
	            {
	              console.log(data);
	              alertify.error('Please enter number!');
	            }

			});
		}
		else
			alertify.error('Please check the password!');
	};

	return this_Login;

})();
//END THIS IS THE CLASS