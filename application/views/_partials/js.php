<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<script>
    let session_branch_id = '<?=$this->session->user_session->branch_id;?>';
</script>
<!-- General JS Scripts -->
<script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/popper.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/tooltip.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/stisla.js"></script>
<script src="<?php echo base_url(); ?>assets/js/page/bootstrap-modal.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js"></script>
<!-- JS Libraies -->
<?php
if ($this->uri->segment(1) == "" || $this->uri->segment(1) == "index") { ?>

    <?php
} elseif ($this->uri->segment(1) == "index_0") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "bootstrap_card") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "bootstrap_modal") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/prism/prism.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "layout_transparent") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/sticky-kit.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_gallery") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_multiple_upload") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/dropzonejs/min/dropzone.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_statistic") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/maps/jquery.vmap.indonesia.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_table") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_user") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "forms_advanced_form") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/cleave-js/dist/cleave.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "forms_editor") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/codemirror/lib/codemirror.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/codemirror/mode/javascript/javascript.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_advanced_route" || $this->uri->segment(1) == "gmaps_draggable_marker" || $this->uri->segment(1) == "gmaps_geocoding" || $this->uri->segment(1) == "gmaps_geolocation" || $this->uri->segment(1) == "gmaps_marker" || $this->uri->segment(1) == "gmaps_multiple_marker" || $this->uri->segment(1) == "gmaps_route" || $this->uri->segment(1) == "gmaps_simple") { ?>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyB55Np3_WsZwUQ9NS7DP-HnneleZLYZDNw&amp;sensor=true"></script>
    <script src="<?php echo base_url(); ?>assets/modules/gmaps.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_calendar") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/fullcalendar/fullcalendar.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_chartjs") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/chart.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "doctor_view1") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>

    <?php
} elseif ($this->uri->segment(1) == "modules_owl_carousel") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_sparkline") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/jquery.sparkline.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_sweet_alert") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js"></script>

    <?php
} elseif ($this->uri->segment(1) == "modules_vector_map") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/maps/jquery.vmap.indonesia.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "auth_register") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_post_create") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_posts") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_profile") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_setting_detail") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/codemirror/lib/codemirror.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/codemirror/mode/javascript/javascript.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_tickets") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "utilities_contact") { ?>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyB55Np3_WsZwUQ9NS7DP-HnneleZLYZDNw&amp;sensor=true"></script>
    <script src="<?php echo base_url(); ?>assets/modules/gmaps.js"></script>
    <?php
} ?>

<!-- Page Specific JS File -->
<?php
if ($this->uri->segment(1) == "" || $this->uri->segment(1) == "index") { ?>
    <!--	<script src="--><?php //echo base_url(); ?><!--assets/js/page/index.js"></script>-->
    <?php
} elseif ($this->uri->segment(1) == "index_0") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/index-0.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "bootstrap_modal") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/bootstrap-modal.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_chat_box") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/components-chat-box.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_multiple_upload") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/components-multiple-upload.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_statistic") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/components-statistic.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_table") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/components-table.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "components_user") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/components-user.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "forms_advanced_form") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/forms-advanced-forms.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_advanced_route") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-advanced-route.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_draggable_marker") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-draggable-marker.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_geocoding") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-geocoding.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_geolocation") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-geolocation.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_marker") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-marker.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_multiple_marker") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-multiple-marker.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_route") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-route.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "gmaps_simple") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/gmaps-simple.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_calendar") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-calendar.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_chartjs") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-chartjs.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_datatables") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-datatables.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_ion_icons") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-ion-icons.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_owl_carousel") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-slider.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_sparkline") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-sparkline.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_sweet_alert") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-sweetalert.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_toastr") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-toastr.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "modules_vector_map") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/modules-vector-map.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "auth_register") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/auth-register.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_post_create") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/features-post-create.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_posts") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/features-posts.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "features_setting_detail") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/features-setting-detail.js"></script>
    <?php
} elseif ($this->uri->segment(1) == "utilities_contact") { ?>
    <script src="<?php echo base_url(); ?>assets/js/page/utilities-contact.js"></script>
    <?php
} ?>
<!--custom js-->

