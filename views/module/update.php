<?php
use yii\helpers\Html;
use pceuropa\forms\Module;
use pceuropa\forms\FormBuilder;

$this->title = Yii::t('app', 'form update') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'All forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Your forms') , 'url' => ['user']];
$this->params['breadcrumbs'][] = Yii::t('builder', 'Form create');

echo FormBuilder::widget([
	'formTable' => Module::getInstance()->formTable,
    'db' => Module::getInstance()->db,
	'jsConfig' => [
			'get'=> true, 
			'save'=> true, 
			'autosave' => true,
		]
]);
?>
