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
            'value' => function ($m, $key) {
                        return  Html::a ( $m->url, ['view', 'url' => $m->url], ['target' => 'new']);
                    },
        ],
        ['class' => 'yii\grid\ActionColumn',
        'buttons' => [
            'list' => function ($url, $model, $key) {
                return html::a ( '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> '.$model->answer, ['list', 'id' => $model->form_id] );
            },
        ],
        'template' => '{list} '
        ],
    ]
]);?>
