<?php
defined('BASEPATH') or exit('No direct script access allowed');
$user_id = null;
$role = 0;
$dep = 0;
$patient_mediine_table = "";
$hospital_room_table = "";
$permission_array = $this->session->user_permission;
$branchpermission_array = $this->session->Branch_permission;
$branch_id = $this->session->user_session->branch_id;
if (isset($this->session->user_session)) {
	$session_data = $this->session->user_session;
	$user_id = $session_data->id;
	$role = $session_data->roles;
	$dep = $session_data->departments;
	$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
	$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
	$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
	$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
	$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
} else {
	redirect("");
}

	if(isset($this->session->user_session->default_access)){
	$default_access = $this->session->user_session->default_access;
	}else{
	$default_access = "";
	}



?>
<style type="text/css">
	.main-sidebar {
		margin-top: 30px !important;
	}

	.menu-header_section li a {
		color: white !important;
	}

	.main-sidebar .sidebar-menu li a {

		display: contents !important;
		color: black;
		font-weight: bold;
	}

	.main-sidebar .sidebar-menu a {

		text-decoration: none;
	}

	.menu-header_section {
		background: #891635 !important;
		color: white !important;
		padding: 5px 0px 5px 0px !important;
	}

	.menu-header_section1 {
		background: #bbb8b9 !important;
		color: black !important;
		padding: 5px 0px 5px 0px !important;
		font-weight: bold;
	}

	.active1 {
		color: white !important;
	}

	.menu-header_section1 a:hover {
		text-decoration: none;
	}

	.selectPatientInfoA {
		color: black !important;
		font-weight: bold !important;
	}

	.selectPatientInfoB {
		color: white !important;
		font-weight: bold !important;
	}


	.main-sidebar {
		display: block;
	}

	.main-sidebar1 {
		display: none;
	}

	.navbar {
		position: absolute;
	}

	.mobile_three {
		display: none;
	}

	@media (max-width: 800px) {
		.main-sidebar {
			display: none;
		}

		.mobile_search {
			display: none;
		}

		.mobile_three {
			display: block;
			margin-bottom: 0;


		}

		.main-sidebar1 {
			display: block;
			padding: 10px;
		}

		.navbar {
			position: relative;

		}

		.buttons .btn {
			margin: 0 3px 7px 0;
		}
		body.layout-2 .main-content1 {
			padding-top: 5px;
			padding-left: 5px;
			padding-right: 5px;
		}

	}

