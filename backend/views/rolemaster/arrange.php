<link href="<?php echo Yii::$app->params['designElementUrl']; ?>css/plugins/jsTree/style.min.css" rel="stylesheet">
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/inspinia.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/pace/pace.min.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/jsTree/jstree.min.js"></script>
<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\vendors\Common;
use app\models\RoleMaster;

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Arrange Menu</h5>
            </div>
            <div class="ibox-content">                 
                <?php $form = ActiveForm::begin(); ?>                                
                <div class="row" id="jstree1">
                    <?php echo RoleMaster::printMenuTree($menusArr); ?>
                </div>                                      
                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <input type="hidden" name="hdn_sort_ids" id="hdn_sort_ids" value="" />
                        <a class="btn btn-white pull-right" onclick="location.href = '<?= Url::to(['index']) ?>'"><?= common::translateText("CANCEL_BTN_TEXT") ?></a>
                        <button onclick="return submitMe();" class="btn btn-primary pull-right" type="submit"><?php echo common::translateText("UPDATE_BTN_TEXT"); ?></button>
                    </div>
                </div>                
                <?php ActiveForm::end(); ?>     
            </div>
        </div>
    </div>  
</div>
<style>
    .jstree-open > .jstree-anchor > .fa-folder:before {
        content: "\f07c";
    }
    .jstree-default .jstree-icon.none {
        width: 0;
    }
</style>

<script>
    $(document).ready(function () {
        $('#jstree1').jstree({
            "core" : {
              "check_callback" : function (operation, node, node_parent, node_position, more) {
                    // operation can be 'create_node', 'rename_node', 'delete_node', 'move_node' or 'copy_node'
                    // in case of 'rename_node' node_position is filled with the new node name
                    if(operation == "move_node"){
                        if(node.parent != node_parent.id){
                            return false;
                        }
                        return true;
                    }
                }
            },
            "dnd" : {
                    "check_while_dragging":true,
            },

            'plugins' : [ 'massload','types','dnd'],
            'types': {
                'default': {
                    'icon': 'fa fa-folder'
                }
            }
        });
    });
    
    function submitMe() {
        var result = $('#jstree1').jstree('get_selected');

        //Sorting Array
        var sort_ids = [];
        $('#jstree1 li').each(function(i,v){
          sort_ids.push($(v).attr('id'));
        });
        $("#hdn_sort_ids").val(sort_ids);
        
    }
</script>    
