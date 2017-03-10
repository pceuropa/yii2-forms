<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'form data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'forms'), 'url' => ['module/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>
<?php
   // $only_data_fields[] = ['class' => 'yii\grid\ActionColumn'];
?>
<?php Pjax::begin(); ?>    

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => $only_data_fields

            //['class' => 'yii\grid\ActionColumn'],
        ,
    ]); ?>
<?php Pjax::end(); ?>
