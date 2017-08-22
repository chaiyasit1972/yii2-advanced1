<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
    <div class="container">
        <h1 class="pull-left">Advanced Forms</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li><a href="">Features</a></li>
            <li class="active">Advanced Forms</li>
        </ul>
    </div>
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Content Part ===-->
<div class="container content">
    <div class="row">
        <!-- Begin Sidebar Menu -->
        <div class="col-md-3">
            <ul class="list-group sidebar-nav-v1" id="sidebar-nav">
                <!-- Typography -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-typography">Typography</a>
                    <ul id="collapse-typography" class="collapse">
                        <li><a href="shortcode_typo_general.html"><i class="fa fa-sort-alpha-asc"></i> General Typography</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_typo_headings.html"><i class="fa fa-magic"></i> Heading Options</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_typo_dividers.html"><i class="fa fa-ellipsis-h"></i> Dividers</a>
                        </li>
                        <li><a href="shortcode_typo_blockquote.html"><i class="fa fa-quote-left"></i> Blockquote Blocks</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_typo_boxshadows.html"><i class="fa fa-asterisk"></i> Box Shadows</a>
                        </li>
                        <li><a href="shortcode_typo_testimonials.html"><i class="fa fa-comments"></i> Testimonials</a></li>
                        <li><a href="shortcode_typo_tagline_boxes.html"><i class="fa fa-tasks"></i> Tagline Boxes</a></li>
                        <li><a href="shortcode_typo_grid.html"><i class="fa fa-align-justify"></i> Grid Layout</a></li>
                    </ul>
                </li>
                <!-- End Typography -->

                <!-- Buttons UI -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-buttons">Buttons UI</a>
                    <ul id="collapse-buttons" class="collapse">
                        <li><a href="shortcode_btn_general.html"><i class="fa fa-flask"></i> General Buttons</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_btn_brands.html"><i class="fa fa-html5"></i> Brand &amp; Social Buttons</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_btn_effects.html"><i class="fa fa-bolt"></i> Loading &amp; Hover Effects</a>
                        </li>
                    </ul>
                </li>
                <!-- End Buttons UI -->

                <!-- Icons -->
                <li class="list-group-item list-toggle">
                    <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-icons">Icons</a>
                    <ul id="collapse-icons" class="collapse">
                        <li>
                            <a href="shortcode_icon_general.html"><i class="fa fa-chevron-circle-right"></i> General Icons</a>
                        </li>
                        <li><a href="shortcode_icon_fa.html"><i class="fa fa-chevron-circle-right"></i> Font Awesome Icons</a></li>
                        <li>
                            <a href="shortcode_icon_line.html"><i class="fa fa-chevron-circle-right"></i> Line Icons</a>
                        </li>
                        <li><a href="shortcode_icon_glyph.html"><i class="fa fa-chevron-circle-right"></i> Glyphicons (Bootstrap)</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_christmas.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Christmas)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_clothes.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Clothes)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_communication.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Communication)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_education.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Education)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_electronics.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Electronics)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_finance.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Finance)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_food.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Food)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_furniture.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Furniture)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_hotel_restaurant.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Hotel Restaurant)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_media.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Media)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_medical.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Medical)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_real_estate.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Real Estate)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_science.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Science)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_sport.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Sport)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_music.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Music)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_travel.html"><i class="fa fa-chevron-circle-right"></i> Line Icons Pro (Travel)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_weather.html"><i class="fa fa-chevron-circle-right"></i>Line Icons Pro (Weather)</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_icon_line_transport.html"><i class="fa fa-chevron-circle-right"></i>Line Icons Pro (Transportation)</a>
                        </li>
                    </ul>
                </li>
                <!-- End Icons -->

                <!-- Thumbails -->
                <li class="list-group-item"><a href="shortcode_thumbnails.html">Thumbnails</a></li>
                <!-- End Thumbails -->

                <!-- Components -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" href="#collapse-components" data-toggle="collapse">Components</a>
                    <ul id="collapse-components" class="collapse">
                        <li><a href="shortcode_compo_messages.html"><i class="fa fa-comment"></i> Alerts &amp; Messages</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_compo_labels.html"><i class="fa fa-tags"></i> Labels &amp; Badges</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_compo_progress_bars.html"><i class="fa fa-align-left"></i> Progress Bars</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_compo_media.html"><i class="fa fa-volume-down"></i> Audio/Videos &amp; Images</a>
                        </li>
                        <li><a href="shortcode_compo_panels.html"><i class="fa fa-columns"></i> Panels</a></li>
                        <li><a href="shortcode_compo_pagination.html"><i class="fa fa-arrows-h"></i> Pagination</a></li>
                    </ul>
                </li>
                <!-- End Components -->

                <!-- Accordion and Tabs -->
                <li class="list-group-item"><a href="shortcode_accordion_and_tabs.html">Accordion and Tabs</a></li>
                <!-- End Accordion and Tabs -->

                <!-- Timeline -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" href="#collapse-timeline" data-toggle="collapse">Timeline</a>
                    <ul id="collapse-timeline" class="collapse">
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_timeline1.html"><i class="fa fa-dot-circle-o"></i> Timeline 1</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_timeline2.html"><i class="fa fa-dot-circle-o"></i> Timeline 2</a>
                        </li>
                    </ul>
                </li>
                <!-- End Timeline -->

                <!-- Carousel Examples -->
                <li class="list-group-item">
                    <span class="badge badge-u">New</span>
                    <a href="shortcode_carousels.html">Carousel Examples</a>
                </li>
                <!-- End Carousel Examples -->

                <!-- Forms -->
                <li class="list-group-item list-toggle active">
                    <a class="accordion-toggle" href="#collapse-forms" data-toggle="collapse">Forms</a>
                    <ul id="collapse-forms" class="collapse in">
                        <li><a href="shortcode_form_general.html"><i class="fa fa-bars"></i> Common Bootstrap Forms</a></li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_form_general1.html"><i class="fa fa-bars"></i> General Unify Forms</a>
                        </li>
                        <li class="active">
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_form_advanced.html"><i class="fa fa-bars"></i> Advanced Forms</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_form_layouts.html"><i class="fa fa-bars"></i> Form Layouts</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_form_layouts_advanced.html"><i class="fa fa-bars"></i> Advanced Form Layouts</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_form_states.html"><i class="fa fa-bars"></i> Form States</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_form_sliders.html"><i class="fa fa-bars"></i> Form Sliders</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_form_modals.html"><i class="fa fa-bars"></i> Modals</a>
                        </li>
                    </ul>
                </li>
                <!-- End Forms -->

                <!-- Tables -->
                <li class="list-group-item"><a href="shortcode_table_general.html">Tables</a></li>
                <!-- End Tables -->

                <!-- Maps -->
                <li class="list-group-item list-toggle">
                    <a class="accordion-toggle" href="#collapse-maps" data-toggle="collapse">Maps</a>
                    <ul id="collapse-maps" class="collapse">
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_maps_google.html"><i class="fa fa-map-marker"></i> Google Maps</a>
                        </li>
                        <li>
                            <span class="badge badge-u">New</span>
                            <a href="shortcode_maps_vector.html"><i class="fa fa-align-center"></i> Vector Maps</a>
                        </li>
                    </ul>
                </li>
                <!-- End Maps -->

                <!-- Charts -->
                <li class="list-group-item">
                    <span class="badge badge-u">New</span>
                    <a href="shortcode_compo_charts.html">Charts &amp; Countdowns</a>
                </li>
                <!-- End Charts -->
            </ul>
        </div>
        <!-- End Sidebar Menu -->

        <!-- Begin Content -->
        <div class="col-md-9">
            <!-- Tabs -->
            <div class="tab-v1">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#home-1" data-toggle="tab">Datepicker Forms</a></li>
                    <li><a href="#profile-1" data-toggle="tab">Validation Forms</a></li>
                    <li><a href="#messages-1" data-toggle="tab">Masking Forms</a></li>
                </ul>
                <div class="tab-content">
                    <!-- Datepicker Forms -->
                    <div class="tab-pane fade in active" id="home-1">
                        <form action="#" id="sky-form" class="sky-form">
                            <header>Datepicker</header>

                            <fieldset>
                                <section>
                                    <label class="label">Select single date</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-calendar"></i>
                                        <input type="text" name="date" id="date">
                                    </label>
                                </section>

                                <label class="label">Select date range</label>
                                <div class="row">
                                    <section class="col col-6">
                                        <label class="input">
                                            <i class="icon-append fa fa-calendar"></i>
                                            <input type="text" name="start" id="start" placeholder="Start date">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="input">
                                            <i class="icon-append fa fa-calendar"></i>
                                            <input type="text" name="finish" id="finish" placeholder="Expected finish date">
                                        </label>
                                    </section>
                                </div>
                            </fieldset>

                            <fieldset>
                                <section>
                                    <label class="label">Select single date with inline datepicker</label>
                                    <div id="inline"></div>
                                </section>

                                <label class="label">Select date range with inline datepickers</label>
                                <div class="row">
                                    <section class="col col-6">
                                        <div id="inline-start"></div>
                                    </section>
                                    <section class="col col-6">
                                        <div id="inline-finish"></div>
                                    </section>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <!-- End Datepicker Forms -->

                    <!-- Validation Forms -->
                    <div class="tab-pane fade" id="profile-1">
                        <form action="#" id="sky-form1" class="sky-form">
                            <header>Available validation rules</header>

                            <fieldset>
                                <div class="row">
                                    <section class="col col-6">
                                        <label class="label">Required field</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="required">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="label">Email validation</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-envelope"></i>
                                            <input type="email" name="email">
                                        </label>
                                    </section>
                                </div>

                                <div class="row">
                                    <section class="col col-6">
                                        <label class="label">URL validation</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-globe"></i>
                                            <input type="url" name="url">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="label">Date validation</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-calendar"></i>
                                            <input type="text" name="date">
                                        </label>
                                    </section>
                                </div>

                                <div class="row">
                                    <section class="col col-4">
                                        <label class="label">Minimum length</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="min">
                                        </label>
                                    </section>
                                    <section class="col col-4">
                                        <label class="label">Maximum length</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="max">
                                        </label>
                                    </section>
                                    <section class="col col-4">
                                        <label class="label">Range length</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="range">
                                        </label>
                                    </section>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="row">
                                    <section class="col col-6">
                                        <label class="label">Digits validation</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="digits">
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label class="label">Decimal number validation</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="number">
                                        </label>
                                    </section>
                                </div>

                                <div class="row">
                                    <section class="col col-4">
                                        <label class="label">Minimum value</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="minVal">
                                        </label>
                                    </section>
                                    <section class="col col-4">
                                        <label class="label">Maximum value</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="maxVal">
                                        </label>
                                    </section>
                                    <section class="col col-4">
                                        <label class="label">Range value</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-asterisk"></i>
                                            <input type="text" name="rangeVal">
                                        </label>
                                    </section>
                                </div>
                            </fieldset>

                            <footer>
                                <button type="submit" class="btn-u btn-u-default">Submit</button>
                                <button type="button" class="btn-u" onclick="window.history.back();">Back</button>
                            </footer>
                        </form>
                    </div>
                    <!-- End Validation Forms -->

                    <!-- Masking Forms -->
                    <div class="tab-pane fade" id="messages-1">
                        <form action="#" id="sky-form2" class="sky-form">
                            <header>Available masking rules</header>

                            <fieldset>
                                <section>
                                    <label class="label">Date masking</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-calendar"></i>
                                        <input type="text" name="date" id="date1">
                                    </label>
                                </section>

                                <section>
                                    <label class="label">Phone masking</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-phone"></i>
                                        <input type="tel" name="phone" id="phone">
                                    </label>
                                </section>

                                <section>
                                    <label class="label">Credit card masking</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-credit-card"></i>
                                        <input type="text" name="card" id="card">
                                    </label>
                                </section>

                                <section>
                                    <label class="label">Serial number masking</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-asterisk"></i>
                                        <input type="text" name="serial" id="serial">
                                    </label>
                                </section>

                                <section>
                                    <label class="label">Tax ID masking</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-briefcase"></i>
                                        <input type="text" name="tax" id="tax">
                                    </label>
                                </section>
                            </fieldset>

                            <footer>
                                <button type="submit" class="btn-u btn-u-default">Submit</button>
                                <button type="button" class="btn-u" onclick="window.history.back();">Back</button>
                            </footer>
                        </form>
                    </div>
                    <!-- End Masking Forms -->
                </div>
            </div>
            <!-- End Tabs-->
        </div>
        <!-- End Content -->
    </div>
</div><!--/container-->
<!--=== End Content Part ===-->

<script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        App.init();
                                        Masking.initMasking();
                                        Datepicker.initDatepicker();
                                        Validation.initValidation();
                                        StyleSwitcher.initStyleSwitcher();
                                    });
</script>

