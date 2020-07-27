<?php use backend\vendors\Common;; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo common::getTitle("menumaster/update");?></h5>
            </div>
            <div class="ibox-content"> 
                <?php echo $this->render("_form",["model"=>$model]); ?>
            </div>
        </div>
    </div>
</div>
