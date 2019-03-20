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

		<div class="row">

			<div class="col-sm-2 col-md-2 col-lg-2">
			</div>

			<div class="col-sm-8 col-md-8 col-lg-8">

				<div class="card" style="border-radius: 50px 50px 20px 20px !important;">
					<div class="card-header bg-info text-white" style="border-radius: 50px 50px 0px 0px !important;">
						<center><i class="fas fa-tv fa-2x"> MONITORING</i></center>
					</div>
					<div class="card-body">

						<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
						  <button type="button" class="btn btn-info">FILTER BY </button>

						  <div class="btn-group" role="group">
						    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="btnChoose">CHOOSE</span> </button>
						    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						      <label class="dropdown-item" onclick="DeliveryReceipt.controlno();">CONTROL NUMBER </label>
						      <label class="dropdown-item" onclick="DeliveryReceipt.partno();">PART NUMBER </label>
						    </div>
						  </div>
						</div>

						<div class="table-responsive" id="divMonitoring">
							<br/>
							<table class="table table-bordered" id="tblMonitoring" width="100%" cellspacing="0">
								<thead>
									<tr align='center'>
										<th width="20%">Action</th>
										<th width="15%">Request</th>
										<th width="15%">Received</th>
										<th width="20%">Control No.</th>
										<th width="20%">In-Charge</th>
										<th width="10%">Status</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>

						<div class="table-responsive" id="divMonitoringRequest">
							<br/>
							<table class="table table-bordered" id="tblMonitoringRequest" width="100%" cellspacing="0">
								<thead>
									<tr align='center'>
										<th width="15%">Action</th>
										<th width="20%">Control No.</th>
										<th width="15%">Part No.</th>
										<th width="10%">Rev</th>
										<th width="20%">Supplier</th>
										<th width="20%">Status</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>

					</div>
				</div>

			</div>

			<div class="col-sm-2 col-md-2 col-lg-2">
			</div>


		</div>

		<br/>

	</div>
	

	<?php
	require_once APPPATH . 'view/template/footer.php';
	?>


	<script src="<?php echo base_url; ?>assets/scripts/deliveryreceipt/monitoring.js"></script>
	<script src="<?php echo base_url; ?>assets/scripts/login/login.js"></script>


</body>


</html>


<!-- RECEIVE MODALS -->
<div id="modalReceive" data-iziModal-title="RECEIVED" data-iziModal-icon="fas fa-truck" hidden>
	<form method="post" id="modalReceiveForm" enctype="multipart/form-data" autocomplete="off">
	<div class="row">

		<!-- ROW 1 -->
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<br/>
					<h4><span class="badge badge-success">DETAILS </span></h4>
					<table class="table table-bordered" id="tblActualReceiving" width="100%" cellspacing="0">
						<thead>
							<tr align='center'>
								<th width="15%">Part No</th>
								<th width="15%">Rev</th>
								<th width="15%">Qty</th>
								<th width="15%">Actual</th>
								<th width="20%">Received By</th>
								<th width="20%">Received Date</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>

					<br/>
					<h4><span class="badge badge-success">DOCUMENTS </span></h4>
					<table class="table table-bordered" id="tblAttachments" width="100%" cellspacing="0">
						<thead>
							<tr align='center'>
								<th>Description</th>
								<th>Location</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>

					<br/>
					<h4><span class="badge badge-success">REMARKS </span></h4>
					<textarea class="form-control" style="height: 140px; resize: none; border-radius: 20px;" id="txtRemarks" name="txtRemarks" onkeyup="this.value = this.value.toUpperCase()" readonly></textarea>
					<br/>

				</div>

			</div>

	</div>
	</form>
</div>

<!-- RETURN MODALS -->
<div id="modalReturn" data-iziModal-title="RETURNED" data-iziModal-icon="fas fa-truck" hidden>
	<form method="post" id="modalReturnForm" enctype="multipart/form-data" autocomplete="off">
	<div class="row">

		<!-- ROW 1 -->
			<div class="col-sm-1 col-md-1 col-lg-1">
			</div>

			<div class="col-sm-10 col-md-10 col-lg-10">

				<h4><span class="badge badge-info">RETURN BY </span></h4>
				<input type="text" class="form-control" id="txtReturnName" name="txtReturnName" style="border-radius: 50px;" readonly>
				<br/>

				<h4><span class="badge badge-info">DATE </span></h4>
				<input type="text" class="form-control" id="txtReturnDate" name="txtReturnDate" style="border-radius: 50px;" readonly>
				<br/>

				<h4><span class="badge badge-info">DETAILED REASON </span></h4>
				<center>
					<textarea class="form-control" style="height: 140px; resize: none; border-radius: 20px;" id="txtReturnDetails" name="txtReturnDetails" readonly></textarea>
				</center>
			</div>

			<div class="col-sm-1 col-md-1 col-lg-1">
			</div>

	</div>
	</form>
</div>

<!-- CANCEL MODALS -->
<div id="modalCancel" data-iziModal-title="CANCELLED" data-iziModal-icon="fas fa-bell-slash" hidden>
	<form method="post" id="modalCancelForm" enctype="multipart/form-data" autocomplete="off">
	<div class="row">

		<!-- ROW 1 -->
			<div class="col-sm-1 col-md-1 col-lg-1">
			</div>

			<div class="col-sm-10 col-md-10 col-lg-10">

				<h4><span class="badge badge-info">RETURN BY </span></h4>
				<input type="text" class="form-control" id="txtCancelName" name="txtCancelName" style="border-radius: 50px; " value="<?php echo $_SESSION['name']; ?> " readonly>
				<br/>

				<h4><span class="badge badge-info">DATE </span></h4>
				<input type="text" class="form-control" id="txtCancelDate" name="txtCancelDate" style="border-radius: 50px; " value="<?php echo date('m/d/Y'); ?>" readonly>
				<br/>

				<h4><span class="badge badge-info">DETAILED REASON </span></h4>
				<center>
					<textarea class="form-control" style="height: 140px; resize: none; border-radius: 20px;" id="txtCancelDetails" name="txtCancelDetails" onkeyup="this.value = this.value.toUpperCase()"></textarea>
				</center>
				<br/>

				<center>
					<button id="btnCancel" onclick="DeliveryReceipt.saveCancel();" class="btn btn-success btn-lg"> SUBMIT</button>
					<input type="hidden" name="txtIdCancel" id="txtIdCancel">
				</center>				

			</div>

			<div class="col-sm-1 col-md-1 col-lg-1">
			</div>

	</div>
	</form>
</div>




