<?php namespace pceuropa\forms;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
    	$data_fields = FormBase::onlyCorrectDataFields($array);
    	$this->model = new \yii\base\DynamicModel(ArrayHelper::getColumn($data_fields, 'name'));  // only 'name' column to dynamic model
    	
    	
    	foreach ($data_fields as $v) {
    		
    		if (isset($v["name"]) && $v["name"]){
    		
    			if (isset($v["require"]) && $v["require"]){
					$this->model->addRule($v["name"], 'required');
				}
				
    			$this->model->addRule($v["name"], FormBase::getValidator($v) );
    		}
    		
    	    
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
		       case 'input': return self::textInput($form, $model, $value); break;
		       case 'textarea': return self::text($form, $model, $value); break;
		       case 'radio': return self::{$value['field']}($form, $model, $value); break;
		       case 'checkbox': return self::{$value['field']}($form, $model, $value); break;
		       case 'select': return self::{$value['field']}($form, $model, $value); break;
		       case 'description': return self::{$value['field']}($value); break;
		       case 'submit': return self::{$value['field']}($value); break;
		       default: return self::textInput($form, $model, $value); break;
		   	}	
      
	}
   
	public static function div($width, $field){
		return '<div class="'.$width.'">'. $field .'</div>';
	}
   
   	public static function textInput($form, $model, $value){
		if (!isset($value['name'])){
			return null;
		}
       
       $field = $form->field($model, $value['name'])->textInput(['type' => $value['type']]);
       
       if (isset($value['label'])){ 
       		$field->label($value['label']);
       }
       
       return self::div($value['width'], $field);
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
   
	public static function radio_ver_depraced($form, $model, $value){
   		
		$items = ArrayHelper::map($value['items'], 'value', 'text');
		$label = (isset($value['label'])) ? '<label>'.$value['label'].'</label>' : '';
		$field = $label . Html::activeRadioList($model, $value['name'], $items,
	
		[
			'item' => function ($index, $label, $name, $checked, $value) {
				return Html::radio($name, $checked, ['value'  => $value]) . $label . '<br/>';
		    }
		]);
    
		return self::div($value['width'], $field);
   }
   
   
   public static function radio($form, $model, $v){
   		
		$items = ArrayHelper::map($v['items'], 'value', 'text');
		$field = $form->field($model, $v['name'])->radioList($items);
		
    	$label = (isset($v['label'])) ? $v['label'] : '';
		$field->label($label, ['class' => 'bold']);
		
		return self::div($v['width'], $field);
   }
   
   public static function checkbox($form, $model, $v){
   		
		$items = ArrayHelper::map($v['items'], 'value', 'text');
		$field = $form->field($model, $v['name'])->checkboxList($items);
		$label = (isset($v['label'])) ? $v['label'] : '';
		$field->label($label);
    
		return self::div($v['width'], $field);
   }
   
   public static function checkbox_ver_depraced($form, $model, $value){
   
   		$items = ArrayHelper::map($value['items'], 'value', 'text');
		$label = (isset($value['label'])) ? '<label>'.$value['label'].'</label>' : '';
		$field = $label . Html::activeCheckboxList($model, $value['name'], $items,
	
		[
		'item' => function ($index, $label, $name, $checked, $value) {
				return Html::checkbox($name, $checked, ['value'  => $value]) . $label . '<br/>';
		    }
		]);
    
    
		return self::div($value['width'], $field);
   }
   
   
   public static function select($form, $model, $v){
   		if (ArrayHelper::keyExists('name', $v) ){
				$items = ArrayHelper::map($v['items'], 'value', 'text');
				$field = $form->field($model, $v['name'])->dropDownList($items);
				$label = (isset($v['label'])) ? $v['label'] : '';
				$field->label($label);
   			return self::div($v['width'], $field); 
		}
   }
   
   
   public static function description($v){
   		return self::div($v['width'], $v['textdescription']);
   }
   
   public static function submit($value){
   		return Html::submitButton($value['label'], ['class' => 'btn btn-success']);
   }
   
}

?>
