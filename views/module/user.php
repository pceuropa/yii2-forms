<?php
$this->title = Yii::t('builder', 'Forms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('builder', 'All forms') , 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('builder', 'Your forms') ;
echo  $this->render('gridview', [
                       'searchModel' => $searchModel,
                       'dataProvider' => $dataProvider,
                ]);
