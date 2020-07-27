<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "purchase_items".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $insta_pay_id
 * @property string $item_code
 * @property string $item_price
 * @property string $item_desc
 */
class PurchaseItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'insta_pay_id', 'item_code', 'item_price', 'item_desc'], 'required'],
            [['article_id', 'insta_pay_id'], 'integer'],
            [['item_price'], 'number'],
            [['item_code'], 'string', 'max' => 50],
            [['item_desc'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'insta_pay_id' => 'Insta Pay ID',
            'item_code' => 'Item Code',
            'item_price' => 'Item Price',
            'item_desc' => 'Item Desc',
        ];
    }
    /*public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::datetimeTimestamp();
            $this->updated_by = Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = Common::datetimeTimestamp();
                $this->created_by = Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }*/
}
