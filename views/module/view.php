<?php

use yii\helpers\Html;
use yii\helpers\Url;
use pceuropa\forms\Form;

$this->title = Yii::t('app', 'Form'). ': '. $form->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms') , 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Form::widget([
	'body' => $form->body,
	'typeRender' => 'php'
]);
?>
