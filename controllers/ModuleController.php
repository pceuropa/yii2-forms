<?php namespace pceuropa\forms\controllers;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;

use yii\filters\VerbFilter;
use yii\helpers\Json;

use pceuropa\forms\{FormBase, FormBuilder};
use pceuropa\forms\models\{FormModel, DynamicFormModel, FormModelSearch};
use pceuropa\email\Send as SendEmail;
use yii2tech\spreadsheet\Spreadsheet;
use yii\db\Exception as DbExcpetion;

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
        (int) $count_insert = 0;
        $form = FormModel::findModelByUrl($url);
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $form_id = $this->module->formDataTable.$form->form_id;

        if ($form->endForm()) { 
            return $this->render('end');
        } 

        if ($form->isFormSentOnlyOnce($form_id)) {
            return $this->render('view_only_once');
        }

        if (($data = $request->post()) ) {
            $data = $data['DynamicModel'];
            $data['_number_fraud'] = $form->checkCorrectnessData($data);
            $data['_form_created'] = $request->post('form_created');
            $data['_ip'] = $request->userIP ?? null;
            $data['_user_agent'] = $request->userAgent;
            $data['_same_site'] = PHP_VERSION_ID >= 70300 ? yii\web\Cookie::SAME_SITE_LAX : null;

            if ($form->only_once) {
                $data['_csrf'] = $request->post('_csrf');
                $data['_finger_print'] = $request->post('_fp');
            }

            foreach ($data as $i => $v) {
                if (is_array($data[$i])) $data[$i] = join(',', $data[$i]);
            }

            $query = (new Query)->createCommand()->insert($form_id, $data);

            try {
              $count_insert = $query->execute();
            } catch (DbExcpetion $e) {
              $count_insert = 0;
              //$session->setFlash('error', $e->getMessage());
            }

            if ($count_insert) {
                $form->updateCounters(['answer' => 1 ]);
                $session->setFlash('success', Yii::t('builder', 'Form completed'));
                $session->set($form_id, 'sent');
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => $form_id,
                    'value' => 'sent',
                ]));

                $this->sendEmail($data, $form);
            } else {
                $session->setFlash('warning', Yii::t('builder', 'Form can be completed only once'));
            }

            return $this->redirect(['list' , 'id' => $form->form_id]);
        } 
        return $this->render('view', ['form' => $form]);
    }

    public function actionList(int $id) {
        $form = FormModel::findModel($id);

        return $this->render('list', [
            'form' => $form,
            'dataProvider' => new ActiveDataProvider([
                'query' => (new Query)->from($this->module->formDataTable.$id)->where('_number_fraud = 0'),
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
    public function actionClone(int $id) 
    {
        $clonedForm = FormModel::cloneModel($id);

        $dynamicFormModel = new DynamicFormModel();
        $dynamicFormModel->createTable(
            (string) $table_name = $this->module->formDataTable.$clonedForm->form_id,
            (array) $table_schema = FormBuilder::tableSchema($clonedForm->body)
        );

        $this->redirect(['user']);
    }

    public function actionDelete(int $id) {
        $form = FormModel::findModel($id);
        $form->delete();
        return $this->redirect(['user']);
    }

    public function actionExport(int $id = 1) {

        $dataProvider = new ActiveDataProvider([
                        'query' => (new Query)->select('*')->from( $this->module->formDataTable.$id ),
                        'db' => $this->module->db
                ]);

        $exporter = new Spreadsheet([
            'dataProvider' => $dataProvider
        ]);

        return $exporter->send('items.csv');
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
    public function setUniqueUrl(FormModel $form) {
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
