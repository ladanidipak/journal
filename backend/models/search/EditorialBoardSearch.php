<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EditorialBoard;

/**
 * EditorialBoardSearch represents the model behind the search form about `backend\models\EditorialBoard`.
 */
class EditorialBoardSearch extends EditorialBoard
{
    /**
     * @inheritdoc
     */
     public $search;
    public function rules()
    {
        return [
            [['id', 'status', 'created_dt', 'created_by', 'updated_dt', 'updated_by', 'is_deleted'], 'integer'],
            [['max_article','full_name', 'qualification', 'designation', 'email', 'phone', 'institute_name', 'country', 'state', 'cv', 'search'], 'safe'],
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
        $query = EditorialBoard::find();
        $query->joinWith(['branch'=>function($query){$query->select(['id','name']);}]);
        $query->from('editorial_board e');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 
                           'defaultOrder' => ['id'=>SORT_DESC],
                           'attributes'   => [ 
                               'id','priority','status'
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
            'e.id' => $this->id,
            'e.status' => $this->status,
            'e.max_article' => $this->max_article,
            'e.created_dt' => $this->created_dt,
            'e.created_by' => $this->created_by,
            'e.updated_dt' => $this->updated_dt,
            'e.updated_by' => $this->updated_by,
            'e.is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'e.full_name', $this->full_name])
            ->andFilterWhere(['like', 'e.qualification', $this->qualification])
            ->andFilterWhere(['like', 'e.designation', $this->designation])
            ->andFilterWhere(['like', 'e.email', $this->email])
            ->andFilterWhere(['like', 'e.phone', $this->phone])
            ->andFilterWhere(['like', 'e.institute_name', $this->institute_name])
            ->andFilterWhere(['like', 'e.country', $this->country])
            ->andFilterWhere(['like', 'e.state', $this->state])
            ->andFilterWhere(['like', 'e.cv', $this->cv]);

        #Generalized Search 
         $query->andFilterWhere(['or',
            ['like', 'e.full_name', $this->search],
            ['like', 'e.qualification', $this->search],
            ['like', 'e.designation', $this->search],
            ['like', 'e.email', $this->search],
            ['like', 'e.phone', $this->search],
            ['like', 'e.institute_name', $this->search],
            ['like', 'e.branch_name', $this->search],
            ['like', 'e.specialization', $this->search],
            ['like', 'e.country', $this->search],
            ['like', 'e.state', $this->search],
            ['like', 'e.cv', $this->search],
            ['like', 'branch.name', $this->search],
        ]);

        return $dataProvider;
    }
}
