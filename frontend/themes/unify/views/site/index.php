<?php

/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;

$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
/* @var $this yii\web\View */
/* @var $posts common\models\Post[] */
/* @var $tags common\models\Term[] */
/* @var $pages yii\data\Pagination */

//$this->title = Html::encode(Option::get('sitetitle') . ' - ' . Option::get('tagline'));
//$this->params['breadcrumbs'][] = Html::encode(Option::get('sitetitle'));
?>

<!--=== Slider ===-->

<!--
รูปภาพ
backgroud ให้ set ที่  'assets/plugins/parallax-slider/css/parallax-slider.css' 
frontend/web/assets/.......... file ที่ assets
-->
<div class="slider-inner">
    <div id="da-slider" class="da-slider">
        <!--
        <div class="da-slide">
            <h2><i>CLEAN &amp; FRESH</i> <br /> <i>FULLY RESPONSIVE</i> <br /> <i>DESIGN</i></h2>
            <p><i>Lorem ipsum dolor amet</i> <br /> <i>tempor incididunt ut</i> <br /> <i>veniam omnis </i></p>
            <div class="da-img"><img class="img-responsive" src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/1.png" alt=""></div>
        </div>  
        -->
        <div class="da-slide">
            <h2><i>บริการข้อมูล</i> <br /> <i>ข้อมูลพื้นฐาน</i> <br /> <i>ข้อมูลบริการทั่วไป</i></h2>
            <div class="da-img"><img class="img-responsive" src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/2.png" alt=""></div>
        </div>
        <div class="da-slide">
            <h2><i>RESPONSIVE VIDEO</i> <br /> <i>SUPPORT AND</i> <br /> <i>MANY MORE</i></h2>
            <p><i>Lorem ipsum dolor amet</i> <br /> <i>tempor incididunt ut</i></p>
            <div class="da-img">
                <iframe src="http://player.vimeo.com/video/47911018" width="530" height="300" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            </div>
        </div>
        <div class="da-slide">
            <h2><i>งานบริการข้อมูล</i> <br /> <i>ข้อมูลผู้ป่วยนอก</i> <br /> <i>ข้อมูลผู้ป่วยใน</i></h2>
            <div class="da-img"><img src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/nurse.png" alt="image01" /></div>
        </div>        
        <div class="da-slide">
            <h2><i>บริการข้อมูล</i> <br /> <i>ตัวชีวัด</i> <br /> <i>Service Plan</i></h2>
            <div class="da-img"><img src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/kpi.png" alt="image01" /></div>
        </div>
        <div class="da-slide">
            <h2><i>บริการข้อมูล</i> <br /> <i>งานคลินิพิเศษ</i> <br /></h2>
            <div class="da-img"><img src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/ncd.png" alt="image01" /></div>
        </div>        
        <div class="da-arrows">
            <span class="da-arrows-prev"></span>
            <span class="da-arrows-next"></span>
        </div>
    </div>
</div><!--/slider-->
<!--=== End Slider ===-->

<!--=== Purchase Block ===-->
<!--
<div class="purchase">
    <div class="container">
        <div class="row">
            <div class="col-md-9 animated fadeInLeft">
                <span>Unify is a clean and fully responsive incredible Template.</span>
                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi  vehicula sem ut volutpat. Ut non libero magna fusce condimentum eleifend enim a feugiat corrupti quos.</p>
            </div>
            <div class="col-md-3 btn-buy animated fadeInRight">
                <a href="#" class="btn-u btn-u-lg"><i class="fa fa-cloud-download"></i> Download Now</a>
            </div>
        </div>
    </div>
</div><!--/row-->
<!-- End Purchase Block -->
<!--=== Service Block ===-->

