<?php

namespace app\controllers;

use backend\models\PritMailer;
use backend\models\search\ArticleSearch;
use Yii;
use backend\models\Hardcopy;
use backend\models\search\HardcopySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * HardcopyController implements the CRUD actions for Hardcopy model.
 */
class HardcopyController extends BaseController
{
    
    /**
     * Lists all Hardcopy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $searchModel->is_deleted= 0;
        $searchModel->hardcopy= 1;
        $searchModel->notStatus = 6;
        $dataProvider = $searchModel->hardcopySearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDispatch($id){
        $hardcopy = Hardcopy::findOne(['article_id'=>$id]);
        if(!$hardcopy){
            $hardcopy = new Hardcopy();
            $hardcopy->article_id = $id;
        } else {
            $hardcopy->dispatched_date = date('d/m/Y',strtotime($hardcopy->dispatched_date));
        }

        if($hardcopy->load(Yii::$app->request->post())){
            $hardcopy->dispatched_date = Common::dmyToYmd($hardcopy->dispatched_date);
            if($hardcopy->save()){
                Yii::$app->session->setFlash('success', common::translateText("ADD_SUCCESS"));
                return $this->redirectReferer(['index'],-2);
            }
        }

        return $this->render('dispatch',['model'=>$hardcopy]);
    }

    public function actionSendemail($id){
        $hardcopy = $this->findModel($id);
        $hardcopy->detail_sent = 1;
        $article = $hardcopy->article;
        $message = PritMailer::dispatchEmail(['hardcopy'=>$hardcopy, 'article'=>$article]);
        if($message && $hardcopy->update()){
            Yii::$app->session->setFlash('success', 'Dispatch Detail send successfully.');
        }else{
            Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
        }
        return $this->redirectReferer(['index'],-1);
    }

    /**
     * Displays a single Hardcopy model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the Hardcopy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hardcopy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hardcopy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function redirectReferer($data,$level){
        return "<script>history.go($level);</script>";
    }
}
