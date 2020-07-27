<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Hardcopy;

/**
 * HardcopySearch represents the model behind the search form about `backend\models\Hardcopy`.
 */
class HardcopySearch extends Hardcopy
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'article_id', 'detail_sent', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['dispatched_date', 'dispatched_by', 'courier_name', 'tracking_no', 'tracking_url', 'created_dt', 'updated_dt', 'search'], 'safe'],
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
        $query = Hardcopy::find();

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
            'article_id' => $this->article_id,
            'dispatched_date' => $this->dispatched_date,
            'dispatched_by' => $this->dispatched_by,
            'detail_sent' => $this->detail_sent,
            'created_dt' => $this->created_dt,
            'created_by' => $this->created_by,
            'updated_dt' => $this->updated_dt,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'courier_name', $this->courier_name])
            ->andFilterWhere(['like', 'tracking_no', $this->tracking_no])
            ->andFilterWhere(['like', 'tracking_url', $this->tracking_url]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'courier_name', $this->search],
            ['like', 'tracking_no', $this->search],
            ['like', 'tracking_url', $this->search],
        ]);

        return $dataProvider;
    }
}