<div class="container content-sm">
    <div class="row">
        <div class="col-md-4 content-boxes-v6 md-margin-bottom-50 thumbnail-kenburn">
            <img src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/2.png" alt="image01" />
            <!--<i class="rounded-x icon-link"></i>-->
            <h1 class="title-v3-md text-uppercase margin-bottom-10">
               <?=Html::a('บริการข้อมูล พื้นฐาน &amp; ทั่วไป', ['service/index1']);?></h1>
            <!--<p>At vero eos et accusato odio dignissimos ducimus qui blanditiis praesentium voluptatum.</p>-->
        </div>
        <div class="col-md-4 content-boxes-v6 md-margin-bottom-50 thumbnail-kenburn">
            <!--<i class="rounded-x icon-paper-plane"></i>-->
            <img src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/nurse.png" alt="image01" />
            <h2 class="title-v3-md text-uppercase margin-bottom-10">งานผู้ป่วยนอก &amp; ผู้ป่วยใน &amp; คลินิกพิเศษ</h2>
            <!--<p>At vero eos et accusato odio dignissimos ducimus qui blanditiis praesentium voluptatum.</p>-->
        </div>
        <div class="col-md-4 content-boxes-v6 thumbnail-kenburn">
            <!--<i class="rounded-x icon-refresh"></i>-->
            <img src="<?= $baseUrl ?>/assets/plugins/parallax-slider/img/kpi.png" alt="image01" />            
            <h2 class="title-v3-md text-uppercase margin-bottom-10">
                      <?=Html::a('ตัวชี้วัด (Kpi)', ['service/index2']);?> &amp; 
                      <?=Html::a('Service Plan', ['service/index3']);?>            
            </h2>
            <!--<p>At vero eos et accusato odio dignissimos ducimus qui blanditiis praesentium voluptatum.</p>-->
        </div>
    </div><!--/row-->
</div><!--/container-->
<!--=== End Service Block ===-->


<div class="container content-sm">
<div class="row margin-bottom-30">
    <!-- Welcome Block -->
    <div class="col-md-8 md-margin-bottom-40">
        <div class="headline"><h2>Welcome To Nangrong Hospital Report</h2></div>
        <div class="row">
            <div class="col-sm-4">
                <img class="img-responsive margin-bottom-20" src="<?= $baseUrl ?>/assets/img/main/img18.jpg"  alt="">
            </div>
            <div class="col-sm-8">
                <p>ระบบรายงาน Nangrong-hosxp Report สนับสนุนบุคลากรในการใช้ข้อมูลในระบบ HIS (Hosxp) โดยรายงานสามารถ ส่งออกไฟล์ Excel & Stilmulsoft Report</p>
                <ul class="list-unstyled margin-bottom-20">
                    <li><i class="fa fa-check color-green"></i> รายงานข้อมูลทั่วไป/ข้อมูลพื้นฐาน</li>
                    <li><i class="fa fa-check color-green"></i> รายงานผู้ป่วยนอก/ใน</li>
                    <li><i class="fa fa-check color-green"></i> รายงานตัวชี้วัด/ service Plan</li>
                    <li><i class="fa fa-check color-green"></i> รายงานคลินิกพิเศษ(โรคไม่ติดต่อเรื้อรัง)</li>
                </ul>
            </div>
        </div>
    </div><!--/col-md-8-->

    <!-- Latest Shots -->
    <div class="col-md-4">
        <div class="headline"><h2>Latest Shots</h2></div>
        <div id="myCarousel" class="carousel slide carousel-v1">
            <div class="carousel-inner">
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/mockup/2.png" alt="">
                    <div class="carousel-caption">
                        <p>Facilisis odio, dapibus ac justo acilisis gestinas.</p>
                    </div>
                </div>
                <div class="item">
                    <img src="<?= $baseUrl ?>/assets/img/mockup/3.png" alt="">
                    <div class="carousel-caption">
                        <p>Cras justo odio, dapibus ac facilisis into egestas.</p>
                    </div>
                </div>
                <div class="item active">
                    <img src="<?= $baseUrl ?>/assets/img/mockup/4.png" alt="">
                    <div class="carousel-caption">
                        <p>Justo cras odio apibus ac afilisis lingestas de.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-arrow">
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div><!--/col-md-4-->
</div>
</div>
<!-- End Info Blokcs -->






