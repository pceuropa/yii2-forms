<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Forms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'All forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Your forms') ;
?>

<h1><?= $this->title ?> <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['create'], ['class' => 'btn btn-success btn-sm']) ?> </h1>

<div class="row">
	<div class="col-md-12">
		
   <?= GridView::widget([
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
        ],

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
		        'view' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ', ['view', 'url' => $model->url] );
				},
		        'clone' => function ($url, $model, $key) {
					return Html::a ( 'clone', ['clone', 'id' => $model->form_id] );
				},
            ],
			'template' => '{update} {view} {delete}  | {clone}'
            ],
        ],
    ]); ?>
    
   </div>
	<div class="col-md-4 pull-right">
    	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> - <?= Yii::t('app', 'Edit form')  ?><br />
    	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> - <?= Yii::t('app', 'View form')  ?><br />
    	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> - <?= Yii::t('app', 'Delete form')  ?><br />
    	<span class="glyphicon glyphicon-list" aria-hidden="true"></span> - <?= Yii::t('app', 'Data received from completed forms')  ?>
	</div>
</div>
