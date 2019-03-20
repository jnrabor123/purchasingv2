/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () 
{
	User.load_user();
});


//THIS IS THE CLASS
var User = (function ()
{
	// ALERTIFY 
		alertify.set('notifier','position', 'top-right');
		// alertify.success('Success message');
		// alertify.error('Success message');
		// alertify.warning('Success message');
		// alertify.info('Success message');

	//PUBLIC OBJECT TO BE RETURNED
	var this_User = {};

	var _current_id;

	this_User.show_modal = function (subtitle)
	{
		$('#modal').iziModal('destroy');
		$("#modal").iziModal({
			subtitle: subtitle,
			width: 1500,
			padding: 10,
			overlay: true,
			top: 70
		});
		$("#modal").iziModal('open');
		$("#txtBirthday").datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'	
		});
		$('#txtBirthday').attr("readonly", true);
	};

	this_User.clear_modal = function ()
	{
		event.preventDefault();
		$('#modalForm')[0].reset();
	};

	this_User.action = function (action)
	{
		$('#btnAdd').show();
		$('#btnUpdate').hide();
		this_User.show_modal(action);
	}

	this_User.load_user = function ()
	{
		$.ajax({
			type: 'POST',
			url: base_url + 'Admin.php?action=load_user',
			dataType: 'json',
			cache: false,
			success: function (data)
			{
				$('#dataTable').DataTable().destroy();

				var tr = "";
				$.each(data, function ()
				{
					tr +=
							"<tr align='center'>" +
							"<td>" + this.id + "</td>" +
							"<td>" + this.firstname + " " + this.lastname +"</td>" +
							"<td>" + this.age + "</td>" +
							"<td>" + this.birthdate + "</td>" +
							"<td>" + this.sex + "</td>" +
							"<td>" + this.status + "</td>" +
							"<td>" +
							"<button class='btn btn-info btn-sm' onclick='User.load_user_details(" + this.id + ")' ><i class='fas fa-edit'></i></button> " +
							"<button class='btn btn-danger btn-sm' onclick='User.delete_user(" + this.id + ")' ><i class='fas fa-trash-alt'></i></button>" +
							"</td>" +
							"</tr>";
				});
				$("#dataTable tbody").html(tr);
				$('#dataTable').DataTable();
			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_User.load_user_details = function (id)
	{
		$.ajax({
			type: 'POST',
			url: base_url + 'Admin.php?action=load_user_details',
			dataType: 'json',
			cache: false,
			data:
				{
					id: id
				},
			success: function (data)
			{
				$.each(data, function ()
				{

					this_User.show_modal("Info");

					$('#txtId').val(id);
					$("#txtFirstName").val(this.firstname);
					$('#txtLastName').val(this.lastname);
					$("#txtAge").val(this.age);
					$("#txtBirthday").val(this.birthdate);
					$("#selectSex").val(this.sex);
					$("#selectStatus").val(this.status);
					$('#btnAdd').hide();
					$('#btnUpdate').show();

				});

			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_User.insert_user = function ()
	{
		event.preventDefault();

		var firstname = $("#txtFirstName").val();
		var lastname = $("#txtLastName").val();
		var age = $("#txtAge").val();
		var birthdate = $("#txtBirthday").val();
		var sex = $("#selectSex").val();
		var status = $("#selectStatus").val();

		$.ajax({
			type: 'POST',
			url: base_url + 'Admin.php?action=insert_user',
			cache: false,
			data:
			{
				firstname : firstname,
				lastname  : lastname,
				age 	  : age,
				birthdate : birthdate,
				sex 	  : sex,
				status 	  : status
			},
			success: function (data)
			{
				this_User.load_user();

				$('#modalForm')[0].reset();

				alertify.success('User Successfully Added!');
			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_User.update_user = function ()
	{
		event.preventDefault();

		var id = $("#txtId").val();
		var firstname = $("#txtFirstName").val();
		var lastname = $("#txtLastName").val();
		var age = $("#txtAge").val();
		var birthdate = $("#txtBirthday").val();
		var sex = $("#selectSex").val();
		var status = $("#selectStatus").val();

		$.ajax({
			type: 'POST',
			url: base_url + 'Admin.php?action=update_user',
			cache: false,
			data:
			{
				id : id,
				firstname : firstname,
				lastname : lastname,
				age : age,
				birthdate : birthdate,
				sex : sex,
				status : status
			},
			success: function (data)
			{
				this_User.load_user();

				$("#modal").iziModal('close');

				$('#modalForm')[0].reset();

				alertify.info('User Successfully Updated!');
			},
			error: function(jqXHR, errorStatus, errorThrown) 
            {
              console.log(errorStatus, errorThrown);
            }
		});
	};

	this_User.delete_user = function (id)
	{
		if (confirm("Are you sure you want to delete?"))
		{
			$.ajax({
				type: 'POST',
				url: base_url + 'Admin.php?action=delete_user',
				cache: false,
				data:
				{
					id : id
				},
				success: function (data)
				{
					this_User.load_user();
					alertify.error('User Successfully Deleted!');
				},
				error: function(jqXHR, errorStatus, errorThrown) 
	            {
	              console.log(errorStatus, errorThrown);
	            }
			});
		}
	};

	return this_User;

})();
//END THIS IS THE CLASS