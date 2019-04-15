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

<style type="text/css">
	.table thead th, .table tbody td 
	{
    	vertical-align: middle !important;
	}
	.round 
	{
		border-radius: 50px; 
		text-align: center;
	}
	.img-rotating
	{
		transition: all 1.5s ease-in-out 0s;
	}

	.img-rotating:hover
	{
		cursor: pointer;
		transform: rotateY(360deg);
		transition: all 1.5s ease-in-out 0s;
	}
</style>

<div id="content-wrapper">

	<div class="container-fluid">

		<div class="row">

				<div class="col-sm-2 col-md-2 col-lg-2">
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4">
					<div class="card" style="width:400px; border: 2px solid #dc3545;">
					<center>
					  <img class="card-img-top img-rotating" src="../../../assets/logo/upload.jpg" style="width: 70%; height: 200px; border-radius: 50%; border: 2px solid #dc3545;" alt="Card image">
					</center>
					  <div class="card-body">
					  	<center>
					    	<a href="#" class="btn btn-outline-danger" onclick="Cancellationorder.show_upload();">UPLOADING</a>
					    </center>
					  </div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-lg-4">
					<div class="card" style="width:400px; border: 2px solid #dc3545;">
					<center>
					  <img class="card-img-top img-rotating" src="../../../assets/logo/keyboard.jpg" style="width: 70%; height: 200px; border-radius: 50%; border: 2px solid #dc3545;" alt="Card image">
					</center>
					  <div class="card-body">
					  	<center>
					    	<button class="btn btn-outline-danger" onclick="Cancellationorder.show_manual();">MANUAL INPUT</button>
					    </center>
					  </div>
					</div>
				</div>

				<div class="col-sm-2 col-md-2 col-lg-2">
				</div>

			<!-- FIRST ROW -->
					
					<div class="col-sm-1 col-md-1 col-lg-1" id="div_manual1">
					</div>

					<div class="col-sm-10 col-md-10 col-lg-10" id="div_manual2">
						<div class="card mt-5" style="border-radius: 50px 50px 20px 20px !important;">
							<div class="card-header bg-danger text-white" style="border-radius: 50px 50px 0px 0px !important;">
								<center><i class="fas fa-file-invoice fa-2x"> MANUAL INPUT</i></center>
							</div>

							<div class="card-body loading_manual">

								<form method="post" id="manualForm" enctype="multipart/form-data" autocomplete="off">

									<div class="row">
										<!-- HEADER -->
											<div class="col-sm-4 col-md-4 col-lg-4">
												<h4><span class="badge badge-danger">DATE </span></h4>
												<input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtRequestDate" name="txtRequestDate" readonly>

												<!-- <h4><span class="badge badge-danger">IN-CHARGE </span></h4>
												<input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="" name="" value="<?php echo $_SESSION['name']; ?>" readonly> -->

												<h4><span class="badge badge-danger">DOCUMENT </span></h4>
												<input type="file" class="form-control" style="border-radius: 50px; text-align: center;" id="txtAttachment" name="txtAttachment">
											</div>

											<div class="col-sm-4 col-md-4 col-lg-4">
											</div>

											<div class="col-sm-4 col-md-4 col-lg-4">
												<h4><span class="badge badge-danger">SUPPLIER</span></h4>
												<input type="text" class="form-control" style="border-radius: 50px; text-align: center;" id="txtRequestSupplier" name="txtRequestSupplier" onkeyup="this.value = this.value.toUpperCase()">
												
												<h4><span class="badge badge-danger">REQUEST TYPE</span></h4>
												<select class="form-control" style="border-radius: 50px; text-align-last: center;" id="txtRequestType" name="txtRequestType">
													<option selected disabled>CHOOSE</option>
													<option value="P.O ISSUANCE">P.O ISSUANCE</option>
													<option value="P.O CANCELLATION">P.O CANCELLATION</option>
													<option value="M.O ISSUANCE">M.O ISSUANCE</option>
													<option value="M.O CANCELLATION">M.O CANCELLATION</option>
												</select>
											</div>

											<div class="col-sm-12 col-md-12 col-lg-12">
													<br/>
													<button type="button" class="btn btn-danger pull-left" data-toggle="tooltip" title="Add" style="margin-bottom: 5px;" onclick="Cancellationorder.add_row(); "><i class="fa fa-plus"></i></button>
												<div class="table-responsive">
													<table class="table table-bordered" id="dynamic_rstable" style="width: 2000px; overflow-x:auto;" cellspacing="0">
														<thead>
															<tr align='center'>
																<th width="10%" rowspan="2">Part No.</th>
																<th width="4%" rowspan="2">Rev</th>
																<th width="6%" rowspan="2">Qty</th>
																<th width="10%" rowspan="2">PO No.</th>
																<th width="10%" rowspan="2">PO Code</th>
																<th width="10%" rowspan="2">Receipt No.</th>
																<th width="10%" rowspan="2">Prod Order No.</th>
																<th width="10%" rowspan="2">Delivery Date <br/> (YYYY-MM-DD)</th>
																<th width="10%" colspan="2">Supplier's Answer</th>
																<th width="15%" rowspan="2">Reason</th>
																<th width="5%" rowspan="2">&nbsp;</th>
															</tr>
															<tr align='center'>
																<th>OK</th>
																<th>NG</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
											</div>

										<!-- HIDDEN -->
											<input type="hidden" id="session_id" name="session_id" value="<?php echo $_SESSION['incharge']; ?>" />
											<input type="hidden" id="session_section" name="session_section" value="<?php echo strtoupper($_SESSION['section']); ?>" />
											<input type="hidden" id="generate_code" name="generate_code" />
									</div>

									<!-- BUTTON -->
										<br/><br/>
										<center>
											<button type="submit" class="btn btn-outline-info btn-lg" id="" name=""><i class="fas fa-check-circle"> PROCEED</i></button> 
											<button type="button" class="btn btn-outline-info btn-lg" onclick='Cancellationorder.clear();'><i class="fas fa-minus-circle"> CLEAR</i></button>
										</center>
								
								</form>
							</div>
						</div>
					</div>

					<div class="col-sm-1 col-md-1 col-lg-1" id="div_manual3">
					</div>
				

			<!-- SECOND ROW -->
				
					<div class="col-sm-3 col-md-3 col-lg-3" id="div_upload1">
					</div>

					<div class="col-sm-6 col-md-6 col-lg-6" id="div_upload2">
						<div class="card mt-5" style="border-radius: 50px 50px 20px 20px !important;">
							<div class="card-header bg-danger text-white" style="border-radius: 50px 50px 0px 0px !important;">
								<center><i class="fas fa-file-invoice fa-2x"> UPLOADING</i></center>
							</div>

							<div class="card-body loading_upload">
								<h4><span class="badge badge-danger">FORM</span></h4>
								<input type="file" class="form-control" style="border-radius: 50px; text-align: center;" id="file_upload" name="file_upload">

								<h4><span class="badge badge-danger">DOCUMENT </span></h4>
								<input type="file" class="form-control" style="border-radius: 50px; text-align: center;" id="txtAttachment_upload" name="txtAttachment_upload">

								<br/><br/>

								<center>
									<button type="button" class="btn btn-outline-info btn-lg" onclick="Cancellationorder.download();"><i class="fas fa-arrow-circle-down"> DOWNLOAD FORM</i></button>
									<button type="button" class="btn btn-outline-info btn-lg" onclick="Cancellationorder.upload();" ><i class="fas fa-arrow-circle-up"> UPLOAD</i></button>
								</center>
							</div>
						</div>
					</div>

					<div class="col-sm-3 col-md-3 col-lg-3" id="div_upload3">
					</div>
				

		</div>

		<br/>

	</div>
	

	<?php
	require_once APPPATH . 'view/template/footer.php';
	?>


	<script src="<?php echo base_url; ?>assets/scripts/cancellationorder/request.js"></script>
	<script src="<?php echo base_url; ?>assets/scripts/login/login.js"></script>



</body>


</html>

