<?php

use app\assets\AppAsset;
//use app\assets\DrthemeAsset;
use common\models\Common;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\base\Widget;
use app\components\LeftMenuWidget;
use app\components\RightMenuWidget;
use yii\helpers\Url;
use backend\models\Testimonials;

AppAsset::register($this);
//DrthemeAsset::register($this);
$this->beginContent('@app/views/layouts/mainlayout.php');
?>  
<div class="modal fade" tabindex="-1" role="dialog" id="notification-modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Notification</h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->render("@app/views/layouts/_message"); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php if ($this->context->sliderVisible): ?>
    <div role="main" class="main">
        <div class="slider-container rev_slider_wrapper" style="height: 415px;">
            <div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options='{"delay": 3000, "gridwidth": 1200, "gridheight": 415, "disableProgressBar": "on", "navigation": {"bullets": {"enable": true, "direction": "vertical", "h_align": "right", "v_align": "center", "space": 6}, "arrows": {"enable": false}}}'>
                <ul>
                    <li data-transition="fade">
                        <img src="<?= BASEURL ?>images/drtheme/slider1.jpg"  
                             alt=""
                             data-bgposition="center center" 
                             data-bgfit="cover" 
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                        <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-5"
                             data-start="1500"
                             data-whitespace="nowrap"                         
                             data-transform_in="y:[100%];s:500;"
                             data-transform_out="opacity:0;s:500;"
                             style="z-index: 5; font-size: 1.5em;"
                             data-mask_in="x:0px;y:0px;">Peer reviewed process to ensure quality</div>

                        <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-55"
                             data-start="500"
                             style="z-index: 5; text-transform: uppercase; font-size: 52px;"
                             data-transform_in="y:[-300%];opacity:0;s:500;">Ensure Quality</div>
                    </li>
                    <li data-transition="fade">
                        <img src="<?= BASEURL ?>images/drtheme/slider2.jpg"
                             alt=""
                             data-bgposition="center center" 
                             data-bgfit="cover" 
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                        <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-5"
                             data-start="1500"
                             data-whitespace="nowrap"                         
                             data-transform_in="y:[100%];s:500;"
                             data-transform_out="opacity:0;s:500;"
                             style="z-index: 5; font-size: 1.5em;"
                             data-mask_in="x:0px;y:0px;">Voluntary reviewer across the globe.</div>

                        <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-55"
                             data-start="500"
                             style="z-index: 5; text-transform: uppercase; font-size: 52px;"
                             data-transform_in="y:[-300%];opacity:0;s:500;">Reviewer across globe</div>
                    </li>
                    <li data-transition="fade">
                        <img src="<?= BASEURL ?>images/drtheme/slider4.jpg"
                             alt=""
                             data-bgposition="center center" 
                             data-bgfit="cover" 
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                    <!--    <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-5"
                             data-start="1500"
                             data-whitespace="nowrap"                         
                             data-transform_in="y:[100%];s:500;"
                             data-transform_out="opacity:0;s:500;"
                             style="z-index: 5; font-size: 1.5em"
                             data-mask_in="x:0px;y:0px;">Fast and Efficient Publication across all popular platform.</div>

                        <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-55"
                             data-start="500"
                             style="z-index: 5; text-transform: uppercase; font-size: 52px;"
                             data-transform_in="y:[-300%];opacity:0;s:500;">Fast and Efficient Publication</div>-->
                    </li>
                    <li data-transition="fade">
                        <img src="<?= BASEURL ?>images/drtheme/slider3.jpg"
                             alt=""
                             data-bgposition="center center" 
                             data-bgfit="cover" 
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                     <!--   <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-5"
                             data-start="1500"
                             data-whitespace="nowrap"                         
                             data-transform_in="y:[100%];s:500;"
                             data-transform_out="opacity:0;s:500;"
                             style="z-index: 5; font-size: 1.5em"
                             data-mask_in="x:0px;y:0px;">Talk to us now to schedule a medical appointment</div>

                        <div class="tp-caption main-label"
                             data-x="left" data-hoffset="25"
                             data-y="center" data-voffset="-55"
                             data-start="500"
                             style="z-index: 5; text-transform: uppercase; font-size: 52px;"
                             data-transform_in="y:[-300%];opacity:0;s:500;"></div>-->
                    </li>

                </ul>
            </div>
        </div>
        <section class="section-custom-medical">
            <div class="container">
                <div class="row medical-schedules">
                    <div class="col-lg-3 box-one background-color-primary appear-animation" data-appear-animation="fadeInLeft" data-appear-animation-delay="0">
                        <div class="feature-box feature-box-style-2 p-lg">
                            <a href="<?= Url::to(['grdje/call-for-paper']) ?>">
                                <div class="feature-box-icon">
                                    <img src="<?= BASEURL ?>images/medical/icons/medical-icon-heart.png" alt class="img-responsive pt-xs" />
                                </div>
                                <div class="feature-box-info ml-md line-height">
                                    <h4 class="m-none">Call for paper</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 box-two background-color-tertiary appear-animation" data-appear-animation="fadeInLeft" data-appear-animation-delay="600">
                        <h5 class="m-none">
                            <a href="/how-to-publish-an-article" title="">
                                How to publish paper
                                <i class="icon-arrow-right-circle icons"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="col-lg-3 box-two background-color-tertiary appear-animation" data-appear-animation="fadeInLeft" data-appear-animation-delay="1200">
                        <h5 class="m-none">
                            <a href="/grdje/submit-an-article" title="">
                                Submit your paper
                                <i class="icon-arrow-right-circle icons"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="col-lg-3 box-two background-color-tertiary appear-animation" data-appear-animation="fadeInLeft" data-appear-animation-delay="1800">
                        <h5 class="m-none">
                            <a href="/grdje/publication-charges" title="">
                                Processing Charge
                                <i class="icon-arrow-right-circle icons"></i>
                            </a>
                        </h5>
                    </div>


                </div>
                <div class="row mt-xlg pt-xlg pb-xs">
                    <div class="col-sm-8 col-md-8">
                        <h2 class="font-weight-semibold mb-xs">About Us</h2>
                        <p><?= $content ?></p>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <img src="<?= BASEURL ?>images/drtheme/extradesign2.jpg" alt class="img-responsive box-shadow-custom" /> 
                    </div>
                </div>
            </div>
        </section>
        <section class="section section-no-border" style="padding-top: 25px;">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12">
                        <h2 class="font-weight-semibold mb-xs">Our Journals</h2>
                        <label>&nbsp;</label>
                    </div>
                </div>
                <div class="brands_products padding-bottom-20">
                    <div class="table-responsive">          
                        <table class="table">
                            <tbody>
                                <tr class="first_row">
                                    <td>GRDJE</td>
                                    <td><ul class="nav padding-10">
                                            <li>
                                                <a class="alert alert-info" role="alert" href="<?= Url::to(['page/grdjeabout']) ?>">GRD Journal
                                                    For Engineering</a>
                                            </li>
                                        </ul></td>
                                </tr>
                                <tr class="second_row">
                                    <td class='image_cell' style="width:17%">
                                        <img src="/design_elements/images/grdje.jpg" alt="" />
                                    </td>
                                    <td style="width:80%">
                                        <ul>
                                            <li>ISSN: 2455-5703</li>
                                            <li>Impact Factor: 2.018</li>
                                           <!-- <li>IC Value: 65.67</li>-->
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <!--        <section class="section section-no-border" style="padding-top: 25px;">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <h2 class="font-weight-semibold mb-xs">Our Journals</h2>
                    <label>&nbsp;</label>
                </div>
            </div>
            <div class="brands_products padding-bottom-20">
                <div class="brands-name blueboxshadow">
                    <h2>LIST OF JOURNALS</h2>
                    <ul class="nav padding-10">
                        <li>
                            <a class="alert alert-info" role="alert" href="<?= Url::to(['page/grdjeabout']) ?>">GRD Journal
                                For Engineering</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>-->

    <section class="team">
        <div class="container">
            <div class="row">
                <div class="owl-carousel owl-theme nav-bottom rounded-nav pl-xs pr-xs" data-plugin-options='{"items": 1, "loop": true, "dots": false, "nav": true,"autoplay":true}'>
                    <?php
                    $editors = \backend\models\EditorialBoard::find()->where(['show_in_front' => 1])->all();

                    for ($i = 0; $i < count($editors); $i++) {
                        ?>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="team_img">
                                                <?php if (isset($editors[$i]->profile_pic) && $editors[$i]->profile_pic) { ?>
                                                    <img src="<?= BASEURL . "../uploads/reviewer_pic/" . $editors[$i]->profile_pic ?>" class="img-responsive" alt="">
                                                <?php } else { ?>
                                                    <img src="<?= BASEURL ?>images/drtheme/avatar.jpg" class="img-responsive" alt="">
                                                <?php } ?>
                                            </div>
                                        </div><!--col-md-5-->
                                        <div class="col-md-8">
                                            <a href="<?= BASEURL ?>../editorial-board" target="_blank" class="text-decoration-none">
                                                <span class="custom-thumb-info-inner font-weight-semibold text-lg"><?= $editors[$i]->full_name ?></span><br>
                                            </a>
                                            <span class="custom-thumb-info-type font-weight-light text-md"><strong><?= $editors[$i]->qualification ?></strong> - <strong><?= ($editors[$i]->branch_id) ? $editors[$i]->branch->name : $editors[$i]->branch_name ?></strong></span><br>
                                            <span class="custom-thumb-info-type font-weight-light text-md"><strong>Specialization : </strong><?= $editors[$i]->specialization ?></span><br>
                                        </div><!--col-md-7-->
                                    </div><!--row-->
                                </div><!--col-md-6-->
                                <?php
                                if (isset($editors[$i + 1])) {
                                    $i++;
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="team_img">
                                                    <?php if (isset($editors[$i]->profile_pic) && $editors[$i]->profile_pic) { ?>
                                                        <img src="<?= BASEURL . "../uploads/reviewer_pic/" . $editors[$i]->profile_pic ?>" class="img-responsive" alt="">
                                                    <?php } else { ?>
                                                        <img src="<?= BASEURL ?>images/drtheme/avatar.jpg" class="img-responsive" alt="">
                                                    <?php } ?>
                                                </div><!--team_img-->
                                            </div><!--col-md-5-->
                                            <div class="col-md-8">
                                                <a href="<?= BASEURL ?>../editorial-board" target="_blank"  class="text-decoration-none">
                                                    <span class="custom-thumb-info-inner font-weight-semibold text-lg"><?= $editors[$i]->full_name ?></span><br>
                                                </a>
                                                <span class="custom-thumb-info-type font-weight-light text-md"><strong><?= $editors[$i]->qualification ?></strong> - <strong><?= ($editors[$i]->branch_id) ? $editors[$i]->branch->name : $editors[$i]->branch_name ?></strong></span><br>
                                                <span class="custom-thumb-info-type font-weight-light text-md"><strong>Specialization : </strong><?= $editors[$i]->specialization ?></span><br>
                                            </div><!--col-md-7-->
                                        </div><!--row-->
                                    </div>
                                <?php } ?>
                            </div>
                            <br>
                            <div class="row">
                                <?php
                                if (isset($editors[$i + 1])) {
                                    $i++;
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="team_img">
                                                    <?php if (isset($editors[$i]->profile_pic) && $editors[$i]->profile_pic) { ?>
                                                        <img src="<?= BASEURL . "../uploads/reviewer_pic/" . $editors[$i]->profile_pic ?>" class="img-responsive" alt="">
                                                    <?php } else { ?>
                                                        <img src="<?= BASEURL ?>images/drtheme/avatar.jpg" class="img-responsive" alt="">
                                                    <?php } ?>
                                                </div>
                                            </div><!--col-md-5-->
                                            <div class="col-md-8">
                                                <a href="<?= BASEURL ?>../editorial-board" target="_blank" class="text-decoration-none">
                                                    <span class="custom-thumb-info-inner font-weight-semibold text-lg"><?= $editors[$i]->full_name ?></span><br>
                                                </a>
                                                <span class="custom-thumb-info-type font-weight-light text-md"><strong><?= $editors[$i]->qualification ?></strong> - <strong><?= ($editors[$i]->branch_id) ? $editors[$i]->branch->name : $editors[$i]->branch_name ?></strong></span><br>
                                                <span class="custom-thumb-info-type font-weight-light text-md"><strong>Specialization : </strong><?= $editors[$i]->specialization ?></span><br>
                                            </div><!--col-md-7-->
                                        </div><!--row-->
                                    </div><!--col-md-6-->
                                    <?php
                                }
                                if (isset($editors[$i + 1])) {
                                    $i++;
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="team_img">
                                                    <?php if (isset($editors[$i]->profile_pic) && $editors[$i]->profile_pic) { ?>
                                                        <img src="<?= BASEURL . "../uploads/reviewer_pic/" . $editors[$i]->profile_pic ?>" class="img-responsive" alt="">
                                                    <?php } else { ?>
                                                        <img src="<?= BASEURL ?>images/drtheme/avatar.jpg" class="img-responsive" alt="">
                                                    <?php } ?>
                                                </div><!--team_img-->
                                            </div><!--col-md-5-->
                                            <div class="col-md-8">
                                                <a href="<?= BASEURL ?>../editorial-board" target="_blank"  class="text-decoration-none">
                                                    <span class="custom-thumb-info-inner font-weight-semibold text-lg"><?= $editors[$i]->full_name ?></span><br>
                                                </a>
                                                <span class="custom-thumb-info-type font-weight-light text-md"><strong><?= $editors[$i]->qualification ?></strong> - <strong><?= ($editors[$i]->branch_id) ? $editors[$i]->branch->name : $editors[$i]->branch_name ?></strong></span><br>
                                                <span class="custom-thumb-info-type font-weight-light text-md"><strong>Specialization : </strong><?= $editors[$i]->specialization ?></span><br>
                                            </div><!--col-md-7-->
                                        </div><!--row-->
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-no-border mb-none mt-none" style="padding-top: 25px;">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <h2 class="font-weight-semibold mb-xs">Feature</h2>
                    <label>&nbsp;</label>
                </div>
            </div>
            <div class=" pt-xl">

                <div class="owl-carousel owl-theme show-nav-hover" data-plugin-options='{"items": 1, "margin": 10,"autoplay":true,"loop":true}'>
                    <!--item-->
                    <div>
                        <div class="row"  >
                            <div class="col-md-3 col-sm-6">
                                <div class="featured-box featured-box-primary featured-box-effect-1">
                                    <div class="box-content">
                                        <i class="icon-featured  fa fa-unlock-alt"></i>
                                            <!--<img src="<?= BASEURL ?>images/drtheme/openaccess.png" class="icon-featured" alt="">-->
                                        <h4 class="text-uppercase">Open Access</h4>
                                        <p>Freely accessible archives containing previously published research work.</p>
                                        <p><a href="<?= Url::to(['page/pastissue']) ?>" class="lnk-primary learn-more">Archives<i class="fa fa-angle-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="featured-box featured-box-primary featured-box-effect-1">
                                    <div class="box-content">
                                        <i class="icon-featured fa fa-book"></i>
                                        <h4 class="text-uppercase">Publication</h4>
                                        <p>Easy, double blinded and fast peer reviewing process by editorial board members from reputed institutions worldwide.</p>
                                        <p><a href="<?= Url::to(['/how-to-publish-an-article']) ?>" class="lnk-primary learn-more">Publication Procedure Step By<i class="fa fa-angle-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="featured-box featured-box-primary featured-box-effect-1">
                                    <div class="box-content">
                                        <i class="icon-featured fa fa-search"></i>
                                        <h4 class="text-uppercase">Indexing</h4>
                                        <p>Indexing in well-known indexing databases across world.</p>
                                        <p><a href="<?= Url::to(['grdje/indexing']) ?>" class="lnk-primary learn-more">Indexing<i class="fa fa-angle-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="featured-box featured-box-primary featured-box-effect-1">
                                    <div class="box-content">
                                        <i class="icon-featured fa fa-clipboard"></i>
                                        <h4 class="text-uppercase">Reporting</h4>
                                        <p>Plagiarism reports, Free review reports for each review.</p>
                                        <p><a href="#" class="lnk-primary learn-more">Learn More <i class="fa fa-angle-right"></i></a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--/item-->
                    <!--item-->
                    <!--<div>
                        <div class="row"  >
                            <div class="col-md-3 col-sm-6">
                                <div class="featured-box featured-box-primary featured-box-effect-1">
                                    <div class="box-content">
                                        <i class="icon-featured fa fa-bell"></i>
                                        <h4 class="text-uppercase">Updates</h4>
                                        <p>Article tracking and notification through phone/email</p>
                                        <p><a href="<?= Url::to(['/check-your-paper-status']) ?>" class="lnk-primary learn-more">Track manuscript<i class="fa fa-angle-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!--/item-->


                </div>


            </div>

        </div>
    </section>
    <section class="section mb-none mt-none" style="background:#fff;padding: 10px 0px;">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <h2 class="font-weight-semibold mb-xs">Indexing Libraries</h2>
                    <label>&nbsp;</label>
                </div>
            </div>
            <div class="row pt-xl">
                <div class="col-md-12 logo-ashish">
                    <div class="team">
                        <div class="container">
                            <div class="row mb-xlg">
                                <div class="owl-carousel owl-theme nav-bottom rounded-nav pl-xs pr-xs" data-plugin-options='{"items": 6, "loop": true, "dots": true, "nav": false}'>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="https://scholar.google.co.in/citations?user=GFDfgr0AAAAJ"><img src="<?= BASEURL ?>images/drtheme/flogo_GoogleScholar.jpg"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="http://independent.academia.edu/GrdJournals"><img class="img-responsive img-rounded" src="<?= BASEURL ?>images/drtheme/flogo_academia-edu.jpg"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="https://www.slideshare.net/GRDJournals1?utm_campaign=profiletracking&utm_medium=sssite&utm_source=ssslideview"><img src="<?= BASEURL ?>images/drtheme/sideshare.jpg"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="https://issuu.com/grdjournals"><img src="<?= BASEURL ?>images/drtheme/flogo_issuu.jpg"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="https://www.scribd.com/user/305339703/GRD-Journals"><img src="<?= BASEURL ?>images/drtheme/flogo_scribd.jpg"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="https://journals.indexcopernicus.com/search/journal/issue?issueId=all&journalId=46907"><img src="<?= BASEURL ?>images/drtheme/download.png"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="http://journalseeker.researchbib.com/view/issn/2455-5703"><img src="<?= BASEURL ?>images/drtheme/bib.png"></a>
                                        </div>
                                    </div>

				    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="#"><img src="<?= BASEURL ?>images/drtheme/Cornell_University.jpg"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="#"><img src="<?= BASEURL ?>images/drtheme/semantic_scholar_og.jpg"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="#"><img src="<?= BASEURL ?>images/drtheme/jgate.png"></a>
                                        </div>
                                    </div>
                                    <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="https://www.citefactor.org/journal/index/23793/grd-journal-for-engineering#.Xw6xYigzbIU"><img src="<?= BASEURL ?>images/drtheme/citefactor_logo.png"></a>
                                        </div>
                                    </div>
                                     <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="http://olddrji.lbp.world/JournalProfile.aspx?jid=2455-5703"><img src="<?= BASEURL ?>images/drtheme/DRJI.png"></a>
                                        </div>
                                    </div>
                                     <div class="pr-sm pl-sm">
                                        <div class="gray_small_img">
                                            <a href="https://www.worldcat.org/title/global-research-and-development-journal-for-engineering/oclc/1127437816&referer=brief_results"><img src="<?= BASEURL ?>images/drtheme/World_Cat.png"></a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-primary mb-none mt-none">
        <div class="container">
            <div class="row">
                <div class="counters counters-text-light">
                    <div class="col-md-3 col-sm-6">
                        <div class="counter">
                            <strong data-to="3000" data-append="+">0</strong>
                            <label>Authors across world</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="counter">
                            <strong data-to="500" data-append="+">0</strong>
                            <label>Reviewers Worldwide</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="counter">
                            <strong data-to="30" data-append="+">0</strong>
                            <label>Issues Published</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="counter">
                            <strong data-to="7" data-append="+">0</strong>
                            <label>Conferences hosted</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (count(Testimonials::getActiveTestimonials()) > 0) { ?>
        <section class="section-secondary">
            <div class="container">
                <div class="row mt-xlg pt-md mb-xlg pb-md">
                    <div class="owl-carousel owl-theme nav-bottom rounded-nav" data-plugin-options='{"items": 1,"autoplay":true, "loop": true, "dots": false}'>
                        <?php foreach (Testimonials::getActiveTestimonials() as $testimonial) { ?>
                            <div>
                                <div class="col-md-8 col-md-offset-2 pt-xlg">
                                    <div class="testimonial testimonial-style-2 testimonial-with-quotes mb-none">
                                        <div class="testimonial-quote">“</div>
                                        <blockquote>
                                            <p class="font-weight-light"><?= $testimonial->description ?></p>
                                        </blockquote>
                                        <div class="testimonial-author mt-xlg">
                                            <p class="text-uppercase">
                                                <strong><?= $testimonial->author ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
<?php endif; ?>
<?php if (Yii::$app->controller->id . '/' . Yii::$app->controller->action->id != 'page/index') { ?>
    <?= $content ?>
<?php } ?>
<?php // \app\components\RightMenuWidget::widget();  ?>
<?php $this->endContent(); ?>
