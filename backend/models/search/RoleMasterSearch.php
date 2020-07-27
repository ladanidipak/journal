<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RoleMaster;

/**
 * RoleMasterSearch represents the model behind the search form about `app\models\RoleMaster`.
 */
class RoleMasterSearch extends RoleMaster {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'is_deleted', 'created_dt', 'created_by', 'updated_dt', 'updated_by'], 'integer'],
            [['role_title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = RoleMaster::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_deleted' => $this->is_deleted,
            'created_dt' => $this->created_dt,
            'created_by' => $this->created_by,
            'updated_dt' => $this->updated_dt,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'role_title', $this->role_title]);

        return $dataProvider;
    }

}
