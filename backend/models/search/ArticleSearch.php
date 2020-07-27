<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `backend\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
     public $search;
    public $notStatus;
    public function rules()
    {
        return [
            [['!conf_id','notStatus','id', 'paper_id', 'a_type_id', 'branch_id', 'status', 'created_by', 'updated_by', 'is_deleted','voliss_id'], 'integer'],
            ['conf_id','safe','on'=>'admin'],
            ['article_title','safe','on'=>'conference'],
            [['article_title', 'research_area', 'branch_name', 'keyword', 'abstract', 'author_name', 'a_org', 'a_email', 'a_phone', 'addr_1', 'addr_2', 'city', 'zip', 'state', 'country', 'article_file', 'created_dt', 'updated_dt', 'search'], 'safe'],
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
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 
                           'defaultOrder' => ['id'=>SORT_DESC], 
                           'attributes'   => [ 
                               'id' 
                           ], 
                       ],
            'pagination'=>[
                'pageSize'=> isset($_SESSION['pagesize'])?($_SESSION['pagesize'][Yii::$app->controller->id]):(Yii::$app->params['defaultPageSize']),
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
            'paper_id' => $this->paper_id,
            'conf_id' => $this->conf_id,
            'voliss_id' => $this->voliss_id,
            'a_type_id' => $this->a_type_id,
            'branch_id' => $this->branch_id,
            'status' => $this->status,
            'created_dt' => $this->created_dt,
            'created_by' => $this->created_by,
            'updated_dt' => $this->updated_dt,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'is_submitted' => $this->is_submitted,
        ]);

        $query->andFilterWhere(['NOT IN','status',$this->notStatus]);

        $query->andFilterWhere(['like', 'article_title', $this->article_title])
            ->andFilterWhere(['like', 'research_area', $this->research_area])
            ->andFilterWhere(['like', 'branch_name', $this->branch_name])
            ->andFilterWhere(['like', 'keyword', $this->keyword])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'a_org', $this->a_org])
            ->andFilterWhere(['like', 'a_email', $this->a_email])
            ->andFilterWhere(['like', 'a_phone', $this->a_phone])
            ->andFilterWhere(['like', 'addr_1', $this->addr_1])
            ->andFilterWhere(['like', 'addr_2', $this->addr_2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'article_file', $this->article_file]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'article_title', $this->search],
            ['like', 'paper_id', $this->search],
            ['like', 'research_area', $this->search],
            ['like', 'branch_name', $this->search],
            ['like', 'keyword', $this->search],
            ['like', 'abstract', $this->search],
            ['like', 'author_name', $this->search],
            ['like', 'a_org', $this->search],
            ['like', 'a_email', $this->search],
            ['like', 'a_phone', $this->search],
            ['like', 'addr_1', $this->search],
            ['like', 'addr_2', $this->search],
            ['like', 'city', $this->search],
            ['like', 'zip', $this->search],
            ['like', 'state', $this->search],
            ['like', 'country', $this->search],
            ['like', 'article_file', $this->search],
        ]);

        return $dataProvider;
    }

    public function hardcopySearch($params)
    {
        $query = Article::find();
        $query->joinWith(['hardcopyRel']);

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
            'article.id' => $this->id,
            'article.hardcopy' => $this->hardcopy,
            'article.is_deleted' => $this->is_deleted,
        ]);
        $query->andFilterWhere(['NOT IN','article.status',$this->notStatus]);

        /*$query->andFilterWhere(['like', 'hardcopy.courier_name', $this->courier_name])
            ->andFilterWhere(['like', 'hardcopy.tracking_no', $this->tracking_no])
            ->andFilterWhere(['like', 'hardcopy.tracking_url', $this->tracking_url]);*/

        #Generalized Search
        $query->andFilterWhere(['or',
            ['like', 'hardcopyRel.courier_name', $this->search],
            ['like', 'hardcopyRel.tracking_no', $this->search],
            ['like', 'hardcopyRel.tracking_url', $this->search],
            ['like', 'article.paper_id', $this->search],
            ['like', 'article.id', $this->search],
            ['like', 'article.author_name', $this->search],
            ['like', 'article.article_title', $this->search],
            ['like', 'article.article_title', $this->search],
            ['like', 'article.a_email', $this->search],
        ]);

        return $dataProvider;
    }
}
