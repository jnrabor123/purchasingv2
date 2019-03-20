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

	th, table.table-bordered.dataTable tbody td
	{

		vertical-align: middle;
	}

	.modal-content
	{
		border-top-right-radius: 30px;
        border-top-left-radius: 30px;
	}

	#view_modal .modal-dialog 
	{
      width:100%;
      height:100%;
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

    .design
	{
		border-radius: 15px; border: 1px solid #dc3545; color: #000; text-align: center; width: 90%;
	}
	.color-red
	{
		color: #dc3545;
	}
</style>



<div id="content-wrapper">

	<input type="hidden" id="section" value="<?php echo $_SESSION['section']; ?>" />

	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-1 col-md-1 col-lg-1">
			</div>

			<div class="col-sm-10 col-md-10 col-lg-10">

				<div class="card" style="border-radius: 50px 50px 20px 20px !important;">
					<div class="card-header bg-danger text-white" style="border-radius: 50px 50px 0px 0px !important;">
						<center><i class="fas fa-tv fa-2x"> DASHBOARD</i></center>
					</div>
					<div class="card-body loading">

						<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
						  <button type="button" class="btn btn-danger">FILTER BY </button>

						  <div class="btn-group" role="group">
						    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="btnChoose">CHOOSE</span> </button>
						    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						    </div>
						  </div>
						</div>

						<div class="table-responsive" id="divMonitoring">
							<br/>
							<table class="table table-bordered" id="tblMonitoring" width="100%" cellspacing="0">
								<thead>
									<tr align='center'>
										<th rowspan="2">Action</th>
										<th colspan="6">Request List</th>
										<th colspan="3">Approval</th>
									</tr>
									<tr align='center'>
										<th width="%">Control No.</th>
										<th width="%">Requestor</th>
										<th width="%">Date</th>
										<th width="%">Type</th>
										<th width="%">Supplier</th>
										<th width="%">Status</th>
										<th width="%">Section Superior</th>
										<th width="%">PC Incharge</th>
										<th width="%">PCWH Superior</th>
									</tr>
								</thead>
							</table>
						</div>

					</div>
				</div>

			</div>

			<div class="col-sm-1 col-md-1 col-lg-1">
			</div>


		</div>

		<br/>

	</div>
	

	<?php
	require_once APPPATH . 'view/template/footer.php';
	?>


	<script src="<?php echo base_url; ?>assets/scripts/cancellationorder/dashboard.js"></script>
	<script src="<?php echo base_url; ?>assets/scripts/login/login.js"></script>

</body>


</html>


  <!-- The Modal -->
  <div class="modal fade" id="view_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        
        <div class="modal-header modal-header-danger ">
          <h4 class="modal-title"><span class="fa fa-eye"></span> View </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        
        <div class="modal-body">
         
        	<div class="container loading_modal">

        		<div class="row">

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
			      			<label class="color-red">SUPPLIER</label><br/>
			      			<textarea class="design" rows="5" id="supplier" style="resize: none;" readonly></textarea>
			      		</div>

			      	<div class="col-sm-12 col-md-12 col-lg-12">

			      		<br/>
			      		<div class="table-responsive">
			      		<table class="table table-bordered" id="tblView" cellspacing="0">
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

        </div>
        
        
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-outline-danger" id="btn_received_encoded" onclick="Dashboard.finish_encode();">RECEIVED & ENCODED</button>
          <input type="hidden" id="txt_id" />
          <input type="hidden" id="txt_name" value="<?php echo $_SESSION['name'] ?>" /> -->
        </div>
        
      </div>
    </div>
  </div>
