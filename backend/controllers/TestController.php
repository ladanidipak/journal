<?php

namespace app\controllers;

use backend\models\Article;
use Yii;
use backend\models\ArticleFormat;
use backend\models\search\ArticleFormatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;

/**
 * AfController implements the CRUD actions for ArticleFormat model.
 */
class TestController extends BaseController {

    /**
     * Lists all ArticleFormat models.
     * @return mixed
     */
    public function actionIndex() {
        
    }

    public function actionRemove_rejected_ar_files($id) {
        error_reporting(E_ERROR);
        $searchModel = new \backend\models\search\ArticleSearch();
        $searchModel->is_deleted = 0;
        $searchModel->conf_id = 0;
        $searchModel->status = 6;
        $searchModel->voliss_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fileDir = "article";
        error_reporting(E_ALL);
        foreach ($dataProvider->getModels() as $model) {
            $arpath = DOCPATH . "/uploads/$fileDir/" . $model->article_file;
            $reviewer_copy = DOCPATH . "/uploads/$fileDir/" . $model->reviewer_copy;
            $formatted_file = DOCPATH . "/uploads/$fileDir/" . $model->formatted_file;
            if (file_exists($arpath) && is_file($arpath)) {
                echo "<pre>" . print_r('Article=='.$arpath, true);
                //unlink($arpath);
            }
            if (file_exists($reviewer_copy) && is_file($formatted_file)) {
                echo "<pre>" . print_r('reviewer_copy ==' . $reviewer_copy, true);
                //unlink($reviewer_copy);
            }
            if (file_exists($formatted_file) && is_file($formatted_file)) {
                echo "<pre>" . print_r('formatted_file ==' . $formatted_file, true);
               //unlink($formatted_file);
            }
        }
      echo "<pre>" . print_r('No File Found in '.$searchModel->voliss_id, true);
        exit;
    }

    protected function findModel($id) {
        if (($model = ArticleFormat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
