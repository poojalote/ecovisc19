<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mycommon.css">
<?php
$username = "";
if (isset($this->session->user_session)) {
	$username = $this->session->user_session->name;
} else {
	redirect("");
}
?>
<div class="profile-widget-header mt-5">
	<div class="rounded-circle profile-widget-picture">
		<i class="fas fa-user-md" style="font-size: 6rem"></i>
	</div>

	<!--	<img alt="image" src="-->
	<? //=base_url()?><!--assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture" >-->
</div>
<div class="mt-2">
	<b style="text-transform: uppercase;"><?= $username ?></b>
</div>
<div>
	<!--	<small>ADMIN</small>-->
</div>
<div>
	<div class="main-sidebar" tabindex="1" style="margin-top: 20px">
		<aside id="sidebar-wrapper" class="is_stuck" style="">
			<div class="sidebar-brand sidebar-gone-show"><a href="index.html"></a></div>
			<ul class="sidebar-menu">
				<li class="menu-header menu-header_section1" style=" "><a href="#" class="">Dashboard</a></li>
				<li class="menu-header <?php echo $this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'view_user' ? 'menu-header_section active' : 'menu-header_section1'; ?>">
					<a href="<?php echo base_url(); ?>patient_info"
					   style="<?php echo $this->uri->segment(1) == 'patient_info' ? 'color: white' : 'color: black'; ?>">Users
						List</a>
				</li>
				<li class="menu-header <?php echo $this->uri->segment(1) == 'bedManagement' ? 'menu-header_section active' : 'menu-header_section1'; ?>"
					style="">
					<a href="<?php echo base_url(); ?>bedManagement"
					   style="<?php echo $this->uri->segment(1) == 'bedManagement' ? 'color: white' : 'color: black'; ?>">
						Bed	Management</a>
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
							$departObject->isAdmin = $departmentId[4];
							if((int)$departmentId[4]==1){
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
								   href="<?php echo base_url(); ?>form_view/<?php echo $dep_encode ?>"
								   style="<?php echo $this->uri->segment(1) == 'form_view/<?php echo $dep_encode ?>' ? 'color: #891635' : 'color:black'; ?>">
									<span><?php echo $depItems->departmentName; ?></span>
								</a>
							</li>
						<?php }
					}
				}
				?>
				<li class="menu-header menu-header_section1" style="">
					<a href="<?php echo base_url(); ?>company/company_admin" class="">Admin</a>
				</li>

			</ul>
		</aside>
	</div>
</div>
