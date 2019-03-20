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

			<!-- FIRST ROW -->
				<div class="col-sm-2 col-md-2 col-lg-2">
				</div>

				<div class="col-sm-8 col-md-8 col-lg-8">

					<div class="card" style="border-radius: 50px 50px 20px 20px !important;">
						<div class="card-header bg-info text-white" style="border-radius: 50px 50px 0px 0px !important;">
							<center><i class="fas fa-file-invoice fa-2x"> DELIVERY RECEIPT</i></center>
						</div>
						<div class="card-body">

							<form method="post" id="drForm" enctype="multipart/form-data" autocomplete="off">

								<div class="row">
									<!-- HEADER -->
										<div class="col-sm-4 col-md-4 col-lg-4">
											<br/>
											<h4><span class="badge badge-info">ATTN: </span></h4>
											<select class="form-control" style="border-radius: 50px; text-align-last: center;" id="txtRequestAttention" name="txtRequestAttention">
												<option selected disabled>CHOOSE</option>
											</select>
											<h4><span class="badge badge-info">IN-CHARGE </span></h4>
											<input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtRequestIncharge" name="txtRequestIncharge" value="<?php echo $_SESSION['name']; ?>" readonly>
										</div>

										<div class="col-sm-4 col-md-4 col-lg-4">
										</div>

										<div class="col-sm-4 col-md-4 col-lg-4">
											<br/>
											<h4><span class="badge badge-info">DATE </span></h4>
											<input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtRequestDate" name="txtRequestDate" readonly>
											<h4><span class="badge badge-info">CONTROL NO. </span></h4>
											<input type="text" class="form-control" style="border-radius: 50px; text-align: center;" placeholder="SYSTEM GENERATED" readonly>
										</div>

										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="table-responsive">
												<br/>
												<button type="button" class="btn btn-success pull-left" data-toggle="tooltip" title="Remove" style="margin-bottom: 5px;" onclick="DeliveryReceipt.add_row(); "><i class="fa fa-plus"></i></button>
												<table class="table table-bordered" id="dynamic_drtrable" width="100%" cellspacing="0">
													<thead>
														<tr align='center'>
															<th width="%">Part No.</th>
															<th width="%">Rev</th>
															<th width="%">Qty</th>
															<th width="%">Supplier</th>
															<th width="%">DR / INV No.</th>
															<th width="%">Remarks</th>
															<th width="%">&nbsp;</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>

										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="table-responsive">
												<br/>
												<button type="button" class="btn btn-success pull-left" data-toggle="tooltip" title="Remove" style="margin-bottom: 5px;" onclick="DeliveryReceipt.add_attachment(); "><i class="fa fa-plus"></i></button>
												<table class="table table-bordered" id="dynamic_dr_attachment" width="100%" cellspacing="0">
													<thead>
														<tr align='center'>
															<th width="45%">Description</th>
															<th width="45%">Location</th>
															<th width="10%">&nbsp;</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>


									<!-- HIDDEN -->
										<input type="hidden" id="" />
								</div>

								<!-- BUTTON -->
									<br/><br/>
									<center>
										<button type="submit" class="btn btn-info btn-lg" id="btnSubmit" name="btnSubmit"><i class="fas fa-check-circle"> PROCEED</i></button> 
										<button type="button" class="btn btn-danger btn-lg" onclick='DeliveryReceipt.clear();'><i class="fas fa-minus-circle"> CLEAR</i></button>
									</center>
							
							</form>
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


	<script src="<?php echo base_url; ?>assets/scripts/deliveryreceipt/request.js"></script>
	<script src="<?php echo base_url; ?>assets/scripts/login/login.js"></script>



</body>


</html>




