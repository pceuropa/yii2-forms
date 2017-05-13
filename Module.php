<?php
namespace pceuropa\forms;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;
/**
 * Module Yii2-forms
 *
 * FormBuilder module. All controllers and views in one place.
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.4.1
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 */
class Module extends \yii\base\Module implements BootstrapInterface {

    /**
     * @ingeritdoc
     */
    public $controllerNamespace = 'pceuropa\forms\controllers';

    /**
     * @ingeritdoc
     */
    public $defaultRoute = 'module';

    /**
     * @var string Default db connection
     */
    public $db = 'db';

    /**
     * @var string The database table storing the forms
     */
    public $formsTable = '{{%forms}';

    /**
     * @var string The database table storing the data from forms
     */
    public $dataFormsTables = '{{%form_}';

    /**
     * @var array the list of rights that are allowed to access this module.
     * If you modify, you also need to enable authManager.
     * http://www.yiiframework.com/doc-2.0/guide-security-authorization.html
     */
    public $roles = [];
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * Adding routing rules and log target.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
      //  $this->addUrlManagerRules($app);
    }

    /**
    * Adds UrlManager rules.
    * @param Application $app the application currently running
    */
    protected function addUrlManagerRules($app)
    {
      $app->getUrlManager()->addRules([
                            $this->id.'/update/<id:\d+>' => $this->id. '/module/update',
                            $this->id.'/delete/<id:\d+>' => $this->id.'module/delete',
                            $this->id.'list/<id:\d+>' => $this->id.'module/list',
            ], false);
    }



    public function init() {
        parent::init();	  // custom initialization code goes here
//        echo '<pre>'; print_r( Yii::$app->UrlManager ); die();
    }

}



