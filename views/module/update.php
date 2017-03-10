<?php

use yii\helpers\Html;
$this->title = Yii::t('app', 'form update') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms list') , 'url' => ['index']];
$this->params['breadcrumbs'][] =  $this->title;

echo \pceuropa\forms\FormBuilder::widget([
	'table' => 'poll_',     // 'form_' . $id
	'config' => [
			'get'=> true, 
			'save'=> true, 
			'autosave' => true,
		]
]);
?>
