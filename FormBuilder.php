<?php
namespace pceuropa\forms;

use Yii;
use yii\base\Widget;
use yii\helpers\{Url, Html, ArrayHelper, Json};
use yii\db\{Query, Exception};
use yii\web\NotFoundHttpException;
use pceuropa\forms\{Form, FormBase};
use pceuropa\forms\models\FormModel;

/**
 * FormBuilder: Generate forms, Storage data in databasesand, create tables
 * Generate forms and create tables from json object
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.6
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forms
 * Please report all issues at GitHub. Thank for Your time.
 * https://github.com/pceuropa/yii2-forms/issues
 *
 * FormBuilder requires Yii 2
 * http://www.yiiframework.com
 * https://github.com/yiisoft/yii2
 *
 * For yii2-form documentation go to
 * https://pceuropa.net/yii2S-extensions/yii2-forms/manual
 *
 */

class FormBuilder extends Widget {

    /**
     * @var array preLoaded data of form
     */
    public $formData = null;

    /**
     * @var bool If true FormBuilder set test data on begin
     * @since 1.0
     */
    public $test_mode = false;

    /**
     * @var bool If true - only basic options of form and fields
     * @since 1.0
     */
    public $easy_mode = true;

    /**
     * @var bool If true - hide options dont need for only generator html|Yii2 code
     * @since 1.0
     */
    public $generator_mode = false;

    /**
     * @var bool If true - form can send email response
     * @since 1.4
     */
    public $send_email = false;

    /**
     * @var array  Configuration data for JavaScript assets
     * @since 1.0
     */
    public $jsConfig = [];

    /**
     * @var array configuration data for php render
     * @since 1.0
     */
    private $options = [];

    /**
     * @var string DB connections
     */
    public $db = 'db';

    /**
     * @var string The database table storing the forms
     */
    public $formTable = '{{%forms}}';

    /**
     * @var string The database table storing the data from forms
     */
    public $formDataTable = 'form_';

    /**
     * @var FormModel Model data
     * @since 1.0
     */
    public $model;

    /**
     * @var bool Response from backend to message success
     * @since 1.0
     */
    public $success = false;  	// for response

    /**
     * @var bolean If false - hide button save form
     */
    public $hide_button_form_save = false;
    
    /**
     * Initializes the object.
     * Variables and functions init
     * @since 1.0
     *
    */
    public function init() {
        parent::init();

        $this->registerTranslations();
        $this->model = new FormModel();
        if ($this->formData !== null) {
            $this->load($this->formData);
        }

        $this->options = [
              'easy_mode' => $this->easy_mode,
              'test_mode' => $this->test_mode,
              'generator_mode' => $this->generator_mode,
              'send_email' => $this->send_email,
              'hide_button_form_save' => $this->hide_button_form_save,
              'jsConfig' =>  $this->jsConfig
        ];
    }

    /**
        * Executes the widget.
        * @since 1.0
        * @return void
    */
    public function run() {
        return $this->formBuilderRender();
    }

    /**
        * Populates the model with input ajax data.
        * @since 1.0
        * @param object $data Data from request post
        * @return null
    */
    public function load($form) {
        foreach ($form as $key => $value) {
            $this->model[$key] = $form[$key];
        }
        $this->model->author = (isset(Yii::$app->user->identity->id)) ? Yii::$app->user->identity->id : null;
    }

    /**
     * Creates an yii\db\ActiveQueryInterface instance for query purpose.
     * @since 1.0
     * @param int $id Data from request post
     * @return null
    */
    public function findModel(int $id) {
        $this->model = $this->model->findModel($id);
    }

    /**
     * Saves the current record.
     * @since 1.0
     * @return array|bool Return message error or true if saved corretly
    */
    public function save() {
        if (!($this->success = $this->model->save())) {
            return $this->success = $this->model->getFirstErrors();
        }
        return $this->success;
    }
    /**
     * Populates the model with input data.
     * @since 1.0
     * @see FormBase::tableSchema
     * @param string Json form
     * @return array Return table shema
    */
    public function tableSchema($form_body) {
        if (!is_string($form_body)) {
            return false;
        }

        $form_body = Json::decode($form_body);
        $schema =  FormBase::tableSchema($form_body);
        return $schema;
    }



    /**
     * Create table
     * Creates a SQL command for creating a new DB table. Execute the SQL statement.
     * If table crate table correctly @return array message success
     * @since 1.0
     * @return object Return json message callback
    */
    public function createTable() {
        if ($this->success !== true) {
            return;
        }
        $table_name = $this->formDataTable . $this->model->form_id;
        $table_schema = $this->tableSchema($this->model->body);
        $query = Yii::$app->{$this->db}->createCommand()->createTable($table_name,  $table_schema, 'CHARACTER SET utf8 COLLATE utf8_general_ci');
        return $this->execute($query);
    }

    /**
     * Add column
     * Creates a SQL command for adding a new DB column and execute.
     * @param array $field
     * @return object Return json message callback
    */
    public function addColumn(array $field) {
        if (!isset($field['name'])) {return $this->success = 'empty name';}

        $column_name = $field['name'];
        $column_type = FormBase::getColumnType($field);
        $id = $this->model->form_id;
        $query = Yii::$app->{$this->db}->createCommand()->addColumn( $this->formDataTable.$id, $column_name, $column_type );
        return $this->execute($query);
    }

    /**
     * Rename column
     * Creates a SQL command for renaming a column and execute.
     * @since 1.0
     * @param array $name Array with old and new name of the column.
     * @return object Return json message callback
    */
    public function renameColumn(array $name) {

        if ( !isset($name['old']) && !isset($name['new']) && $name['old'] === $name['new'] ) {
            return $this->success = false;
        }

        $id = $this->model->form_id;
        $query = Yii::$app->db->createCommand()->renameColumn( $this->formDataTable.$id, $name['old'], $name['new']);

        return $this->execute($query);
    }

    /**
     * Drop column
     * Creates a SQL command for dropping a DB column. and execute.
     * @since 1.0
     * @param string $column The name of the column to be dropped.
     * @return object Return json message callback
    */
    public function dropColumn(string $column) {
        $id = $this->model->form_id;
        $query = Yii::$app->db->createCommand()->dropColumn($this->formDataTable.$id, $column);
        return $this->execute($query);
    }


    /**
     * Executes the SQL statement and @return array callback.
     * @since 1.0
     * @param object $query
     * @return object Return json message callback
    */
    public function execute($query) {
        try {
            $query->execute();
            return $this->success = true;
        } catch (Exception $e) {
            return $this->success = $e->getMessage();
        }
    }

    /**
     * Function @return array for ajax callback
     * @since 1.0
     * @param string $format format response
     * @return array Return json message callback
    */
    public function response(string $format = 'json') {
      \Yii::$app->response->format = $format;
      $response = ['success' => $this->success];

      if ( $this->success === true) {

        try {
          $response['url'] =  Url::to(['user']);
        } catch (\yii\base\InvalidParamException $e) {
          $response['url'] =  '';
        }
      }
      return $response;
    }

    /**
     * Render view
     * @since 1.0
     * @return void
    */
    public function formBuilderRender() {
        return $this->render('builder/main', $this->options );
    }

    /**
     * Translates a message to the specified language.
     * @since 1.0
     * @return null
    */
    public function registerTranslations() {
        Yii::$app->i18n->translations['builder'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/pceuropa/yii2-forms/messages',
        ];
    } 
}
?>
