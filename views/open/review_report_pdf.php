<?php $reviewArray = \yii\helpers\Json::decode($article->article_review); ?>
<hr>
<br>
<br>

<table cellspacing="0" cellpadding="5" width="100%" style="text-align: left;">
    <tr>
        <td width="100"><b>Manuscript ID : </b></td>
        <td><?= $article->paper_id; ?></td>
    </tr>
    <tr>
        <td width="100"><b>Article Title : </b></td>
        <td><?= $article->article_title; ?></td>
    </tr>
    <tr>
        <td width="100"><b>Author Name : </b></td>
        <td><?= $article->author_name; ?></td>
    </tr>
</table>
<br>
<br>
<table cellspacing="0" cellpadding="5" border="1" style="font-size: 12px">
    <thead>
    <tr style="background-color: #000000; color: #ffffff;text-align: center">
        <th width="500"><b>Topics</b></th>
        <th width="100"><b>Review</b></th>
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
                <td width="500"><?= $key?></td>
                <td width="100"><?= $value?></td>
            </tr>
        <?php endforeach;endif;?>
    <tr>
        <td colspan="2">
            <b>Reviewer Comment: </b>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p><?= nl2br($comment)?></p>
        </td>
    </tr>
    <?php if($editor_comment):?>
    <tr>
        <td colspan="2">
            <b>Editor's Comment: </b>
        </td>
    </tr>
        <tr>
            <td colspan="2">
                <p><?= nl2br($editor_comment)?></p>
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<br>
<br>

<p style="font-size: 12px;font-style: italic">Note: This is an automatic generated review report based on Reviewer’s and Editor’s inputs. In case of any queries please let us know at <a href="mailto:info@grdjournals.com">info@grdjournals.com</a>.</p>