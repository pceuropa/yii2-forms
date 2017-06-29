<?php namespace pceuropa\forms\models;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pceuropa\forms\models\FormModel;

/**
 * AR search model for Yii2-forms extensions
 *
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.4.1
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 */
class FormModelSearch extends FormModel {

    public function rules(){
        return [
            [['form_id', 'maximum', 'answer'], 'integer'],
            [['author', 'title', 'body', 'date_start', 'date_end', 'meta_title', 'url'], 'safe'],
        ];
    }

/**
 * Search and filter result of gridview
 *
 * @param array $param List of params
 * @return ActiveDataProvider 
*/
    public function search($params) {
        $query = FormModel::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([ 'query' => $query, ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'author' => $this->author,
            'form_id' => $this->form_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'maximum' => $this->maximum,
            'answer' => $this->answer,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
