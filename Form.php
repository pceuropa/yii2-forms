<?php namespace pceuropa\forms;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use pceuropa\forms\FormBase;
use yii\base\Widget;
use yii\base\DynamicModel;

/**
 * FormRender: Render form
 *
 * Two method render form : php or js (beta)
 *
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.4
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 * FormBuilder requires Yii 2
 * http://www.yiiframework.com
 * https://github.com/yiisoft/yii2
 *
 *
 */


class Form extends Widget {
    
    /**
     * @var object JSON object representing the form body
     */
    public $form = '{}';
	
	/**
	 * @var string Type render js|php
	 * @since 1.0
	 */
	public $typeRender = 'php';

    /**
     * Initializes the object.
     *
     * @return void
     * @see Widget
    */
    public function init() {
        parent::init();
        $this->form = Json::decode($this->form);
    }

    /**
        * Executes the widget.
        * @since 1.0
        * @return function
    */
    public function run() {
    	if ($this->typeRender === 'js'){
    		return $this->jsRender($this->form);
    	} 
    	return $this->phpRender($this->form);
    }
    

    /**
     * Create form
     *
     * Render form by PHP language. 
     * @param array $form
     * @return View Form
    */
    public function phpRender($form) {
    	

    	$data_fields = FormBase::onlyCorrectDataFields($form['body']);
    	$DynamicModel = new DynamicModel( ArrayHelper::getColumn($data_fields, 'name') ); 
    	
    	foreach ($data_fields as $v) {
    		
    		if (isset($v["name"]) && $v["name"]){
    		
    			if (isset($v["require"]) && $v["require"]){
					$DynamicModel->addRule($v["name"], 'required');
				} 
				
    			$DynamicModel->addRule($v["name"], FormBase::getValidator($v) );
    		}
    	}
	    
		return $this->render('form_php', [
			'array' => $form['body'], 
			'model' => $DynamicModel
		]);
    }
    
    /**
     * Create form 
     *
     * Render form by JavaScript language. 
     * @param array $form
     * @return View
    */
    public function jsRender($form){
        return $this->render('form_js', ['form' => $form]);
    }
    

    /**
     * Select and return function render field 
     *
     * Render field in view
     * @param yii\bootstrap\ActiveForm $form
     * @param DynamicModel $model
     * @param array $field
     * @return string Return field in div HTML 
    */
    public static function field($form, $model, $field = null){
    
            $width = $field['width'];

	 		switch ($field['field']) {
		       case 'input': $field = self::input($form, $model, $field); break;
		       case 'textarea': $field = self::textArea($form, $model, $field); break;
		       case 'radio': $field = self::radio($form, $model, $field); break;
		       case 'checkbox': $field = self::checkbox($form, $model, $field); break;
		       case 'select': $field = self::select($form, $model, $field); break;
		       case 'description': $field = self::description($field); break;
		       case 'submit': $field = self::submit($field); break;
		    default: $field = ''; break;
		   	}

        return self::div($width, $field);	
      
	}
   
    /**
     * Return HTML div with field 
     *
     * @param string $width Class bootstrap
     * @param string $field
     * @return string 
    */
	public static function div($width, $field){
		return '<div class="'.$width.'">'. $field .'</div>';
	}

/**
 * Renders an input tag
 * @param yii\bootstrap\ActiveForm $form
 * @param DynamicModel $model
 * @param array $field
 * @return this The field object itself.
 */   
    public static function input($form, $model, $field){

    if (!isset($field['name'])){
        return null;
    }

    $input = $form->field($model, $field['name'])->input($field['type']);

    if (isset($field['label'])){ 
        $input->label($field['label']);
    }

        return $input;
    }

