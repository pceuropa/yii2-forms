<?php
use yii\helpers\Html;

$this->title = Yii::t('builder', 'Twice response');
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'All forms') , 'url' => ['index']];
?>

<div class="alert alert-warning" role="alert">
    <?= Yii::t('builder', 'The form can be completed only once')?>
</div>
  <?= Html::a (Yii::t('builder', 'See results'), ['list', 'id' => $form_id]);?>
