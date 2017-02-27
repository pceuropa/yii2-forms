<?php namespace pceuropa\forms\models;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

use Yii;
use yii\web\NotFoundHttpException;

class FormModel extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'forms';
    }

    public function rules(){
        return [
            [['body', 'title', 'url'], 'required'],
            [['body', 'response'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['maximum'], 'integer'],
            [['title', 'author', 'meta_title', 'url'], 'string', 'max' => 255],
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
		
		$validator = new \yii\validators\NumberValidator();
		
	    if ($validator->validate($id) && ($model = FormModel::find()->where(['form_id' => $id])->one()) !== null ) {
	        return $model;
	    } else {
            throw new NotFoundHttpException('The requested form does not exist.');
        }
	}
	
	public function findModelByUrl($url){
        if (($model = FormModel::find()->where(['url' => $url])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   
}