   /**
     * Renders a text area.
     * @param yii\bootstrap\ActiveForm $form
     * @param DynamicModel $model
     * @param array $field
     * @return $this The field object itself.
     */ 
    public static function textArea($form, $model, $field){
        
        if (!isset($field['name'])){
	        return null;
        }

        $text_area = $form->field($model, $field['name'])->textArea();

        if (isset($field['label'])){ 
	        $text_area->label($field['label']);
        }

        return $text_area;
    }
   
/**
* Renders a list of radio buttons.
* @param yii\bootstrap\ActiveForm $form
* @param DynamicModel $model
* @param array $field
* @return $this The field object itself.
*/ 
   public static function radio($form, $model, $field){
   		
   		$items = [];
   		$checked = [];
   		
   		foreach ($field['items'] as $key => $value) {
   		    $items[$value['value']] =  $value['text'];
   		    if (isset( $value['checked'] )){ $checked[]  = $key+1; }
   		}
   		
   		$model->{$field['name']} = $checked;
		$radio_list = $form->field($model, $field['name'])->radioList($items);
		
    	$label = (isset($field['label'])) ? $field['label'] : '';
    	
		$radio_list->label($label, ['class' => 'bold']);
		
		return $radio_list;
   }
   
    /**
    * Renders a list of checkboxes.
    * @param yii\bootstrap\ActiveForm $form
    * @param DynamicModel $model
    * @param array $field
    * @return $this The field object itself.
    */ 
   public static function checkbox($form, $model, $field){


   		$items = [];
   		$checked = [];
   		
   		foreach ($field['items'] as $key => $value) {
   		    $items[$value['value']] =  $value['text'];
   		    if (isset($value['checked'])){
   		    	$checked[]  = $key+1;
   		    }
   		    
   		}
		$items = ArrayHelper::map($field['items'], 'value', 'text');
		$model->{$field['name']} = $checked;
		$checkbox_list = $form->field($model, $field['name'])->checkboxList($items);
		
		$label = (isset($field['label'])) ? $field['label'] : '';
		$checkbox_list->label($label);
    
		return $checkbox_list;
   
   
    
}
   
    /**
    * Renders a drop-down list.
    * @param yii\bootstrap\ActiveForm $form
    * @param DynamicModel $model
    * @param array $field
    * @return $this The field object itself.
    */ 

   public static function select($form, $model, $field){
   		if (ArrayHelper::keyExists('name', $field) ){
   				$items = [];
   				$checked = [];

				foreach ($field['items'] as $key => $value) {
		   		    $items[$value['value']] =  $value['text'];
		   		    
		   		    if (isset($value['checked'])){
		   		    	$checked[]  = $key+1;
		   		    }
		   		}
		   		
				$model->{$field['name']} = $checked;
				$select = $form->field($model, $field['name'])->dropDownList($items);
				$label = (isset($field['label'])) ? $field['label'] : '';
				$select->label($label);
   			return $select; 
		}
   }
   
      /**
     * Renders a description html.
     * @param array $v
     * @return string
     */ 
   public static function description($v){
   		return $v['textdescription'];
   }
   
   /**
     * Renders a submit buton tag.
     * @param array $data
     * @return string The generated submit button tag
     */ 
   public static function submit($data){
   		return Html::submitButton($data['label'], ['class' => 'btn '.$data['backgroundcolor'] ]);
   }
   
   
   
   
    /**
    * Depraced
    * @depraced .
    * @param yii\bootstrap\ActiveForm $form
    * @param DynamicModel $model
    * @param array $value
    */   	
    public static function radio2($form, $model, $value){
   		
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

    /**
    * Depraced
    * @depraced .
    * @param yii\bootstrap\ActiveForm $form
    * @param DynamicModel $model
    * @param array $value
    */ 
   public static function checkbox2($form, $model, $value){
   		
   		$items = ArrayHelper::map($value['items'], 'value', 'text');
		$label = (isset($value['label'])) ? '<label>'.$value['label'].'</label>' : '';
		$field = $label . Html::activeCheckboxList($model, $value['name'], $items,
		[
		'item' => function ($index, $label, $name, $checked, $value) {
				
				return Html::checkbox($name, $checked, ['value'  => $value]) . $label . '<br/>';
		    },
		]);
		return self::div($value['width'], $field);
   }
}

?>