<?php if ($this->uri->segment(1) == "doctor_view") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/page/bootstrap-modal.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/doctor-view.js"></script>
<?php } ?>
<!-- supriya js -->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js"></script>
<!-- Template JS File -->
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js?1500"></script>

<?php if ($this->uri->segment(1) == "") { ?>
    <script src="<?php echo base_url(); ?>assets/js/login.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "Hl7View") { ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/page/bootstrap-modal.js"></script>
<?php } ?>
<?php if ($this->uri->segment(2) == "view_companies") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/company/company_view.js?version=<?= time(); ?>"></script>

    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(2) == "view_branch") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/branch/branch_view.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(2) == "view_departments") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/department/department_view.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(2) == "view_user") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <!--	<script src="--><?php //echo base_url(); ?><!--assets/js/module/department/department_view.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/js/module/users/user.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "patient_info"  || $this->uri->segment(1) == "datatableTabSection" || $this->uri->segment(1) == "patient_report") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/patient_view.js?version=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_patientform.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modernizr.custom.js"></script>
    <script src="https://vs.ecovisrkca.com/socket.io/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/bedManagement/icubedManagement.js?version=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/bedManagement/video-camera-socket.js?version=<?= time(); ?>"></script>
<?php } ?>

<?php if ($this->uri->segment(1) == "patient_info" || $this->uri->segment(2) == "patient_info") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <!--	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>-->

    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/patient_view.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(2) == "view_patients") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/patient_view.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(2) == "new_patients" || $this->uri->segment(1) == "new_patients") { ?>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/webcam.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/patient_view.js"></script>

    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(1) == "lab_patient") { ?>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/webcam.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/labpatient_view.js?version=<?= time(); ?>"></script>

    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(1) == "labpatient_info") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <!--    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>-->

    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/labpatient_view.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(1) == "labpatient_report") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <!--    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>-->

    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_form.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(1) == "html_form_view") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <!--    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>-->

    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_form.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(1) == "staffRegistration") { ?>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/webcam.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/staff/staffRegistration.js?version=<?= time(); ?>"></script>

    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(1) == "medicine") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/module/medicine/medicine.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>

<?php if ($this->uri->segment(1) == "bedManagement") { ?>

    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/bedManagement/bedManagement.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>


<?php if ($this->uri->segment(1) == "IcunursingCare") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/IcuCare/icunursingcare.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "icubedManagement") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <script src="https://vs.ecovisrkca.com/socket.io/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/bedManagement/video-camera-socket.js?version=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/bedManagement/icubedManagement.js?version=<?= time(); ?>"></script>

    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php if ($this->uri->segment(1) == "assignBed") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/bedManagement/assignBed.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>
<?php //if ($this->uri->segment(1) == "medicine") { ?>
<!--	<script src="--><?php //echo base_url(); ?><!--assets/modules/datatables/datatables.min.js"></script>-->
<!--	<script src="--><?php //echo base_url(); ?><!--assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>-->
<!--	<script src="--><?php //echo base_url(); ?><!--assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>-->
<!--	<script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>-->
<!--	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>-->
<!--	<script src="--><?php //echo base_url(); ?><!--assets/js/module/medicine/medicine.js"></script>-->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/module/department/companyModule.js"></script>-->
<?php //} ?>
<?php if ($this->uri->segment(3) == "medicine_master" || $this->uri->segment(3) == "prescription_master") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/module/medicine/medicine.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(2) == "form_template") { ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/templates/templates.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(2) == "personal_template") { ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/templates/personal_template.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "patient" && $this->uri->segment(2) == "dashboard") { ?>

    <script src="<?php echo base_url(); ?>assets/js/module/patient/dashboard.js"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "billing" || $this->uri->segment(1) == "billingMaster") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/billing/billing.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "viewOtherService") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "discharge") { ?>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/section_form.js?version=<?= time(); ?>"></script>
	<script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_form.js"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "patient" && $this->uri->segment(2) == "dashboard") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/dashboard.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/webcam.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/patient_view.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "staff" && $this->uri->segment(2) == "dashboard") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/dashboard.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/webcam.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/staff/staffRegistration.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "serviceOrder" || $this->uri->segment(1) == "serviceOrder1") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/serviceOrder/serviceOrder.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "radiologySampleCollection") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/serviceOrder/serviceOrder.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "pathologySampleCollection") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/serviceOrder/serviceOrder.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "pharmeasy" || $this->uri->segment(1) == "hospitalMedicine") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/medicine/order_medicine.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "pharmeasy1") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/medicine/order_medicine1.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "view_pickup" || $this->uri->segment(1) == "view_pickup1") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/serviceOrder/pickup.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "view_radiologypickup") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/serviceOrder/serviceOrder.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "labReport") { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/lab_report/lab_report.js?version=<?= time(); ?>"></script>
<?php } ?>

