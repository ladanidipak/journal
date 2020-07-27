<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->registerJsFile("@web/design_elements/js/clipboard.min.js", ['position' => View::POS_END]);
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div role="main" class="main">

    <section class="page-header page-header-color page-header-primary page-header-float-breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-xs">SEARCH MANUSCRIPT ONLINE</span></h1>
                    <ul class="breadcrumb breadcrumb-valign-mid">
                        <li><a href="/">Home</a></li>
                        <li class="active">SEARCH MANUSCRIPT ONLINE</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="heading heading-border heading-middle-border heading-middle-border-center center">
                <h2><span class="text-color-secondary">SEARCH MANUSCRIPT ONLINE</span></h2>
            </div>
            <div class="col-md-6">
                <?php
                $form = ActiveForm::begin([
                            'enableClientValidation' => true,
                            'action' => ['page/searchmanuscript'],
                            'method' => 'get',
                ]);
                ?>
                <div class="form-group ">
                    <label>Search by one of the following term: Manuscript-id / Title / Author's Name / Email Id / Stream / Keyword</label>
                    <?= $form->field($searchModel, 'search', ['inputOptions' => ['placeholder' => backend\vendors\Common::translateText("SEARCH_BTN_TEXT"), 'class' => 'form-control'],])->label(false); ?>

                </div>

                <div class="form-group ">
                    <?= Html::submitButton(backend\vendors\Common::translateText("SEARCH_BTN_TEXT"), ['class' => 'btn btn-primary pull-left']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="row">
            <div class="features_items prit_items"><!--features_items-->
                <?php
                if ($dataProvider->totalCount != 0) {
                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_search_article'
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="features_items prit_items"><!--features_items-->
    <?php
//    if ($dataProvider->totalCount != 0) {
  //      echo \yii\widgets\ListView::widget([
    //        'dataProvider' => $dataProvider,
      //      'itemView' => '_search_article'
       // ]);

        /* echo GridView::widget([
          'dataProvider' => $dataProvider,
          'options' => ['class' => 'project-list'],
          'tableOptions' => ['class' => 'table table-hover',],
          'summaryOptions' => ['class' => 'dataTables_info'],
          'layout' => "{items}\n{summary}\n<div class=\"pull-right\">{pager}</div>",
          'columns' => [
          [
          'header' => 'No.',
          'class' => SerialColumn::className()
          ],
          [
          'attribute' => 'Title and Author',
          'content' => function ($publish) {
          return '<a href="' . Url::to(['page/article', 'paper_id' => $publish->article->paper_id]) . '" class="archive-title">' . $publish->title . '</a><br>
          -' . $publish->authors . '<br>
          <div class="cart_delete">
          <a class="cart_quantity_delete citation-link" href="javascript:;">
          Cite
          </a>
          <span class="citation-hide">
          ' . ($publish->authors . ". \"$publish->title.\" Global Research and Development Journal For Engineering  {$publish->article->voliss->volume}.{$publish->article->voliss->issue} " . date('Y', strtotime($publish->article->voliss->last_date)) . ": $publish->start_page" . " - " . "$publish->end_page.") . '
          </span>
          |
          <a class="cart_quantity_delete" target="_blank" href="' . DOCURL . "uploads/article/" . $publish->pdf . '">
          Download
          </a>
          </div>';


          }
          ],
          [
          'header' => 'Area',
          'attribute' => 'article.research_area'
          ],
          [
          'header' => 'Country',
          'attribute' => 'article.country'
          ],
          [
          'header' => 'Page',
          'content' => function ($publish) {
          return $publish->start_page . " - " . $publish->end_page;
          }
          ]
          ],
          ]); */
   // }
    ?>

</div><!--features_items-->
<div class="modal fade" id="citation-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Citation</h4>
            </div>
            <div class="modal-body copy-div"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-copy" data-clipboard-action="copy" data-clipboard-target=".copy-div">Copy</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("$('.citation-link').click(function(){
        var html = $(this).next().text();
        $('#citation-modal .modal-body').html(html);
        $('#citation-modal').modal('show');
        var clipboard = new Clipboard('.btn-copy');
    });", View::POS_READY);
?>
