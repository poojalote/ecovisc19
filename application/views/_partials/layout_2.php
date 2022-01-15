<?php
defined('BASEPATH') or exit('No direct script access allowed');
$username = "";
if (isset($this->session->user_session)) {
	$username = $this->session->user_session->name;
	$role = $this->session->user_session->roles;
	$type = $this->session->user_session->user_type;
	$default_access = $this->session->user_session->default_access;
} else {
	redirect("");
}
?>
<style type="text/css">
	#site-logo{
        width: 65px;
        height: 60px;
        margin-left: 20px;
	}
	@media (max-width: 800px) {
		.dataTables_length {
			display: none;
		}
		#site-logo{
			width: 50px;
			height: 50px;
		}
	}
    body.layout-2 .main-wrapper{
        padding: 0 25px;
    }


</style>
<body class="layout-2">
<!-- app start -->
<div id="app">
	<!-- wrapper start -->
	<div class="main-wrapper container-fluid">
		<div class="navbar-bg"  style="background: #891635;"></div>
		<!-- nav bar start -->
		<?php
		if ($role == 1) {
			$url = base_url()."admin/dashboard";
		} else {
			if($role == 2) {
				if ($type == 5) {
					$url = base_url(). "hospitalMedicine";
					// $url = base_url(). "pharmeasy";
				} else {
					if ($default_access !== 2) {
						$url = base_url(). "patient_info";
					}else{
						$url = base_url(). "icubedManagement";
					}
				}
			}else{
				if ($type ==4) {
					$url = base_url(). "pharmeasy";
					// $url = base_url(). "hospitalMedicine";
				} else if ($type ==6) {
					$url = base_url(). "view_pickup";
					// $url = base_url(). "pharmeasy";
				}
				else if ($type ==12) {
					$url = base_url(). "labpatient_info";
				}
				else{
					$url = base_url(). "view_radiologypickup";
				}

			}
		}
		?>
		<nav class="navbar navbar-expand-lg main-navbar">
			<a href="#" class="nav-link nav-link-lg mobile_three" onclick="mobileMenuHideShoe()"></a>
			<a href="<?php echo $url; ?>" class="navbar-brand sidebar-gone-hide">
                <?php
                if (!is_null($this->session->branch_logo)) {
                    if(!is_null($this->session->branch_logo->branch_logo)){
                        $logo = $this->session->branch_logo->branch_logo;
                    }else{
                        $logo = "dist/img/credit/healthstart.jpeg";
                    }
                } else {
                    $logo = "dist/img/credit/healthstart.jpeg";

                }
                ?>
				<img src="<?php echo base_url($logo); ?>" id="site-logo"
					 class="logo_image rounded-circle">
			</a>
			<form class="form-inline ml-auto mobile_search">
				<ul class="navbar-nav">
				</ul>
			</form>
			<ul class="navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
						<img alt="image" src="<?php  echo base_url(); ?>assets/img/avatar/avatar-1.png"
							 class="rounded-circle mr-1">
						<div class="d-sm-none d-lg-inline-block">Hi, <?= $username ?></div>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="<?= base_url('logout'); ?>" class="dropdown-item has-icon text-danger">
							<i class="fas fa-sign-out-alt"></i> Logout
						</a>
					</div>
				</li>
			</ul>
		</nav>
		<!-- nav bar end -->