<?php if ($this->uri->segment(1) == "operation_details") { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
<?php } ?>
<?php if ($this->uri->segment(3) == "hospital_order_management" || $this->uri->segment(1) == "hospital_order_management") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/hospitalOrder/hospitalOrder.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "Consumable_Inventory") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/hospitalOrder/hospitalOrder.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "consumableOrder") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/consumableOrder/consumableOrder.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "form_view" || $this->uri->segment(2) == "form_view") { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/section_form.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "form_view_personal") { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/section_form.js?version=<?= time(); ?>"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "patientReport") { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/modules/chart.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <script src="https://vs.ecovisrkca.com/socket.io/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/bedManagement/video-camera-socket.js?version=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patientReport/patient_report.js?version=<?= time(); ?>"></script>
<?php } ?>

<?php if ($this->uri->segment(2) == "Html_form") { ?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/htmldepartment.js?version=<?= time(); ?>"></script>
    <!--<script src="<?php echo base_url(); ?>assets/js/module/department/companyModule.js"></script>-->
<?php } ?>

<?php if ($this->uri->segment(2) == "Html_template_drag") { ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
    <!-- Import dependency for Resizimg (tested with version 0.35). For a production setup, follow install instructions here: https://github.com/RickStrahl/jquery-resizable -->
    <!-- <script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/0.35/dist/jquery-resizable.min.js"></script> -->

    <!-- JS Libraies -->
    <!-- <script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/jquery.rsLiteGrid.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/Htmlform_template_drag.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/section_htmlform.js"></script>

<?php } ?>
<?php
if ($this->uri->segment(2) == "Reports_query") { ?>
	<script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
<?php } ?>
<?php
if ($this->uri->segment(1) == "access_management" || $this->uri->segment(1) == "branch_access_management") { ?>
	<script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
<?php } ?>
<?php
if ($this->uri->segment(1) == "user_management") { ?>
	<script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.js"></script>
<?php } ?>
<?php
if($this->uri->segment(1) == "labMaster"){?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_form.js"></script>
<?php
}
?>
<?php if ($this->uri->segment(2) == "view_lab_branch") { ?>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/lab_branch/lab_branch_view.js"></script>
<?php } ?>
<?php
if($this->uri->segment(1) == "setup_lab_master" || $this->uri->segment(1) == "setup_child_lab_master"|| $this->uri->segment(1) == "master_package"){?>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_form.js"></script>
<?php
}
?>

<?php if ($this->uri->segment(1) == "patient_navigation") { ?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_patientNavigationform.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modernizr.custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/jquery.rsLiteGrid.js"></script>
<?php } ?>

<?php if ($this->uri->segment(1) == "html_navigation") { ?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modernizr.custom.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_form.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/jquery.rsLiteGrid.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/patient/section_form.js?version=<?= time(); ?>"></script>

<?php } ?>
<?php if ($this->uri->segment(1) == "report_maker") { ?>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/ReportMaker/report_maker.js"></script>

<?php } ?>

