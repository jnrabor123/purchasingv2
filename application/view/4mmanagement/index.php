<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//required
require_once '../../config/setup.php';
//end required

require_once APPPATH . 'view/template/header.php';
?>

<div id="content-wrapper">

	<div class="container-fluid">

		<!-- Page Content -->
		<!-- <h1>SAMPLE MVC</h1>
		<div class="card mb-3">
            <div class="card-header">
				<i class="fas fa-table"> Table Example</i>
					
				<button class="btn btn-success btn-sm float-right" onclick='User.action("New")'>
					<i class="fas fa-plus-circle"></i>
				</button>

			</div>
            <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr align='center'>
								<th>ID</th>
								<th>Name</th>
								<th>Age</th>
								<th>Birthday</th>
								<th>Sex</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
            </div>
		</div>

	 -->
	</div>
	<!-- /.container-fluid -->

	<?php
	require_once APPPATH . 'view/template/footer.php';
	?>


	<script src="<?php echo base_url; ?>assets/scripts/login/login.js"></script>



</body>


</html>


<!-- MODALS -->
<!-- <div id="modal" data-iziModal-title="User Management" data-iziModal-icon="fas fa-user-circle" hidden>
	<form method="post" id="modalForm" enctype="multipart/form-data" autocomplete="off">
	<div class="row">

		<div class="form-group col-md-2"></div>
		<div class="form-group col-md-4">
			<label for="">First Name</label>
			<input type="text" class="form-control center-align" id="txtFirstName" onkeyup="this.value = this.value.toUpperCase()">
		</div>
		<div class="form-group col-md-4">
			<label for="">Last Name</label>
			<input type="text" class="form-control center-align" id="txtLastName" onkeyup="this.value = this.value.toUpperCase()">
		</div>
		<div class="form-group col-md-2"></div>

		<div class="form-group col-md-2"></div>
		<div class="form-group col-md-4">
			<label for="">Age</label>
			<input type="number" class="form-control center-align" id="txtAge">
		</div>
		<div class="form-group col-md-4">
			<label for="">Birthday</label>
			<input type="text" class="form-control center-align" id="txtBirthday">
		</div>
		<div class="form-group col-md-2"></div>

		<div class="form-group col-md-2"></div>
		<div class="form-group col-md-4">
			<label for="">Sex</label>
			<select class="form-control center-align" id="selectSex">
				<option selected disabled>Select</option>
				<option value="0">FEMALE</option>
				<option value="1">MALE</option>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label for="">Status</label>
			<select class="form-control center-align" id="selectStatus">
				<option selected disabled>Select</option>
				<option value="1">ACTIVE</option>
				<option value="0">DEACTIVATE</option>
			</select>
		</div>
		<div class="form-group col-md-2"></div>

		<div class="form-group col-md-2"></div>
		<div class="form-group col-md-4">
			<center>
			<button id="btnAdd" class="btn btn-success btn-lg" onclick='User.insert_user()'>
				<i class="fas fa-plus-circle"></i> Proceed
			</button>
			<button id="btnUpdate" class="btn btn-info btn-lg" onclick='User.update_user()'>
				<i class="fas fa-edit"></i> Update
			</button>
			</center>
		</div>
		<div class="form-group col-md-4">
			<center>
			<button type="button" class="btn btn-danger btn-lg" onclick='User.clear_modal()'>
				<i class="fas fa-minus-circle"></i> Clear
			</button>
			</center>
		</div>
		<div class="form-group col-md-2">
			<input type="hidden" class="form-control center-align" id="txtId">
		</div>

	</div>
	</form>
</div> -->







