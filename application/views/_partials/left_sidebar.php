<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mycommon.css">
<?php
$username = "";
$default_access = "";
if (isset($this->session->user_session)) {
	$username = $this->session->user_session->name;
	if(isset($this->session->user_session->default_access)){
	$default_access = $this->session->user_session->default_access;
	}else{
	$default_access = "";
	}
} else {
	redirect("");
}
$permission_array = $this->session->user_permission;
$branchpermission_array = $this->session->Branch_permission;
if(is_null($branchpermission_array)){
	$branchpermission_array=array();
}
if(is_null($permission_array)){
	$permission_array=array();
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
			<?php
			//if (in_array("patient_list", $permission_array)) { ?>
				<a href="<?php echo base_url(); ?>patient_info" class="list_ang"
				   style="<?php echo $this->uri->segment(1) == 'patient_info' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
					<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'patient_info' ? 'menu-header_section active' : 'menu-header_section1'; ?>">
						Patient List
					</li>
				</a>
			<?php // }
			?>
			<?php
			if (in_array("patient_registration", $permission_array)) { ?>
				<a href="<?php echo base_url(); ?>new_patients"
				   style="<?php echo $this->uri->segment(2) == 'new_patient' || $this->uri->segment(1) == 'new_patients' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
					<li class="menu-header mt-2 <?php echo $this->uri->segment(2) == 'new_patients' || $this->uri->segment(1) == 'new_patients' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
						style="">
						Patient Registration
					</li>
				</a>
			<?php }
			?>
			<?php
			if (in_array("risk_dashboard", $branchpermission_array) && in_array("risk_dashboard", $permission_array)) { ?>
				<a href="<?php echo base_url(); ?>bedManagement"
				   style="<?php echo $this->uri->segment(1) == 'bedManagement' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
					<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'bedManagement' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
						style="">
                        Risk Dashboard
					</li>
				</a>
			<?php }
			?>


			<?php
			if (in_array("dashboard", $branchpermission_array) && in_array("dashboard", $permission_array)) { ?>
			<a href="<?php echo base_url(); ?>Dashboard" class=""  style="<?php echo $this->uri->segment(1) == 'Dashboard' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'Dashboard' ? 'menu-header_section active' : 'menu-header_section1'; ?>">Dashboard</li>

			</a>
			<?php }
			?>
			<a href="<?php echo base_url(); ?>admin/chnage_password" class="" style="text-decoration: none;">
				<li class="menu-header mt-2 menu-header_section1">Password Change</li>
			</a>
			<?php
			if (in_array("admin", $branchpermission_array)) { ?>
			<?php if ((int)$this->session->user_session->user_type === 3) { ?>
				<a href="<?php echo base_url(); ?>company/view_user" class="" style="text-decoration: none; ">
					<li class="menu-header mt-2 menu-header_section1" style="">Admin</li>
				</a>
			<?php } } ?>
			<?php
			if (in_array("radiology_sample_collection", $permission_array) && in_array("radiology_sample_collection", $branchpermission_array)) { ?>
			<a href="<?php echo base_url(); ?>radiologySampleCollection"
			   style="<?php echo $this->uri->segment(1) == 'radiologySampleCollection' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'radiologySampleCollection' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Radiology Progress
				</li>
			</a>
			<?php }
			?>
			<?php
			if (in_array("pathology_sample_collection", $permission_array) && in_array("pathology_sample_collection", $branchpermission_array)) { ?>
			<a href="<?php echo base_url(); ?>pathologySampleCollection"
			   style="<?php echo $this->uri->segment(1) == 'pathologySampleCollection' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'pathologySampleCollection' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Pathology Progress
				</li>
			</a>
			<?php }
			?>
			<?php
			if (in_array("other_services", $branchpermission_array) && in_array("other_services", $permission_array)) { ?>
			<a href="<?php echo base_url(); ?>viewOtherService"
			   style="<?php echo $this->uri->segment(1) == 'viewOtherService' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'viewOtherService' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Other Service Progress
				</li>
			</a>
			<?php }
			?>
			<?php
			if (in_array("pharmacy", $branchpermission_array)) { ?>
			<a href="<?php echo base_url(); ?>hospitalMedicine"
			   style="<?php echo $this->uri->segment(1) == 'hospitalMedicine' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'hospitalMedicine' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Pharmacy Receiver
				</li>
			</a>
			<?php }
			?>
			<?php
			if (in_array("staff_registration", $branchpermission_array)) { ?>
			<a href="<?php echo base_url(); ?>staffRegistration"
			   style="<?php echo $this->uri->segment(1) == 'staffRegistration' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'staffRegistration' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Staff Registration
				</li>
			</a>
			<?php }
			?>
			<?php
			if (in_array("hospital_order", $branchpermission_array)) { ?>
			<a href="<?php echo base_url(); ?>hospital_order_management"
			   style="<?php echo $this->uri->segment(1) == 'hospital_order_management' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'hospital_order_management' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Hospital Order
				</li>
			</a>
			<?php }
			?>
			<?php
			if (in_array("consumable_inventory", $branchpermission_array)) { ?>
			<a href="<?php echo base_url(); ?>Consumable_Inventory"
			   style="<?php echo $this->uri->segment(1) == 'Consumable_Inventory' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'Consumable_Inventory' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Consumable Inventory
				</li>
			</a>
			<?php }
			?>
			<a href="<?php echo base_url(); ?>pathologyCollection"
			   style="<?php echo $this->uri->segment(1) == 'pathologyCollection' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
				<li class="menu-header mt-2 <?php echo $this->uri->segment(1) == 'pathologyCollection' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					Pathology Collection
				</li>
			</a>
            
<!--			--><?php //if($default_access == 2){ ?>
				<!--<a href="<?php /*echo base_url(); */?>icubedManagement"
			   style="<?php /*echo $this->uri->segment(1) == 'icubedManagement' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; */?>">
				<li class="menu-header mt-2 <?php /*echo $this->uri->segment(1) == 'icubedManagement' ? 'menu-header_section active' : 'menu-header_section1'; */?>"
					style="">
					ICU Patient
				</li>
			</a>-->
<!--			--><?php //} ?>
			
<!--			<a href="--><?php //echo base_url(); ?><!--view_pickup"-->
<!--			   style="--><?php //echo $this->uri->segment(1) == 'pathologySampleCollection' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?><!--">-->
<!--				<li class="menu-header mt-2 --><?php //echo $this->uri->segment(1) == 'view_pickup' ? 'menu-header_section active' : 'menu-header_section1'; ?><!--"-->
<!--					style="">-->
<!--					Sample Pickup-->
<!--				</li>-->
<!--			</a>-->
		</ul>
	</aside>
</div>
<!-- left side bar Menu -->
<div class="main-sidebar1 mobile_menu_hide">

	<div class="buttons">
		<a href="<?php echo base_url(); ?>patient_info" data-toggle="tooltip" data-placement="top" title="Patient List"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'patient_info' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-list"></i></a>
		<?php if (in_array("patient_registration", $permission_array)) { ?>
		<a href="<?php echo base_url(); ?>new_patients" data-toggle="tooltip" data-placement="top" title="Patient Registration"
		   class="btn btn-icon <?php echo $this->uri->segment(2) == 'new_patients' || $this->uri->segment(1) == 'new_patients' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fa fa-user-plus"></i></a>
		<?php } ?>
		<a href="<?php echo base_url(); ?>bedManagement"  data-toggle="tooltip" data-placement="top" title="Risk Dashboard"
		   class="btn btn-icon <?php echo $this->uri->segment(1) == 'bedManagement' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-bed"></i></a>

		<a href="<?php echo base_url(); ?>Dashboard" class="btn btn-icon <?php echo $this->uri->segment(1) == 'Dashboard' ? 'btn-primary' : 'btn-light'; ?>" data-toggle="tooltip" data-placement="top" title="Dashboard"><i class="fas fa-tachometer-alt"></i></a>

		<a href="<?php echo base_url(); ?>admin/chnage_password" data-toggle="tooltip" data-placement="top" title="Password Change"
		   class="btn btn-icon <?php echo $this->uri->segment(2) == 'chnage_password' ? 'btn-primary' : 'btn-light'; ?>"><i
					class="fas fa-key"></i></a>

		<?php if ((int)$this->session->user_session->user_type === 3) { ?>
			<a href="<?php echo base_url(); ?>company/company_admin" data-toggle="tooltip" data-placement="top" title="Admin"
			   class="btn btn-icon <?php echo $this->uri->segment(2) == 'company_admin' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-user"></i></a>
		<?php } ?>
		<?php if (in_array("radiology_sample_collection", $permission_array)) { ?>
			<a href="<?php echo base_url(); ?>radiologySampleCollection" data-toggle="tooltip" data-placement="top" title="Radiology Progress"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'radiologySampleCollection' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-x-ray"></i></a>
		<?php } ?>
		<?php if (in_array("pathology_sample_collection", $permission_array)) { ?>
			<a href="<?php echo base_url(); ?>pathologySampleCollection" data-toggle="tooltip" data-placement="top" title="Pathology Progress"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'pathologySampleCollection' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-vial"></i></a>
		<?php } ?>
		<a href="<?php echo base_url(); ?>viewOtherService" data-toggle="tooltip" data-placement="top" title="Other Service Progress"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'viewOtherService' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-life-ring"></i></a>
		<a href="<?php echo base_url(); ?>hospitalMedicine" data-toggle="tooltip" data-placement="top" title="Pharmacy Reciver"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'hospitalMedicine' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-prescription-bottle-alt"></i></a>
		<a href="<?php echo base_url(); ?>staffRegistration" data-toggle="tooltip" data-placement="top" title="Staff Registration"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'staffRegistration' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-address-book"></i></a>
		<a href="<?php echo base_url(); ?>icubedManagement" data-toggle="tooltip" data-placement="top" title="Icu Patient"
			   class="btn btn-icon <?php echo $this->uri->segment(1) == 'icubedManagement' ? 'btn-primary' : 'btn-light'; ?>"><i
						class="fas fa-procedures"></i></a>
	</div>
</div>



