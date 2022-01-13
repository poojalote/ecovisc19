<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>

	table.dataTable tbody td {
		word-break: break-word;
		vertical-align: top;
	}

	div.wrapDiv {
		white-space: nowrap;
		width: 100px;

		overflow: hidden;
		text-overflow: ellipsis;
	}

	div.wrapDiv:hover {
		overflow: visible;
		white-space: normal;

	}

	.bundle_div {
		padding: 35px;
		border-top: 5px solid #d3d3d3;

	}

	.text-muted {
		font-size: 12px;
	}

	.card_my_header {
		border-bottom: 1px solid #f9f9f9;

		width: 100%;
		/*min-height: 70px;*/
		padding: 5px 5px;

		text-align: center;
	}

	.right_side_card {
		border-radius: 0px 0px 20px 20px;
		border: 1px: solid #f1f1f1;
		padding: 23px;
	}

	.right_side_card_middle {
		border: 1px: solid #f1f1f1;
		padding: 23px;
	}

	.right_side_card_top {
		border-radius: 20px 20px 0px 0px;
		border: 1px: solid #f1f1f1;
		padding: 23px;
	}

	
	.diagonal_divline_l {
	  width:25%;
	  background: linear-gradient(to top right, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.diagonal_divline_r {
	  width:25%;
	  background: linear-gradient(to bottom right, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.diagonal_divline_b {
	  width:25%;
	  background: linear-gradient(to left bottom, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.diagonal_divline_bl {
	  width:25%;
	  background: linear-gradient(to bottom right, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.border_bottom
	{
		border-bottom: 1px solid #aaa;
	}
	.border_right
	{
		border-right: 1px solid #aaa;

	}
	table .collapse.in {
	    display: table-row !important;
	}
</style>

<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<!-- <div class="section-header" style="border-top: 2px solid #891635">
			<h1> Sample Collection</h1>
		</div> -->
		<div class="section-header card-primary">
			<h1 style="color: #891635">Critical Care</h1>

		</div>
		<div class="section-body" style="">
			<div class="">
				<div class="card">
					<div class="card-body">
						<table class="table-bordered" style="width: 100%">
							<thead>
								<tr>
								<th></th>
								<th>Now</th>
								<tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<a class="btn btn-link" style="color: #891635!important;" data-toggle="collapse"
									   href="#newSchedulePanel"
									   role="button"
									   aria-expanded="true" aria-controls="collapseExample">
											<i class="fa fa-plus"></i>
										</a>
										Vitals
									</td>
									<td></td>

								</tr>
								
									<tr>
										<div class="collapse " id="newSchedulePanel">
										<td>Temperature</td>
										<td><input type="number" name="v_tem" id="v_tem" class="form-control"></td>
										</div>
									</tr>
									<tr>
										<td>Temperature</td>
										<td><input type="number" name="v_tem" id="v_tem" class="form-control"></td>
									</tr>
								
								<tr>
									<td>Ventilator</td>
									<td></td>
								</tr>
								<tr>
									<td>DRUG Infusion</td>
									<td></td>
								</tr>
								<tr>
									<td>BOLUS</td>
									<td></td>
								</tr>
								<tr>
									<td>IV Fluids</td>
									<td></td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
	</section>
</div>


<?php $this->load->view('_partials/footer'); ?>



