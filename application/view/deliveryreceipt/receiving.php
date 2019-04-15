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
						<center><i class="fas fa-truck fa-2x"> RECEIVING</i></center>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<br/>
							<table class="table table-bordered" id="tblReceiving" width="100%" cellspacing="0">
								<thead>
									<tr align='center'>
										<th>Action</th>
										<th>Attention</th>
										<th>Request</th>
										<th>Control No.</th>
										<th>Status</th>
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


	<script src="<?php echo base_url; ?>assets/scripts/deliveryreceipt/receiving.js"></script>
	<script src="<?php echo base_url; ?>assets/scripts/login/login.js"></script>



</body>


</html>

<!-- RECEIVE MODALS -->
	<div id="modalReceive" data-iziModal-title="RECEIVING" data-iziModal-icon="fas fa-truck" hidden>
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
									<th>#</th>
									<th>Part No</th>
									<th>Rev</th>
									<th>Qty</th>
									<th>Actual</th>
									<th>Supplier</th>
									<th>DR INV No</th>
									<th>Remarks</th>
									<th>Action</th>
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

					</div>

					<br/>
					<h4><span class="badge badge-success">REMARKS </span></h4>
					<textarea class="form-control" style="height: 140px; resize: none; border-radius: 20px;" id="txtRemarks" name="txtRemarks" onkeyup="this.value = this.value.toUpperCase()" ></textarea>
					<br/>
					<center>
						<button type="submit" id="" class="btn btn-success btn-lg"><i class="fas fa-cart-plus"> RECEIVED</i></button>
						<input type="hidden" name="txtIdModal" id="txtIdModal" />
						<input type="hidden" name="txtNameModal" id="txtNameModal" value="<?php echo $_SESSION['name']; ?>" />

					</center>
				</div>

		</div>
		</form>
	</div>

<!-- RETURN MODALS -->
	<div id="modalReturn" data-iziModal-title="RETURN" data-iziModal-icon="fas fa-truck" hidden>
		<form method="post" id="modalReturnForm" enctype="multipart/form-data" autocomplete="off">
		<div class="row">

			<!-- ROW 1 -->
				<div class="col-sm-1 col-md-1 col-lg-1">
				</div>

				<div class="col-sm-10 col-md-10 col-lg-10">

					<br/>
					<h4><span class="badge badge-danger">PLEASE PROVIDE DETAILED REASON </span></h4>
					<center>
						<textarea class="form-control" style="height: 140px; resize: none; border-radius: 20px;" onkeyup="this.value = this.value.toUpperCase()" id="txtDetails" name="txtDetails"></textarea>
						<br/>
						<button type="button" id="" class="btn btn-danger btn-lg" onclick='DeliveryReceipt.btnreturn();'><i class="fas fa-times-circle"> RETURN</i></button>
					</center>
				</div>

				<div class="col-sm-1 col-md-1 col-lg-1">
					<input type="hidden" name="txtReturnName" id="txtReturnName" value="<?php echo $_SESSION['name']; ?>" />
				</div>

		</div>
		</form>
	</div>