<?php if ($this->uri->segment(1) == "ViewReportMaker") { ?>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>


<?php } ?>
<?php
if($this->uri->segment(1) == "payerDetails"){?>
	<script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/module/HtmlTemplate/html_form.js"></script>
	<?php
}
?>

<?php if ($this->uri->segment(1) == "ViewReportMaker") { ?>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>


<?php } ?>

<?php if ($this->uri->segment(1) == "Dashboard") { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/dashboard/dashboard.js"></script>
<?php }
if ($this->uri->segment(1) == "risknode") { ?>
    <script src="<?php echo base_url(); ?>assets/tree_node/js/d3-mitch-tree.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/content_menu/basicContext.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/module/riskNode/risknode.js?version=<?= time(); ?>"></script>
<?php } else { ?>
    <script>
        let forms = document.forms;
        for (let i = 0; i < forms.length; i++) {
            if (forms[i].hasAttribute("data-form-valid")) {

                let formID = forms[i].getAttribute("id");
                let handlerName = forms[i].getAttribute("data-form-valid");

                let elements = forms[i].elements;
                let formRules = {};
                let formMessages = {};
                for (let e = 0; e < elements.length; e++) {

                    let elementName = elements[e].getAttribute('name');
                    let elementRuleObject = {};
                    let elementMessageObject = {};
                    if (elements[e].hasAttribute("data-valid")) {
                        let rules = elements[e].getAttribute('data-valid');
                        let messages = elements[e].getAttribute("data-msg");
                        let validationsRules = rules.split("|");
                        let validationsMessages = messages.split("|");
                        validationsRules.forEach((prop, index) => {
                            if (!prop.includes("=")) {
                                elementRuleObject[prop] = true;
                                if (validationsMessages[index]) {
                                    elementMessageObject[prop] = validationsMessages[index];
                                } else {
                                    elementMessageObject[prop] = $.validator.messages[prop];
                                }
                            } else {
                                let splitProp = prop.split("=");
                                elementRuleObject[splitProp[0]] = splitProp[1];
                                if (validationsMessages[index]) {
                                    elementMessageObject[splitProp[0]] = validationsMessages[index];
                                } else {
                                    elementMessageObject[splitProp[0]] = $.validator.messages[splitProp[0]];
                                }
                            }
                        });
                        formRules[elementName] = elementRuleObject;
                        formMessages[elementName] = elementMessageObject;
                    }
                }

                let hasFunction = window[handlerName];
                if (typeof hasFunction === "function") {
                    app.validation(formID, formRules, formMessages, hasFunction)
                }
            }
        }
    </script>
<?php } ?>
<!-- <script>
	$(function () {
		$(window).resize(function () {
			if (window.matchMedia("(max-width: 768px)").matches) {

				location.reload();

			} else {


			}
		});
		if (window.matchMedia("(max-width: 768px)").matches) {


		} else {


		}
	});
