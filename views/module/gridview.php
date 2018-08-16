<?php
use yii\helpers\Html;
use yii\grid\GridView;
$template = ($buttonsEditOnIndex ?? true) ? '{update} {view} {delete} | {clone}':'{view}';
if (Yii::$app->User->can('admin')) {
    $template = '{update} {view} {delete} | {clone}';
} 

?>

<h1>
    <?= Yii::t('builder', 'Forms') ?>
    <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
</h1>

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
                        return  Html::a ($model->url, ['view', 'url' => $model->url], ['target' => 'new']);
                    },
        ],[
            'attribute' => 'answer',
            'format' => 'html',
            'value' => function ($model) {
             $maximum = null;
             if ($model->maximum !== null) { 
               $maximum = ' /'. $model->maximum; 
             } 
                return html::a ('<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> ' . $model->answer.$maximum, ['list', 'id' => $model->form_id]);
             },
        ],[
            'attribute' => 'date_end',
            'format' => 'datetime',
        ],

        ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
		        'view' => function ($url, $model, $key) {
					return Html::a ( '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ', ['view', 'url' => $model->url] );
				},
		        'clone' => function ($url, $model, $key) {
					return Html::a ( Yii::t('builder', 'clone'), ['clone', 'id' => $model->form_id] );
				},
            ],
			'template' => $template
        ],
     ],
   ]);?>
    
   </div>
	<div class="col-md-4 pull-right">
    	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> - <?= Yii::t('builder', 'Edit form')  ?><br />
    	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> - <?= Yii::t('builder', 'View form')  ?><br />
    	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> - <?= Yii::t('builder', 'Delete form')  ?><br />
    	<span class="glyphicon glyphicon-list" aria-hidden="true"></span> - <?= Yii::t('builder', 'Completed forms')  ?>
	</div>
</div>
