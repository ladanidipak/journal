<link href="<?php echo Yii::$app->params['designElementUrl']; ?>css/plugins/jsTree/style.min.css" rel="stylesheet">
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/inspinia.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/pace/pace.min.js"></script>
<script src="<?php echo Yii::$app->params['designElementUrl']; ?>js/plugins/jsTree/jstree.min.js"></script>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\vendors\Common;
use app\models\MenuMaster;
use app\models\RoleMaster;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo common::getTitle("rolemaster/permissions"); ?> (<?php echo trim($RoleMaster->role_title); ?>)</h5>            
            </div>
            <div class="ibox-content">                 
                <?php $form = ActiveForm::begin(); ?>                                
                <div class="row" id="jstree1">
                    <?php echo RoleMaster::printMenuTree($menusArr, $permissionsArr); ?>                                        
                </div>                                      
                <div class="row">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group col-sm-12">
                        <input type="hidden" name="hdn_menu_ids" id="hdn_menu_ids" value="<?php echo implode(",", $permissionsArr); ?>" />
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
                    "check_while_dragging":true
            },
            'checkbox':{
                "undetermined" : true
            },
            'plugins' : [ 'massload','types','dnd','checkbox' ],
            'types': {
                'default': {
                    'icon': 'fa fa-folder'
                }
            }
        });  
        /*$('#jstree1').on('ready.jstree',function(e,data){
            data.instance.close_all();
        });*/
    });
    
    function submitMe() {
        var result = $('#jstree1').jstree('get_selected');
        
        //Permission Array
        $("#hdn_menu_ids").val("");
        var checked_ids = [];
        $("#jstree1").find(".jstree-undetermined").each(function (i, element) {
            checked_ids.push($(element).closest('.jstree-node').attr("id"));
        });
        $("#hdn_menu_ids").val($.merge(checked_ids, result));
        
        //Sorting Array
        var sort_ids = [];
        $('#jstree1 li').each(function(i,v){
          sort_ids.push($(v).attr('id'));
        });
        $("#hdn_sort_ids").val(sort_ids);
        
    }
</script>    