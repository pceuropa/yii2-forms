<?php namespace pceuropa\forms\models;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pceuropa\forms\models\FormModel;

class FormModelSearch extends FormModel {

    public function rules(){
        return [
            [['form_id', 'maximum'], 'integer'],
            [['author', 'title', 'body', 'date_start', 'date_end', 'seo_title', 'seo_url'], 'safe'],
        ];
    }

    public function search($params) {
        $query = FormModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'form_id' => $this->form_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'maximum' => $this->maximum,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_url', $this->seo_url]);

        return $dataProvider;
    }
}
