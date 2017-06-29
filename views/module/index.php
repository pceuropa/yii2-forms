<?php
$this->title = Yii::t('builder', 'FormBuilder: Online form generator');
$this->params['breadcrumbs'][] =  Yii::t('builder', 'Forms');

echo $this->render('gridview', [
                        'buttonsEditOnIndex' => $buttonsEditOnIndex,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                  ]);
