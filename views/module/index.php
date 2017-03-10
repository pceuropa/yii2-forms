<?php
use yii\helpers\Html;

$this->title = 'FormBuilder: Free Software Open Source';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Yii::t('app', 'FormBuilder <small>Free Software Open Source</small>') ?></h1>


	<?= Html::a(Yii::t('app', 'Create form'), ['create'], ['class' => 'btn btn-success']) ?>
	
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
							return  Html::a ( $m->url, ['forms/view', 'url' => $m->url], ['target' => 'new']);
						},
			],

            ['class' => 'yii\grid\ActionColumn',
            
            'buttons' => [
		        'view' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ', ['module/view', 'url' => $model->url] );
				},
		        'list' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> ', ['module/list', 'id' => $model->form_id] );
				},
            ],
			'template' => '{update} {view} {delete} {list}'
            
            
            ],
        ],
    ]); ?>
    
  




    
