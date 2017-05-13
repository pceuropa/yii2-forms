<?php use yii\helpers\Html;

$this->title = 'FormBuilder: Free Software Open Source';
$this->params['breadcrumbs'][] =  Yii::t('app', 'Forms');
?>

<h1><?= Yii::t('app', 'Forms') ?> <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['create'], ['class' => 'btn btn-success btn-sm']) ?> </h1>

<div class="row">
	<div class="col-md-12">
		
   <?= \yii\grid\GridView::widget([
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
					return Html::a ( '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> ', ['list', 'id' => $model->form_id] );
				},
		        'number' => function ($url, $model, $key) {
					return $model->answer;
				},
            ],
			'template' => '{list} {number}'
            
            
            ],
        ],
    ]); ?>
    </div>
</div>
