<?php namespace pceuropa\forms\models;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use Yii;
class FormModel extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'forms';
    }

    public function rules(){
        return [
            [['body'], 'required'],
            [['body'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['maximum'], 'integer'],
            [['author', 'meta_title', 'url'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 400],
            [['url'], 'unique'],
        ];
    }

    public function attributeLabels(){
        return [
            'form_id' => Yii::t('app', 'ID'),
            'author' => Yii::t('app', 'Author'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'date_start' => Yii::t('app', 'Date'),
            'date_end' => Yii::t('app', 'Date Expire'),
            'maximum' => Yii::t('app', 'Max'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'url' => Yii::t('app', 'Url'),
        ];
    }

	public function findModel($id){
	    if (($model = FormModel::find()->where(['form_id' => $id])->one()) !== null) {
	        return $model;
	    } else {
            throw new \yii\web\NotFoundHttpException('The requested form does not exist.');
        }
	}
	

	
}
