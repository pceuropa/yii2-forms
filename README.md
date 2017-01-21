[![Latest Stable Version](https://poser.pugx.org/pceuropa/yii2-forms/v/stable)](https://packagist.org/packages/pceuropa/yii2-forms) [![Total Downloads](https://poser.pugx.org/pceuropa/yii2-forms/downloads)](https://packagist.org/packages/pceuropa/yii2-forms) [![Latest Unstable Version](https://poser.pugx.org/pceuropa/yii2-forms/v/unstable)](https://packagist.org/packages/pceuropa/yii2-forms) [![License](https://poser.pugx.org/pceuropa/yii2-forms/license)](https://packagist.org/packages/pceuropa/yii2-forms)

Form Builder for Yii2
==========================


[DEMO](https://pceuropa.net/yii2-extensions/yii2-forms)

## Features

 * Creating forms , 
 * Sorting, editing, and deleting using drag and drop
 * No jQuery for drag and drop ([RubaXa/Sortable](https://github.com/RubaXa/Sortable))
 * CRUD operations by jQuery Ajax
 
## Installation Form Builder
```
composer require pceuropa/yii2-forms "dev-master"
```

## Configuration Form Builder

### 1. Create database schema

Make sure that you have properly configured `db` application component and run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/pceuropa/yii2-forms/migrations

```


### 2. Add the following code to view file Yii2
```php

echo \pceuropa\forms\FormBuilder::widget([
		'test_mode' => false
]);

```

### 3. Add the following code to controller view file Yii2

```php

use pceuropa\forms\FormBase;
use pceuropa\forms\Form;
use pceuropa\forms\FormBuilder;
use pceuropa\forms\models\FormModel;
use pceuropa\forms\models\FormModelSearch;

    public function actionIndex(){
        $searchModel = new FormModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
    	
    	$form = $this->findModel($id);
            
    	if (Yii::$app->request->post()) {
    	
    		$data = Yii::$app->request->post('DynamicModel');
    		
    		foreach ($data as $key => $value) {
    		    if (is_array($data[$key])){
    		    	$data[$key] = join(',', $data[$key]);
    		    }
    		}
    		
    		Yii::$app->db->createCommand()->insert('form_'.$id, $data)->execute();
			
            return $this->redirect(['index']);
        } else {
            return $this->render('view', [ 'form_body' => $form->body] );
        }
    
	}

    public function actionCreate(){
    
    	$r = Yii::$app->request;
		
		 if ($r->isAjax && $r->post('request_data')) {
		 
		 	$form = new FormBuilder();
		 	$form->data_json = $r->post('request_data'); 
			$form->save();
			$form->createTable();
			
			return $form->response('json');
        	
		} else {
			return $this->render('create');
		}
	}


   public function actionUpdate($id){
   
   
		$model = FormModel::findModel($id);
		$form = new FormBuilder();
		$form->table_name = 'form_';
		$r = Yii::$app->request;
	
		if ($r->isAjax) {
			\Yii::$app->response->format = 'json';
			
			switch (true) { 
				case $r->isGet: echo $model->body; break;
				
				case $r->post('request_data'): 
					$model->body = $r->post('request_data');
					return ['success' => $model->save()]; 
				
				case $r->post('add'): $form->addColumn($id, $r->post('add')); return ['success' => $form->success];
				case $r->post('delete'): $form->dropColumn($id, $r->post('delete'));  return ['success' => $form->success];
				
					
				case $r->post('change_name'):
					$field = $r->post('change_name');
				
					$form->renameColumn ( 'form_' . $id, $field['old'], $field['new'] );
				
					return ['success' => $form->success];	
					
					 	 	
				default: return ['success' => false];
			}
			
		} else {
			return $this->render('update');
		}
	}


    public function actionDelete($id){
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    protected function findModel($id){
        if (($model = FormModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

```



### 3. Getting started
/forms/index
/forms/create
/forms/update

