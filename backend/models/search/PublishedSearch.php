<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Published;

/**
 * PublishedSearch represents the model behind the search form about `backend\models\Published`.
 */
class PublishedSearch extends Published
{
    /**
     * @inheritdoc
     */
    public $search;
    public $v_voliss_id;
    public $v_conf_id;
    public $branch_id;
    public function rules()
    {
        return [
            [['id', 'article_id', 'start_page', 'end_page', 'status', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['title', 'authors', 'country', 'abstract', 'keywords', 'pub_date', 'pdf', 'created_dt', 'updated_dt', 'search', 'v_voliss_id', 'v_conf_id', 'branch_id'], 'safe'],
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
        $query = Published::find();
        $query->joinWith(['article', 'article.branch']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['published.id' => SORT_DESC],
                'attributes'   => [
                    'published.id'
                ],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSize'],
            ],
        ]);

        $this->load($params);

        if (!empty($this->branch_id)) {
            $query->andFilterWhere(['article.branch_id' => $this->branch_id]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'published.id' => $this->id,
            'article.voliss_id' => $this->v_voliss_id,
            'article.conf_id' => $this->v_conf_id,
            'published.article_id' => $this->article_id,
            'published.start_page' => $this->start_page,
            'published.end_page' => $this->end_page,
            'published.pub_date' => $this->pub_date,
            'published.status' => $this->status,
            'published.created_dt' => $this->created_dt,
            'published.created_by' => $this->created_by,
            'published.updated_dt' => $this->updated_dt,
            'published.updated_by' => $this->updated_by,
            'published.is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'published.title', $this->title])
            ->andFilterWhere(['like', 'published.authors', $this->authors])
            ->andFilterWhere(['like', 'published.country', $this->country])
            ->andFilterWhere(['like', 'published.abstract', $this->abstract])
            ->andFilterWhere(['like', 'published.keywords', $this->keywords])
            ->andFilterWhere(['like', 'published.pdf', $this->pdf]);


        #Generalized Search 
        $query->andFilterWhere([
            'or',
            ['like', 'published.title', $this->search],
            ['like', 'published.paper_id', $this->search],
            ['like', 'published.authors', $this->search],
            ['like', 'published.country', $this->search],
            ['like', 'published.abstract', $this->search],
            ['like', 'published.keywords', $this->search],
            ['like', 'published.pdf', $this->search],
        ]);

        return $dataProvider;
    }

    public function frontsearch($params)
    {
        $query = Published::find();
        $query->joinWith(['article' => function ($query) {
            return $query->joinWith('voliss');
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes'   => [
                    'id'
                ],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSize'],
            ],
        ]);

        $this->load($params);

        if (!$this->search) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'published.status' => $this->status,
            'published.is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere([
            'or',
            ['like', 'published.paper_id', $this->search],
            ['like', 'published.title', $this->search],
            ['like', 'published.authors', $this->search],
            ['like', 'article.a_email', $this->search],
            ['like', 'article.research_area', $this->search],
            ['like', 'published.keywords', $this->search],
        ]);

        return $dataProvider;
    }
}
