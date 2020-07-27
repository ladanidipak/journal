<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "vol_iss".
 *
 * @property integer $id
 * @property integer $volume
 * @property integer $issue
 * @property string $detail
 * @property string $last_date
 * @property string $publish_date
 * @property integer $created_by
 * @property string $created_dt
 * @property integer $updated_by
 * @property string $updated_dt
 * @property integer $is_deleted
 */
class VolIss extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vol_iss';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['volume', 'issue', 'detail', 'last_date', 'publish_date'], 'required'],
            [['volume', 'articles','issue', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['last_date', 'publish_date', 'created_dt', 'updated_dt'], 'safe'],
            [['detail'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'volume' => 'Volume',
            'issue' => 'Issue',
            'detail' => 'Detail',
            'articles' => 'No. of Articles',
            'last_date' => 'Paper Last Date',
            'publish_date' => 'Paper Publish Date',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::datetimeTimestamp();
            $this->updated_by = (Yii::$app->user->isGuest)?0:Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = Common::datetimeTimestamp();
                $this->created_by = (Yii::$app->user->isGuest)?0:Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }
    
    public static function createCurrentIssue($currentIssue){
        $newIssue = new VolIss();
        if($currentIssue){
            if($currentIssue->issue == '12'){
                $newIssue->volume = $currentIssue->volume + 1;
                $newIssue->issue = 1;
            }else{
                $newIssue->volume = $currentIssue->volume;
                $newIssue->issue = $currentIssue->issue + 1;
            }
        }else{
            $newIssue->volume = 1;
            $newIssue->issue = 1;
        }
        if(date('d') > 25){
            $newIssue->last_date = date('Y-m', strtotime("+1 month"))."-25";
            $newIssue->publish_date = date('Y-m', strtotime("+2 month"))."-1";
            $newIssue->detail = date('F Y', strtotime("+1 month"));
        }else{
            $newIssue->last_date = date('Y-m')."-25";
            $newIssue->publish_date = date('Y-m', strtotime("+1 month"))."-1";
            $newIssue->detail = date('F Y');
        }


        $newIssue->articles = 0;
        
        if($newIssue->save()){
            return $newIssue;
        }else{
            ob_clean();
            echo "<pre>" . print_r($newIssue->getErrors(), true);
            exit;
        }
            
        
    }
    
    public static function findCurrentIssue(){
        $currentIssue = self::find()->where(['is_deleted'=>0])->orderBy('id DESC')->one();
        if($currentIssue && $currentIssue->last_date >= date('Y-m-d')){
            return $currentIssue;
        }else{
            return self::createCurrentIssue($currentIssue);
        }
        
    }
    
    public static function udpateArticle($model){
        $counter = $model->articles;
        $success = 0;
        while($success == 0){
            $counter = $counter + 1;
            $success = VolIss::updateAll(['articles'=>$counter],"articles < {$counter}");
        }
        return $counter;
    }


    public static function getList(){
        $voliss = VolIss::find()->where(['is_deleted'=>0])->orderBy('id desc')->all();
        return ArrayHelper::map($voliss,'id',function($data){return "Vol-{$data->volume} Iss-{$data->issue} ({$data->detail})";});
    }
}
