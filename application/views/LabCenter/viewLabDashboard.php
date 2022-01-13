<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$session_data = $this->session->user_session;
$user_type = $session_data->user_type;
$role = $session_data->roles;
?>

    <!-- Main Content start -->
    <div class="main-content main-content1">
        <section class="section">
            <div class="section-body">
                <div class="">
                    <div class="section-header card-primary">
                        <h1 style="color: #891635">Patient List</h1>
                    </div>
                </div>
            </div>
        </section>
    </div>


<?php $this->load->view('_partials/footer'); ?>