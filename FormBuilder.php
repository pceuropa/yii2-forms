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
    
	public $test_mode = false;
	public $easy_mode = true; 	// if false more options
	public $config = [];		// from widget
	private $options = [];		// to js file
	
	public $table;
	public $model;				// model active record 
	public $success = false;  	// for response
		
	public function init() {
		parent::init();
		
		$this->registerTranslations();
		$this->model = new FormModel();
		
        $this->options = [
			'easy_mode' => $this->easy_mode,
			'test_mode' => $this->test_mode,
			'update' => false,
			'config' =>  $this->config
		];
	}

	public function run() {
		return $this->formBuilderRender();
	}
	
	public function load($data) {
	
		$this->model->body = $data['form_data'];
		$this->model->title = (isset($data['title'])) ? $data['title'] : null;
		$this->model->url = (isset($data['url'])) ? $data['url'] : null; 
		$this->model->meta_title = (isset($data['title'])) ? $data['title'] : null; 
	
	}
	
	public function findModel($id) {
		$this->model =  $this->model->findModel($id);
	}
	
	
    public function save() {
    
   		if (!($this->success = $this->model->save())){
   			 return $this->success = $this->model->getFirstErrors();
   		} else {
   			return true;
   		}
   		
	}
	
    protected function tableShema(){
		$table_shema = Json::decode($this->model->body)['body'];
    	return FormBase::tableShema($table_shema);
    }
    
    
	public function createTable() {
		if ($this->success === true){
			$table_name = $this->table . $this->model->getPrimaryKey();
			$query = Yii::$app->db->createCommand()->createTable($table_name, $this->tableShema(), 'CHARACTER SET utf8 COLLATE utf8_general_ci'); 

			try {
			   $query->execute();
			   $this->success = true;
			} catch (\Exception $e) {
			   $this->success = $e->errorInfo[2];
			}
		}
	}
	
	
	// sprawdzic zapisywanie
	public function addColumn($field = false) { // type
		
		if (isset($field['name'])){
			$column = $field['name'];
			//$this->model->body = $field['body'];
			$type = FormBase::getColumnType($field);
		
        	$query = Yii::$app->db->createCommand()->addColumn($this->table, $column, $type ); 
        
		    try {
		       if ($query->execute()){
				   	//$this->save();
				   	return $this->success = true;
			   }
		       
		    } catch (\Exception $e) {
		       return $this->success = $e->errorInfo[2];
		    }
		}
		
	}
	
	public function renameColumn($data) {
		
		if ( !isset($data['old']) && !isset($data['new']) && $data['old'] === $data['new'] ){
			return $this->success = false;
		}
        	$query = Yii::$app->db->createCommand()->renameColumn( $this->table, $data['old'],$data['new']); 
        
       	try {
	       	$query->execute();
	       	return $this->success = true;
	    } catch (\Exception $e) {
	       	return $this->success = $e->errorInfo[2];
	    }
	}
	
	public function dropColumn($column) {
		
       $query = Yii::$app->db->createCommand()->dropColumn($this->table, $column); 
        
       try {
	       	$query->execute();
	       	return $this->success = true;
	    } catch (\Exception $e) {
	       	return $this->success = $e->errorInfo[2];
	    }
	}
	
	
	
	public function response($format = 'json') {
	
		\Yii::$app->response->format = $format;
		return ['success' => $this->success, 'url' => Url::to(['index'])];
	}
	
	public function formBuilderRender() {
	
		return $this->render('builder/main', $this->options );
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
