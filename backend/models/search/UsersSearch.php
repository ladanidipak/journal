<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form about `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'user_group', 'created_by', 'updated_by', 'status', 'is_deleted'], 'integer'],
            [['password', 'first_name', 'last_name', 'email','profile_pic','search', 'created_dt', 'updated_dt'], 'safe'],
            [['conf_id','type'],'safe','on'=>'admin']
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
        $query = Users::find();

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
            'conf_id' => $this->conf_id,
            'user_group' => $this->user_group,
            'created_by' => $this->created_by,
            'status' => $this->status,
            'type' => $this->type,
            'is_deleted' => $this->is_deleted,
        ]);
        
        $query->andFilterWhere(['or',['like', 'email', $this->search],['like', 'first_name', $this->search]]);
        
        return $dataProvider;
    }
}