<!--=== Intro Block ===-->
<!--
<div class="bg-color-light">
    <div class="container content-sm">
        <div class="headline-center-v2 headline-center-v2-dark margin-bottom-60">
            <h2>About Us</h2>
            <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
            <p>Phasellus vitae ipsum ex. Etiam eu vestibulum ante. <br>
                Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipiscing elit. Morbi libero libero, imperdiet fringilla </p>
        </div><!--/Headline Center v2-->
<!--
        <div class="row">
            <div class="col-md-6 md-margin-bottom-50">
                <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/mockup/4.png" alt="">
            </div>
            <div class="col-md-6">
                <p>Phasellus feugiat elit quam, nec tincidunt leo imperdiet nec. Aliquam et orci orci. In finibus lorem eget sapien mollis finibus. Cras ultrices mollis justo.</p><br>
                <div class="row">
                    <ul class="col-xs-6 list-unstyled lists-v1">
                        <li><i class="fa fa-angle-right"></i>Curabitur porttitor sapien</li>
                        <li><i class="fa fa-angle-right"></i>Donec vitae quam neque</li>
                        <li><i class="fa fa-angle-right"></i>Cum sociis natoque</li>
                        <li><i class="fa fa-angle-right"></i>Aliquam et orci orci</li>
                    </ul>
                    <ul class="col-xs-6 list-unstyled lists-v1">
                        <li><i class="fa fa-angle-right"></i>Curabitur porttitor sapien</li>
                        <li><i class="fa fa-angle-right"></i>Donec vitae quam neque</li>
                        <li><i class="fa fa-angle-right"></i>Cum sociis natoque</li>
                        <li><i class="fa fa-angle-right"></i>Aliquam et orci orci</li>
                    </ul>
                </div>
            </div>
        </div><!--/end row-->
    </div>
</div>
<!--=== End Intro Block ===-->

<!--=== Recent Posts ===-->
<!--
<div class="container content-sm">
    <div class="headline-center-v2 headline-center-v2-dark margin-bottom-60">
        <h2>Recent Posts</h2>
        <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et qua s molestias excepturi vehicula sem ut volutpat. Ut non libero magna fusce co.</p>
    </div><!--/Headline Center V2-->
<!--
    <div class="row">
        <div class="col-sm-4">
            <div class="thumbnails-v1">
                <div class="thumbnail-img">
                    <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/masonry/blog2.jpg" alt="">
                </div>
                <div class="caption">
                    <h3><a href="#">Business Opportunities</a></h3>
                    <p>Donec id elit non mi porta gravida at eget metsit us. Fusce dapibus, justo sit amet risus etiam portapsum generators on the Internet tend to repeat predefined.</p>
                    <p><a class="read-more" href="#">See More</a></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="thumbnails-v1">
                <div class="thumbnail-img">
                    <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/masonry/blog3.jpg" alt="">
                </div>
                <div class="caption">
                    <h3><a href="#">Engage Customers With Unify</a></h3>
                    <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text, all the  ipsum generators.</p>
                    <p><a class="read-more" href="#">See More</a></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="thumbnails-v1">
                <div class="thumbnail-img">
                    <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/masonry/blog4.jpg" alt="">
                </div>
                <div class="caption">
                    <h3><a href="#">Empower People, HCM</a></h3>
                    <p>Donec id elit non mi porta gravida at eget metsit us. Fusce dapibus, justo sit amet risus etiam portapsum generators on the Internet tend to repeat predefined.</p>
                    <p><a class="read-more" href="#">See More</a></p>
                </div>
            </div>
        </div>
    </div>
</div><!--/container-->
<!--=== End Recent Posts ===-->

