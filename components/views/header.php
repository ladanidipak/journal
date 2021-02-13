<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use backend\models\VolIss;
?>
<?php
$volissue = VolIss::findCurrentIssue();
?>
<!-- <header id="header">
        <div class="header_top">
                <div class="container">
                        <div class="row">
                                <div class="col-sm-6">
                                        <div class="contactinfo">
                                                <ul class="nav nav-pills">
                                                        <li><a href="tel:<?= $GLOBALS['settings']['contact_phone'] ?>"><i class="fa fa-phone"></i> <?= $GLOBALS['settings']['contact_phone'] ?></a></li>
                                                        <li><a href="mailto:<?= $GLOBALS['settings']['contact_email'] ?>"><i class="fa fa-envelope"></i> <?= $GLOBALS['settings']['contact_email'] ?></a></li>
                                                </ul>
                                        </div>
                                </div>
                                <div class="col-sm-6">
                                        <div class="social-icons pull-right">
                                                <ul class="nav navbar-nav">
                                                        <li><a href="https://www.facebook.com/grdjournals" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                                        <li><a href="https://twitter.com/grdjournals" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                                        <li><a href="https://plus.google.com/+grdjournals" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                                </ul>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        <div class="header-middle">
                <div class="container">
                        <div class="row">
                                <div class="col-lg-3">
                                        <div class="logo pull-left grdlogo">
                                                <a href="<?= Url::to(['page/index']) ?>"><img src="<?= BASEURL ?>images/logo.png" alt="" /></a>
                                        </div>
                                        <div class="btn-group pull-right">

                                        </div>
                                </div>
                                <div class="col-lg-9">
                                        <div class="row">
                                                <div class="shop-menu pull-right">
                                                        <ul class="nav navbar-nav">
                                                                <li><a href="<?= Url::to(['page/index']) ?>"><i class="fa fa-bars"></i> Welcome</a></li>
                                                                <li><a href="<?= Url::to(['page/aboutus']) ?>"><i class="fa fa-users"></i> About Us</a></li>
                                                                <li><a href="<?= Url::to(['page/contactus']) ?>"><i class="fa fa-user"></i> Contact Us</a></li>
                                                        </ul>
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-sm-9 remove-left-padding"><h1 class="sitetitle">Global Research and Development Journals</h1></div>
                                                <div class="col-sm-3 pull-right header-issn">GRDJE<br>e-ISSN : 2455-5703</div>
                                        </div>
                                        <div class="row">
                                                <div class="mennucontainer container pull-left">
                                                        <div class="col-sm-12 menustyle">
                                                                <div class="navbar-header">
                                                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                                                                <span class="sr-only">Toggle navigation</span>
                                                                                <span class="icon-bar"></span>
                                                                                <span class="icon-bar"></span>
                                                                                <span class="icon-bar"></span>
                                                                        </button>
                                                                </div>
                                                                <div class="mainmenu pull-left">
                                                                        <ul class="nav navbar-nav collapse navbar-collapse">
                                                                                <li><a href="<?= Url::to(['page/index']) ?>" class="active">Home</a></li>
                                                                                <li class="dropdown"><a href="javascript:;">For Authors<i class="fa fa-angle-down"></i></a>
                                                                                        <ul role="menu" class="sub-menu">
                                                                                                <li><a href="<?= Url::to(['page/howtopublish']) ?>">How to Publish</a></li>
                                                                                                <li><a href="<?= Url::to(['page/authorguideline']) ?>">Author Guideline</a></li>
                                                                                                <li><a href="<?= Url::to(['page/grdjecharges']) ?>">Processing Charge</a></li>
                                                                                                <li><a href="http://grdjournals.com/uploads/files/GRD-paper-format.pdf" target="_blank">Paper Format</a></li>
                                                                                                <li><a href="http://grdjournals.com/uploads/files/GRD-copyright.pdf" target="_blank">Copyright Form</a></li>
                                                                                                <li><a href="<?= Url::to(['page/payment']) ?>">Submit Payment</a></li>
                                                                                                <li><a href="<?= Url::to(['page/paperstatus']) ?>">Check Paper Status</a></li> 
                                                                                                <li><a href="<?= Url::to(['page/searchmanuscript']) ?>">Search Manuscript Online</a></li>
                                                                                                <li><a href="<?= Url::to(['page/confproposal']) ?>">Conference Proposal</a></li> 
                                                                                        </ul>
                                                                                </li> 
                                                                                <li class="dropdown"><a href="javascript:;">For Reviewers<i class="fa fa-angle-down"></i></a>
                                                                                        <ul role="menu" class="sub-menu">
                                                                                                <li><a href="<?= Url::to(['page/editorialboard']) ?>">Editorial Board</a></li>
                                                                                                <li><a href="<?= Url::to(['page/joinboard']) ?>">Join Editorial Board</a></li>
                                                                                        </ul>
                                                                                </li> 
                                                                                <li class="dropdown"><a href="javascript:;">Archive<i class="fa fa-angle-down"></i></a>
                                                                                        <ul role="menu" class="sub-menu">
                                                                                                <li><a href="<?= Url::to(['page/pastissue']) ?>">All Issues</a></li>
                                                                                                <li><a href="<?= Url::to(['page/specialissue']) ?>">Special Issues</a></li>
                                                                                        </ul>
                                                                                </li> 
                                                                                <li class="dropdown"><a href="javascript:;">Download<i class="fa fa-angle-down"></i></a>
                                                                                        <ul role="menu" class="sub-menu">
                                                                                                <li><a target="_blank" href="http://grdjournals.com/uploads/files/GRD-copyright.pdf">Copyright Form</a></li>
                                                                                                <li><a target="_blank" href="http://grdjournals.com/uploads/files/GRD-paper-format.pdf">Paper Template</a></li>
                                                                                                <li><a href="<?= Url::to(['page/download']) ?>">Download Section</a></li>
                                                                                        </ul>
                                                                                </li>
                                                                                <li class="dropdown"><a href="javascript:;">Conference<i class="fa fa-angle-down"></i></a>
                                                                                        <ul role="menu" class="sub-menu">
                                                                                                <li><a href="<?= Url::to(['page/confproposal']) ?>">Conference Proposal</a></li>
                                                                                                <li><a href="<?= Url::to(['page/conferences']) ?>" style="font-size : 16px;">Conference Preceedings</a></li>
                                                                                        </ul>
                                                                                </li>
                                                                                <li><a href="<?= Url::to(['page/ethicsdocument']) ?>">Ethics</a></li>
                                                                                <li><a href="<?= Url::to(['page/faq']) ?>">FAQ</a></li>
                                                                        </ul>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        <div class="header-bottom">
        </div>
