<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EmailRequest;

/**
 * EmailRequestSearch represents the model behind the search form about `backend\models\EmailRequest`.
 */
class EmailRequestSearch extends EmailRequest
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'message_id', 'id_from', 'id_to', 'id_ended', 'list_id', 'created_by', 'send_status', 'is_deleted'], 'integer'],
            [['send_to_ids', 'send_time', 'created_dt', 'search'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EmailRequest::find();
        $query->joinWith(['message'=>function($query){$query->select(['id','subject']);}]);
        $query->from('email_request e');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 
                           'defaultOrder' => ['id'=>SORT_DESC],
                           'attributes'   => [ 
                               'id'
                           ], 
                       ],
            'pagination'=>[
                'pageSize'=> Yii::$app->params['defaultPageSize'],
            ],           
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'e.id' => $this->id,
            'e.message_id' => $this->message_id,
            'e.e.id_from' => $this->id_from,
            'e.id_to' => $this->id_to,
            'e.id_ended' => $this->id_ended,
            'e.list_id' => $this->list_id,
            'e.send_time' => $this->send_time,
            'e.created_dt' => $this->created_dt,
            'e.created_by' => $this->created_by,
            'e.send_status' => $this->send_status,
            'e.is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'send_to_ids', $this->send_to_ids]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'e.send_to_ids', $this->search],
            ['like', 'email_master.subject', $this->search],
        ]);

        return $dataProvider;
    }
}
