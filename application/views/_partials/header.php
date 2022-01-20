<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php echo $title; ?></title>
    <!-- add icon link -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/reliance_logo.ico"
          type="image/x-icon" style="font-size:60px;">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
    <!-- CSS Libraries -->
    <?php
    if ($this->uri->segment(1) == "" || $this->uri->segment(1) == "index") { ?>
        <!-- section 1 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jqvmap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "index_0") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jqvmap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/weather-icon/css/weather-icons.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/weather-icon/css/weather-icons-wind.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css">
        <?php
    } elseif ($this->uri->segment(1) == "bootstrap_card") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css">
        <?php
    } elseif ($this->uri->segment(1) == "bootstrap_modal") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/prism/prism.css">
        <?php
    } elseif ($this->uri->segment(1) == "components_gallery") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css">
        <?php
    } elseif ($this->uri->segment(1) == "components_multiple_upload") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/dropzonejs/dropzone.css">
        <?php
    } elseif ($this->uri->segment(1) == "components_statistic") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jqvmap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/flag-icon-css/css/flag-icon.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "components_user") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-social/bootstrap-social.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "forms_advanced_form") { ?>
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
        <?php
    } elseif ($this->uri->segment(1) == "forms_editor") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/codemirror/lib/codemirror.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/codemirror/theme/duotone-dark.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css">
        <?php
    } elseif ($this->uri->segment(1) == "modules_calendar") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fullcalendar/fullcalendar.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "doctor_view") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "modules_ion_icons") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/ionicons/css/ionicons.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "modules_owl_carousel") { ?>
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "doctor_form") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "modules_vector_map") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jqvmap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/flag-icon-css/css/flag-icon.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "modules_weather_icon") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/weather-icon/css/weather-icons.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/weather-icon/css/weather-icons-wind.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "auth_login") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-social/bootstrap-social.css">
        <?php
    } elseif ($this->uri->segment(1) == "auth_register") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css">
        <?php
    } elseif ($this->uri->segment(1) == "features_post_create") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
        <?php
    } elseif ($this->uri->segment(1) == "features_posts") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css">
        <?php
    } elseif ($this->uri->segment(1) == "features_profile") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-social/bootstrap-social.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css">
        <?php
    } elseif ($this->uri->segment(1) == "features_setting_detail") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/codemirror/lib/codemirror.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/codemirror/theme/duotone-dark.css">
        <?php
    } elseif ($this->uri->segment(1) == "features_tickets") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css">
        <?php
    } elseif ($this->uri->segment(2) == "view_departments") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <?php
    } elseif ($this->uri->segment(2) == "view_user") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <?php
    } elseif ($this->uri->segment(2) == "view_companies") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <?php
    } elseif ($this->uri->segment(2) == "new_patients") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <?php
    } elseif ($this->uri->segment(1) == "lab_patient") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <?php
    } else if ($this->uri->segment(1) == "form_view" || $this->uri->segment(2) == "form_view" || $this->uri->segment(1) == "form_view_personal") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "medicine") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
              integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">

    <?php } else if ($this->uri->segment(1) == "bedManagement") { ?>


    <?php } else if ($this->uri->segment(1) == "billing") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "billingMaster") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "patient_info" || $this->uri->segment(1) == "datatableTabSection" || $this->uri->segment(1) == "patient_report") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabsStyle.css">
    <?php } else if ($this->uri->segment(1) == "assignBed") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "serviceOrder" || $this->uri->segment(1) == "serviceOrder1") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "radiologySampleCollection") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "pathologySampleCollection") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(3) == "prescription_master") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "labpatient_info") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "labpatient_report") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabsStyle.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
    <?php } else if ($this->uri->segment(3) == "medicine_master") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "pharmeasy" || $this->uri->segment(1) == "pharmeasy1" || $this->uri->segment(1) == "hospitalMedicine") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(3) == "hospital_order_management" || $this->uri->segment(1) == "hospital_order_management") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "Consumable_Inventory") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "consumableOrder") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(3) == "labReport") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "labReport") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "operation_details") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "icubedManagement") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">

    <?php } else if ($this->uri->segment(1) == "IcunursingCare") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "view_pickup") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "viewOtherService") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } else if ($this->uri->segment(1) == "Dashboard") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <?php
    } elseif ($this->uri->segment(2) == "Html_template") { ?>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>vendor/trumbowyg/dist/ui/trumbowyg.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>vendor/trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>vendor/trumbowyg/dist/plugins/table/ui/trumbowyg.table.min.css">

    <?php } else if ($this->uri->segment(1) == "risknode") { ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>assets/tree_node/css/d3-mitch-tree.min.css">
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>assets/tree_node/css/d3-mitch-tree-theme-default.min.css">
        <link href="<?php echo base_url(); ?>assets/content_menu/basicContext.min.css" rel="stylesheet"
              type="text/css"/>
    <?php } ?>
    <?php if ($this->uri->segment(1) == "html_navigation") { ?>
        <!--		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">

    <?php } ?>
    <?php if ($this->uri->segment(1) == "patient_navigation") { ?>
        <!--        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">


    <?php } ?>
    <?php if ($this->uri->segment(1) == "labMaster") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabsStyle.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
    <?php } ?>

    <?php if ($this->uri->segment(1) == "setup_lab_master" || $this->uri->segment(1) == "setup_child_lab_master" || $this->uri->segment(1) == "master_package") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabsStyle.css">
    <?php } ?>
    <?php if ($this->uri->segment(1) == "") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabsStyle.css">
    <?php } ?>
    <?php if ($this->uri->segment(1) == "opdPanel") { ?>
        <!--        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tabs.css">


    <?php } ?>
    <?php
    if ($this->uri->segment(2) == "Html_template_drag") { ?>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">


        <!-- CSS Libraries -->
        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css"> -->
    <?php } ?>
    <?php
    if ($this->uri->segment(1) == "html_form_view") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } ?>

    <?php
    if ($this->uri->segment(1) == "report_maker") { ?>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery.ui.resizable.css"> -->

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">


    <?php } ?>
    <?php
    if ($this->uri->segment(2) == "Reports_query") { ?>


        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">


    <?php } ?>
    <?php
    if ($this->uri->segment(1) == "access_management" || $this->uri->segment(1) == "branch_access_management") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } ?>
    <?php if ($this->uri->segment(1) == "payerDetails") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
    <?php } ?>
    <?php
    if ($this->uri->segment(1) == "user_management") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/excel_handson/handsontable.full.min.css"/>
    <?php } ?>
    <?php
    if ($this->uri->segment(1) == "ViewReportMaker") { ?>

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">


    <?php } ?>
    <?php if ($this->uri->segment(1) == "security") { ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
        <?php
    } ?>
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">
</head>

