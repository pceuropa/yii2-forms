<?php namespace pceuropa\forms;
use yii\helpers\ArrayHelper;
/**
 * Yii 2 Forum Module
 *
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.3
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 */
class FormBase {

    public function onlyCorrectDataFields($array){
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
    
    /**
     * Summary.
     *
     * Description.
     * @since 1.0
     * @param array $array Description.
     * @return array
    */
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
    /**
     * Return column type.
     *
     * Description.
     * @link URL
     * @since 1.0
     *
     * @param array $field Get array with field data.
     * @return null|array 
    */
    public function getColumnType($field){

    	if (!ArrayHelper::keyExists('field', $field)){
    		return null;
    	}
    		$type = ['input' =>  [
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
    		return $type[ $field['field'] ][ $field['type'] ];
    	} else {
    		return $type[ $field['field'] ];
    	}
    }		
    
    
    public function getValidator($field){
    	
    		$a = ['input' =>  [
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
    		return $a[$field['field']][$field['type']];
    	} 
    	
		return $a[$field['field']];
    	
    }
    
    
    
}
    
?>
