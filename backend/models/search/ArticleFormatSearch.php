<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ArticleFormat;

/**
 * ArticleFormatSearch represents the model behind the search form about `backend\models\ArticleFormat`.
 */
class ArticleFormatSearch extends ArticleFormat
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'article_id', 'formatter_id', 'created_by', 'is_deleted'], 'integer'],
            [['formatted_file', 'formatted_date', 'created_dt', 'search'], 'safe'],
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
        $query = ArticleFormat::find();

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
            'formatter_id' => $this->formatter_id,
            'formatted_date' => $this->formatted_date,
            'created_dt' => $this->created_dt,
            'created_by' => $this->created_by,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'formatted_file', $this->formatted_file]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'formatted_file', $this->search],
        ]);

        return $dataProvider;
    }
}