<?php
if ($this->uri->segment(1) != "auth_login" && $this->uri->segment(1) != "auth_forgot_password" && $this->uri->segment(1) != "auth_register"
    && $this->uri->segment(1) != "auth_reset_password" && $this->uri->segment(1) != "errors_503" &&
    $this->uri->segment(1) != "errors_403" && $this->uri->segment(1) != "errors_404"
    && $this->uri->segment(1) != "errors_500" && $this->uri->segment(1) != "utilities_contact"
    && $this->uri->segment(1) != "utilities_subscribe"
    && $this->uri->segment(1) != "view_pickup"
    && $this->uri->segment(1) != "view_pickup1"
    && $this->uri->segment(1) != "view_radiologypickup"
    && $this->uri->segment(1) != "labReport"
    && $this->uri->segment(1) != "operation_details"
    && $this->uri->segment(1) !== "html_navigation"
    && $this->uri->segment(1) !== "opdPanel"
    && $this->uri->segment(1) != "viewOtherService"
    && $this->uri->segment(1) != "patient_info"
    && $this->uri->segment(1) != "labMaster"
    && $this->uri->segment(1) != "setup_lab_master"
    && $this->uri->segment(1) != "master_package"
    && $this->uri->segment(1) != "setup_child_lab_master"
    && $this->uri->segment(1) != "patient_report"
    && $this->uri->segment(1) != "datatableTabSection"
    && $this->uri->segment(1) !== "patient_navigation"
    && $this->uri->segment(1) !== "viewLabDashboard"
    && $this->uri->segment(1) != "company" && $this->uri->segment(1) !== "serviceOrder" && $this->uri->segment(1) !== "serviceOrder1"
    && $this->uri->segment(1) !== "pharmeasy1" && $this->uri->segment(1) !== "pharmeasy" && $this->uri->segment(1) !== "hospitalMedicine" && $this->uri->segment(1) !== "discharge_report"
    && $this->uri->segment(1) != "bedManagement" && $this->uri->segment(2) != "dashboard" && $this->uri->segment(1) != "assignBed" &&
    $this->uri->segment(1) != "medicine" && $this->uri->segment(1) !== "form_view" && $this->uri->segment(1) !== "new_patients"
    && $this->uri->segment(1) !== "discharge" && $this->uri->segment(1) !== "billing"
    && $this->uri->segment(3) !== "medicine_master"
    && $this->uri->segment(2) !== "Html_template_drag"
    && $this->uri->segment(1) !== "report_maker"
    && $this->uri->segment(2) !== "Html_template"
    && $this->uri->segment(1) != "security"
    && $this->uri->segment(3) !== "prescription_master" && $this->uri->segment(2) !== "company_admin" && $this->uri->segment(2) !== "chnage_password" && $this->uri->segment(1) != "radiologySampleCollection" && $this->uri->segment(1) != "pathologySampleCollection" && $this->uri->segment(1) != "billingMaster" && $this->uri->segment(3) != "hospital_order_management" && $this->uri->segment(1) !== "staffRegistration" && $this->uri->segment(1) !== "staff" && $this->uri->segment(1) !== "icubedManagement" && $this->uri->segment(1) !== "IcunursingCare" && $this->uri->segment(1) !== "patientReport" && $this->uri->segment(1) !== "consumableOrder" && $this->uri->segment(1) !== "Dashboard" && $this->uri->segment(1) !== "hospital_order_management" && $this->uri->segment(1) !== "Consumable_Inventory" && $this->uri->segment(1) !== "form_view_personal" && $this->uri->segment(1) !== "risknode" && $this->uri->segment(1) !== "icuPatientView"
    && $this->uri->segment(1) !== "labpatient_info" && $this->uri->segment(1) !== "labpatient_report" && $this->uri->segment(1) !== "lab_patient" && $this->uri->segment(1) !== "payerDetails"

) {
    $this->load->view('_partials/layout');
    $this->load->view('_partials/sidebar');
}
if ($this->uri->segment(1) == "report_maker") {
    $this->load->view('_partials/layout_2');
}
if ($this->uri->segment(1) == "ViewReportMaker") {
    $this->load->view('_partials/layout_2');
}
if ($this->uri->segment(1) == "admin" && $this->uri->segment(2) == "Html_template") {
    $this->load->view('_partials/layout_2');
}

