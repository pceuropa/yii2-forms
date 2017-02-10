<?php namespace pceuropa\forms;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use pceuropa\forms\Form;
use pceuropa\forms\FormBase;
use pceuropa\forms\FormBuilder;
use pceuropa\forms\models\FormModel;


class FormBuilder extends \yii\base\Widget {
    
    public $action = 'create';
	public $test_mode = false;
	public $easy_mode = true; 	// if false more options
	public $table_name = 'form_';
	public $model;				// model active record 
	public $success = false;  	// for response
		
	public function init() {
		parent::init();
		$this->registerTranslations();
		$this->model = new FormModel();
	}

	public function run() {
		return $this->formBuilderRender();
	}
	
	public function load($data) {
		$this->model->body = $data['form_data'];
		$this->model->title = (isset($data['title'])) ? $data['title'] : null;
		$this->model->seo_url = (isset($data['url'])) ? $data['url'] : null; 
		$this->model->seo_title = (isset($data['title'])) ? $data['title'] : null; 
	
	}
	
	
    public function save() {
		if ($this->model->save()){
			
			return $this->success = true;
		}else {
			return $this->model->getErrors();
		}
	}
	
    protected function tableShema(){
		$table_shema = Json::decode($this->model->body)['body'];
    	return FormBase::tableShema($table_shema);
    }
    
    
	public function createTable($prefix = 'form_') {
		if ($this->success){
			$table_name = $prefix . $this->model->getPrimaryKey();
			$query = Yii::$app->db->createCommand()->createTable($table_name, $this->tableShema(), 'CHARACTER SET utf8 COLLATE utf8_general_ci'); 

			try {
			   $query->execute();
			   $this->success = true;
			} catch (\Exception $e) {
			   $this->success = $e->errorInfo[2];
			}
		}
	}
	
	public function addColumn($id, $field = false) { // type
		
		$table = $this->table_name . $id;
		$column = $field['name'];
		$type = FormBase::getColumnType($field);
		
        if ($table && $column && $type) {
        	$query = Yii::$app->db->createCommand()->addColumn( $table, $column, $type ); 
        
		    try {
		       $query->execute();
		       $this->success = true;
		    } catch (\Exception $e) {
		       $this->success = $e->errorInfo[2];
		    }
        }
	}
	
	public function renameColumn( $table, $oldName, $newName ) {
        $query = Yii::$app->db->createCommand()->renameColumn( $table, $oldName, $newName ); 
        
        try {
           $query->execute();
           $this->success = true;
        } catch (\Exception $e) {
           $this->success = $e->errorInfo[2];
        }
	}
	
	public function dropColumn($id, $post) {
		
		$table = $this->table_name . $id;
		$column = $post;
		
        $query = Yii::$app->db->createCommand()->dropColumn($table, $column); 
        
        try {
           $query->execute();
           $this->success = true;
        } catch (\Exception $e) {
           $this->success = $e->errorInfo[2];
        }
	}
	
	
	
	public function response($format = 'json') {
		\Yii::$app->response->format = $format;
		
			return ['success' => $this->success, 'url' => Url::to(['index'])];
	}
	
	public function formBuilderRender() {
	
		$options = [
			'easy_mode' => $this->easy_mode,
			'test_mode' => $this->test_mode,
			'update' => false
			
		];
	
		if ($this->action === 'update'){
			$options['update'] = true;
		} 
		
		return $this->render('builder/main', $options );
	}
	
	public function registerTranslations() {
	
        Yii::$app->i18n->translations['builder'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/pceuropa/yii2-forms/messages',
            
        ];
    }

   
}
    
?>
