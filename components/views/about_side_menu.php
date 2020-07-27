<?php
use yii\helpers\Url;
?>
<hr>
<div class="panel-group panel-group-primary" id="accordion2Primary">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title <?= (Yii::$app->controller->action->id =='grdjeabout')?'active':''?>">
                <a class="accordion-toggle" href="<?= Url::to(['/grdje']) ?>">About Journal</a>
            </h4>
        </div>

    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title <?= (Yii::$app->controller->action->id =='grdjecallforpaper')?'active':''?>">
                <a class="accordion-toggle" href="<?= Url::to(['/grdje/call-for-paper']) ?>">Call For Paper</a>
            </h4>
        </div>

    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title <?= (Yii::$app->controller->action->id =='grdjeresearcharea')?'active':''?>">
                <a class="accordion-toggle" href="<?= Url::to(['grdje/research-area']) ?>">Research areas</a>
            </h4>
        </div>

    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title <?= (Yii::$app->controller->action->id =='grdjesubmit')?'active':''?>">
                <a class="accordion-toggle" href="<?= Url::to(['grdje/submit-an-article']) ?>">Submit an Article</a>
            </h4>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title <?= (Yii::$app->controller->action->id =='grdjecharges')?'active':''?>">
                <a class="accordion-toggle" href="<?= Url::to(['grdje/publication-charges']) ?>">Publication Charges</a>
            </h4>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title <?= (Yii::$app->controller->action->id =='grdjeimpactfactor')?'active':''?>">
                <a class="accordion-toggle" href="<?= Url::to(['grdje/impact-factor']) ?>">Journal Statistics</a>
            </h4>
        </div>
    </div>
  	<div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title <?= (Yii::$app->controller->action->id =='grdjeindexing')?'active':''?>">
                <a class="accordion-toggle" href="<?= Url::to(['grdje/indexing']) ?>">Indexing Library</a>
            </h4>
        </div>
    </div>
</div>