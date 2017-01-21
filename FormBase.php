<?php namespace pceuropa\forms;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net
use yii\helpers\ArrayHelper;

class FormBase {
    
    
    public function filterInvalidFields($array){
    	$fields = [];
    	foreach ($array as $row => $r) {
    	
			foreach ($r as $key => $v) {
			
				$field = $array[$row][$key];
				
				if (ArrayHelper::keyExists('name', $field) ){
    				array_push($fields, $field);
    			}
			}
			
		}
		return $fields;
    }
    
    public function dataFields($array){
    	$array = ArrayHelper::getColumn($array, 'name');;
		return $array;
    }
    
    public function tableShema($array){
    	$fields['id'] = 'pk';
    	
    	foreach ($array as $r) {
			foreach ($r as $v) {
			
				if ( isset($v['name']) ){
					$fields[ $v['name'] ] = ($v['field'] === 'textarea') ? 'text' : 'string';
				}
				
				
				
			}
		}
		return $fields;
    }
    
    public function getColumnType($field){
    	if (!ArrayHelper::keyExists('field', $field)){
    		return null;
    	}
    		$array = ['input' =>  [
								'text' => 'string',
								'email' => 'string',
								'password' => 'string',
								'date' => 'date',
								'number' => 'integer',
								'url' => 'string',
								'tel' => 'string',
								'url' => 'string',
								'color' => 'string',
								'range' => 'string',
								'url' => 'string',
							],
						'textarea' => 'text',
						'checkbox' => 'string',
						'radio' => 'string',
						'select' => 'string',
    			];
    			
    			
    	if ($field['field'] === 'input'){
    		return $array[ $field['field'] ][ $field['type'] ];
    	} else {
    		return $array[ $field['field'] ];
    	}
    }		
    
    
    public function getValidator($field){
    	
    		$array =	['input' =>  [
								'text' => 'string',
								'email' => 'email',
								'password' => 'string',
								'date' => 'date',
								'number' => 'integer',
								'url' => 'url',
								'tel' => 'string',
								'url' => 'string',
								'color' => 'string',
								'range' => 'string',
								'url' => 'string',
							],
						'textarea' => 'string',
						'checkbox' => 'string',
						'radio' => 'string',
						'select' => 'string',
    			];
    			
    			
    	if ($field['field'] === 'input'){
    		return $array[$field['field']][$field['type']];
    	} else {
    		return $array[$field['field']];
    	}
    	
    	
    }
    
    
    
}
    
?>
