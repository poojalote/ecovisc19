<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
    .card .card_border101 .shadow-none,
    .card .card_border102 .shadow-none,
    .card .card_border103 .shadow-none,
    .card .card_border104 .shadow-none,
    .card .card_border105 .shadow-none,
    {
        padding: 0!important;
    }
    .card-body.card_body101,.card-body.card_body102,.card-body.card_body103,.card-body.card_body104,.card-body.card_body105{
        padding: 0!important;
    }

</style>
<style type="text/css">
    
    .tabs {
    position: relative;
    overflow: hidden;
    margin: 0 auto;
    width: 100%;
    font-weight: 300;
    font-size: 1.25em;
}

/* Nav */
.tabs nav {
    text-align: center;
}

.tabs nav ul {
    position: relative;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: flex;
    margin: 0 auto;
    padding: 0;
    max-width: 1200px;
    list-style: none;
    -ms-box-orient: horizontal;
    -ms-box-pack: center;
    -webkit-flex-flow: row wrap;
    -moz-flex-flow: row wrap;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    -ms-justify-content: center;
    justify-content: center;
}

.tabs nav ul li {
    position: relative;
    z-index: 1;
    display: block;
    margin: 0;
    text-align: center;
    -webkit-flex: 1;
    -moz-flex: 1;
    -ms-flex: 1;
    flex: 1;
}

.tabs nav a {
    position: relative;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    line-height: 2.5;
}

.tabs nav a span {
    vertical-align: middle;
    font-size: 1em;
}

.tabs nav li.tab-current a {
    color: #74777b;
}

.tabs nav a:focus {
    outline: none;
}
/* Icons */
.icon::before {
    z-index: 10;
    display: inline-block;
    margin: 0 0.4em 0 0;
    vertical-align: middle;
    text-transform: none;
    font-weight: normal;
    font-variant: normal;
    font-size: 1.3em;
    font-family: 'stroke7pixeden';
    line-height: 1;
    speak: none;
    -webkit-backface-visibility: hidden;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
/* Content */
.content-wrap {
    position: relative;
}

.content-wrap section {
    display: none;
    /*margin: 0 auto;*/
    padding: 0px!important;
    max-width: 100%;
    text-align: center;
}

.content-wrap section.content-current {
    display: block;
}

.content-wrap section p {
    margin: 0;
    padding: 0.75em 0;
    color: rgba(40,44,42,0.05);
    font-weight: 900;
    font-size: 4em;
    line-height: 1;
}

/* Fallback */
.no-js .content-wrap section {
    display: block;
    padding-bottom: 2em;
    border-bottom: 1px solid rgba(255,255,255,0.6);
}

.no-flexbox nav ul {
    display: block;
}

.no-flexbox nav ul li {
    min-width: 15%;
    display: inline-block;
}

/*****************************/
/* Underline */
/*****************************/

.tabs-style-underline nav {
    background: #fff;
}

.tabs-style-underline nav a {
    padding: 0.25em 0 0.5em!important;
    border-left: 1px solid #e7ecea;
    -webkit-transition: color 0.2s;
    transition: color 0.2s;
}

.tabs-style-underline nav li:last-child a {
    border-right: 1px solid #e7ecea;
}

.tabs-style-underline nav li a::after {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: #891635;
    content: '';
    -webkit-transition: -webkit-transform 0.3s;
    transition: transform 0.3s;
    -webkit-transform: translate3d(0,150%,0);
    transform: translate3d(0,150%,0);
}

.tabs-style-underline nav li.tab-current a::after {
    -webkit-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
}

.tabs-style-underline nav a span {
    font-weight: 700;
}
.tabs-style-underline nav a:hover
{
    text-decoration: none!important;
    color: #74777b!important;
}
.fa_class
{
    font-size: 22px!important;
}

@media screen and (max-width: 58em) {
    .tabs nav a.icon span {
        display: none;
    }
    .tabs nav a:before {
        margin-right: 0;
    }
}
#dynamicDataTableFilter_0
{
    margin-top: 6px!important;
}
.main-content
{
    width: 100%!important;
    padding-left: 0px!important;
}
.main-footer
{
    width: 100%!important;
    margin-left: 0px!important;
}
</style>
<!-- Main Content start -->
<div class="main-content">
    <section class="section">
        <div class="section-header" style="border-top: 2px solid #891635;color: #891635;">
            <h1>Patient Critical Data</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="">
                            <section>
                                <input type="hidden" id="department_id" name="department_id"
                                       value="">
                                <input type="hidden" id="section_id" name="section_id"
                                       value="">
                                <input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden"
                                       value="">
                                <section id="patient_report_sec">

                                </section>
                               
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>


<!-- Main Content end -->
<?php $this->load->view('_partials/footer'); ?>

<script type="text/javascript">
    
    var base_url="<?php echo base_url(); ?>";
    $(document).ready(function () {
        setInterval(get_forms, 1000 * 60 * 60);
        get_forms(131,0,'patient_report_sec');
       
    });

</script>
