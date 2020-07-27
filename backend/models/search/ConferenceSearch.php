<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Conference;

/**
 * ConferenceSearch represents the model behind the search form about `backend\models\Conference`.
 */
class ConferenceSearch extends Conference
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'conf_type', 'is_deleted', 'updated_by'], 'integer'],
            [['conf_cor_name', 'email', 'org_name', 'phone', 'org_website', 'dept_name', 'aff_by', 'title', 'description', 'short_name', 'conf_date', 'specialization', 'venue', 'conf_website', 'brochure', 'college_logo', 'created_dt', 'updated_dt', 'search'], 'safe'],
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
        $query = Conference::find();

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
            'conf_type' => $this->conf_type,
            'is_deleted' => $this->is_deleted,
            'created_dt' => $this->created_dt,
            'updated_dt' => $this->updated_dt,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'conf_cor_name', $this->conf_cor_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'org_name', $this->org_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'org_website', $this->org_website])
            ->andFilterWhere(['like', 'dept_name', $this->dept_name])
            ->andFilterWhere(['like', 'aff_by', $this->aff_by])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'conf_date', $this->conf_date])
            ->andFilterWhere(['like', 'specialization', $this->specialization])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'conf_website', $this->conf_website])
            ->andFilterWhere(['like', 'brochure', $this->brochure])
            ->andFilterWhere(['like', 'college_logo', $this->college_logo]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'conf_cor_name', $this->search],
            ['like', 'email', $this->search],
            ['like', 'org_name', $this->search],
            ['like', 'phone', $this->search],
            ['like', 'org_website', $this->search],
            ['like', 'dept_name', $this->search],
            ['like', 'aff_by', $this->search],
            ['like', 'title', $this->search],
            ['like', 'description', $this->search],
            ['like', 'short_name', $this->search],
            ['like', 'conf_date', $this->search],
            ['like', 'specialization', $this->search],
            ['like', 'venue', $this->search],
            ['like', 'conf_website', $this->search],
            ['like', 'brochure', $this->search],
            ['like', 'college_logo', $this->search],
        ]);

        return $dataProvider;
    }
}
