<?php
namespace pceuropa\forms;
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net

use Yii;

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
