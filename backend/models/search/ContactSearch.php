<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Contact;

/**
 * ContactSearch represents the model behind the search form about `backend\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'list_id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['first_name', 'last_name', 'email_id', 'created_dt', 'updated_dt', 'search'], 'safe'],
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
        $query = Contact::find();

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
            'list_id' => $this->list_id,
            'created_by' => $this->created_by,
            'created_dt' => $this->created_dt,
            'updated_by' => $this->updated_by,
            'updated_dt' => $this->updated_dt,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email_id', $this->email_id]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'first_name', $this->search],
            ['like', 'last_name', $this->search],
            ['like', 'email_id', $this->search],
        ]);

        return $dataProvider;
    }
}
