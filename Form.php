<?php namespace pceuropa\forms;

use Yii;
use yii\base\Widget;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use pceuropa\forms\FormBase;
use pceuropa\forms\models\FormModel;
use pceuropa\email\Send as SendEmail;

/**
 * FormRender: Render form
 * Two method form render: php or js (beta)
 *
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 2.0
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 *
 * Usage example:
 * ~~~
 * echo \pceuropa\forms\form::widget([
 *    'form' => ',{}'
 * ]);
 *
 * echo \pceuropa\forms\form::widget([
 *    'formId' => 1,
 * ]);
 * ~~~
 * echo \pceuropa\forms\Form::widget([
 * FormBuilder requires Yii 2
 * http://www.yiiframework.com
 * https://github.com/yiisoft/yii2
 *
 */

class Form extends Widget {

    /**
     * @var int Id of form. If set, widget take data from FormModel.
     * @see pceuropa\models\FormModel
     */
    public $formId = null;

    /**
     * @var array|string JSON Object representing the form body
     */
    public $body = '{}';

    /**
     * @var string Type render js|php
     * @since 1.0
     */
    public $typeRender = 'php';

    /**
     * Initializes the object.
     * @return void
     * @see Widget
    */
    public function init() {
        parent::init();
        if (is_int($this->formId)) {
            $form = FormModel::FindOne($this->formId);
            $this->body = $form->body;
        }
        $this->body = Json::decode($this->body);
    }

    /**
        * Executes the widget.
        * @since 1.0
        * @return function
    */
    public function run() {
        if ($this->typeRender === 'js') {
            return $this->jsRender($this->body);
        }
        return $this->phpRender($this->body);
    }


    /**
     * Render form by PHP and add rules
     * @param array $form
     * @return View Form
    */
    public function phpRender($form) {

        $data_fields = FormBase::onlyCorrectDataFields($form);
        $DynamicModel = new DynamicModel( ArrayHelper::getColumn($data_fields, 'name') );

        foreach ($data_fields as $v) {

            if (isset($v["name"]) && $v["name"]) {

                if (isset($v["require"]) && $v["require"]) {
                    $DynamicModel->addRule($v["name"], 'required');
                }

                $DynamicModel->addRule($v["name"], FormBase::ruleType($v) );
            }
        }

        return $this->render('form_php', [
                'form_body' => $form,
                'model' => $DynamicModel
        ]);
    }

    /**
     * Render form by JavaScript
     * @param array $form
     * @return View
    */
    public function jsRender($form) {
        return $this->render('form_js', ['form' => $form]);
    }
}
?>