</style>
<!-- main sidebar menu start -->
<div class="main-sidebar ">
	<!-- brand start -->
	<div class="sidebar-brand">
		<?php if ($role == 1) { ?>
			<a href="<?php echo base_url(); ?>patient_info">Covid-19</a>
		<?php } else { ?>
			<a href="<?php echo base_url(); ?>admin/dashboard">Covid-19</a>
		<?php } ?>
	</div>
	<!-- brand end -->
	<div class="sidebar-brand sidebar-brand-sm">
		<a href="<?php echo base_url(); ?>dist/index">DP</a>
	</div>
	<!-- side menu start -->
	<div class="text-center">
		<ul class="sidebar-menu">
			<div class="text-center">
				<div class="profile-widget-header">
					<img alt="image" id="patient_profile" src="<?= base_url() ?>assets/img/avatar/avatar-1.png"
						 class="rounded-circle profile-widget-picture"
						 style="box-shadow: 0 4px 8px rgb(0 0 0 / 3%); width: 120px;position: relative;z-index: 1;">
				</div>
				<div class="mt-2">
					<b style="text-transform: uppercase;"><span id="patient_nameSidebar"></span></b>
				</div>
				<div class="">
					<small style="text-transform: uppercase;"><span id="patient_adharSidebar"></span></small>
				</div>
			</div>

			<?php
			if($default_access == 2){ ?>
					<a class="" id="homeURL" href="<?php echo base_url(); ?>icubedManagement"
			   style="<?php echo $this->uri->segment(1) == 'icubedManagement' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'icubedManagement' ? 'menu-header_section active' : 'menu-header_section1'; ?>">
					<span>Home</span>
				</li>
			</a>
		<?php	}else{ ?>
			<a class="" id="homeURL" href="<?php echo base_url(); ?>patient_info"
			   style="<?php echo $this->uri->segment(1) == 'patient_info' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'patient_info' ? 'menu-header_section active' : 'menu-header_section1'; ?>">
					<span>Home</span>
				</li>
			</a>
		 <?php }
				?>



			<div class="mt-2 panel-group d-none patientLeftSide" id="patient_info_bar">
				<div class="panel panel-default">
					<a data-toggle="collapse" onclick="selectPatientInfo()" class="selectPatientInfoA"
					   style="<?php echo $this->uri->segment(1) == 'form_view' ? 'color: #891635' : 'color:black'; ?>"
					   id="selectPatientInfoA" href="#collapse1">
						<div class="panel-heading">

							<div class="panel-title  <?php echo $this->uri->segment(1) == 'form_view' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
								 id="selectPatientInfo"
								 style="<?php echo $this->uri->segment(1) == 'form_view' ? 'color: white' : 'color:black'; ?>">
								Patient Info <i class="fa fa-angle-down"></i>
							</div>
							<!--								<div class="panel-title menu-header_section1">-->
							<!--									<a data-toggle="collapse" href="#collapse1" style="color: black!important;font-weight: bold;">Patient Info</a>-->
							<!--								</div>-->
						</div>
					</a>
					<div id="collapse1"
						 class="panel-collapse collapse <?php echo $this->uri->segment(1) == 'form_view' ? 'show' : '' ?>">
						<ul class="ml-2 mr-2 list-group">
							<?php
							if ($dep !== 0) {
								$departments = explode(',', $dep);
								$depArray = array();
								foreach ($departments as $department) {
									$departmentId = explode('|||', $department);
									if (count($departmentId) > 1) {
										$departObject = new stdClass();
										$departObject->id = $departmentId[1];
										$departObject->departmentName = $departmentId[2];
										$departObject->departmentSeq = $departmentId[3];
										if ((int)$departmentId[4] == 0) {
											array_push($depArray, $departObject);
										}
									}
								}

								usort($depArray, function ($a, $d) {
									if ($a->departmentSeq == $d->departmentSeq) {
										return 0;
									}
									return (int)$a->departmentSeq > (int)$d->departmentSeq ? 1 : -1;
								});
								if (!empty($departments) && count($departments) > 0) {
									foreach ($depArray as $depItems) {
										$dep_encode = urlencode(base64_encode($depItems->id));
										?>

										<li class="list-group-item border-0 pt-0 pb-0<?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
											<a class="nav-link"
											   href="<?php echo base_url(); ?>form_view/<?php echo $dep_encode ?>"
											   style="<?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'color: #891635' : 'color:black'; ?>">
												<span><?php echo $depItems->departmentName; ?></span>
											</a>
										</li>
									<?php  }
								}
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php

				if ( in_array("assign_bed", $branchpermission_array)) {
			?>

			<a class="patientLeftSide" href="<?php echo base_url(); ?>assignBed"
			   style="<?php echo $this->uri->segment(1) == 'assignBed' ? 'color: white' : 'color: black'; ?>">
					<li class="mt-2  <?php echo $this->uri->segment(1) == 'assignBed' ? 'menu-header_section active1' : 'menu-header_section1'; ?>"
					id="assign_bed_bar">

					<span>Assign Bed</span>

				</li>
			</a>
			<?php
				}

			if ($patient_mediine_table != "" && in_array("medication", $permission_array) && in_array("medication", $branchpermission_array)) {
				?>
				<a class="patientLeftSide" id="medication_list" href="<?php echo base_url(); ?>medicine"
				   style="<?php echo $this->uri->segment(1) == 'medicine' ? 'color: white' : 'color: black'; ?>">
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'medicine' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

						<span>Medication</span>

					</li>
				</a>

			<?php }
			if (in_array("billing", $permission_array) && in_array("billing", $branchpermission_array)) {
				?>
				<a class="" id="billinginfo_list" href="<?php echo base_url(); ?>billing"
				   style="<?php echo $this->uri->segment(1) == 'billing' ? 'color: white' : 'color: black'; ?>">
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'billing' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

						<span>Billing Info</span>

					</li>

				</a>

				<?php
			} ?>
			<?php
			if (in_array("billing_info", $permission_array) && in_array("billing_info", $branchpermission_array)) {
				?>
			<a class="" href="<?php echo base_url(); ?>billingMaster"
			   style="<?php echo $this->uri->segment(1) == 'billingMaster' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'billingMaster' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Billing</span>

				</li>

			</a>
			<?php
			} ?>
			<?php
			if (in_array("discharge_form", $permission_array) && in_array("discharge_form", $branchpermission_array)) { ?>
				<a class="patientLeftSide" href="<?php echo base_url(); ?>discharge"

				   style="<?php echo $this->uri->segment(1) == 'discharge' ? 'color: white' : 'color: black'; ?>">
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'discharge' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

						<span>Discharge</span>

					</li>
				</a>

			<?php }
			?>
			<?php

			if (in_array("discharge_report", $permission_array) && in_array("discharge_report", $branchpermission_array)) { ?>
				<a class="patientLeftSide" href="<?php echo base_url(); ?>discharge_report"
				   style="<?php echo $this->uri->segment(1) == 'discharge_report' ? 'color: white' : 'color: black'; ?>">
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'discharge_report' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

						<span>Discharge Report</span>

					</li>
				</a>
			<?php } ?>

			<?php

			if (in_array("service_order", $permission_array) && in_array("service_order", $branchpermission_array)) { ?>
				<a class="" id="serviceOrder_list" href="<?php echo base_url(); ?>serviceOrder"
				   style="<?php echo $this->uri->segment(1) == 'serviceOrder' ? 'color: white' : 'color: black'; ?>">
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'serviceOrder' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

						<span>Service Order</span>

					</li>
				</a>
			<?php } ?>
			<?php
			if (in_array("lab_report", $branchpermission_array)) { ?>
			<a class="" href="<?php echo base_url(); ?>labReport"
			   style="<?php echo $this->uri->segment(1) == 'labReport' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'labReport' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Lab Report</span>

				</li>
			</a>
			<?php } ?>
			<?php
			if (in_array("operation_details", $branchpermission_array)) { ?>
            <a class="" href="<?php echo base_url(); ?>operation_details"
			   style="<?php echo $this->uri->segment(1) == 'operation_details' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'operation_details' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Operation Details</span>

				</li>
			</a>
			<?php } ?>
			<?php
			if (in_array("patient_report", $branchpermission_array)) { ?>
			<a class="isIcu" href="<?php echo base_url(); ?>patientReport"
			   style="<?php echo $this->uri->segment(1) == 'patientReport' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'patientReport' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Patient Dashboard</span>

				</li>
			</a>
			<?php } ?>
			<?php
			if (in_array("icu_nursing_care", $branchpermission_array)) { ?>
			<a class="isIcu" href="<?php echo base_url(); ?>IcunursingCare"
			   style="<?php echo $this->uri->segment(1) == 'IcunursingCare' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'IcunursingCare' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Critical Care</span>

				</li>
			</a>
			<?php } ?>
			<?php
			if (in_array("consumable_order", $branchpermission_array)) { ?>
			<a class="" id="consumableOrder_list" href="<?php echo base_url(); ?>consumableOrder"
			   style="<?php echo $this->uri->segment(1) == 'consumableOrder' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'consumableOrder' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Consumable Order</span>

				</li>
			</a>
			<?php } ?>
			<?php
			if (in_array("payer_detail", $branchpermission_array)) { ?>
			<a class="" id="payerDetails_list" href="<?php
			$qparam = base64_encode(json_encode(array("branch_id"=>$this->session->user_session->branch_id)));
			echo base_url("payerDetails/25/148/".$qparam);
			?>"
			   style="<?php echo $this->uri->segment(1) == 'consumableOrder' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'payerDetails' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Payment</span>

				</li>
			</a>
			<?php } ?>
		</ul>
	</div>
	<!-- side menu close -->
</div>
<!-- main sidebar menu end -->
<!-- main sidebar menu1 start -->
<div class="main-sidebar1 mobile_menu_hide">
	<div class="media mb-1">
		<img alt="image" class="mr-3 rounded-circle" width="30" id="patient_profile1"
			 src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png">
		<div class="media-body">
			<div class="media-right" style="margin-top: -3px;"><span id="patient_adharSidebar1"
																	 style="font-size: 10px;"></span></div>
			<div class="media-title"><span id="patient_nameSidebar1" style="font-size: 12px;"></span></div>
			<!-- <div class="text-job text-muted"></div> -->
		</div>
	</div>
	<!-- button start -->
	<div class="buttons">
		<?php if($default_access == 2){ ?>
			<a id="homeURL" href="<?php echo base_url(); ?>icubedManagement" data-toggle="tooltip" data-placement="top" title="Home"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'icubedManagement' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-home"></i></a>
		<?php }else{ ?>
			<a href="<?php echo base_url(); ?>patient_info" data-toggle="tooltip" data-placement="top" title="Home"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'patient_info' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-home"></i></a>
		<?php } ?>

		<div class="dropdown d-inline">
			<button class="btn dropdown-toggle <?php echo $this->uri->segment(1) == 'form_view' ? 'btn-primary' : 'btn-light'; ?>"
					type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false">
				<i class="fas fa-user"></i>
			</button>
			<div class="dropdown-menu" x-placement="bottom-start"
				 style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
				<?php
				if ($dep !== 0) {
					$departments = explode(',', $dep);
					$depArray = array();
					foreach ($departments as $department) {
						$departmentId = explode('|||', $department);
						if (count($departmentId) > 1) {
							$departObject = new stdClass();
							$departObject->id = $departmentId[1];
							$departObject->departmentName = $departmentId[2];
							$departObject->departmentSeq = $departmentId[3];
//												array_push($depArray, $departObject);
							if ((int)$departmentId[4] == 0) {
								array_push($depArray, $departObject);
							}
						}
					}

					usort($depArray, function ($a, $d) {
						if ($a->departmentSeq == $d->departmentSeq) {
							return 0;
						}
						return (int)$a->departmentSeq > (int)$d->departmentSeq ? 1 : -1;
					});
					if (!empty($departments) && count($departments) > 0) {
						foreach ($depArray as $depItems) {
							$dep_encode = urlencode(base64_encode($depItems->id));

							?>


							<li class="list-group-item border-0 pt-0 pb-0<?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
								<a class="nav-link"
								   href="<?php echo base_url(); ?>form_view/<?php echo $dep_encode ?>"
								   style="<?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'color: #891635' : 'color:black'; ?>">
									<span><?php echo $depItems->departmentName; ?></span>
								</a>
							</li>
						<?php }
					}
				}
				?>

			</div>
		</div>
		<?php
//		if ($hospital_room_table != "") {
			?>
			<a href="<?php echo base_url(); ?>assignBed" data-toggle="tooltip" data-placement="top" title="Assign bed"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'assignBed' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-bed"></i></a>
			<?php
//		}
			?>
		<?php if ($patient_mediine_table != "" && in_array("medication", $permission_array)) {
				?>
			<a href="<?php echo base_url(); ?>medicine" data-toggle="tooltip" data-placement="top" title="Medication"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'medicine' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-capsules"></i></a>
		<?php } ?>
		<?php if (in_array("billing", $permission_array)) { ?>
		<a href="<?php echo base_url(); ?>billing" data-toggle="tooltip" data-placement="top" title="Billing Info"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'billing' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-file-invoice"></i></a>
		<?php } ?>
		<a href="<?php echo base_url(); ?>billingMaster" data-toggle="tooltip" data-placement="top" title="Billing"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'billingMaster' ? 'btn-primary' : 'btn-light'; ?>"><i class="fas fa-file-invoice-dollar"></i></a>
		<?php if (in_array("discharge_form", $permission_array)) { ?>
		<a href="<?php echo base_url(); ?>discharge" data-toggle="tooltip" data-placement="top" title="Discharge"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'discharge' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-ambulance"></i></a>
		<?php } ?>
		<?php if (in_array("discharge_report", $permission_array)) { ?>
		<a href="<?php echo base_url(); ?>discharge_report" data-toggle="tooltip" data-placement="top" title="Discharge Report"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'discharge_report' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-file-medical"></i></a>
		<?php } ?>
		<!-- <a class="" href="<?php echo base_url(); ?>discharge_report"
			   style="<?php echo $this->uri->segment(1) == 'discharge_report' ? 'color: white' : 'color: black'; ?>">
				<li class="mt-2 <?php echo $this->uri->segment(1) == 'discharge_report' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

					<span>Discharge Report</span>

				</li>
			</a> -->
		<?php if (in_array("service_order", $permission_array)) { ?>
		<a href="<?php echo base_url(); ?>serviceOrder" data-toggle="tooltip" data-placement="top" title="Service Order"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'serviceOrder' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-file-alt"></i></a>
		<?php } ?>
	<!-- 	<a href="<?php echo base_url(); ?>serviceOrder1"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'serviceOrder1' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-file"></i></a> -->

			<a href="<?php echo base_url(); ?>labReport" data-toggle="tooltip" data-placement="top" title="Lab Report"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'labReport' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-file-medical-alt"></i></a>

			<a href="<?php echo base_url(); ?>patientReport" data-toggle="tooltip" data-placement="top" title="Patient Report"
		   class="isIcu btn btn-icon <?php echo $this->uri->segment(1) == 'patientReport' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-file-contract"></i></a>

			<a href="<?php echo base_url(); ?>IcunursingCare" data-toggle="tooltip" data-placement="top" title="Critical Care"
		   class="isIcu btn btn-icon <?php echo $this->uri->segment(1) == 'IcunursingCare' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-diagnoses"></i></a>

			<a href="<?php echo base_url(); ?>consumableOrder" data-toggle="tooltip" data-placement="top" title="Consumable order"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'consumableOrder' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-thermometer"></i></a>

	</div>
	<!-- button close -->
</div>
<!-- main sidebar menu1 end -->
