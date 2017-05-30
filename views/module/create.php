<?php
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net
use yii\helpers\Html;
use pceuropa\forms\FormBuilder;
$this->title = 'Form generator Yii2';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'All forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Your forms') , 'url' => ['user']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Form create');
?>

<h1 class="header"><?= Yii::t('builder', 'Form Builder') ?></h1>
<?= FormBuilder::widget([
		'test_mode' => false,
		'easy_mode' => true
]);
?>
