<?php
use yii\helpers\Html;
use app\widgets\Lightbox;
$this->title = Yii::t('app', 'Form Builder: generator free software open source Yii2 JavaScript') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Yii2 extensions'), 'url' => ['yii2-extensions/index']];
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->view->registerMetaTag([
		'name' => 'description',
		'content' => Yii::t('app', 'Generator Form Builder. Create your own forms speed and easy')
	]); 

?>


<div class="row">
	<div class="col-md-8">
<h1><?= Yii::t('app', 'Form Builder <small>Yii2, free software, open source</small>')  ?> </h1>

<div class="panel panel-default">
  <div class="panel-body">
  <?= Html::a(Yii::t('app', 'FormBuilder Demo'), ['create'], ['class' => 'pull-right btn btn-success']) ?>
<?= Yii::t('app', 'Features') ?>
<h4><?= Yii::t('app', 'Generator forms (class pceuropa\forms\FormBuilder)')  ?></h4>
<ol>
  <li><?= Yii::t('app', 'Add, edit, sort (drag&drop), delete items') ?></li>
  <li><?= Yii::t('app', 'Drag and drop function compatible <b>with any screen</b>') ?></li>
  <li><?= Yii::t('app', 'CRUD operations by <b>JavaScript</b>') ?></li>
  <li><?= Yii::t('app', 'List of forms (Yii2 GridView)') ?></li>
</ol>

<h4><?= Yii::t('app', 'Render form (class pceuropa\forms\Form)')  ?></h4>
<ol>
  <li><?= Yii::t('app', 'Validation forms (dynamic model)') ?></li>
  <li><?= Yii::t('app', 'Possibility storage data from forms in database') ?></li>
  <li><?= Yii::t('app', 'GridView of submitted data') ?></li>
</ol>

<h4><?= Yii::t('app', '[Storage data submited from form in databases]')  ?></h4>
<ol>
  <li><?= Yii::t('app', 'Creating database tables after create form (yii\db\Command::createTable)') ?></li>
  <li><?= Yii::t('app', 'Delete database tables after delete form (yii\db\Command::dropColumn)') ?></li>
  <li><?= Yii::t('app', 'Rename column after change the name of field (yii\db\Command::renameColumn)') ?></li>
  <li><?= Yii::t('app', 'Drop column after delete field in form (yii\db\Command:: dropColumn)') ?></li>
  <li><?= Yii::t('app', 'Add column after add new field to form (yii\db\Command:: addColumn)') ?></li>
</ol>
  </div>
</div>
   

<h2><?= Yii::t('app', 'Installation')  ?></h2>
<pre class="bash"><code>composer require pceuropa/yii2-form dev-master</code></pre>

<h2><?= Yii::t('app', 'Create database')  ?> <small><?= Yii::t('app', 'if you need storage data')  ?></small></h2>
<pre class="bash"><code>php yii migrate/up --migrationPath=@vendor/pceuropa/yii2-forms/migrations</code></pre>

<h2><?= Yii::t('app', 'FormBuilder widget')?></h2>
<div class="row">
<div class="col-md-6"><pre><code  class="language-php">
echo \pceuropa\forms\FormBuilder::widget([
        'table' => 'form_',
        'test_mode' => false,
        'database'    => true,		// TD
        'type_database' => 'sql',   // TD
        'easy_mode' => true,
]);
</code></pre>
</div>

<div class="col-md-6">
<pre><code  class="language-php">
        'test_mode'  // comments TD,
        'database'   // comments TD,
        'type_database' // comments TD,
        'table' // prefixm TD,
        'easy_mode' // comments TD,

</code></pre>
</div>
</div>


<?= Yii::t('app', 'You can create a form...')  ?>

<br />

<h2><?= Yii::t('app', 'FormBuilder controller')  ?></h2>

<pre><code class="language-css">
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


class FormsController extends \yii\web\Controller {

protected $table = 'poll_'; 


public function actionIndex(){
    $searchModel = new FormModelSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
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
		
		$query = Yii::$app->db->createCommand()->insert($this->table.$form->form_id, $data);
		
		if ($query->execute()){
			
			Yii::$app->session->setFlash('success', Yii::t('app', 'Registration successfully completed'));
			
			if (isset($data['email'])){
				Send::widget([
					'from' => 'info@domain.com',
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
</code></pre>


<h2><?= Yii::t('app', 'FormRender view')  ?></h2>

<pre><code class="language-css">
&lt;?= \pceuropa\forms\Form::widget([
	'body' => $form_body,
	'typeRender' => 'php'
]);
?>
</code></pre>

<h2><?= Yii::t('app', 'FormRender controller')  ?></h2>

<pre><code class="language-css">
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use pceuropa\forms\models\FormModel;
use pceuropa\email\Send;

class FormsController extends \yii\web\Controller{
	
	protected $table = 'poll_'; 
    public function actionIndex(){
        return $this->render('index');
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
						'from' => 'info@domain.com',
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

}
</code></pre>


<?= $this->render('@views/_comments'); ?>

</div>
	<div class="col-md-4">
	<br /><br />
	<?php
	
    echo Lightbox::img('@web/images/formbuilder/scheme.png', true, 'form builder yii2'); 
    echo Lightbox::img('@web/images/formbuilder/formbuilder.png', false);
	echo Lightbox::img('@web/images/formbuilder/formbuilder_jsonview.png', false);
	echo Lightbox::img('@web/images/formbuilder/formbuilder_textview.png', false);
	echo Lightbox::img('@web/images/formbuilder/formbuilder_export_data.png', false);
	
	?><hr />
		<?=  $this->render('@views/_badge', [ 'app' => 'yii2-forms', ]); ?>
		<?=  $this->render('@views/_donate'); ?>
	</div>
</div>

<?php
	
    $this->registerJsFile('/js/prism.js', ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
    $this->registerCssFile('@web/css/prism.css');
    $this->registerJsFile('/js/lightbox.js', ['position' => 3, 'depends' => 'yii\web\YiiAsset']);
    $this->registerCssFile('/css/lightbox.css');
?>
    
