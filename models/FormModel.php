<?php namespace pceuropa\forms\models;

use Yii;
use yii\web\NotFoundHttpException;
use pceuropa\forms\{Module, FormBase};
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * AR model for Yii2-forms extensions
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.4.1
 * @license MIT
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 */
class FormModel extends \yii\db\ActiveRecord {

    /**
     * @var boolean Form can be complated only once by one human
     */
    public $canByCompletedOnlyOnce = true;

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
    public function rules() : array
    {
        return [
            [['body', 'title', 'url'], 'required'],
            [['body', 'response'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['date_start'], 'default', 'value' => date('Y-m-d')],
            [['form_id','maximum', 'answer', 'author'], 'integer'],
            [['only_once'], 'integer', 'max' => 1],
            [['method'], 'string', 'max' => 4],
            [['language'], 'string', 'max' => 11],
            [['title',  'meta_title', 'url', 'id', 'class', 'action'], 'string', 'max' => 255],
            [['action'], 'default', 'value' => 'POST'],
            [['url'], 'unique'],
        ];
    }

    /**
     * @ingeritdoc
     */
    public function attributeLabels() : array
    {
        return [
            'form_id' => Yii::t('builder', 'ID'),        //form_id - id for database
            'author' => Yii::t('builder', 'Author'),
            'title' => Yii::t('builder', 'Title'),
            'body' => Yii::t('builder', 'Body'),
            'date_start' => Yii::t('builder', 'Date'),
            'answer' => Yii::t('builder', 'Answers'),
            'date_end' => Yii::t('builder', 'End'),
            'only_once' => Yii::t('builder', 'Can be completed only once'),
            'maximum' => Yii::t('builder', 'Max'),
            'meta_title' => Yii::t('builder', 'Meta Title'),
            'url' => Yii::t('builder', 'URL'),
            'id' => Yii::t('builder', 'id'),             // id - for html
            'class' => Yii::t('builder', 'class'),       // class - for html
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
    public function endForm() : bool
    {
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

    /**
     * End registration form
     * @return void
     */
    private function possibleAnswers()
    {
        $tmp_array = [];
        if (!is_array($this->body)) {
            $this->body = Json::decode($this->body);
        }
        
        foreach(FormBase::onlyCorrectDataFields($this->body) as $key => $field) {
            if (in_array($field['field'], ['radio', 'select', 'checkbox'])) {
                $tmp_array[$field['name']] = ArrayHelper::getColumn($field['items'], 'value');
            }
        }
        return $tmp_array;
    }

    /**
     * Check the correctness of the data
     *
     * Return number of froud
     *
     * @return int
     */
    public function checkCorrectnessData(array $data) : int
    {
        $bad = 0;
        foreach ($this->possibleAnswers() as $key => $value) {

            // test checkbox
            if (is_array($data[$key])) {
                $bad += (int) array_diff($data[$key], $value);
                continue;
            }
          
            // test radio and select
            if (!in_array($data[$key], $value) and $data[$key] != null) {
                $bad += 1;
            }
        }
        return $bad;
    }

    /**
     * Send only once
     *
     * Protected against send twice
     */
    public function isFormSentOnlyOnce(string $form_id): bool
    {
        if ((bool) $this->only_once) {
            return 
                Yii::$app->request->cookies->getValue($form_id, null) ?? 
                Yii::$app->session->get($form_id) ?? 
                false;
        }
        return false;
    }
}
