<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EmailMaster;

/**
 * EmailMasterSearch represents the model behind the search form about `backend\models\EmailMaster`.
 */
class EmailMasterSearch extends EmailMaster
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['from_name', 'from_email', 'reply_to', 'subject', 'content', 'created_dt', 'updated_dt', 'search'], 'safe'],
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
        $query = EmailMaster::find();

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
            'id' => $this->id,
            'created_by' => $this->created_by,
            'created_dt' => $this->created_dt,
            'updated_by' => $this->updated_by,
            'updated_dt' => $this->updated_dt,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'from_name', $this->from_name])
            ->andFilterWhere(['like', 'from_email', $this->from_email])
            ->andFilterWhere(['like', 'reply_to', $this->reply_to])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'from_name', $this->search],
            ['like', 'from_email', $this->search],
            ['like', 'reply_to', $this->search],
            ['like', 'subject', $this->search],
            ['like', 'content', $this->search],
        ]);

        return $dataProvider;
    }
}
