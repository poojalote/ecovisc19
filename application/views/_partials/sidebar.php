<?php
defined('BASEPATH') or exit('No direct script access allowed');
$user_id = null;
$role = 0;
$dep = 0;
$patient_mediine_table = "";
$hospital_room_table = "";
$user_type = 1;
if (isset($this->session->user_session)) {
	$session_data = $this->session->user_session;
	$user_id = $session_data->id;
	$role = $session_data->roles;
	$dep = $session_data->departments;
	$user_type = $session_data->user_type;
	$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
	$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
	$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
	$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
	$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
} else {
	redirect("");
}

?>

<div class="main-sidebar sidebar-style-2">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand">
			<?php if ($role == 1) { ?>
				<a href="<?php echo base_url(); ?>patient_info"></a>
			<?php } else { ?>
				<a href="<?php echo base_url(); ?>admin/dashboard"></a>
			<?php } ?>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="<?php echo base_url(); ?>dist/index">DP</a>
		</div>
		<ul class="sidebar-menu">
			<?php if ($role == 1) { ?>
				<li class="menu-header">Dashboard</li>
				<li class="<?php echo $this->uri->segment(2) == 'view_dashboard' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin/dashboard">
						<i class="fas fa-fire"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="menu-header">Admin</li>
				<li class="<?php echo $this->uri->segment(2) == 'view_companies' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin/view_companies">
						<i class="fas fa-swatchbook"></i>
						<span>Companies</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(2) == 'view_branch' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin/view_branch">
						<i class="fas fa-hospital"></i>
						<span>Branches</span>
					</a>
				</li>
                <li class="<?php echo $this->uri->segment(2) == 'view_lab_branch' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>admin/view_lab_branch">
                        <i class="fas fa-hospital"></i>
                        <span>Lab Branches</span>
                    </a>
                </li>
				<li class="<?php echo $this->uri->segment(2) == 'view_departments' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin/view_departments">
						<i class="fas fa-swatchbook"></i>
						<span>Departments</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(2) == 'view_user' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin/view_user">
						<i class="fas fa-users"></i>
						<span>View Users</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(2) == 'patient_info' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin/patient_info">
						<i class="fas fa-procedures"></i>
						<span>Patients</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(2) == 'Reports_query' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>admin/Reports_query">
						<i class="fas fa-procedures"></i>
						<span>Reports</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(1) == 'access_management' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>access_management">
						<i class="fas fa-keyboard"></i>
						<span>Access Management</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(1) == 'user_management' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>user_management">
						<i class="fas fa-users"></i>
						<span>User Management</span>
					</a>
				</li>
                <li class="<?php echo $this->uri->segment(2) == 'Html_form' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>admin/Html_form">
                        <i class="fas fa-procedures"></i>
                        <span>Html Form</span>
                    </a>
                </li>
                <!--<li class="<?php echo $this->uri->segment(1) == 'html_form_view' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>html_form_view/75">
						<i class="fas fa-procedures"></i>
						<span>Html Form View</span>
					</a>
				</li>-->
                <li class="<?php echo $this->uri->segment(2) == 'HtmlPageTemplate' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>admin/HtmlPageTemplate">
                        <i class="fas fa-procedures"></i>
                        <span>Html Page</span>
                    </a>
                </li>
                <li class="<?php echo $this->uri->segment(1) == 'table_creation' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>table_creation">
                        <i class="fas fa-procedures"></i>
                        <span>Database</span>
                    </a>
                </li>
                <!-- <li class="<?php echo $this->uri->segment(1) == 'hrms_system' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>hrms_system">
						<i class="fas fa-procedures"></i>
						<span>HRMS System</span>
					</a>
				</li> -->
                <li class="<?php echo $this->uri->segment(1) == 'html_navigation' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>html_navigation/18/null/null">
                        <i class="fas fa-procedures"></i>
                        <span>Html Navigation</span>
                    </a>
                </li>
                <li class="<?php echo $this->uri->segment(1) == 'report_maker' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>report_maker">
                        <i class="fas fa-procedures"></i>
                        <span>Report Maker</span>
                    </a>
                </li>
                <li class="<?php echo $this->uri->segment(1) == 'branch_access_management' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>branch_access_management">
                        <i class="fas fa-keyboard"></i>
                        <span>Branch Level Access</span>
                    </a>
                </li>
                <li class="<?php echo $this->uri->segment(1) == 'branch_access_management' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>labMasterData">
                        <i class="fas fa-keyboard"></i>
                        <span>Lab Master Data</span>
                    </a>
                </li>
			<?php } else if ($role == 2 && $this->uri->segment(1) !== "company") { ?>
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
				</style>
				<div class="text-center">
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
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'patient_info' ? 'menu-header_section active' : 'menu-header_section1'; ?>">
						<a class="nav-link" href="<?php echo base_url(); ?>patient_info"
						   style="<?php echo $this->uri->segment(1) == 'patient_info' ? 'color: white' : 'color: black'; ?>">
							<span>Home</span>
						</a>
					</li>

					<div class="mt-2 panel-group d-none" id="patient_info_bar">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="panel-title  <?php echo $this->uri->segment(1) == 'form_view' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
									 id="selectPatientInfo">
									<a data-toggle="collapse" onclick="selectPatientInfo()" class="selectPatientInfoA"
									   style="<?php echo $this->uri->segment(1) == 'form_view' ? 'color: #891635' : 'color:black'; ?>"
									   id="selectPatientInfoA" href="#collapse1">Patient Update <i
												class="fa fa-angle-down"></i></a>
								</div>
								<!--								<div class="panel-title menu-header_section1">-->
								<!--									<a data-toggle="collapse" href="#collapse1" style="color: black!important;font-weight: bold;">Patient Info</a>-->
								<!--								</div>-->
							</div>
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
												if ((int)$departmentId[4] != 1) {
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
								</ul>
							</div>
						</div>
					</div>
					<?php
					if ($hospital_room_table != "") {
						?>
						<li class="mt-2 d-none <?php echo $this->uri->segment(1) == 'assignBed' ? 'menu-header_section active1' : 'menu-header_section1'; ?>"
							id="assign_bed_bar">
							<a class="nav-link" href="<?php echo base_url(); ?>assignBed"
							   style="<?php echo $this->uri->segment(1) == 'assignBed' ? 'color: white' : 'color: black'; ?>">
								<span>Assign Bed</span>
							</a>
						</li>
						<?php
					}
					if ($patient_mediine_table != "") {
						?>
						<li class="mt-2 <?php echo $this->uri->segment(1) == 'medicine' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
							<a class="nav-link" href="<?php echo base_url(); ?>medicine"
							   style="<?php echo $this->uri->segment(1) == 'medicine' ? 'color: white' : 'color: black'; ?>">
								<span>Medication</span>
							</a>
						</li>

					<?php } ?>
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'billing' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
						<a class="nav-link" href="<?php echo base_url(); ?>billing"
						   style="<?php echo $this->uri->segment(1) == 'billing' ? 'color: white' : 'color: black'; ?>">
							<span>Billing</span>
						</a>
					</li>
					<li class="mt-2 <?php echo $this->uri->segment(1) == 'discharge' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
						<a class="nav-link" href="<?php echo base_url(); ?>discharge"
						   style="<?php echo $this->uri->segment(1) == 'discharge' ? 'color: white' : 'color: black'; ?>">
							<span>Discharge</span>
						</a>
					</li>

					<li class="mt-2 <?php echo $this->uri->segment(1) == 'discharge_report' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
						<a class="" href="<?php echo base_url(); ?>discharge_report"
						   style="<?php echo $this->uri->segment(1) == 'discharge_report' ? 'color: white' : 'color: black'; ?>">
							<span>Discharge Report</span>
						</a>
					</li>


					<li class="mt-2 <?php echo $this->uri->segment(1) == 'serviceOrder' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
						<a class="" href="<?php echo base_url(); ?>serviceOrder"
						   style="<?php echo $this->uri->segment(1) == 'serviceOrder' ? 'color: white' : 'color: black'; ?>">
							<span>Service Order</span>
						</a>
					</li>

				</div>
			<?php }else if ($role == 6 ) {?>
				<li class="<?php echo $this->uri->segment(1) == 'labMasterAdmin' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>labMasterAdmin">
						<i class="fas fa-fire"></i>
						<span>Lab Admin Dashboard</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(1) == 'labParentServices' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>labParentServices">
						<i class="fas fa-vial"></i>
						<span>Lab Master Service Test</span>
					</a>
				</li>
				<li class="<?php echo $this->uri->segment(1) == 'labMasterData' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo base_url(); ?>labMasterData">
						<i class="fas fa-vial"></i>
						<span>Lab Master Data</span>
					</a>
				</li>
			<?php }
			if ($role == 2 && $user_type == 3 && $this->uri->segment(1) == "company") { ?>
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
				</style>
				<div class="text-center">
					<!--					<div class="text-center">-->
					<!--						<div class="profile-widget-header">-->
					<!--							<img alt="image" id="patient_profile" src="-->
					<? //= base_url() ?><!--assets/img/avatar/avatar-1.png"-->
					<!--								 class="rounded-circle profile-widget-picture"-->
					<!--								 style="box-shadow: 0 4px 8px rgb(0 0 0 / 3%); width: 120px;position: relative;z-index: 1;">-->
					<!--						</div>-->
					<!--						<div class="mt-2">-->
					<!--							<b style="text-transform: uppercase;"><span id="patient_nameSidebar"></span></b>-->
					<!--						</div>-->
					<!--						<div class="">-->
					<!--							<small style="text-transform: uppercase;"><span id="patient_adharSidebar"></span></small>-->
					<!--						</div>-->
					<!--					</div>-->
					<li class="menu-header menu-header_section1" style=" "><a href="#" class="">Dashboard</a></li>
					<li class="menu-header <?php echo $this->uri->segment(1) == 'company' && $this->uri->segment(2) == 'view_user' ? 'menu-header_section active' : 'menu-header_section1'; ?>">
						<a href="<?php echo base_url(); ?>company/view_user"
						   style="<?php echo $this->uri->segment(1) == 'company' && $this->uri->segment(2) == 'view_user' ? 'color: white' : 'color: black'; ?>">Users
							List</a>
					</li>
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

								if ((int)$departmentId[4] == 1) {
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

								<li class="menu-header <?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
									<a
											href="<?php echo base_url(); ?>company/form_view/<?php echo $dep_encode ?>"
											style="<?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'color: #891635' : 'color:black'; ?>">
										<span><?php echo $depItems->departmentName; ?></span>
									</a>
								</li>
							<?php }
						}
					}
					?>
					<li class="menu-header <?php echo $this->uri->segment(3) == 'medicine_master' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
						<a href="<?= base_url('company/admin/medicine_master') ?>" class="" style="<?php echo $this->uri->segment(3) == 'medicine_master' ? 'color: white' : 'color: black'; ?>"><span>Medicine Master</span></a>
					</li>
					<li class="menu-header <?php echo $this->uri->segment(3) == 'prescription_master' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">
						<a href="<?= base_url('company/admin/prescription_master') ?>" class="" style="<?php echo $this->uri->segment(3) == 'prescription_master' ? 'color: white' : 'color: black'; ?>"><span>Prescription Master</span></a>
					</li>
				</div>
			<?php } ?>

		</ul>

	</aside>
</div>
