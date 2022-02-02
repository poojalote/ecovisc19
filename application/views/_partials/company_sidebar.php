<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mycommon.css">
<?php
defined('BASEPATH') or exit('No direct script access allowed');
$user_id = null;
$role = 0;
$dep = 0;
$patient_mediine_table = "";
$hospital_room_table = "";
$user_type = 1;
$username = "";
$permission_array = $this->session->user_permission;
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
	$username = $this->session->user_session->name;
} else {
	redirect("");
}

?>
<style type="text/css">
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

		body.layout-2 .main-content {
			padding-top: 5px;
			padding-left: 5px;
			padding-right: 5px;
		}

		body.layout-2 .main-content1 {
			padding-top: 5px;
			padding-left: 5px;
			padding-right: 5px;
		}
	}

</style>
<!-- left side bar -->
<div class="main-sidebar text-center sidebar-style-2" tabindex="1"
	 style="margin-top: 50px;overflow: hidden; outline: none;">
	<aside id="sidebar-wrapper" style="">
		<div class="profile-widget-header mt-5">
			<div class="rounded-circle profile-widget-picture">
				<i class="fas fa-user-md" style="font-size: 6rem"></i>
			</div>
		</div>
		<div class="mt-2">
			<b style="text-transform: uppercase;"><?= $username ?></b>
		</div>
		<div>
			<small>ADMIN</small>
		</div>
		<div class="sidebar-brand sidebar-gone-show"><a href="index.html"></a></div>
		<ul class="sidebar-menu">
			<a href="<?php echo base_url(); ?>patient_info" class="" style="text-decoration: none;">
				<li class="menu-header menu-header_section1" style=" ">Dashboard</li>
			</a>


			<?php

			if (in_array("userlist", $permission_array)) { ?>
				<a href="<?php echo base_url(); ?>company/view_user" class="list_ang"
				   style="<?php echo $this->uri->segment(1) == 'company' && $this->uri->segment(2) == 'view_user' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
					<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'company' && $this->uri->segment(2) == 'view_user' ? 'menu-header_section active' : 'menu-header_section1'; ?>">
						Users List
					</li>
				</a>
			<?php } ?>
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
						<a href="<?php echo base_url(); ?>company/form_view/<?php echo $dep_encode ?>"
						   style="<?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'color: #891635' : 'color:black'; ?>">
							<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'menu-header_section active1' : 'menu-header_section1'; ?>">

								<span><?php echo $depItems->departmentName; ?></span>

							</li>
						</a>
					<?php }
				}
			}
			?>

			<?php

			if (in_array("medication_master", $permission_array)) { ?>
				<a href="<?php echo base_url(); ?>company/admin/medicine_master"
				   style="<?php echo $this->uri->segment(3) == 'medicine_master' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
					<li class="menu-header mt-2 <?php echo $this->uri->segment(3) == 'medicine_master' || $this->uri->segment(1) == 'medicine_master' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
						style="">
						Medicine Master
					</li>
				</a>
			<?php } ?>
			<?php

			if (in_array("prescription_master", $permission_array)) { ?>
				<a href="<?php echo base_url(); ?>company/admin/prescription_master"
				   style="<?php echo $this->uri->segment(3) == 'prescription_master' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
					<li class="menu-header mt-2 <?php echo $this->uri->segment(3) == 'prescription_master' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
						style="">
						Prescription Master
					</li>
				</a>
			<?php } ?>

			<a href="<?php echo base_url(); ?>company/admin/hospital_order_management"
			   style="<?php echo $this->uri->segment(3) == 'hospital_order_management' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(3) == 'hospital_order_management' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Hospital Order Management
				</li>
			</a>
			<a href="<?php echo base_url(); ?>company/admit"
			   style="<?php echo $this->uri->segment(3) == 'prescription_master' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(2) == 'admit' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Readmit Patients
				</li>
			</a>
		</ul>
	</aside>
</div>
<!-- left side bar Menu -->
<div class="main-sidebar1 mobile_menu_hide">

	<div class="buttons">
		<a href="<?php echo base_url(); ?>patient_info" data-toggle="tooltip" data-placement="top" title="Dashboard"
		   class="btn btn-icon btn-light"><i class="fas fa-tachometer-alt"></i></a>
		<?php if (in_array("userlist", $permission_array)) { ?>
			<a href="<?php echo base_url(); ?>company/view_user" data-toggle="tooltip" data-placement="top"
			   title="User List"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'company' && $this->uri->segment(1) == 'view_user' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-users"></i></a>
		<?php } ?>
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
					<a href="<?php echo base_url(); ?>company/form_view/<?php echo $dep_encode ?>" data-toggle="tooltip"
					   data-placement="top" title="<?php echo $depItems->departmentName; ?>"
					   class="btn btn-icon <?php echo $this->uri->segment(2) == 'form_view' && $this->uri->segment(3) == '<?php echo $dep_encode ?>' ? 'btn-primary' : 'btn-light'; ?>"><i
								class="fas fa-hospital-alt"></i></a>
				<?php }
			}
		}
		?>
		<?php if (in_array("medication_master", $permission_array)) { ?>
			<a href="<?php echo base_url(); ?>company/admin/medicine_master" data-toggle="tooltip" data-placement="top"
			   title="Medicine Master"
			   class="btn btn-icon <?php echo $this->uri->segment(3) == 'medicine_master' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-capsules"></i></a>
		<?php } ?>
		<?php if (in_array("prescription_master", $permission_array)) { ?>
			<a href="<?php echo base_url(); ?>company/admin/prescription_master" data-toggle="tooltip"
			   data-placement="top" title="Prescription Master"
			   class="btn btn-icon <?php echo $this->uri->segment(3) == 'prescription_master' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-prescription"></i></a>
		<?php } ?>
		<a href="<?php echo base_url(); ?>company/admin/hospital_order_management" data-toggle="tooltip"
		   data-placement="top" title="Hospital Order Management"
		   class="btn btn-icon <?php echo $this->uri->segment(3) == 'hospital_order_management' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-ambulance"></i></a>


	</div>
</div>



