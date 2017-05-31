<?php
use yii\helpers\Html;
use pceuropa\forms\Module;
use pceuropa\forms\FormBuilder;

$this->title = Yii::t('builder', 'Form update') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'All forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'Your forms') , 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="header"><?= Yii::t('builder', 'Form Builder') ?></h1>

<?= FormBuilder::widget([
	'formTable' => Module::getInstance()->formTable,
    'db' => Module::getInstance()->db,
    'easy_mode' => false,
	'jsConfig' => [
      'get'=> true, 
			'save'=> true, 
			'autosave' => true,
		]
]);
?>
