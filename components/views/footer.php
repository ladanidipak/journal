<?php

use yii\helpers\Url;
?>
<footer id="footer" class="m-none" style="background: #34383d">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4 class="mb-xlg">Location</h4>
                <p>
                    712, 7th Floor, Shivalik Shilp<br>
                    Iscon cross road<br>
                    Sarkhej - Gandhinagar Hwy<br>
                    Ahmedabad, Gujarat 380015
                </p>
            </div>
            <!--            <div class="col-md-2">
                            <h4 class="mb-xlg">Opening Hours</h4>
                            <div class="info custom-info">
                                <span>Mon-Fri</span>
                                <span>8:30 am to 5:00 pm</span>
                            </div>
                            <div class="info custom-info">
                                <span>Saturday</span>
                                <span>9:30 am to 1:00 pm</span>
                            </div>
                            <div class="info custom-info">
                                <span>Sunday</span>
                                <span>Closed</span>
                            </div>
                        </div>-->
            <div class="col-md-3">
                <div class="contact-details">
                    <h4 class="mb-xlg">Contact Us</h4>
                    <a class="text-decoration-none" href="mailto:<?= $GLOBALS['settings']['contact_email'] ?>">
                        <i class="fa fa-envelope"></i>&nbsp;<span class="font-weight-light"><?= $GLOBALS['settings']['contact_email'] ?></span>
                    </a>
                    <br>
                    <a class="text-decoration-none" href="tel:<?= $GLOBALS['settings']['contact_phone'] ?>">
                        <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<span class="font-weight-light"><?= $GLOBALS['settings']['contact_phone'] ?></span>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <h4 class="mb-xlg">Quick Links</h4>
                <ul class="list list-icons">
                    <li><i class="fa fa-check"></i> <a href="<?= Url::to(['page/howtopublish']) ?>">Publication process</a></li>
                    <li><i class="fa fa-check"></i> <a href="<?= Url::to(['page/pastissue']) ?>">Archives</a></li>
                    <li><i class="fa fa-check"></i> <a href="<?= Url::to(['page/refundpolicy']) ?>">Policy</a></li>
                    <li><i class="fa fa-check"></i> <a href="<?= Url::to(['page/ethicsdocument']) ?>">Publication Ethics</a></li>
                    <li><i class="fa fa-check"></i> <a href="<?= Url::to(['page/faq']) ?>">FAQ</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h4 class="mb-4">Social Media</h4>
                    <ul class="social-icons">
                        <li class="social-icons-facebook">
                            <a href="https://www.facebook.com/grdjournals" target="_blank" title="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="social-icons-twitter">
                            <a href="https://twitter.com/grdjournals" target="_blank" title="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="social-icons-linkedin">
                            <a href="https://www.linkedin.com/in/grd-journals-235849109" target="_blank" title="Linkedin">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="social-icons-linkedin">
                            <a href="http://grdjournals.blogspot.in" target="_blank" title="Blogger">
                                <img class='blogger' src='<?= BASEURL ?>images/drtheme/blogger.png'>
                            </a>
                        </li>
                    </ul>
                    <ul class="social-icons">
                        <li class="social-icons-linkedin">
                            <a href="https://grdjournals.wordpress.com" target="_blank" title="Wordpress">
                                <img class='blogger' src='<?= BASEURL ?>images/drtheme/wordpress.png'>
                            </a>
                        </li>
                        <li class="social-icons-linkedin">
                            <a href="https://www.instagram.com/grdjournals/" target="_blank" title="Instagram">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                        <li class="social-icons-linkedin">
                            <a href="https://www.pinterest.com/grdjournals" target="_blank" title="Pinterest">
                                <i class="fa fa-pinterest"></i>
                            </a>
                        </li>
                        <li class="social-icons-linkedin">
                            <a href="https://grdjournals.tumblr.com/" target="_blank" title="Tumblr">
                                <i class="fa fa-tumblr"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright pt-md pb-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 center m-none">
                        <p>Copyright © <?= date('Y') ?> GRD Journals. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
</footer>

<!-- <footer id="footer">
  <div class="footer-widget">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
              <div class="single-widget">
                <h2>Publication</h2>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?= Url::to(['page/publicationpolicies']) ?>">Policy</a></li>
                    <li><a href="<?= Url::to(['page/ethicsdocument']) ?>">Ethics</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="single-widget">
                <h2>For Authors</h2>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?= Url::to(['page/grdjesubmit']) ?>">Submit Manuscript</a></li>
                    <li><a href="<?= Url::to(['page/paperstatus']) ?>">Check Paper Status</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="single-widget">
                <h2>Archive</h2>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?= Url::to(['page/pastissue']) ?>">All Issues</a></li>
                    <li><a href="<?= Url::to(['page/specialissue']) ?>">Special Issues</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-3 col-sm-offset-1">
            <div class="single-widget">
                <h2>Subscribe</h2>
<?php $subscriber = new backend\models\Subscriber(); ?>
<?php $form = yii\widgets\ActiveForm::begin(['action' => ['subscriber/create'], 'options' => ['class' => 'searchform']]); ?>
<?= yii\helpers\Html::activeTextInput($subscriber, 'email', ['placeholder' => 'Your Email Address']) ?>
                <button class="btn btn-default" type="submit"><i class="fa fa-arrow-circle-o-right"></i></button>
                <p>Get the most recent updates from <br>our site and be updated your self...</p>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <p class="pull-left">Copyright © <?= date('Y') ?> GRD Journals. All rights reserved.</p>
        </div>
    </div>
</div>
</footer> -->