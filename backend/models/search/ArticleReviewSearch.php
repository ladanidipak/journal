<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ArticleReview;

/**
 * ArticleReviewSearch represents the model behind the search form about `backend\models\ArticleReview`.
 */
class ArticleReviewSearch extends ArticleReview
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'article_id', 'reviewer_id', 'created_by', 'is_deleted'], 'integer'],
            [['article_review', 'reviewed_date', 'created_dt', 'search'], 'safe'],
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
        $query = ArticleReview::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 
                           'defaultOrder' => ['id'=>SORT_ASC], 
                           'attributes'   => [ 
                               'id' 
                           ], 
                       ],
            'pagination'=>false,
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
            'reviewer_id' => $this->reviewer_id,
            'reviewed_date' => $this->reviewed_date,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'article_review', $this->article_review]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'article_review', $this->search],
        ]);

        return $dataProvider;
    }
}
