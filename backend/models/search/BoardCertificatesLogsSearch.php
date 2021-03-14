<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BoardCertificatesLogs;

/**
 * BoardCertificatesLogs represents the model behind the search form about `backend\models\BoardCertificatesLogs`.
 */
class BoardCertificatesLogsSearch extends BoardCertificatesLogs
{
    /**
     * @inheritdoc
     */
    public $search;
    public function rules()
    {
        return [
            [['id', 'board_member', 'created_by', 'created_dt', 'updated_by', 'updated_dt', 'is_deleted'], 'integer'],
            [['name', 'recognize', 'date_on_certificate', 'to', 'subject', 'body', 'search'], 'safe'],
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
        $query = BoardCertificatesLogs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes'   => [
                    'id'
                ],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSize'],
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
            'board_member' => $this->board_member,
            'created_by' => $this->created_by,
            'created_dt' => $this->created_dt,
            'updated_by' => $this->updated_by,
            'updated_dt' => $this->updated_dt,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'recognize', $this->recognize])
            ->andFilterWhere(['like', 'date_on_certificate', $this->date_on_certificate])
            ->andFilterWhere(['like', 'to', $this->to])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body]);

        #Generalized Search 
        $query->andFilterWhere([
            'or',
            ['like', 'name', $this->search],
            ['like', 'recognize', $this->search],
            ['like', 'date_on_certificate', $this->search],
            ['like', 'to', $this->search],
            ['like', 'subject', $this->search],
            ['like', 'body', $this->search],
        ]);

        return $dataProvider;
    }
}
