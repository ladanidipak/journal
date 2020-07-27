<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use \backend\models\Cms;
use backend\models\search\PublishedSearch;
use Yii;

class HeaderWidget extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
    	$content = Cms::getContent('Searchmanuscript');
      //  $this->siteTitle = $content->page_title;

        $searchModel = new PublishedSearch();
        $searchModel->is_deleted= 0;
        $searchModel->status= 1;

        $dataProvider = $searchModel->frontsearch(Yii::$app->request->queryParams);

        return $this->render('header', ['content' => $content, 'dataProvider'=>$dataProvider, 'searchModel'=>$searchModel]);
    }

}

?>