if ($this->uri->segment(1) == "security") {
    $this->load->view('_partials/layout_2');
}
if ($this->uri->segment(1) == "labReport") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "operation_details") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "Dashboard") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(2) == "Html_template_drag") {
    $this->load->view('_partials/layout_2');
}
if ($this->uri->segment(2) == "chnage_password") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "discharge_report") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "pharmeasy" || $this->uri->segment(1) == "pharmeasy1" || $this->uri->segment(1) == "hospitalMedicine") {
    $this->load->view('_partials/layout_2');
}
if ($this->uri->segment(1) == "viewOtherService") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "view_pickup" || $this->uri->segment(1) == "view_pickup1") {
    $this->load->view('_partials/layout_2');
}
if ($this->uri->segment(1) == "view_radiologypickup") {
    $this->load->view('_partials/layout_2');
}

if ($this->uri->segment(1) == "serviceOrder" || $this->uri->segment(1) == "serviceOrder1") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}

if ($this->uri->segment(1) == "company") {
    $this->load->view('_partials/layout_2');
    // $this->load->view('_partials/sidebar');
}

if ($this->uri->segment(1) == "patient_info" || $this->uri->segment(1) == "datatableTabSection") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}

if ($this->uri->segment(1) == "viewLabDashboard" || $this->uri->segment(1) == "labMaster") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/lab_left_sidebar');
}


