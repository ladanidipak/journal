<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MenuMaster;
use backend\vendors\Common;

/**
 * MenuMasterSearch represents the model behind the search form about `app\models\MenuMaster`.
 */
class MenuMasterSearch extends MenuMaster {

    /**
     * @inheritdoc
     */
    public $search;
    public function rules() {
        return [
            [['id', 'is_deleted', 'created_dt', 'created_by', 'updated_dt', 'updated_by'], 'integer'],
            [['menu_title','search','show_in_menu'], 'safe'],
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
        $query = MenuMaster::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);        
        if (!$this->validate()) {
            return $dataProvider;
        }                
        $query->andFilterWhere([
            'show_in_menu' => $this->show_in_menu,
        ]);

        $query->andFilterWhere(['like', 'menu_title', $this->search]);

        return $dataProvider;
    }

}
