<?php

namespace backend\models;

use Yii;
use backend\vendors\Common;
use yii\base\Exception;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $list_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email_id
 * @property integer $created_by
 * @property string $created_dt
 * @property integer $updated_by
 * @property string $updated_dt
 * @property integer $is_deleted
 * @property integer $unsubscribed
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $list_input;
    public $list_drop;
    public $csv;
    public $zero = 0;
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['list_id', 'first_name', 'last_name', 'email_id'], 'required'],
            [['list_id', 'created_by', 'updated_by', 'is_deleted','unsubscribed'], 'integer'],
            [['created_dt', 'updated_dt'], 'safe'],
            ['email_id', 'unique', 'targetAttribute' => ['zero'=>'is_deleted','email_id'=>'email_id','list_id'=>'list_id']],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['email_id','list_input'], 'string', 'max' => 255],
            [['list_drop'],'required','on'=>['import']],
            [['list_input'], 'required', 'when' => function ($model) {return $model->list_drop == 'other';}, 'whenClient' => "function (attribute, value) {return $('#contact-list_drop').val() == 'Other';}", 'on' => ['import']],
            [['csv'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv', 'maxSize' => 1024 * 1024 * 5, 'on' => ['import']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_id' => 'List',
            'list_drop' => 'List',
            'list_input' => 'New List Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email_id' => 'Email ID',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
            'is_deleted' => 'Is Deleted',
            'csv' => 'CSV File',
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
            if($insert){
                $this->created_dt = date('Y-m-d H:i:s');
                $this->created_by = Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public function csv_to_array($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 15000, $delimiter)) !== FALSE)
            {
                if(!$header){
                    $header = array('first_name','last_name','email_id');
                }
                if(count($header) !== count($row)) {
                        continue;
                }
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }

    public function getType(){
        return $this->hasOne(ContactList::className(),['id'=>'list_id']);
    }

    public function import($id, $path)
    {
        set_time_limit(0);
        $rawData = $this->csv_to_array($path);
        if($rawData === FALSE){
            Yii::$app->session->setFlash('error', 'Uploaded CSV is not valid. Please refer demo csv.');
            return FALSE;
        }
        $i  = 1;
        $count = 0;
        try {
            foreach ($rawData as $key => $value) {
                foreach ($value as $k => $v){
                    $value[$k]=trim($v);
                }
                $contact = new Contact();
                $contact->list_id = $id;
                $contact->first_name = $value['first_name'];
                $contact->last_name = $value['last_name'];
                $contact->email_id = $value['email_id'];
                if($contact->save()){
                    $count++;
                }
            }
        } catch (Exception $exc) {
            Yii::$app->session->setFlash('error', $exc->getTraceAsString());
        }
        return $count;
    }
}
