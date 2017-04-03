<?php
namespace pceuropa\forms;

use Yii;

/**
 * Module Yii2-forms
 *
 * FormBuilder module. All controllers and views in one place.
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.4.1
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 */
class Module extends \yii\base\Module {
	public $controllerNamespace = 'pceuropa\forms\controllers';
	public $defaultRoute = 'module';
	public $table;
	
    public function init(){
		parent::init();	  // custom initialization code goes here
	}
	
	public function table(){
		return $this->table;
	}
}
