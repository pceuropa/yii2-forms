<?php
use yii\helpers\Html;
use pceuropa\forms\Module;
use pceuropa\forms\FormBuilder;

$this->title = Yii::t('builder', 'Form update') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'All forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'Your forms') , 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= FormBuilder::widget([
	'formTable' => Module::getInstance()->formTable,
    'db' => Module::getInstance()->db,
    'send_email' => $sendEmail,
	'easy_mode' => $easyMode ?? true,
	'jsConfig' => [
      'get'=> true, 
			'save'=> true, 
			'autosave' => true,
		]
]);
?>
