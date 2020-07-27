<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cms;

/**
 * CmsSearch represents the model behind the search form about `app\models\Cms`.
 */
class CmsSearch extends Cms
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['status', 'is_deleted', 'created_by', 'created_dt', 'updated_by', 'updated_dt'], 'integer'],
            [['id', 'page_title', 'page_name', 'content', 'slug', 'meta_key', 'meta_description', 'search'], 'safe'],
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
        $query = Cms::find();

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
            'created_by' => $this->created_by,
            'created_dt' => $this->created_dt,
            'updated_by' => $this->updated_by,
            'updated_dt' => $this->updated_dt,
        ]);

        $query->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'page_name', $this->page_name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'meta_key', $this->meta_key])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'page_title', $this->search],
            ['like', 'page_name', $this->search],
            ['like', 'content', $this->search],
            ['like', 'slug', $this->search],
            ['like', 'meta_key', $this->search],
            ['like', 'meta_description', $this->search],
        ]);

        return $dataProvider;
    }
}
