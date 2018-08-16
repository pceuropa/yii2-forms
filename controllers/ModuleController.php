<?php namespace pceuropa\forms\controllers;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;

use yii\filters\VerbFilter;
use yii\helpers\Json;

use pceuropa\forms\FormBase;
use pceuropa\forms\FormBuilder;
use pceuropa\forms\models\FormModel;
use pceuropa\forms\models\FormModelSearch;
use pceuropa\email\Send as SendEmail;

/**
 * Controller of formBuilder
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @license MIT
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 */
class ModuleController extends \yii\web\Controller {

    /**
     * This method is invoked before any actions
     * @return void
     */
    public function behaviors() {
        $config = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
        
        if (Yii::$app->User->can('admin')) {
          return $config;
        } 

        $config['access'] = [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['user', 'create', 'update', 'delete', 'deleteitem', 'clone'],
            'rules' => $this->module->rules
        ];
        return $config;
    }

    public function actionIndex() {
        $searchModel = new FormModelSearch();

        return $this->render('index', [
                'buttonsEditOnIndex' => $this->module->buttonsEditOnIndex,
                'searchModel' => $searchModel,
                'dataProvider' => $searchModel->search(Yii::$app->request->queryParams)
        ]);
    }

    public function actionUser() {
        $searchModel = new FormModelSearch();
        $searchModel->author = Yii::$app->user->identity->id ?? null;

        return $this->render('user', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $searchModel->search(Yii::$app->request->queryParams)
                ]);
    }


    public function actionView(string $url) {
        $form = FormModel::findModelByUrl($url);

        if ($form->endForm()) { 
          return $this->render('end');
        } 
      
        // request - use form
        if (($data = Yii::$app->request->post('DynamicModel')) !== null) {

            foreach ($data as $i => $v) {
                if (is_array($data[$i])) $data[$i] = join(',', $data[$i]);
            }

            $query = (new Query)->createCommand()->insert($this->module->formDataTable.$form->form_id, $data);

            if ($query->execute()) {
              $form->updateCounters(['answer' => 1 ]);
              Yii::$app->session->setFlash('success', Yii::t('builder', 'Form completed'));
              $this->sendEmail($data, $form);
            } 

            return $this->redirect(['index']);
        } 
        return $this->render('view', [ 'form' => $form] );
    }

    public function actionList(int $id) {
        $form = FormModel::findModel($id);

        return $this->render('list', [
                'form' => $form,
                'dataProvider' => new ActiveDataProvider([
                        'query' => (new Query)->from( $this->module->formDataTable.$id ),
                        'db' => $this->module->db
                ]),
                'only_data_fields' => FormBase::gridViewItemsForm(Json::decode($form->body))
        ]);
    }

    /**
     * Create Form action
     * @throws yii\base\InvalidParamException
     * @return string
     */
    public function actionCreate() {
        $r = Yii::$app->request;

        if ($r->isAjax) {
            $form = new FormBuilder([
                'db' => $this->module->db,
                'formTable' => $this->module->formTable,
                'formDataTable' => $this->module->formDataTable,
                'formData' => $r->post()
            ]);

            $form->save();
            $form->createTable();
            return $form->response();
        } else {
          return $this->render('create', [
            'testMode' => $this->module->testMode,
            'easyMode' => $this->module->easyMode,
            'sendEmail' => $this->module->sendEmail
         ] 
          );
        }
    }


    /**
     * Create Form action
     * @throws yii\base\InvalidParamException
     * @return string
     */
    public function actionUpdate(int $id) {
        $form = new FormBuilder([
                    'db' => $this->module->db,
                    'formTable' => $this->module->formTable,
                    'formDataTable' => $this->module->formDataTable,
                ]);

        $form->findModel($id);
        $r = Yii::$app->request;

        if ($r->isAjax) {
            \Yii::$app->response->format = 'json';

            switch (true) {
            case $r->isGet:
                return $form->model;
            case $r->post('body'):
                $form->load($r->post());
                $form->save();
                break;
            case $r->post('add'):
                $form->addColumn($r->post('add'));
                break;
            case $r->post('delete'):
                $form->dropColumn($r->post('delete'));
                break;
            case $r->post('change'):
                $form->renameColumn($r->post('change'));
                break;
            default:
                return ['success' => false];
            }

            return ['success' => $form->success];
        } else {
          return $this->render('update', [
            'id' => $id,
            'easyMode' => $this->module->easyMode,
            'sendEmail' => $this->module->sendEmail
        ]);
        }
    }

    /**
     * Create Form action
     * @throws yii\base\InvalidParamException
     * @return void
     */
    public function actionClone(int $id) {

        $form = FormModel::find()
            ->select(['body', 'title', 'author', 'date_start', 'date_end', 'maximum', 'meta_title', 'url', 'response', 'class', 'id'])
            ->where(['form_id' => $id])
            ->one();
        $form->answer = 0;
        $this->uniqueUrl($form);

        $db = Yii::$app->{$this->module->db};
        $db->createCommand()->insert( $this->module->formTable , $form)->execute();

        $last_id = $db->getLastInsertID();
        $schema = FormBuilder::tableSchema($form->body);

        $db->createCommand()->createTable($this->module->formDataTable.$last_id, $schema, 'CHARACTER SET utf8 COLLATE utf8_general_ci')->execute();

        $this->redirect(['user']);
    }

    public function actionDelete(int $id) {
        $form = FormModel::findModel($id);
        $form->delete();
        return $this->redirect(['user']);
    }

    public function actionDeleteitem(int $form, int $id ) {
        
        $tablename = $this->module->formDataTable . $form;

        $command = Yii::$app->db->createCommand("DELETE FROM {$tablename} WHERE id=:id")
              ->bindValues([':id' => $id])
              ->execute();

        if ($command) {
            return $this->redirect(['list' , 'id' => $form]);
        } 
        
    }

    /**
     * Unique URL
     * @param $array form
     * @return void
     */
    public function uniqueUrl(FormModel $form) {
        do {
            $form->url = $form->url.'_2';
            $count = FormModel::find()->select(['url'])->where(['url' => $form->url])->count();
        } while ($count > 0);
    }

    /**
     * Send email if in form is email filed
     * @param array $data
     * @param array $form
     * @return void
     */
    public function sendEmail($data, $form) {
        if ($this->module->sendEmail && is_string($this->module->emailSender) && isset($data['email']) && isset($form['response']) ) {

            SendEmail::widget([
              'from' => $this->module->emailSender,
              'to' => $data['email'],
              'subject' => 'form: ' . $form['title'],
              'textBody' => $form['response'],
            ]);
            Yii::$app->session->setFlash('success', Yii::t('app', 'An confirmation email was sent'));
        }
      
    }
    
    
}
