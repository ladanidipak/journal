<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VolIss;

/**
 * VolIssSearch represents the model behind the search form about `backend\models\VolIss`.
 */
class VolIssSearch extends VolIss
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'volume', 'issue', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['detail', 'last_date', 'publish_date', 'created_dt', 'updated_dt', 'search'], 'safe'],
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
        $query = VolIss::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 
                           'defaultOrder' => ['id'=>SORT_ASC], 
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
            'volume' => $this->volume,
            'issue' => $this->issue,
            'last_date' => $this->last_date,
            'publish_date' => $this->publish_date,
            'created_by' => $this->created_by,
            'created_dt' => $this->created_dt,
            'updated_by' => $this->updated_by,
            'updated_dt' => $this->updated_dt,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'detail', $this->detail]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'detail', $this->search],
        ]);

        return $dataProvider;
    }
}
