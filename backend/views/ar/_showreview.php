<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= backend\vendors\Common::translateText('CLOSE_BTN_TEXT') ?></span></button>
    <h4 class="modal-title">Reviewed By : <?= $article->reviewer->full_name ?></h4>
</div>
<div class="modal-body">
    <div class="row review-popup">

        <?php $reviewArray = \yii\helpers\Json::decode($article->article_review); ?>
        <table class='table-responsive table-bordered col-sm-12'>
            <thead>
            <tr>
                <th>Topics</th>
                <th>Review</th>
            </tr>
            </thead>
            <tbody>
            <?php if($reviewArray):
				
                $comment = $reviewArray['comment'];
                $editor_comment = isset($reviewArray['editor_comment'])?$reviewArray['editor_comment']:"";
                if(isset($reviewArray['que_1'])){
                    $reviews = $reviewArray['que_1'];
                }else{
                    $reviews = $reviewArray;
                    unset($reviews['comment']);
                    unset($reviews['editor_comment']);
                }
                foreach($reviews as $key=>$value): ?>
                    <tr>
                        <td><?= $key?></td>
                        <td><?= $value?></td>
                    </tr>
                <?php endforeach;endif;?>
            <?php if($reviewArray && isset($reviewArray['que_2'])):
                foreach($reviewArray['que_2'] as $key=>$value): ?>
                    <tr>
                        <td><?= $key?></td>
                        <td><?= $value?></td>
                    </tr>
                <?php endforeach;endif;?>
            <tr>
                <td colspan="2">
                    <p><b>Reviewer Comment</b></p>
                    <pre><?=$comment?></pre>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p><b>Editor's Comment</b></p>
                    <pre><?=$editor_comment?></pre>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="col-md-12">&nbsp;</div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
</div>
