<?php namespace pceuropa\forms;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Json;


use pceuropa\forms\FormBase;

class Form extends \yii\base\Widget {
    
	public $body = '{}';
	public $model;
	public $typeRender;
	public $fields;
	public $fields_require;


    public function init() {
        parent::init();
    }

    public function run() {
    	if ($this->typeRender === 'js'){
    		return $this->formJsRender();
    	} else {
    		return $this->formPhpRender();
    	}
    }
    
    public function formPhpRender() {
    
    	$array = Json::decode($this->body)['body'];
    	
    	$merge_array = FormBase::filterInvalidFields($array);
    	$data_fields = FormBase::onlyDataFields($merge_array);
    	
    	$this->model = new \yii\base\DynamicModel($data_fields);
    	
    	foreach ($merge_array as $key => $value) {
    	
    		if (isset($value["require"]) && $value["require"]){
    		
    			$this->model->addRule($value["name"], 'required');
    		}
    		
    		$this->model->addRule($value["name"], FormBase::getValidator($value) );
    	    
    	}
	    
		return $this->render('form_php', [
			'array' => $array, 
			'model' => $this->model
		]);
    }
    
    
    public function formJsRender(){
        return $this->render('form_js', ['form_body' => $this->body]);
    }
    
    public static function field($form, $model, $value){
	 		switch ($value['field']) {
		       case 'input': return self::text($form, $model, $value); break;
		       case 'radio': return self::{$value['field']}($form, $model, $value); break;
		       case 'checkbox': return self::{$value['field']}($form, $model, $value); break;
		       case 'select': return self::{$value['field']}($form, $model, $value); break;
		       case 'description': return self::{$value['field']}($value); break;
		       case 'submit': return self::{$value['field']}($value); break;
		       default: return self::text($form, $model, $value); break;
		   	}	
      
	}
   
	public static function div($width, $field){
		return '<div class="'.$width.'">'. $field .'</div>';
	}
   
	public static function text($form, $model, $value){
		if (!isset($value['name'])){
			return null;
		}
	
       $fieldType = ['input' => 'textInput', 'textarea' => 'textarea', 'radio' => 'radioList']; // maping method ActiveField Yii2
       $field = $form->field($model, $value['name'])->{$fieldType[$value['field']]}();
       
       if (isset($value['label'])){ 
       		$field->label($value['label']);
       }
       return self::div($value['width'], $field);
	}
   
	public static function radio($form, $model, $value){
   		
		$items = ArrayHelper::map($value['items'], 'value', 'text');
		
		$field = '<label>'.$value['label'].'</label>'.Html::activeRadioList($model, $value['name'], $items,
	
	[
    'item' => function ($index, $label, $name, $checked, $value) {
			return Html::radio($name, $checked, ['value'  => $value]) . $label . '<br/>';
        }
    ]);
    
	return self::div($value['width'], $field);
   }
   
   public static function checkbox($form, $model, $value){
   		$items = ArrayHelper::map($value['items'], 'value', 'text');
		
		$field = '<label>'.$value['label'].'</label>'.Html::activeCheckboxList($model, $value['name'], $items,
	
	[
    'item' => function ($index, $label, $name, $checked, $value) {
			return Html::checkbox($name, $checked, ['value'  => $value]) . $label . '<br/>';
        }
    ]);
    
    
	return self::div($value['width'], $field);
   }
   
   public static function description($v){
   		return self::div($v['width'], $v['description']);
   }
   
   public static function select($form, $model, $v){
   		if (ArrayHelper::keyExists('name', $v) ){
				$items = ArrayHelper::map($v['items'], 'value', 'text');
				$field = $form->field($model, $v['name'])->dropDownList($items);
   			return self::div($v['width'], $field); 
		}
   }
   
   public static function submit($value){
   		return Html::submitButton($value['label'], ['class' => 'btn btn-success']);
   }
   
}

?>
