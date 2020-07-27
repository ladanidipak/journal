<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Setting;

/**
 * SettingSearch represents the model behind the search form about `backend\models\Setting`.
 */
class SettingSearch extends Setting
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['name', 'value', 'updated_dt', 'search'], 'safe'],
            [['updated_by'], 'integer'],
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
        $query = Setting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 
                           'defaultOrder' => ['name'=>SORT_ASC], 
                           'attributes'   => [ 
                               'name' 
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
            'updated_dt' => $this->updated_dt,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'name', $this->search],
            ['like', 'value', $this->search],
        ]);

        return $dataProvider;
    }
}
