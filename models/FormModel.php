<?php namespace pceuropa\forms\models;

use Yii;
use yii\web\NotFoundHttpException;
use pceuropa\forms\Module;

/**
 * AR model for Yii2-forms extensions
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
class FormModel extends \yii\db\ActiveRecord {

    /**
     * @ingeritdoc
     */
    public static function getDb() {

        if (Module::getInstance()) {
            return Yii::$app->get(Module::getInstance()->db);
        } else {
            return Yii::$app->db;
        }
    }

    /**
     * @ingeritdoc
     */
    public static function tableName() {

        if (Module::getInstance()) {
            return Module::getInstance()->formTable;
        } else {
            return 'forms';
        }
    }

    /**
     * @ingeritdoc
     */
    public function rules() {
        return [
                   [['body', 'title', 'url'], 'required'],
                   [['body', 'response', 'language', 'method'], 'string'],
                   [['date_start', 'date_end'], 'safe'],
                   [['date_start'], 'default', 'value' => date('Y-m-d')],
                   [['maximum', 'answer', 'author'], 'integer'],
                   [['title',  'meta_title', 'url'], 'string', 'max' => 255],
                   [['url'], 'unique'],
               ];
    }

    /**
     * @ingeritdoc
     */
    public function attributeLabels() {
        return [
                   'form_id' => Yii::t('app', 'ID'),
                   'author' => Yii::t('app', 'Author'),
                   'title' => Yii::t('app', 'Title'),
                   'body' => Yii::t('app', 'Body'),
                   'date_start' => Yii::t('app', 'Date'),
                   'answer' => Yii::t('app', 'Answers'),
                   'date_end' => Yii::t('app', 'Date Expire'),
                   'maximum' => Yii::t('app', 'Max'),
                   'meta_title' => Yii::t('app', 'Meta Title'),
                   'url' => Yii::t('app', 'Url'),
               ];
    }
    /**
     * Get form by id number (form_id) in database
     * @param int $id number of form
     * @return array|boolean The first row of the query result represent one form. False is reurned if the query results in nothing
     */
    public static function findModel(int $id) {

        if (($model = self::find()->where(['form_id' => $id])->one()) !== null ) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested form does not exist.');
        }
    }

    /**
     * Get form by url
     * @param string $url Unique string represent url of form
     * @return array|boolean The first row of the query result represent one form. False is reurned if the query results in nothing
     */
    public function findModelByUrl(string $url) {
        if (($model = self::find()->where(['url' => $url])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * End registration form
     * @return void
     */
    public function endForm() {
        if (is_null($this->maximum) && is_null($this->date_end) ) {
            return false;
        }

        // deadline after now
        if (!is_null($this->date_end) && strtotime($this->date_end) < time()) {
            return true;
        }

        // is max possible answer is less than answer then end form
        if (!is_null($this->maximum) && $this->maximum <= $this->answer) {
            return true;
        }

        return false;
    }

}




