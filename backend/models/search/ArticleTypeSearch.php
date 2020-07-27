<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ArticleType;

/**
 * ArticleTypeSearch represents the model behind the search form about `backend\models\ArticleType`.
 */
class ArticleTypeSearch extends ArticleType
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'status', 'is_deleted', 'created_dt', 'created_by', 'updated_dt', 'updated_by'], 'integer'],
            [['name', 'search'], 'safe'],
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
        $query = ArticleType::find();

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
            'status' => $this->status,
            'is_deleted' => $this->is_deleted,
            'created_dt' => $this->created_dt,
            'created_by' => $this->created_by,
            'updated_dt' => $this->updated_dt,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'name', $this->search],
        ]);

        return $dataProvider;
    }
}
