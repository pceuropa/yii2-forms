<?php 
namespace pceuropa\forms;
/**
 * Asset bundle for formbuilder
 *
 * @author Rafal Marguzewicz <info@pceuropa.net>
 * @version 1.5
 * @license MIT
 *
 * https://github.com/pceuropa/yii2-forum
 * Please report all issues at GitHub
 * https://github.com/pceuropa/yii2-forum/issues
 */

class FormBuilderAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@vendor/pceuropa/yii2-forms/assets/form-builder';
    public $baseUrl = '@web';
    public $css = [
//    	'css/forms/quill.snow.css',
    	'css/forms/form-builder.css',
    ];
    public $js = [
        'js/forms/Sortable.min.js',
		//'js/forms/form.min.js',
		'js/forms/helpers.js',
		'js/forms/form.js',
		'js/forms/field.js',
		'js/forms/controller.js',
		
		'js/forms/form.module.response.js',
		'js/forms/examples.js',
		'js/forms/test.js',
		
		'js/forms/quill.min.js',
		'js/forms/clipboard.min.js',
		
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

