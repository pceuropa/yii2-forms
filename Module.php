<?php
namespace pceuropa\forms;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;
/**
 * Module Yii2-forms
 * FormBuilder module. All controllers and views in one place.
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.4.1
 * @license MIT
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 */
class Module extends \yii\base\Module{

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
    public $formTable = '{{%forms}}';

    /**
     * @var string The database table storing the data from forms
     */
    public $formDataTable = 'form_';

    /**
     * @var array the list of rights that are allowed to access this module.
     * If you modify, you also need to enable authManager.
     * http://www.yiiframework.com/doc-2.0/guide-security-authorization.html
     *     $rules = [
     *                   [
     *                       'actions' => [ 'update', 'delete', 'clone' ],
     *                       'allow' => true,
     *                       'roles' => ['updateOwnForm'],
     *                   ],
     *                   [
     *                       'actions' => ['user', 'create'],
     *                       'allow' => true,
     *                       'roles' => ['user'],
     *                   ]
     *               ];
     */
    public $rules = [
                       [
                           'allow' => true,
                           'actions' => [],
                           'roles' => ['?'],
                       ],[
                           'allow' => true,
                           'actions' => [],
                           'roles' => ['@'],
                       ]
                   ];

    /**
     * @var boolean If true after completing the form the message is sent
     */
    public $sendEmail = false;
    
    /**
     * @var string The sender's address
     */
    public $emailSender = null;

    /**
     * @var Boolean If true, you can see action buttons on index action
     */
    public $buttonsEditOnIndex = false;
    
    /**
     * @var boolean if true, only necesaire options
     */
    public $easyMode = true;

    /**
     * @var boolean if true, example form
     */
    public $testMode = false;
    
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['builder'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@pceuropa/forms/messages',
                    'fileMap' => [ 'builder' => 'builder.php', ]
        ];
    }
}
