<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $iso
 * @property string $iso3
 * @property string $fips
 * @property string $country_name
 * @property integer $region_id
 * @property string $currency_code
 * @property string $currency_name
 * @property string $phone_prefix
 * @property string $postal_code
 * @property string $languages
 * @property string $geonameid
 * @property string $ip_address
 * @property integer $status
 * @property integer $is_deleted
 * @property integer $created_date
 * @property integer $created_by
 * @property integer $updated_date
 * @property integer $updated_by
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'status', 'is_deleted', 'created_date', 'created_by', 'updated_date', 'updated_by'], 'integer'],
            [['ip_address'], 'required'],
            [['iso', 'iso3', 'fips', 'country_name', 'currency_code', 'currency_name', 'phone_prefix', 'postal_code', 'languages', 'geonameid'], 'string', 'max' => 45],
            [['ip_address'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iso' => 'Iso',
            'iso3' => 'Iso3',
            'fips' => 'Fips',
            'country_name' => 'Country Name',
            'region_id' => 'Region ID',
            'currency_code' => 'Currency Code',
            'currency_name' => 'Currency Name',
            'phone_prefix' => 'Phone Prefix',
            'postal_code' => 'Postal Code',
            'languages' => 'Languages',
            'geonameid' => 'Geonameid',
            'ip_address' => 'Ip Address',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
        ];
    }
    public function beforeSave($insert) {
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
    }
    
    public static function getCountries($id=NULL,$withoutId=TRUE){
        $arr = ($id != NULL)?['is_deleted'=>0, 'status'=>1, 'region_id'=>$id]:['is_deleted'=>0, 'status'=>1];
        if($withoutId){
            return \yii\helpers\ArrayHelper::map(self::find()->where($arr)->all(), 'country_name', 'country_name');
        }else{
            return \yii\helpers\ArrayHelper::map(self::find()->where($arr)->all(), 'id', 'country_name');
        }
    }
}
