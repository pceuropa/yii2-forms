<?php
use yii\helpers\Html;
use pceuropa\forms\FormBuilder;

$this->title = Yii::t('builder', 'Form generator Yii2');
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'All forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'Your forms') , 'url' => ['user']];
$this->params['breadcrumbs'][] = Yii::t('builder', 'Create');
?>
<?= FormBuilder::widget([
      'test_mode' => $testMode,
      'easy_mode' => $easyMode,
      'send_email' => $sendEmail,
]); ?>
