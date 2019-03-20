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




	return this_Login;

})();
//END THIS IS THE CLASS