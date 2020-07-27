<?php

namespace app\controllers;

use Yii;
use app\models\RoleMaster;
use app\models\MenuMaster;
use app\models\GroupRights;
use app\models\search\RoleMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\components\BaseController;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use yii\helpers\ArrayHelper;

/**
 * RolemasterController implements the CRUD actions for RoleMaster model.
 */
class RolemasterController extends BaseController {

    /**
     * Lists all RoleMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RoleMasterSearch();
        $searchModel->is_deleted= 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RoleMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new RoleMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RoleMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', common::translateText("UPDATE_SUCCESS"));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RoleMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the RoleMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RoleMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RoleMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPermissions($id) {
        
        if ($id == RoleMaster::SUPER_ADMIN) {
            Yii::$app->session->setFlash('danger', common::translateText("CAUTION_MSG"));
            return $this->redirect(["index"]);
        }

        //TREE FOR MENU
        $model = MenuMaster::find()->orderBy("sort_order ASC")->all();
        $arr = array();
        if (!empty($model)) : foreach ($model as $value):                
                $arr[] = array(
                    "id" => $value->id,
                    "parent_id" => $value->parent_id,
                    "menu_title" => $value->menu_title,
                    "menu_icon" => $value->menu_icon,
                    "url" => $value->page_url
                );
            endforeach;
        endif;        
        $menusArr = MenuMaster::buildMenuTree($arr);
        //TREE FOR MENU
        
        //CURRENT RIGHTS FOR PASSED USER GROUP        
        $modelRights = GroupRights::findAll(["group_id" => $id]);
        $permissionsArr = array();
        if (!empty($modelRights)):
            foreach ($modelRights as $value):
                $permissionsArr[] = $value->menu_id;
            endforeach;
        endif;
        //CURRENT RIGHTS FOR PASSED USER GROUP

        if (Yii::$app->request->post()) {
            
            $GroupRights = explode(",", $_POST["hdn_menu_ids"]);
            $sortMenus = explode(",", $_POST["hdn_sort_ids"]);
            
            //Group Rights
            GroupRights::deleteAll(["group_id" => $id]);
            if (!empty($GroupRights)) {
                foreach ($GroupRights as $menu_id){
                    if (!empty($menu_id)){
                        $saveModel = new GroupRights();
                        $saveModel->menu_id = $menu_id;
                        $saveModel->group_id = $id;
                        $saveModel->save(false);
                    }
                }
                Yii::$app->session->setFlash("success", common::translateText("UPDATE_SUCCESS"));
            }
            
            //Sortings
            if($sortMenus){
                foreach ($sortMenus as $skey=>$sval){
                    $menu = MenuMaster::findOne(['id'=>$sval]);
                    $menu->sort_order = $skey;
                    $menu->update();
                }
                Yii::$app->session->setFlash("success", common::translateText("UPDATE_SUCCESS"));
            }
            return $this->redirect(["index", "id" => $id]);
        }
        return $this->render('permissions', ["menusArr" => $menusArr, "RoleMaster" => $this->findModel($id), "permissionsArr" => $permissionsArr]);
    }
    
    public function actionArrange(){

        //TREE FOR MENU
        $model = MenuMaster::find()->where(['show_in_menu'=>1,'is_deleted'=>0])->orderBy("sort_order ASC")->all();
        $arr = array();
        if (!empty($model)) : foreach ($model as $value):
            $arr[] = array(
                "id" => $value->id,
                "parent_id" => $value->parent_id,
                "menu_title" => $value->menu_title,
                "menu_icon" => $value->menu_icon,
                "url" => $value->page_url
            );
        endforeach;
        endif;
        $menusArr = MenuMaster::buildMenuTree($arr);
        //TREE FOR MENU

        if (Yii::$app->request->post()) {

            $sortMenus = explode(",", $_POST["hdn_sort_ids"]);
            if($sortMenus){
                foreach ($sortMenus as $skey=>$sval){
                    $menu = MenuMaster::findOne(['id'=>$sval]);
                    $menu->sort_order = $skey;
                    $menu->update();
                }
                Yii::$app->session->setFlash("success", common::translateText("UPDATE_SUCCESS"));
            }
            return $this->redirect(["index"]);
        }
        return $this->render('arrange', ["menusArr" => $menusArr]);
    }

}
