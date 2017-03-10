<?php namespace pceuropa\forms\controllers;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net LTD
use Yii;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use pceuropa\email\Send;
use pceuropa\forms\FormBase;
use pceuropa\forms\Form;
use pceuropa\forms\FormBuilder;
use pceuropa\forms\models\FormModel;
use pceuropa\forms\models\FormModelSearch;


class ModuleController extends \yii\web\Controller {

	protected $list_action = ['index', 'create', 'update', 'delete', 'list'];
	protected $table = 'poll_';
	
	public function behaviors() {
	    return [
			'access' => [
		            'class' => \yii\filters\AccessControl::className(),
		            'only' => $this->list_action,
		            'rules' => [
		                [
		                    'allow' => true,
		                    'roles' => ['?'],
		                ],
		                [
		                    'allow' => true,
		                    'actions' => $this->list_action,
		                    'roles' => ['admin'],
		                ],
		                
		            ],
		        ],
		        'verbs' => [
		            'class' => VerbFilter::className(),
		            'actions' => [
		                'delete' => ['post'],
		            ],
		        ],
		    ];
		}
		
    public function actionIndex(){
        $searchModel = new FormModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionManual(){

        return $this->render('manual');
    }
    
   public function actionView($url) {
    
    	$form = FormModel::findModelByUrl($url);
    	
    	if (($data = Yii::$app->request->post('DynamicModel')) !== null) {
    		
    		foreach ($data as $i => $v) {
    		    if (is_array($data[$i])) $data[$i] = join(',', $data[$i]);
    		}
    		
    		$query = Yii::$app->db->createCommand()->insert($this->table.$form->form_id, $data);
			
			if ($query->execute()){
				
				Yii::$app->session->setFlash('success', Yii::t('app', 'Registration successfully completed'));
				
				if (isset($data['email'])){
					Send::widget([
						'from' => 'info@email.net',
						'to' => $data['email'],
						'subject' => Yii::t('app', 'Registration successfully completed'),
						'textBody' => Json::decode($form->body)['response'],
					]);
				}
				 
				
			} else {
				Yii::$app->session->setFlash('error', Yii::t('app', 'An confirmation email was not sent'));
			}
			
            return $this->redirect(['index']);
        } else {
            return $this->render('view', [ 'form_body' => $form->body] );
        }
	}
	
	
	public function actionList($id) {
    
    	$query = (new \yii\db\Query)->from($this->table.$id);
    	$form = FormModel::findModel($id);
		$array = Json::decode($form->body);
		
		$merge_array = FormBase::onlyCorrectDataFields($array['body']);
		
        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $query]);
        
         return $this->render('list', [
         //   'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'only_data_fields' => ArrayHelper::getColumn($merge_array, 'name')
        ]);
	}
	
	
    public function actionCreate(){
    
		$r = Yii::$app->request;
		
 		if ($r->isAjax && $r->post('form_data')) {
		 
		 	$form = new FormBuilder(['table' => $this->table]);
		 	$form->load($r->post());
			$form->save();
			$form->createTable();
	 return $form->response();
        	
		} else {
			return $this->render('create');
		}
	}


 public function actionUpdate($id){
   
		$form = new FormBuilder(['table' => $this->table.$id]);
		$form->findModel($id);
		$r = Yii::$app->request;
		
		if ($r->isAjax) {
			\Yii::$app->response->format = 'json';
			
			switch (true) { 
				case $r->isGet: 
					echo $form->model->body; break;
				
				case $r->post('form_data'): 
					
					$form->load($r->post());
					
					return ['success' => $form->save()]; 
				
				case $r->post('add'):
					return ['success' => $form->addColumn($r->post('add'))];
				
				case $r->post('delete'):
					return ['success' => $form->dropColumn($r->post('delete'))];
				
				case $r->post('change'):
					return ['success' => $form->renameColumn($r->post('change'))];
					 	 	
				default: return ['success' => false];
			}
			
		} else {
			return $this->render('update', ['id' => $id]);
		}
	}


    public function actionDelete($id){
    	$form = new FormBuilder();
        $form->model->findModel($id)->delete();
        return $this->redirect(['index']);
    }

}
