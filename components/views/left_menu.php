<?php

use backend\models\VolIss;
use yii\helpers\Url;

?>
<div class="col-sm-3 seconddiv div-table-footer">
    <div class="left-sidebar">
        <div class="brands_products padding-bottom-20">
            <h2>CALL FOR PAPERS</h2>

            <div class="blueboxshadow brands-name padding-10"><!--category-productsr-->
                <?php
                $volissue = VolIss::findCurrentIssue();
                ?>
                <table class="table table-striped table-bordered callforpaper text-center table-vcenter">
                    <colgroup>
                        <col style="width:45%">
                        <col style="width:55%">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>Important Dates</th>
                        <th><?= $volissue->detail ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Submission Last Date</td>
                        <td><span class="highlighttext" data-in-effect="bounce"
                                  data-out-effect="fadeOut"><?= date('d-F-Y', strtotime($volissue->last_date)) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><a class="glowbutton" href="<?= Url::to(['page/grdjesubmit']) ?>"> Submit
                                manuscript online</a></td>
                    </tr>
                    </tbody>
                </table>
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

        <?php
        $news = \backend\models\News::find()->where(['status' => 1, 'is_deleted' => 0])->all();
        ?>
        <div class="brands_products padding-bottom-20">
            <h2>NEWS & UPDATES</h2>

            <div class="blueboxshadow brands-name">
                <div class="marquee newsfeed" data-direction="up" data-duplicated="true" data-loop="true"
                     data-scrollamount="2" data-pauseOnHover="true" style="height:200px;overflow: hidden">
                    <ul class="nav">
                        <?php foreach ($news as $nval): ?>
                            <li class="label-info">
                                <a class="ntitle" href="#"><?= $nval->title ?></a>
                            </li>
                            <li>
                                <?= $nval->description ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/brands_products-->
        <div class="brands_products padding-bottom-20">
            <div class="blueboxshadow brands-name">
                <h2>For Authors</h2>
                <ul class="nav nav-pills nav-stacked">
                    <li><a class="alert alert-info" href="<?= Url::to(['page/grdjecharges']) ?>">Processing Charge</a></li>
                    <li><a class="alert alert-info" href="<?= Url::to(['page/payment']) ?>">Submit Payment</a></li>
                    <li><a class="alert alert-info" href="<?= Url::to(['page/paperstatus']) ?>">Check Paper Status</a></li>
                    <li><a class="alert alert-info" href="<?= Url::to(['page/howtopublish']) ?>">How to Publish</a></li>
                    <li><a class="alert alert-info" href="<?= Url::to(['page/searchmanuscript']) ?>">Search Manuscript Online</a></li>
                </ul>
            </div>
        </div>
        <div class="brands_products padding-bottom-20">
            <div class="blueboxshadow brands-name">
                <h2>For Reviewers</h2>
                <ul class="nav nav-pills nav-stacked">
                    <li><a class="alert alert-info" href="<?= Url::to(['page/editorialboard']) ?>">Editorial Board</a></li>
                    <li><a class="alert alert-info" href="<?= Url::to(['page/joinboard']) ?>">Join as Reviewer</a></li>
                </ul>
            </div>
        </div>
        <div class="brands_products padding-bottom-20">
            <div class="blueboxshadow brands-name">
                <h2>Downloads</h2>
                <ul class="nav nav-pills nav-stacked">
                    <li><a class="alert alert-info" href="http://grdjournals.com/uploads/files/GRD-paper-format.pdf">Paper Format</a></li>
                    <li><a class="alert alert-info" href="http://grdjournals.com/uploads/files/GRD-copyright.pdf">Copyright Form</a></li>
                </ul>
            </div>
        </div>


    </div>
</div>