<!--=== Service Info ===-->
<!--
<div class="service-info margin-bottom-60">
    <div class="container">
        <div class="headline-center-v2 headline-center-v2-dark margin-bottom-60">
            <h2>Features</h2>
            <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et qua s molestias excepturi vehicula sem ut volutpat. Ut non libero magna fusce co.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="margin-bottom-30">
                    <i class="service-info-icon rounded-x icon-wrench"></i>
                    <div class="info-description">
                        <h3 class="title-v3-md text-uppercase">HTML5 + CSS3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nisi augue. Maecenas eu risus ex. Pellentesque laoreet eros at erat lacinia tempus.</p>
                    </div>
                </div>
                <div class="margin-bottom-30">
                    <i class="service-info-icon rounded-x icon-power"></i>
                    <div class="info-description">
                        <h3 class="title-v3-md text-uppercase">Launch Ready</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nisi augue. Maecenas eu risus ex. Pellentesque laoreet eros at erat lacinia tempus.</p>
                    </div>
                </div>
                <div class="md-margin-bottom-30">
                    <i class="service-info-icon rounded-x icon-bell"></i>
                    <div class="info-description">
                        <h3 class="title-v3-md text-uppercase">Fully Responsive</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nisi augue. Maecenas eu risus ex. Pellentesque laoreet eros at erat lacinia tempus.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="responsive-video">
                    <iframe src="//player.vimeo.com/video/78451097?title=0&amp;byline=0&amp;portrait=0&amp;badge=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>
            </div>
        </div><!--/row-->
    </div><!--/container-->
</div>
<!--=== End Service Info ===-->

<!--=== Portfolio Box c2 ===-->
<!--
<div class="container">
    <div class="headline-center-v2 headline-center-v2-dark margin-bottom-60">
        <h2>Portfolio</h2>
        <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et qua s molestias excepturi vehicula sem ut volutpat. Ut non libero magna fusce co.</p>
    </div>
</div><!--/container-->
<!--
<ul class="list-unstyled row portfolio-box-v2 no-margin-bottom">
    <li class="col-sm-3">
        <a class="fancybox" data-rel="gallery" title="Project One" href="assets/img/main/img12.jpg">
            <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/main/img12.jpg" alt="">
            <span class="portfolio-box-v2-in">
                <i class="rounded-x icon-magnifier-add"></i>
            </span>
        </a>
    </li>
    <li class="col-sm-3">
        <a class="fancybox" data-rel="gallery" title="Project Two" href="assets/img/main/img6.jpg">
            <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/main/img6.jpg" alt="">
            <span class="portfolio-box-v2-in">
                <i class="rounded-x icon-magnifier-add"></i>
            </span>
        </a>
    </li>
    <li class="col-sm-3">
        <a class="fancybox" data-rel="gallery" title="Project Three" href="assets/img/main/img17.jpg">
            <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/main/img17.jpg" alt="">
            <span class="portfolio-box-v2-in">
                <i class="rounded-x icon-magnifier-add"></i>
            </span>
        </a>
    </li>
    <li class="col-sm-3">
        <a class="fancybox" data-rel="gallery" title="Project Four" href="assets/img/main/img25.jpg">
            <img class="img-responsive" src="<?= $baseUrl ?>/assets/img/main/img25.jpg" alt="">
            <span class="portfolio-box-v2-in">
                <i class="rounded-x icon-magnifier-add"></i>
            </span>
        </a>
    </li>
</ul>
<!--=== End Portfolio Box c2 ===-->

<!--=== Call To Action ===-->
<!--
<div class="call-action-v1 bg-color-light margin-bottom-60">
    <div class="container">
        <div class="call-action-v1-box">
            <div class="call-action-v1-in">
                <p>Unify creative technology company providing key digital services and focused on helping our clients to build a successful business on web and mobile.</p>
            </div>
            <div class="call-action-v1-in inner-btn page-scroll">
                <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-dark btn-u-block">View Our Portfolio</a>
            </div>
        </div>
    </div>
</div>
<!--=== End Call To Action ===-->

<!--=== Service Block ===-->
<!--
<div class="container">
    <div class="headline-center-v2 headline-center-v2-dark margin-bottom-60">
        <h2>Our Services</h2>
        <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
        <p>Phasellus vitae ipsum ex. Etiam eu vestibulum ante. <br>
            Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipiscing elit. Morbi libero libero, imperdiet fringilla </p>
    </div><!--/Headline Center v2-->
