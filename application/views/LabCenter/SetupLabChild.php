<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<style>
    .content-wrap section
    {
        text-align: unset!important;
    }
    .div_display{
        height: 100% !important;
    }
    .card_body137{
        padding-bottom: 32px !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section section-body_new">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <input type="hidden" id="department_id" name="department_id"
                               value="<?= $dep_id ?>">
                        <input type="hidden" id="section_id" name="section_id"
                               value="<?= $section_id ?>">
                        <input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden"
                               value="<?= $string_param ?>">
                        <input type="hidden" id="hiddenDivName" name="hiddenDivName">

                        <section id="profileSection">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <div class="tabs tabs-style-underline" id="stuplabdiv">


                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php $this->load->view('_partials/footer'); ?>

<script type="text/javascript">
    const base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        let queryParam =document.getElementById("queryparameter_hidden").value;
        let sectionId = document.getElementById("section_id").value;
        let departmentId = document.getElementById("department_id").value;

        get_forms(sectionId, 0, queryParam, departmentId, null, 'stuplabdiv');

    })


</script>
