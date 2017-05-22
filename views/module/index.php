<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'FormBuilder: Free Software Open Source';
$this->params['breadcrumbs'][] =  Yii::t('app', 'Forms');
?>

<h1><?= Yii::t('app', 'Forms') ?> <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['create'], ['class' => 'btn btn-success btn-sm']) ?> </h1>
<?= Gridview::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'title',
         [
            'attribute' => 'url',
            'format' => 'html',
            'value' => function ($model) {
                        return  Html::a ( $model->url, ['view', 'url' => $model->url], ['target' => 'new']);
                    },
        ],[
            'attribute' => 'answer',
            'format' => 'html',
            'value' => function ($model) {
              $maximum = null;
              if ($model->maximum !== null) {
               $maximum = ' /'. $model->maximum; 
              } 
              
                return html::a ( '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> '.$model->answer . $maximum, ['list', 'id' => $model->form_id] );
                    },
        ],[
            'attribute' => 'date_end',
            'format' => 'datetime',
        ]
    ]
]);?>