if ($this->uri->segment(1) == "bedManagement") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "IcunursingCare") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}

if ($this->uri->segment(2) == "dashboard") {
    $this->load->view('_partials/layout_2');
//	$this->load->view('_partials/sidebar');
}
if ($this->uri->segment(1) == "assignBed") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "medicine") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "html_navigation") {
    $this->load->view('_partials/layout_2');
    $this->load->view('Form_Show/form_navigation');
}
if ($this->uri->segment(1) == "opdPanel") {
    $this->load->view('_partials/layout_2');
    $this->load->view('Form_Show/form_navigation');
}
if ($this->uri->segment(1) == "form_view") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "new_patients") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "discharge") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "billing") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "patient" && $this->uri->segment(2) == "dashboard") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "company" && $this->uri->segment(2) == "view_user") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/company_sidebar');
}
if ($this->uri->segment(1) == "company" && $this->uri->segment(2) == "company_admin") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/company_sidebar');
}
if ($this->uri->segment(1) == "company" && $this->uri->segment(3) == "medicine_master") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/company_sidebar');
}
if ($this->uri->segment(1) == "company" && $this->uri->segment(3) == "prescription_master") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/company_sidebar');
}
if ($this->uri->segment(1) == "company" && $this->uri->segment(2) == "form_view") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/company_sidebar');
}
if ($this->uri->segment(1) == "company" && $this->uri->segment(3) == "hospital_order_management") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/company_sidebar');
}
if ($this->uri->segment(1) == "radiologySampleCollection") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "pathologySampleCollection") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "billingMaster") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}

if ($this->uri->segment(1) == "staffRegistration") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}

if ($this->uri->segment(1) == "staff" && $this->uri->segment(2) == "dashboard") {
    // $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "icubedManagement") {

    $this->load->view('_partials/layout_2');
    // $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "patientReport") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}

if ($this->uri->segment(1) == "criticalCare") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}

if ($this->uri->segment(1) == "consumableOrder") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}

if ($this->uri->segment(1) == "hospital_order_management") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}

if ($this->uri->segment(1) == "Consumable_Inventory") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}

if ($this->uri->segment(1) == "form_view_personal") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}
if ($this->uri->segment(1) == "risknode") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}
if ($this->uri->segment(1) == "icuPatientView") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/left_sidebar');
}

if ($this->uri->segment(1) == "patient_navigation") {
    $this->load->view('_partials/layout_2');
    $this->load->view('Form_Show/patient_navigation');
}

if ($this->uri->segment(1) == "patient_report") {
    $this->load->view('_partials/layout_2');
}
if ($this->uri->segment(1) == "lab_patient") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/lab_left_sidebar');
}
if ($this->uri->segment(1) == "labpatient_info") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/lab_left_sidebar');
}
if ($this->uri->segment(1) == "labpatient_report") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/lab_left_sidebar');
}
if ($this->uri->segment(1) == "setup_lab_master") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/lab_left_sidebar');
}
if ($this->uri->segment(1) == "setup_child_lab_master") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/lab_left_sidebar');
}
if ($this->uri->segment(1) == "master_package") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/lab_left_sidebar');
}
if ($this->uri->segment(1) == "payerDetails") {
    $this->load->view('_partials/layout_2');
    $this->load->view('_partials/patientLeft_sidebar');
}

?>
