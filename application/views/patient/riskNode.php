<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$session_data = $this->session->user_session;
	$user_type = $session_data->user_type;
	$role = $session_data->roles;
?>
<style>
		.complete {
			stroke: #3ac47d !important;
			fill: #3ac47d !important;
		}

		g.node {
			cursor: pointer;
		}

		.node-details {
			stroke: #40b92e !important;
			fill: #3ac47d !important;
		}

		.node-title {
			fill: #5c55af !important;
			stroke: black !important;
		}

		.node-details-close {
			stroke: #2593d9 !important;
			fill: #2593d9 !important;
		}

		.select2-container {
			width: 100% !important;
		}

		.select2-container .select2-selection--multiple .select2-selection__rendered {
			display: flex !important;
			flex-direction: column !important;

		}
		.lightRed
		{
			stroke: #f70d0d82 !important;
			fill: #f70d0d82 !important;
		}
		.lightGreen
		{
			stroke: #3ac47d73 !important;
			fill: #3ac47d73 !important;
		}
		.darkGreen
		{
			stroke: #40b92e !important;
			fill: #3ac47d !important;
		}
		.darkRed
		{
			stroke: #dc14149e !important;
			fill: #dc14149e !important;
		}
		.extremRed
		{
			stroke: #DC143C !important;
			fill: #DC143C !important;
		}

	</style>
<!-- Main Content start -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-body">
			<div class="">
				<div class="section-header card-primary">
					<h1 style="color: #891635">Risk</h1>
					<div class="card-header-action d-flex" style="margin-left: auto; ">
					
					
					
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<div class="col-md-12" id="treebox" style="height: 70vh;"></div>
				</div>
			</div>
		</div>
	</section>
</div>





<?php $this->load->view('_partials/footer'); ?>