<!--
    <div class="row margin-bottom-60">
        <div class="col-sm-4">
            <div class="service-block-v1 md-margin-bottom-50">
                <i class="rounded-x icon-energy"></i>
                <h3 class="title-v3-bg text-uppercase">Retina ready</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non tincidunt neque.</p>
                <a class="text-uppercase" href="#">Read More</a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="service-block-v1 md-margin-bottom-50">
                <i class="rounded-x icon-badge"></i>
                <h3 class="title-v3-bg text-uppercase">User friendly</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non tincidunt neque.</p>
                <a class="text-uppercase" href="#">Read More</a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="service-block-v1 md-margin-bottom-50">
                <i class="rounded-x icon-diamond"></i>
                <h3 class="title-v3-bg text-uppercase">Powerful Plugins</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non tincidunt neque.</p>
                <a class="text-uppercase" href="#">Read More</a>
            </div>
        </div>
    </div><!--/row-->
<!--
    <div class="row margin-bottom-60">
        <div class="col-sm-4">
            <div class="service-block-v1 md-margin-bottom-50">
                <i class="rounded-x icon-fire"></i>
                <h3 class="title-v3-bg text-uppercase">Stunning Features</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non tincidunt neque.</p>
                <a class="text-uppercase" href="#">Read More</a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="service-block-v1 md-margin-bottom-50">
                <i class="rounded-x icon-trophy"></i>
                <h3 class="title-v3-bg text-uppercase">Most Wanted</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non tincidunt neque.</p>
                <a class="text-uppercase" href="#">Read More</a>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="service-block-v1 md-margin-bottom-50">
                <i class="rounded-x icon-chemistry"></i>
                <h3 class="title-v3-bg text-uppercase">Ready to use</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non tincidunt neque.</p>
                <a class="text-uppercase" href="#">Read More</a>
            </div>
        </div>
    </div><!--/row-->

    <!-- Owl Clients v1 -->
<!--    
    <div class="headline-center-v2 headline-center-v2-dark"><h2>Our Clients</h2>
        <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
    </div>
    <div class="owl-clients-v1">
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/1.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/2.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/3.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/4.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/5.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/6.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/7.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/8.png" alt="">
        </div>
        <div class="item">
            <img src="<?= $baseUrl ?>/assets/img/clients4/9.png" alt="">
        </div>
    </div>
    <!-- End Owl Clients v1 -->
</div><!--/container-->
<!-- End Content Part -->

</div><!--/container-->
<!--=== End Service Block ===-->

<!--=== Testimonials Section ===-->
<!---
<div class="bg-color-light margin-bottom-60">
    <div class="container content-md">
        <div class="headline-center-v2 headline-center-v2-dark margin-bottom-60">
            <h2>WHAT PEOPLE SAY</h2>
            <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
            <p>Phasellus vitae ipsum ex. Etiam eu vestibulum ante. <br>
                Lorem ipsum <strong>dolor</strong> sit amet, consectetur adipiscing elit. Morbi libero libero, imperdiet fringilla </p>
        </div><!--/Headline Center v2-->
<!--
        <div class="row">
            <div class="col-sm-6">
                <div class="testimonials-v4 md-margin-bottom-50">
                    <div class="testimonials-v4-in">
                        <p>The best programs are written so that computing machines can perform them quickly and so that human beings can understand them clearly. A programmer is ideally an essayist who works with traditional aesthetic and literary forms as well as mathematical concepts.</p>
                    </div>
                    <img class="rounded-x" src="<?= $baseUrl ?>/assets/img/testimonials/img5.jpg" alt="thumb">
                    <span class="testimonials-author">
                        Jeremy Asigner<br>
                        <em>Web Developer, <a href="#">Google Inc.</a></em>
                    </span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="testimonials-v4">
                    <div class="testimonials-v4-in">
                        <p>We see a lot of feature-driven product design in which the cost of features is not properly accounted. Features can have a negative value to customers because they make the products more difficult to understand and use. We are finding that people like products that just work.</p>
                    </div>
                    <img class="rounded-x" src="<?= $baseUrl ?>/assets/img/testimonials/img4.jpg" alt="thumb">
                    <span class="testimonials-author">
                        John Davenport<br>
                        <em>UX/UI Designer, <a href="#">Apple Inc.</a></em>
                    </span>
                </div>
            </div>
        </div>



    </div><!--/end container
-->
</div>
<!--=== End Section ===-->