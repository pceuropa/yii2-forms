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


/**
 * Example controller help to use all functions of formBuilder
 *
 * FormBuilder controller of module.
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.4.1
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 */
class ModuleController extends \yii\web\Controller {

/**
 * @var array List all actions to rule of access
 */
	protected $list_action = ['index', 'create', 'update', 'delete', 'list'];
	

/**
 * @var string Prefix table (if you need storage data in SQL)
 */
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
		                    'roles' => ['@'],
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
		
/**
 * Index Controller.
 *
 * List of all forms
 * @return Void View
*/
    public function actionIndex(){
        $searchModel = new FormModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
 /**
 * View Controller.
 *
 * Preview form.
 * @return Void View
*/   
    public function actionView($url) {
    
    	$form = FormModel::findModelByUrl($url);
    	$r = Yii::$app->request;

    
        if ($r->isAjax && $r->isGet) {
			echo $form->body;
            return;

		}


    	if (($data = Yii::$app->request->post('DynamicModel')) !== null) {
    		
    		foreach ($data as $i => $v) {
    		    if (is_array($data[$i])) $data[$i] = join(',', $data[$i]);
    		}
    		
    		$query = Yii::$app->db->createCommand()->insert($this->table.$form->form_id, $data);
			
			if ($query->execute()){
				
				Yii::$app->session->setFlash('success', Yii::t('app', 'Registration successfully completed'));
				
				if (isset($data['email']) && isset(Json::decode($form->body)['response'])){
					Send::widget([
						'from' => 'info@pceuropa.net',
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
            return $this->render('view', [ 'form' => $form->body] );
        }
	}
	
 /**
 * List Controller.
 *
 * List of data from submited forms.
 * @return Void View
*/   	
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
	
 /**
 * Create Controller.
 *
 * Create form - FormBuilder
 * @return Void View
*/   	
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

/**
 * Update Controller.
 *
 * Update form - FormBuilder
 * @return Void View
*/   
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

/**
 * Delete Controller.
 *
 * Delete form
 * @return Void Redirect to index controller
*/  
    public function actionDelete($id){
    	$form = new FormBuilder();
        $form->model->findModel($id)->delete();
        return $this->redirect(['index']);
    }

}
