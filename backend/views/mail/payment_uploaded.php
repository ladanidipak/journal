<?php

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

$article = $model;
?>
<h2>Hello Admin</h2>
<p>
    A new payment and copyright have been uploaded. <?= date('d/m/Y')?><br><br>
    Details:<br>
    Manuscript Id : <?= $article->paper_id ?><br>
    Name : <?= $article->author_name ?><br>
    Email : <?= $article->a_email ?><br>
    Title : <?= $article->article_title ?>
</p>


