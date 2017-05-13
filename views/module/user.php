<?php use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use lajax\translatemanager\helpers\Language as Lx;
use pceuropa\languageSelection\LanguageSelection;
$this->title = Yii::t('app', 'Questionnaire') . ' Online';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
?>

<h1><?= $this->title ?> <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['create'], ['class' => 'btn btn-success btn-sm']) ?> </h1>
<div class="row">
	<div class="col-md-8">
		
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
		        'view' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ', ['view', 'url' => $model->url] );
				},
		        'list' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> '.$model->answer, ['list', 'id' => $model->form_id] );
				},
		        'clone' => function ($url, $model, $key) {
					return Html::a ( 'clone', ['clone', 'id' => $model->form_id] );
				},
            ],
			'template' => '{update} {view} {delete} {list} | {clone}'
            
            
            ],
        ],
    ]); ?>
    
   </div>
	<div class="col-md-4">
    	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> - <?= Yii::t('app', 'Edit form')  ?><br />
    	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> - <?= Yii::t('app', 'View form')  ?><br />
    	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> - <?= Yii::t('app', 'Delete form')  ?><br />
    	<span class="glyphicon glyphicon-list" aria-hidden="true"></span> - <?= Yii::t('app', 'Data received from completed forms')  ?><br />
	</div>
</div>