</header> -->
<header id="header" class="header-narrow" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 35, "stickySetTop": "-35px", "stickyChangeLogo": false}'>
    <div class="header-body">
        <!--		<div class="header-top header-top header-top-style-3 header-top-custom" style="margin-bottom:0;">
                                <div class="container">
                                        <nav class="header-nav-top pull-right">
                                                <ul class="nav nav-pills">
                                                        <li class="search-id">
                                                                <button type="button" data-toggle="collapse" data-target="#hidd" class="btn btn-primary search-id"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                                        </li>
                                                        <li class="hidden-xs">
                                                                <a href="mailto:<?= $GLOBALS['settings']['contact_email'] ?>"><span class="ws-nowrap"><?= $GLOBALS['settings']['contact_email'] ?></span></a>
                                                        </li>
                                                        <li class="hidden-xs">
                                                                <a href="tel:<?= $GLOBALS['settings']['contact_phone'] ?>"><span class="ws-nowrap"><?= $GLOBALS['settings']['contact_phone'] ?></span></a>
                                                        </li>
                                                        
                                                </ul>
                                        </nav>
                                </div>
                        </div>-->

        <div class="header-container container">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-logo">
                        <a href="<?= Url::to(['/']) ?>"><img src="<?= BASEURL ?>images/logo.png" alt="" /></a>
                    </div>
                </div>
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-nav pt-xs">
                            <button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
                                <i class="fa fa-bars"></i>
                            </button>
                            <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
                                <h3 class="stickyh3">Global Research and Development Journals</h3>
                                <nav>
                                    <ul class="nav nav-pills" id="mainNav">
                                        <li class="activedropdown-full-color dropdown-secondary"><a href="<?= Url::to(['/']) ?>">Home</a></li>
                                        <li class="dropdown dropdown-full-color dropdown-secondary">
                                            <a class="dropdown-toggle" href="javascript:void(0)">
                                                Authors
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?= Url::to(['page/howtopublish']) ?>">How to Publish</a></li>
                                                <li><a href="<?= Url::to(['page/authorguideline']) ?>">Author Guideline</a></li>
                                                <li><a href="<?= Url::to(['grdje/submit-an-article']) ?>">Submit Manuscript online</a></li>
                                                <!-- <li><a href="<?= Url::to(['page/grdjecharges']) ?>">Processing Charge</a></li> -->
                                                <!--<li><a href="http://grdjournals.com/uploads/files/GRD-paper-format.pdf" target="_blank">Paper Format</a></li>-->
                                                <!--<li><a href="http://grdjournals.com/uploads/files/GRD-copyright.pdf" target="_blank">Copyright Form</a></li>-->
                                                <li><a href="<?= Url::to(['page/payment']) ?>">Submit Payment</a></li>
                                                <li><a href="<?= Url::to(['page/paperstatus']) ?>">Check Paper Status</a></li>
                                                <li><a href="<?= Url::to(['page/searchmanuscript']) ?>">Search Manuscript Online</a></li>
                                                <!--<li><a href="<?= Url::to(['page/confproposal']) ?>">Conference Proposal</a></li>-->
                                                <li><a href="<?= Url::to(['page/download']) ?>">Download Section</a></li>
                                                <li><a href="<?= Url::to(['page/grdjeindexing']) ?>">Indexing Library</a></li>
                                                <!--<li><a target="_blank" href="http://grdjournals.com/uploads/files/GRD-copyright.pdf">Copyright Form</a></li>-->
                                                <!--<li><a target="_blank" href="http://grdjournals.com/uploads/files/GRD-paper-format.pdf">Paper Template</a></li>-->
                                                <!--<li><a href="<?= Url::to(['page/faq']) ?>">FAQ</a></li>-->
                                                <!--<li><a href="<?= Url::to(['page/refund_policy']) ?>">Refund Policy</a></li>-->
                                            </ul>
                                        </li>
                                        <li class="dropdown dropdown-full-color dropdown-secondary">
                                            <a class="dropdown-toggle" href="#">
                                                Board Members
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?= Url::to(['page/editorialboard']) ?>">Editorial Board</a></li>
                                                <li><a href="<?= Url::to(['page/reviewerboard']) ?>">Reviewer Board</a></li>
                                                <!-- <li><a href="<?= Url::to(['page/joinboard']) ?>">Join Editorial Board</a></li>-->
                                                <li><a href="<?= Url::to(['page/reviewerguideline']) ?>">Reviewer Guideline</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown dropdown-full-color dropdown-secondary">
                                            <a class="dropdown-toggle" href="#">
                                                Archive
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?= Url::to(['page/pastissue']) ?>">All Issues</a></li>
                                                <li><a href="<?= Url::to(['page/specialissue']) ?>">Special Issues</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown dropdown-full-color dropdown-secondary">
                                            <a class="dropdown-toggle" href="#">
                                                Conference
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?= Url::to(['page/confproposal']) ?>">Conference Proposal</a></li>
                                                <li><a href="<?= Url::to(['page/conferences']) ?>">Conference Preceedings</a></li>
                                                <!--<li><a href="#">Conference Inquiry</a></li>
                                                <li><a href="#">Bulk publishing</a></li>
                                                <li><a href="#">Request contact</a></li>-->
                                            </ul>
                                        </li>
                                        <li><a href="<?= Url::to(['page/ethicsdocument']) ?>">Ethics</a></li>
                                        <li><a href="<?= Url::to(['/contact-us']) ?>">Contact us</a>
                                        </li>
                                        <li><a data-toggle="collapse" data-target="#hidd" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse" id="hidd">
            <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
            <div id="flipkart-navbar">
                <div class="container">

                    <div class="row row2">
                        <br>
                        <?php
                        $form = ActiveForm::begin([
                            'enableClientValidation' => true,
                            'action' => ['searchmanuscript'],
                            'method' => 'get',
                            'fieldConfig' => [
                                'options' => [
                                    'tag' => false,
                                ],
                            ],
                        ]);
                        ?>
                        <div class="flipkart-navbar-search smallsearch col-sm-12">
                            <div class="row">

                                <?= Html::activeTextInput($searchModel, 'search', ['placeholder' => 'Search by one of the following term: Manuscript-id / Title / Author\'s Name / Email Id / Stream / Keyword', 'class' => 'flipkart-navbar-input col-xs-11']); ?>
                                <button type='submit' class="flipkart-navbar-button col-xs-1"><span class="glyphicon glyphicon-search" aria-hidden="true" style="color: #a7a5b8;"></span></button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <!-- <div class="flipkart-navbar-search smallsearch col-sm-12">
                                <div class="row">
                                        <input class="flipkart-navbar-input col-xs-11" type="" placeholder="Search for Products, Brands and more" style=" color:#000 ;">
                                        <button class="flipkart-navbar-button col-xs-1"><span class="glyphicon glyphicon-search" aria-hidden="true" style="color: #a7a5b8;"></span></button>
                                </div>
                        </div> -->
                        <div class="form-inline" style=" width: 100%;  text-align: center;float: left;margin-top: 10px;">
                            <div class="form-group1">

                                <span class="r-label"><b>Search in:&nbsp;</b></span>

                            </div>
                            <div class="form-group1">
                                <input id="search-radio-all" class="form-control1" name="labels" type="radio" value="all" checked="">
                                <label for="search-radio-all" class="r-label">All</label>
                            </div>
                            <div class="form-group1">
                                <input id="search-radio-webpages" class="form-control1" name="labels" type="radio" value="pages">
                                <label for="search-radio-webpages" class="r-label">Webpages</label>
                            </div>
                            <div class="form-group1">
                                <input id="search-radio-books" class="form-control1" name="labels" type="radio" value="books">
                                <label for="search-radio-books" class="r-label">Books</label>
                            </div>
                            <div class="form-group1">
                                <input id="search-radio-journals" class="form-control1" name="labels" type="radio" value="journals">
                                <label for="search-radio-journals" class="r-label">Journals</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<style>
    #flipkart-navbar {
        background-color: #2874f0;
        color: #FFFFFF;
    }

    .row1 {
        padding-top: 10px;
    }

    .row2 {
        padding-bottom: 20px;
    }

    .flipkart-navbar-input {
        padding: 11px 16px 10px;
        border-radius: 2px 0 0 2px;
        border: 0 none;
        outline: 0 none;
        font-size: 15px;
    }

    .flipkart-navbar-button {
        background-color: #f4f4f4;
        border: 1px solid #f4f4f4;
        border-radius: 0 2px 2px 0;
        color: #565656;
        padding: 10px 0;
        height: 43px;
        cursor: pointer;
    }

    .cart-button {
        background-color: #2469d9;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .23), inset 1px 1px 0 0 hsla(0, 0%, 100%, .2);
        padding: 10px 0;
        text-align: center;
        height: 41px;
        border-radius: 2px;
        font-weight: 500;
        width: 120px;
        display: inline-block;
        color: #FFFFFF;
        text-decoration: none;
        color: inherit;
        border: none;
        outline: none;
    }

    .cart-button:hover {
        text-decoration: none;
        color: #fff;
        cursor: pointer;
    }

    .cart-svg {
        display: inline-block;
        width: 16px;
        height: 16px;
        vertical-align: middle;
        margin-right: 8px;
    }

    .item-number {
        border-radius: 3px;
        background-color: rgba(0, 0, 0, .1);
        height: 20px;
        padding: 3px 6px;
        font-weight: 500;
        display: inline-block;
        color: #fff;
        line-height: 12px;
        margin-left: 10px;
    }

    .upper-links {
        display: inline-block;
        padding: 10px 16px 11px;
        line-height: 23px;
        font-family: 'Roboto', sans-serif;
        letter-spacing: 0;
        color: inherit;
        border: none;
        outline: none;
        font-size: 12px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
        margin-bottom: 0px;
    }

    .dropdown:hover {
        background-color: #fff;
    }

    .dropdown:hover .links {
        color: #000;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown .dropdown-menu {
        position: absolute;
        top: 100%;
        display: none;
        background-color: #fff;
        color: #333;
        left: 0px;
        border: 0;
        border-radius: 0;
        box-shadow: 0 4px 8px -3px #555454;
        margin: 0;
        padding: 0px;
    }

    .form-control1 {
        position: relative;
        top: 3px;
    }

    .links {
        color: #fff;
        text-decoration: none;
    }

    .links:hover {
        color: #fff;
        text-decoration: none;
    }

    .profile-links {
        font-size: 12px;
        font-family: 'Roboto', sans-serif;
        border-bottom: 1px solid #e9e9e9;
        box-sizing: border-box;
        display: block;
        padding: 0 11px;
        line-height: 23px;
    }

    .profile-li {
        padding-top: 2px;
    }

    .largenav {
        display: none;
    }

    .smallnav {
        display: block;
    }

    .smallsearch {
        margin-left: 15px;
        margin-top: 15px;
    }

    .menu {
        cursor: pointer;
    }

    @media screen and (min-width: 768px) {
        .largenav {
            display: block;
        }

        .smallnav {
            display: none;
        }

        .smallsearch {
            margin: 0px;
        }
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #fff;
        overflow-x: hidden;
        transition: 0.5s;
        box-shadow: 0 4px 8px -3px #555454;
        padding-top: 0px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
        color: #fff;
    }

    .form-group1 {
        display: inline-block;
    }

    @media screen and (max-height: 450px) {
        .sidenav a {
            font-size: 18px;
        }
    }

    @media screen and (max-width: 550px) {
        .smallsearch {
            margin-left: 0;
            margin-top: 15px;
            width: 90%;
            text-align: center;
            margin: auto;
        }
    }

    .sidenav-heading {
        font-size: 36px;
        color: #fff;
    }
</style>