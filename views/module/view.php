<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Form preview') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?>:</h1><hr>

<?php
echo \pceuropa\forms\Form::widget([
	'body' => $form_body,
	'typeRender' => 'php'
]);
?>
