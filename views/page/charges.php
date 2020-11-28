<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\vendors\Common;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$actionId = $this->context->action->id;
?>
<div role="main" class="main">
    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs"><?= $content->page_title ?></span></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="/">Home</a></li>
                        <li><a href="/grdje">GRDJE</a></li>
                        <li class="active"><?= $content->page_title ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">

        <div class="col-md-4">
            <?= \app\components\AboutSideMenu::widget(); ?>
        </div>


        <div class="col-md-8">
            <div class="tabs tabs-bottom tabs-center tabs-simple">
                <ul class="nav nav-tabs">
                    <li class="nav-item active">
                        <a class="nav-link" href="#tabsNavigationSimple1" data-toggle="tab">FOR INDIAN AUTHOR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabsNavigationSimple2" data-toggle="tab">FOR FOREIGN AUTHOR</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabsNavigationSimple1">
                        <div class="text-center">
                            <h4>PROCESSING CHARGES - FOR INDIAN AUTHOR</h4>
                            <div class="row">
                                <div class="pricing-table">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="plan">
                                            <h3>Enterprise<span>₹1200</span></h3>
                                            <ul>
                                                <li>Manuscript Publication</li>
                                                <li>Review Report</li>
                                                <li>E-Certificate</li>
                                                <li>Indexing</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 center">
                                        <div class="plan most-popular notthis">
                                            <div class="plan-ribbon-wrapper">
                                                <div class="plan-ribbon">Popular</div>
                                            </div>
                                            <h3>Professional<span>₹1450</span></h3>
                                            <ul>
                                                <li>Manuscript Publication</li>
                                                <li>Review Report</li>
                                                <li>E-Certificate</li>
                                                <li>Certificate Hard Copies(Incl. Delivery)</li>
                                                <li>Indexing</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="plan">
                                            <h3>Standard<span>₹1600 </span></h3>
                                            <ul>
                                                <li>Manuscript Publication</li>
                                                <li>Review Report</li>
                                                <li>E-Certificate</li>
                                                <li>Certificate Hard Copies(Incl. Delivery)</li>
                                                <li>Plagiarism Report(Incl. Delivery)</li>
                                                <li>Indexing</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabsNavigationSimple2">
                        <div class="text-center">
                            <h4>PROCESSING CHARGES - FOR FOREIGN AUTHOR</h4>
                            <div class="row">
                                <div class="pricing-table">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="plan">
                                            <h3>Enterprise<span>$100</span></h3>
                                            <ul>
                                                <li>Manuscript Publication</li>
                                                <li>Review Report</li>
                                                <li>E-Certificate</li>
                                                <li>Indexing</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 center">
                                        <div class="plan most-popular notthis">
                                            <div class="plan-ribbon-wrapper">
                                                <div class="plan-ribbon">Popular</div>
                                            </div>
                                            <h3>Professional<span>$130</span></h3>
                                            <ul>
                                                <li>Manuscript Publication</li>
                                                <li>Review Report</li>
                                                <li>E-Certificate</li>
                                                <li>Certificate Hard Copies(Incl. Delivery)</li>
                                                <li>Indexing</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="plan">
                                            <h3>Standard<span>$150 </span></h3>
                                            <ul>
                                                <li>Manuscript Publication</li>
                                                <li>Review Report</li>
                                                <li>E-Certificate</li>
                                                <li>Certificate Hard Copies(Incl. Delivery)</li>
                                                <li>Plagiarism Report(Incl. Delivery)</li>
                                                <li>Indexing</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?= $content->content; ?>
        </div>

    </div>
    <br>
    <br>
</div>
