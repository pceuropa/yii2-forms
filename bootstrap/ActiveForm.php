<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace pceuropa\forms\bootstrap;

use Yii;
use yii\base\InvalidConfigException;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ActiveForm extends \yii\bootstrap\ActiveForm
{

    public $fieldClass = 'pceuropa\forms\bootstrap\ActiveField';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }


    /**
     * Select and return function render field
     * @param yii\bootstrap\ActiveForm $form
     * @param DynamicModel $model
     * @param array $field
     * @return string Return field in div HTML
    */
    public function dynamicField($model, $field) {

        $width = $field['width'];
        $options = [];

        if (isset($field['items'])) {

            $items = [];
            $checked = [];

            foreach ($field['items'] as $key => $value) {
                if (isset($value['checked'])) {
                    $checked[]  = $value['value'];
                }

            }

            $items = ArrayHelper::map($field['items'], 'value', 'text');
            $model-> {$field['name']} = $checked;

            if (!isset($field['label'])) {
                $options['template'] = "{input}\n{hint}\n{description}\n{error}";
            }

        }

        if (isset($field['helpBlock'])) {
            $options['description'] = $field['helpBlock'];
        }

        foreach (['placeholder', 'value', 'id', 'class', 'type'] as $key => $value) {
            if (isset($field[$value])) {
                $options['inputOptions'][$value] = $field[$value];
            }
        }
        switch ($field['field']) {
        case 'input':
            $field = parent::field($model, $field['name'], $options)->label($field['label'] ?? false);
            break;
        case 'textarea':
            $field = parent::field($model, $field['name'], $options)->textarea()->label($field['label'] ?? false);
            break;
        case 'radio':
            $field = parent::field($model, $field['name'], $options)->radioList($items)->label($field['label'] ?? false);
            break;
        case 'checkbox':
            $field = parent::field($model, $field['name'], $options)->checkboxList($items)->label($field['label'] ?? false);
            break;
        case 'select':
            $field = parent::field($model, $field['name'], $options)->dropDownList($items)->label($field['label'] ?? false);
            break;
        case 'description':
            $field = self::description($field);
            break;
        case 'submit':
            $field = self::submit($field);
            break;
        default:
            $field = '';
            break;
        }

        return self::div($width, $field);

    }
    public static function checkbox($form, $model, $field) {
        $items = [];
        $checked = [];

        foreach ($field['items'] as $key => $value) {

            $items[$value['value']] =  $value['text'];
            if (isset($value['checked'])) {
                $checked[]  = $key+1;
            }

        }

        $items = ArrayHelper::map($field['items'], 'value', 'text');
        $model-> {$field['name']} = $checked;
        $checkbox_list = $form->field($model, $field['name'])->checkboxList($items);

        $label = (isset($field['label'])) ? $field['label'] : '';
        $checkbox_list->label($label);

        return $checkbox_list;



    }
    /**
     * Set items for field list
     *
     * @param array $field
     * @return void
     */
    public function setItems(array $field) {

        $items = [];
        $checked = [];

        foreach ($field['items'] as $key => $value) {

            $items[$value['value']] =  $value['text'];

            if (isset( $value['checked'] )) {
                $checked[]  = $key+1;
            }
        }
    }
    /**
     * Generates a label tag for [[attribute]].
     * @param null|string|false $label the label to use. If `null`, the label will be generated via [[Model::getAttributeLabel()]].
     * If `false`, the generated field will not contain the label part.
     * Note that this will NOT be [[Html::encode()|encoded]].
     * @param null|array $options the tag options in terms of name-value pairs. It will be merged with [[labelOptions]].
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded
     * using [[Html::encode()]]. If a value is `null`, the corresponding attribute will not be rendered.
     * @return $this the field object itself.
     */
    public function label($label = null, $options = [])
    {
        echo '<pre>';
        print_r('');
        die();
        if ($label === false) {
            $this->parts['{label}'] = '';
            return $this;
        }

        $options = array_merge($this->labelOptions, $options);
        if ($label !== null) {
            $options['label'] = $label;
        }

        if ($this->_skipLabelFor) {
            $options['for'] = null;
        }

        $this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Return HTML div with field
     * @param string $width Class bootstrap
     * @param string $field
     * @return string
    */
    public static function div($width, $field) {
        return Html::tag('div', $field, ['class' => $width]);
    }

    /**
    * Renders a description html.
    * @param array $v
    * @return string
    */
    public static function description($v) {
        return $v['textdescription'];
    }

    /**
      * Renders a submit buton tag.
      * @param array $data
      * @return string The generated submit button tag
      */
    public static function submit($data) {
        return Html::submitButton($data['label'], ['class' => 'btn '.$data['backgroundcolor'] ]);
    }

}