</script> -->
<script type="text/javascript">

    $(document).ready(function () {
        screen.width < 800 ? $('.main-content1').removeClass('main-content') : $('.main-content1').addClass('main-content');
        screen.width < 800 ? $('.main-footer1').removeClass('main-footer') : $('.main-footer1').addClass('main-footer');

        $('[data-toggle="tooltip"]').tooltip();
        if (window.location.href == "<?= base_url()?>") {

        } else {
            check_billing_status();
        }

    });

    function check_billing_status() {

        var p_id = localStorage.getItem("patient_id");

        $.ajax({
            type: "POST",
            url: '<?= base_url("check_billing_status")?>',
            dataType: "json",
            async: false,
            cache: false,
            data: {p_id},
            success: function (result) {

                if (result.status == 200) {
                    var value = result.value;
                    if (value == 1) {

                        $("#medication_list").hide();
                        $("#serviceOrder_list").hide();
                        $("#billinginfo_list").hide();
                        $("#consumableOrder_list").hide();
                        $("#assign_bed_btn").prop('disabled', true);
                        $("#check_order_btn").prop('disabled', true);
                        $("#submit_btn").prop('disabled', true);
                        $("#changebillbutton").html("Billing Already Close");
                    } else {
                        $("#medication_list").show();
                        $("#serviceOrder_list").show();
                        $("#billinginfo_list").show();
                        $("#consumableOrder_list").show();
                        $("#changebillbutton").html("Close Billing");
                    }
                } else {

                }
            }
        });
    }

    function selectPatientInfo() {
        // console.log('hiiiii');
        var spi = document.getElementById('selectPatientInfo');
        spi.classList.toggle("menu-header_section1");
        spi.classList.toggle("menu-header_section");
        var spiA = document.getElementById('selectPatientInfoA');

        spiA.classList.toggle("menu-selectPatientInfoA");
        spiA.classList.toggle("selectPatientInfoB");
        // spi.style.color="white";
        // $("#selectPatientInfo").removeClass("menu-header_section1").toggle();
        // $("#selectPatientInfo").addClass("menu-header_section active1").toggle();
        // document.getElementById('').addClass = "";

    }

    function mobileMenuHideShoe() {
        // var spi=document.getElementsByClassName('mobile_menu_hide');
        // spi.classList.toggle("d-none");
        document.getElementsByClassName('mobile_menu_hide')[0].classList.toggle("d-none");
    }


</script>
<?php if ($this->uri->segment(1) !== "new_patients" || $this->uri->segment(1) !== "lab_patient") { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            if (document.getElementById("patient_nameSidebar"))
                document.getElementById("patient_nameSidebar").innerText = localStorage.getItem("patient_name");

            if (document.getElementById("patient_adharSidebar"))
                document.getElementById("patient_adharSidebar").innerText = localStorage.getItem("patient_adharnumber");

            if (document.getElementById("patient_nameSidebar1")) {
                document.getElementById("patient_nameSidebar1").innerText = localStorage.getItem("patient_name");
            }
            if (document.getElementById("patient_adharSidebar1"))
                document.getElementById("patient_adharSidebar1").innerText = localStorage.getItem("patient_adharnumber");

            if (document.getElementById("patient_profile"))
                if (localStorage.getItem("patient_profile") !== "" && localStorage.getItem("patient_profile") !== "null") {
                    document.getElementById("patient_profile").setAttribute("src", localStorage.getItem("patient_profile"));
                }
            if (document.getElementById("patient_profile1"))
                if (localStorage.getItem("patient_profile1") !== "" && localStorage.getItem("patient_profile") !== "null") {
                    document.getElementById("patient_profile1").setAttribute("src", localStorage.getItem("patient_profile"));
                }


            //document.getElementById("patient_aadhar_numberSidebar").innerText=localStorage.getItem("patient_adharnumber");
            //document.getElementById("patient_idSidebar").innerText=localStorage.getItem("patient_id");
        });
        $(document).ready(function () {
            admissionDate = localStorage.getItem("patient_admission");
            mode = localStorage.getItem("patient_mode");
            if (admissionDate !== "null" && admissionDate !== null) {
                $('#patient_info_bar').removeClass('d-none');
            } else {
                $('#patient_info_bar').addClass('d-none');
            }

            if (mode != null && mode !== "null") {
                if (parseInt(mode) === 2) {
                    // $('#assign_bed_bar').removeClass('d-none');
                } else {
                    // $('#assign_bed_bar').addClass('d-none');
                }
            } else {
                // $('#assign_bed_bar').addClass('d-none');
            }
            if (localStorage.getItem("patient_type") == "2") {
                $(".patientLeftSide").addClass('d-none');
            } else {
                $(".patientLeftSide").removeClass('d-none');
            }

            if (localStorage.getItem("patient_icu") == "3") {
                $(".isIcu").removeClass('d-none');
                let url = '<?=base_url('icubedManagement');  ?>';
                $("#homeURL").attr("href", url)
            } else {
                $(".isIcu").addClass('d-none');
            }

        });

    </script>
<?php } ?>
</body>
</html>
