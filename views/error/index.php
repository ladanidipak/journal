<h1><?php echo $statusCode;?></h1>
<h3 class="font-bold">Invalid Request</h3>
<div class="error-desc">     
    <?= $message?>
    <br /><br />
    <a class="btn btn-primary" href="<?php echo Yii::$app->request->baseUrl; ?>/">Back</a>
</div>