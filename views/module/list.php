<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = $form->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
                          'dataProvider' => $dataProvider,
                          'columns' => $only_data_fields
                      ]);
?>

