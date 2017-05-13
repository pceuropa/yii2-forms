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
use pceuropa\forms\Module;
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

    protected $list_action = ['create', 'update', 'delete', 'user'];
    protected $table = 'form_';

    /**
     * @var string form table name
     */
    protected $formsTable = 'forms';

    /**
     * @var string data forms table name
     */
    protected $dataFormsTables = 'form_';

    /**
     * This method is invoked before any actions
     *
     * @param string $arg
     * @return void
     */

    public function behaviors() {
        return [
                   'access' => [
                       'class' => \yii\filters\AccessControl::className(),
                       'only' => $this->list_action,
                       'rules' => [
                           [
                               'actions' => $this->list_action,
                               'allow' => true,
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

    public function actionIndex() {
        $searchModel = new FormModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                                 'searchModel' => $searchModel,
                                 'dataProvider' => $dataProvider,
                             ]);
    }
    public function actionUser() {
        $searchModel = new FormModelSearch();
        $searchModel->author = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('user', [
                                 'searchModel' => $searchModel,
                                 'dataProvider' => $dataProvider,
                             ]);
    }


    public function actionView($url) {

        $form = FormModel::findModelByUrl($url);

        if (($data = Yii::$app->request->post('DynamicModel')) !== null) {

            foreach ($data as $i => $v) {
                if (is_array($data[$i])) $data[$i] = join(',', $data[$i]);
            }

            $query = Yii::$app[Module::getInstance()->db]->createCommand()->insert($this->table.$form->form_id, $data);

            if ($query->execute()) {
                $form->updateCounters(['answer' => 1 ]);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Registration successfully completed'));

                if (isset($data['email'])) {
                    $response = (isset(Json::decode($form->body)['response'])) ? Json::decode($form->body)['response'] : '';

                    Send::widget([
                                     'from' => 'info@pceuropa.net',
                                     'to' => $data['email'],
                                     'subject' => Yii::t('app', 'Registration successfully completed'),
                                     'textBody' => $response,
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


    public function actionCreate() {

        $r = Yii::$app->request;

        if ($r->isAjax && $r->post('form_data')) {

            $form = new FormBuilder(['table' => $this->formsTable]);
            $form->load($r->post());
            $form->model->author = Yii::$app->user->identity->id;
            $form->save();
            $form->createTable($this->formsTable, $this->module->db);
            if ($form->success) {
                return $this->redirect(['user']);
            }

        } else {
            return $this->render('create');
        }
    }


    public function actionUpdate($id) {
        $form = new FormBuilder(['table' => $this->formsTable.$id]);
        $form->findModel($id);
        $this->rbacUser($form->model);
        $r = Yii::$app->request;


        if ($r->isAjax) {
            \Yii::$app->response->format = 'json';

            switch (true) {
            case $r->isGet:
                echo $form->model->body;
                break;

            case $r->post('form_data'):

                $form->load($r->post());

                return ['success' => $form->save()];

            case $r->post('add'):
                return ['success' => $form->addColumn($r->post('add'))];

            case $r->post('delete'):
                return ['success' => $form->dropColumn($r->post('delete'))];

            case $r->post('change'):
                return ['success' => $form->renameColumn($r->post('change'))];

            default:
                return ['success' => false];
            }

        } else {
            // update post
            return $this->render('update', ['id' => $id]);
        }
    }

    public function actionClone($id) {

        $form = FormModel::find()->select(['body', 'title', 'author', 'date_start', 'date_start', 'maximum', 'meta_title', 'url', 'response'])->where(['form_id' => $id])->one();
        $this->rbacUser($form);
        do {
            $form->url = $form->url.'_2';
            $count = FormModel::find()->select(['url'])->where(['url' => $form->url])->count();
        } while ($count > 0);
        $form->answer = 0;
        Yii::$app->db->createCommand()->insert('forms', $form)->execute();

        $last_id = Yii::$app->db->getLastInsertID();
        $schema = FormBuilder::tableSchema($form->body);
        Yii::$app->db->createCommand()->createTable($this->table.$last_id, $schema, 'CHARACTER SET utf8 COLLATE utf8_general_ci')->execute();

        $this->redirect(['user']);
    }

    public function actionDelete($id) {
        $form = new FormBuilder();
        $form = $form->model->findModel($id);
        $this->rbacUser($form);
        $form->delete();
        return $this->redirect(['index']);
    }
    public function rbacUser($form) {
        if (!\Yii::$app->user->can('updateOwnForm', ['item' => $form])) {
            $this->redirect(['user']);
            exit();
        }
    }
}

